<?php
declare(strict_types=1);

namespace App\Controller;

/**
 * Complementos Controller
 *
 * @property \App\Model\Table\ComplementosTable $Complementos
 * @method \App\Model\Entity\Complemento[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class ComplementosController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        try {
            $this->Authorization->authorize($this->Complementos);
        } catch (\Authorization\Exception\ForbiddenException $e) {
            $this->Flash->error(__('Acesso negado. Você não tem permissão para acessar esta página.'));
            return $this->redirect(['action' => 'index']);
        }
        $complementos = $this->paginate($this->Complementos);
        $this->set(compact('complementos'));
    }

    /**
     * View method
     *
     * @param string|null $id Complemento id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        try {
            $complemento = $this->Complementos->get($id, [
                'contain' => ['Estagiarios'],
            ]);
        } catch (\Cake\Datasource\Exception\RecordNotFoundException $e) {
            $this->Flash->error(__('Complemento nao foi encontrado. Tente novamente.'));
            return $this->redirect(['action' => 'index']);
        }

        try {
            $this->Authorization->authorize($complemento);
        } catch (\Authorization\Exception\ForbiddenException $e) {
            $this->Flash->error(__('Acesso negado. Você não tem permissão para acessar esta página.'));
            return $this->redirect(['action' => 'index']);
        }

        $this->set(compact('complemento'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $complemento = $this->Complementos->newEmptyEntity();
        try {
            $this->Authorization->authorize($complemento);
        } catch (\Authorization\Exception\ForbiddenException $e) {
            $this->Flash->error(__('Acesso negado. Você não tem permissão para acessar esta página.'));
            return $this->redirect(['action' => 'index']);
        }
        if ($this->request->is('post')) {
            $complemento = $this->Complementos->patchEntity($complemento, $this->request->getData());
            if ($this->Complementos->save($complemento)) {
                $this->Flash->success(__('Complemento inserido.'));
                return $this->redirect(['action' => 'view', $complemento->id]);
            }
            $this->Flash->error(__('Complemento não inserido.'));
        }
        $this->set(compact('complemento'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Complemento id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        try {
            $complemento = $this->Complementos->get($id, [
                'contain' => [],
            ]);
        } catch (\Cake\Datasource\Exception\RecordNotFoundException $e) {
            $this->Flash->error(__('Complemento nao foi encontrado. Tente novamente.'));
            return $this->redirect(['action' => 'index']);
        }
        try {
            $this->Authorization->authorize($complemento);
        } catch (\Authorization\Exception\ForbiddenException $e) {
            $this->Flash->error(__('Acesso negado. Você não tem permissão para acessar esta página.'));
            return $this->redirect(['action' => 'index']);
        }

        if ($this->request->is(['patch', 'post', 'put'])) {
            $complemento = $this->Complementos->patchEntity($complemento, $this->request->getData());
            if ($this->Complementos->save($complemento)) {
                $this->Flash->success(__('Complemento atualizado.'));
                return $this->redirect(['action' => 'view', $complemento->id]);
            }
            $this->Flash->error(__('Complemento não atualizado.'));
        }
        $this->set(compact('complemento'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Complemento id.
     * @return \Cake\Http\Response|null|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        try {
            $complemento = $this->Complementos->get($id);
        } catch (\Cake\Datasource\Exception\RecordNotFoundException $e) {
            $this->Flash->error(__('Complemento nao foi encontrado. Tente novamente.'));
            return $this->redirect(['action' => 'index']);
        }

        try {
            $this->Authorization->authorize($complemento);
        } catch (\Authorization\Exception\ForbiddenException $e) {
            $this->Flash->error(__('Acesso negado. Você não tem permissão para acessar esta página.'));
            return $this->redirect(['action' => 'index']);
        }

        if ($this->Complementos->delete($complemento)) {
            $this->Flash->success(__('Complemento excluído.'));
        } else {
            $this->Flash->error(__('Complemento não excluído.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
