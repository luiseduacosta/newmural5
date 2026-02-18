<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Estagiario[]|\Cake\Collection\CollectionInterface $estagiarios
 * @var \Cake\Datasource\PaginatorInterface $paginator
 * @var string $periodo
 * @var string $nivel
 * @var string $instituicao
 * @var string $supervisor
 * @var string $professor
 * @var string $turmaestagio
 * @var string $periodos
 * @var string $instituicoes
 * @var string $supervisores
 * @var string $professores
 * @var string $turmaestagios
 * @var \App\Model\Entity\Estagiario $estagiario
 * @var \App\Model\Entity\Aluno $aluno
 * @var \App\Model\Entity\Instituicao $instituicao
 * @var \App\Model\Entity\Supervisor $supervisor
 * @var \App\Model\Entity\Professor $professor
 * @var \App\Model\Entity\Turmaestagio $turmaestagio
 * @var \App\Model\Entity\User $user
 * @var \Cake\I18n\DateTime $now
 * @var \Cake\ORM\Query $query
 */
$user = $this->getRequest()->getAttribute('identity');
?>

<script type="text/javascript">
    $(document).ready(function () {

        var url = "<?= $this->Html->Url->build(['controller' => 'estagiarios', 'action' => 'index']); ?>";
        // alert(url);
        $("#EstagiarioPeriodo").change(function () {
            var periodo = $(this).val();
            // alert(url + '/index?periodo=');
            window.location = url + '/index?periodo=' + periodo;
        })

        $("#EstagiarioNivel").change(function () {
            var nivel = $(this).val();
            window.location = url + '/index?periodo=' + $('#EstagiarioPeriodo').val() + '&nivel=' + nivel;
        })

        $("#EstagiarioInstituicao").change(function () {
            var instituicao = $(this).val();
            window.location = url + '/index?periodo=' + $('#EstagiarioPeriodo').val() + '&instituicao=' + instituicao;
        })

        $("#EstagiarioSupervisor").change(function () {
            var supervisor = $(this).val();
            window.location = url + '/index?periodo=' + $('#EstagiarioPeriodo').val() + '&supervisor=' + supervisor;
        })

        $("#EstagiarioProfessor").change(function () {
            var professor = $(this).val();
            window.location = url + '/index?periodo=' + $('#EstagiarioPeriodo').val() + '&professor=' + professor;
        })

        $("#EstagiarioTurmaestagio").change(function () {
            var turmaestagio = $(this).val();
            window.location = url + '/index?periodo=' + $('#EstagiarioPeriodo').val() + '&turmaestagio=' + turmaestagio;
        })

    })
</script>

<?php echo $this->element('menu_mural') ?>

<?php if (isset($user) && $user->categoria == '1'): ?>
    <nav class="navbar navbar-expand-lg py-2 navbar-light bg-light" id="actions-sidebar">
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarTogglerMural"
            aria-controls="navbarTogglerMural" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <ul class="navbar-nav collapse navbar-collapse" id="navbarTogglerMural">
            <?php if (isset($user) && $user->categoria == "1"): ?>
                <li class="nav-item">
                    <?= $this->Html->link(
                        __(
                            'Novo Estagiário'
                        ),
                        ['action' => 'add'],
                        ['class' => 'btn btn-primary me-1']
                    ) ?>
                </li>
            <?php endif; ?>
            <?php if (isset($user) && ($user->categoria == "1" || $user->categoria == "2")): ?>
                <li class="nav-item">
                    <?= $this->Html->link(
                        __("Inscrição para mural"),
                        ['controller' => 'Muralinscricoes', "action" => "add"],
                        ["class" => "btn btn-primary me-1", 'aria-disabled' => 'false'],
                    ) ?>
                </li>
            <?php endif; ?>
        </ul>
    </nav>
<?php endif; ?>

