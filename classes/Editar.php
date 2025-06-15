<?php
class Editar {
    public static function atualizar($token, $dados) {
        $dadosFiltrados = array_filter($dados);

        if (empty($dadosFiltrados)) {
            return [
                'erro' => true,
                'mensagem' => 'Nenhum dado para atualizar.'
            ];
        }

        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, "http://localhost:3333/alunos");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PUT");
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($dadosFiltrados));
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            "Content-Type: application/json",
            "Authorization: Bearer $token"
        ]);

        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        if ($httpCode == 200) {
            return [
                'erro' => false,
                'mensagem' => 'Dados atualizados com sucesso!'
            ];
        } else {
            return [
                'erro' => true,
                'mensagem' => $response
            ];
        }
    }
}
