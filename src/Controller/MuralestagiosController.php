<?php
declare(strict_types=1);

namespace App\Controller;

use Authorization\Exception\ForbiddenException;
use Cake\Datasource\Exception\RecordNotFoundException;
use Cake\Event\EventInterface;

/**
 * Muralestagios Controller
 *
 * @property \App\Model\Table\MuralestagiosTable $Muralestagios
 * @property \Authorization\Controller\Component\AuthorizationComponent $Authorization
 * @property \Authentication\Controller\Component\AuthenticationComponent $Authentication
 * @method \App\Model\Entity\Muralestagio[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class MuralestagiosController extends AppController
{
    /**
     * Before filter method
     *
     * @param \Cake\Event\EventInterface $event Event
     * @return void
     */
    public function beforeFilter(EventInterface $event): void
    {
        parent::beforeFilter($event);
        // Permitir aos usuários visitantes possam ver o mural.
        $this->Authentication->addUnauthenticatedActions(['index', 'view']);
    }

    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        try {
            $this->Authorization->authorize($this->Muralestagios);
        } catch (ForbiddenException $e) {
            $this->Flash->error(__('Acesso negado. Você não tem permissão para acessar esta página.'));

            return $this->redirect(['action' => 'index']);
        }
        $periodo = $this->request->getQuery('periodo');

        if (($periodo == null) || empty($periodo)) {
            $configuracaotable = $this->fetchTable('Configuracoes');
            $periodoconfiguracao = $configuracaotable->find()->first();
            $periodo = $periodoconfiguracao->mural_periodo_atual;
        }

        $query = $this->Muralestagios->find()
            ->contain(['Instituicoes']);

        if ($periodo) {
            $query->where([
                'Muralestagios.periodo' => $periodo,
            ]);
        } else {
            $this->Flash->error(__('Selecionar período.'));
            // return $this->redirect(['action' => 'index']); // Prevent infinite loop if no config
        }

        $query->order(['Muralestagios.dataInscricao' => 'DESC']);

        /** Todos os períodos */
        $periodototal = $this->Muralestagios->find('list', [
            'keyField' => 'periodo',
            'valueField' => 'periodo',
            // 'group' => 'periodo', // Group by deprecated/not needed if list unique? check logic
            'sort' => ['periodo' => 'DESC'],
        ])->distinct(['periodo']); // Distinct instead of group for list if needed

        $periodos = $periodototal->toArray();

        if ($query->count() == 0) {
             // Warning managed in view or just flash
             $this->Flash->warning(__('Nenhum registro de mural de estágio encontrado para o período selecionado.'));
        }

        $muralestagios = $this->paginate($query, [
            'sortableFields' => ['instituicao', 'vagas', 'beneficios', 'final_de_semana', 'cargaHoraria', 'dataInscricao', 'dataSelecao'],
        ]);

        $this->set(compact('muralestagios', 'periodo', 'periodos'));
    }

    /**
     * View method
     *
     * @param string|null $id Muralestagio id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view(?string $id = null)
    {
        try {
            $muralestagio = $this->Muralestagios->get($id, [
                'contain' => ['Instituicoes', 'Turmaestagios', 'Professores', 'Muralinscricoes' => ['Alunos', 'Muralestagios']],
            ]);
        } catch (RecordNotFoundException $e) {
            $this->Flash->error(__('Não há registros de estágio para esse número!'));

            return $this->redirect(['action' => 'index']);
        }

        try {
            $this->Authorization->authorize($muralestagio);
        } catch (ForbiddenException $e) {
            $this->Flash->error(__('Acesso negado. Você não tem permissão para acessar esta página.'));

            return $this->redirect(['action' => 'index']);
        }

        /** Para o administrador selecionar o aluno */
        $alunotable = $this->fetchTable('Alunos');
        $alunos = $alunotable->find('list', [
            'keyField' => 'registro',
            'valueField' => 'nome',
            'order' => ['nome' => 'ASC'],
        ])->toArray();

        $this->set(compact('muralestagio', 'alunos'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $periodo = $this->request->getQuery('periodo'); // Original used undefined variable check logic?
        // Logic: if (empty($periodo)) fetch from config. But variable $periodo isn't defined in scope unless passed or fetched.

        if (empty($periodo)) {
            $configuracaotable = $this->fetchTable('Configuracoes');
            $periodoconfiguracao = $configuracaotable->find()
                ->select(['mural_periodo_atual'])
                ->first();
            $periodo = $periodoconfiguracao->mural_periodo_atual;
        }

        $muralestagio = $this->Muralestagios->newEmptyEntity();

        try {
            $this->Authorization->authorize($muralestagio);
        } catch (ForbiddenException $e) {
            $this->Flash->error(__('Acesso negado. Você não tem permissão para acessar esta página.'));

            return $this->redirect(['action' => 'index']);
        }

        if ($this->request->is('post')) {
            $dados = $this->request->getData();

            // Auto populate instituicao name from ID if chosen
            // Original code fetched institution name to save it as string in 'instituicao' field?
            // "Muralestagios.instituicao" seems to be a field, distinct from association?
            $instituicao = $this->Muralestagios->Instituicoes->find()
                ->where(['id' => $dados['instituicao_id']])
                ->select(['instituicao'])
                ->first();

            if (empty($instituicao->instituicao)) {
                $this->Flash->error(__('Instituição não encontrada.'));

                return $this->redirect(['action' => 'add']);
            } else {
                 $dados['instituicao'] = $instituicao->instituicao;

                 $muralestagio = $this->Muralestagios->patchEntity($muralestagio, $dados);
                if ($this->Muralestagios->save($muralestagio)) {
                    $this->Flash->success(__('Registo de novo mural de estágio feito.'));

                    return $this->redirect(['action' => 'view', $muralestagio->id]);
                }
                 $this->Flash->error(__('Registro de mural de estágio não foi feito. Tente novamente.'));
            }
        }
        $instituicoes = $this->fetchTable('Instituicoes')->find('list', ['order' => ['instituicao' => 'ASC']]);
        $turmaestagios = $this->fetchTable('Turmaestagios')->find('list', ['order' => ['area' => 'ASC']]);
        $professores = $this->fetchTable('Professores')->find('list', ['order' => ['nome' => 'ASC']]);
        $this->set(compact('muralestagio', 'instituicoes', 'turmaestagios', 'professores', 'periodo'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Muralestagio id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit(?string $id = null)
    {
        try {
            $muralestagio = $this->Muralestagios->get($id, [
                'contain' => ['Instituicoes'],
            ]);
        } catch (RecordNotFoundException $e) {
            $this->Flash->error(__('Não há registros de estágio para esse número!'));

            return $this->redirect(['action' => 'index']);
        }

        try {
            $this->Authorization->authorize($muralestagio);
        } catch (ForbiddenException $e) {
            $this->Flash->error(__('Acesso negado. Você não tem permissão para acessar esta página.'));

            return $this->redirect(['action' => 'index']);
        }

        if ($this->request->is(['patch', 'post', 'put'])) {
            $muralestagio = $this->Muralestagios->patchEntity($muralestagio, $this->request->getData());
            if ($this->Muralestagios->save($muralestagio)) {
                $this->Flash->success(__('Registro muralestagio atualizado.'));

                return $this->redirect(['action' => 'view', $muralestagio->id]);
            }
            $this->Flash->error(__('Registro muralestagio não foi atualizado. Tente novamente.'));
        }

        /** Todos os periódos */
        $periodototal = $this->Muralestagios->find('list', [
            'keyField' => 'periodo',
            'valueField' => 'periodo',
            'sort' => ['periodo' => 'DESC'],
        ])->distinct(['periodo']);
        $periodos = $periodototal->toArray();

        $instituicoes = $this->Muralestagios->Instituicoes->find('list', ['order' => ['instituicao' => 'ASC']]);
        $turmaestagios = $this->Muralestagios->Turmaestagios->find('list', ['order' => ['area' => 'ASC']]);
        $professores = $this->Muralestagios->Professores->find('list', ['order' => ['nome' => 'ASC']]);
        $this->set(compact('muralestagio', 'instituicoes', 'turmaestagios', 'professores', 'periodos'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Muralestagio id.
     * @return \Cake\Http\Response|null|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete(?string $id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        try {
            $muralestagio = $this->Muralestagios->get($id);
        } catch (RecordNotFoundException $e) {
            $this->Flash->error(__('Não há registros de estágio para esse número!'));

            return $this->redirect(['action' => 'index']);
        }

        try {
            $this->Authorization->authorize($muralestagio);
        } catch (ForbiddenException $e) {
            $this->Flash->error(__('Acesso negado. Você não tem permissão para acessar esta página.'));

            return $this->redirect(['action' => 'index']);
        }

        // Check for associated records to prevent data integrity issues
        $inscricoesCount = $this->Muralestagios->Muralinscricoes->find()
            ->where(['muralestagio_id' => $id])
            ->count();

        if ($inscricoesCount > 0) {
            $this->Flash->error(__('Não é possível excluir o mural de estágio. Existem {$inscricoesCount} inscrição(s) associada(s).'));

            return $this->redirect(['action' => 'view', $id]);
        }

        if ($this->Muralestagios->delete($muralestagio)) {
            $this->Flash->success(__('Mural de estágio excluído.'));
        } else {
            $this->Flash->error(__('Mural de estágio não foi excluído.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
