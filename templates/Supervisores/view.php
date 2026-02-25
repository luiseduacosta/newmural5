<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Supervisor $supervisor
 */
?>

<?php echo $this->element("menu_mural"); ?>

<nav class="navbar navbar-expand-lg py-2 navbar-light bg-light">
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarTogglerSupervisores"
        aria-controls="navbarTogglerSupervisores" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <ul class="navbar-nav collapse navbar-collapse" id="navbarTogglerSupervisores">
        <?php if (isset($user) && $user->categoria == "1"): ?>
            <?= $this->Html->link(
                __("Listar supervisores(as)"),
                ["action" => "index"],
                ["class" => "btn btn-primary me-1"],
            ) ?>
            <?= $this->Html->link(
                __("Editar supervisor(a)"),
                ["action" => "edit", $supervisor->id],
                ["class" => "btn btn-primary me-1"],
            ) ?>
            <?= $this->Html->link(
                __("Cadastrar supervisor(a)"),
                ["action" => "add"],
                ["class" => "btn btn-primary me-1"],
            ) ?>
            <?= $this->Form->postLink(
                __("Exclur supervisor(a)"),
                ["action" => "delete", $supervisor->id],
                [
                    "confirm" => __(
                        "Tem certeza que deseja excluir este registo # {0}?",
                        $supervisor->id,
                    ),
                    "class" => "btn btn-danger me-1",
                ],
            ) ?>
        <?php elseif (isset($user) && $user->categoria == "4"): ?>
            <?php if ($user->supervisor_id == $supervisor->id): ?>
                <?= $this->Html->link(
                    __("Editar supervisor(a)"),
                    ["action" => "edit", $supervisor->id],
                    ["class" => "btn btn-primary"],
                ) ?>
            <?php endif; ?>
        <?php endif; ?>
    </ul>
</nav>

<div class="row">
    <ul class="nav nav-tabs">
        <li class="nav-item">
            <a class="nav-link active" data-bs-toggle="tab" href="#supervisora" role="tab" aria-controls="supervisora"
                aria-selected="true">Supervisora</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" data-bs-toggle="tab" href="#instituicao" role="tab" aria-controls="instituicao"
                aria-selected="false">Instituição</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" data-bs-toggle="tab" href="#estagiarios" role="tab" aria-controls="estagiarios"
                aria-selected="false">Estagiários</a>
        </li>
    </ul>
</div>

