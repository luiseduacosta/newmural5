<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Aluno $aluno
 */
?>

<?= $this->element('menu_mural') ?>

<?php
$Confirma = [
    "button" => "<div class='d-flex justify-content-center'><button type ='Confirma' class= 'btn btn-danger' {{attrs}}>{{text}}</button></div>"
]
?>

<?= $this->element('templates') ?>

<div class="container col-lg-8 shadow p-3 mb-5 bg-white rounded">
    <?= $this->Form->create(null) ?>
    <fieldset class="border p-2">
        <legend><?= __('Declaração de ' . $totalperiodos . 'º' . ' período do(a) aluno(a)') ?></legend>
        <?php
        if ($aluno['periodonovo']):
            echo $this->Form->control('novoperiodo', ['label' => ['text' => 'Período de ingresso'], 'value' => $aluno['periodonovo']]);
        else:
            echo $this->Form->control('novoperiodo', ['label' => ['text' => 'Período de ingresso'], 'value' => $aluno['ingresso']]);
        endif;
        echo $this->Form->control('nome', ['value' => $aluno->nome, 'readonly']);
        echo $this->Form->control('nomesocial', ['label' => ['text' => 'Nome social'], 'value' => $aluno->nomesocial]);
        echo $this->Form->control('registro', ['label' => ['text' => 'Registro'], 'readonly', 'value' => $aluno->registro]);
        echo $this->Form->control('ingresso', ['label' => ['text' => 'Ingresso'], 'readonly', 'value' => $aluno->ingresso]);
        echo $this->Form->control('turno', ['label' => ['text' => 'Turno'], 'options' => ['diurno' => 'Diurno', 'noturno' => 'Noturno'], 'value' => $aluno->turno]);
        echo $this->Form->control('codigo_telefone', ['label' => ['text' => 'DDD'], 'value' => $aluno->codigo_telefone]);
        echo $this->Form->control('telefone', ['label' => ['text' => 'Telefone'], 'value' => $aluno->telefone]);
        echo $this->Form->control('codigo_celular', ['label' => ['text' => 'DDD'], 'value' => $aluno->codigo_celular]);
        echo $this->Form->control('celular', ['label' => ['text' => 'Celular'], 'value' => $aluno->celular]);
        echo $this->Form->control('email', ['label' => ['text' => 'E-mail'], 'value' => $aluno->email]);
        echo $this->Form->control('cpf', ['label' => ['text' => 'CPF'], 'value' => $aluno->cpf]);
        echo $this->Form->control('identidade', ['label' => ['text' => 'Carteira de identidade'], 'value' => $aluno->identidade]);
        echo $this->Form->control('orgao', ['label' => ['text' => 'Orgão emissor'], 'value' => $aluno->orgao]);
        echo $this->Form->control('nascimento', ['label' => ['text' => 'Data de nascimento'], 'value' => $this->Time->format('Y-m-d', $aluno->nascimento), 'empty' => true]);
        echo $this->Form->control('endereco', ['label' => ['text' => 'Endereço'], 'value' => $aluno->endereco]);
        echo $this->Form->control('cep', ['label' => ['text' => 'CEP'], 'value' => $aluno->cep]);
        echo $this->Form->control('municipio', ['label' => ['text' => 'Município'], 'value' => $aluno->municipio]);
        echo $this->Form->control('bairro', ['label' => ['text' => 'Bairro'], 'value' => $aluno->bairro]);
        echo $this->Form->control('observacoes', ['label' => ['text' => 'Observações'], 'value' => $aluno->observacoes]);
        ?>
    </fieldset>
    <div class="d-flex justify-content-center">
        <div class="btn-group" role="group" aria-label="Confirma">
            <?= $this->Html->link('Imprime PDF', ['action' => 'certificadoperiodopdf', '?' => ['id' => $aluno->id, 'totalperiodos' => $totalperiodos]], ['class' => 'btn btn-lg btn-primary', 'rule' => 'button']); ?>
            <?= $this->Form->button(__('Confirmar alterações'), ['type' => 'Confirma', 'class' => 'btn btn-lg btn-danger']) ?>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>