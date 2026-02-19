<?php

declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Turmaestagios Model
 *
 * @property \App\Model\Table\EstagiariosTable&\Cake\ORM\Association\HasMany $Estagiarios
 * @property \App\Model\Table\MuralestagiosTable&\Cake\ORM\Association\HasMany $Muralestagios
 * @property \App\Model\Table\InstituicoesTable&\Cake\ORM\Association\HasMany $Instituicoes
 * 
 * @method \App\Model\Entity\Turmaestagio newEmptyEntity()
 * @method \App\Model\Entity\Turmaestagio newEntity(array $data, array $options = [])
 * @method \App\Model\Entity\Turmaestagio[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Turmaestagio get($primaryKey, $options = [])
 * @method \App\Model\Entity\Turmaestagio findOrCreate($search, ?callable $callback = null, $options = [])
 * @method \App\Model\Entity\Turmaestagio patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Turmaestagio[] patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\Turmaestagio|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Turmaaestagio saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Turmaestagio[]|\Cake\Datasource\ResultSetInterface|false saveMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\Turmaestagio[]|\Cake\Datasource\ResultSetInterface saveManyOrFail(iterable $entities, $options = [])
 * @method \App\Model\Entity\Turmaestagio[]|\Cake\Datasource\ResultSetInterface|false deleteMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\Turmaestagio[]|\Cake\Datasource\ResultSetInterface deleteManyOrFail(iterable $entities, $options = [])
 */
class TurmaestagiosTable extends Table {

    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config): void {
        parent::initialize($config);

        $this->setTable('turma_estagios');
        $this->setAlias('Turmaestagios');
        $this->setDisplayField('area');
        $this->setPrimaryKey('id');

        $this->hasMany('Estagiarios', [
            'foreignKey' => 'turmaestagio_id',
        ]);
        $this->hasMany('Muralestagios', [
            'foreignKey' => 'turmaestagio_id',
        ]);
        $this->hasMany('Instituicoes', [
            'foreignKey' => 'turmaestagio_id',
        ]);
    }

    public function beforeFind($event, $query, $options, $primary) {

        $query->order(['Turmaestagios.area' => 'ASC']);
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
                ->allowEmptyString('id', null, 'create');

        $validator
                ->scalar('area')
                ->maxLength('area', 70)
                ->notEmptyString('area');

        return $validator;
    }

}
