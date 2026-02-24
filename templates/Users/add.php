<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\User $user
 */
?>

<?= $this->element('menu_mural') ?>

<?= $this->element('templates') ?>

<div class="container col-lg-8 shadow p-3 mb-5 bg-white rounded">
    <?= $this->Form->create($user) ?>
    <fieldset class="border p-2">
        <legend><?= __('Adiciona usuário') ?></legend>
        <?php
        echo $this->Form->control('email', [
            'required' => true,
            'type' => 'email',
            'label' => ['E-mail', 'class' => 'col-sm-2 form-label'],
            'templates' => [
                'formGroup' => '<div class="form-group row">{{label}}<div class="col-sm-8">{{input}}</div></div>',
                'input' => '<input class="col-sm-2 form-control " type="{{type}}" name="{{name}}"{{attrs}}/>'
            ]
        ]);
        echo $this->Form->control('password', [
            'required' => true,
            'type' => 'password',
            'label' => ['text' => 'Senha', 'class' => 'col-sm-2 form-label'],
            'templates' => [
                'formGroup' => '<div class="form-group row">{{label}}<div class="col-sm-8">{{input}}</div></div>',
                'input' => '<input class="col-sm-2 form-control " type="{{type}}" name="{{name}}"{{attrs}}/>'
            ]
        ]);
        echo $this->Form->control('categoria', [
            'label' => ['Categoria', 'class' => 'col-sm-2 form-label'],
            'options' => ['2' => 'estudante', '3' => 'professor(a)', '4' => 'supervisor(a)'],
            'templates' => [
                'formGroup' => '<div class="form-group row">{{label}}<div class="col-sm-7">{{input}}</div></div>',
                'selectContainer' => '<div class="mb-1">{{content}}</div>'
            ],
            'empty' => '-- Selecione a categoria --',
            'required' => true
        ]);
        echo $this->Form->control('numero', [
            'label' => 'Número de DRE, CRESS ou SIAPE respectivamente',
            'class' => 'col-sm-2 form-label',
            'type' => 'number',
            'required' => true,
            'templates' => [
                'formGroup' => '<div class="form-group row">{{label}}<div class="col-sm-8">{{input}}</div></div>',
                'input' => '<input class="col-sm-2 form-control " type="{{type}}" name="{{name}}"{{attrs}}/>'
            ]
        ]);
        ?>
    </fieldset>
    <?= $this->Form->button(__('Confirma'), ['class' => 'btn btn-primary', 'onclick' => 'this.disabled=true;this.form.submit();']) ?>
    <?= $this->Form->end() ?>
</div>