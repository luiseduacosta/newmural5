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
            <?= $this->Html->link(__('Editar configurações'), ['action' => 'edit', $configuracao->id], ['class' => 'btn btn-primary float-right']) ?>
        </li>
    </ul>
</nav>

<div class="container col-lg-12 shadow p-3 mb-5 bg-white rounded">
    <h3>Configurações</h3>
    <table class="table table-striped table-hover table-responsive">
        <tr>
            <th><?= __('Id') ?></th>
            <td><?= $configuracao->id ?></td>
        </tr>
        <tr>
            <th><?= __('Período do mural de estágios') ?></th>
            <td><?= h($configuracao->mural_periodo_atual) ?></td>
        </tr>
        <tr>
            <th><?= __('Período do termo de compromisso') ?></th>
            <td><?= h($configuracao->termo_compromisso_periodo) ?></td>
        </tr>
        <tr>
            <th><?= __('Data de início do termo de compromisso') ?></th>
            <td><?= h($configuracao->termo_compromisso_inicio) ?></td>
        </tr>
        <tr>
            <th><?= __('Data de finalização do termo de compromisso') ?></th>
            <td><?= h($configuracao->termo_compromisso_final) ?></td>
        </tr>
        <tr>
            <th><?= __('Período calendário acadêmico') ?></th>
            <td><?= h($configuracao->periodo_calendario_academico) ?></td>
        </tr>      
        <tr>
            <th><?= __('Curso Turma Atual') ?></th>
            <td><?= $configuracao->curso_turma_atual ?></td>
        </tr>
        <tr>
            <th><?= __('Curso Abertura Inscricoes') ?></th>
            <td><?= h($configuracao->curso_abertura_inscricoes) ?></td>
        </tr>
        <tr>
            <th><?= __('Curso Encerramento Inscricoes') ?></th>
            <td><?= h($configuracao->curso_encerramento_inscricoes) ?></td>
        </tr>
    </table>
</div>