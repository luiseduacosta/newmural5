<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Muralestagio $muralestagio
 * @var \Cake\I18n\DateTime $now
 */
$hoje = new \Cake\I18n\DateTime();
$user = $this->getRequest()->getAttribute('identity');

$this->assign('title', __('Mural de Estágios'));
?>
<?php echo $this->element('menu_mural') ?>

<nav class="navbar navbar-expand-lg py-2 navbar-light bg-light" id="actions-sidebar">
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarTogglerMural"
        aria-controls="navbarTogglerMural" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <ul class="navbar-nav collapse navbar-collapse" id="navbarTogglerMural">
        <?php if (isset($user) && $user->categoria == '1'): ?>
            <li class="nav-item">
                <?= $this->Html->link(__('Novo'), ['action' => 'add'], ['class' => 'btn btn-primary me-1']) ?>
            </li>
            <li class="nav-item">
                <?= $this->Html->link(__('Editar'), ['action' => 'edit', $muralestagio->id], ['class' => 'btn btn-primary me-1']) ?>
            </li>
            <li class="nav-item">
                <?= $this->Html->link(__('Listar'), ['action' => 'index'], ['class' => 'btn btn-primary me-1']) ?>
            </li>
            <li class="nav-item">
                <?= $this->Form->postLink(__('Excluir'), ['action' => 'delete', $muralestagio->id], ['confirm' => __('Tem certeza que quer excluir o registro # {0}?', $muralestagio->id), 'class' => 'btn btn-danger me-1']) ?>
            </li>
        <?php endif; ?>
    </ul>
</nav>

<div class="row">
    <ul class="nav nav-tabs">
        <li class="nav-item">
            <a class="nav-link active" data-bs-toggle="tab" href="#instituicao" role="tab" aria-controls="Instituição"
                aria-selected="true">Instituição</a>
        </li>
        <?php if (isset($user) && $user->categoria == 1): ?>
            <li class="nav-item">
                <a class="nav-link" data-bs-toggle="tab" href="#inscricoes" role="tab" aria-controls="Estudantes inscritos"
                    aria-selected="false">Estudantes inscritos</a>
            </li>
        <?php endif; ?>
    </ul>
</div>

