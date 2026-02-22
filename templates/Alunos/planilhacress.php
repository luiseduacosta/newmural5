<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Aluno $aluno
 */
?>

<?= $this->element('menu_mural') ?>

<script>

    $(document).ready(function () {

        var base_url = "<?= $this->Html->Url->build(['controller' => 'alunos', 'action' => 'planilhacress']); ?>";
        /* alert(base_url); */
        $("#EstudantesPeriodo").change(function () {
            var periodo = $(this).val();
            window.location = base_url + "?periodo=" + periodo;
        })
    });

</script>

<?= $this->element('templates') ?>

<div class='container'>
        <?= $this->Form->create(null, ['class' => 'form-inline']); ?>
        <div class="form-group row">
            <label class='col-sm-1 col-form-label'>Período</label>
            <div class='col-sm-2'>
                <?= $this->Form->input('periodo', ['type' => 'select', 'id' => 'EstudantesPeriodo', 'label' => ['text' => 'Período'], 'options' => $periodos, 'empty' => [$periodoselecionado => $periodoselecionado]], ['class' => 'form-control']); ?>
            </div>
        </div>
        <?= $this->Form->end(); ?>

    <table class='table table-hover table-striped table-responsive'>
        <caption style='caption-side: top;'>Escola de Serviço Social da UFRJ. Planilha de estagiários para o CRESS 7ª
            Região</caption>
        <thead class='thead-light'>
            <tr>
                <th>Aluno</th>
                <th>Instituição</th>
                <th>Endereço</th>
                <th>CEP</th>
                <th>Bairro</th>
                <th>Supervisor</th>
                <th>CRESS</th>
                <th>Professor</th>
            </tr>
        </thead>
        <?php foreach ($cress as $c_cress): ?>
            <?php // pr($c_cress); ?>
            <tr>
                <td><?php echo isset($c_cress->aluno->nome) ? $this->Html->link($c_cress->aluno->nome, '/alunos/view/' . $c_cress->aluno->id) : 'Sem informação'; ?>
                </td>
                <td><?php echo isset($c_cress->instituicao->instituicao) ? $this->Html->link($c_cress->instituicao->instituicao, '/instituicoes/view/' . $c_cress->instituicao->id) : 'Sem informação'; ?>
                </td>
                <td><?php echo $c_cress->instituicao->endereco; ?></td>
                <td><?php echo isset($c_cress->instituicao->cep) ? $c_cress->instituicao->cep : ''; ?></td>
                <td><?php echo isset($c_cress->instituicao->bairro) ? $c_cress->instituicao->bairro : ''; ?></td>
                <td><?php echo isset($c_cress->supervisor->nome) ? $c_cress->supervisor->nome : ''; ?></td>
                <td><?php echo isset($c_cress->supervisor->cress) ? $c_cress->supervisor->cress : ''; ?></td>
                <td><?php echo isset($c_cress->professor->nome) ? $c_cress->professor->nome : ''; ?></td>
            </tr>
        <?php endforeach; ?>
    </table>
</div>