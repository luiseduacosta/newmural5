<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Supervisor Entity
 *
 * @property int $id
 * @property string $nome
 * @property string $cpf
 * @property string $endereco
 * @property string $bairro
 * @property string $municipio
 * @property string $cep
 * @property string $codigo_tel
 * @property string $telefone
 * @property string $codigo_cel
 * @property string $celular
 * @property string|null $email
 * @property string $escola
 * @property string $ano_formatura
 * @property int|null $cress
 * @property int $regiao
 * @property string|null $outros_estudos
 * @property string|null $area_curso
 * @property string|null $ano_curso
 * @property string|null $cargo
 * @property int|null $num_inscricao
 * @property string|null $curso_turma
 * @property string|null $observacoes
 *
 * @property \App\Model\Entity\Estagiario[] $estagiarios
 * @property \App\Model\Entity\User[] $users
 * @property \App\Model\Entity\Instituicao[] $instituicoes
 */
class Supervisor extends Entity
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
        'cpf' => true,
        'endereco' => true,
        'bairro' => true,
        'municipio' => true,
        'cep' => true,
        'codigo_tel' => true,
        'telefone' => true,
        'codigo_cel' => true,
        'celular' => true,
        'email' => true,
        'escola' => true,
        'ano_formatura' => true,
        'cress' => true,
        'regiao' => true,
        'outros_estudos' => true,
        'area_curso' => true,
        'ano_curso' => true,
        'cargo' => true,
        'num_inscricao' => true,
        'curso_turma' => true,
        'observacoes' => true,
        'estagiarios' => true,
        'users' => true,
        'instituicoes' => true,
    ];
}
