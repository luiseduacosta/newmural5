<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Avaliacoes Model
 *
 * @property \App\Model\Table\EstagiariosTable&\Cake\ORM\Association\BelongsTo $Estagiarios
 *
 * @method \App\Model\Entity\Avaliacao newEmptyEntity()
 * @method \App\Model\Entity\Avaliacao newEntity(array $data, array $options = [])
 * @method \App\Model\Entity\Avaliacao[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Avaliacao get($primaryKey, $options = [])
 * @method \App\Model\Entity\Avaliacao findOrCreate($search, ?callable $callback = null, $options = [])
 * @method \App\Model\Entity\Avaliacao patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Avaliacao[] patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\Avaliacao|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Avaliacao saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Avaliacao[]|\Cake\Datasource\ResultSetInterface|false saveMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\Avaliacao[]|\Cake\Datasource\ResultSetInterface saveManyOrFail(iterable $entities, $options = [])
 * @method \App\Model\Entity\Avaliacao[]|\Cake\Datasource\ResultSetInterface|false deleteMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\Avaliacao[]|\Cake\Datasource\ResultSetInterface deleteManyOrFail(iterable $entities, $options = [])
 */
class AvaliacoesTable extends Table
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

        $this->setTable('avaliacoes');
        $this->setAlias('Avaliacoes');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->belongsTo('Estagiarios', [
            'foreignKey' => 'estagiario_id',
            'joinType' => 'INNER',
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
            ->scalar('avaliacao1')
            ->maxLength('avaliacao1', 1)
            ->requirePresence('avaliacao1', 'create')
            ->notEmptyString('avaliacao1');

        $validator
            ->scalar('avaliacao2')
            ->maxLength('avaliacao2', 1)
            ->requirePresence('avaliacao2', 'create')
            ->notEmptyString('avaliacao2');

        $validator
            ->scalar('avaliacao3')
            ->maxLength('avaliacao3', 1)
            ->requirePresence('avaliacao3', 'create')
            ->notEmptyString('avaliacao3');

        $validator
            ->scalar('avaliacao4')
            ->maxLength('avaliacao4', 1)
            ->requirePresence('avaliacao4', 'create')
            ->notEmptyString('avaliacao4');

        $validator
            ->scalar('avaliacao5')
            ->maxLength('avaliacao5', 1)
            ->requirePresence('avaliacao5', 'create')
            ->notEmptyString('avaliacao5');

        $validator
            ->scalar('avaliacao6')
            ->maxLength('avaliacao6', 1)
            ->requirePresence('avaliacao6', 'create')
            ->notEmptyString('avaliacao6');

        $validator
            ->scalar('avaliacao7')
            ->maxLength('avaliacao7', 1)
            ->requirePresence('avaliacao7', 'create')
            ->notEmptyString('avaliacao7');

        $validator
            ->scalar('avaliacao8')
            ->maxLength('avaliacao8', 1)
            ->requirePresence('avaliacao8', 'create')
            ->notEmptyString('avaliacao8');

        $validator
            ->scalar('avaliacao9')
            ->maxLength('avaliacao9', 1)
            ->requirePresence('avaliacao9', 'create')
            ->notEmptyString('avaliacao9');

        $validator
            ->scalar('avaliacao9_1')
            ->maxLength('avaliacao9_1', 255)
            ->allowEmptyString('avaliacao9_1');

        $validator
            ->scalar('avaliacao10')
            ->maxLength('avaliacao10', 1)
            ->requirePresence('avaliacao10', 'create')
            ->notEmptyString('avaliacao10');

        $validator
            ->scalar('avaliacao10_1')
            ->maxLength('avaliacao10_1', 255)
            ->allowEmptyString('avaliacao10_1');

        $validator
            ->scalar('avaliacao11')
            ->maxLength('avaliacao11', 1)
            ->requirePresence('avaliacao11', 'create')
            ->notEmptyString('avaliacao11');

        $validator
            ->scalar('avaliacao11_1')
            ->maxLength('avaliacao11_1', 255)
            ->allowEmptyString('avaliacao11_1');

        $validator
            ->scalar('avaliacao12')
            ->maxLength('avaliacao12', 1)
            ->requirePresence('avaliacao12', 'create')
            ->notEmptyString('avaliacao12');

        $validator
            ->scalar('avaliacao12_1')
            ->maxLength('avaliacao12_1', 255)
            ->allowEmptyString('avaliacao12_1');

        $validator
            ->scalar('avaliacao13')
            ->maxLength('avaliacao13', 1)
            ->requirePresence('avaliacao13', 'create')
            ->notEmptyString('avaliacao13');

        $validator
            ->scalar('avaliacao13_1')
            ->maxLength('avaliacao13_1', 255)
            ->allowEmptyString('avaliacao13_1');

        $validator
            ->scalar('avaliacao14')
            ->maxLength('avaliacao14', 255)
            ->requirePresence('avaliacao14', 'create')
            ->notEmptyString('avaliacao14');

        $validator
            ->scalar('observacoes')
            ->maxLength('observacoes', 255)
            ->requirePresence('observacoes', 'create')
            ->notEmptyString('observacoes');

        $validator
            ->dateTime('TIMESTAMP')
            ->notEmptyDateTime('TIMESTAMP');

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
        $rules->add($rules->existsIn(['estagiario_id'], 'Estagiarios'), ['errorField' => 'estagiario_id']);

        return $rules;
    }
}
