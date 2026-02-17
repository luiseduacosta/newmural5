<?php

namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Docentes Model
 *
 * @property \App\Model\Table\UsersTable&\Cake\ORM\Association\HasMany $Users
 * @property \App\Model\Table\MonografiasTable&\Cake\ORM\Association\HasMany $Monografias
 * @property \App\Model\Table\AreamonografiasTable&\Cake\ORM\Association\HasMany $Areamonografias
 * @property \App\Model\Table\AgendamentotccsTable&\Cake\ORM\Association\HasMany $Agendamentotccs
 *
 * @method \App\Model\Entity\Docente get($primaryKey, $options = [])
 * @method \App\Model\Entity\Docente newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\Docente[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Docente|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Docente saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Docente patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Docente[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\Docente findOrCreate($search, callable $callback = null, $options = [])
 */
class DocentesTable extends Table
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

                $this->setTable('professores');
                $this->setAlias('Docentes');
                $this->setDisplayField('id');
                $this->setPrimaryKey('id');

                $this->hasMany('Users', [
                        'foreignKey' => 'professor_id',
                ]);

                $this->hasMany('Monografias', [
                        'className' => 'Monografias',
                        'foreignKey' => 'professor_id',
                ]);

                $this->hasMany('Monografias1', [
                        'className' => 'Monografias',
                        'foreignKey' => 'banca1',
                ]);

                $this->hasMany('Monografias2', [
                        'className' => 'Monografias',
                        'foreignKey' => 'banca2',
                ]);

                $this->hasMany('Monografias3', [
                        'className' => 'Monografias',
                        'foreignKey' => 'banca3',
                ]);

                $this->belongsToMany('Areamonografias', [
                        'targetForeignKey' => 'areamonografia_id',
                        'foreignKey' => 'docente_id',
                        'joinTable' => 'areamonografias_docentes'
                ]);

                $this->hasMany('Agendamentotccs', [
                        'foreignKey' => 'docente_id',
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
                        ->scalar('nome')
                        ->maxLength('nome', 50)
                        ->notEmptyString('nome');

                $validator
                        ->scalar('cpf')
                        ->maxLength('cpf', 15)
                        ->allowEmptyString('cpf');

                $validator
                        ->integer('siape')
                        ->allowEmptyString('siape');

                $validator
                        ->date('datanascimento')
                        ->allowEmptyDate('datanascimento');

                $validator
                        ->scalar('localnascimento')
                        ->maxLength('localnascimento', 30)
                        ->allowEmptyString('localnascimento');

                $validator
                        ->scalar('sexo')
                        ->allowEmptyString('sexo');

                $validator
                        ->scalar('ddd_telefone')
                        ->maxLength('ddd_telefone', 2)
                        ->notEmptyString('ddd_telefone');

                $validator
                        ->scalar('telefone')
                        ->maxLength('telefone', 15)
                        ->allowEmptyString('telefone');

                $validator
                        ->scalar('ddd_celular')
                        ->maxLength('ddd_celular', 2)
                        ->notEmptyString('ddd_celular');

                $validator
                        ->scalar('celular')
                        ->maxLength('celular', 15)
                        ->allowEmptyString('celular');

                $validator
                        ->email('email')
                        ->allowEmptyString('email');

                $validator
                        ->scalar('homepage')
                        ->maxLength('homepage', 120)
                        ->allowEmptyString('homepage');

                $validator
                        ->scalar('redesocial')
                        ->maxLength('redesocial', 50)
                        ->allowEmptyString('redesocial');

                $validator
                        ->scalar('curriculolattes')
                        ->maxLength('curriculolattes', 50)
                        ->allowEmptyString('curriculolattes');

                $validator
                        ->date('atualizacaolattes')
                        ->allowEmptyDate('atualizacaolattes');

                $validator
                        ->scalar('curriculosigma')
                        ->maxLength('curriculosigma', 7)
                        ->allowEmptyString('curriculosigma');

                $validator
                        ->scalar('pesquisadordgp')
                        ->maxLength('pesquisadordgp', 20)
                        ->allowEmptyString('pesquisadordgp');

                $validator
                        ->scalar('formacaoprofissional')
                        ->maxLength('formacaoprofissional', 30)
                        ->allowEmptyString('formacaoprofissional');

                $validator
                        ->scalar('universidadedegraduacao')
                        ->maxLength('universidadedegraduacao', 50)
                        ->allowEmptyString('universidadedegraduacao');

                $validator
                        ->integer('anoformacao')
                        ->allowEmptyString('anoformacao');

                $validator
                        ->scalar('mestradoarea')
                        ->maxLength('mestradoarea', 40)
                        ->allowEmptyString('mestradoarea');

                $validator
                        ->scalar('mestradouniversidade')
                        ->maxLength('mestradouniversidade', 50)
                        ->allowEmptyString('mestradouniversidade');

                $validator
                        ->integer('mestradoanoconclusao')
                        ->allowEmptyString('mestradoanoconclusao');

                $validator
                        ->scalar('doutoradoarea')
                        ->maxLength('doutoradoarea', 40)
                        ->allowEmptyString('doutoradoarea');

                $validator
                        ->scalar('doutoradouniversidade')
                        ->maxLength('doutoradouniversidade', 50)
                        ->allowEmptyString('doutoradouniversidade');

                $validator
                        ->integer('doutoradoanoconclusao')
                        ->allowEmptyString('doutoradoanoconclusao');

                $validator
                        ->date('dataingresso')
                        ->allowEmptyDate('dataingresso');

                $validator
                        ->scalar('formaingresso')
                        ->maxLength('formaingresso', 100)
                        ->allowEmptyString('formaingresso');

                $validator
                        ->scalar('tipocargo')
                        ->allowEmptyString('tipocargo');

                $validator
                        ->scalar('categoria')
                        ->maxLength('categoria', 10)
                        ->allowEmptyString('categoria');

                $validator
                        ->scalar('regimetrabalho')
                        ->allowEmptyString('regimetrabalho');

                $validator
                        ->scalar('departamento')
                        ->allowEmptyString('departamento');

                $validator
                        ->date('dataegresso')
                        ->allowEmptyDate('dataegresso');

                $validator
                        ->scalar('motivoegresso')
                        ->maxLength('motivoegresso', 100)
                        ->allowEmptyString('motivoegresso');

                $validator
                        ->scalar('observacoes')
                        ->maxLength('observacoes', 250)
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
                // $rules->add($rules->isUnique(['email']));

                return $rules;
        }

}
