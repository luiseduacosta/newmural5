<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Areamonografia $areamonografia
 */
$user = $this->getRequest()->getAttribute('identity');
?>

<?php echo $this->element('menu_monografias') ?>

<nav class="navbar navbar-expand-lg py-2 navbar-light bg-light" id="actions-sidebar">
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
        data-bs-target="#navbarTogglerAreamonografiaView" aria-controls="navbarTogglerAreamonografiaView"
        aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <ul class="navbar-nav collapse navbar-collapse" id="navbarTogglerAreamonografiaView">
        <li class="nav-item">
            <?= $this->Html->link(__('Listar'), ['controller' => 'Areamonografias', 'action' => 'index'], ['class' => 'btn btn-primary me-1']) ?>
        </li>
        <?php if (isset($user->categoria) && $user->categoria == '1'): ?>
            <li class="nav-item">
                <?= $this->Html->link(__('Editar'), ['controller' => 'Areamonografias', 'action' => 'edit', $areamonografia->id], ['class' => 'btn btn-primary me-1']) ?>
            </li>
            <li class="nav-item">
                <?= $this->Form->postLink(__('Excluir'), ['controller' => 'Areamonografias', 'action' => 'delete', $areamonografia->id], ['confirm' => __('Tem certeza que deseja excluir este registo # {0}?', $areamonografia->id), 'class' => 'btn btn-danger float-start']) ?>
            </li>
        <?php endif; ?>
    </ul>
</nav>

<?= $this->element('templates') ?>

<div class="container col-lg-8 shadow p-3 mb-5 bg-white rounded">
    <h3><?= h($areamonografia->area) ?></h3>
    <table class="table table-striped table-hover table-responsive">
        <thead class="table-light">
            <tr>
                <th scope="row"><?= __('ID') ?></th>
                <td><?= $this->Number->format($areamonografia->id) ?></td>
            </tr>
            <tr>
                <th scope="row"><?= __('Área') ?></th>
                <td><?= h($areamonografia->area) ?></td>
            </tr>
            </tbody>
    </table>
</div>

<div class="container col-lg-8 shadow p-3 mb-5 bg-white rounded">
    <h4><?= __('Monografias') ?></h4>
    <?php if (!empty($areamonografia->monografias)): ?>
        <table class="table table-striped table-hover">
            <thead class="table-dark">
                <tr>
                    <th scope="col"><?= __('Estudante') ?></th>
                    <th scope="col"><?= __('Titulo') ?></th>
                    <th scope="col"><?= __('Periodo') ?></th>
                    <th scope="col"><?= __('Orientador') ?></th>
                    <th scope="col"><?= __('Url') ?></th>                    
                </tr>
            </thead>
            <?php foreach ($areamonografia->monografias as $monografias): ?>
                <tr>
                    <?php if (isset($monografias->tccestudantes) && count($monografias->tccestudantes) > 0): ?>
                        <td>
                            <?php for ($i = 0; $i < count($monografias->tccestudantes); $i++): ?>
                                <?= $this->Html->link(h($monografias->tccestudantes[$i]->nome), ['controller' => 'tccestudantes', 'action' => 'view', $monografias->tccestudantes[$i]->id]) ?>
                            <?php endfor; ?>
                        </td>
                    <?php endif; ?>

                    <td><?= $this->Html->link(h($monografias->titulo), ['controller' => 'Monografias', 'action' => 'view', $monografias->id]) ?>
                    </td>
                    <td><?= h($monografias['periodo']) ?></td>
                    <td><?= $this->Html->link(h($monografias->docentes['nome']), ['controller' => 'Docentes', 'action' => 'view', $monografias->docentes['id']]) ?>
                    </td>
                    <td>
                        <?php
                        if (isset($monografias['url']) && !empty($monografias['url'])):
                            echo $this->Html->link(h($monografias['url']), h($monografias['url']), ['target' => '_blank']); 
                        else:
                            echo '';
                        endif;    
                        ?>          
                    </td>
                </tr>
            <?php endforeach; ?>
        </table>
    <?php endif; ?>
</div>

<div class="container col-lg-8 shadow p-3 mb-5 bg-white rounded">
    <h4><?= __('Professores da área') ?></h4>
    <?php if (!empty($areamonografia->docentes)): ?>
        <table class="table table-striped table-hover">
            <thead class="table-dark">
                <tr>
                    <th scope="col"><?= __('Docente') ?></th>
                </tr>
            </thead>
            <?php foreach ($areamonografia->docentes as $docentes): ?>
                <tr>
                    <td><?= $this->Html->link(h($docentes['nome']), ['controller' => 'Docentes', 'action' => 'view', $docentes['id']]) ?>
                    </td>
                </tr>
            <?php endforeach; ?>
        </table>
    <?php endif; ?>
</div>