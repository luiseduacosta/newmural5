<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Docente[]|\Cake\Collection\CollectionInterface $Professores
 */
$user = $this->getRequest()->getAttribute('identity');
?>

<?php echo $this->element('menu_monografias'); ?>

<?php if (isset($user->categoria) && $user->categoria == '1'): ?>
    <?= $this->Html->link(__('Novo docente'), ['action' => 'add'], ['class' => 'button float-right']) ?>
<?php endif; ?>

<div class="container col-lg-8 shadow p-3 mb-5 bg-white rounded">
    <h3><?= __('Professores') ?></h3>
    <p>
        <?php if (isset($user->categoria) && $user->categoria == '1'): ?>
            <?= $this->Html->link('Dados funcionais', ['controller' => 'docentemonografias', 'action' => 'index0'], ['class' => 'button float-right']) ?>
            <?= $this->Html->link('Dados pessoais', ['controller' => 'docentemonografias', 'action' => 'index1'], ['class' => 'button float-right']) ?>
            <?= $this->Html->link('Dados graduação', ['controller' => 'docentemonografias', 'action' => 'index2'], ['class' => 'button float-right']) ?>
            <?= $this->Html->link('Dados pósgraduação', ['controller' => 'docentemonografias', 'action' => 'index3'], ['class' => 'button float-right']) ?>
        <?php endif; ?>
    </p>
    <table class="table table-hover table-responsive table-striped">
        <thead class="table-dark">
            <tr>
                <th scope="col"><?= $this->Paginator->sort('nome') ?></th>
                <th scope="col"><?= $this->Paginator->sort('cpf') ?></th>
                <th scope="col"><?= $this->Paginator->sort('sexo') ?></th>
                <th scope="col"><?= $this->Paginator->sort('datanascimento', 'Nascimento') ?></th>
                <th scope="col"><?= $this->Paginator->sort('localnascimento', 'Local') ?></th>
                <th scope="col"><?= $this->Paginator->sort('telefone', 'Telefone') ?></th>
                <th scope="col"><?= $this->Paginator->sort('celular', 'Celular') ?></th>
                <th scope="col"><?= $this->Paginator->sort('email', 'E-mail') ?></th>
                <th scope="col"><?= $this->Paginator->sort('homepage', 'Site') ?></th>
                <th scope="col"><?= $this->Paginator->sort('redesocial', 'Rede social') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($docentemonografias as $docente): ?>
                <tr>
                    <td><?= $this->Html->link(h($docente->nome), ['controller' => 'docentemonografias', 'action' => 'view', $docente->id]) ?>
                    </td>
                    <td><?= h($docente->cpf) ?></td>
                    <td>
                        <?php
                        if ($docente->sexo == '1'):
                            echo "Masculino";
                        elseif ($docente->sexo == '2'):
                            echo "Feminino";
                        else:
                            echo "s/d";
                        endif;
                        ?>
                    </td>
                    <td><?= isset($docente->datanascimento) ? date('d-m-Y', strtotime($docente->datanascimento)) : '' ?>
                    </td>
                    <td><?= $docente->localnascimento ?></td>
                    <td><?= '(' . h($docente->ddd_telefone) . ')' . h($docente->telefone) ?></td>
                    <td><?= '(' . h($docente->ddd_celular) . ')' . h($docente->celular) ?></td>
                    <td><?= h($docente->email) ?></td>
                    <td><?= $docente->has('homepage') ? $this->html->link($docente->homepage, $docente->homepage) : '' ?>
                    </td>
                    <td><?= $docente->has('redesocial') ? $this->html->link($docente->redesocial, $docente->redesocial) : '' ?>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <?= $this->element('templates') ?>
    <div class="d-flex justify-content-center">
        <div class="paginator">
            <ul class="pagination">
                <?= $this->Paginator->first('<< ' . __('primeiro')) ?>
                <?= $this->Paginator->prev('< ' . __('anterior')) ?>
                <?= $this->Paginator->numbers() ?>
                <?= $this->Paginator->next(__('próximo') . ' >') ?>
                <?= $this->Paginator->last(__('último') . ' >>') ?>
            </ul>
        </div>
    </div>
</div>