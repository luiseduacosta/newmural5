<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Folhadeatividades Model
 * 
 * @property \App\Model\Table\EstagiariosTable&\Cake\ORM\Association\BelongsTo $Estagiarios
 *
 * @method \App\Model\Entity\Folhadeatividade newEmptyEntity()
 * @method \App\Model\Entity\Folhadeatividade newEntity(array $data, array $options = [])
 * @method \App\Model\Entity\Folhadeatividade[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Folhadeatividade get($primaryKey, $options = [])
 * @method \App\Model\Entity\Folhadeatividade findOrCreate($search, ?callable $callback = null, $options = [])
 * @method \App\Model\Entity\Folhadeatividade patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Folhadeatividade[] patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\Folhadeatividade|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Folhadeatividade saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Folhadeatividade[]|\Cake\Datasource\ResultSetInterface|false saveMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\Folhadeatividade[]|\Cake\Datasource\ResultSetInterface saveManyOrFail(iterable $entities, $options = [])
 * @method \App\Model\Entity\Folhadeatividade[]|\Cake\Datasource\ResultSetInterface|false deleteMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\Folhadeatividade[]|\Cake\Datasource\ResultSetInterface deleteManyOrFail(iterable $entities, $options = [])
 */
class FolhadeatividadesTable extends Table {

    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config): void {
        parent::initialize($config);

        $this->setTable('folhadeatividades');
        $this->setAlias('Folhadeatividades');
        $this->setDisplayField('atividade');
        $this->setPrimaryKey('id');

        $this->belongsTo('Estagiarios', [
            'foreignKey' => 'estagiario_id',
        ]);
    }

    public function beforeFind($event, $query, $options, $primary) {

        $query->order(['Folhadeatividades.dia' => 'ASC']);
        return $query;
    }

    /**
     * Default validation rules.
     *
     * @param \Cake\Validation\Validator $validator Validator instance.
     * @return \Cake\Validation\Validator
     */
    public function validationDefault(Validator $validator): Validator {
        $validator
                ->integer('id')
                ->allowEmptyString('id', null, 'create');

        $validator
                ->date('dia')
                ->requirePresence('dia', 'create')
                ->notEmptyDate('dia');

        $validator
                ->time('inicio')
                ->requirePresence('inicio', 'create')
                ->notEmptyTime('inicio');

        $validator
                ->time('final')
                ->requirePresence('final', 'create')
                ->notEmptyTime('final');

        $validator
                ->time('horario')
                ->allowEmptyTime('horario');

        $validator
                ->scalar('atividade')
                ->maxLength('atividade', 100)
                ->requirePresence('atividade', 'create')
                ->notEmptyString('atividade');

        return $validator;
    }

    /**
     * Returns a rules checker object that will be used for validating
     * application integrity.
     *
     * @param \Cake\ORM\RulesChecker $rules The rules object to be modified.
     * @return \Cake\ORM\RulesChecker
     */
    public function buildRules(RulesChecker $rules): RulesChecker {
        $rules->add($rules->existsIn(['estagiario_id'], 'Estagiarios'), ['errorField' => 'estagiario_id']);

        return $rules;
    }

}
