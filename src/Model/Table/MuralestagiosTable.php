<?php

declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Muralestagios Model
 *
 * @property \App\Model\Table\InstituicoesTable&\Cake\ORM\Association\BelongsTo $Instituicoes
 * @property \App\Model\Table\TurmaestagiosTable&\Cake\ORM\Association\BelongsTo $Turmaestagios
 * @property \App\Model\Table\ProfessoresTable&\Cake\ORM\Association\BelongsTo $Professores
 * @property \App\Model\Table\MuralinscricoesTable&\Cake\ORM\Association\HasMany $Muralinscricoes
 *
 * @method \App\Model\Entity\Muralestagio newEmptyEntity()
 * @method \App\Model\Entity\Muralestagio newEntity(array $data, array $options = [])
 * @method \App\Model\Entity\Muralestagio[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Muralestagio get($primaryKey, $options = [])
 * @method \App\Model\Entity\Muralestagio findOrCreate($search, ?callable $callback = null, $options = [])
 * @method \App\Model\Entity\Muralestagio patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Muralestagio[] patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\Muralestagio|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Muralestagio saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Muralestagio[]|\Cake\Datasource\ResultSetInterface|false saveMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\Muralestagio[]|\Cake\Datasource\ResultSetInterface saveManyOrFail(iterable $entities, $options = [])
 * @method \App\Model\Entity\Muralestagio[]|\Cake\Datasource\ResultSetInterface|false deleteMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\Muralestagio[]|\Cake\Datasource\ResultSetInterface deleteManyOrFail(iterable $entities, $options = [])
 */
class MuralestagiosTable extends Table
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

                $this->setTable('mural_estagio');
                $this->setAlias('Muralestagios');
                $this->setDisplayField('instituicao');
                $this->setPrimaryKey('id');

                $this->belongsTo('Instituicoes', [
                        'propertyName' => 'instituicoes',
                        'foreignKey' => ['instituicao_id'],
                ]);
                $this->belongsTo('Turmaestagios', [
                        'foreignKey' => ['turmaestagio_id'],
                ]);
                $this->belongsTo('Professores', [
                        'foreignKey' => ['professor_id'],
                ]);
                $this->hasMany('Muralinscricoes', [
                        'foreignKey' => ['muralestagio_id'],
                ]);
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
                        ->scalar('instituicao')
                        ->maxLength('instituicao', 100)
                        ->notEmptyString('instituicao');

                $validator
                        ->scalar('convenio')
                        ->maxLength('convenio', 1)
                        ->notEmptyString('convenio');

                $validator
                        ->notEmptyString('vagas');

                $validator
                        ->scalar('beneficios')
                        ->maxLength('beneficios', 50)
                        ->allowEmptyString('beneficios');

                $validator
                        ->scalar('final_de_semana')
                        ->maxLength('final_de_semana', 1)
                        ->allowEmptyString('final_de_semana');

                $validator
                        ->allowEmptyString('cargaHoraria');

                $validator
                        ->scalar('requisitos')
                        ->maxLength('requisitos', 255)
                        ->allowEmptyString('requisitos');

                $validator
                        ->scalar('horario')
                        ->maxLength('horario', 1)
                        ->allowEmptyString('horario');

                $validator
                        ->date('dataSelecao')
                        ->allowEmptyDate('dataSelecao');

                $validator
                        ->date('dataInscricao')
                        ->allowEmptyDate('dataInscricao');

                $validator
                        ->scalar('horarioSelecao')
                        ->maxLength('horarioSelecao', 5)
                        ->allowEmptyString('horarioSelecao');

                $validator
                        ->scalar('localSelecao')
                        ->maxLength('localSelecao', 70)
                        ->allowEmptyString('localSelecao');

                $validator
                        ->scalar('formaSelecao')
                        ->maxLength('formaSelecao', 1)
                        ->allowEmptyString('formaSelecao');

                $validator
                        ->scalar('contato')
                        ->maxLength('contato', 70)
                        ->allowEmptyString('contato');

                $validator
                        ->scalar('outras')
                        ->allowEmptyString('outras');

                $validator
                        ->scalar('periodo')
                        ->maxLength('periodo', 6)
                        ->notEmptyString('periodo');
                /*
                        $validator
                                ->date('datafax')
                                ->allowEmptyDate('datafax');
                */
                $validator
                        ->scalar('localInscricao')
                        ->notEmptyString('localInscricao');

                $validator
                        ->email('email')
                        ->allowEmptyString('email');

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

                $rules->add($rules->existsIn(['instituicao_id'], 'Instituicoes'), ['errorField' => 'instituicao_id']);
                $rules->add($rules->existsIn(['turmaestagio_id'], 'Turmaestagios'), ['errorField' => 'turmaestagio_id']);
                $rules->add($rules->existsIn(['professor_id'], 'Professores'), ['errorField' => 'professor_id']);
                
                return $rules;
        }

}
