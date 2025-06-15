<?php

class Registrar{
    public static function cadastrar(array $dados): array
    {
        $ch = curl_init('http://localhost:3333/alunos');

        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($dados));

        $response = curl_exec($ch);
        curl_close($ch);

        return json_decode($response, true);
    }
}
