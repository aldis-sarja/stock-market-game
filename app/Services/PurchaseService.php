<?php


namespace App\Services;

use App\Models\Purchase;
use App\Models\Sale;
use App\Models\StockPortfolio;

class PurchaseService
{
    public function buy(TransactionRequest $request): PurchasesHistoryRecord
    {

        $realPrice = $request->getStock()->current_price * $request->getAmount();
        $purchase = new Purchase([
            'user_id' => $request->getUser()->id,
            'stock_id' => $request->getStock()->id,
            'symbol' => $request->getStock()->symbol,
            'price' => (int)$realPrice,
            'amount' => $request->getAmount()
        ]);
        $purchase->save();

        $request->getUser()->update([
            'wallet' => $request->getUser()->wallet - (int)$realPrice
        ]);

        $portfolio = StockPortfolio::firstWhere([
            ['stock_id', '=', $request->getStock()->id],
            ['user_id', '=', $request->getUser()->id]
        ]);

        if (!$portfolio) {
            $portfolio = new StockPortfolio([
                'stock_id' => $request->getStock()->id,
                'symbol' => $request->getStock()->symbol,
                'amount' => $request->getAmount(),
            ]);
            $portfolio->user()->associate($request->getUser());
            $portfolio->save();

        } else {
            $portfolio->update([
                'amount' => $portfolio->amount + $request->getAmount(),
            ]);
        }

        return new PurchasesHistoryRecord(
            Purchase::where([
                ['user_id', '=', $request->getUser()->id],
                ['stock_id', '=', $request->getStock()->id]
            ])
                ->orderBy('created_at', 'desc')
                ->get(),

            Sale::where([
                ['user_id', $request->getUser()->id],
                ['stock_id', '=', $request->getStock()->id]
            ])
                ->orderBy('created_at', 'desc')
                ->get()
        );
    }

    public function sell(TransactionRequest $request): PurchasesHistoryRecord
    {

        $realPrice = $request->getStock()->current_price * $request->getAmount();
        $sale = new Sale([
            'user_id' => $request->getUser()->id,
            'stock_id' => $request->getStock()->id,
            'symbol' => $request->getStock()->symbol,
            'price' => (int)$realPrice,
            'amount' => $request->getAmount()
        ]);
        $sale->save();

        $request->getUser()->update([
            'wallet' => $request->getUser()->wallet + (int)$realPrice
        ]);

        $portfolio = StockPortfolio::firstWhere([
            ['stock_id', '=', $request->getStock()->id],
            ['user_id', '=', $request->getUser()->id]
        ]);

        $portfolio->update([
            'amount' => $portfolio->amount - $request->getAmount(),
        ]);

        return new PurchasesHistoryRecord(
            Purchase::where([
                ['user_id', '=', $request->getUser()->id],
                ['stock_id', '=', $request->getStock()->id]
            ])
                ->orderBy('created_at', 'desc')
                ->get(),

            Sale::where([
                ['user_id', '=', $request->getUser()->id],
                ['stock_id', '=', $request->getStock()->id]
            ])
                ->orderBy('created_at', 'desc')
                ->get()
        );
    }

}
