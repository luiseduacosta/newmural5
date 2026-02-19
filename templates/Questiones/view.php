<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Questione $questione
 */
?>

<?php echo $this->element('menu_mural') ?>

<?php $this->element('templates') ?>

<div class="container mt-1">

    <nav class="nav navbar-expand-lg navbar-light bg-light">
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
            aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <ul class="navbar-nav collapse navbar-collapse" id="navbarSupportedContent">
            <li class="nav-item">
                <?= $this->Html->link(__('Editar'), ['action' => 'edit', $questione->id], ['class' => 'btn btn-primary me-1']) ?>
            </li>
            <li class="nav-item">
                <?= $this->Form->postLink(__('Excluir'), ['action' => 'delete', $questione->id], ['confirm' => __('Tem certeza que deseja excluir este registo # {0}?', $questione->id), 'class' => 'btn btn-danger me-1']) ?>
            </li>
            <li class="nav-item">
                <?= $this->Html->link(__('Listar'), ['action' => 'index'], ['class' => 'btn btn-primary me-1']) ?>
            </li>
            <li class="nav-item">
                <?= $this->Html->link(__('Nova'), ['action' => 'add'], ['class' => 'btn btn-primary me-1']) ?>
            </li>
        </ul>
    </nav>

    <div class="container mt-1">
        <h3><?= h($questione->text) ?></h3>
        <table class="table table-striped table-hover table-responsive">
            <tr>
                <th><?= __('Questionario') ?></th>
                <td><?= $questione->hasValue('questionario') ? $this->Html->link($questione->questionario->title, ['controller' => 'Questionarios', 'action' => 'view', $questione->questionario->id]) : '' ?>
                </td>
            </tr>
            <tr>
                <th><?= __('Id') ?></th>
                <td><?= $this->Number->format($questione->id) ?></td>
            </tr>
            <tr>
                <th><?= __('Text') ?></th>
                <td><?= h($questione->text) ?></td>
            </tr>
            <tr>
                <th><?= __('Tipo') ?></th>
                <td><?= h($questione->type) ?></td>
            </tr>
            <tr>
                <th><?= __('Opções') ?></th>
                <td>
                    <?php
                    if (!empty($questione->options)) {
                        $i = 0;
                        $opcoes = json_decode($questione->options, true);
                        // pr($opcoes);
                        for ($i = 0; $i <= array_key_last($opcoes); $i++):
                            if ($i === array_key_last($opcoes)):
                                echo $opcoes[$i];
                            else:
                                echo $opcoes[$i] . ', ';
                            endif;
                        endfor;
                    }
                    ?>
                </td>
            </tr>
            <tr>
                <th><?= __('Ordem') ?></th>
                <td><?= $questione->ordem === null ? '' : $this->Number->format($questione->ordem) ?></td>
            </tr>
            <tr>
                <th><?= __('Criado') ?></th>
                <td><?= $this->Time->format($questione->created, 'd-MM-Y HH:mm:ss') ?></td>
            </tr>
            <tr>
                <th><?= __('Modificado') ?></th>
                <td><?= $this->Time->format($questione->modified, 'd-MM-Y HH:mm:ss') ?></td>
            </tr>
        </table>
    </div>
</div>