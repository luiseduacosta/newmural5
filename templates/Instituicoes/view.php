<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Instituicao $instituicao
 */
?>

<?php echo $this->element('menu_mural') ?>

<nav class="navbar navbar-expand-lg py-2 navbar-light bg-light" id="actions-sidebar">
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarTogglerInstituicao"
        aria-controls="navbarTogglerInstituicao" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <ul class="navbar-nav collapse navbar-collapse" id="navbarTogglerInstituicao">
        <li class="nav-item">
            <?= $this->Html->link(__('Listar'), ['action' => 'index'], ['class' => 'btn btn-primary me-1']) ?>
        </li>
        <?php if (isset($user) && $user->categoria == '1'): ?>
            <li class="nav-item">
                <?= $this->Html->link(__('Editar'), ['action' => 'edit', $instituicao->id], ['class' => 'btn btn-primary me-1']) ?>
            </li>
            <li class="nav-item">
                <?= $this->Html->link(__('Nova'), ['action' => 'add'], ['class' => 'btn btn-primary me-1']) ?>
            </li>
            <li class="nav-item">
                <?= $this->Form->postLink(__('Excluir'), ['action' => 'delete', $instituicao->id], ['confirm' => __('Tem certeza que deseja excluir este registo # {0}?', $instituicao->id), 'class' => 'btn btn-danger me-1']) ?>
            </li>
        <?php endif; ?>
    </ul>
</nav>

<div class="row">
    <ul class="nav nav-tabs">
        <li class="nav-item">
            <a class="nav-link active" data-bs-toggle="tab" href="#instituicao" role="tab" aria-controls="instituicao"
                aria-selected="true">Instituição</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" data-bs-toggle="tab" href="#supervisores" role="tab" aria-controls="supervisores"
                aria-selected="false">Supervisores</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" data-bs-toggle="tab" href="#estagiarios" role="tab" aria-controls="estagiarios"
                aria-selected="false">Estagiários</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" data-bs-toggle="tab" href="#muraldeestagio" role="tab" aria-controls="muraldeestagio"
                aria-selected="false">Mural de estágio</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" data-bs-toggle="tab" href="#visitas" role="tab" aria-controls="visitas"
                aria-selected="false">Visitas</a>
        </li>
    </ul>
</div>

