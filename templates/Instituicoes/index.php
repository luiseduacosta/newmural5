<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Instituicao[]|\Cake\Collection\CollectionInterface $instituicao
 */
// pr($instituicoes);
?>

<?= $this->element('menu_mural') ?>

<nav class="navbar navbar-expand-lg py-2 navbar-light bg-light" id="actions-sidebar">
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarTogglerInstituicoes"
        aria-controls="navbarTogglerInstituicoes" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <ul class="navbar-nav collapse navbar-collapse" id="navbarTogglerInstituicoes">
        <?php if (isset($user->categoria) && $user->categoria == '1'): ?>
            <li class="nav-item">
                <?= $this->Html->link(__('Nova instituição'), ['action' => 'add'], ['class' => 'btn btn-primary float-end']) ?>
            </li>
            <div class="col-sm-2">
                <?= $this->Form->create(null, ['url' => ['controller' => 'Instituicoes', 'action' => 'buscainstituicao'], 'class' => 'form-inline']) ?>
                <?= $this->Form->control('nome', [
                    'type' => 'text',
                    'label' => false,
                    'placeholder' => 'Busca instituição',
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

<div class="row">
    <ul class="nav nav-tabs">
        <li class="nav-item">
            <a class="nav-link active" data-bs-toggle="tab" href="#instituicao" role="tab" aria-controls="instituicao"
                aria-selected="true">Instituição</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" data-bs-toggle="tab" href="#endereco" role="tab" aria-controls="endereco"
                aria-selected="false">Endereço</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" data-bs-toggle="tab" href="#estagio" role="tab" aria-controls="estagio"
                aria-selected="false">Estágio</a>
        </li>
    </ul>
</div>

<div class="container col-lg-12 shadow p-3 mb-5 bg-white rounded">
    <div class="tab-content">
        <div id="instituicao" class="tab-pane container active show">
            <table class="table table-striped table-hover table-responsive caption-top">
                <caption>Instituições</caption>
                <thead class="table-dark">
                    <tr>
                        <th><?= $this->Paginator->sort('Instituicoes.id', 'ID') ?></th>
                        <th><?= $this->Paginator->sort('Instituicoes.instituicao', 'Instituição') ?></th>
                        <th><?= $this->Paginator->sort('Instituicoes.area_instituicoes_id', 'Área institucional') ?></th>
                        <th><?= $this->Paginator->sort('Instituicoes.natureza', 'Natureza') ?></th>
                        <th><?= $this->Paginator->sort('Instituicoes.cnpj', 'CNPJ') ?></th>
                        <th><?= $this->Paginator->sort('Instituicoes.email', 'Email') ?></th>
                        <th><?= __('Ações') ?></th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($instituicoes as $instituicao): ?>
                        <?php // pr($instituicao); ?>
                        <tr>
                            <td><?= $instituicao->id ?></td>
                            <td><?= $this->Html->link($instituicao->instituicao, ['controller' => 'Instituicoes', 'action' => 'view', $instituicao->id]) ?>
                            </td>
                            <td><?= $instituicao->hasvalue('areainstituicao') ? $this->Html->link($instituicao->areainstituicao->area, ['controller' => 'Areainstituicoes', 'action' => 'view', $instituicao->areainstituicao->id]) : 's/d' ?>
                            </td>
                            <td><?= h($instituicao->natureza) ?></td>
                            <td><?= h($instituicao->cnpj) ?></td>
                            <td><?= h($instituicao->email) ?></td>
                            <td class="d-grid">
                                <?= $this->Html->link(__('Ver'), ['action' => 'view', $instituicao->id], ['class' => 'btn btn-primary btn-sm btn-block p-1 mb-1']) ?>
                                <?php if (isset($user->categoria) && $user->categoria == '1'): ?>
                                    <?= $this->Html->link(__('Editar'), ['action' => 'edit', $instituicao->id], ['class' => 'btn btn-primary btn-sm btn-block p-1 mb-1']) ?>
                                    <?= $this->Form->postLink(__('Excluir'), ['action' => 'delete', $instituicao->id], ['confirm' => __('Tem certeza que deseja excluir este registo # {0}?', $instituicao->id), 'class' => 'btn btn-danger btn-sm btn-block p-1 mb-1']) ?>
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>

    <div class="tab-content">
        <div id="endereco" class="tab-pane container fade">
            <table class="table table-striped table-hover table-responsive caption-top">
                <caption>Instituições endereço</caption>
                <thead class="table-dark">
                    <tr>
                        <th><?= $this->Paginator->sort('id', 'ID') ?></th>
                        <th><?= $this->Paginator->sort('instituicao', 'Instituição') ?></th>
                        <th><?= $this->Paginator->sort('url', 'URL') ?></th>
                        <th><?= $this->Paginator->sort('endereco', 'Endereço') ?></th>
                        <th><?= $this->Paginator->sort('bairro', 'Bairro') ?></th>
                        <th><?= $this->Paginator->sort('municipio', 'Município') ?></th>
                        <th><?= $this->Paginator->sort('cep', 'CEP') ?></th>
                        <th><?= $this->Paginator->sort('telefone', 'Telefone') ?></th>
                        <th><?= $this->Paginator->sort('fax', 'Fax') ?></th>
                        <th><?= __('Ações') ?></th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($instituicoes as $instituicao): ?>
                        <tr>
                            <td><?= $instituicao->id ?></td>
                            <td><?= $this->Html->link($instituicao->instituicao, ['controller' => 'Instituicoes', 'action' => 'view', $instituicao->id]) ?>
                            </td>
                            <td><?= h($instituicao->url) ?></td>
                            <td><?= h($instituicao->endereco) ?></td>
                            <td><?= h($instituicao->bairro) ?></td>
                            <td><?= h($instituicao->municipio) ?></td>
                            <td><?= h($instituicao->cep) ?></td>
                            <td><?= h($instituicao->telefone) ?></td>
                            <td><?= h($instituicao->fax) ?></td>
                            <td class="d-grid">
                                <?= $this->Html->link(__('Ver'), ['action' => 'view', $instituicao->id], ['class' => 'btn btn-primary btn-sm btn-block p-1 mb-1']) ?>
                                <?php if (isset($user->categoria) && $user->categoria == '1'): ?>
                                    <?= $this->Html->link(__('Editar'), ['action' => 'edit', $instituicao->id], ['class' => 'btn btn-primary btn-sm btn-block p-1 mb-1']) ?>
                                    <?= $this->Form->postLink(__('Excluir'), ['action' => 'delete', $instituicao->id], ['confirm' => __('Tem certeza que deseja excluir este registo # {0}?', $instituicao->id), 'class' => 'btn btn-danger btn-sm btn-block p-1 mb-1']) ?>
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>

    <div class="tab-content">
        <div id="estagio" class="tab-pane container fade">
            <table class="table table-striped table-hover table-responsive caption-top">
                <caption>Instituições estágio</caption>
                <thead class="table-dark">
                    <tr>
                        <th><?= $this->Paginator->sort('id', 'ID') ?></th>
                        <th><?= $this->Paginator->sort('instituicao', 'Instituição') ?></th>
                        <th><?= $this->Paginator->sort('beneficio', 'Benefícios') ?></th>
                        <th><?= $this->Paginator->sort('fim_de_semana', 'Fim de semana') ?></th>
                        <th><?= $this->Paginator->sort('localInscricao', 'Local de inscrição') ?></th>
                        <th><?= $this->Paginator->sort('convenio', 'Convenio') ?></th>
                        <th><?= $this->Paginator->sort('expira', 'Expira') ?></th>
                        <th><?= $this->Paginator->sort('seguro', 'Seguro') ?></th>
                        <th><?= __('Ações') ?></th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($instituicoes as $instituicao): ?>
                        <tr>
                            <td><?= $instituicao->id ?></td>
                            <td><?= $this->Html->link($instituicao->instituicao, ['controller' => 'Instituicoes', 'action' => 'view', $instituicao->id]) ?>
                            </td>
                            <td><?= h($instituicao->beneficio) ?></td>
                            <td><?= h($instituicao->fim_de_semana) ?></td>
                            <td><?= h($instituicao->localInscricao) ?></td>
                            <td><?= h($instituicao->convenio) ?></td>
                            <td><?= h($instituicao->expira) ?></td>
                            <td><?= h($instituicao->seguro) ?></td>
                            <td class="d-grid">
                                <?= $this->Html->link(__('Ver'), ['action' => 'view', $instituicao->id], ['class' => 'btn btn-primary btn-sm btn-block p-1 mb-1']) ?>
                                <?php if (isset($user->categoria) && $user->categoria == '1'): ?>
                                    <?= $this->Html->link(__('Edit'), ['action' => 'edit', $instituicao->id], ['class' => 'btn btn-primary btn-sm btn-block p-1 mb-1']) ?>
                                    <?= $this->Form->postLink(__('Excluir'), ['action' => 'delete', $instituicao->id], ['confirm' => __('Tem certeza que deseja excluir o registro # {0}?', $instituicao->id), 'class' => 'btn btn-danger btn-sm btn-block p-1 mb-1']) ?>
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>

    <?php $this->element('templates') ?>

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