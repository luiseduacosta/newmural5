<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Estagiario $estagiarios
 * @var \App\Model\Entity\Aluno $alunos
 */
?>

<?= $this->element("menu_mural"); ?>

<nav class="navbar navbar-expand-lg py-2 navbar-light bg-light" id="actions-sidebar">
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarTogglerEstagiarios"
        aria-controls="navbarTogglerEstagiarios" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <ul class="navbar-nav collapse navbar-collapse" id="navbarTogglerEstagiarios">
        <?php if (isset($user) && $user->categoria == "1"): ?>
            <li class="nav-item">
                <?= $this->Form->postLink(
                    __("Excluir Estagiario"),
                    ["action" => "delete", $estagiario->id],
                    [
                        "confirm" => __(
                            "Tem certeza que deseja excluir este registo # {0}?",
                            $estagiario->id,
                        ),
                        "class" => "btn btn-danger me-1",
                        "style" =>
                            "max-width:120px; word-wrap:break-word; font-size:14px",
                    ],
                ) ?>
            </li>
            <li class="nav-item">
                <?= $this->Html->link(
                    __("Listar Estagiarios"),
                    ["action" => "index"],
                    [
                        "class" => "btn btn-primary me-1",
                        "style" =>
                            "max-width:120px; word-wrap:break-word; font-size:14px",
                    ],
                ) ?>
            </li>
            <li class="nav-item">
                <?= $this->Html->link(
                    __("Inserir Estagiario"),
                    [
                        "action" => "add",
                        "?" => ["aluno_id" => $estagiario->aluno_id],
                    ],
                    [
                        "class" => "btn btn-primary me-1",
                        "style" =>
                            "max-width:120px; word-wrap:break-word; font-size:14px",
                    ],
                ) ?>
            </li>
            <li class="nav-item">
                <?= $this->Html->link(
                    __("Editar Estagiario"),
                    ["action" => "edit", $estagiario->id],
                    [
                        "class" => "btn btn-primary me-1",
                        "style" =>
                            "max-width:120px; word-wrap:break-word; font-size:14px",
                    ],
                ) ?>
            </li>
            <li class="nav-item">
                <?= $this->Html->link(
                    __("Termo de compromisso"),
                    [
                        "controller" => "estagiarios",
                        "action" => "novotermocompromisso",
                        "?" => ["aluno_id" => $estagiario->aluno_id],
                    ],
                    [
                        "class" => "btn btn-primary me-1",
                        "style" =>
                            "max-width:120px; word-wrap:break-word; font-size:14px",
                    ],
                ) ?>
            </li>
        <?php endif; ?>

        <?php if (
            isset($user) &&
            ($user->categoria == "1" || $user->categoria == "4")
        ): ?>
            <li class="nav-item">
                <?= $this->Html->link(
                    __("Preencher Avaliação"),
                    [
                        "controller" => "respostas",
                        "action" => "add",
                        "?" => ["estagiario_id" => $estagiario->id],
                    ],
                    [
                        "class" => "btn btn-primary me-1",
                        "style" =>
                            "max-width:100px; word-wrap:break-word; font-size:14px",
                    ],
                ) ?>
            </li>
        <?php endif; ?>

        <?php if (isset($user) && $user->categoria == "1"): ?>
            <li class="nav-item">
                <?= $this->Html->link(
                    __("Imprimir Avaliação"),
                    [
                        "controller" => "respostas",
                        "action" => "imprimeresposta",
                        "?" => ["estagiario_id" => $estagiario->id],
                    ],
                    [
                        "class" => "btn btn-primary me-1",
                        "style" =>
                            "max-width:100px; word-wrap:break-word; font-size:14px",
                    ],
                ) ?>
            </li>
            <li class="nav-item">
                <?= $this->Html->link(
                    __("Preencher Atividades"),
                    [
                        "controller" => "folhadeatividades",
                        "action" => "atividade",
                        "?" => ["estagiario_id" => $estagiario->id],
                    ],
                    [
                        "class" => "btn btn-primary me-1",
                        "style" =>
                            "max-width:100px; word-wrap:break-word; font-size:14px",
                    ],
                ) ?>
            </li>
            <li class="nav-item">
                <?= $this->Html->link(
                    __("Imprimir Atividades"),
                    [
                        "controller" => "folhadeatividades",
                        "action" => "folhadeatividadespdf",
                        "?" => ["estagiario_id" => $estagiario->id],
                    ],
                    [
                        "class" => "btn btn-primary me-1",
                        "style" =>
                            "max-width:100px; word-wrap:break-word; font-size:14px",
                    ],
                ) ?>
            </li>
            <li class="nav-item">
                <?= $this->Html->link(
                    __("Declaração de estágio"),
                    ["action" => "declaracaodeestagiopdf", $estagiario->id],
                    [
                        "class" => "btn btn-primary me-1",
                        "style" =>
                            "max-width:100px; word-wrap:break-word; font-size:14px",
                    ],
                ) ?>
            </li>
        <?php endif; ?>
    </ul>
