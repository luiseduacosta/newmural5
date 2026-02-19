<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Agendamentotcc[]|\Cake\Collection\CollectionInterface $agendamentotccs
 */
$user = $this->getRequest()->getAttribute('identity');
// pr($agendamentotccs);
?>

<?php echo $this->element('menu_monografias') ?>

<nav class="navbar navbar-expand-lg py-2 navbar-light bg-light" id="actions-sidebar">
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbar"
        aria-controls="navbar" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbar">
        <ul class="navbar-nav me-auto mb-2 mb-lg-0">
            <?php if (isset($user) && $user->categoria == '1'): ?>
                <li class='nav-item'>
                    <?= $this->Html->link(__('Agendar Oficina TCC'), ['action' => 'add'], ['class' => 'btn btn-primary']) ?>
                </li>
            <?php endif; ?>
        </ul>
    </div>
</nav>

<div class="container col-lg-10 shadow p-3 mb-5 bg-white rounded">

    <h3><?= __('Agendamento de Oficina de TCC') ?></h3>

    <table class="table table-striped table-hover table-responsive">
        <thead class="table-dark">
            <tr>
                <th><?= $this->Paginator->sort('Estudantes.nome', 'Estudante') ?></th>
                <th><?= $this->Paginator->sort('Docentes.nome', 'Orientador') ?></th>
                <th><?= $this->Paginator->sort('Docentebanca1.nome', 'Banca 1') ?></th>
                <th><?= $this->Paginator->sort('Docentebanca2.nome', 'Banca 2') ?></th>
                <th><?= $this->Paginator->sort('Agendamentotccs.data', 'Data') ?></th>
                <th><?= $this->Paginator->sort('Agendamentotccs.horario', 'Horário') ?></th>
                <th><?= $this->Paginator->sort('Agendamentotccs.sala', 'Sala') ?></th>
                <th><?= $this->Paginator->sort('Monografias.titulo', 'Título') ?></th>
                <?php if (isset($user->categoria) && $user->categoria == '1'): ?>
                    <th><?= $this->Paginator->sort('Agendamentotccs.avaliacao', 'Avaliação') ?></th>
                <?php endif; ?>
                <th><?= __('Ações') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($agendamentotccs as $agendamentotcc): ?>
                <tr>
                    <td><?= $agendamentotcc->hasValue('estudante') ? $this->Html->link($agendamentotcc->estudante->nome, ['controller' => 'Estudantes', 'action' => 'view', $agendamentotcc->estudante->id]) : '' ?>
                    </td>
                    <td><?= $agendamentotcc->hasValue('docente') ? $this->Html->link($agendamentotcc->docente->nome, ['controller' => 'Docentes', 'action' => 'view', $agendamentotcc->docente->id]) : '' ?>
                    </td>
                    <td><?= $agendamentotcc->hasValue('docentebanca1') ? $this->Html->link($agendamentotcc->docentebanca1->nome, ['controller' => 'Docentes', 'action' => 'view', $agendamentotcc->docentebanca1->id]) : '' ?>
                    </td>
                    <td><?= $agendamentotcc->hasValue('docentebanca2') ? $this->Html->link($agendamentotcc->docentebanca2->nome, ['controller' => 'Docentes', 'action' => 'view', $agendamentotcc->docentebanca2->id]) : '' ?>
                    </td>
                    <td><?= h($agendamentotcc->data) ?></td>
                    <td><?= h($agendamentotcc->horario) ?></td>
                    <td><?= h($agendamentotcc->sala) ?></td>
                    <td><?= h($agendamentotcc->titulo) ?></td>
                    <?php if (isset($user) && $user->categoria == '1'): ?>
                        <td><?= h($agendamentotcc->avaliacao) ?></td>
                    <?php endif; ?>
                    <td>
                        <?= $this->Html->link(__('Ver'), ['action' => 'view', $agendamentotcc->id]) ?>
                        <?php if (isset($user) && $user->categoria == '1'): ?>
                            <?= $this->Html->link(__('Editar'), ['action' => 'edit', $agendamentotcc->id]) ?>
                            <?= $this->Form->postLink(__('Excluir'), ['action' => 'delete', $agendamentotcc->id], ['confirm' => __('Tem certeza que deseja excluir este registo # {0}?', $agendamentotcc->id)]) ?>
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
        <p><?= $this->Paginator->counter(__('Página {{page}} de {{pages}}, mostrando {{current}} registro(s) do {{count}} total')) ?>
        </p>
    </div>
</div>