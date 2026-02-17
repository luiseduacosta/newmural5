<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Tccestudante $tccestudante
 */
$user = $this->getRequest()->getAttribute('identity');
// pr($monografias)
?>

<?php echo $this->element('menu_monografias') ?>

<nav class="navbar navbar-collapse navbar-expand-lg" id="actions-sidebar">
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarTogglerTccestudantesEdit"
        aria-controls="navbarTogglerTccestudantesEdit" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <ul class="navbar-nav collapse navbar-collapse" id="navbarTogglerTceEstudantesEdit">
        <?php if (isset($user) && $user->categoria == '1'): ?>
            <li class="">
                <?=
                    $this->Form->postLink(
                        __('Excluir'),
                        ['action' => 'delete', $tccestudante->id],
                        ['confirm' => __('Tem certeza que quer excluir o registro # {0}?', $tccestudante->id), 'class' => 'btn btn-danger float-start']
                    )
                    ?>
            </li>
        <?php endif; ?>
    </ul>
</nav>

<?= $this->element('templates') ?>

<div class="container col-lg-8 shadow p-3 mb-5 bg-white rounded">
    <?= $this->Form->create($tccestudante) ?>
    <fieldset class="border p-2">
        <legend><?= __('Editar estudante autor de TCC') ?></legend>
        <div class="form-group row">
            <label class="col-form-label col-2" for="nome">Estudante</label>
            <div class="col-10">
                <input type="text" class="form-control" value="<?= $tccestudante->nome ?>" readonly>
            </div>
        </div>
        <div class="form-group row">
            <label class="col-form-label col-2" for="registro">Registro</label>
            <div class="col-10">
                <input type="text" class="form-control" value="<?= $tccestudante->registro ?>" readonly>
            </div>
        </div>
        <?php
        echo $this->Form->control('monografia_id', ['label' => 'Monografia']);
        ?>
    </fieldset>
    <div class="d-flex justify-content-center">
        <?= $this->Form->button(__('Confirmar', ['class' => 'btn btn-primary'])) ?>
    </div>
    <?= $this->Form->end() ?>
</div>