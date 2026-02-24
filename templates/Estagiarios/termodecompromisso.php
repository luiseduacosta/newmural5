<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Estagiario $estagiario
 */
if (isset($estudanteestagiario)) {
    // pr($estudanteestagiario);
} else {
    // echo "Estudante sem estágios." . "<br>";
}
if (isset($ultimoestagio)) {
    // pr($ultimoestagio);
} else {
    // echo "Estudante sem último estágio" . "<br>";
}

if (isset($estudante_semestagio)) {
    // pr($estudante_semestagio);
} else {
    // echo "Estudante estagiário." . "<br>";
}

if (isset($atualizar)) {
    // pr($atualizar);
}

if (isset($instituicao_id)) {
    // pr($instituicao_id);
}

if (isset($instituicao)) {
    // pr($instituicao);
}

if (isset($supervisores)) {
    // pr($supervisores);
}
// pr($periodo);
// die();
?>

<script type="text/javascript">
    $(document).ready(function () {

        var url = "<?= $this->Html->Url->build(['controller' => 'estagiarios', 'action' => 'termodecompromisso', '?' => ['aluno_id' => $estudante->id]]); ?>";
        /* alert(url); */
        $("#id-instituicao").change(function () {
            var instituicao = $(this).val();
            // alert(instituicao);
            // alert(url + '&instituicao_id =' + instituicao);
            window.location = url + "&instituicao_id=" + instituicao;
        })

    })
</script>

<?php echo $this->element('menu_mural'); ?>

<?= $this->element('templates') ?>

<?php
$Confirma = [
    "button" => "<div class='d-flex justify-content-center'><button type ='Confirma' class= 'btn btn-danger' {{attrs}}>{{text}}</button></div>"
]
    ?>

