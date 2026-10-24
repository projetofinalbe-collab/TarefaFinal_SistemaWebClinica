<?php
include "conexao.php";
?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pesquisa de Paciente</title>
</head>

<body>
    <p>Digite o nome para pesquisar</p>
    <form method="POST">
        <input type="text" name="nome" placeholder="Nome" required>
        <button type="submit">Enviar</button>
    </form>
</body>

</html>

<?php
if (isset($_POST["nome"])) {
    $nome = $_POST["nome"];

    // Busca todos os dados do paciente + nome do convênio (se tiver)
    $SQL_paciente = "SELECT p.*, c.nome AS nome_convenio 
                     FROM paciente p 
                     LEFT JOIN convenio c ON p.id_convenio = c.id_convenio 
                     WHERE p.nome LIKE '%$nome%'";
                     
    $resultado = $conexao->query($SQL_paciente);
    $paciente = $resultado->fetch_assoc();

    if ($paciente) {
        $id = $paciente['id_paciente'];

        // --- EXIBIÇÃO DOS DADOS DO PACIENTE ---
        echo "<h3>Dados do Paciente</h3>";
        echo "<p>Nome: " . $paciente["nome"] . "</p>";
        echo "<p>CPF: " . $paciente["cpf"] . "</p>";
        echo "<p>Data de Nascimento: " . $paciente["data_nascimento"] . "</p>";
        echo "<p>Telefone: " . $paciente["telefone"] . "</p>";
        echo "<p>E-mail: " . $paciente["email"] . "</p>";
        echo "<p>Endereço: " . $paciente["endereco"] . "</p>";
        echo "<p>Cidade: " . $paciente["cidade"] . "</p>";
        
        // Verifica se tem convênio ou se é particular
        $convenio = $paciente["nome_convenio"] ? $paciente["nome_convenio"] : "Nenhum (Particular)";
        echo "<p>Convênio: " . $convenio . "</p>";

        echo "<hr>";
        echo "<h3>Consultas do Paciente</h3>";

        // --- SEU CÓDIGO ORIGINAL CONTINUA AQUI ---
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
            echo "<br>";
        }
    } else {
        echo "<p>Nenhum paciente encontrado com o nome '$nome'.</p>";
    }
}
?>