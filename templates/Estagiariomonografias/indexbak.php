<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Estagiario[]|\Cake\Collection\CollectionInterface $estagiarios
 */
$user = $this->getRequest()->getAttribute('identity');
?>

<script type="text/javascript">
    $(document).ready(function() {
        var url = "<?= $this->Html->Url->build(['controller' => 'estagiariomonografias', 'action' => 'index']); ?>";
        $('#EstagiarioPeriodo').change(function() {
            window.location = url + '/index?periodo=' + $(this).val();
        });
    });
</script>

<?= $this->element('menu_monografias') ?>

<?= $this->element('templates') ?>

<div class="container col-lg-8 shadow p-3 mb-5 bg-white rounded">

    <h3><?= __('Estagiarios por período e por TCC concluída') ?></h3>

    <div class="col-sm-5">
        <?= $this->Form->create(null, ['url' => ['action' => 'index']]) ?>
        <div class="form-group row">
            <?= $this->Form->control('periodo', ['id' => 'EstagiarioPeriodo', 'type' => 'select', 'label' => 'Período', 'options' => $periodos, 'empty' => [$periodo => $periodo], 'class' => 'form-control']); ?>
        </div>
    </div>

    <?php if ($estagiariomonografias): ?>
    <table class="table table-striped table-hover table-responsive">
        <thead class="table-dark">
            <tr>
                <th scope="col"><?= $this->Paginator->sort('registro', ['label' => 'DRE']) ?></th>
                <th scope="col"><?= $this->Paginator->sort('nome', ['label' => 'Estudante']) ?></th>
                <th scope="col"><?= $this->Paginator->sort('turno', ['label' => 'Turno']) ?></th>
                <th scope="col"><?= $this->Paginator->sort('nivel', ['label' => 'Nível']) ?></th>
                <th scope="col"><?= $this->Paginator->sort('periodo', ['label' => 'Período']) ?></th>
                <th scope="col"><?= $this->Paginator->sort('titulo', ['label' => 'Título']) ?></th>
                <th scope="col"><?= $this->Paginator->sort('periodo_monog', ['label' => 'Período de monografia']) ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($estagiariomonografias as $c_estagiariomonografia): ?>
                <?php // pr($c_estagiariomonografia->estudante->tccestudante->monografia) ?>
                <tr>
                    <td><?= h($c_estagiariomonografia->estudante->registro) ?></td>
                    <?php if (!empty($c_estagiariomonografia->estudante->id)): ?>
                        <td><?= $this->Html->link($c_estagiariomonografia->estudante->nome, ['controller' => 'Tccestudantes', 'action' => 'view', $c_estagiariomonografia->estudante->id]) ?>
                        </td>
                    <?php else: ?>
                        <td><?= h($c_estagiariomonografia->estudante->nome) ?></td>
                    <?php endif; ?>
                    <td><?= h($c_estagiariomonografia->turno) ?></td>
                    <td><?= h($c_estagiariomonografia->nivel) ?></td>
                    <td><?= h($c_estagiariomonografia->periodo) ?></td>
                    <td><?= $this->Html->link($c_estagiariomonografia->estudante->tccestudante->monografia->titulo, ['controller' => 'Monografias', 'action' => 'view', $c_estagiariomonografia->estudante->tccestudante->monografia->id]) ?>
                    </td>
                    <td><?= h($c_estagiariomonografia->estudante->tccestudante->monografia->periodo_monog) ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <?php endif; ?>

    <?php if ($this->Paginator->hasPage()): ?>
        <?= $this->element('templates') ?>
        <div class="d-flex justify-content-center">
        <div class="paginator">
            <ul class="pagination">
                <?= $this->Paginator->first('<< ' . __('first')) ?>
                <?= $this->Paginator->prev('< ' . __('previous')) ?>
                <?= $this->Paginator->numbers() ?>
                <?= $this->Paginator->next(__('next') . ' >') ?>
                <?= $this->Paginator->last(__('last') . ' >>') ?>
            </ul>
        </div>
        <p><?= $this->Paginator->counter(__('Page {{page}} of {{pages}}, showing {{current}} record(s) out of {{count}} total')) ?>
        </p>
    </div>
    <?php endif; ?>
</div>