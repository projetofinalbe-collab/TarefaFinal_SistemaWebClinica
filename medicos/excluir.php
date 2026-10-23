
<?php
require_once __DIR__ . '/../conexao.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    die("Requisição inválida.");
}

if (!isset($_POST['id']) || !is_numeric($_POST['id'])) {
    die("ID inválido.");
}

$id = (int) $_POST['id'];

$sql = "DELETE FROM medico WHERE id_medico = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id);

if ($stmt->execute()) {
    header("Location: listar.php");
    exit;
}

echo "Não foi possível excluir o médico. Verifique se existem consultas vinculadas.";
?>
