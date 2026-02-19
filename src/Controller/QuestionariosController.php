<?php
declare(strict_types=1);

namespace App\Controller;

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
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        try {
            $this->Authorization->authorize($this->Questionarios);
        } catch (\AuthorizationException $e) {
            $this->Flash->error(__('Erro ao carregar os dados. Tente novamente.'));
            return $this->redirect(['action' => 'index']);
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
    public function view($id = null)
    {
        $this->Authorization->skipAuthorization();
        try {
            $questionario = $this->Questionarios->get($id, [
                'contain' => ['Questiones'],
            ]);
        } catch (\Cake\Datasource\Exception\RecordNotFoundException $e) {
            $this->Flash->error(__('Registro não encontrado.'));
            return $this->redirect(['action' => 'index']);
        }

        try {
            $this->Authorization->authorize($questionario);
        } catch (\AuthorizationException $e) {
            $this->Flash->error(__('Erro ao carregar os dados. Tente novamente.'));
            return $this->redirect(['action' => 'index']);
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
        } catch (\AuthorizationException $e) {
            $this->Flash->error(__('Erro ao carregar os dados. Tente novamente.'));
            return $this->redirect(['action' => 'index']);
        }
        
        if ($this->request->is('post')) {
            $questionario = $this->Questionarios->patchEntity($questionario, $this->request->getData());
            if ($this->Questionarios->save($questionario)) {
                $this->Flash->success(__('Questionário inserido.'));
                return $this->redirect(['action' => 'view', $questionario->id]);
            }
            $this->Flash->error(__('Questionário não inserido. Tente novamente.'));
            // return $this->redirect(['action' => 'index']);
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
    public function edit($id = null)
    {
        try {
            $questionario = $this->Questionarios->get($id, [
                'contain' => [],
            ]);
        } catch (\Cake\Datasource\Exception\RecordNotFoundException $e) {
            $this->Flash->error(__('Registro não encontrado.'));
            return $this->redirect(['action' => 'index']);
        }

        try {
            $this->Authorization->authorize($questionario);
        } catch (\AuthorizationException $e) {
            $this->Flash->error(__('Erro ao carregar os dados. Tente novamente.'));
            return $this->redirect(['action' => 'index']);
        }
        
        if ($this->request->is(['patch', 'post', 'put'])) {
            $questionario = $this->Questionarios->patchEntity($questionario, $this->request->getData());
            if ($this->Questionarios->save($questionario)) {
                $this->Flash->success(__('Questionário atualizado.'));
                return $this->redirect(['action' => 'view', $questionario->id]);
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
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        try {
            $questionario = $this->Questionarios->get($id);
        } catch (\Cake\Datasource\Exception\RecordNotFoundException $e) {
            $this->Flash->error(__('Registro não encontrado.'));
            return $this->redirect(['action' => 'index']);
        }

        try {
            $this->Authorization->authorize($questionario);
        } catch (\AuthorizationException $e) {
            $this->Flash->error(__('Erro ao carregar os dados. Tente novamente.'));
            return $this->redirect(['action' => 'index']);
        }
        
        if ($this->Questionarios->delete($questionario)) {
            $this->Flash->success(__('Questionário excluído.'));
        } else {
            $this->Flash->error(__('Questionário não excluído. Tente novamente.'));
            return $this->redirect(['action' => 'view', $questionario->id]);
        }
        
        return $this->redirect(['action' => 'index']);
    }
}
