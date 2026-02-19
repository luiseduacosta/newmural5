<?php
declare(strict_types=1);

namespace App\Controller;

/**
 * Areainstituicoes Controller
 *
 * @property \App\Model\Table\AreainstituicoesTable $Areainstituicoes
 * 
 * @method \App\Model\Entity\Areainstituicao[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class AreainstituicoesController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        try {
            $this->Authorization->authorize($this->Areainstituicoes);
        } catch (\Authorization\Exception\ForbiddenException $e) {
            $this->Flash->error(__("Acesso negado. Você não tem permissão para visualizar as áreas de instituição."));
            return $this->redirect(["controller" => "Instituicoes", "action" => "index"]);
        }
        $areainstituicoes = $this->paginate($this->Areainstituicoes);
        $this->set(compact('areainstituicoes'));
    }

    /**
     * View method
     *
     * @param string|null $id Areainstituicao id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        try {
            $areainstituicao = $this->Areainstituicoes->get($id, [
                'contain' => ['Instituicoes' => ['sort' => ['instituicao' => 'ASC']]],
            ]);
        } catch (\Cake\Datasource\Exception\RecordNotFoundException $e) {
            $this->Flash->error(__('Área de instituição não encontrada.'));
            return $this->redirect(['action' => 'index']);
        }

        try {
            $this->Authorization->authorize($areainstituicao);
        } catch (\Authorization\Exception\ForbiddenException $e) {
            $this->Flash->error(__("Acesso negado. Você não tem permissão para visualizar a área de instituição."));
            return $this->redirect(["controller" => "Instituicoes", "action" => "index"]);
        }
        $this->set(compact('areainstituicao'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $areainstituicao = $this->Areainstituicoes->newEmptyEntity();
        try {
            $this->Authorization->authorize($areainstituicao);
        } catch (\Authorization\Exception\ForbiddenException $e) {
            $this->Flash->error(__("Acesso negado. Você não tem permissão para inserir áreas de instituição."));
            return $this->redirect(["controller" => "Instituicoes", "action" => "index"]);
        }

        if ($this->request->is('post')) {
            $areainstituicao = $this->Areainstituicoes->patchEntity($areainstituicao, $this->request->getData());
            if ($this->Areainstituicoes->save($areainstituicao)) {
                $this->Flash->success(__('Área de instituição inserida.'));
                return $this->redirect(['action' => 'view', $areainstituicao->id]);
            }
            $this->Flash->error(__('Área de instituição não inserida.'));
            return $this->redirect(['action' => 'index']);
        }
        $this->set(compact('areainstituicao'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Areainstituicao id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        try {
            $areainstituicao = $this->Areainstituicoes->get($id, [
                'contain' => [],
            ]);
        } catch (\Cake\Datasource\Exception\RecordNotFoundException $e) {
            $this->Flash->error(__('Área de instituição não encontrada.'));
            return $this->redirect(['action' => 'index']);
        }

        try {
            $this->Authorization->authorize($areainstituicao);
        } catch (\Authorization\Exception\ForbiddenException $e) {
            $this->Flash->error(__("Acesso negado. Você não tem permissão para editar a área de instituição."));
            return $this->redirect(["controller" => "Instituicoes", "action" => "index"]);
        }

        if ($this->request->is(['patch', 'post', 'put'])) {
            $areainstituicao = $this->Areainstituicoes->patchEntity($areainstituicao, $this->request->getData());
            if ($this->Areainstituicoes->save($areainstituicao)) {
                $this->Flash->success(__('Área de instituição atualizada.'));
                return $this->redirect(['action' => 'view', $areainstituicao->id]);
            }
            $this->Flash->error(__('Área de instituição não atualizada. Tente novamente'));
            return $this->redirect(['action' => 'view', $areainstituicao->id]);
        }
        $this->set(compact('areainstituicao'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Areainstituicao id.
     * @return \Cake\Http\Response|null|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        try {
            $areainstituicao = $this->Areainstituicoes->get($id, [
                'contain' => [],
            ]);
        } catch (\Cake\Datasource\Exception\RecordNotFoundException $e) {
            $this->Flash->error(__('Área de instituição não encontrada.'));
            return $this->redirect(['action' => 'index']);
        }
        
        try {
            $this->Authorization->authorize($areainstituicao);
        } catch (\Authorization\Exception\ForbiddenException $e) {
            $this->Flash->error(__("Acesso negado. Você não tem permissão para excluir a área de instituição."));
            return $this->redirect(["controller" => "Instituicoes", "action" => "index"]);
        }

        if ($this->Areainstituicoes->delete($areainstituicao)) {
            $this->Flash->success(__('Área da instituição excluída.'));
        } else {
            $this->Flash->error(__('Área da instituição não excluída. Tente novamente'));
        }
        return $this->redirect(['action' => 'index']);
    }
}
