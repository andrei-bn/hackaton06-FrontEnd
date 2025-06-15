<?php
session_start();
require_once "classes/Editar.php";

$msg = null;
$erro = null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $token = $_SESSION['token'] ?? '';
    $nome = $_POST['nome'] ?? '';
    $email = $_POST['email'] ?? '';
    $curso = $_POST['curso'] ?? '';
    $senha = $_POST['senha'] ?? '';

    $dados = [
        'nome' => $nome,
        'email' => $email,
        'curso' => $curso,
        'senha' => $senha
    ];

    $resultado = Editar::atualizar($token, $dados);

    if ($resultado['erro']) {
        $erro = $resultado['mensagem'];
    } else {
        $_SESSION['aluno']['nome'] = $nome;
        $_SESSION['aluno']['email'] = $email;
        $_SESSION['aluno']['curso'] = $curso;
        $msg = $resultado['mensagem'];
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <header>
        <nav>
            <ul class="menu">
                <li><a href="meus_eventos.php">Meus Eventos</a></li>
                <li><a href="palestrantes.php">Palestrantes</a></li>
                <li><a href="eventos.php">Eventos</a></li>
                <li><a href='sair.php'>Sair</a></li>
            </ul>
        </nav>
    </header>
    <div class="card">
        <h2>Editar Perfil</h2>
        <form method="POST">
            <input type="text" name="nome" placeholder="Nome" value="<?php echo $_SESSION['aluno']['nome']; ?>" required>
            <input type="email" name="email" placeholder="E-mail" value="<?php echo $_SESSION['aluno']['email']; ?>" required>
            <input type="text" name="curso" placeholder="Curso" value="<?php echo $_SESSION['aluno']['curso']; ?>" required>
            <input type="password" name="senha" placeholder="Senha (opcional)">
            <button type="submit">Salvar</button>

            <?php if ($msg) echo "<p class='message success'>$msg</p>"; ?>
            <?php if ($erro) echo "<p class='message error'>$erro</p>"; ?>
        </form>
    </div>
</body>
</html>
