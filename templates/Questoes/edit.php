<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Questao $questao
 * @var string[]|\Cake\Collection\CollectionInterface $questionarios
 */
?>

<?php echo $this->element('menu_mural') ?>

<?php echo $this->element('templates') ?>

<div class="container mt-1">
    <nav class="nav navbar-expand-lg navbar-light bg-light">
        <ul class="navbar-nav collapse navbar-collapse">
            <?php if (isset($user) && $user->categoria === '1'): ?>
            <li class="nav-item">
                <?= $this->Form->postLink(
                    __('Excluir'),
                    ['action' => 'delete', $questao->id],
                    ['confirm' => __('Tem certeza que deseja excluir este registo # {0}?', $questao->id), 'class' => 'btn btn-danger me-1']
                ) ?>
            </li>
            <?php endif; ?>
            <li class="nav-item">
                <?= $this->Html->link(__('Listar questões'), ['action' => 'index'], ['class' => 'btn btn-primary me-1']) ?>
            </li>
        </ul>
    </nav>

    <div class="container mt-1">
        <?= $this->Form->create($questao) ?>
        <fieldset>
            <legend><?= __('Editar') ?></legend>
            <?php
            echo $this->Form->control('questionario_id', ['options' => $questionarios, 'label' => 'Questionario']);
            echo $this->Form->control('text', ['label' => 'Texto', 'class' => 'form-control', 'rows' => 5, 'style' => 'width: 100%']);
            echo $this->Form->control('type', ['label' => 'Tipo (text, textarea, select, scale, boolean)', 'options' => ['text' => 'text', 'textarea' => 'textarea', 'radio' => 'radio', 'select' => 'select', 'scale' => 'scale (1 - 5)', 'boolean' => 'boolean (sim/não)'], 'class' => 'form-control']);
            echo $this->Form->control('options', ['label' => 'Opções', 'class' => 'form-control', 'rows' => 5, 'style' => 'width: 100%']);
            echo $this->Form->control('ordem', ['label' => 'Ordem', 'class' => 'form-control'], ['type' => 'number']);
            ?>
        </fieldset>
        <?= $this->Form->button(__('Confirma'), ['class' => 'btn btn-primary']) ?>
        <?= $this->Form->end() ?>
    </div>
</div>
