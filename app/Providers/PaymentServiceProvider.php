<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Http\Services\PaymobPaymentService;
use App\Interfaces\PaymentGatewayInterface;

class PaymentServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void {
        $this->app->bind(PaymentGatewayInterface::class, PaymobPaymentService::class);
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
