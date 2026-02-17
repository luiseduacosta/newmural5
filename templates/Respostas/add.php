<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Resposta $resposta
 * @var \Cake\Collection\CollectionInterface|string[] $questiones
 * @var \Cake\Collection\CollectionInterface|string[] $estagiarios
 */
?>

<?php echo $this->element('menu_mural') ?>

<div class="container mt-1">
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <ul class="navbar-nav collapse navbar-collapse">
            <li class="nav-item">
                <?= $this->Html->link(__('Listar respostas'), ['action' => 'index'], ['class' => 'btn btn-primary']) ?>
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
                'label' => 'Estagiário ID',
                'value' => $estagiario_id,
                'templates' => [
                    'inputContainer' => '<div class="d-none" {{type}}{{required}}">{{content}}</div>'
                ],
                'class' => 'form-control'
            ]);
            ?>
            <?php foreach ($questiones as $questione): ?>
                <div class="row mb-3">
                    <?php
                    $opcoes = is_string($questione->options) ? json_decode($questione->options, true) : [];
                    if ($questione->type === 'select') {
                        echo $this->Form->control('avaliacao' . $questione->id, [
                            'type' => $questione->type,
                            'div' => false,
                            'label' => $questione->text,
                            'options' => $opcoes,
                            'empty' => 'Seleciona',
                            'class' => 'form-control',
                            'templates' => [
                                'inputContainer' => '<div class="col-sm-12" {{type}}{{required}}">{{content}}</div>',
                                'select' => '<select class="form-select" name="{{name}}"{{attrs}}>{{content}}</select>'
                            ]
                        ]);
                    } elseif ($questione->type === 'radio' || $questione->type === 'checkbox') {
                        echo $this->Form->control('avaliacao' . $questione->id, [
                            'type' => "radio",
                            'div' => false,
                            'label' => $questione->text,
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
                    } elseif ($questione->type === 'boolean') {
                        echo $this->Form->control('avaliacao' . $questione->id, [
                            'type' => 'radio',
                            'div' => false,
                            'default' => '0',
                            'label' => $questione->text,
                            'options' => ['0' => 'Não', '1' => 'Sim'],
                            'templates' => [
                                'inputContainer' => '<div class="col-sm-12" {{type}}{{required}}">{{content}}</div>',
                                'radioWrapper' => '<div class="form-check">{{label}}{{input}}</div>',
                                'nestingLabel' => '<label class="form-check-label"{{attrs}}>{{text}}</label>',
                                'radio' => '<input class="form-check-input" type="radio" name="{{name}}" value="{{value}}"{{attrs}}>'
                            ]
                        ]);
                    } elseif ($questione->type === 'escala') {
                        echo $this->Form->control('avaliacao' . $questione->id, [
                            'type' => 'number',
                            'div' => false,
                            'default' => 1,
                            'min' => 1,
                            'max' => 5,
                            'label' => $questione->text,
                            'class' => 'form-control',
                        ]);
                    } elseif ($questione->type === 'text' || $questione->type === 'textarea') {
                        $this->Form->setTemplates(['textarea' => '<textarea name="{{name}}"{{attrs}}>{{value}}</textarea>']);
                        echo $this->Form->control('avaliacao' . $questione->id, [
                            'type' => $questione->type,
                            'div' => false,
                            'label' => $questione->text,
                            'class' => 'form-control',
                            'templates' => [
                                'inputContainer' => '<div class="col-sm-12" {{type}}{{required}}">{{content}}</div>',
                                'textarea' => '<textarea name="{{name}}"{{attrs}}>{{value}}</textarea>'
                            ]
                        ]);
                    } else {
                        $this->Form->setTemplates(['input' => '<div class="col-sm-9"><input type="{{type}}" name="{{name}}" class="form-control" {{attrs}}></div>']);
                        echo $this->Form->control('avaliacao' . $questione->id, [
                            'type' => 'text',
                            'div' => false,
                            'label' => $questione->text,
                            'class' => 'form-control'
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
            echo $this->Form->button(__('Confirma'), ['class' => 'btn btn-primary'])
                ?>
        </fieldset>
        <?= $this->Form->end() ?>
    </div>
</div>