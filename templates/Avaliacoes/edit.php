<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Avaliacao $avaliacao
 * @var \Cake\Collection\CollectionInterface|string[] $estagiarios
 */
$user = $this->getRequest()->getAttribute('identity');
$estagiario = $avaliacao->estagiario;
// pr($estagiario);
// die();
?>
<?php
$dia = strftime('%e', time());
$mes = strftime('%B', time());
$ano = strftime('%Y', time());

$supervisora = isset($estagiario->supervisor->nome) ? $estagiario->supervisor->nome : "____________________";
$regiao = isset($estagiario->supervisor->regiao) ? $estagiario->supervisor->regiao : '__';
$cress = isset($estagiario->supervisor->cress) ? $estagiario->supervisor->cress : '__________';
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
        <li class="nav-item">
            <?= $this->Html->link(__('Listar Avaliações'), ['action' => 'index', '?' => ['id' => $estagiario->id, 'registro' => $estagiario->registro]], ['class' => 'btn btn-primary']) ?>
        </li>
    </ul>
</nav>    

<h1>Formulário de avalição da(a) discente <?= $estagiario->aluno->nome ?></h1>

<div class="container col-lg-8 shadow p-3 mb-5 bg-white rounded">

        <?= $this->Form->create($avaliacao) ?>
        <?php
        $this->Form->setTemplates(["textarea" => "<div class='col-8'><textarea class='form-control' name = '{{name}}' {{attrs}}>{{value}}</textarea></div>",
            'nestingLabel' => '{{hidden}}<label class="form-check-label" style="font-weight: normal; font-size: 14px;" {{attrs}}>{{text}}</label>',
            'radioWrapper' => '<div class="form-check form-check-inline">{{label}}{{input}}</div>',
            'radio' => '<input class="form-check-input" type="radio" name="{{name}}" value="{{value}}"{{attrs}}>',
            'legend' => '<legend style = "font-weight: normal">{{text}}</legend>',
        ]);
        ?>

        <fieldset>
            <?= $this->Form->control('estagiario_id', ['options' => [$estagiario->id => $estagiario->aluno->nome]]); ?>

            <legend style="font-weight: normal;">1) ASSIDUIDADE: Desenvolveu as atividades propostas com frequência, ausentando-se apenas com conhecimento e acordado com o(a) supervisor(a) de campo e ou acadêmico(a), seja por motivo de saúde, seja por situações estabelecidas na Lei 11788/2008, entre outras:</legend>
            <?= $this->Form->input('avaliacao1', ['type' => 'radio', 'legend' => false, 'options' => [0 => 'Ruim', 1 => 'Regular', 2 => 'Bom', 3 => 'Excelente']]); ?>

            <legend style="font-weight: normal;">2) PONTUALIDADE: cumpre horário estabelecido no Plano de Estágio:</legend>
            <?= $this->Form->input('avaliacao2', ['type' => 'radio', 'legend' => false, 'options' => [0 => 'Ruim', 1 => 'Regular', 2 => 'Bom', 3 => 'Excelente']]); ?>

            <legend style="font-weight: normal;">3) COMPROMISSO: com as ações e estratégias previstas no Plano de Estágio:</legend>
            <?= $this->Form->input('avaliacao3', ['type' => 'radio', 'legend' => false, 'options' => [0 => 'Ruim', 1 => 'Regular', 2 => 'Bom', 3 => 'Excelente']]); ?>

            <legend style="font-weight: normal;">4) Na relação com o(a) usuário(a): compromisso ético-político no atendimento ao usuário(a):</legend>
            <?= $this->Form->input('avaliacao4', ['type' => 'radio', 'legend' => false, 'options' => [0 => 'Ruim', 1 => 'Regular', 2 => 'Bom', 3 => 'Excelente']]); ?>

            <legend style="font-weight: normal;">5) Na relação com outro(a)s profissionais: Integração e articulação à equipe da área de estágio, cooperação e habilidade de trabalhar em equipe multiprofissional:</legend>
            <?= $this->Form->input('avaliacao5', ['type' => 'radio', 'legend' => false, 'options' => [0 => 'Ruim', 1 => 'Regular', 2 => 'Bom', 3 => 'Excelente']]); ?>

            <legend style="font-weight: normal;">6) CRITICIDADE E INICATIVA: Capacidade crítica, interventiva, propositiva e investigativa no enfrentamento das diversas questões existentes no campo de estágio:</legend>
            <?= $this->Form->input('avaliacao6', ['type' => 'radio', 'legend' => false, 'options' => [0 => 'Ruim', 1 => 'Regular', 2 => 'Bom', 3 => 'Excelente']]); ?>

            <legend style="font-weight: normal;">7) Apreensão do referencial teórico-metodológico, ético-político e investigativo e aplicação nas atividades inerentes ao campo e previstas no Plano de Estágio:</legend>
            <?= $this->Form->input('avaliacao7', ['type' => 'radio', 'legend' => false, 'options' => [0 => 'Ruim', 1 => 'Regular', 2 => 'Bom', 3 => 'Excelente']]); ?>

            <legend style="font-weight: normal;">8)  Avaliação do desempenho do(a) estagiário(a) na elaboração de relatórios, pesquisas, projetos de pesquisa e intervenção, etc:</legend>
            <?= $this->Form->input('avaliacao8', ['type' => 'radio', 'legend' => false, 'options' => [0 => 'Ruim', 1 => 'Regular', 2 => 'Bom', 3 => 'Excelente']]); ?>

            <legend style="font-weight: normal;">9)  As atividades previstas no Plano de Estágio em articulação com o nível de formação acadêmica foram efetuadas plenamente?</legend>
            <?= $this->Form->input('avaliacao9', ['type' => 'radio', 'legend' => false, 'options' => [0 => 'Sim', 1 => 'Não']]); ?>

            <legend style="font-weight: normal;">Fundamente se achar necessário: </legend>
            <?= $this->Form->input('avaliacao9-1', ['type' => 'textarea', 'label' => false, 'class' => 'form-control', 'rows' => 5, 'cols' => 100]); ?>

            <legend style="font-weight: normal;">10) O desempenho das atividades desenvolvidas pelo(a) estagiário(a) e o processo de supervisão foram afetados pelas condições de trabalho no campo de estágio e, em particular, pelas condições estabelecidas pelo estágio remoto? </legend>
            <?= $this->Form->input('avaliacao10', ['type' => 'radio', 'legend' => false, 'options' => [0 => 'Sim', 1 => 'Não']]); ?>

            <legend style="font-weight: normal;">Justifique a resposta se achar necessário: </legend>
            <?= $this->Form->input('avaliacao10-1', ['type' => 'textarea', 'label' => false, 'class' => 'form-control', 'rows' => 5, 'cols' => 60]); ?>

            <legend style="font-weight: normal;">11) Quanto à integração Disciplina de OTP/Coordenação de Estágio da ESS/Campo de Estágio: houve algum tipo de interlocução entre os 3 segmentos: aluno(a), professor(a) e supervisor(a)?</legend>
            <?= $this->Form->input('avaliacao11', ['type' => 'radio', 'legend' => false, 'options' => [0 => 'Sim', 1 => 'Não']]); ?>

            <legend style="font-weight: normal;">Como você avalia esta interação? (Responda se achar necessário)</legend>
            <?= $this->Form->input('avaliacao11-1', ['type' => 'textarea', 'label' => false, 'class' => 'form-control', 'rows' => 5, 'cols' => 60]); ?>

            <legend style="font-weight: normal;">12) Você recebeu e acompanhou o programa da Disciplina OTP?</legend>
            <?= $this->Form->input('avaliacao12', ['type' => 'radio', 'legend' => false, 'options' => [0 => 'Sim', 1 => 'Não']]); ?>

            <legend style="font-weight: normal;">Sugestões ao que foi desenvolvido? </legend>
            <?= $this->Form->input('avaliacao12-1', ['type' => 'textarea', 'label' => false, 'class' => 'form-control', 'rows' => 5, 'cols' => 60]); ?>

            <legend style="font-weight: normal;">13) Há questões que você considera que devam ser mais enfatizadas na disciplina de OTP?</legend>
            <?= $this->Form->input('avaliacao13', ['type' => 'radio', 'legend' => false, 'options' => [0 => 'Sim', 1 => 'Não']]); ?>

            <legend style="font-weight: normal;">Se sim, quais? </legend>
            <?= $this->Form->input('avaliacao13-1', ['type' => 'textarea', 'label' => false, 'class' => 'form-control', 'rows' => 5, 'cols' => 60]); ?>

            <legend style="font-weight: normal;">14) Como avalia a experiência do estágio remoto neste semestre? Será possível a continuidade do estágio na modalidade remota no próximo semestre? </legend>
            <?= $this->Form->input('avaliacao14', ['type' => 'textarea', 'label' => false, 'class' => 'form-control', 'rows' => 5, 'cols' => 60]); ?>

            <legend style="font-weight: normal;">Sugestões e observações: </legend>
            <?= $this->Form->input('observacoes', ['type' => 'textarea', 'label' => false, 'class' => 'form-control', 'rows' => 5, 'cols' => 60]); ?>

        </fieldset>

        <?= $this->Form->button(__('Salvar'), ['class' => 'btn btn-primary']) ?>
        <?= $this->Form->end() ?>
</div>
