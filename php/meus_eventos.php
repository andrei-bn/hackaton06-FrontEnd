<?php
include 'protect.php';

$ch = curl_init('http://localhost:3333/inscricoes');
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, [
    'Authorization: Bearer ' . $_SESSION['token'],
    'Content-Type: application/json'
]);
$response = curl_exec($ch);
curl_close($ch);
$inscricoes = json_decode($response, true);
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Meus Cursos</title>
    <link rel="stylesheet" href="css/style.css">
    <style>
        body {
            margin: 0;
            font-family: "Segoe UI", sans-serif;
            background-color: #f4f6f8;
            color: #333;
        }
        header {
            background-color: #2c3e50;
            padding: 1rem 0;
        }
        .menu {
            list-style: none;
            display: flex;
            justify-content: center;
            gap: 1.5rem;
            padding: 0;
            margin: 0;
        }
        .menu li a {
            color: #ecf0f1;
            text-decoration: none;
            font-weight: bold;
        }
        .menu li a:hover {
            text-decoration: underline;
        }
        main {
            max-width: 800px;
            margin: 2rem auto;
            padding: 0 1rem;
        }
        h1 {
            text-align: center;
            margin-bottom: 2rem;
        }
        .card {
            background-color: #ffffff;
            border-radius: 8px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
            padding: 1.5rem;
            margin-bottom: 1.5rem;
            transition: transform 0.2s ease;
        }
        .card:hover {
            transform: scale(1.02);
        }
        .evento-nome {
            font-size: 1.2rem;
            font-weight: bold;
            margin-bottom: 0.5rem;
            color: #2c3e50;
        }
        .evento-data {
            font-size: 0.95rem;
            color: #555;
        }
        .mensagem {
            text-align: center;
            color: #888;
        }
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

    <main>
        <h1>🎓 Meus Eventos Inscritos</h1>
        <?php
        if (isset($inscricoes['error'])) {
            echo "<p class='mensagem'>Erro: {$inscricoes['error']}</p>";
        } elseif (is_array($inscricoes) && count($inscricoes) > 0) {
            foreach ($inscricoes as $inscricao) {
                $eventoNome = $inscricao['evento'] ?? 'Evento desconhecido';
                $data = date("d/m/Y", strtotime($inscricao['data'] ?? ''));
                echo "
                <div class='card'>
                    <div class='evento-nome'>$eventoNome</div>
                    <div class='evento-data'>📅 $data</div>
                </div>";
            }
        } else {
            echo "<p class='mensagem'>Você ainda não está inscrito em nenhum curso.</p>";
        }
        ?>
    </main>
</body>
</html>
