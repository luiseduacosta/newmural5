<?php
declare(strict_types=1);

namespace App\Controller;

use Authorization\Exception\ForbiddenException;
use Cake\Datasource\Exception\RecordNotFoundException;
use Cake\I18n\DateTime;
use Exception;

/**
 * Muralinscricoes Controller
 *
 * @property \App\Model\Table\MuralinscricoesTable $Muralinscricoes
 * @property \Authorization\Controller\Component\AuthorizationComponent $Authorization
 * @property \Authentication\Controller\Component\AuthenticationComponent $Authentication
 * @method \App\Model\Entity\Muralinscricao[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class MuralinscricoesController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index($periodo = null)
    {
        try {
            $this->Authorization->authorize($this->Muralinscricoes);
        } catch (ForbiddenException $e) {
            $this->Flash->error(__('Acesso negado. Você não tem permissão para acessar esta página.'));

            return $this->redirect(['controller' => 'Muralestagios', 'action' => 'index']);
        }

        if (empty($periodo)) {
            $configuracaotable = $this->fetchTable('Configuracoes');
            $periodoconfiguracao = $configuracaotable->get(1);
            $periodo = $periodoconfiguracao->mural_periodo_atual;
        }

        $query = $this->Muralinscricoes->find()
            ->contain(['Alunos', 'Muralestagios'])
            ->order(['Alunos.nome' => 'ASC']);

        if ($periodo) {
            $query->where(['Muralinscricoes.periodo' => $periodo]);
        }

        $muralinscricoes = $this->paginate($query, [
            'sortableFields' => ['id', 'registro', 'Alunos.nome', 'Muralestagios.instituicao', 'data', 'periodo', 'timestamp'],
        ]);

        $periodototal = $this->Muralinscricoes->find('list', [
            'keyField' => 'periodo',
            'valueField' => 'periodo',
            'sort' => ['periodo' => 'DESC'],
        ])->distinct(['periodo']);

        $periodos = $periodototal->toArray();

        $this->set(compact('muralinscricoes', 'periodo', 'periodos'));
    }

    /**
     * View method
     *
     * @param string|null $id Muralinscricao id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view(?string $id = null)
    {

        try {
            $muralinscricao = $this->Muralinscricoes->get($id, [
                'contain' => ['Alunos', 'Muralestagios' => ['Instituicoes']],
            ]);
        } catch (RecordNotFoundException $e) {
            $this->Flash->error(__('Não há registros de inscrições para esse número!'));

            return $this->redirect(['controller' => 'Muralestagios', 'action' => 'index']);
        }

        try {
            $this->Authorization->authorize($muralinscricao);
        } catch (ForbiddenException $e) {
            $this->Flash->error(__('Acesso negado. Você não tem permissão para acessar esta página.'));

            return $this->redirect(['controller' => 'Muralestagios', 'action' => 'index']);
        }

        $this->set(compact('muralinscricao'));
    }

    /**
     * Add method
     *
     * @param string|null $id Muralestagio id.
     * @param string|null $registro Registro dre.
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add(?string $id = null, ?string $registro = null)
    {
        $muralinscricao = $this->Muralinscricoes->newEmptyEntity();
        try {
            $this->Authorization->authorize($muralinscricao);
        } catch (ForbiddenException $e) {
            $this->Flash->error(__('Acesso negado. Você não tem permissão para acessar esta página.'));

            return $this->redirect(['controller' => 'Muralestagios', 'action' => 'index']);
        }

        $muralestagios = []; // Init variables
        $alunos = [];

        if ($this->request->is(['post', 'put', 'patch'])) {
            $data = $this->request->getData();

            // Pega os dados do formulário
            if (!empty($data['aluno_id'])) {
                try {
                    $aluno = $this->fetchTable('Alunos')->get($data['aluno_id']);
                    $registro = $aluno->registro;
                } catch (RecordNotFoundException $e) {
                    $this->Flash->error(__('Aluno não encontrado.'));

                    return $this->redirect(['controller' => 'Alunos', 'action' => 'index']);
                }
            } elseif (!empty($data['registro'])) {
                $registro = $data['registro'];
            }

            if (empty($registro)) {
                $this->Flash->error(__('Precisa do DRE do estudante para fazer inscrição'));

                return $this->redirect(['controller' => 'Alunos', 'action' => 'index']);
            }

            $muralestagio_id = $data['muralestagio_id'] ?? null;
            if (empty($muralestagio_id)) {
                $this->Flash->error(__('Selecionar um mural de estágio para a qual quer fazer inscrição.'));

                return $this->redirect(['controller' => 'Muralestagios', 'action' => 'index']);
            }

            try {
                 $muralestagio = $this->Muralinscricoes->Muralestagios->get($muralestagio_id);
                 $periodo_mural = $muralestagio->periodo;
            } catch (Exception $e) {
                 $this->Flash->error(__('Mural de estágio não localizado'));

                 return $this->redirect(['controller' => 'Muralestagios', 'action' => 'index']);
            }

            $hoje = DateTime::now();

            // Date check logic - use clone to avoid mutating $hoje
            $dataInscricao = $muralestagio->dataInscricao ?? (clone $hoje)->addDays(1);

            /** Verifica se o período de inscrição está aberto para o aluno fazer inscrição */
            if ($this->user && $this->user->categoria == '2' && $dataInscricao < $hoje) {
                $this->Flash->error(__('Período de inscrição encerrado em {0}. Não é possível fazer inscrição.', $dataInscricao));

                return $this->redirect(['controller' => 'Muralestagios', 'action' => 'index']);
            }

            /** Verifica se já fez inscricações para essa mesma vaga de estágio */
            $verifica = $this->Muralinscricoes->find()
                ->where(['muralestagio_id' => $muralestagio_id, 'registro' => $registro])
                ->first();

            if ($verifica) {
                $this->Flash->error(__('Inscrição já realizada'));

                return $this->redirect(['controller' => 'Muralinscricoes', 'action' => 'view', $verifica->id]);
            }

            /** Pega o id do aluno */
            if (!isset($aluno)) {
                $aluno = $this->fetchTable('Alunos')->find()
                    ->where(['registro' => $registro])
                    ->first();
            }

            if (!$aluno) {
                $this->Flash->error(__('Aluno não localizado'));

                return $this->redirect(['controller' => 'Alunos', 'action' => 'index']);
            }

            /** Pega o período atual */
            $config = $this->fetchTable('Configuracoes')->get(1);
            $periodo_atual = $config->mural_periodo_atual;

            /** Dados para fazer a inscrição */
            $saveData = [];
            $saveData['registro'] = $registro;
            $saveData['aluno_id'] = $aluno->id;
            $saveData['muralestagio_id'] = $muralestagio_id;
            $saveData['data'] = date('Y-m-d');
            $saveData['periodo'] = $periodo_mural ?? $periodo_atual;
            $saveData['timestamp'] = date('Y-m-d H:i:s');

            $muralinscricao = $this->Muralinscricoes->patchEntity($muralinscricao, $saveData);
            if ($this->Muralinscricoes->save($muralinscricao)) {
                $this->Flash->success(__('Inscrição realizada!'));

                return $this->redirect(['controller' => 'Muralinscricoes', 'action' => 'view', $muralinscricao->id]);
            }
            $this->Flash->error(__('Não foi possível realizar a inscrição. Tente novamente.'));
        }

        /**  Alunos com o registro */
        // Use concat for display
        $queryAlunos = $this->Muralinscricoes->Alunos->find();
        $concat = $queryAlunos->func()->concat([
            'Alunos.registro' => 'identifier',
            ' - ',
            'Alunos.nome' => 'identifier',
        ]);
        $alunosList = $queryAlunos->select([
                'id',
                'registro_nome' => $concat,
            ])
            ->order(['Alunos.nome' => 'ASC'])
            ->all();

        foreach ($alunosList as $a) {
            $alunos[$a->id] = $a->registro_nome;
        }

        /**  Muralestagios com período e instituição */
        $queryMural = $this->Muralinscricoes->Muralestagios->find();
        $concatMural = $queryMural->func()->concat([
            'Muralestagios.periodo' => 'identifier',
            ' - ',
            'Muralestagios.instituicao' => 'identifier',
        ]);
        $muralList = $queryMural->select([
                'Muralestagios.id',
                'instituicao_periodo' => $concatMural,
            ])
            ->order(['Muralestagios.periodo' => 'DESC', 'Muralestagios.instituicao' => 'ASC'])
            ->all();

        foreach ($muralList as $m) {
            $muralestagios[$m->id] = $m->instituicao_periodo;
        }

        $this->set(compact('muralinscricao', 'alunos', 'muralestagios'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Muralinscricao id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit(?string $id = null)
    {
        try {
            $muralinscricao = $this->Muralinscricoes->get($id, [
                'contain' => ['Alunos', 'Muralestagios'],
            ]);
        } catch (RecordNotFoundException $e) {
            $this->Flash->error(__('Registro de inscrição não foi encontrado. Tente novamente.'));

            return $this->redirect(['controller' => 'Muralestagios', 'action' => 'index']);
        }

        try {
            $this->Authorization->authorize($muralinscricao);
        } catch (ForbiddenException $e) {
            $this->Flash->error(__('Acesso negado. Você não tem permissão para acessar esta página.'));

            return $this->redirect(['controller' => 'Muralestagios', 'action' => 'index']);
        }

        if ($this->request->is(['patch', 'post', 'put'])) {

            /** Ajusto o período conforme o mural de estágio selecionado */
            $mural_id_to_check = $this->request->getData('muralestagio_id');

            if ($mural_id_to_check) {
                $mural = $this->Muralinscricoes->Muralestagios->get($mural_id_to_check);
                if (!$mural) {
                    $this->Flash->error(__('Mural de estágio não localizado'));

                    return $this->redirect(['controller' => 'Muralestagios', 'action' => 'index']);
                }
                $data = $this->request->getData();
                $data['periodo'] = $mural->periodo;

                $muralinscricao = $this->Muralinscricoes->patchEntity($muralinscricao, $data);
                if ($this->Muralinscricoes->save($muralinscricao)) {
                    $this->Flash->success(__('Registro de inscrição atualizado.'));

                    return $this->redirect(['controller' => 'Muralinscricoes', 'action' => 'view', $muralinscricao->id]);
                }
            }
            $this->Flash->error(__('Registro de inscrição não foi atualizado. Tente novamente.'));
        }

        // Prepare lists
        $muralestagios = [];
        $alunos = [];

        /**  Muralestagios com período e instituição */
        $queryMural = $this->Muralinscricoes->Muralestagios->find();
        $concatMural = $queryMural->func()->concat([
            'Muralestagios.periodo' => 'identifier',
            ' - ',
            'Muralestagios.instituicao' => 'identifier',
        ]);
        $muralList = $queryMural->select([
                'Muralestagios.id',
                'instituicao_periodo' => $concatMural,
            ])
            ->order(['Muralestagios.periodo' => 'DESC', 'Muralestagios.instituicao' => 'ASC'])
            ->all();

        foreach ($muralList as $m) {
            $muralestagios[$m->id] = $m->instituicao_periodo;
        }

        /**  Alunos */
        $queryAlunos = $this->Muralinscricoes->Alunos->find();
        $concat = $queryAlunos->func()->concat([
            'Alunos.registro' => 'identifier',
            ' - ',
            'Alunos.nome' => 'identifier',
        ]);
        $alunosList = $queryAlunos->select([
                'id',
                'registro_nome' => $concat,
            ])
            ->order(['Alunos.nome' => 'ASC'])
            ->all();
        foreach ($alunosList as $a) {
            $alunos[$a->id] = $a->registro_nome;
        }

        $this->set(compact('muralinscricao', 'muralestagios', 'alunos'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Muralinscricao id.
     * @return \Cake\Http\Response|null|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete(?string $id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        try {
            $muralinscricao = $this->Muralinscricoes->get($id);
        } catch (RecordNotFoundException $e) {
            $this->Flash->error(__('Registro de inscrição não foi encontrado. Tente novamente.'));

            return $this->redirect(['controller' => 'Muralestagios', 'action' => 'index']);
        }

        try {
            $this->Authorization->authorize($muralinscricao);
        } catch (ForbiddenException $e) {
            $this->Flash->error(__('Acesso negado. Você não tem permissão para acessar esta página.'));

            return $this->redirect(['controller' => 'Muralestagios', 'action' => 'index']);
        }

        if ($this->Muralinscricoes->delete($muralinscricao)) {
            $this->Flash->success(__('Inscrição excluída.'));
            // return $this->redirect(['controller' => 'Alunos', 'action' => 'view', $muralinscricao->aluno_id]); // Or index
        } else {
            $this->Flash->error(__('Não foi possível excluir a inscrição.'));

            return $this->redirect(['controller' => 'Muralinscricoes', 'action' => 'view', $muralinscricao->id]);
        }

        return $this->redirect(['controller' => 'Muralestagios', 'action' => 'index']);
    }
}
