<?php

namespace App\Http\Requests;

use App\Helpers\JsendResponse;
use Illuminate\Foundation\Http\FormRequest;

abstract class Request extends FormRequest
{
    /**
     * Get the proper failed validation response for the request.
     *
     * @param  array $errors
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function response(array $errors)
    {
        return new JsendResponse(['errors' => $errors], 'Input validation failed', 422);
    }
}
