<?php

class Errorhandler
{
    public static function handleExcpetion($exception)
    {
        $responseCode = $exception->getCode();

        if ($responseCode && $responseCode !== 0) {
            http_response_code($responseCode);
        } else {
            http_response_code(500);
        }

        echo json_encode([
            "message" => $exception->getMessage(),
            "file" => $exception->getFile(),
            "line" => $exception->getLine()
        ]);
    }
}
