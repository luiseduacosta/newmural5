<?php

// pr($aluno->turno);
// die();

$dia = strftime('%e', time());
$mes = strftime('%B', time());
$ano = strftime('%Y', time());
// pr($aluno['aluno']['turno']);
if ($aluno->turno == 'diurno'):
    $duracaocurso = '8';
elseif ($aluno->turno == 'noturno'):
    $duracaocurso = '10';
endif;
// die($duracaocurso);
?>

<body style="max-width: 100%; margin: 50px">
    <h1 style="text-align:center">
        <img src="data:image/png;base64,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" alt="ESS" width="200" height="50" />
        <br />
        Coordenação de Estágio<br />
        Declaração
    </h1>
    <br />
    <br />
    <p style="text-align:justify; line-height: 2.5;">
        Declaramos que o/a aluno <b><?= $aluno->nome; ?></b> 
        inscrito(a) no CPF sob o nº <?= $aluno->cpf; ?> 
        e no RG nº <?= $aluno->identidade; ?> 
        expedido por <?= $aluno->orgao; ?>, 
        matriculado(a) no Curso de Serviço Social da 
        Universidade Federal do Rio de Janeiro com o número <?= $aluno->registro; ?>, 
        ingressou em <?= $aluno->ingresso ?> no turno <?= ucfirst($aluno->turno); ?>
        cursando atualmente <?= $totalperiodos ?><sup>o</sup> período.
    <p>

    <p style="text-align:justify; line-height: 2.5;">
        O turno <?= ucfirst($aluno->turno); ?> do curso de Serviço Social consta de <?= ($aluno->turno == 'diurno') ? '8': '10'; ?> semestres.
    </p>
    <br />
    <br />
    <p style="text-align:right">Rio de Janeiro, <?= $dia; ?> de <?= $mes; ?> de <?= $ano; ?>.</p>

    <br style='line-height: 10.0'/>

    <table style="width:100%">
        <tr>
            <td style="text-decoration: overline;">Coordenação de Estágio</td>
        </tr>
        <tr>
            <td>Escola de Serviço Social</td>
        </tr>
        <tr>
            <td>Universidade Federal do Rio de Janeiro</td>
        </tr>
    </table>
</body>