<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Docente[]|\Cake\Collection\CollectionInterface $Professores
 */
$user = $this->getRequest()->getAttribute('identity');
?>

<?php echo $this->element('menu_monografias'); ?>

<?php if (isset($user->categoria) && $user->categoria == '1'): ?>
    <?= $this->Html->link(__('Novo docente'), ['action' => 'add'], ['class' => 'btn btn-primary float-right']) ?>
<?php endif; ?>

<div class="container col-lg-8 shadow p-3 mb-5 bg-white rounded">
    <h3><?= __('Professores') ?></h3>
    <p>
        <?php if (isset($user->categoria) && $user->categoria == '1'): ?>
            <?= $this->Html->link('Dados funcionais', ['controller' => 'docentemonografias', 'action' => 'index0'], ['class' => 'button float-right']) ?>
            <?= $this->Html->link('Dados pessoais', ['controller' => 'docentemonografias', 'action' => 'index1'], ['class' => 'button float-right']) ?>
            <?= $this->Html->link('Dados graduação', ['controller' => 'docentemonografias', 'action' => 'index2'], ['class' => 'button float-right']) ?>
            <?= $this->Html->link('Dados pósgraduação', ['controller' => 'docentemonografias', 'action' => 'index3'], ['class' => 'button float-right']) ?>
        <?php endif; ?>
    </p>
    <table class="table table-hover table-responsive table-striped">
        <thead class="table-dark">
            <tr>
                <th scope="col"><?= $this->Paginator->sort('nome') ?></th>
                <th scope="col"><?= $this->Paginator->sort('siape') ?></th>
                <th scope="col"><?= $this->Paginator->sort('departamento') ?></th>
                <th scope="col"><?= $this->Paginator->sort('dataingresso', 'Data ingresso') ?></th>
                <th scope="col"><?= $this->Paginator->sort('formaingresso', 'Forma ingresso') ?></th>
                <th scope="col"><?= $this->Paginator->sort('tipocargo', 'Tipo de cargo') ?></th>
                <th scope="col"><?= $this->Paginator->sort('categoria', 'Categoria') ?></th>
                <th scope="col"><?= $this->Paginator->sort('regimetrabalho', 'Regime de trabalho') ?></th>
                <th scope="col"><?= $this->Paginator->sort('dataegresso', 'Data de egresso') ?></th>
                <th scope="col"><?= $this->Paginator->sort('motivoegresso', 'Motivo egresso') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($docentemonografias as $docente): ?>
                <tr>
                    <td><?= $this->Html->link(h($docente->nome), ['controller' => 'docentemonografias', 'action' => 'view', $docente->id]) ?>
                    </td>
                    <td><?= h($docente->siape) ?></td>
                    <td><?= h($docente->departamento) ?></td>
                    <td><?= h($docente->dataingresso) ?></td>
                    <td><?= h($docente->formaingresso) ?></td>
                    <td><?= h($docente->tipocargo) ?></td>
                    <td><?= h($docente->categoria) ?></td>
                    <td><?= h($docente->regimetrabalho) ?></td>
                    <td><?= h($docente->dataegresso) ?></td>
                    <td><?= h($docente->motivoegresso) ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <?= $this->element('templates') ?>
    <div class="paginator">
        <ul class="pagination">
            <?= $this->Paginator->first('<< ' . __('primeiro')) ?>
            <?= $this->Paginator->prev('< ' . __('anterior')) ?>
            <?= $this->Paginator->numbers() ?>
            <?= $this->Paginator->next(__('próximo') . ' >') ?>
            <?= $this->Paginator->last(__('último') . ' >>') ?>
        </ul>
    </div>
</div>