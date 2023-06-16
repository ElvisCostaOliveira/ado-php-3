<?php
session_start();

if (!isset($_SESSION['usuario_logado'])) {
    header('Location: index.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['logout'])) {
    session_destroy();
    header('Location: index.php');
    exit;
}

require_once 'conecta_sqlite.php';
require_once 'operacoes.php';

try {
    $db = conectar();

    $stmt = $db->query('SELECT * FROM quarto');
    $quartos = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo "Erro ao consultar os quartos: " . $e->getMessage();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Listagem de Quartos</title>
    <meta charset="utf-8">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <div class="container">
        <h1>Bem-vindo, <?php echo $_SESSION['usuario_logado']; ?>!</h1>
        
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Número</th>
                    <th>Andar</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($quartos as $quarto) : ?>
                    <tr>
                        <td><?php echo $quarto['id']; ?></td>
                        <td><?php echo $quarto['numero']; ?></td>
                        <td><?php echo $quarto['andar']; ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        
        <form action="principal.php" method="POST">
            <button type="submit" name="logout" class="btn btn-primary">Logout</button>
        </form>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
