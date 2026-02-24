<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Monografia $monografia
 */
use Cake\ORM\TableRegistry;
$user = $this->getRequest()->getAttribute('identity');
?>

<nav class="navbar navbar-expand-lg py-2 navbar-light bg-secondary">
    <div class="container-fluid">
        <?= $this->Html->link("Monografias", ['controller' => 'Monografias', 'action' => 'index'], ['class' => 'navbar-brand']); ?>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarPrincipal"
            aria-controls="navbarPrincipal" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarPrincipal">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class='nav-item'>
                    <?= $this->Html->link(__('Agenda TCC'), ['controller' => 'Agendamentotccs', 'action' => 'index'], ['class' => 'nav-link']) ?>
                </li>
                <li class='nav-item'>
                    <?= $this->Html->link(__('Monografias'), ['controller' => 'Monografias', 'action' => 'index'], ['class' => 'nav-link']) ?>
                </li>
                <?php if (isset($user) && $user->categoria == 1): ?>
                    <li class='nav-item'>
                        <?= $this->Html->link(__('Estudantes'), ['controller' => 'Tccestudantes', 'action' => 'index'], ['class' => 'nav-link']) ?>
                    </li>
                    <li class='nav-item'>
                        <?= $this->Html->link(__('Docentes'), ['controller' => 'Docentes', 'action' => 'index'], ['class' => 'nav-link']) ?>
                    </li>
                    <li class='nav-item'>
                        <?= $this->Html->link(__('Áreas'), ['controller' => 'Areamonografias', 'action' => 'index'], ['class' => 'nav-link']) ?>
                    </li>
                    <li class='nav-item'>
                        <?= $this->Html->link(__('Trajetórias'), ['controller' => 'Estagiariomonografias', 'action' => 'index'], ['class' => 'nav-link']) ?>
                    </li>
                <?php endif; ?>
            </ul>
            <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                <li class='nav-item'>
                    <?= $this->Html->link(__('Mural'), ['controller' => 'Muralestagios', 'action' => 'index'], ['class' => 'btn btn-info me-1']) ?>
                </li>
                <?php if (isset($user) && !empty($user)): ?>
                    <?php if ($user->categoria == 2):
                        $estudante = TableRegistry::getTableLocator()->get('Estudantes')->find()->where(['Estudantes.id' => $user->aluno_id])->first();
                        ?>
                        <li class='nav-item'>
                            <?= $this->Html->link($user->email, ['controller' => 'Estudantes', 'action' => 'view', $user->aluno_id], ['class' => 'btn btn-primary me-1']) ?>
                        </li>
                    <?php endif; ?>
                <?php else: ?>
                    <li class='nav-item ms-auto'><span class="btn btn-secondary"><?= 'Visitante' ?></span></li>
                <?php endif; ?>
                <?php if (isset($user) && !empty($user)): ?>
                    <li class="nav-item">
                        <?= $this->Html->link(__('Sair'), ['controller' => 'Users', 'action' => 'logout'], ['class' => 'nav-link']) ?>
                    </li>
                <?php else: ?>
                    <li class="nav-item">
                        <?= $this->Html->link(__('Entrar'), ['controller' => 'Users', 'action' => 'login'], ['class' => 'nav-link']) ?>
                    </li>
                <?php endif; ?>
            </ul>
        </div>
    </div>
</nav>