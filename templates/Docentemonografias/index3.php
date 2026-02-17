<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Docente[]|\Cake\Collection\CollectionInterface $Professores
 */
$user = $this->getRequest()->getAttribute('identity');
?>

<?php echo $this->element('menu_monografias'); ?>

<?php if (isset($user->categoria) && $user->categoria == '1'): ?>
    <?= $this->Html->link(__('Novo docente'), ['action' => 'add'], ['class' => 'button float-right']) ?>
<?php endif; ?>

<div class="container col-lg-8 shadow p-3 mb-5 bg-white rounded">
    <h3><?= __('Professores') ?></h3>
    <p>
        <?php if (isset($user->categoria) && $user->categoria == '1'): ?>
            <?= $this->Html->link('Dados funcionais', ['controller' => 'docentemonografias', 'action' => 'index0'], ['class' => 'button float-end']) ?>
            <?= $this->Html->link('Dados pessoais', ['controller' => 'docentemonografias', 'action' => 'index1'], ['class' => 'button float-end']) ?>
            <?= $this->Html->link('Dados graduação', ['controller' => 'docentemonografias', 'action' => 'index2'], ['class' => 'button float-end']) ?>
            <?= $this->Html->link('Dados pósgraduação', ['controller' => 'docentemonografias', 'action' => 'index3'], ['class' => 'button float-end']) ?>
        <?php endif; ?>
    </p>
    <table class="table table-striped table-hover table-responsive">
        <thead class="table-dark">
            <tr>
                <th scope="col"><?= $this->Paginator->sort('nome') ?></th>
                <th scope="col"><?= $this->Paginator->sort('mestradoarea', "Área") ?></th>
                <th scope="col"><?= $this->Paginator->sort('mestradouniversidade', 'Universidade') ?></th>
                <th scope="col"><?= $this->Paginator->sort('mestradoanoconclusao', 'Conclusão') ?></th>
                <th scope="col"><?= $this->Paginator->sort('doutoradoarea', "Área") ?></th>
                <th scope="col"><?= $this->Paginator->sort('doutoradouniversidade', "Universidade") ?></th>
                <th scope="col"><?= $this->Paginator->sort('doutoradoanoconclusao', "Conclusão") ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($docentemonografias as $docente): ?>
                <tr>
                    <td><?= $this->Html->link(h($docente->nome), ['controller' => 'Professores', 'action' => 'view', $docente->id]) ?>
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
    <?= $this->element("templates") ?>
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