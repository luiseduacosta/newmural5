<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Estagiario[]|\Cake\Collection\CollectionInterface $estagiarios
 */
$user = $this->getRequest()->getAttribute('identity');
?>

<script type="text/javascript">
    $(document).ready(function () {

        var url = "<?= $this->Html->Url->build(['controller' => 'estagiarios', 'action' => 'lancanota']); ?>";
        // alert(url);
        $("#Periodo").change(function () {
            var periodo = $(this).val();
            // alert(url + '/index/' + periodo);
            window.location = url + '/index/' + periodo;
        })

    })
</script>

<?php echo $this->element('menu_mural'); ?>

<div class="row justify-content-center">
    <div class="col-auto">
        <?php if (isset($user) && $user->categoria == '1'): ?>
            <?= $this->Form->create($estagiarios, ['class' => 'form-inline']); ?>
            <?php echo $this->Form->input('periodo', ['id' => 'Periodo', 'type' => 'select', 'label' => ['text' => 'Período ', 'style' => 'display: inline;'], 'options' => $periodos, 'empty' => [$periodo => $periodo]], ['class' => 'form-control']); ?>
            <?= $this->Form->end(); ?>
        <?php else: ?>
            <h1 style="text-align: center;">Estudantes estagiários professor(a):
                <?php // echo $estagiariosestudante->nome; ?>
            </h1>
        <?php endif; ?>
    </div>
</div>

<div class="container col-lg-12 shadow p-3 mb-5 bg-white rounded">
    <h3><?= __('Estagiários') ?></h3>
    <table class="table table-striped table-hover table-responsive">
        <thead class="table-dark">
            <tr>
                <?php if (isset($user) && $user->categoria == 1): ?>
                    <th><?= $this->Paginator->sort('id') ?></th>
                <?php endif; ?>
                <th><?= $this->Paginator->sort('Alunos.nome', 'Aluno') ?></th>
                <th><?= $this->Paginator->sort('registro', 'DRE') ?></th>
                <th><?= $this->Paginator->sort('Instituicoes.instituicao', 'Instituicao') ?></th>
                <th><?= $this->Paginator->sort('Supervisores.nome', 'Supervisor') ?></th>
                <th><?= $this->Paginator->sort('periodo', 'Período') ?></th>
                <th><?= $this->Paginator->sort('nivel', 'Nível') ?></th>
                <th><?= $this->Paginator->sort('nota', 'Nota') ?></th>
                <th><?= $this->Paginator->sort('ch', 'CH') ?></th>
                <th><?= $this->Paginator->sort('folhadeatividades', 'Folha de atividades') ?></th>
                <th><?= $this->Paginator->sort('avaliacao', 'Avaliação discente') ?></th>
                <th><?= __('Ações') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($estagiarios as $estagiario): ?>
                <tr>
                    <?php if (isset($user) && $user->categoria == '1'): ?>
                        <td><?= $estagiario->id ?></td>
                    <?php endif; ?>
                    <td><?= $this->Html->link($estagiario['aluno'], ['controller' => 'Alunos', 'action' => 'view', $estagiario['aluno_id']]) ?>
                    </td>
                    <td><?= $estagiario['registro'] ?></td>
                    <td><?= $this->Html->link($estagiario['instituicao'], ['controller' => 'Instituicoes', 'action' => 'view', $estagiario['instituicao_id']]) ?>
                    </td>
                    <td><?= $this->Html->link($estagiario['supervisor'], ['controller' => 'Supervisores', 'action' => 'view', $estagiario['supervisor_id']]) ?>
                    </td>
                    <td><?= $estagiario['periodo'] ?></td>
                    <td><?= $estagiario['nivel'] ?></td>
                    <td><?= $this->Number->format($estagiario['nota'], ['precision' => 2]) ?></td>
                    <td><?= $this->Number->format($estagiario['ch']) ?></td>
                    <?php if (isset($estagiario['folha_id'])): ?>
                        <td><?= $this->Html->link('Folha de atividades', ['controller' => 'Folhadeatividades', 'action' => 'index', $estagiario['id']]) ?>
                        </td>
                    <?php else: ?>
                        <td></td>
                    <?php endif; ?>
                    <?php if (isset($estagiario['avaliacao_id'])): ?>
                        <td><?= $this->Html->link('Ver avaliação', ['controller' => 'avaliacoes', 'action' => 'view', $estagiario['avaliacao_id']]) ?>
                        </td>
                    <?php else: ?>
                        <td></td>
                    <?php endif; ?>
                    <td>
                        <?= $this->Html->link(__('Ver'), ['action' => 'view', $estagiario['id']]) ?>
                        <?php if (isset($user) && $user->categoria == '1'): ?>
                            <?= $this->Html->link(__('Editar'), ['action' => 'edit', $estagiario['id']]) ?>
                            <?= $this->Form->postLink(__('Excluir'), ['action' => 'delete', $estagiario['id']], ['confirm' => __('Tem certeza de excluir este registro # {0}?', $estagiario['id'])]) ?>
                        <?php endif; ?>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>