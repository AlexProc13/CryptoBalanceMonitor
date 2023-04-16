<?php

namespace App\Providers;

use Exception;
use App\Servises\Wallets\Wallet;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(Wallet::class, function ($app, $params) {
            //check currency
            if (!isset($params['currency'])) {
                throw new Exception('wrong currency');
            }
            //check provider
            $currency = $params['currency'];
            $walletProviders = config('wallets.walletProviders');
            if (!isset($walletProviders[$currency])) {
                throw new Exception('wrong currency');
            }

            return new $walletProviders[$currency]();
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
