<?php
session_start();
require_once __DIR__ . '/protect.php';

if (!isset($_SESSION['token']) || !isset($_SESSION['aluno'])) {
    header('Location: login.php');
    exit();
}

$token = $_SESSION['token'];
$aluno = $_SESSION['aluno'];

$ch = curl_init("http://localhost:3333/eventos");
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, [
    'Content-Type: application/json',
    'Authorization: Bearer ' . $token
]);

$response = curl_exec($ch);
$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
curl_close($ch);

$eventos = [];
$erro = '';

if ($httpCode === 200) {
    $eventos = json_decode($response, true);
} else {
    $erro = "Não foi possível carregar os eventos. Código HTTP: $httpCode";
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Eventos</title>
    <link rel="stylesheet" href="css/style.css">
    <style>
        table { width: 100%; border-collapse: collapse; margin-top: 20px; background: #fff; }
        th, td { padding: 10px; border: 1px solid #ccc; text-align: left; }
        th { background-color: #007BFF; color: white; }
        body { font-family: Arial, sans-serif; background-color: #f5f5f5; padding: 20px; }
        h1 { margin-bottom: 10px; }
    </style>
</head>
<body>
    <header>
        <nav>
            <ul class="menu">
                <li><a href="meus_eventos.php">Meus Eventos</a></li>
                <li><a href="palestrantes.php">Palestrantes</a></li>
                <li><a href="editar.php">Editar</a></li>
                <li><a href="eventos.php">Eventos</a></li>
                <li><a href='sair.php'>Sair</a></li>
            </ul>
        </nav>
    </header>

    <h1>Bem-vindo, <?= htmlspecialchars($aluno['nome']) ?></h1>

    <?php if (!empty($erro)): ?>
        <p style="color: red;"><?= $erro ?></p>
    <?php elseif (empty($eventos)): ?>
        <p>Nenhum evento disponível no momento.</p>
    <?php else: ?>
        <table>
            <thead>
                <tr>
                    <th>Nome</th>
                    <th>Descrição</th>
                    <th>Data</th>
                    <th>Início</th>
                    <th>Fim</th>
                    <th>Palestrante</th>
                    <th>Tema</th>
                    <th>Coordenador</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($eventos as $evento): ?>
                    <tr>
                        <td><?= htmlspecialchars($evento['nome']) ?></td>
                        <td><?= htmlspecialchars($evento['descricao']) ?></td>
                        <td><?= htmlspecialchars($evento['data']) ?></td>
                        <td><?= htmlspecialchars($evento['horario_inicio']) ?></td>
                        <td><?= htmlspecialchars($evento['horario_fim']) ?></td>
                        <td><?= htmlspecialchars($evento['palestrante_nome']) ?></td>
                        <td><?= htmlspecialchars($evento['palestrante_tema']) ?></td>
                        <td><?= htmlspecialchars($evento['coordenador_nome']) ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php endif; ?>
</body>
</html>
