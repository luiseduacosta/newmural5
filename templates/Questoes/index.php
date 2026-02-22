<?php
/**
 * @var \App\View\AppView $this
 * @var iterable<\App\Model\Entity\Questao $questoes 
 */
?>

<?= $this->element("menu_mural"); ?>
<?= $this->element("templates"); ?>

<div class="container">

    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <ul class="navbar-nav collapse navbar-collapse">
            <?php if (isset($user) && $user->categoria == '1'): ?>
            <li class="nav-item">
                <?= $this->Html->link(
                    __("Nova questão"),
                    ["action" => "add"],
                    [
                        "class" => "btn btn-primary",
                    ],
                ) ?>
            </li>
            <?php endif; ?>
        </ul>
    </nav>

    <div class="container mt-1">
        <table class="table table-striped table-hover table-responsive">
            <thead class="table-dark">
                <tr>
                    <th><?= $this->Paginator->sort("id") ?></th>
                    <th><?= $this->Paginator->sort(
                        "questionario->title",
                        "Questionário",
                    ) ?></th>
                    <th><?= $this->Paginator->sort("text", "Questão") ?></th>
                    <th><?= $this->Paginator->sort("type", "Tipo") ?></th>
                    <th><?= $this->Paginator->sort("options", "Opções") ?></th>
                    <th><?= $this->Paginator->sort("ordem") ?></th>
                    <th><?= __("Ações") ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($questoes as $questao): ?>
                    <tr>
                        <td><?= $this->Number->format($questao->id) ?></td>
                        <td><?= $questao->hasValue("questionario")
                            ? $this->Html->link(
                                $questao->questionario->title,
                                [
                                    "controller" => "Questionarios",
                                    "action" => "view",
                                    $questao->questionario->id,
                                ],
                            )
                            : "" ?>
                        </td>
                        <td><?= h($questao->text) ?></td>
                        <td><?= h($questao->type) ?></td>
                        <td>
                            <?php if ($questao->options) {
                                $opcoes = json_decode(
                                    $questao->options, true
                                );
                                foreach ($opcoes as $key => $opcao):
                                    echo $key . " - " . $opcao . "<br>";
                                endforeach;
                            } ?>
                        </td>
                        <td><?= $questao->ordem === null
                            ? ""
                            : $this->Number->format($questao->ordem) ?></td>
                        <td class="d-grid">
                            <?= $this->Html->link(__("Ver"), [
                                "action" => "view",
                                $questao->id,
                            ], [
                                "class" => "btn btn-primary btn-sm btn-block p-1 mb-1",
                            ]) ?>
                            <?php if (isset($user) && $user->categoria == '1'): ?>
                            <?= $this->Html->link(__("Editar"), [
                                "action" => "edit",
                                $questao->id,
                            ], [
                                "class" => "btn btn-primary btn-sm btn-block p-1 mb-1",
                            ]) ?>
                            <?= $this->Form->postLink(
                                __("Excluir"),
                                ["action" => "delete", $questao->id],
                                [
                                    "confirm" => __(
                                        "Tem certeza que deseja excluir este registro # {0}?",
                                        $questao->id,
                                    ),
                                    'class' => 'btn btn-danger btn-sm btn-block p-1 mb-1',
                                ],
                            ) ?>
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <div class="paginator">
        <ul class="pagination">
            <?= $this->Paginator->first("<< " . __("primeiro")) ?>
            <?= $this->Paginator->prev("< " . __("anterior")) ?>
            <?= $this->Paginator->numbers() ?>
            <?= $this->Paginator->next(__("próximo") . " >") ?>
            <?= $this->Paginator->last(__("último") . " >>") ?>
        </ul>
        <p><?= $this->Paginator->counter(
            __(
                "Página {{page}} de {{pages}}, mostrando {{current}} registros(s) de um total de {{count}}.",
            ),
        ) ?>
        </p>
    </div>
</div>