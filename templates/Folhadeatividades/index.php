<?php

use Cake\I18n\Time;
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Folhadeatividade[]|\Cake\Collection\CollectionInterface $folhadeatividades
 */

$supervisora = isset($estagiario->supervisor->nome) ? $estagiario->supervisor->nome : '_______________';
$cress = isset($estagiario->supervisor->cress) ? $estagiario->supervisor->cress : '_______________';
$professora = isset($estagiario->professor->nome) ? $estagiario->professor->nome : '_______________';
?>

<?php echo $this->element('menu_mural') ?>

<nav class="navbar navbar-expand-lg py-2 navbar-light bg-light">
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarTogglerAtividades"
        aria-controls="navbarTogglerAtividades" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <ul class="navbar-nav collapse navbar-collapse" id="navbarTogglerAtividades">
        <?php if ($user->categoria == '1' || $user->categoria == '2'): ?>
            <li class='nav-link'>
                <?= $this->Html->link(__('Cadastra nova atividade'), ['action' => 'add', '?' => ['estagiario_id' => $estagiario->id]], ['class' => 'btn btn-primary me-1']) ?>
            </li>
        <?php endif; ?>
        <li class='nav-link'>
            <?= $this->Html->link(__('Imprime folha de atividades'), ['action' => 'folhadeatividadespdf', '?' => ['estagiario_id' => $estagiario->id]], ['class' => 'btn btn-primary']) ?>
        </li>
    </ul>
</nav>

<h3 class="text-center"><?= __('Folha de atividades da(o) estagiária(o) ' . $estagiario->aluno->nome) ?></h3>

<div class="table-responsive">
    <table class="table table-responsive table-striped table-hover">
        <thead>
            <tr>
                <th>Período</th>
                <th>Nível</th>
                <th>Instituição</th>
                <th>Supervisor</th>
                <th>Professor(a)</th>
            </tr>
        </thead>
        <tr>
            <td><?= $estagiario->periodo ?></td>
            <td><?= $estagiario->nivel ?></td>
            <td><?= $estagiario->instituicao->instituicao ?></td>
            <td><?= $supervisora ?></td>
            <td><?= $professora ?></td>
        </tr>
    </table>
</div>

<div class="table-responsive">
    <table class="table table-responsive table-striped table-hover">
        <thead>
            <tr>
                <th><?= $this->Paginator->sort('id') ?></th>
                <th><?= $this->Paginator->sort('estagiario_id') ?></th>
                <th><?= $this->Paginator->sort('dia') ?></th>
                <th><?= $this->Paginator->sort('inicio') ?></th>
                <th><?= $this->Paginator->sort('final') ?></th>
                <th><?= $this->Paginator->sort('horario', 'Horas') ?></th>
                <th><?= $this->Paginator->sort('atividade') ?></th>
                <th><?= __('Ações') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php $seconds = NULL ?>
            <?php foreach ($folhadeatividades as $folhadeatividade): ?>
                <tr>
                    <td><?= $folhadeatividade->id ?></td>
                    <td><?= $folhadeatividade->estagiario_id ?></td>
                    <td><?= $this->Time->format($folhadeatividade->dia, 'd-MM-Y') ?></td>
                    <td><?= $this->Time->format($folhadeatividade->inicio, 'HH:mm') ?></td>
                    <td><?= $this->Time->format($folhadeatividade->final, 'HH:mm') ?></td>
                    <td><?= $this->Time->format($folhadeatividade->horario, "HH:mm") ?></td>
                    <td><?= h($folhadeatividade->atividade) ?></td>
                    <td>
                        <?= $this->Html->link(__('Ver'), ['action' => 'view', $folhadeatividade->id], ['class' => 'btn btn-info']) ?>
                        <?php if ($user->categoria == '1' || $user->categoria == '2'): ?>
                            <?= $this->Html->link(__('Editar'), ['action' => 'edit', $folhadeatividade->id], ['class' => 'btn btn-warning']) ?>
                            <?= $this->Form->postLink(__('Excluir'), ['action' => 'delete', $folhadeatividade->id], ['confirm' => __('Tem certeza que deseja excluir este registo # {0}?', $folhadeatividade->id), 'class' => 'btn btn-danger']) ?>
                        <?php endif; ?>
                    </td>
                </tr>
                <?php
                list($hour, $minute, $second) = array_pad(explode(':', $folhadeatividade->horario), 3, null);
                $seconds += $hour * 3600;
                $seconds += $minute * 60;
                $seconds += $second;
                // pr($seconds);
                ?>
            <?php endforeach; ?>
            <tr>
                <td colspan="5">Total de horas</td>
                <td>
                    <?php
                    $hours = floor($seconds / 3600);
                    $seconds -= $hours * 3600;
                    $minutes = floor($seconds / 60);
                    $seconds -= $minutes * 60;
                    echo $hours . ":" . $minutes . ":" . $seconds;
                    ?>
                </td>
                <td></td>
            </tr>
        </tbody>
    </table>
</div>

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