
<?php
require_once __DIR__ . '/../conexao.php';

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    die("ID inválido.");
}

$id = (int) $_GET['id'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nome = trim($_POST['nome']);
    $crm = trim($_POST['crm']);
    $telefone = trim($_POST['telefone']);
    $email = trim($_POST['email']);

    $sql = "UPDATE medico
            SET nome = ?, crm = ?, telefone = ?, email = ?
            WHERE id_medico = ?";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param(
        "ssssi",
        $nome,
        $crm,
        $telefone,
        $email,
        $id
    );

    if ($stmt->execute()) {
        header("Location: listar.php");
        exit;
    }

    echo "Erro ao atualizar médico.";
}

$sql = "SELECT * FROM medico WHERE id_medico = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id);
$stmt->execute();

$resultado = $stmt->get_result();
$medico = $resultado->fetch_assoc();

if (!$medico) {
    die("Médico não encontrado.");
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Editar Médico</title>
</head>
<body>

<h1>Editar médico</h1>

<form method="POST">
    <label>Nome:</label>
    <input type="text" name="nome"
        value="<?= htmlspecialchars($medico['nome']) ?>" required>
    <br><br>

    <label>CRM:</label>
    <input type="text" name="crm"
        value="<?= htmlspecialchars($medico['crm']) ?>" required>
    <br><br>

    <label>Telefone:</label>
    <input type="text" name="telefone"
        value="<?= htmlspecialchars($medico['telefone'] ?? '') ?>">
    <br><br>

    <label>E-mail:</label>
    <input type="email" name="email"
        value="<?= htmlspecialchars($medico['email'] ?? '') ?>">
    <br><br>

    <button type="submit">Salvar alterações</button>
</form>

</body>
</html>
