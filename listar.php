<?php
session_start();

if (!isset($_SESSION['logged_in'])) {
    header("Location: login.php");
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
        <h1>Listagem de Quartos</h1>
        
        <p>Usuário logado: <?php echo $_SESSION['username']; ?></p>

        <?php if (!empty($quartos)) { ?>
            <table class="table">
                <thead>
                    <tr>
                        <th>Número</th>
                        <th>Camas de Solteiro</th>
                        <th>Camas de Casal</th>
                        <th>Área (m²)</th>
                        <th>Reservado</th>
                        <th>Valor Diária</th>
                        <th>Ações</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($quartos as $quarto) { ?>
                        <tr>
                            <td><?php echo $quarto['numero']; ?></td>
                            <td><?php echo $quarto['camas_solteiro']; ?></td>
                            <td><?php echo $quarto['camas_casal']; ?></td>
                            <td><?php echo $quarto['area_m2']; ?></td>
                            <td><?php echo ($quarto['reservado'] == 1) ? 'Sim' : 'Não'; ?></td>
                            <td>R$ <?php echo number_format($quarto['valor_diaria'], 2, ',', '.'); ?></td>

                            <td>
                                <a href="cadastrar.php?acao=alterar&numero=<?php echo $quarto['numero']; ?>" class="btn btn-primary">Editar</a>
                                <a href="excluir.php?numero=<?php echo $quarto['numero']; ?>" onclick="return confirm('Deseja realmente excluir o quarto?')" class="btn btn-danger">Excluir</a>
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        <?php } else { ?>
            <p>Não há quartos cadastrados.</p>
        <?php } ?>

        <a href="cadastrar.php" class="btn btn-success">Cadastrar Quarto</a>
        <a href="logout.php" class="btn btn-secondary">Sair</a>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
