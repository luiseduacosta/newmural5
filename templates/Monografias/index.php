<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Monografia[]|\Cake\Collection\CollectionInterface $monografias
 */
$user = $this->getRequest()->getAttribute('identity');
// pr($monografias);
// die();
?>

<?= $this->element('menu_monografias') ?>

<nav class="navbar navbar-expand-lg py-2 navbar-light bg-light" id="actions-sidebar">
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarTogglerMonografias"
        aria-controls="navbarTogglerMonografias" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <ul class="navbar-nav collapse navbar-collapse" id="navbarTogglerMonografias">
        <?php if (isset($user->categoria) && $user->categoria == '1'): ?>
            <li class="nav-item">
                <?= $this->Html->link(__('Nova Monografia'), ['action' => 'add'], ['class' => 'btn btn-primary float-end']) ?>
            </li>
        <?php endif; ?>
    </ul>
</nav>

<div class="container col-lg-8 shadow p-3 mb-5 bg-white rounded">

    <h3><?= __('Monografias') ?></h3>

    <?= $this->Form->create($monografias); ?>
    <div class="form-group row p-2">
        <div class="col-8">
            <label class='form-label'>Busca por título</label>
            <?= $this->Form->control('titulo', ['label' => false, 'class' => 'form-control']); ?>
        </div>
        <div class="col-1 d-flex align-items-end">
            <?= $this->Form->button(__("Confirma"), ['class' => 'btn btn-primary']); ?>
        </div>
    </div>
    <?= $this->Form->end(); ?>

    <table class='table table-striped table-hover table-responsive'>
        <thead class="table-dark">
            <tr>
                <th scope="col"><?= $this->Paginator->sort('Monografias.titulo', 'Título') ?></th>
                <th scope="col"><?= $this->Paginator->sort('Monografias.periodo', 'Período') ?></th>
                <th scope="col"><?= $this->Paginator->sort('Tccestudantes[0].nome', 'Estudante') ?></th>
                <th scope="col"><?= $this->Paginator->sort('Docentes.nome', 'Orientador(a)') ?></th>
                <th scope="col"><?= $this->Paginator->sort('Areamonografias.area', 'Área') ?></th>
                <th scope="col"><?= $this->Paginator->sort('Monografias.url', 'PDF') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($monografias as $monografia): ?>
                <?php // pr($monografia); ?>
                <?php // die(pr($monografia->titulo)); ?>
                <tr>

                    <td>
                        <?=
                            $this->Html->link(substr($monografia->titulo, 0, 55) . ' ...', ['action' => 'view', $monografia->id])
                            ?>
                    </td>

                    <td><?= h($monografia->periodo) ?></td>
                    <td>
                        <?php
                        if (!(empty($monografia->tccestudantes))):
                            $q_estudantes = count($monografia->tccestudantes);
                            foreach ($monografia->tccestudantes as $tccestudante):
                                if (empty($tccestudante->nome) || $tccestudante['nome'] == 'Sem nome do aluno'):
                                    echo " ";
                                else:
                                    echo $this->Html->link($tccestudante->nome, ['controller' => 'tccestudantes', 'action' => 'view', $tccestudante->id]);
                                    if ($q_estudantes > 1):
                                        echo ", ";
                                    endif;
                                endif;
                            endforeach;
                        endif;
                        ?>
                    </td>
                    <td><?= $monografia->hasValue('docentes') ? $this->Html->link($monografia->docentes['nome'], ['controller' => 'Docentes', 'action' => 'view', $monografia->docentes['id']]) : '' ?>
                    </td>

                    <td><?= $monografia->hasValue('areamonografias') ? $this->Html->link($monografia->areamonografias['area'], ['controller' => 'Areamonografias', 'action' => 'view', $monografia->areamonografias['id']]) : '' ?>
                    </td>

                    <?php if (!empty($monografia->url)): ?>
                        <td><a href="<?= WWW_ROOT . 'monografias/' . $monografia->url ?>">Download</a></td>
                    <?php endif; ?>

                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <?= $this->element('templates'); ?>

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