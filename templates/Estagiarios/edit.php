<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Estagiario $estagiario
 */
?>

<!-- Get mask -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js"></script>

<script type="text/javascript">
    function getaluno(id) {
        $.ajax({
            url: '<?= $this->Url->build(['controller' => 'Alunos', 'action' => 'getaluno']) ?>',
            type: 'POST',
            dataType: 'json',
            data: {
                id: id,
                _csrfToken: '<?= $this->request->getAttribute('csrfToken') ?>'
            },
            success: function (response) {
                if (response && Object.keys(response).length > 0) {
                    $('#registro').val(response.registro);
                    $('#turno').val(response.turno);
                    $('#nivel').val(response.nivel);
                    $('#tc').val(response.tc);
                    $('#ajuste2020').val(response.ajuste2020);
                    $('#tc_solicitacao').val(response.tc_solicitacao);
                    $('#instituicao-id').val(response.instituicao_id);
                    $('#supervisor-id').val(response.supervisor_id);
                } else {
                    $('#registro').val('');
                    $('#turno').val('');
                    $('#nivel').val('');
                    $('#tc').val('');
                    $('#ajuste2020').val('');
                    $('#tc_solicitacao').val('');
                    $('#instituicao-id').val('');
                    $('#supervisor-id').val('');
                    alert('Nenhum aluno encontrado');
                }
            },
            error: function (xhr, status, error) {
                console.error('Ajax error:', error);
            }
        });
    }

    function getsupervisores(id) {
        $.ajax({
            url: '<?= $this->Url->build(['controller' => 'Instituicoes', 'action' => 'buscasupervisores']) ?>',
            type: 'POST',
            dataType: 'json',
            data: {
                id: id,
                _csrfToken: '<?= $this->request->getAttribute('csrfToken') ?>'
            },
            success: function (response) {
                let options = '<option value="">Selecione o supervisor</option>';
                if (response && Object.keys(response).length > 0) {
                    $.each(response, function (key, value) {
                        options += '<option value="' + key + '">' + value + '</option>';
                    });
                } else {
                    options = '<option value="">Nenhum supervisor encontrado</option>';
                }
                $('#supervisor-id').html(options);
            },
            error: function (xhr, status, error) {
                console.error('Ajax error:', error);
                $('#supervisor-id').html('<option value="">Erro ao carregar supervisores</option>');
            }
        });
    }
    $(document).ready(function () {
        $('#nota').mask('00.0');
        $('#ch').mask('000');
    });
</script>

<?= $this->element('menu_mural'); ?>

<?= $this->element('templates') ?>

<nav class="navbar navbar-expand-lg navbar-light bg-white">
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
        aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav">
            <?php if (isset($user) && $user->categoria == '1'): ?>
                <li class="nav-item">
                    <?=
                        $this->Form->postLink(
                            __('Excluir'),
                            ['action' => 'delete', $estagiario->id],
                            ['confirm' => __('Tem certeza que quer excluir o registro # {0}?', $estagiario->id), 'class' => 'btn btn-danger float-start']
                        )
                        ?>
                </li>
            <?php endif; ?>
        </ul>
    </div>
</nav>

<?php
$niveis = [
    '1' => '1º',
    '2' => '2º',
    '3' => '3º',
    '4' => '4º',
    '9' => 'Estágio extra-curricular',
];
?>

