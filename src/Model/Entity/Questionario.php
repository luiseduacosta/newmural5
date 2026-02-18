<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Questionario Entity
 *
 * @property int $id
 * @property string $title
 * @property string|null $description
 * @property \Cake\I18n\DateTime|null $created
 * @property \Cake\I18n\DateTime|null $modified
 * @property bool $is_active
 * @property string|null $category
 * @property string|null $target_user_type
 *
 * @property \App\Model\Entity\Questione[] $questiones
 */
class Questionario extends Entity
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
        'title' => true,
        'description' => true,
        'created' => true,
        'modified' => true,
        'is_active' => true,
        'category' => true,
        'target_user_type' => true,
        'questiones' => true,
    ];
}
