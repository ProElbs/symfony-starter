<?php

namespace App\Exception;

use Exception;
use Throwable;

class FormException extends Exception
{
    /** @var array<string> $errors */
    protected array $errors = [];

    /**
     * FormException constructor.
     *
     * @param array<string>  $errors
     * @param string         $message
     * @param int            $code
     * @param Throwable|null $previous
     */
    public function __construct(array $errors, $message = '', $code = 0, Throwable $previous = null)
    {
        $this->errors = $errors;
        parent::__construct($message, $code, $previous);
    }

    /**
     * @return array<string>
     */
    public function getErrors(): array
    {
        return $this->errors;
    }
}
