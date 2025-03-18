<?php

namespace App\Http\Middleware;

use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as Middleware;

class VerifyCsrfToken extends Middleware
{
    /**
     * المسارات المستثناة من التحقق من CSRF
     *
     * @var array<int, string>
     */
    protected $except = [
        'https://bulk.whysms.com/api/v3/sms/send' // أضف أي روابط تريد استثنائها هنا
    ];
}
