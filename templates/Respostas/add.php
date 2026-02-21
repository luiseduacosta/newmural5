<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Resposta $resposta
 * @var \Cake\Collection\CollectionInterface|string[] $questoes
 * @var \Cake\Collection\CollectionInterface|string[] $estagiarios
 */
?>

<?php echo $this->element('menu_mural') ?>

<?php echo $this->element('templates') ?>

<div class="container mt-1">
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <ul class="navbar-nav collapse navbar-collapse">
            <li class="nav-item">
                <?= $this->Html->link('Listar respostas', ['action' => 'index'], ['class' => 'btn btn-primary']) ?>
            </li>
        </ul>
    </nav>

    <div class="container mt-4">
        <?= $this->Form->create($resposta, ['container' => false]) ?>
        <fieldset>
            <legend><?= $estagiario->aluno->nome . ' estagiário nível ' . $estagiario->nivel ?></legend>
            <?php
            echo $this->Form->control('estagiario_id', [
                'div' => false,
                'type' => 'text',
                'label' => 'Estagiário',
                'value' => $estagiario_id,
                'templates' => [
                    'inputContainer' => '<div class="d-none" {{type}}{{required}}">{{content}}</div>'
                ],
                'class' => 'form-control'
            ]);
            ?>
            <?php foreach ($questoes as $questao): ?>
                <div class="row mb-3">
                    <?php
                    $opcoes = is_string($questao->options) ? json_decode($questao->options, true) : [];
                    echo $this->Form->control('questao_text' . $questao->id, [
                        'type' => 'hidden',
                        'value' => $questao->text ?? ''
                    ]);
                    if ($questao->type === 'select') {
                        echo $this->Form->control('questao_text' . $questao->id, [
                            'type' => 'hidden',
                            'value' => $opcoes
                        ]);
                        echo $this->Form->control('avaliacao' . $questao->id, [
                            'type' => $questao->type,
                            'div' => false,
                            'label' => ['text' => $questao->text, 'class' => 'd-block fw-bold mb-2'],
                            'options' => $opcoes,
                            'empty' => 'Seleciona',
                            'class' => 'form-control',
                            'templates' => [
                                'inputContainer' => '<div class="col-sm-12" {{type}}{{required}}">{{content}}</div>',
                                'select' => '<select class="form-select" name="{{name}}"{{attrs}}>{{content}}</select>'
                            ]
                        ]);
                    } elseif ($questao->type === 'radio' || $questao->type === 'checkbox') {
                        echo $this->Form->control('questao_text' . $questao->id, [
                            'type' => 'hidden',
                            'value' => $opcoes
                        ]);
                        echo $this->Form->control('avaliacao' . $questao->id, [
                            'type' => $questao->type,
                            'div' => false,
                            'label' => ['text' => $questao->text, 'class' => 'd-block fw-bold mb-2'],
                            'options' => $opcoes,
                            'class' => 'form-check-input',
                            'nestedInput' => false,
                            'templates' => [
                                'inputContainer' => '<div class="col-sm-12 mb-3" {{type}}{{required}}">{{content}}</div>',
                                'radioWrapper' => '<div class="form-check">{{input}}{{label}}</div>',
                                'radio' => '<input type="radio" name="{{name}}" value="{{value}}"{{attrs}}>',
                                'checkboxWrapper' => '<div class="form-check">{{input}}{{label}}</div>',
                                'checkbox' => '<input type="checkbox" name="{{name}}" value="{{value}}"{{attrs}}>',
                                'labelOption' => '<label class="form-check-label"{{attrs}}>{{text}}</label>'
                            ]
                        ]);
                        } elseif ($questao->type === 'boolean') {
                            echo $this->Form->control('questao_text' . $questao->id, [
                                'type' => 'hidden',
                                'value' => $opcoes
                            ]);
                            echo $this->Form->control('avaliacao' . $questao->id, [
                                'type' => 'radio',
                                'div' => false,
                                'default' => '0',
                                'label' => ['text' => $questao->text, 'class' => 'd-block fw-bold mb-2'],
                                'options' => ['0' => 'Não', '1' => 'Sim'],
                                'class' => 'form-check-input',
                                'templates' => [
                                'inputContainer' => '<div class="col-sm-12 mb-3" {{type}}{{required}}">{{content}}</div>',
                                'radioWrapper' => '<div class="form-check">{{input}}{{label}}</div>',
                                'radio' => '<input type="radio" name="{{name}}" value="{{value}}"{{attrs}}>',
                                'labelOption' => '<label class="form-check-label"{{attrs}}>{{text}}</label>',
                            ]
                        ]);
                    } elseif ($questao->type === 'escala') {
                        echo $this->Form->control('questao_text' . $questao->id, [
                            'type' => 'hidden',
                            'value' => $opcoes
                        ]);
                        echo $this->Form->control('avaliacao' . $questao->id, [
                            'type' => 'number',
                            'div' => false,
                            'default' => 1,
                            'min' => 1,
                            'max' => 5,
                            'label' => ['text' => $questao->text, 'class' => 'd-block fw-bold mb-2'],
                            'class' => 'form-control',
                        ]);
                    } elseif ($questao->type === 'text' || $questao->type === 'textarea') {
                        echo $this->Form->control('questao_text' . $questao->id, [
                            'type' => 'hidden',
                            'value' => $opcoes
                        ]);
                        echo $this->Form->control('avaliacao' . $questao->id, [
                            'type' => $questao->type,
                            'div' => false,
                            'label' => ['text' => $questao->text, 'class' => 'd-block fw-bold mb-2'],
                            'class' => 'form-control',
                            'templates' => [
                                'inputContainer' => '<div class="col-sm-12" {{type}}{{required}}">{{content}}</div>',
                                'textarea' => '<textarea name="{{name}}"{{attrs}}>{{value}}</textarea>'
                            ]
                        ]);
                    } else {
                        echo $this->Form->control('questao_text' . $questao->id, [
                            'type' => 'hidden',
                            'value' => $opcoes  
                        ]);
                        echo $this->Form->control('avaliacao' . $questao->id, [
                            'type' => 'text',
                            'div' => false,
                            'label' => ['text' => $questao->text, 'class' => 'd-block fw-bold mb-2'],
                            'class' => 'form-control',
                            'templates' => [
                                'inputContainer' => '<div class="col-sm-12" {{type}}{{required}}">{{content}}</div>',
                            ]
                        ]);
                    }
                    ?>
                </div>
            <?php endforeach; ?>
            <?php
            echo $this->Form->control('created', [
                'type' => 'hidden',
                'value' => date('Y-m-d H:i:s')
            ]);
            echo $this->Form->control('modified', [
                'type' => 'hidden',
                'value' => date('Y-m-d H:i:s')
            ]);
            echo $this->Form->button('Confirma', ['class' => 'btn btn-primary'])
            ?>
        </fieldset>
        <?= $this->Form->end() ?>
    </div>
</div>