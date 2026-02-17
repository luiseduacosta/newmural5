<?php
/**
 * CakePHP(tm) : Rapid Development Framework (https://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 * @link      https://cakephp.org CakePHP(tm) Project
 * @since     0.10.0
 * @license   https://opensource.org/licenses/mit-license.php MIT License
 * @var \App\View\AppView $this
 */
use Cake\Cache\Cache;
use Cake\Core\Configure;
use Cake\Core\Plugin;
use Cake\Datasource\ConnectionManager;
use Cake\Error\Debugger;
use Cake\Http\Exception\NotFoundException;

$this->disableAutoLayout();

if (!Configure::read('debug')):
    throw new NotFoundException(
        'Please replace templates/Pages/home.php with your own version or re-enable debug mode.'
    );
endif;

$cakeDescription = 'Banco de TCCs e de ofertas de vagas de estágio da ESS/UFRJ. Feito com o framework CakePHP';
?>
<!DOCTYPE html>
<html>

<head>
    <?= $this->Html->charset() ?>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>
        <?= $cakeDescription ?>:
        <?= $this->fetch('title') ?>
    </title>
    <?= $this->Html->meta('icon') ?>

    <link href="https://fonts.googleapis.com/css?family=Raleway:400,700" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/normalize.css@8.0.1/normalize.css">

<!--
Cake 4.0
    <?= $this->Html->css('milligram.min.css') ?>
    <?= $this->Html->css('cake.css') ?>
    <?= $this->Html->css('home.css') ?>
-->

<!-- Cake 3.0 
    <?= $this->Html->css('base.css') ?>
    <?= $this->Html->css('style.css') ?>
    <?= $this->Html->css('home.css') ?>
-->

    <?= $this->fetch('meta') ?>
    <?= $this->fetch('css') ?>
    <?= $this->fetch('script') ?>

<!--
    <meta http-equiv="refresh" content="0; url=tccestudantes" />
-->
</head>

<body>
    <header>
        <div class="d-flex justify-content-center">
            <a href="http://ess.ufrj.br/" target="_blank">
                <img alt="Escola de Serviço Social - CFCH - UFRJ"
                    src="http://ess.ufrj.br/templates/joomtic3/images/banner_logo.jpg" width="100%" height="20%" />
            </a>
            <h1>
                <?= $this->Html->link('Escola de Serviço Social', ['http://www.ess.ufrj.br']) ?>
            </h1>
        </div>
    </header>
    <p><a href="Monografias">Clique aqui se não foi direcionado para o site</a></p>
</body>

</html>
<?php

header("location: monografias/index/");
// header("location: muralestagios/index/");

die();