<div class="tab-content container">

        <div id="supervisora" class="tab-pane container active show">
            <h3><?= $supervisor->nome ?></h3>
            <table class="table table-striped table-hover table-responsive">
                <col style="width: 30%;">
                <col style="width: 70%;">
                <tr>
                    <th><?= __("Id") ?></th>
                    <td><?= $this->Number->format($supervisor->id, [
                        "pattern" => "######",
                    ]) ?></td>
                </tr>
                <tr>
                    <th><?= __("Cress") ?></th>
                    <td><?= $this->Number->format($supervisor->cress, [
                        "pattern" => "######",
                    ]) ?></td>
                </tr>
                <tr>
                    <th><?= __("Região") ?></th>
                    <td><?= $this->Number->ordinal($supervisor->regiao, [
                        "locale" => "pt_BR",
                    ]) ?></td>
                </tr>
                <tr>
                    <th><?= __("CPF") ?></th>
                    <td><?= $supervisor->cpf ?></td>
                </tr>
                <tr>
                    <th><?= __("Cargo na instituição") ?></th>
                    <td><?= $supervisor->cargo ?></td>
                </tr>
                <tr>
                    <th><?= __("CEP") ?></th>
                    <td><?= $supervisor->cep ?></td>
                </tr>
                <tr>
                    <th><?= __("Endereço") ?></th>
                    <td><?= $supervisor->endereco ?></td>
                </tr>
                <tr>
                    <th><?= __("Bairro") ?></th>
                    <td><?= $supervisor->bairro ?></td>
                </tr>
                <tr>
                    <th><?= __("Município") ?></th>
                    <td><?= $supervisor->municipio ?></td>
                </tr>
                <tr>
                    <th><?= __("E-mail") ?></th>
                    <td><?= $this->Html->link(
                        $supervisor->email,
                        "mailto:" . $supervisor->email,
                        ["target" => "_blank"],
                    ) ?></td>
                </tr>
                <tr>
                    <th><?= __("DDD") ?></th>
                    <td><?= $this->Number->format($supervisor->codigo_tel, [
                        "places" => 0,
                    ]) ?></td>
                </tr>
                <tr>
                    <th><?= __("Telefone") ?></th>
                    <td><?= $supervisor->telefone ?></td>
                </tr>
                <tr>
                    <th><?= __("DDD") ?></th>
                    <td><?= $this->Number->format($supervisor->codigo_cel, [
                        "places" => 0,
                    ]) ?></td>
                </tr>
                <tr>
                    <th><?= __("Celular") ?></th>
                    <td><?= $supervisor->celular ?></td>
                </tr>
                <tr>
                    <th><?= __("Escola de formação em Serviço Social") ?></th>
                    <td><?= $supervisor->escola ?></td>
                </tr>
                <tr>
                    <th><?= __("Ano Formatura") ?></th>
                    <td><?= $supervisor->ano_formatura ?></td>
                </tr>
                <tr>
                    <th><?= __("Outros estudos") ?></th>
                    <td><?= $supervisor->outros_estudos ?></td>
                </tr>
                <tr>
                    <th><?= __("Área do curso de outros estudos") ?></th>
                    <td><?= $supervisor->area_curso ?></td>
                </tr>
                <tr>
                    <th><?= __("Ano do curso de outros estudos") ?></th>
                    <td><?= $supervisor->ano_curso ?></td>
                </tr>
                <tr>
                    <th><?= __("Turma do curso de supervisores da ESS") ?></th>
                    <td><?= $supervisor->curso_turma ?></td>
                </tr>
                <tr>
                    <th><?= __(
                        "Número de inscrição no curso de supervisores da ESS",
                    ) ?></th>
                    <td><?= $supervisor->num_inscricao ?></td>
                </tr>
            </table>
            <div class="text-justify">
                <strong><?= __("Observações") ?></strong>
                <blockquote>
                    <?= $this->Text->autoParagraph($supervisor->observacoes) ?>
                </blockquote>
            </div>
        </div>

        <div id="instituicao" class="tab-pane container fade">
            <h4><?= __("Instituição de estágio") ?></h4>
            <?php if ($supervisor->hasValue('instituicoes')): ?>
                <table class="table table-striped table-hover table-responsive">
                    <thead>
                    <tr>
                        <th><?= __("Id") ?></th>
                        <th><?= __("Instituição") ?></th>
                        <th><?= __("CNPJ") ?></th>
                        <th><?= __("E-mail") ?></th>
                        <th><?= __("Endereço") ?></th>
                        <th><?= __("Bairro") ?></th>
                        <th><?= __("Município") ?></th>
                        <th><?= __("CEP") ?></th>
                        <th><?= __("Telefone") ?></th>
                        <th><?= __("Convenio") ?></th>
                        <th><?= __("Expira") ?></th>
                        <th><?= __("Seguro") ?></th>
                        <th><?= __("Observações") ?></th>
                        <th><?= __("Ações") ?></th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php foreach (
                        $supervisor->instituicoes
                        as $instituicoes
                    ): ?>
                        <tr>
                            <td><?= $this->Number->format($instituicoes->id, [
                                "pattern" => "######",
                            ]) ?></td>
                            <td><?= h($instituicoes->instituicao) ?></td>
                            <td><?= $this->Number->format($instituicoes->cnpj, [
                                "pattern" => "##.###.###/####-##",
                            ]) ?></td>
                            <td><?= h($instituicoes->email) ?></td>
                            <td><?= h($instituicoes->endereco) ?></td>
                            <td><?= h($instituicoes->bairro) ?></td>
                            <td><?= h($instituicoes->municipio) ?></td>
                            <td><?= $this->Number->format($instituicoes->cep, [
                                "pattern" => "#####-###",
                            ]) ?></td>
                            <td><?= $this->Number->format(
                                $instituicoes->telefone,
                                ["pattern" => "####-####"],
                            ) ?></td>
                            <td><?= h($instituicoes->convenio) ?></td>
                            <td><?= h($instituicoes->expira) ?></td>
                            <td><?= h($instituicoes->seguro) ?></td>
                            <td><?= $this->Text->autoParagraph(
                                h($instituicoes->observacoes),
                            ) ?></td>
                            <td class="d-grid">
                                <?= $this->Html->link(__("Ver"), [
                                    "controller" => "Instituicoes",
                                    "action" => "view",
                                    $instituicoes->id,
                                ], ["class" => "btn btn-primary btn-sm btn-block mb-1"]) ?>
                                <?php if (
                                    isset($user) &&
                                    $user["categoria"] == 1
                                ): ?>
                                    <?= $this->Html->link(__("Editar"), [
                                        "controller" => "Instituicoes",
                                        "action" => "edit",
                                        $instituicoes->id,
                                    ], ["class" => "btn btn-primary btn-sm btn-block mb-1"]) ?>
                                    <?= $this->Form->postLink(
                                        __("Excluir"),
                                        [
                                            "controller" => "Instituicoes",
                                            "action" => "delete",
                                            $instituicoes->id,
                                        ],
                                        [
                                            "confirm" => __(
                                                "Tem certeza que quer excluir o registro # {0}?",
                                                $instituicoes->id,
                                            ), "class" => "btn btn-danger btn-sm btn-block mb-1"
                                        ],
                                    ) ?>
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                    </tbody>
                </table>
            <?php endif; ?>
        </div>

        <div id="estagiarios" class="tab-pane container fade">
            <h4><?= __("Estagiarios") ?></h4>
            <?php if (!empty($supervisor->estagiarios)): ?>
                <table class="table table-striped table-hover table-responsive">
                    <thead>
                    <tr>
                        <th><?= __("ID") ?></th>
                        <th><?= __("Estudante") ?></th>
                        <th><?= __("Registro") ?></th>
                        <th><?= __("Turno") ?></th>
                        <th><?= __("Nível") ?></th>
                        <th><?= __("Docente") ?></th>
                        <th><?= __("Período") ?></th>
                        <th><?= __("Nota") ?></th>
                        <th><?= __("CH") ?></th>
                        <th><?= __("Observações") ?></th>
                        <th><?= __("Ações") ?></th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php foreach ($supervisor->estagiarios as $estagiarios): ?>
                        <tr>
                            <td><?= h($estagiarios->id) ?></td>
                            <td><?= $this->Html->link(
                                $estagiarios->aluno["nome"],
                                [
                                    "controller" => "alunos",
                                    "action" => "view",
                                    $estagiarios->aluno_id,
                                ],
                            ) ?>
                            </td>
                            <td><?= h($estagiarios->registro) ?></td>
                            <td><?= h($estagiarios->turno) ?></td>
                            <td><?= h($estagiarios->nivel) ?></td>
                            <?php if (
                                isset($user) &&
                                $user->categoria == "1"
                            ): ?>
                                <td><?= $estagiarios->hasValue("professor")
                                    ? $this->Html->link(
                                        h($estagiarios->professor["nome"]),
                                        [
                                            "controller" => "Professores",
                                            "action" => "view",
                                            $estagiarios->professor_id,
                                        ],
                                    )
                                    : "" ?>
                                </td>
                            <?php else: ?>
                                <td><?= $estagiarios->hasValue("professor")
                                    ? $estagiarios->professor["nome"]
                                    : "" ?>
                                <?php endif; ?>
                            <td><?= h($estagiarios->periodo) ?></td>
                            <td><?= h($estagiarios->nota) ?></td>
                            <td><?= h($estagiarios->ch) ?></td>
                            <td><?= h($estagiarios->observacoes) ?></td>
                            <td class="d-grid">
                                <?php if (
                                    isset($user) &&
                                    ($user->categoria == "1" || $user->categoria == "4")
                                ): ?>
                                <?= $this->Html->link(__("Avaliação"), [
                                    "controller" => "Respostas",
                                    "action" => "view",
                                    "?" => ["estagiario_id" => $estagiarios->id],
                                ], ["class" => "btn btn-primary btn-sm btn-block mb-1"]) ?>
                                <?php endif; ?>
                                <?= $this->Html->link(__("Ver"), [
                                    "controller" => "Estagiarios",
                                    "action" => "view",
                                    $estagiarios->id,
                                ], ["class" => "btn btn-primary btn-sm btn-block mb-1"]) ?>
                                <?php if (
                                    isset($user) &&
                                    $user["categoria"] == "1"
                                ): ?>
                                    <?= $this->Html->link(__("Editar"), [
                                        "controller" => "Estagiarios",
                                        "action" => "edit",
                                        $estagiarios->id,
                                    ], ["class" => "btn btn-primary btn-sm btn-block mb-1"]) ?>
                                    <?= $this->Form->postLink(
                                        __("Excluir"),
                                        [
                                            "controller" => "Estagiarios",
                                            "action" => "delete",
                                            $estagiarios->id,
                                        ],
                                        [
                                            "confirm" => __(
                                                "Tem certeza que deseja excluir este registo # {0}?",
                                                $estagiarios->id,
                                            ), "class" => "btn btn-danger btn-sm btn-block mb-1",
                                        ],
                                    ) ?>
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                    </tbody>
                </table>
            <?php endif; ?>
        </div>
</div>
