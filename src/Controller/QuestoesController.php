<?php
declare(strict_types=1);

namespace App\Controller;

use Authorization\Exception\ForbiddenException;
use Cake\Datasource\Exception\RecordNotFoundException;

/**
 * Questoes Controller
 *
 * @property \App\Model\Table\QuestoesTable $Questoes
 * @property \Authorization\Controller\Component\AuthorizationComponent $Authorization
 * @property \Authentication\Controller\Component\AuthenticationComponent $Authentication
 * @method \App\Model\Entity\Questao[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
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
        } catch (ForbiddenException $e) {
            $this->Flash->error(__('Acesso negado. Você não tem permissão para acessar esta página.'));

            return $this->redirect(['controller' => 'Muralestagiarios', 'action' => 'index']);
        }

        $query = $this->Questoes->find()
            ->contain(['Questionarios'])
            ->orderBy(['ordem' => 'ASC']);
        $questoes = $this->paginate($query, [
            'sortableFields' => [
                'id',
                'type',
                'text',
                'options',
                'ordem',
                'Questionarios.title', // Check association alias
            ],
            'limit' => 20,
        ]);
        $this->set(compact('questoes'));
    }

    /**
     * View method
     *
     * @param string|null $id Questao id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view(?string $id = null)
    {
        try {
            $questao = $this->Questoes->get($id, [
                'contain' => ['Questionarios'],
            ]);
        } catch (RecordNotFoundException $e) {
            $this->Flash->error(__('Registro não encontrado.'));

            return $this->redirect(['controller' => 'Questoes', 'action' => 'index']);
        }

        try {
            $this->Authorization->authorize($questao);
        } catch (ForbiddenException $e) {
            $this->Flash->error(__('Acesso negado. Você não tem permissão para acessar esta página.'));

            return $this->redirect(['controller' => 'Muralestagiarios', 'action' => 'index']);
        }

        $this->set(compact('questao'));
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
        } catch (ForbiddenException $e) {
            $this->Flash->error(__('Acesso negado. Você não tem permissão para acessar esta página.'));

            return $this->redirect(['controller' => 'Muralestagiarios', 'action' => 'index']);
        }

        // Find last order
        $ultimaPergunta = $this->Questoes
            ->find()
            ->orderBy(['ordem' => 'DESC'])
            ->first();

        if ($ultimaPergunta && $ultimaPergunta->ordem) {
            $this->set('ordem', $ultimaPergunta->ordem + 1);
        }

        if ($this->request->is('post')) {
            $questao = $this->Questoes->patchEntity(
                $questao,
                $this->request->getData(),
            );
            if ($this->Questoes->save($questao)) {
                $this->Flash->success(__('Pergunta inserida.'));

                return $this->redirect(['action' => 'view', $questao->id]);
            }
            $this->Flash->error(__('Pergunta não inserida. Tente novamente.'));
        }

        $questionarios = $this->Questoes->Questionarios
            ->find('list', ['limit' => 200])
            ->all();
        $this->set(compact('questao', 'questionarios'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Questao id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit(?string $id = null)
    {
        try {
            $questao = $this->Questoes->get($id, [
                'contain' => [],
            ]);
        } catch (RecordNotFoundException $e) {
            $this->Flash->error(__('Registro não encontrado.'));

            return $this->redirect(['controller' => 'Questoes', 'action' => 'index']);
        }

        try {
            $this->Authorization->authorize($questao);
        } catch (ForbiddenException $e) {
            $this->Flash->error(__('Acesso negado. Você não tem permissão para acessar esta página.'));

            return $this->redirect(['controller' => 'Muralestagiarios', 'action' => 'index']);
        }

        if ($this->request->is(['patch', 'post', 'put'])) {
            $questao = $this->Questoes->patchEntity(
                $questao,
                $this->request->getData(),
            );
            if ($this->Questoes->save($questao)) {
                $this->Flash->success(__('Pergunta atualizada.'));

                return $this->redirect(['action' => 'view', $questao->id]);
            }
            $this->Flash->error(__('Pergunta não atualizada. Tente novamente.'));
        }

        $questionarios = $this->Questoes->Questionarios
            ->find('list', ['limit' => 200])
            ->all();

        $this->set(compact('questao', 'questionarios'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Questao id.
     * @return \Cake\Http\Response|null|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete(?string $id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        try {
            $questao = $this->Questoes->get($id, [
                'contain' => [],
            ]);
        } catch (RecordNotFoundException $e) {
            $this->Flash->error(__('Registro não encontrado.'));

            return $this->redirect(['controller' => 'Questoes', 'action' => 'index']);
        }

        try {
            $this->Authorization->authorize($questao);
        } catch (ForbiddenException $e) {
            $this->Flash->error(__('Acesso negado. Você não tem permissão para acessar esta página.'));

            return $this->redirect(['controller' => 'Muralestagiarios', 'action' => 'index']);
        }

        if ($this->Questoes->delete($questao)) {
            $this->Flash->success(__('Pergunta excluída.'));
        } else {
            $this->Flash->error(__('Pergunta não excluída. Tente novamente.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
