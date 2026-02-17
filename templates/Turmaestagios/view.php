<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Turmaestagio $turmaestagio
 */
$user = $this->getRequest()->getAttribute('identity');
?>

<?= $this->element('menu_mural') ?>

<div class="d-flex justify-content-start">
    <nav class="navbar navbar-expand-lg py-2 navbar-light bg-light">
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarTogglerTurma"
            aria-controls="navbarTogglerTurma" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <ul class="navbar-nav collapse navbar-collapse" id="navbarTogglerTurma">
            <li class="nav-item">
                    <?= $this->Html->link(__('Listar turma de estágios'), ['action' => 'index'], ['class' => 'btn btn-primary me-1']) ?>
            </li>
            <?php if (isset($user) && $user->categoria == 1): ?>
                <li class="nav-item">
                    <?= $this->Html->link(__('Editar turma de estágio'), ['action' => 'edit', $turmaestagio->id], ['class' => 'btn btn-primary me-1']) ?>
                </li>
                <li class="nav-item">
                    <?= $this->Form->postLink(__('Excluir turma de estágio'), ['action' => 'delete', $turmaestagio->id], ['confirm' => __('Tem certeza que deseja excluir este registo # {0}?', $turmaestagio->id), 'class' => 'btn btn-danger me-1']) ?>
                </li>
                <li class="nav-item">
                    <?= $this->Html->link(__('Nova turma de estágio'), ['action' => 'add'], ['class' => 'btn btn-primary me-1']) ?>
                </li>
            <?php endif; ?>
        </ul>
    </nav>
</div>

<h3><?= h($turmaestagio->area) ?></h3>
<table class="table table-stripted table-hover table-responsive">
    <tr>
        <th><?= __('Turma de estágio') ?></th>
        <td><?= h($turmaestagio->area) ?></td>
    </tr>
    <tr>
        <th><?= __('Id') ?></th>
        <td><?= $turmaestagio->id ?></td>
    </tr>
</table>

<h4><?= __('Estagiários') ?></h4>
<?php if (!empty($turmaestagio->estagiarios)): ?>
    <table class="table table-striped table-hover table-responsive">
        <tr>
            <th><?= __('Id') ?></th>
            <th><?= __('Aluno') ?></th>
            <th><?= __('Registro') ?></th>
            <th><?= __('Ajuste curricular 2020') ?></th>
            <th><?= __('Turno') ?></th>
            <th><?= __('Nivel') ?></th>
            <th><?= __('Tc') ?></th>
            <th><?= __('Tc Solicitacao') ?></th>
            <th><?= __('Instituição') ?></th>
            <th><?= __('Supervisor') ?></th>
            <th><?= __('Professor') ?></th>
            <th><?= __('Periodo') ?></th>
            <th><?= __('Turmaestagio') ?></th>
            <?php if (isset($user) && $user->categoria_id == 1): ?>
                <th><?= __('Nota') ?></th>
                <th><?= __('Ch') ?></th>
                <th><?= __('Observacoes') ?></th>
            <?php endif; ?>
            <?php if (isset($user) && $user->categoria_id == 1): ?>
                <th><?= __('Ações') ?></th>
            <?php endif; ?>
        </tr>
        <?php foreach ($turmaestagio->estagiarios as $estagiarios): ?>
            <tr>
                <?php // pr($estagiarios); ?>
                <?php // die(); ?>
                <td><?= h($estagiarios->id) ?></td>
                <?php if (isset($user) && $user->categoria_id == 1): ?>
                    <td><?= $estagiarios->hasValue('aluno') ? $this->Html->link(h($estagiarios->aluno->nome), ['controller' => 'alunos', 'action' => 'view', $estagiarios->aluno_id]) : '' ?>
                    </td>
                <?php else: ?>
                    <td><?= $estagiarios->hasValue('aluno') ? $estagiarios->aluno->nome : '' ?></td>
                <?php endif; ?>
                <td><?= h($estagiarios->registro) ?></td>
                <td><?= h($estagiarios->ajuste2020) ?></td>
                <td><?= h($estagiarios->turno) ?></td>
                <td><?= h($estagiarios->nivel) ?></td>
                <td><?= h($estagiarios->tc) ?></td>
                <td><?= h($estagiarios->tc_solicitacao) ?></td>
                <td><?= $estagiarios->hasValue('instituicao') ? $this->Html->link(h($estagiarios->instituicao['instituicao']), ['controller' => 'Instituicoes', 'action' => 'view', $estagiarios->instituicao_id]) : '' ?>
                </td>
                <?php if (isset($user) && $user->categoria_id == 1): ?>
                    <td><?= $estagiarios->hasValue('supervisor') ? $this->Html->link(h($estagiarios->supervisor['nome']), ['controller' => 'Supervisores', 'action' => 'view', $estagiarios->supervisor_id]) : '' ?>
                    </td>
                <?php else: ?>
                    <td><?= $estagiarios->hasValue('supervisor') ? $estagiarios->supervisor['nome'] : '' ?></td>
                <?php endif; ?>
                <?php if (isset($user) && $user->categoria_id == 1): ?>
                    <td><?= $estagiarios->hasValue('professor') ? $this->Html->link(h($estagiarios->professor['nome']), ['controller' => 'Professores', 'action' => 'view', $estagiarios->professor_id]) : '' ?>
                    </td>
                <?php else: ?>
                    <td><?= $estagiarios->hasValue('professor') ? $estagiarios->professor['nome'] : '' ?></td>
                <?php endif; ?>
                <td><?= h($estagiarios->periodo) ?></td>
                <td><?= $estagiarios->hasValue('turmaestagio') ? $this->Html->link(h($estagiarios->turmaestagio['area']), ['controller' => 'Turmaestagios', 'action' => 'view', $estagiarios->turmaestagio_id]) : '' ?>
                </td>
                <?php if (isset($user) && $user->categoria_id == 1): ?>
                    <td><?= h($estagiarios->nota) ?></td>
                    <td><?= h($estagiarios->ch) ?></td>
                    <td><?= h($estagiarios->observacoes) ?></td>
                <?php endif; ?>

                <td class="d-grid">
                    <?php if (isset($user) && $user->categoria_id == 1): ?>
                        <?= $this->Html->link(__('Ver'), ['controller' => 'Estagiarios', 'action' => 'view', $estagiarios->id]) ?>
                        <?= $this->Html->link(__('Editar'), ['controller' => 'Estagiarios', 'action' => 'edit', $estagiarios->id]) ?>
                        <?= $this->Form->postLink(__('Excluir'), ['controller' => 'Estagiarios', 'action' => 'delete', $estagiarios->id], ['confirm' => __('Tem certeza que deseja excluir este registo # {0}?', $estagiarios->id), 'class' => 'btn btn-danger']) ?>
                    <?php endif; ?>
                </td>
            </tr>
        <?php endforeach; ?>
    </table>
<?php endif; ?>