<?php

namespace App\Console\Commands;

use App\Models\Wallet;
use App\Servises\Wallets\Currencies\Wallet as WalletService;
use Illuminate\Console\Command;
use Illuminate\Database\Eloquent\Collection;

class GetBalanceData extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:get-balance-data';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Get balance data for wallets';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $currencies = config('wallets.currencies');
        foreach ($currencies as $currency => $currencyId) {
            $this->line('RUN... ' . $currency);
            //todo what to do if one of sources not working - need discuss
            $this->updateData($currencyId);
            sleep(1);
        }
        $this->line('Done');
    }

    protected function updateData($currencyId)
    {
        $chunkSize = 30;//todo depends on api's limits && we use `get` we have to consider this
        $walletService = app()->make(WalletService::class, ['currencyId' => $currencyId]);
        Wallet::where('type', $currencyId)->with('lastBalance')
            ->chunk($chunkSize, function (Collection $wallets) use ($walletService) {
                $walletService->updateBalances($wallets);
                usleep(100000);
            });
    }
}
