<?php

namespace App\Providers;

use App\Interfaces\ProviderInterface;

class AiCaseProvider implements ProviderInterface
{
    protected string $apiKey;

    public function __construct()
    {
        $config = require __DIR__ . '/../../config/config.php';

        if (empty($config['api-key'])) {
            throw new \Exception('Missing API key');
        }

        $this->apiKey = $config['api-key'];
    }

    public function split(string $word): array
    {
        $data = [
            'model' => 'gpt-4',
            'messages' => [
                [
                    'role' => 'user',
                    'content' => 'Is the word "' . $word . '" compound? If so, split it using camelCase. If not, leave as is. Write only this modified word'
                ]
            ]
        ];

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "https://api.openai.com/v1/chat/completions");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Content-Type: application/json',
            'Authorization: Bearer ' . $this->apiKey
        ]);

        $response = curl_exec($ch);
        curl_close($ch);

        $response_data = json_decode($response, true);

        $camelCase = $response_data['choices'][0]['message']['content'];

        // odpověď není nebo je víceslovná
        if (empty($camelCase) || str_contains($camelCase, ' ')) {
            return [$word];
        }

        return (new CamelCaseProvider())->split($camelCase);
    }
}