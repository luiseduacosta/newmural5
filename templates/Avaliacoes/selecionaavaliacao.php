<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Avaliaco[]|\Cake\Collection\CollectionInterface $avaliacaoes
 */
$user = $this->getRequest()->getAttribute('identity');
// pr($estagiario->item->estudante);
// die();
?>

<?php echo $this->element('menu_mural') ?>

<nav class="navbar navbar-expand-lg py-2 navbar-light bg-light" id="actions-sidebar">
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarTogglerAvaliacoes"
        aria-controls="navbarTogglerAvaliacoes" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
</nav>

<h3><?= __('Estágios cursados pela(o) estudande ') ?></h3>

<div class="container col-lg-8 shadow p-3 mb-5 bg-white rounded">
    <table class="table table-striped table-responsive table-hover">
        <thead class="table-dark">
            <tr>
                <th><?= $this->Paginator->sort('id') ?></th>
                <th><?= $this->Paginator->sort('estagiario.avaliacao.id', 'Declaração') ?></th>
                <th><?= $this->Paginator->sort('estagiario->estudante->nome', 'Estudante') ?></th> 
                <th><?= $this->Paginator->sort('estagiario->periodo', 'Período') ?></th>
                <th><?= $this->Paginator->sort('estagiario->nivel', 'Nível') ?></th>
                <th><?= $this->Paginator->sort('estagiario->instituicao->instituicao', 'Instituição') ?></th>
                <th><?= $this->Paginator->sort('estagiario->supervisor->nome', 'Supervisor(a)') ?></th>
                <th><?= $this->Paginator->sort('estagiario->ch', 'Carga horária') ?></th>
                <th><?= $this->Paginator->sort('estagiario->nota', 'Nota') ?></th>
                <th><?= __('Ações') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($estagiario as $c_estagiario): ?>
                <?php // pr($c_estagiario); ?>
                <?php // die(); ?>
                <tr>
                    <td><?= isset($c_estagiario->id) ? $this->Html->link($c_estagiario->id, ['controller' => 'estagiarios', 'action' => 'view', $c_estagiario->id]) : '' ?></td>
                    <td><?= $this->Html->link('Imprime folha de avaliação', ['controller' => 'avaliacoes', 'action' => 'imprimeavaliacaopdf', $c_estagiario->id], ['class' => 'btn btn-success']) ?></td>
                    <td><?= $c_estagiario->has('estudante') ? $this->Html->link($c_estagiario->estudante->nome, ['controller' => 'estudantes', 'action' => 'view', $c_estagiario->estudante->id]) : '' ?></td>
                    <td><?= $c_estagiario->periodo ?></td>
                    <td><?= $c_estagiario->nivel ?></td>
                    <td><?= $c_estagiario->has('instituicao') ? $c_estagiario->instituicao->instituicao : '' ?></td>                        
                    <td><?= $c_estagiario->has('supervisor') ? $c_estagiario->supervisor->nome : '' ?></td>
                    <td><?= $c_estagiario->ch ?></td>
                    <td><?= $c_estagiario->nota ?></td>
                    <?php if (isset($c_estagiario->id)): ?>
                        <td>
                            <?= $this->Html->link(__('Ver'), ['action' => 'view', $c_estagiario->id]) ?>
                            <?= $this->Html->link(__('Editar'), ['action' => 'edit', $c_estagiario->id]) ?>
                            <?= $this->Form->postLink(__('Excluir'), ['action' => 'delete', $c_estagiario->id], ['confirm' => __('Tem certeza que deseja excluir a avaliação # {0}?', $c_estagiario->id)]) ?>
                        </td>
                    <?php endif; ?>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
