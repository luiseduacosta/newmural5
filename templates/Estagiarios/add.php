<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Estagiario $estagiario
 * @var \App\Model\Entity\Aluno $aluno
 * @var \Cake\I18n\DateTime $now
 */
$now = new \Cake\I18n\DateTime();
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
</script>

<?php echo $this->element('menu_mural'); ?>

<nav class="navbar navbar-expand-lg py-2 navbar-light bg-light" id="actions-sidebar">
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarTogglerEstagiarioAdd"
        aria-controls="navbarTogglerEstagiarioAdd" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <ul class="navbar-nav collapse navbar-collapse" id="navbarTogglerEstagiarioAdd">
        <?php if (isset($user->categoria) && $user->categoria == '1'): ?>
            <li class="nav-item">
                <?= $this->Html->link(__('Estagiarios'), ['action' => 'index'], ['class' => 'btn btn-primary float-start']) ?>
            </li>
        <?php endif; ?>
    </ul>
</nav>

<?= $this->element('templates') ?>

<div class="container col-lg-8 shadow p-3 mb-5 bg-white rounded">
    <?= $this->Form->create($estagiario) ?>
    <fieldset class="border p-2">
        <legend><?= __('Novo estagiário') ?></legend>
        <?php
        if (isset($aluno)) {
            echo $this->Form->control('aluno_id', [
                'label' => 'Aluno',
                'options' => [$aluno->id => $aluno->nome],
                'readonly' => true,
                'templates' => [
                    'formGroup' => '<div class="form-group row">{{label}}<div class="col-sm-9">{{input}}</div></div>',
                    'label' => '<label class="col-sm-2 form-label"{{attrs}}>{{text}}</label>',
                    'select' => '<select name="{{name}}"{{attrs}} class="form-select">{{content}}</select>'
                ]
            ]);
        } elseif (isset($alunos)) {
            echo $this->Form->control('aluno_id', [
                'label' => 'Aluno',
                'options' => $alunos,
                'empty' => ['' => 'Seleciona estudante'],
                'onchange' => 'getaluno(this.value)',
                'templates' => [
                    'formGroup' => '<div class="form-group row">{{label}}<div class="col-sm-9">{{input}}</div></div>',
                    'label' => '<label class="col-sm-2 form-label"{{attrs}}>{{text}}</label>',
                    'select' => '<select name="{{name}}"{{attrs}} class="form-select">{{content}}</select>'
                ]
            ]);
        }
        echo $this->Form->control('registro', [
            'label' => 'DRE',
            'value' => $aluno->registro,
            'type' => 'text',
            'readonly' => true,
            'id' => 'registro',
            'templates' => [
                'formGroup' => '<div class="form-group row">{{label}}<div class="col-sm-2">{{input}}</div></div>',
                'label' => '<label class="col-sm-2 form-label"{{attrs}}>{{text}}</label>',
                'input' => '<input class="col-sm-2 form-control " type="{{type}}" name="{{name}}"{{attrs}}/>'
            ]
        ]);
        echo $this->Form->control('turno', [
            'label' => 'Turno',
            'options' => ['D' => 'Diurno', 'N' => 'Noturno', 'I' => 'Indefinido'],
            'templates' => [
                'formGroup' => '<div class="form-group row">{{label}}<div class="col-sm-2">{{input}}</div></div>',
                'label' => '<label class="col-sm-2 form-label"{{attrs}}>{{text}}</label>',
                'select' => '<select class="form-select" name="{{name}}"{{attrs}}>{{content}}</select>'
            ],
            'id' => 'turno',
            'value' => isset($aluno) ? $aluno->turno : ''
        ]);
        echo $this->Form->control('nivel', [
            'label' => 'Nível',
            'options' => ['1' => 1, '2' => 2, '3' => 3, '4' => 4, '9' => 'Não curricular'],
            'value' => $nivel,
            'templates' => [
                'formGroup' => '<div class="form-group row">{{label}}<div class="col-sm-2">{{input}}</div></div>',
                'label' => '<label class="col-sm-2 form-label"{{attrs}}>{{text}}</label>',
                'select' => '<select class="form-select" name="{{name}}"{{attrs}}>{{content}}</select>'
            ],
            'id' => 'nivel'
        ]);
        echo $this->Form->control('tc', [
            'label' => 'Termo de compromisso',
            'options' => ['0' => 'Sem TC', '1' => 'Com TC'],
            'templates' => [
                'formGroup' => '<div class="form-group row">{{label}}<div class="col-sm-2">{{input}}</div></div>',
                'label' => '<label class="col-sm-2 form-label"{{attrs}}>{{text}}</label>',
                'select' => '<select class="form-select" name="{{name}}"{{attrs}}>{{content}}</select>'
            ],
            'id' => 'tc',
            'value' => isset($aluno) ? $aluno->tc : ''
        ]);
        echo $this->Form->control('tc_solicitacao', [
            'label' => 'Solicitação de TC',
            'empty' => true,
            'type' => 'date',
            'value' => $now->i18nFormat('dd-MM-yyyy'),
            'readonly' => true,
            'templates' => [
                'formGroup' => '<div class="form-group row">{{label}}<div class="col-sm-3">{{input}}</div></div>',
                'label' => '<label class="col-sm-2 form-label"{{attrs}}>{{text}}</label>',
                'input' => '<input class="col-sm-3 form-control " type="{{type}}" name="{{name}}"{{attrs}}/>'
            ],
            'id' => 'tc_solicitacao'
        ]);
        echo $this->Form->control('ajuste2020', [
            'label' => 'Ajuste 2020',
            'empty' => true,
            'type' => 'select',
            'options' => ['0' => 'Não', '1' => 'Sim'],
            'readonly' => false,
            'templates' => [
                'formGroup' => '<div class="form-group row">{{label}}<div class="col-sm-2">{{input}}</div></div>',
                'label' => '<label class="col-sm-2 form-label"{{attrs}}>{{text}}</label>',
                'select' => '<select class="form-select" name="{{name}}"{{attrs}}>{{content}}</select>'
            ],
            'id' => 'ajuste2020',
            'value' => isset($ultimo_estagio) ? $ultimo_estagio->ajuste2020 : ''
        ]);
        echo $this->Form->control('instituicao_id', [
            'label' => 'Instituição',
            'empty' => ['' => 'Selecione uma instituição'],
            'options' => $instituicoes,
            'value' => isset($ultimo_estagio) ? $ultimo_estagio->instituicao_id : '',
            'onchange' => 'getsupervisores(this.value)',
            'templates' => [
                'formGroup' => '<div class="form-group row">{{label}}<div class="col-sm-9">{{input}}</div></div>',
                'label' => '<label class="col-sm-2 form-label"{{attrs}}>{{text}}</label>',
                'select' => '<select name="{{name}}"{{attrs}} class="form-select">{{content}}</select>'
            ],
            'id' => 'instituicao-id',
        ]);
        echo $this->Form->control('supervisor_id', [
            'label' => 'Supervisor',
            'options' => $supervisores,
            'empty' => true,
            'templates' => [
                'formGroup' => '<div class="form-group row">{{label}}<div class="col-sm-9">{{input}}</div></div>',
                'label' => '<label class="col-sm-2 form-label"{{attrs}}>{{text}}</label>',
                'select' => '<select name="{{name}}"{{attrs}} class="form-select">{{content}}</select>'
            ],
            'id' => 'supervisor-id',
            'value' => isset($ultimo_estagio) ? $ultimo_estagio->supervisor_id : ''
        ]);
        echo $this->Form->control('professor_id', [
            'label' => 'Professor',
            'options' => $professores,
            'value' => isset($ultimo_estagio) ? $ultimo_estagio->professor_id : '',
            'empty' => true,
            'templates' => [
                'formGroup' => '<div class="form-group row">{{label}}<div class="col-sm-9">{{input}}</div></div>',
                'label' => '<label class="col-sm-2 form-label"{{attrs}}>{{text}}</label>',
                'select' => '<select name="{{name}}"{{attrs}} class="form-select">{{content}}</select>'
            ]
        ]);
        echo $this->Form->control('periodo', [
            'label' => 'Período',
            'value' => $periodo,
            'templates' => [
                'formGroup' => '<div class="form-group row">{{label}}<div class="col-sm-2">{{input}}</div></div>',
                'label' => '<label class="col-sm-2 form-label"{{attrs}}>{{text}}</label>',
                'input' => '<input class="col-sm-2 form-control " type="{{type}}" name="{{name}}"{{attrs}}/>'
            ],
            'readonly' => true
        ]);
        echo $this->Form->control('turmaestagio_id', [
            'label' => 'Turma de estágio',
            'options' => $turmaestagios,
            'value' => isset($ultimo_estagio) ? $ultimo_estagio->turmaestagio_id : '',
            'empty' => true,
            'templates' => [
                'formGroup' => '<div class="form-group row">{{label}}<div class="col-sm-9">{{input}}</div></div>',
                'label' => '<label class="col-sm-2 form-label"{{attrs}}>{{text}}</label>',
                'select' => '<select name="{{name}}"{{attrs}} class="form-select">{{content}}</select>'
            ]
        ]);
        if (isset($user) && $user->categoria == '1') {
            echo $this->Form->control('nota', [
                'label' => 'Nota',
                'value' => '',
                'readonly' => true,
                'templates' => [
                    'formGroup' => '<div class="form-group row">{{label}}<div class="col-sm-2">{{input}}</div></div>',
                    'label' => '<label class="col-sm-2 form-label"{{attrs}}>{{text}}</label>',
                    'input' => '<input class="col-sm-2 form-control " type="{{type}}" name="{{name}}"{{attrs}}/>'
                ]
            ]);
            echo $this->Form->control('ch', [
                'label' => 'Carga horária',
                'value' => '',
                'readonly' => true,
                'templates' => [
                    'formGroup' => '<div class="form-group row">{{label}}<div class="col-sm-2">{{input}}</div></div>',
                    'label' => '<label class="col-sm-2 form-label"{{attrs}}>{{text}}</label>',
                    'input' => '<input class="col-sm-2 form-control " type="{{type}}" name="{{name}}"{{attrs}}/>'
                ]
            ]);
            echo $this->Form->control('observacoes', [
                'type' => 'textarea',
                'rows' => '3',
                'cols' => '50',
                'label' => 'Observações',
                'value' => '',
                'templates' => [
                    'formGroup' => '<div class="form-group row">{{label}}{{input}}</div>',
                    'label' => '<label class="col-sm-2 form-label"{{attrs}}>{{text}}</label>',
                    'input' => '<textarea class="form-control col-sm-12" rows="{{rows}}" cols="{{cols}}" name="{{name}}"{{attrs}}>{{value}}</textarea>'
                ]
            ]);
        }
        ?>
    </fieldset>
    <?= $this->Form->button(__('Confirma'), ['class' => 'btn btn-primary']) ?>
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

    let ;
    if (typeof observacoes !== 'undefined') {
        observacoes.destroy();
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