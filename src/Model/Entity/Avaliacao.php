<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Avaliacao Entity
 *
 * @property int $id
 * @property int $estagiario_id
 * @property string $avaliacao1
 * @property string $avaliacao2
 * @property string $avaliacao3
 * @property string $avaliacao4
 * @property string $avaliacao5
 * @property string $avaliacao6
 * @property string $avaliacao7
 * @property string $avaliacao8
 * @property string $avaliacao9
 * @property string|null $avaliacao9_1
 * @property string $avaliacao10
 * @property string|null $avaliacao10_1
 * @property string $avaliacao11
 * @property string|null $avaliacao11_1
 * @property string $avaliacao12
 * @property string|null $avaliacao12_1
 * @property string $avaliacao13
 * @property string|null $avaliacao13_1
 * @property string $avaliacao14
 * @property string $observacoes
 * @property \Cake\I18n\DateTime $TIMESTAMP
 *
 * @property \App\Model\Entity\Estagiario[] $estagiarios
 */
class Avaliacao extends Entity
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
        'estagiario_id' => true,
        'avaliacao1' => true,
        'avaliacao2' => true,
        'avaliacao3' => true,
        'avaliacao4' => true,
        'avaliacao5' => true,
        'avaliacao6' => true,
        'avaliacao7' => true,
        'avaliacao8' => true,
        'avaliacao9' => true,
        'avaliacao9_1' => true,
        'avaliacao10' => true,
        'avaliacao10_1' => true,
        'avaliacao11' => true,
        'avaliacao11_1' => true,
        'avaliacao12' => true,
        'avaliacao12_1' => true,
        'avaliacao13' => true,
        'avaliacao13_1' => true,
        'avaliacao14' => true,
        'observacoes' => true,
        'TIMESTAMP' => true,
        'estagiarios' => true,
    ];
}
