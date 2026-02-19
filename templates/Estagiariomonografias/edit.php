<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Estagiario $estagiario
 */
$user = $this->getRequest()->getAttribute('identity');
?>

<?= $this->element('menu_monografias') ?>

<div class="container col-lg-8 shadow p-3 mb-5 bg-white rounded">
    <?= $this->Form->create($estagiariomonografia) ?>
    <fieldset class="border p-2">
        <legend><?= __('Editar estagiário') ?></legend>
        <?php
        echo $this->Form->control('aluno_id', ['options' => $alunos, 'label' => 'Estudante']);
        echo $this->Form->control('registro', ['label' => 'Registro']);
        echo $this->Form->control('turno', ['label' => 'Turno']);
        echo $this->Form->control('nivel', ['label' => 'Nível']);
        echo $this->Form->control('tc', ['label' => 'Termo de compromisso']);
        echo $this->Form->control('tc_solicitacao', ['empty' => true, 'label' => 'Solicitação de TC']);
        echo $this->Form->control('instituicao_id', ['label' => 'Instituição']);
        echo $this->Form->control('supervisor_id', ['label' => 'Supervisor']);
        echo $this->Form->control('professor_id', ['options' => $Professores, 'empty' => true, 'label' => 'Professor']);
        echo $this->Form->control('periodo', ['label' => 'Período']);
        echo $this->Form->control('turmaestagio_id', ['label' => 'Turma', 'options' => $areas, 'empty' => true]);
        echo $this->Form->control('nota', ['label' => 'Nota']);
        echo $this->Form->control('ch', ['label' => 'Carga horária']);
        echo $this->Form->control('observacoes', ['label' => 'Observações']);
        ?>
    </fieldset>
    <?= $this->Form->button(__('Confirmar'), ['class' => 'btn btn-primary']) ?>
    <?= $this->Form->end() ?>
</div>