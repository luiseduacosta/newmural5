<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Questionario $questionario
 */
?>

<?= $this->element("menu_mural"); ?>
<?= $this->element("templates"); ?>

<div class="container mt-1">

    <nav class="navbar-expand-lg navbar-light bg-light">
        <ul class="navbar-nav collapse navbar-collapse">
            <li class="nav-item">
                <?= $this->Html->link(
                    __("Listar Questionarios"),
                    ["controller" => "Questionarios", "action" => "index"],
                    ["class" => "btn btn-primary me-1"],
                ) ?>
            </li>
        </ul>
    </nav>

    <div class="container mt-4">
        <?= $this->Form->create($questionario) ?>
        <fieldset>
            <legend><?= __("Novo questionario") ?></legend>
            <?php
            echo $this->Form->control("title", ["label" => "Título"]);
            echo $this->Form->control("description", [
                "label" => [
                    "text" => "Descrição",
                    "class" => "label-control col-sm-3",
                ],
                "class" => "form-control",
            ]);
            echo $this->Form->control("is_active", ["label" => "Ativo"]);
            echo $this->Form->control("category", ["label" => "Categoria"]);
            echo $this->Form->control("target_user_type", [
                "label" => "Tipo de usuário alvo",
            ]);
            ?>
        </fieldset>
        <?= $this->Form->button(__("Confirma"), [
            "class" => "btn btn-primary",
        ]) ?>
        <?= $this->Form->end() ?>
    </div>
</div>
