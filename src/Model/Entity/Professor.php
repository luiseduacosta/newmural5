<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Professor Entity
 *
 * @property int $id
 * @property string $nome
 * @property string|null $cpf
 * @property int|null $siape
 * @property int|null $rg
 * @property string|null $orgaoexpedidor
 * @property \Cake\I18n\Date|null $datanascimento
 * @property string|null $localnascimento
 * @property string|null $sexo
 * @property string $ddd_telefone
 * @property string|null $telefone
 * @property string $ddd_celular
 * @property string|null $celular
 * @property string|null $email
 * @property string|null $homepage
 * @property string|null $redesocial
 * @property string|null $endereco
 * @property string|null $bairro
 * @property string|null $cep
 * @property string|null $cidade
 * @property string|null $estado
 * @property string|null $pais
 * @property string|null $curriculolattes
 * @property \Cake\I18n\Date|null $atualizacaolattes
 * @property string|null $curriculosigma
 * @property string|null $pesquisadordgp
 * @property string|null $formacaoprofissional
 * @property string|null $universidadedegraduacao
 * @property int|null $anoformacao
 * @property string|null $mestradoarea
 * @property string|null $mestradouniversidade
 * @property int|null $mestradoanoconclusao
 * @property string|null $doutoradoarea
 * @property string|null $doutoradouniversidade
 * @property int|null $doutoradoanoconclusao
 * @property \Cake\I18n\Date|null $dataingresso
 * @property string|null $formaingresso
 * @property string|null $tipocargo
 * @property string|null $categoria
 * @property string|null $regimetrabalho
 * @property string|null $departamento
 * @property \Cake\I18n\Date|null $dataegresso
 * @property string|null $motivoegresso
 * @property string|null $observacoes
 *
 * @property \App\Model\Entity\Estagiario[] $estagiarios
 * @property \App\Model\Entity\Muralestagio[] $muralestagios
 * @property \App\Model\Entity\User[] $users
 */
class Professor extends Entity
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
        'id' => false,
        'nome' => true,
        'cpf' => true,
        'siape' => true,
        'rg' => true,
        'orgaoexpedidor' => true,
        'datanascimento' => true,
        'localnascimento' => true,
        'sexo' => true,
        'ddd_telefone' => true,
        'telefone' => true,
        'ddd_celular' => true,
        'celular' => true,
        'email' => true,
        'homepage' => true,
        'redesocial' => true,
        'endereco' => true,
        'bairro' => true,
        'cep' => true,
        'cidade' => true,
        'estado' => true,
        'pais' => true,
        'curriculolattes' => true,
        'atualizacaolattes' => true,
        'curriculosigma' => true,
        'pesquisadordgp' => true,
        'formacaoprofissional' => true,
        'universidadedegraduacao' => true,
        'anoformacao' => true,
        'mestradoarea' => true,
        'mestradouniversidade' => true,
        'mestradoanoconclusao' => true,
        'doutoradoarea' => true,
        'doutoradouniversidade' => true,
        'doutoradoanoconclusao' => true,
        'dataingresso' => true,
        'formaingresso' => true,
        'tipocargo' => true,
        'categoria' => true,
        'regimetrabalho' => true,
        'departamento' => true,
        'dataegresso' => true,
        'motivoegresso' => true,
        'observacoes' => true,
        'estagiarios' => true,
        'muralestagios' => true,
        'users' => true,
    ];
}
