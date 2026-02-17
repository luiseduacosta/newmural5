<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Visita[]|\Cake\Collection\CollectionInterface $visitas
 */
$user = $this->getRequest()->getAttribute('identity');
?>

<?php echo $this->element('menu_mural') ?>

<nav class="navbar navbar-expand-lg py-2 navbar-light bg-light" id="actions-sidebar">
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarTogglerVisitas"
        aria-controls="navbarTogglerVisitas" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <ul class="navbar-nav collapse navbar-collapse" id="navbarTogglerVisitas">
        <?php if (isset($user) && $user->categoria == '1'): ?>
            <li class="nav-item">
                <?= $this->Html->link(__('Nova visita'), ['action' => 'add'], ['class' => 'btn btn-primary float-end']) ?>
            </li>
        <?php endif; ?>
    </ul>
</nav>

<h3><?= __('Visitas instituicionais') ?></h3>

<div class="container col-lg-8 shadow p-3 mb-5 bg-white rounded">
    <table class="table table-striped table-hover table-responsive">
        <thead class="table-dark">
            <tr>
                <th><?= $this->Paginator->sort('id', 'ID') ?></th>
                <th><?= $this->Paginator->sort('instituicao_id', 'Instituição') ?></th>
                <th><?= $this->Paginator->sort('data', 'Data') ?></th>
                <th><?= $this->Paginator->sort('motivo', 'Motivo') ?></th>
                <th><?= $this->Paginator->sort('responsavel', 'Responsável') ?></th>
                <th><?= $this->Paginator->sort('avaliacao', 'Avaliação') ?></th>
                <th><?= __('Ações') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($visitas as $visita): ?>
                <tr>
                    <td><?= $visita->id ?></td>
                    <td><?= $visita->has('instituicao') ? $this->Html->link($visita->instituicao->instituicao, ['controller' => 'Instituicoes', 'action' => 'view', $visita->instituicao->id]) : '' ?></td>
                    <td><?= $visita->data->i18nFormat('dd-MM-yyyy') ?></td>
                    <td><?= h($visita->motivo) ?></td>
                    <td><?= h($visita->responsavel) ?></td>
                    <td><?= h($visita->avaliacao) ?></td>
                    <td class="d-grid">
                        <?= $this->Html->link(__('Ver'), ['controller' => 'Visitas', 'action' => 'view', $visita->id], ['class' => 'btn btn-primary btn-sm btn-block mb-1']) ?>
                        <?= $this->Html->link(__('Editar'), ['controller' => 'Visitas', 'action' => 'edit', $visita->id], ['class' => 'btn btn-primary btn-sm btn-block mb-1']) ?>
                        <?= $this->Form->postLink(__('Excluir'), ['controller' => 'Visitas', 'action' => 'delete', $visita->id], ['confirm' => __('Tem certeza que deseja excluir este registo # {0}?', $visita->id), 'class' => 'btn btn-danger btn-sm btn-block mb-1']) ?>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<div class="d-flex justify-content-center">
    <div class="paginator">
        <ul class="pagination">
            <?= $this->Paginator->first('<< ' . __('primeiro')) ?>
            <?= $this->Paginator->prev('< ' . __('anterior')) ?>
            <?= $this->Paginator->numbers() ?>
            <?= $this->Paginator->next(__('próximo') . ' >') ?>
            <?= $this->Paginator->last(__('último') . ' >>') ?>
    </ul>
        <p><?= $this->Paginator->counter(__('Página {{page}} de {{pages}}, mostrando {{current}} registro(s) do total em {{count}}.')) ?></p>
    </div>
</div>
