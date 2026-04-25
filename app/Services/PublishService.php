<?php

namespace App\Services;

use Exception;
use Illuminate\Http\Client\ConnectionException;
use Illuminate\Http\Client\RequestException;
use Illuminate\Support\Facades\Http;

class PublishService
{
    /**
     * @throws Exception
     */
    public function createSite(string $siteName): array
    {
        $token = (string) env('NETLIFY_TOKEN');

        if ($token === '') {
            throw new Exception('Netlify token is not configured.');
        }

        $baseUrl = 'https://api.netlify.com/api/v1';

        try {
            $response = Http::withToken($token)
                ->acceptJson()
                ->post("{$baseUrl}/sites", [
                    'name' => $siteName,
                ])
                ->throw()
                ->json();

            $siteId = $response['id'] ?? null;
            $siteUrl = $response['url'] ?? null;

            if (! is_string($siteId) || $siteId === '') {
                throw new Exception('Netlify did not return a valid site ID.');
            }

            if (! is_string($siteUrl) || $siteUrl === '') {
                throw new Exception('Netlify did not return a valid site URL.');
            }

            return [
                'site_id' => $siteId,
                'site_url' => $siteUrl,
            ];
        } catch (ConnectionException $exception) {
            throw new Exception('Failed to connect to Netlify.', previous: $exception);
        } catch (RequestException $exception) {
            $responseBody = $exception->response?->body();
            $message = $responseBody ? "Netlify API request failed: {$responseBody}" : 'Netlify API request failed.';

            throw new Exception($message, previous: $exception);
        }
    }

    /**
     * @throws Exception
     */
    public function publishHtml(string $html, string $siteId): string
    {
        $token = (string) env('NETLIFY_TOKEN');

        if ($token === '') {
            throw new Exception('Netlify token is not configured.');
        }

        if ($siteId === '') {
            throw new Exception('Site ID is required.');
        }

        $filePath = 'index.html';
        $fileHash = sha1($html);
        $baseUrl = 'https://api.netlify.com/api/v1';

        try {
            $createDeployResponse = Http::withToken($token)
                ->acceptJson()
                ->post("{$baseUrl}/sites/{$siteId}/deploys", [
                    'files' => [
                        $filePath => $fileHash,
                    ],
                ])
                ->throw()
                ->json();

            $deployId = $createDeployResponse['id'] ?? null;

            if (! is_string($deployId) || $deployId === '') {
                throw new Exception('Netlify did not return a valid deploy ID.');
            }

            Http::withToken($token)
                ->withBody($html, 'text/html; charset=UTF-8')
                ->send('PUT', "{$baseUrl}/deploys/{$deployId}/files/{$filePath}")
                ->throw();

            $deployDetails = Http::withToken($token)
                ->acceptJson()
                ->get("{$baseUrl}/deploys/{$deployId}")
                ->throw()
                ->json();

            $deployUrl = $deployDetails['ssl_url']
                ?? $deployDetails['deploy_ssl_url']
                ?? $deployDetails['url']
                ?? null;

            if (! is_string($deployUrl) || $deployUrl === '') {
                throw new Exception('Netlify deploy URL not found in response.');
            }

            return $deployUrl;
        } catch (ConnectionException $exception) {
            throw new Exception('Failed to connect to Netlify.', previous: $exception);
        } catch (RequestException $exception) {
            $responseBody = $exception->response?->body();
            $message = $responseBody ? "Netlify API request failed: {$responseBody}" : 'Netlify API request failed.';

            throw new Exception($message, previous: $exception);
        }
    }
}
