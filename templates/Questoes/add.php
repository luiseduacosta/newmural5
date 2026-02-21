<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Questao $questao
 * @var \Cake\Collection\CollectionInterface|string[] $questionarios
 */
?>

<?php echo $this->element('menu_mural') ?>

<?php echo $this->element('templates') ?>

<div class="container mt-1">
    <nav class='navbar-expand-lg navbar-light bg-light'>
        <ul class="navbar-nav mr-auto">
            <li class="nav-item">
                <?= $this->Html->link(__('Listar questões'), ['action' => 'index'], ['class' => 'btn btn-primary me-1']) ?>
            </li>
        </ul>
    </nav>

    <div class="container mt-1">
        <?= $this->Form->create($questao) ?>
        <fieldset>
            <legend><?= __('Nova questão') ?></legend>
            <div class="mb-3 row">
                <?php
                echo $this->Form->label('questionario_id', "Questionário", ['class' => 'col-sm-2 col-form-label']);
                ?>
                <div class="col-sm-9">
                    <?php
                    echo $this->Form->control('questionario_id', ['options' => $questionarios, 'label' => false, 'class' => 'form-control']);
                    ?>
                </div>
            </div>
            <?php
            echo $this->Form->control('text', ['label' => 'Texto', 'class' => 'form-control']);
            echo $this->Form->control('type', ['label' => 'Tipo (text, textarea, select, scale, boolean)', 'options' => ['text' => 'text', 'textarea' => 'textarea', 'radio' => 'radio', 'select' => 'select', 'escala' => 'escala (1 - 5)', 'boolean' => 'boolean (sim/não)'], 'class' => 'form-control']);
            echo $this->Form->control('options', ['label' => 'Opções', 'class' => 'form-control']);
            echo $this->Form->control('ordem', ['label' => 'Ordem', 'value' => $ordem]);
            ?>
        </fieldset>
        <?= $this->Form->button(__('Confirma'), ['class' => 'btn btn-primary']) ?>
        <?= $this->Form->end() ?>
    </div>
</div>