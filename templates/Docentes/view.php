<?php
/**
 * @var \App\View\AppView $this 
 * @var \App\Model\Entity\Docente $docente 
 */
?>

<?= $this->element('menu_monografias') ?>

<nav class="navbar navbar-expand-lg py-2 navbar-light bg-light" id="actions-sidebar">
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarTogglerDocentesView"
            aria-controls="navbarTogglerDocentesView" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <ul class="navbar-nav collapse navbar-collapse" id="navbarTogglerDocentesView">
    <li class="item-link">
            <?= $this->Html->link(__('Listar'), ['action' => 'index'], ['class' => 'btn btn-primary me-1']) ?>
        </li>
    <?php if (isset($user) && $user->categoria == '1'): ?>
            <li class="item-link">
                <?= $this->Html->link(__('Editar docente'), ['action' => 'edit', $docente->id], ['class' => 'btn btn-primary me-1']) ?>
            </li>
            <li class="item-link">
                <?= $this->Form->postLink(__('Excluir docente'), ['action' => 'delete', $docente->id], ['confirm' => __('Tem certeza que quer exclir este registro # {0}?', $docente->id), 'class' => 'btn btn-danger']) ?>
            </li>
        <?php endif; ?>
    </ul>
</nav>

<div class="container col-lg-8 shadow p-3 mb-5 bg-white rounded">
    <h3 class="text-center"><?= h($docente->nome) ?></h3>
    <?php if (isset($user->categoria) && $user->categoria == '1'): ?>
        <dl class="row">

            <dt class="col-sm-5 h3">Dados pessoais</dt>
            <dd></dd>

            <dt class="col-sm-3"><?= __('Nome') ?></dt>
            <dd class="col-sm-9"><?= h($docente->nome) ?></dd>

            <dt class="col-sm-3"><?= __('CPF') ?></dt>
            <dd class="col-sm-9"><?= $docente->cpf ? h($docente->cpf) : 's/d' ?></dd>

            <dt class="col-sm-3"><?= __('Sexo') ?></dt>
            <dd class="col-sm-9">
                <?php 
                if ($docente->sexo == '0') {
                    echo 'Feminino';
                } elseif ($docente->sexo == '1') {
                    echo 'Masculino';
                } elseif ($docente->sexo == '2') {
                    echo 'Não informado';
                }
                ?>
            </dd>

            <dt class="col-sm-3"><?= __('Data de nascimento') ?></dt>
            <dd class="col-sm-9"><?= $docente->datanascimento ? $docente->datanascimento->i18nFormat('dd-MM-yyyy') : 's/d' ?></dd>

            <dt class="col-sm-3"><?= __('Local de nascimento') ?></dt>
            <dd class="col-sm-9"><?= h($docente->localnascimento) ?></dd>
        </dl>

        <dl class="row">
            <dt class="col-sm-5 h3">Dados de contato</dt>
            <dd></dd>

            <dt class="col-sm-3"><?= __('Telefone') ?></dt>
            <dd class="col-sm-9"><?= $docente->ddd_telefone ? h('(' . h($docente->ddd_telefone) . ')' . h($docente->telefone)) : 's/d' ?></dd>

            <dt class="col-sm-3"><?= __('Celular') ?></dt>
            <dd class="col-sm-9"><?= $docente->ddd_celular ? h('(' . h($docente->ddd_celular) . ')' . h($docente->celular)) : 's/d' ?></dd>

            <dt class="col-sm-3"><?= __('E-mail') ?></dt>
            <dd class="col-sm-9"><?= $docente->email ? $this->Html->link($docente->email, 'mailto:' . $docente->email) : 's/d' ?></dd>

            <dt class="col-sm-3"><?= __('Site') ?></dt>
            <dd class="col-sm-9"><?= $docente->has('homepage') ? $this->Html->link($docente->homepage, $docente->homepage) : '' ?></dd>

            <dt class="col-sm-3"><?= __('Rede social') ?></dt>
            <dd class="col-sm-9"><?= $docente->has('redesocial') ? $this->Html->link($docente->redesocial, $docente->redesocial) : '' ?></dd>

        </dl>

        <dl class="row">
            <dt class="col-sm-5 h3">Currículos</dt>
            <dd></dd>

            <dt class="col-sm-3"><?= __('Curriculo lattes') ?></dt>
            <dd class="col-sm-9"><?= $docente->curriculolattes ? $this->Html->link($docente->curriculolattes, 'http://lattes.cnpq.br/' . $docente->curriculolattes, ['target' => '_blanck', 'full' => true]) : 's/d' ?></dd>

            <dt class="col-sm-3"><?= __('Atualização lattes') ?></dt>
            <dd class="col-sm-9"><?= $docente->atualizacaolattes ? $docente->atualizacaolattes->i18nFormat('dd-MM-yyyy') : 's/d' ?></dd>

            <dt class="col-sm-3"><?= __('Curriculo Sigma') ?></dt>
            <dd class="col-sm-9"><?= $docente->curriculosigma ? $this->Html->link($docente->curriculosigma, $docente->curriculosigma) : 's/d' ?></dd>

            <dt class="col-sm-3"><?= __('Diretório de Grupos de Pesquisa') ?></dt>
            <dd class="col-sm-9"><a href='http://dgp.cnpq.br/dgp/espelhogrupo/<?= $docente->pesquisadordgp ?>'>Grupo de pesquisa</a></dd>
        </dl>

        <dl class="row">
            <dt class="col-sm-5 h3">Graduação</dt>
            <dd></dd>

            <dt class="col-sm-3"><?= __('Formação profissional') ?></dt>
            <dd class="col-sm-9"><?= h($docente->formacaoprofissional) ?></dd>

            <dt class="col-sm-3"><?= __('Universidade de graduação') ?></dt>
            <dd class="col-sm-9"><?= h($docente->universidadedegraduacao) ?></dd>

            <dt class="col-sm-3"><?= __('Ano formação') ?></dt>
            <dd class="col-sm-9"><?= h($docente->anoformacao) ?></dd>
        </dl>

        <dl class="row">
            <dt class="col-sm-5 h3">Pós-graduação</dt>
            <dd></dd>

            <dt class="col-sm-3"><?= __('Mestrado área') ?></dt>
            <dd class="col-sm-9"><?= h($docente->mestradoarea) ?></dd>

            <dt class="col-sm-3"><?= __('Universidade de mestrado') ?></dt>
            <dd class="col-sm-9"><?= h($docente->mestradouniversidade) ?></dd>

            <dt class="col-sm-3"><?= __('Ano de conclusão do mestrado') ?></dt>
            <dd class="col-sm-9"><?= $this->Number->format($docente->mestradoanoconclusao) ?></dd>

            <dt class="col-sm-3"><?= __('Área de doutorado') ?></dt>
            <dd class="col-sm-9"><?= h($docente->doutoradoarea) ?></dd>

            <dt class="col-sm-3"><?= __('Universidade de doutorado') ?></dt>
            <dd class="col-sm-9"><?= h($docente->doutoradouniversidade) ?></dd>

            <dt class="col-sm-3"><?= __('Ano de conclusão do doutorado') ?></dt>
            <dd class="col-sm-9"><?= h($docente->doutoradoanoconclusao) ?></dd>

        </dl>

        <dl class="row">
            <dt class="col-sm-5 h3">Dados funcionais</dt>
            <dd></dd>

            <dt class="col-sm-3"><?= __('SIAPE') ?></dt>
            <dd class="col-sm-9"><?= $this->Number->format($docente->siape, ['pattern' => '#######']) ?></dd>

            <dt class="col-sm-3"><?= __('Departamento') ?></dt>
            <dd class="col-sm-9"><?= h($docente->departamento) ?></dd>

            <dt class="col-sm-3"><?= __('Forma de ingresso') ?></dt>
            <dd class="col-sm-9"><?= h($docente->formaingresso) ?></dd>

            <dt class="col-sm-3"><?= __('Data de ingresso') ?></dt>
            <dd class="col-sm-9"><?= $docente->dataingresso ? $docente->dataingresso->i18nFormat('dd-MM-yyyy') : 's/d' ?></dd>

            <dt class="col-sm-3"><?= __('Tipo de cargo') ?></dt>
            <dd class="col-sm-9"><?= h($docente->tipocargo) ?></dd>

            <dt class="col-sm-3"><?= __('Classe e nível') ?></dt>
            <dd class="col-sm-9"><?= h($docente->categoria) ?></dd>

            <dt class="col-sm-3"><?= __('Regime de trabalho') ?></dt>
            <dd class="col-sm-9"><?= h($docente->regimetrabalho) ?></dd>

            <dt class="col-sm-3"><?= __('Data de egresso') ?></dt>
            <dd class="col-sm-9"><?= $docente->dataegresso ? $docente->dataegresso->i18nFormat('dd-MM-yyyy') : 's/d' ?></dd>

            <dt class="col-sm-3"><?= __('Motivo de egresso') ?></dt>
            <dd class="col-sm-9"><?= h($docente->motivoegresso) ?></dd>

            <dt class="col-sm-3"><?= __('Observações') ?></dt>
            <dd class="col-sm-9"><?= $this->Text->autoParagraph(h($docente->observacoes)); ?></dd>
        </dl>
    </div>
