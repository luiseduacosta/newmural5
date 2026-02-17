<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Visitas Model
 *
 * @property \App\Model\Table\InstituicoesTable&\Cake\ORM\Association\BelongsTo $Instituicoes
 *
 * @method \App\Model\Entity\Visita newEmptyEntity()
 * @method \App\Model\Entity\Visita newEntity(array $data, array $options = [])
 * @method \App\Model\Entity\Visita[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Visita get($primaryKey, $options = [])
 * @method \App\Model\Entity\Visita findOrCreate($search, ?callable $callback = null, $options = [])
 * @method \App\Model\Entity\Visita patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Visita[] patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\Visita|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Visita saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Visita[]|\Cake\Datasource\ResultSetInterface|false saveMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\Visita[]|\Cake\Datasource\ResultSetInterface saveManyOrFail(iterable $entities, $options = [])
 * @method \App\Model\Entity\Visita[]|\Cake\Datasource\ResultSetInterface|false deleteMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\Visita[]|\Cake\Datasource\ResultSetInterface deleteManyOrFail(iterable $entities, $options = [])
 * 
 */
class VisitasTable extends Table
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

        $this->setTable('visita');
        $this->setAlias('Visitas');
        $this->setDisplayField('instituicao_id');
        $this->setPrimaryKey('id');

        $this->belongsTo('Instituicoes', [
            'foreignKey' => 'instituicao_id',
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
            ->date('data')
            ->requirePresence('data', 'create')
            ->notEmptyDate('data');

        $validator
            ->scalar('motivo')
            ->maxLength('motivo', 256)
            ->requirePresence('motivo', 'create')
            ->notEmptyString('motivo');

        $validator
            ->scalar('responsavel')
            ->maxLength('responsavel', 50)
            ->requirePresence('responsavel', 'create')
            ->notEmptyString('responsavel');

        $validator
            ->scalar('descricao')
            ->allowEmptyString('descricao');

        $validator
            ->scalar('avaliacao')
            ->maxLength('avaliacao', 50)
            ->requirePresence('avaliacao', 'create')
            ->notEmptyString('avaliacao');

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

        return $rules;
    }
}
