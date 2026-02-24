<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Estagiarios Model
 *
 * @property \App\Model\Table\AlunosTable&\Cake\ORM\Association\BelongsTo $Alunos
 * @property \App\Model\Table\ProfessoresTable&\Cake\ORM\Association\BelongsTo $Professores
 * @property \App\Model\Table\TurmaestagiosTable&\Cake\ORM\Association\BelongsTo $Turmestagios
 * @property \App\Model\Table\SupervisoresTable&\Cake\ORM\Association\BelongsTo $Supervisores
 * @property \App\Model\Table\InstituicoesTable&\Cake\ORM\Association\BelongsTo $Instituicoes
 * @property \App\Model\Table\AvaliacoesTable&\Cake\ORM\Association\HasOne $Avaliacao
 * @property \App\Model\Table\FolhadeatividadesTable&\Cake\ORM\Association\HasMany $Folhadeatividade
 *
 * @method \App\Model\Entity\Estagiario get($primaryKey, $options = [])
 * @method \App\Model\Entity\Estagiario newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\Estagiario[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Estagiario|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Estagiario saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Estagiario patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Estagiario[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\Estagiario findOrCreate($search, callable $callback = null, $options = [])
 */
class EstagiariosTable extends Table
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

        $this->setTable("estagiarios");
        $this->setAlias("Estagiarios");
        $this->setDisplayField("id");
        $this->setPrimaryKey("id");

        $this->belongsTo("Alunos", [
            "className" => "Alunos",
            "foreignKey" => "aluno_id",
            "joinType" => "LEFT",
        ]);

        $this->belongsTo("Professores", [
            "foreignKey" => "professor_id",
        ]);

        $this->belongsTo("Turmaestagios", [
            "foreignKey" => "turmaestagio_id",
        ]);

        $this->belongsTo("Supervisores", [
            "foreignKey" => "supervisor_id",
        ]);

        $this->belongsTo("Instituicoes", [
            "className" => "Instituicoes",
            "foreignKey" => "instituicao_id",
        ]);

        $this->hasOne("Avaliacoes", [
            "foreignKey" => "estagiario_id",
            "joinType" => "LEFT",
        ]);

        $this->hasOne("Respostas", [
            "foreignKey" => "estagiario_id",
            "joinType" => "LEFT",
        ]);

        $this->hasMany("Folhadeatividades", [
            "foreignKey" => "estagiario_id",
            "order" => ["Folhadeatividades.dia" => "ASC"],
        ]);

        $this->belongsTo("Tccestudantes", [
            "className" => "Tccestudantes",
            "foreignKey" => false,
            "conditions" => ["Estagiarios.registro = Tccestudantes.registro"],
            "joinType" => "LEFT",
        ]);
    }

    public function beforeFind($event, $query, $options, $primary)
    {
        $query->order([
            "Estagiarios.registro" => "ASC",
            "Estagiarios.nivel" => "ASC",
        ]);
        return $query;
    }

    /**
     * Default validation rules.
     *
     * @param \Cake\Validation\Validator $validator Validator instance.
     * @return \Cake\Validation\Validator
     */
    public function validationDefault(Validator $validator): Validator
    {
        $validator->integer("id")->allowEmptyString("id", null, "create");

        $validator->integer("registro")->notEmptyString("registro");

        $validator
            //->multipleOptions( "turno", ["D" => "Diurno", "N" => "Noturno", "I" => "Indefinido"], "Selecione um turno", )
            ->inList('turno', ['D', 'N', 'I'], 'Selecione um turno')
            ->scalar("turno")
            ->maxLength("turno", 1)
            ->notEmptyString("turno");

        $validator
            ->inList(
                "nivel",
                ["1", "2", "3", "4", "9"],
                "Selecione um dos níveis",
            )
            ->scalar("nivel")
            ->maxLength("nivel", 1)
            ->notEmptyString("nivel");

        $validator
             //->multipleOptions("tc", ["0" => "0", "1" => "1"])
            ->inList("tc", ["0", "1"])
            ->notEmptyString("tc");

        $validator->date("tc_solicitacao")->allowEmptyDate("tc_solicitacao");

        $validator->notEmptyString("instituicao_id");

        $validator->allowEmptyString("supervisor_id");

        $validator
            ->scalar("periodo")
            ->maxLength("periodo", 6)
            ->notEmptyString("periodo");

        $validator
            ->naturalNumber("turmaestagio_id")
            ->allowEmptyString("turmaestagio_id");

        $validator
            ->decimal("nota")
            ->range("nota", [0, 10], "Digite a nota")
            ->allowEmptyString("nota");

        $validator->allowEmptyString("ch");

        $validator
            ->scalar("observacoes")
            ->maxLength("observacoes", 255)
            ->allowEmptyString("observacoes");

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
        $rules->add($rules->existsIn(["aluno_id"], "Alunos"));
        $rules->add($rules->existsIn(["professor_id"], "Professores"));
        $rules->add($rules->existsIn(["turmaestagio_id"], "Turmaestagios"));
        $rules->add($rules->existsIn(["supervisor_id"], "Supervisores"));
        $rules->add($rules->existsIn(["instituicao_id"], "Instituicoes"));
        $rules->add($rules->existsIn(["tccaluno_id"], "Tccestudantes"));

        return $rules;
    }
}
