<?php
declare(strict_types=1);

namespace App\Controller;

/**
 * Areaestagios Controller
 *
 * @property \App\Model\Table\AreaestagiosTable $Areaestagios
 * @method \App\Model\Entity\Areaestagio[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class AreaestagiosController extends AppController {

    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index() {

        try {
            $this->Authorization->authorize($this->Areaestagios);
        } catch (\Authorization\Exception\ForbiddenException $e) {
            $this->Flash->error(__("Acesso negado. Você não tem permissão para visualizar os registros de área de estágio."));
            return $this->redirect(["controller" => "Muralestagios", "action" => "index"]);
        }
        $areaestagios = $this->paginate($this->Areaestagios);

        $this->set(compact('areaestagios'));
    }

    /**
     * View method
     *
     * @param string|null $id Areaestagio id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null) {

        try {
            $areaestagio = $this->Areaestagios->get($id, [
                'contain' => [],
            ]);
        } catch (\Exception $e) {
            $this->Flash->error(__('Registro areaestagio nao foi encontrado. Tente novamente.'));

            return $this->redirect(['action' => 'index']);
        }

        try {
            $this->Authorization->authorize($areaestagio);
        } catch (\Authorization\Exception\ForbiddenException $e) {
            $this->Flash->error(__("Acesso negado. Você não tem permissão para visualizar o registro de área de estágio."));
            return $this->redirect(["controller" => "Muralestagios", "action" => "index"]);
        }

        $this->set(compact('areaestagio'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add() {

        $areaestagio = $this->Areaestagios->newEmptyEntity();
        try {
            $this->Authorization->authorize($areaestagio);
        } catch (\Authorization\Exception\ForbiddenException $e) {
            $this->Flash->error(__("Acesso negado. Você não tem permissão para inserir registros de área de estágio."));
            return $this->redirect(["controller" => "Muralestagios", "action" => "index"]);
        }

        if ($this->request->is('post')) {
            $areaestagio = $this->Areaestagios->patchEntity($areaestagio, $this->request->getData());
            if ($this->Areaestagios->save($areaestagio)) {
                $this->Flash->success(__('Registro areaestagio inserido.'));

                return $this->redirect(['action' => 'view', $areaestagio->id]);
            }
            $this->Flash->error(__('Registro areaestagio nao foi inserido. Tente novamente.'));
        }
        $this->set(compact('areaestagio'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Areaestagio id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null) {
        
        try {
            $areaestagio = $this->Areaestagios->get($id, [
                'contain' => [],
            ]);
        } catch (\Exception $e) {
            $this->Flash->error(__('Registro areaestagio nao foi encontrado. Tente novamente.'));

            return $this->redirect(['action' => 'index']);
        }

        try {
            $this->Authorization->authorize($areaestagio);
        } catch (\Authorization\Exception\ForbiddenException $e) {
            $this->Flash->error(__("Acesso negado. Você não tem permissão para editar o registro de área de estágio."));
            return $this->redirect(["controller" => "Muralestagios", "action" => "index"]);
        }

        if ($this->request->is(['patch', 'post', 'put'])) {
            $areaestagio = $this->Areaestagios->patchEntity($areaestagio, $this->request->getData());
            if ($this->Areaestagios->save($areaestagio)) {
                $this->Flash->success(__('Registro areaestagio atualizado.'));

                return $this->redirect(['action' => 'view', $areaestagio->id]);
            }
            $this->Flash->error(__('Registro areaestagio nao foi atualizado. Tente novamente.'));
        }
        $this->set(compact('areaestagio'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Areaestagio id.
     * @return \Cake\Http\Response|null|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null) {
        $this->request->allowMethod(['post', 'delete']);
        try {
            $areaestagio = $this->Areaestagios->get($id);
        } catch (\Exception $e) {
            $this->Flash->error(__('Registro areaestagio nao foi encontrado. Tente novamente.'));

            return $this->redirect(['action' => 'index']);
        }

        try {
            $this->Authorization->authorize($areaestagio);
        } catch (\Authorization\Exception\ForbiddenException $e) {
            $this->Flash->error(__("Acesso negado. Você não tem permissão para excluir o registro de área de estágio."));
            return $this->redirect(["controller" => "Muralestagios", "action" => "index"]);
        }

        if ($this->Areaestagios->delete($areaestagio)) {
            $this->Flash->success(__('Registro areaestagio excluido.'));
        } else {
            $this->Flash->error(__('Registro areaestagio nao foi excluido. Tente novamente.'));
        }
        return $this->redirect(['action' => 'index']);
    }
}
