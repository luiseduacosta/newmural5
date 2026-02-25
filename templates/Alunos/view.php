<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Aluno $aluno
 */
?>

<?php echo $this->element('menu_mural') ?>

<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
        aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
            <?php if (isset($user) && $user->categoria == '1'): ?>
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
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
                        <?= $this->Html->link(__('Adicionar estágio'), ['controller' => 'Estagiarios', 'action' => 'add', '?' => ['aluno_id' => $aluno->id]], ['class' => 'btn btn-primary me-1']) ?>
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
                </ul>
            <?php endif ?>
            <?php if (isset($user) && $user->categoria == '2'): ?>
                <?php if ($user->aluno_id == $aluno->id): ?>
                    <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                        <li class="nav-item">
                            <?= $this->Html->link(__('Editar Aluno'), ['controller' => 'Alunos', 'action' => 'edit', $aluno->id], ['class' => 'btn btn-primary me-1']) ?>
                        </li>
                        <li class="nav-item">
                            <?= $this->Html->link(__('Declaração de período'), ['controller' => 'Alunos', 'action' => 'certificadoperiodo', $aluno->id], ['class' => 'btn btn-primary me-1']) ?>
                        </li>
                        <li class="nav-item">
                            <?= $this->Html->link(__('Termo de compromisso'), ['controller' => 'Estagiarios', 'action' => 'novotermocompromisso', '?' => ['aluno_id' => $aluno->id]], ['class' => 'btn btn-primary me-1']) ?>
                        </li>
                    </ul>
                <?php endif; ?>
            <?php endif ?>
    </div>
</nav>

