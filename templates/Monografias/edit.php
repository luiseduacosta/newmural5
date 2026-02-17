<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Monografia $monografia
 */
$user = $this->getRequest()->getAttribute('identity');
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

    function contaresumo() {
        var max = 7000;
        var len = document.getElementById('resumo').value.length;
        if (len >= max) {
            alert('Você atingiu o limite de ' + max + ' caracteres');
        } else {
            var char = max - len;
            document.getElementById('carateresresumo').value = char + ' caracteres restantes';
        }
    }
</script>

<?= $this->element('menu_monografias') ?>

<nav class="navbar navbar-expand-lg py-2 navbar-light bg-light" id="actions-sidebar">
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarTogglerMonografiasEdit"
            aria-controls="navbarTogglerMonografiasEdit" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <ul class="navbar-nav collapse navbar-collapse" id="navbarTogglerMonografiasEdit">
        <?php if (isset($user->categoria) && $user->categoria == '1'): ?>
            <li>
                <?=
                $this->Form->postLink(
                        __('Excluir Monografia'),
                        ['action' => 'delete', $monografia->id],
                        ['confirm' => __('Tem certeza que quer excluir a monografia # {0}?', $monografia->id), 'class' => 'btn btn-danger float-end']
                )
            ?>
            </li>
        <?php endif; ?>
    </ul>
</nav>

<?= $this->element('templates'); ?>

