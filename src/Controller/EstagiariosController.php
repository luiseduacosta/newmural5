<?php
declare(strict_types=1);

namespace App\Controller;

use Authorization\Exception\ForbiddenException;
use Cake\Datasource\Exception\RecordNotFoundException;
use Cake\Http\Exception\NotFoundException;
use Exception;

/**
 * Estagiarios Controller
 *
 * @property \App\Model\Table\EstagiariosTable $Estagiarios
 * @property \Authorization\Controller\Component\AuthorizationComponent $Authorization
 * @property \Authentication\Controller\Component\AuthenticationComponent $Authentication
 * @method \App\Model\Entity\Estagiario[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class EstagiariosController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        try {
            $this->Authorization->authorize($this->Estagiarios);
        } catch (ForbiddenException $e) {
            $this->Flash->error(__('Acesso negado. Você não tem permissão para acessar esta página.'));

            return $this->redirect(['action' => 'index']);
        }

        $instituicao = $this->getRequest()->getQuery('instituicao');
        $supervisor = $this->getRequest()->getQuery('supervisor');
        $professor = $this->getRequest()->getQuery('professor');
        $turmaestagio = $this->getRequest()->getQuery('turmaestagio');
        $nivel = $this->getRequest()->getQuery('nivel');
        $periodo = $this->getRequest()->getQuery('periodo');

        if ($periodo === null) {
            $configuracao = $this->fetchTable('Configuracoes');
            $periodo_atual = $configuracao
                ->find()
                ->select(['mural_periodo_atual'])
                ->first();
            $periodo = $periodo_atual->mural_periodo_atual;
        }

        $query = $this->Estagiarios->find();

        $query->contain([
            'Alunos',
            'Professores',
            'Supervisores',
            'Instituicoes',
            'Turmaestagios',
        ]);

        if ($periodo) {
            $query->where(['Estagiarios.periodo' => $periodo]);
        }

        $query->order(['Alunos.nome' => 'ASC']);

        if ($nivel) {
            $query->where([
                'Estagiarios.nivel' => $nivel,
            ]);
        }
        if ($instituicao) {
            $query->where([
                'Instituicoes.id' => $instituicao,
            ]);
        }
        if ($supervisor) {
            $query->where([
                'Supervisores.id' => $supervisor,
            ]);
        }
        if ($professor) {
            $query->where([
                'Professores.id' => $professor,
            ]);
        }
        if ($turmaestagio) {
            $query->where([
                'Turmaestagios.id' => $turmaestagio,
            ]);
        }
        $config =  [ // Removed $this->paginate assignment to local var as array
            'sortableFields' => [
                'id',
                'Alunos.nome',
                'registro',
                'turno',
                'nivel',
                'Instituicoes.instituicao',
                'Supervisores.nome',
                'Professores.nome',
                'nota',
                'ch',
            ],
            'limit' => 20,
        ];
        $estagiarios = $this->paginate($query, $config);

        /* Todos os periódos */
        $periodototal = $this->Estagiarios->find('list', [
            'keyField' => 'periodo',
            'valueField' => 'periodo',
        ])->order(['periodo' => 'asc']);

        $periodos = $periodototal->toArray();

        // Used for optional filters in view
        $instituicoesQuery = $this->Estagiarios->find()
            ->contain([
                'Instituicoes',
                'Supervisores',
                'Professores',
                'Turmaestagios',
            ])
            ->where(['Estagiarios.periodo' => $periodo]);

        // Manually collecting lists to replicate original behavior of showing only relevant filter options
        // This could be optimized but sticking to migration logic
        $listainstituicoes = [];
        $listasupervisores = [];
        $listaprofessores = [];
        $listaturmaestagios = [];

        foreach ($instituicoesQuery as $estagio) {
            if ($estagio->instituicao) {
                $listainstituicoes[$estagio->instituicao->id] = $estagio->instituicao->instituicao;
            }
            if ($estagio->supervisor) {
                $listasupervisores[$estagio->supervisor->id] = $estagio->supervisor->nome;
            }
            if ($estagio->professor) {
                $listaprofessores[$estagio->professor->id] = $estagio->professor->nome;
            }
            if ($estagio->turmaestagio) {
                $listaturmaestagios[$estagio->turmaestagio->id] = $estagio->turmaestagio->area;
            }
        }

        asort($listainstituicoes);
        asort($listasupervisores);
        asort($listaprofessores);
        asort($listaturmaestagios);

        if (!empty($listainstituicoes)) {
            $this->set('instituicoes', $listainstituicoes);
        }
        if (!empty($listasupervisores)) {
            $this->set('supervisores', $listasupervisores);
        }
        if (!empty($listaprofessores)) {
            $this->set('professores', $listaprofessores);
        }
        if (!empty($listaturmaestagios)) {
            $this->set('turmaestagios', $listaturmaestagios);
        }

        $this->set(compact('estagiarios', 'periodo', 'periodos'));
    }

    /**
     * View method
     *
     * @param string|null $id Estagiario id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view(?string $id = null)
    {
        try {
            $estagiario = $this->Estagiarios->get($id, [
                'contain' => [
                    'Alunos',
                    'Instituicoes',
                    'Supervisores',
                    'Professores',
                    'Turmaestagios',
                    'Respostas',
                    'Folhadeatividades' => [
                        'sort' => ['dia' => 'desc'],
                    ],
                ],
                'order' => [
                    'Estagiarios.periodo' => 'ASC',
                    'Estagiarios.nivel' => 'ASC',
                    'Alunos.nome' => 'ASC',
                ],
            ]);
        } catch (RecordNotFoundException $e) {
            $this->Flash->error(__('Estagiário não encontrado.'));

            return $this->redirect(['action' => 'index']);
        }

        try {
            $this->Authorization->authorize($estagiario);
        } catch (ForbiddenException $e) {
            $this->Flash->error(__('Acesso negado. Você não tem permissão para acessar esta página.'));

            return $this->redirect(['action' => 'index']);
        }

        $resposta = $this->fetchTable('Respostas')->find()
            ->where(['Respostas.estagiario_id' => $estagiario->id])
            ->first();

        $avaliacoes = [];

        if ($resposta) {
            $respostas = json_decode($resposta->response, true);
            foreach ($respostas as $key => $value) {
                if (substr($key, 0, 9) == 'avaliacao') {
                    $pergunta_id = (int)substr($key, 9); // Removed ,2 to allow more digits if needed
                    try {
                        $pergunta = $this->fetchTable('Questiones')->get(intval($pergunta_id));
                        if (in_array($pergunta->type, ['select', 'radio', 'checkbox', 'boolean'])) {
                            $opcoes = json_decode($pergunta->options, true);
                            foreach ($opcoes as $option_key => $option_value) {
                                if ($option_key == $value) {
                                    $avaliacoes[$pergunta->text] = $option_value;
                                }
                            }
                        } else {
                            $avaliacoes[$pergunta->text] = $value;
                        }
                    } catch (Exception $e) {
                        // Ignore missing questions
                    }
                }
            }
        }

        $this->set(compact('estagiario', 'avaliacoes'));
    }

    /**
     * Add method
     *
     * @param string|null $id ID (not used appropriately in signature, uses query param)
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add(?string $id = null)
    {
        $estagiario = $this->Estagiarios->newEmptyEntity();
        try {
            $this->Authorization->authorize($estagiario);
        } catch (ForbiddenException $e) {
            $this->Flash->error(__('Acesso negado. Você não tem permissão para acessar esta página.'));

            return $this->redirect(['action' => 'index']);
        }

        if ($this->request->is(['patch', 'post', 'put'])) {
            $estagiario = $this->Estagiarios->patchEntity(
                $estagiario,
                $this->request->getData(),
            );
            if ($this->Estagiarios->save($estagiario)) {
                $this->Flash->success(__('Registro de estagiario inserido.'));

                return $this->redirect(['action' => 'view', $estagiario->id]);
            }
            $this->Flash->error(
                __('Registro de estagiário não foi inserido. Tente novamente.'),
            );
        }

        $aluno_id = $this->getRequest()->getQuery('aluno_id');

        if ($aluno_id) {
            $ultimo_estagio = $this->Estagiarios
                ->find()
                ->where(['aluno_id' => $aluno_id])
                ->order(['nivel' => 'desc'])
                ->first();

            if ($ultimo_estagio) {
                $this->Flash->success(
                    __(
                        'O aluno é estagiário ' .
                        $ultimo_estagio->nivel .
                        ' no periodo ' .
                        $ultimo_estagio->periodo,
                    ),
                );
                $nivel = $ultimo_estagio->nivel + 1;
                $ajuste2020 = $ultimo_estagio->ajuste2020;

                // Logic from original
                if ($ajuste2020 == 1) {
                    if ($nivel > 3) {
                        $nivel = 9;
                    }
                } elseif ($ajuste2020 == 0) {
                    if ($nivel > 4) {
                        $nivel = 9;
                    }
                }

                $periodo_config = $this->fetchTable('Configuracoes')
                    ->find()
                    ->select(['mural_periodo_atual'])
                    ->first();

                // Check period validity
                if ($ultimo_estagio->periodo >= $periodo_config->mural_periodo_atual) {
                    $this->Flash->error(
                        __(
                            'O período de estágio do aluno tem que ser igual o maior que o período atual ' . $periodo_config->mural_periodo_atual,
                        ),
                    );

                    return $this->redirect([
                       'controller' => 'Estagiarios',
                       'action' => 'view',
                       $ultimo_estagio->id,
                    ]);
                }

                $this->set('nivel', $nivel);
            } else {
                $this->Flash->success(__('O aluno não é estagiário'));
                $this->set('nivel', 1);
            }

            $aluno = $this->fetchTable('Alunos')
                ->get($aluno_id);
            $this->set('aluno', $aluno);
        } else {
            if (isset($this->user) && $this->user->categoria == '2') {
                try {
                    $aluno = $this->fetchTable('Alunos')->get($this->user->aluno_id);
                    $this->set('aluno', $aluno);
                } catch (RecordNotFoundException $e) {
                    $this->Flash->error(__('Aluno não encontrado.'));

                    return $this->redirect(['action' => 'index']);
                }
            } else {
                $this->Flash->error(__('Selecionar o aluno para o estágio.'));

                return $this->redirect(['action' => 'index']);
            }
             $alunos = $this->fetchTable('Alunos')->find('list', ['order' => ['nome' => 'asc']]);
             $this->set('alunos', $alunos);
        }

        $periodo = $this->fetchTable('Configuracoes')
            ->find()
            ->select(['mural_periodo_atual'])
            ->first();
        $this->set('periodo', $periodo->mural_periodo_atual);

        $instituicoes = $this->fetchTable('Instituicoes')->find('list', ['order' => ['instituicao' => 'asc']]);
        $supervisores = $this->fetchTable('Supervisores')->find('list', ['order' => ['nome' => 'asc']]);
        $professores = $this->fetchTable('Professores')->find('list', ['order' => ['nome' => 'asc']]);
        $turmaestagios = $this->fetchTable('Turmaestagios')->find('list', ['order' => ['area' => 'asc']]);

        $this->set(
            compact(
                'estagiario',
                'ultimo_estagio',
                'instituicoes',
                'supervisores',
                'professores',
                'turmaestagios',
            ),
        );
    }

    /**
     * Novotermocompromisso method
     *
     * @param string|null $id Estagiario id.
     * @return \Cake\Http\Response|null|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function novotermocompromisso(?string $id = null)
    {

        $this->Authorization->skipAuthorization();
        $aluno_id = $this->getRequest()->getQuery('aluno_id');

        if (empty($aluno_id)) {
            if (isset($this->user) && $this->user->categoria == '2') {
                $aluno_id = $this->user->aluno_id;
            }
        }

        if ($aluno_id === null) {
            $this->Flash->error(__('Selecionar o aluno para o termo de compromisso'));

            return $this->redirect(['controller' => 'Alunos', 'action' => 'index']);
        }

        $estagiario = $this->Estagiarios
            ->find()
            ->where(['aluno_id' => $aluno_id])
            ->order(['nivel' => 'desc'])
            ->first();

        try {
            $this->Authorization->authorize($estagiario);
        } catch (ForbiddenException $e) {
            $this->Flash->error(__('Acesso negado. Você não tem permissão para acessar esta página.'));

            return $this->redirect(['action' => 'index']);
        }

        if ($estagiario) {
            $config = $this->fetchTable('Configuracoes')
                ->find()
                ->select('mural_periodo_atual')
                ->first();
            $periodoatual = $config->mural_periodo_atual;

            if ($estagiario->periodo == $periodoatual) {
                return $this->redirect([
                    'action' => 'edit',
                    $estagiario->id,
                ]);
            } else {
                return $this->redirect([
                    'action' => 'add',
                    '?' => ['aluno_id' => $aluno_id],
                ]);
            }
        } else {
            $this->Flash->success(__('O aluno ainda não é estagiário'));

            return $this->redirect([
                'action' => 'add',
                '?' => ['aluno_id' => $aluno_id],
            ]);
        }
    }

    /**
     * Termodecompromissopdf method
     *
     * @param string|null $id Estagiario id.
     * @return \Cake\Http\Response|null|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function termodecompromissopdf(?string $id = null)
    {
        $this->Authorization->skipAuthorization();
        if ($id === null) {
            throw new NotFoundException(__('Sem parâmetros para localizar o estagiário'));
        }

        try {
            $estagiario = $this->Estagiarios->get($id, [
                'contain' => ['Alunos', 'Supervisores', 'Instituicoes'],
            ]);
        } catch (RecordNotFoundException $e) {
            $this->Flash->error(__('Estagiário não encontrado.'));

            return $this->redirect(['action' => 'index']);
        }

        $configuracao = $this->fetchTable('Configuracoes')
            ->find()
            ->where(['Configuracoes.id' => 1])
            ->first();

        $this->viewBuilder()->enableAutoLayout(false);
        $this->viewBuilder()->setClassName('CakePdf.Pdf');
        $this->viewBuilder()->setOption('pdfConfig', [
            'orientation' => 'portrait',
            'download' => true,
            'filename' => 'termo_de_compromisso_' . $id . '.pdf',
        ]);
        $this->set('configuracao', $configuracao);
        $this->set('estagiario', $estagiario);
    }

    /**
     * Declaracaodeestagiopdf method
     *
     * @param string|null $id Estagiario id.
     * @return \Cake\Http\Response|null|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function declaracaodeestagiopdf(?string $id = null)
    {
        $this->Authorization->skipAuthorization();
        try {
            $estagiario = $this->Estagiarios->get($id, [
                'contain' => ['Alunos', 'Supervisores', 'Instituicoes'],
            ]);
        } catch (Exception $e) {
            $this->Flash->error(__('Sem estagio cadastrado.'));

            return $this->redirect(['action' => 'index']);
        }

        try {
            $this->Authorization->authorize($estagiario);
        } catch (ForbiddenException $e) {
            $this->Flash->error(__('Acesso negado. Você não tem permissão para acessar esta página.'));

            return $this->redirect(['action' => 'index']);
        }

        // Validations
        if (empty($estagiario->aluno->identidade)) {
            $this->Flash->error(__('Estudante sem RG'));

            return $this->redirect(['controller' => 'Alunos', 'action' => 'view', $estagiario->aluno->id]);
        }
        if (empty($estagiario->aluno->orgao)) {
            $this->Flash->error(__('Estudante não especifica o orgão emisor do documento'));

            return $this->redirect(['controller' => 'Alunos', 'action' => 'view', $estagiario->aluno->id]);
        }
        if (empty($estagiario->aluno->cpf)) {
            $this->Flash->error(__('Estudante sem CPF'));

            return $this->redirect(['controller' => 'Alunos', 'action' => 'view', $estagiario->aluno->id]);
        }
        if ($estagiario->supervisor_id === null) {
            $this->Flash->error(__('Falta o supervisor de estágio'));

            return $this->redirect(['action' => 'view', $estagiario->id]);
        }

        $this->viewBuilder()->enableAutoLayout(false);
        $this->viewBuilder()->setClassName('CakePdf.Pdf');
        $this->viewBuilder()->setOption('pdfConfig', [
            'orientation' => 'portrait',
            'download' => true,
            'filename' => 'declaracao_de_estagio_' . $id . '.pdf',
        ]);
        $this->set('estagiario', $estagiario);
    }

    /**
     * Folhadeatividadespdf method
     *
     * @param string|null $id Estagiario id.
     * @return \Cake\Http\Response|null|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function folhadeatividadespdf(?string $id = null) // ID param seems unused in original, uses query param
    {
        $this->Authorization->skipAuthorization();
        $estagiario_id = $this->getRequest()->getQuery('estagiario_id');

        if (!$estagiario_id) {
             // Fallback if ID is passed
            if ($id) {
                $estagiario_id = $id;
            } else {
                $this->Flash->error(__('Sem estagiario cadastrado'));

                return $this->redirect(['action' => 'index']);
            }
        }

        try {
            $estagiario = $this->Estagiarios->get($estagiario_id, [
                'contain' => ['Alunos', 'Supervisores', 'Instituicoes', 'Professores'],
            ]);
        } catch (Exception $e) {
             $this->Flash->error(__('Estagiário não encontrado.'));

             return $this->redirect(['action' => 'index']);
        }

        $this->viewBuilder()->enableAutoLayout(false);
        $this->viewBuilder()->setClassName('CakePdf.Pdf');
        $this->viewBuilder()->setOption('pdfConfig', [
            'orientation' => 'portrait',
            'download' => true,
            'filename' => 'folha_de_atividades_' . $estagiario_id . '.pdf',
        ]);
        $this->set('estagiario', $estagiario);
    }

    /**
     * Edit method
     *
     * @param string|null $id Estagiario id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit(?string $id = null)
    {
        // Support AJAX POST with id in request body
        if ($id === null && $this->request->is(['post', 'put', 'patch'])) {
            $id = $this->request->getData('id');
        }

        if ($id === null) {
            $this->Flash->error(__('Sem parâmetro para localizar o estagiário.'));

            return $this->redirect(['action' => 'index']);
        }

        try {
            $estagiario = $this->Estagiarios->get($id, [
                'contain' => ['Alunos', 'Instituicoes', 'Professores', 'Supervisores', 'Turmaestagios'],
            ]);
        } catch (RecordNotFoundException $e) {
            $this->Flash->error(__('Estagiário não encontrado.'));

            return $this->redirect(['action' => 'index']);
        }

        $user = $this->Authentication->getIdentity();
        if ($user && $user->categoria == '3' && $estagiario->professor_id != $user->professor_id) {
            $this->Flash->error(__('Acesso negado. Você não tem permissão para editar este estagiário.'));

            return $this->redirect(['action' => 'index']);
        }

        try {
            $this->Authorization->authorize($estagiario);
        } catch (ForbiddenException $e) {
            $this->Flash->error(__('Acesso negado. Você não tem permissão para acessar esta página.'));

            return $this->redirect(['action' => 'index']);
        }

        if ($this->request->is(['patch', 'post', 'put'])) {
            $estagiario = $this->Estagiarios->patchEntity(
                $estagiario,
                $this->request->getData(),
            );
            if ($this->Estagiarios->save($estagiario)) {
                if ($this->request->is('ajax')) {
                    return $this->response->withType('application/json')
                        ->withStringBody(json_encode(['status' => 'success', 'data' => $estagiario]));
                }
                $this->Flash->success(__('Registro de estagiario atualizado.'));

                return $this->redirect(['action' => 'view', $id]);
            }

            if ($this->request->is('ajax')) {
                 return $this->response->withStatus(400)
                    ->withType('application/json')
                    ->withStringBody(json_encode(['status' => 'error', 'errors' => $estagiario->getErrors()]));
            }

            $this->Flash->error(
                __('Registro de estagiário não foi atualizado. Tente novamente.'),
            );
        }

        // Logic for Supervisors list based on Institution
        $supervisores = [];
        if ($estagiario->instituicao_id) {
            $instituicao = $this->fetchTable('Instituicoes')
                ->find()
                ->contain(['Supervisores'])
                ->where(['Instituicoes.id' => $estagiario->instituicao_id])
                ->first();

            if ($instituicao && !empty($instituicao->supervisores)) {
                foreach ($instituicao->supervisores as $supervisor) {
                    $supervisores[$supervisor->id] = $supervisor->nome;
                }
                asort($supervisores);
            }
        }

        $alunos = $this->fetchTable('Alunos')->find('list', ['order' => ['nome' => 'asc']]);
        $instituicoes = $this->fetchTable('Instituicoes')->find('list', ['order' => ['instituicao' => 'asc']]);
        $professores = $this->fetchTable('Professores')->find('list', ['order' => ['nome' => 'asc']]);
        $turmaestagios = $this->fetchTable('Turmaestagios')->find('list', ['order' => ['area' => 'asc']]);

        $this->set(
            compact(
                'estagiario',
                'alunos',
                'instituicoes',
                'professores',
                'turmaestagios',
                'supervisores',
            ),
        );
    }

    /**
     * Delete method
     *
     * @param string|null $id Estagiario id.
     * @return \Cake\Http\Response|null|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete(?string $id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        try {
            $estagiario = $this->Estagiarios->get($id);
        } catch (RecordNotFoundException $e) {
             $this->Flash->error(__('Registro não encontrado.'));

             return $this->redirect(['action' => 'index']);
        }

        try {
            $this->Authorization->authorize($estagiario);
        } catch (ForbiddenException $e) {
            $this->Flash->error(__('Acesso negado. Você não tem permissão para acessar esta página.'));

            return $this->redirect(['action' => 'index']);
        }

        if ($this->Estagiarios->delete($estagiario)) {
            $this->Flash->success(__('Registro de estagiário excluído.'));
        } else {
            $this->Flash->error(__('Registro de estagiário não excluído.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
