<?php

include "conexao.php";

$mensagem = "";
$tipoMensagem = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    // Receber os dados do formulário
    $cpf = trim($_POST["cpf"] ?? "");
    $crm = trim($_POST["crm"] ?? "");
    $data_consulta = $_POST["data_consulta"] ?? "";
    $horario = $_POST["horario"] ?? "";
    $motivo = trim($_POST["motivo"] ?? "");
    $observacao = trim($_POST["observacao"] ?? "");
    $status = $_POST["status"] ?? "";

    // Buscar o paciente pelo CPF
    $SQL = "SELECT id, nome FROM paciente WHERE cpf = ?";

    $stmt = $conexao->prepare($SQL);

    if (!$stmt) {
        die("Erro ao buscar paciente: " . $conexao->error);
    }

    $stmt->bind_param("s", $cpf);
    $stmt->execute();

    $resultadoPaciente = $stmt->get_result();
    $paciente = $resultadoPaciente->fetch_assoc();

    $stmt->close();

    // Buscar o médico pelo CRM
    $SQL = "SELECT id, nome FROM medico WHERE crm = ?";

    $stmt = $conexao->prepare($SQL);

    if (!$stmt) {
        die("Erro ao buscar médico: " . $conexao->error);
    }

    $stmt->bind_param("s", $crm);
    $stmt->execute();

    $resultadoMedico = $stmt->get_result();
    $medico = $resultadoMedico->fetch_assoc();

    $stmt->close();

    // Verificar se paciente e médico existem
    if (!$paciente) {

        $mensagem = "Paciente não encontrado. Verifique o CPF.";
        $tipoMensagem = "erro";

    } elseif (!$medico) {

        $mensagem = "Médico não encontrado. Verifique o CRM.";
        $tipoMensagem = "erro";

    } else {

        // Cadastrar a consulta utilizando os IDs encontrados
        $SQL = "INSERT INTO faz_consulta
                (id_paciente, id_medico, data_consulta, horario,
                 motivo, observacao, status)
                VALUES (?, ?, ?, ?, ?, ?, ?)";

        $stmt = $conexao->prepare($SQL);

        if (!$stmt) {
            die("Erro ao preparar cadastro da consulta: " . $conexao->error);
        }

        $stmt->bind_param(
            "iisssss",
            $paciente["id"],
            $medico["id"],
            $data_consulta,
            $horario,
            $motivo,
            $observacao,
            $status
        );

        if ($stmt->execute()) {

            $mensagem = "Consulta cadastrada com sucesso!";
            $tipoMensagem = "sucesso";

        } else {

            $mensagem = "Erro ao cadastrar a consulta: " . $stmt->error;
            $tipoMensagem = "erro";

        }

        $stmt->close();
    }
}

