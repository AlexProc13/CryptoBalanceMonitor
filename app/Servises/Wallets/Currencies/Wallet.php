<?php

namespace App\Servises\Wallets\Currencies;

use Exception;
use App\Models\Wallet as WalletModel;
use App\Models\HistoryBalance;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

abstract class Wallet
{
    /**
     * @return Source
     */
    abstract public function getSource(): Source;

    abstract public function fromPennyToCoin(string $pennies): string;

    /**
     * @param Collection $wallets
     * @return bool
     */
    public function updateBalances(Collection $wallets): bool
    {
        //todo catch errors if it would be neeeded
        $addresses = $wallets->pluck('address')->toArray();
        $source = $this->getSource();
        $balancePerAddress = $source->getBalances($addresses);
        foreach ($wallets as $wallet) {
            if (!isset($balancePerAddress[$wallet->address])) {
                continue;
            }

            $balance = $wallet->lastBalance->balance;
            $currentBalance = $balancePerAddress[$wallet->address];
            //update only if changed
            if ($balance === (string)$currentBalance) {
                continue;
            }

            HistoryBalance::create([
                'wallet_id' => $wallet->id,
                'balance' => $currentBalance
            ]);
        }

        return true;
    }

    public function store(Request $request): bool
    {
        $currencies = config('wallets.currencies');
        //check is address related for currency network
        if (!$this->isAddress($request->address)) {
            throw new Exception('Wrong address for this network');
        }
        //create wallet
        DB::beginTransaction();
        WalletModel::create(['type' => $currencies[$request->currency], 'address' => $request->address]);
        //...some actions
        DB::commit();

        return true;
    }
}
