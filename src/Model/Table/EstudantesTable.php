<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Estudantes Model (clone de Alunos para usar com Monografias)
 * 
 * @property \App\Model\Table\MuralinscricoesTable&\Cake\ORM\Association\HasMany $Muralinscricoes
 * @property \App\Model\Table\EstagiariosTable&\Cake\ORM\Association\HasMany $Estagiarios
 * @property \App\Model\Table\AgendamentotccsTable&\Cake\ORM\Association\HasMany $Agendamentotccs
 * @property \App\Model\Table\TccestudantesTable&\Cake\ORM\Association\HasOne $Tccestudantes
 *
 * @method \App\Model\Entity\Estudante get($primaryKey, $options = [])
 * @method \App\Model\Entity\Estudante newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\Estudante[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Estudante|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Estudante saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Estudante patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Estudante[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\Estudante findOrCreate($search, callable $callback = null, $options = [])
 */
class EstudantesTable extends Table
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

        $this->setTable('alunos');
        $this->setAlias('Estudantes');
        $this->setDisplayField('nome');
        $this->setPrimaryKey('id');

        /** A tabela Muralinscricoes tem um campo aluno_id que se conexta com o id de Estudantes */
        $this->hasMany('Muralinscricoes', [
            'className' => 'Muralinscricoes',
            'targetForeignKey' => 'id',
            'foreignKey' => 'aluno_id',
            'joinType' => 'INNER'
        ]);

        /** A tabela Estagiarios tem um campo aluno_id que se conexta com o id de Estudantess */
        $this->hasMany('Estagiarios', [
            'className' => 'Estagiarios',
            'targetForeignKey' => 'id',
            'foreignKey' => 'aluno_id',
            'joinType' => 'INNER'
        ]);

        /** A tabela Agendamentotcc tem um campo estudante_id que se conexta com o id de Estudantes */
        $this->hasMany('Agendamentotccs', [
            'className' => 'Agendamentotccs',
            'targetForeignKey' => 'id',
            'foreignKey' => 'estudante_id',
            'joinType' => 'INNER'
        ]);

        /** A tabela Tccestudantes tem um campo registro que se conexta com o registro */
        $this->hasOne('Tccestudantes', [
            'className' => 'Tccestudantes',
            'targetForeignKey' => 'registro',
            'foreignKey' => 'registro',
            'conditions' => 'Estudantes.registro = Tccestudantes.registro',
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
            ->integer('registro')
            ->notEmptyString('registro')
            ->add('registro', 'unique', ['rule' => 'validateUnique', 'provider' => 'table']);

        $validator
            ->notEmptyString('codigo_telefone');

        $validator
            ->scalar('telefone')
            ->maxLength('telefone', 15)
            ->allowEmptyString('telefone');

        $validator
            ->notEmptyString('codigo_celular');

        $validator
            ->scalar('celular')
            ->maxLength('celular', 15)
            ->allowEmptyString('celular');

        $validator
            ->email('email')
            ->allowEmptyString('email');
        /*
                $validator
                    ->scalar('cpf')
                    ->maxLength('cpf', 12)
                    ->allowEmptyString('cpf', 'update', 'unique', ['rule' => 'validateUnique', 'provider' => 'table']);
        */
        $validator
            ->scalar('cpf')
            ->maxLength('cpf', 14)
            ->allowEmptyString('cpf');

        $validator
            ->scalar('identidade')
            ->maxLength('identidade', 15)
            ->allowEmptyString('identidade');

        $validator
            ->scalar('orgao')
            ->maxLength('orgao', 10)
            ->allowEmptyString('orgao');

        $validator
            ->date('nascimento')
            ->allowEmptyDate('nascimento');

        $validator
            ->scalar('endereco')
            ->maxLength('endereco', 50)
            ->allowEmptyString('endereco');

        $validator
            ->scalar('cep')
            ->maxLength('cep', 9)
            ->allowEmptyString('cep');

        $validator
            ->scalar('municipio')
            ->maxLength('municipio', 30)
            ->allowEmptyString('municipio');

        $validator
            ->scalar('bairro')
            ->maxLength('bairro', 30)
            ->allowEmptyString('bairro');

        $validator
            ->scalar('observacoes')
            ->maxLength('observacoes', 250)
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
        $rules->add($rules->isUnique(['email']));
        $rules->add($rules->isUnique(['registro']));
        /* $rules->add($rules->isUnique(['cpf'])); */

        return $rules;
    }
}
