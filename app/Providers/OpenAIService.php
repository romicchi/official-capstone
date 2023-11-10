<?php

namespace App\Services;

use GuzzleHttp\Client;

class OpenAIService
{
    protected $client;
    protected $apiKey;

    public function __construct()
    {
        $this->apiKey = config('services.openai.api_key');
        $this->client = new Client();
    }

    public function interactWithOpenAI($query)
    {
        $response = $this->client->post('https://api.openai.com/v1/engines/davinci-codex/completions', [
            'headers' => [
                'Authorization' => 'Bearer ' . $this->apiKey,
                'Content-Type' => 'application/json',
            ],
            'json' => [
                'prompt' => $query,
            ],
        ]);

        return json_decode($response->getBody());
    }
}
