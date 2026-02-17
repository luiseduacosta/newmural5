<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Estudante $estudante
 * @var \Cake\ORM\ResultSet<\App\Model\Entity\Estudante> $estudantes
 */
$user = $this->getRequest()->getAttribute('identity');
?>

<!-- jQuery Mask -->
<script>
    $(document).ready(function() {
        $('#cpf').mask('000.000.000-00');
        $('#cep').mask('00000-000');
        $('#ddd_telefone').mask('00');
        $('#ddd_celular').mask('00');
        $('#telefone').mask('0000.0000');
        $('#celular').mask('00000.0000');
    });
</script>

<?= $this->element('menu_monografias') ?>

<nav class="navbar navbar-expand-lg py-2 navbar-light bg-light" id="actions-sidebar">
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarTogglerEstudantesEdit"
            aria-controls="navbarTogglerEstudantesEdit" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <ul class="navbar-nav collapse navbar-collapse" id="navbarTogglerEstudantesEdit">
        <?php if (isset($user->categoria) && $user->categoria == '1'): ?>
            <li class="item-link">
                <?= $this->Form->postLink(__('Excluir'), ['action' => 'delete', $estudante->id], ['confirm' => __('Tem certeza que quer excluir o registro # {0}?', $estudante->id), 'class' => 'btn btn-danger float-start']) ?>
            </li>
        <?php endif; ?>
    </ul>
</nav>

<?= $this->element("templates") ?>

<div class="container col-lg-8 shadow p-3 mb-5 bg-white rounded">
    <div class="alunos form content">
        <?= $this->Form->create($estudante) ?>
        <fieldset>
            <legend><?= __('Editar estudante') ?></legend>
            <?php
            echo $this->Form->control('nome', ['label' => 'Nome', 'class' => 'form-control']);
            echo $this->Form->control('registro', ['label' => 'Registro', 'class' => 'form-control']);
            echo $this->Form->control('codigo_telefone', ['label' => 'Código de telefone', 'class' => 'form-control']);
            echo $this->Form->control('telefone', ['id' => 'telefone', 'label' => 'Telefone', 'class' => 'form-control']);
            echo $this->Form->control('codigo_celular', ['label' => 'Código de celular', 'class' => 'form-control']);
            echo $this->Form->control('celular', ['id' => 'celular', 'label' => 'Celular', 'class' => 'form-control']);
            echo $this->Form->control('email', ['label' => 'Email', 'class' => 'form-control']);
            echo $this->Form->control('cpf', ['id' => 'cpf', 'label' => 'CPF', 'class' => 'form-control']);
            echo $this->Form->control('identidade', ['label' => 'Identidade', 'class' => 'form-control']);
            echo $this->Form->control('orgao', ['label' => 'Orgão', 'class' => 'form-control']);
            echo $this->Form->control('nascimento', ['empty' => true, 'label' => 'Data de nascimento', 'class' => 'form-control']);
            echo $this->Form->control('endereco', ['label' => 'Endereço', 'class' => 'form-control']);
            echo $this->Form->control('cep', ['id' => 'cep', 'label' => 'CEP', 'class' => 'form-control']);
            echo $this->Form->control('municipio', ['label' => 'Município', 'class' => 'form-control']);
            echo $this->Form->control('bairro', ['label' => 'Bairro', 'class' => 'form-control']);
            echo $this->Form->control('observacoes', ['label' => 'Observações', 'class' => 'form-control']);
            ?>
        </fieldset>
        <?= $this->Form->button(__('Confirmar'), ['class' => 'btn btn-primary']) ?>
        <?= $this->Form->end() ?>
    </div>
</div>