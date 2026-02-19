<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Instituicoes Model
 *
 * @property \App\Model\Table\AreainstituicoesTable&\Cake\ORM\Association\BelongsTo $Areainstituicoes
 * @property \App\Model\Table\EstagiariosTable&\Cake\ORM\Association\HasMany $Estagiarios
 * @property \App\Model\Table\MuralestagiosTable&\Cake\ORM\Association\HasMany $Muralestagios
 * @property \App\Model\Table\VisitasTable&\Cake\ORM\Association\HasMany $Visitas
 * @property \App\Model\Table\SupervisoresTable&\Cake\ORM\Association\BelongsToMany $Supervisores
 *
 * @method \App\Model\Entity\Instituicao newEmptyEntity()
 * @method \App\Model\Entity\Instituicao newEntity(array $data, array $options = [])
 * @method \App\Model\Entity\Instituicao[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Instituicao get($primaryKey, $options = [])
 * @method \App\Model\Entity\Instituicao findOrCreate($search, ?callable $callback = null, $options = [])
 * @method \App\Model\Entity\Instituicao patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Instituicao[] patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\Instituicao|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Instituicao saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Instituicao[]|\Cake\Datasource\ResultSetInterface|false saveMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\Instituicao[]|\Cake\Datasource\ResultSetInterface saveManyOrFail(iterable $entities, $options = [])
 * @method \App\Model\Entity\Instituicao[]|\Cake\Datasource\ResultSetInterface|false deleteMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\Instituicao[]|\Cake\Datasource\ResultSetInterface deleteManyOrFail(iterable $entities, $options = [])
 */
class InstituicoesTable extends Table
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

        $this->setTable('estagio');
        $this->setAlias('Instituicoes');
        $this->setDisplayField('instituicao');
        $this->setPrimaryKey('id');

        $this->belongsTo('Areainstituicoes', [
            'className' => 'Areainstituicoes',
            'foreignKey' => 'areainstituicoes_id',
        ]);
        $this->hasMany('Estagiarios', [
            'foreignKey' => 'instituicao_id',
        ]);
        $this->hasMany('Muralestagios', [
            'foreignKey' => 'instituicao_id',
        ]);
        $this->hasMany('Visitas', [
            'foreignKey' => 'instituicao_id',
        ]);
        $this->belongsToMany('Supervisores', [
            'className' => 'Supervisores',
            'foreignKey' => 'instituicao_id',
            'targetForeignKey' => 'supervisor_id',
            'joinTable' => 'inst_super',
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
            ->scalar('instituicao')
            ->maxLength('instituicao', 120)
            ->notEmptyString('instituicao');

        $validator
            ->allowEmptyString('area');

        $validator
            ->scalar('natureza')
            ->maxLength('natureza', 50)
            ->allowEmptyString('natureza');

        $validator
            ->scalar('cnpj')
            ->maxLength('cnpj', 18)
            ->requirePresence('cnpj', 'create')
            ->notEmptyString('cnpj');

        $validator
            ->email('email')
            ->allowEmptyString('email');

        $validator
            ->scalar('url')
            ->maxLength('url', 100)
            ->allowEmptyString('url');

        $validator
            ->scalar('endereco')
            ->maxLength('endereco', 105)
            ->notEmptyString('endereco');

        $validator
            ->scalar('bairro')
            ->maxLength('bairro', 30)
            ->requirePresence('bairro', 'create')
            ->notEmptyString('bairro');

        $validator
            ->scalar('municipio')
            ->maxLength('municipio', 30)
            ->requirePresence('municipio', 'create')
            ->notEmptyString('municipio');

        $validator
            ->scalar('cep')
            ->maxLength('cep', 9)
            ->notEmptyString('cep');

        $validator
            ->scalar('telefone')
            ->maxLength('telefone', 50)
            ->notEmptyString('telefone');

        $validator
            ->scalar('fax')
            ->maxLength('fax', 20)
            ->allowEmptyString('fax');

        $validator
            ->scalar('beneficio')
            ->maxLength('beneficio', 50)
            ->allowEmptyString('beneficio');

        $validator
            ->scalar('fim_de_semana')
            ->maxLength('fim_de_semana', 1)
            ->allowEmptyString('fim_de_semana');

        $validator
            ->scalar('localInscricao')
            ->notEmptyString('localInscricao');

        $validator
            ->integer('convenio')
            ->requirePresence('convenio', 'create')
            ->notEmptyString('convenio');

        $validator
            ->date('expira')
            ->allowEmptyDate('expira');

        $validator
            ->scalar('seguro')
            ->maxLength('seguro', 1)
            ->requirePresence('seguro', 'create')
            ->notEmptyString('seguro');

        $validator
            ->scalar('avaliacao')
            ->notEmptyString('avaliacao');

        $validator
            ->scalar('observacoes')
            ->maxLength('observacoes', 255)
            ->allowEmptyString('observacoes');

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
        $rules->add($rules->existsIn(['areainstituicoes_id'], 'Areainstituicoes'), ['errorField' => 'areainstituicoes_id']);

        return $rules;
    }
}
