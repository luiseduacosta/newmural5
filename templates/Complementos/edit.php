<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Complemento $complemento
 */
$user = $this->getRequest()->getAttribute('identity');
?>

<?php echo $this->element('menu_mural') ?>

<nav class="navbar navbar-expand-lg py-2 navbar-light bg-light">
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarToggler"
        aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <ul class="navbar-nav collapse navbar-collapse" id="navbarToggler">
        <li class="nav-item">
            <?=
                $this->Form->postLink(
                    __('Excluir'),
                    ['action' => 'delete', $complemento->id],
                    ['confirm' => __('Tem certeza que quer excluir # {0}?', $complemento->id), 'class' => 'btn btn-danger']
                )
                ?>
        </li>
        <li class="nav-item">
            <?= $this->Html->link(__('Listar complemento do estágio'), ['action' => 'index'], ['class' => 'btn btn-primary']) ?>
        </li>
    </ul>
</nav>

<div class="container col-lg-8 shadow p-3 mb-5 bg-white rounded">
    <?= $this->Form->create($complemento) ?>
    <fieldset>
        <legend><?= __('Editar complemento de estágio') ?></legend>
        <?php
        echo $this->Form->control('periodo_especial');
        ?>
    </fieldset>
    <?= $this->Form->button(__('Confirma')) ?>
    <?= $this->Form->end() ?>
</div>