<?php endif; ?>

<?php // pr($docente->monografias) ?>

<div class="container col-lg-8 shadow p-3 mb-5 bg-white rounded">
    <h4><?= __('Monografias') ?></h4>
    <?php if (!empty($docente->monografias)): ?>
        <table class="table table-striped table-hover table-responsive">
            <thead class="table-dark">
                <tr>
                    <th scope="col"><?= __('Titulo') ?></th>
                    <th scope="col"><?= __('Periodo') ?></th>
                    <th scope="col"><?= __('Pdf') ?></th>
                </tr>
            </thead>
            <?php foreach ($docente->monografias as $monografias): ?>
                <?php // pr($monografias); ?>
                <tr>
                    <td><?= $this->Html->link($monografias->titulo, ['controller' => 'monografias', 'action' => 'view', $monografias->id]) ?>
                    </td>
                    <td><?= h($monografias->periodo) ?></td>
                    <td><?= $this->Html->link($monografias->url, ['controller' => 'monografias', 'action' => 'download', $monografias->url, $monografias->id]) ?>
                    </td>
                </tr>
            <?php endforeach; ?>
        </table>
    <?php endif; ?>
</div>

<div class="container col-lg-8 shadow p-3 mb-5 bg-white rounded">
    <h4><?= __('Áreas') ?></h4>
    <?php if (!empty($docente->areamonografias)): ?>
        <?php // pr($docente->areas); ?>
        <table class="table table-striped table-hover table-responsive">
            <thead class="table-dark">
                <tr>
                    <th scope="col"><?= __('Área') ?></th>
                </tr>
            </thead>
            <?php foreach ($docente->areamonografias as $professoresAreas): ?>
                <?php // pr($ProfessoresAreas); ?>
                <tr>
                    <td><?= $this->Html->link($professoresAreas->area, ['controller' => 'areamonografias', 'action' => 'view', $professoresAreas->id]) ?>
                    </td>
                </tr>
            <?php endforeach; ?>
        </table>
    <?php endif; ?>
</div>