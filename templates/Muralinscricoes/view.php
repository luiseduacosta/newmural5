<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Muralinscricao $muralinscricao
 */
$user = $this->getRequest()->getAttribute('identity');
?>

<?php echo $this->element('menu_mural') ?>

<nav class="navbar navbar-expand-lg py-2 navbar-light bg-light" id="actions-sidebar">
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarTogglerMuralinscricao"
            aria-controls="navbarTogglerMuralinscricao" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <ul class="navbar-nav collapse navbar-collapse" id="navbarTogglerMuralinscricao">
        <li class="nav-item">
            <?= $this->Html->link(__('Voltar'), ['controller' => 'Alunos', 'action' => 'view', $muralinscricao->aluno_id], ['class' => 'btn btn-info me-1']) ?>
        </li>
        <li class="nav-item">
            <?= $this->Html->link(__('Listar inscrições'), ['action' => 'index'], ['class' => 'btn btn-primary me-1']) ?>
        </li>
        <?php if (isset($user) && $user->categoria == '1'): ?>
            <li class="nav-item">
                <?= $this->Html->link(__('Nova inscrição'), ['action' => 'add'], ['class' => 'btn btn-primary me-1']) ?>
            </li>
            <li class="nav-item">
                <?= $this->Html->link(__('Editar inscrição'), ['action' => 'edit', $muralinscricao->id], ['class' => 'btn btn-primary me-1']) ?>
            </li>
            <li class="nav-item">
                <?= $this->Form->postLink(__('Excluir inscrição'), ['action' => 'delete', $muralinscricao->id], ['confirm' => __('Tem certeza que deseja excluir este registo # {0}?', $muralinscricao->id), 'class' => 'btn btn-danger me-1']) ?>
            </li>
        <?php elseif (isset($user) && $user->categoria == '2'): ?>
            <li class="nav-item">
                <?= $this->Form->postLink(__('Excluir inscrição'), ['action' => 'delete', $muralinscricao->id], ['confirm' => __('Tem certeza que deseja excluir este registo # {0}?', $muralinscricao->id), 'class' => 'btn btn-danger me-1']) ?>
            </li>
        <?php endif; ?>
    </ul>
</nav>

<div class="container col-lg-12 shadow p-3 mb-5 bg-white rounded">
    <h3><?= h($muralinscricao->alunos['nome']) ?></h3>
    <table class="table table-responsive table-hover table-striped table-bordered">
        <tr>
            <th><?= __('Id') ?></th>
            <td><?= $muralinscricao->id ?></td>
        </tr>
        <tr>
            <th><?= __('Registro') ?></th>
            <td><?= $muralinscricao->registro ?></td>
        </tr>
        <tr>
            <th><?= __('Aluno(a)') ?></th>
            <td><?= $muralinscricao->has('alunos') ? $this->Html->link($muralinscricao->alunos['nome'], ['controller' => 'Alunos', 'action' => 'view', $muralinscricao->alunos['id']]) : '' ?>
            </td>
        </tr>
        <tr>
            <th><?= __('Inscrição para estagio') ?></th>
            <td><?= $muralinscricao->has('muralestagios') ? $this->Html->link($muralinscricao->muralestagios['instituicao'], ['controller' => 'Muralestagios', 'action' => 'view', $muralinscricao->muralestagios['id']]) : '' ?>
            </td>
        </tr>
        <tr>
            <th><?= __('Período') ?></th>
            <td><?= h($muralinscricao->periodo) ?></td>
        </tr>
        <tr>
            <th><?= __('Data de inscrição') ?></th>
            <td><?= h($muralinscricao->data ? $muralinscricao->data->format('d-m-Y H:i:s') : '') ?></td>
        </tr>
        <tr>
            <th><?= __('Atualização') ?></th>
            <td><?= h($muralinscricao->timestamp ? $muralinscricao->timestamp->format('d-m-Y H:i:s'): '') ?></td>
        </tr>
    </table>
</div>