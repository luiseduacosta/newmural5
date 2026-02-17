<?php
declare(strict_types=1);

namespace App\Controller;

/**
 * Docentes Controller
 *
 * @property \App\Model\Table\DocentesTable $Docentes
 * @method \App\Model\Entity\Docente[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class DocentesController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null
     */
    public function index()
    {
        $this->Authorization->skipAuthorization();
        $query = $this->Docentes->find();
        if ($query) {
            if ($this->request->getQuery('sort') === null) {
                $query->order(['nome' => 'ASC']);
            }
            $docentes = $this->paginate($query, [
                'sortableFields' => ['nome', 'siape', 'departamento', 'dataingresso', 'dataegresso']
            ]);
            $this->set(compact('docentes'));
        } else {
            $this->Flash->error(__('Nenhum(a) docente encontrado.'));
            return $this->redirect(['action' => 'add']);
        }
    }

    /**
     * View method
     *
     * @param string|null $id Docente id.
     * @return \Cake\Http\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $this->Authorization->skipAuthorization();

        if (empty($id)) {
            $this->Flash->error(__('Registro ID do docente não encontrado'));
            return $this->redirect(['action' => 'index']);
        }

        try {
            $docente = $this->Docentes->get($id, [
                'contain' => ['Monografias' => ['sort' => ['titulo' => 'ASC']], 'Areamonografias']
            ]);
        } catch (\Cake\Datasource\Exception\RecordNotFoundException $e) {
            $this->Flash->error(__('Registro docente não encontrado'));
            return $this->redirect(['action' => 'index']);
        }

        $this->set('docente', $docente);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $docente = $this->Docentes->newEmptyEntity();
        $this->Authorization->authorize($docente);

        if ($this->request->is('post')) {
            $siape = $this->request->getData('siape');
            if (empty($siape)) {
                $this->Flash->error(__('Siape do(a) docente não informado'));
                return $this->redirect(['action' => 'index']);
            }
            $docentesiape = $this->Docentes->find()
                ->where(['siape' => $siape])
                ->first();
            if ($docentesiape):
                $this->Flash->error(__('Siape do(a) docente já cadastrado'));
                return $this->redirect(['action' => 'view', $docentesiape->id]);
            endif;
            $email = $this->request->getData('email');
            if (empty($email)) {
                $this->Flash->error(__('E-mail do(a) docente não informado'));
                return $this->redirect(['action' => 'index']);
            }
            $docenteemail = $this->Docentes->find()
                ->where(['email' => $email])
                ->first();
            if ($docenteemail):
                $this->Flash->error(__('E-mail do(a) docente já cadastrado'));
                return $this->redirect(['action' => 'view', $docenteemail->id]);
            endif;
            $docente = $this->Docentes->patchEntity($docente, $this->request->getData());
            if ($this->Docentes->save($docente)) {
                $this->Flash->success(__('Registro docente inserido.'));
                return $this->redirect(['action' => 'view', $docente->id]);
            }
            $this->Flash->error(__('Registro docente não inserido. Tente novamente.'));
        }
        $this->set(compact('docente'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Docente id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        try {
            $docente = $this->Docentes->get($id, [
                'contain' => [],
            ]);
        } catch (\Cake\Datasource\Exception\RecordNotFoundException $e) {
            $this->Flash->error(__('Registro docente não encontrado'));
            return $this->redirect(['action' => 'index']);
        }
        $this->Authorization->authorize($docente);

        if ($this->request->is(['patch', 'post', 'put'])) {
            $docente = $this->Docentes->patchEntity($docente, $this->request->getData());
            if ($this->Docentes->save($docente)) {
                $this->Flash->success(__('Registro docente atualizado.'));
                return $this->redirect(['action' => 'view', $docente->id]);
            }
            $this->Flash->error(__('Registro docente não atualizado.'));
        }

        $this->set(compact('docente'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Docente id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        try {
            $docente = $this->Docentes->get($id);
        } catch (\Cake\Datasource\Exception\RecordNotFoundException $e) {
            $this->Flash->error(__('Registro docente não encontrado'));
            return $this->redirect(['action' => 'index']);
        }
        $this->Authorization->authorize($docente);
        
        if ($this->Docentes->delete($docente)) {
            $this->Flash->success(__('Registro docente excluído.'));
        } else {
            $this->Flash->error(__('Registro docente não excluídio'));
            return $this->redirect(['action' => 'view', $docente->id]);
        }
        return $this->redirect(['action' => 'index']);
    }
}
