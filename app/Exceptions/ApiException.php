<?php

namespace App\Exceptions;

use Exception;

class ApiException extends Exception
{
    protected $statusCode = 400;

    public function __construct(string $message = '', int $statusCode = 400, ?Exception $previous = null)
    {
        parent::__construct($message, 0, $previous);
        $this->statusCode = $statusCode;
    }

    public function getStatusCode(): int
    {
        return $this->statusCode;
    }

    public function render()
    {
        return response()->json([
            'success' => false,
            'message' => $this->getMessage(),
        ], $this->getStatusCode());
    }
}
