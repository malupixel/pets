<?php
declare(strict_types=1);

namespace App\Services;

final class Api
{
    const API_URL = 'https:/sellingo_nginx/api';

    public function get(string $uri, string $method, ?string $data = null): string
    {
        if (!str_starts_with($uri, '/')) {
            $uri = '/' .$uri;
        }
        return $this->sendQuery(self::API_URL . $uri, $method, $data);
    }

    private function sendQuery(string $uri, string $method, ?string $data): string
    {
        $ch = curl_init();

        $options = [
            CURLOPT_URL => $uri,
            CURLOPT_RETURNTRANSFER => true,  //
            CURLOPT_CUSTOMREQUEST => strtoupper($method),
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTPHEADER => [
                'Content-Type: application/json',
                'Accept: application/json',
            ],
            CURLOPT_SSL_VERIFYPEER => false,
            CURLOPT_SSL_VERIFYHOST => false,
        ];


        if (!empty($data)) {
            $options[CURLOPT_POSTFIELDS] = $data;
        }

        curl_setopt_array($ch, $options);

        $response = curl_exec($ch);

        if ($response === false) {
            $error = curl_error($ch);
            curl_close($ch);
            throw new \RuntimeException("cURL error: {$error}");
        }

        curl_close($ch);

        return $response;
    }
}
