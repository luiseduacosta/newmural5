<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Questoes Table
 *
 * @property \App\Model\Table\QuestionariosTable&\Cake\ORM\Association\BelongsTo $Questionarios
 *
 * @method \App\Model\Entity\Questao newEmptyEntity()
 * @method \App\Model\Entity\Questao newEntity(array $data, array $options = [])
 * @method \App\Model\Entity\Questao[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Questao get($primaryKey, $options = [])
 * @method \App\Model\Entity\Questao findOrCreate($search, ?callable $callback = null, $options = [])
 * @method \App\Model\Entity\Questao patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Questao[] patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\Questao|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Questao saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Questao[]|\Cake\Datasource\ResultSetInterface|false saveMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\Questao[]|\Cake\Datasource\ResultSetInterface saveManyOrFail(iterable $entities, $options = [])
 * @method \App\Model\Entity\Questao[]|\Cake\Datasource\ResultSetInterface|false deleteMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\Questao[]|\Cake\Datasource\ResultSetInterface deleteManyOrFail(iterable $entities, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class QuestoesTable extends Table
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

        $this->setTable('questoes');
        $this->setAlias('Questoes');
        $this->setDisplayField('type');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('Questionarios', [
            'foreignKey' => 'questionario_id',
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
            ->integer('questionario_id')
            ->notEmptyString('questionario_id');

        $validator
            ->scalar('text')
            ->requirePresence('text', 'create')
            ->notEmptyString('text');

        $validator
            ->scalar('type')
            ->maxLength('type', 50)
            ->requirePresence('type', 'create')
            ->notEmptyString('type');

        $validator
            ->scalar('options')
            ->allowEmptyString('options');

        $validator
            ->integer('ordem')
            ->allowEmptyString('ordem');

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
        $rules->add($rules->existsIn('questionario_id', 'Questionarios'), ['errorField' => 'questionario_id']);

        return $rules;
    }
}
