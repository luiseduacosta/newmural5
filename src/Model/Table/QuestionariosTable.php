<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Questionarios Model
 *
 * @property \App\Model\Table\QuestionesTable&\Cake\ORM\Association\HasMany $Questiones
 *
 * @method \App\Model\Entity\Questionario newEmptyEntity()
 * @method \App\Model\Entity\Questionario newEntity(array $data, array $options = [])
 * @method \App\Model\Entity\Questionario[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Questionario get($primaryKey, $options = [])
 * @method \App\Model\Entity\Questionario findOrCreate($search, ?callable $callback = null, $options = [])
 * @method \App\Model\Entity\Questionario patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Questionario[] patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\Questionario|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Questionario saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Questionario[]|\Cake\Datasource\ResultSetInterface|false saveMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\Questionario[]|\Cake\Datasource\ResultSetInterface saveManyOrFail(iterable $entities, $options = [])
 * @method \App\Model\Entity\Questionario[]|\Cake\Datasource\ResultSetInterface|false deleteMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\Questionario[]|\Cake\Datasource\ResultSetInterface deleteManyOrFail(iterable $entities, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class QuestionariosTable extends Table
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

        $this->setTable('questionarios');
        $this->setDisplayField('title');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->hasMany('Questoes', [
            'foreignKey' => 'questionario_id',
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
            ->scalar('title')
            ->maxLength('title', 255)
            ->requirePresence('title', 'create')
            ->notEmptyString('title');

        $validator
            ->scalar('description')
            ->allowEmptyString('description');

        $validator
            ->boolean('is_active')
            ->notEmptyString('is_active');

        $validator
            ->scalar('category')
            ->maxLength('category', 100)
            ->allowEmptyString('category');

        $validator
            ->scalar('target_user_type')
            ->maxLength('target_user_type', 50)
            ->allowEmptyString('target_user_type');

        return $validator;
    }
}
