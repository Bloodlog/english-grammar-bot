<?php

namespace App\Services;

use App\Support\OpenAiClient\OpenAiClient;

class GrammarCorrectionService
{

    private OpenAiClient $openAiClient;

    public function __construct(OpenAiClient $openAiClient)
    {
        $this->openAiClient = $openAiClient;
    }

    /**
     * Corrects sentences into standard English.
     *
     * @return array
     */
    public function send(string $message): array
    {
        return $this->openAiClient->request($message);
    }
}
