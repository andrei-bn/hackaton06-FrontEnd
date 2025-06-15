<?php

class ReqresApiService
{
    private string $baseUrl;
    private string $apiKey;

    public function __construct()
    {
        $this->baseUrl = 'http://localhost:3333';
        $this->apiKey = "reqres-free-v1";
    }

    private function request(string $endpoint, string $method = 'GET', array $data = []): array
    {
        $ch = curl_init($this->baseUrl . $endpoint);

        $headers = [
            'Content-Type: application/json',
            'x-api-key: ' . $this->apiKey
        ];
        $options = [
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_CUSTOMREQUEST => $method,
            CURLOPT_HTTPHEADER => $headers,
        ];

        if (in_array($method, ['POST', 'PUT'])) {
            $options[CURLOPT_POSTFIELDS] = json_encode($data);
        }

        curl_setopt_array($ch, $options);

        $response = curl_exec($ch);
        $httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        return [
            'code' => $httpcode,
            'body' => json_decode($response, true)
        ];
    }

    public function cadastrarAluno(array $aluno): array
    {
        return $this->request('/register', 'POST', $aluno);
    }

    public function fazerLogin(array $dados): array
    {
        return $this->request('/login', 'POST', $dados);
    }

    public function listarEventos(): array
    {
        return $this->request('/eventos');
    }

}

