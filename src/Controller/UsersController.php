<?php
declare(strict_types=1);

namespace App\Controller;

use Cake\Datasource\Exception\RecordNotFoundException;
use Cake\Event\EventInterface;

/**
 * Users Controller
 *
 * @property \App\Model\Table\UsersTable $Users
 * @property \Authorization\Controller\Component\AuthorizationComponent $Authorization
 * @property \Authentication\Controller\Component\AuthenticationComponent $Authentication
 * @method \App\Model\Entity\User[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class UsersController extends AppController
{
    public function beforeFilter(EventInterface $event): void
    {
        parent::beforeFilter($event);
        $this->Authentication->addUnauthenticatedActions(['login', 'add', 'logout']);
    }

    public function login()
    {
        $this->Authorization->skipAuthorization();
        $this->request->allowMethod(['get', 'post']);

        $result = $this->Authentication->getResult();

        if ($result && $result->isValid()) {
            $user = $result->getData();
            $controlador = 'Users';
            $acao = 'index';
            $parametro = null;

            // Check category and ensure linkage
            switch ($user->categoria) {
                case '2': // Aluno
                    $aluno_id = $user->aluno_id;
                    if (empty($aluno_id)) {
                        $estudante = $this->fetchTable('Alunos')->find()
                            ->where(['Alunos.email' => $user->email])
                            ->first();

                        if (empty($estudante)) {
                            // Link failed, redirect to add Aluno?
                            $this->Flash->error(__('Aluno não encontrado. Por favor, cadastre-se.'));

                            return $this->redirect(['controller' => 'Alunos', 'action' => 'add', '?' => ['dre' => $user->numero, 'email' => $user->email]]);
                        } else {
                            // Link found, update user
                            $userEntity = $this->Users->get($user->id);
                            $userEntity->aluno_id = $estudante->id;
                            $this->Users->save($userEntity);
                            $parametro = $estudante->id;
                        }
                    } else {
                        $parametro = $aluno_id;
                    }
                    $controlador = 'Alunos';
                    $acao = 'view';
                    break;

                case '3': // Professor
                    $professor_id = $user->professor_id;
                    if (empty($professor_id)) {
                        $professor = $this->fetchTable('Professores')->find()
                            ->where(['Professores.email' => $user->email])
                            ->first();

                        if (empty($professor)) {
                            return $this->redirect(['controller' => 'Professores', 'action' => 'add', '?' => ['siape' => $user->numero, 'email' => $user->email]]);
                        } else {
                            $userEntity = $this->Users->get($user->id);
                            $userEntity->professor_id = $professor->id;
                            $userEntity->numero = $professor->siape;
                            $this->Users->save($userEntity);
                            $parametro = $professor->id;
                        }
                    } else {
                        $parametro = $professor_id;
                    }
                    $controlador = 'Professores';
                    $acao = 'view';
                    break;

                case '4': // Supervisor
                    $supervisor_id = $user->supervisor_id;
                    if (empty($supervisor_id)) {
                        $supervisor = $this->fetchTable('Supervisores')->find()
                            ->where(['Supervisores.email' => $user->email])
                            ->first();

                        if (empty($supervisor)) {
                             return $this->redirect(['controller' => 'Supervisores', 'action' => 'add', '?' => ['cress' => $user->numero, 'email' => $user->email]]);
                        } else {
                            $userEntity = $this->Users->get($user->id);
                            $userEntity->supervisor_id = $supervisor->id;
                            $userEntity->numero = $supervisor->cress;
                            $this->Users->save($userEntity);
                            $parametro = $supervisor->id;
                        }
                    } else {
                        $parametro = $supervisor_id;
                    }
                    $controlador = 'Supervisores';
                    $acao = 'view';
                    break;

                case '1': // Admin
                    $controlador = 'Muralestagios';
                    $acao = 'index';
                    break;

                default:
                    $this->Flash->error(__('Categoria inválida.'));
                    $this->Authentication->logout();

                    return $this->redirect(['action' => 'login']);
            }

            $this->Flash->success(__('Login realizado com sucesso'));

            // Redirect using parameters
            return $this->redirect(['controller' => $controlador, 'action' => $acao, $parametro]);
        }

        if ($this->request->is('post') && $result && !$result->isValid()) {
            $this->Flash->error(__('Usuário ou senha inválidos'));
        }
    }

    public function logout()
    {
        $this->Authorization->skipAuthorization();
        $result = $this->Authentication->getResult();
        if ($result && $result->isValid()) {
            $this->Authentication->logout();
            $this->Flash->success(__('Até mais!'));
        }

        return $this->redirect(['action' => 'login']);
    }

    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $this->Authorization->skipAuthorization();
        $user = $this->Authentication->getIdentity();

        if ($user && $user->categoria == 1) {
            $users = $this->paginate($this->Users);
            $this->set(compact('users'));
        } else {
            $this->Flash->error(__('Usuário não autorizado'));

            return $this->redirect(['action' => 'login']);
        }
    }

    /**
     * View method
     *
     * @param string|null $id User id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view(?string $id = null)
    {
        try {
            $user = $this->Users->get($id, [
                'contain' => [],
            ]);
        } catch (RecordNotFoundException $e) {
            $this->Flash->error(__('Usuário não encontrado.'));

            return $this->redirect(['action' => 'index']);
        }
        $this->Authorization->authorize($user);
        $this->set('user', $user);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $this->Authorization->skipAuthorization();
        $user = $this->Users->newEmptyEntity();

        if ($this->request->is('post')) {
            $user = $this->Users->patchEntity($user, $this->request->getData());
            if ($this->Users->save($user)) {
                $this->Flash->success(__('Usuário cadastrado.'));

                // Post-save logic to link depending on category
                switch ($user->categoria) {
                    case '2': // Aluno
                        $aluno = $this->fetchTable('Alunos')->find()
                            ->where(['Alunos.registro' => $user->numero])
                            ->first();

                        if ($aluno) {
                            $user->aluno_id = $aluno->id;
                            $this->Users->save($user);

                            return $this->redirect(['controller' => 'Alunos', 'action' => 'view', $aluno->id]);
                        } else {
                             $this->Flash->error(__('Redireciona para continuar com o cadastro do(a) aluno(a).'));

                             return $this->redirect(['controller' => 'Alunos', 'action' => 'add', '?' => ['dre' => $user->numero, 'email' => $user->email]]);
                        }
                        break;

                    case '3': // Professor
                         $professor = $this->fetchTable('Professores')->find()
                             ->where(['Professores.siape' => $user->numero])
                             ->first();
                        if ($professor) {
                            $user->professor_id = $professor->id;
                            $this->Users->save($user);

                            return $this->redirect(['controller' => 'Professores', 'action' => 'view', $professor->id]);
                        } else {
                            return $this->redirect(['controller' => 'Professores', 'action' => 'add', '?' => ['siape' => $user->numero, 'email' => $user->email]]);
                        }
                        break;

                    case '4': // Supervisor
                        $supervisor = $this->fetchTable('Supervisores')->find()
                            ->where(['Supervisores.cress' => $user->numero])
                            ->first();
                        if ($supervisor) {
                            $user->supervisor_id = $supervisor->id;
                            $this->Users->save($user);

                            return $this->redirect(['controller' => 'Supervisores', 'action' => 'view', $supervisor->id]);
                        } else {
                            return $this->redirect(['controller' => 'Supervisores', 'action' => 'add', '?' => ['cress' => $user->numero, 'email' => $user->email]]);
                        }
                        break;
                }

                return $this->redirect(['action' => 'login']);
            }
            $this->Flash->error(__('Usuário não foi cadastrado. Tente novamente.'));
        }
        $this->set(compact('user'));
    }

    /**
     * Edit method
     *
     * @param string|null $id User id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit(?string $id = null)
    {
        try {
            $user = $this->Users->get($id, [
                'contain' => [],
            ]);
        } catch (RecordNotFoundException $e) {
            $this->Flash->error(__('Usuário não encontrado.'));

            return $this->redirect(['action' => 'index']);
        }

        $this->Authorization->authorize($user);

        if ($this->request->is(['patch', 'post', 'put'])) {
            $user = $this->Users->patchEntity($user, $this->request->getData());
            if ($this->Users->save($user)) {
                $this->Flash->success(__('Usuário atualizado.'));

                return $this->redirect(['action' => 'view', $user->id]);
            }
            $this->Flash->error(__('Usuário não atualizado.'));
        }
        $this->set(compact('user'));
    }

    /**
     * Delete method
     *
     * @param string|null $id User id.
     * @return \Cake\Http\Response|null|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete(?string $id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        try {
            $user = $this->Users->get($id);
        } catch (RecordNotFoundException $e) {
            $this->Flash->error(__('Registro de usuário não encontrado.'));

            return $this->redirect(['action' => 'index']);
        }

        $this->Authorization->authorize($user);

        if ($this->Users->delete($user)) {
            $this->Flash->success(__('Registro de usuário excluído.'));
        } else {
            $this->Flash->error(__('Registro de usuário não excluído.'));
        }

        return $this->redirect(['action' => 'index']); // or login
    }
}
