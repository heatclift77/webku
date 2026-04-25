<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Exception;

class AIService
{
    protected ?string $apiKey;
    protected ?string $model;
    protected ?string $baseUrl;

    public function __construct()
    {
        $this->apiKey = config('services.groq.api_key');
        $this->model = config('services.groq.model') ?? 'llama3-8b-8192';
        $this->baseUrl = config('services.groq.base_url') ?? 'https://api.groq.com';
    }

    public function generateSalesPage(string $prompt): string
    {
        if (!$this->apiKey) {
            throw new Exception('Groq API key is not configured. Please set GROQ_API_KEY in your .env file.');
        }
        try {
            $response = Http::timeout(300000)
                ->withHeaders([
                    'Authorization' => 'Bearer ' . $this->apiKey,
                    'Content-Type' => 'application/json',
                ])
                ->post($this->baseUrl . '/openai/v1/chat/completions', [
                    'model' => $this->model,
                    'messages' => [
                        [
                            'role' => 'user',
                            'content' => $prompt,
                        ],
                    ],
                    'temperature' => 0.7,
                ]);


            if (!$response->successful()) {
                Log::error('Groq API Error: ' . $response->body());
                throw new Exception('Groq API request failed: ' . $response->status() . ' - ' . $response->body());
            }

            $data = $response->json();

            if (!isset($data['choices'][0]['message']['content'])) {
                Log::error('Invalid Groq Response: ' . json_encode($data));
                throw new Exception('Invalid response structure from Groq API');
            }

            return $data['choices'][0]['message']['content'];

        } catch (Exception $e) {
            // Log the error or handle as needed
            Log::error('Failed to generate sales page: ' . $e->getMessage());
            throw new Exception('Failed to generate sales page: ' . $e->getMessage());
        }
    }
}