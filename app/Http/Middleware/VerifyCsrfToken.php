<?php

namespace App\Http\Middleware;

use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as Middleware;

class VerifyCsrfToken extends Middleware
{
    /**
     * The URIs that should be excluded from CSRF verification.
     *
     * @var array
     */
    protected $except = [
        //
        '/user_api',
        '/get_user_count_api',
        '/search_user_api',
        '/change_user_dormant_status_api',
        '/change_user_status_api',
        '/activate_user_portal_api',
        '/update_subscription',
    ];
}
