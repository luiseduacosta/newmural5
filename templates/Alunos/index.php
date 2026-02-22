<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Aluno[]|\Cake\Collection\CollectionInterface $alunos
 */
?>

<?php echo $this->element("menu_mural"); ?>

<nav class="navbar navbar-expand-sm navbar-light bg-light">
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarTogglerAlunos"
        aria-controls="navbarTogglerAlunos" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <ul class="navbar-nav collapse navbar-collapse" id="navbarTogglerAlunos">
        <?php if (isset($user) && $user->categoria == "1"): ?>
            <li class="nav-item">
                <?= $this->Html->link(
                    __("Novo(a) aluno(a)"),
                    ["action" => "add"],
                    ["class" => "btn btn-primary me-1"],
                ) ?>
            </li>
            <div class="col-sm-2">
                <?= $this->Form->create(null, ['url' => ['controller' => 'Alunos', 'action' => 'buscaalunonome'], 'method' => 'post', 'class' => 'form-inline']) ?>
                <?= $this->Form->control('nome', [
                    'label' => false,
                    'placeholder' => 'Busca aluno(a) por nome',
                    'class' => 'form-control'
                ])
                ?>
            </div>
            <div class="col-sm-1 me-1">
                <?= $this->Form->button(__("Buscar nome"), [
                    'type' => 'submit',
                    'class' => 'btn btn-primary',
                ]) ?>
            </div>
            <?= $this->Form->end() ?>
            <div class="col-sm-2">
                <?= $this->Form->create(null, ['url' => ['controller' => 'Alunos', 'action' => 'buscaalunoregistro'], 'method' => 'post', 'class' => 'form-inline']) ?>
                <?= $this->Form->control('registro', [
                    'label' => false,
                    'placeholder' => 'Busca aluno(a) por DRE',
                    'class' => 'form-control'
                ]) ?>
            </div>
            <div class="col-sm-1 me-1">
                <?= $this->Form->button(__("Buscar registro"), [
                    'type' => 'submit',
                    'class' => 'btn btn-primary',
                ]) ?>
            </div>
            <?= $this->Form->end() ?>
        <?php endif; ?>
        <?php if (isset($user) && ($user->categoria == "1" || $user->categoria == "2")): ?>
            <li class="nav-item">
                <?= $this->Html->link(
                    __("Inscrição para mural"),
                    ['controller' => 'Muralinscricoes', "action" => "add"],
                    ["class" => "btn btn-primary me-1", 'aria-disabled' => 'false'],
                ) ?>
            </li>
        <?php endif; ?>
        <!--  if user.categoria == '2':-->
    </ul>
</nav>

<div class="row">
    <ul class="nav nav-tabs">
        <li class="nav-item">
            <a class="nav-link active" data-bs-toggle="tab" href="#aluno1" role="tab"
                aria-controls="Alunos dados pessoais" aria-selected="true">Alunos dados pessoais</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" data-bs-toggle="tab" href="#aluno2" role="tab" aria-controls="Alunos comunicação"
                aria-selected="false">Alunos comunicação</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" data-bs-toggle="tab" href="#aluno3" role="tab" aria-controls="Alunos endereço"
                aria-selected="false">Alunos endereço</a>
        </li>
    </ul>
</div>

