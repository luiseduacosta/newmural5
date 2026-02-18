<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Visita Entity
 *
 * @property int $id
 * @property int $instituicao_id
 * @property \Cake\I18n\Date $data
 * @property string $motivo
 * @property string $responsavel
 * @property string|null $descricao
 * @property string $avaliacao
 *
 * @property \App\Model\Entity\Instituicao[] $instituicoes
 */
class Visita extends Entity
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
        'instituicao_id' => true,
        'data' => true,
        'motivo' => true,
        'responsavel' => true,
        'descricao' => true,
        'avaliacao' => true,
        'instituicoes' => true,
    ];
}
