<?php
declare(strict_types=1);

namespace App\Controller;

/**
 * Estagiariomonografias Controller
 *
 * @property \App\Model\Table\EstagiariomonografiasTable $Estagiariomonografias
 * @method \App\Model\Entity\Estagiariomonografia[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class EstagiariomonografiasController extends AppController
{
    public function beforeFilter(\Cake\Event\EventInterface $event): void
    {
        parent::beforeFilter($event);
        $this->Authentication->addUnauthenticatedActions([
            "view",
            "index",
            "busca",
            "registro",
        ]);
    }

    /**
     * Index method
     *
     * @return \Cake\Http\Response|null
     */
    public function index()
    {
        try {
            $this->Authorization->authorize($this->Estagiariomonografias);
        } catch (\AuthorizationException $e) {
            $this->Flash->error(__('Erro ao carregar os dados. Tente novamente.'));
            return $this->redirect(['action' => 'index']);
        }

        $this->viewBuilder()->setTemplate("index");

        $periodo = $this->request->getQuery("periodo");
        $periodos = $this->Estagiariomonografias
            ->find("list", [
                "keyField" => "periodo",
                "valueField" => "periodo",
            ])
            ->order(["periodo" => "ASC"]);
        $periodos = $periodos->toArray();
        if (empty($periodo) && !empty($periodos)) {
            $periodo = end($periodos); // Pega o último elemento do array
        }

        $query = $this->Estagiariomonografias->find();
        
        $estagiariomonografias = $query
            ->contain(["Estudantes", "Tccestudantes" => ["Monografias"]])
            ->where([
                "or" => [
                    ["Estagiariomonografias.ajuste2020" => "0", "Estagiariomonografias.nivel" => 4],
                    ["Estagiariomonografias.ajuste2020" => "1", "Estagiariomonografias.nivel" => 3],
                ]
            ]);
            
        if ($periodo) {
             $estagiariomonografias->where(["Estagiariomonografias.periodo" => $periodo]);
        }

        if ($this->request->getQuery("sort") === null) {
            $estagiariomonografias->order(["Estudantes.nome" => "ASC"]);
        }
               
        $this->set("estagiariomonografias", $this->paginate($estagiariomonografias));
        $this->set(compact("periodo", "periodos"));
    }

    /**
     * View method
     *
     * @param string|null $id Estagiario id.
     * @return \Cake\Http\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $estagiariomonografia = $this->Estagiariomonografias->get($id, [
            "contain" => ["Estudantes", "Docentes"],
        ]);
        try {
            $this->Authorization->authorize($estagiariomonografia);
        } catch (\AuthorizationException $e) {
            $this->Flash->error(__('Erro ao carregar os dados. Tente novamente.'));
            return $this->redirect(['action' => 'index']);
        }
        $this->set("estagiariomonografia", $estagiariomonografia);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $estagiariomonografia = $this->Estagiariomonografias->newEmptyEntity();
        try {
            $this->Authorization->authorize($estagiariomonografia);
        } catch (\AuthorizationException $e) {
            $this->Flash->error(__('Erro ao carregar os dados. Tente novamente.'));
            return $this->redirect(['action' => 'index']);
        }
        if ($this->request->is("post")) {
            $estagiariomonografia = $this->Estagiariomonografias->patchEntity(
                $estagiariomonografia,
                $this->request->getData(),
            );
            if ($this->Estagiariomonografias->save($estagiariomonografia)) {
                $this->Flash->success(__("Registros de estagiário inserido."));

                return $this->redirect([
                    "action" => "view",
                    $estagiariomonografia->id,
                ]);
            }
            $this->Flash->error(
                __("Registro estagiário não foi inserido. Tente novamente."),
            );
        }
        $alunos = $this->Estagiariomonografias->Estudantes->find("list", [
            "keyField" => "id",
            "valueField" => "nome",
        ]);

        $professores = $this->Estagiariomonografias->Docentes->find("list", [
            "keyField" => "id",
            "valueField" => "nome",
        ]);

        $this->set(compact("estagiariomonografia", "alunos", "professores"));
    }

    /**
     * Edit method
     *
     * @param string|null $id Estagiario id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $estagiariomonografia = $this->Estagiariomonografias->get($id, [
            "contain" => [],
        ]);
        try {
            $this->Authorization->authorize($estagiariomonografia);
        } catch (\AuthorizationException $e) {
            $this->Flash->error(__('Erro ao carregar os dados. Tente novamente.'));
            return $this->redirect(['action' => 'index']);
        }

        if ($this->request->is(["patch", "post", "put"])) {
            $estagiariomonografia = $this->Estagiariomonografias->patchEntity(
                $estagiariomonografia,
                $this->request->getData(),
            );
            if ($this->Estagiariomonografias->save($estagiariomonografia)) {
                $this->Flash->success(__("Estagiário atualizado."));
                return $this->redirect(["action" => "view", $id]);
            }
            $this->Flash->error(
                __("Estagiário não foi atualizado. Tente novamente."),
            );
        }
        $alunos = $this->Estagiariomonografias->Estudantes->find("list", [
            "keyField" => "id",
            "valueField" => "nome",
        ]);
        $docentemonografias = $this->Estagiariomonografias->Docentes->find("list",
            [
                "keyField" => "id",
                "valueField" => "nome",
            ],
        );
        $areas = $this->Estagiariomonografias->Areaestagios->find("list", [
            "keyField" => "id",
            "valueField" => "area",
        ]);

        $this->set(
            compact(
                "estagiariomonografia",
                "alunos",
                "docentemonografias",
                "areas",
            ),
        );
    }

    /**
     * Delete method
     *
     * @param string|null $id Estagiario id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(["post", "delete"]);
        try {
            $estagiariomonografia = $this->Estagiariomonografias->get($id);
        } catch (\Cake\Datasource\Exception\RecordNotFoundException $e) {
             $this->Flash->error(__("Registro não encontrado."));
             return $this->redirect(["action" => "index"]);
        }

        try {
            $this->Authorization->authorize($estagiariomonografia);
        } catch (\AuthorizationException $e) {
            $this->Flash->error(__('Erro ao carregar os dados. Tente novamente.'));
            return $this->redirect(['action' => 'index']);
        }

        if ($this->Estagiariomonografias->delete($estagiariomonografia)) {
            $this->Flash->success(__("Registro estagiário excluído."));
        } else {
            $this->Flash->error(
                __("Registro estagiário não foi excluído. Tente novamente."),
            );
        }

        return $this->redirect(["action" => "index"]);
    }

    public function busca($busca = null)
    {
        $this->Authorization->skipAuthorization();
        $this->viewBuilder()->disableAutoLayout();
        if ($busca):
            echo "Buscar: " . $busca . "<br>";
        else:
            echo "Digitar a busca";
        endif;
    }

    public function registro($id = null)
    {
        $this->Authorization->skipAuthorization();
        $this->viewBuilder()->disableAutoLayout();
        $this->request->allowMethod(['ajax', 'post']); // Add post

        if ($this->request->is("ajax") || $this->request->is("post")): // Allow post/ajax
            try {
                $estagiariomonografia = $this->Estagiariomonografias->get($id);
                $registro = $estagiariomonografia->registro;
                if ($registro):
                    return $this->response
                        ->withType("application/json")
                        ->withStringBody(
                            json_encode([
                                "registro" => $registro,
                            ]),
                        );
                endif;
            } catch (\Exception $e) {
                return $this->response->withStatus(404);
            }
        endif;
    }
}
