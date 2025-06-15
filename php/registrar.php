<?php
session_start();
require_once __DIR__ . '/../classes/Registrar.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $dados = [
        'nome' => $_POST['nome'],
        'email' => $_POST['email'],
        'senha' => $_POST['senha'],
        'curso' => $_POST['curso']
    ];

    $resultado = Registrar::cadastrar($dados);

    if (isset($resultado['id'])) {
        header('Location: login.php');
        exit();
    } else {
        $erro = 'Erro ao cadastrar';
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastrar</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
    <header>
        <nav>
            <form method="post">
                <input type="text" name="nome" required placeholder="Nome">
                <input type="email" name="email" required placeholder="Email">
                <input type="password" name="senha" required placeholder="Senha">
                <input type="text" name="curso" required placeholder="Curso">
                <button type="submit">Cadastrar</button>
            </form>
            <ul class="menu">
                <li><a href='login.php'>Já possuí uma conta?</a></li>
            </ul>
        </nav>
    </header>   
    <?php if (isset($erro)) echo "<p>$erro</p>"; ?>
</body>
</html>
