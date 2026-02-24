<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\User $user
 */
?>

<?= $this->element('menu_mural') ?>

<nav class="navbar navbar-expand-lg navbar-light" id="actions-sidebar">
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarTogglerUseresView"
            aria-controls="navbarTogglerUsersView" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <ul class="navbar-nav collapse navbar-collapse" id="navbarTogglerUserView">
        <?php if (isset($user->categoria) && $user->categoria == '1'): ?>
            <li class="nav-item">
                <?= $this->Html->link(__('Novo usuário'), ['action' => 'add'], ['class' => 'btn btn-primary me-1']) ?>
            </li>
            <li class="nav-item">
                <?= $this->Html->link(__('Editar usuário'), ['action' => 'edit', $user->id], ['class' => 'btn btn-primary me-1']) ?>
            </li>
            <li class="nva-item">
                <?= $this->Form->postLink(__('Excluir usuaŕio'), ['action' => 'delete', $user->id], ['confirm' => __('Tem certeza que quer excluir # {0}?', $user->id), 'class' => 'btn btn-danger me-1']) ?>
            </li>
        <?php endif; ?>
        <li class="nav-item">
            <?= $this->Html->link(__('Listar usuarios'), ['action' => 'index'], ['class' => 'btn btn-primary me-1']) ?>
        </li>
    </ul>
</nav>

<div class="container col-lg-8 shadow p-3 mb-5 bg-white rounded">
    <h3><?= h($user->id) ?></h3>
    <table class="table table-striped table-hover table-responsive">
        <tr>
            <th scope="row"><?= __('Email') ?></th>
            <td><?= h($user->email) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Categoria') ?></th>
            <td><?= h($user->categoria) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Id') ?></th>
            <td><?= $this->Number->format($user->id) ?></td>
        </tr>
    </table>
</div>