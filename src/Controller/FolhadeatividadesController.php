<?php
declare(strict_types=1);

namespace App\Controller;

use Authorization\Exception\ForbiddenException;
use Cake\Datasource\Exception\RecordNotFoundException;
use Exception;

/**
 * Folhadeatividades Controller
 *
 * @property \App\Model\Table\FolhadeatividadesTable $Folhadeatividades
 * @property \Authorization\Controller\Component\AuthorizationComponent $Authorization
 * @property \Authentication\Controller\Component\AuthenticationComponent $Authentication
 * @method \App\Model\Entity\Folhadeatividade[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class FolhadeatividadesController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        try {
            $this->Authorization->authorize($this->Folhadeatividades);
        } catch (ForbiddenException $e) {
            $this->Flash->error(__('Acesso negado. Você não tem permissão para acessar esta página.'));

            return $this->redirect(['action' => 'index']);
        }
        $estagiario_id = $this->getRequest()->getQuery('estagiario_id');
        if ($estagiario_id === null) {
            $this->Flash->error(__('Selecione o estagiário e o período da folha de atividades'));

            return $this->redirect(['controller' => 'Estagiarios', 'action' => 'index']);
        }

        $estagiario = $this->Folhadeatividades->Estagiarios->find()
            ->contain(['Alunos', 'Supervisores', 'Instituicoes', 'Professores'])
            ->where(['Estagiarios.id' => $estagiario_id])
            ->first(); // Removed specific select to avoid missing data, getting full entities is safer

        $query = $this->Folhadeatividades->find()
            ->where(['Folhadeatividades.estagiario_id' => $estagiario_id])
            ->contain(['Estagiarios' => ['Alunos']])
            ->order(['Folhadeatividades.dia' => 'ASC']);

        if ($query->count() == 0) {
            $this->Flash->error(__('Nenhum registro encontrado.'));
        }

        $folhadeatividades = $this->paginate($query);
        $this->set(compact('folhadeatividades', 'estagiario'));
    }

    /**
     * View method
     *
     * @param string|null $id Folhadeatividade id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view(?string $id = null)
    {
        $this->Authorization->skipAuthorization();

        try {
             $folhadeatividade = $this->Folhadeatividades->get($id, [
                'contain' => ['Estagiarios' => ['Alunos']],
             ]);
        } catch (RecordNotFoundException $e) {
            $this->Flash->error(__('Atividade não encontrada.'));

            return $this->redirect(['action' => 'index']);
        }

        try {
            $this->Authorization->authorize($folhadeatividade);
        } catch (ForbiddenException $e) {
            $this->Flash->error(__('Acesso negado. Você não tem permissão para acessar esta página.'));

            return $this->redirect(['action' => 'index']);
        }

        if (isset($this->user) && $this->user->categoria == '2') {
             // Student check
            if ($this->user->aluno_id != $folhadeatividade->estagiario->aluno_id) {
                 $this->Flash->error(__('Você não tem permissão para acessar esta página'));

                 return $this->redirect(['controller' => 'Alunos', 'action' => 'view', $this->user->aluno_id]);
            }
        }

        $this->set(compact('folhadeatividade'));
    }

    /**
     * Atividade method - Consolidated view for activities of an intern
     *
     * @param string|null $id Folhadeatividade id.
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function atividade(?string $id = null)
    {
        $this->Authorization->skipAuthorization();
        $estagiario_id = $this->getRequest()->getQuery('estagiario_id');

        // If ID provided, maybe it's Folhadeatividade ID? Original logic was murky.
        // Original logic: if $id passed, find Estagiario via Folhadeatividade. Else use getQuery('estagiario_id').

        if ($id) {
            try {
                $activity = $this->Folhadeatividades->get($id, ['contain' => 'Estagiarios']);
                $estagiario_id = $activity->estagiario_id;
            } catch (Exception $e) {
                $this->Flash->error(__('Atividade não encontrada.'));
            }
        }

        if (!$estagiario_id) {
            $this->Flash->error(__('Selecione o estagiário'));

            return $this->redirect(['controller' => 'Estagiarios', 'action' => 'index']);
        }

        // Fetch Estagiario with all details
        $folhadeatividade = $this->Folhadeatividades->Estagiarios->find()
             ->where(['Estagiarios.id' => $estagiario_id])
             ->contain(['Folhadeatividades' => ['sort' => ['dia' => 'ASC']], 'Alunos', 'Supervisores', 'Instituicoes', 'Professores'])
             ->first();

        if (!$folhadeatividade) {
            $this->Flash->error(__('Estagiário não encontrado'));

            return $this->redirect(['controller' => 'Estagiarios', 'action' => 'index']);
        }

        // Security check
        if (isset($this->user) && $this->user->categoria == '2') {
            if ($this->user->aluno_id != $folhadeatividade->aluno_id) {
                 $this->Flash->error(__('Você não tem permissão para acessar esta página'));

                 return $this->redirect(['controller' => 'Alunos', 'action' => 'view', $this->user->aluno_id]);
            }
        }

        if (empty($folhadeatividade->folhadeatividades)) {
            $this->Flash->error(__('Não há folha de atividades para este estagiário'));

            return $this->redirect(['controller' => 'Folhadeatividades', 'action' => 'add', '?' => ['estagiario_id' => $estagiario_id]]);
        }

        $this->set(compact('folhadeatividade'));
    }

    /**
     * Add method
     *
     * @param string|null $id Estagiário id (unused in sig, used via query)
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $this->Authorization->skipAuthorization();
        $estagiario_id = $this->getRequest()->getQuery('estagiario_id');

        if ($estagiario_id === null) {
            $this->Flash->error(__('Selecione o estagiário'));

            return $this->redirect(['controller' => 'Estagiarios', 'action' => 'index']);
        }

        $estagiario = $this->fetchTable('Estagiarios')
            ->find()
            ->contain(['Alunos'])
            ->where(['Estagiarios.id' => $estagiario_id])
            ->first();


        if (!$estagiario) {
            $this->Flash->error(__('Estagiário não encontrado'));

            return $this->redirect(['controller' => 'Estagiarios', 'action' => 'index']);
        }

        $folhadeatividade = $this->Folhadeatividades->newEmptyEntity();

        try {
            $this->Authorization->authorize($folhadeatividade);
        } catch (ForbiddenException $e) {
            $this->Flash->error(__('Acesso negado. Você não tem permissão para acessar esta página.'));

            return $this->redirect(['action' => 'index']);
        }

        if ($this->request->is('post')) {
            $folhadeatividade = $this->Folhadeatividades->patchEntity($folhadeatividade, $this->request->getData());
            if ($this->Folhadeatividades->save($folhadeatividade)) {
                $this->Flash->success(__('Atividades cadastrada!'));

                return $this->redirect(['controller' => 'Folhadeatividades', 'action' => 'atividade', '?' => ['estagiario_id' => $estagiario_id]]);
            }
            $this->Flash->error(__('Atividade não foi cadastrada. Tente mais uma vez.'));
        }
        $this->set(compact('folhadeatividade', 'estagiario'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Folhadeatividade id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit(?string $id = null)
    {
        try {
            $folhadeatividade = $this->Folhadeatividades->get($id, [
                'contain' => [],
            ]);
        } catch (RecordNotFoundException $e) {
            $this->Flash->error(__('Registro não encontrado.'));

            return $this->redirect(['action' => 'index']);
        }

        try {
            $this->Authorization->authorize($folhadeatividade);
        } catch (ForbiddenException $e) {
            $this->Flash->error(__('Acesso negado. Você não tem permissão para acessar esta página.'));

            return $this->redirect(['action' => 'index']);
        }

        if ($this->request->is(['patch', 'post', 'put'])) {
            $folhadeatividade = $this->Folhadeatividades->patchEntity($folhadeatividade, $this->request->getData());
            if ($this->Folhadeatividades->save($folhadeatividade)) {
                $this->Flash->success(__('Atividade atualizada.'));

                return $this->redirect(['action' => 'view', $id]);
            }
            $this->Flash->error(__('Não foi possível atualizar. Tente outra vez.'));
        }

        // Find Estagiario for context
        $estagiario = $this->Folhadeatividades->Estagiarios->find()
            ->where(['Estagiarios.id' => $folhadeatividade->estagiario_id])
            ->contain(['Alunos'])
            ->first();

        $this->set(compact('folhadeatividade', 'estagiario'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Folhadeatividade id.
     * @return \Cake\Http\Response|null|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete(?string $id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        try {
            $folhadeatividade = $this->Folhadeatividades->get($id);
        } catch (RecordNotFoundException $e) {
            $this->Flash->error(__('Registro não encontrado.'));

            return $this->redirect(['action' => 'index']);
        }

        try {
            $this->Authorization->authorize($folhadeatividade);
        } catch (ForbiddenException $e) {
            $this->Flash->error(__('Acesso negado. Você não tem permissão para acessar esta página.'));

            return $this->redirect(['action' => 'index']);
        }

        if ($this->Folhadeatividades->delete($folhadeatividade)) {
            $this->Flash->success(__('Folha de atividade excluída.'));
        } else {
            $this->Flash->error(__('Folha de atividade não excluída.'));
        }

        return $this->redirect(['action' => 'index']);
    }

    /**
     * Folhadeatividadespdf method
     *
     * @param string|null $id Folhadeatividade id.
     * @return \Cake\Http\Response|null|void Redirects to index.
     */
    public function folhadeatividadespdf(?string $id = null)
    {
        $estagiario_id = $this->getRequest()->getQuery('estagiario_id');
        $this->Authorization->skipAuthorization();

        if (is_null($estagiario_id)) {
            // Try to use $id as fallback if needed? Or error.
            if ($id) {
                $estagiario_id = $id; // Not guaranteed but legacy mixup happens
            } else {
                $this->Flash->error(__('Selecione o estagiário e o período da folha de atividades'));

                return $this->redirect(['controller' => 'Estagiarios', 'action' => 'index']);
            }
        }

        $estagiario = $this->Folhadeatividades->Estagiarios->find()
            ->contain(['Folhadeatividades' => ['sort' => ['dia' => 'ASC']], 'Alunos', 'Professores', 'Instituicoes', 'Supervisores'])
            ->where(['Estagiarios.id' => $estagiario_id])
            ->first();

        if (!$estagiario) {
            $this->Flash->error(__('Estagiário não encontrado.'));

            return $this->redirect(['controller' => 'Estagiarios', 'action' => 'index']);
        }

        $folha = $estagiario->folhadeatividades; // already contained

        $this->viewBuilder()->enableAutoLayout(false);
        $this->viewBuilder()->setClassName('CakePdf.Pdf');
        $this->viewBuilder()->setOption(
            'pdfConfig',
            [
                'orientation' => 'portrait',
                'download' => true,
                'filename' => 'folha_de_atividades_' . $estagiario->aluno->nome . '.pdf',
            ],
        );
        $this->set('folha', $folha);
        $this->set('estagiario', $estagiario);
    }
}
