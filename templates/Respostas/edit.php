<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Resposta $resposta
 * @var string[]|\Cake\Collection\CollectionInterface $questiones
 * @var string[]|\Cake\Collection\CollectionInterface $estagiarios
 */
?>

<?= $this->element('menu_mural') ?>

<div class="container mt-1">

    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <ul class="navbar-nav collapse navbar-collapse">
            <li class="nav-item">
                <?php if (isset($user) && $user->categoria == '1'): ?>
                <?= $this->Form->postLink(
                    __('Excluir'),
                    ['action' => 'delete', $resposta->id],
                    ['confirm' => __('Tem certeza que deseja excluir este registo # {0}?', $resposta->id), 'class' => 'btn btn-danger me-1']
                ) ?>
                <?php endif; ?>
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
            $resultado = null;
            $respostaporpergunta = null;
            foreach ($avaliacoes as $avaliacao) { ?>
            <?php // pr($avaliacao); ?>
            
                <div class="row mb-3">
                    <?php
                    $resultado = json_decode($resposta['response'], true);
                    $respostaporpergunta = $resultado['avaliacao' . $avaliacao['id']];
                    $opcoes = isset($avaliacao['options']) ? $avaliacao['options'] : [];
                    if ($avaliacao['type'] === 'select') {
                        echo $this->Form->control('avaliacao' . $avaliacao['id'], [
                            'type' => $avaliacao['type'],
                            'div' => false,
                            'label' => $avaliacao['text'],
                            'value' => $respostaporpergunta['valor'] ?? '',
                            'options' => $opcoes,
                            'empty' => 'Seleciona',
                            'class' => 'form-control',
                            'templates' => [
                                'inputContainer' => '<div class="col-sm-12" {{type}}{{required}}">{{content}}</div>',
                                'select' => '<select class="form-select" name="{{name}}"{{attrs}}>{{content}}</select>'
                            ]
                        ]);
                    } elseif ($avaliacao['type'] === 'radio' || $avaliacao['type'] === 'checkbox') {
                        echo $this->Form->control('avaliacao' . $avaliacao['id'], [
                            'type' => $avaliacao['type'],
                            'div' => false,
                            'label' => ['text' => $avaliacao['text'], 'class' => 'd-block fw-bold mb-2'],
                            'value' => $respostaporpergunta['valor'] ?? '',
                            'options' => $opcoes,
                            'class' => 'form-check-input',
                            'nestedInput' => false,
                            'templates' => [
                                'inputContainer' => '<div class="col-sm-12 mb-3" {{type}}{{required}}">{{content}}</div>',
                                'radioWrapper' => '<div class="form-check">{{input}}{{label}}</div>',
                                'checkboxWrapper' => '<div class="form-check">{{input}}{{label}}</div>',
                                'checkbox' => '<input type="checkbox" name="{{name}}" value="{{value}}"{{attrs}}>',
                                'radio' => '<input type="radio" name="{{name}}" value="{{value}}"{{attrs}}>',
                                'labelOption' => '<label class="form-check-label"{{attrs}}>{{text}}</label>'
                            ]
                        ]);
                    } elseif ($avaliacao['type'] === 'boolean') {
                        echo $this->Form->control('avaliacao' . $avaliacao['id'], [
                            'type' => 'radio',
                            'div' => false,
                            'default' => $respostaporpergunta['valor'] ?? '',
                            'label' => ['text' => $avaliacao['text'], 'class' => 'd-block fw-bold mb-2'],
                            'options' => ['0' => 'Não', '1' => 'Sim'],
                            'class' => 'form-check-input',
                            'templates' => [
                                'inputContainer' => '<div class="col-sm-12 mb-3" {{type}}{{required}}">{{content}}</div>',
                                'radioWrapper' => '<div class="form-check">{{input}}{{label}}</div>',
                                'radio' => '<input type="radio" name="{{name}}" value="{{value}}"{{attrs}}>'
                            ]
                        ]);
                    } elseif ($avaliacao['type'] === 'escala') {
                        echo $this->Form->control('avaliacao' . $avaliacao['id'], [
                            'type' => 'number',
                            'div' => false,
                            'min' => 1,
                            'max' => 5,
                            'label' => $avaliacao['text'],
                            'value' => $respostaporpergunta['valor'] ?? '',
                            'class' => 'form-control',
                        ]);
                    } elseif ($avaliacao['type'] === 'text' || $avaliacao['type'] === 'textarea') {
                        $this->Form->setTemplates(['textarea' => '<textarea name="{{name}}"{{attrs}}>{{value}}</textarea>']);
                        echo $this->Form->control('avaliacao' . $avaliacao['id'], [
                            'type' => $avaliacao['type'],
                            'div' => false,
                            'label' => $avaliacao['text'],
                            'value' => $respostaporpergunta['valor'] ?? '',
                            'class' => 'form-control',
                            'templates' => [
                                'inputContainer' => '<div class="col-sm-12" {{type}}{{required}}">{{content}}</div>',
                                'textarea' => '<textarea name="{{name}}"{{attrs}}>{{value}}</textarea>'
                            ]
                        ]);
                    } else {
                        $this->Form->setTemplates(['input' => '<div class="col-sm-9"><input type="{{type}}" name="{{name}}" class="form-control" {{attrs}}></div>']);
                        echo $this->Form->control('avaliacao' . $avaliacao['id'], [
                            'type' => 'text',
                            'div' => false,
                            'label' => $avaliacao['text'],
                            'value' => $respostaporpergunta['valor'] ?? '',
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