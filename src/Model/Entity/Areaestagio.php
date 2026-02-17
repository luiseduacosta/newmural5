<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Areaestagio Entity
 *
 * @property int $id
 * @property string $area
 *
 * @property \App\Model\Entity\Estagiario[] $estagiarios
 * @property \App\Model\Entity\Muralestagio[] $muralestagios
 * @property \App\Model\Entity\Instituicaoestagio[] $instituicaoestagios
 */
class Areaestagio extends Entity
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
        'area' => true,
        'estagiarios' => true,
        'muralestagios' => true,
        'instituicaoestagios' => true,
        'instituicao_id' => true, // Added implicit field if missing
    ];
}