<div class="row">
    <div class="tab-content">
        <div id="instituicao" class="tab-pane container active show">
            <h3><?= $instituicao->instituicao ?></h3>
            <table class="table table-responsive table-hover table-striped">
                <tr>
                    <th><?= __('Id') ?></th>
                    <td><?= $instituicao->id ?></td>
                </tr>
                <tr>
                    <th><?= __('Instituição') ?></th>
                    <td><?= $instituicao->instituicao ? h($instituicao->instituicao) : 's/d' ?></td>
                </tr>
                <tr>
                    <th><?= __('Área instituicao') ?></th>
                    <td><?= $instituicao->hasvalue('areainstituicao') ? $this->Html->link($instituicao->areainstituicao->area, ['controller' => 'Areainstituicoes', 'action' => 'view', $instituicao->areainstituicao->id]) : 's/d' ?>
                    </td>
                </tr>
                <tr>
                    <th><?= __('Natureza') ?></th>
                    <td><?= h($instituicao->natureza) ?></td>
                </tr>
                <tr>
                    <th><?= __('CNPJ') ?></th>
                    <td><?= h($instituicao->cnpj) ?></td>
                </tr>
                <tr>
                    <th><?= __('E-mail') ?></th>
                    <td><?= h($instituicao->email) ?></td>
                </tr>
                <tr>
                    <th><?= __('Endereço do site') ?></th>
                    <td><?= h($instituicao->url) ?></td>
                </tr>
                <tr>
                    <th><?= __('Telefone') ?></th>
                    <td><?= h($instituicao->telefone) ?></td>
                </tr>
                <tr>
                    <th><?= __('Fax') ?></th>
                    <td><?= h($instituicao->fax) ?></td>
                </tr>
                <tr>
                    <th><?= __('CEP') ?></th>
                    <td><?= h($instituicao->cep) ?></td>
                </tr>
                <tr>
                    <th><?= __('Endereço') ?></th>
                    <td><?= h($instituicao->endereco) ?></td>
                </tr>
                <tr>
                    <th><?= __('Bairro') ?></th>
                    <td><?= h($instituicao->bairro) ?></td>
                </tr>
                <tr>
                    <th><?= __('Município') ?></th>
                    <td><?= h($instituicao->municipio) ?></td>
                </tr>

                <tr>
                    <th><?= __('Beneficios') ?></th>
                    <td><?= h($instituicao->beneficio) ?></td>
                </tr>
                <tr>
                    <th><?= __('Fim de Semana') ?></th>
                    <td><?= ($instituicao->fim_de_semana == 0) ? 'Não' : 'Sim'; ?></td>
                </tr>
                <tr>
                    <th><?= __('Local de inscrição') ?></th>
                    <td><?= h($instituicao->localInscricao) ?></td>
                </tr>
                <tr>
                    <th><?= __('Seguro') ?></th>
                    <td><?= ($instituicao->seguro == 0) ? 'Não' : 'Sim'; ?></td>
                </tr>
                <tr>
                    <th><?= __('Avaliação') ?></th>
                    <td><?= h($instituicao->avaliacao) ?></td>
                </tr>
                <tr>
                    <th><?= __('Área') ?></th>
                    <td><?= $instituicao->area ?></td>
                </tr>
                <tr>
                    <th><?= __('Convênio') ?></th>
                    <td><?= ($instituicao->convenio == 0) ? 'Não' : 'Sim' ?></td>
                </tr>
                <tr>
                    <th><?= __('Expira') ?></th>
                    <td><?= ($instituicao->expira) ? date('d-m-Y', strtotime($instituicao->expira)) : 'Sem informação' ?>
                    </td>
                </tr>
                <tr>
                    <th><?= __('Observações') ?></th>
                    <td><?= h($instituicao->observacoes) ?></td>
                </tr>
            </table>
        </div>

        <div class="tab-content">
            <div id="supervisores" class="tab-pane container fade">
                <h3><?= __('Supervisores') ?></h3>
                <?php if (!empty($instituicao->supervisores)): ?>
                    <table class="table table-responsive table-hover table-striped">
                        <tr>
                            <th><?= __('Id') ?></th>
                            <th><?= __('Nome') ?></th>
                            <th><?= __('Cress') ?></th>
                            <th><?= __('Observações') ?></th>
                            <th><?= __('Ações') ?></th>
                        </tr>
                        <?php foreach ($instituicao->supervisores as $supervisores): ?>
                            <tr>
                                <td><?= h($supervisores->id) ?></td>
                                <td><?= (isset($user) && $user->categoria == 1) ? $this->Html->link($supervisores->nome, ['controller' => 'Supervisores', 'action' => 'view', $supervisores->id]) : $supervisores->nome ?>
                                </td>
                                <td><?= h($supervisores->cress) ?></td>
                                <td><?= h($supervisores->observacoes) ?></td>
                                <?php if (isset($user) && $user->categoria == 1): ?>
                                    <td class="d-grid">
                                        <?= $this->Html->link(__('Ver'), ['controller' => 'Supervisores', 'action' => 'view', $supervisores->id], ['class' => 'btn btn-primary btn-sm btn-block mb-1']) ?>
                                        <?php if (isset($user) && $user->categoria == '1'): ?>
                                            <?= $this->Html->link(__('Editar'), ['controller' => 'Supervisores', 'action' => 'edit', $supervisores->id], ['class' => 'btn btn-primary btn-sm btn-block mb-1']) ?>
                                            <?= $this->Form->postLink(__('Excluir'), ['controller' => 'Supervisores', 'action' => 'delete', $supervisores->id], ['confirm' => __('Tem certeza que deseja excluir este registo # {0}?', $supervisores->id), 'class' => 'btn btn-danger btn-sm btn-block mb-1']) ?>
                                        <?php endif; ?>

                                    </td>
                                <?php endif; ?>
                            </tr>
                        <?php endforeach; ?>
                    </table>
                <?php endif; ?>
            </div>
        </div>

        <div class="tab-content">
            <div id="estagiarios" class="tab-pane container fade">
                <h3><?= __('Estagiarios') ?></h3>
                <?php if (!empty($instituicao->estagiarios)): ?>
                    <table class="table table-striped table-hover table-responsive">
                        <tr>
                            <th><?= __('Id') ?></th>
                            <th><?= __('Estudante') ?></th>
                            <th><?= __('Registro') ?></th>
                            <th><?= __('Supervisor') ?></th>
                            <th><?= __('Docente') ?></th>
                            <th><?= __('Período') ?></th>
                            <th><?= __('Nível') ?></th>
                            <?php if (isset($user) && $user->categoria == '1'): ?>
                                <th><?= __('Ajuste 2020') ?></th>
                                <th><?= __('Turno') ?></th>
                                <th><?= __('Tc') ?></th>
                                <th><?= __('Tc Solicitação') ?></th>
                                <th><?= __('Instituição de estagio') ?></th>
                                <th><?= __('Área de estágio') ?></th>
                                <th><?= __('Nota') ?></th>
                                <th><?= __('CH') ?></th>
                                <th><?= __('Observações') ?></th>
                                <th><?= __('Ações') ?></th>
                            <?php endif; ?>
                        </tr>
                        <?php foreach ($instituicao->estagiarios as $estagiarios): ?>
                            <?php // pr($estagiarios->areaestagio); ?>
                            <tr>
                                <td><?= h($estagiarios->id) ?></td>
                                <?php if (isset($user) && $user->categoria == '1'): ?>
                                    <td><?= $estagiarios->hasvalue('aluno') ? $this->Html->link($estagiarios->aluno->nome, ['controller' => 'alunos', 'action' => 'view', $estagiarios->aluno_id]) : '' ?>
                                    </td>
                                <?php else: ?>
                                    <td><?= $estagiarios->hasvalue('aluno') ? $estagiarios->aluno->nome : '' ?></td>
                                <?php endif; ?>

                                <td><?= h($estagiarios->registro) ?></td>

                                <?php if (isset($user) && $user->categoria == '1'): ?>
                                    <td><?= $estagiarios->hasvalue('supervisor') ? $this->Html->link(h($estagiarios->supervisor->nome), ['controller' => 'supervisores', 'action' => 'view', $estagiarios->supervisor_id]) : '' ?>
                                    </td>
                                <?php else: ?>
                                    <td><?= $estagiarios->hasvalue('supervisor') ? $estagiarios->supervisor->nome : '' ?></td>
                                <?php endif; ?>

                                <?php if (isset($user) && $user->categoria == '1'): ?>
                                    <td><?= $estagiarios->hasvalue('professor') ? $this->Html->link($estagiarios->professor->nome, ['controller' => 'Professores', 'action' => 'view', $estagiarios->professor_id]) : '' ?>
                                    </td>
                                <?php else: ?>
                                    <td><?= $estagiarios->hasvalue('professor') ? $estagiarios->professor->nome : '' ?></td>
                                <?php endif; ?>

                                <td><?= h($estagiarios->periodo) ?></td>
                                <td><?= h($estagiarios->nivel) ?></td>

                                <?php if (isset($user) && $user->categoria == '1'): ?>
                                    <td><?= h($estagiarios->ajuste2020) ?></td>
                                    <td><?= h($estagiarios->turno) ?></td>
                                    <td><?= h($estagiarios->tc) ?></td>
                                    <td><?= $estagiarios->tc_solicitacao ? date('d-m-Y', strtotime(h($estagiarios->tc_solicitacao))) : '' ?>
                                    </td>
                                    <td><?= $estagiarios->has('areaestagio') ? $estagiarios->areaestagio->area : '' ?></td>
                                    <td><?= $this->Number->format($estagiarios->nota, ['places' => 2]) ?></td>
                                    <td><?= h($estagiarios->ch) ?></td>
                                    <td><?= h($estagiarios->observacoes) ?></td>
                                    <td class="d-grid">
                                        <?= $this->Html->link(__('Ver'), ['controller' => 'Estagiarios', 'action' => 'view', $estagiarios->id], ['class' => 'btn btn-primary btn-sm btn-block mb-1']) ?>
                                        <?= $this->Html->link(__('Editar'), ['controller' => 'Estagiarios', 'action' => 'edit', $estagiarios->id], ['class' => 'btn btn-primary btn-sm btn-block mb-1']) ?>
                                        <?= $this->Form->postLink(__('Excluir'), ['controller' => 'Estagiarios', 'action' => 'delete', $estagiarios->id], ['confirm' => __('Tem certeza que deseja excluir este registo # {0}?', $estagiarios->id), 'class' => 'btn btn-danger btn-sm btn-block mb-1']) ?>
                                    </td>
                                <?php endif; ?>
                            </tr>
                        <?php endforeach; ?>
                    </table>
                <?php endif; ?>
            </div>
        </div>

        <div class="tab-content">
            <div id="muraldeestagio" class="tab-pane container fade">
                <h3><?= __('Ofertas de vagas no Mural de estágios') ?></h3>
                <?php if (!empty($instituicao->muralestagios)): ?>
                    <table class="table table-responsive table-hover table-striped">
                        <tr>
                            <th><?= __('Id') ?></th>
                            <th><?= __('Instituicao') ?></th>
                            <th><?= __('Vagas') ?></th>
                            <th><?= __('Periodo') ?></th>
                            <?php if (isset($user) && $user->categoria == '1'): ?>
                                <th><?= __('Ações') ?></th>
                            <?php endif; ?>
                        </tr>
                        <?php foreach ($instituicao->muralestagios as $muralestagios): ?>
                            <tr>
                                <td><?= h($muralestagios->id) ?></td>
                                <td><?= $this->Html->link($muralestagios->instituicao, ['controller' => 'muralestagios', 'action' => 'view', $muralestagios->id]) ?>
                                </td>
                                <td><?= h($muralestagios->vagas) ?></td>
                                <td><?= h($muralestagios->periodo) ?></td>
                                <?php if (isset($user) && $user->categoria == '1'): ?>
                                    <td class="d-grid">
                                        <?= $this->Html->link(__('Ver'), ['controller' => 'Muralestagios', 'action' => 'view', $muralestagios->id], ['class' => 'btn btn-primary btn-sm btn-block mb-1']) ?>
                                        <?= $this->Html->link(__('Editar'), ['controller' => 'Muralestagios', 'action' => 'edit', $muralestagios->id], ['class' => 'btn btn-primary btn-sm btn-block mb-1']) ?>
                                        <?= $this->Form->postLink(__('Excluir'), ['controller' => 'Muralestagios', 'action' => 'delete', $muralestagios->id], ['confirm' => __('Tem certeza que deseja excluir este registo # {0}?', $muralestagios->id), 'class' => 'btn btn-danger btn-sm btn-block mb-1']) ?>
                                    </td>
                                <?php endif; ?>
                            </tr>
                        <?php endforeach; ?>
                    </table>
                <?php endif; ?>
            </div>
        </div>

        <div class="tab-content">
            <div id="visitas" class="tab-pane container fade">
                <h3><?= __('Visitas realizadas') ?></h3>
                <?php if (!empty($instituicao->visitas)): ?>
                    <table class="table table-responsive table-hover table-striped">
                        <tr>
                            <th><?= __('Id') ?></th>
                            <th><?= __('Instituição') ?></th>
                            <th><?= __('Data') ?></th>
                            <th><?= __('Motivo') ?></th>
                            <th><?= __('Responsável') ?></th>
                            <th><?= __('Descrição') ?></th>
                            <th><?= __('Avaliação') ?></th>
                            <?php if (isset($user) && $user->categoria == '1'): ?>
                                <th><?= __('Ações') ?></th>
                            <?php endif; ?>
                        </tr>
                        <?php foreach ($instituicao->visitas as $visitas): ?>
                            <tr>
                                <td><?= h($visitas->id) ?></td>
                                <td><?= h($visitas->estagio_id) ?></td>
                                <td><?= date('d-m-Y', strtotime($visitas->data)) ?></td>
                                <td><?= h($visitas->motivo) ?></td>
                                <td><?= h($visitas->responsavel) ?></td>
                                <td><?= h($visitas->descricao) ?></td>
                                <td><?= h($visitas->avaliacao) ?></td>
                                <?php if (isset($user) && $user->categoria == '1'): ?>
                                    <td class="d-grid">
                                        <?= $this->Html->link(__('Ver'), ['controller' => 'Visitas', 'action' => 'view', $visitas->id], ['class' => 'btn btn-primary btn-sm btn-block mb-1']) ?>
                                        <?= $this->Html->link(__('Editar'), ['controller' => 'Visitas', 'action' => 'edit', $visitas->id], ['class' => 'btn btn-primary btn-sm btn-block mb-1']) ?>
                                        <?= $this->Form->postLink(__('Excluir'), ['controller' => 'Visitas', 'action' => 'delete', $visitas->id], ['confirm' => __('Tem certeza que deseja excluir este registo # {0}?', $visitas->id), 'class' => 'btn btn-danger btn-sm btn-block mb-1']) ?>
                                    </td>
                                <?php endif; ?>
                            </tr>
                        <?php endforeach; ?>
                    </table>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>