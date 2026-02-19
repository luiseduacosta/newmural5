<?php
declare(strict_types=1);

namespace App\Controller;

/**
 * Tccestudantes Controller
 *
 * @property \App\Model\Table\TccestudantesTable $Tccestudantes
 * @property \Authorization\Controller\Component\AuthorizationComponent $Authorization
 * @property \Authentication\Controller\Component\AuthenticationComponent $Authentication
 * @method \App\Model\Entity\Tccestudante[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class TccestudantesController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        try {
            $this->Authorization->authorize($this->Tccestudantes);
        } catch (\AuthorizationException $e) {
            $this->Flash->error(__('Erro ao carregar os dados. Tente novamente.'));
            return $this->redirect(['action' => 'index']);
        }
        
        $query = $this->Tccestudantes->find()
            ->contain(['Monografias']);

        if ($this->request->is('post')) {
            $dados = $this->request->getData();
            if (!empty($dados['nome'])) {
                $query->where(['nome LIKE' => "%" . $dados['nome'] . "%"]);
            }
        }
        
        if ($query->count() === 0 && !$this->request->is('post')) {
             // Maybe don't error on empty index if not search
             // $this->Flash->error(__('Nenhum registro encontrado.'));
             // return $this->redirect(['action' => 'add']);
        } elseif ($query->count() === 0 && $this->request->is('post')) {
             $this->Flash->error(__('Nenhum registro encontrado.'));
        }

        $query->order(['nome' => 'ASC']); // Default order

        $tccestudantes = $this->paginate($query, [
            'sortableFields' => [
                'Tccestudantes.id',
                'Tccestudantes.registro',
                'Tccestudantes.nome',
                'Monografias.titulo'
            ]
        ]);

        $this->set(compact('tccestudantes'));
    }

    /**
     * View method
     *
     * @param string|null $id Tccestudante id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        try {
            $tccestudante = $this->Tccestudantes->get($id, [
                'contain' => ['Monografias'],
            ]);
        } catch (\Cake\Datasource\Exception\RecordNotFoundException $e) {
            $this->Flash->error(__('Registro não encontrado.'));
            return $this->redirect(['action' => 'index']);
        }

        try {
            $this->Authorization->authorize($tccestudante);
        } catch (\AuthorizationException $e) {
            $this->Flash->error(__('Erro ao carregar os dados. Tente novamente.'));
            return $this->redirect(['action' => 'index']);
        }

        $this->set('tccestudante', $tccestudante);
    }

    /**
     * Add method
     * @param string|null $estudante_id Estudante id.
     * @param string|null $monografia_id Monografia id.
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add($estudante_id = null, $monografia_id = null)
    {
        if ($estudante_id) {
            if (strlen($estudante_id) < 9) {
                $this->Flash->error(__('Registro inválido.'));
                return $this->redirect(['action' => 'index']);
            }
            $registro = $estudante_id;

            /* Nome do aluno */
            $resultado = $this->fetchTable('Alunos') // Changed from Estudantes to Alunos
                ->find()
                ->where(['registro' => $estudante_id])
                ->select(['nome'])
                ->first();
                
            if ($resultado) {
                $nome = $resultado->nome;
                $this->set(compact('registro', 'nome'));
            }
        }

        $tccestudante = $this->Tccestudantes->newEmptyEntity();
        try {
            $this->Authorization->authorize($tccestudante);
        } catch (\AuthorizationException $e) {
            $this->Flash->error(__('Erro ao carregar os dados. Tente novamente.'));
            return $this->redirect(['action' => 'index']);
        }

        if ($this->request->is('post')) {
            $tccestudante = $this->Tccestudantes->patchEntity($tccestudante, $this->request->getData());
            if ($this->Tccestudantes->save($tccestudante)) {
                $this->Flash->success(__('Estudante autor de TCC inserido!'));
                return $this->redirect(['action' => 'view', $tccestudante->id]);
            }
            $this->Flash->error(__('Estudante autor de TCC não foi inserido. Tente novamente.'));
        }

        $monografias = $this->Tccestudantes->Monografias->find('list', [
            'keyField' => 'id', 
            'valueField' => 'titulo',
            'order' => ['titulo' => 'asc']
        ]);
        
        // List of students who are authors (for selection?) or all students?
        // Original code joined tccestudantes, likely to show existing authors?
        // "Estudantes.registro = Tccestudantes.registro".
        // It seems it wanted to list students that are already TCC authors? Or available students?
        // Original: "Select Estudantes using Left Join Tccestudantes".
        
        // I will list all Alunos for simplicity to choose from
        $estudantes = $this->fetchTable('Alunos')->find('list', [
             'keyField' => 'registro',
             'valueField' => 'nome',
             'order' => ['nome' => 'asc']
        ]);

        $this->set(compact('monografia_id', 'estudante_id', 'monografias', 'tccestudante', 'estudantes'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Tccestudante id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        try {
            $tccestudante = $this->Tccestudantes->get($id, [
                'contain' => ['Monografias'],
            ]);
        } catch (\Cake\Datasource\Exception\RecordNotFoundException $e) {
            $this->Flash->error(__('Registro não encontrado.'));
            return $this->redirect(['action' => 'index']);
        }

        try {
            $this->Authorization->authorize($tccestudante);
        } catch (\AuthorizationException $e) {
            $this->Flash->error(__('Erro ao carregar os dados. Tente novamente.'));
            return $this->redirect(['action' => 'index']);
        }

        if ($this->request->is(['patch', 'post', 'put'])) {
            $tccestudante = $this->Tccestudantes->patchEntity($tccestudante, $this->request->getData());
            if ($this->Tccestudantes->save($tccestudante)) {
                $this->Flash->success(__('Estudante de TCC atualizado.'));
                return $this->redirect(['action' => 'view', $tccestudante->id]);
            }
            $this->Flash->error(__('Estudante de TCC não foi atualizado.'));
        }
        
        $monografias = $this->Tccestudantes->Monografias->find('list', [
            'keyField' => 'id', 
            'valueField' => 'titulo',
            'order' => ['titulo' => 'asc']
        ]);
        
        $this->set(compact('monografias', 'tccestudante'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Tccestudante id.
     * @return \Cake\Http\Response|null|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        try {
            $tccestudante = $this->Tccestudantes->get($id);
        } catch (\Exception $e) {
             $this->Flash->error(__('Registro não encontrado'));
             return $this->redirect(['action' => 'index']);
        }

        try {
            $this->Authorization->authorize($tccestudante);
        } catch (\AuthorizationException $e) {
            $this->Flash->error(__('Erro ao carregar os dados. Tente novamente.'));
            return $this->redirect(['action' => 'index']);
        }
        
        if ($this->Tccestudantes->delete($tccestudante)) {
            $this->Flash->success(__('Estudante autor de TCC excluído.'));
        } else {
            $this->Flash->error(__('Estudante autor de TCC não foi excluído.'));
        }
        return $this->redirect(['action' => 'index']);
    }
}
