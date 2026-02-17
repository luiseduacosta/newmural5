<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Areamonografia $areamonografia
 */
$user = $this->getRequest()->getAttribute('identity');
?>

<?php echo $this->element('menu_monografias') ?>

<nav class="navbar navbar-expand-lg py-2 navbar-light bg-secondary">
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarPrincipal"
            aria-controls="navbarPrincipal" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
    </button>
    <ul class="navbar-nav me-auto mb-2 mb-lg-0">
        <?php if (isset($user->categoria) && $user->categoria == '1'): ?>
            <li class="nav-item">
                <?= $this->Html->link(__('Nova área de monografia'), ['action' => 'add'], ['class' => 'btn btn-primary float-start']) ?>
            </li>
        <?php endif; ?>
    </ul>
</nav>

<?= $this->element('templates') ?>

<div class="container col-lg-8 shadow p-3 mb-5 bg-white rounded">
    <?= $this->Form->create($areamonografia) ?>
    <fieldset class="border p-2">
        <legend><?= __('Nova área de monografia') ?></legend>
        <?php
        echo $this->Form->control('area', ['label' => 'Área', 'class' => 'form-control']);
        ?>
    </fieldset>
    <div class="d-flex justify-content-center">
        <?= $this->Form->button(__('Confirmar'), ['class' => 'btn btn-primary']) ?>
    </div>
    <?= $this->Form->end() ?>
</div>