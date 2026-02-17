<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Turmaestagio[]|\Cake\Collection\CollectionInterface $turmaestagios
 */
$user = $this->getRequest()->getAttribute('identity');
?>

<?= $this->element('menu_mural') ?>

<nav class="navbar navbar-expand-lg py-2 navbar-light bg-light">
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarTogglerTurma"
            aria-controls="navbarTogglerTurma" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
    </button>
    <ul class="navbar-nav collapse navbar-collapse" id="navbarTogglerTurma">
    <?php if (isset($user) && $user->categoria == '1'): ?>
        <li class="nav-item">
            <?= $this->Html->link(__('Nova turma de estágio'), ['action' => 'add'], ['class' => 'btn btn-primary float-end']) ?>
        </li>
    <?php endif; ?>
    </ul>
</nav>

<h3><?= __('Turmas de estágios') ?></h3>

<div class="container col-lg-8 shadow p-3 mb-5 bg-white rounded">
    <table class="table table-striped table-hover table-responsive">
        <thead class="table-dark">
            <tr>
                <th><?= $this->Paginator->sort('id') ?></th>
                <th><?= $this->Paginator->sort('area') ?></th>
                <th><?= __('Ações') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($turmaestagios as $turmaestagio): ?>
                <tr>
                    <td><?= $turmaestagio->id ?></td>
                    <td><?= h($turmaestagio->area) ?></td>
                    <td>
                        <?= $this->Html->link(__('Ver'), ['action' => 'view', $turmaestagio->id]) ?>
                        <?php if (isset($user) && $user->categoria_id == 1): ?>
                            <?= $this->Html->link(__('Editar'), ['action' => 'edit', $turmaestagio->id]) ?>
                            <?= $this->Form->postLink(__('Excluir'), ['action' => 'delete', $turmaestagio->id], ['confirm' => __('Tem certeza que deseja excluir este registo # {0}?', $turmaestagio->id), 'class' => 'btn btn-danger']) ?>
                        <?php endif; ?>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<?= $this->element('templates'); ?>

<div class="d-flex justify-content-center">
    <div class="paginator">
        <ul class="pagination">
            <?= $this->element('paginator') ?>
        </ul>
    </div>
    <?= $this->element('paginator_count') ?>
</div>