<?php
declare(strict_types=1);

namespace App\Controller;

use Authorization\Exception\ForbiddenException;
use Cake\Datasource\Exception\RecordNotFoundException;

/**
 * Configuracoes Controller
 *
 * @property \App\Model\Table\ConfiguracoesTable $Configuracoes
 * @method \App\Model\Entity\Configuracao[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class ConfiguracoesController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {

        try {
            $this->Authorization->authorize($this->Configuracoes);
        } catch (ForbiddenException $e) {
            $this->Flash->error(__('Acesso negado. Você não tem permissão para acessar esta página.'));

            return $this->redirect(['action' => 'index']);
        }
        // This table has only one record, so get it directly
        $configuracao = $this->Configuracoes->find()->first();
        $this->set(compact('configuracao'));
    }

    /**
     * View method
     *
     * @param string|null $id Configuracao id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view(?string $id = null)
    {

        try {
            $configuracao = $this->Configuracoes->get($id, [
                'contain' => [],
            ]);
        } catch (RecordNotFoundException $e) {
            $this->Flash->error(__('Configuração não foi encontrada. Tente novamente.'));

            return $this->redirect(['action' => 'index']);
        }

        try {
            $this->Authorization->authorize($configuracao);
        } catch (ForbiddenException $e) {
            $this->Flash->error(__('Acesso negado. Você não tem permissão para acessar esta página.'));

            return $this->redirect(['action' => 'index']);
        }
        $this->set(compact('configuracao'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {

        $configuracao = $this->Configuracoes->newEmptyEntity();

        try {
            $this->Authorization->authorize($configuracao);
        } catch (ForbiddenException $e) {
            $this->Flash->error(__('Acesso negado. Você não tem permissão para acessar esta página.'));

            return $this->redirect(['action' => 'index']);
        }

        if ($this->request->is('post')) {
            $configuracao = $this->Configuracoes->patchEntity($configuracao, $this->request->getData());
            if ($this->Configuracoes->save($configuracao)) {
                $this->Flash->success(__('Dados de configuração inseridos.'));

                return $this->redirect(['action' => 'view', $configuracao->id]);
            }
            $this->Flash->error(__('Dados de configuração não foram inseridos. Tente novamente.'));
        }
        $this->set(compact('configuracao'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Configuracao id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit(?string $id = null)
    {

        try {
            $configuracao = $this->Configuracoes->get($id, [
                'contain' => [],
            ]);
        } catch (RecordNotFoundException $e) {
            $this->Flash->error(__('Configuração não foi encontrada. Tente novamente.'));

            return $this->redirect(['action' => 'index']);
        }

        try {
            $this->Authorization->authorize($configuracao);
        } catch (ForbiddenException $e) {
            $this->Flash->error(__('Acesso negado. Você não tem permissão para acessar esta página.'));

            return $this->redirect(['action' => 'index']);
        }

        if ($this->request->is(['patch', 'post', 'put'])) {
            $configuracao = $this->Configuracoes->patchEntity($configuracao, $this->request->getData());
            if ($this->Configuracoes->save($configuracao)) {
                $this->Flash->success(__('Configuração atualizada.'));

                return $this->redirect(['action' => 'view', $id]);
            }
            $this->Flash->error(__('Não foi possível atualizar a configuração. Tente novamente.'));
        }
        $this->set(compact('configuracao'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Configuracao id.
     * @return \Cake\Http\Response|null|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete(?string $id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        try {
            $configuracao = $this->Configuracoes->get($id);
        } catch (RecordNotFoundException $e) {
            $this->Flash->error(__('Configuração não foi encontrada. Tente novamente.'));

            return $this->redirect(['action' => 'index']);
        }

        try {
            $this->Authorization->authorize($configuracao);
        } catch (ForbiddenException $e) {
            $this->Flash->error(__('Acesso negado. Você não tem permissão para acessar esta página.'));

            return $this->redirect(['action' => 'index']);
        }

        if ($this->Configuracoes->delete($configuracao)) {
            $this->Flash->success(__('Dados de configuração excluídos.'));
        } else {
            $this->Flash->error(__('Não foi possível excluír os dados de configuração. Tente novamente.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
