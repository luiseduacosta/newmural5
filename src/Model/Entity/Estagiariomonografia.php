<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Estagiariomonografia Entity
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
 * @property string|null $observacoes
 *
 * @property \App\Model\Entity\Docente[] $docentes
 * @property \App\Model\Entity\Estudante[] $estudantes
 * @property \App\Model\Entity\Supervisor[] $supervisores
 * @property \App\Model\Entity\Instituicao[] $instituicoes
 * @property \App\Model\Entity\Complemento[] $complementos
 * @property \App\Model\Entity\Turmaestagio[] $turmestagios
 * @property \App\Model\Entity\Avaliacao[] $avaliacoes
 * @property \App\Model\Entity\Folhadeatividade[] $folhadeatividades
 * @property \App\Model\Entity\Tccestudante[] $tccestudantes
 */
class Estagiariomonografia extends Entity
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
        'aluno_id' => true,
        'alunonovo_id' => true,
        'registro' => true,
        'turno' => true,
        'nivel' => true,
        'tc' => true,
        'tc_solicitacao' => true,
        'instituicao_id' => true,
        'supervisor_id' => true,
        'professor_id' => true,
        'periodo' => true,
        'turmaestagio_id' => true,
        'nota' => true,
        'ch' => true,
        'observacoes' => true,
        'complemento_id' => true,
        'ajuste2020' => true,
        'docentes' => true,
        'estudantes' => true,
        'supervisores' => true,
        'instituicoes' => true,
        'areaestagios' => true,
        'avaliacoes' => true,
        'folhadeatividades' => true,
        'tccestudantes' => true,
    ];
}
