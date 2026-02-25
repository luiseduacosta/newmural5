<?php
declare(strict_types=1);

namespace App\Controller;

use Authorization\Exception\ForbiddenException;
use Cake\Datasource\Exception\RecordNotFoundException;

/**
 * Questionarios Controller
 *
 * @property \App\Model\Table\QuestionariosTable $Questionarios
 * @property \Authorization\Controller\Component\AuthorizationComponent $Authorization
 * @property \Authentication\Controller\Component\AuthenticationComponent $Authentication
 * @method \App\Model\Entity\Questionario[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class QuestionariosController extends AppController
{
    public function initialize(): void
    {
        parent::initialize();

        $this->loadComponent('Authorization.Authorization');
        $this->loadComponent('Authentication.Authentication');
    }

    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        try {
            $this->Authorization->authorize($this->Questionarios);
        } catch (ForbiddenException $e) {
            $this->Flash->error(__('Acesso negado. Você não tem permissão para acessar esta página.'));

            return $this->redirect(['controller' => 'Muralestagiarios', 'action' => 'index']);
        }
        $questionarios = $this->paginate($this->Questionarios);
        $this->set(compact('questionarios'));
    }

    /**
     * View method
     *
     * @param string|null $id Questionario id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view(?string $id = null)
    {
        try {
            $questionario = $this->Questionarios->get($id, [
                'contain' => ['Questoes'],
            ]);
        } catch (RecordNotFoundException $e) {
            $this->Flash->error(__('Registro não encontrado.'));

            return $this->redirect(['controller' => 'Questionarios', 'action' => 'index']);
        }

        try {
            $this->Authorization->authorize($questionario);
        } catch (ForbiddenException $e) {
            $this->Flash->error(__('Acesso negado. Você não tem permissão para acessar esta página.'));

            return $this->redirect(['controller' => 'Muralestagiarios', 'action' => 'index']);
        }
        $this->set(compact('questionario'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $questionario = $this->Questionarios->newEmptyEntity();

        try {
            $this->Authorization->authorize($questionario);
        } catch (ForbiddenException $e) {
            $this->Flash->error(__('Acesso negado. Você não tem permissão para acessar esta página.'));

            return $this->redirect(['controller' => 'Muralestagiarios', 'action' => 'index']);
        }

        if ($this->request->is('post')) {
            $questionario = $this->Questionarios->patchEntity($questionario, $this->request->getData());
            if ($this->Questionarios->save($questionario)) {
                $this->Flash->success(__('Questionário inserido.'));

                return $this->redirect(['controller' => 'Questionarios', 'action' => 'view', $questionario->id]);
            }
            $this->Flash->error(__('Questionário não inserido. Tente novamente.'));
        }
        $this->set(compact('questionario'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Questionario id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit(?string $id = null)
    {
        try {
            $questionario = $this->Questionarios->get($id, [
                'contain' => [],
            ]);
        } catch (RecordNotFoundException $e) {
            $this->Flash->error(__('Registro não encontrado.'));

            return $this->redirect(['controller' => 'Questionarios', 'action' => 'index']);
        }

        try {
            $this->Authorization->authorize($questionario);
        } catch (ForbiddenException $e) {
            $this->Flash->error(__('Acesso negado. Você não tem permissão para acessar esta página.'));

            return $this->redirect(['controller' => 'Muralestagiarios', 'action' => 'index']);
        }

        if ($this->request->is(['patch', 'post', 'put'])) {
            $questionario = $this->Questionarios->patchEntity($questionario, $this->request->getData());
            if ($this->Questionarios->save($questionario)) {
                $this->Flash->success(__('Questionário atualizado.'));

                return $this->redirect(['controller' => 'Questionarios', 'action' => 'view', $questionario->id]);
            }
            $this->Flash->error(__('Questionário não atualizado. Tente novamente.'));
        }
        $this->set(compact('questionario'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Questionario id.
     * @return \Cake\Http\Response|null|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete(?string $id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        try {
            $questionario = $this->Questionarios->get($id, [
                'contain' => [],
            ]);
        } catch (RecordNotFoundException $e) {
            $this->Flash->error(__('Registro não encontrado.'));

            return $this->redirect(['controller' => 'Questionarios', 'action' => 'index']);
        }

        // Check if the questionario has any associated respostas
        $respostasCount = $this->Respostas->find()
            ->where(['Respostas.questionario_id' => $questionario->id])
            ->count();

        if ($respostasCount > 0) {
            $this->Flash->error(__('Este questionário possui respostas associadas. Exclua as respostas antes de excluir o questionário.'));

            return $this->redirect(['controller' => 'Questionarios', 'action' => 'view', $questionario->id]);
        }

        try {
            $this->Authorization->authorize($questionario);
        } catch (ForbiddenException $e) {
            $this->Flash->error(__('Acesso negado. Você não tem permissão para acessar esta página.'));

            return $this->redirect(['controller' => 'Muralestagiarios', 'action' => 'index']);
        }

        if ($this->Questionarios->delete($questionario)) {
            $this->Flash->success(__('Questionário excluído.'));
        } else {
            $this->Flash->error(__('Questionário não excluído. Tente novamente.'));
        }

        return $this->redirect(['controller' => 'Questionarios', 'action' => 'index']);
    }
}
