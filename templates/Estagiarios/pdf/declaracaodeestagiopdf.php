<?php
/**
 * Declaração de Estágio PDF
 * 
 * @var \App\Model\Entity\Estagiario $estagiario
 */

use Cake\I18n\DateTime;
use Cake\I18n\I18n;

I18n::setLocale('pt-BR');
$hoje = DateTime::now('America/Sao_Paulo', 'pt_BR');

$this->layout = 'pdf/default';
$this->assign('title', 'Declaração de Estágio');

$nivel = $estagiario->nivel;
if ($nivel == '9') {
    $nivel = "estágio extra-curricular";
}

$horas = $estagiario->ch;
if (empty($horas) && $horas === '0') {
    $horas = '_____';
}

$supervisora = $estagiario->supervisor->nome ?? null;
if (empty($supervisora)) {
    $supervisora = "______________________________________";
}

$regiao = $estagiario->supervisor->regiao ?? null;
if (empty($regiao)) {
    $regiao = '___';
}

$cress = $estagiario->supervisor->cress ?? null;
if (empty($cress)) {
    $cress = '_______';
}
?>

<h1 style="text-align:center">
<img src="<?= $logoUfrj ?>" alt="ESS" width="200" height="50" />
<br />
Coordenação de Estágio<br />
Declaração de Estágio Curricular
</h1>
<br />
<br />
<p style="text-align:justify; line-height: 2.5;">
Declaramos que o/a estudante <b><?= h($estagiario->aluno->nome) ?></b> 
inscrito(a) no CPF sob o nº <?= h($estagiario->aluno->cpf) ?> 
e no RG nº <?= h($estagiario->aluno->identidade) ?> 
expedido por <?= h($estagiario->aluno->orgao) ?> 
matriculado(a) no Curso de Serviço Social da 
Universidade Federal do Rio de Janeiro com o número <?= h($estagiario->aluno->registro) ?>, 
estagiou na instituição <b><?= h($estagiario->instituicao->instituicao) ?></b>, 
com a supervisão profissional do/a Assistente Social <b><?= h($supervisora) ?></b> 
registrada no CRESS <?= h($regiao) ?>&ordf; região 
com o número <?= h($cress) ?>, 
no semestre de <?= h($estagiario->periodo) ?>, 
com uma carga horária de <?= h($horas) ?> horas.
<p>

<p style="text-align:justify; line-height: 2.5;">
As atividades desenvolvidas correspondem ao 
nível <?= h($nivel) ?> do currículo da Escola de Serviço Social da UFRJ.
</p>
<br />
<br />
<p style="text-align:right">Rio de Janeiro, <?= $hoje->i18nFormat("dd ' de ' MMMM ' de ' yyyy") ?>.</p>

<br style='line-height: 10.0'/>

<table style="width:100%">
<tr>
<td style="text-decoration: overline;">Coordenação de Estágio</td>
<td style="text-decoration: overline;"><?= h($estagiario->aluno->nome) ?></td>
<td style="text-decoration: overline;"><?= h($supervisora) ?></td>
</tr>

<tr>
<td>Escola de Serviço Social</td>
<td>DRE: <?= h($estagiario->aluno->registro) ?></td>
<td>CRESS: <?= h($cress) ?> da <?= h($regiao) ?>&ordf; Região</td>
</tr>

<tr>
<td>UFRJ</td>
<td></td>
<td></td>
</tr>

</table>
