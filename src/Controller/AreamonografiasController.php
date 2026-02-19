<?php
declare(strict_types=1);

namespace App\Controller;

/**
 * Areamonografias Controller
 *
 * @property \App\Model\Table\AreamonografiasTable $Areamonografias
 * @method \App\Model\Entity\Areamonografia[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class AreamonografiasController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null
     */
    public function index()
    {
        try {
            $this->Authorization->authorize($this->Areamonografias);
        } catch (\Authorization\Exception\ForbiddenException $e) {
            $this->Flash->error(__("Acesso negado. Você não tem permissão para visualizar as áreas de monografia."));
            return $this->redirect(["controller" => "Monografias", "action" => "index"]);
        }

        $query = $this->Areamonografias->find()->contain(["Monografias"]);
        if ($this->request->getQuery("sort") === null) {
            $query->order(["area" => "ASC"]);
        }
        $areas = $this->paginate($query);
        $this->set(compact("areas"));
    }

    /**
     * View method
     *
     * @param string|null $id Area id.
     * @return \Cake\Http\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $areamonografia = $this->Areamonografias->get($id, [
            "contain" => [
                "Docentes" => ['sort' => 'nome'],
                "Monografias" => ["Tccestudantes", "Docentes"],
            ],
        ]);

        try {
            $this->Authorization->authorize($areamonografia);
        } catch (\Authorization\Exception\ForbiddenException $e) {
            $this->Flash->error(__("Acesso negado. Você não tem permissão para visualizar a área de monografia."));
            return $this->redirect(["controller" => "Monografias", "action" => "index"]);
        }

        $this->set("areamonografia", $areamonografia);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $areamonografia = $this->Areamonografias->newEmptyEntity();
        try {
            $this->Authorization->authorize($areamonografia);
        } catch (\Authorization\Exception\ForbiddenException $e) {
            $this->Flash->error(__("Acesso negado. Você não tem permissão para inserir áreas de monografia."));
            return $this->redirect(["controller" => "Monografias", "action" => "index"]);
        }

        if ($this->request->is("post")) {
            $areamonografia = $this->Areamonografias->patchEntity(
                $areamonografia,
                $this->request->getData(),
            );
            if ($this->Areamonografias->save($areamonografia)) {
                $this->Flash->success(__("Área de monografia inserida."));

                return $this->redirect(["action" => "view", $areamonografia->id]);
            }
            $this->Flash->error(__("Área de monografia não inserida."));
        }
        $docentes = $this->Areamonografias->Docentes->find("list");
        $this->set(compact("areamonografia", "docentes"));
    }

    /**
     * Edit method
     *
     * @param string|null $id Area id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $areamonografia = $this->Areamonografias->get($id, [
            "contain" => ["Docentes"],
        ]);

        try {
            $this->Authorization->authorize($areamonografia);
        } catch (\Authorization\Exception\ForbiddenException $e) {
            $this->Flash->error(__("Acesso negado. Você não tem permissão para editar a área de monografia."));
            return $this->redirect(["controller" => "Monografias", "action" => "index"]);
        }

        if ($this->request->is(["patch", "post", "put"])) {
            $areamonografia = $this->Areamonografias->patchEntity(
                $areamonografia,
                $this->request->getData(),
            );
            if ($this->Areamonografias->save($areamonografia)) {
                $this->Flash->success(__("Área de monografia atualizada."));

                return $this->redirect(["action" => "view", $areamonografia->id]);
            }
            $this->Flash->error(__("Área de monografia não foi atualizada."));
        }
        $docentes = $this->Areamonografias->Docentes->find("list");
        $this->set(compact("areamonografia", "docentes"));
    }

    /**
     * Delete method
     *
     * @param string|null $id Area id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(["post", "delete"]);

        $areamonografias = $this->Areamonografias->get($id, [
            'contain' => ['Monografias']
        ]);

        try {
            $areamonografia = $this->Areamonografias->get($id);
            $this->Authorization->authorize($areamonografia);
        } catch (\Authorization\Exception\ForbiddenException $e) {
            $this->Flash->error(__("Acesso negado. Você não tem permissão para excluir a área de monografia."));
            return $this->redirect(["controller" => "Monografias", "action" => "index"]);
        }

        if (!empty($areamonografias->monografias)) {
            $this->Flash->error(__('Há monografias assoaciadas a esta área. Desfazer as associações primeiro.'));
            return $this->redirect(['action' => 'view', $id]);
        }

        if ($this->Areamonografias->delete($areamonografia)) {
            $this->Flash->success(__("Área da mongrafia excluída."));
        } else {
            $this->Flash->error(__("Área da monografia não excluída."));
        }

        return $this->redirect(["action" => "index"]);
    }
}
