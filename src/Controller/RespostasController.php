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
        $this->Authorization->skipAuthorization();
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
        
        $this->Authorization->skipAuthorization();
        
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
        $this->Authorization->skipAuthorization();
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
            ->where(['Respostas.estagiarios_id' => $estagiario_id])
            ->first();
            
        if ($respostaExistente) {
            $this->Flash->error(__('Este estagiário já possui uma avaliação preenchida.'));
            return $this->redirect(['action' => 'view', $respostaExistente->id]);
        }
        
        $this->set('estagiario', $estagiario);
        $resposta = $this->Respostas->newEmptyEntity();
        
        if ($this->request->is('post')) {
            $data = $this->request->getData();
            
            // Re-map fields as per original logic?
            // Original logic: json_encode entire data into response field.
            // Also explicitly set question_id (default 1?), estagiarios_id.
            
            $saveData = [];
            $saveData['question_id'] = $data['question_id'] ?? 1;
            $saveData['estagiarios_id'] = $estagiario_id;
            $saveData['response'] = json_encode($data, JSON_PRETTY_PRINT);
            // Created/Modified managed by timestamp behavior usually, but explicitly setting if needed
            
            $resposta = $this->Respostas->patchEntity($resposta, $saveData);
            
            if ($this->Respostas->save($resposta)) {
                $this->Flash->success(__('Respuesta inserida.'));
                return $this->redirect(['action' => 'view', $resposta->id]);
            }
            $this->Flash->error(__('Respuesta não inserida. Tente novamente.'));
        }
        
        $questiones = $this->Respostas->Questiones->find()->all();
        $this->set(compact('resposta', 'questiones', 'estagiario_id'));
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
        
        $this->Authorization->skipAuthorization();
        
        $estagiario = $this->fetchTable('Estagiarios')->get($resposta->estagiarios_id, [
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
                        $pergunta = $this->fetchTable('Questiones')->get($pergunta_id);
                        $avaliacoes[$i]['pergunta_id'] = $pergunta_id;
                        $avaliacoes[$i]['pergunta'] = $pergunta->text;
                        $avaliacoes[$i]['type'] = $pergunta->type;
                        $avaliacoes[$i]['value'] = $value;
                        
                        if (in_array($pergunta->type, ['select', 'radio', 'checkbox', 'boolean'])) {
                            $avaliacoes[$i]['opcoes'] = json_decode($pergunta->options, true);
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
             // Original logic implies re-encoding the posted data into response
             $resposta->response = json_encode($data, JSON_PRETTY_PRINT);
             // Patch other fields if any? usually strictly response content updates
             
             if ($this->Respostas->save($resposta)) {
                 $this->Flash->success(__('Resposta atualizada.'));
                 return $this->redirect(['action' => 'view', $resposta->id]);
             }
             $this->Flash->error(__('Resposta não atualizada. Tente novamente.'));
             // return $this->redirect(['action' => 'index']);
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
        
        $this->Authorization->skipAuthorization();
        
        if ($this->Respostas->delete($resposta)) {
            $this->Flash->success(__('Resposta excluída.'));
        } else {
            $this->Flash->error(__('Resposta não excluída. Tente novamente.'));
            return $this->redirect(['action' => 'view', $resposta->id]);
        }
        
        return $this->redirect(['action' => 'index']);
    }
}
