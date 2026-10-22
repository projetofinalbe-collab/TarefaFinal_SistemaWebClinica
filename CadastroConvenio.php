
<?php

include "conexao.php";

$mensagem = "";
$tipoMensagem = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $nome = trim($_POST["nome"] ?? "");
    $telefone = trim($_POST["telefone"] ?? "");
    $percentual_desconto = $_POST["percentual_desconto"] ?? "";

    if (
        empty($nome) ||
        empty($telefone) ||
        $percentual_desconto === ""
    ) {

        $mensagem = "Preencha todos os campos.";
        $tipoMensagem = "erro";

    } elseif (
        !is_numeric($percentual_desconto) ||
        $percentual_desconto < 0 ||
        $percentual_desconto > 100
    ) {

        $mensagem = "Informe um desconto entre 0 e 100%.";
        $tipoMensagem = "erro";

    } else {

        $SQL = "INSERT INTO convenio
                (nome, telefone, percentual_desconto)
                VALUES (?, ?, ?)";

        $stmt = $conexao->prepare($SQL);

        if (!$stmt) {

            $mensagem = "Erro ao preparar cadastro: " . $conexao->error;
            $tipoMensagem = "erro";

        } else {

            $desconto = (float) $percentual_desconto;

            $stmt->bind_param(
                "ssd",
                $nome,
                $telefone,
                $desconto
            );

            if ($stmt->execute()) {

                $mensagem = "Convênio cadastrado com sucesso!";
                $tipoMensagem = "sucesso";

            } else {

                $mensagem = "Erro ao cadastrar convênio: " . $stmt->error;
                $tipoMensagem = "erro";

            }

            $stmt->close();
        }
    }
}

?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Cadastro de Convênio</title>

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: Arial, Helvetica, sans-serif;
        }

        body {
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 25px;
            background: linear-gradient(135deg, #0f4c81, #4f9bd9);
        }

        .container {
            width: 100%;
            max-width: 500px;
            background: #ffffff;
            padding: 35px;
            border-radius: 16px;
            box-shadow: 0 10px 35px rgba(0, 0, 0, 0.18);
        }

        h1 {
            text-align: center;
            color: #174a75;
            margin-bottom: 10px;
            font-size: 28px;
        }

        .descricao {
            text-align: center;
            color: #64748b;
            font-size: 14px;
            line-height: 1.5;
            margin-bottom: 28px;
        }

        .campo {
            margin-bottom: 20px;
        }

        label {
            display: block;
            margin-bottom: 8px;
            font-weight: bold;
            font-size: 14px;
            color: #334155;
        }

        input {
            width: 100%;
            padding: 13px 14px;
            border: 1px solid #cbd5e1;
            border-radius: 8px;
            font-size: 15px;
            outline: none;
            transition: border-color 0.2s, box-shadow 0.2s;
        }

        input:focus {
            border-color: #2584c7;
            box-shadow: 0 0 0 3px rgba(37, 132, 199, 0.12);
        }

        .ajuda {
            display: block;
            margin-top: 6px;
            color: #64748b;
            font-size: 12px;
        }

        button {
            width: 100%;
            padding: 14px;
            border: none;
            border-radius: 8px;
            background: #1769aa;
            color: white;
            font-size: 16px;
            font-weight: bold;
            cursor: pointer;
            transition: background 0.2s;
        }

        button:hover {
            background: #10558c;
        }

        .mensagem {
            padding: 12px;
            border-radius: 8px;
            margin-bottom: 20px;
            font-size: 14px;
            text-align: center;
        }

        .sucesso {
            background: #dcfce7;
            color: #166534;
            border: 1px solid #86efac;
        }

        .erro {
            background: #fee2e2;
            color: #991b1b;
            border: 1px solid #fca5a5;
        }

        .rodape {
            text-align: center;
            margin-top: 22px;
            font-size: 13px;
            color: #64748b;
        }

        @media (max-width: 480px) {
            .container {
                padding: 25px 20px;
            }

            h1 {
                font-size: 24px;
            }
        }
    </style>
</head>

<body>

    <div class="container">

        <h1>Cadastro de Convênio</h1>

        <p class="descricao">
            Preencha os dados abaixo para cadastrar um novo convênio
            na clínica.
        </p>

        <?php if ($mensagem !== ""): ?>
            <div class="mensagem <?php echo $tipoMensagem; ?>">
                <?php echo htmlspecialchars($mensagem); ?>
            </div>
        <?php endif; ?>

        <form method="POST">

            <div class="campo">
                <label for="nome">Nome do convênio</label>

                <input
                    type="text"
                    id="nome"
                    name="nome"
                    placeholder="Ex.: Unimed"
                    value="<?php echo htmlspecialchars($_POST["nome"] ?? ""); ?>"
                    maxlength="150"
                    required
                >
            </div>

            <div class="campo">
                <label for="telefone">Telefone</label>

                <input
                    type="tel"
                    id="telefone"
                    name="telefone"
                    placeholder="Ex.: (34) 3333-4444"
                    value="<?php echo htmlspecialchars($_POST["telefone"] ?? ""); ?>"
                    required
                >
            </div>

            <div class="campo">
                <label for="percentual_desconto">
                    Percentual de desconto (%)
                </label>

                <input
                    type="number"
                    id="percentual_desconto"
                    name="percentual_desconto"
                    placeholder="Ex.: 15"
                    min="0"
                    max="100"
                    step="0.01"
                    value="<?php echo htmlspecialchars($_POST["percentual_desconto"] ?? ""); ?>"
                    required
                >

                <span class="ajuda">
                    Informe um valor entre 0 e 100.
                </span>
            </div>

            <button type="submit">Cadastrar Convênio</button>

        </form>

        <div class="rodape">
            Sistema de Gerenciamento da Clínica
        </div>

    </div>

</body>
</html>
