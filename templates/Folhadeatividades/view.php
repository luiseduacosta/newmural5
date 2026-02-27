<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Folhadeatividade $folhadeatividade
 */
$user = $this->getRequest()->getAttribute('identity');
?>

<?php echo $this->element('menu_mural') ?>

<nav class="navbar navbar-expand-lg py-2 navbar-light bg-light" id="actions-sidebar">
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarTogglerAtividades"
            aria-controls="navbarTogglerAtividades" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <ul class="navbar-nav collapse navbar-collapse" id="navbarTogglerAtividades">
        <?php if (isset($user) && ($user->categoria == '1' || $user->categoria == '2')): ?>
        <li class="nav-item">
            <?=
                $this->Form->postLink(
                    __('Excluir'),
                    ['action' => 'delete', $folhadeatividade->id],
                    ['confirm' => __('Tem certeza que quer excluir esta atividade # {0}?', $folhadeatividade->id), 'class' => 'btn btn-danger me-1']
            )
            ?>
        </li>
        <li class="nav-item">
            <?= $this->Html->link(__('Editar'), ['action' => 'edit', $folhadeatividade->id], ['class' => 'btn btn-warning me-1']) ?>
        </li>
        <?php endif; ?>
        <li class="nav-item">
            <?= $this->Html->link(__('Lista de atividades'), ['action' => 'atividade', '?' => ['estagiario_id' => $folhadeatividade->estagiario->id]], ['class' => 'btn btn-primary']) ?>
        </li>
    </ul>
</nav>        

<?= $this->element('templates') ?>

<div class="container col-lg-8 shadow p-3 mb-5 bg-white rounded">
     <dl>
        <div class='row'>
            <dt class="col-sm-3"><?= __('Estagiario') ?></dt>
            <dd class="col-sm-9"><?= $folhadeatividade->has('estagiario') ? $this->Html->link($folhadeatividade->estagiario->aluno->nome, ['controller' => 'Estagiarios', 'action' => 'view', $folhadeatividade->estagiario->id]) : '' ?></dd>
        </div>

        <div class='row'>
            <dt class="col-sm-3"><?= __('Dia') ?></dt>
            <dd class="col-sm-9"><?= h($folhadeatividade->dia) ?></dd>
        </div>

        <div class='row'>
            <dt class="col-sm-3"><?= __('Inicio') ?></dt>
            <dd class="col-sm-9"><?= h($folhadeatividade->inicio) ?></dd>
        </div>

        <div class='row'>
            <dt class="col-sm-3"><?= __('Final') ?></dt>
            <dd class="col-sm-9"><?= h($folhadeatividade->final) ?></dd>
        </div>

        <div class='row'>
            <dt class="col-sm-3"><?= __('Horario') ?></dt>
            <dd class="col-sm-9"><?= h($folhadeatividade->horario) ?></dd>
        </div>

        <div class='row'>
            <dt class="col-sm-3"><?= __('Atividade') ?></dt>
            <dd class="col-sm-9"><?= h($folhadeatividade->atividade) ?></dd>
        </div>
    </dl>
</div>