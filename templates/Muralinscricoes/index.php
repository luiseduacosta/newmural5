<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Muralinscricao[]|\Cake\Collection\CollectionInterface $muralinscricoes
 */
$user = $this->getRequest()->getAttribute('identity');
// pr($muralinscricoes);
?>

<script type="text/javascript">
    $(document).ready(function () {

        var url = "<?= $this->Html->Url->build(['controller' => 'muralinscricoes', 'action' => 'index']); ?>";
        // alert(url);
        $("#MuralinscricoesPeriodo").change(function () {
            var periodo = $(this).val();
            // alert(url + '/index/' + periodo);
            window.location = url + '/index/' + periodo;
        })

    })
</script>

<?php echo $this->element('menu_mural') ?>

<nav class="navbar navbar-expand-lg py-2 navbar-light bg-light" id="actions-sidebar">
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarTogglerMural"
        aria-controls="navbarTogglerMural" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="row">
        <?php if (isset($user) && $user->categoria == '1'): ?>
            <?= $this->Form->create($muralinscricoes, ['class' => 'form-inline']); ?>
            <?= $this->Form->input('periodo', ['id' => 'MuralinscricoesPeriodo', 'type' => 'select', 'label' => ['text' => 'Período ', 'style' => 'display: inline;'], 'options' => $periodos, 'empty' => [$periodo => $periodo], 'class' => 'form-control']); ?>
            <?= $this->Form->end(); ?>
        <?php else: ?>
            <h1 style="text-align: center;">Inscrições para seleção de estágio da ESS/UFRJ. Período: <?= $periodo; ?></h1>
        <?php endif; ?>
    </div>
</nav>

<div class="d-flex justify-content-start">
    <?= $this->Html->link(__('Nova inscrição'), ['action' => 'add'], ['class' => 'btn btn-primary float-end']) ?>
</div>

<div class="container col-lg-12 shadow p-3 mb-5 bg-white rounded">
    <h3><?= __('Inscrições para seleção de estágio') ?></h3>
    <table class="table table-striped table-hover table-responsive">
        <thead class="thead-dark">
            <tr>
                <th><?= $this->Paginator->sort('id') ?></th>
                <th><?= $this->Paginator->sort('Muralestagios.registro', 'Registro') ?></th>
                <th><?= $this->Paginator->sort('Alunos.nome', 'Aluno') ?></th>
                <th><?= $this->Paginator->sort('Muralestagios.instituicao', 'Instituição') ?></th>
                <th><?= $this->Paginator->sort('data') ?></th>
                <th><?= $this->Paginator->sort('periodo') ?></th>
                <th><?= $this->Paginator->sort('timestamp') ?></th>
                <th><?= __('Ações') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($muralinscricoes as $muralinscricao): ?>
                <tr>
                    <td><?= $muralinscricao->id ?></td>
                    <td><?= $muralinscricao->registro ?></td>
                    <td><?= $muralinscricao->has('alunos') ? $this->Html->link($muralinscricao->alunos['nome'], ['controller' => 'Alunos', 'action' => 'view', $muralinscricao->aluno_id]) : '' ?>
                    </td>
                    <td><?= $muralinscricao->has('muralestagios') ? $this->Html->link($muralinscricao->muralestagios['instituicao'], ['controller' => 'Muralestagios', 'action' => 'view', $muralinscricao->muralestagios['id']]) : '' ?>
                    </td>
                    <td><?= date('d-m-Y', strtotime(h($muralinscricao->data))) ?></td>
                    <td><?= h($muralinscricao->periodo) ?></td>
                    <td><?= h($muralinscricao->timestamp) ?></td>
                    <td>
                        <?= $this->Html->link(__('Ver'), ['action' => 'view', $muralinscricao->id]) ?>
                        <?php if (isset($user) && $user->categoria == '1'): ?>
                            <?= $this->Html->link(__('Editar'), ['action' => 'edit', $muralinscricao->id]) ?>
                            <?= $this->Form->postLink(__('Excluir'), ['action' => 'delete', $muralinscricao->id], ['confirm' => __('Tem certeza que deseja excluir este registo # {0}?', $muralinscricao->id)]) ?>
                        <?php endif; ?>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<?php $this->Paginator->setTemplates(['first' => '<li class="page-item"><a class="page-link" href="{{url}}">{{text}}</a></li>']); ?>
<?php $this->Paginator->setTemplates(['last' => '<li class="page-item"><a class="page-link" href="{{url}}">{{text}}</a></li>']); ?>

<?= $this->element('paginator') ?>