<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Estagiario $estagiario
 */
$user = $this->getRequest()->getAttribute('identity');
// pr($estagiariomonografia);
// die();
?>

<?= $this->element('menu_monografias') ?>

<div class="container col-lg-8 shadow p-3 mb-5 bg-white rounded">
    <h3><?= h($estagiariomonografia->estudante->nome) ?></h3>
    <table class="table table-hover table-responsive table-striped">
        <tr>
            <th scope="row"><?= __('Id') ?></th>
            <td><?= $estagiariomonografia->id ?></td>
        </tr>

        <tr>
            <th scope="row"><?= __('Registro') ?></th>
            <td><?= h($estagiariomonografia->registro) ?></td>
        </tr>

        <tr>
            <th scope="row"><?= __('Estudante') ?></th>
            <td><?= $estagiariomonografia->has('estudante') ? $this->Html->link($estagiariomonografia->estudantemonografia->nome, ['controller' => 'estudantemonografias', 'action' => 'view', $estagiariomonografia->estudantemonografia->id]) : '' ?>
            </td>
        </tr>

        <tr>
            <th scope="row"><?= __('Turno') ?></th>
            <td><?= h($estagiariomonografia->turno) ?></td>
        </tr>

        <tr>
            <th scope="row"><?= __('Nível') ?></th>
            <td><?= h($estagiariomonografia->nivel) ?></td>
        </tr>

        <tr>
            <th scope="row"><?= __('Docente') ?></th>
            <td><?= $estagiariomonografia->has('docente') ? $this->Html->link($estagiariomonografia->docente->nome, ['controller' => 'Docentes', 'action' => 'view', $estagiariomonografia->docente->id]) : '' ?>
            </td>
        </tr>

        <tr>
            <th scope="row"><?= __('Período') ?></th>
            <td><?= h($estagiariomonografia->periodo) ?></td>
        </tr>

        <tr>
            <th scope="row"><?= __('Termo de compromisso') ?></th>
            <td><?= $estagiariomonografia->tc ?></td>
        </tr>

        <tr>
            <th scope="row"><?= __('Solicitação de TC') ?></th>
            <td><?= h($estagiariomonografia->tc_solicitacao) ?></td>
        </tr>

        <tr>
            <th scope="row"><?= __('Instituição') ?></th>
            <td><?= $estagiariomonografia->instituicao_id ?></td>
        </tr>

        <tr>
            <th scope="row"><?= __('Supervisor(a)') ?></th>
            <td><?= $estagiariomonografia->supervisor_id ?></td>
        </tr>

        <tr>
            <th scope="row"><?= __('Turma') ?></th>
            <td><?= $estagiariomonografia->turmaestagio_id ?></td>
        </tr>

        <tr>
            <th scope="row"><?= __('Nota') ?></th>
            <td><?= $this->Number->format($estagiariomonografia->nota) ?></td>
        </tr>

        <tr>
            <th scope="row"><?= __('Carga horária') ?></th>
            <td><?= $this->Number->format($estagiariomonografia->ch) ?></td>
        </tr>

        <tr>
            <th scope="row"><?= __('Observações') ?></th>
            <td><?= h($estagiariomonografia->observacoes) ?></td>
        </tr>
    </table>
</div>