<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Monografia $monografia
 */
?>

<?php $user = $this->getRequest()->getAttribute('identity'); ?>

<nav class='navbar navbar-expand-lg navbar-light py-2 navbar-fixed-top' style="background-color: #2b6c9c;">
    <?= $this->Html->link("Mural", ['controller' => 'Muralestagios', 'action' => 'index'], ['class' => 'nav-link', 'style' => 'color: white;']); ?>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarPrincipal">
        <span class="navbar-toggler-icon"></span>
    </button>

    <div style='font-size: 90%', class='collapse navbar-collapse' id='navbarPrincipal'>
        <ul class="navbar-nav mr-auto">

            <?php
            if ($id_categoria == 1):
                ?>

                <li class="nav-item dropdown">
                    <a style='color:white' class="nav-link dropdown-toggle" data-bs-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">Declarações</a>
                    <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                        <?php echo $this->Html->link("Termo de compromisso", "/estagiarios/termodecompromisso?registro=" . $this->getRequest()->getSession()->read('numero'), ['class' => 'dropdown-item', 'style' => 'background-color: #2b6c9c; color: white;']); ?>
                        <?php echo $this->Html->link("Folha de avaliação discente", "/estagiarios/selecionaavaliacaodiscente/" . $this->getRequest()->getSession()->read('estagiario_id'), ['class' => 'dropdown-item', 'style' => 'background-color: #2b6c9c; color: white']); ?>
                        <?php echo $this->Html->link("Formulário de avaliação discente on-line", "/avaliacoes/index/" . $this->getRequest()->getSession()->read('estagiario_id'), ['class' => 'dropdown-item', 'style' => 'background-color: #2b6c9c; color: white']); ?>
                        <?php echo $this->Html->link("Folha de atividades", "/estagiarios/selecionafolhadeatividades/" . $this->getRequest()->getSession()->read('estagiario_id'), ['class' => 'dropdown-item', 'style' => 'background-color: #2b6c9c; color: white']); ?>
                        <?php echo $this->Html->link("Folha de atividades on-line", "/folhadeatividades/selecionafolhadeatividades/" . $this->getRequest()->getSession()->read('estagiario_id'), ['class' => 'dropdown-item', 'style' => 'background-color: #2b6c9c; color: white']); ?>
                        <?php echo $this->Html->link("Declaração de estágio", "/estagiarios/selecionadeclaracaodeestagio/" . $this->getRequest()->getSession()->read('estagiario_id'), ['class' => 'dropdown-item', 'style' => 'background-color: #2b6c9c; color: white']); ?>
                    </div>
                </li>

                <li class="nav-item">
                    <?php echo $this->Html->link("Estagiários", "/Estagiarios/index", ['class' => 'nav-link', 'style' => 'background-color: #2b6c9c; color: white']); ?>
                </li>
                <li class="nav-item">
                    <?php echo $this->Html->link("Instituições", "/instituicoes/index", ['escape' => FALSE, 'class' => 'nav-link', 'style' => 'background-color: #2b6c9c; color: white']); ?>
                </li>
                <li class="nav-item">
                    <?php echo $this->Html->link("Supervisores", "/Supervisores/index/ordem:nome", ['class' => 'nav-link', 'style' => 'background-color: #2b6c9c; color: white']); ?>
                </li>
                <li class="nav-item">
                    <?php echo $this->Html->link("Professores", "/Professores/index/", ['class' => 'nav-link', 'style' => 'background-color: #2b6c9c; color: white']); ?>
                </li>
                <li class="nav-item dropdown">
                    <a style='color: white' class="nav-link dropdown-toggle" data-bs-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">Administração</a>
                    <div class="dropdown-menu">
                        <?php echo $this->Html->link('Configuração', '/Configuracao/view/1', ['class' => 'dropdown-item', 'style' => 'background-color: #2b6c9c; color: white']); ?>
                        <?php echo $this->Html->link('Usuários', '/userestagios/index', ['class' => 'dropdown-item', 'style' => 'background-color: #2b6c9c; color: white']); ?>
                        <?php echo $this->Html->link('Planilha seguro', '/estudantes/planilhaseguro/', ['class' => 'dropdown-item', 'style' => 'background-color: #2b6c9c; color: white']); ?>
                        <?php echo $this->Html->link('Planilha CRESS', '/estudantes/planilhacress/', ['class' => 'dropdown-item', 'style' => 'background-color: #2b6c9c; color: white']); ?>
                        <?php echo $this->Html->link('Carga horária', '/Alunos/cargahoraria/', ['class' => 'dropdown-item', 'style' => 'background-color: #2b6c9c; color: white']); ?>
                        <?php echo $this->Html->link('Complemento período', '/Complementos/index/', ['class' => 'dropdown-item', 'style' => 'background-color: #2b6c9c; color: white']); ?>
                        <?php echo $this->Html->link('Extensão', '/Extensaos/index/', ['class' => 'dropdown-item', 'style' => 'background-color: #2b6c9c; color: white']); ?>
                    </div>
                </li>
            <?php endif; ?>
            <li class = "nav-item">
                <?php echo $this->Html->link('Grupo Google', 'https://groups.google.com/forum/#!forum/estagio_ess', ['class' => 'nav-link', 'style' => 'background-color: #2b6c9c; color: white']); ?>
            </li>
            <li class = "nav-item">
                <?php echo $this->Html->link('Fale conosco', 'mailto: estagio@ess.ufrj.br', ['class' => 'nav-link', 'style' => 'background-color: #2b6c9c; color: white']); ?>
            </li>
        </ul>

        <ul class = "navbar-nav ml-auto">
            <?php
            switch ($id_categoria) {
                case 1: // Administrador
                    ?>
                    <li class = "nav-item">
                        <?php echo $this->Html->link('Sair', '/userestagios/logout/', ['class' => 'nav-link', 'style' => 'background-color: #2b6c9c; color: white']); ?>
                    </li>
                    <?php
                    break;
                case 2: // Estudante
                    $estagiario_id = $this->getRequest()->getSession()->read('estagiario_id');
                    ?>
                    <li class="nav-item">
                        <?php if ($estagiario_id): ?>
                            <?php echo $this->Html->link("Termo de compromisso", "/estagiarios/termodecompromisso/" . $this->getRequest()->getSession()->read('estagiario_id'), ['class' => 'btn btn-white btn-sm btn-block', 'style' => 'background-color: #2b6c9c; color: white; width: 100px; height: 50px']); ?>
                        <?php else: ?>
                            <?php echo $this->Html->link("Termo de compromisso", "/estagiarios/termodecompromisso/", ['class' => 'btn btn-white btn-sm btn-block', 'style' => 'background-color: #2b6c9c; color: white; width: 150px']); ?>
                        <?php endif; ?>
                    </li>
                    <?php if ($estagiario_id): ?>
                        <li class="nav-item">
                            <?php echo $this->Html->link("Declaração de estágio", "/estagiarios/selecionadeclaracaodeestagio/" . $this->getRequest()->getSession()->read('estagiario_id'), ['class' => 'btn btn-white btn-sm btn-block', 'style' => 'background-color: #2b6c9c; color: white; width: 100px']); ?>
                        </li>
                        <li class="nav-item">
                            <?php echo $this->Html->link("Folha de atividades", "/estagiarios/selecionafolhadeatividades/" . $this->getRequest()->getSession()->read('estagiario_id'), ['class' => 'btn btn-white btn-sm btn-block', 'style' => 'background-color: #2b6c9c; color: white; width: 100px']); ?>
                        </li>
                        <li>
                            <?php echo $this->Html->link("Preencher atividades on-line", "/folhadeatividades/selecionafolhadeatividades/" . $this->getRequest()->getSession()->read('estagiario_id'), ['class' => 'btn btn-white btn-sm btn-block', 'style' => 'background-color: #2b6c9c; color: white; width: 100px']); ?>
                        </li>
                        <li class="nav-item">
                            <?php echo $this->Html->link("Avaliação discente", "/estagiarios/selecionaavaliacaodiscente/" . $this->getRequest()->getSession()->read('estagiario_id'), ['class' => 'btn btn-white btn-sm btn-block', 'style' => 'background-color: #2b6c9c; color: white; width: 100px']); ?>
                        </li>
                        <li class="nav-item">
                            <?php echo $this->Html->link("Avaliação discente on-line", "/avaliacoes/index/" . $this->getRequest()->getSession()->read('estagiario_id'), ['class' => 'btn btn-white btn-sm btn-block', 'style' => 'background-color: #2b6c9c; color: white; width: 100px']); ?>
                        </li>
                    <?php endif; ?>
                    <li class="nav-item">
                        <?php echo $this->Html->link("Meus dados", "/estudantes/view?registro=" . $this->getRequest()->getSession()->read('numero'), ['class' => 'btn btn-white btn-sm btn-block', 'style' => 'background-color: #2b6c9c; color: white; width: 100px; height: 50px']); ?>
                    </li>
                    <li class = "nav-item">
                        <?php echo $this->Html->link('Sair', '/userestagios/logout/', ['class' => 'btn btn-white btn-sm btn-block', 'style' => 'background-color: #2b6c9c; color: white; width: 100px; height: 50px']); ?>
                    </li>
                    <?php
                    break;
                case 3: // Professor
                    ?>
                    <?php if ($this->getRequest()->getSession()->read('estagiario') == 1): ?>
                        <li class="nav-item">
                            <?php echo $this->Html->link("Notas e carga horária", "/Estagiarios/lancanota?siape=" . $this->getRequest()->getSession()->read('numero'), ['class' => 'nav-link', 'style' => 'color: white']); ?>
                        </li>
                    <?php endif; ?>
                    <li class="nav-item">
                        <?php echo $this->Html->link("Meus dados", "/Professores/view?siape=" . $this->getRequest()->getSession()->read('numero'), ['class' => 'nav-link', 'style' => 'color: white']); ?>
                    </li>
                    <li class = "nav-item">
                        <?php echo $this->Html->link('Sair', '/Userestagios/logout/', ['class' => 'nav-link', 'style' => 'background-color: #2b6c9c; color: white']); ?>
                    </li>
                    <?php
                    break;
                case 4: // Supervisor
                    ?>
                    <li class="nav-item">
                        <?php echo $this->Html->link("Avaliação discente", "/avaliacoes/supervisoravaliacao?cress=" . $this->getRequest()->getAttribute('identity')['numero'], ['class' => 'btn btn-white btn-lg btn-block', 'style' => 'background-color: #2b6c9c; color: white; width: 100px']); ?>
                    </li>
                    <li class="nav-item">
                        <?php echo $this->Html->link("Meus dados", "/Supervisores/view?cress=" . $this->getRequest()->getSession()->read('numero'), ['class' => 'nav-link', 'style' => 'background-color: #2b6c9c; color: white']); ?>
                    </li>
                    <li class = "nav-item">
                        <?php echo $this->Html->link('Sair', '/Userestagios/logout/', ['class' => 'nav-link', 'style' => 'background-color: #2b6c9c; color: white']); ?>
                    </li>
                    <?php
                    break;
                default:
                    ?>
                    <li class="nav-item">
                        <?php echo $this->Html->link("Login", ['controller' => 'Userestagios', 'action' => 'login'], ['class' => 'nav-link', 'style' => 'background-color: #2b6c9c; color: white']); ?>
                    </li>
                <?php
            }
            ?>
        </ul>
    </div>
</nav>
