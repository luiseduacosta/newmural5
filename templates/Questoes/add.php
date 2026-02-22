<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Questao $questao
 * @var \Cake\Collection\CollectionInterface|string[] $questionarios
 */
?>

<?= $this->element('menu_mural') ?>
<?= $this->element('templates') ?>

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
            <?php
            echo $this->Form->control('questionario_id', ['options' => $questionarios, 'label' => 'Questionario',
                'templates' => [
                    'inputContainer' => '<div class="form-group row mb-3">{{content}}</div>',
                    'label' => '<div class="col-sm-3"><label class="form-label"{{attrs}}>{{text}}</label></div>',
                    'select' => '<div class="col-sm-9"><select class="form-select" name="{{name}}"{{attrs}}>{{content}}</select></div>',
                    ]
                ]);
            echo $this->Form->control('text', ['type' => 'textarea', 'label' => 'Texto', 
                'templates' => [
                    'inputContainer' => '<div class="form-group row mb-3">{{content}}</div>',
                    'label' => '<div class="col-sm-3"><label class="form-label"{{attrs}}>{{text}}</label></div>',
                    'textarea' => '<div class="col-sm-9"><textarea class="form-control" name="{{name}}"{{attrs}}>{{value}}</textarea></div>',
                    ]
                ]);
            echo $this->Form->control('type', ['label' => 'Tipo (text, textarea, select, scale, boolean)', 'options' => [
                'text' => 'text', 
                'textarea' => 'textarea', 
                'radio' => 'radio', 
                'select' => 'select', 
                'scale' => 'scale (1 - 5)', 
                'boolean' => 'boolean (sim/não)'], 
                'templates' => [
                    'inputContainer' => '<div class="form-group row mb-3">{{content}}</div>',
                    'label' => '<div class="col-sm-3"><label class="form-label"{{attrs}}>{{text}}</label></div>',
                    'select' => '<div class="col-sm-9"><select class="form-select" name="{{name}}"{{attrs}}>{{content}}</select></div>',
                    ]
                ]);
            echo $this->Form->control('options', ['type' => 'textarea', 'label' => 'Opções', 'rows' => 5, 'style' => 'width: 100%', 
                'templates' => [
                    'inputContainer' => '<div class="form-group row mb-3">{{content}}</div>',
                    'label' => '<div class="col-sm-3"><label class="form-label"{{attrs}}>{{text}}</label></div>',
                    'textarea' => '<div class="col-sm-9"><textarea class="form-control" name="{{name}}"{{attrs}}>{{value}}</textarea></div>',
                    ]
                ]);
            echo $this->Form->control('ordem', ['type' => 'number', 'label' => 'Ordem', 
                'templates' => [
                    'inputContainer' => '<div class="form-group row mb-3">{{content}}</div>',
                    'number' => '<input class="form-control" name="{{name}}"{{attrs}}>{{value}}</input>',
                    ]
            ]);
            ?>
        </fieldset>
        <?= $this->Form->button(__('Confirma'), ['class' => 'btn btn-primary']) ?>
        <?= $this->Form->end() ?>
    </div>
</div>