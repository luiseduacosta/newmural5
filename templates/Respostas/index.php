<?php

use Cake\I18n\Time;
/**
 * @var \App\View\AppView $this
 * @var iterable<\App\Model\Entity\Resposta> $respostas
 */
?>

<?= $this->element('menu_mural') ?>
<?= $this->element('templates') ?>

<div class="container mt-1">

    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <ul class="navbar-nav mr-auto">
            <?php if (isset($user) && $user->categoria == '1'): ?>
            <li class="nav-item">
                <?= $this->Html->link(__('Nova resposta'), ['action' => 'add'], ['class' => 'btn btn-primary']) ?>
            </li>
            <?php endif; ?>
        </ul>
    </nav>

    <h3><?= __('Respostas') ?></h3>
    <div class="container mt-4">
        <table class="table table-striped table-hover table-responsive">
            <thead class="thead-light">
                <tr>
                    <th><?= $this->Paginator->sort('id') ?></th>
                    <th><?= $this->Paginator->sort('estagiario.aluno.nome', 'Aluno') ?></th>
                    <th><?= $this->Paginator->sort('estagiario_id', 'Nível de estágio') ?></th>
                    <th><?= $this->Paginator->sort('created') ?></th>
                    <th><?= $this->Paginator->sort('modified') ?></th>
                    <th><?= __('Ações') ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($respostas as $resposta): ?>
                    <tr>
                        <td><?= $this->Number->format($resposta->id) ?></td>
                        <td><?= $this->Html->link($resposta->estagiario->aluno->nome, ['controller' => 'Respostas', 'action' => 'view', $resposta->id]) ?>
                        </td>
                        <td><?= $resposta->hasValue('estagiario') ? $this->Html->link($resposta->estagiario->nivel, ['controller' => 'Estagiarios', 'action' => 'view', $resposta->estagiario->id]) : '' ?>
                        </td>
                        <td><?= $this->Time->format($resposta->created, 'd-MM-Y HH:mm:ss') ?></td>
                        <td><?= $this->Time->format($resposta->modified, 'd-MM-Y HH:mm:ss') ?></td>
                        <td class="d-grid">
                            <?= $this->Html->link(__('Ver'), ['action' => 'view', $resposta->id], ['class' => 'btn btn-primary btn-sm btn-block p-1 mb-1']) ?>
                            <?php if (isset($user) && $user->categoria == '1'): ?>
                            <?= $this->Html->link(__('Editar'), ['action' => 'edit', $resposta->id], ['class' => 'btn btn-primary btn-sm btn-block p-1 mb-1']) ?>
                            <?= $this->Form->postLink(__('Excluir'), ['action' => 'delete', $resposta->id], ['confirm' => __('Tem certeza que deseja excluir este registo # {0}?', $resposta->id), 'class' => 'btn btn-danger btn-sm btn-block p-1 mb-1']) ?>
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <?= $this->element('paginator') ?>

</div>