<?php
/**
 * Imprimir Resposta PDF
 * 
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Resposta $resposta
 */

use Cake\I18n\I18n;
use Cake\I18n\DateTime;

I18n::setLocale('pt-BR');
$hoje = DateTime::now('America/Sao_Paulo', 'pt_BR');

$this->setLayout('default');
$this->assign('title', 'Avaliação do Estagiário');
$logoUfrj = $this->Url->image('logo_ufrj.png', ['fullBase' => true]);
?>

<h2 style="text-align:center; line-height: 80%; margin: 0">
    <img src="<?= $logoUfrj ?>" alt="ESS" width="200" height="50" />
    <br />
    Avaliação do(a) estagiário(a)

</h2>

<div class="container mt-4">
    <div class="card">
        <div class="card-body" style="font-size: 12px;">
            <p><strong>Aluno(a):</strong> <?= h($resposta->estagiario->aluno->nome) ?><span>&nbsp;<strong>DRE:</strong> <?= h($resposta->estagiario->aluno->registro) ?></span></p>
            <p><strong>Supervisor(a):</strong> <?= h($resposta->estagiario->supervisor->nome ?? '____________________') ?><span>&nbsp;<strong>CRESS:</strong> <?= h($resposta->estagiario->supervisor->cress ?? '_____') ?></span></p>
            <p><strong>Instituição:</strong> <?= h($resposta->estagiario->instituicao->instituicao ?? '____________________') ?></p>
            <p><strong>Período:</strong> <?= h($resposta->estagiario->periodo) ?></p>
            <p><strong>Nível de estágio:</strong> <?= h($resposta->estagiario->nivel) ?></p>
            <p><strong>Professor(a):</strong> <?= h($resposta->estagiario->professor->nome ?? '____________________') ?></p>
        </div>
    </div>
</div>

<div class = "container mt-4">

<?php if ($resposta->respostas) { ?>
    <table class="table table-responsive table-striped table-hover" style="font-size: 12px;">
    <?php
    foreach ($resposta->respostas as $cada_resposta) {
        ?>
        <tr>
            <td colspan="2"><?= h($cada_resposta->text) ?></td>
        </tr>
        <?php
        if ($cada_resposta->type == 'textarea' || $cada_resposta->type == 'text') {
            echo '<tr><td colspan="2" style="padding-left: 20px;"><div style="border: 1px solid #000; min-height: 60px; padding: 5px;"></div></td></tr>';
            continue;
        } else if ($cada_resposta->type == 'radio' ||  $cada_resposta->type == 'checkbox' || $cada_resposta->type == 'select' || $cada_resposta->type == 'boolean') {

            $opcoes = json_decode($cada_resposta->options);
            if (is_array($opcoes) || is_object($opcoes)) {
                foreach ($opcoes as $key => $opcao) {
                echo '<tr><td style="width: 10%; padding-left: 20px;">' . h($key) . '</td><td>' . h($opcao) . '</td></tr>';
                }
            }
        }
    }
    ?>
    </table>
    <?php

 } else { ?>

    <table class="table table-responsive table-striped table-hover" style="font-size: 12px;">
    <?php
    $perguntas = json_decode($resposta->response, true);
    foreach ($perguntas as $key => $value): 
        if (!str_starts_with($key, 'avaliacao')) continue;
                    
        $label = $key;
        $displayValue = $value;
                    
        if (is_array($value) && isset($value['pergunta'])) {
            $label = $value['pergunta'];
            $displayValue = $value['texto_valor'] ?? $value['valor'];
        }
    ?>
    <tr>
        <td colspan="2" style="padding-bottom: 2px;">
            <p style="text-align: justify; font-weight: bold; margin-bottom: 5px;"><?= h($label) ?></p>
        </td>
    </tr>
    <tr>
        <td colspan="2" style="padding-top: 0;">
            <p style="text-align: justify; margin-top: 0;"><?= h($displayValue) ?></p>
        </td>
    </tr>
    <?php endforeach; ?>
    </table>
<?php } ?>

</div>

<p style="text-align:right; line-height:100%;">
Rio de Janeiro, <?= $hoje->i18nFormat("dd ' de ' MMMM ' de ' yyyy") ?>
</p>

<br />
<br />
<br />

<table class="table" style="width: 100%; background-color: white;">
    <tr>
        <td style="width: 33%"><span style="font-size: 100%; text-decoration: overline">Coordenação de Estágio</span></td>
        <td style="width: 33%"><span style="font-size: 100%; text-decoration: overline"><?= h($resposta->estagiario->aluno->nome) ?></span></td>
        <td style="width: 33%"><span style="font-size: 100%; text-decoration: overline"><?= h($resposta->estagiario->supervisor->nome ?? 'Supervisor(a)') ?></span></td>
    </tr>

    <tr>
        <td style="width: 33%"></td>
        <td style="width: 33%"><span style="font-size: 100%">DRE: <?= h($resposta->estagiario->aluno->registro) ?></span></td>
        <td style="width: 33%"><span style="font-size: 100%">CRESS: <?= h($resposta->estagiario->supervisor->cress ?? '__________') ?></span></td>
    </tr>
</table>
