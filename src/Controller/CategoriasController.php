<?php
declare(strict_types=1);

namespace App\Controller;

/**
 * Categorias Controller
 *
 * @property \App\Model\Table\CategoriasTable $Categorias
 * @method \App\Model\Entity\Categoria[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class CategoriasController extends AppController {

    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index() {
        $this->Authorization->skipAuthorization();
        $categorias = $this->paginate($this->Categorias);
        $this->set(compact('categorias'));
    }

    /**
     * View method
     *
     * @param string|null $id Categoria id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null) {
        $this->Authorization->skipAuthorization();
        try {   
            $categoria = $this->Categorias->get($id, [
                'contain' => [],
            ]);
        } catch (\Cake\Datasource\Exception\RecordNotFoundException $e) {
            $this->Flash->error(__('Registro categoria nao foi encontrado. Tente novamente.'));
            return $this->redirect(['action' => 'index']);
        }

        $this->set(compact('categoria'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add() {
        $categoria = $this->Categorias->newEmptyEntity();
        $this->Authorization->authorize($categoria);
        if ($this->request->is('post')) {
            $categoria = $this->Categorias->patchEntity($categoria, $this->request->getData());
            if ($this->Categorias->save($categoria)) {
                $this->Flash->success(__('Registro categoria inserido.'));
                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('Registro categoria nao foi inserido. Tente novament.'));
        }
        $this->set(compact('categoria'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Categoria id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null) {
        try {
            $categoria = $this->Categorias->get($id, [
                'contain' => [],
            ]);
        } catch (\Cake\Datasource\Exception\RecordNotFoundException $e) {
            $this->Flash->error(__('Registro categoria nao foi encontrado. Tente novamente.'));
            return $this->redirect(['action' => 'index']);
        }
        $this->Authorization->authorize($categoria);
        
        if ($this->request->is(['patch', 'post', 'put'])) {
            $categoria = $this->Categorias->patchEntity($categoria, $this->request->getData());
            if ($this->Categorias->save($categoria)) {
                $this->Flash->success(__('Registro categoria atualizadao.'));
                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('Registro categoria nao foi atualizado. Tente novamente.'));
        }
        $this->set(compact('categoria'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Categoria id.
     * @return \Cake\Http\Response|null|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null) {
        $this->request->allowMethod(['post', 'delete']);
        try {
            $categoria = $this->Categorias->get($id);
        } catch (\Cake\Datasource\Exception\RecordNotFoundException $e) {
            $this->Flash->error(__('Registro categoria nao foi encontrado. Tente novamente.'));
            return $this->redirect(['action' => 'index']);
        }
        $this->Authorization->authorize($categoria);

        if ($this->Categorias->delete($categoria)) {
            $this->Flash->success(__('Registro categoria excluido.'));
        } else {
            $this->Flash->error(__('Registro categoria nao foi excluido. Tente novamente.'));
        }
        
        return $this->redirect(['action' => 'index']);
    }
}
