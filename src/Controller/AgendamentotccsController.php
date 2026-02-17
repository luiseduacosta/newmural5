<?php
declare(strict_types=1);

namespace App\Controller;

use Cake\Event\EventInterface;

/**
 * Agendamentotccs Controller
 *
 * @property \App\Model\Table\AgendamentotccsTable $Agendamentotccs
 * @property \Authorization\Controller\Component\AuthorizationComponent $Authorization
 * @property \Authentication\Controller\Component\AuthenticationComponent $Authentication
 *
 * @method \App\Model\Entity\Agendamentotcc[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class AgendamentotccsController extends AppController
{
    public function beforeFilter(EventInterface $event)
    {
        parent::beforeFilter($event);
        $this->Authentication->addUnauthenticatedActions(["index", "view"]);
    }

    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $this->Authorization->skipAuthorization();

        $query = $this->Agendamentotccs
            ->find()
            ->contain([
                "Estudantes",
                "Docentes",
                "Docentebanca1",
                "Docentebanca2",
            ]);

        if ($this->request->getQuery("sort") === null) {
            $query->order(["Estudantes.nome" => "ASC"]);
        }

        $agendamentotccs = $this->paginate($query, [
            "sortableFields" => [
                "Estudantes.nome",
                "Docentes.nome",
                "Docentebanca1.nome",
                "Docentebanca2.nome",
                "Agendamentotccs.data",
                "Agendamentotccs.horario",
                "Agendamentotccs.sala",
                "Agendamentotccs.convidado",
                "Agendamentotccs.avaliacao",
            ],
        ]);

        $this->set(compact("agendamentotccs"));
    }

    /**
     * View method
     *
     * @param string|null $id Agendamentotcc id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        try {
            $agendamentotcc = $this->Agendamentotccs->get($id, [
                "contain" => [
                    "Estudantes",
                    "Docentes",
                    "Docentebanca1",
                    "Docentebanca2",
                ],
            ]);
        } catch (\Cake\Datasource\Exception\RecordNotFoundException $e) {
            $this->Flash->error(__("Agendamento TCC não encontrado."));
            return $this->redirect(["action" => "index"]);
        }
        $this->Authorization->authorize($agendamentotcc);
        $this->set("agendamentotcc", $agendamentotcc);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $agendamentotcc = $this->Agendamentotccs->newEmptyEntity();
        $this->Authorization->authorize($agendamentotcc);

        if ($this->request->is(["post", "put", "patch"])) {
            $dados = $this->request->getData();
            // pr($dados);
            // exit;
            /* Ajusta o horário */
            if (!empty($dados["horario"])) {
                $horarioarray = explode(":", $dados["horario"]);
                if (empty($horarioarray[2])) {
                    $dados["horario"] .= ":00";
                }
            }
            
            $agendamentotcc = $this->Agendamentotccs->patchEntity(
                $agendamentotcc,
                $dados,
            );
            if ($this->Agendamentotccs->save($agendamentotcc)) {
                $this->Flash->success(__("Agendamento TCC inserido."));
                return $this->redirect([
                    "action" => "view",
                    $agendamentotcc->id,
                ]);
            }
            $this->Flash->error(
                __("Agendamento TCC não foi inserido. Tente novamente"),
            );
        }

        $estudantes = $this->Agendamentotccs->Estudantes->find("list", [
            "keyField" => "id",
            "valueField" => "nome",
            "order" => ["nome" => "asc"],
        ]);

        $docentes = $this->Agendamentotccs->Docentes->find("list", [
            "keyField" => "id",
            "valueField" => "nome",
            "order" => ["nome" => "asc"],
        ]);

        $this->set(compact("agendamentotcc", "estudantes", "docentes"));
    }

    /**
     * Edit method
     *
     * @param string|null $id Agendamentotcc id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        try {
            $agendamentotcc = $this->Agendamentotccs->get($id, [
                "contain" => [
                    "Estudantes",
                    "Docentes",
                    "Docentebanca1",
                    "Docentebanca2",
                ],
            ]);
        } catch (\Cake\Datasource\Exception\RecordNotFoundException $e) {
            $this->Flash->error(__("Agendamento TCC não encontrado."));
            return $this->redirect(["action" => "index"]);
        }
        $this->Authorization->authorize($agendamentotcc);
        if ($this->request->is(["patch", "post", "put"])) {
            /* Ajusta o horário */
            $dados = $this->request->getData();
            if (!empty($dados["horario"])) {
                $horarioarray = explode(":", $dados["horario"]);
                if (empty($horarioarray[2])) {
                    $dados["horario"] .= ":00";
                }
            }
            /* Finaliza ajuste de horario */

            $agendamentotcc = $this->Agendamentotccs->patchEntity(
                $agendamentotcc,
                $dados,
            );
            if ($this->Agendamentotccs->save($agendamentotcc)) {
                $this->Flash->success(__("Agendamento TCC atualizado."));
                return $this->redirect([
                    "action" => "view",
                    $agendamentotcc->id,
                ]);
            }
            $this->Flash->error(
                __("Agendamento TCC não foi atualizado. Tente novamente."),
            );
        }
        $estudantes = $this->Agendamentotccs->Estudantes->find("list", [
            "keyField" => "id",
            "valueField" => "nome",
            "order" => ["nome" => "asc"],
        ]);
        $docentes = $this->Agendamentotccs->Docentes->find("list", [
            "keyField" => "id",
            "valueField" => "nome",
            "order" => ["nome" => "asc"],
        ]);

        $this->set(compact("agendamentotcc", "estudantes", "docentes"));
    }

    /**
     * Delete method
     *
     * @param string|null $id Agendamentotcc id.
     * @return \Cake\Http\Response|null|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(["post", "delete"]);
        try {
            $agendamentotcc = $this->Agendamentotccs->get($id);
        } catch (\Cake\Datasource\Exception\RecordNotFoundException $e) {
            $this->Flash->error(__("Agendamento TCC não encontrado."));
            return $this->redirect(["action" => "index"]);
        }
        $this->Authorization->authorize($agendamentotcc);
        
        if ($this->Agendamentotccs->delete($agendamentotcc)) {
            $this->Flash->success(__("Agendamento TCC foi excluído."));
        } else {
            $this->Flash->error(
                __(
                    "Registro agendamento TCC não foi excluído. Tente novamente.",
                ),
            );
        }
        return $this->redirect(["action" => "index"]);
    }
}
