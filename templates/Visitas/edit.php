<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Visita $visita
 */
$user = $this->getRequest()->getAttribute('identity');
?>

<?php echo $this->element('menu_mural') ?>

<nav class="navbar navbar-expand-lg py-2 navbar-light bg-light" id="actions-sidebar">
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarTogglerVisitas"
        aria-controls="navbarTogglerVisitas" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <ul class="navbar-nav collapse navbar-collapse" id="navbarTogglerVisitas">
        <?php if (isset($user) && $user->categoria == '1'): ?>
            <li class="nav-item">
            <?=
            $this->Form->postLink(
                __('Excluir'),
                ['action' => 'delete', $visita->id],
                ['confirm' => __('Tem certeza que deseja excluir este registo # {0}?', $visita->id), 'class' => 'btn btn-danger me-1']
            )
            ?>
            </li>
        <?php endif; ?>
        <li>
            <?= $this->Html->link(__('Listar visitas'), ['action' => 'index'], ['class' => 'btn btn-primary']) ?>
        </li>
    </ul>
</nav>

<?php $this->element("templates"); ?>

<div class="container col-lg-8 shadow p-3 mb-5 bg-white rounded">
        <?= $this->Form->create($visita) ?>
        <fieldset>
            <legend><?= __('Editar visita') ?></legend>
            <?php
            echo $this->Form->control('instituicao_id', ['options' => $instituicoes]);
            echo $this->Form->control('data', ['label' => ['text' => 'Data'], 'class' => 'form-control']);
            echo $this->Form->control('motivo', ['label' => ['text' => 'Motivo'], 'class' => 'form-control']);
            echo $this->Form->control('responsavel', ['label' => ['text' => 'Responsável'], 'class' => 'form-control']);
            echo $this->Form->control('descricao', ['label' => ['text' => 'Descrição'], 'class' => 'form-control']);
            echo $this->Form->control('avaliacao', ['label' => ['text' => 'Avaliação'], 'class' => 'form-control']);
            ?>
        </fieldset>
        <div class="d-flex justify-content-center">
            <?= $this->Form->button(__('Confirmar'), ['class' => 'btn btn-primary mt-1']) ?>
        </div>
        <?= $this->Form->end() ?>
</div>
