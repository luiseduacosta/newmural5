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
                <?= $this->Html->link(__('Editar área instituição'), ['controller' => 'Areainstituicoes', 'action' => 'edit', $areainstituicao->id], ['class' => 'btn btn-primary me-1']) ?>
            </li>
            <li class="nav-item">
                <?= $this->Form->postLink(__('Excluir área instituição'), ['controller' => 'Areainstituicoes', 'action' => 'delete', $areainstituicao->id], ['confirm' => __('Tem certeza que deseja excluir este registo # {0}?', $areainstituicao->id), 'class' => 'btn btn-danger me-1']) ?>
            </li>
            <li class="nav-item">
                <?= $this->Html->link(__('Nova área instituição'), ['controller' => 'Areainstituicoes', 'action' => 'add'], ['class' => 'btn btn-primary me-1']) ?>
            </li>        
        <?php endif; ?>
        <li class="nav-item">
            <?= $this->Html->link(__('Listar áreas instituições'), ['controller' => 'Areainstituicoes', 'action' => 'index'], ['class' => 'btn btn-primary me-1']) ?>
        </li>
    </ul>
</nav>

<?= $this->element('templates') ?>

<div class="container col-lg-8 shadow p-3 mb-5 bg-white rounded">
    <div class="areainstituicoes view content">
        <h3><?= h($areainstituicao->area) ?></h3>
        <table class="table table-striped table-hover table-responsive">
            <tr>
                <th><?= __('ID') ?></th>
                <td><?= $this->Number->format($areainstituicao->id) ?></td>
            </tr>
            <tr>
                <th><?= __('Área') ?></th>
                <td><?= h($areainstituicao->area) ?></td>
            </tr>
        </table>
    </div>
</div>

<div class="container col-lg-8 shadow p-3 mb-5 bg-white rounded">
<?php 
if (!empty($areainstituicao->instituicoes)):
?>

<h1 class='h3'>Instituições</h1>

<?php
    foreach ($areainstituicao->instituicoes as $instituicao) {
?> 
    <table class='table table-responsive table-striper table-hover'>
        <tr>
            <td><?= $this->Html->link($instituicao->instituicao, ['controller' => 'Instituicoes', 'action' => 'view', $instituicao->id]) ?></td>
        </tr>    
    </table>
<?php
    }
endif; 
?>
</div>

