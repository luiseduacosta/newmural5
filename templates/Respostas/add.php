<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Resposta $resposta
 * @var \Cake\Collection\CollectionInterface|string[] $questoes
 * @var \Cake\Collection\CollectionInterface|string[] $estagiarios
 */
?>

<?= $this->element('menu_mural') ?>

<div class="container mt-1">
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <ul class="navbar-nav collapse navbar-collapse">
            <li class="nav-item">
                <?= $this->Html->link('Listar respostas', ['action' => 'index'], ['class' => 'btn btn-primary me-1']) ?>
            </li>
            <?php if (isset($user->categoria) && ($user->categoria == '1' || $user->categoria == '4')): ?>
                <li class="nav-item">
                    <?= $this->Html->link(__('Imprimir'), ['action' => 'imprimeresposta', '?' => ['estagiario_id' => $estagiario->id]], ['class' => 'btn btn-primary me-1']) ?>
                </li>
            <?php endif ?>
        </ul>
    </nav>

    <div class="container mt-4">
        <?= $this->Form->create($resposta, ['container' => false]) ?>
        <fieldset>
            <legend><?= $estagiario->aluno->nome . ' estagiário - nível ' . $estagiario->nivel ?></legend>
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
                    ?>
                    <div class="row mb-2">
                        <div class="col-sm-12">
                            <label class="fw-bold"><?= h($questao->text) ?></label>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-sm-12">
                            <?php
                            echo $this->Form->control('avaliacao' . $questao->id, [
                                'type' => $questao->type,
                                'div' => false,
                                'label' => false,
                                'options' => $opcoes,
                                'empty' => 'Selecione',
                                'class' => 'form-select',
                            ]);
                            ?>
                        </div>
                    </div>
                    <?php
                } elseif ($questao->type === 'radio' || $questao->type === 'checkbox') {
                    echo $this->Form->control('questao_text' . $questao->id, [
                        'type' => 'hidden',
                        'value' => $opcoes
                    ]);
                    ?>
                    <div class="row mb-2">
                        <div class="col-sm-12">
                            <label class="fw-bold"><?= h($questao->text) ?></label>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-sm-12">
                            <?php
                            echo $this->Form->control('avaliacao' . $questao->id, [
                                'type' => $questao->type,
                                'div' => false,
                                'label' => false,
                                'options' => $opcoes,
                                'class' => 'form-check-input',
                                'nestedInput' => false,
                                'templates' => [
                                    'radioWrapper' => '<div class="form-check">{{input}}{{label}}</div>',
                                    'radio' => '<input type="radio" name="{{name}}" value="{{value}}"{{attrs}}>',
                                    'checkboxWrapper' => '<div class="form-check">{{input}}{{label}}</div>',
                                    'checkbox' => '<input type="checkbox" name="{{name}}" value="{{value}}"{{attrs}}>',
                                    'labelOption' => '<label class="form-check-label"{{attrs}}>{{text}}</label>'
                                ]
                            ]);
                            ?>
                        </div>
                    </div>
                    <?php
                } elseif ($questao->type === 'boolean') {
                    echo $this->Form->control('questao_text' . $questao->id, [
                        'type' => 'hidden',
                        'value' => $opcoes
                    ]);
                    ?>
                    <div class="row mb-2">
                        <div class="col-sm-12">
                            <label class="fw-bold"><?= h($questao->text) ?></label>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-sm-12">
                            <?php
                            echo $this->Form->control('avaliacao' . $questao->id, [
                                'type' => 'radio',
                                'div' => false,
                                'label' => false,
                                'default' => '0',
                                'options' => ['0' => 'Não', '1' => 'Sim'],
                                'class' => 'form-check-input',
                                'templates' => [
                                    'radioWrapper' => '<div class="form-check">{{input}}{{label}}</div>',
                                    'radio' => '<input type="radio" name="{{name}}" value="{{value}}"{{attrs}}>',
                                    'labelOption' => '<label class="form-check-label"{{attrs}}>{{text}}</label>',
                                ]
                            ]);
                            ?>
                        </div>
                    </div>
                    <?php
                } elseif ($questao->type === 'escala') {
                    echo $this->Form->control('questao_text' . $questao->id, [
                        'type' => 'hidden',
                        'value' => $opcoes
                    ]);
                    ?>
                    <div class="row mb-2">
                        <div class="col-sm-12">
                            <label class="fw-bold"><?= h($questao->text) ?></label>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-sm-12">
                            <?php
                            echo $this->Form->control('avaliacao' . $questao->id, [
                                'type' => 'number',
                                'div' => false,
                                'label' => false,
                                'default' => 1,
                                'min' => 1,
                                'max' => 5,
                                'class' => 'form-control',
                            ]);
                            ?>
                        </div>
                    </div>
                    <?php
                } elseif ($questao->type === 'text' || $questao->type === 'textarea') {
                    echo $this->Form->control('questao_text' . $questao->id, [
                        'type' => 'hidden',
                        'value' => $opcoes
                    ]);
                    ?>
                    <div class="row mb-2">
                        <div class="col-sm-12">
                            <label class="fw-bold"><?= h($questao->text) ?></label>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-sm-12">
                            <?php
                            echo $this->Form->control('avaliacao' . $questao->id, [
                                'type' => $questao->type,
                                'div' => false,
                                'label' => false,
                                'class' => 'form-control',
                            ]);
                            ?>
                        </div>
                    </div>
                    <?php
                } else {
                    echo $this->Form->control('questao_text' . $questao->id, [
                        'type' => 'hidden',
                        'value' => $opcoes
                    ]);
                    ?>
                    <div class="row mb-2">
                        <div class="col-sm-12">
                            <label class="fw-bold"><?= h($questao->text) ?></label>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-sm-12">
                            <?php
                            echo $this->Form->control('avaliacao' . $questao->id, [
                                'type' => 'text',
                                'div' => false,
                                'label' => false,
                                'class' => 'form-control',
                            ]);
                            ?>
                        </div>
                    </div>
                    <?php
                }
                ?>
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