<?php
declare(strict_types=1);

namespace App\Controller;

use Cake\I18n\DateTime;
use Cake\I18n\I18n;

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
        } catch (\Authorization\Exception\ForbiddenException $e) {
            $this->Flash->error(__('Acesso negado. Você não tem permissão para acessar esta página.'));
            return $this->redirect(['action' => 'index']);
        }

        $query = $this->Respostas->find()
            ->contain(['Estagiarios' => ['Alunos']])
            ->order(['Respostas.id' => 'DESC']);

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
    public function view($id = null)
    {
        try {
            $resposta = $this->Respostas->get($id, [
                'contain' => ['Estagiarios' => ['Alunos']],
            ]);
        } catch (\Cake\Datasource\Exception\RecordNotFoundException $e) {
            $this->Flash->error(__('Registro não encontrado.'));
            return $this->redirect(['action' => 'index']);
        }

        try {
            $this->Authorization->authorize($resposta);
        } catch (\Authorization\Exception\ForbiddenException $e) {
            $this->Flash->error(__('Acesso negado. Você não tem permissão para acessar esta página.'));
            return $this->redirect(['action' => 'index']);
        }
        
        $respostasData = json_decode($resposta->response, true) ?? [];
        $avaliacoes = [];
        
        foreach ($respostasData as $key => $value) {
            if (str_starts_with($key, 'avaliacao')) {
                $pergunta_id = (int) substr($key, 9); // Removed length limit to be safe
                if ($pergunta_id > 0) {
                    try {
                        $pergunta = $this->fetchTable('Questiones')->get($pergunta_id);
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
                    } catch (\Exception $e) {
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
        $estagiario_id = $this->request->getQuery('estagiario_id');
        
        if (!$estagiario_id) {
            $this->Flash->error(__('Estagiário não informado.'));
            return $this->redirect(['action' => 'index']);
        }
        
        $estagiario = $this->fetchTable('Estagiarios')->find()
            ->contain(['Alunos'])
            ->where(['Estagiarios.id' => $estagiario_id])
            ->first();
            
        if (!$estagiario) {
            $this->Flash->error(__('Estagiário não localizado.'));
            return $this->redirect(['action' => 'index']);
        }

        $respostaExistente = $this->Respostas->find()
            ->where(['Respostas.estagiario_id' => $estagiario_id])
            ->first();
            
        if ($respostaExistente) {
            $this->Flash->error(__('Este estagiário já possui uma avaliação preenchida.'));
            return $this->redirect(['action' => 'view', $respostaExistente->id]);
        }
        
        $this->set('estagiario', $estagiario);

        $resposta = $this->Respostas->newEmptyEntity();     
        try {
            $this->Authorization->authorize($resposta);
        } catch (\Authorization\Exception\ForbiddenException $e) {
            $this->Flash->error(__('Acesso negado. Você não tem permissão para acessar esta página.'));
            return $this->redirect(['action' => 'index']);
        }

        if ($this->request->is('post')) {
            $data = $this->request->getData();
            
            $saveData = [];
            $saveData['questionario_id'] = $data['questionario_id'] ?? 1;
            $saveData['estagiario_id'] = $estagiario_id;
            $saveData['response'] = json_encode($data, JSON_PRETTY_PRINT);
            
            $resposta = $this->Respostas->patchEntity($resposta, $saveData);
            
            if ($this->Respostas->save($resposta)) {
                $this->Flash->success(__('Respuesta inserida.'));
                return $this->redirect(['action' => 'view', $resposta->id]);
            }
            $this->Flash->error(__('Respuesta não inserida. Tente novamente.'));
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
    public function edit($id = null)
    {
        try {
            $resposta = $this->Respostas->get($id);
        } catch (\Cake\Datasource\Exception\RecordNotFoundException $e) {
            $this->Flash->error(__('Registro não encontrado.'));
            return $this->redirect(['action' => 'index']);
        }

        try {
            $this->Authorization->authorize($resposta);
        } catch (\Authorization\Exception\ForbiddenException $e) {
            $this->Flash->error(__('Acesso negado. Você não tem permissão para acessar esta página.'));
            return $this->redirect(['action' => 'index']);
        }
        
        $estagiario = $this->fetchTable('Estagiarios')->get($resposta->estagiario_id, [
            'contain' => ['Alunos']
        ]);
        
        $respostasUnique = json_decode($resposta->response, true);
        $avaliacoes = [];
        $i = 0;
        
        if ($respostasUnique) {
            foreach ($respostasUnique as $key => $value) {
                if (str_starts_with($key, 'avaliacao')) {
                    $pergunta_id = (int) substr($key, 9);
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
                    } catch(\Exception $e) {
                         // Skip
                    }
                }
            }
            
        }

        if ($this->request->is(['patch', 'post', 'put'])) {
             $data = $this->request->getData();
             $resposta->response = json_encode($data, JSON_PRETTY_PRINT);
             
             if ($this->Respostas->save($resposta)) {
                 $this->Flash->success(__('Resposta atualizada.'));
                 return $this->redirect(['action' => 'view', $resposta->id]);
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
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        try {
            $resposta = $this->Respostas->get($id);
        } catch (\Cake\Datasource\Exception\RecordNotFoundException $e) {
            $this->Flash->error(__('Registro não encontrado.'));
            return $this->redirect(['action' => 'index']);
        }
        
        try {
            $this->Authorization->authorize($resposta);
        } catch (\Authorization\Exception\ForbiddenException $e) {
            $this->Flash->error(__('Acesso negado. Você não tem permissão para acessar esta página.'));
            return $this->redirect(['action' => 'index']);
        }
        
        if ($this->Respostas->delete($resposta)) {
            $this->Flash->success(__('Resposta excluída.'));
        } else {
            $this->Flash->error(__('Resposta não excluída. Tente novamente.'));
        }
        
        return $this->redirect(['action' => 'index']);
    }

    /**
     * Imprimerespostapdf method
     *
     * @param string|null $id Resposta id.
     * @param string|null $estagiario_id Estagiario id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function imprimeresposta($id = null)
    {
        $estagiario_id = $this->request->getQuery("estagiario_id");

        $this->Authorization->skipAuthorization();

        if ($estagiario_id === null) {
            $this->Flash->error(__("Selecionar estagiário."));
            return $this->redirect([
                "controller" => "estagiarios",
                "action" => "index",
            ]);
        }
 
        try {
            $resposta = $this->Respostas->find()
                ->contain([
                    "Estagiarios" => [
                        "Alunos",
                        "Supervisores",
                        "Professores",
                        "Instituicoes",
                        ],
                    "Questionarios" => [
                        "Questoes",
                        ],
                    ])
                ->where(["Estagiarios.id" => $estagiario_id])
                ->first();
        } catch (\Cake\Datasource\Exception\RecordNotFoundException $e) {
            $this->Flash->error(__("Resposta não foi encontrada."));
            return $this->redirect([
                "controller" => "estagiarios",
                "action" => "view",
                $estagiario_id,
            ]);
        }

        if ($resposta === null) {
            $this->Flash->error(__("Resposta não foi encontrada."));
            return $this->redirect([
                "controller" => "estagiarios",
                "action" => "view",
                $estagiario_id,
            ]);
        }
        
        $this->viewBuilder()->enableAutoLayout(false);
        $this->viewBuilder()->setClassName("CakePdf.Pdf");
        $this->viewBuilder()->setOption("pdfConfig", [
            "orientation" => "portrait",
            "download" => true,
            "filename" => "avaliacao_discente_" . $id . ".pdf",
        ]);
        $this->set("resposta", $resposta);
    }
}
