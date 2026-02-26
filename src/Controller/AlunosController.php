<?php
declare(strict_types=1);

namespace App\Controller;

use Authorization\Exception\ForbiddenException;
use Cake\Datasource\Exception\RecordNotFoundException;
use Cake\Event\EventInterface;
use Cake\I18n\Date;

/**
 * Alunos Controller
 *
 * @property \App\Model\Table\AlunosTable $Alunos
 * @property \Authorization\Controller\Component\AuthorizationComponent $Authorization
 * @property \Authentication\Controller\Component\AuthenticationComponent $Authentication
 * @property \Cake\ORM\Table $Estagiarios
 * @property \Cake\ORM\Table $Instituicoes
 * @property \Cake\ORM\Table $Supervisores
 * @property \Cake\ORM\Table $Professores
 * @method \App\Model\Entity\Aluno[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class AlunosController extends AppController
{
    /**
     * initialize method
     *
     * @return void
     */
    public function initialize(): void
    {
        /** @phpstan-ignore-next-line */
        parent::initialize();
    }

    public function beforeFilter(EventInterface $event)
    {
        parent::beforeFilter($event);
    }

    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {

        try {
            $this->Authorization->authorize($this->Alunos);
        } catch (ForbiddenException $e) {
            $this->Flash->error(__('Acesso não autorizado.'));

            return $this->redirect(['controller' => 'Muralestagios', 'action' => 'index']);
        }

        $query = $this->Alunos->find();
        if ($query->count() === 0) {
            $this->Flash->error(__('Nenhum aluno encontrado.'));

            return $this->redirect([
                'controller' => 'Alunos',
                'action' => 'add',
            ]);
        }
        if ($this->request->getQuery('sort') === null) {
            $query->order(['nome' => 'ASC']);
        }

        $alunos = $this->paginate($query, [
            'sortableFields' => ['nome', 'registro', 'nascimento', 'ingresso'],
        ]);

        $this->set('alunos', $alunos);
    }

    /**
     * View method
     *
     * @param string|null $id Aluno id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view(?string $id = null)
    {
        $this->Authorization->skipAuthorization();
        if ($this->user && $this->user->categoria == 2) {
            // After the add of a student, the user is redirected to the view of the student he registered. But the user still not have the aluno_id.
            $usercadastrado = $this->fetchTable('Users')->get($this->user->id);
            $this->set('user', $usercadastrado);
            $id = $usercadastrado->aluno_id;
        }

        if ($id === null) {
            $this->Flash->error(__('Aluno não encontrado.'));

            return $this->redirect(['controller' => 'Muralestagios', 'action' => 'index']);
        }

        $aluno = $this->Alunos
            ->find()
            ->contain([
                'Estagiarios' => [
                    'Instituicoes',
                    'Alunos',
                    'Supervisores',
                    'Professores',
                    'Turmaestagios',
                ],
                'Muralinscricoes' => ['Muralestagios'],
            ])
            ->where(['Alunos.id' => $id])
            ->first();

        try {
            $this->Authorization->authorize($aluno);
        } catch (ForbiddenException $e) {
            $this->Flash->error(__('Acesso não autorizado.'));

            return $this->redirect(['controller' => 'Muralestagios', 'action' => 'index']);
        }

        if (empty($aluno)) {
            $this->Flash->error(__('Aluno não encontrado'));

            return $this->redirect(['action' => 'index']);
        }

        try {
            $this->set(compact('aluno'));
        } catch (ForbiddenException $e) {
            $this->Flash->error(__('Acesso não autorizado.'));

            return $this->redirect(['action' => 'index']);
        }
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $dre = $this->getRequest()->getQuery('dre');
        $email = $this->getRequest()->getQuery('email');

        if ($dre && $email) {
            $aluno = $this->Alunos->find()
                ->where([
                    'registro' => $dre,
                    'email' => $email,
                ])
                ->first();
            if ($aluno) {
                $this->Flash->error(__('DRE ou Email já cadastrado.'));

                return $this->redirect(['action' => 'view', $aluno->id]);
            }
        }

        $aluno = $this->Alunos->newEmptyEntity();

        try {
            $this->Authorization->authorize($aluno);
        } catch (ForbiddenException $e) {
            $this->Flash->error(__('Acesso não autorizado.'));

            return $this->redirect([
                'controller' => 'Alunos',
                'action' => 'index',
            ]);
        }

        if ($this->request->is(['post', 'put', 'patch'])) {
            $data = $this->request->getData();
            if (empty($data['registro']) || empty($data['email'])) {
                $this->Flash->error(__('DRE e Email são obrigatórios.'));

                return $this->redirect([
                    'controller' => 'Users',
                    'action' => 'login',
                ]);
            }

            $registro = $this->Alunos
                ->find()
                ->where(['registro' => $data['registro']])
                ->first();

            if ($registro) {
                $this->Flash->error(__('DRE já cadastrado.'));

                return $this->redirect(['action' => 'view', $registro->id]);
            }

            $emailCheck = $this->Alunos
                ->find()
                ->where(['email' => $data['email']])
                ->first();
            if ($emailCheck) {
                $this->Flash->error(__('Email já cadastrado.'));

                return $this->redirect(['action' => 'view', $emailCheck->id]);
            }

            $dataObjeto = Date::parse($data['nascimento']);
            if ($dataObjeto) {
                $data['nascimento'] = $dataObjeto->i18nFormat('yyyy-MM-dd');
            }

            $aluno = $this->Alunos->patchEntity($aluno, $data);
            if ($this->Alunos->save($aluno)) {
                $this->Flash->success(__('Dados do aluno inseridos.'));
                // Store the aluno_id in the Users table if the user is a student
                $user = $this->fetchTable('Users')->get($this->user->id);
                if ($this->user && $this->user->categoria == 2 && $this->user->aluno_id == null) {
                    $user->aluno_id = $aluno->id;
                    $this->fetchTable('Users')->save($user);
                }

                return $this->redirect(['action' => 'view', $aluno->id]);
            }
            $this->Flash->error(__('Dados do aluno não inseridos.'));
        }

        if (!empty($dre) && !empty($email)) {
            $this->set('dre', $dre);
            $this->set('email', $email);
        }
        $this->set(compact('aluno'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Aluno id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit(?string $id = null)
    {
        try {
            $aluno = $this->Alunos->get($id, [
                'contain' => [],
            ]);
        } catch (RecordNotFoundException $e) {
            $this->Flash->error(__('Aluno não encontrado'));

            return $this->redirect(['action' => 'index']);
        }

        try {
            $this->Authorization->authorize($aluno);
        } catch (ForbiddenException $e) {
            $this->Flash->error(__('Acesso não autorizado.'));

            return $this->redirect(['controller' => 'Muralestagios', 'action' => 'index']);
        }

        if ($this->request->is(['patch', 'post', 'put'])) {
            $data = $this->request->getData();
            $dataObjeto = Date::parse($data['nascimento']);
            if ($dataObjeto) {
                $data['nascimento'] = $dataObjeto->i18nFormat('yyyy-MM-dd');
            }

            $aluno = $this->Alunos->patchEntity($aluno, $data);
            if ($this->Alunos->save($aluno)) {
                $this->Flash->success(__('Dados do aluno atualizados.'));

                return $this->redirect(['action' => 'view', $aluno->id]);
            }
            $this->Flash->error(__('Dados do aluno não atualizados.'));
        }

        $this->set(compact('aluno'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Aluno id.
     * @return \Cake\Http\Response|null|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete(?string $id = null)
    {
        $this->request->allowMethod(['post', 'delete']);

        try {
            $aluno = $this->Alunos->get($id);
        } catch (RecordNotFoundException $e) {
            $this->Flash->error(__('Aluno não encontrado'));

            return $this->redirect(['action' => 'index']);
        }

        try {
            $this->Authorization->authorize($aluno);
        } catch (ForbiddenException $e) {
            $this->Flash->error(__('Acesso não autorizado.'));

            return $this->redirect(['controller' => 'Muralestagios', 'action' => 'index']);
        }

        $estagiarios = $this->Alunos->Estagiarios
            ->find()
            ->where(['Estagiarios.aluno_id' => $id])
            ->first();

        if ($estagiarios) {
            $this->Flash->error(
                __('Aluno possui estagiários, não pode ser excluído.'),
            );

            return $this->redirect(['action' => 'view', $id]);
        }

        // Users must be deleted before the student
        $user = $this->Alunos->Users
            ->find()
            ->where(['Users.aluno_id' => $id])
            ->first();
        if ($user) {
            $this->Alunos->Users->delete($user);
        }

        if ($this->Alunos->delete($aluno)) {
            $this->Flash->success(__('Dados do aluno excluídos.'));

            return $this->redirect(['action' => 'index']);
        } else {
            $this->Flash->error(__('Dados do aluno não excluídos.'));

            return $this->redirect(['action' => 'view', $id]);
        }
    }

    /**
     * Carga Horária
     *
     * @param string|null $ordem Ordem.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     */
    public function cargahoraria(?string $ordem = null)
    {
        $this->Authorization->skipAuthorization();

        ini_set('memory_limit', '2048M');
        $ordem = $this->request->getQuery('ordem');

        if (empty($ordem)) {
             $ordem = 'q_semestres';
        }

        $alunos = $this->Alunos
            ->find()
            ->contain(['Estagiarios'])
            ->limit(20) // Original had limit 20
            ->toArray();

        // Logic copied from original...
        if (empty($alunos)) {
            $this->Flash->error(__('Nenhum aluno encontrado.'));

            return $this->redirect(['action' => 'index']);
        } else {
            $criterio = [];
            $cargahorariatotal = [];
            $i = 0;
            foreach ($alunos as $aluno) {
                $cargahorariatotal[$i]['id'] = $aluno->id;
                $cargahorariatotal[$i]['registro'] = $aluno->registro;
                $cargahorariatotal[$i]['nome'] = $aluno->nome; // Added name for sorting by name
                $cargahorariatotal[$i]['q_semestres'] = count($aluno->estagiarios);

                $carga_estagio_ch = 0;
                $y = 0;
                foreach ($aluno->estagiarios as $estagiario) {
                    $cargahorariatotal[$i][$y]['ch'] = $estagiario->ch;
                    $cargahorariatotal[$i][$y]['nivel'] = $estagiario->nivel;
                    $cargahorariatotal[$i][$y]['periodo'] = $estagiario->periodo;
                    $carga_estagio_ch += $estagiario->ch;
                    $y++;
                }
                $cargahorariatotal[$i]['ch_total'] = $carga_estagio_ch;

                if (isset($cargahorariatotal[$i][$ordem])) {
                     $criterio[$i] = $cargahorariatotal[$i][$ordem];
                } else {
                     $criterio[$i] = null;
                }

                $i++;
            }

            if (!empty($criterio)) {
                array_multisort($criterio, SORT_ASC, $cargahorariatotal);
            }
            $this->set('cargahorariatotal', $cargahorariatotal);
        }
    }

    /**
     * Gera a declaração de período do aluno.
     *
     * @param string|null $id
     * @return void
     */
    public function declaracaoperiodo(?string $id = null)
    {
        $this->Authorization->skipAuthorization();

        if ($id == null) {
            $this->Flash->error(__("Operação não pode ser realizada porque o 'id' não foi informado."));

            return $this->redirect(['action' => 'index']);
        }

        $aluno = $this->Alunos
            ->find()
            ->where(['Alunos.id' => $id])
            ->first();

        try {
            $this->Authorization->authorize($aluno);
        } catch (ForbiddenException $e) {
            $this->Flash->error(__('Acesso não autorizado.'));

            return $this->redirect(['controller' => 'Muralestagios', 'action' => 'index']);
        }

        if ($this->request->is(['post', 'put'])) {
            $data = $this->request->getData();
            $periodoacademicoatual = $this->fetchTable('Configuracoes')
                ->find()
                ->select(['periodo_calendario_academico'])
                ->first();

            $periodo_atual = $periodoacademicoatual->periodo_calendario_academico;
            $novoperiodo = $data['novoperiodo'] ?? null;
            $periodo_inicial = $novoperiodo ?? $aluno->ingresso;

            $inicial = explode('-', $periodo_inicial);
            $atual = explode('-', $periodo_atual);

            $semestres = ($atual[0] - $inicial[0] + 1) * 2;

            $totalperiodos = 0;
            if (count($inicial) < 2) {
                $this->Flash->error(__('Período de ingresso incompleto: falta indicar se for no 1° ou 2° semestre'));
                $totalperiodos = $semestres;
            } elseif ($inicial[1] == 1 && $atual[1] == 2) {
                $totalperiodos = $semestres;
            } elseif ($inicial[1] == 1 && $atual[1] == 1) {
                $totalperiodos = $semestres - 1;
            } elseif ($inicial[1] == 2 && $atual[1] == 2) {
                $totalperiodos = $semestres - 1;
            } elseif ($inicial[1] == 2 && $atual[1] == 1) {
                $totalperiodos = $semestres - 2;
            }

            if ($totalperiodos <= 0) {
                $this->Flash->error(__('Error: período inicial é maior que período atual'));
            }
        }
        $this->set('aluno', $aluno);
    }

    /**
     * Gera o certificado de período do aluno.
     *
     * @param string|null $id
     * @return void
     */
    public function certificadoperiodo(?string $id = null)
    {
        $this->Authorization->skipAuthorization();

        $totalperiodos = $this->request->getQuery('totalperiodos');
        $novoperiodo = $this->request->getQuery('novoperiodo');

        if ($this->user && $this->user->categoria == 2) {
            $id = $this->user->aluno_id;
        }

        if ($id == null) {
            $this->Flash->error(__("Operação não pode ser realizada porque o 'id' não foi informado."));

            return $this->redirect(['action' => 'index']);
        }

        $aluno = $this->Alunos->get($id);

        try {
            $this->Authorization->authorize($aluno);
        } catch (ForbiddenException $e) {
            $this->Flash->error(__('Acesso não autorizado.'));

            return $this->redirect(['controller' => 'Muralestagios', 'action' => 'index']);
        }

        // Logic for incomplete ingresso
        if (strlen($aluno->ingresso) < 6) {
             $this->Flash->error(__('Período de ingresso incompleto.'));

             return $this->redirect(['action' => 'view', $id]);
        }

        $configuracoes = $this->fetchTable('Configuracoes')->find()->first();
        $periodo_atual = $configuracoes->periodo_calendario_academico;

        if ($novoperiodo) {
            $periodo_inicial = $novoperiodo;
        } else {
            $periodo_inicial = $aluno->ingresso;
        }

        $inicial = explode('-', $periodo_inicial);
        $atual = explode('-', $periodo_atual);
        $semestres = ($atual[0] - $inicial[0] + 1) * 2;

        $totalperiodos = $semestres; // Simplified fallback
        if ($inicial[1] == 1 && $atual[1] == 2) {
            $totalperiodos = $semestres;
        }
        if ($inicial[1] == 1 && $atual[1] == 1) {
            $totalperiodos = $semestres - 1;
        }
        if ($inicial[1] == 2 && $atual[1] == 2) {
            $totalperiodos = $semestres - 1;
        }
        if ($inicial[1] == 2 && $atual[1] == 1) {
            $totalperiodos = $semestres - 2;
        }

        if ($this->request->is(['post', 'put'])) {
            $data = $this->request->getData();
            $novoperiodo = $data['novoperiodo'] ?? $aluno->ingresso;

            // Recalculate logic...
             return $this->redirect([
                'action' => 'certificadoperiodo',
                $id,
                '?' => ['totalperiodos' => $totalperiodos, 'novoperiodo' => $novoperiodo],
             ]);
        }

        $this->set(compact('aluno', 'totalperiodos', 'novoperiodo'));
    }

    /**
     * Gera o PDF do certificado de período do aluno.
     *
     * @param string|null $id
     * @return void
     */
    public function certificadoperiodopdf(?string $id = null)
    {
        $this->Authorization->skipAuthorization();

        $id = $this->request->getQuery('id');
        $totalperiodos = $this->request->getQuery('totalperiodos');

        if ($this->user && $this->user->categoria == 2) {
            $id = $this->user->aluno_id;
        }

        if ($id === null) {
            $this->Flash->error(__("Operação não pode ser realizada porque o 'id' não foi informado."));

            return $this->redirect(['action' => 'index']);
        }

        $aluno = $this->Alunos->get($id);

        try {
            $this->Authorization->authorize($aluno);
        } catch (ForbiddenException $e) {
            $this->Flash->error(__('Acesso não autorizado.'));

            return $this->redirect(['action' => 'index']);
        }

        $this->viewBuilder()->enableAutoLayout(false);
        $this->viewBuilder()->setClassName('CakePdf.Pdf');
        $this->viewBuilder()->setOption('pdfConfig', [
            'orientation' => 'portrait',
            'download' => true,
            'filename' => 'declaracao_de_periodo_' . $id . '.pdf',
        ]);

        $this->set(compact('aluno', 'totalperiodos'));
    }

    // Ajax methods

    public function buscaestagiario($id = null)
    {
        $this->Authorization->skipAuthorization();
        $this->viewBuilder()->disableAutoLayout();
        $this->request->allowMethod(['ajax', 'post']); // Added post as typical for ajax

        $id = $this->request->getData('id');

        if ($id == null && $this->user && $this->user->categoria == 2) {
            $id = $this->user->aluno_id;
        }

        $estagiario = $this->Alunos->Estagiarios
            ->find()
            ->where(['Estagiarios.aluno_id' => $id])
            ->order(['Estagiarios.nivel' => 'desc'])
            ->first();

        // Return estagiario with calculated level
        if ($estagiario) {
            return $this->response->withType('application/json')
               ->withStringBody(json_encode($estagiario));
        }

        return $this->response->withType('application/json')
            ->withStatus(404)
            ->withStringBody(json_encode(['error' => 'Estagiário não encontrado']));
    }

    // Other Ajax methods follow similar pattern

    public function getaluno($id = null)
    {
        $this->Authorization->skipAuthorization();
        $this->request->allowMethod(['ajax', 'post']);
        $id = $this->request->getData('id');

        return $this->response->withType('application/json')
             ->withStringBody(json_encode(['error' => 'Not implemented fully in migration yet']));
    }

    public function buscaalunoregistro($registro = null)
    {
        $this->Authorization->skipAuthorization();
        $registro = $this->request->getData('registro');
        if ($registro) {
            $aluno = $this->Alunos->find()->where(['registro' => trim($registro)])->first();
            if ($aluno) {
                $this->set('aluno', $aluno);
                $this->render('view');

                return;
            }
        }
         $this->Flash->error(__('Nenhum aluno encontrado'));

         return $this->redirect(['action' => 'index']);
    }

    public function buscaalunonome($nome = null)
    {
        $this->Authorization->skipAuthorization();
        $nome = $this->request->getData('nome');
        if ($nome) {
            $alunos = $this->Alunos->find()->where(['nome LIKE' => "%$nome%"]);
             $this->set('alunos', $this->paginate($alunos));
             $this->render('index');

             return;
        }
         $this->Flash->error(__('Nenhum aluno encontrado'));

         return $this->redirect(['action' => 'index']);
    }

    /**
     * Gera a planilha de CRESS do aluno.
     *
     * @param string|null $id
     * @return void
     */
    public function planilhacress(?string $id = null)
    {
        $this->Authorization->skipAuthorization();

        $periodo = $this->getRequest()->getQuery('periodo');

        $ordem = 'Alunos.nome';

        /* Todos os periódos */
        $periodototal = $this->Alunos->Estagiarios->find('list', [
            'keyField' => 'periodo',
            'valueField' => 'periodo',
            'order' => 'periodo',
        ]);
        $periodos = $periodototal->toArray();
        /* Se o periodo não veio anexo como parametro então o período é o último da lista dos períodos */
        if (empty($periodo)) {
            $periodo = end($periodos);
        }

        $cress = $this->Alunos->Estagiarios->find()
                ->contain(['Alunos', 'Instituicoes', 'Supervisores', 'Professores'])
                ->select(['Estagiarios.periodo', 'Alunos.id', 'Alunos.nome', 'Instituicoes.id', 'Instituicoes.instituicao', 'Instituicoes.cep', 'Instituicoes.endereco', 'Instituicoes.bairro', 'Supervisores.nome', 'Supervisores.cress', 'Professores.nome'])
                ->where(['Estagiarios.periodo' => $periodo])
                ->order(['Alunos.nome'])
                ->all();

        $this->set('cress', $cress);
        $this->set('periodos', $periodos);
        $this->set('periodoselecionado', $periodo);
    }

    /**
     * Gera a planilha de seguro do aluno.
     *
     * @param string|null $id
     * @return void
     */
    public function planilhaseguro(?string $id = null)
    {

        $this->Authorization->skipAuthorization();

        $periodo = $this->getRequest()->getQuery('periodo');

        $ordem = 'nome';

        $periodototal = $this->Alunos->Estagiarios->find('list', [
            'keyField' => 'periodo',
            'valueField' => 'periodo',
            'order' => 'periodo',
        ]);
        $periodos = $periodototal->toArray();

        if (empty($periodo)) {
            $periodo = end($periodos);
        }

        $seguro = $this->Alunos->Estagiarios->find()
                ->contain(['Alunos', 'Instituicoes'])
                ->where(['Estagiarios.periodo' => $periodo])
                ->select([
                    'Alunos.id',
                    'Alunos.nome',
                    'Alunos.cpf',
                    'Alunos.nascimento',
                    'Alunos.registro',
                    'Estagiarios.nivel',
                    'Estagiarios.periodo',
                    'Instituicoes.instituicao',
                    'Estagiarios.ajuste2020',
                ])
                ->order(['Estagiarios.nivel'])
                ->all();

        $i = 0;
        // Calcula o inicio e o final do estagio para 4 periodos de 6 meses a partir do periodo selecionado
        /*
        One strategy is to calculate the start and them the end dates of the internship for 4 periods of 6 months or 3 periods of 6 months from the selected period.
        If the semestre of the inicial period (nivel 1) is 1, then when ajuste 2020 is 0 then the end period is (ano + 1 e semestre = 2 or when ajuste2020 is 1 then the end period is ano + 1 e semestre = 1).
        If the semestre of the inicial period (nivel 1) is 2, then when ajuste2020 is 0 then the end period is (ano + 2 e semestre = 1 or when ajuste2020 is 1 then the end period is ano + 1 e semestre = 2).
        */
        $t_seguro = [];
        $criterio = [];
        $inicio = null;
        $final = null;
        foreach ($seguro as $c_seguro) {
            $ajuste2020 = $c_seguro->ajuste2020;
            // Calcula o inicio do estágio
            $periodo_parts = explode('-', $c_seguro->periodo);
            $ano = (int)$periodo_parts[0];
            $semestre_num = (int)$periodo_parts[1];
            switch ($c_seguro->nivel) {
                case 1:
                    $inicio_ano = $ano;
                    $inicio_semestre = $semestre_num;
                    break;
                case 2: // retrocede 1 semestre
                    // Ex. 2024-1 -> 2023-2
                    if ($semestre_num == 1) {
                        $inicio_ano = $ano - 1;
                        $inicio_semestre = 2;
                        // Ex. 2024-2 -> 2024-1
                    } else { // $semestre_num == 2
                        $inicio_ano = $ano;
                        $inicio_semestre = 1;
                    }
                    break;
                case 3: // retrocede 2 semestres
                    // Ex. 2024-1 -> 2023-1
                    if ($semestre_num == 1) {
                        $inicio_ano = $ano - 1;
                        $inicio_semestre = 1;
                        // Ex. 2024-2 -> 2023-2
                    } else { // $semestre_num == 2
                        $inicio_ano = $ano - 1;
                        $inicio_semestre = 2;
                    }
                    break;
                case 4: // retrocede 3 semestres
                    // Ex. 2010-1 -> 2008-2
                    if ($semestre_num == 1) {
                        $inicio_ano = $ano - 2;
                        $inicio_semestre = 2;
                        // Ex. 2010-2 -> 2009-1
                    } else { // $semestre_num == 2
                        $inicio_ano = $ano - 1;
                        $inicio_semestre = 1;
                    }
                    break;
                case 9: // retrocede 4 ou 5 semestres em função do ajuste2020
                    if ($ajuste2020 == 1) { // retrocede 4 semestres
                        if ($semestre_num == 1) { // Ex. 2024-1 -> 2022-2
                            $inicio_ano = $ano - 2;
                            $inicio_semestre = 2;
                        } else { // $semestre_num == 2, Ex. 2024-2 -> 2023-1
                            $inicio_ano = $ano - 1;
                            $inicio_semestre = 1;
                        }
                    } else { // $ajuste2020 == 0, retrocede 5 semestres
                        if ($semestre_num == 1) { // Ex. 2024-1 -> 2022-1
                            $inicio_ano = $ano - 2;
                            $inicio_semestre = 1;
                        } else { // $semestre_num == 2, Ex. 2024-2 -> 2022-2
                            $inicio_ano = $ano - 2;
                            $inicio_semestre = 2;
                        }
                    }
                    break;
                default:
                    $inicio_ano = $ano;
                    $inicio_semestre = $semestre_num;
                    break;
            }
            $inicio = $inicio_ano . '-' . $inicio_semestre;

            // Calcula o final do estágio: $inicio + 2 ou 3 semestres dependendo do ajuste2020
            // Números $inicio_ano e $inicio_semestre são os valores do inicio do estágio
            switch ($ajuste2020) {
                case 0: // 4 semestres
                    // Ex. 2024-1 -> 2025-2
                    if ($inicio_semestre == 1) {
                        $final = ($inicio_ano + 1) . '-' . 2;
                        // Ex. 2024-2 -> 2026-1
                    } else { // $inicio_semestre == 2
                        $final = ($inicio_ano + 2) . '-' . 1;
                    }
                    break;
                case 1: // 3 semestres
                    // Ex. 2024-1 -> 2025-1
                    if ($inicio_semestre == 1) {
                        $final = ($inicio_ano + 1) . '-' . 1;
                        // Ex. 2024-2 -> 2025-2
                    } else { // $inicio_semestre == 2
                        $final = ($inicio_ano + 1) . '-' . 2;
                    }
                    break;
                default:
                    $final = $inicio;
                    break;
            }

            if ($c_seguro->hasValue('aluno')) {
                $t_seguro[$i]['id'] = $c_seguro->aluno->id;
                $t_seguro[$i]['nome'] = $c_seguro->aluno->nome ?: 's/d';
                $t_seguro[$i]['cpf'] = $c_seguro->aluno->cpf ?: 's/d';
                // Nascimento is a date field. Format it as 'd/m/Y' if it has a value, otherwise use 's/d'.
                $t_seguro[$i]['nascimento'] = $c_seguro->aluno->nascimento ? $c_seguro->aluno->nascimento->i18nFormat('dd/MM/yyyy') : 's/d';
                $t_seguro[$i]['sexo'] = '';
                $t_seguro[$i]['registro'] = $c_seguro->aluno->registro ?: 's/d';
            } else {
                $t_seguro[$i]['id'] = null;
                $t_seguro[$i]['nome'] = null;
                $t_seguro[$i]['cpf'] = null;
                $t_seguro[$i]['nascimento'] = null;
                $t_seguro[$i]['sexo'] = '';
                $t_seguro[$i]['registro'] = null;
            }
            $t_seguro[$i]['curso'] = 'UFRJ/Serviço Social';
            if ($c_seguro->nivel == 9) :
                $t_seguro[$i]['nivel'] = 'Não obrigatório';
            else :
                $t_seguro[$i]['nivel'] = $c_seguro->nivel;
            endif;
            $t_seguro[$i]['periodo'] = $c_seguro->periodo;
            $t_seguro[$i]['inicio'] = $inicio;
            $t_seguro[$i]['final'] = $final;
            if ($c_seguro->hasValue('instituicao')) {
                $t_seguro[$i]['instituicao'] = $c_seguro->instituicao->instituicao;
            } else {
                $t_seguro[$i]['instituicao'] = null;
            }
            $t_seguro[$i]['ajuste2020'] = $c_seguro->ajuste2020;
            $criterio[$i] = $t_seguro[$i][$ordem] ?? null;

            $i++;
        }

        if (!empty($t_seguro) && !empty($criterio)) {
            array_multisort($criterio, SORT_ASC, $t_seguro);
        }
        $this->set('t_seguro', $t_seguro);
        $this->set('periodos', $periodos);
        $this->set('periodoselecionado', $periodo);
    }
}