<div class="container col-lg-12 shadow p-3 mb-5 bg-white rounded">

    <div class="row">
        <ul class="nav nav-tabs">
            <li class="nav-item">
                <a class="nav-link active" data-bs-toggle="tab" href="#aluno" role="tab" aria-controls="aluno"
                    aria-selected="true">Aluno</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" data-bs-toggle="tab" href="#inscricoes" role="tab" aria-controls="inscricoes"
                    aria-selected="false">Inscrições para seleção</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" data-bs-toggle="tab" href="#estagios" role="tab" aria-controls="estagios"
                    aria-selected="false">Estágios</a>
            </li>
        </ul>
    </div>

    <div class="row">

        <div class="tab-content">
            <div id="aluno" class="tab-pane container active show">
                <h3><?= h($aluno->nome) ?></h3>
                <table class="table table-hover table-responsive table-striped">
                    <tr>
                        <th><?= __('Id') ?></th>
                        <td><?= $aluno->id ?></td>
                    </tr>
                    <tr>
                        <th><?= __('Registro') ?></th>
                        <td><?= $aluno->registro ?></td>
                    </tr>
                    <tr>
                        <th><?= __('Nome') ?></th>
                        <td><?= h($aluno->nome) ?></td>
                    </tr>
                    <tr>
                        <th><?= __('Nome social') ?></th>
                        <td><?= h($aluno->nomesocial) ?></td>
                    </tr>
                    <tr>
                        <th><?= __('Ingresso') ?></th>
                        <td><?= h($aluno->ingresso) ?></td>
                    </tr>
                    <tr>
                        <th><?= __('Turno') ?></th>
                        <td><?= h($aluno->turno) ?></td>
                    </tr>
                    <?php if (isset($user) && ($user->categoria == '1' || ($user->categoria == '2' && $aluno->id == $user->aluno_id))): ?>
                        <tr>
                            <th><?= __('Data de nascimento') ?></th>
                            <td><?= $aluno->nascimento ? $aluno->nascimento->i18nFormat('dd-MM-yyyy') : '' ?></td>
                        </tr>
                        <tr>
                            <th><?= __('CPF') ?></th>
                            <td><?= h($aluno->cpf) ?></td>
                        </tr>
                        <tr>
                            <th><?= __('RG') ?></th>
                            <td><?= h($aluno->identidade) ?></td>
                        </tr>
                        <tr>
                            <th><?= __('Orgão') ?></th>
                            <td><?= h($aluno->orgao) ?></td>
                        </tr>
                        <tr>
                            <th><?= __('E-mail') ?></th>
                            <td><?= h($aluno->email) ?></td>
                        </tr>
                        <tr>
                            <th><?= __('DDD') ?></th>
                            <td><?= $this->Number->format($aluno->codigo_telefone) ?></td>
                        </tr>
                        <tr>
                            <th><?= __('Telefone') ?></th>
                            <td><?= h($aluno->telefone) ?></td>
                        </tr>
                        <tr>
                            <th><?= __('DDD') ?></th>
                            <td><?= $this->Number->format($aluno->codigo_celular) ?></td>
                        </tr>
                        <tr>
                            <th><?= __('Celular') ?></th>
                            <td><?= h($aluno->celular) ?></td>
                        </tr>
                        <tr>
                            <th><?= __('CEP') ?></th>
                            <td><?= h($aluno->cep) ?></td>
                        </tr>
                        <tr>
                            <th><?= __('Endereço') ?></th>
                            <td><?= h($aluno->endereco) ?></td>
                        </tr>
                        <tr>
                            <th><?= __('Município') ?></th>
                            <td><?= h($aluno->municipio) ?></td>
                        </tr>
                        <tr>
                            <th><?= __('Bairro') ?></th>
                            <td><?= h($aluno->bairro) ?></td>
                        </tr>
                        <tr>
                            <th><?= __('Observações') ?></th>
                            <td><?= h($aluno->observacoes) ?></td>
                        </tr>
                    <?php endif ?>
                </table>
            </div>
        </div>

        <div class="tab-content">
            <div id="inscricoes" class="tab-pane container fade">
                <h4><?= __('Inscrições para seleção de estágio') ?></h4>
                <?php if (!empty($aluno->muralinscricoes)): ?>
                    <table class="table table-hover table-responsive table-striped">
                        <thead class="table-dark">
                            <tr>
                                <th><?= __('Id') ?></th>
                                <th><?= __('Registro') ?></th>
                                <th><?= __('Instituição') ?></th>
                                <th><?= __('Data') ?></th>
                                <th><?= __('Período') ?></th>
                                <th><?= __('Timestamp') ?></th>
                                <th><?= __('Ações') ?></th>
                            </tr>
                        </thead>
                        <?php foreach ($aluno->muralinscricoes as $muralinscricoes): ?>
                            <tr>
                                <td><?= h($muralinscricoes->id) ?></td>
                                <td><?= h($muralinscricoes->registro) ?></td>
                                <td><?= $muralinscricoes->has('muralestagios') ? $this->Html->link($muralinscricoes->muralestagios['instituicao'], ['controller' => 'Muralestagios', 'action' => 'view', $muralinscricoes->muralestagios['id']]) : '' ?>
                                </td>
                                <td><?= $muralinscricoes->data->i18nFormat('dd-MM-yyyy') ?></td>
                                <td><?= h($muralinscricoes->periodo) ?></td>
                                <td><?= $muralinscricoes->timestamp->i18nFormat('dd-MM-yyyy') ?></td>
                                <td class="d-grid">
                                    <?= $this->Html->link(__('Ver'), ['controller' => 'Muralinscricoes', 'action' => 'view', $muralinscricoes->id], ['class' => 'btn btn-primary btn-sm btn-block mb-1']) ?>
                                    <?php if (isset($user->categoria) && $user->categoria == '1'): ?>
                                        <?= $this->Html->link(__('Editar'), ['controller' => 'Muralinscricoes', 'action' => 'edit', $muralinscricoes->id], ['class' => 'btn btn-primary btn-sm btn-block mb-1']) ?>
                                        <?= $this->Form->postLink(__('Excluir'), ['controller' => 'Muralinscricoes', 'action' => 'delete', $muralinscricoes->id], ['confirm' => __('Tem certeza que quer excluir o registro # {0}?', $muralinscricoes->id), 'class' => 'btn btn-danger btn-sm btn-block mb-1']) ?>
                                    <?php endif ?>
                                </td>

                            </tr>
                        <?php endforeach; ?>
                    </table>
                <?php endif; ?>
            </div>
        </div>

        <div class="tab-content">
            <div id="estagios" class="tab-pane container fade">
                <h4><?= __('Estágios cursados') ?></h4>
                <?php if (!empty($aluno->estagiarios)): ?>
                    <table class="table table-hover table-responsive table-striped">
                        <thead class="table-dark">
                            <tr>
                                <th><?= __('Id') ?></th>
                                <th><?= __('Aluno') ?></th>
                                <th><?= __('Estagiario') ?></th>
                                <th><?= __('Ajuste 2020') ?></th>
                                <th><?= __('Turno') ?></th>
                                <th><?= __('Nível') ?></th>
                                <th><?= __('Período') ?></th>
                                <th><?= __('Tc') ?></th>
                                <th><?= __('Tc Solicitação') ?></th>
                                <th><?= __('Instituição de estágio') ?></th>
                                <th><?= __('Supervisor') ?></th>
                                <th><?= __('Docente') ?></th>
                                <th><?= __('Turma de estágio') ?></th>
                                <?php if (isset($user) && $user->categoria == '1'): ?>
                                    <th><?= __('Nota') ?></th>
                                    <th><?= __('CH') ?></th>
                                    <th><?= __('Observações') ?></th>
                                    <th><?= __('Ações') ?></th>
                                <?php endif ?>
                            </tr>
                        </thead>
                        <?php foreach ($aluno->estagiarios as $estagiarios): ?>
                            <tr>
                                <?php // pr($estagiarios); ?>
                                <td><?= h($estagiarios->id) ?></td>
                                <td><?= $this->Html->link($estagiarios->aluno->nome, ['controller' => 'Estagiarios', 'action' => 'view', $estagiarios->id]) ?>
                                </td>
                                <td><?= h($estagiarios->registro) ?></td>
                                <td><?= h($estagiarios->ajuste2020) ?></td>
                                <td><?= h($estagiarios->turno) ?></td>
                                <td><?= h($estagiarios->nivel) ?></td>
                                <td><?= h($estagiarios->periodo) ?></td>
                                <td><?= h($estagiarios->tc) ?></td>
                                <td><?= $estagiarios->tc_solicitacao ? $estagiarios->tc_solicitacao->i18nFormat('dd-MM-yyyy') : '' ?>
                                </td>
                                <td><?= $estagiarios->hasvalue ('instituicao') ? $this->Html->link($estagiarios->instituicao->instituicao, ['controller' => 'Instituicoes', 'action' => 'view', $estagiarios->instituicao_id]) : '' ?>
                                </td>
                                <td><?= $estagiarios->hasvalue ('supervisor') ? $this->Html->link($estagiarios->supervisor->nome, ['controller' => 'Supervisores', 'action' => 'view', $estagiarios->supervisor_id]) : '' ?>
                                </td>
                                <td><?= $estagiarios->hasvalue ('professor') ? $this->Html->link($estagiarios->professor->nome, ['controller' => 'Professores', 'action' => 'view', $estagiarios->professor_id]) : '' ?>
                                </td>
                                <td><?= $estagiarios->hasvalue ('turmaestagio') ? $this->Html->link($estagiarios->turmaestagio->area, ['controller' => 'Turmaestagios', 'action' => 'view', $estagiarios->turmaestagio_id]) : '' ?>
                                </td>
                                <?php if (isset($user->categoria) && $user->categoria == '1'): ?>
                                    <td><?= h($estagiarios->nota) ?></td>
                                    <td><?= h($estagiarios->ch) ?></td>
                                    <td><?= h($estagiarios->observacoes) ?></td>
                                    <td class="d-grid">
                                        <?= $this->Html->link(__('Ver'), ['controller' => 'Estagiarios', 'action' => 'view', $estagiarios->id], ['class' => 'btn btn-primary btn-sm w-auto mb-1']) ?>
                                        <?php if (isset($user->categoria) && $user->categoria == '1'): ?>
                                            <?= $this->Html->link(__('Editar'), ['controller' => 'Estagiarios', 'action' => 'edit', $estagiarios->id], ['class' => 'btn btn-primary btn-sm btn-block mb-1']) ?>
                                            <?= $this->Form->postLink(__('Excluir'), ['controller' => 'Estagiarios', 'action' => 'delete', $estagiarios->id], ['confirm' => __('Tem certeza que quer excluir o registro # {0}?', $estagiarios->id), 'class' => 'btn btn-danger btn-sm btn-block mb-1']) ?>
                                        <?php endif ?>
                                    </td>
                                <?php endif ?>
                            </tr>
                        <?php endforeach; ?>
                    </table>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>