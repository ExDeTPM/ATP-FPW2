<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$conn = new mysqli('localhost', 'root', '', 'registro_pets');
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$animal = null;

if (isset($_GET['id'])) {
    $animal_id = $_GET['id'];
    $animal_id = $conn->real_escape_string($animal_id);
    $result = $conn->query("SELECT * FROM animais WHERE id='$animal_id'");

    if ($result->num_rows > 0) {
        $animal = $result->fetch_assoc();
    } else {
        echo "<script>alert('Animal não encontrado.'); window.location.href='../dashboard.php';</script>";
        exit();
    }
} else {
    echo "<script>alert('ID do animal não especificado.'); window.location.href='../dashboard.php';</script>";
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nome = $conn->real_escape_string($_POST['nome']);
    $especie = $conn->real_escape_string($_POST['especie']);
    $idade = $conn->real_escape_string($_POST['idade']);
    $personalidade = $conn->real_escape_string($_POST['personalidade']);
    $motivo_resgate = $conn->real_escape_string($_POST['motivo_resgate']);
    $estado_saude = $conn->real_escape_string($_POST['estado_saude']);

    $sql = "UPDATE animais SET 
            nome='$nome',
            especie='$especie',
            idade='$idade',
            personalidade='$personalidade',
            motivo_resgate='$motivo_resgate',
            estado_saude='$estado_saude'
            WHERE id='$animal_id'";

    if ($conn->query($sql) === TRUE) {
        echo "<script>alert('Animal atualizado com sucesso!'); window.location.href='../dashboard.php';</script>";
    } else {
        echo "Erro ao atualizar registro: " . $conn->error;
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Animal</title>
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
    <h1>Editar Animal</h1>
    <form method="POST" action="">
        <label for="nome">Nome:</label>
        <input type="text" name="nome" value="<?php echo htmlspecialchars($animal['nome']); ?>" maxlength="50" required><br>
        <label for="especie">Espécie:</label>
        <select name="especie" required>
            <option value="Ave" <?php if ($animal['especie'] == 'Ave') echo 'selected'; ?>>Ave</option>
            <option value="Réptil" <?php if ($animal['especie'] == 'Réptil') echo 'selected'; ?>>Réptil</option>
            <option value="Canino" <?php if ($animal['especie'] == 'Canino') echo 'selected'; ?>>Canino</option>
            <option value="Felino" <?php if ($animal['especie'] == 'Felino') echo 'selected'; ?>>Felino</option>
            <option value="Roedor" <?php if ($animal['especie'] == 'Roedor') echo 'selected'; ?>>Roedor</option>
        </select><br>
        <label for="idade">Idade:</label>
        <select name="idade" required>
            <option value="filhote" <?php if ($animal['idade'] == 'filhote') echo 'selected'; ?>>Filhote</option>
            <option value="jovem" <?php if ($animal['idade'] == 'jovem') echo 'selected'; ?>>Jovem</option>
            <option value="adulto" <?php if ($animal['idade'] == 'adulto') echo 'selected'; ?>>Adulto</option>
            <option value="idoso" <?php if ($animal['idade'] == 'idoso') echo 'selected'; ?>>Idoso</option>
        </select><br>
        <label for="personalidade">Personalidade:</label>
        <textarea name="personalidade" maxlength="500" required><?php echo htmlspecialchars($animal['personalidade']); ?></textarea><br>
        <label for="motivo_resgate">Motivo do Resgate:</label>
        <textarea name="motivo_resgate" maxlength="500" required><?php echo htmlspecialchars($animal['motivo_resgate']); ?></textarea><br>
        <label for="estado_saude">Estado de Saúde:</label>
        <select name="estado_saude" required>
            <option value="Saudável" <?php if ($animal['estado_saude'] == 'Saudável') echo 'selected'; ?>>Saudável</option>
            <option value="doente" <?php if ($animal['estado_saude'] == 'doente') echo 'selected'; ?>>Doente</option>
            <option value="em tratamento" <?php if ($animal['estado_saude'] == 'em tratamento') echo 'selected'; ?>>Em Tratamento</option>
            <option value="terminal" <?php if ($animal['estado_saude'] == 'terminal') echo 'selected'; ?>>Terminal</option>
        </select><br>
        <div class="button-container">
            <input type="submit" value="Atualizar Animal" class="button">
        </div>
    </form>
    <form action="../dashboard.php" method="GET">
        <div class="button-container">
            <button type="submit" class="button">Voltar à Página Anterior</button>
        </div>
    </form>
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