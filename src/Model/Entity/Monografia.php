<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Monografia Entity
 *
 * @property int $id
 * @property int|null $catalogo
 * @property string|null $titulo
 * @property string|null $resumo
 * @property string|null $data
 * @property string|null $periodo
 * @property int|null $professor_id
 * @property int|null $co_orienta_id
 * @property int|null $areamonografia_id
 * @property int|null $classificamonografia_id
 * @property string|null $data_defesa
 * @property int|null $banca1
 * @property int|null $banca2
 * @property int|null $banca3
 * @property string|null $convidado
 * @property string|null $url
 * @property \Cake\I18n\DateTime|null $timestamp
 *
 * @property \App\Model\Entity\Docente[] $docentes
 * @property \App\Model\Entity\Areamonografia[] $areamonografias
 * @property \App\Model\Entity\Tccestudante[] $tccestudantes
 */
class Monografia extends Entity
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
        'catalogo' => true,
        'titulo' => true,
        'resumo' => true,
        'data' => true,
        'periodo' => true,
        'professor_id' => true,
        'co_orienta_id' => true,
        'areamonografia_id' => true,
        'classificamonografia_id' => true,        
        'data_defesa' => true,
        'banca1' => true,
        'banca2' => true,
        'banca3' => true,
        'convidado' => true,
        'url' => true,
        'timestamp' => true,
        'docentes' => true,
        'docentes1' => true,
        'docentes2' => true,
        'docentes3' => true,
        'areamonografias' => true,
        'tccestudantes' => true,
    ];

}