</nav>

<?= $this->element("templates") ?>

<div class='container col-lg-8 shadow p-3 mb-5 bg-white rounded'>

    <h3><?= h($estagiario->aluno->nome) ?></h3>

    <div class="row">
        <ul class="nav nav-tabs">
            <li class="nav-item">
                <a class="nav-link active" data-bs-toggle="tab" href="#estagiario" role="tab" aria-controls="estagiario"
                    aria-selected="true">Estagiário</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" data-bs-toggle="tab" href="#atividades" role="tab" aria-controls="atividades"
                    aria-selected="false">Atividades</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" data-bs-toggle="tab" href="#avaliacao" role="tab" aria-controls="avaliacao"
                    aria-selected="false">Avaliação</a>
            </li>
        </ul>
    </div>

    <div class="view">

        <div class="tab-content">
            <div id="estagiario" class="tab-pane container active show">
                <table class="table table-striped table-hover table-responsive">
                    <tr>
                        <th><?= __("Id") ?></th>
                        <td><?= $estagiario->id ?></td>
                    </tr>
                    <tr>
                        <th><?= __("Registro") ?></th>
                        <td><?= $estagiario->registro ?></td>
                    </tr>
                    <tr>
                        <th><?= __("Aluno") ?></th>
                        <?php if (isset($user) && $user->categoria == "1"): ?>
                            <td><?= isset($estagiario->aluno)
                                ? $this->Html->link(
                                    $estagiario->aluno["nome"],
                                    [
                                        "controller" => "Alunos",
                                        "action" => "view",
                                        $estagiario->aluno["id"],
                                    ],
                                )
                                : "" ?>
                            </td>
                        <?php else: ?>
                            <td><?= $estagiario->aluno["nome"] ?></td>
                        <?php endif; ?>
                    </tr>
                    <tr>
                        <th><?= __("Ajuste 2020") ?></th>
                        <td><?= h($estagiario->ajuste2020) == 0
                            ? "Não"
                            : "Sim" ?></td>
                    </tr>
                    <tr>
                        <th><?= __("Turno") ?></th>
                        <td><?= h($estagiario->turno) ?></td>
                    </tr>
                    <tr>
                        <th><?= __("Nível") ?></th>
                        <?php if ($estagiario->nivel == 9): ?>
                            <td>Não curricular</td>
                        <?php else: ?>
                            <td><?= h($estagiario->nivel) ?></td>
                        <?php endif; ?>
                    </tr>
                    <tr>
                        <th><?= __("Instituição") ?></th>
                        <?php if (isset($user) && $user->categoria == "1"): ?>
                            <td><?= isset($estagiario->instituicao)
                                ? $this->Html->link(
                                    $estagiario->instituicao["instituicao"],
                                    [
                                        "controller" => "Instituicoes",
                                        "action" => "view",
                                        $estagiario->instituicao["id"],
                                    ],
                                )
                                : "" ?>
                            </td>
                        <?php else: ?>
                            <td><?= $estagiario->hasValue("instituicao")
                                ? $estagiario->instituicao["instituicao"]
                                : "" ?>
                            </td>
                        <?php endif; ?>
                    </tr>
                    <tr>
                        <th><?= __("Supervisor(a)") ?></th>
                        <?php if (!empty($estagiario->supervisor["nome"])): ?>
                            <?php if (
                                isset($user) &&
                                $user->categoria == "1"
                            ): ?>
                                <td><?= isset($estagiario->supervisor)
                                    ? $this->Html->link(
                                        $estagiario->supervisor["nome"],
                                        [
                                            "controller" => "Supervisores",
                                            "action" => "view",
                                            $estagiario->supervisor["id"],
                                        ],
                                    )
                                    : "" ?>
                                </td>
                            <?php else: ?>
                                <td><?= $estagiario->hasValue("supervisor")
                                    ? $estagiario->supervisor["nome"]
                                    : "" ?></td>
                            <?php endif; ?>
                        <?php else: ?>
                            <td>Sem informaçao</td>
                        <?php endif; ?>
                    </tr>
                    <tr>
                        <th><?= __("Professor") ?></th>
                        <?php if (!empty($estagiario->professor["nome"])): ?>
                            <?php if (
                                isset($user) &&
                                $user->categoria == "1"
                            ): ?>
                                <td><?= isset($estagiario->professor)
                                    ? $this->Html->link(
                                        $estagiario->professor["nome"],
                                        [
                                            "controller" => "Professores",
                                            "action" => "view",
                                            $estagiario->professor["id"],
                                        ],
                                    )
                                    : "" ?>
                                </td>
                            <?php else: ?>
                                <td><?= $estagiario->hasValue("professor")
                                    ? $estagiario->professor["nome"]
                                    : "" ?></td>
                            <?php endif; ?>
                        <?php else: ?>
                            <td>Sem informaçao</td>
                        <?php endif; ?>
                    </tr>
                    <tr>
                        <th><?= __("Período") ?></th>
                        <td><?= h($estagiario->periodo) ?></td>
                    </tr>
                    <tr>
                        <th><?= __("Turm de estágio") ?></th>
                        <td><?= isset($estagiario->turmaestagios)
                            ? $this->Html->link(
                                $estagiario->turmaestagios["area"],
                                [
                                    "controller" => "Turmaestagios",
                                    "action" => "view",
                                    $estagiario->turmaestagios["id"],
                                ],
                            )
                            : "" ?>
                        </td>
                    </tr>
                    <tr>
                        <th><?= __("TC") ?></th>
                        <td><?= $this->Number->format($estagiario->tc) ?></td>
                    </tr>
                    <tr>
                        <th><?= __("Data TC") ?></th>
                        <td><?= $estagiario->tc_solicitacao
                            ? $estagiario->tc_solicitacao
                            : "" ?></td>
                    </tr>
                    <?php if (isset($user) && $user->categoria == "1"): ?>
                        <tr>
                            <th><?= __("Nota") ?></th>
                            <?php if ($estagiario->nota): ?>
                                <td><?= $this->Number->format(
                                    $estagiario->nota,
                                    [
                                        "places" => 2,
                                    ],
                                ) ?></td>
                            </tr>
                        <?php else: ?>
                            <td>Sem informaçao</td>
                        <?php endif; ?>
                        <tr>
                            <th><?= __("Carga horária") ?></th>
                            <td><?= $this->Number->format(
                                $estagiario->ch,
                            ) ?></td>
                        </tr>
                        <tr>
                            <th><?= __("Observações") ?></th>
                            <td name='observacoes'><?= h(
                                $estagiario->observacoes,
                            ) ?></td>
                        </tr>
                    <?php endif; ?>
                    <tr>
                        <td colspan='2' class="text-center">
                            <?= $this->Html->link(
                                __("Imprime termo de compromisso"),
                                [
                                    "action" => "termodecompromissopdf",
                                    $estagiario->id,
                                ],
                                [
                                    "class" => "btn btn-warning mx-auto",
                                    "style" =>
                                        "max-width:120px; word-wrap:break-word; font-size:14px",
                                ],
                            ) ?>
                        </td>
                    </tr>
                </table>
            </div>
        </div>

        <div class="tab-content">
            <div id="atividades" class="tab-pane container">
                <?php if (empty($estagiario->folhadeatividades)): ?>
                    <div class="alert-warning" role="alert">
                        <h4 class="alert-heading">Atenção!</h4>
                        <p>Este estagiário ainda não possui atividades cadastradas.</p>
                        <hr>
                        <p class="mb-0">Clique no botão
                            <?= $this->Html->link(
                                "Preencher Atividades",
                                ['controller' => 'folhadeatividades', 'action' => 'atividade', '?' => ['estagiario_id' => $estagiario->id]],
                                ['class' => 'btn btn-sm btn-primary me-1']
                            ) ?>
                            para adicionar atividades.
                        </p>
                    </div>
                <?php else: ?>
                    <table class="table table-striped table-hover table-responsive">
                        <tr>
                            <th><?= __("Id") ?></th>
                            <th><?= __("Dia") ?></th>
                            <th><?= __("Início") ?></th>
                            <th><?= __("Final") ?></th>
                            <th><?= __("Atividade") ?></th>
                            <th><?= __("Horário") ?></th>
                        </tr>
                        <?php foreach (
                            $estagiario->folhadeatividades
                            as $folhadeatividade
                        ): ?>
                            <tr>
                                <td><?= h($folhadeatividade->id) ?></td>
                                <td>
                                    <?=
                                        $this->Time->format($folhadeatividade->dia, "d-MM-Y")
                                        ?>
                                </td>
                                <td>
                                    <?=
                                        $this->Time->format(
                                            $folhadeatividade->inicio,
                                            "HH:mm"
                                        )
                                        ?>
                                </td>
                                <td>
                                    <?=
                                        $this->Time->format(
                                            $folhadeatividade->final,
                                            "HH:mm"
                                        )
                                        ?>
                                </td>
                                <td class="text">
                                    <?= $this->Text->autoParagraph(
                                        h($folhadeatividade->atividade),
                                    ) ?>
                                </td>
                                <td><?= h($folhadeatividade->horario) ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </table>
                <?php endif; ?>
            </div>
        </div>

        <div class="tab-content">
            <div id="avaliacao" class="tab-pane container">
                <?php if (empty($estagiario->resposta)): ?>
                    <div class="alert-warning" role="alert">
                        <h4 class="alert-heading">Atenção!</h4>
                        <p>Este estagiário ainda não possui avaliação.</p>
                        <hr>
                        <?php if (isset($user->categoria)): ?>
                            <p class="mb-0">Clique no botão para
                                <?= $this->Html->link(
                                    "imprimir",
                                    ['controller' => 'respostas', 'action' => 'imprimeresposta', '?' => ['estagiario_id' => $estagiario->id]],
                                    ['class' => 'btn btn-sm btn-info me-1']
                                ) ?>
                                uma folha de avaliação.
                            </p>
                        <?php endif; ?>
                    </div>
                <?php else: ?>
                    <table class="table table-striped table-hover table-responsive">
                        <tr>
                            <td colspan="3">
                                <strong><?= __("Avaliação") ?></strong>
                            </td>
                        </tr>
                        <?php $avaliacoes = json_decode($estagiario->resposta->response, true); ?>
                        <?php foreach ($avaliacoes as $avaliacao): ?>
                            <?php if (is_string($avaliacao)) { ?>
                                <tr>
                                    <td colspan="3"><?php // h($avaliacao) ?></td>
                                </tr>
                            <?php } elseif (is_array($avaliacao)) { ?>
                                <tr>
                                    <td><?= h($avaliacao['pergunta']) ?></td>
                                    <td><?= h($avaliacao['valor']) ?></td>
                                    <td><?= h($avaliacao['texto_valor']) ?></td>
                                </tr>
                            <?php } ?>
                        <?php endforeach; ?>
                        </table>
                        <div class="row">
                            <div class="col-6">
                                <?= __("Criado: ") ?>
                                <?= $this->Time->format(
                                    $estagiario->resposta->created,
                                    "d-MM-Y HH:mm",
                                ) ?>
                            </div>
                            <div class="col-6 text-end">
                                <?= __("Modificado: ") ?>
                                <?= $this->Time->format(
                                    $estagiario->resposta->modified,
                                    "d-MM-Y HH:mm",
                                ) ?>
                            </div>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>