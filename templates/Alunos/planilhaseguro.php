<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Aluno[]|\Cake\Collection\CollectionInterface $t_seguro
 * @var \App\Model\Entity\Aluno[]|\Cake\Collection\CollectionInterface $periodos
 * @var string $periodoselecionado
 */
?>

<?= $this->element('menu_mural') ?>

<script>
    var base_url = "<?= $this->Html->Url->build(['controller' => 'Alunos', 'action' => 'planilhaseguro']); ?>";
    /* alert(base_url); */

    $(document).ready(function () {

        $("#periodo").change(function () {
            var periodo = $(this).val();
            /* alert(periodo); */
            window.location = base_url + "?periodo=" + periodo;
        })
    });
</script>

<?= $this->element('templates') ?>

<div class="container">

    <?= $this->Form->create(null, ['url' => 'index', 'class' => 'form-inline']); ?>
    <div class="form-group row">
        <label class='col-sm-1 col-form-label'>Período</label>
        <div class='col-sm-2'>
            <?= $this->Form->input('periodo', ['id' => 'periodo', 'type' => 'select', 'label' => false, 'options' => $periodos, 'empty' => [$periodoselecionado => $periodoselecionado]], ['class' => 'form-control']); ?>
        </div>
    </div>
    <?= $this->Form->end(); ?>

    <table class='table table-striped table-hover table-responsive'>
        <thead class='thead-light'>
            <caption style='caption-side: top'>Planilha para seguro de vida dos alunos estagiários</caption>
            <tr>
                <th>Nome</th>
                <th>CPF</th>
                <th>Nascimento</th>
                <th>Sexo</th>
                <th>DRE</th>
                <th>Curso</th>
                <th>Nível</th>
                <th>Ajuste 2020</th>
                <th>Período</th>
                <th>Início</th>
                <th>Final</th>
                <th>Instituição</th>
            </tr>
        </thead>
        <?php foreach ($t_seguro as $cada_aluno): ?>
            <?php pr($cada_aluno['nascimento']);  ?>
            <?php pr(date('d/m/Y', strtotime($cada_aluno['nascimento'])));  ?>
            <?php // die(); ?>
            <tr>
                <td>
                    <?php echo $this->Html->link($cada_aluno['nome'], '/Alunos/view/' . $cada_aluno['id']); ?>
                </td>
                <td>
                    <?php echo $cada_aluno['cpf']; ?>
                </td>
                <td>
                    <?php if (empty($cada_aluno['nascimento'])): ?>
                        <?php echo "s/d"; ?>
                    <?php else: ?>
                        <?php echo date('d-m-Y', strtotime($cada_aluno['nascimento'])); ?>
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
                    <?php if ($cada_aluno['ajuste2020'] == 0): ?>
                        <?php echo "4 períodos"; ?>
                    <?php elseif ($cada_aluno['ajuste2020'] == 1): ?>
                        <?php echo "3 períodos"; ?>
                    <?php else: ?>
                        <?php echo "s/d"; ?>
                    <?php endif; ?>
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