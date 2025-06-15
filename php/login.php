<?php
session_start();
require_once __DIR__ . '/../classes/Login.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];
    $senha = $_POST['senha'];

    $data = json_encode(['email' => $email, 'senha' => $senha]);
    $ch = curl_init('http://localhost:3333/login');
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $data);

    $response = curl_exec($ch);
    curl_close($ch);

    $result = json_decode($response, true);

    if (Login::salvarSessaoLogin($result)) {
    header('Location: eventos.php');
    exit();
    }

}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
    <header>
        <nav>
            <form method="post">
                <input type="email" name="email" required placeholder="Email">
                <input type="password" name="senha" required placeholder="Senha">
                <button type="submit">Entrar</button>
            </form>
            <ul class="menu">
                <li><a href='registrar.php'>Ainda não é cadastrado?</a></li>
            </ul>
        </nav>
    </header>   
</body>
</html>
<?php if (isset($erro)) echo "<p>$erro</p>"; ?>