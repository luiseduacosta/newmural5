<?php
declare(strict_types=1);

namespace App\Controller;

use Authorization\Exception\ForbiddenException;
use Cake\Datasource\Exception\RecordNotFoundException;

/**
 * Supervisores Controller
 *
 * @property \App\Model\Table\SupervisoresTable $Supervisores
 * @property \Authorization\Controller\Component\AuthorizationComponent $Authorization
 * @property \Authentication\Controller\Component\AuthenticationComponent $Authentication
 * @method \App\Model\Entity\Supervisor[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class SupervisoresController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        try {
            $this->Authorization->authorize($this->Supervisores);
        } catch (ForbiddenException $e) {
            $this->Flash->error(__('Acesso negado. Você não tem permissão para acessar esta página.'));

            return $this->redirect(['controller' => 'Muralestagios', 'action' => 'index']);
        }

        $query = $this->Supervisores->find();

        if ($query->count() === 0) {
            $this->Flash->error(__('Nenhum supervisor encontrado.'));
            // return $this->redirect(['action' => 'add']); // Avoid redirect if empty, just show empty index
        }

        $query->order(['nome' => 'ASC']);

        $supervisores = $this->paginate($query, [
            'sortableFields' => ['nome', 'cress'],
        ]);

        $this->set(compact('supervisores'));
    }

    /**
     * View method
     *
     * @param string|null $id Supervisor id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view(?string $id = null)
    {
        $this->Authorization->skipAuthorization();
        if ($this->user && $this->user->categoria == 4) {
            // After adding a new record, the user table needs to be reloaded to get the new value of supervisor_id
            $usercadastrado = $this->fetchTable('Users')->get($this->user->id);
            $this->set('user', $usercadastrado);
            $id = $usercadastrado->supervisor_id;
        }

        if ($id === null) {
                $this->Flash->error(__('Supervisora não encontrada.'));

                return $this->redirect(['action' => 'index']);
        }

        try {
            // Ordenar os estagiários por período
            $supervisor = $this->Supervisores->get($id, [
                'contain' => [
                    'Instituicoes' => ['Areainstituicoes'],
                    'Estagiarios' => [
                        'sort' => ['Estagiarios.periodo' => 'DESC'],
                        'Alunos',
                        'Supervisores',
                        'Professores',
                        'Instituicoes',
                    ],
                ],
            ]);
        } catch (RecordNotFoundException $e) {
            $this->Flash->error(__('Supervisora não encontrada.'));

            return $this->redirect(['action' => 'index']);
        }

        try {
            $this->Authorization->authorize($supervisor);
        } catch (ForbiddenException $e) {
            $this->Flash->error(__('Acesso negado. Você não tem permissão para acessar esta página.'));

            return $this->redirect(['controller' => 'Muralestagios', 'action' => 'index']);
        }

        $this->set(compact('supervisor'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        // This fields cames from the adding of the UserController
        $cress = $this->getRequest()->getQuery('cress');
        $email = $this->getRequest()->getQuery('email');

        if ($cress && $email) {
            $supervisor = $this->Supervisores->find()
                ->where(['cress' => $cress, 'email' => $email])
                ->first();
            if ($supervisor) {
                $this->Flash->error(__('Já existe um supervisor com este CRESS e email.'));

                return $this->redirect(['action' => 'view', $supervisor->id]);
            }
            $this->set('cress', $cress);
            $this->set('email', $email);
        }

        $supervisor = $this->Supervisores->newEmptyEntity();
        try {
            $this->Authorization->authorize($supervisor);
        } catch (ForbiddenException $e) {
            $this->Flash->error(__('Acesso negado. Você não tem permissão para acessar esta página.'));

            return $this->redirect(['controller' => 'Muralestagios', 'action' => 'index']);
        }

        if ($this->request->is('post')) {
            $supervisor = $this->Supervisores->patchEntity($supervisor, $this->request->getData());
            if ($this->Supervisores->save($supervisor)) {
                if ($this->user && $this->user->categoria == 4 && $this->user->supervisor_id == null) {
                    $userEntity = $this->fetchTable('Users')->get($this->user->id);
                    $userEntity->supervisor_id = $supervisor->id;
                    $this->fetchTable('Users')->save($userEntity);
                }
                $this->Flash->success(__('Registro de supervisora atualizado.'));

                return $this->redirect(['action' => 'view', $supervisor->id]);
            }
            $this->Flash->error(__('O registro da supervisora não foi atualizado. Tente novamente.'));
            // return $this->redirect(['action' => 'index']);
        }
        $instituicoes = $this->Supervisores->Instituicoes->find('list', ['order' => ['instituicao' => 'ASC']]);
        $this->set(compact('supervisor', 'instituicoes'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Supervisor id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit(?string $id = null)
    {
        try {
            $supervisor = $this->Supervisores->get($id, [
                'contain' => ['Instituicoes'], // check if multiple selection allowed or belongsTo?
            ]);
        } catch (RecordNotFoundException $e) {
            $this->Flash->error(__('Supervisora não encontrada.'));

            return $this->redirect(['action' => 'index']);
        }

        try {
            $this->Authorization->authorize($supervisor);
        } catch (ForbiddenException $e) {
            $this->Flash->error(__('Acesso negado. Você não tem permissão para acessar esta página.'));

            return $this->redirect(['controller' => 'Muralestagios', 'action' => 'index']);
        }

        if ($this->request->is(['patch', 'post', 'put'])) {
            $supervisor = $this->Supervisores->patchEntity($supervisor, $this->request->getData());
            if ($this->Supervisores->save($supervisor)) {
                $this->Flash->success(__('Supervisora atualizada com sucesso.'));

                return $this->redirect(['action' => 'view', $id]);
            }
            $this->Flash->error(__('A supervisora não foi atualizada. Tente novamente.'));
        }
        $instituicoes = $this->Supervisores->Instituicoes->find('list', ['order' => ['instituicao' => 'ASC']]);
        $this->set(compact('supervisor', 'instituicoes'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Supervisor id.
     * @return \Cake\Http\Response|null|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete(?string $id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        try {
            $supervisor = $this->Supervisores->get($id);
        } catch (RecordNotFoundException $e) {
            $this->Flash->error(__('Supervisora não encontrada.'));

            return $this->redirect(['action' => 'index']);
        }

        try {
            $this->Authorization->authorize($supervisor);
        } catch (ForbiddenException $e) {
            $this->Flash->error(__('Acesso negado. Você não tem permissão para acessar esta página.'));

            return $this->redirect(['controller' => 'Muralestagios', 'action' => 'index']);
        }

        // Delete the supervisor from the Users table if the user is a supervisor
        $user = $this->Supervisores->Users
            ->find()
            ->where(['Users.supervisor_id' => $id])
            ->first();
        if ($user) {
            $this->Supervisores->Users->delete($user);
        }

        if ($this->Supervisores->delete($supervisor)) {
            $this->Flash->success(__('Registro de supervisora excluído com sucesso.'));
        } else {
            $this->Flash->error(__('Registro de supervisora não excluído. Tente novamente.'));

             return $this->redirect(['action' => 'view', $id]);
        }

        return $this->redirect(['action' => 'index']);
    }

    /**
     * Busca supervisor por nome
     *
     * @return \Cake\Http\Response|null|void
     */
    public function buscasupervisor()
    {
        $this->Authorization->skipAuthorization();
        $nome = trim((string)$this->request->getData('nome'));

        if ($nome) {
            $query = $this->Supervisores->find()
                ->where(['Supervisores.nome LIKE' => "%$nome%"])
                ->order(['Supervisores.nome' => 'asc']);

            if ($query->count() > 0) {
                $this->Flash->success(__("Supervisores encontrados com o nome '$nome'."));
                $this->set('supervisores', $this->paginate($query));
                $this->render('index');
            } else {
                $this->Flash->error(__("Nenhum supervisor encontrado com o nome '$nome'."));

                return $this->redirect(['action' => 'index']);
            }
        } else {
            $this->Flash->error(__('Digite um nome para buscar'));

            return $this->redirect(['action' => 'index']);
        }
    }
}
