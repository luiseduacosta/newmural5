<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Muralestagio Entity
 *
 * @property int $id
 * @property int|null $instituicao_id // id_estagio -> instituicao_id
 * @property string $instituicao
 * @property string $convenio
 * @property int $vagas
 * @property string|null $beneficios
 * @property string|null $final_de_semana
 * @property int|null $cargaHoraria
 * @property string|null $requisitos
 * @property int $turmaestagio_id // id_area -> turmaestagio_id
 * @property string|null $horario
 * @property int $professor_id // id_professor -> professor_id
 * @property \Cake\I18n\Date|null $dataSelecao
 * @property \Cake\I18n\Date|null $dataInscricao
 * @property string|null $horarioSelecao
 * @property string|null $localSelecao
 * @property string|null $formaSelecao
 * @property string|null $contato
 * @property string|null $outras
 * @property string|null $periodo
 * @property \Cake\I18n\Date|null $datafax
 * @property string $localInscricao
 * @property string|null $email
 *
 * @property \App\Model\Entity\Instituicao[] $instituicoes
 * @property \App\Model\Entity\Turmaestagio[] $turmaestagios
 * @property \App\Model\Entity\Professor[] $professores
 * @property \App\Model\Entity\Muralinscricao[] $muralinscricoes
 */
class Muralestagio extends Entity
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
        'instituicao' => true,
        'convenio' => true,
        'vagas' => true,
        'beneficios' => true,
        'final_de_semana' => true,
        'cargaHoraria' => true,
        'requisitos' => true,
        'turmaestagio_id' => true,
        'horario' => true,
        'professor_id' => true,
        'dataSelecao' => true,
        'dataInscricao' => true,
        'horarioSelecao' => true,
        'localSelecao' => true,
        'formaSelecao' => true,
        'contato' => true,
        'outras' => true,
        'periodo' => true,
        'datafax' => true,
        'localInscricao' => true,
        'email' => true,
        'instituicoes' => true, // corrigir a tabela ou corrigir o nome do campo
        'turmaestagios' => true,
        'professores' => true,
        'muralinscricoes' => true,
    ];
}
