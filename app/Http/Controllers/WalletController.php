<?php

namespace App\Http\Controllers;

use App\Http\Resources\WalletResource;
use App\Http\Resources\WalletCollection;
use App\Models\Wallet;
use App\Servises\Wallets\Currencies\Wallet as WalletService;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class WalletController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return array
     */
    public function index(): ResourceCollection
    {
        $perPage = 10;
        $wallets = Wallet::with('lastBalance')->paginate($perPage);
        return new WalletCollection($wallets);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return array|false[]|true[]
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    public function store(Request $request): array
    {
        $validator = Validator::make($request->all(), [
            'address' => ['required', 'max:255'],
            'currency' => ['required', Rule::in(array_keys(config('wallets.currencies')))],
        ]);
        if ($validator->fails()) {
            return ['status' => false];
        }

        $walletService = app()->make(WalletService::class, ['currency' => $request->currency]);
        $walletService->store($request);

        return ['status' => true];
    }

    /**
     * Display the specified resource.
     *
     * @param Request $request
     * @param int $id
     * @return array|false[]
     */
    public function show(Request $request, int $id): array
    {
        $wallet = Wallet::where('id', $id)->with('lastBalance')->first();
        if (is_null($wallet)) {
            return ['status' => false];
        }
        return ['status' => true, 'data' => new WalletResource($wallet)];
    }
}
