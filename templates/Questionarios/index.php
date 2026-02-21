<?php
/**
 * @var \App\View\AppView $this
 * @var iterable<\App\Model\Entity\Questionario $questionarios
 */
?>

<?= $this->element('menu_mural') ?>
<?= $this->element('templates') ?>

<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <ul class="navbar-nav mr-auto">
        <?php if (isset($user) && $user->categoria == '1'): ?>
        <li class="nav-item active">
            <?= $this->Html->link(__('Novo Questionario'), ['controller' => 'Questionarios', 'action' => 'add'], ['class' => 'btn btn-primary']) ?>
        </li>
        <?php endif; ?>
    </ul>
</nav>

<h3><?= __('Questionarios') ?></h3>

<div class="container mt-4">
    <table class="table table-striped table-hover table-responsive">
        <thead class="thead-light">
            <tr>
                <th><?= $this->Paginator->sort('id', 'ID') ?></th>
                <th><?= $this->Paginator->sort('title', 'Título') ?></th>
                <th><?= $this->Paginator->sort('created', 'Criado') ?></th>
                <th><?= $this->Paginator->sort('modified', 'Modificado') ?></th>
                <th><?= $this->Paginator->sort('is_active', 'Activo') ?></th>
                <th><?= $this->Paginator->sort('category', 'Categoria') ?></th>
                <th><?= $this->Paginator->sort('target_user_type', 'Tipo de usuário alvo') ?></th>
                <th><?= __('Ações') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($questionarios as $questionario): ?>
                <tr>
                    <td><?= $this->Number->format($questionario->id) ?></td>
                    <td><?= h($questionario->title) ?></td>
                    <td><?= $this->Time->format($questionario->created, 'd-MM-Y HH:mm:ss') ?></td>
                    <td><?= $this->Time->format($questionario->modified, 'd-MM-Y HH:mm:ss') ?></td>
                    <td><?= h($questionario->is_active) ?></td>
                    <td><?= h($questionario->category) ?></td>
                    <td><?= h($questionario->target_user_type) ?></td>
                    <td class="d-grid">
                        <?= $this->Html->link(__('Ver'), ['action' => 'view', $questionario->id], ['class' => 'btn btn-primary btn-sm btn-block p-1 mb-1']) ?>
                        <?php if (isset($user) && $user->categoria == '1'): ?>
                            <?= $this->Html->link(__('Editar'), ['action' => 'edit', $questionario->id], ['class' => 'btn btn-primary btn-sm btn-block p-1 mb-1']) ?>
                            <?= $this->Form->postLink(__('Excluir'), ['action' => 'delete', $questionario->id], ['confirm' => __('Tem certeza que deseja excluir este registo # {0}?', $questionario->id), 'class' => 'btn btn-danger btn-sm btn-block p-1 mb-1']) ?>
                        <?php endif; ?>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<div class="paginator">
    <ul class="pagination">
        <?= $this->Paginator->first('<< ' . __('primeiro')) ?>
        <?= $this->Paginator->prev('< ' . __('anterior')) ?>
        <?= $this->Paginator->numbers() ?>
        <?= $this->Paginator->next(__('próximo') . ' >') ?>
        <?= $this->Paginator->last(__('último') . ' >>') ?>
    </ul>
    <p><?= $this->Paginator->counter(__('Página {{page}} de {{pages}}, mostrando {{current}} registros de um total de {{count}}.')) ?>
    </p>
</div>
