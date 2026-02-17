<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Estagiariomonografias Model
 *
 * @property \App\Model\Table\AlunosTable&\Cake\ORM\Association\BelongsTo $Alunos 
 * @property \App\Model\Table\ProfessoresTable&\Cake\ORM\Association\BelongsTo $Professores
 * @property \App\Model\Table\TurmaestagiosTable&\Cake\ORM\Association\BelongsTo $Turmestagios
 * @property \App\Model\Table\SupervisoresTable&\Cake\ORM\Association\BelongsTo $Supervisores
 * @property \App\Model\Table\InstituicoesTable&\Cake\ORM\Association\BelongsTo $Instituicoes
 * @property \App\Model\Table\AvaliacoesTable&\Cake\ORM\Association\HasOne $Avaliacao
 * @property \App\Model\Table\FolhadeatividadesTable&\Cake\ORM\Association\HasMany $Folhadeatividade 
 * @property \App\Model\Table\TccestudantesTable&\Cake\ORM\Association\BelongsTo $Tccestudantes
 * 
 * @method \App\Model\Entity\Estagiariomonografia get($primaryKey, $options = [])
 * @method \App\Model\Entity\Estagiariomonografia newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\Estagiariomonografia[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Estagiariomonografia|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Estagiariomonografia saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Estagiariomonografia patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Estagiariomonografia[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\Estagiariomonografia findOrCreate($search, callable $callback = null, $options = [])
 */
class EstagiariomonografiasTable extends Table
{

        /**
         * Initialize method
         *
         * @param array $config The configuration for the Table.
         * @return void
         */
        public function initialize(array $config): void
        {
                parent::initialize($config);

                $this->setTable('estagiarios');
                $this->setAlias('Estagiarios');
                $this->setDisplayField('id');
                $this->setPrimaryKey('id');

                $this->belongsTo('Alunos', [
                        'className' => 'Alunos',
                        'foreignKey' => 'aluno_id',
                        'joinType' => 'LEFT',
                ]);

                $this->belongsTo('Professores', [
                        'foreignKey' => 'professor_id',
                ]);

                $this->belongsTo('Turmaestagios', [
                        'foreignKey' => 'turmaestagio_id',
                ]);

                $this->belongsTo('Supervisores', [
                        'foreignKey' => 'supervisor_id',
                ]);

                $this->belongsTo('Instituicoes', [
                        'className' => 'Instituicoes',
                        'foreignKey' => 'instituicao_id',
                ]);

                $this->hasOne('Avaliacoes', [
                        'foreignKey' => 'estagiario_id',
                        'joinType' => 'INNER',
                ]);

                $this->hasMany('Folhadeatividades', [
                        'foreignKey' => 'estagiario_id',
                        'order' => ['Folhadeatividades.dia' => 'ASC'],
                ]);

                $this->belongsTo('Tccestudantes', [
                        'className' => 'Tccestudantes',
                        'foreignKey' => FALSE,
                        'conditions' => 'Estagiarios.registro = Tccestudantes.registro',
                        'joinType' => 'LEFT'
                ]);

        }

        public function beforeFind($event, $query, $options, $primary)
        {
                $query->order(['Estagiariomonografias.registro' => 'ASC', 'Estagiariomonografias.nivel' => 'ASC']);
                return $query;
        }

        /**
         * Default validation rules.
         *
         * @param \Cake\Validation\Validator $validator Validator instance.
         * @return \Cake\Validation\Validator
         */
        public function validationDefault(Validator $validator): Validator
        {
                $validator
                        ->integer('id')
                        ->allowEmptyString('id', null, 'create');

                $validator
                        ->integer('registro')
                        ->notEmptyString('registro');

                $validator
                        ->scalar('turno')
                        // ->multipleOptions('turno', ['D' => 'Diurno', 'N' => 'Noturno', 'I' => 'Indefinido'], 'Selecione um turno') // Cake 5 validator doesn't have multipleOptions like this, it uses inList usually. But multipleOptions might be a custom rule or from a plugin. I will comment it out if it is likely custom or just rely on scalar + maxLength.
                        // Actually, 'multipleOptions' is NOT a standard Validator method in CakePHP 4/5. It might be 'inList'.
                        // However, since tcc4 has it, maybe it was added via macro?
                        // I will replace it with 'inList' if possible, or just leave 'scalar'.
                        // Let's assume it was intended to be 'inList'.
                         ->inList('turno', ['D', 'N', 'I'], 'Selecione um turno')
                        ->maxLength('turno', 1)
                        ->notEmptyString('turno');

                $validator
                        ->inList('nivel', ['1', '2', '3', '4', '9'], 'Selecione um dos níveis')
                        ->scalar('nivel')
                        ->maxLength('nivel', 1)
                        ->notEmptyString('nivel');

                $validator
                        //->multipleOptions('tc', ['0' => '0', '1' => '1'])
                         ->inList('tc', ['0', '1'])
                        ->notEmptyString('tc');

                $validator
                        ->date('tc_solicitacao')
                        ->allowEmptyDate('tc_solicitacao');

                $validator
                        ->notEmptyString('instituicao_id');

                $validator
                        ->allowEmptyString('supervisor_id');

                $validator
                        ->scalar('periodo')
                        ->maxLength('periodo', 6)
                        ->notEmptyString('periodo');

                $validator
                        ->naturalNumber('turmaestagio_id')
                        ->allowEmptyString('turmaestagio_id');

                $validator
                        ->decimal('nota')
                        ->range('nota', [0, 10], 'Digite a nota')
                        ->allowEmptyString('nota');

                $validator
                        ->allowEmptyString('ch');

                $validator
                        ->scalar('observacoes')
                        ->maxLength('observacoes', 255)
                        ->allowEmptyString('observacoes');

                return $validator;
        }

        /**
         * Returns a rules checker object that will be used for validating
         * application integrity.
         *
         * @param \Cake\ORM\RulesChecker $rules The rules object to be modified.
         * @return \Cake\ORM\RulesChecker
         */
        public function buildRules(RulesChecker $rules): RulesChecker
        {
                $rules->add($rules->existsIn(['aluno_id'], 'Alunos'));
                $rules->add($rules->existsIn(['professor_id'], 'Professores'));
                $rules->add($rules->existsIn(['turmaestagio_id'], 'Turmaestagios'));
                $rules->add($rules->existsIn(['supervisor_id'], 'Supervisores'));
                $rules->add($rules->existsIn(['instituicao_id'], 'Instituicoes'));
                $rules->add($rules->existsIn(['tccestudante_id'], 'Tccestudantes'));

                return $rules;
        }

}
