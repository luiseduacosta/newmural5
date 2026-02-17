<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Areainstituicao $areainstituicao
 */
$user = $this->getRequest()->getAttribute('identity');
?>

<?php echo $this->element('menu_mural') ?>

<nav class="navbar navbar-expand-lg py-2 navbar-light bg-light" id="actions-sidebar">
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarTogglerAreainstituicoes"
        aria-controls="navbarTogglerAreainstituicoes" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <ul class="navbar-nav collapse navbar-collapse" id="navbarTogglerAreainstituicoes">
        <?php if (isset($user) && $user->categoria == '1'): ?>
            <li class="nav-item">
                <?=
                $this->Form->postLink(
                        __('Excluir'),
                        ['action' => 'delete', $areainstituicao->id],
                        ['confirm' => __('Tem certeza que deseja excluir este registo # {0}?', $areainstituicao->id), 'class' => 'btn btn-danger me-1']
                )
            ?>
            </li>
        <?php endif; ?>
        <li class="nav-item">
            <?= $this->Html->link(__('Listar área instituições'), ['controller' => 'Areainstituicoes', 'action' => 'index'], ['class' => 'btn btn-primary me-1']) ?>
        </li>
    </ul>
</nav>

<div class="container col-lg-8 shadow p-3 mb-5 bg-white rounded">
    <?= $this->Form->create($areainstituicao) ?>
    <fieldset class="border p-2">
        <legend><?= __('Editar área instituição') ?></legend>
        <?php
        echo $this->Form->control('area', ['label' =>'Área', 'class' => 'form-control']);
        ?>
    </fieldset>
    <div class="d-flex justify-content-center">
        <?= $this->Form->button(__('Confirmar'), ['class' => 'btn btn-primary']) ?>
    </div>
    <?= $this->Form->end() ?>
</div>
