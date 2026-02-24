<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Aluno $aluno
 */
?>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js"></script>

<script>

    $(document).ready(function() {
        $('#cpf').mask('000.000.000-00');
        if ($('#codigo-telefone').val() == null) {
            codigo = '21';
        } else {
            codigo = $('#codigo-telefone').val();
        }
        if ($('#telefone').val().length == 9) {
            $('#telefone').val('(' + codigo + ') ' + $('#telefone').val());
        } else {
            $('#telefone').mask('(00) 0000-0000');
        }
        if ($('#codigo-celular').val() == null) {
            codigo = '21';
        } else {
            codigo = $('#codigo-celular').val();
        }
        if ($('#celular').val().length == 10) {
            $('#celular').val('(' + codigo + ') ' + $('#celular').val());
        } else {
            $('#celular').mask('(00) 00000-0000');
        }
        $('#nascimento').mask('00-00-0000');
        $('#cep').mask('00000-000');
        $('#ingresso').mask('0000-0');
        if ($('#novoperiodo').val() == null) {
            $('#novoperiodo').val($('#ingresso').val());
        }
        $('#novoperiodo').mask('0000-0');
    });
</script>

<?= $this->element('menu_mural') ?>

<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
        aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav me-auto mb-2 mb-lg-0">
            <?php if (isset($user) && $user->categoria == '1'): ?>
                <li class="nav-item">
                    <?= $this->Html->link(__('Listar Alunos'), ['controller' => 'Alunos', 'action' => 'index'], ['class' => 'btn btn-primary me-1']) ?>
                </li>
                <li class="nav-item">
                    <?= $this->Html->link(__('Declaração de período'), ['controller' => 'Alunos', 'action' => 'certificadoperiodo', $aluno->id], ['class' => 'btn btn-primary me-1']) ?>
                </li>
                <li class="nav-item">
                    <?= $this->Html->link(__('Termo de compromisso'), ['controller' => 'Estagiarios', 'action' => 'novotermocompromisso', '?' => ['aluno_id' => $aluno->id]], ['class' => 'btn btn-primary me-1']) ?>
                </li>
                <li class="nav-item">
                    <?= $this->Html->link(__('Novo Aluno'), ['controller' => 'Alunos', 'action' => 'add'], ['class' => 'btn btn-primary me-1']) ?>
                </li>
                <li class="nav-item">
                    <?= $this->Html->link(__('Editar Aluno'), ['controller' => 'Alunos', 'action' => 'edit', $aluno->id], ['class' => 'btn btn-primary me-1']) ?>
                </li>
                <li class="nav-item">
                    <?= $this->Form->postLink(__('Excluir Aluno'), ['controller' => 'Alunos', 'action' => 'delete', $aluno->id], ['confirm' => __('Tem certeza que quer excluir o registro # {0}?', $aluno->id), 'class' => 'btn btn-danger me-1']) ?>
                </li>
            <?php elseif (isset($user) && $user->categoria == '2'): ?>
                <?php if ($user->aluno_id == $aluno->id): ?>
                    <li class="nav-item">
                        <?= $this->Html->link(__('Editar Aluno'), ['controller' => 'Alunos', 'action' => 'edit', $aluno->id], ['class' => 'btn btn-primary me-1']) ?>
                    </li>
                    <li class="nav-item">
                        <?= $this->Html->link(__('Declaração de período'), ['controller' => 'Alunos', 'action' => 'certificadoperiodo', $aluno->id], ['class' => 'btn btn-primary me-1']) ?>
                    </li>
                    <li class="nav-item">
                        <?= $this->Html->link(__('Termo de compromisso'), ['controller' => 'Estagiarios', 'action' => 'novotermocompromisso', $aluno->id], ['class' => 'btn btn-primary me-1']) ?>
                    </li>
                <?php endif; ?>
            <?php endif ?>
        </ul>
    </div>
</nav>

<?= $this->element('templates') ?>

