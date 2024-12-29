<?php

namespace App\Exceptions;

use Exception;

class NotFoundException extends Exception
{
    protected $message;

    public function __construct($message = 'An unexpected error occurred.')
    {
        $this->message = $message;
    }

    public function render()
    {
        return response()->json([
            'error' => 'Not Found',
            'message' => $this->message,
        ], 500);
    }
}
