<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Turmaestagio $turmaestagio
 */
$user = $this->getRequest()->getAttribute('identity');
?>

<?= $this->element('menu_mural') ?>

<nav class="navbar navbar-expand-lg py-2 navbar-light bg-light">
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarTogglerEstagiario"
            aria-controls="navbarTogglerEstagiario" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarTogglerEstagiario">
        <ul class="navbar-nav ms-auto mt-lg-0">
            <li class="nav-item">
                <?=
                $this->Form->postLink(
                        __('Excluir'),
                        ['action' => 'delete', $turmaestagio->id],
                        ['confirm' => __('Tem certeza que deseja excluir este registo # {0}?', $turmaestagio->id), 'class' => 'btn btn-danger float-end']
                )
                ?>
            </li>
            <li class="nav-item">
                <?= $this->Html->link(__('Listar turma de estágios'), ['action' => 'index'], ['class' => 'btn btn-primary float-end']) ?>
            </li>
        </ul>
    </div>
</nav>

<?= $this->element('templates') ?>

<div class="container col-lg-8 shadow p-3 mb-5 bg-white rounded">
    <?= $this->Form->create($turmaestagio) ?>
    <fieldset>
        <legend><?= __('Editar turma de estágio') ?></legend>
        <?php
        echo $this->Form->control('area', ['label' => ['text' => 'Turma'], 'class' => 'form-control']);
        ?>
    </fieldset>
    <div class="d-flex justify-content-center">
        <?= $this->Form->button(__('Confirma', ['class' => 'btn btn-primary'])) ?>
    </div>
    <?= $this->Form->end() ?>
</div>