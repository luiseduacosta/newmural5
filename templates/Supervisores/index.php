<?php
/**
 * @var \App\View\AppView $this 
 * @var \App\Model\Entity\Supervisor[]|\Cake\Collection\CollectionInterface $supervisores 
 */ 
?>

<?php echo $this->element('menu_mural') ?>

<nav class="navbar navbar-expand-lg py-2 navbar-light bg-light">
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarTogglerSupervisor"
            aria-controls="navbarTogglerSupervisor" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="container-fluid">

        <ul class="navbar-nav collapse navbar-collapse" id="navbarTogglerSupervisor">
            <?php if (isset($user) && $user->categoria == '1'): ?>
                <li class="nav-item me-1">
                    <?= $this->Html->link(__('Cadastra supervisora'), ['action' => 'add'], ['class' => 'btn btn-primary']) ?>
                </li>
                <div class="col-sm-2">
                <?= $this->Form->create(null, ['url' => ['controller' => 'Supervisores', 'action' => 'buscasupervisor'], 'class' => 'form-inline']) ?>
                <?= $this->Form->control('nome', [
                    'type' => 'text',
                    'label' => false,
                    'placeholder' => 'Busca supervisor(a)',
                    'class' => 'form-control'
                ])
                ?>
            </div>
            <div class="col-sm-1 me-1">
                <?= $this->Form->button(__("Buscar"), [
                    'type' => 'submit',
                    'class' => 'btn btn-primary',
                ]) ?>
            </div>
            <?= $this->Form->end() ?>
            <?php endif; ?>
        </ul>
    </div>
</nav>

<div class="container col-lg-10 shadow p-3 mb-5 bg-white rounded">
    <h3><?= __('Supervisores(as)') ?></h3>
    <table class="table table-responsive table-hover table-striped">
        <thead class="table-dark">
            <tr>
                <th><?= $this->Paginator->sort('id', 'ID') ?></th>
                <th><?= $this->Paginator->sort('nome', 'Nome') ?></th>
                <th><?= $this->Paginator->sort('cress', 'CRESS') ?></th>
                <th><?= $this->Paginator->sort('regiao', 'Região') ?></th>
                <th><?= $this->Paginator->sort('codigo_tel', 'DDD') ?></th>
                <th><?= $this->Paginator->sort('telefone', 'Telefone') ?></th>
                <th><?= $this->Paginator->sort('codigo_cel', 'DDD') ?></th>
                <th><?= $this->Paginator->sort('celular', 'Celular') ?></th>
                <th><?= $this->Paginator->sort('email', 'E-mail') ?></th>
                <th><?= __('Ações') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($supervisores as $supervisor): ?>
                <tr>
                    <td><?= $supervisor->id ?></td>
                    <?php if (isset($user) && $user->categoria == '1'): ?>
                        <td><?= $this->Html->link($supervisor->nome, ['controller' => 'Supervisores', 'action' => 'view', $supervisor->id]) ?>
                        </td>
                    <?php else: ?>
                        <td><?= $supervisor->nome ?></td>
                    <?php endif; ?>
                    <td><?= $supervisor->cress ?></td>
                    <td><?= $supervisor->regiao ?></td>
                    <td><?= h($supervisor->codigo_tel) ?></td>
                    <td><?= h($supervisor->telefone) ?></td>
                    <td><?= h($supervisor->codigo_cel) ?></td>
                    <td><?= h($supervisor->celular) ?></td>
                    <td><?= h($supervisor->email) ?></td>
                    <td class="d-grid">
                        <?= $this->Html->link(__('Ver'), ['controller' => 'Supervisores', 'action' => 'view', $supervisor->id], ['class' => 'btn btn-primary btn-sm btn-block mb-1']) ?>
                        <?php if (isset($user) && $user['categoria'] == '1'): ?>
                            <?= $this->Html->link(__('Editar'), ['controller' => 'Supervisores', 'action' => 'edit', $supervisor->id], ['class' => 'btn btn-primary btn-sm btn-block mb-1']) ?>
                            <?= $this->Form->postLink(__('Excluir'), ['controller' => 'Supervisores', 'action' => 'delete', $supervisor->id], ['confirm' => __('Tem certeza que quer excluir o registro # {0}?', $supervisor->id), 'class' => 'btn btn-danger btn-sm btn-block mb-1']) ?>
                        <?php endif; ?>
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
        <p><?= $this->Paginator->counter(__('Página {{page}} de {{pages}}, mostrando {{current}} registro(s) de um total de {{count}}.')) ?>
        </p>
    </div>
</div>