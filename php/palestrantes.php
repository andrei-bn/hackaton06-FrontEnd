<?php
require_once __DIR__ . '/protect.php';

$url = 'http://localhost:3333/palestrantes';

$ch = curl_init($url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, [
    'Content-Type: application/json',
    'Authorization: Bearer ' . $_SESSION['token']
]);

$response = curl_exec($ch);
$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
curl_close($ch);

$palestrantes = [];
$erro = '';

if ($httpCode === 200) {
    $palestrantes = json_decode($response, true);
} else {
    $erro = "Erro ao carregar palestrantes (HTTP $httpCode)";
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Palestrantes</title>
    <link rel="stylesheet" href="../css/style.css">
    <style>
        table { width: 100%; border-collapse: collapse; margin-top: 20px; background: #fff; }
        th, td { padding: 10px; border: 1px solid #ccc; text-align: left; }
        th { background-color: #28a745; color: white; }
        body { font-family: Arial, sans-serif; background-color: #f5f5f5; padding: 20px; }
    </style>
</head>
<body>
    <h1>Lista de Palestrantes</h1>

    <?php if (!empty($erro)): ?>
        <p style="color: red;"><?= htmlspecialchars($erro) ?></p>
    <?php elseif (empty($palestrantes)): ?>
        <p>Nenhum palestrante encontrado.</p>
    <?php else: ?>
        <table>
            <thead>
                <tr>
                    <th>Nome</th>
                    <th>Tema</th>
                    <th>Minicurrículo</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($palestrantes as $palestrante): ?>
                    <tr>
                        <td><?= htmlspecialchars($palestrante['nome'] ?? '-') ?></td>
                        <td><?= htmlspecialchars($palestrante['tema'] ?? '-') ?></td>
                        <td><?= htmlspecialchars($palestrante['minicurriculo'] ?? '-') ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php endif; ?>
</body>
</html>
