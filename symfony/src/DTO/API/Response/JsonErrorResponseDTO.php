<?php

namespace App\DTO\API\Response;

class JsonErrorResponseDTO
{
    public string $message;

    /**
     * @var array<string>
     */
    public array $errors;
}
