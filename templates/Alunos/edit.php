<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Aluno $aluno
 * @var \App\Model\Entity\User $user
 */
?>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js"></script>

<script>
    $(document).ready(function () {

        $('#cpf').mask('000.000.000-00');

        if ($('#codigo-telefone').val() == null) {
            codigo = '21';
        } else {
            codigo = $('#codigo-telefone').val();
        }
        if ($('#telefone').val().length >= 8 && $('#telefone').val().length <= 10) {
            $('#telefone').val('(' + codigo + ') ' + $('#telefone').val());
        } else if ($('#telefone').val().length == 15) {
            $('#telefone').mask('(00) 00000-0000');
        } else {
            $('#telefone').mask('(00) 0000-0000');
        }
        if ($('#codigo-celular').val() == null) {
            codigo = '21';
        } else {
            codigo = $('#codigo-celular').val();
        }
        if ($('#celular').val().length >= 8 && $('#celular').val().length <= 10) {
            $('#celular').val('(' + codigo + ') ' + $('#celular').val());
        } else if ($('#celular').val().length == 15) {
            $('#celular').mask('(00) 00000-0000');
        } else {
            $('#celular').mask('(00) 0000-0000');
        }
        $('#nascimento').mask('00-00-0000', { placeholder: "dd-MM-yyyy" });
        $('#cep').mask('00000-000', {
            onComplete: function(cep, e, masks) {
                buscarEndereco(cep);
            }
        });        
        $('#ingresso').mask('0000-0');
        $('#novoperiodo').val($('#ingresso').val());
        $('#novoperiodo').mask('0000-0');
    });

    function buscarEndereco(cep) {
        $.ajax({
            url: "https://viacep.com.br/ws/" + cep + "/json/",
            type: "GET",
            dataType: "json",
            success: function(data) {
                $('#endereco').val(data.logradouro);
                $('#bairro').val(data.bairro);
                $('#municipio').val(data.localidade);
            }
        });
    }
</script>

<?php echo $this->element("menu_mural"); ?>

<nav class="navbar navbar-expand-lg py-2 navbar-light bg-light" id="actions-sidebar">
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarTogglerAlunosEdit"
        aria-controls="navbarTogglerAlunosEdit" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <ul class="navbar-nav collapse navbar-collapse" id="navbarTogglerAlunosEdit">
        <?php if (isset($user->categoria) && $user->categoria == "1"): ?>
            <?= $this->Html->link(
                __("Listar Alunos"),
                ["action" => "index"],
                ["class" => "btn btn-primary me-1"],
            ) ?>
            <?= $this->Form->postLink(
                __("Excluir"),
                ["action" => "delete", $aluno->id],
                [
                    "confirm" => __(
                        "Tem certeza que deseja excluir este registo # {0}?",
                        $aluno->id,
                    ),
                    "class" => "btn btn-danger me-1",
                ],
            ) ?>
            </li>
        <?php endif; ?>
    </ul>
</nav>

<?= $this->element("templates") ?>

<div class="container col-lg-8 shadow p-3 mb-5 bg-white rounded">
    <?= $this->Form->create($aluno) ?>
    <fieldset class="border p-2">
        <legend><?= __("Editar aluno(a)") ?></legend>
        <?php
        echo $this->Form->control("id", [
            "type" => "hidden",
        ]);
        echo $this->Form->control("nome", [
            "label" => "Nome",
            "class" => "form-control",
        ]);
        echo $this->Form->control("nomesocial", [
            "label" => "Nome social",
            "class" => "form-control",
        ]);
        echo $this->Form->control("registro", [
            "label" => "Registro",
            "class" => "form-control",
        ]);
        echo $this->Form->control("ingresso", [
            'placeholder' => 'Ano e período de ingresso: ex: 2023-1',
            "label" => "Ingresso",
            "class" => "form-control",
        ]);
        echo $this->Form->control("turno", [
            'placeholder' => 'diurno, noturno ou outro',
            'options' => [
                'diurno' => 'Diurno',
                'noturno' => 'Noturno',
                'outro' => 'Outro',
            ],
            "label" => "Turno",
            "class" => "form-control",
            'templates' => [
                'formGroup' => '<div class="form-group row">{{label}}<div class="col-sm-9">{{input}}</div></div>',
                'label' => '<label class="col-sm-3 form-label"{{attrs}}>{{text}}</label>',
                'select' => '<div class="col-sm-9"><select class="form-select" name="{{name}}"{{attrs}}>{{content}}</select></div>',
            ],

        ]);
        echo $this->Form->control("nascimento", [
            'value' => $aluno->nascimento ? $aluno->nascimento->i18nFormat('dd-MM-yyyy') : '',
            'placeholder' => 'dd-MM-yyyy',
            'type' => 'text',
            'pattern' => '\d{2}-\d{2}-\d{4}',
            'title' => 'Formato: dd-MM-yyyy',
            "label" => "Data de nascimento",
            "empty" => true,
            "class" => "form-control",
        ]);
        echo $this->Form->control("cpf", [
            'placeholder' => 'Número do CPF: ex: 000.000.000-00',
            "label" => "CPF",
            "class" => "form-control",
        ]);
        echo $this->Form->control("identidade", [
            "label" => "RG",
            "class" => "form-control",
        ]);
        echo $this->Form->control("orgao", [
            "label" => "Orgão emissor",
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
            __("Confirmar alterações"),
            ["class" => "btn btn-primary"],
        ) ?>
    </div>
    <?= $this->Form->end() ?>
</div>