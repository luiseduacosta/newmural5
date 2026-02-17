<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Estagiario $estagiario
 */
$user = $this->getRequest()->getAttribute('identity');
?>

<?= $this->element('menu_monografias') ?>

<script type="text/javascript">
    $(document).ready(function () {
        $("#aluno-id").change(function () {
            var aluno_id = $(this).val();
            /* $("#registro").val(aluno_id); */
            /* alert(aluno_id); */

            $.ajax({
                type: 'post',
                url: 'registro/' + aluno_id,
                data: 'aluno_id',
                dataType: 'json',
                beforeSend: function (xhr) { // Add this line
                    xhr.setRequestHeader('X-CSRF-Token', $('[name="_csrfToken"]').val());
                }, // Add this line
                success: function (resposta) {
                    // console.log(resposta);
                    $.each(resposta, function (key, item) {
                        // console.log(item);
                        // alert(item);
                        $('#registro').val(item);
                    })
                }
            });
        });
    });
</script>

<div class="container col-lg-8 shadow p-3 mb-5 bg-white rounded">
    <?= $this->Form->create($estagiariomonografia) ?>
    <fieldset class="border p-2">
        <legend><?= __('Estagiário') ?></legend>
        <?php
        echo $this->Form->control('aluno_id', ['label' => 'Estudante', 'options' => $alunos, 'empty' => 'Seleciona estudante']);
        echo $this->Form->control('registro', ['label' => 'DRE', 'value' => $aluno->registro, 'type' => 'text', 'readonly' => true]);
        echo $this->Form->control('turno', ['label' => 'Turno', 'options' => ['D' => 'Diurno', 'N' => 'Noturno', 'I' => 'Indefinido']]);
        echo $this->Form->control('nivel', ['label' => 'Nível', 'options' => ['1' => '1º', '2' => '2º', '3' => '3º', '4' => '4º', '9' => 'Não curricular']]);
        echo $this->Form->control('tc', ['label' => 'Termo de compromisso', 'options' => ['0' => 'Sem TC', '1' => 'Com TC']]);
        echo $this->Form->control('tc_solicitacao', ['label' => 'Solicitação de TC', 'empty' => true, 'type' => 'date', 'value' => $now->i18nFormat('dd-MM-yyyy'), 'readonly' => true]);
        echo $this->Form->control('instituicao_id', ['label' => 'Instituição', 'empty' => ['' => 'Selecione uma instituição'], 'options' => $instituicoes, 'onchange' => 'getsupervisores(this.value)']);
        echo $this->Form->control('supervisor_id', ['label' => 'Supervisor', 'options' => $supervisores, 'empty' => true]);
        echo $this->Form->control('professor_id', ['label' => 'Professor', 'options' => $professores, 'empty' => true]);
        echo $this->Form->control('periodo', ['label' => 'Período', 'value' => $periodo->mural_periodo_atual]);
        echo $this->Form->control('turmaestagio_id', ['label' => 'Turma', 'options' => $turmaestagios, 'empty' => true]);
        echo $this->Form->control('nota', ['label' => 'Nota', 'value' => '', 'readonly' => true]);
        echo $this->Form->control('ch', ['label' => 'Carga horária', 'value' => '', 'readonly' => true]);
        echo $this->Form->control('observacoes', ['type' => 'textarea', 'rows' => '3', 'cols' => '40', 'label' => 'Observações', 'value' => '']);
        ?>
    </fieldset>
    <?= $this->Form->button(__('Confirmar'), ['class' => 'btn btn-primary']) ?>
    <?= $this->Form->end() ?>
</div>