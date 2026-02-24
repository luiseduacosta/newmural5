<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\User $user
 */
?>

<?= $this->element('menu_mural') ?>

<nav class="navbar navbar-expand-lg navbar-light" id="actions-sidebar">
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarTogglerUsereEdit"
            aria-controls="navbarTogglerUserEdit" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <ul class="navbar-nav collapse navbar-collapse" id="navbarTogglerUserEdit">
        <?php if (isset($user->categoria) && $user->categoria == '1'): ?>
            <li class="nav-link">
                <?=
                $this->Form->postLink(
                        __('Excluir'),
                        ['action' => 'delete', $user->id],
                        ['confirm' => __('Tem certeza que quer excluir este usuário # {0}?', $user->id), 'class' => 'btn btn-danger float-start']
                )
                ?>
            </li>
        <li class="nav-link">
            <?= $this->Html->link(__('Listar usuários'), ['action' => 'index'], ['class' => 'btn btn-primary float-start']) ?>
        </li>
        <?php endif; ?>
    </ul>
</nav>

<?= $this->element('templates') ?>

<div class="container col-lg-8 shadow p-3 mb-5 bg-white rounded">

    <?= $this->Form->create($user) ?>
    <fieldset class="border p-2">
        <legend><?= __('Editar usuário') ?></legend>
        <?php
        echo $this->Form->control('email');
        echo $this->Form->control('password', ['type' => 'hidden']);
        echo $this->Form->control('categoria', ['options' => ['1' => 'Outro(a)s', '2' => 'estudante', '3' => 'professor', '4' => 'supervisor']]);
        ?>
    </fieldset>
    <?= $this->Form->button(__('Confirma')) ?>
    <?= $this->Form->end() ?>
</div>