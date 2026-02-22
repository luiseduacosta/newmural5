<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Professor[]|\Cake\Collection\CollectionInterface $professores
 */
?>

<?= $this->element('menu_mural') ?>

<nav class="navbar navbar-expand-lg py-2 navbar-light bg-light">
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarTogglerProfessor"
        aria-controls="navbarTogglerProfessor" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <ul class="navbar-nav collapse navbar-collapse" id="navbarTogglerProfessor">
        <?php if (isset($user) && ($user->categoria == '1' || $user->categoria == '3')): ?>
            <li class="nav-item me-1">
                <?= $this->Html->link(__('Nova professora'), ['action' => 'add'], ['class' => 'btn btn-primary float-end']) ?>
            </li>
            <div class="col-sm-2">
                <?= $this->Form->create(null, ['url' => ['controller' => 'Professores', 'action' => 'buscaprofessor'], 'class' => 'form-inline']) ?>
                <?= $this->Form->control('nome', [
                    'type' => 'text',
                    'label' => false,
                    'placeholder' => 'Busca professor(a)',
                    'class' => 'form-control'
                ])
                    ?>
            </div>
            <div class="col-sm-1 me-1">
                <?= $this->Form->button(__("Buscar"), [
                    'type' => 'submit',
                    'class' => 'btn btn-primary',
                ]) ?>
            </div>
            <?= $this->Form->end() ?>
        <?php endif; ?>
    </ul>
</nav>

