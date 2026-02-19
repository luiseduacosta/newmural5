s<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Estudante $estudante
 * @var \Cake\ORM\ResultSet<\App\Model\Entity\Estudante> $estudantes
 */
$user = $this->getRequest()->getAttribute('identity');
?>

<script>

    $(document).ready(function () {

        var base_url = "<?= $this->Html->Url->build(['controller' => 'estudantes', 'action' => 'planilhacress']); ?>";
        /* alert(base_url); */
        $("#EstudantesPeriodo").change(function () {
            var periodo = $(this).val();
            window.location = base_url + "?periodo=" + periodo;
        })
    });

</script>

<?php echo $this->element('menu_mural') ?>

<div class="d-flex justify-content-start">
    <div class="col-auto">
        <?php echo $this->Form->create(null, ['class' => 'form-inline']); ?>
        <?php echo $this->Form->input('periodo', ['type' => 'select', 'id' => 'EstudantesPeriodo', 'label' => ['text' => 'Período'], 'options' => $periodos, 'selected' => $periodoselecionado, 'empty' => [$periodoselecionado => $periodoselecionado], 'class' => 'form-control']); ?>
        <?php echo $this->Form->end(); ?>
    </div>
</div>

<div class='container col-lg-8 shadow p-3 mb-5 bg-white rounded'>
    <table class='table table-hover table-striped table-responsive'>
        <caption style='caption-side: top;'>Escola de Serviço Social da UFRJ. Planilha de estagiários para o CRESS 7ª
            Região</caption>
        <thead class='table-dark'>
            <tr>
                <th>Estudante</th>
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
                <td><?php echo isset($c_cress->estudante->nome) ? $this->Html->link($c_cress->estudante->nome, ['controller' => 'estudantes', 'action' => 'view', $c_cress->estudante->id]) : 'Sem informação'; ?>
                </td>
                <td><?php echo isset($c_cress->instituicao->instituicao) ? $this->Html->link($c_cress->instituicao->instituicao, ['controller' => 'instituicoes', 'action' => 'view', $c_cress->instituicao->id]) : 'Sem informação'; ?>
                </td>
                <td><?php echo $c_cress->instituicao->endereco; ?></td>
                <td><?php echo isset($c_cress->instituicao->cep) ? $c_cress->instituicao->cep : ''; ?></td>
                <td><?php echo isset($c_cress->instituicao->bairro) ? $c_cress->instituicao->bairro : ''; ?>
                </td>
                <td><?php echo isset($c_cress->supervisor->nome) ? $c_cress->supervisor->nome : ''; ?></td>
                <td><?php echo isset($c_cress->supervisor->cress) ? $c_cress->supervisor->cress : ''; ?></td>
                <td><?php echo isset($c_cress->docente->nome) ? $c_cress->docente->nome : ''; ?></td>
            </tr>
        <?php endforeach; ?>
    </table>
</div>
