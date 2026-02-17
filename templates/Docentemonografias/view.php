<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Docente $docente
 */
$user = $this->getRequest()->getAttribute('identity');
// pr($docente);
?>

<?php echo $this->element('menu_monografias'); ?></div>

<?php if (isset($user->categoria) && $user->categoria == '1'): ?>
    <?= $this->Html->link(__('Editar Docente'), ['action' => 'edit', $docentemonografia->id], ['class' => 'btn btn-primary float-start']) ?>
    <?= $this->Form->postLink(__('Excluir Docente'), ['action' => 'delete', $docentemonografia->id], ['confirm' => __('Tem certeza que quer excluir o registro # {0}?', $docentemonografia->id), 'class' => 'btn btn-danger float-start']) ?>
<?php endif; ?>

<div class="container col-lg-8 shadow p-3 mb-5 bg-white rounded">
    <h3><?= h($docentemonografia->nome) ?></h3>
    <?php if (isset($user->categoria) && $user->categoria == '1'): ?>
        <table class="table table-hover table-responsive table-striped">
            <tr>
                <td colspan="2">Dados pessoais</td>
            </tr>
            <tr>
                <th scope="row"><?= __('Nome') ?></th>
                <td><?= h($docentemonografia->nome) ?></td>
            </tr>
            <tr>
                <th scope="row"><?= __('CṔF') ?></th>
                <td><?= h($docentemonografia->cpf) ?></td>
            </tr>
            <tr>
                <th scope="row"><?= __('Sexo') ?></th>
                <td>
                    <?php if ($docentemonografia->sexo == '1'): ?>
                        <?= 'Masculino'; ?>
                    <?php elseif ($docentemonografia->sexo == '2'): ?>
                        <?= 'Feminino'; ?>
                    <?php else: ?>
                        <?= "s/d" ?>
                    <?php endif; ?>
                </td>
            </tr>
            <tr>
                <th scope="row"><?= __('Data de nascimento') ?></th>
                <td><?= h($docentemonografia->datanascimento) ?></td>
            </tr>
            <tr>
                <th scope="row"><?= __('Local de nascimento') ?></th>
                <td><?= h($docentemonografia->localnascimento) ?></td>
            </tr>
            <tr>
                <th scope="row"><?= __('Telefone') ?></th>
                <td><?= h('(' . h($docentemonografia->ddd_telefone) . ')' . h($docentemonografia->telefone)) ?></td>
            </tr>
            <tr>
                <th scope="row"><?= __('Celular') ?></th>
                <td><?= h('(' . h($docentemonografia->ddd_celular) . ')' . h($docentemonografia->celular)) ?></td>
            </tr>
            <tr>
                <th scope="row"><?= __('E-mail') ?></th>
                <td><?= h($docentemonografia->email) ?></td>
            </tr>
            <tr>
                <th scope="row"><?= __('Site') ?></th>
                <td><?= isset($docentemonografia->homepage) ? $this->Html->link($docentemonografia->homepage, $docentemonografia->homepage) : '' ?>
                </td>
            </tr>
            <tr>
                <th scope="row"><?= __('Rede social') ?></th>
                <td><?= isset($docentemonografia->redesocial) ? $this->Html->link($docentemonografia->redesocial, $docentemonografia->redesocial) : '' ?>
                </td>
            </tr>

            <tr>
                <td colspan="2">Dados acadêmicos</td>
            </tr>
            <tr>
                <th scope="row"><?= __('Curriculo lattes') ?></th>
                <td><a href="<?= 'http://lattes.cnpq.br/' . $docentemonografia->curriculolattes ?>">Currículo</a></td>
            </tr>
            <tr>
                <th scope="row"><?= __('Atualização lattes') ?></th>
                <td><?= h($docentemonografia->atualizacaolattes) ?></td>
            </tr>
            <tr>
                <th scope="row"><?= __('Curriculo Sigma') ?></th>
                <td><?= h($docentemonografia->curriculosigma) ?></td>
            </tr>
            <tr>
                <th scope="row"><?= __('Diretório de Grupos de Pesquisa') ?></th>
                <td><a href='http://dgp.cnpq.br/dgp/espelhogrupo/<?= $docentemonografia->pesquisadordgp ?>'>Grupo de
                        pesquisa</a></td>
            </tr>
            <tr>
                <th scope="row"><?= __('Formação profissional') ?></th>
                <td><?= h($docentemonografia->formacaoprofissional) ?></td>
            </tr>
            <tr>
                <th scope="row"><?= __('Universidade de graduação') ?></th>
                <td><?= h($docentemonografia->universidadedegraduacao) ?></td>
            </tr>
            <tr>
                <th scope="row"><?= __('Ano formação') ?></th>
                <td><?= h($docentemonografia->anoformacao) ?></td>
            </tr>
            <tr>
                <th scope="row"><?= __('Mestrado área') ?></th>
                <td><?= h($docentemonografia->mestradoarea) ?></td>
            </tr>
            <tr>
                <th scope="row"><?= __('Mestrado universidade') ?></th>
                <td><?= h($docentemonografia->mestradouniversidade) ?></td>
            </tr>
            <tr>
                <th scope="row"><?= __('Mestrado ano conclusão') ?></th>
                <td><?= $docentemonografia->mestradoanoconclusao ?></td>
            </tr>
            <tr>
                <th scope="row"><?= __('Doutorado área') ?></th>
                <td><?= h($docentemonografia->doutoradoarea) ?></td>
            </tr>
            <tr>
                <th scope="row"><?= __('Doutorado universidade') ?></th>
                <td><?= h($docentemonografia->doutoradouniversidade) ?></td>
            </tr>

            <tr>
                <th scope="row"><?= __('Doutorado ano conclusão') ?></th>
                <td><?= h($docentemonografia->doutoradoanoconclusao) ?></td>
            </tr>

            <tr>
                <td colspan="2">Dados funcionais</td>
            </tr>
            <tr>
                <th scope="row"><?= __('Siape') ?></th>
                <td><?= $docentemonografia->siape ?></td>
            </tr>
            <tr>
                <th scope="row"><?= __('Departamento') ?></th>
                <td><?= h($docentemonografia->departamento) ?></td>
            </tr>
            <tr>
                <th scope="row"><?= __('Forma de ingresso') ?></th>
                <td><?= h($docentemonografia->formaingresso) ?></td>
            </tr>
            <tr>
                <th scope="row"><?= __('Data de ingresso') ?></th>
                <td><?= h($docentemonografia->dataingresso) ?></td>
            </tr>
            <tr>
                <th scope="row"><?= __('Tipo de cargo') ?></th>
                <td><?= h($docentemonografia->tipocargo) ?></td>
            </tr>
            <tr>
                <th scope="row"><?= __('Classe e nível') ?></th>
                <td><?= h($docentemonografia->categoria) ?></td>
            </tr>
            <tr>
                <th scope="row"><?= __('Regime de trabalho') ?></th>
                <td><?= h($docentemonografia->regimetrabalho) ?></td>
            </tr>
            <tr>
                <th scope="row"><?= __('Data de egresso') ?></th>
                <td><?= h($docentemonografia->dataegresso) ?></td>
            </tr>
            <tr>
                <th scope="row"><?= __('Motivo de egresso') ?></th>
                <td><?= h($docentemonografia->motivoegresso) ?></td>
            </tr>

        </table>
        <div>
            <p><?= __('Observações') ?></p>
            <?= $this->Text->autoParagraph(h($docentemonografia->observacoes)); ?>
        </div>
    <?php endif; ?>
</div>

<div class="container col-lg-8 shadow p-3 mb-5 bg-white rounded">
    <h4><?= __('Monografias') ?></h4>
    <?php if (!empty($docentemonografia->monografias)): ?>
        <table cellpadding="0" cellspacing="0">
            <tr>
                <th scope="col"><?= __('Titulo') ?></th>
                <th scope="col"><?= __('Periodo') ?></th>
                <th scope="col"><?= __('Pdf') ?></th>
            </tr>
            <?php foreach ($docentemonografia->monografias as $monografias): ?>
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
    <h4><?= __('Áreas do docente') ?></h4>
    <?php if (!empty($docentemonografia->areamonografias)): ?>
        <?php // pr($docente->areas); ?>
        <table cellpadding="0" cellspacing="0">
            <tr>
                <th scope="col"><?= __('Área') ?></th>
            </tr>
            <?php foreach ($docentemonografia->areamonografias as $Professoresareas): ?>
                <?php // pr($ProfessoresAreas); ?>
                <tr>
                    <td><?= $this->Html->link($Professoresareas->area, ['controller' => 'areamonografias', 'action' => 'view', $Professoresareas->id]) ?>
                    </td>
                </tr>
            <?php endforeach; ?>
        </table>
    <?php endif; ?>
</div>