?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Agendamento de Consultas</title>

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: Arial, Helvetica, sans-serif;
        }

        body {
            min-height: 100vh;
            background: linear-gradient(135deg, #e8f0fe, #f5f7fb);
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 30px 15px;
        }

        .container {
            width: 100%;
            max-width: 650px;
            background: white;
            padding: 35px;
            border-radius: 16px;
            box-shadow: 0 10px 35px rgba(0, 0, 0, 0.08);
        }

        .cabecalho {
            text-align: center;
            margin-bottom: 28px;
        }

        .icone {
            width: 65px;
            height: 65px;
            background: #e8f0fe;
            color: #2563eb;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 30px;
            margin: 0 auto 15px;
        }

        h1 {
            color: #1e293b;
            font-size: 27px;
            margin-bottom: 10px;
        }

        .cabecalho p {
            color: #64748b;
            font-size: 14px;
            line-height: 1.5;
        }

        .secao {
            color: #2563eb;
            font-size: 16px;
            margin: 25px 0 15px;
            padding-bottom: 10px;
            border-bottom: 1px solid #e2e8f0;
        }

        .campo {
            margin-bottom: 18px;
        }

        label {
            display: block;
            color: #334155;
            font-size: 14px;
            font-weight: bold;
            margin-bottom: 8px;
        }

        input, select, textarea {
            width: 100%;
            padding: 12px 13px;
            border: 1px solid #cbd5e1;
            border-radius: 8px;
            font-size: 14px;
            color: #1e293b;
            background: white;
            outline: none;
        }

        input:focus, select:focus, textarea:focus {
            border-color: #2563eb;
            box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.12);
        }

        textarea {
            resize: vertical;
            min-height: 90px;
        }

        .linha {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 15px;
        }

        button {
            width: 100%;
            padding: 14px;
            background: #2563eb;
            color: white;
            border: none;
            border-radius: 8px;
            font-size: 16px;
            font-weight: bold;
            cursor: pointer;
            margin-top: 10px;
            transition: 0.2s;
        }

        button:hover {
            background: #1d4ed8;
        }

        .mensagem {
            padding: 13px;
            border-radius: 8px;
            margin-bottom: 20px;
            font-size: 14px;
            overflow-wrap: anywhere;
        }

        .sucesso {
            background: #dcfce7;
            color: #166534;
        }

        .erro {
            background: #fee2e2;
            color: #991b1b;
        }

        .rodape {
            margin-top: 22px;
            text-align: center;
            color: #94a3b8;
            font-size: 12px;
        }

        @media (max-width: 500px) {
            .container {
                padding: 25px 20px;
            }

            .linha {
                grid-template-columns: 1fr;
                gap: 0;
            }

            h1 {
                font-size: 23px;
            }
        }
    </style>
</head>

<body>

    <div class="container">

        <div class="cabecalho">
            <div class="icone">🩺</div>

            <h1>Agendamento de Consulta</h1>

            <p>
                Informe os dados do paciente, do médico
                e os detalhes da consulta.
            </p>
        </div>

        <?php if ($mensagem != "") { ?>

            <div class="mensagem <?= $tipoMensagem ?>">
                <?= htmlspecialchars($mensagem, ENT_QUOTES, 'UTF-8') ?>
            </div>

        <?php } ?>

        <form method="POST">

            <h3 class="secao">Identificação</h3>

            <div class="campo">
                <label for="cpf">CPF do paciente</label>
                <input
                    type="text"
                    id="cpf"
                    name="cpf"
                    placeholder="Digite o CPF cadastrado"
                    required
                >
            </div>

            <div class="campo">
                <label for="crm">CRM do médico</label>
                <input
                    type="text"
                    id="crm"
                    name="crm"
                    placeholder="Digite o CRM cadastrado"
                    required
                >
            </div>

            <h3 class="secao">Detalhes da consulta</h3>

            <div class="linha">

                <div class="campo">
                    <label for="data_consulta">Data da consulta</label>
                    <input
                        type="date"
                        id="data_consulta"
                        name="data_consulta"
                        required
                    >
                </div>

                <div class="campo">
                    <label for="horario">Horário</label>
                    <input
                        type="time"
                        id="horario"
                        name="horario"
                        required
                    >
                </div>

            </div>

            <div class="campo">
                <label for="motivo">Motivo da consulta</label>
                <input
                    type="text"
                    id="motivo"
                    name="motivo"
                    placeholder="Ex.: consulta de rotina"
                    required
                >
            </div>

            <div class="campo">
                <label for="observacao">Observações</label>
                <textarea
                    id="observacao"
                    name="observacao"
                    placeholder="Informações adicionais sobre a consulta"
                ></textarea>
            </div>

            <div class="campo">
                <label for="status">Status da consulta</label>

                <select id="status" name="status" required>
                    <option value="Agendada">Agendada</option>
                    <option value="Realizada">Realizada</option>
                    <option value="Cancelada">Cancelada</option>
                </select>
            </div>

            <button type="submit">Cadastrar Consulta</button>

        </form>

        <div class="rodape">
            Sistema de Gestão de Consultas
        </div>

    </div>

</body>
</html>
