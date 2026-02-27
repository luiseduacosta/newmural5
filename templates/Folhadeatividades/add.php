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
        <li class="nav-item">
            <?= $this->Html->link(__('Listar atividades'), ['action' => 'index'], ['class' => 'btn btn-primary']) ?>
        </li>
    </ul>
</nav>

<?= $this->element('templates') ?>

<div class="container col-lg-8 shadow p-3 mb-5 bg-white rounded">
        <?= $this->Form->create($folhadeatividade) ?>
        <fieldset>
            <legend><?= __('Adicionar atividade') ?></legend>
            <?php
            echo $this->Form->control('estagiario_id', ['value' => $estagiario->id, 'options' => [$estagiario->id => $estagiario->aluno->nome], 'readonly' => true, 
            'templates' => [
                'label' => '<div class="col-sm-3"><label class="form-label">{{text}}</label></div>',
                'select' => '<div class="col-sm-9"><select name="{{name}}" class="form-control" {{attrs}}>{{content}}</select></div>',
                ]
            ]);
            echo $this->Form->control('dia', ['class' => 'form-control']);
            echo $this->Form->control('inicio', ['label' => __('Horário de início'), 'class' => 'form-control']);
            echo $this->Form->control('final', ['label' => __('Horário de finalização'), 'class' => 'form-control']);
            echo $this->Form->control('atividade', ['class' => 'form-control']);
            echo $this->Form->control('horario', ['type' => 'hidden']);
            ?>
        </fieldset>
        <div class="d-flex justify-content-center mt-3">
            <?= $this->Form->button(__('Confirmar'), ['class' => 'btn btn-primary']) ?>
        </div>
        <?= $this->Form->end() ?>
</div>
