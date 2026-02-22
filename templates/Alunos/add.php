<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Aluno $aluno
 * @var \App\Model\Entity\User $user
 */
?>

<script>
    $(document).ready(function() {
        $('#cpf').mask('000.000.000-00');
        $('#telefone').mask('(00) 0000.0000');
        $('#celular').mask('(00) 00000.0000');
        $('#cep').mask('00000-000');
        $('#ingresso').mask('0000-0');
        $('#novoperiodo').val($('#ingresso').val());
        $('#novoperiodo').mask('0000-0');
        $('#nascimento').mask('0000-00-00', { placeholder: "AAAA-MM-DD" });
    });
</script>

<?php echo $this->element("menu_mural"); ?>

<nav class="navbar navbar-expand-lg py-2 navbar-light bg-light" id="actions-sidebar">
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarTogglerAlunosAdd"
        aria-controls="navbarTogglerAlunosAdd" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <ul class="navbar-nav collapse navbar-collapse" id="navbarTogglerAlunosAdd">
        <?php if (isset($user->categoria) && $user->categoria == "1"): ?>
            <li class="nav-item">
                <?= $this->Html->link(
                    __("Listar alunos"),
                    ["action" => "index"],
                    ["class" => "btn btn-primary"],
                ) ?>
            </li>
        <?php endif; ?>
    </ul>
</nav>

<?php $this->element("templates"); ?>

<div class="container col-lg-8 shadow p-3 mb-5 bg-white rounded">
    <?= $this->Form->create($aluno) ?>
    <fieldset class="border p-2">
        <legend><?= __("Novo aluno") ?></legend>
        <?php
        echo $this->Form->control("nome", [
            "label" => "Nome",
            "class" => "form-control",
        ]);
        echo $this->Form->control("nomesocial", [
            "label" => "Nome social",
            "class" => "form-control",
        ]);
        echo $this->Form->control("registro", [
            'placeholder' => 'Número do DRE',
            "label" => "Registro",
            "class" => "form-control",
        ]);
        echo $this->Form->control("ingresso", [
            'placeholder' => 'Ano e semestre, separado por hífen de ingresso no curso: ex: 2023-1',
            "label" => "Ingresso",
            "class" => "form-control",
        ]);
        echo $this->Form->control("turno", [
            'placeholder' => 'diurno, noturno ou outro',
            "label" => "Turno",
            "class" => "form-control",
        ]);
        echo $this->Form->control("nascimento", [
            "label" => "Data de nascimento",
            "placeholder" => "AAAA-MM-DD",
            "empty" => true,
            "class" => "form-control",
        ]);
        echo $this->Form->control("cpf", [
            'placeholder' => 'Número do CPF: ex: 000.000.000-00',
            "label" => "CPF",
            "class" => "form-control",
        ]);
        echo $this->Form->control("identidade", [
            'placeholder' => 'Número da identidade: ex: 000000000',
            "label" => "RG",
            "class" => "form-control",
        ]);
        echo $this->Form->control("orgao", [
            "placeholder" => "Orgão expedidor",
            "label" => "Orgão",
            "class" => "form-control",
        ]);
        echo $this->Form->control("email", [
            "label" => "E-mail",
            "class" => "form-control",
        ]);
        echo $this->Form->control("codigo_telefone", [
            "label" => "DDD",
            "class" => "form-control",
        ]);
        echo $this->Form->control("telefone", [
            "label" => "Telefone",
            "class" => "form-control",
        ]);
        echo $this->Form->control("codigo_celular", [
            "label" => "DDD",
            "class" => "form-control",
        ]);
        echo $this->Form->control("celular", [
            "label" => "Celular",
            "class" => "form-control",
        ]);
        echo $this->Form->control("cep", [
            "placeholder" => "CEP: ex: 00000-000",
            "label" => "CEP",
            "class" => "form-control",
        ]);
        echo $this->Form->control("endereco", [
            "label" => "Endereço",
            "class" => "form-control",
        ]);
        echo $this->Form->control("municipio", [
            "label" => "Município",
            "class" => "form-control",
        ]);
        echo $this->Form->control("bairro", [
            "label" => "Bairro",
            "class" => "form-control",
        ]);
        echo $this->Form->control("observacoes", [
            "label" => "Observações",
            "class" => "form-control",
        ]);
        ?>
    </fieldset>
    <div class="d-flex justify-content-center">
        <?= $this->Form->button(
            __("Confirma"),
            ["class" => "btn btn-primary mt-1"])
         ?>
    </div>
    <?= $this->Form->end() ?>
</div>
