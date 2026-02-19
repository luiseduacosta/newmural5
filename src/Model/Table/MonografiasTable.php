<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Monografias Model
 *
 * @property \App\Model\Table\DocentesTable&\Cake\ORM\Association\BelongsTo $Docentes
 * @property \App\Model\Table\TccestudantesTable&\Cake\ORM\Association\HasMany $Tccestudantes
 * @property \App\Model\Table\AreamonografiasTable&\Cake\ORM\Association\BelongsTo $Areamonografias
 *
 * @method \App\Model\Entity\Monografia newEmptyEntity()
 * @method \App\Model\Entity\Monografia newEntity(array $data, array $options = [])
 * @method \App\Model\Entity\Monografia[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Monografia get($primaryKey, $options = [])
 * @method \App\Model\Entity\Monografia findOrCreate($search, ?callable $callback = null, $options = [])
 * @method \App\Model\Entity\Monografia patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Monografia[] patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\Monografia|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Monografia saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Monografia[]|\Cake\Datasource\ResultSetInterface|false saveMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\Monografia[]|\Cake\Datasource\ResultSetInterface saveManyOrFail(iterable $entities, $options = [])
 * @method \App\Model\Entity\Monografia[]|\Cake\Datasource\ResultSetInterface|false deleteMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\Monografia[]|\Cake\Datasource\ResultSetInterface deleteManyOrFail(iterable $entities, $options = [])
 */
class MonografiasTable extends Table
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

                // Areamonografias tem monografias. Quantas monografias tem uma area
                $this->addBehavior('CounterCache', [
                        'Areamonografias' => ['q_monografia'] // Caches monografia count on the 'Areamonografias' table
                ]);

                $this->setTable('monografias');
                $this->setAlias('Monografias');
                $this->setDisplayField('titulo');
                $this->setPrimaryKey('id');

                // Monografia tem um campo professor_id
                $this->belongsTo('Docentes', [
                        'className' => 'Docentes',
                        'propertyName' => 'docentes',
                        'foreignKey' => 'professor_id',
                ]);

                $this->belongsTo('Docentes1', [
                        'className' => 'Docentes',
                        'foreignKey' => 'banca1',
                        'propertyName' => 'docentes1',
                ]);

                $this->belongsTo('Docentes2', [
                        'className' => 'Docentes',
                        'foreignKey' => 'banca2',
                        'propertyName' => 'docentes2',
                ]);

                $this->belongsTo('Docentes3', [
                        'className' => 'Docentes',
                        'foreignKey' => 'banca3',
                        'propertyName' => 'docentes3',
                ]);

                // Monografia tem um campo areamonografia_id
                $this->belongsTo('Areamonografias', [
                        'propertyName' => 'areamonografias',
                        'className' => 'Areamonografias',
                        'foreignKey' => 'areamonografia_id',
                        'joinType' => 'LEFT'
                ]);

                // Tccestudantes tem um campo monografia_id
                $this->hasMany('Tccestudantes', [
                        'propertyName' => 'tccestudantes',
                        'className' => 'Tccestudantes',
                        'foreignKey' => 'monografia_id',
                        'joinType' => 'LEFT'
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
                        ->integer('catalogo')
                        ->allowEmptyString('catalogo');

                $validator
                        ->scalar('titulo')
                        ->maxLength('titulo', 180)
                        ->allowEmptyString('titulo');

                $validator
                        ->scalar('resumo')
                        ->maxLength('resumo', 7398)
                        ->allowEmptyString('resumo');
                /*
                  $validator
                  ->scalar('data')
                  ->maxLength('data', 10)
                  ->allowEmptyString('data');
                 */
                $validator
                        ->scalar('periodo')
                        ->maxLength('periodo', 6)
                        ->allowEmptyString('periodo');

                $validator
                        ->integer('areamonografia_id')
                        ->allowEmptyString('areamonografia_id');

                $validator
                        ->scalar('data_defesa')
                        ->maxLength('data_defesa', 10)
                        ->allowEmptyString('data_defesa');

                $validator
                        ->integer('banca1')
                        ->allowEmptyString('banca1');

                $validator
                        ->integer('banca2')
                        ->allowEmptyString('banca2');

                $validator
                        ->integer('banca3')
                        ->allowEmptyString('banca3');

                $validator
                        ->scalar('convidado')
                        ->maxLength('convidado', 50)
                        ->allowEmptyString('convidado');

                $validator
                        ->scalar('url')
                        ->maxLength('url', 13)
                        ->allowEmptyString('url');
                /*
                  $validator
                  ->dateTime('timestamp')
                  ->allowEmptyDateTime('timestamp');
                 */
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
                $rules->add($rules->existsIn(['professor_id'], 'Docentes'));
                $rules->add($rules->existsIn(['areamonografia_id'], 'Areamonografias'));

                return $rules;
        }
}
