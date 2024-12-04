<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];
    $nome = $_POST['nome'];
    $senha = password_hash($_POST['senha'], PASSWORD_BCRYPT);

    $conn = new mysqli('localhost', 'root', '', 'registro_pets');
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $email_check_query = "SELECT * FROM usuarios WHERE email='$email' LIMIT 1";
    $result = $conn->query($email_check_query);

    if ($result->num_rows > 0) {
        echo "Erro: Este email já está cadastrado. Por favor, use outro email.";
    } else {
        $sql = "INSERT INTO usuarios (email, nome, senha) VALUES ('$email', '$nome', '$senha')";
        if ($conn->query($sql) === TRUE) {
            echo "Seja bem-vindo! Por gentileza, clique <a href='login.php'>aqui</a> para logar em sua nova conta!";
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
    <title>Cadastro</title>
    <link rel="stylesheet" href="css/style.css">
    <style>
        .back-button {
            margin-top: 20px;
            background-color: #4CAF50;
            color: white;
            padding: 10px 20px;
            text-align: center;
            text-decoration: none;
            display: inline-block;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .back-button:hover {
            background-color: #45a049;
        }
    </style>
</head>
<body>
    <h1>Cadastro</h1>
    <form method="POST" action="">
        <label for="email">Email:</label>
        <input type="email" name="email" required><br>
        <label for="nome">Nome:</label>
        <input type="text" name="nome" required><br>
        <label for="senha">Senha:</label>
        <input type="password" name="senha" required><br>
        <input type="submit" value="Cadastrar">
    </form>
    <a href="index.php" class="back-button">Voltar à Tela Inicial</a>
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