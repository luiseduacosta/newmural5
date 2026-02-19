<?php
declare(strict_types=1);

namespace App\Controller;

/**
 * Instituicoes Controller
 *
 * @property \App\Model\Table\InstituicoesTable $Instituicoes
 * @property \Authorization\Controller\Component\AuthorizationComponent $Authorization
 * @method \App\Model\Entity\Instituicao[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class InstituicoesController extends AppController
{
    /**
     * Index method
     * 
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index($instituicao = null)
    {
        try {
            $this->Authorization->authorize($this->Instituicoes);
        } catch (\AuthorizationException $e) {
            $this->Flash->error(__('Erro ao carregar os dados. Tente novamente.'));
            return $this->redirect(['action' => 'index']);
        }

        $query = $this->Instituicoes->find()->contain(['Areainstituicoes']);
        
        $query->order(['Instituicoes.instituicao' => 'ASC']);
        
        $instituicoes = $this->paginate($query);
        $this->set(compact('instituicoes'));
    }

    /**
     * View method
     *
     * @param string|null $id Instituicao id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        // Aumentar a memória
        ini_set('memory_limit', '512M');
 
        try {
            $instituicao = $this->Instituicoes->get($id, [
                'contain' => ['Areainstituicoes', 'Supervisores', 'Estagiarios' => ['Alunos', 'Instituicoes', 'Professores', 'Supervisores', 'Turmaestagios'], 'Muralestagios', 'Visitas']
            ]);
        } catch (\Cake\Datasource\Exception\RecordNotFoundException $e) {
            $this->Flash->error(__('Instituição não encontrada.'));
            return $this->redirect(['action' => 'index']);
        }
 
        try {
            $this->Authorization->authorize($instituicao);
        } catch (\AuthorizationException $e) {
            $this->Flash->error(__('Erro ao carregar os dados. Tente novamente.'));
            return $this->redirect(['action' => 'index']);
        }

        $this->set(compact('instituicao'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $instituicao = $this->Instituicoes->newEmptyEntity();
        try {
            $this->Authorization->authorize($instituicao);
        } catch (\AuthorizationException $e) {
            $this->Flash->error(__('Erro ao carregar os dados. Tente novamente.'));
            return $this->redirect(['action' => 'index']);
        }

        if ($this->request->is('post')) {
            $instituicao = $this->Instituicoes->patchEntity($instituicao, $this->request->getData());
            if ($this->Instituicoes->save($instituicao)) {
                $this->Flash->success(__('Instituição de estágio criada.'));
                return $this->redirect(['action' => 'view', $instituicao->id]);
            }
            $this->Flash->error(__('Não foi possível criar a instituição de estágio. Tente novamente.'));
        }
        $areainstituicoes = $this->Instituicoes->Areainstituicoes->find('list', ['keyField' => 'id', 'valueField' => 'area']);
        $supervisores = $this->Instituicoes->Supervisores->find('list', ['keyField' => 'id', 'valueField' => 'nome']);
        $this->set(compact('instituicao', 'areainstituicoes', 'supervisores'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Instituicoes id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        try {
            $instituicao = $this->Instituicoes->get($id, [
                'contain' => ['Supervisores'],
            ]);
        } catch (\Cake\Datasource\Exception\RecordNotFoundException $e) {
            $this->Flash->error(__('Instituição não encontrada.'));
            return $this->redirect(['action' => 'index']);
        }

        try {
            $this->Authorization->authorize($instituicao);
        } catch (\AuthorizationException $e) {
            $this->Flash->error(__('Erro ao carregar os dados. Tente novamente.'));
            return $this->redirect(['action' => 'index']);
        }

        if ($this->request->is(['patch', 'post', 'put'])) {
            $instituicao = $this->Instituicoes->patchEntity($instituicao, $this->request->getData());
            if ($this->Instituicoes->save($instituicao)) {
                $this->Flash->success(__('Instituição de estágio atualizada.'));
                return $this->redirect(['action' => 'view', $instituicao->id]);
            }
            $this->Flash->error(__('Instituição de estágio não foi atualizada.'));
        }
        $areainstituicoes = $this->Instituicoes->Areainstituicoes->find('list', ['keyField' => 'id', 'valueField' => 'area']);
        $supervisores = $this->Instituicoes->Supervisores->find('list', ['keyField' => 'id', 'valueField' => 'nome']);
        $this->set(compact('instituicao', 'areainstituicoes', 'supervisores'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Instituicao id.
     * @return \Cake\Http\Response|null|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        try {
            $instituicao = $this->Instituicoes->get($id);
        } catch (\Cake\Datasource\Exception\RecordNotFoundException $e) {
            $this->Flash->error(__('Instituição não encontrada.'));
            return $this->redirect(['action' => 'index']);
        }

        try {
            $this->Authorization->authorize($instituicao);
        } catch (\AuthorizationException $e) {
            $this->Flash->error(__('Erro ao carregar os dados. Tente novamente.'));
            return $this->redirect(['action' => 'index']);
        }
        
        if ($this->Instituicoes->delete($instituicao)) {
            $this->Flash->success(__('Instituição de estágio excluída.'));
        } else {
            $this->Flash->error(__('Instituição de estágio não foi excluída.'));
            return $this->redirect(['action' => 'view', $instituicao->id]);
        }
        return $this->redirect(['action' => 'index']);
    }

    /**
     * buscasupervisores method - Ajax
     *
     * @return \Cake\Http\Response|null|void
     */
    public function buscasupervisores()
    {
        $this->Authorization->skipAuthorization();
        if (!$this->request->is('post')) {
            return $this->response->withStatus(400);
        }

        $instituicao_id = $this->request->getData('id');
        try {
            $supervisores = $this->Instituicoes->Supervisores->find('list', [
                'keyField' => 'id',
                'valueField' => 'nome'
            ])
            ->matching('Instituicoes', function ($q) use ($instituicao_id) {
                return $q->where(['Instituicoes.id' => $instituicao_id]);
            })
            ->order(['nome' => 'ASC'])
            ->toArray();

            return $this->response
                ->withType('application/json')
                ->withStringBody(json_encode($supervisores));

        } catch (\Exception $e) {
            return $this->response
                ->withStatus(500)
                ->withType('application/json')
                ->withStringBody(json_encode(['error' => 'Erro ao buscar supervisores']));
        }
    }

    /**
     * buscainstituicao method
     *
     * @return \Cake\Http\Response|null|void
     */
    public function buscainstituicao()
    {
        $this->Authorization->skipAuthorization();
        $instituicao = $this->getRequest()->getData('nome');
        if ($instituicao) {
            $query = $this->Instituicoes->find();
            $query->where(['instituicao LIKE' => "%{$instituicao}%"]);
            $query->order(['instituicao' => 'ASC']);
            
            if ($query->count() == 0) {
                $this->Flash->error(__('Nenhum(a) instituição de estágio encontrado com o nome: ' . $instituicao));
            }
            
            $instituicoes = $this->paginate($query);
            $this->set('instituicoes', $instituicoes);
            $this->render('index');
            
        } else {
            $this->Flash->error(__('Digite um nome para busca'));
            return $this->redirect(["action" => "index"]);
        }
    }
}
