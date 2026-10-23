<?php

    include "conexao.php";

    $SQL = "SELECT * FROM medico ORDER BY nome ASC";
    $resultado = $conexao->query($SQL);

?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Médicos Cadastrados</title>

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: Arial, Helvetica, sans-serif;
        }

        body {
            background: #f1f5f9;
            padding: 40px 20px;
            color: #1e293b;
        }

        .container {
            max-width: 1200px;
            margin: auto;
        }

        .cabecalho {
            text-align: center;
            margin-bottom: 35px;
        }

        .cabecalho h1 {
            font-size: 32px;
            margin-bottom: 10px;
            color: #1e293b;
        }

        .cabecalho p {
            color: #64748b;
            font-size: 15px;
        }

        .quantidade {
            display: inline-block;
            margin-top: 18px;
            padding: 9px 16px;
            background: #dbeafe;
            color: #1d4ed8;
            border-radius: 20px;
            font-size: 14px;
            font-weight: bold;
        }

        .medicos {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(290px, 1fr));
            gap: 25px;
        }

        .card {
            background: white;
            border-radius: 15px;
            overflow: hidden;
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.06);
            transition: 0.2s;
        }

        .card:hover {
            transform: translateY(-4px);
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.10);
        }

        .foto {
            width: 100%;
            height: 240px;
            background: #e2e8f0;
            overflow: hidden;
        }

        .foto img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .sem-foto {
            height: 100%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #64748b;
            font-size: 15px;
        }

        .informacoes {
            padding: 24px;
        }

        .informacoes h2 {
            font-size: 21px;
            margin-bottom: 8px;
            color: #1e293b;
        }

        .especialidade {
            display: inline-block;
            background: #dcfce7;
            color: #166534;
            padding: 7px 12px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: bold;
            margin-bottom: 20px;
        }

        .dado {
            padding: 12px 0;
            border-bottom: 1px solid #e2e8f0;
            overflow-wrap: anywhere;
        }

        .dado:last-child {
            border-bottom: none;
        }

        .dado strong {
            display: block;
            color: #64748b;
            font-size: 12px;
            text-transform: uppercase;
            margin-bottom: 6px;
        }

        .dado span {
            color: #334155;
            font-size: 14px;
        }

        .valor {
            color: #15803d !important;
            font-size: 19px !important;
            font-weight: bold;
        }

        .vazio {
            background: white;
            text-align: center;
            padding: 50px 20px;
            border-radius: 15px;
            color: #64748b;
            grid-column: 1 / -1;
        }

        .vazio h2 {
            margin-bottom: 12px;
            color: #334155;
        }

        .botao {
            display: inline-block;
            margin-top: 25px;
            padding: 13px 20px;
            background: #2563eb;
            color: white;
            text-decoration: none;
            border-radius: 8px;
            font-weight: bold;
            transition: 0.2s;
        }

        .botao:hover {
            background: #1d4ed8;
        }

        @media (max-width: 480px) {
            body {
                padding: 25px 14px;
            }

            .cabecalho h1 {
                font-size: 26px;
            }
        }
    </style>

</head>

<body>

    <div class="container">

        <div class="cabecalho">

            <h1>👨‍⚕️ Médicos Cadastrados</h1>

            <p>
                Consulte as informações dos profissionais cadastrados no sistema.
            </p>

            <?php if ($resultado) { ?>
                <div class="quantidade">
                    Total de médicos: <?= $resultado->num_rows ?>
                </div>
            <?php } ?>

        </div>

        <div class="medicos">

            <?php if ($resultado && $resultado->num_rows > 0) { ?>

                <?php while ($medico = $resultado->fetch_assoc()) { ?>

                    <?php
                        $crmArquivo = preg_replace(
                            '/[^a-zA-Z0-9_-]/',
                            '',
                            (string) $medico["crm"]
                        );

                        $caminhoFoto = "imagem/" . $crmArquivo . ".jpg";
                    ?>

                    <div class="card">

                        <div class="foto">

                            <?php if (file_exists($caminhoFoto)) { ?>

                                <img
                                    src="<?= htmlspecialchars($caminhoFoto, ENT_QUOTES, 'UTF-8') ?>"
                                    alt="Foto de <?= htmlspecialchars($medico["nome"], ENT_QUOTES, 'UTF-8') ?>"
                                >

                            <?php } else { ?>

                                <div class="sem-foto">
                                    Foto não cadastrada
                                </div>

                            <?php } ?>

                        </div>

                        <div class="informacoes">

                            <h2>
                                <?= htmlspecialchars($medico["nome"], ENT_QUOTES, 'UTF-8') ?>
                            </h2>

                            <div class="especialidade">
                                <?= htmlspecialchars($medico["especialidade"], ENT_QUOTES, 'UTF-8') ?>
                            </div>

                            <div class="dado">
                                <strong>CRM</strong>
                                <span>
                                    <?= htmlspecialchars((string) $medico["crm"], ENT_QUOTES, 'UTF-8') ?>
                                </span>
                            </div>

                            <div class="dado">
                                <strong>Telefone</strong>
                                <span>
                                    <?= htmlspecialchars($medico["telefone"] ?? "", ENT_QUOTES, 'UTF-8') ?: "Não informado" ?>
                                </span>
                            </div>

                            <div class="dado">
                                <strong>E-mail</strong>
                                <span>
                                    <?= htmlspecialchars($medico["email"] ?? "", ENT_QUOTES, 'UTF-8') ?: "Não informado" ?>
                                </span>
                            </div>

                            <div class="dado">
                                <strong>Valor da consulta</strong>
                                <span class="valor">
                                    R$ <?= number_format((float) $medico["valor_consulta"], 2, ",", ".") ?>
                                </span>
                            </div>

                        </div>

                    </div>

                <?php } ?>

            <?php } else { ?>

                <div class="vazio">

                    <h2>Nenhum médico encontrado</h2>

                    <p>
                        Ainda não existem médicos cadastrados no sistema.
                    </p>

                    <a href="cadastromedico.php" class="botao">
                        Cadastrar médico
                    </a>

                </div>

            <?php } ?>

        </div>

    </div>

</body>

</html>