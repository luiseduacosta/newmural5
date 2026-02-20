<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Configuracao[]|\Cake\Collection\CollectionInterface $configuracao
 */
$user = $this->getRequest()->getAttribute('identity');
?>

<?php echo $this->element('menu_mural') ?>

<nav class="navbar navbar-expand-lg py-2 navbar-light bg-light">
    <ul class="navbar-nav collapse navbar-collapse">
        <li class="nav-item">
            <?= $this->Html->link(__('Nova Configuração'), ['action' => 'add'], ['class' => 'btn btn-primary']) ?>
        </li>
    </ul>
</nav>

<h3><?= __('Configurações') ?></h3>

<div class="container col-lg-8 shadow p-3 mb-5 bg-white rounded">
    <table class="table table-striped table-hover table-responsive">
        <thead class="thead-dark">
            <tr>
                <th><?= $this->Paginator->sort('id') ?></th>
                <th><?= $this->Paginator->sort('mural_periodo_atual', 'Período do mural') ?></th>
                <th><?= $this->Paginator->sort('termo_compromisso_periodo', 'Período do termo de compromisso') ?></th>
                <th><?= $this->Paginator->sort('termo_compromisso_inicio', 'Data de início do termo de compromisso') ?>
                </th>
                <th><?= $this->Paginator->sort('termo_compromisso_final', 'Data de finalização do termo de compromisso') ?>
                </th>
                <th><?= $this->Paginator->sort('periodo_calendario_academico', 'Período calendário acadêmico') ?>
                </th>
                <th><?= __('Ações') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($configuracao as $configura): ?>
                <tr>
                    <td><?= $configura->id ?></td>
                    <td><?= h($configura->mural_periodo_atual) ?></td>
                    <td><?= h($configura->termo_compromisso_periodo) ?></td>
                    <td><?= h($configura->termo_compromisso_inicio) ?></td>
                    <td><?= h($configura->termo_compromisso_final) ?></td>
                    <td><?= h($configura->periodo_calendario_academico) ?></td>
                    <td>
                        <?= $this->Html->link(__('Ver'), ['action' => 'view', $configura->id], ['class' => 'btn btn-primary']) ?>
                        <?= $this->Html->link(__('Editar'), ['action' => 'edit', $configura->id], ['class' => 'btn btn-primary']) ?>
                        <?= $this->Form->postLink(__('Excluir'), ['action' => 'delete', $configura->id], ['confirm' => __('Tem certeza que deseja excluir a configuração # {0}?', $configura->id), 'class' => 'btn btn-danger']) ?>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<?= $this->element("templates") ?>

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