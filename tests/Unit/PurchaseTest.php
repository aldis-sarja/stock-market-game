<?php

namespace Tests\Unit;

use App\Models\Purchase;
use App\Models\Sale;
use App\Models\Stock;
use App\Models\StockPortfolio;
use App\Models\User;
use App\Services\PurchaseService;
use App\Services\TransactionRequest;
use PHPUnit\Framework\TestCase;

class PurchaseTest extends TestCase
{
    public function test_should_be_able_to_buy_and_sell_stocks()
    {
        $stock = new Stock([
            'symbol' => 'stock',
            'company_name' => 'company',
            'current_price' => 1,
            'change' => 2,
            'percent_change' => 3,
            'high_price' => 4,
            'low_price' => 5,
            'open_price' => 6,
            'previous_close_price' => 7,
            'last_change_time' => 8
        ]);

        $user = new User([
            'name' => 'UserName',
            'email' => 'user@email.com',
            'password' => 'user_password',
            'wallet' => 100000,
        ]);

        (new PurchaseService)->buy(new TransactionRequest(
            $user,
            $stock,
            5
        ));

        $this->assertEquals(99995, $user->wallet);

        $purchase = Purchase::firstWhere([
            ['symbol', '=', 'stock'],
            ['amount', '=', 5],
            ['price', '=', 5],
            ['user_id', '=', $user->id],
            ['stock_id', '=', $stock-id]
        ]);
        $this->assertNotNull($purchase);

        $portfolio = StockPortfolio::firstWhere([
            ['symbol', '=', 'stock'],
            ['amount', '=', 5],
            ['user_id', '=', $user->id],
            ['stock_id', '=', $stock-id]
        ]);

        (new PurchaseService)->sell(new TransactionRequest(
            $user,
            $stock,
            3
        ));

        $this->assertEquals(99998, $user->wallet);

        $purchase = Sale::firstWhere([
            ['symbol', '=', 'stock'],
            ['amount', '=', 3],
            ['price', '=', 3],
            ['user_id', '=', $user->id],
            ['stock_id', '=', $stock-id]
        ]);
        $this->assertNotNull($purchase);

        $portfolio = StockPortfolio::firstWhere([
            ['symbol', '=', 'stock'],
            ['amount', '=', 2],
            ['user_id', '=', $user->id],
            ['stock_id', '=', $stock-id]
        ]);

    }
}
