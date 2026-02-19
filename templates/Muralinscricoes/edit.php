<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Muralinscricao $muralinscricao
 */
$user = $this->getRequest()->getAttribute('identity');
// pr($muralinscricao);
?>

<?php echo $this->element('menu_mural') ?>

<div class="navbar navbar-expand-lg py-2 navbar-light bg-light" id="actions-sidebar">
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarTogglerMural"
        aria-controls="navbarTogglerMural" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <ul class="navbar-nav collapse navbar-collapse" id="navbarTogglerMural">
        <?php if (isset($user) && $user->categoria == '1'): ?>
            <li class="nav-item">
                <?= $this->Form->postLink(__('Excluir'), ['action' => 'delete', $muralinscricao->id], ['confirm' => __('Tem certeza que deseja excluir este registo # {0}?', $muralinscricao->id), 'class' => 'btn btn-danger me-1']) ?>
            </li>
        <?php endif; ?>
        <li class='nav-link'>
            <?= $this->Html->link(__('Listar'), ['action' => 'index'], ['class' => 'btn btn-primary']) ?>
        </li>
    </ul>
</div>

<div class="container col-lg-8 shadow p-3 mb-5 bg-white rounded">
    <?= $this->Form->create($muralinscricao) ?>
    <fieldset>
        <legend><?= __('Editar inscrição') ?></legend>
        <?php
        echo $this->Form->control('id', [
            'value' => $muralinscricao->id,
            'readonly' => true,
            'type' => 'hidden'
        ]);
        echo $this->Form->control('registro', [
            'value' => $muralinscricao->alunos['registro'],
            'readonly' => true,
            'label' => 'Registro',
            'templates' => [
                'formGroup' => '<div class="form-group row">{{label}}<div class="col-sm-9">{{input}}</div></div>',
                'label' => '<label class="col-sm-2 form-label"{{attrs}}>{{text}}</label>',
                'input' => '<input class="col-sm-2 form-control " type="{{type}}" name="{{name}}"{{attrs}}/>'
            ]
        ]);
        echo $this->Form->control('aluno_id', [
            'label' => ['text' => 'Aluno(a)', 'class' => 'col-sm-2 form-label'],
            'name' => 'aluno_id',
            'options' => [$muralinscricao->aluno_id => $muralinscricao->alunos['nome']],
            'disabled' => true,
            'templates' => [
                'formGroup' => '<div class="form-group row">{{label}}<div class="col-sm-9">{{input}}</div></div>',
                'select' => '<select class="form-select col-sm-3" name="{{name}}"{{attrs}}>{{content}}</select>'
            ]
        ]);
        echo $this->Form->control('muralestagio_id', [
            'options' => $muralestagios,
            'empty' => 'Selecione o estágio',
            'value' => $muralinscricao->muralestagios->id,
            'label' => ['text' => 'Instituição', 'class' => 'col-sm-2 form-label'],
            'templates' => [
                'formGroup' => '<div class="form-group row">{{label}}<div class="col-sm-9">{{input}}</div></div>',
                'select' => '<select class="form-select col-sm-3" name="{{name}}"{{attrs}}>{{content}}</select>'
            ]
        ]);
        echo $this->Form->control('data', [
            'type' => 'date',
            'value' => $muralinscricao->data ? $muralinscricao->data->format('Y-m-d') : '',
            'readonly' => true,
            'label' => 'Data de inscrição',
            'templates' => [
                'formGroup' => '<div class="form-group row">{{label}}<div class="col-sm-9">{{input}}</div></div>',
                'label' => '<label class="col-sm-2 form-label"{{attrs}}>{{text}}</label>',
                'input' => '<input class="form-control" type="{{type}}" name="{{name}}"{{attrs}}/>'
            ]
        ]);
        echo $this->Form->control('periodo', [
            'type' => 'text',
            'label' => 'Período',
            'value' => $muralinscricao->periodo,
            'readonly' => true,
            'templates' => [
                'formGroup' => '<div class="form-group row">{{label}}<div class="col-sm-9">{{input}}</div></div>',
                'label' => '<label class="col-sm-2 form-label"{{attrs}}>{{text}}</label>',
                'input' => '<input class="form-control" type="{{type}}" name="{{name}}"{{attrs}}/>'
            ]
        ]);
        echo $this->Form->control('timestamp', [
            'label' => 'Atualização',
            'value' => $muralinscricao->timestamp->format('d-m-Y H:i:s'),
            'readonly' => true,
            'templates' => [
                'formGroup' => '<div class="form-group row">{{label}}<div class="col-sm-9">{{input}}</div></div>',
                'label' => '<label class="col-sm-2 form-label"{{attrs}}>{{text}}</label>',
                'input' => '<input class="form-control" type="{{type}}" name="{{name}}"{{attrs}}/>'
            ]
        ]);
        ?>
    </fieldset>
    <?= $this->Form->button(__('Confirma'), ['class' => 'btn btn-primary']) ?>
    <?= $this->Form->end() ?>
</div>
