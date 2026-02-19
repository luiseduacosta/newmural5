<?php

declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Areainstituicoes Model
 *
 * @property \App\Model\Table\InstituicoesTable&\Cake\ORM\Association\HasMany $Instituicoes
 * 
 * @method \App\Model\Entity\Areainstituicao newEmptyEntity()
 * @method \App\Model\Entity\Areainstituicao newEntity(array $data, array $options = [])
 * @method \App\Model\Entity\Areainstituicao[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Areainstituicao get($primaryKey, $options = [])
 * @method \App\Model\Entity\Areainstituicao findOrCreate($search, ?callable $callback = null, $options = [])
 * @method \App\Model\Entity\Areainstituicao patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Areainstituicao[] patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\Areainstituicao|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Areainstituicao saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Areainstituicao[]|\Cake\Datasource\ResultSetInterface|false saveMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\Areainstituicao[]|\Cake\Datasource\ResultSetInterface saveManyOrFail(iterable $entities, $options = [])
 * @method \App\Model\Entity\Areainstituicao[]|\Cake\Datasource\ResultSetInterface|false deleteMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\Areainstituicao[]|\Cake\Datasource\ResultSetInterface deleteManyOrFail(iterable $entities, $options = [])
 */
class AreainstituicoesTable extends Table {

    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config): void {
        parent::initialize($config);

        $this->setTable('area_instituicoes');
        $this->setAlias('Areainstituicoes');
        $this->setDisplayField('area');
        $this->setPrimaryKey('id');

        $this->hasMany('Instituicoes', [
            'foreignKey' => 'areainstituicoes_id',
        ]);
    }

    public function beforeFind($event, $query, $options, $primary) {

        $query->order(['Areainstituicoes.area' => 'ASC']);
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
                ->maxLength('area', 90)
                ->notEmptyString('area');

        return $validator;
    }

}
