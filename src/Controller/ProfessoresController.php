<?php
declare(strict_types=1);

namespace App\Controller;

use App\Controller\AppController;
use Cake\Event\EventInterface;
use Cake\ORM\TableRegistry;
use Cake\I18n\FrozenTime;
use Cake\I18n\I18n;

/**
 * Professores Controller
 *
 * @property \App\Model\Table\ProfessoresTable $Professores
 * @property \Authorization\Controller\Component\AuthorizationComponent $Authorization
 * @property \Authentication\Controller\Component\AuthenticationComponent $Authentication
 * 
 * @method \App\Model\Entity\Professor[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class ProfessoresController extends AppController
{
    public function beforeFilter(EventInterface $event): void
    {
        parent::beforeFilter($event);
        $this->Authentication->addUnauthenticatedActions(['index', 'view', 'buscaprofessor']);
    }

    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $this->Authorization->skipAuthorization();
        $query = $this->Professores->find();
        
        // Sorting managed by paginate defaults or query params
        $query->order(['nome' => 'ASC']);

        $professores = $this->paginate($query, [
            'sortableFields' => ['nome', 'siape', 'departamento', 'dataingresso', 'dataegresso']
        ]);
        
        if (count($professores) === 0) {
            $this->Flash->error(__('Nenhum(a) professor(a) encontrado.'));
             // return $this->redirect(['action' => 'add']); // Avoid redirect loop if empty?
        }
        
        $this->set(compact('professores'));
    }

    /**
     * View method
     *
     * @param string|null $id Professor id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $this->Authorization->skipAuthorization();
        $user = $this->Authentication->getIdentity();
        
        if (isset($user) && ($user->categoria == '1' || $user->categoria == '3')) {
            if ($id === null) {
                $siape = $this->getRequest()->getQuery('siape');
                if ($siape) {
                    $query = $this->Professores->find()
                        ->where(['siape' => $siape])
                        ->first();
                    if ($query) $id = $query->id;
                } else {
                    if ($user->categoria == '3') { // Professor
                        $siape = $user->numero;
                        if ($siape) {
                            $query = $this->Professores->find()
                                ->where(['siape' => $siape])
                                ->first();
                            if ($query) $id = $query->id;
                        }
                    }
                }
            }
        } else {
            $this->Flash->error(__('Acesso não autorizado para este recurso.'));
            return $this->redirect(['controller' => 'Users', 'action' => 'login']);
        }
        
        if ($id === null) {
             $this->Flash->error(__('Professor não identificado.'));
             return $this->redirect(['action' => 'index']);
        }

        /** Têm Professores com muitos estagiários: aumentar a memória */
        ini_set('memory_limit', '2048M');
        try {
            $professor = $this->Professores->get(
                $id,
                [
                    'contain' => ['Estagiarios' => ['sort' => ['Estagiarios.periodo' => 'DESC'], 'Instituicoes', 'Supervisores', 'Professores', 'Alunos']]
                ]
            );
        } catch (\Cake\Datasource\Exception\RecordNotFoundException $e) {
            $this->Flash->error(__('Nao ha registros de professor para esse numero!'));
            return $this->redirect(['action' => 'index']);
        }

        $this->set(compact('professor'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $siape = $this->getRequest()->getQuery('siape');
        $email = $this->getRequest()->getQuery('email');

        if ($siape) $this->set('siape', $siape);
        if ($email) $this->set('email', $email);

        /* Verifico se já está cadastrado */
        if ($siape) {
            $professorcadastrado = $this->Professores->find()
                ->where(['siape' => $siape])
                ->first();

            if ($professorcadastrado) {
                $this->Flash->error(__('Siape do(a) professor(a) já cadastrado'));
                return $this->redirect(['action' => 'view', $professorcadastrado->id]);
            }
        }

        if ($email) {
            $professorcadastrado = $this->Professores->find()
                ->where(['email' => $email])
                ->first();

            if ($professorcadastrado) {
                $this->Flash->error(__('E-mail do(a) professor(a) já cadastrado'));
                return $this->redirect(['action' => 'view', $professorcadastrado->id]);
            }
        }

        $professor = $this->Professores->newEmptyEntity();
        $this->Authorization->authorize($professor);

        if ($this->request->is('post')) {
            $data = $this->request->getData();
            $siape = $data['siape'];
            
            /** Busca se já está cadastrado como user */
            $usercadastrado = $this->fetchTable('Users')->find()
                ->where(['categoria' => 3, 'numero' => $siape])
                ->first();
                
            if (empty($usercadastrado)) {
                $this->Flash->error(__('Professor(a) não cadastrado(a) como usuário(a)'));
            }

            $professor = $this->Professores->patchEntity($professor, $data);
            if ($this->Professores->save($professor)) {
                $this->Flash->success(__('Registro do(a) professor(a) inserido.'));
                return $this->redirect(['action' => 'view', $professor->id]);
            }
            $this->Flash->error(__('Registro do(a) professor(a) não inserido. Tente novamente.'));
            
            // Re-populate query params on failure if valid?
        }
        $this->set(compact('professor'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Professor id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        try {
            $professor = $this->Professores->get($id, [
                'contain' => [],
            ]);
        } catch (\Cake\Datasource\Exception\RecordNotFoundException $e) {
            $this->Flash->error(__('Professor incorreto.'));
            return $this->redirect(['action' => 'index']);
        }
        
        $this->Authorization->authorize($professor);

        if ($this->request->is(['patch', 'post', 'put'])) {
            $professor = $this->Professores->patchEntity($professor, $this->request->getData());
            if ($this->Professores->save($professor)) {
                $this->Flash->success(__('Registro do(a) professor(a) atualizado.'));
                return $this->redirect(['action' => 'view', $id]);
            }
            $this->Flash->error(__('Registro do(a) professor(a) no foi atualizado. Tente novamente.'));
        }
        $this->set(compact('professor'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Professor id.
     * @return \Cake\Http\Response|null|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        
        try {
            $professor = $this->Professores->get($id, [
                'contain' => ['Estagiarios']
            ]);
        } catch (\Cake\Datasource\Exception\RecordNotFoundException $e) {
            $this->Flash->error(__('Professor(a) não encontrado.'));
            return $this->redirect(['action' => 'index']);
        }

        $this->Authorization->authorize($professor);
        
        if (count($professor->estagiarios) > 0) {
            $this->Flash->error(__('Professor(a) tem estagiários associados'));
            return $this->redirect(['controller' => 'Professores', 'action' => 'view', $id]);
        }

        if ($this->Professores->delete($professor)) {
            $this->Flash->success(__('Registro professor(a) excluído.'));
        } else {
            $this->Flash->error(__('Registro professor(a) não foi excluído. Tente novamente.'));
        }

        return $this->redirect(['action' => 'index']);
    }

    public function buscaprofessor()
    {
        $this->Authorization->skipAuthorization();
        $nome = $this->getRequest()->getData('nome');
        
        if ($nome) {
            $query = $this->Professores->find()
                ->where(['nome LIKE' => "%{$nome}%"])
                ->order(['nome' => 'ASC']);
                
            if ($query->count() == 0) {
                $this->Flash->error(__('Nenhum(a) professor(a) encontrado com o nome: ' . $nome));
                return $this->redirect(['controller' => 'Professores', 'action' => 'index']);
            }
            
            $professores = $this->paginate($query);
            $this->set('professores', $professores);
            $this->render('index');
        } else {
            $this->Flash->error(__('Digite um nome para buscar'));
            return $this->redirect(['controller' => 'Professores', 'action' => 'index']);
        }
    }
}
