<?php
declare(strict_types=1);

namespace App\Controller;

/**
 * Instituicaoestagios Controller
 *
 * @property \App\Model\Table\InstituicaoestagiosTable $Instituicaoestagios
 * @method \App\Model\Entity\Instituicaoestagio[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class InstituicaoestagiosController extends AppController {

    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index() {
        $this->Authorization->skipAuthorization();
        $query = $this->Instituicaoestagios->find()->contain(['Areainstituicoes', 'Areaestagios']);
        $instituicaoestagios = $this->paginate($query);
        $this->set(compact('instituicaoestagios'));
    }

    /**
     * View method
     *
     * @param string|null $id Instituicaoestagio id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null) {
        $this->Authorization->skipAuthorization(); // View generally public or auth logic handled elsewhere, legacy skipped
        try {
            $instituicaoestagio = $this->Instituicaoestagios->get($id, [
                'contain' => ['Areainstituicoes', 'Supervisores', 'Estagiarios' => ['Estudantes', 'Instituicaoestagios', 'Docentes', 'Supervisores', 'Areaestagios'], 'Muralestagios', 'Visitas'],
            ]);
        } catch (\Exception $e) {
            $this->Flash->error(__('Instituicao de estagio nao foi encontrado. Tente novamente.'));
            return $this->redirect(['action' => 'index']);
        }
        // $this->Authorization->authorize($instituicaoestagio); // Skipped to match legacy logic if needed, or re-enable
        $this->set(compact('instituicaoestagio'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add() {
        $instituicaoestagio = $this->Instituicaoestagios->newEmptyEntity();
        $this->Authorization->authorize($instituicaoestagio);
        
        if ($this->request->is('post')) {
            $instituicaoestagio = $this->Instituicaoestagios->patchEntity($instituicaoestagio, $this->request->getData());
            if ($this->Instituicaoestagios->save($instituicaoestagio)) {
                $this->Flash->success(__('Registro instituicaoestagio inserido.'));
                return $this->redirect(['action' => 'view', $instituicaoestagio->id]);
            }
            $this->Flash->error(__('Não foi possível inserir o registro instituicaoestagio. Tente novamente.'));
        }
        $areainstituicoes = $this->Instituicaoestagios->Areainstituicoes->find('list');
        $supervisores = $this->Instituicaoestagios->Supervisores->find('list');
        $this->set(compact('instituicaoestagio', 'areainstituicoes', 'supervisores'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Instituicaoestagio id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null) {
        try {
            $instituicaoestagio = $this->Instituicaoestagios->get($id, [
                'contain' => ['Supervisores'],
            ]);
        } catch (\Exception $e) {
            $this->Flash->error(__('Instituicao de estagio nao foi encontrado. Tente novamente.'));
            return $this->redirect(['action' => 'index']);
        }
        $this->Authorization->authorize($instituicaoestagio);
        
        if ($this->request->is(['patch', 'post', 'put'])) {
            $instituicaoestagio = $this->Instituicaoestagios->patchEntity($instituicaoestagio, $this->request->getData());
            if ($this->Instituicaoestagios->save($instituicaoestagio)) {
                $this->Flash->success(__('Registro instituicaoestagio atualizado.'));
                return $this->redirect(['action' => 'view', $instituicaoestagio->id]);
            }
            $this->Flash->error(__('Registro instituicaoestagio não foi atualizado. Tente novamente.'));
        }
        $areainstituicoes = $this->Instituicaoestagios->Areainstituicoes->find('list');
        $supervisores = $this->Instituicaoestagios->Supervisores->find('list');
        $this->set(compact('instituicaoestagio', 'areainstituicoes', 'supervisores'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Instituicaoestagio id.
     * @return \Cake\Http\Response|null|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null) {
        $this->request->allowMethod(['post', 'delete']);
        try {
            $instituicaoestagio = $this->Instituicaoestagios->get($id, ['contain' => ['Muralestagios']]);
        } catch (\Exception $e) {
            $this->Flash->error(__('Instituicao de estagio nao foi encontrado. Tente novamente.'));
            return $this->redirect(['action' => 'index']);
        }
        $this->Authorization->authorize($instituicaoestagio);
        
        /** Se tem ofertas de vagas de estagio nao pode ser excluido. */
        if (!empty($instituicaoestagio->muralestagios)) {
            $this->Flash->error(__('Institucao de estagio com mural de selecao de estagiarios. Realoque o mural para poder excluir a instituicao'));
            return $this->redirect(['controller' => 'Instituicaoestagios', 'action' => 'view', $id]);
        }
        
        if ($this->Instituicaoestagios->delete($instituicaoestagio)) {
            $this->Flash->success(__('Registro instituicaoestagio excluído.'));
        } else {
            $this->Flash->error(__('Registro instituicaoestagio não foi excluído. Tente novamente.'));
        }
        return $this->redirect(['action' => 'index']);
    }
}
