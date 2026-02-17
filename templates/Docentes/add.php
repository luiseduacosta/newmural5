<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Docente $docente
 */
$user = $this->getRequest()->getAttribute('identity');
?>

<!-- jQuery Mask -->
<script>
    $(document).ready(function(){
        $('#cpf').mask('000.000.000-00');
        $('#cep').mask('00000-000');
        $('#ddd_telefone').mask('00');
        $('#ddd_celular').mask('00');
        $('#telefone').mask('0000.0000');
        $('#celular').mask('00000.0000');
    });
</script>

<?= $this->element('menu_monografias') ?>

<?= $this->element('templates') ?>

<div class="container col-lg-8 shadow p-3 mb-5 bg-white rounded">
    <?= $this->Form->create($docente) ?>
    <fieldset class="border p-2">
        <legend><?= __('Novo(a) docente') ?></legend>
        <?php
        /** Dados pessoais */
        echo $this->Form->control('nome', ['label' => 'Nome completo', 'required' => true]);
        echo $this->Form->control('cpf', ['label' => 'CPF', 'pattern' => '\d{3}\.\d{3}\.\d{3}-\d{2}', 'placeholder' => '000.000.000-00', 'keypress()','required' => true]);
        if (isset($siape)) {
            echo $this->Form->control('siape', ['value' => $siape, 'readonly', 'label' => 'SIAPE']);
        } else {
            echo $this->Form->control('siape', ['label' => 'SIAPE', 'required' => true]);
        }
        echo $this->Form->control('rg', ['label' => 'RG', 'required' => false]);
        echo $this->Form->control('orgaoexpedidor', ['label' => 'Órgão expedidor', 'required' => false]);
        echo $this->Form->control('datanascimento', ['label' => 'Data de nascimento']);
        echo $this->Form->control('localnascimento', ['label' => 'Local de nascimento']);
        echo $this->Form->control('sexo', ['options' => ['0' => 'Mulher', '1' => 'Homem', '2' => 'Não informado'], 'label' => 'Sexo', 'empty' => true]);
        /** Dados funcionais */
        echo $this->Form->control('dataingresso', ['label' => 'Data de ingresso na UFRJ/ESS', 'empty' => true]);
        echo $this->Form->control('formaingresso', ['label' => 'Forma de ingresso', 'options' => ['Concurso público' => 'Concurso público', 'Livre-docente' => 'Livre-docente', 'outro' => 'Outro']]);
        echo $this->Form->control('tipocargo', ['label' => 'Tipo de cargo', 'options' => ['efetivo' => 'Efetivo(a)', 'substituto' => 'Substituto(a)', 'temporario' => 'Temporário(a)', 'outro' => 'Outro']]);
        echo $this->Form->control('categoria', ['label' => 'Categoria', 'options' => ['auxiliar' => 'Auxiliar' , 'assistente' => 'Assistente', 'adjunto' => 'Adjuno', 'associado' => 'Associado', 'titular' => 'Titular', 'outro' => 'Outro']]);
        echo $this->Form->control('regimetrabalho', ['label' => 'Regime de trabalho', 'options' => ['20' => '20', '40' => '40', 'DE' => 'DE']]);
        echo $this->Form->control('departamento', ['label' => 'Departamento', 'options' => ['Fundamentos' => 'Fundamentos', 'Métodos e técnicas' => 'Métodos e técnicas', 'Política social' => 'Política social', 'Outro' => 'Outro']]);
        echo $this->Form->control('dataegresso', ['label' => 'Data de egresso', 'empty' => true]);
        echo $this->Form->control('motivoegresso', ['label' => 'Motivo de egresso', 'options' => ['Aposentadoria' => 'Aposentadoria', 'Demissão' => 'Demissão', 'Falecimento' => 'Falecimento', 'Outro' => 'Outro']]);
        /** Dados de contato */
        echo $this->Form->control('ddd_telefone', ['label' => 'DDD telefone']);
        echo $this->Form->control('telefone', ['label' => 'Telefone']);
        echo $this->Form->control('ddd_celular', ['label' => 'DDD celular']);
        echo $this->Form->control('celular', ['label' => 'Celular', 'required' => true]);
        if (isset($email)) {
            echo $this->Form->control('email', ['value' => $email, 'readonly', 'label' => 'E-mail']);
        } else {
            echo $this->Form->control('email', ['label' => 'E-mail', 'required' => true]);
        }
        echo $this->Form->control('homepage', ['label' => 'Homepage']);
        echo $this->Form->control('redesocial', ['label' => 'Rede social']);
        /** Dados de endereço */
        echo $this->Form->control('endereco', ['label' => 'Endereço']);
        echo $this->Form->control('bairro', ['label' => 'Bairro']);
        echo $this->Form->control('cidade', ['label' => 'Cidade']);
        echo $this->Form->control('estado', ['label' => 'Estado']);
        echo $this->Form->control('cep', ['label' => 'CEP', 'pattern' => '\d{5}-\d{3}', 'placeholder' => '00000-000', 'keypress()','required' => false]);
        echo $this->Form->control('pais', ['label' => 'País']);
        /** Dados de currículos */
        echo $this->Form->control('curriculolattes', ['label' => 'Currículo Lattes']);
        echo $this->Form->control('atualizacaolattes', ['label' => 'Atualização Lattes', 'empty' => true]);
        echo $this->Form->control('curriculosigma', ['label' => 'Currículo Sigma']);
        echo $this->Form->control('pesquisadordgp', ['label' => 'Pesquisador DGP']);
        /** Dados de graduação */
        echo $this->Form->control('formacaoprofissional', ['label' => 'Formação profissional']);
        echo $this->Form->control('graduacaoarea', ['label' => 'Área de graduação']);
        echo $this->Form->control('universidadedegraduacao', ['label' => 'Universidade de graduação']);
        echo $this->Form->control('anoformacao', ['label' => 'Ano de formação']);
        /** Dados de pós-graduação */
        echo $this->Form->control('mestradoarea', ['label' => 'Área de mestrado']);
        echo $this->Form->control('mestradouniversidade', ['label' => 'Universidade de mestrado']);
        echo $this->Form->control('mestradoanoconclusao', ['label' => 'Ano de conclusão do mestrado']);
        echo $this->Form->control('doutoradoarea', ['label' => 'Área de doutorado']);
        echo $this->Form->control('doutoradouniversidade', ['label' => 'Universidade de doutorado']);
        echo $this->Form->control('doutoradoanoconclusao', ['label' => 'Ano de conclusão do doutorado']);
        /** Outras informações */
        echo $this->Form->control('observacoes', ['label' => 'Outras informações']);
        ?>
    </fieldset>
    <?= $this->Form->button(__('Confirma')) ?>
    <?= $this->Form->end() ?>
</div>