<div class="d-flex justify-content-center py-1">
    <?php if (isset($user) && $user->categoria == '1'): ?>
        <p class="h3">Estagiários da ESS/UFRJ</p>
    <?php endif; ?>
</div>

<div class="row justify-content-start bg-dark p-1">

    <div class="col-sm-1">
        <?= $this->Form->create($estagiarios); ?>
        <div class="form-group row">
            <?= $this->Form->control('periodo', ['id' => 'EstagiarioPeriodo', 'type' => 'select', 'label' => false, 'options' => $periodos, 'empty' => [$periodo => $periodo], 'class' => 'form-control']); ?>
        </div>
    </div>

    <?php $niveis = ['1' => '1º', '2' => '2º', '3' => '3º', '4' => '4º', '9' => 'Não curricular']; ?>

    <div class="col-sm-1">
        <?= $this->Form->create($estagiarios); ?>
        <div class="form-group row">
            <?= $this->Form->control('nivel', ['id' => 'EstagiarioNivel', 'type' => 'select', 'label' => false, 'options' => $niveis, 'empty' => 'Nível', 'class' => 'form-control']); ?>
        </div>
    </div>

    <?php if (!empty($instituicoes)): ?>
        <div class="col-sm-2">
            <?= $this->Form->create($estagiarios); ?>
            <div class="form-group row">
                <?= $this->Form->control('instituicao_id', ['id' => 'EstagiarioInstituicao', 'type' => 'select', 'label' => false, 'options' => $instituicoes, 'empty' => 'Instituição', 'class' => 'form-control']); ?>
            </div>
        </div>
    <?php endif; ?>

    <?php if (!empty($supervisores)): ?>
        <div class="col-sm-2">
            <?= $this->Form->create($estagiarios); ?>
            <div class="form-group row">
                <?= $this->Form->control('supervisor_id', ['id' => 'EstagiarioSupervisor', 'type' => 'select', 'label' => false, 'options' => $supervisores, 'empty' => 'Supervisor(a)', 'class' => 'form-control']); ?>
            </div>
        </div>
    <?php endif; ?>

    <?php if (!empty($professores)): ?>
        <div class="col-sm-2">
            <?= $this->Form->create($estagiarios); ?>
            <div class="form-group row">
                <?= $this->Form->control('professor_id', ['id' => 'EstagiarioProfessor', 'type' => 'select', 'label' => false, 'options' => $professores, 'empty' => 'Professor(a)', 'class' => 'form-control']); ?>
            </div>
        </div>
    <?php endif; ?>

    <?php if (!empty($turmaestagios)): ?>
        <div class="col-sm-1">
            <?= $this->Form->create($estagiarios); ?>
            <div class="form-group row">
                <?= $this->Form->control('turmaestagio_id', ['id' => 'EstagiarioTurmaestagio', 'type' => 'select', 'label' => false, 'options' => $turmaestagios, 'empty' => 'Turma', 'class' => 'form-control']); ?>
            </div>
        </div>
    <?php endif; ?>

</div>

