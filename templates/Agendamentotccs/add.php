<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Agendamentotcc $agendamentotcc
 */
$user = $this->getRequest()->getAttribute('identity');
// pr($estudantes);
?>

<script>
    function contatitulo() {
        var max = 180;
        var len = document.getElementById('titulo').value.length;
        if (len >= max) {
            alert('Você atingiu o limite de ' + max + ' caracteres');
        } else {
            var char = max - len;
            document.getElementById('caraterestitulo').value = char + ' caracteres restantes';
        }
    }
</script>

<?php echo $this->element('menu_monografias') ?>

<nav class="navbar navbar-expand-lg py-2 navbar-light bg-light" id="actions-sidebar">
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbar"
            aria-controls="navbar" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbar">
        <ul class="navbar-nav me-auto mb-2 mb-lg-0">
            <li class="nav-item">
                <?= $this->Html->link(__('Agendamentos de TCC'), ['action' => 'index'], ['class' => 'btn btn-primary float-start']) ?>
            </li>
        </ul>
    </div>
</nav>

<?php $this->element('templates') ?>

<div class="container col-lg-8 shadow p-3 mb-5 bg-white rounded">
    <?= $this->Form->create($agendamentotcc) ?>
    <fieldset class="border p-2">
        <legend><?= __('Agendamento de oficina de defesa de TCC') ?></legend>
        <?php
        echo $this->Form->control('estudante_id', [
            'label' => 'Estudante', 
            'options' => $estudantes, 
            'empty' => 'Seleciona', 
            'templates' => [
                'inputContainer' => '<div class="row mb-3" {{type}}{{required}}">{{content}}</div>',
                'label' => '<label class="col-sm-3 col-form-label"{{attrs}}>{{text}}</label>',
                'select' => '<div class="col-sm-9"><select class="form-select" name="{{name}}"{{attrs}}>{{content}}</select></div>'
            ]]);
        echo $this->Form->control('docente_id', [
            'label' => 'Professor(a)', 
            'options' => $docentes, 
            'empty' => 'Seleciona', 
            'templates' => [
                'inputContainer' => '<div class="row mb-3" {{type}}{{required}}">{{content}}</div>',
                'label' => '<label class="col-sm-3 col-form-label"{{attrs}}>{{text}}</label>',
                'select' => '<div class="col-sm-9"><select class="form-select" name="{{name}}"{{attrs}}>{{content}}</select></div>'
        ]]);
        echo $this->Form->control('banca1', [
            'label' => 'Banca', 
            'options' => $docentes, 
            'empty' => 'Seleciona', 
            'templates' => [
                'inputContainer' => '<div class="row mb-3" {{type}}{{required}}">{{content}}</div>',
                'label' => '<label class="col-sm-3 col-form-label"{{attrs}}>{{text}}</label>',
                'select' => '<div class="col-sm-9"><select class="form-select" name="{{name}}"{{attrs}}>{{content}}</select></div>'
            ]]);
        echo $this->Form->control('banca2', [
            'label' => 'Banca', 
            'options' => $docentes, 
            'empty' => 'Seleciona', 
            'templates' => [
                'inputContainer' => '<div class="row mb-3" {{type}}{{required}}">{{content}}</div>',
                'label' => '<label class="col-sm-3 col-form-label"{{attrs}}>{{text}}</label>',
                'select' => '<div class="col-sm-9"><select class="form-select" name="{{name}}"{{attrs}}>{{content}}</select></div>'
        ]]);
        echo $this->Form->control('convidado', [
            'label' => 'Convidado(a)', 
            'templates' => [
                'inputContainer' => '<div class="row mb-3" {{type}}{{required}}">{{content}}</div>',
                'label' => '<label class="col-sm-3 col-form-label"{{attrs}}>{{text}}</label>',
                'input' => '<div class="col-sm-9"><input class="form-control" name="{{name}}" type="text"{{attrs}}></div>'
            ]]);
        echo $this->Form->control('data', [
            'type' => 'date', 
            'templates' => [
                'dateWidget' => '{{day}}{{month}}{{year}}'
            ]]);
        echo $this->Form->control('horario', [
            'type' => 'time', 
            'templates' => [
                'timeWidget' => '{{HH}}{{mm}}{{ss}}'
            ]]);
        echo $this->Form->control('sala', [
            'label' => 'Sala. Colocar 0 se for não-presencial', 
            'default' => '0', 
            'templates' => [
                'inputContainer' => '<div class="row mb-3" {{type}}{{required}}">{{content}}</div>',
                'label' => '<label class="col-sm-3 col-form-label"{{attrs}}>{{text}}</label>',
                'input' => '<div class="col-sm-9"><input class="form-control" name="{{name}}" type="text"{{attrs}}></div>'
            ]]);
        ?>
        <?php
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
            ]]);
        ?>
        <?php
        echo $this->Form->control('avaliacao', [
            'type' => 'hidden',
            'value' => 's/d'
        ]);
        ?>
    </fieldset>
    <div class="d-flex justify-content-center">
        <?= $this->Form->button(__('Confirmar'), ['class' => 'btn btn-primary']) ?>
    </div>
    <?= $this->Form->end() ?>
</div>