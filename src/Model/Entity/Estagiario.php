<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Estagiario Entity
 *
 * @property int $id
 * @property int $aluno_id
 * @property int $registro
 * @property string $turno
 * @property string $nivel
 * @property int $tc
 * @property \Cake\I18n\Date|null $tc_solicitacao
 * @property int $instituicao_id
 * @property int|null $supervisor_id
 * @property int|null $professor_id
 * @property string $periodo
 * @property int|null $turmaestagio_id
 * @property float|null $nota
 * @property int|null $ch
 * @property string $ajuste2020
 * @property string|null $observacoes
 *
 * @property \App\Model\Entity\Aluno[] $aluno
 * @property \App\Model\Entity\Professor[] $professor
 * @property \App\Model\Entity\Turmaestagio[] $turmaestagio
 * @property \App\Model\Entity\Supervisor[] $supervisor
 * @property \App\Model\Entity\Instituicao[] $instituicao
 * @property \App\Model\Entity\Avaliacao[] $avaliacao
 * @property \App\Model\Entity\Avaliacao[] $resposta
 * @property \App\Model\Entity\Folhadeatividade[] $folhadeatividade
 * @property \App\Model\Entity\Tccestudante[] $tccestudante
 */
class Estagiario extends Entity
{
    /**
     * Fields that can be mass assigned using newEntity() or patchEntity().
     *
     * Note that when '*' is set to true, this allows all unspecified fields to
     * be mass assigned. For security purposes, it is advised to set '*' to false
     * (or remove it), and explicitly make individual fields accessible as needed.
     *
     * @var array
     */
    protected array $_accessible = [
        "aluno_id" => true,
        "registro" => true,
        "turno" => true,
        "nivel" => true,
        "tc" => true,
        "tc_solicitacao" => true,
        "instituicao_id" => true,
        "supervisor_id" => true,
        "professor_id" => true,
        "periodo" => true,
        "area_id" => true,
        "nota" => true,
        "ch" => true,
        "ajuste2020" => true,
        "observacoes" => true,
        "aluno" => true,
        "professor" => true,
        "turmaestagio" => true,
        "supervisor" => true,
        "instituicao" => true,
        "avaliacao" => true,
        "resposta" => true,
        "folhadeatividade" => true,
        "tccestudante" => true,
    ];
}
