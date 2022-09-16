<?php

namespace Tests\Unit;

use App\Models\Stock;
use PHPUnit\Framework\TestCase;

class StockTest extends TestCase
{
    public function test_should_be_able_to_create_stock()
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
        $this->assertEquals('stock', $stock->symbol);
        $this->assertEquals('company', $stock->company_name);
        $this->assertEquals(1, $stock->current_price);
        $this->assertEquals(2, $stock->change);
        $this->assertEquals(3, $stock->percent_change);
        $this->assertEquals(4, $stock->high_price);
        $this->assertEquals(5, $stock->low_price);
        $this->assertEquals(6, $stock->open_price);
        $this->assertEquals(7, $stock->previous_close_price);
        $this->assertEquals(8, $stock->last_change_time);
    }
}
