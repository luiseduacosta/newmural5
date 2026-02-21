<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Questionario $questionario
 */
?>

<?= $this->element('menu_mural') ?>
<?= $this->element('templates') ?>

<div class="container mt-1">

    <nav class="nav navbar-expand-lg navbar-light bg-light">
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
            aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <ul class="navbar-nav collapse navbar-collapse" id="navbarSupportedContent">
            <?php if (isset($user) && $user->categoria == '1'): ?>
            <li class="nav-item">
                <?= $this->Html->link(__('Editar'), ['action' => 'edit', $questionario->id], ['class' => 'btn btn-primary me-1']) ?>
            </li>
            <li class="nav-item">
                <?= $this->Form->postLink(__('Excluir'), ['action' => 'delete', $questionario->id], ['confirm' => __('Tem certeza que deseja excluir este registo # {0}?', $questionario->id), 'class' => 'btn btn-danger me-1']) ?>
            </li>
            <li class="nav-item">
                <?= $this->Html->link(__('Novo'), ['action' => 'add'], ['class' => 'btn btn-primary me-1']) ?>
            </li>
            <?php endif; ?>
            <li class="nav-item">
                <?= $this->Html->link(__('Listar'), ['action' => 'index'], ['class' => 'btn btn-primary me-1']) ?>
            </li>
        </ul>
    </nav>

    <div class="container mt-1">
        <h3><?= h($questionario->title) ?></h3>
        <table class="table table-striped table-hover table-responsive">
            <tr>
                <th><?= __('Titulo') ?></th>
                <td><?= $this->Html->link($questionario->title, ['controller' => 'Questoes', 'action' => 'index']) ?></td>
            </tr>
            <tr>
                <th><?= __('Categoria') ?></th>
                <td><?= h($questionario->category) ?></td>
            </tr>
            <tr>
                <th><?= __('Usuário alvo') ?></th>
                <td><?= h($questionario->target_user_type) ?></td>
            </tr>
            <tr>
                <th><?= __('Id') ?></th>
                <td><?= $this->Number->format($questionario->id) ?></td>
            </tr>
            <tr>
                <th><?= __('Criado') ?></th>
                <td><?= h($questionario->created) ?></td>
            </tr>
            <tr>
                <th><?= __('Modificado') ?></th>
                <td><?= h($questionario->modified) ?></td>
            </tr>
            <tr>
                <th><?= __('Activo') ?></th>
                <td><?= $questionario->is_active ? __('Yes') : __('No'); ?></td>
            </tr>
        </table>
        <div class="container mt-1">
            <strong><?= __('Descrição') ?></strong>
            <blockquote>
                <?= $this->Text->autoParagraph(h($questionario->description)); ?>
            </blockquote>
        </div>
        <div class="container mt-1">
            <h4><?= __('Questões') ?></h4>
            <?php if (!empty($questionario->questoes)): ?>
                <div class="container mr-1">
                    <table class="table table-striped table-hover table-responsive">
                        <tr>
                            <th><?= __('Id') ?></th>
                            <th><?= __('Questionario Id') ?></th>
                            <th><?= __('Texto') ?></th>
                            <th><?= __('Tipo') ?></th>
                            <th><?= __('Opções') ?></th>
                            <th><?= __('Ordem') ?></th>
                            <th><?= __('Ações') ?></th>
                        </tr>
                        <?php foreach ($questionario->questoes as $questoes): ?>
                            <tr>
                                <td><?= h($questoes->id) ?></td>
                                <td><?= h($questoes->questionario_id) ?></td>
                                <td><?= h($questoes->text) ?></td>
                                <td><?= h($questoes->type) ?></td>
                                <td><?= h($questoes->options) ?></td>
                                <td><?= h($questoes->ordem) ?></td>
                                <td class="d-grid">
                                    <?= $this->Html->link(__('Ver'), ['controller' => 'Questoes', 'action' => 'view', $questoes->id], ['class' => 'btn btn-primary btn-sm btn-block p-1 mb-1']) ?>
                                    <?php if (isset($user) && $user->categoria == '1'): ?>
                                    <?= $this->Html->link(__('Editar'), ['controller' => 'Questoes', 'action' => 'edit', $questoes->id], ['class' => 'btn btn-primary btn-sm btn-block p-1 mb-1']) ?>
                                    <?= $this->Form->postLink(__('Excluir'), ['controller' => 'Questoes', 'action' => 'delete', $questoes->id], ['confirm' => __('Tem certeza que deseja excluir este registo # {0}?', $questoes->id), 'class' => 'btn btn-danger btn-sm btn-block p-1 mb-1']) ?>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </table>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>