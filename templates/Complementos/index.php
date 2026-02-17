<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Complemento[]|\Cake\Collection\CollectionInterface $complementos
 */
$user = $this->getRequest()->getAttribute('identity');
?>

<?php echo $this->element('menu_mural') ?>

<nav class="navbar navbar-expand-lg py-2 navbar-light bg-light">
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarToggler"
        aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <ul class="navbar-nav collapse navbar-collapse" id="navbarToggler">
        <li class="nav-item">
            <?= $this->Html->link(__('Novo registro'), ['action' => 'add'], ['class' => 'btn btn-primary float-end']) ?>
        </li>
    </ul>
</nav>

<div class="container col-lg-12 shadow p-3 mb-5 bg-white rounded">
    <h3><?= __('Complemento de estagiário') ?></h3>
    <table class="table table-striped table-hover table-responsive">
        <thead class="thead-dark">
            <tr>
                <th><?= $this->Paginator->sort('id') ?></th>
                <th><?= $this->Paginator->sort('periodo_especial') ?></th>
                <th><?= __('Ações') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($complementos as $complemento): ?>
                <tr>
                    <td><?= $complemento->id ?></td>
                    <td><?= h($complemento->periodo_especial) ?></td>
                    <td>
                        <?= $this->Html->link(__('Ver'), ['action' => 'view', $complemento->id]) ?>
                        <?= $this->Html->link(__('Editar'), ['action' => 'edit', $complemento->id]) ?>
                        <?= $this->Form->postLink(__('Excluir'), ['action' => 'delete', $complemento->id], ['confirm' => __('Tem certeza que deseja excluir este registo # {0}?', $complemento->id)]) ?>

                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<?= $this->element('templates') ?>

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