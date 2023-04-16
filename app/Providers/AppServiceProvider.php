<?php

namespace App\Providers;

use App\Servises\Wallets\Currencies\Wallet;
use Exception;
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
            if (!isset($params['currency']) && !isset($params['currencyId'])) {
                throw new Exception('wrong currency');
            }

            //get by id or code
            if (isset($params['currencyId'])) {
                $currency = array_flip(config('wallets.currencies'))[$params['currencyId']];
            } else {
                $currency = $params['currency'];
            }

            //check provider
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
