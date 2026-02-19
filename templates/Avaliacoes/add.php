<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Avaliacao $avaliacao
 * @var \Cake\Collection\CollectionInterface|string[] $estagiarios
 */
$user = $this->getRequest()->getAttribute('identity');
// pr($estagiario);
// die();
?>

<?php
$dia = strftime('%e', time());
$mes = strftime('%B', time());
$ano = strftime('%Y', time());

$supervisora = isset($estagiario->supervisor->nome);
if ($supervisora) {
    $supervisora = $estagiario->supervisor->nome;
} else {
    $supervisora = "____________________";
}

$regiao = isset($estagiario->supervisor->regiao);
if ($regiao) {
    $regiao = $estagiario->supervisor->regiao;
} else {
    $regiao = '__';
}

$cress = isset($estagiario->supervisor->cress);
if ($cress) {
    $cress = $estagiario->supervisor->cress;
} else {
    $cress = '_____';
}
?>

<style>
    legend {
        font-weight: normal;
        text-align: justify;
    }
</style>

<?php echo $this->element('menu_mural') ?>

<nav class="navbar navbar-expand-lg py-2 navbar-light bg-light" id="actions-sidebar">
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarTogglerAvaliacoes"
        aria-controls="navbarTogglerAvaliacoes" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <ul class="navbar-nav collapse navbar-collapse" id="navbarTogglerAvaliacoes">
        <?php if (isset($user) && ($user->categoria == '1' || $user->categoria == '4')): ?>
            <li class="nav-item">
                <?= $this->Html->link(__('Listar avaliações'), ['action' => 'index', '?' => $estagiario->id . '/' . $estagiario->registro], ['class' => 'btn btn-primary']) ?>
            </li>
        <?php endif; ?>
    </ul>
</nav>

<?php $this->Form->setTemplates(['formStart' => '<form{{attrs}}>']); ?>
<?php $this->Form->setTemplates(['formEnd' => '</form>']); ?>
<?php $this->Form->setTemplates(['fieldset' => '<fieldset class="border p-3 mb-4" {{attrs}}>{{content}}</fieldset>']); ?>
<?php $this->Form->setTemplates(['select' => '<select class="form-select" name="{{name}}"{{attrs}}>{{content}}</select>']); ?>
<?php $this->Form->setTemplates(['option' => '<option value="{{value}}"{{attrs}}>{{text}}</option>']); ?>
<?php $this->Form->setTemplates(['legend' => '<legend class="h3">{{text}}</legend>']); ?>
<?php $this->Form->setTemplates(['label' => '<label class="form-label" {{attrs}}>{{text}}</label>']); ?>
<?php $this->Form->setTemplates(['input' => '<input class="form-control" type="{{type}}" name="{{name}}"{{attrs}}>']); ?>
<?php $this->Form->setTemplates(['radioWrapper' => '<div class="form-check form-check-inline">{{label}}{{input}}</div>']); ?>
<?php $this->Form->setTemplates(['radio' => '<input class="form-check-input" type="radio" name="{{name}}" value="{{value}}"{{attrs}}>']); ?>
<?php $this->Form->setTemplates(['textarea' => '<textarea name="{{name}}"{{attrs}}>{{value}}</textarea>']); ?>
<?php $this->Form->setTemplates(['requiredClass' => 'required']); ?>
<?php $this->Form->setTemplates(['submitContainer' => '<div class="Confirma">{{content}}</div>']); ?>
<?php $this->Form->setTemplates(['button' => '<button{{attrs}}>{{text}}</button>']); ?>

<?= $this->element('templates'); ?>

<h1>Formulário de avalição da(a) discente <?= $estagiario->aluno->nome ?></h1>

