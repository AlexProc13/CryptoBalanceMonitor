<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Tests\TestCase;
use App\Models\Wallet;

class WalletTest extends TestCase
{
    use RefreshDatabase;

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
        $response = $this->json(Request::METHOD_GET, route('wallets.index'));
        $response
            ->assertStatus(Response::HTTP_OK)
            ->assertJsonStructure([
                'status',
                'total',
                'perPage',
                'hasPages',
                'previousPageUrl',
                'previousPageUrl',
                'data' => [
                    [
                        'id',
                        'address',
                        'balance',
                        'createdAt',
                        'balanceUpdated',
                    ]
                ],
            ])
            ->assertJsonFragment(['status' => true])
            ->assertJsonCount($wallets->count(), 'data')
            ->assertStatus(200);
    }

    public function testGetWalletStore(): void
    {
        //todo by facker
        $addresses = [
            'MQSs17ECe51kqhkFPQY98wiyPvGuK5iCB6',
            'MQSs17ECe51kqhkFPQY98wiyPvGuK5iCB6'
        ];
        $data = ['currency' => 'LTC', 'address' => fake()->randomElement($addresses),];
        $response = $this->json(Request::METHOD_POST, route('wallets.index'), $data);
        $response
            ->assertStatus(Response::HTTP_OK)
            ->assertJsonStructure([
                'status'
            ])
            ->assertJsonFragment(['status' => true])
            ->assertStatus(200);

        $this->assertDatabaseHas('wallets', [
            'address' => $data['address'],
        ]);
    }

    public function testGetWalletStoreError(): void
    {
        //todo by facker
        $addresses = [
            'Wrong address1',
            'Wrong address2'
        ];
        $data = ['currency' => 'LTC', 'address' => fake()->randomElement($addresses),];
        $response = $this->json(Request::METHOD_POST, route('wallets.index'), $data);
        $response
            ->assertStatus(Response::HTTP_OK)
            ->assertJsonStructure([
                'status'
            ])
            ->assertJsonFragment(['status' => false])
            ->assertStatus(200);

        $this->assertDatabaseMissing('wallets', [
            'address' => $data['address'],
        ]);
    }
}
