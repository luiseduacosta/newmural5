<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Muralinscricao Entity
 *
 * @property int $id
 * @property int $registro // id_aluno -> registro
 * @property int $aluno_id // alunonovo_id -> aluno_id
 * @property int $muralestagio_id
 * @property \Cake\I18n\Date $data
 * @property string $periodo
 * @property \Cake\I18n\DateTime $timestamp
 *
 * @property int|null $alunoestagiario_id // aluno_id -> alunoestagiario_id
 * @property \App\Model\Entity\Aluno[] $alunos
 * @property \App\Model\Entity\Muralestagio[] $muralestagios
 */
class Muralinscricao extends Entity
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
        'registro' => true, // id_aluno -> registro 
        'aluno_id' => true, // alunonovo_id -> aluno_id
        'muralestagio_id' => true,
        'data' => true,
        'periodo' => true,
        'timestamp' => true,
        'alunoestagiario_id' => true, // aluno_id -> alunoestagiario_id Obsoleto
        'alunos' => true,
        'muralestagios' => true,
    ];
}
