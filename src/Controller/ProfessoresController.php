<?php
declare(strict_types=1);

namespace App\Controller;

use Authorization\Exception\ForbiddenException;
use Cake\Datasource\Exception\RecordNotFoundException;
use Cake\Event\EventInterface;

/**
 * Professores Controller
 *
 * @property \App\Model\Table\ProfessoresTable $Professores
 * @property \Authorization\Controller\Component\AuthorizationComponent $Authorization
 * @property \Authentication\Controller\Component\AuthenticationComponent $Authentication
 * @method \App\Model\Entity\Professor[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class ProfessoresController extends AppController
{
    public function beforeFilter(EventInterface $event): void
    {
        parent::beforeFilter($event);
        $this->Authentication->addUnauthenticatedActions(['index', 'view', 'buscaprofessor']);
    }

    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        try {
            $this->Authorization->authorize($this->Professores);
        } catch (ForbiddenException $e) {
            $this->Flash->error(__('Acesso negado. Você não tem permissão para acessar esta página.'));

            return $this->redirect(['controller' => 'Muralestagios', 'action' => 'index']);
        }

        $query = $this->Professores->find();

        // Sorting managed by paginate defaults or query params
        $query->order(['nome' => 'ASC']);

        $professores = $this->paginate($query, [
            'sortableFields' => ['nome', 'siape', 'departamento', 'dataingresso', 'dataegresso'],
        ]);

        if (count($professores) === 0) {
            $this->Flash->error(__('Nenhum(a) professor(a) encontrado.'));
        }

        $this->set(compact('professores'));
    }

    /**
     * View method
     *
     * @param string|null $id Professor id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view(?string $id = null)
    {
        if ($this->user && $this->user->categoria == 3) {
            // After adding a new record, the user table needs to be reloaded to get the new value of professor_id
            $usercadastrado = $this->fetchTable('Users')->get($this->user->id);
            $this->set('user', $usercadastrado);
            $id = $usercadastrado->professor_id;
        }

        if ($id == null) {
             $this->Flash->error(__('Professor(a) não identificado(a).'));

             return $this->redirect(['action' => 'index']);
        }

        /** Têm Professores com muitos estagiários: aumentar a memória */
        ini_set('memory_limit', '2048M');

        try {
            $professor = $this->Professores->get(
                $id,
                [
                    'contain' => ['Estagiarios' => ['sort' => ['Estagiarios.periodo' => 'DESC'], 'Instituicoes', 'Supervisores', 'Professores', 'Alunos', 'Folhadeatividades', 'Respostas']],
                ],
            );
        } catch (RecordNotFoundException $e) {
            $this->Flash->error(__('Não há registros de professor para esse número!'));

            return $this->redirect(['action' => 'index']);
        }

        try {
            $this->Authorization->authorize($professor);
        } catch (ForbiddenException $e) {
            $this->Flash->error(__('Acesso negado. Você não tem permissão para acessar esta página.'));

            return $this->redirect(['controller' => 'Muralestagios', 'action' => 'index']);
        }

        $this->set(compact('professor'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {

        $this->Authorization->skipAuthorization();
        // This fields cames from the adding of the UserController
        $siape = $this->getRequest()->getQuery('siape');
        $email = $this->getRequest()->getQuery('email');

        // Verify is there is a record with this values
        if ($siape && $email) {
            $professor = $this->Professores->find()
                ->where(['siape' => $siape, 'email' => $email])
                ->first();
            if ($professor) {
                $this->Flash->error(__('Já existe um professor com este SIAPE e email.'));

                return $this->redirect(['action' => 'view', $professor->id]);
            }
        }

        if ($siape) {
            $this->set('siape', $siape);
        }
        if ($email) {
            $this->set('email', $email);
        }

        $professor = $this->Professores->newEmptyEntity();

        try {
            $this->Authorization->authorize($professor);
        } catch (ForbiddenException $e) {
            $this->Flash->error(__('Acesso negado. Você não tem permissão para acessar esta página.'));

            return $this->redirect(['controller' => 'Muralestagios', 'action' => 'index']);
        }

        if ($this->request->is('post')) {
            $data = $this->request->getData();

            $professor = $this->Professores->patchEntity($professor, $data);
            if ($this->Professores->save($professor)) {
                $this->Flash->success(__('Registro do(a) professor(a) inserido.'));
                if ($this->user && $this->user->categoria == 3 && $this->user->professor_id == null) {
                    $userEntity = $this->fetchTable('Users')->get($this->user->id);
                    $userEntity->professor_id = $professor->id;
                    $this->fetchTable('Users')->save($userEntity);
                }

                return $this->redirect(['action' => 'view', $professor->id]);
            }
            $this->Flash->error(__('Registro do(a) professor(a) não inserido. Tente novamente.'));
        }
        $this->set(compact('professor'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Professor id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit(?string $id = null)
    {
        try {
            $professor = $this->Professores->get($id, [
                'contain' => [],
            ]);
        } catch (RecordNotFoundException $e) {
            $this->Flash->error(__('Professor incorreto.'));

            return $this->redirect(['action' => 'index']);
        }

        try {
            $this->Authorization->authorize($professor);
        } catch (ForbiddenException $e) {
            $this->Flash->error(__('Acesso negado. Você não tem permissão para acessar esta página.'));

            return $this->redirect(['controller' => 'Muralestagios', 'action' => 'index']);
        }

        if ($this->request->is(['patch', 'post', 'put'])) {
            $professor = $this->Professores->patchEntity($professor, $this->request->getData());
            if ($this->Professores->save($professor)) {
                $this->Flash->success(__('Registro do(a) professor(a) atualizado.'));

                return $this->redirect(['action' => 'view', $id]);
            }
            $this->Flash->error(__('Registro do(a) professor(a) não foi atualizado. Tente novamente.'));
        }
        $this->set(compact('professor'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Professor id.
     * @return \Cake\Http\Response|null|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete(?string $id = null)
    {
        $this->request->allowMethod(['post', 'delete']);

        try {
            $professor = $this->Professores->get($id, [
                'contain' => ['Estagiarios'],
            ]);
        } catch (RecordNotFoundException $e) {
            $this->Flash->error(__('Professor(a) não encontrado.'));

            return $this->redirect(['action' => 'index']);
        }

        try {
            $this->Authorization->authorize($professor);
        } catch (ForbiddenException $e) {
            $this->Flash->error(__('Acesso negado. Você não tem permissão para acessar esta página.'));

            return $this->redirect(['controller' => 'Muralestagios', 'action' => 'index']);
        }

        if (count($professor->estagiarios) > 0) {
            $this->Flash->error(__('Professor(a) tem estagiários associados'));

            return $this->redirect(['controller' => 'Professores', 'action' => 'view', $id]);
        }

        // Delete the professor from the Users table if the user is a teacher
        $user = $this->Professores->Users
            ->find()
            ->where(['Users.professor_id' => $id])
            ->first();
        if ($user) {
            $this->Professores->Users->delete($user);
        }

        if ($this->Professores->delete($professor)) {
            $this->Flash->success(__('Registro professor(a) excluído.'));
        } else {
            $this->Flash->error(__('Registro professor(a) não foi excluído. Tente novamente.'));
        }

        return $this->redirect(['action' => 'index']);
    }

    /**
     * Busca professor method
     *
     * @return \Cake\Http\Response|null|void Redirects to index.
     */
    public function buscaprofessor()
    {
        $this->Authorization->skipAuthorization();
        $nome = $this->getRequest()->getData('nome');

        if ($nome) {
            $query = $this->Professores->find()
                ->where(['nome LIKE' => "%{$nome}%"])
                ->order(['nome' => 'ASC']);

            if ($query->count() == 0) {
                $this->Flash->error(__('Nenhum(a) professor(a) encontrado com o nome: ' . $nome));

                return $this->redirect(['controller' => 'Professores', 'action' => 'index']);
            }

            $professores = $this->paginate($query);
            $this->set('professores', $professores);
            $this->render('index');
        } else {
            $this->Flash->error(__('Digite um nome para buscar'));

            return $this->redirect(['controller' => 'Professores', 'action' => 'index']);
        }
    }
}
