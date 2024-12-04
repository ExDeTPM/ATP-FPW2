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
$search_query = "";
if ($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET['search'])) {
    $search_term = $conn->real_escape_string($_GET['search']);
    $search_query = "WHERE nome LIKE '%$search_term%'";
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['delete_id'])) {
    $delete_id = $_POST['delete_id'];
    $conn->query("DELETE FROM animais WHERE id=$delete_id");
}

$result = $conn->query("SELECT * FROM animais $search_query");
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link rel="stylesheet" href="css/style.css">
    <style>
        .logout-button {
            position: fixed;
            bottom: 20px;
            right: 20px;
            background-color: #ff4d4d;
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            cursor: pointer;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            transition: background-color 0.3s ease;
        }

        .logout-button:hover {
            background-color: #e60000;
        }

        form {
            margin: 0;
            padding: 0;
        }

        .search-form {
            margin-bottom: 20px;
        }

        .search-form input[type="text"] {
            padding: 10px;
            width: 300px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        .search-form button {
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            background-color: #4CAF50;
            color: white;
            cursor: pointer;
        }

        .search-form button:hover {
            background-color: #45a049;
        }
    </style>
</head>
<body>
    <h1>Animais Disponíveis para Adoção</h1>
    <form class="search-form" method="GET" action="">
        <input type="text" name="search" placeholder="Pesquisar por nome..." value="<?php echo isset($_GET['search']) ? htmlspecialchars($_GET['search']) : ''; ?>">
        <button type="submit">Pesquisar</button>
    </form>

    <table>
        <tr>
            <th>Nome</th>
            <th>Espécie</th>
            <th>Idade</th>
            <th>Personalidade</th>
            <th>Motivo do Resgate</th>
            <th>Estado de Saúde</th>
            <th>Ações</th>
        </tr>
        <?php while ($animal = $result->fetch_assoc()): ?>
            <tr>
                <td><?php echo htmlspecialchars($animal['nome']); ?></td>
                <td><?php echo htmlspecialchars($animal['especie']); ?></td>
                <td><?php echo htmlspecialchars($animal['idade']); ?></td>
                <td><?php echo htmlspecialchars($animal['personalidade']); ?></td>
                <td><?php echo htmlspecialchars($animal['motivo_resgate']); ?></td>
                <td><?php echo htmlspecialchars($animal['estado_saude']); ?></td>
                <td>
                    <form method="POST" action="" style="display:inline;">
                        <input type="hidden" name="delete_id" value="<?php echo $animal['id']; ?>">
                        <input type="submit" value="Excluir">
                    </form>
                    <form method="GET" action="crud/update.php" style="display:inline;">
                        <input type="hidden" name="id" value="<?php echo $animal['id']; ?>">
                        <input type="submit" value="Editar">
                    </form>
                </td>
            </tr>
        <?php endwhile; ?>
    </table>
    <a href="crud/create.php">Adicionar Novo Animal</a>

    <form action="logout.php" method="POST">
        <button type="submit" class="logout-button">Logout</button>
    </form>
</body>
</html>