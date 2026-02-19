<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Areamonografia[]|\Cake\Collection\CollectionInterface $areamonografias
 */
$user = $this->getRequest()->getAttribute('identity');
?>

<?php echo $this->element('menu_monografias') ?>

<nav class="navbar navbar-expand-lg py-2 navbar-light bg-light">
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarArea"
        aria-controls="navbarArea" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarArea">
        <ul class="navbar-nav me-auto mb-2 mb-lg-0">
            <?php if (isset($user->categoria) && $user->categoria == '1'): ?>
                <li class="nav-item">
                    <?= $this->Html->link(__('Nova área de monografia'), ['action' => 'add'], ['class' => 'btn btn-primary float-start']) ?>
                </li>
            <?php endif; ?>
        </ul>
    </div>
</nav>

<div class="container col-lg-8 shadow p-3 mb-5 bg-white rounded">
    <h3><?= __('Áreas') ?></h3>
    <table class="table table-striped table-hover table-responsive">
        <thead class="table-dark">
            <tr>
                <th scope="col"><?= $this->Paginator->sort('area', 'Área') ?></th>
                <th scope="col"><?= $this->Paginator->sort('q_monografia', 'Monografias') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($areas as $area): ?>
                <?php // pr(count($area->monografias)); ?>
                <tr>
                    <td><?= $this->Html->link(h($area->area), ['controller' => 'Areamonografias', 'action' => 'view', $area->id]) ?>
                    </td>
                    <td><?= $this->Number->format($area->q_monografia) ?? $this->Number->format(count($area->monografias)) ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

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