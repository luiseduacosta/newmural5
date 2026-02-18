<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Aluno Entity
 *
 * @property int $id
 * @property string $nome
 * @property int $registro
 * @property int $codigo_telefone
 * @property string|null $telefone
 * @property int $codigo_celular
 * @property string|null $celular
 * @property string|null $email
 * @property string|null $cpf
 * @property string|null $identidade
 * @property string|null $orgao
 * @property \Cake\I18n\Date|null $nascimento
 * @property string|null $ingresso
 * @property string|null $turno
 * @property string|null $endereco
 * @property string|null $cep
 * @property string|null $municipio
 * @property string|null $bairro
 * @property string|null $observacoes
 *
 * @property \App\Model\Entity\Estagiario[] $estagiarios
 * @property \App\Model\Entity\Muralinscricao[] $muralinscricoes
 */
class Aluno extends Entity
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
        'nome' => true,
        'registro' => true,
        'codigo_telefone' => true,
        'telefone' => true,
        'codigo_celular' => true,
        'celular' => true,
        'email' => true,
        'cpf' => true,
        'identidade' => true,
        'orgao' => true,
        'nascimento' => true,
        'ingresso' => true,
        'turno' => true,
        'endereco' => true,
        'cep' => true,
        'municipio' => true,
        'bairro' => true,
        'observacoes' => true,
        'estagiarios' => true,
        'muralinscricoes' => true,
    ];
}
