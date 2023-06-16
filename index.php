<?php
session_start();


if (isset($_SESSION['usuario_logado'])) {
    header('Location: principal.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    require_once 'conecta_sqlite.php';

    $login = $_POST['login'];
    $senha = $_POST['senha'];

    try {
        $db = conectar();
        $stmt = $db->prepare('SELECT * FROM usuario WHERE login = ? AND senha = ?');
        $stmt->bindParam(1, $login);
        $stmt->bindParam(2, $senha);
        $stmt->execute();
        $usuario = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($usuario) {
            $_SESSION['usuario_logado'] = $usuario['nome'];
            header('Location: principal.php');
            exit;
        } else {
            $erro = "Login ou senha incorretos.";
        }
    } catch (PDOException $e) {
        echo "Erro ao consultar usuário: " . $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Bem-vindo</title>
    <meta charset="utf-8">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <div class="container">
        <h1>Bem-vindo</h1>
        <a href="listar.php" class="btn btn-primary">Acessar Lista de Quartos</a>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
