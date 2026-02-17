<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Docente[]|\Cake\Collection\CollectionInterface $Docentes
 */
$user = $this->getRequest()->getAttribute('identity');
// pr($docentes);
?>

<?= $this->element('menu_monografias') ?>

<nav class="navbar navbar-expand-lg py-2 navbar-light bg-light" id="actions-sidebar">
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarTogglerDocentes"
        aria-controls="navbarTogglerDocentes" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarTogglerDocentes">
        <ul class="navbar-nav collapse navbar-collapse" id="navbarTogglerDocentes">
            <?php if (isset($user->categoria) && $user->categoria == '1'): ?>
                <li class="item-link">
                    <?= $this->Html->link(__('Novo docente'), ['action' => 'add'], ['class' => 'btn btn-primary float-start']) ?>
                </li>
            <?php endif; ?>
        </ul>
    </div>
</nav>

<div class="container col-lg-12 shadow p-3 mb-5 bg-white rounded">

    <div class="row">
        <ul class="nav nav-tabs">
            <li class="nav-item">
                <a class="nav-link active" data-bs-toggle="tab" href="#docente1" role="tab" aria-controls="docente1"
                    aria-selected="true">Dados funcionais</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" data-bs-toggle="tab" href="#docente2" role="tab" aria-controls="docente2"
                    aria-selected="false">Dados pessoais</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" data-bs-toggle="tab" href="#docente3" role="tab" aria-controls="docente2"
                    aria-selected="false">Dados de endereço</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" data-bs-toggle="tab" href="#docente4" role="tab" aria-controls="docente4"
                    aria-selected="false">Dados de contato</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" data-bs-toggle="tab" href="#docente5" role="tab" aria-controls="docente5"
                    aria-selected="false">Currículos</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" data-bs-toggle="tab" href="#docente6" role="tab" aria-controls="docente6"
                    aria-selected="false">Graduação</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" data-bs-toggle="tab" href="#docente7" role="tab" aria-controls="docente7"
                    aria-selected="false">Pós-graduação</a>
            </li>
        </ul>
    </div>

    <div class="tab-content">
        <div id="docente1" class="tab-pane container active show">
            <h3><?= __('Dados funcionais') ?></h3>
            <table class="table table-striped table-hover table-responsive">
                <thead class="table-dark">
                    <tr>
                        <th scope="col"><?= $this->Paginator->sort('nome') ?></th>
                        <th scope="col"><?= $this->Paginator->sort('siape') ?></th>
                        <th scope="col"><?= $this->Paginator->sort('departamento') ?></th>
                        <th scope="col"><?= $this->Paginator->sort('dataingresso', 'Data de ingresso') ?></th>
                        <th scope="col"><?= $this->Paginator->sort('formaingresso', 'Forma de ingresso') ?></th>
                        <th scope="col"><?= $this->Paginator->sort('tipocargo', 'Tipo de cargo') ?></th>
                        <th scope="col"><?= $this->Paginator->sort('categoria', 'Categoria') ?></th>
                        <th scope="col"><?= $this->Paginator->sort('regimetrabalho', 'Regime de trabalho') ?></th>
                        <th scope="col"><?= $this->Paginator->sort('dataegresso', 'Data de egresso') ?></th>
                        <th scope="col"><?= $this->Paginator->sort('motivoegresso', 'Motivo egresso') ?></th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($docentes as $docente): ?>
                        <tr>
                            <td><?= $this->Html->link(h($docente->nome), ['controller' => 'Docentes', 'action' => 'view', $docente->id]) ?>
                            </td>
                            <td><?= h($docente->siape) ?></td>
                            <td><?= h($docente->departamento) ?></td>
                            <td><?= $docente->dataingresso ? $docente->dataingresso->i18nFormat('dd-MM-yyyy') : 's/d' ?></td>
                            <td><?= h($docente->formaingresso) ?></td>
                            <td><?= h($docente->tipocargo) ?></td>
                            <td><?= h($docente->categoria) ?></td>
                            <td><?= h($docente->regimetrabalho) ?></td>
                            <td><?= $docente->dataegresso ? $docente->dataegresso->i18nFormat('dd-MM-yyyy') : 's/d' ?></td>
                            <td><?= h($docente->motivoegresso) ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>

    <div class="tab-content">
        <div id="docente2" class="tab-pane container active show">
            <h3><?= __('Dados pessoais') ?></h3>
            <table class="table table-striped table-hover table-responsive">
                <thead class="table-dark">
                    <tr>
                        <th scope="col"><?= $this->Paginator->sort('nome', 'Nome') ?></th>
                        <th scope="col"><?= $this->Paginator->sort('cpf', 'CPF') ?></th>
                        <th scope="col"><?= $this->Paginator->sort('rg', 'RG') ?></th>
                        <th scope="col"><?= $this->Paginator->sort('orgaoexpedidor', 'Órgão expedidor') ?></th>
                        <th scope="col"><?= $this->Paginator->sort('sexo', 'Sexo') ?></th>
                        <th scope="col"><?= $this->Paginator->sort('datanascimento', 'Data de nascimento') ?></th>
                        <th scope="col"><?= $this->Paginator->sort('localnascimento', 'Local de nascimento') ?></th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($docentes as $docente): ?>
                        <tr>
                            <td><?= $this->Html->link(h($docente->nome), ['controller' => 'Docentes', 'action' => 'view', $docente->id]) ?>
                            </td>
                            <td><?= h($docente->cpf) ?></td>
                            <td><?= h($docente->rg) ?></td>
                            <td><?= h($docente->orgaoexpedidor) ?></td>
                            <td>
                                <?php
                                if ($docente->sexo == '0'):
                                    echo "Feminino";
                                elseif ($docente->sexo == '1'):
                                    echo "Masculino";
                                elseif ($docente->sexo == '2'):
                                    echo "Não informado";
                                endif;
                                ?>
                            </td>
                            <td><?= $docente->datanascimento ? $docente->datanascimento->i18nFormat('dd-MM-yyyy') : ' ' ?></td>
                            <td><?= h($docente->localnascimento) ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>

    <div class="tab-content">
        <div id="docente3" class="tab-pane container active show">
            <h3><?= __('Dados de endereço') ?></h3>
            <table class="table table-striped table-hover table-responsive">
                <thead class="table-dark">
                    <tr>
                        <th scope="col"><?= $this->Paginator->sort('nome', 'Nome') ?></th>
                        <th scope="col"><?= $this->Paginator->sort('endereco', 'Endereço') ?></th>
                        <th scope="col"><?= $this->Paginator->sort('bairro', 'Bairro') ?></th>
                        <th scope="col"><?= $this->Paginator->sort('cidade', 'Cidade') ?></th>
                        <th scope="col"><?= $this->Paginator->sort('estado', 'Estado') ?></th>
                        <th scope="col"><?= $this->Paginator->sort('cep', 'CEP') ?></th>
                        <th scope="col"><?= $this->Paginator->sort('pais', 'País') ?></th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($docentes as $docente): ?>
                        <tr>
                            <td><?= $this->Html->link(h($docente->nome), ['controller' => 'Docentes', 'action' => 'view', $docente->id]) ?>
                            </td>
                            <td><?= h($docente->endereco) ?></td>
                            <td><?= h($docente->bairro) ?></td>
                            <td><?= h($docente->cidade) ?></td>
                            <td><?= h($docente->estado) ?></td>
                            <td><?= h($docente->cep) ?></td>
                            <td><?= h($docente->pais) ?></td>
                          </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>

    <div class="tab-content">
        <div id="docente4" class="tab-pane container active show">
            <h3><?= __('Dados de contato') ?></h3>
            <table class="table table-striped table-hover table-responsive">
                <thead class="table-dark">
                    <tr>
                        <th scope="col"><?= $this->Paginator->sort('nome', 'Nome') ?></th>
                        <th scope="col"><?= $this->Paginator->sort('ddd_telefone', 'DDD telefone') ?></th>
                        <th scope="col"><?= $this->Paginator->sort('telefone', 'Telefone') ?></th>
                        <th scope="col"><?= $this->Paginator->sort('ddd_celular', 'DDD celular') ?></th>
                        <th scope="col"><?= $this->Paginator->sort('celular', 'Celular') ?></th>
                        <th scope="col"><?= $this->Paginator->sort('email', 'E-mail') ?></th>
                        <th scope="col"><?= $this->Paginator->sort('homepage', 'Site') ?></th>
                        <th scope="col"><?= $this->Paginator->sort('redesocial', 'Rede social') ?></th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($docentes as $docente): ?>
                        <tr>
                            <td><?= $this->Html->link(h($docente->nome), ['controller' => 'Docentes', 'action' => 'view', $docente->id]) ?>
                            </td>
                            <td><?= '(' . h($docente->ddd_telefone) . ')' . h($docente->telefone) ?></td>
                            <td><?= '(' . h($docente->ddd_celular) . ')' . h($docente->celular) ?></td>
                            <td><?= $docente->email ? $this->Html->link($docente->email, 'mailto:' . $docente->email) : 's/d' ?></td>
                            <td><?= $docente->has('homepage') ? $this->Html->link($docente->homepage, $docente->homepage) : '' ?>
                            </td>
                            <td><?= $docente->has('redesocial') ? $this->Html->link($docente->redesocial, $docente->redesocial) : '' ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>

    <div class="tab-content">
        <div id="docente5" class="tab-pane container active show">
            <h3><?= __('Currículos') ?></h3>
            <table class="table table-striped table-hover table-responsive">
                <thead class="table-dark">
                    <tr>
                        <th scope="col"><?= $this->Paginator->sort('nome', 'Nome') ?></th>
                        <th scope="col"><?= $this->Paginator->sort('curriculolattes', 'Currículo Lattes') ?></th>
                        <th scope="col"><?= $this->Paginator->sort('atualizacaolattes', 'Atualização do currículo Lattes') ?>
                        </th>
                        <th scope="col"><?= $this->Paginator->sort('pesquisadordgp', 'Diretório de Grupos de Pesquisa') ?></th>
                        <th scope="col"><?= $this->Paginator->sort('curriculosigma', 'Currículo Sigma') ?></th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($docentes as $docente): ?>
                        <tr>
                            <td><?= $this->Html->link(h($docente->nome), ['controller' => 'Docentes', 'action' => 'view', $docente->id]) ?>
                            </td>
                            <td>
                                <?php if ($docente->curriculolattes): ?>
                                    <a href="<?= 'http://lattes.cnpq.br/' . $docente->curriculolattes ?>">Currículo Lattes</a>
                                <?php endif; ?>
                            </td>
                            <td>
                                <?php if ($docente->atualizacaolattes): ?>
                                    <?= $docente->atualizacaolattes ? $docente->atualizacaolattes->i18nFormat('dd-MM-yyyy') : ' ' ?>
                                <?php endif; ?>
                            </td>
                            <td>
                                <?php if ($docente->pesquisadordgp): ?>
                                    <a href='<?= 'http://dgp.cnpq.br/dgp/espelhogrupo/' . $docente->pesquisadordgp ?>'>Diretório de Grupos de Pesquisa</a>
                                <?php endif; ?>
                            </td>
                            <td>
                                <?php if ($docente->curriculosigma): ?>
                                    <a href='<?= 'http://dgp.cnpq.br/dgp/espelhogrupo/' . $docente->pesquisadordgp ?>'>Currículo Sigma</a>
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>

    <div class="tab-content">
        <div id="docente6" class="tab-pane container active show">
            <h3><?= __('Graduação') ?></h3>
            <table class="table table-striped table-hover table-responsive">
                <thead class="table-dark">
                    <tr>
                        <th scope="col"><?= $this->Paginator->sort('nome', 'Nome') ?></th>
                        <th scope="col"><?= $this->Paginator->sort('formacaoprofissional', 'Formação profissional') ?>
                        </th>
                        <th scope="col"><?= $this->Paginator->sort('universidadedegraduacao', 'Universidade de graduação') ?></th>
                        <th scope="col"><?= $this->Paginator->sort('anoformacao', 'Ano de conclusão da graduação') ?></th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($docentes as $docente): ?>
                        <tr>
                            <td><?= $this->Html->link(h($docente->nome), ['controller' => 'Docentes', 'action' => 'view', $docente->id]) ?>
                            </td>
                            <td><?= h($docente->formacaoprofissional) ?></td>
                            <td><?= h($docente->universidadedegraduacao) ?></td>
                            <td><?= h($docente->anoformacao) ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>

    <div class="tab-content">
        <div id="docente7" class="tab-pane container active show">
            <h3><?= __('Pós-graduação') ?></h3>
            <table class="table table-striped table-hover table-responsive">
                <thead class="table-dark">
                    <tr>
                        <th scope="col"><?= $this->Paginator->sort('nome') ?></th>
                        <th scope="col"><?= $this->Paginator->sort('mestradoarea', "Área de mestrado") ?></th>
                        <th scope="col"><?= $this->Paginator->sort('mestradouniversidade', 'Universidade de mestrado') ?></th>
                        <th scope="col"><?= $this->Paginator->sort('mestradoanoconclusao', 'Ano de conclusão do mestrado') ?></th>
                        <th scope="col"><?= $this->Paginator->sort('doutoradoarea', "Área de doutorado") ?></th>
                        <th scope="col"><?= $this->Paginator->sort('doutoradouniversidade', "Universidade de doutorado") ?></th>
                        <th scope="col"><?= $this->Paginator->sort('doutoradoanoconclusao', "Ano de conclusão do doutorado") ?></th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($docentes as $docente): ?>
                        <tr>
                            <td><?= $this->Html->link(h($docente->nome), ['controller' => 'Docentes', 'action' => 'view', $docente->id]) ?>
                            </td>
                            <td><?= h($docente->mestradoarea) ?></td>
                            <td><?= h($docente->mestradouniversidade) ?></td>
                            <td><?= h($docente->mestradoanoconclusao) ?></td>
                            <td><?= h($docente->doutoradoarea) ?></td>
                            <td><?= h($docente->doutoradouniversidade) ?></td>
                            <td><?= h($docente->doutoradoanoconclusao) ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<div class="d-flex justify-content-center">
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
            <p><?= $this->Paginator->counter(__('Página {{page}} de {{pages}}, mostrando {{current}} registro(s) do {{count}} total')) ?>
            </p>
        </div>
    </div>
</div>