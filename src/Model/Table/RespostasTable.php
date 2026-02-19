<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Respostas Model
 *
 * @property \App\Model\Table\QuestionesTable&\Cake\ORM\Association\BelongsTo $Questiones
 * @property \App\Model\Table\EstagiariosTable&\Cake\ORM\Association\BelongsTo $Estagiarios
 *
 * @method \App\Model\Entity\Resposta newEmptyEntity()
 * @method \App\Model\Entity\Resposta newEntity(array $data, array $options = [])
 * @method \App\Model\Entity\Resposta[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Resposta get($primaryKey, $options = [])
 * @method \App\Model\Entity\Resposta findOrCreate($search, ?callable $callback = null, $options = [])
 * @method \App\Model\Entity\Resposta patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Resposta[] patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\Resposta|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Resposta saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Resposta[]|\Cake\Datasource\ResultSetInterface|false saveMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\Resposta[]|\Cake\Datasource\ResultSetInterface saveManyOrFail(iterable $entities, $options = [])
 * @method \App\Model\Entity\Resposta[]|\Cake\Datasource\ResultSetInterface|false deleteMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\Resposta[]|\Cake\Datasource\ResultSetInterface deleteManyOrFail(iterable $entities, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class RespostasTable extends Table
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

        $this->setTable('respostas');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('Questiones', [
            'foreignKey' => 'question_id',
            'joinType' => 'INNER',
        ]);
        $this->belongsTo('Estagiarios', [
            'foreignKey' => 'estagiarios_id',
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
            ->integer('question_id')
            ->notEmptyString('question_id');

        $validator
            ->integer('estagiarios_id')
            ->notEmptyString('estagiarios_id');

        $validator
            ->scalar('response')
            ->allowEmptyString('response');

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
        $rules->add($rules->existsIn('question_id', 'Questiones'), ['errorField' => 'question_id']);
        $rules->add($rules->existsIn('estagiarios_id', 'Estagiarios'), ['errorField' => 'estagiarios_id']);

        return $rules;
    }
}
