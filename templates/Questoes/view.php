<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Questao $questao
 */
?>

<?= $this->element('menu_mural') ?>
<?= $this->element('templates') ?>

<div class="container mt-1">

    <nav class="nav navbar-expand-lg navbar-light bg-light">
        <ul class="navbar-nav collapse navbar-collapse">
            <?php if (isset($user) && $user->categoria == '1'): ?>
            <li class="nav-item">
                <?= $this->Html->link(__('Editar'), ['action' => 'edit', $questao->id], ['class' => 'btn btn-primary me-1']) ?>
            </li>
            <li class="nav-item">
                <?= $this->Form->postLink(__('Excluir'), ['action' => 'delete', $questao->id], ['confirm' => __('Tem certeza que deseja excluir este registo # {0}?', $questao->id), 'class' => 'btn btn-danger me-1']) ?>
            </li>
            <li class="nav-item">
                <?= $this->Html->link(__('Nova'), ['action' => 'add'], ['class' => 'btn btn-primary me-1']) ?>
            </li>
            <?php endif; ?>
            <li class="nav-item">
                <?= $this->Html->link(__('Listar'), ['action' => 'index'], ['class' => 'btn btn-primary me-1']) ?>
            </li>
        </ul>
    </nav>

    <div class="container mt-1">
        <h3><?= h($questao->text) ?></h3>
        <table class="table table-striped table-hover table-responsive">
            <tr>
                <th><?= __('Questionario') ?></th>
                <td><?= $questao->hasValue('questionario') ? $this->Html->link($questao->questionario->title, ['controller' => 'Questionarios', 'action' => 'view', $questao->questionario->id]) : '' ?>
                </td>
            </tr>
            <tr>
                <th><?= __('Id') ?></th>
                <td><?= $this->Number->format($questao->id) ?></td>
            </tr>
            <tr>
                <th><?= __('Text') ?></th>
                <td><?= h($questao->text) ?></td>
            </tr>
            <tr>
                <th><?= __('Tipo') ?></th>
                <td><?= h($questao->type) ?></td>
            </tr>
            <tr>
                <th><?= __('Opções') ?></th>
                <td>
                    <?php
                    if (!empty($questao->options)) {
                        $i = 0;
                        $opcoes = json_decode($questao->options, true);
                        foreach ($opcoes as $key => $opcao):
                            echo $key . " - " . $opcao . "<br>";
                        endforeach;
                    }
                    ?>
                </td>
            </tr>
            <tr>
                <th><?= __('Ordem') ?></th>
                <td><?= $questao->ordem === null ? '' : $this->Number->format($questao->ordem) ?></td>
            </tr>
            <tr>
                <th><?= __('Criado') ?></th>
                <td><?= $this->Time->format($questao->created, 'd-MM-Y HH:mm:ss') ?></td>
            </tr>
            <tr>
                <th><?= __('Modificado') ?></th>
                <td><?= $this->Time->format($questao->modified, 'd-MM-Y HH:mm:ss') ?></td>
            </tr>
        </table>
    </div>
</div>