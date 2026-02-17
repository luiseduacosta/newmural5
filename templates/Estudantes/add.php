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
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarTogglerEstudantesAdd"
            aria-controls="navbarTogglerEstudantesAdd" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <ul class="navbar-nav collapse navbar-collapse" id="navbarTogglerEstudantesAdd">
        <?php if (isset($user->categoria) && $user->categoria == '1'): ?>
            <li class="nav-item">
                <?= $this->Html->link(__('Listar estudantes'), ['action' => 'index'], ['class' => 'btn btn-primary float-start']) ?>
            </li>
        <?php endif; ?>
    </ul>
</nav>

<?= $this->element("templates") ?>

<div class="container col-lg-8 shadow p-3 mb-5 bg-white rounded">
    <?= $this->Form->create($estudante) ?>
    <fieldset>
        <legend><?= __('Inserir estudante') ?></legend>
        <?php
        echo $this->Form->control('nome', ['label' => 'Nome', 'class' => 'form-control']);
        echo $this->Form->control('registro', ['label' => 'Registro', 'class' => 'form-control']);
        echo $this->Form->control('codigo_telefone', ['label' => 'Código de telefone', 'class' => 'form-control']);
        echo $this->Form->control('telefone', ['label' => 'Telefone', 'class' => 'form-control', 'id' => 'telefone']);
        echo $this->Form->control('codigo_celular', ['label' => 'Código de celular', 'class' => 'form-control']);
        echo $this->Form->control('celular', ['label' => 'Celular', 'class' => 'form-control', 'id' => 'celular']);
        echo $this->Form->control('email', ['label' => 'Email', 'class' => 'form-control']);
        echo $this->Form->control('cpf', ['label' => 'CPF', 'class' => 'form-control', 'keypress()', 'id' => 'cpf']);
        echo $this->Form->control('identidade', ['label' => 'Identidade', 'class' => 'form-control']);
        echo $this->Form->control('orgao', ['label' => 'Orgão', 'class' => 'form-control']);
        echo $this->Form->control('nascimento', ['label' => 'Data de nascimento', 'empty' => true, 'class' => 'form-control', 'id' => 'nascimento']);
        echo $this->Form->control('endereco', ['label' => 'Endereço', 'class' => 'form-control']);
        echo $this->Form->control('cep', ['label' => 'CEP', 'class' => 'form-control', 'keypress()', 'id' => 'cep']);
        echo $this->Form->control('municipio', ['label' => 'Município', 'class' => 'form-control']);
        echo $this->Form->control('bairro', ['label' => 'Bairro', 'class' => 'form-control']);
        echo $this->Form->control('observacoes', ['label' => 'Observações', 'class' => 'form-control']);
        ?>
    </fieldset>
    <?= $this->Form->button(__('Confirmar'), ['class' => 'btn btn-primary']) ?>
    <?= $this->Form->end() ?>
</div>