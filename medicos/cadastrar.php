
<?php
require_once __DIR__ . '/../conexao.php';

$mensagem = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nome = trim($_POST['nome']);
    $crm = trim($_POST['crm']);
    $telefone = trim($_POST['telefone']);
    $email = trim($_POST['email']);

    $sql = "INSERT INTO medico (nome, crm, telefone, email)
            VALUES (?, ?, ?, ?)";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param(
        "ssss",
        $nome,
        $crm,
        $telefone,
        $email
    );

    if ($stmt->execute()) {
        $mensagem = "Médico cadastrado com sucesso!";
    } else {
        $mensagem = "Erro ao cadastrar médico.";
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Cadastrar Médico</title>
</head>
<body>

<h1>Cadastrar médico</h1>

<p><?= htmlspecialchars($mensagem) ?></p>

<form method="POST">
    <label>Nome:</label>
    <input type="text" name="nome" required>
    <br><br>

    <label>CRM:</label>
    <input type="text" name="crm" required>
    <br><br>

    <label>Telefone:</label>
    <input type="text" name="telefone">
    <br><br>

    <label>E-mail:</label>
    <input type="email" name="email">
    <br><br>

    <button type="submit">Cadastrar médico</button>
</form>

<a href="listar.php">Ver médicos cadastrados</a>

</body>
</html>
