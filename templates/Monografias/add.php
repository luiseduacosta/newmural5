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
            // document.getElementById('caraterestitulo').value = 'Você atingiu o limite de ' + max + ' caracteres';
        } else {
            var char = max - len;
            document.getElementById('caraterestitulo').value = char + ' caracteres restante';
        }
    }

</script>

<?= $this->element('menu_monografias') ?>

<nav class="navbar navbar-expand-lg py-2 navbar-light bg-light" id="actions-sidebar">
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarTogglerMonografiasAdd"
            aria-controls="navbarTogglerMonografiasAdd" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <ul class="navbar-nav collapse navbar-collapse" id="navbarTogglerMonografiasAdd">
        <?php if (isset($user->categoria) && $user->categoria == '1'): ?>
            <li class="nav-item">
                <?= $this->Html->link(__('Monografias'), ['action' => 'index'], ['class' => 'btn btn-primary float-start']) ?>
            </li>
        <?php endif; ?>
    </ul>
</nav>

<div class="container col-lg-8 shadow p-3 mb-5 bg-white rounded">

    <?php echo $this->Form->create($monografia, ['type' => 'file']) ?>
    <legend><?= __('Inserir nova monografia') ?></legend>

    <div class=" form-group">
        <?php echo $this->Form->control('estudantes_ids.0', [
            'label' => 'Estudante 1',
            'type' => 'select',
            'options' => $estudantes, 
            'empty' => 'Seleciona estudante', 
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
            'required' => false,
            'templates' => [
                'inputContainer' => '<div class="row mb-3" {{type}}{{required}}>{{content}}</div>',
                'label' => '<label class="col-sm-3 col-form-label"{{attrs}}>{{text}}</label>', 
                'select' => '<div class="col-sm-9"><select class="form-select" name="{{name}}"{{attrs}}>{{content}}</select></div>'
            ]
        ]); ?>
    </div>

    <div class=" form-group row">
        <?php echo $this->Form->control('catalogo', [
            'type' => 'hidden'
        ]); ?>
    </div>

    <div class=" form-group row">
        <?php echo $this->Form->control('titulo', [
            'type' => 'textarea',
            'label' => 'Título', 
            'required' => true,
            'rows' => '5', 
            'maxlength' => '180', 
            'onkeyup' => 'contatitulo()', 
            'placeholder' => 'Digite o título com até 180 carateres',
            'templates' => [
                'inputContainer' => '<div class="row mb-3" {{type}}{{required}}>{{content}}</div>',
                'label' => '<label class="col-sm-3 col-form-label"{{attrs}}>{{text}}</label>',
                'textarea' => '<div class="col-sm-9"><textarea class="form-control" name="{{name}}"{{attrs}}>{{content}}</textarea></div>'
            ]]); ?>
    </div>

    <div class=" form-group row">
        <?php echo $this->Form->control('caraterestitulo', [
            'label' => " ", 
            'placeholder' => 'Carateres restantes',
            'type' => 'text', 
            'readonly' => true, 
            'class' => 'form-control',
            'templates' => [
                'inputContainer' => '<div class="row mb-3" {{type}}{{required}}>{{content}}</div>',
                'label' => '<label class="col-sm-3 col-form-label"{{attrs}}>{{text}}</label>',
                'input' => '<div class="col-sm-9"><input class="form-control" name="{{name}}" type="text"{{attrs}}></div>'
            ]]); ?>
    </div>

    <div class=" form-group row">
        <?php echo $this->Form->control('resumo', [
            'type' => 'textarea',
            'label' => 'Resumo', 
            'required' => false,
            'rows' => '5', 
            'maxlength' => '7000', 
            'onkeyup' => 'contaresumo()', 
            'placeholder' => 'Digite o resumo com até 7000 carateres',
            'templates' => [
                'inputContainer' => '<div class="row mb-3" {{type}}{{required}}>{{content}}</div>',
                'label' => '<label class="col-sm-3 col-form-label"{{attrs}}>{{text}}</label>',
                'textarea' => '<div class="col-sm-9"><textarea class="form-control" name="{{name}}"{{attrs}}>{{content}}</textarea></div>'
            ]]); ?>
    </div>

    <div class="form-group row mb-3">
        <!-- Include a div to hold the word count display -->
        <label class="col-sm-3 col-form-label"></label> 
        <div class="col-sm-9">
            <div id="contacarateres" class="form-control"></div>
        </div>
    </div>

    <div class=" form-group row">
        <?php echo $this->Form->control('data', [
            'type' => 'date', 
            'label' => 'Data de entrega', 
            'required' => true,
            'templates' => [
                'inputContainer' => '<div class="form-group row mb-3">{{content}}</div>',
                'label' => '<label class="col-sm-3 col-form-label"{{attrs}}>{{text}}</label>',
                'input' => '<div class="col-sm-9"><input class="form-control" name="{{name}}" type="date"{{attrs}}></div>'
            ]]); ?>
    </div>

    <div class=" form-group row">
        <?php echo $this->Form->control('ano', [
            'label' => 'Ano',
            'type' => 'year',
            'min' => date('Y') - 20, 
            'max' => date('Y') + 10, 
            'required' => true,
            'templates' => [
                'inputContainer' => '<div class="form-group row mb-3">{{content}}</div>',
                'label' => '<label class="col-sm-3 col-form-label" {{attrs}}>{{text}}</label>',
                'select' => '<div class="col-sm-9"><select class="form-select" name="{{name}}"{{attrs}}>{{content}}</select></div>'
            ]]); ?>
    </div>

    <div class=" form-group row">
        <?php echo $this->Form->control('semestre', [
            'label' => 'Semestre',
            'type' => 'select',
            'required' => true,
            'options' => ['0' => 'Sem dados', '1' => '1º', '2' => '2º'],
            'templates' => [
                'inputContainer' => '<div class="form-group row mb-3">{{content}}</div>',
                'label' => '<label class="col-sm-3 col-form-label" {{attrs}}>{{text}}</label>',
                'select' => '<div class="col-sm-9"><select class="form-select" name="{{name}}"{{attrs}}>{{content}}</select></div>'
            ]]); ?>
    </div>

    <div class=" form-group row">
        <?php echo $this->Form->control('professor_id', [
            'label' => 'Orientador(a)', 
            'type' => 'select',
            'options' => $docentes, 
            'empty' => 'Selecione', 
            'required' => true,
            'templates' => [
                'inputContainer' => '<div class="row mb-3" {{type}}{{required}}>{{content}}</div>',
                'label' => '<label class="col-sm-3 col-form-label"{{attrs}}>{{text}}</label>',
                'select' => '<div class="col-sm-9"><select class="form-select" name="{{name}}"{{attrs}}>{{content}}</select></div>'
            ]]); ?>
    </div>

    <div class=" form-group row">
        <?php echo $this->Form->control('co_orienta_id', [
            'label' => 'Co-orientador(a)', 
            'type' => 'select',
            'options' => $docentes, 
            'empty' => 'Selecione', 
            'required' => false,
            'templates' => [
                'inputContainer' => '<div class="row mb-3" {{type}}{{required}}>{{content}}</div>',
                'label' => '<label class="col-sm-3 col-form-label"{{attrs}}>{{text}}</label>',
                'select' => '<div class="col-sm-9"><select class="form-select" name="{{name}}"{{attrs}}>{{content}}</select></div>'
            ]]); ?>
    </div>

   <div class=" form-group row">
        <?php echo $this->Form->control('areamonografia_id', [
            'label' => 'Área da monografia', 
            'type' => 'select',
            'options' => $areamonografias, 
            'empty' => 'Selecione', 
            'required' => false,
            'templates' => [
                'inputContainer' => '<div class="row mb-3" {{type}}{{required}}>{{content}}</div>',
                'label' => '<label class="col-sm-3 col-form-label"{{attrs}}>{{text}}</label>',
                'select' => '<div class="col-sm-9"><select class="form-select" name="{{name}}"{{attrs}}>{{content}}</select></div>'
            ]]); ?>
    </div>

    <div class=" form-group row">
        <?php echo $this->Form->control('data_defesa', [
            'label' => 'Data da defesa', 
            'type' => 'date', 
            'templates' => [
                'inputContainer' => '<div class="row mb-3" {{type}}{{required}}>{{content}}</div>',
                'label' => '<label class="col-sm-3 col-form-label"{{attrs}}>{{text}}</label>',
                'input' => '<div class="col-sm-9"><input class="form-control" name="{{name}}" type="date"{{attrs}}></div>'
            ]]); ?>
    </div>

    <div class=" form-group row">
        <?php echo $this->Form->control('banca1', [
            'label' => 'Banca Professor(a) orientador', 
            'type' => 'select',
            'options' => $docentes, 
            'empty' => 'Selecione', 
            'required' => true,
            'templates' => [
                'inputContainer' => '<div class="row mb-3" {{type}}{{required}}>{{content}}</div>',
                'label' => '<label class="col-sm-3 col-form-label"{{attrs}}>{{text}}</label>',
                'select' => '<div class="col-sm-9"><select class="form-select" name="{{name}}"{{attrs}}>{{content}}</select></div>'
            ]]); ?>
    </div>

    <div class=" form-group row">
        <?php echo $this->Form->control('banca2', [
            'label' => 'Professor(a)', 
            'type' => 'select',
            'options' => $docentes, 
            'empty' => 'Selecione', 
            'required' => false,
            'templates' => [
                'inputContainer' => '<div class="row mb-3" {{type}}{{required}}>{{content}}</div>',
                'label' => '<label class="col-sm-3 col-form-label"{{attrs}}>{{text}}</label>',
                'select' => '<div class="col-sm-9"><select class="form-select" name="{{name}}"{{attrs}}>{{content}}</select></div>'
            ]]); ?>
    </div>

    <div class=" form-group row">
        <?php echo $this->Form->control('banca3', [
            'label' => 'Professor(a)', 
            'type' => 'select',
            'options' => $docentes, 
            'empty' => 'Selecione', 
            'required' => false,
            'templates' => [
                'inputContainer' => '<div class="row mb-3" {{type}}{{required}}>{{content}}</div>',
                'label' => '<label class="col-sm-3 col-form-label"{{attrs}}>{{text}}</label>',
                'select' => '<div class="col-sm-9"><select class="form-select" name="{{name}}"{{attrs}}>{{content}}</select></div>'
            ]]); ?>
    </div>

    <div class="form-group row">
        <?php echo $this->Form->control('convidado', [
            'label' => 'Convidado(a)',
            'type' => 'text',
            'required' => false,
            'templates' => [
                'inputContainer' => '<div class="row mb-3" {{type}}{{required}}>{{content}}</div>',
                'label' => '<label class="col-sm-3 col-form-label"{{attrs}}>{{text}}</label>',
                'input' => '<div class="col-sm-9"><input class="form-control" name="{{name}}" type="text"{{attrs}}></div>'
            ]]); ?>
    </div>

    <div class="form-group row">
        <?php echo $this->Form->control('url', [
            'label' => 'Inserir monografia em PDF', 
            'type' => 'file',
            'required' => false,
            'templates' => [
                'inputContainer' => '<div class="row mb-3" {{type}}{{required}}>{{content}}</div>',
                'label' => '<label class="col-sm-3 col-form-label"{{attrs}}>{{text}}</label>',
                'input' => '<div class="col-sm-9"><input type="file" name="{{name}}"{{attrs}}></div>'
            ]]); ?>
    </div>

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
            texto.setData("");
            const wordCountPlugin = texto.plugins.get( 'WordCount' );
            const wordCountWrapper = document.getElementById( 'contacarateres' );
            wordCountWrapper.appendChild( wordCountPlugin.wordCountContainer );
            console.log("Resumo editor initialized successfully: ${ wordCountPlugin.wordCountContainer.textContent } characters");
        })
        .catch(error => {
            console.error('Error initializing resumo editor:', error);
        });
</script>