<div class="container">
<?php if ((isset($ultimoestagio) && $ultimoestagio) || (isset($estudante_semestagio) && $estudante_semestagio)): ?>
    <div class="row">
        <div class="container">
            <?= $this->Form->create(null, ['type' => 'post', 'url' => ['controller' => 'estagiarios', 'action' => 'termodecompromisso', '?' => ['aluno_id' => $estudante->id]]]) ?>
            <fieldset>
                <legend><?= __('Solicitação de termo de compromisso') ?></legend>
                <?php
                if (isset($atualizar)) {
                    echo $this->Form->control('id', ['value' => $ultimoestagio->id, 'type' => 'hidden', 'readonly']);
                }
                ?>
                <?php
                // Estudante estagiário
                if (isset($ultimoestagio) && $ultimoestagio): ?>
                    <fieldset>
                    <legend>Estagiário</legend>
                    <?= $this->Form->control('registro', ['value' => $ultimoestagio->estudante->registro, 'readonly']); ?>
                    <?= $this->Form->control('aluno_id', ['label' => ['text' => 'Aluno'], 'options' => [$ultimoestagio->aluno->id => $ultimoestagio->aluno->nome], 'readonly']); ?>
                    <?= $this->Form->control('ajuste2020', ['label' => ['text' => 'Ajuste 2020'], 'options' => ['0' => 'Não', '1' => 'Sim']]); ?>
                    <?= $this->Form->control('ingresso', ['label' => ['text' => 'Ingresso'], 'value' => $ultimoestagio->estudante->ingresso]); ?>
                    <?= $this->Form->control('turno', ['options' => ['D' => 'Diurno', 'N' => 'Noturno', 'I' => 'Sem informação'], 'value' => substr($ultimoestagio->estudante->turno, 0, 1)]); ?>
                    <?= $this->Form->control('nivel', ['value' => $ultimoestagio->nivel]); ?>
                    <?= $this->Form->control('periodo', ['label' => ['text' => 'Período'], 'value' => $periodo, 'readonly']); ?>
                    </fieldset>
                    // Estudante novo sem estágio
                <?php else: ?>
                    <fieldset>
                    <legend>Estudante sem estágio</legend>
                    <?= $this->Form->control('registro', ['value' => $estudante_semestagio->registro, 'readonly']); ?>
                    <?= $this->Form->control('aluno_id', ['label' => ['text' => 'Aluno'], 'value' => null, 'type' => 'hidden']); ?>
                    <?= $this->Form->control('ajuste2020', ['label' => ['text' => 'Ajuste 2020'], 'options' => ['0' => 'Não', '1' => 'Sim']]); ?>
                    <?= $this->Form->control('ingresso', ['label' => ['text' => 'Ingresso'], 'value' => $estudante_semestagio->ingresso]); ?>
                    <?= $this->Form->control('turno', ['options' => ['D' => 'Diurno', 'N' => 'Noturno', 'I' => 'Sem informação'], 'value' => substr($estudante_semestagio->turno, 0, 1)]); ?>
                    <?= $this->Form->control('nivel', ['value' => 1, 'readonly']); ?>
                    <?= $this->Form->control('periodo', ['label' => ['text' => 'Período'], 'value' => $periodo, 'readonly']); ?>
                    </fieldset>
                <?php endif; ?>
                <?= $this->Form->control('tc', ['value' => 1]); ?>
                <?= $this->Form->control('tc_solicitacao', ['value' => date('Y-m-d')]); ?>
                <?= $this->Form->control('tipo_de_estagio', ['label' => ['text' => 'Tipo de estágio'], 'options' => ['1' => 'Presencial', '2' => 'Remoto'], 'default' => '1']); ?>

                <?php 
                if (isset($instituicao_id)) {
                    echo $this->Form->control('instituicao_id', ['label' => ['text' => 'Instituição1'], 'options' => $instituicoes, 'empty' => [$instituicao_id => $instituicao->instituicao], 'required']);
                } elseif (isset($ultimoestagio->instituicao->id) && $ultimoestagio->instituicao->id) {
                    echo $this->Form->control('instituicao_id', ['label' => ['text' => 'Instituição2'], 'options' => $instituicoes, 'empty' => [$ultimoestagio->instituicao->id => $ultimoestagio->instituicao->instituicao], 'required']);
                } else {
                    echo $this->Form->control('instituicao_id', ['label' => ['text' => 'Instituição3'], 'options' => $instituicoes, 'empty' => ['Seleciona instituição de estágio'], 'required']);
                }

                if (isset($ultimoestagio->supervisor->id) && $ultimoestagio->supervisor->id):
                    if (isset($supervisoresdainstituicao) && ($supervisoresdainstituicao)) {
                        echo $this->Form->control('supervisor_id', ['label' => ['text' => 'Supervisor(a)'], 'options' => $supervisoresdainstituicao, 'value' => $ultimoestagio->supervisor->id, 'empty' => "Selecione supervisor(a)"]);
                        // echo $this->Form->control('supervisor_id', ['label' => ['text' => 'Supervisor(a)'], 'options' => $supervisores, 'empty' => [$ultimoestagio->supervisor->id => $ultimoestagio->supervisor->nome]]);
                    } else {
                        echo $this->Form->control('supervisor_id', ['label' => ['text' => 'Supervisor(a)'], 'options' => ['0' => 'Sem informação'], 'value' => $ultimoestagio->supervisor->id, 'empty' => "Selecione supervisor(a)"]);
                    }
                else:
                    if (isset($supervisoresdainstituicao)):
                        echo $this->Form->control('supervisor_id', ['label' => ['text' => 'Supervisor(a)'], 'options' => $supervisoresdainstituicao, 'empty' => "Selecione supervisor(a)"]);
                    else:
                        echo $this->Form->control('supervisor_id', ['label' => ['text' => 'Supervisor(a)'], 'options' => ['0' => 'Sem informação'], 'empty' => ['0' => 'Sem informação']]);
                    endif;
                endif;
                ?>
            </fieldset>
            <div class="d-flex justify-content-center">
                <div class="btn-group" role="group" aria-label="Confirma">
                    <?php if (isset($ultimoestagio) && $ultimoestagio->id): ?>
                        <?= $this->Html->link('Imprime PDF', ['action' => 'termodecompromissopdf', $ultimoestagio->id], ['class' => 'btn btn-lg btn-primary', 'rule' => 'button', 'style' => 'width: 200px']); ?>
                    <?php else: ?>
                        <?= $this->Html->link('Imprime PDF', ['action' => 'termodecompromissopdf'], ['class' => 'btn btn-lg btn-primary', 'rule' => 'button', 'style' => 'width: 200px']); ?>
                    <?php endif; ?>
                    <?php $this->Form->setTemplates($Confirma); ?>
                    <?= $this->Form->button(__('Confirmar alteraçoes antes de imprimir'), ['type' => 'Confirma', 'class' => 'btn btn-lg btn-danger btn-xs col-lg-3', 'style' => 'max-width:200px; word-wrap:break-word']) ?>
                    <?= $this->Form->end() ?>
                </div>
            </div>
        </div>
    </div>
<?php endif; ?>
</div>