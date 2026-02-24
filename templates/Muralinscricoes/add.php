<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Muralinscricao $muralinscricao
 */
$user = $this->getRequest()->getAttribute('identity');
?>

<?php echo $this->element('menu_mural') ?>

<nav class="navbar navbar-expand-lg py-2 navbar-light bg-light" id="actions-sidebar">
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarTogglerMural"
        aria-controls="navbarTogglerMural" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <ul class="navbar-nav collapse navbar-collapse" id="navbarTogglerMural">
        <li class="nav-item">
            <?= $this->Html->link(__('Listar'), ['action' => 'index'], ['class' => 'btn btn-primary']) ?>
        </li>
    </ul>
</nav>

<div class="container col-lg-8 shadow p-3 mb-5 bg-white rounded">
    <?= $this->Form->create() ?>
    <fieldset>
        <legend><?= __('Inscrição para seleção de estágio') ?></legend>
        <?php
        if (isset($user->categoria) && $user->categoria == 1):
            echo $this->Form->control('aluno_id', [
                'label' => 'Aluno(a)',
                'options' => $alunos,
                'empty' => 'Selecione o aluno',
                'templates' => [
                    'formGroup' => '<div class="form-group row">{{label}}<div class="col-sm-9">{{input}}</div></div>',
                    'label' => '<label class="col-sm-2 form-label"{{attrs}}>{{text}}</label>',
                    'select' => '<select class="form-select" name="{{name}}"{{attrs}}>{{content}}</select>'
                ]
            ]);
            echo $this->Form->control('registro', [
                'type' => 'hidden',
                'label' => 'Registro',
                'placeholder' => 'Digite o DRE',
                'options' => $alunos,
                'empty' => 'Selecione o aluno',
                'templates' => [
                    'formGroup' => '<div class="form-group row">{{label}}<div class="col-sm-9">{{input}}</div></div>',
                    'label' => '<label class="col-sm-2 form-label"{{attrs}}>{{text}}</label>',
                    'select' => '<select class="form-select" name="{{name}}"{{attrs}}>{{content}}</select>'
                ]
            ]);
            echo $this->Form->control('muralestagio_id', [
                'label' => ['text' => 'Mural de estágio', 'class' => 'col-sm-2 form-label'],
                'options' => $muralestagios,
                'empty' => 'Selecione o estágio',
                'templates' => [
                    'formGroup' => '<div class="form-group row">{{label}}<div class="col-sm-9">{{input}}</div></div>',
                    'select' => '<select class="form-select" name="{{name}}"{{attrs}}>{{content}}</select>'
                ]
            ]);
            echo $this->Form->control('data', [
                'value' => date('d-m-Y'),
                'readonly' => true,
                'templates' => [
                    'formGroup' => '<div class="form-group row">{{label}}<div class="col-sm-2">{{input}}</div></div>',
                    'label' => '<label class="col-sm-2 form-label"{{attrs}}>{{text}}</label>',
                    'input' => '<input class="col-sm-2 form-control " type="{{type}}" name="{{name}}"{{attrs}}/>'
                ]
            ]);
            echo $this->Form->control('periodo', [
                'type' => 'hidden',
                'label' => ['text' => 'Período', 'class' => 'col-sm-2 form-label'],
                'value' => null, // será definido pela escolha do mural no controller
                'readonly' => true,
                'templates' => [
                    'formGroup' => '<div class="form-group row">{{label}}<div class="col-sm-2">{{input}}</div></div>',
                    'select' => '<select class="form-select" name="{{name}}"{{attrs}}>{{content}}</select>'
                ]
            ]);
            echo $this->Form->control('timestamp', ['type' => 'hidden', 'value' => date('Y-m-d H:i:s'), 'readonly' => true]);
        elseif (isset($user) && $user->categoria == 2):
            echo $this->Form->control('aluno_id', [
                'label' => 'Aluno(a)',
                'options' => [$alunos[$user->aluno_id]],
                'readonly' => true,
                'templates' => [
                    'formGroup' => '<div class="form-group row">{{label}}<div class="col-sm-9">{{input}}</div></div>',
                    'label' => '<label class="col-sm-2 form-label"{{attrs}}>{{text}}</label>',
                    'select' => '<select class="form-select" name="{{name}}"{{attrs}}>{{content}}</select>'
                ]
            ]);
            echo $this->Form->control('registro', [
                'label' => 'Registro',
                'value' => $user->numero,
                'readonly' => true,
                'templates' => [
                    'formGroup' => '<div class="form-group row">{{label}}<div class="col-sm-9">{{input}}</div></div>',
                    'label' => '<label class="col-sm-2 form-label"{{attrs}}>{{text}}</label>',
                    'input' => '<input class="col-sm-9 form-control " type="{{type}}" name="{{name}}"{{attrs}}/>'
                ]
            ]);
            echo $this->Form->control('muralestagio_id', [
                'label' => 'Mural de estágio',
                'options' => $muralestagios,
                'empty' => 'Selecione o estágio',
                'readonly' => true,
                'templates' => [
                    'formGroup' => '<div class="form-group row">{{label}}<div class="col-sm-9">{{input}}</div></div>',
                    'label' => '<label class="col-sm-2 form-label"{{attrs}}>{{text}}</label>',
                    'select' => '<select class="form-select" name="{{name}}"{{attrs}}>{{content}}</select>'
                ]
            ]);
            echo $this->Form->control('data', [
                'type' => 'hidden',
                'value' => date('Y-m-d'),
                'readonly' => true
            ]);
            echo $this->Form->control('periodo', [
                'type' => 'hidden',
                'label' => 'Período',
                'value' => null, // será definido pela escolha do mural no controller
                'readonly' => false,
                'templates' => [
                    'formGroup' => '<div class="form-group row">{{label}}<div class="col-sm-2">{{input}}</div></div>',
                    'label' => '<label class="col-sm-2 form-label"{{attrs}}>{{text}}</label>',
                    'input' => '<input class="col-sm-9 form-control " type="{{type}}" name="{{name}}"{{attrs}}/>'
                ]
            ]);
            echo $this->Form->control('timestamp', ['type' => 'hidden', 'value' => date('Y-m-d H:i:s'), 'readonly' => true]);
        else:
            $this->Flash->error(__('Usuário não autorizado para fazer inscrição.'));
            echo $this->Html->link('Voltar para Mural', ['controller' => 'Muralestagios', 'action' => 'index'], ['class' => 'btn btn-primary']);
        endif;
        ?>
    </fieldset>
    <?= $this->Form->button(__('Confirma'), ['class' => 'btn btn-primary mt-1']) ?>
    <?= $this->Form->end() ?>
</div>