<?php

namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Tccestudantes Model
 *
 * @property \Cake\ORM\Association\BelongsTo $Monografias
 * @property \Cake\ORM\Association\HasOne $Estudantes
 * 
 * @method \App\Model\Entity\Tccestudante get($primaryKey, $options = [])
 * @method \App\Model\Entity\Tccestudante newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\Tccestudante[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Tccestudante|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Tccestudante saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Tccestudante patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Tccestudante[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\Tccestudante findOrCreate($search, callable $callback = null, $options = [])
 */
class TccestudantesTable extends Table
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

        $this->setTable('tccestudantes');
        $this->setAlias('Tccestudantes');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        // Tccestudantes tem uma monografia
        $this->belongsTo('Monografias', [
            'foreignKey' => 'monografia_id',
            'className' => 'Monografias',
            'propertyName' => 'monografias',
            'joinType' => 'LEFT'
        ]);

        // Tccestudantes com estudantes para usar em Monografias
        $this->hasOne('Estudantes', [
            'className' => 'Estudantes',
            'propertyName' => 'estudantes',
            'foreignKey' => false,
            'conditions' => 'Tccestudantes.registro = Estudantes.registro',
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
            ->scalar('nome')
            ->maxLength('nome', 50)
            ->notEmptyString('nome');

        $validator
            ->scalar('registro')
            ->maxLength('registro', 10)
            ->allowEmptyString('registro');

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
        $rules->add($rules->existsIn(['monografia_id'], 'Monografias'));

        return $rules;
    }

}
