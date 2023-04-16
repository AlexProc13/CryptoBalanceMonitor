<?php

namespace App\Http\Controllers;

use App\Http\Resources\WalletResource;
use App\Models\Wallet;
use App\Servises\Wallets\Currencies\Wallet as WalletService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class WalletController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return array
     */
    public function index(): array
    {
        $perPage = 100;
        $wallets = Wallet::with('lastBalance')->paginate($perPage);
        return [
            'status' => true,
            'total' => $wallets->total(),
            'perPage' => $wallets->perPage(),
            'hasPages' => $wallets->hasPages(),
            'currentPage' => $wallets->currentPage(),
            'previousPageUrl' => $wallets->previousPageUrl(),
            'data' => WalletResource::collection($wallets),
        ];
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
        $currencies = config('wallets.currencies');
        $validator = Validator::make($request->all(), [
            'address' => ['required', 'max:255'],
            'currency' => ['required', Rule::in(array_keys($currencies))],
        ]);
        if ($validator->fails()) {
            return ['status' => false];
        }

        $walletService = app()->make(WalletService::class, ['currency' => $request->currency]);
        //check is address related for currency network
        if (!$walletService->isAddress($request->address)) {
            return ['status' => false, 'msg' => 'Wrong address for this network'];
        }
        //create wallet
        DB::beginTransaction();
        Wallet::create(['type' => $currencies[$request->currency], 'address' => $request->address]);
        //...
        DB::commit();

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
