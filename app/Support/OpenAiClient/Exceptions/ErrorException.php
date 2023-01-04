<?php

namespace App\Support\OpenAiClient\Exceptions;

use Exception;

final class ErrorException extends Exception
{
    /**
     * @var array
     */
    private mixed $contents;

    /**
     * @param array $contents
     */
    public function __construct(array $contents)
    {
        parent::__construct($contents['message']);
        $this->contents = $contents['message'];
    }

    /**
     * Returns the error message.
     */
    public function getErrorMessage(): string
    {
        return $this->getMessage();
    }

    /**
     * Returns the error type.
     */
    public function getErrorType(): string
    {
        return $this->contents['type'];
    }

    /**
     * Returns the error type.
     */
    public function getErrorCode(): string
    {
        return $this->contents['code'];
    }
}
