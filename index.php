
<?php

    include "conexao.php";

?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Cadastro de Pacientes</title>

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

        input {
            width: 100%;
            padding: 12px 13px;
            border: 1px solid #cbd5e1;
            border-radius: 8px;
            font-size: 14px;
            color: #1e293b;
            background: white;
            outline: none;
            transition: 0.2s;
        }

        input:focus {
            border-color: #2563eb;
            box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.12);
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

            <div class="icone">👤</div>

            <h1>Cadastro de Paciente</h1>

            <p>
                Preencha os campos abaixo para registrar
                as informações do paciente.
            </p>

        </div>

        <form method="POST">

            <h3 class="secao">Dados pessoais</h3>

            <div class="campo">
                <label for="nome">Nome completo</label>
                <input
                    type="text"
                    id="nome"
                    name="nome"
                    placeholder="Digite o nome completo"
                >
            </div>

            <div class="linha">

                <div class="campo">
                    <label for="data_nascimento">Data de nascimento</label>
                    <input
                        type="date"
                        id="data_nascimento"
                        name="data_nascimento"
                    >
                </div>

                <div class="campo">
                    <label for="cpf">CPF</label>
                    <input
                        type="text"
                        id="cpf"
                        name="cpf"
                        placeholder="Digite o CPF"
                    >
                </div>

            </div>

            <h3 class="secao">Contato</h3>

            <div class="campo">
                <label for="email">E-mail</label>
                <input
                    type="email"
                    id="email"
                    name="email"
                    placeholder="exemplo@email.com"
                >
            </div>

            <div class="campo">
                <label for="telefone">Telefone</label>
                <input
                    type="tel"
                    id="telefone"
                    name="telefone"
                    placeholder="(00) 00000-0000"
                >
            </div>

            <div class="campo">
                <label for="endereco">Endereço</label>
                <input
                    type="text"
                    id="endereco"
                    name="endereco"
                    placeholder="Rua, número e bairro"
                >
            </div>

            <div class="campo">
                <label for="cidade">Cidade</label>
                <input
                    type="text"
                    id="cidade"
                    name="cidade"
                    placeholder="Digite a cidade"
                >
            </div>

            <h3 class="secao">Convênio</h3>

            <div class="campo">
                <label for="convenio">Código do convênio</label>
                <input
                    type="text"
                    id="convenio"
                    name="convenio"
                    placeholder="Informe o ID do convênio"
                >
            </div>

            <button type="submit">Cadastrar Paciente</button>

        </form>

        <div class="rodape">
            Sistema de Gestão de Pacientes
        </div>

    </div>

</body>

</html>

<?php

    if (isset($_POST["nome"]))
        {
            $nome = $_POST["nome"];
            $cpf = $_POST["cpf"];
            $data_nascimento = $_POST["data_nascimento"];
            $telefone = $_POST["telefone"];
            $email = $_POST["email"];
            $endereco = $_POST["endereco"];
            $cidade = $_POST["cidade"];
            $convenio = $_POST["convenio"];

            $SQL = "INSERT INTO paciente (nome, cpf, data_nascimento, telefone, email, endereco, cidade, id_convenio)
                    VALUES ('$nome', '$cpf', '$data_nascimento', '$telefone', '$email','$endereco', '$cidade', '$convenio')";

            $conexao->query($SQL);

        }

?>
