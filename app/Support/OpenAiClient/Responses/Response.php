<?php

namespace App\Support\OpenAiClient\Responses;

class Response
{
    public string $id;
    public string $object;
    public int $created;
    public string $model;
    public array $choices;

    /**
     * @param array $parameters
     * @return $this
     */
    public function from(array $parameters): self
    {
        $this->id = $parameters['id'];
        $this->object = $parameters['object'];
        $this->created = $parameters['created'];
        $this->model = $parameters['model'];
        $this->choices = $parameters['choices'];

        return $this;
    }

    /**
     * @return array
     */
    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'object' => $this->object,
            'created' => $this->created,
            'model' => $this->model,
            'choices' => $this->choices
        ];
    }
}
