<?php

namespace App\Support\OpenAiClient;

use App\Support\OpenAiClient\Exceptions\RequestException;
use App\Support\OpenAiClient\Responses\Response;
use JsonException;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use App\Support\OpenAiClient\Exceptions\ErrorException;

class OpenAiClient
{
    private Client $client;

    private Response $response;

    public function __construct(Client $client, Response $response)
    {
        $this->client = $client;
        $this->version = 'v1';
        $this->response = $response;
    }

    /**
     * @param string $message
     * @return array
     * @throws ErrorException
     * @throws RequestException
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function request(string $message): array
    {
        $data = [
            "model" => config('services.openai.model'),
            "prompt" => "Correct this to standard English:\n\n" . $message,
            "temperature" => 0,
            "max_tokens" => 60,
            "top_p" => 1.0,
            "frequency_penalty" => 0.0,
            "presence_penalty" => 0.0
        ];

        $response = $this->post('/completions', [], $data);

        return $this->response->from($response)->toArray();
    }

    /**
     * @param string $uri
     * @param array $query
     * @param array $form
     * @return array
     * @throws ErrorException
     * @throws RequestException
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function post(string $uri, array $query = [], array $form = []): array
    {
        return json_decode($this->makeRequest('POST', $uri, $query, $form), true);
    }

    /**
     * @param string $method
     * @param string $uri
     * @param array $query
     * @param array $form
     * @return string
     * @throws ErrorException
     * @throws RequestException
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function makeRequest(string $method, string $uri, array $query = [], array $form = []): string
    {
        try {
            $response = $this->client->request($method, $this->version
                . $uri, ['query' => $query, 'json' => $form]);
        } catch (ClientException $exception) {
            throw new RequestException($exception);
        }

        $contents = $response->getBody()->getContents();
        try {
            $response = json_decode($contents, true, 512, JSON_THROW_ON_ERROR);
            if (isset($response['error'])) {
                throw new ErrorException($response['error']);
            }
        } catch (JsonException $exception) {
            throw new \Exception($exception);
        }

        return $contents;
    }
}
