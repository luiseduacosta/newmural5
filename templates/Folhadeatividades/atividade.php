<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Folhadeatividade $folhadeatividade
 */
$user = $this->getRequest()->getAttribute('identity');
?>

<?php echo $this->element('menu_mural') ?>

<nav class="navbar navbar-expand-lg py-1 navbar-light bg-light" id="actions-sidebar">
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarTogglerAtividades"
            aria-controls="navbarTogglerAtividades" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <ul class="navbar-nav collapse navbar-collapse" id="navbarTogglerAtividades">
        <?php if (isset($user) && $user->categoria == '1'): ?>
            <li class='nav-item'>
                <?= $this->Html->link(__('Nova atividade'), ['action' => 'add', '?' => ['estagiario_id' => $folhadeatividade->id]], ['class' => 'btn btn-primary me-1']) ?>
            </li>
        <?php endif; ?>    
        <li class='nav-item'>
            <?= $this->Html->link(__('Listar atividades'), ['action' => 'atividade', '?' => ['estagiario_id' => $folhadeatividade->id]], ['class' => 'btn btn-primary me-1']) ?>
        </li>
    </ul>
</nav>

<div class="container col-lg-8 shadow p-3 mb-5 bg-white rounded">

<div class="row">
    <div class="col-lg-6">
        <dl class="row">
            <dt class="col-sm-3"><?= __('Estagiário(a)') ?></dt>
            <dd class="col-sm-9"><?= $this->Html->link($folhadeatividade->aluno->nome, ['controller' => 'Alunos', 'action' => 'view', $folhadeatividade->aluno->id]) ?></dd>
            <dt class="col-sm-3"><?= __('Nível') ?></dt>
            <dd class="col-sm-9"><?= $folhadeatividade->nivel ?></dd>
            <dt class="col-sm-3"><?= __('Período') ?></dt>
            <dd class="col-sm-9"><?= $folhadeatividade->periodo ?></dd>
            <dt class="col-sm-3"><?= __('Instituição') ?></dt>
            <dd class="col-sm-9"><?= $folhadeatividade->instituicao ? $folhadeatividade->instituicao->instituicao : '' ?></dd>
            <dt class="col-sm-3"><?= __('Supervisor') ?></dt>
            <dd class="col-sm-9"><?= $folhadeatividade->supervisor ? $folhadeatividade->supervisor->nome : '' ?></dd>
            <dt class="col-sm-3"><?= __('Professor') ?></dt>
            <dd class="col-sm-9"><?= $folhadeatividade->professor ? $folhadeatividade->professor->nome : '' ?></dd>
        </dl>
    </div>
</div>

<table class="table table-striped table-hover table-responsive">
        <thead class="table-dark">
            <tr>
                <th><?= __('Id') ?></th>
                <th><?= __('Atividade') ?></th>
                <th><?= __('Día') ?></th>
                <th><?= __('Início') ?></th>
                <th><?= __('Final') ?></th>
                <th><?= __('Horário') ?></th>
                <th><?= __('Ações') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($folhadeatividade->folhadeatividades as $c_folhadeatividade): ?>
            <tr>
                <td><?= $c_folhadeatividade->id ?></td>
                <td><?= h($c_folhadeatividade->atividade) ?></td>
                <td><?= h($c_folhadeatividade->dia) ?></td>
                <td><?= h($c_folhadeatividade->inicio) ?></td>
                <td><?= h($c_folhadeatividade->final) ?></td>
                <td><?= h($c_folhadeatividade->horario) ?></td>
                <td>
                    <div class="row">
                        <div class="col-lg-3">
                            <?= $this->Html->link(__('Ver'), ['action' => 'view', $c_folhadeatividade->id]) ?>
                        </div>
                        <?php if (isset($user) && $user->categoria == '1'): ?>

                        <div class="col-lg-3">
                            <?= $this->Html->link(__('Editar'), ['action' => 'edit', $c_folhadeatividade->id]) ?>
                        </div>                        
                        <div class="col-lg-3">
                            <?= $this->Form->postLink(__('Excluir'), ['action' => 'delete', $c_folhadeatividade->id], ['confirm' => __('Tem certeza que deseja excluir a atividade {0}?', $c_folhadeatividade->atividade)]) ?>
                        </div>
                        <?php endif; ?>
                    </div>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