<div class="container col-lg-12 shadow p-3 mb-5 bg-white rounded">

    <div class="row">
        <ul class="nav nav-tabs">
            <li class="nav-item">
                <a class="nav-link active" data-bs-toggle="tab" href="#professor1" role="tab" aria-controls="professor1"
                    aria-selected="true">Dados funcionais</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" data-bs-toggle="tab" href="#professor2" role="tab" aria-controls="professor2"
                    aria-selected="false">Dados pessoais</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" data-bs-toggle="tab" href="#professor3" role="tab" aria-controls="professor3"
                    aria-selected="false">Dados endereço</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" data-bs-toggle="tab" href="#professor4" role="tab" aria-controls="professor4"
                    aria-selected="false">Comunicação</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" data-bs-toggle="tab" href="#professor5" role="tab" aria-controls="professor5"
                    aria-selected="false">Curriculo</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" data-bs-toggle="tab" href="#professor6" role="tab" aria-controls="professor6"
                    aria-selected="false">Graduação</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" data-bs-toggle="tab" href="#professor7" role="tab" aria-controls="professor7"
                    aria-selected="false">Pós-graduação</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" data-bs-toggle="tab" href="#professor8" role="tab" aria-controls="professor8"
                    aria-selected="false">Outras informações</a>
            </li>
        </ul>
    </div>

    <div class="tab-content">
        <div id="professor1" class="tab-pane container active show">
            <h3><?= __('Dados funcionais') ?></h3>
            <table class="table table-striped table-hover table-responsive">
                <thead class="table-dark">
                    <tr>
                        <th><?= $this->Paginator->sort('id') ?></th>
                        <th><?= $this->Paginator->sort('nome') ?></th>
                        <th><?= $this->Paginator->sort('siape', 'SIAPE') ?></th>
                        <th><?= $this->Paginator->sort('departamento', 'Departamento') ?></th>
                        <th><?= $this->Paginator->sort('dataingresso', 'Data de ingresso') ?></th>
                        <th><?= $this->Paginator->sort('formaingresso', 'Forma de ingresso') ?></th>
                        <th><?= $this->Paginator->sort('tipocargo', 'Tipo de cargo') ?></th>
                        <th><?= $this->Paginator->sort('categoria', 'Categoria') ?></th>
                        <th><?= $this->Paginator->sort('regimetrabalho', 'Regime de trabalho') ?></th>
                        <th><?= $this->Paginator->sort('dataegresso', 'Data de egresso') ?></th>
                        <th><?= $this->Paginator->sort('motivoegresso', 'Motivo de egresso') ?></th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($professores as $professor): ?>
                        <tr>
                            <td><?= $professor->id ?></td>
                            <td><?= $this->Html->link(h($professor->nome), ['controller' => 'Professores', 'action' => 'view', $professor->id]) ?>
                            </td>
                            <td><?= $professor->siape ?></td>
                            <td><?= $professor->departamento ?></td>
                            <td><?= $professor->dataingresso ? $professor->dataingresso->i18nFormat('dd-MM-yyyy') : '' ?>
                            </td>
                            <td><?= h($professor->formaingresso) ?></td>
                            <td><?= h($professor->tipocargo) ?></td>
                            <td><?= h($professor->categoria) ?></td>
                            <td><?= h($professor->regimetrabalho) ?></td>
                            <td><?= $professor->dataegresso ? $professor->dataegresso->i18nFormat('dd-MM-yyyy') : '' ?>
                            </td>
                            <td><?= h($professor->motivoegresso) ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>

    <div class="tab-content">
        <div id="professor2" class="tab-pane container fade">
            <h3><?= __('Dados pessoais') ?></h3>
            <table class="table table-striped table-hover table-responsive">
                <thead class="table-dark">
                    <tr>
                        <th><?= $this->Paginator->sort('id', 'ID') ?></th>
                        <th><?= $this->Paginator->sort('nome', 'Nome') ?></th>
                        <th><?= $this->Paginator->sort('cpf', 'CPF') ?></th>
                        <th><?= $this->Paginator->sort('rg', 'RG') ?></th>
                        <th><?= $this->Paginator->sort('orgaoexpedidor', 'Órgão expedidor') ?></th>
                        <th><?= $this->Paginator->sort('sexo', 'Sexo') ?></th>
                        <th><?= $this->Paginator->sort('datanascimento', 'Data de nascimento') ?></th>
                        <th><?= $this->Paginator->sort('localnascimento', 'Local de nascimento') ?></th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($professores as $professor): ?>
                        <tr>
                            <td><?= $professor->id ?></td>
                            <td><?= $this->Html->link(h($professor->nome), ['controller' => 'Professores', 'action' => 'view', $professor->id]) ?>
                            </td>
                            <td><?= h($professor->cpf) ?></td>
                            <td><?= h($professor->rg) ?></td>
                            <td><?= h($professor->orgaoexpedidor) ?></td>
                            <td><?php
                            if ($professor->sexo == '0') {
                                echo 'Feminino';
                            } elseif ($professor->sexo == '1') {
                                echo 'Masculino';
                            } elseif ($professor->sexo == '2') {
                                echo 'Não informado';
                            }
                            ?></td>
                            <td><?= $professor->datanascimento ? $professor->datanascimento->i18nFormat('dd-MM-yyyy') : '' ?>
                            </td>
                            <td><?= h($professor->localnascimento) ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>

    <div class="tab-content">
        <div id="professor3" class="tab-pane container fade">
            <h3><?= __('Dados endereço') ?></h3>
            <table class="table table-striped table-hover table-responsive">
                <thead class="table-dark">
                    <tr>
                        <th><?= $this->Paginator->sort('id', 'ID') ?></th>
                        <th><?= $this->Paginator->sort('nome', 'Nome') ?></th>
                        <th><?= $this->Paginator->sort('endereco', 'Endereço') ?></th>
                        <th><?= $this->Paginator->sort('bairro', 'Bairro') ?></th>
                        <th><?= $this->Paginator->sort('cidade', 'Cidade') ?></th>
                        <th><?= $this->Paginator->sort('estado', 'Estado') ?></th>
                        <th><?= $this->Paginator->sort('cep', 'CEP') ?></th>
                        <th><?= $this->Paginator->sort('pais', 'País') ?></th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($professores as $professor): ?>
                        <tr>
                            <td><?= $professor->id ?></td>
                            <td><?= $this->Html->link(h($professor->nome), ['controller' => 'Professores', 'action' => 'view', $professor->id]) ?>
                            </td>
                            <td><?= h($professor->endereco) ?></td>
                            <td><?= h($professor->bairro) ?></td>
                            <td><?= h($professor->cidade) ?></td>
                            <td><?= h($professor->estado) ?></td>
                            <td><?= h($professor->cep) ?></td>
                            <td><?= h($professor->pais) ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>

    <div class="tab-content">
        <div id="professor4" class="tab-pane container fade">
            <h3><?= __('Comunicação') ?></h3>
            <table class="table table-striped table-hover table-responsive">
                <thead class="table-dark">
                    <tr>
                        <th><?= $this->Paginator->sort('id', 'ID') ?></th>
                        <th><?= $this->Paginator->sort('nome', 'Nome') ?></th>
                        <th><?= $this->Paginator->sort('ddd_telefone', 'Telefone') ?></th>
                        <th><?= $this->Paginator->sort('telefone') ?></th>
                        <th><?= $this->Paginator->sort('ddd_celular', 'Celular') ?></th>
                        <th><?= $this->Paginator->sort('celular') ?></th>
                        <th><?= $this->Paginator->sort('email', 'E-mail') ?></th>
                        <th><?= $this->Paginator->sort('homepage', 'Homepage') ?></th>
                        <th><?= $this->Paginator->sort('redesocial', 'Rede social') ?></th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($professores as $professor): ?>
                        <tr>
                            <td><?= $professor->id ?></td>
                            <td><?= $this->Html->link(h($professor->nome), ['controller' => 'Professores', 'action' => 'view', $professor->id]) ?>
                            </td>
                            <td><?= h($professor->ddd_telefone) ?></td>
                            <td><?= h($professor->telefone) ?></td>
                            <td><?= h($professor->ddd_celular) ?></td>
                            <td><?= h($professor->celular) ?></td>
                            <td><?= $professor->email ? $this->Html->link($professor->email, 'mailto:' . $professor->email) : '' ?>
                            </td>
                            <td><?= $professor->hasValue('homepage') ? $this->Html->link($professor->homepage, $professor->homepage) : '' ?>
                            </td>
                            <td><?= $professor->hasValue('redesocial') ? $this->Html->link($professor->redesocial, $professor->redesocial) : '' ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>

    <div class="tab-content">
        <div id="professor5" class="tab-pane container fade">
            <h3><?= __('Currículo') ?></h3>
            <table class="table table-striped table-hover table-responsive">
                <thead class="table-dark">
                    <tr>
                        <th><?= $this->Paginator->sort('id', 'ID') ?></th>
                        <th><?= $this->Paginator->sort('nome', 'Nome') ?></th>
                        <th><?= $this->Paginator->sort('curriculolattes', 'Lattes') ?></th>
                        <th><?= $this->Paginator->sort('atualizacaolattes', 'Última atualização') ?></th>
                        <th><?= $this->Paginator->sort('curriculosigma', 'Sigma') ?></th>
                        <th><?= $this->Paginator->sort('pesquisadordgp', 'DGP') ?></th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($professores as $professor): ?>
                        <tr>
                            <td><?= $professor->id ?></td>
                            <td><?= $this->Html->link(h($professor->nome), ['controller' => 'Professores', 'action' => 'view', $professor->id]) ?>
                            </td>
                            <td><?= $professor->curriculolattes ? $this->Html->link($professor->curriculolattes, $professor->curriculolattes) : '' ?>
                            </td>
                            <td><?= $professor->atualizacaolattes ? $professor->atualizacaolattes->i18nFormat('dd-MM-yyyy') : '' ?>
                            </td>
                            <td><?= $professor->curriculosigma ? $this->Html->link($professor->curriculosigma, $professor->curriculosigma) : '' ?>
                            </td>
                            <td><?= $professor->pesquisadordgp ? $this->Html->link($professor->pesquisadordgp, $professor->pesquisadordgp) : '' ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>

    <div class="tab-content">
        <div id="professor6" class="tab-pane container fade">
            <h3><?= __('Graduação') ?></h3>
            <table class="table table-striped table-hover table-responsive">
                <thead class="table-dark">
                    <tr>
                        <th><?= $this->Paginator->sort('id', 'ID') ?></th>
                        <th><?= $this->Paginator->sort('nome', 'Nome') ?></th>
                        <th><?= $this->Paginator->sort('formacaoprofissional', 'Formação') ?></th>
                        <th><?= $this->Paginator->sort('graduacaoarea', 'Área de graduação') ?></th>
                        <th><?= $this->Paginator->sort('universidadedegraduacao', 'Universidade de graduação') ?></th>
                        <th><?= $this->Paginator->sort('anoformacao', 'Ano de formação') ?></th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($professores as $professor): ?>
                        <tr>
                            <td><?= $professor->id ?></td>
                            <td><?= $this->Html->link(h($professor->nome), ['controller' => 'Professores', 'action' => 'view', $professor->id]) ?>
                            </td>
                            <td><?= h($professor->formacaoprofissional) ?></td>
                            <td><?= h($professor->universidadedegraduacao) ?></td>
                            <td><?= h($professor->anoformacao) ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>

    <div class="tab-content">
        <div id="professor7" class="tab-pane container fade">
            <h3><?= __('Pós-graduação') ?></h3>
            <table class="table table-striped table-hover table-responsive">
                <thead class="table-dark">
                    <tr>
                        <th><?= $this->Paginator->sort('id', 'ID') ?></th>
                        <th><?= $this->Paginator->sort('nome', 'Nome') ?></th>
                        <th><?= $this->Paginator->sort('mestradoarea', 'Área de mestrado') ?></th>
                        <th><?= $this->Paginator->sort('mestradouniversidade', 'Universidade do mestrado') ?></th>
                        <th><?= $this->Paginator->sort('mestradoanoconclusao', 'Ano de conclusão do mestrado') ?></th>
                        <th><?= $this->Paginator->sort('doutoradoarea', 'Área de doutorado') ?></th>
                        <th><?= $this->Paginator->sort('doutoradouniversidade', 'Universidade de doutorado') ?></th>
                        <th><?= $this->Paginator->sort('doutoradoanoconclusao', 'Ano de conclusão do doutorado') ?></th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($professores as $professor): ?>
                        <tr>
                            <td><?= $professor->id ?></td>
                            <td><?= $this->Html->link(h($professor->nome), ['controller' => 'Professores', 'action' => 'view', $professor->id]) ?>
                            </td>
                            <td><?= h($professor->mestradoarea) ?></td>
                            <td><?= h($professor->mestradouniversidade) ?></td>
                            <td><?= h($professor->mestradoanoconclusao) ?></td>
                            <td><?= h($professor->doutoradoarea) ?></td>
                            <td><?= h($professor->doutoradouniversidade) ?></td>
                            <td><?= h($professor->doutoradoanoconclusao) ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>

    <div class="tab-content">
        <div id="professor8" class="tab-pane container fade">
            <h3><?= __('Outras informações') ?></h3>
            <table class="table table-striped table-hover table-responsive">
                <thead class="table-dark">
                    <tr>
                        <th><?= $this->Paginator->sort('id', 'ID') ?></th>
                        <th><?= $this->Paginator->sort('nome', 'Nome') ?></th>
                        <th><?= $this->Paginator->sort('observacoes', 'Observações') ?></th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($professores as $professor): ?>
                        <tr>
                            <td><?= $professor->id ?></td>
                            <td><?= $this->Html->link(h($professor->nome), ['controller' => 'Professores', 'action' => 'view', $professor->id]) ?>
                            </td>
                            <td><?= h($professor->observacoes) ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>

    <?= $this->element('templates') ?>

    <div class="d-flex justify-content-center">
        <div class="paginator">
            <ul class="pagination">
                <?= $this->Paginator->first('<< ' . __('primeiro')) ?>
                <?= $this->Paginator->prev('< ' . __('anterior')) ?>
                <?= $this->Paginator->numbers() ?>
                <?= $this->Paginator->next(__('próximo') . ' >') ?>
                <?= $this->Paginator->last(__('último') . ' >>') ?>
            </ul>
            <p><?= $this->Paginator->counter(__('Página {{page}} de {{pages}}, mostrando {{current}} registro(s) de um total de {{count}}.')) ?>
            </p>
        </div>
    </div>
</div>