<div class="container col-lg-12 shadow p-3 mb-5 bg-white rounded">
    <table class="table table-striped table-hover table-responsive">
        <thead class="table-dark">
            <tr>
                <th><?= $this->Paginator->sort('Estagiarios.id', 'Id') ?></th>
                <th><?= $this->Paginator->sort('Alunos.nome', 'Estudante') ?></th>
                <th><?= $this->Paginator->sort('registro', ) ?></th>
                <th><?= $this->Paginator->sort('ajuste2020', 'Ajuste 2020') ?></th>
                <th><?= $this->Paginator->sort('turno', 'Turno') ?></th>
                <th><?= $this->Paginator->sort('nivel', 'Nível') ?></th>
                <th><?= $this->Paginator->sort('Instituicoes.instituicao', 'Instituição') ?></th>
                <th><?= $this->Paginator->sort('Supervisores.nome', 'Supervisor(a)') ?></th>
                <th><?= $this->Paginator->sort('Docentes.nome', 'Professor(a)') ?></th>
                <th><?= $this->Paginator->sort('periodo', 'Período') ?></th>
                <th><?= $this->Paginator->sort('Turmaestagio.area', 'Turma') ?></th>
                <?php if (isset($user) && $user->categoria == '1'): ?>
                    <th><?= $this->Paginator->sort('nota', 'Nota') ?></th>
                    <th><?= $this->Paginator->sort('ch', 'Carga horária') ?></th>
                    <th><?= __('Ações') ?></th>
                <?php endif; ?>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($estagiarios as $estagiario): ?>
                <tr>
                    <?php // pr($estagiario); ?>
                    <td><?= $this->Html->link($estagiario->id, ['controller' => 'estagiarios', 'action' => 'view', $estagiario->id]) ?>
                    </td>
                    <td><?= $estagiario->hasValue('aluno') ? $this->Html->link($estagiario->aluno['nome'], ['controller' => 'Alunos', 'action' => 'view', $estagiario->aluno_id]) : '' ?>
                    </td>
                    <td><?= $estagiario->registro ?></td>
                    <td><?= h($estagiario->ajuste2020) == 0 ? 'Não' : 'Sim' ?></td>
                    <td><?= h($estagiario->turno) ?></td>
                    <td><?= h($estagiario->nivel) ?></td>
                    <td><?= $estagiario->hasValue('instituicao') ? $this->Html->link($estagiario->instituicao['instituicao'], ['controller' => 'Instituicoes', 'action' => 'view', $estagiario->instituicao['id']]) : '' ?>
                    </td>
                    <td><?= $estagiario->hasValue('supervisor') ? $this->Html->link($estagiario->supervisor['nome'], ['controller' => 'Supervisores', 'action' => 'view', $estagiario->supervisor['id']]) : 'Sem dados' ?>
                    </td>
                    <td><?= $estagiario->hasValue('professor') ? $this->Html->link($estagiario->professor['nome'], ['controller' => 'Professores', 'action' => 'view', $estagiario->professor['id']]) : 'Sem dados' ?>
                    </td>
                    <td><?= h($estagiario->periodo) ?></td>
                    <td><?= $estagiario->hasValue('turmaestagio') ? $this->Html->link($estagiario->turmaestagio['area'], ['controller' => 'Turmaestagios', 'action' => 'view', $estagiario->turmaestagio['turmestagio_id']]) : '' ?>
                    </td>
                    <?php if (isset($user) && $user->categoria == '1'): ?>
                        <?php if (isset($estagiario->nota)): ?>
                            <td><?= $this->Number->format($estagiario->nota, ['precision' => 2]) ?></td>
                        <?php else: ?>
                            <td>Sem nota</td>
                        <?php endif; ?>
                        <?php if (isset($estagiario->ch)): ?>
                            <td><?= $this->Number->format($estagiario->ch) ?></td>
                        <?php else: ?>
                            <td>Sem dados</td>
                        <?php endif; ?>
                        <td class="d-grid">
                            <?= $this->Html->link(__('Ver'), ['action' => 'view', $estagiario->id], ['class' => 'btn btn-primary btn-sm btn-block mb-1']) ?>
                            <?php if (isset($user) && $user->categoria == 1): ?>
                                <?= $this->Html->link(__('Editar'), ['action' => 'edit', $estagiario->id], ['class' => 'btn btn-primary btn-sm btn-block mb-1']) ?>
                                <?= $this->Form->postLink(__('Excluir'), ['action' => 'delete', $estagiario->id], ['confirm' => __('Tem certeza que quer excluir o registro # {0}?', $estagiario->id), 'class' => 'btn btn-danger btn-sm btn-block mb-1']) ?>
                            <?php endif; ?>
                        </td>
                    <?php endif; ?>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <?= $this->element('paginator') ?>

</div>