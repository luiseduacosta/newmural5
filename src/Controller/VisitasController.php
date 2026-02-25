<?php
declare(strict_types=1);

namespace App\Controller;

use Authorization\Exception\ForbiddenException;
use Cake\Datasource\Exception\RecordNotFoundException;

/**
 * Visitas Controller
 *
 * @property \App\Model\Table\VisitasTable $Visitas
 * @property \Authorization\Controller\Component\AuthorizationComponent $Authorization
 * @property \Authentication\Controller\Component\AuthenticationComponent $Authentication
 * @method \App\Model\Entity\Visita[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class VisitasController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        try {
            $this->Authorization->authorize($this->Visitas);
        } catch (ForbiddenException $e) {
            $this->Flash->error(__('Acesso negado. Você não tem permissão para acessar esta página.'));

            return $this->redirect(['action' => 'index']);
        }

        $query = $this->Visitas->find()->contain(['Instituicoes']);
        $visitas = $this->paginate($query);
        $this->set(compact('visitas'));
    }

    /**
     * View method
     *
     * @param string|null $id Visita id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view(?string $id = null)
    {
        try {
            $visita = $this->Visitas->get($id, [
                'contain' => ['Instituicoes'],
            ]);
        } catch (RecordNotFoundException $e) {
            $this->Flash->error(__('Não há registros de visitas para esse número!'));

            return $this->redirect(['action' => 'index']);
        }

        try {
            $this->Authorization->authorize($visita);
        } catch (ForbiddenException $e) {
            $this->Flash->error(__('Erro ao carregar os dados. Tente novamente.'));

            return $this->redirect(['action' => 'index']);
        }

        $this->set(compact('visita'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $visita = $this->Visitas->newEmptyEntity();
        try {
            $this->Authorization->authorize($visita);
        } catch (ForbiddenException $e) {
            $this->Flash->error(__('Acesso negado. Você não tem permissão para acessar esta página.'));

            return $this->redirect(['action' => 'index']);
        }

        if ($this->request->is('post')) {
            $visita = $this->Visitas->patchEntity($visita, $this->request->getData());
            if ($this->Visitas->save($visita)) {
                $this->Flash->success(__('Visita inserida.'));

                return $this->redirect(['action' => 'view', $visita->id]);
            }
            $this->Flash->error(__('Visita não inserida.'));
        }
        $instituicoes = $this->Visitas->Instituicoes->find('list', ['order' => ['instituicao' => 'ASC']]);
        $this->set(compact('visita', 'instituicoes'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Visita id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit(?string $id = null)
    {
        try {
            $visita = $this->Visitas->get($id, [
                'contain' => ['Instituicoes'],
            ]);
        } catch (RecordNotFoundException $e) {
             $this->Flash->error(__('Não há registros de visitas para esse número!'));

             return $this->redirect(['action' => 'index']);
        }

        try {
            $this->Authorization->authorize($visita);
        } catch (ForbiddenException $e) {
            $this->Flash->error(__('Acesso negado. Você não tem permissão para acessar esta página.'));

            return $this->redirect(['action' => 'index']);
        }

        if ($this->request->is(['patch', 'post', 'put'])) {
            $visita = $this->Visitas->patchEntity($visita, $this->request->getData());
            if ($this->Visitas->save($visita)) {
                $this->Flash->success(__('Visita atualizada.'));

                return $this->redirect(['action' => 'view', $visita->id]);
            }
            $this->Flash->error(__('Visita não atualizada.'));
        }
        $instituicoes = $this->Visitas->Instituicoes->find('list', ['order' => ['instituicao' => 'ASC']]);
        $this->set(compact('visita', 'instituicoes'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Visita id.
     * @return \Cake\Http\Response|null|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete(?string $id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        try {
            $visita = $this->Visitas->get($id);
        } catch (RecordNotFoundException $e) {
            $this->Flash->error(__('Não há registros de visitas para esse número!'));

            return $this->redirect(['action' => 'index']);
        }

        try {
            $this->Authorization->authorize($visita);
        } catch (ForbiddenException $e) {
            $this->Flash->error(__('Acesso negado. Você não tem permissão para acessar esta página.'));

            return $this->redirect(['action' => 'index']);
        }

        if ($this->Visitas->delete($visita)) {
            $this->Flash->success(__('Visita excluída.'));

             return $this->redirect(['action' => 'index']);
        } else {
            $this->Flash->error(__('Visita não excluída.'));

             return $this->redirect(['action' => 'view', $visita->id]);
        }
    }
}
