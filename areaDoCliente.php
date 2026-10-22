<?php
include "conexao.php";
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <p>Digite o nome para pesquisar</p>
    <form method="POST">
        <input type="text" name="nome" placeholder="Nome">
        <button type="submit">Enviar</button>
    </form>
</body>

</html>

<?php
if (isset($_POST["nome"])) {
    $nome = $_POST["nome"];

    $SQL = "SELECT id_paciente FROM paciente WHERE nome = '$nome'";
    $resultado = $conexao->query($SQL);

    $paciente = $resultado->fetch_assoc();

    if ($paciente) {
        $id = $paciente['id_paciente'];

        $SQL = "SELECT 
                c.data_consulta,  
                c.horario, 
                c.motivo, 
                c.statusConsulta, 
                m.nome AS nome_medico, 
                m.especialidade 
                FROM fazConsulta c
                INNER JOIN medico m ON c.id_medico = m.id_medico
                WHERE c.id_paciente = '$id'
                ORDER BY c.data_consulta DESC, c.horario DESC";

        $resultado2 = $conexao->query($SQL);


        while ($consulta = $resultado2->fetch_assoc()) {
            echo "<p>Data: " . $consulta["data_consulta"] . "</p>";
            echo "<p>Horário: " . $consulta["horario"] . "</p>";
            echo "<p>Motivo: " . $consulta["motivo"] . "</p>";
            echo "<p>Status: " . $consulta["statusConsulta"] . "</p>";
            echo "<p>Médico: " . $consulta["nome_medico"] . "</p>";
            echo "<p>Especialidade: " . $consulta["especialidade"] . "</p>";
        }
    } else {
        echo "<p>Nenhum paciente encontrado com o nome '$nome'.</p>";
    }
}
?>