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
            <?= $this->Html->link('Dados funcionais', ['controller' => 'docentemonografias', 'action' => 'index0'], ['class' => 'button']) ?>
            <?= $this->Html->link('Dados pessoais', ['controller' => 'docentemonografias', 'action' => 'index1'], ['class' => 'button']) ?>
            <?= $this->Html->link('Dados graduação', ['controller' => 'docentemonografias', 'action' => 'index2'], ['class' => 'button']) ?>
            <?= $this->Html->link('Dados pósgraduação', ['controller' => 'docentemonografias', 'action' => 'index3'], ['class' => 'button']) ?>
        <?php endif; ?>
    </p>
    <table class="table table-striped table-hover table-responsive">
        <thead class="table-dark">
            <tr>
                <th scope="col"><?= $this->Paginator->sort('nome') ?></th>
                <th scope="col"><?= $this->Paginator->sort('departamento') ?></th>
                <th scope="col"><?= $this->Paginator->sort('homepage', 'Site') ?></th>
                <th scope="col"><?= $this->Paginator->sort('curriculolattes', 'Lattes') ?></th>
                <th scope="col"><?= $this->Paginator->sort('motivoegresso', 'Motivo egresso') ?></th>
                <?php if (isset($user->categoria) && $user->categoria == '1'): ?>
                    <th><?= __('Ações') ?></th>
                <?php endif; ?>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($docentemonografias as $docentemonografia): ?>
                <tr>
                    <td><?= $this->Html->link(h($docentemonografia->nome), ['controller' => 'docentemonografias', 'action' => 'view', $docentemonografia->id]) ?>
                    </td>
                    <td><?= h($docentemonografia->departamento) ?></td>
                    <td><?= h($docentemonografia->homepage) ?></td>
                    <td>
                        <?php if ($docentemonografia->curriculolattes): ?>
                            <a href="<?= 'http://lattes.cnpq.br/' . $docentemonografia->curriculolattes ?>">Lattes</a>
                        <?php endif; ?>
                    </td>
                    <td><?= h($docentemonografia->motivoegresso) ?></td>
                    <?php if (isset($user->categoria) && $user->categoria == '1'): ?>
                        <td>
                            <?= $this->Html->link(__('Ver'), ['action' => 'view', $docentemonografia->id, 'class' => 'nav-link']) ?>
                            <?= $this->Html->link(__('Editar'), ['action' => 'edit', $docentemonografia->id, 'class' => 'nav-link']) ?>
                            <?= $this->Form->postLink(__('Excluir'), ['action' => 'delete', $docentemonografia->id], ['confirm' => __('Tem certeza que deseja excluir este registo # {0}?', $docentemonografia->id), 'class' => 'nav-link']) ?>
                        </td>
                    <?php endif; ?>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <div class="d-flex justify-content-center">
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
</div>