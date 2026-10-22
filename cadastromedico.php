<?php

    include "conexao.php";

?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Cadastro de Médicos</title>

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
            max-width: 550px;
            background-color: #ffffff;
            padding: 35px;
            border-radius: 16px;
            box-shadow: 0 10px 35px rgba(0, 0, 0, 0.08);
        }

        .cabecalho {
            text-align: center;
            margin-bottom: 30px;
        }

        .icone {
            width: 65px;
            height: 65px;
            background-color: #e8f0fe;
            color: #2563eb;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 30px;
            margin: 0 auto 15px;
        }

        h2 {
            color: #1e293b;
            font-size: 27px;
            margin-bottom: 8px;
        }

        .cabecalho p {
            color: #64748b;
            font-size: 14px;
            line-height: 1.5;
        }

        .campo {
            margin-bottom: 20px;
        }

        label {
            display: block;
            color: #334155;
            font-size: 14px;
            font-weight: bold;
            margin-bottom: 8px;
        }

        input {
            width: 100%;
            padding: 13px 14px;
            border: 1px solid #cbd5e1;
            border-radius: 8px;
            font-size: 15px;
            color: #1e293b;
            background-color: #ffffff;
            outline: none;
            transition: 0.2s;
        }

        input:focus {
            border-color: #2563eb;
            box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.12);
        }

        input[type="file"] {
            background-color: #f8fafc;
            padding: 10px;
            cursor: pointer;
        }

        button {
            width: 100%;
            padding: 14px;
            background-color: #2563eb;
            color: #ffffff;
            border: none;
            border-radius: 8px;
            font-size: 16px;
            font-weight: bold;
            cursor: pointer;
            transition: 0.2s;
            margin-top: 5px;
        }

        button:hover {
            background-color: #1d4ed8;
            transform: translateY(-1px);
        }

        .rodape {
            margin-top: 22px;
            text-align: center;
            color: #94a3b8;
            font-size: 12px;
        }

        @media (max-width: 480px) {
            .container {
                padding: 25px 20px;
            }

            h2 {
                font-size: 24px;
            }
        }
    </style>

</head>

<body>

    <div class="container">

        <div class="cabecalho">
            <div class="icone">⚕</div>

            <h2>Cadastro de Médico</h2>

            <p>
                Preencha os campos abaixo para registrar
                as informações do profissional.
            </p>
        </div>

        <form method="POST" enctype="multipart/form-data">

            <div class="campo">
                <label>Nome Completo</label>
                <input type="text" name="nome"
                       placeholder="Digite o nome completo">
            </div>

            <div class="campo">
                <label>Digite o CRM</label>
                <input type="text" name="crm"
                       placeholder="Digite o número do CRM">
            </div>

            <div class="campo">
                <label>Especialidade</label>
                <input type="text" name="especialidade"
                       placeholder="Ex.: Cardiologia">
            </div>

            <div class="campo">
                <label>Telefone</label>
                <input type="text" name="telefone"
                       placeholder="(00) 00000-0000">
            </div>

            <div class="campo">
                <label>E-mail</label>
                <input type="text" name="email"
                       placeholder="exemplo@email.com">
            </div>

            <div class="campo">
                <label>Valor da Consulta (R$)</label>
                <input type="number" name="valor_consulta"
                       placeholder="Ex.: 150" step="0.01">
            </div>

            <div class="campo">
                <label>Foto do Médico</label>
                <input type="file" name="imagem"
                       accept="image/*">
            </div>

            <button type="submit">Cadastrar Médico</button>

        </form>

        <div class="rodape">
            Sistema de Cadastro Médico
        </div>

    </div>

</body>

</html>

<?php

    if (isset($_POST["nome"]))
        {
            $nome = $_POST["nome"];
            $crm = $_POST["crm"];
            $especialidade = $_POST["especialidade"];
            $telefone = $_POST["telefone"];
            $email = $_POST["email"];
            $valor_consulta = $_POST["valor_consulta"];
            $foto = $_FILES["imagem"];

            $caminho = "imagem/" . $crm . ".jpg";

            move_uploaded_file(
                $foto["tmp_name"],
                $caminho
            );

            $SQL = "INSERT INTO medico (nome, crm, especialidade, telefone, email, valor_consulta)
                    VALUES ('$nome', '$crm', '$especialidade', '$telefone', '$email', '$valor_consulta')";

            $conexao->query($SQL);

        }

?>
