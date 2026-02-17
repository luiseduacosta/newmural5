<?php

declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Areaestagios Model
 *
 * @property \App\Model\Table\EstagiariosTable&\Cake\ORM\Association\HasMany $Estagiarios
 * @property \App\Model\Table\MuralestagiosTable&\Cake\ORM\Association\HasMany $Muralestagios
 * @property \App\Model\Table\InstituicaoestagiosTable&\Cake\ORM\Association\HasMany $Instituicaoestagios
 * 
 * @method \App\Model\Entity\Areaestagio newEmptyEntity()
 * @method \App\Model\Entity\Areaestagio newEntity(array $data, array $options = [])
 * @method \App\Model\Entity\Areaestagio[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Areaestagio get($primaryKey, $options = [])
 * @method \App\Model\Entity\Areaestagio findOrCreate($search, ?callable $callback = null, $options = [])
 * @method \App\Model\Entity\Areaestagio patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Areaestagio[] patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\Areaestagio|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Areaestagio saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Areaestagio[]|\Cake\Datasource\ResultSetInterface|false saveMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\Areaestagio[]|\Cake\Datasource\ResultSetInterface saveManyOrFail(iterable $entities, $options = [])
 * @method \App\Model\Entity\Areaestagio[]|\Cake\Datasource\ResultSetInterface|false deleteMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\Areaestagio[]|\Cake\Datasource\ResultSetInterface deleteManyOrFail(iterable $entities, $options = [])
 */
class AreaestagiosTable extends Table {

    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config): void {
        parent::initialize($config);

        $this->setTable('areas_estagio');
        $this->setAlias('Areaestagios');
        $this->setDisplayField('area');
        $this->setPrimaryKey('id');

        $this->hasMany('Estagiarios', [
            'foreignKey' => 'areaestagio_id',
        ]);
        $this->hasMany('Muralestagios', [
            'foreignKey' => 'areaestagio_id',
        ]);
        $this->hasMany('Instituicaoestagios', [
            'foreignKey' => 'areaestagio_id',
        ]);
    }

    public function beforeFind($event, $query, $options, $primary) {

        $query->order(['area' => 'ASC']);
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
