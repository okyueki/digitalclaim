<?php

namespace App\Http\Middleware;

use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as Middleware;

class VerifyCsrfToken extends Middleware
{
    /**
     * The URIs that should be excluded from CSRF verification.
     *
     * @var array<int, string>
     */
   protected function tokensMatch($request)
    {
        \Log::info('CSRF token match: ', ['token' => $request->session()->token(), 'input' => $request->input('_token')]);
        return parent::tokensMatch($request);
    }
}
