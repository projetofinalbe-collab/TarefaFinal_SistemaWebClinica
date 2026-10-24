
<?php
include "conexao.php";

$resultados = null;
$mensagem = "";
$nome_pesquisa = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $nome_pesquisa = trim($_POST["nome"] ?? "");

    if ($nome_pesquisa !== "") {
        $sql = "SELECT
                    p.NOME AS paciente,
                    c.NOME AS convenio,
                    e.nome AS exame,
                    e.data_solicitacao,
                    e.data_realizacao,
                    e.resultado,
                    e.status,
                    e.valor
                FROM paciente p
                INNER JOIN convenio c
                    ON p.id_convenio = c.ID_CONVENIO
                INNER JOIN faz_consulta fc
                    ON p.ID_PACIENTE = fc.id_paciente
                INNER JOIN exame e
                    ON fc.id_consulta = e.id_consulta
                WHERE p.NOME LIKE ?
                ORDER BY e.data_solicitacao DESC";

        $stmt = $conexao->prepare($sql);

        if ($stmt) {
            $busca = "%" . $nome_pesquisa . "%";
            $stmt->bind_param("s", $busca);
            $stmt->execute();

            $resultados = $stmt->get_result();

            if ($resultados->num_rows === 0) {
                $mensagem = "Nenhum exame encontrado para esse paciente.";
            }
        } else {
            $mensagem = "Erro ao preparar a consulta: " . $conexao->error;
        }
    } else {
        $mensagem = "Digite o nome do paciente.";
    }
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Área de Exames</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

    <main class="container">
        <h1>Área de Exames</h1>
        <p>Pesquise um paciente para consultar seus exames.</p>

        <form method="POST" action="exames.php">
            <label for="nome">Nome do paciente</label>
            <input
                type="text"
                id="nome"
                name="nome"
                placeholder="Digite o nome do paciente"
                value="<?= htmlspecialchars($nome_pesquisa) ?>"
                required
            >
            <button type="submit">Pesquisar exames</button>
        </form>

        <?php if ($mensagem !== ""): ?>
            <p class="mensagem">
                <?= htmlspecialchars($mensagem) ?>
            </p>
        <?php endif; ?>

        <?php if ($resultados !== null && $resultados->num_rows > 0): ?>
            <h2>Exames encontrados</h2>

            <?php while ($exame = $resultados->fetch_assoc()): ?>
                <section class="card-exame">
                    <h3><?= htmlspecialchars($exame["exame"]) ?></h3>

                    <p>
                        <strong>Paciente:</strong>
                        <?= htmlspecialchars($exame["paciente"]) ?>
                    </p>

                    <p>
                        <strong>Convênio:</strong>
                        <?= htmlspecialchars($exame["convenio"]) ?>
                    </p>

                    <p>
                        <strong>Data da solicitação:</strong>
                        <?= htmlspecialchars($exame["data_solicitacao"] ?? "Não informada") ?>
                    </p>

                    <p>
                        <strong>Data da realização:</strong>
                        <?= htmlspecialchars($exame["data_realizacao"] ?? "Ainda não realizado") ?>
                    </p>

                    <p>
                        <strong>Status:</strong>
                        <?= htmlspecialchars($exame["status"] ?? "Não informado") ?>
                    </p>

                    <p>
                        <strong>Resultado:</strong>
                        <?= htmlspecialchars($exame["resultado"] ?? "Ainda não disponível") ?>
                    </p>

                    <p>
                        <strong>Valor:</strong>
                        R$ <?= number_format((float)$exame["valor"], 2, ",", ".") ?>
                    </p>
                </section>
            <?php endwhile; ?>
        <?php endif; ?>

        <p><a href="index.php">Voltar ao início</a></p>
    </main>

</body>
</html>
