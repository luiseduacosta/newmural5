<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Tccestudante $tccestudante
 */
$user = $this->getRequest()->getAttribute('identity');
// pr($tccestudante);
?>

<?php echo $this->element('menu_monografias') ?>

<nav class="navbar navbar-expand-lg py-2 navbar-light bg-light" id="actions-sidebar">
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
        data-bs-target="#navbarTogglerTccestudantesView" aria-controls="navbarTogglerTccestudantesview"
        aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <ul class="navbar-nav collapse navbar-collapse" id="navbarTogglerTccestudantesView">
        <li class="nav-item">
            <?= $this->Html->link(__('Listar'), ['action' => 'index'], ['class' => 'btn btn-primary me-1']) ?>
        </li>
        <?php if (isset($user) && $user->categoria == '1'): ?>
            <li class="nav-item">
                <?= $this->Html->link(__('Editar Estudante'), ['action' => 'edit', $tccestudante->id], ['class' => 'btn btn-primary me-1']) ?>
            </li>
            <li class="nav-item">
                <?= $this->Form->postLink(__('Excluir Estudante'), ['action' => 'delete', $tccestudante->id], ['confirm' => __('Tem certeza que deseja excluir este registo # {0}?', $tccestudante->id), 'class' => 'btn btn-danger']) ?>
            </li>
        <?php endif; ?>
    </ul>
</nav>

<div class="container col-lg-8 shadow p-3 mb-5 bg-white rounded">
    <h3><?= h($tccestudante->nome) ?></h3>
    <table class="table table-striped table-hover">
        <tr>
            <td scope="row"><?= __('Id') ?></td>
            <td><?= h($tccestudante->id) ?></td>
        </tr>
        <tr>
            <td scope="row"><?= __('Registro') ?></td>
            <td><?= h($tccestudante->registro) ?></td>
        </tr>
        <tr>
            <td scope="row"><?= __('Nome') ?></td>
            <?php if (!empty($tccestudante->estudante)): ?>
                <td><?= $this->Html->link($tccestudante->estudante->nome, ['controller' => 'estudantes', 'action' => 'view', $tccestudante->estudante->id]) ?>
                </td>
            <?php else: ?>
                <td><?= h($tccestudante->nome) ?></td>
            <?php endif ?>
        </tr>
        <tr>
            <td scope="row"><?= __('Monografia') ?></td>
            <td><?= $this->Html->link($tccestudante->monografias->titulo, ['controller' => 'monografias', 'action' => 'view', $tccestudante->monografias->id]) ?>
            </td>
        </tr>
    </table>
</div>