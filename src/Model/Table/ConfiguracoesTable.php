<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Configuracoes Model
 *
 * @method \App\Model\Entity\Configuracoes newEmptyEntity()
 * @method \App\Model\Entity\Configuracoes newEntity(array $data, array $options = [])
 * @method \App\Model\Entity\Configuracoes[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Configuracoes get($primaryKey, $options = [])
 * @method \App\Model\Entity\Configuracoes findOrCreate($search, ?callable $callback = null, $options = [])
 * @method \App\Model\Entity\Configuracoes patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Configuracoes[] patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\Configuracoes|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Configuracoes saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Configuracao[]|\Cake\Datasource\ResultSetInterface|false saveMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\Configuracao[]|\Cake\Datasource\ResultSetInterface saveManyOrFail(iterable $entities, $options = [])
 * @method \App\Model\Entity\Configuracao[]|\Cake\Datasource\ResultSetInterface|false deleteMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\Configuracao[]|\Cake\Datasource\ResultSetInterface deleteManyOrFail(iterable $entities, $options = [])
 */
class ConfiguracoesTable extends Table {

    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config): void {
        parent::initialize($config);

        $this->setTable('configuracoes');
        $this->setAlias('Configuracoes');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');
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
                ->scalar('mural_periodo_atual')
                ->maxLength('mural_periodo_atual', 6)
                ->requirePresence('mural_periodo_atual', 'create')
                ->notEmptyString('mural_periodo_atual');

        $validator
                ->requirePresence('curso_turma_atual', 'create')
                ->notEmptyString('curso_turma_atual');

        $validator
                ->date('curso_abertura_inscricoes')
                ->requirePresence('curso_abertura_inscricoes', 'create')
                ->notEmptyDate('curso_abertura_inscricoes');

        $validator
                ->date('curso_encerramento_inscricoes')
                ->requirePresence('curso_encerramento_inscricoes', 'create')
                ->notEmptyDate('curso_encerramento_inscricoes');

        $validator
                ->scalar('termo_compromisso_periodo')
                ->maxLength('termo_compromisso_periodo', 6)
                ->requirePresence('termo_compromisso_periodo', 'create')
                ->notEmptyString('termo_compromisso_periodo');

        $validator
                ->date('termo_compromisso_inicio')
                ->requirePresence('termo_compromisso_inicio', 'create')
                ->notEmptyDate('termo_compromisso_inicio');

        $validator
                ->date('termo_compromisso_final')
                ->requirePresence('termo_compromisso_final', 'create')
                ->notEmptyDate('termo_compromisso_final');

        return $validator;
    }
}
