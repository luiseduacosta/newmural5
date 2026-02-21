<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Questionario $questionario
 */
?>
<?= $this->element('menu_mural') ?>
<?= $this->element('templates') ?>

<div class="container mt-1">
    <nav class="nav navbar-expand-lg navbar-light bg-light">
        <ul class="navbar-nav collapse navbar-collapse">
            <?php if (isset($user) && $user->categoria == '1'): ?>
            <li class="nav-item">
                <?= $this->Form->postLink(
                    __('Excluir'),
                    ['controller' => 'Questionarios', 'action' => 'delete', $questionario->id],
                    ['confirm' => __('Tem certeza que deseja excluir este registo # {0}?', $questionario->id), 'class' => 'btn btn-danger me-1']
                ) ?>
            </li>
            <?php endif; ?>
            <li class="nav-item">
                <?= $this->Html->link(__('Listar'), ['controller' => 'Questionarios', 'action' => 'index'], ['class' => 'btn btn-primary me-1']) ?>
            </li>
        </ul>
    </nav>

    <div class="container mt-1">
        <?= $this->Form->create($questionario) ?>
        <fieldset>
            <legend><?= __('Editar questionário') ?></legend>
            <?php
            echo $this->Form->control('title');
            echo $this->Form->control('description');
            echo $this->Form->control('is_active');
            echo $this->Form->control('category');
            echo $this->Form->control('target_user_type');
            ?>
        </fieldset>
        <?= $this->Form->button(__('Confirma'), ['class' => 'btn btn-primary']) ?>
        <?= $this->Form->end() ?>
    </div>
</div>