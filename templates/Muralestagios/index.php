<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Muralestagio[]|\Cake\Collection\CollectionInterface $muralestagios
 */
?>

<script type="text/javascript">
    $(document).ready(function () {

        var url = "<?= $this->Html->Url->build(['controller' => 'muralestagios', 'action' => 'index']); ?>";
        // alert(url);
        $("#MuralestagioPeriodo").change(function () {
            var periodo = $(this).val();
            // alert(url + '/index/' + periodo);
            window.location = url + '/index?periodo=' + periodo;
        })

    })
</script>

<?php echo $this->element('menu_mural') ?>

<nav class="navbar navbar-expand-lg py-2 navbar-light bg-light" id="actions-sidebar">
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarTogglerMural"
        aria-controls="navbarTogglerMural" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <?php if (isset($user) && $user->categoria == '1'): ?>
        <ul class="navbar-nav collapse navbar-collapse" id="navbarTogglerMural">
            <li class="nav-item">
                <?= $this->Html->link(__('Novo mural'), ['action' => 'add'], ['class' => 'btn btn-primary float-right']) ?>
            </li>
        </ul>
    <?php endif; ?>
</nav>

<p class='h3' style="text-align: center;">Mural de estágios da ESS/UFRJ. Período: <?= $periodo; ?></p>

<?php if (isset($user) && $user->categoria == '1'): ?>
    <?= $this->Form->create($muralestagios); ?>
    <div class="d-flex justify-content-center">
        <div class="col-1 p-3">
            <label class="form-label" for="MuralestagioPeriodo">Período</label>
        </div>
        <div class="col-1 p-2">
            <?= $this->Form->input('periodo', ['id' => 'MuralestagioPeriodo', 'type' => 'select', 'label' => false, 'options' => $periodos, 'empty' => [$periodo => $periodo], 'class' => 'form-control']); ?>
        </div>
    </div>
    <?= $this->Form->end(); ?>
<?php endif; ?>

<?= $this->element('templates') ?>

<div class="container col-lg-10 shadow p-3 mb-5 bg-white rounded">
    <table class="table table-striped table-hover table-responsive">
        <thead class="table-dark">
            <tr>
                <?php if (isset($user) && $user->categoria == '1'): ?>
                    <th><?= __('ID') ?></th>
                <?php endif; ?>
                <th><?= $this->Paginator->sort('instituicao', 'Instituição') ?></th>
                <th><?= $this->Paginator->sort('vagas', 'Vagas') ?></th>
                <th><?= $this->Paginator->sort('beneficios', 'Benefícios') ?></th>
                <th><?= $this->Paginator->sort('final_de_semana', 'Final de semana') ?></th>
                <th><?= $this->Paginator->sort('cargaHoraria', 'Carga horária') ?></th>
                <th><?= $this->Paginator->sort('dataInscricao', 'Encerramento') ?></th>
                <th><?= $this->Paginator->sort('dataSelecao', 'Data de seleção') ?></th>
                <?php if (isset($user) && $user->categoria == '1'): ?>
                    <th><?= __('Ações') ?></th>
                <?php endif; ?>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($muralestagios as $muralestagio): ?>
                <tr>
                    <?php if (isset($user) && $user->categoria == '1'): ?>
                        <td><?= $this->Html->link($muralestagio->instituicao_id, ['controller' => 'Instituicoes', 'action' => 'view', $muralestagio->instituicao_id]) ?></td>
                    <?php endif; ?>
                    <td><?= $this->Html->link($muralestagio->instituicao, ['controller' => 'Muralestagios', 'action' => 'view', $muralestagio->id]) ?>
                    </td>
                    <td><?= $this->Number->format($muralestagio->vagas, ['pattern' => '##']) ?></td>
                    <td><?= $this->Text->autoParagraph($muralestagio->beneficios) ?></td>
                    <td><?= (h($muralestagio->final_de_semana) == 0) ? 'Não' : 'Sim' ?></td>
                    <td><?= $this->Number->format($muralestagio->cargaHoraria, ['pattern' => '##']) ?></td>
                    <td><?= isset($muralestagio->dataInscricao) ? $muralestagio->dataInscricao->i18nFormat('dd-MM-yyyy') : '' ?>
                    </td>
                    <td><?= isset($muralestagio->dataSelecao) ? $muralestagio->dataSelecao->i18nFormat('dd-MM-yyyy') : '' ?>
                    </td>
                    <?php if (isset($user) && $user->categoria == '1'): ?>
                        <td class="d-grid">
                            <?= $this->Html->link(__('Ver'), ['action' => 'view', $muralestagio->id], ['class' => 'btn btn-primary btn-sm btn-block mb-1']) ?>
                            <?= $this->Html->link(__('Editar'), ['action' => 'edit', $muralestagio->id], ['class' => 'btn btn-primary btn-sm btn-block mb-1']) ?>
                            <?= $this->Form->postLink(__('Excluir'), ['action' => 'delete', $muralestagio->id], ['confirm' => __('Tem certeza quer quer excluir este registro # {0}?', $muralestagio->id), 'class' => 'btn btn-danger btn-sm btn-block mb-1']) ?>
                        </td>
                    <?php endif; ?>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

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