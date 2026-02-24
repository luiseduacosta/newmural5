<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\User[]|\Cake\Collection\CollectionInterface $users
 */
?>

<?= $this->element('menu_mural') ?>

<nav class="navbar navbar-expand-lg py-2 navbar-light bg-light" id="actions-sidebar">
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarTogglerUseresIndex"
            aria-controls="navbarTogglerUsersIndex" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <ul class="navbar-nav collapse navbar-collapse" id="navbarTogglerUsersIndex">
        <?php if (isset($user->categoria) && $user->categoria == '1'): ?>
            <li class="nav-item">
                <?= $this->Html->link(__('Novo usuário'), ['action' => 'add'], ['class' => 'btn btn-primary float-start']) ?>
            </li>
        <?php endif; ?>
    </ul>
</nav>

<div class="container col-lg-8 shadow p-3 mb-5 bg-white rounded">
    <h3><?= __('Usuários') ?></h3>
    <table class="table table-striped table-hover table-responsitive">
        <thead class="table-dark">
            <tr>
                <th scope="col"><?= $this->Paginator->sort('id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('email') ?></th>
                <th scope="col"><?= $this->Paginator->sort('categoria') ?></th>
                <th scope="col"><?= __('Ações') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($users as $user): ?>
                <tr>
                    <td><?= $this->Number->format($user->id) ?></td>
                    <td><?= h($user->email) ?></td>
                    <td><?= h($user->categoria) ?></td>
                    <td>
                        <?= $this->Html->link(__('Ver'), ['action' => 'view', $user->id]) ?>
                        <?php if (isset($user->categoria) && $user->categoria == '1'): ?>
                            <?= $this->Html->link(__('Editar'), ['action' => 'edit', $user->id]) ?>
                            <?= $this->Form->postLink(__('Excluir'), ['action' => 'delete', $user->id], ['confirm' => __('Tem certeza que deseja excluir este registo # {0}?', $user->id)]) ?>
                        <?php endif; ?>
                    </td>
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