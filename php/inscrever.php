<?php
session_start();

if (!isset($_SESSION['token']) || !isset($_POST['evento_id'])) {
    header("Location: eventos.php");
    exit();
}

$token = $_SESSION['token'];
$evento_id = intval($_POST['evento_id']);

$ch = curl_init("http://localhost:3333/inscricoes");
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, [
    'Content-Type: application/json',
    'Authorization: Bearer ' . $token
]);
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode([
    "evento_id" => $evento_id
]));

$response = curl_exec($ch);
$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
curl_close($ch);

if ($httpCode === 201) {
    header("Location: meus_eventos.php?sucesso=1");
} else {
    header("Location: eventos.php?erro=1");
}
exit();
