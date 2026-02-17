<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Estudante $estudante
 * @var \Cake\ORM\ResultSet<\App\Model\Entity\Estudante> $estudantes
 */
$user = $this->getRequest()->getAttribute('identity');
?>

<script>

    var base_url = "<?= $this->Html->Url->build(['controller' => 'Estudantes', 'action' => 'planilhaseguro']); ?>";
    /* alert(base_url); */

    $(document).ready(function () {

        $("#periodo").change(function () {
            var periodo = $(this).val();
            /* alert(periodo); */
            window.location = base_url + "?periodo=" + periodo;
        })
    });

</script>

<?php echo $this->element('menu_mural') ?>

<div class="d-flex justify-content-start">
    <div class="col-auto">
        <?php echo $this->Form->create(null, ['url' => 'index', 'class' => 'form-inline']); ?>
        <?php echo $this->Form->input('periodo', ['id' => 'periodo', 'type' => 'select', 'label' => ['text' => 'Período'], 'options' => $periodos, 'selected' => $periodoselecionado, 'empty' => [$periodoselecionado => $periodoselecionado], 'class' => 'form-control']); ?>
        <?php echo $this->Form->end(); ?>
    </div>
</div>

<div class="container col-lg-8 shadow p-3 mb-5 bg-white rounded">
    <table class='table table-hover table-striped table-responsive'>
        <thead class='thead-light'>
        <caption style='caption-side: top'>Planilha para seguro de vida dos estudantes estagiários</caption>
        <tr>
            <th>Nome</th>
            <th>CPF</th>
            <th>Nascimento</th>
            <th>Sexo</th>
            <th>DRE</th>
            <th>Curso</th>
            <th>Nível</th>
            <th>Período</th>
            <th>Início</th>
            <th>Final</th>
            <th>Instituição</th>
        </tr>
        </thead>
        <?php foreach ($t_seguro as $cada_aluno): ?>
            <?php // pr($cada_aluno);  ?>
            <?php // die(); ?>
            <tr>
                <td>
                    <?php echo $this->Html->link($cada_aluno['nome'], ['controller' => 'estudantes', 'action' => 'view', $cada_aluno['id']]); ?>
                </td>
                <td>
                    <?php echo $cada_aluno['cpf']; ?>
                </td>
                <td>
                    <?php if (empty($cada_aluno['nascimento'])): ?>
                        <?php echo "s/d"; ?>
                    <?php else: ?>
                        <?php echo $cada_aluno['nascimento']->i18nFormat('dd-MM-yyyy'); ?>
                    <?php endif; ?>
                </td>
                <td>
                    <?php echo $cada_aluno['sexo']; ?>
                </td>
                <td>
                    <?php echo $cada_aluno['registro']; ?>
                </td>
                <td>
                    <?php echo $cada_aluno['curso']; ?>
                </td>
                <td>
                    <?php echo $cada_aluno['nivel']; ?>
                </td>
                <td>
                    <?php echo $cada_aluno['periodo']; ?>
                </td>
                <td>
                    <?php echo $cada_aluno['inicio']; ?>
                </td>
                <td>
                    <?php echo $cada_aluno['final']; ?>
                </td>
                <td>
                    <?php echo $cada_aluno['instituicao']; ?>
                </td>
            </tr>
        <?php endforeach; ?>
    </table>
</div>