<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Professor $professor
 */
use Cake\I18n\Date;
 
// $user = $this->getRequest()->getAttribute('identity');
?>

<?php echo $this->element('menu_mural') ?>

<div class="d-flex justify-content-start">
    <nav class="navbar navbar-expand-lg py-2 navbar-light bg-light">
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarTogglerProfessor"
            aria-controls="navbarTogglerProfessor" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarTogglerProfessor">
            <ul class="navbar-nav ms-auto mt-lg-0">
                <?php if (isset($user) && $user->categoria == '1'): ?>
                    <li class="nav-item">
                        <?= $this->Html->link(__('Editar Professor(a)'), ['action' => 'edit', $professor->id], ['class' => 'btn btn-primary me-1']) ?>
                    </li>
                    <li class="nav-item">
                        <?= $this->Form->postLink(__('Excluir Professor(a)'), ['action' => 'delete', $professor->id], ['confirm' => __('Tem certeza que deseja excluir este registo # {0}?', $professor->id), 'class' => 'btn btn-danger me-1']) ?>
                    </li>
                    <li class="nav-item">
                        <?= $this->Html->link(__('Listar Professore(a)s'), ['action' => 'index'], ['class' => 'btn btn-primary me-1']) ?>
                    </li>
                    <li class="nav-item">
                        <?= $this->Html->link(__('Novo(a) Professor(a)'), ['action' => 'add'], ['class' => 'btn btn-primary me-1']) ?>
                    </li>
                <?php endif; ?>

                <?php if (isset($user) && $user->categoria == '3'): ?>
                    <li class="nav-item">
                        <?= $this->Html->link(__('Editar Professor'), ['action' => 'edit', $professor->id], ['class' => 'btn btn-primary me-1']) ?>
                    </li>
                <?php endif; ?>
            </ul>
        </div>
    </nav>
</div>

<div class="row">
    <ul class="nav nav-tabs">
        <li class="nav-item">
            <a class="nav-link active" data-bs-toggle="tab" href="#professor" role="tab" aria-controls="professor"
                aria-selected="true">Professor(a)</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" data-bs-toggle="tab" href="#estagiarios" role="tab" aria-controls="estagiarios"
                aria-selected="false">Estagiários</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" data-bs-toggle="tab" href="#notas" role="tab" aria-controls="estagiarios"
                aria-selected="false">Atividades de estágio</a>
        </li>
    </ul>
</div>