<div class="container col-lg-8 shadow p-3 mb-5 bg-white rounded">
    <?= $this->Form->create($monografia) ?>
    <fieldset>
        <legend><?= __('Editar monografia: ' . $monografia->titulo) ?></legend>

        <?php 
        // Prepare current students
        $currentStudents = [];
        $i = 0;
        if (!empty($monografia->tccestudantes)) {
            foreach ($monografia->tccestudantes as $tccStudent) {
                $currentStudents[] = $tccStudent->registro;
                $i++;
            }
        }
        ?>

        <div class=" form-group">
            <?php echo $this->Form->control('estudantes_ids.0', [
                'label' => 'Estudante 1',
                'type' => 'select',
                'options' => $estudantes, 
                'empty' => 'Seleciona estudante', 
                'value' => $currentStudents[0] ?? null,
                'required' => true,
                'templates' => [
                    'inputContainer' => '<div class="row mb-3" {{type}}{{required}}>{{content}}</div>',
                    'label' => '<label class="col-sm-3 col-form-label"{{attrs}}>{{text}}</label>', 
                    'select' => '<div class="col-sm-9"><select class="form-select" name="{{name}}"{{attrs}}>{{content}}</select></div>'
                ]
            ]); ?>
        </div>

        <div class=" form-group">
            <?php echo $this->Form->control('estudantes_ids.1', [
                'label' => 'Estudante 2',
                'type' => 'select',
                'options' => $estudantes, 
                'empty' => 'Seleciona estudante', 
                'value' => $currentStudents[1] ?? null,
                'required' => false,
                'templates' => [
                    'inputContainer' => '<div class="row mb-3" {{type}}{{required}}>{{content}}</div>',
                    'label' => '<label class="col-sm-3 col-form-label"{{attrs}}>{{text}}</label>', 
                    'select' => '<div class="col-sm-9"><select class="form-select" name="{{name}}"{{attrs}}>{{content}}</select></div>'
                ]
            ]); ?>
        </div>

        <div class=" form-group">
            <?php echo $this->Form->control('estudantes_ids.2', [
                'label' => 'Estudante 3',
                'type' => 'select',
                'options' => $estudantes, 
                'empty' => 'Seleciona estudante', 
                'value' => $currentStudents[2] ?? null,
                'required' => false,
                'templates' => [
                    'inputContainer' => '<div class="row mb-3" {{type}}{{required}}>{{content}}</div>',
                    'label' => '<label class="col-sm-3 col-form-label"{{attrs}}>{{text}}</label>', 
                    'select' => '<div class="col-sm-9"><select class="form-select" name="{{name}}"{{attrs}}>{{content}}</select></div>'
                ]
            ]); ?>
        </div>

        <?= $this->Form->control('catalogo', [
            'type' => 'hidden'
        ]); ?>

        <?= $this->Form->control('titulo', [
            'type' => 'textarea',
            'value' => $monografia->titulo,
            'required' => true,
            'rows' => 5,
            'maxlength' => '180',
            'label' => 'Título',
            'onkeyup' => 'contatitulo()',
            'placeholder' => 'Título de até 180 carateres',
            'templates' => [
                'inputContainer' => '<div class="form-group row mb-3">{{content}}</div>',
                'label' => '<label class="col-sm-3 col-form-label" {{attrs}}>{{text}}</label>',
                'textarea' => '<div class="col-sm-9"><textarea class="form-control" name="{{name}}" id="{{name}}"{{attrs}}>{{value}}</textarea><input id="caraterestitulo" /></div>'
            ]
        ]); ?>

        <?= $this->Form->control('resumo', [
            'type' => 'textarea', 
            'label' => 'Resumo', 
            'required' => false,
            'rows' => 5, 
            'maxlength' => 7000, 
            'value' => $monografia->resumo,
            'onkeyup' => 'contaresumo()', 
            'placeholder' => 'Resumo de até 7000 carateres',
            'templates' => [
                'inputContainer' => '<div class="form-group row mb-3">{{content}}</div>',
                'label' => '<label class="col-sm-3 col-form-label" {{attrs}}>{{text}}</label>',
                'textarea' => '<div class="col-sm-9"><textarea class="form-control" name="{{name}}" id="{{name}}"{{attrs}}>{{value}}</textarea><input id="caratereresumo" /></div>',
            ]
        ]); ?>

        <?php echo $this->Form->control('data', [
            'type' => 'date', 
            'label' => 'Data de entrega', 
            'value' => $monografia->data,
            'required' => false,
            'templates' => [
                'inputContainer' => '<div class="form-group row mb-3">{{content}}</div>',
                'label' => '<label class="col-sm-3 col-form-label"{{attrs}}>{{text}}</label>',
                'input' => '<div class="col-sm-9"><input class="form-control" name="{{name}}" type="date"{{attrs}}>{{value}}</div>'
            ]
        ]); ?>

        <?php echo $this->Form->control('periodo', [
            'type' => 'text',
            'label' => 'Período',
            'value' => $monografia->periodo,
            'required' => true,
            'templates' => [
                'inputContainer' => '<div class="form-group row mb-3">{{content}}</div>',
                'label' => '<label class="col-sm-3 col-form-label" {{attrs}}>{{text}}</label>',
                'text' => '<div class="col-sm-9" name="periodo" {{attrs}}>{{value}}</div>',
            ]
        ]); ?>

        <?php echo $this->Form->control('professor_id', [
            'type' => 'select',
            'selected' => $monografia->professor_id,
            'label' => 'Docente',
            'options' => $docentes,
            'empty' => 'Seleciona docente',
            'required' => true,
            'templates' => [
                'inputContainer' => '<div class="form-group row mb-3">{{content}}</div>',
                'label' => '<label class="col-sm-3 col-form-label" {{attrs}}>{{text}}</label>',
                'select' => '<div class="col-sm-9"><select class="form-select" name="{{name}}"{{attrs}}>{{content}}</select></div>',
            ]
        ]); ?>

        <?php echo $this->Form->control('co_orienta_id', [
            'label' => 'Co-orientador(a)', 
            'type' => 'select',
            'options' => $docentes, 
            'selected' => $monografia->co_orienta_id,
            'empty' => 'Selecione', 
            'required' => false,
            'templates' => [
                'inputContainer' => '<div class="form-group row mb-3">{{content}}</div>',
                'label' => '<label class="col-sm-3 col-form-label" {{attrs}}>{{text}}</label>',
                'select' => '<div class="col-sm-9"><select class="form-select" name="{{name}}"{{attrs}}>{{content}}</select></div>'
            ]
        ]); ?>

        <?php echo $this->Form->control('areamonografia_id', [
            'label' => 'Área da monografia', 
            'type' => 'select',
            'selected' => $monografia->areamonografia_id,
            'options' => $areamonografias, 
            'empty' => 'Selecione', 
            'required' => false,
            'templates' => [
                'inputContainer' => '<div class="form-group row mb-3">{{content}}</div>',
                'label' => '<label class="col-sm-3 col-form-label" {{attrs}}>{{text}}</label>',
                'select' => '<div class="col-sm-9"><select class="form-select" name="{{name}}"{{attrs}}>{{content}}</select></div>'
            ]
        ]); ?>

        <?php echo $this->Form->control('data_defesa', [
            'label' => 'Data da defesa', 
            'type' => 'date', 
            'value' => $monografia->data_defesa,
            'required' => false,
            'templates' => [
                'inputContainer' => '<div class="form-group row mb-3">{{content}}</div>',
                'label' => '<label class="col-sm-3 col-form-label"{{attrs}}>{{text}}</label>',
                'input' => '<div class="col-sm-9"><input class="form-control" name="{{name}}" type="date"{{attrs}}></div>'
            ]
        ]); ?>

        <?php echo $this->Form->control('banca1', [
            'label' => 'Banca Professor(a) avaliador', 
            'type' => 'select',
            'value' => $monografia->banca1->id ?? $monografia->professor_id,
            'options' => $docentes, 
            'empty' => 'Selecione', 
            'required' => true,
            'templates' => [
                'inputContainer' => '<div class="form-group row mb-3">{{content}}</div>',
                'label' => '<label class="col-sm-3 col-form-label"{{attrs}}>{{text}}</label>',
                'select' => '<div class="col-sm-9"><select class="form-select" name="{{name}}"{{attrs}}>{{content}}</select></div>'
            ]
        ]); ?>

        <?php echo $this->Form->control('banca2', [
            'label' => 'Banca Professor(a) orientador', 
            'type' => 'select',
            'value' => $monografia->banca2->id ?? null,
            'options' => $docentes, 
            'empty' => 'Selecione', 
            'required' => false,
            'templates' => [
                'inputContainer' => '<div class="form-group row mb-3">{{content}}</div>',
                'label' => '<label class="col-sm-3 col-form-label"{{attrs}}>{{text}}</label>',
                'select' => '<div class="col-sm-9"><select class="form-select" name="{{name}}"{{attrs}}>{{content}}</select></div>'
            ]
        ]); ?>

        <?php echo $this->Form->control('banca3', [
            'label' => 'Professor(a)', 
            'type' => 'select',
            'value' => $monografia->banca3->id ?? null,
            'options' => $docentes, 
            'empty' => 'Selecione', 
            'required' => false,
            'templates' => [
                'inputContainer' => '<div class="form-group row mb-3">{{content}}</div>',
                'label' => '<label class="col-sm-3 col-form-label"{{attrs}}>{{text}}</label>',
                'select' => '<div class="col-sm-9"><select class="form-select" name="{{name}}"{{attrs}}>{{content}}</select></div>'
            ]
        ]); ?>

        <?php echo $this->Form->control('convidado', [
            'label' => 'Convidado(a)',
            'type' => 'text',
            'value' => $monografia->convidado,
            'required' => false,
            'templates' => [
                'inputContainer' => '<div class="form-group row mb-3">{{content}}</div>',
                'label' => '<label class="col-sm-3 col-form-label"{{attrs}}>{{text}}</label>',
                'input' => '<div class="col-sm-9"><input class="form-control" name="{{name}}" type="text"{{attrs}}></div>'
            ]
        ]); ?>

    <?php if (empty($monografia->url)): ?>

        <?php echo $this->Form->control('url', [
            'label' => 'Inserir monografia em PDF', 
            'type' => 'file',
            'required' => false,
            'templates' => [
                'inputContainer' => '<div class="form-group row mb-3">{{content}}</div>',
                'label' => '<label class="col-sm-3 col-form-label"{{attrs}}>{{text}}</label>',
                'input' => '<div class="col-sm-9"><input type="file" name="{{name}}"{{attrs}}></div>'
            ]
        ]); ?>
    <?php else: ?>
        <?php echo $this->Form->control('url', [
            'label' => 'Monografia', 
            'type' => 'file',
            'value' => $monografia->url,
            'required' => false,
            'templates' => [
                'inputContainer' => '<div class="form-group row mb-3">{{content}}</div>',
                'label' => '<label class="col-sm-3 col-form-label"{{attrs}}>{{text}}</label>',
                'input' => '<div class="col-sm-9"><input type="file" name="{{name}}"{{attrs}}></div>'
            ]
        ]); ?>
        <?php echo $this->Form->control('url_nova', [
            'label' => 'Alterar monografia', 
            'type' => 'file',
            'required' => false,
            'templates' => [
                'inputContainer' => '<div class="form-group row mb-3">{{content}}</div>',
                'label' => '<label class="col-sm-3 col-form-label"{{attrs}}>{{text}}</label>',
                'input' => '<div class="col-sm-9"><input type="file" name="{{name}}"{{attrs}}></div>'
            ]
        ]); ?>
    <?php endif ?>

        <?= $this->Form->control('timestamp', [
            'type' => 'hidden',
            'value' => $monografia->timestamp
        ]); ?>

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
        Table,
        TableToolbar,
        SourceEditing,
        WordCount
    } from 'ckeditor5';

    let texto;
    if (typeof texto !== 'undefined') {
        texto.destroy();
    }
    ClassicEditor
        .create(document.querySelector('#resumo'), {
            plugins: [Essentials, Bold, Italic, Strikethrough, Font, Paragraph, Table, TableToolbar, SourceEditing, WordCount],
            toolbar: [
                'sourceEditing', 'undo', 'redo', '|', 'bold', 'italic', 'strikethrough', 'insertTable', '|',
                'fontSize', 'fontFamily', 'fontColor', 'fontBackgroundColor'
            ],
            table: {
                contentToolbar: [
                    'tableColumn',
                    'tableRow',
                    'mergeTableCells'
                ]
            },
            wordCount: {
                showParagraphs: false, // Optional: show paragraph count
                showWordCount: true,   // Show word count
                showCharCount: true,   // Show character count
                countSpacesAsChars: true, // Count spaces in character count
                countHTML: false,      // Do not include HTML in character count
                maxCharCount: 7000,     // Informational max character count
                maxWordCount: 800      // Informational max word count
            }
        })
        .then(editor => {
            texto = editor;
            texto.setData("<?= $monografia->resumo ?>");
            const wordCountPlugin = texto.plugins.get( 'WordCount' );
            const wordCountWrapper = document.getElementById( 'contacarateres' );
            wordCountWrapper.appendChild( wordCountPlugin.wordCountContainer );
            console.log("Resumo editor initialized successfully: ${ wordCountPlugin.wordCountContainer.textContent } characters");
        })
        .catch(error => {
            console.error('Error initializing resumo editor:', error);
        });
</script>