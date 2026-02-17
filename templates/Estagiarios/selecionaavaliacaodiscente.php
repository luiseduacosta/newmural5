<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Avaliacao[]|\Cake\Collection\CollectionInterface $avaliacoes
 * @var \App\Model\Entity\Estagiario $estagiario
 */
$user = $this->getRequest()->getAttribute('identity');
?>

<?php echo $this->element('menu_mural'); ?>

<div class="container col-lg-8 shadow p-3 mb-5 bg-white rounded">
    <h3><?= __('Estágios cursados pela(o) estudande ') ?></h3>
    <table class="table table-striped table-hover table-responsive">
        <thead class="table-dark">
            <tr>
                <th><?= $this->Paginator->sort('id') ?></th>
                <th><?= $this->Paginator->sort('estagiario.avaliacao.id', 'Imprime avaliação') ?></th>
                <th><?= $this->Paginator->sort('estagiario->estudante->nome', 'Estudante') ?></th>
                <th><?= $this->Paginator->sort('estagiario->periodo', 'Período') ?></th>
                <th><?= $this->Paginator->sort('estagiario->nivel', 'Nível') ?></th>
                <th><?= $this->Paginator->sort('estagiario->instituicao->instituicao', 'Instituição') ?></th>
                <th><?= $this->Paginator->sort('estagiario->supervisor->nome', 'Supervisor(a)') ?></th>
                <th><?= $this->Paginator->sort('estagiario->ch', 'Carga horária') ?></th>
                <th><?= $this->Paginator->sort('estagiario->nota', 'Nota') ?></th>
                <?php if (isset($user) && $user->categoria == '1'): ?>
                    <th><?= __('Ações') ?></th>
                <?php endif; ?>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($estagiario as $c_estagiario): ?>
                <tr>
                    <?php if (isset($user) && $user->categoria == '1'): ?>
                        <td><?= isset($c_estagiario->id) ? $this->Html->link($c_estagiario->id, ['controller' => 'estagiarios', 'action' => 'view', $c_estagiario->id]) : '' ?>
                        </td>
                    <?php else: ?>
                        <td><?= isset($c_estagiario->id) ? $c_estagiario->id : '' ?></td>
                    <?php endif; ?>

                    <td><?= $this->Html->link('Imprime avaliação discente', ['controller' => 'estagiarios', 'action' => 'avaliacaodiscentepdf', $c_estagiario->id], ['class' => 'btn btn-success']) ?>
                    </td>

                    <?php if (isset($user) && $user->categoria == '1'): ?>
                        <td><?= $c_estagiario->hasValue('aluno') ? $this->Html->link($c_estagiario->estudante->nome, ['controller' => 'alunos', 'action' => 'view', $c_estagiario->aluno->id]) : '' ?>
                        </td>
                    <?php else: ?>
                        <td><?= $c_estagiario->hasValue('estudante') ? $c_estagiario->estudante->nome : '' ?></td>
                    <?php endif; ?>

                    <td><?= $c_estagiario->periodo ?></td>
                    <td><?= $c_estagiario->nivel ?></td>
                    <td><?= $c_estagiario->hasValue('instituicao') ? $c_estagiario->instituicao->instituicao : '' ?></td>
                    <td><?= $c_estagiario->hasValue('supervisor') ? $c_estagiario->supervisor->nome : '' ?></td>
                    <td><?= $c_estagiario->ch ?></td>
                    <td><?= $c_estagiario->nota ?></td>

                    <?php if (isset($user) && $user->categoria == '1'): ?>
                        <?php if (isset($c_estagiario->id)): ?>
                            <td>
                                <?= $this->Html->link(__('Ver'), ['action' => 'view', $c_estagiario->id]) ?>
                                <?= $this->Html->link(__('Editar'), ['action' => 'edit', $c_estagiario->id]) ?>
                                <?= $this->Form->postLink(__('Excluir'), ['action' => 'delete', $c_estagiario->id], ['confirm' => __('Tem certeza que quer excluir o registro # {0}?', $c_estagiario->id)]) ?>
                            </td>
                        <?php endif; ?>
                    <?php endif; ?>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>