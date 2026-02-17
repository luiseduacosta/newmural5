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

<nav class="navbar navbar-expand-lg py-2 navbar-light bg-light" id="actions-sidebar">
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarTogglerDocentesEdit"
            aria-controls="navbarTogglerDocentesEdit" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <ul class="navbar-nav collapse navbar-collapse" id="navbarTogglerDocentesEdit">
        <?php if (isset($user->categoria) && $user->categoria == '1'): ?>
            <li class="nav-item">
                <?=
                $this->Form->postLink(
                        __('Excluir'),
                        ['action' => 'delete', $docente->id],
                        ['confirm' => __('Tem certeza que quer excluir o registro # {0}?', $docente->id), 'class' => 'btn btn-danger float-start'],
                )
                ?>
            </li>
        <?php endif; ?>
    </ul>
</nav>

<?= $this->element('templates') ?>

<div class="container col-lg-8 shadow p-3 mb-5 bg-white rounded">
    <?= $this->Form->create($docente) ?>
    <fieldset class="border p-2">
        <legend><?= __('Editar docente') ?></legend>
        <?php
        /** Dados pessoais */
        echo $this->Form->control('nome', ['label' => ['text' => 'Nome completo']]);
        echo $this->Form->control('cpf', ['label' => ['text' => 'CPF'], 'pattern' => '\d{3}\.\d{3}\.\d{3}-\d{2}', 'placeholder' => '000.000.000-00', 'keypress()','required' => true]);
        echo $this->Form->control('rg', ['label' => ['text' => 'RG']]);
        echo $this->Form->control('orgaoexpedidor', ['label' => ['text' => 'Órgão expedidor']]);
        echo $this->Form->control('siape', ['label' => ['text' => 'SIAPE']]);
        echo $this->Form->control('datanascimento', ['label' => ['text' => 'Data de nascimento'], 'empty' => true]);
        echo $this->Form->control('localnascimento', ['label' => ['text' => 'Local de nascimento']]);
        echo $this->Form->control('sexo', ['options' => ['0' => 'Mulher', '1' => 'Homem', '2' => 'Não informa'], 'empty' => true, 'label' => ['text' => 'Sexo']]);
        /** Dados funcionais */
        echo $this->Form->control('dataingresso', ['label' => ['text' => 'Data de ingresso na ESS'], 'empty' => true]);
        echo $this->Form->control('formaingresso', ['label' => ['text' => 'Forma de ingresso'], 'options' => ['Concurso público' => 'Concurso público', 'Livre-docente' => 'Livre-docente', 'outro' => 'Outro']]);
        echo $this->Form->control('tipocargo', ['label' => ['text' => 'Tipo de cargo'], 'options' => ['efetivo' => 'Efetivo', 'substituto' => 'Substituto', 'temporario' => 'Temporário', 'outro' => 'Outro']]);
        echo $this->Form->control('categoria', ['label' => ['text' => 'Categoria'], 'options' => ['auxiliar' => 'Auxiliar', 'assistente' => 'Assistente', 'adjunto' => 'Adjunto', 'associado' => 'Associado', 'titular' => 'Titular', 'outro' => 'Outro']]);
        echo $this->Form->control('regimetrabalho', ['label' => ['text' => 'Regime de trabalho'], 'options' => ['20' => '20', '40' => '40', 'DE' => 'DE']]);
        echo $this->Form->control('departamento', ['label' => ['text' => 'Departamento'], 'options' => ['Fundamentos' => 'Fundamentos', 'Métodos e técnicas' => 'Métodos e técnicas', 'Política social' => 'Política social', 'Outro' => 'Outro']]);
        echo $this->Form->control('dataegresso', ['label' => ['text' => 'Data de egresso'], 'empty' => true]);
        echo $this->Form->control('motivoegresso', ['label' => ['text' => 'Motivo de egresso'], 'options' => ['Aposentadoria' => 'Aposentadoria', 'Demissão' => 'Demissão', 'Falecimento' => 'Falecimento', 'Outro' => 'Outro']]);
        /** Dados de contato */
        echo $this->Form->control('ddd_telefone', ['label' => ['text' => 'DDD do Telefone']]);
        echo $this->Form->control('telefone', ['label' => ['text' => 'Telefone']]);
        echo $this->Form->control('ddd_celular', ['label' => ['text' => 'DDD do Celular']]);
        echo $this->Form->control('celular', ['label' => ['text' => 'Celular']]);
        echo $this->Form->control('email', ['label' => ['text' => 'E-mail']]);
        echo $this->Form->control('homepage', ['label' => ['text' => 'Homepage']]);
        echo $this->Form->control('redesocial', ['label' => ['text' => 'Rede social']]);
        /** Dados de endereço */
        echo $this->Form->control('endereco', ['label' => ['text' => 'Endereço']]);
        echo $this->Form->control('bairro', ['label' => ['text' => 'Bairro']]);
        echo $this->Form->control('cidade', ['label' => ['text' => 'Cidade']]);
        echo $this->Form->control('estado', ['label' => ['text' => 'Estado']]);
        echo $this->Form->control('cep', ['label' => ['text' => 'CEP'], 'pattern' => '\d{5}-\d{3}', 'placeholder' => '00000-000', 'keypress()','required' => false]);
        echo $this->Form->control('pais', ['label' => ['text' => 'País']]);
        /** Dados de currículos */
        echo $this->Form->control('curriculolattes', ['label' => ['text' => 'Currículo Lattes']]);
        echo $this->Form->control('atualizacaolattes', ['label' => 'Atualização do Lattes', 'empty' => true]);
        echo $this->Form->control('curriculosigma', ['label' => ['text' => 'Currículo Sigma']]);
        echo $this->Form->control('pesquisadordgp', ['label' => ['text' => 'Pesquisador DGP']]);
        /** Dados de graduação */
        echo $this->Form->control('formacaoprofissional', ['label' => ['text' => 'Formação profissional']]);
        echo $this->Form->control('graduacaoarea', ['label' => ['text' => 'Área de graduação']]);
        echo $this->Form->control('universidadedegraduacao', ['label' => ['text' => 'Universidade de graduação']]);
        echo $this->Form->control('anoformacao', ['label' => ['text' => 'Ano de formação']]);
        /** Dados de pós-graduação */
        echo $this->Form->control('mestradoarea', ['label' => ['text' => 'Área de mestrado']]);
        echo $this->Form->control('mestradouniversidade', ['label' => ['text' => 'Universidade de mestrado']]);
        echo $this->Form->control('mestradoanoconclusao', ['label' => ['text' => 'Ano de conclusão do mestrado']]);
        echo $this->Form->control('doutoradoarea', ['label' => ['text' => 'Área de doutorado']]);
        echo $this->Form->control('doutoradouniversidade', ['label' => ['text' => 'Universidade de doutorado']]);
        echo $this->Form->control('doutoradoanoconclusao', ['label' => ['text' => 'Ano de conclusão do doutorado']]);
        /** Observações */
        echo $this->Form->control('observacoes', ['label' => ['text' => 'Outras informações']]);
        ?>
    </fieldset>
    <?= $this->Form->button(__('Confirma'), ['class' => 'btn btn-primary']) ?>
    <?= $this->Form->end() ?>
</div>