<div class="container col-lg-8 shadow p-3 mb-5 bg-white rounded">
    <?= $this->Form->create($aluno) ?>
    <fieldset class="border p-2">
        <legend><?= __('Declaração de ' . $totalperiodos . 'º' . ' período do(a) aluno(a)') ?></legend>
        <?php
        if (isset($novoperiodo)):
            echo $this->Form->control('novoperiodo', ['label' => ['text' => 'Período de ingresso'], 'value' => $novoperiodo]);
        else:
            echo $this->Form->control('novoperiodo', ['label' => ['text' => 'Período de ingresso'], 'value' => $aluno['ingresso']]);
        endif;
        echo $this->Form->control('nome', ['label' => 'Nome', 'readonly' => true]);
        echo $this->Form->control('nomesocial', ['label' => ['text' => 'Nome social'], 'readonly' => true]);
        echo $this->Form->control('registro', ['label' => 'Registro', 'readonly' => true]);
        echo $this->Form->control('ingresso', ['label' => 'Ingresso', 'readonly' => true]);
        echo $this->Form->control('turno', ['options' => ['diurno' => 'Diurno', 'noturno' => 'Noturno'], 'readonly' => true, 
        'templates' => ['inputContainer' => '<div class="row col-md-12 {{type}}{{required}}">{{content}}</div>',
                        'label' => '<label class="col-sm-3 col-form-label"{{attrs}}>{{text}}</label>',
                        'select' => '<div class="col-sm-9"><select class="form-select" name="{{name}}"{{attrs}}>{{content}}</select></div>']]);
        echo $this->Form->control('codigo_telefone', ['label' => ['text' => 'DDD'], 'readonly' => true]);
        echo $this->Form->control('telefone', ['label' => ['text' => 'Telefone'], 'readonly' => false]);
        echo $this->Form->control('codigo_celular', ['label' => ['text' => 'DDD'], 'readonly' => true]);
        echo $this->Form->control('celular', ['label' => ['text' => 'Celular'], 'readonly' => false]);
        echo $this->Form->control('email', ['label' => ['text' => 'E-mail'], 'readonly' => true ]);
        echo $this->Form->control('cpf', ['label' => ['text' => 'CPF'], 'readonly' => false]);
        echo $this->Form->control('identidade', ['label' => ['text' => 'Carteira de identidade'], 'readonly' => true]);
        echo $this->Form->control('orgao', ['label' => ['text' => 'Orgão emissor'], 'readonly' => true]);
        echo $this->Form->control('nascimento', ['type' => 'text', 'empty' => true, 'readonly' => true]);
        echo $this->Form->control('endereco', ['label' => ['text' => 'Endereço'], 'readonly' => true]);
        echo $this->Form->control('cep', ['label' => ['text' => 'CEP'], 'readonly' => true  ]);
        echo $this->Form->control('municipio', ['label' => ['text' => 'Município'], 'readonly' => true  ]);
        echo $this->Form->control('bairro', ['label' => ['text' => 'Bairro'], 'readonly' => true]);
        echo $this->Form->control('observacoes', ['label' => ['text' => 'Observações'], 'readonly' => true]);
        ?>
    </fieldset>
    
    <?php
    // This is a template
    $Confirma = [
        "button" => "<div class='d-flex justify-content-center'><button type ='Confirma' class= 'btn btn-danger' {{attrs}}>{{text}}</button></div>"
    ]
    ?>

    <div class="d-flex justify-content-center">
        <div class="btn-group" role="group" aria-label="Confirma">
            <?= $this->Html->link('Imprime PDF', ['action' => 'certificadoperiodopdf', '?' => ['id' => $aluno->id, 'totalperiodos' => $totalperiodos]], ['class' => 'btn btn-lg btn-primary  me-1', 'rule' => 'button']); ?>
            <?php $this->Form->setTemplates($Confirma); ?>
            <?= $this->Form->button(__('Confirmar período'), ['type' => 'Confirma', 'class' => 'btn btn-lg btn-danger']) ?>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>
