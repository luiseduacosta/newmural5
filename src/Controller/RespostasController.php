<?php
declare(strict_types=1);

namespace App\Controller;

use Authorization\Exception\ForbiddenException;
use Cake\Datasource\Exception\RecordNotFoundException;
use Exception;
use PhpParser\Node\Expr\Cast\Object_;

/**
 * Respostas Controller
 *
 * @property \App\Model\Table\RespostasTable $Respostas
 * @property \Authorization\Controller\Component\AuthorizationComponent $Authorization
 * @property \Authentication\Controller\Component\AuthenticationComponent $Authentication
 * @method \App\Model\Entity\Resposta[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class RespostasController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        try {
            $this->Authorization->authorize($this->Respostas);
        } catch (ForbiddenException $e) {
            $this->Flash->error(__('Acesso negado. Você não tem permissão para acessar esta página.'));

            return $this->redirect(['controller' => 'Muralestagiarios', 'action' => 'index']);
        }

        $query = $this->Respostas->find()
            ->contain(['Estagiarios' => ['Alunos']])
            ->orderBy(['Respostas.id' => 'DESC']);

        $respostas = $this->paginate($query);
        $this->set(compact('respostas'));
    }

    /**
     * View method
     *
     * @param string|null $id Resposta id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view(?string $id = null)
    {
        $this->Authorization->skipAuthorization();
        $resposta = null;
        if ($id === null) {
            $estagiario_id = $this->request->getQuery('estagiario_id');
            if ($estagiario_id) {
                $resposta = $this->Respostas->find()
                    ->contain(['Estagiarios' => ['Alunos', 'Supervisores']])
                    ->where(['Respostas.estagiario_id' => $estagiario_id])
                    ->first();
                if (!$resposta) {
                    $this->Flash->error(__('Nenhuma avaliação encontrada para o estagiário ID {0}.', $estagiario_id));

                    return $this->redirect(['controller' => 'Respostas', 'action' => 'add', '?' => ['estagiario_id' => $estagiario_id]]);
                }
            }
        }

        if (!$resposta) {
            $resposta = $this->Respostas->get($id, [
                        'contain' => ['Estagiarios' => ['Alunos', 'Supervisores']],
            ]);
            if (!$resposta) {
                $this->Flash->error(__('Nenhuma avaliação encontrada para o estagiário ID {0}.', $estagiario_id));

                return $this->redirect(['controller' => 'Respostas', 'action' => 'add', '?' => ['estagiario_id' => $estagiario_id]]);
            }
        }

        try {
            $this->Authorization->authorize($resposta);
        } catch (ForbiddenException $e) {
            $this->Flash->error(__('Acesso negado. Você não tem permissão para acessar esta página.'));

            return $this->redirect(['controller' => 'Muralestagiarios', 'action' => 'index']);
        }
        $respostasData = json_decode($resposta->response, true) ?? [];
        $avaliacoes = [];

        foreach ($respostasData as $key => $value) {
            if (is_array($value) && isset($value['pergunta'])) {
                $avaliacoes[$value['pergunta']] = $value['texto_valor'] ?? $value['valor'];
                continue;
            }

            if (str_starts_with($key, 'avaliacao')) {
                $pergunta_id = (int)substr($key, 9);
                if ($pergunta_id > 0) {
                    try {
                        $pergunta = $this->fetchTable('Questoes')->get($pergunta_id);
                        if (in_array($pergunta->type, ['select', 'radio', 'checkbox', 'boolean'])) {
                            $opcoes = json_decode($pergunta->options, true);
                            if (is_array($opcoes) && isset($opcoes[$value])) {
                                $avaliacoes[$pergunta->text] = $opcoes[$value];
                            } else {
                                $avaliacoes[$pergunta->text] = $value;
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

        $this->set(compact('resposta', 'avaliacoes'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $this->Authorization->skipAuthorization();
        $estagiario_id = $this->request->getQuery('estagiario_id');

        if (!$estagiario_id) {
            $this->Flash->error(__('Estagiário não informado.'));

            return $this->redirect(['controller' => 'Estagiarios', 'action' => 'index']);
        }

        $estagiario = $this->fetchTable('Estagiarios')->find()
            ->contain(['Alunos'])
            ->where(['Estagiarios.id' => $estagiario_id])
            ->first();

        if (!$estagiario) {
            $this->Flash->error(__('Estagiário não localizado.'));

            return $this->redirect(['controller' => 'Estagiarios', 'action' => 'index']);
        }

        $respostaExistente = $this->Respostas->find()
            ->where(['Respostas.estagiario_id' => $estagiario_id])
            ->first();

        if ($respostaExistente) {
            $this->Flash->error(__('Este estagiário já possui uma avaliação preenchida.'));

            return $this->redirect(['controller' => 'Respostas', 'action' => 'view', $respostaExistente->id]);
        }

        $this->set('estagiario', $estagiario);

        $resposta = $this->Respostas->newEmptyEntity();
        try {
            $this->Authorization->authorize($resposta);
        } catch (ForbiddenException $e) {
            $this->Flash->error(__('Acesso negado. Você não tem permissão para acessar esta página.'));

            return $this->redirect(['controller' => 'Muralestagiarios', 'action' => 'index']);
        }

        if ($this->request->is('post')) {
            $data = $this->request->getData();
            $saveData = [];
            $saveData['questionario_id'] = $data['questionario_id'] ?? 1;
            $saveData['estagiario_id'] = $estagiario_id;

            // Enrich response data with question text and values
            $questoes = $this->fetchTable('Questoes')->find()->all()->combine('id', function ($entity) {
                return $entity;
            })->toArray();
            $enrichedData = [];
            foreach ($data as $key => $value) {
                if (str_starts_with($key, 'avaliacao')) {
                    $pergunta_id = (int)substr($key, 9);
                    if (isset($questoes[$pergunta_id])) {
                        $questao = $questoes[$pergunta_id];
                        $texto_valor = $value;
                        if (in_array($questao->type, ['select', 'radio', 'checkbox', 'boolean'])) {
                            $opcoes = json_decode($questao->options, true);
                            if ($questao->type === 'boolean') {
                                $opcoes = ['0' => 'Não', '1' => 'Sim'];
                            }
                            if (is_array($opcoes) && isset($opcoes[$value])) {
                                $texto_valor = $opcoes[$value];
                            }
                        }
                        $enrichedData[$key] = [
                            'pergunta' => $questao->text,
                            'valor' => $value,
                            'texto_valor' => $texto_valor,
                        ];
                    } else {
                        $enrichedData[$key] = $value;
                    }
                } else {
                    $enrichedData[$key] = $value;
                }
            }

            $saveData['response'] = json_encode($enrichedData, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
            $resposta = $this->Respostas->patchEntity($resposta, $saveData);

            if ($this->Respostas->save($resposta)) {
                $this->Flash->success(__('Resposta inserida.'));

                return $this->redirect(['action' => 'view', $resposta->id]);
            }
            $this->Flash->error(__('Resposta não inserida. Tente novamente.'));
        }

        $questoes = $this->fetchTable('Questoes')->find()->all();
        $this->set(compact('resposta', 'questoes', 'estagiario_id'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Resposta id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit(?string $id = null)
    {
        try {
            $resposta = $this->Respostas->get($id, [
                'contain' => ['Questionarios'],
            ]);
        } catch (RecordNotFoundException $e) {
            $this->Flash->error(__('Registro não encontrado.'));

            return $this->redirect(['controller' => 'Respostas', 'action' => 'index']);
        }

        try {
            $this->Authorization->authorize($resposta);
        } catch (ForbiddenException $e) {
            $this->Flash->error(__('Acesso negado. Você não tem permissão para acessar esta página.'));

            return $this->redirect(['controller' => 'Muralestagiarios', 'action' => 'index']);
        }

        $estagiario = $this->fetchTable('Estagiarios')->get($resposta->estagiario_id, [
            'contain' => ['Alunos'],
        ]);

        $respostasUnique = json_decode($resposta->response, true);
        $avaliacoes = [];
        $i = 0;

        if ($respostasUnique) {
            foreach ($respostasUnique as $key => $value) {
                if (str_starts_with($key, 'avaliacao')) {
                    $pergunta_id = (int)substr($key, 9);
                    try {
                        $pergunta = $this->fetchTable('Questoes')->get($pergunta_id);
                        $avaliacoes[$i]['id'] = $pergunta->id;
                        $avaliacoes[$i]['questionario_id'] = $pergunta->questionario_id;
                        $avaliacoes[$i]['text'] = $pergunta->text;
                        $avaliacoes[$i]['type'] = $pergunta->type;
                        $avaliacoes[$i]['options'] = $pergunta->options;
                        $avaliacoes[$i]['ordem'] = $pergunta->ordem;

                        if (in_array($pergunta->type, ['select', 'radio', 'checkbox', 'boolean'])) {
                            $avaliacoes[$i]['options'] = json_decode($pergunta->options, true);
                        } else {
                            $avaliacoes[$i]['opcoes'] = null;
                        }
                        $i++;
                    } catch (Exception $e) {
                         // Skip
                    }
                }
            }
        }

        if ($this->request->is(['patch', 'post', 'put'])) {
             $data = $this->request->getData();

             // Enrich response data with question text and values
             $questoes = $this->fetchTable('Questoes')->find()->all()->combine('id', function ($entity) {
                return $entity;
             })->toArray();
             $enrichedData = [];
            foreach ($data as $key => $value) {
                if (str_starts_with($key, 'avaliacao')) {
                    $pergunta_id = (int)substr($key, 9);
                    if (isset($questoes[$pergunta_id])) {
                        $questao = $questoes[$pergunta_id];
                        $texto_valor = $value;
                        if (in_array($questao->type, ['select', 'radio', 'checkbox', 'boolean'])) {
                            $opcoes = json_decode($questao->options, true);
                            if ($questao->type === 'boolean') {
                                $opcoes = ['0' => 'Não', '1' => 'Sim'];
                            }
                            if (is_array($opcoes) && isset($opcoes[$value])) {
                                $texto_valor = $opcoes[$value];
                            }
                        }
                        $enrichedData[$key] = [
                            'pergunta' => $questao->text,
                            'valor' => $value,
                            'texto_valor' => $texto_valor,
                        ];
                    } else {
                        $enrichedData[$key] = $value;
                    }
                } else {
                    $enrichedData[$key] = $value;
                }
            }
             $resposta->response = json_encode($enrichedData, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);

            if ($this->Respostas->save($resposta)) {
                $this->Flash->success(__('Resposta atualizada.'));

                return $this->redirect(['controller' => 'Respostas', 'action' => 'view', $resposta->id]);
            }
             $this->Flash->error(__('Resposta não atualizada. Tente novamente.'));
        }
        $this->set(compact('resposta', 'avaliacoes', 'estagiario'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Resposta id.
     * @return \Cake\Http\Response|null|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete(?string $id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        try {
            $resposta = $this->Respostas->get($id);
        } catch (RecordNotFoundException $e) {
            $this->Flash->error(__('Registro não encontrado.'));

            return $this->redirect(['controller' => 'Respostas', 'action' => 'index']);
        }

        try {
            $this->Authorization->authorize($resposta);
        } catch (ForbiddenException $e) {
            $this->Flash->error(__('Acesso negado. Você não tem permissão para acessar esta página.'));

            return $this->redirect(['controller' => 'Muralestagiarios', 'action' => 'index']);
        }

        if ($this->Respostas->delete($resposta)) {
            $this->Flash->success(__('Resposta excluída.'));
        } else {
            $this->Flash->error(__('Resposta não excluída. Tente novamente.'));
        }

        return $this->redirect(['controller' => 'Respostas', 'action' => 'index']);
    }

    /**
     * Imprimerespostapdf method
     *
     * @param string|null $id Resposta id.
     * @param string|null $estagiario_id Estagiario id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function imprimeresposta(?string $id = null)
    {
        $estagiario_id = $this->request->getQuery('estagiario_id');

        $this->Authorization->skipAuthorization();

        if ($estagiario_id === null) {
            $this->Flash->error(__('Selecionar estagiário.'));

            return $this->redirect([
                'controller' => 'estagiarios',
                'action' => 'index',
            ]);
        }

        try {
            $resposta = $this->Respostas->find()
                ->contain([
                    'Estagiarios' => [
                        'Alunos',
                        'Supervisores',
                        'Professores',
                        'Instituicoes',
                        ],
                    'Questionarios' => [
                        'Questoes',
                        ],
                    ])
                ->where(['Estagiarios.id' => $estagiario_id])
                ->first();
        } catch (RecordNotFoundException $e) {
            $this->Flash->error(__('Resposta não foi encontrada.'));
        }

        // Nothing happens if no resposta found, but we want to generate an empty PDF with student info
        if ($resposta === null) {
            $this->Flash->error(__('Avaliação não realizada.'));
            echo 'Nenhuma avaliação encontrada para este estagiário. Gerando PDF vazio com as informações do estagiário...';
            // Fetch a empty record resposta with question and without answers to avoid errors in the template
            $questoes = $this->fetchTable('Questoes')->find()
                ->where(['Questoes.questionario_id' => 1])
                ->all();

            $estagiario = $this->fetchTable('Estagiarios')->get($estagiario_id, [
                    'contain' => ['Alunos', 'Supervisores', 'Professores', 'Instituicoes'],
                ]);

            $respostavazia = ['respostas' => $questoes, 'estagiario' => $estagiario];
            }

        $this->viewBuilder()->enableAutoLayout(enable: false);
        $this->viewBuilder()->setClassName('CakePdf.Pdf');
        $this->viewBuilder()->setOption('pdfConfig', [
            'orientation' => 'portrait',
            'download' => true,
            'filename' => 'avaliacao_discente_' . $id . '.pdf',
        ]);
        $this->set('resposta', $resposta ?? (object)$respostavazia);
    }
}