<div class="row">
    <div class="tab-content">
        <div id="aluno1" class="tab-pane container active show">
            <div class="container col-lg-12 shadow p-3 mb-5 bg-white rounded">
                <h3><?= __("Alunos") ?></h3>
                <table class="table table-striped table-hover table-responsive">
                    <thead class="table-dark">
                        <tr>
                            <th><?= $this->Paginator->sort("id", "ID") ?></th>
                            <th><?= $this->Paginator->sort(
                                "registro",
                                "Registro",
                            ) ?></th>
                            <th><?= $this->Paginator->sort(
                                "nome",
                                "Nome",
                            ) ?></th>
                            <th><?= $this->Paginator->sort(
                                "nomesocial",
                                "Nome social",
                            ) ?></th>
                            <th><?= $this->Paginator->sort(
                                "nascimento",
                                "Data de nascimento",
                            ) ?></th>
                            <th><?= $this->Paginator->sort("cpf", "CPF") ?></th>
                            <th><?= $this->Paginator->sort(
                                "identidade",
                                "RG",
                            ) ?></th>
                            <th><?= $this->Paginator->sort(
                                "orgao",
                                "Orgão",
                            ) ?></th>
                            <th><?= $this->Paginator->sort(
                                "ingresso",
                                "Ingresso",
                            ) ?></th>
                            <th><?= $this->Paginator->sort(
                                "turno",
                                "Turno",
                            ) ?></th>
                            <th><?= $this->Paginator->sort(
                                "observacoes",
                                "Observações",
                            ) ?></th>
                            <?php if (
                                isset($user) &&
                                $user->categoria == "1"
                            ): ?>
                                <th><?= __("Ações") ?></th>
                            <?php endif; ?>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($alunos as $aluno): ?>
                            <tr>
                                <td><?= $aluno->id ?></td>
                                <td><?= $aluno->registro ?></td>
                                <td><?= $this->Html->link($aluno->nome, [
                                    "controller" => "Alunos",
                                    "action" => "view",
                                    $aluno->id,
                                ]) ?>
                                </td>
                                <td><?= h($aluno->nomesocial) ?></td>
                                <?php if (empty($aluno->nascimento)): ?>
                                    <td>Sem dados</td>
                                <?php else: ?>
                                    <td><?= $aluno->nascimento->i18nFormat(
                                        "dd-MM-yyyy",
                                    ) ?></td>
                                <?php endif; ?>
                                <td><?= h($aluno->cpf) ?></td>
                                <td><?= h($aluno->identidade) ?></td>
                                <td><?= h($aluno->orgao) ?></td>
                                <td><?= h($aluno->ingresso) ?></td>
                                <td><?= h($aluno->turno) ?></td>
                                <td><?= h($aluno->observacoes) ?></td>
                                <td class="d-grid">
                                    <?= $this->Html->link(__("Ver"), [
                                        "controller" => "Alunos",
                                        "action" => "view",
                                        $aluno->id,
                                    ], ["class" => "btn btn-primary btn-sm btn-block mb-1"]) ?>
                                    <?php if (
                                        isset($user) &&
                                        $user->categoria == "1"
                                    ): ?>
                                        <?= $this->Html->link(__("Editar"), [
                                            "controller" => "Alunos",
                                            "action" => "edit",
                                            $aluno->id,
                                        ], ["class" => "btn btn-primary btn-sm btn-block mb-1"]) ?>
                                        <?= $this->Form->postLink(
                                            __("Excluir"),
                                            [
                                                "controller" => "Alunos",
                                                "action" => "delete",
                                                $aluno->id,
                                            ],
                                            [
                                                "confirm" => __(
                                                    "Tem certeza que quer excluir o registro # {0}?",
                                                    $aluno->id,
                                                ),
                                                'class' => 'btn btn-danger btn-sm btn-block mb-1',
                                            ],
                                        ) ?>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="tab-content">
            <div id="aluno2" class="tab-pane container fade">
                <div class="container col-lg-12 shadow p-3 mb-5 bg-white rounded">
                    <h3><?= __("Alunos comunicação") ?></h3>
                    <table class="table table-striped table-hover table-responsive">
                        <thead class="table-dark">
                            <tr>
                                <th><?= $this->Paginator->sort(
                                    "id",
                                    "ID",
                                ) ?></th>
                                <th><?= $this->Paginator->sort(
                                    "registro",
                                    "Registro",
                                ) ?></th>
                                <th><?= $this->Paginator->sort(
                                    "nome",
                                    "Nome",
                                ) ?></th>
                                <th><?= $this->Paginator->sort(
                                    "email",
                                    "E-mail",
                                ) ?></th>
                                <th><?= $this->Paginator->sort(
                                    "codigo_telefone",
                                    "DDD",
                                ) ?></th>
                                <th><?= $this->Paginator->sort(
                                    "telefone",
                                    "Telefone",
                                ) ?></th>
                                <th><?= $this->Paginator->sort(
                                    "codigo_celular",
                                    "DDD",
                                ) ?></th>
                                <th><?= $this->Paginator->sort(
                                    "celular",
                                    "Celular",
                                ) ?></th>
                                <th><?= $this->Paginator->sort(
                                    "observacoes",
                                    "Observações",
                                ) ?></th>
                                <th><?= __("Ações") ?></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($alunos as $aluno): ?>
                                <tr>
                                    <td><?= $aluno->id ?></td>
                                    <td><?= $aluno->registro ?></td>
                                    <td><?= $this->Html->link($aluno->nome, [
                                        "controller" => "Alunos",
                                        "action" => "view",
                                        $aluno->id,
                                    ]) ?>
                                    </td>
                                    <td><?= h($aluno->email) ?></td>
                                    <td><?= $this->Number->format(
                                        $aluno->codigo_telefone,
                                    ) ?></td>
                                    <td><?= h($aluno->telefone) ?></td>
                                    <td><?= $this->Number->format(
                                        $aluno->codigo_celular,
                                    ) ?></td>
                                    <td><?= h($aluno->celular) ?></td>
                                    <td><?= h($aluno->observacoes) ?></td>
                                    <td class="d-grid">
                                        <?= $this->Html->link(__("Ver"), [
                                            "controller" => "Alunos",
                                            "action" => "view",
                                            $aluno->id,
                                        ], ["class" => "btn btn-primary btn-sm btn-block mb-1"]) ?>
                                        <?php if (
                                            isset($user) &&
                                            $user->categoria == "1"
                                        ): ?>
                                            <?= $this->Html->link(
                                                __("Editar"),
                                                [
                                                    "controller" => "Alunos",
                                                    "action" => "edit",
                                                    $aluno->id,
                                                ],
                                                ["class" => "btn btn-primary btn-sm btn-block mb-1"]
                                            ) ?>
                                            <?= $this->Form->postLink(
                                                __("Excluir"),
                                                [
                                                    "controller" => "Alunos",
                                                    "action" => "delete",
                                                    $aluno->id,
                                                ],
                                                [
                                                    "confirm" => __(
                                                        "Tem certeza que quer excluir o registro # {0}?",
                                                        $aluno->id,
                                                    ),
                                                    'class' => 'btn btn-danger btn-sm btn-block mb-1',
                                                ],
                                            ) ?>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="tab-content">
            <div id="aluno3" class="tab-pane container fade">
                <div class="container col-lg-12 shadow p-3 mb-5 bg-white rounded">
                    <h3><?= __("Alunos endereço") ?></h3>
                    <table class="table table-striped table-hover table-responsive">
                        <thead class="table-dark">
                            <tr>
                                <th><?= $this->Paginator->sort(
                                    "id",
                                    "ID",
                                ) ?></th>
                                <th><?= $this->Paginator->sort(
                                    "registro",
                                    "Registro",
                                ) ?></th>
                                <th><?= $this->Paginator->sort(
                                    "nome",
                                    "Nome",
                                ) ?></th>
                                <th><?= $this->Paginator->sort(
                                    "cep",
                                    "CEP",
                                ) ?></th>
                                <th><?= $this->Paginator->sort(
                                    "endereco",
                                    "Endereço",
                                ) ?></th>
                                <th><?= $this->Paginator->sort(
                                    "municipio",
                                    "Município",
                                ) ?></th>
                                <th><?= $this->Paginator->sort(
                                    "bairro",
                                    "Bairro",
                                ) ?></th>
                                <th><?= $this->Paginator->sort(
                                    "observacoes",
                                    "Observações",
                                ) ?></th>
                                <th><?= __("Ações") ?></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($alunos as $aluno): ?>
                                <tr>
                                    <td><?= $aluno->id ?></td>
                                    <td><?= $aluno->registro ?></td>
                                    <td><?= $this->Html->link($aluno->nome, [
                                        "controller" => "Alunos",
                                        "action" => "view",
                                        $aluno->id,
                                    ]) ?>
                                    </td>
                                    <td><?= h($aluno->cep) ?></td>
                                    <td><?= h($aluno->endereco) ?></td>
                                    <td><?= h($aluno->municipio) ?></td>
                                    <td><?= h($aluno->bairro) ?></td>
                                    <td><?= h($aluno->observacoes) ?></td>
                                    <td class="d-grid">
                                        <?= $this->Html->link(__("Ver"), [
                                            "controller" => "Alunos",
                                            "action" => "view",
                                            $aluno->id,
                                        ], ["class" => "btn btn-primary btn-sm btn-block mb-1"]) ?>
                                        <?php if (
                                            isset($user) &&
                                            $user->categoria == "1"
                                        ): ?>
                                            <?= $this->Html->link(
                                                __("Editar"),
                                                [
                                                    "controller" => "Alunos",
                                                    "action" => "edit",
                                                    $aluno->id,
                                                ],
                                                ["class" => "btn btn-primary btn-sm btn-block mb-1"]
                                            ) ?>
                                            <?= $this->Form->postLink(
                                                __("Excluir"),
                                                [
                                                    "controller" => "Alunos",
                                                    "action" => "delete",
                                                    $aluno->id,
                                                ],
                                                [
                                                    "confirm" => __(
                                                        "Tem certeza que quer excluir o registro # {0}?",
                                                        $aluno->id,
                                                    ),
                                                    'class' => 'btn btn-danger btn-sm btn-block mb-1'
                                                ],
                                            ) ?>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <?php echo $this->element("paginator") ?>

</div>