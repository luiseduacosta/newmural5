<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Configuracao $configuracao
 */
$user = $this->getRequest()->getAttribute('identity');
?>

<?= $this->element('menu_mural') ?>

<nav class="navbar navbar-expand-lg py-2 navbar-light bg-light">
    <ul class="navbar-nav collapse navbar-collapse">
        <li class="nav-item">
            <?= $this->Html->link(__('Listar configurações'), ['action' => 'index'], ['class' => 'btn btn-primary']) ?>
        </li>
    </ul>
</nav>

<?= $this->element('templates') ?>

<div class="container col-lg-8 shadow p-3 mb-5 bg-white rounded">
    <?= $this->Form->create($configuracao) ?>
    <fieldset>
        <legend><?= __('Editar configurações') ?></legend>
        <?php
        echo $this->Form->control('mural_periodo_atual', ['label' => ['text' => 'Período do mural de estágios']]);
        echo $this->Form->control('termo_compromisso_periodo', ['label' => ['text' => 'Período do termo de compromisso']]);
        echo $this->Form->control('termo_compromisso_inicio', ['label' => ['text' => 'Data de início do termo de compromisso']]);
        echo $this->Form->control('termo_compromisso_final', ['label' => ['text' => 'Data de finalização do termo de compromisso']]);
        echo $this->Form->control('periodo_calendario_academico');
        echo $this->Form->control('curso_turma_atual');
        echo $this->Form->control('curso_abertura_inscricoes');
        echo $this->Form->control('curso_encerramento_inscricoes');
        ?>
    </fieldset>
    <?= $this->Form->button(__('Salvar'), ['class' => 'btn btn-primary']) ?>
    <?= $this->Form->end() ?>
</div>