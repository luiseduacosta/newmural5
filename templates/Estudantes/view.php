<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Estudante $estudante
 * @var \Cake\ORM\ResultSet<\App\Model\Entity\Estudante> $estudantes
 */
$user = $this->getRequest()->getAttribute('identity');
?>

<?= $this->element('menu_monografias') ?>

<nav class="navbar navbar-expand-lg py-2 navbar-light bg-light" id="actions-sidebar">
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarTogglerEstudantesView"
            aria-controls="navbarTogglerEstudantesView" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <ul class="navbar-nav collapse navbar-collapse" id="navbarTogglerEstudantesView">
        <?php if (isset($user) && $user->categoria == '1'): ?>
            <li class="nav-item">
                <?= $this->Html->link(__('Novo Estudante'), ['action' => 'add'], ['class' => 'btn btn-primary me-1']) ?>
            </li>
            <li class="nav-item">
                <?= $this->Html->link(__('Editar Estudante'), ['action' => 'edit', $estudante->id], ['class' => 'btn btn-primary me-1']) ?>
            </li>
            <li class="nav-item">
                <?= $this->Form->postLink(__('Excluir Estudante'), ['action' => 'delete', $estudante->id], ['confirm' => __('Tem certeza que deseja excluir este registo # {0}?', $estudante->id), 'class' => 'btn btn-danger me-1']) ?>
            </li>
        <?php endif; ?>
        <li class="nav-item">
            <?= $this->Html->link(__('Listar Estudantes'), ['action' => 'index'], ['class' => 'btn btn-primary']) ?>
        </li>
    </ul>
</nav>

<div class="container col-lg-8 shadow p-3 mb-5 bg-white rounded">
    <h3><?= h($estudante->nome) ?></h3>
    <table class="table table-striped table-hover table-responsive">
        <tr>
            <th><?= __('Nome') ?></th>
            <td><?= h($estudante->nome) ?></td>
        </tr>
        <tr>
            <th><?= __('Registro') ?></th>
            <td><?= h($estudante->registro) ?></td>
        </tr>
        <?php if (isset($user) && $user->categoria == '1'): ?>
            <tr>
                <th><?= __('Nascimento') ?></th>
                <td><?= h($estudante->nascimento) ?></td>
            </tr>
            <tr>
                <th><?= __('Telefone') ?></th>
                <td><?= '(' . h($estudante->codigo_telefone) . ')' . h($estudante->telefone) ?></td>
            </tr>
            <tr>
                <th><?= __('Celular') ?></th>
                <td><?= '(' . h($estudante->codigo_celular) . ')' . h($estudante->celular) ?></td>
            </tr>
            <tr>
                <th><?= __('Email') ?></th>
                <td><?= h($estudante->email) ?></td>
            </tr>
            <tr>
                <th><?= __('Cpf') ?></th>
                <td><?= h($estudante->cpf) ?></td>
            </tr>
            <tr>
                <th><?= __('Identidade') ?></th>
                <td><?= h($estudante->identidade) ?></td>
            </tr>
            <tr>
                <th><?= __('Orgao') ?></th>
                <td><?= h($estudante->orgao) ?></td>
            </tr>
            <tr>
                <th><?= __('Endereço') ?></th>
                <td><?= h($estudante->endereco) ?></td>
            </tr>
            <tr>
                <th><?= __('Cep') ?></th>
                <td><?= h($estudante->cep) ?></td>
            </tr>
            <tr>
                <th><?= __('Município') ?></th>
                <td><?= h($estudante->municipio) ?></td>
            </tr>
            <tr>
                <th><?= __('Bairro') ?></th>
                <td><?= h($estudante->bairro) ?></td>
            </tr>
            <tr>
                <th><?= __('Observacoes') ?></th>
                <td><?= $estudante->observacoes ?></td>
            </tr>
        <?php endif; ?>
    </table>
</div>