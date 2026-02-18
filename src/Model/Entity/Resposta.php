<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Resposta Entity
 *
 * @property int $id
 * @property int $question_id
 * @property int $estagiarios_id
 * @property string|null $response
 * @property \Cake\I18n\DateTime|null $created
 * @property \Cake\I18n\DateTime|null $modified
 *
 * @property \App\Model\Entity\Questione $questione
 * @property \App\Model\Entity\Estagiario $estagiario
 */
class Resposta extends Entity
{
    /**
     * Fields that can be mass assigned using newEntity() or patchEntity().
     *
     * Note that when '*' is set to true, this allows all unspecified fields to
     * be mass assigned. For security purposes, it is advised to set '*' to false
     * (or remove it), and explicitly make individual fields accessible as needed.
     *
     * @var array<string, bool>
     */
    protected array $_accessible = [
        'question_id' => true,
        'estagiarios_id' => true,
        'response' => true,
        'created' => true,
        'modified' => true,
        'questione' => true,
        'estagiario' => true,
    ];
}
