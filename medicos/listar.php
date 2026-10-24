
<?php
require_once __DIR__ . '/../conexao.php';

$sql = "SELECT * FROM medico ORDER BY nome";
$resultado = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Lista de Médicos</title>
</head>
<body>

    <h1>Médicos cadastrados</h1>

    <a href="cadastrar.php">Cadastrar novo médico</a>

    <br><br>

    <table border="1" cellpadding="8">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nome</th>
                <th>CRM</th>
                <th>Telefone</th>
                <th>E-mail</th>
            </tr>
        </thead>

        <tbody>
            <?php while ($medico = $resultado->fetch_assoc()) { ?>
                <tr>
                    <td><?= (int) $medico['id_medico'] ?></td>
                    <td><?= htmlspecialchars($medico['nome']) ?></td>
                    <td><?= htmlspecialchars($medico['crm']) ?></td>
                    <td><?= htmlspecialchars($medico['telefone'] ?? '') ?></td>
                    <td><?= htmlspecialchars($medico['email'] ?? '') ?></td>
                </tr>
                
<td>
    <form action="excluir.php" method="POST"
          onsubmit="return confirm('Deseja realmente excluir este médico?');">
        <input type="hidden" name="id"
               value="<?= (int) $medico['id_medico'] ?>">
        <button type="submit">Excluir</button>
    </form>
</td>

                
<td>
    <a href="editar.php?id=<?= (int) $medico['id_medico'] ?>">
        Editar
    </a>
</td>

            <?php } ?>
        </tbody>
    </table>

</body>
</html>