<div class="row">
    <div class="tab-content">
        <div id="instituicao" class="tab-pane container active show">
            <h3><?= h($muralestagio->instituicao) ?></h3>

            <table class='table table-stripper table-hover table-responsive'>
                <tr>
                    <th><?= __('Id') ?></th>
                    <td><?= $muralestagio->id ?></td>
                </tr>
                <tr>
                    <th><?= __('Instituição') ?></th>
                    <?php if (isset($user) && $user->categoria == '1' && !empty($muralestagio->instituicao_id)): ?>
                        <td><?= $this->Html->link($muralestagio->instituicao, ['controller' => 'Instituicoes', 'action' => 'view', $muralestagio->instituicao_id]) ?>
                        </td>
                    <?php else: ?>
                        <td><?= $muralestagio->has('instituicao') ? $muralestagio->instituicao : '' ?></td>
                    <?php endif; ?>
                </tr>
                <tr>
                    <th><?= __('Convênio com UFRJ') ?></th>
                    <td><?= (h($muralestagio->convenio) == 0) ? 'Não' : 'Sim' ?></td>
                </tr>
                <tr>
                    <th><?= __('Benefícios') ?></th>
                    <td><?= h($muralestagio->beneficios) ?></td>
                </tr>
                <tr>
                    <th><?= __('Final de Semana') ?></th>
                    <td><?php
                    switch ($muralestagio->final_de_semana) {
                        case 0:
                            echo "Não";
                            break;
                        case 1;
                            echo "Sim";
                            break;
                        case 2:
                            echo "Parcialmente";
                            break;
                        default;
                            echo "Não";
                            break;
                    }
                    ?>
                    </td>
                </tr>
                <tr>
                    <th><?= __('Requisitos') ?></th>
                    <td><?= $this->Text->autoParagraph($muralestagio->requisitos) ?></td>
                </tr>
                <tr>
                    <th><?= __('Turme de estágio') ?></th>
                    <td><?= $muralestagio->has('turmaestagios') ? $this->Html->link($muralestagio->turmaestagios['area'], ['controller' => 'Areaestagios', 'action' => 'view', $muralestagio->turmaestagios['id']]) : '' ?>
                    </td>
                </tr>
                <tr>
                    <th><?= __('Horário da OTP') ?></th>
                    <td><?php
                    switch ($muralestagio->horario) {
                        case 'D':
                            echo "Diurno";
                            break;
                        case 'N':
                            echo "Noturno";
                            break;
                        case 'I':
                            echo 'Indeterminado';
                            break;
                        default:
                            echo 'Indeterminado';
                            break;
                    }
                    ?></td>
                </tr>
                <tr>
                    <th><?= __('Docente') ?></th>
                    <td><?= $muralestagio->has('professores') ? $this->Html->link($muralestagio->professores['nome'], ['controller' => 'Professores', 'action' => 'view', $muralestagio->professores['id']]) : '' ?>
                    </td>
                </tr>
                <tr>
                    <th><?= __('Horario da seleção') ?></th>
                    <td><?= h($muralestagio->horarioSelecao) ?></td>
                </tr>
                <tr>
                    <th><?= __('Local da seleção') ?></th>
                    <td><?= h($muralestagio->localSelecao) ?></td>
                </tr>
                <tr>
                    <th><?= __('Forma de seleção') ?></th>
                    <td><?php
                    switch ($muralestagio->formaSelecao) {
                        case '0':
                            echo 'Entrevista';
                            break;
                        case '1':
                            echo 'CR';
                            break;
                        case '2':
                            echo 'Prova';
                            break;
                        case '3':
                            echo 'Outras';
                            break;
                        default:
                            echo 'Outras: ver nas observações';
                            break;
                    }
                    ?></td>
                </tr>
                <tr>
                    <th><?= __('Contato') ?></th>
                    <td><?= h($muralestagio->contato) ?></td>
                </tr>
                <tr>
                    <th><?= __('E-mail') ?></th>
                    <td><?= h($muralestagio->email) ?></td>
                </tr>
                <tr>
                    <th><?= __('Período') ?></th>
                    <td><?= h($muralestagio->periodo) ?></td>
                </tr>
                <tr>
                    <th><?= __('Local da inscrição') ?></th>
                    <td><?php
                    switch ($muralestagio->localInscricao) {
                        case '0':
                            echo 'Somente no mural da Coordenação de Estágio/ESS';
                            break;
                        case '1':
                            echo 'Diretamente na Instituição e no mural da Coordenação de Estágio/ESS';
                            break;
                        default:
                            echo 'Somente no mural da Coordenação de Estágio/ESS';
                            break;
                    }
                    ?></td>
                </tr>
                <tr>
                    <th><?= __('Vagas') ?></th>
                    <td><?= $muralestagio->vagas ?></td>
                </tr>
                <tr>
                    <th><?= __('Carga horária') ?></th>
                    <td><?= $this->Number->format($muralestagio->cargaHoraria, ['pattern' => '##']) ?></td>
                </tr>
                <tr>
                    <th><?= __('Data da seleção') ?></th>
                    <td><?= $muralestagio->dataSelecao ? $muralestagio->dataSelecao->i18nFormat('dd-MM-yyyy') : '' ?>
                    </td>
                </tr>
                <tr>
                    <th><?= __('Data de encerramento da inscrição') ?></th>
                    <td><?= $muralestagio->dataInscricao ? $muralestagio->dataInscricao->i18nFormat('dd-MM-yyyy') : '' ?>
                    </td>
                </tr>
                <tr>
                    <th><?= __('Data fax') ?></th>
                    <td><?= $muralestagio->datafax ? $muralestagio->datafax->i18nFormat('dd-MM-yyyy') : '' ?></td>
                </tr>
                <tr>
                    <div class="text">
                        <th><?= __('Outras informações') ?></th>
                        <td>
                            <blockquote>
                                <?= $this->Text->autoParagraph($muralestagio->outras); ?>
                            </blockquote>
                        </td>
                    </div>
                </tr>
                <!--
                    Se a inscricao é na instituição também tem que fazer inscrição no mural
                    //-->
                <?php if ($muralestagio->localInscricao === 1): ?>

                    <tr>
                        <td colspan=2>
                            <p style="text-align: center; color: red">Não esqueça de também fazer inscrição diretamente na
                                instituição. Ambas são necessárias!</p>
                        </td>
                    </tr>

                <?php endif; ?>

                <?php if (isset($user) && $user->categoria == '1'): ?>
                    <tr>
                        <td colspan='2' style="text-align: center">
                            <?= $this->Form->create(null, ['url' => ['controller' => 'Muralinscricoes', 'action' => 'add', '?' => ['muralestagio_id', $muralestagio->id]], 'type' => 'post']); ?>
                            <?= $this->Form->input('muralestagio_id', ['type' => 'hidden', 'value' => $muralestagio->id]); ?>
                            <?= $this->Form->input('registro', ['type' => 'select', 'options' => $alunos, 'empty' => 'Seleciona aluno', 'class' => 'form-control']); ?>
                            <div class='row justify-content-center'>
                                <div class='col-auto'>
                                    <?=
                                        $this->Form->submit('Inscrição', ['type' => 'submit', 'label' => ['text' => 'Inscrição', 'class' => 'col-4'], 'class' => 'btn btn-primary']);
                                    $this->Form->end();
                                    ?>
                                </div>
                            </div>
                        </td>
                    </tr>

                <?php elseif (isset($user) && $user->categoria == '2'): ?>
                    <!--
                        Para os outros usuários as inscrições dependem da data de encerramento
                        //-->
                    <?php if (empty($muralestagio->dataInscricao)): ?>
                        <?php $muralestagio->dataInscricao = $hoje->addDays(1); ?>
                    <?php endif; ?>
                    <?php if ($hoje->i18nFormat('yyyy-MM-dd') < $muralestagio->dataInscricao->i18nFormat('yyyy-MM-dd')): ?>
                        <tr>
                            <td colspan=2 style="text-align: center">

                                <?= $this->Form->create(null, ['url' => ['controller' => 'Muralinscricoes', 'action' => 'add', '?' => ['muralestagio_id', $muralestagio->id]], 'type' => 'post']); ?>
                                <?= $this->Form->input('muralestagio_id', ['type' => 'hidden', 'value' => $muralestagio->id]); ?>
                                <?= $this->Form->input('registro', ['type' => 'hidden', 'value' => $user->numero]); ?>
                                <div class='row justify-content-center'>
                                    <div class='col-auto'>
                                        <?=
                                            $this->Form->button('Fazer inscrição', ['type' => 'Confirma', 'label' => ['text' => 'Inscrição', 'class' => 'col-4'], 'class' => 'btn btn-primary']);
                                        ?>
                                        <?=
                                            $this->Form->end();
                                        ?>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    <?php else: ?>
                        <tr>
                            <td colspan=2>
                                <div class='row justify-content-center'>
                                    <p class='btn btn-danger'>Inscrições encerradas!</p>
                                </div>
                            </td>
                        </tr>
                    <?php endif; ?>

                <?php endif; ?>

            </table>
        </div>

        <div class="tab-content">
            <div id="inscricoes" class="tab-pane container fade">
                <h3><?= __('Inscrições para seleção de estágio') ?></h3>
                <?php if (!empty($muralestagio->muralinscricoes)): ?>
                    <table class="table table-responsive table-striped table-hover">
                        <tr>
                            <th><?= __('Id') ?></th>
                            <th><?= __('Registro') ?></th>
                            <th><?= __('Estudante') ?></th>
                            <th><?= __('Vaga de estágio') ?></th>
                            <th><?= __('Data') ?></th>
                            <th><?= __('Periodo') ?></th>
                            <?php if (isset($user) && $user->categoria == 1): ?>
                                <th><?= __('Timestamp') ?></th>
                                <th><?= __('Ações') ?></th>
                            <?php endif; ?>
                        </tr>
                        <?php foreach ($muralestagio->muralinscricoes as $muralinscricoes): ?>
                            <tr>
                                <?php // pr($muralinscricoes) ?>
                                <td><?= h($muralinscricoes->id) ?></td>
                                <td><?= h($muralinscricoes->registro) ?></td>
                                <td><?= (isset($user) && $user->categoria == 1) ? $this->Html->link($muralinscricoes->alunos['nome'], ['controller' => 'Alunos', 'action' => 'view', $muralinscricoes->aluno_id]) : $muralinscricoes->alunos['nome']; ?>
                                </td>
                                <td><?= $this->Html->link($muralinscricoes->muralestagios['instituicao'], ['controller' => 'muralestagios', 'action' => 'view', $muralinscricoes->muralestagio_id]) ?>
                                </td>
                                <td><?= $muralinscricoes->data->i18nFormat('dd-MM-yyyy') ?></td>
                                <td><?= h($muralinscricoes->periodo) ?></td>
                                <?php if (isset($user) && $user->categoria == 1): ?>
                                    <td><?= $muralinscricoes->timestamp->i18nFormat('dd-MM-yyyy') ?></td>
                                    <td class="d-grid">
                                        <?= $this->Html->link(__('Ver'), ['controller' => 'Muralinscricoes', 'action' => 'view', $muralinscricoes->id], ['class' => 'btn btn-primary btn-sm btn-block mb-1']) ?>
                                        <?= $this->Html->link(__('Editar'), ['controller' => 'Muralinscricoes', 'action' => 'edit', $muralinscricoes->id], ['class' => 'btn btn-primary btn-sm btn-block mb-1']) ?>
                                        <?= $this->Form->postLink(__('Excluir'), ['controller' => 'Muralinscricoes', 'action' => 'delete', $muralinscricoes->id], ['confirm' => __('Tem certeza que quer excluir o registro # {0}?', $muralinscricoes->id), 'class' => 'btn btn-danger btn-sm btn-block mb-1']) ?>
                                    </td>
                                <?php endif; ?>
                            </tr>
                        <?php endforeach; ?>
                    </table>
                <?php else: ?>
                    <p>Sem inscrições</p>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>