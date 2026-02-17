<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Instituicao $instituicao
 */
$user = $this->getRequest()->getAttribute('identity');
?>

<!-- jQuery Mask -->
<script>
    $(document).ready(function(){
        $('#cnpj').mask('00.000.000/0000-00');
        $('#telefone').mask('(00) 00000-0000');
        $('#cep').mask('00000-000');
    });
</script>

<?= $this->element('menu_mural') ?>

<nav class="navbar navbar-expand-lg py-2 navbar-light bg-light" id="actions-sidebar">
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarTogglerInstituicoes"
            aria-controls="navbarTogglerInstituicoes" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <ul class="navbar-nav collapse navbar-collapse" id="navbarTogglerInstituicoes">
        <li class="nav-item">
            <?= $this->Html->link(__('Listar instituições'), ['action' => 'index'], ['class' => 'btn btn-primary']) ?>
        </li>
    </ul>
</nav>

<?php $this->element('templates') ?>

<div class="container col-lg-10 shadow p-3 mb-5 bg-white rounded">
    <?= $this->Form->create($instituicao) ?>
    <fieldset>
        <legend><?= __('Nova instituição') ?></legend>
        <?php
        echo $this->Form->control('instituicao', ['label' => ['text' => 'Instituição'], 'required' => true, 'class' => 'form-control']);
        echo $this->Form->control('areainstituicoes_id', ['label' => ['text' => 'Área da instituição'], 'options' => $areainstituicoes, 'empty' => true, 'class' => 'form-control']);
        echo $this->Form->control('natureza', ['label' => ['text' => 'Natureza'], 'class' => 'form-control']);
        echo $this->Form->control('cnpj', ['label' => ['text' => 'CNPJ'], 'placeholder' => '00.000.000/0000-00', 'id' => 'cnpj', 'keypress()', 'required' => true, 'class' => 'form-control']);
        echo $this->Form->control('email', ['label' => ['text' => 'Email'], 'class' => 'form-control']);
        echo $this->Form->control('url', ['label' => ['text' => 'Site'], 'class' => 'form-control']);
        echo $this->Form->control('endereco', ['label' => ['text' => 'Endereço'], 'class' => 'form-control']);
        echo $this->Form->control('bairro', ['label' => ['text' => 'Bairro'], 'class' => 'form-control']);
        echo $this->Form->control('municipio', ['label' => ['text' => 'Município'], 'class' => 'form-control']);
        echo $this->Form->control('cep', ['label' => ['text' => 'CEP'], 'id' => 'cep', 'required' => false, 'keypress()', 'class' => 'form-control']);
        echo $this->Form->control('telefone', ['label' => ['text' => 'Telefone'], 'id' => 'telefone', 'required' => true, 'keypress()', 'class' => 'form-control']);
        echo $this->Form->control('fax', ['label' => ['text' => 'Fax'], 'type' => 'hidden']);
        echo $this->Form->control('beneficio', ['label' => ['text' => 'Benefícios'], 'class' => 'form-control']);
        echo $this->Form->control('fim_de_semana', ['label' => ['text' => 'Estágio no final de semana?'], 'options' => ['0' => 'Não', '1' => 'Sim'], 'class' => 'form-control']);
        echo $this->Form->control('localInscricao', ['label' => ['text' => 'Local de inscrição'], 'placeholder' => 'Local de inscrição', 'required' => false, 'class' => 'form-control']);
        echo $this->Form->control('convenio', ['label' => ['text' => 'Convênio'], 'placeholder' => 'Número do convêncio registrado na PR4', 'required' => true, 'class' => 'form-control']);
        echo $this->Form->control('expira', ['label' => ['text' => 'Data de encerramento do convênio'], 'placeholder' => 'Data de encerramento do convênio', 'empty' => true, 'class' => 'form-control']);
        echo $this->Form->control('seguro', ['label' => ['text' => 'Seguro'], 'options' => ['0' => 'Não', '1' => 'Sim'], 'required' => true, 'class' => 'form-control']);
        echo $this->Form->control('avaliacao', ['label' => ['text' => 'Avaliação'], 'type' => 'hidden']);
        echo $this->Form->control('observacoes', ['label' => ['text' => 'Observações'], 'class' => 'form-control']);
        echo $this->Form->control('supervisores._ids', ['label' => ['text' => 'Supervisores'], 'options' => $supervisores, 'empty' => true, 'class' => 'form-control']);
        ?>
    </fieldset>
    <div class="d-flex justify-content-end">
        <?= $this->Form->button(__('Confirmar'), ['class' => 'btn btn-primary']) ?>
    </div>
    <?= $this->Form->end() ?>
</div>