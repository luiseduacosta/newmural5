<?php
declare(strict_types=1);

namespace App\Controller;

use Cake\I18n\DateTime;
use Cake\I18n\I18n;

/**
 * Avaliacoes Controller
 *
 * @property \App\Model\Table\AvaliacoesTable $Avaliacoes
 * @property \Authorization\Controller\Component\AuthorizationComponent $Authorization
 * @property \Authentication\Controller\Component\AuthenticationComponent $Authentication
 * 
 * @method \App\Model\Entity\Avaliaco[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class AvaliacoesController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        try {
            $this->Authorization->authorize($this->Avaliacoes);
        } catch (\Authorization\Exception\ForbiddenException $e) {
            $this->Flash->error(__("Acesso negado. Você não tem permissão para visualizar as avaliações."));
            return $this->redirect(["controller" => "Instituicoes", "action" => "index"]);
        }
        $avaliacoes = $this->Avaliacoes->find()->contain([
            "Estagiarios" => ["Alunos", "Supervisores", "Instituicoes"],
        ]);
        $this->set("estagiarios", $this->paginate($avaliacoes));
    }

    /**
     * Avaliacoes method
     *
     * @param string|null $id Estagiario id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function avaliacoes($id = null)
    {
        try {
            $this->Authorization->authorize($this->Avaliacoes);
        } catch (\Authorization\Exception\ForbiddenException $e) {
            $this->Flash->error(__("Acesso negado. Você não tem permissão para visualizar as avaliações."));
            return $this->redirect(["controller" => "Instituicoes", "action" => "index"]);
        }


        /** O id enviado pelo submenu_navegacao corresponde ao estagiario_id */
        $estagiario_id = $this->request->getQuery("estagiario_id");
        if ($estagiario_id === null) {
            $this->Flash->error(__("Selecionar estagiário"));
            return $this->redirect(["controller" => "estagiarios", "action" => "index"]);
        } 

        /**  Captura os estágios do aluno */
        $estagios = $this->fetchTable('Estagiarios')->find()
            ->contain([
                "Estudantes",
                "Instituicoes",
                "Supervisores",
                "Avaliacoes",
                ])
            ->where(["Estagiarios.id" => $estagiario_id])
            ->first();

        $this->set("estagiario", $estagios);
        $this->set("id", $estagiario_id);
    }

    /**
     * Supervisoravaliacao method
     * @param string|null $id Estagiario id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function supervisoravaliacao($id = null)
    {
        /* O submenu_navegacao envia o cress */
        $this->Authorization->skipAuthorization();
                
        $cress = $cress ?? null;
        $dre = $dre ?? null;

        if (empty($cress)) {
            $this->Flash->error(__("Selecionar supervisor(a)."));
            if ($dre):
                return $this->redirect([
                    "controller" => "alunos",
                    "action" => "view",
                    $dre,
                ]);
            else:
                return $this->redirect([
                    "controller" => "alunos",
                    "action" => "index",
                ]);
            endif;
        } else {
            $estagiario = $this->fetchTable('Estagiarios')->find()
                ->contain([
                    "Supervisores",
                    "Alunos",
                    "Professores",
                    "Folhadeatividades",
                ])
                ->where(["Supervisores.cress" => $cress])
                ->order(["periodo" => "desc"])
                ->first();
            $this->set("estagiario", $estagiario);
        }
    }

    /**
     * View method
     *
     * @param string|null $id Avaliaco id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        try {
            $avaliacao = $this->Avaliacoes->get($id, [
                "contain" => [
                    "Estagiarios" => [
                        "Alunos",
                        "Professores",
                        "Instituicoes",
                        "Supervisores",
                    ],
                ],
            ]);
        } catch (\Cake\Datasource\Exception\RecordNotFoundException $e) {
            $this->Flash->error(__("Registro não encontrado."));
            return $this->redirect(["action" => "index"]);
        }

        try {
            $this->Authorization->authorize($avaliacao);
        }
        catch (\Authorization\Exception\ForbiddenException $e) {
            $this->Flash->error(__("Acesso negado. Você não tem permissão para visualizar esta avaliação."));
            return $this->redirect(["controller" => "avaliacoes", "action" => "index"]);
        }

        $this->set(compact("avaliacao"));
    }

    /**
     * Add method
     *
     * @param string|null $id Estagiario id.
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function add($id = null)
    {

        $estagiario_id = $this->request->getQuery("estagiario_id");
        if ($estagiario_id == null) {
            $this->Flash->error(__("Selecionar estagiário."));
            return $this->redirect(["controller" => "estagiarios", "action" => "index"]);
        }
        $avaliacaoestagiario = $this->Avaliacoes->find()
                ->where(["estagiario_id" => $estagiario_id])
                ->first();

        if (isset($avaliacaoestagiario) && !is_null($avaliacaoestagiario)) {
            $this->Flash->error(__("Estagiário já foi avaliado"));
            return $this->redirect([
                "controller" => "avaliacoes",
                "action" => "view",
                $avaliacaoestagiario->id,
            ]);
        }
    
        $avaliacao = $this->Avaliacoes->newEmptyEntity();
        try {
            $this->Authorization->authorize($avaliacao);
        } catch (\Authorization\Exception\ForbiddenException $e) {
            $this->Flash->error(__("Acesso negado. Você não tem permissão para adicionar esta avaliação."));
            return $this->redirect(["controller" => "avaliacoes", "action" => "index"]);
        }

        if ($this->request->is("post")) {
            $avaliacao = $this->Avaliacoes->patchEntity(
                $avaliacao,
                $this->request->getData(),
            );
            if ($this->Avaliacoes->save($avaliacao)) {
                $this->Flash->success(__("Avaliação registrada."));
                return $this->redirect([
                    "controller" => "avaliacoes",
                    "action" => "index",
                    $estagiario_id,
                ]);
            }
            $this->Flash->error(
                __("Avaliação não foi registrada. Tente novamente."),
            );
        }
        $estagiario = $this->Avaliacoes->Estagiarios->find()
            ->contain(["Alunos"])
            ->where(["Estagiarios.id" => $estagiario_id])
            ->first();

        $this->set(compact("avaliacao", "estagiario"));
    }

    /**
     * Edit method
     *
     * @param string|null $id Avaliaco id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        try {
            $avaliacao = $this->Avaliacoes->get($id, [
                "contain" => [
                    "Estagiarios" => [
                        "Alunos",
                        "Professores",
                        "Instituicoes",
                        "Supervisores",
                    ],
                ],
            ]);
        } catch (\Cake\Datasource\Exception\RecordNotFoundException $e) {
            $this->Flash->error(__("Registro não encontrado."));
            return $this->redirect(["action" => "index"]);
        }

        try {
            $this->Authorization->authorize($avaliacao);
        } catch (\Authorization\Exception\ForbiddenException $e) {
            $this->Flash->error(__("Acesso negado. Você não tem permissão para editar esta avaliação."));
            return $this->redirect(["controller" => "avaliacoes", "action" => "index"]);
        }

        if ($this->request->is(["patch", "post", "put"])) {
            $avaliacao = $this->Avaliacoes->patchEntity(
                $avaliacao,
                $this->request->getData(),
            );
            if ($this->Avaliacoes->save($avaliacao)) {
                $this->Flash->success(__("Avaliação atualizada."));
                return $this->redirect([
                    "action" => "index",
                    $avaliacao->estagiario_id,
                ]);
            }
            $this->Flash->error(
                __("Avaliação não atualizada. Tente novamente."),
            );
        }

        $this->set(compact("avaliacao"));
    }

    /**
     * Delete method
     *
     * @param string|null $id Avaliaco id.
     * @return \Cake\Http\Response|null|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        try {
            $avaliacao = $this->Avaliacoes->get($id);
        } catch (\Cake\Datasource\Exception\RecordNotFoundException $e) {
            $this->Flash->error(__("Registro não encontrado."));
            return $this->redirect(["action" => "index"]);
        }

        try {
            $this->Authorization->authorize($avaliacao);
        } catch (\Authorization\Exception\ForbiddenException $e) {
            $this->Flash->error(__("Acesso negado. Você não tem permissão para excluir esta avaliação."));
            return $this->redirect(["controller" => "avaliacoes", "action" => "index"]);
        }

        if ($this->request->is(["post", "delete"])) {
            if ($this->Avaliacoes->delete($avaliacao)) {
                $this->Flash->success(__("Avaliação excluída."));
            } else {
                $this->Flash->error(__("Avaliação não excluída."));
            }
            return $this->redirect(["action" => "index"]);
        }
    }

    /**
     * Selecionaavaliacao method
     *
     * @param string|null $id Estagiario id.
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function selecionaavaliacao($id = null)
    {
        $this->Authorization->skipAuthorization();

        if ($id == null) {
            $this->Flash->error(__("Selecionar o estudante estagiário"));
                return $this->redirect([
                    "controller" => "estudantes",
                    "action" => "index",
            ]);
        }
            
        $estagiario = $this->Avaliacoes->Estagiarios->find()
            ->contain(["Estudantes", "Supervisores", "instituicoes"])
            ->where(["Estagiarios.id" => $id])
            ->first();
        
        $this->set("estagiario", $estagiario);

    }

    /**
     * Imprimeavaliacaopdf method
     *
     * @param string|null $id Avaliaco id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function imprimeavaliacaopdf($id = null)
    {
        $estagiario_id = $this->request->getQuery("estagiario_id");

        $this->Authorization->skipAuthorization();

        if ($estagiario_id === null) {
            $this->Flash->error(__("Selecionar estagiário."));
            return $this->redirect([
                "controller" => "estagiarios",
                "action" => "index",
            ]);
        }
        
        $avaliacao = $this->Avaliacoes->find()
            ->contain([
                "Estagiarios" => [
                        "Alunos",
                        "Supervisores",
                        "Professores",
                        "Instituicoes",
                    ],
                ])
            ->where(["Estagiarios.id" => $estagiario_id])
            ->first();

        if ($avaliacao === null) {
            $this->Flash->error(__("Avaliação não foi encontrada."));
            return $this->redirect([
                "controller" => "estagiarios",
                "action" => "view",
                $estagiario_id,
            ]);
        
        $this->viewBuilder()->enableAutoLayout(false);
        $this->viewBuilder()->setClassName("CakePdf.Pdf");
        $this->viewBuilder()->setOption("pdfConfig", [
            "orientation" => "portrait",
            "download" => true,
            "filename" => "avaliacao_discente_" . $id . ".pdf",
        ]);
        $this->set("avaliacao", $avaliacao);
        }
    }
}