<div class="tab-content">

    <div id="professor" class="tab-pane container active show">

        <h3><?= h($professor->nome) ?></h3>

        <h4><?= __('Dados pessoais do(a) Professor(a)') ?></h4>

        <dl class="row">
            <dt class="col-sm-3"><?= __('Id') ?></dt>
            <dd class="col-sm-9"><?= $professor->id ?></dd>

            <dt class="col-sm-3"><?= __('Nome') ?></dt>
            <dd class="col-sm-9"><?= h($professor->nome) ?></dd>

            <dt class="col-sm-3"><?= __('CPF') ?></dt>
            <dd class="col-sm-9"><?= h($professor->cpf) ?></dd>

            <dt class="col-sm-3"><?= __('Local nascimento') ?></dt>
            <dd class="col-sm-9"><?= h($professor->localnascimento) ?></dd>

            <dt class="col-sm-3"><?= __('Sexo') ?></dt>
            <dd class="col-sm-9">
                <?php
                switch ($professor->sexo) {
                    case '0':
                        echo 'Feminino';
                        break;
                    case '1':
                        echo 'Masculino';
                        break;
                    case '2':
                        echo 'Não informado';
                        break;
                    }
                ?>
            </dd>
            <dt class="col-sm-3"><?= __('Data nascimento') ?></dt>
            <dd class="col-sm-9">
                <?= $professor->datanascimento ? $professor->datanascimento->i18nFormat('dd-MM-yyyy') : 's/d' ?>
            </dd>
        </dl>

        <h4><?= __('Dados funcionais do(a) Professor(a)') ?></h4>

        <dl class="row">
            <dt class="col-sm-3"><?= __('Siape') ?></dt>
            <dd class="col-sm-9"><?= $professor->siape ?></dd>

            <dt class="col-sm-3"><?= __('Forma de ingresso') ?></dt>
            <dd class="col-sm-9"><?= h($professor->formaingresso) ?></dd>

            <dt class="col-sm-3"><?= __('Data de ingresso') ?></dt>
            <dd class="col-sm-9">
                <?= $professor->dataingresso ? $professor->dataingresso->i18nFormat('dd-MM-yyyy') : ' ' ?>
            </dd>

            <dt class="col-sm-3"><?= __('Tipo de cargo') ?></dt>
            <dd class="col-sm-9"><?= h($professor->tipocargo) ?></dd>

            <dt class="col-sm-3"><?= __('Categoria') ?></dt>
            <dd class="col-sm-9"><?= h($professor->categoria) ?></dd>

            <dt class="col-sm-3"><?= __('Regime de trabalho') ?></dt>
            <dd class="col-sm-9"><?= h($professor->regimetrabalho) ?></dd>

            <dt class="col-sm-3"><?= __('Departamento') ?></dt>
            <dd class="col-sm-9"><?= h($professor->departamento) ?></dd>

            <dt class="col-sm-3"><?= __('Data de egresso') ?></dt>
            <dd class="col-sm-9">
                <?= $professor->dataegresso ? $professor->dataegresso->i18nFormat('dd-MM-yyyy') : ' ' ?>
            </dd>

            <dt class="col-sm-3"><?= __('Motivo egresso') ?></dt>
            <dd class="col-sm-9"><?= h($professor->motivoegresso) ?></dd>
        </dl>

        <h4><?= __('Dados de contato do(a) Professor(a)') ?></h4>

        <dl class="row">
            <dt class="col-sm-3"><?= __('Ddd Telefone') ?></dt>
            <dd class="col-sm-9"><?= h($professor->ddd_telefone) ?></dd>

            <dt class="col-sm-3"><?= __('Telefone') ?></dt>
            <dd class="col-sm-9"><?= h($professor->telefone) ?></dd>

            <dt class="col-sm-3"><?= __('Ddd Celular') ?></dt>
            <dd class="col-sm-9"><?= h($professor->ddd_celular) ?></dd>

            <dt class="col-sm-3"><?= __('Celular') ?></dt>
            <dd class="col-sm-9"><?= h($professor->celular) ?></dd>

            <dt class="col-sm-3"><?= __('E-mail') ?></dt>
            <dd class="col-sm-9"><?= h($professor->email) ?></dd>

            <dt class="col-sm-3"><?= __('Home page') ?></dt>
            <dd class="col-sm-9"><?= h($professor->homepage) ?></dd>

            <dt class="col-sm-3"><?= __('Rede social') ?></dt>
            <dd class="col-sm-9"><?= h($professor->redesocial) ?></dd>
        </dl>

        <h4><?= __('Endereço do(a) Professor(a)') ?></h4>

        <dl class="row">
            <dt class="col-sm-3"><?= __('Endereço') ?></dt>
            <dd class="col-sm-9"><?= h($professor->endereco) ?></dd>

            <dt class="col-sm-3"><?= __('Bairro') ?></dt>
            <dd class="col-sm-9"><?= h($professor->bairro) ?></dd>

            <dt class="col-sm-3"><?= __('CEP') ?></dt>
            <dd class="col-sm-9"><?= h($professor->cep) ?></dd>

            <dt class="col-sm-3"><?= __('Cidade') ?></dt>
            <dd class="col-sm-9"><?= h($professor->cidade) ?></dd>

            <dt class="col-sm-3"><?= __('Estado') ?></dt>
            <dd class="col-sm-9"><?= h($professor->estado) ?></dd>

            <dt class="col-sm-3"><?= __('País') ?></dt>
            <dd class="col-sm-9"><?= h($professor->pais) ?></dd>
        </dl>

        <h4><?= __('Dados acadêmicos do(a) Professor(a)') ?></h4>

        <dl class="row">
            <dt class="col-sm-3"><?= __('Curriculo lattes') ?></dt>
            <dd class="col-sm-9"><?= $professor->curriculolattes ? $this->Html->link($professor->curriculolattes, 'https://lattes.cnpq.br/'. $professor->curriculolattes, ['target' => '_blank', 'full' => true]) : '' ?></dd>

            <dt class="col-sm-3"><?= __('Atualização lattes') ?></dt>
            <dd class="col-sm-9">
                <?= $professor->atualizacaolattes ? $professor->atualizacaolattes->i18nFormat('dd-MM-yyyy') : ' ' ?>
            </dd>

            <dt class="col-sm-3"><?= __('Curriculo sigma') ?></dt>
            <dd class="col-sm-9"><?= h($professor->curriculosigma) ?></dd>

            <dt class="col-sm-3"><?= __('Pesquisador dgp') ?></dt>
            <dd class="col-sm-9"><?= h($professor->pesquisadordgp) ?></dd>
        </dl>

        <h4><?= __('Dados da formação do(a) Professor(a)') ?></h4>

        <dl class="row">
            <dt class="col-sm-3"><?= __('Formacao profissional') ?></dt>
            <dd class="col-sm-9"><?= h($professor->formacaoprofissional) ?></dd>

            <dt class="col-sm-3"><?= __('Universidade de graduacao') ?></dt>
            <dd class="col-sm-9"><?= h($professor->universidadedegraduacao) ?></dd>

            <dt class="col-sm-3"><?= __('Ano formação') ?></dt>
            <dd class="col-sm-9"><?= $professor->anoformacao ?></dd>
        </dl>

        <h4><?= __('Dados de posgraduação do(a) Professor(a)') ?></h4>

        <dl class="row">
            <dt class="col-sm-3"><?= __('Mestrado area') ?></dt>
            <dd class="col-sm-9"><?= h($professor->mestradoarea) ?></dd>

            <dt class="col-sm-3"><?= __('Mestrado universidade') ?></dt>
            <dd class="col-sm-9"><?= h($professor->mestradouniversidade) ?></dd>

            <dt class="col-sm-3"><?= __('Mestrado ano conclusão') ?></dt>
            <dd class="col-sm-9"><?= $professor->mestradoanoconclusao ?></dd>

            <dt class="col-sm-3"><?= __('Doutorado area') ?></dt>
            <dd class="col-sm-9"><?= h($professor->doutoradoarea) ?></dd>

            <dt class="col-sm-3"><?= __('Doutorado universidade') ?></dt>
            <dd class="col-sm-9"><?= h($professor->doutoradouniversidade) ?></dd>

            <dt class="col-sm-3"><?= __('Doutorado ano conclusão') ?></dt>
            <dd class="col-sm-9"><?= $professor->doutoradoanoconclusao ?></dd>
        </dl>

        <h4><?= __('Outras informações do(a) Professor(a)') ?></h4>

        <dl class="row">
            <dt class="col-sm-3"><?= __('Observações') ?></dt>
            <dd class="col-sm-9"><?= $this->Text->autoParagraph(h($professor->observacoes)); ?>
            </dd>
        </dl>

    </div>

    <div id="estagiarios" class="tab-pane container fade">
        <h4><?= __('Estagiarios') ?></h4>
        <?php if (!empty($professor->estagiarios)): ?>
            <table class="table table-striped table-hover table-responsive">
                <tr>
                    <?php if (isset($user) && $user->categoria == '1'): ?>
                        <th><?= __('Id') ?></th>
                    <?php endif; ?>
                    <th><?= __('Aluno') ?></th>
                    <th><?= __('Registro') ?></th>
                    <th><?= __('Ajuste 2020') ?></th>
                    <th><?= __('Turno') ?></th>
                    <th><?= __('Nivel') ?></th>
                    <th><?= __('Instituição') ?></th>
                    <th><?= __('Supervisora') ?></th>
                    <th><?= __('Periodo') ?></th>
                    <?php if (isset($user) && $user->categoria == '1'): ?>
                        <th><?= __('Nota') ?></th>
                        <th><?= __('CH') ?></th>
                        <th><?= __('Observações') ?></th>
                        <th><?= __('Ações') ?></th>
                    <?php endif; ?>
                </tr>
                <?php foreach ($professor->estagiarios as $estagiarios): ?>
                    <?php // pr($estagiarios->aluno) ?>
                    <tr>
                        <?php if (isset($user) && $user->categoria == '1'): ?>
                            <td><?= h($estagiarios->id) ?></td>
                        <?php endif; ?>
                        <td><?= $estagiarios->hasValue('aluno') ? $estagiarios->aluno->nome : "" ?>
                        </td>
                        <td><?= h($estagiarios->registro) ?></td>
                        <td><?= h($estagiarios->ajuste2020) ?></td>
                        <td><?= h($estagiarios->turno) ?></td>
                        <td><?= h($estagiarios->nivel) ?></td>
                        <td><?= $estagiarios->hasValue('instituicao') ? $estagiarios->instituicao->instituicao : ' ' ?>
                        </td>
                        <td><?= $estagiarios->hasValue('supervisor') ? $estagiarios->supervisor->nome : ' ' ?>
                        </td>
                        <td><?= h($estagiarios->periodo) ?></td>
                        <?php if (isset($user) && $user->categoria == '1'): ?>
                            <td><?= h($estagiarios->nota) ?></td>
                            <td><?= h($estagiarios->ch) ?></td>
                            <td><?= h($estagiarios->observacoes) ?></td>
                            <td>
                                <?= $this->Html->link(__('Ver'), ['controller' => 'Estagiarios', 'action' => 'view', $estagiarios->id]) ?>
                                <?= $this->Html->link(__('Editar'), ['controller' => 'Estagiarios', 'action' => 'edit', $estagiarios->id]) ?>
                                <?= $this->Form->postLink(__('Excluir'), ['controller' => 'Estagiarios', 'action' => 'delete', $estagiarios->id], ['confirm' => __('Tem certeza que quer excluir o registro # {0}?', $estagiarios->id)]) ?>
                            </td>
                        <?php endif; ?>
                    </tr>
                <?php endforeach; ?>
            </table>
        <?php endif; ?>
    </div>

    <div id="notas" class="tab-pane container fade">
        <h4><?= __('Atividades') ?></h4>
        <?php if (!empty($professor->estagiarios)): ?>
            <table class="table table-striped table-hover table-responsive">
                <tr>
                    <?php if (isset($user) && $user->categoria == '1'): ?>
                        <th><?= __('Id') ?></th>
                    <?php endif; ?>
                    <th><?= __('Aluno') ?></th>
                    <th><?= __('Registro') ?></th>
                    <th><?= __('Atividades') ?></th>
                    <th><?= __('Avaliação estágio') ?></th>
                    <th><?= __('Turno') ?></th>
                    <th><?= __('Nivel') ?></th>
                    <th><?= __('Instituição') ?></th>
                    <th><?= __('Supervisora') ?></th>
                    <th><?= __('Periodo') ?></th>
                    <?php if (isset($user) && $user->categoria == '1'): ?>
                        <th><?= __('Nota') ?></th>
                        <th><?= __('CH') ?></th>
                        <th><?= __('Observações') ?></th>
                        <th><?= __('Ações') ?></th>
                    <?php endif; ?>
                </tr>
                <?php foreach ($professor->estagiarios as $estagiarios): ?>
                    <?php // pr($estagiarios->folhadeatividade) ?>
                    <tr>
                        <?php if (isset($user) && $user->categoria == '1'): ?>
                            <td><?= h($estagiarios->id) ?></td>
                        <?php endif; ?>
                        <td><?= $estagiarios->hasValue('aluno') ? $estagiarios->aluno->nome : "" ?>
                        </td>
                        <td><?= h($estagiarios->registro) ?></td>
                        <?php if (isset($user) && $user->categoria == '1'): ?>
                            <td><?= $estagiarios->hasValue('folhadeatividade') ? $this->Html->link('Atividades de estágio', ['controller' => 'folhadeatividades', 'action' => 'index', $estagiarios->id]) : $this->Html->link('Cadastrar atividades de estágio', ['controller' => 'folhadeatividades', 'action' => 'add', '?' => ['estagiario_id' => $estagiarios->id]]) ?>
                            </td>
                        <?php else: ?>
                            <td><?= $estagiarios->hasValue('folhadeatividade') ? $this->Html->link('Atividades de estágio', ['controller' => 'folhadeatividades', 'action' => 'index', $estagiarios->id]) : "Sem atividades cadastradas" ?>
                            </td>
                        <?php endif; ?>
                        <td><?= $estagiarios->hasValue('avaliacao') ? $this->Html->link('Avaliacao de estágio', ['controller' => 'avaliacoes', 'action' => 'view', '?' => ['estagiario_id' => $estagiarios->id]]) : 'Sem avaliações cadastradas' ?>
                        </td>
                        <td><?= h($estagiarios->turno) ?></td>
                        <td><?= h($estagiarios->nivel) ?></td>
                        <td><?= $estagiarios->hasValue('instituicao') ? $estagiarios->instituicao->instituicao : "" ?>
                        </td>
                        <td><?= $estagiarios->hasValue('supervisor') ? $this->Html->link($estagiarios->supervisor->nome, ['controller' => 'supervisores', 'action' => 'view', $estagiarios->supervisor->id]) : "" ?>
                        </td>
                        <td><?= h($estagiarios->periodo) ?></td>
                        <?php if (isset($user) && $user->categoria == '1'): ?>
                            <td><?= h($estagiarios->nota) ?></td>
                            <td><?= h($estagiarios->ch) ?></td>
                            <td><?= h($estagiarios->observacoes) ?></td>
                            <td>
                                <?= $this->Html->link(__('Atividades'), ['controller' => 'Folhadeatividades', 'action' => 'index', '?' => ['estagiario_id' => $estagiarios->id]]) ?>
                                <?php if (isset($user) && $user->categoria == '1'): ?>
                                    <?= $this->Html->link(__('Editar'), ['controller' => 'Estagiarios', 'action' => 'edit', $estagiarios->id]) ?>
                                    <?= $this->Form->postLink(__('Excluir'), ['controller' => 'Estagiarios', 'action' => 'delete', $estagiarios->id], ['confirm' => __('Tem certeza que quer excluir o registro # {0}?', $estagiarios->id)]) ?>
                                <?php endif; ?>
                            </td>
                        <?php endif; ?>
                    </tr>
                <?php endforeach; ?>
            </table>
        <?php endif; ?>
    </div>
</div>