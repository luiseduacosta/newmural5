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
$user = $this->getRequest()->getAttribute('identity');
// echo 'Usuário: ' . $user->username;
// die();
?>

<nav class="navbar navbar-expand-lg py-2 navbar-light bg-light" id="actions-sidebar">
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarTogglerMenuEsquerdo"
        aria-controls="navbarTogglerMenuEsquerdo" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarTogglerMenuEsquerdo">
        <ul class="navbar-nav mr-auto mt-lg-0">
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
                    <?= $this->Html->link(__('Professores'), ['controller' => 'Professores', 'action' => 'index'], ['class' => 'nav-link']) ?>
                </li>
                <li class='nav-item'>
                    <?= $this->Html->link(__('Áreas'), ['controller' => 'Areamonografias', 'action' => 'index'], ['class' => 'nav-link']) ?>
                </li>
                <li class='nav-item'>
                    <?= $this->Html->link(__('Trajetórias'), ['controller' => 'Estagiarios', 'action' => 'index'], ['class' => 'nav-link']) ?>
                </li>
            <?php endif; ?>
            <li class='nav-item'>
                <?= $this->Html->link(__('Mural'), ['controller' => 'Muralestagios', 'action' => 'index'], ['class' => 'nav-link']) ?>
            </li>
            <?php if (isset($user) && !empty($user)): ?>
                <li class='nav-item'>
                    <?= $this->Html->link(__('Sair'), ['controller' => 'Users', 'action' => 'logout'], ['class' => 'nav-link']) ?>
                </li>
            <?php else: ?>
                <li class='nav-item'>
                    <?= $this->Html->link(__('Login'), ['controller' => 'Users', 'action' => 'login'], ['class' => 'nav-link']) ?>
                </li>
            <?php endif; ?>
        </ul>
    </div>
</nav>