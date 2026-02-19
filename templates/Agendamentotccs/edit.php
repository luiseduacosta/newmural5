<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Agendamentotcc $agendamentotcc
 */
$user = $this->getRequest()->getAttribute('identity');
?>

<?php echo $this->element('menu_monografias') ?>

<nav class="navbar navbar-expand-lg py-2 navbar-light bg-light" id="actions-sidebar">
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbar"
        aria-controls="navbar" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbar">
        <ul class="navbar-nav me-auto mb-2 mb-lg-0">
            <?php if (isset($user->categoria) && $user->categoria == '1'): ?>
                <li class="nav-item">
                    <?= $this->Form->postLink(
                        __('Excluir'),
                        ['action' => 'delete', $agendamentotcc->id],
                        ['confirm' => __('Tem certeza que deseja excluir este registo # {0}?', $agendamentotcc->id), 'class' => 'btn btn-danger me-1']
                    ) ?>
                </li>
            <?php endif; ?>
        </ul>
    </div>
</nav>

<?= $this->element('templates') ?>

<div class="container col-lg-8 shadow p-3 mb-5 bg-white rounded">
    <?= $this->Form->create($agendamentotcc) ?>
    <fieldset class="border p-2">
        <legend><?= __('Editar agendamento de defesa de TCC') ?></legend>
        <?php
        echo $this->Form->control('estudante_id', [
            'options' => $estudantes,
            'type' => 'select',
            'div' => false,
            'class' => 'form-control',
            'templates' => [
                'inputContainer' => '<div class="row mb-3" {{type}}{{required}}">{{content}}</div>',
                'label' => '<label class="col-sm-3 col-form-label"{{attrs}}>{{text}}</label>',
                'select' => '<div class="col-sm-9"><select class="form-select" name="{{name}}"{{attrs}}>{{content}}</select></div>'
            ]
        ]);
        echo $this->Form->control('docente_id', [
            'options' => $docentes,
            'type' => 'select',
            'div' => false,
            'class' => 'form-control',
            'templates' => [
                'inputContainer' => '<div class="row mb-3" {{type}}{{required}}">{{content}}</div>',
                'label' => '<label class="col-sm-3 col-form-label"{{attrs}}>{{text}}</label>',
                'select' => '<div class="col-sm-9"><select class="form-select" name="{{name}}"{{attrs}}>{{content}}</select></div>'
            ]
        ]);
        echo $this->Form->control('banca1', [
            'options' => $docentes,
            'type' => 'select',
            'div' => false,
            'class' => 'form-control',
            'templates' => [
                'inputContainer' => '<div class="row mb-3" {{type}}{{required}}">{{content}}</div>',
                'label' => '<label class="col-sm-3 col-form-label"{{attrs}}>{{text}}</label>',
                'select' => '<div class="col-sm-9"><select class="form-select" name="{{name}}"{{attrs}}>{{content}}</select></div>'
            ]
        ]);
        echo $this->Form->control('banca2', [
            'options' => $docentes,
            'type' => 'select',
            'div' => false,
            'class' => 'form-control',
            'templates' => [
                'inputContainer' => '<div class="row mb-3" {{type}}{{required}}">{{content}}</div>',
                'label' => '<label class="col-sm-3 col-form-label"{{attrs}}>{{text}}</label>',
                'select' => '<div class="col-sm-9"><select class="form-select" name="{{name}}"{{attrs}}>{{content}}</select></div>'
            ]
        ]);
        echo $this->Form->control('convidado', [
            'label' => 'Convidado(a)',
            'templates' => [
                'inputContainer' => '<div class="row mb-3" {{type}}{{required}}">{{content}}</div>',
                'label' => '<label class="col-sm-3 col-form-label"{{attrs}}>{{text}}</label>',
                'input' => '<div class="col-sm-9"><input class="form-control" name="{{name}}" type="text"{{attrs}}></div>'
            ]
        ]);
        echo $this->Form->control('data', [
            'type' => 'date', 
            'templates' => ['dateWidget' => '{{day}}{{month}}{{year}}']
        ]);
        echo $this->Form->control('horario', [
            'type' => 'time', 
            'templates' => ['timeWidget' => '{{HH}}{{mm}}{{ss}}']
        ]);
        echo $this->Form->control('sala', [
            'label' => 'Sala. Colocar 0 se for não-presencial', 
            'default' => '0', 
            'templates' => [
                'inputContainer' => '<div class="row mb-3" {{type}}{{required}}">{{content}}</div>',
                'label' => '<label class="col-sm-3 col-form-label"{{attrs}}>{{text}}</label>',
                'input' => '<div class="col-sm-9"><input class="form-control" name="{{name}}" type="text"{{attrs}}></div>'
            ]
        ]);
        echo $this->Form->control('titulo', [
            'label' => 'Título',
            'placeholder' => 'Digite o título com até 180 carateres',
            'maxlength' => '180',
            'rows' => '5',
            'id' => 'caraterestitulo',
            'onkeyup' => 'contatitulo()',
            'templates' => [
                'inputContainer' => '<div class="row mb-3" {{type}}{{required}}">{{content}}</div>',
                'label' => '<label class="col-sm-3 col-form-label"{{attrs}}>{{text}}</label>',
                'textarea' => '<div class="col-sm-9"><textarea class="form-control" name="{{name}}" id="{{name}}" rows="5" maxlength="180" onkeyup="contatitulo()" placeholder="Digite o título com até 180 carateres"></textarea></div>'
            ]
        ]);
        echo $this->Form->control('avaliacao', [
            'templates' => [
                'inputContainer' => '<div class="row mb-3" {{type}}{{required}}">{{content}}</div>',
                'label' => '<label class="col-sm-3 col-form-label"{{attrs}}>{{text}}</label>',
                'input' => '<div class="col-sm-9"><input class="form-control" name="{{name}}" type="text"{{attrs}}></div>'
            ]
        ]);
    ?>
    </fieldset>
    <div class="d-flex justify-content-center">
        <?= $this->Form->button(__('Confirmar'),['class' => 'btn btn-primary']) ?>
    </div>
    <?= $this->Form->end() ?>
</div>