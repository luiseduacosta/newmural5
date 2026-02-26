<?php

use Cake\I18n\Time;
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Resposta $resposta
 */
?>

<?= $this->element('menu_mural') ?>
<?= $this->element('templates') ?>

<div class="container mt-1">

    <nav class="nav navbar-expand-lg navbar-light bg-light">
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#resposta"
            aria-controls="resposta" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <ul class="navbar-nav collapse navbar-collapse" id="resposta">
            <?php if (isset($user->categoria) && $user->categoria == '1'): ?>
                <li class="nav-item">
                    <?= $this->Html->link(__('Listar'), ['action' => 'index'], ['class' => 'btn btn-primary me-1']) ?>
                </li>
                <li class="nav-item">
                    <?= $this->Html->link(__('Editar'), ['action' => 'edit', $resposta->id], ['class' => 'btn btn-primary me-1']) ?>
                </li>
                <li class="nav-item">
                    <?= $this->Form->postLink(__('Excluir'), ['action' => 'delete', $resposta->id], ['confirm' => __('Tem certeza que deseja excluir este registo # {0}?', $resposta->id), 'class' => 'btn btn-danger me-1']) ?>
                </li>
                <li class="nav-item">
                    <?= $this->Html->link(__('Nova'), ['action' => 'add', '?' => ['estagiario_id' => $resposta->estagiario->id]], ['class' => 'btn btn-primary me-1']) ?>
                </li>
                <?php endif ?>
                <?php if (isset($user->supervisor_id) && ($user->supervisor_id == $resposta->estagiario->supervisor_id)): ?>
                    <li class="nav-item">
                        <?= $this->Html->link(__('Supervisor(a)'), ['controller' => 'Supervisores', 'action' => 'view', '?' => ['id' => $user->supervisor_id]], ['class' => 'btn btn-primary me-1']) ?>
                    </li>
                    <li class="nav-item">
                        <?= $this->Html->link(__('Editar'), ['action' => 'edit', $resposta->id], ['class' => 'btn btn-primary me-1']) ?>
                    </li>
                    <li class="nav-item">
                        <?= $this->Form->postLink(__('Excluir'), ['action' => 'delete', $resposta->id], ['confirm' => __('Tem certeza que deseja excluir este registo # {0}?', $resposta->id), 'class' => 'btn btn-danger me-1']) ?>
                    </li>
                <?php endif ?>
            <?php if (isset($user->categoria) && ($user->categoria == '1' || $user->categoria == '2' || $user->categoria == '4')): ?>
                <li class="nav-item">
                    <?= $this->Html->link(__('Imprimir'), ['action' => 'imprimeresposta', '?' => ['estagiario_id' => $resposta->estagiario->id]], ['class' => 'btn btn-primary me-1']) ?>
                </li>
            <?php endif ?>
        </ul>
    </nav>

    <div class="container mt-4">
        <div class="card">
            <div class="card-header">
                <?= 'Avaliação de: ' . $resposta->estagiario->aluno->nome ?>
                <?= ' - Supervisor(a): ' . $this->Html->link($resposta->estagiario->supervisor->nome, ['controller' => 'Supervisores', 'action' => 'view', $resposta->estagiario->supervisor->id]) ?>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-6">
                        <?= 'Período: ' . $resposta->estagiario->periodo ?>
                    </div>
                    <div class="col-6 text-end">
                        <?= 'Nível: ' . $resposta->estagiario->nivel ?>
                    </div>
                </div>
            </div>    
        </div>

        <table class="table table-responsive table-striped table-hover">

            <?php
            foreach ($avaliacoes as $key => $value): ?>
                <tr>
                    <th>
                        <?= h($key) ?>
                    </th>
                </tr>
                <tr>    
                    <td>
                        <?= h($value) ?>
                    </td>
                </tr>
            <?php endforeach; ?>
            </table>
            <p>
                <div class="row">
                    <span class="col-6 text-start"><?= __('Criado') ?>: <?= $this->Time->format($resposta->created, 'd-MM-Y HH:mm:ss') ?></span>
                    <span class="col-6 text-end"><?= __('Modificado') ?>: <?= $this->Time->format($resposta->modified, 'd-MM-Y HH:mm:ss') ?></span>
                </div>
            </p>
        </div>
    </div>
</div>