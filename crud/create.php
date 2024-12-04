<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nome = $_POST['nome'];
    $especie = $_POST['especie'];
    $idade = $_POST['idade'];
    $personalidade = $_POST['personalidade'];
    $motivo_resgate = $_POST['motivo_resgate'];
    $estado_saude = $_POST['estado_saude'];

    $conn = new mysqli('localhost', 'root', '', 'registro_pets');
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $nome = $conn->real_escape_string($nome);
    $especie = $conn->real_escape_string($especie);
    $idade = $conn->real_escape_string($idade);
    $personalidade = $conn->real_escape_string($personalidade);
    $motivo_resgate = $conn->real_escape_string($motivo_resgate);
    $estado_saude = $conn->real_escape_string($estado_saude);

    $check_sql = "SELECT * FROM animais WHERE nome='$nome'";
    $result = $conn->query($check_sql);

    if ($result->num_rows > 0) {
        echo "<script>alert('Erro: Um animal com este nome já existe. Por favor, escolha outro nome.');</script>";
    } else {
        $sql = "INSERT INTO animais (nome, especie, idade, personalidade, motivo_resgate, estado_saude) 
                VALUES ('$nome', '$especie', '$idade', '$personalidade', '$motivo_resgate', '$estado_saude')";

        if ($conn->query($sql) === TRUE) {
            echo "<script>alert('Animal adicionado com sucesso!'); window.location.href='../dashboard.php';</script>";
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    }

    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Adicionar Novo Animal</title>
    <link rel="stylesheet" href="../css/style.css">
    <style>
        .button {
            background-color: #4CAF50;
            color: white;
            padding: 10px 20px;
            text-align: center;
            text-decoration: none;
            display: inline-block;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s ease;
            margin: 5px 0;
        }

        .button:hover {
            background-color: #45a049;
        }

        .button-container {
            display: flex;
            gap: 10px;
        }
    </style>
</head>
<body>
    <h1>Adicionar Novo Animal</h1>
    <form method="POST" action="">
        <label for="nome">Nome:</label>
        <input type="text" name="nome" maxlength="50" required><br>
        <label for="especie">Espécie:</label>
        <select name="especie" required>
            <option value="Ave">Ave</option>
            <option value="Réptil">Réptil</option>
            <option value="Canino">Canino</option>
            <option value="Felino">Felino</option>
            <option value="Roedor">Roedor</option>
        </select><br>
        <label for="idade">Idade:</label>
        <select name="idade" required>
            <option value="filhote">Filhote</option>
            <option value="jovem">Jovem</option>
            <option value="adulto">Adulto</option>
            <option value="idoso">Idoso</option>
        </select><br>
        <label for="personalidade">Personalidade:</label>
        <textarea name="personalidade" maxlength="500" required></textarea><br>
        <label for="motivo_resgate">Motivo do Resgate:</label>
        <textarea name="motivo_resgate" maxlength="500" required></textarea><br>
        <label for="estado_saude">Estado de Saúde:</label>
        <select name="estado_saude" required>
            <option value="Saudável">Saudável</option>
            <option value="doente">Doente</option>
            <option value="em tratamento">Em Tratamento</option>
            <option value="terminal">Terminal</option>
        </select><br>
        <input type="submit" value="Adicionar Animal">
        </form>
    <form action="../dashboard.php" method="GET">
        <div class="button-container">
            <button type="submit" class="button">Voltar à Página Anterior</button>
        </div>
    </form>
    <footer>
    <div class="footer-content">
        <p>&copy; 2024 Pelos, Patas, Bicos e Escamas. Todos os direitos reservados.</p>
        <nav class="footer-nav">
        </nav>
    </div>
</footer>
</body>
</html>