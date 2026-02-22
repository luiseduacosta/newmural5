<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Aluno $aluno
 */
?>

<?php echo $this->element('menu_mural') ?>

<div class='container col-lg-8 shadow p-3 mb-5 bg-white rounded'>
    <table class='table table-hover table-striped table-responsive'>
        <thead class='thead-light'>
            <tr>
                <th>Id</th>
                <th><?= $this->Html->link("Registro", ['controller' => 'alunos', 'action' => 'cargahoraria', '?' => ['ordem' => 'registro']]); ?>
                </th>
                <th><?= $this->Html->link("Semestres", ['controller' => 'alunos', 'action' => 'cargahoraria', '?' => ['ordem' => 'q_semestres']]); ?>
                </th>
                <th>Nível</th>
                <th>Período</th>
                <th>CH 1</th>
                <th>Nível</th>
                <th>Período</th>
                <th>CH 2</th>
                <th>Nível</th>
                <th>Período</th>
                <th>CH 3</th>
                <th>Nível</th>
                <th>Período</th>
                <th>CH 4</th>
                <th><?= $this->Html->link("Total", ['controller' => 'alunos', 'action' => 'cargahoraria', '?' => ['ordem' => 'ch_total']]); ?>
                </th>
            </tr>
        </thead>
        <?php $i = 1; ?>
        <?php foreach ($cargahorariatotal as $c_cargahorariatotal): ?>
            <tr>

                <td>
                    <?php echo $i++; ?>
                </td>

                <td>
                    <?php echo $this->Html->link($c_cargahorariatotal['registro'], '/alunos/view/' . $c_cargahorariatotal['id']); ?>
                </td>

                <td>
                    <?php echo $c_cargahorariatotal['q_semestres']; ?>
                </td>

                <?php foreach ($c_cargahorariatotal as $cada_cargahorariatotal): ?>
                    <?php // pr($cada_cargahorariatotal); ?>
                    <?php if (is_array($cada_cargahorariatotal)): ?>

                        <td>
                            <?php echo $cada_cargahorariatotal['nivel']; ?>
                        </td>

                        <td>
                            <?php echo $cada_cargahorariatotal['periodo']; ?>
                        </td>

                        <td>
                            <?php echo $cada_cargahorariatotal['ch']; ?>
                        </td>

                    <?php endif; ?>

                <?php endforeach; ?>

                <td>
                    <?php echo "Total: "; ?>
                </td>

                <td>
                    <?php echo $c_cargahorariatotal['ch_total']; ?>
                </td>
            </tr>
        <?php endforeach; ?>
    </table>
</div>