<div class="container col-lg-8 shadow p-3 mb-5 bg-white rounded">

    <?= $this->Form->create($avaliacao) ?>

    <fieldset>

        <?= $this->Form->control('estagiario_id', ['options' => [$estagiario->id => $estagiario->aluno->nome]]); ?>

        <legend style="font-size: 16px; font-weight: normal; text-align: justify;">1. ASSIDUIDADE. Desenvolveu as atividades propostas com frequência,
            ausentando-se apenas com conhecimento e acordado com o(a) supervisor(a) de campo e ou acadêmico(a), seja por
            motivo de saúde, seja por situações estabelecidas na Lei 11788/2008, entre outras.</legend>
        <div class="row">
            <div class="col-md-12">
                <?= $this->Form->input('avaliacao1', ['type' => 'radio', 'legend' => true, 'options' => [0 => 'Ruim', 1 => 'Regular', 2 => 'Bom', 3 => 'Excelente']]); ?>
            </div>
        </div>

        <legend style="font-size: 16px; font-weight: normal; text-align: justify;">2. PONTUALIDADE. Cumpre horário estabelecido no Plano de Estágio.</legend>
        <div class="row">
            <div class="col-md-12">
                <?= $this->Form->input('avaliacao2', ['type' => 'radio', 'legend' => false, 'options' => [0 => 'Ruim', 1 => 'Regular', 2 => 'Bom', 3 => 'Excelente']]); ?>
            </div>
        </div>

        <legend style="font-size: 16px; font-weight: normal; text-align: justify;">3. COMPROMISSO. Cumpre com as ações e estratégias previstas no Plano de
            Estágio.</legend>
        <div class="row">
            <div class="col-md-12">
                <?= $this->Form->input('avaliacao3', ['type' => 'radio', 'legend' => false, 'options' => [0 => 'Ruim', 1 => 'Regular', 2 => 'Bom', 3 => 'Excelente']]); ?>
            </div>
        </div>

        <legend style="font-size: 16px; font-weight: normal; text-align: justify;">4. RELACIONAMENTO COM O(A) USUÁRIO(A). Na relação com o(a) usuário(a):
            compromisso ético-político no atendimento ao usuário(a).</legend>
        <div class="row">
            <div class="col-md-12">
                <?= $this->Form->input('avaliacao4', ['type' => 'radio', 'legend' => false, 'options' => [0 => 'Ruim', 1 => 'Regular', 2 => 'Bom', 3 => 'Excelente']]); ?>
            </div>
        </div>

        <legend style="font-size: 16px; font-weight: normal; text-align: justify;">5. INTEGRAÇÃO E ARTICULAÇÃO. Na relação com outro(a)s profissionais:
            Integração e articulação à equipe da área de estágio, cooperação e habilidade de trabalhar em equipe
            multiprofissional.</legend>
        <div class="row">
            <div class="col-md-12">
                <?= $this->Form->input('avaliacao5', ['type' => 'radio', 'legend' => false, 'options' => [0 => 'Ruim', 1 => 'Regular', 2 => 'Bom', 3 => 'Excelente']]); ?>
            </div>
        </div>

        <legend style="font-size: 16px; font-weight: normal; text-align: justify;">6. CRITICIDADE E INICATIVA. Capacidade crítica, interventiva, propositiva e
            investigativa no enfrentamento das diversas questões existentes no campo de estágio.</legend>
        <div class="row">
            <div class="col-md-12">
                <?= $this->Form->input('avaliacao6', ['type' => 'radio', 'legend' => false, 'options' => [0 => 'Ruim', 1 => 'Regular', 2 => 'Bom', 3 => 'Excelente']]); ?>
            </div>
        </div>

        <legend style="font-size: 16px; font-weight: normal; text-align: justify;">7. APREENSÃO DO REFERENCIAL TEÓRICO-METODOLÓGICO, ÉTICO-POLÍTICO E
            INVESTIGATIVO E APLICAÇÃO NAS ATIVIDADES INERENTES AO CAMPO</legend>
        <div class="row">
            <div class="col-md-12">
                <?= $this->Form->input('avaliacao7', ['type' => 'radio', 'legend' => false, 'options' => [0 => 'Ruim', 1 => 'Regular', 2 => 'Bom', 3 => 'Excelente']]); ?>
            </div>
        </div>

        <legend style="font-size: 16px; font-weight: normal; text-align: justify;">8. AVALIAÇÃO DO DESSEMPENHO DO(A) ESTAGIÁRIO(A) NA ELABORAÇÃO DE
            RELATÓRIOS, PESQUISAS, PROJETOS DE PESQUISA E INTERVENÇÃO, ETC:</legend>
        <div class="row">
            <div class="col-md-12">
                <?= $this->Form->input('avaliacao8', ['type' => 'radio', 'legend' => false, 'options' => [0 => 'Ruim', 1 => 'Regular', 2 => 'Bom', 3 => 'Excelente']]); ?>
            </div>
        </div>

        <legend style="font-size: 16px; font-weight: normal; text-align: justify;">9. AS ATIVIDADES PREVISTAS NO PLANO DE ESTÁGIO EM ARTECIAÇÃO COM O NÍVEL DE
            FORMAÇÃO ACADÊMICA FORAM EFETUADAS PLENAMENTE?</legend>
        <div class="row">
            <div class="col-md-12">
                <?= $this->Form->input('avaliacao9', ['type' => 'radio', 'legend' => false, 'options' => [0 => 'Sim', 1 => 'Não']]); ?>
            </div>
        </div>

        <legend style="font-size: 16px; font-weight: normal; text-align: justify;">Fundamente se achar necessário:</legend>
        <div class="row">
            <div class="col-md-12">
                <?= $this->Form->input('avaliacao9-1', ['type' => 'textarea', 'label' => false, 'class' => 'form-control', 'rows' => 5, 'cols' => 100]); ?>
            </div>
        </div>

        <legend style="font-size: 16px; font-weight: normal; text-align: justify;">10. O desempenho das atividades desenvolvidas pelo(a) estagiário(a) e o
            processo de supervisão foram afetados pelas condições de trabalho no campo de estágio e, em particular,
            pelas condições estabelecidas pelo estágio remoto?</legend>
        <div class="row">
            <div class="col-md-12">
                <?= $this->Form->input('avaliacao10', ['type' => 'radio', 'legend' => false, 'options' => [0 => 'Sim', 1 => 'Não']]); ?>
            </div>
        </div>

        <legend style="font-size: 16px; font-weight: normal; text-align: justify;">Justifique a resposta se achar necessário:</legend>
        <div class="row">
            <div class="col-md-12">
                <?= $this->Form->input('avaliacao10-1', ['type' => 'textarea', 'label' => false, 'class' => 'form-control', 'rows' => 5, 'cols' => 60]); ?>
            </div>
        </div>

        <legend style="font-size: 16px; font-weight: normal; text-align: justify;">11. Quanto à integração Disciplina de OTP/Coordenação de Estágio da
            ESS/Campo de Estágio: houve algum tipo de interlocução entre os 3 segmentos: aluno(a), professor(a) e
            supervisor(a)?
        </legend>
        <div class="row">
            <div class="col-md-12">
                <?= $this->Form->input('avaliacao11', ['type' => 'radio', 'legend' => false, 'options' => [0 => 'Sim', 1 => 'Não']]); ?>
            </div>
        </div>

        <legend style="font-size: 16px; font-weight: normal; text-align: justify;">Como você avalia esta interação? (Responda se achar necessário)</legend>
        <div class="row">
            <div class="col-md-12">
                <?= $this->Form->input('avaliacao11-1', ['type' => 'textarea', 'label' => false, 'class' => 'form-control', 'rows' => 5, 'cols' => 60]); ?>
            </div>
        </div>

        <legend style="font-size: 16px; font-weight: normal; text-align: justify;">12. Você recebeu e acompanhou o programa da Disciplina OTP?</legend>
        <div class="row">
            <div class="col-md-12">
                <?= $this->Form->input('avaliacao12', ['type' => 'radio', 'legend' => false, 'options' => [0 => 'Sim', 1 => 'Não']]); ?>
            </div>
        </div>

        <legend style="font-size: 16px; font-weight: normal; text-align: justify;">Sugestões ao que foi desenvolvido?</legend>
        <div class="row">
            <div class="col-md-12">
                <?= $this->Form->input('avaliacao12-1', ['type' => 'textarea', 'label' => false, 'class' => 'form-control', 'rows' => 5, 'cols' => 60]); ?>
            </div>
        </div>

        <legend style="font-size: 16px; font-weight: normal; text-align: justify;">13. Há questões que você considera que devam ser mais enfatizadas na
            disciplina de OTP?</legend>
        <div class="row">
            <div class="col-md-12">
                <?= $this->Form->input('avaliacao13', ['type' => 'radio', 'legend' => false, 'options' => [0 => 'Sim', 1 => 'Não']]); ?>
            </div>
        </div>

        <legend style="font-size: 16px; font-weight: normal; text-align: justify;">Se sim, quais?</legend>
        <div class="row">
            <div class="col-md-12">
                <?= $this->Form->input('avaliacao13-1', ['type' => 'textarea', 'label' => false, 'class' => 'form-control', 'rows' => 5, 'cols' => 60]); ?>
            </div>
        </div>

        <legend style="font-size: 16px; font-weight: normal; text-align: justify;">14. Como avalia a experiência do estágio remoto neste semestre? Será
            possível a continuidade do estágio na modalidade remota no próximo semestre?</legend>
        <div class="row">
            <div class="col-md-12">
                <?= $this->Form->input('avaliacao14', ['type' => 'textarea', 'label' => false, 'class' => 'form-control', 'rows' => 5, 'cols' => 60]); ?>
            </div>
        </div>

        <legend style="font-size: 16px; font-weight: normal; text-align: justify;">15. Sugestões e observações:</legend>
        <div class="row">
            <div class="col-md-12">
                <?= $this->Form->input('observacoes', ['type' => 'textarea', 'rows' => 5, 'cols' => 60, 'label' => false, 'class' => 'form-control']); ?>
            </div>
        </div>

    </fieldset>

    <?= $this->Form->button(__('Confirma'), ['type' => 'Confirma', 'class' => 'btn btn-primary']) ?>
    <?= $this->Form->end() ?>

</div>