<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Tests\TestCase;
use App\Models\Wallet;

class WalletTest extends TestCase
{
   // use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();
        //...
    }

    public function testGetWalletIndexEmpty(): void
    {
        $response = $this->json(Request::METHOD_GET, route('wallets.index'));
        $response
            ->assertStatus(Response::HTTP_OK)
            ->assertJsonStructure([
                'status',
                'total',
                'perPage',
                'hasPages',
                'previousPageUrl',
                'data',
                "previousPageUrl",
            ])
            ->assertJsonFragment(['status' => true])
            ->assertStatus(200);
    }

    public function testGetWalletIndexWithData(): void
    {
        $count = mt_rand(5, 10);
        $wallets = Wallet::factory()->count($count)->create();

dd(Wallet::all()->toArray());
        $response = $this->json(Request::METHOD_GET, route('wallets.index'));
        dd($wallets->toArray(), route('wallets.index'));
        $response
            ->assertStatus(Response::HTTP_OK)
            ->assertJsonStructure([
                'status',
                'total',
                'perPage',
                'hasPages',
                'previousPageUrl',
                'data',
                "previousPageUrl",
            ])
            ->assertJsonFragment(['status' => true, 'total' => $count])
            ->assertStatus(200);
    }
}
