<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Resposta $resposta
 * @var string[]|\Cake\Collection\CollectionInterface $questiones
 * @var string[]|\Cake\Collection\CollectionInterface $estagiarios
 */
// pr($avaliacoes);
// die();
?>

<?= $this->element('menu_mural') ?>

<div class="container mt-1">

    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <ul class="navbar-nav collapse navbar-collapse">
            <li class="nav-item">
                <?= $this->Form->postLink(
                    __('Excluir'),
                    ['action' => 'delete', $resposta->id],
                    ['confirm' => __('Tem certeza que deseja excluir este registo # {0}?', $resposta->id), 'class' => 'btn btn-danger me-1']
                ) ?>
            </li>
            <li class="nav-item">
                <?= $this->Html->link(__('Listar respostas'), ['action' => 'index'], ['class' => 'btn btn-primary me-1']) ?>
            </li>
        </ul>
    </nav>

    <div class="container mt-4">
        <h1><?= $estagiario->aluno->nome . ' estagiário nível ' . $estagiario->nivel ?></h1>
        <?= $this->Form->create($resposta) ?>
        <fieldset>
            <legend><?= __('Editar resposta') ?></legend>
            <?php
            foreach ($avaliacoes as $avaliacao) { ?>
                <div class="row mb-3">
                    <?php
                    $opcoes = isset($avaliacao['opcoes']) ? $avaliacao['opcoes'] : [];
                    if ($avaliacao['type'] === 'select') {
                        echo $this->Form->control('avaliacao' . $avaliacao['pergunta_id'], [
                            'type' => $avaliacao['type'],
                            'div' => false,
                            'label' => $avaliacao['pergunta'],
                            'value' => $avaliacao['value'],
                            'options' => $opcoes,
                            'empty' => 'Seleciona',
                            'class' => 'form-control',
                            'templates' => [
                                'inputContainer' => '<div class="col-sm-12" {{type}}{{required}}">{{content}}</div>',
                                'select' => '<select class="form-select" name="{{name}}"{{attrs}}>{{content}}</select>'
                            ]
                        ]);
                    } elseif ($avaliacao['type'] === 'radio' || $avaliacao['type'] === 'checkbox') {
                        echo $this->Form->control('avaliacao' . $avaliacao['pergunta_id'], [
                            'type' => "radio",
                            'div' => false,
                            'label' => $avaliacao['pergunta'],
                            'value' => $avaliacao['value'],
                            'options' => $opcoes,
                            'class' => 'form-control',
                            'nestedInput' => false,
                            'templates' => [
                                'inputContainer' => '<div class="col-sm-12" {{type}}{{required}}">{{content}}</div>',
                                'radioWrapper' => '<div class="form-check">{{label}}{{input}}</div>',
                                'nestingLabel' => '<label class="form-check-label"{{attrs}}>{{text}}</label>',
                                'radio' => '<input class="form-check-input" type="radio" name="{{name}}" value="{{value}}"{{attrs}}>',
                                'labelOption' => '<label class="form-check-label"{{attrs}}>{{text}}</label>'
                            ]
                        ]);
                    } elseif ($avaliacao['type'] === 'boolean') {
                        echo $this->Form->control('avaliacao' . $avaliacao['pergunta_id'], [
                            'type' => 'radio',
                            'div' => false,
                            'default' => $avaliacao['value'],
                            'label' => $avaliacao['pergunta'],
                            'options' => ['0' => 'Não', '1' => 'Sim'],
                            'templates' => [
                                'inputContainer' => '<div class="col-sm-12" {{type}}{{required}}">{{content}}</div>',
                                'radioWrapper' => '<div class="form-check">{{label}}{{input}}</div>',
                                'nestingLabel' => '<label class="form-check-label"{{attrs}}>{{text}}</label>',
                                'radio' => '<input class="form-check-input" type="radio" name="{{name}}" value="{{value}}"{{attrs}}>'
                            ]
                        ]);
                    } elseif ($avaliacao['type'] === 'escala') {
                        echo $this->Form->control('avaliacao' . $avaliacao['pergunta_id'], [
                            'type' => 'number',
                            'div' => false,
                            'min' => 1,
                            'max' => 5,
                            'label' => $avaliacao['pergunta'],
                            'value' => $avaliacao['value'],
                            'class' => 'form-control',
                        ]);
                    } elseif ($avaliacao['type'] === 'text' || $avaliacao['type'] === 'textarea') {
                        $this->Form->setTemplates(['textarea' => '<textarea name="{{name}}"{{attrs}}>{{value}}</textarea>']);
                        echo $this->Form->control('avaliacao' . $avaliacao['pergunta_id'], [
                            'type' => $avaliacao['type'],
                            'div' => false,
                            'label' => $avaliacao['pergunta'],
                            'value' => $avaliacao['value'],
                            'class' => 'form-control',
                            'templates' => [
                                'inputContainer' => '<div class="col-sm-12" {{type}}{{required}}">{{content}}</div>',
                                'textarea' => '<textarea name="{{name}}"{{attrs}}>{{value}}</textarea>'
                            ]
                        ]);
                    } else {
                        $this->Form->setTemplates(['input' => '<div class="col-sm-9"><input type="{{type}}" name="{{name}}" class="form-control" {{attrs}}></div>']);
                        echo $this->Form->control('avaliacao' . $avaliacao['pergunta_id'], [
                            'type' => 'text',
                            'div' => false,
                            'label' => $avaliacao['pergunta'],
                            'value' => $avaliacao['value'],
                            'class' => 'form-control'
                        ]);
                    }
                    ?>
                </div>
                <?php
            }
            ?>
        </fieldset>
        <?= $this->Form->button(__('Confirma'), ['class' => 'btn btn-primary']) ?>
        <?= $this->Form->end() ?>
    </div>

</div>