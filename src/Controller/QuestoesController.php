<?php
declare(strict_types=1);

namespace App\Controller;

/**
 * Questoes Controller
 *
 * @property \App\Model\Table\QuestoesTable $Questoes
 * @property \Authorization\Controller\Component\AuthorizationComponent $Authorization
 */
class QuestoesController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        try {
            $this->Authorization->authorize($this->Questoes);
        } catch (\Authorization\Exception\ForbiddenException $e) {
            $this->Flash->error(__('Acesso negado. Você não tem permissão para acessar esta página.'));
            return $this->redirect(['action' => 'index']);
        }

        $query = $this->Questoes->find()->contain(["Questionarios"]);
        
        $questoes = $this->paginate($query, [
            "sortableFields" => [
                "id",
                "type",
                "text",
                "options",
                "ordem",
                "Questionarios.title", // Check association alias
            ],
            "order" => ["ordem" => "ASC"],
            "limit" => 20,
        ]);

        $this->set(compact("questoes"));
    }

    /**
     * View method
     *
     * @param string|null $id Questao id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        try {
            $questao = $this->Questoes->get($id, [
                "contain" => ["Questionarios"],
            ]);
        } catch (\Cake\Datasource\Exception\RecordNotFoundException $e) {
            $this->Flash->error(__("Registro não encontrado."));
            return $this->redirect(["action" => "index"]);
        }

        try {
            $this->Authorization->authorize($questao);
        } catch (\Authorization\Exception\ForbiddenException $e) {
            $this->Flash->error(__('Acesso negado. Você não tem permissão para acessar esta página.'));
            return $this->redirect(['action' => 'index']);
        }

        $this->set(compact("questao"));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $questao = $this->Questoes->newEmptyEntity();

        try {
            $this->Authorization->authorize($questao);
        } catch (\Authorization\Exception\ForbiddenException $e) {
            $this->Flash->error(__('Acesso negado. Você não tem permissão para acessar esta página.'));
            return $this->redirect(['action' => 'index']);
        }

        // Find last order
        $ultimaPergunta = $this->Questoes
            ->find()
            ->order(["ordem" => "DESC"])
            ->first();
            
        if ($ultimaPergunta && $ultimaPergunta->ordem) {
            $this->set("ordem", $ultimaPergunta->ordem + 1);
        }
        
        if ($this->request->is("post")) {
            $questao = $this->Questoes->patchEntity(
                $questao,
                $this->request->getData(),
            );
            if ($this->Questoes->save($questao)) {
                $this->Flash->success(__("Pergunta inserida."));
                return $this->redirect(["action" => "view", $questao->id]);
            }
            $this->Flash->error(__("Pergunta não inserida. Tente novamente."));
        }
        
        $questionarios = $this->Questoes->Questionarios
            ->find("list", ["limit" => 200])
            ->all();
        $this->set(compact("questao", "questionarios"));
    }

    /**
     * Edit method
     *
     * @param string|null $id Questao id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        try {
            $questao = $this->Questoes->get($id, [
                "contain" => [],
            ]);
        } catch (\Cake\Datasource\Exception\RecordNotFoundException $e) {
            $this->Flash->error(__("Registro não encontrado."));
            return $this->redirect(["action" => "index"]);
        }

        try {
            $this->Authorization->authorize($questao);
        } catch (\Authorization\Exception\ForbiddenException $e) {
            $this->Flash->error(__('Acesso negado. Você não tem permissão para acessar esta página.'));
            return $this->redirect(['action' => 'index']);
        }
                
        if ($this->request->is(["patch", "post", "put"])) {
            $questao = $this->Questoes->patchEntity(
                $questao,
                $this->request->getData(),
            );
            if ($this->Questoes->save($questao)) {
                $this->Flash->success(__("Pergunta atualizada."));
                return $this->redirect(["action" => "view", $questao->id]);
            }
            $this->Flash->error(__("Pergunta não atualizada. Tente novamente."));
        }
        
        $questionarios = $this->Questoes->Questionarios
            ->find("list", ["limit" => 200])
            ->all();
            
        $this->set(compact("questao", "questionarios"));
    }

    /**
     * Delete method
     *
     * @param string|null $id Questao id.
     * @return \Cake\Http\Response|null|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(["post", "delete"]);
        try {
            $questao = $this->Questoes->get($id);
        } catch (\Cake\Datasource\Exception\RecordNotFoundException $e) {
            $this->Flash->error(__("Registro não encontrado."));
            return $this->redirect(["action" => "index"]);
        }
        
        try {
            $this->Authorization->authorize($questao);
        } catch (\Authorization\Exception\ForbiddenException $e) {
            $this->Flash->error(__('Acesso negado. Você não tem permissão para acessar esta página.'));
            return $this->redirect(['action' => 'index']);
        }
        
        if ($this->Questoes->delete($questao)) {
            $this->Flash->success(__("Pergunta excluída."));
        } else {
            $this->Flash->error(__("Pergunta não excluída. Tente novamente."));
        }
        
        return $this->redirect(["action" => "index"]);
    }
}
