<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Muralestagio $muralestagio
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
            <?= $this->Html->link(__('Listar mural de estágios'), ['action' => 'index'], ['class' => 'btn btn-primary float-end']) ?>
        </li>
    </ul>
</nav>

<?= $this->element('templates') ?>

<div class="container col-lg-8 shadow p-3 mb-5 bg-white rounded">
    <?= $this->Form->create($muralestagio, ['method' => 'post', 'id' => 'muralestagio-form']) ?>
    <fieldset>
        <legend><?= __('Novo mural de estágio') ?></legend>
        <?php
        echo $this->Form->control('instituicao_id', ['label' => ['text' => 'Instituição'], 'options' => $instituicoes, 'empty' => 'Selecione']);
        echo $this->Form->control('instituicao', ['type' => 'hidden']);
        echo $this->Form->control('convenio', ['label' => ['text' => 'Convênio'], 'options' => ['0' => 'Não', '1' => 'Sim']]);
        echo $this->Form->control('vagas', ['label' => ['text' => 'Vagas'], 'type' => 'number']);
        echo $this->Form->control('beneficios', ['label' => ['text' => 'Benefícios']]);
        echo $this->Form->control('final_de_semana', ['label' => ['text' => 'Final de semana'], 'options' => ['0' => 'Não', '1' => 'Sim']]);
        echo $this->Form->control('cargaHoraria', ['label' => ['text' => 'Carga horária']]);
        echo $this->Form->control('requisitos', ['type' => 'textarea', 'rows' => 5, 'style' => 'height: 200', 'label' => ['text' => 'Requisitos']]);
        echo $this->Form->control('turmeestagio_id', ['label' => ['text' => 'Turma de estágio'], 'options' => $turmaestagios, 'empty' => 'Selecione']);
        echo $this->Form->control('horario', ['label' => ['text' => 'Horário da OTP'], 'options' => ['D' => 'Diurno', 'N' => 'Noturno', 'I' => 'Indeterminado']]);
        echo $this->Form->control('professor_id', ['label' => ['text' => 'Docente da OTP'], 'options' => $professores, 'empty' => [0 => 'Selecione']]);
        echo $this->Form->control('dataInscricao', ['label' => ['text' => 'Encerramento das inscrições'], 'empty' => true]);
        echo $this->Form->control('dataSelecao', ['label' => ['text' => 'Data da seleção'], 'empty' => true]);
        echo $this->Form->control('horarioSelecao', ['label' => ['text' => 'Horário da seleção']]);
        echo $this->Form->control('localSelecao', ['label' => ['text' => 'Local da seleção']]);
        echo $this->Form->control('formaSelecao', ['label' => ['text' => 'Forma de seleção'], 'options' => ['0' => 'Entrevista', '1' => 'CR', '2' => 'Prova', '3' => 'Outras (especificar em "Outras informações")']]);
        echo $this->Form->control('contato', ['label' => ['text' => 'Contato'], 'type' => 'email']);
        echo $this->Form->control('periodo', ['label' => ['text' => 'Período'], 'value' => $periodo, 'readonly']);
        echo $this->Form->control('datafax', ['type' => 'hidden', 'empty' => true]);
        echo $this->Form->control('localInscricao', ['label' => ['text' => 'Local da inscrição'], 'options' => ['0' => 'Somente no mural da Coordenação de Estágio/ESS', '1' => 'Diretamente na Instituição e no mural da Coordenação de Estágio/ESS']]);
        echo $this->Form->control('email', ['label' => ['text' => 'Email'], 'type' => 'email']);
        echo $this->Form->control('outras', ['type' => 'textarea', 'rows' => 5, 'style' => 'height: 200', 'label' => ['text' => 'Outras informações']]);
        ?>
    </fieldset>
    <div class="d-flex justify-content-end">
        <?= $this->Form->button(__('Confirmar'), ['class' => 'btn btn-primary']) ?>
    </div>
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
        .create(document.querySelector('#requisitos'), {
            plugins: [Essentials, Bold, Italic, Strikethrough, Font, Paragraph, List, Alignment],
            toolbar: [
                'undo', 'redo', '|', 'bold', 'italic', 'strikethrough', 'bulletedList', 'numberedList', 'alignment', '|',
                'fontSize', 'fontFamily', 'fontColor', 'fontBackgroundColor'
            ]
        })
        .then(editor => {
            requisitos = editor;
            console.log('Olá editor requisitos was initialized', requisitos);
            requisitos.setData("");
        });


    let outras;
    if (typeof outras !== 'undefined') {
        outras.destroy();
    }

    ClassicEditor
        .create(document.querySelector('#outras'), {
            plugins: [Essentials, Bold, Italic, Strikethrough, Font, Paragraph, List, Alignment],
            toolbar: [
                'undo', 'redo', '|', 'bold', 'italic', 'strikethrough', 'bulletedList', 'numberedList', 'alignment', '|',
                'fontSize', 'fontFamily', 'fontColor', 'fontBackgroundColor'
            ]
        })
        .then(editor => {
            outras = editor;
            console.log('Olá editor outras was initialized', outras);
            outras.setData("");
        });

</script>