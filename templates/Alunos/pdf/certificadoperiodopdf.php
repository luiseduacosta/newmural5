<?php
/**
 * Certificado de Período PDF
 * 
 * @var \App\Model\Entity\Aluno $aluno
 * @var int $totalperiodos
 */

use Cake\I18n\DateTime;
use Cake\I18n\I18n;

I18n::setLocale('pt-BR');
$hoje = DateTime::now('America/Sao_Paulo', 'pt_BR');

if ($aluno->turno == 'diurno') {
    $duracaocurso = '8';
} elseif ($aluno->turno == 'noturno') {
    $duracaocurso = '10';
}

$this->layout = 'pdf/default';
$this->assign('title', 'Certificado de Período');
?>

<h1 style="text-align:center">
    <img src="<?= $logoUfrj ?>" alt="ESS" width="200" height="50" />
    <br />
    Coordenação de Estágio<br />
    Declaração
</h1>
<br />
<br />
<p style="text-align:justify; line-height: 2.5;">
    Declaramos que o/a aluno <b><?= h($aluno->nome) ?></b> 
    inscrito(a) no CPF sob o nº <?= h($aluno->cpf) ?> 
    e no RG nº <?= h($aluno->identidade) ?> 
    expedido por <?= h($aluno->orgao) ?>, 
    matriculado(a) no Curso de Serviço Social da 
    Universidade Federal do Rio de Janeiro com o número <?= h($aluno->registro) ?>, 
    ingressou em <?= h($aluno->ingresso) ?> no turno <?= ucfirst(h($aluno->turno)) ?>
    cursando atualmente <?= $totalperiodos ?><sup>o</sup> período.
<p>

<p style="text-align:justify; line-height: 2.5;">
    O turno <?= ucfirst(h($aluno->turno)) ?> do curso de Serviço Social consta de <?= ($aluno->turno == 'diurno') ? '8' : '10' ?> semestres.
</p>
<br />
<br />
<p style="text-align:right">Rio de Janeiro, <?= $hoje->i18nFormat("dd ' de ' MMMM ' de ' yyyy") ?>.</p>

<br style='line-height: 10.0'/>

<table style="width:100%">
    <tr>
        <td style="text-decoration: overline;">Coordenação de Estágio</td>
    </tr>
    <tr>
        <td>Escola de Serviço Social</td>
    </tr>
    <tr>
        <td>Universidade Federal do Rio de Janeiro</td>
    </tr>
</table>
