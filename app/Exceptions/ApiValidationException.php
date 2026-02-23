<?php

namespace App\Exceptions;

use Illuminate\Validation\ValidationException;

class ApiValidationException extends ApiException
{
    public function __construct(ValidationException $exception)
    {
        parent::__construct(
            'Validation failed',
            422,
            $exception
        );
    }

    public function render()
    {
        return response()->json([
            'success' => false,
            'message' => $this->getMessage(),
            'errors' => $this->getPrevious()?->errors(),
        ], $this->getStatusCode());
    }
}
