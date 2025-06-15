<?php
include 'protect.php';

$ch = curl_init('http://localhost:3333/palestrantes');
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, [
    'Authorization: Bearer ' . $_SESSION['token'],
    'Content-Type: application/json'
]);
$response = curl_exec($ch);
curl_close($ch);
$palestrantes = json_decode($response, true);

foreach ($palestrantes as $p) {
    echo "<p>{$p['nome']} ({$p['especialidade']})</p>";
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Palestrantes</title>
    <link rel="stylesheet" href="css/style.css">
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
    
</body>
</html>