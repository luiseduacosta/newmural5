<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Areainstituicao[]|\Cake\Collection\CollectionInterface $areainstituicoes
 */
$user = $this->getRequest()->getAttribute('identity');
?>

<?php echo $this->element('menu_mural') ?>

<nav class="navbar navbar-expand-lg py-2 navbar-light bg-light" id="actions-sidebar">
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarTogglerAreainstituicoes"
        aria-controls="navbarTogglerAreainstituicoes" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <ul class="navbar-nav collapse navbar-collapse" id="navbarTogglerAreainstituicoes">
        <?php if (isset($user) && $user->categoria == '1'): ?>
            <li class="nav-item">
                <?= $this->Html->link(__('Nova área instituição'), ['action' => 'add'], ['class' => 'btn btn-primary']) ?>
            </li>
        <?php endif; ?>
    </ul>
</nav>

<div class="container col-lg-8 shadow p-3 mb-5 bg-white rounded">
    <table class="table table-striped table-hover table-responsive">
        <thead class="table-dark">
            <tr>
                <th><?= $this->Paginator->sort('id', 'ID') ?></th>
                <th><?= $this->Paginator->sort('area', 'Área') ?></th>
                <th><?= __('Ações') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($areainstituicoes as $areainstituicao): ?>
                <tr>
                    <td><?= $areainstituicao->id ?></td>
                    <td><?= h($areainstituicao->area) ?></td>
                    <td>
                        <?= $this->Html->link(__('Ver'), ['controller' => 'Areainstituicoes', 'action' => 'view', $areainstituicao->id]) ?>
                        <?= $this->Html->link(__('Editar'), ['controller' => 'Areainstituicoes', 'action' => 'edit', $areainstituicao->id]) ?>
                        <?= $this->Form->postLink(__('Excluir'), ['controller' => 'Areainstituicoes', 'action' => 'delete', $areainstituicao->id], ['confirm' => __('Tem certeza que deseja excluir este registo # {0}?', $areainstituicao->id)]) ?>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
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
        <p><?= $this->Paginator->counter(__('Página {{page}} de {{pages}}, mostrando {{current}} registro(s) do {{count}} total')) ?></p>
    </div>
</div>