<div class="container col-lg-8 shadow p-3 mb-5 bg-white rounded">
    <?= $this->Form->create($estagiario) ?>
    <fieldset class="border p-2">
        <legend><?= __('Editar estagiário') ?></legend>
        <?php
        echo $this->Form->control('aluno_id', [
            'options' => $alunos,
            'value' => isset($estagiario) ? $estagiario->aluno_id : '',
            'onchange' => 'getaluno(this.value)',
            'empty' => true,
            'label' => 'Aluno(a)',
            'templates' => [
                'formGroup' => '<div class="form-group row">{{label}}<div class="col-sm-9">{{input}}</div></div>',
                'label' => '<label class="col-sm-3 form-label"{{attrs}}>{{text}}</label>',
                'select' => '<div class="col-sm-9"><select class="form-select" name="{{name}}"{{attrs}}>{{content}}</select></div>',
            ]
        ]);
        echo $this->Form->control('registro', ['label' => 'DRE']);
        echo $this->Form->control('turno', ['label' => 'Turno']);
        echo $this->Form->control('nivel', [
            'options' => $niveis,
            'value' => isset($estagiario) ? $estagiario->nivel : '',
            'empty' => true,
            'label' => 'Nível',
            'templates' => [
                'formGroup' => '<div class="form-group row">{{label}}<div class="col-sm-9">{{input}}</div></div>',
                'label' => '<label class="col-sm-3 form-label"{{attrs}}>{{text}}</label>',
                'select' => '<div class="col-sm-9"><select class="form-select" name="{{name}}"{{attrs}}>{{content}}</select></div>',
            ]
        ]);
        echo $this->Form->control('tc', ['label' => 'Termo de compromisso']);
        echo $this->Form->control('tc_solicitacao', ['empty' => true, 'label' => 'Solicitação de termo de compromisso']);
        echo $this->Form->control('instituicao_id', [
            'options' => $instituicoes,
            'value' => isset($estagiario) ? $estagiario->instituicao_id : '',
            'onchange' => 'getsupervisores(this.value)',
            'empty' => true,
            'label' => 'Instituição',
            'templates' => [
                'formGroup' => '<div class="form-group row">{{label}}<div class="col-sm-9">{{input}}</div></div>',
                'label' => '<label class="col-sm-3 form-label"{{attrs}}>{{text}}</label>',
                'select' => '<div class="col-sm-9"><select class="form-select" name="{{name}}"{{attrs}}>{{content}}</select></div>',
            ]
        ]);
        echo $this->Form->control('supervisor_id', [
            'options' => $supervisores,
            'value' => isset($estagiario) ? $estagiario->supervisor_id : '',
            'empty' => true,
            'label' => 'Supervisor(a)',
            'templates' => [
                'formGroup' => '<div class="form-group row">{{label}}<div class="col-sm-9">{{input}}</div></div>',
                'label' => '<label class="col-sm-3 form-label"{{attrs}}>{{text}}</label>',
                'select' => '<div class="col-sm-9"><select class="form-select" name="{{name}}"{{attrs}}>{{content}}</select></div>',
            ]
        ]);
        echo $this->Form->control('professor_id', [
            'options' => $professores,
            'value' => isset($estagiario) ? $estagiario->professor_id : '',
            'empty' => true,
            'label' => 'Professor(a)',
            'templates' => [
                'formGroup' => '<div class="form-group row">{{label}}<div class="col-sm-9">{{input}}</div></div>',
                'label' => '<label class="col-sm-3 form-label"{{attrs}}>{{text}}</label>',
                'select' => '<div class="col-sm-9"><select class="form-select" name="{{name}}"{{attrs}}>{{content}}</select></div>',
            ]
        ]);
        echo $this->Form->control('periodo', ['label' => 'Semestre']);
        echo $this->Form->control('turmaestagio_id', [
            'label' => 'Turma',
            'options' => $turmaestagios,
            'value' => isset($estagiario) ? $estagiario->turmaestagio_id : '',
            'empty' => true,
            'templates' => [
                'formGroup' => '<div class="form-group row">{{label}}<div class="col-sm-9">{{input}}</div></div>',
                'label' => '<label class="col-sm-3 form-label"{{attrs}}>{{text}}</label>',
                'select' => '<div class="col-sm-9"><select class="form-select" name="{{name}}"{{attrs}}>{{content}}</select></div>',
            ]
        ]);
        if (isset($user) && $user->categoria == '1') {
            echo $this->Form->control('nota', ['label' => 'Nota', 'type' => 'number', 'step' => '0.01', 'placeholder' => '00.00']);
            echo $this->Form->control('ch', ['label' => 'Carga horária', 'type' => 'number', 'placeholder' => '000']);
            echo $this->Form->control('observacoes', ['type' => 'textarea', 'rows' => '3', 'cols' => '40', 'label' => 'Observações']);
        }
        ?>
    </fieldset>
    <?= $this->Form->button(__('Confirmar'), ['class' => 'btn btn-primary']) ?>
    <?= $this->Form->end() ?>
</div>

<script type="module">
    import {
        ClassicEditor,
        Essentials,
        Bold,
        Italic,
        Strikethrough,
        Font,
        Paragraph,
        List,
        Alignment
    } from 'ckeditor5';

    let requisitos;
    if (typeof requisitos !== 'undefined') {
        requisitos.destroy();
    }

    ClassicEditor
        .create(document.querySelector('#observacoes'), {
            plugins: [Essentials, Bold, Italic, Strikethrough, Font, Paragraph, List, Alignment],
            toolbar: [
                'undo', 'redo', '|', 'bold', 'italic', 'strikethrough', 'bulletedList', 'numberedList', 'alignment', '|',
                'fontSize', 'fontFamily', 'fontColor', 'fontBackgroundColor'
            ]
        })
        .then(editor => {
            observacoes = editor;
            console.log('Olá editor observações inicializado', observacoes);
            requisitos.setData("");
        });

</script>