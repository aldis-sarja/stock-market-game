<?php

namespace App\Http\Controllers;

use App\Models\Stock;
use App\Models\StockPortfolio;
use App\Services\PurchaseService;
use App\Services\TransactionRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Validator;

class TransactionController extends Controller
{
    private PurchaseService $purchaseService;

    public function __construct(PurchaseService $purchaseService)
    {
        $this->purchaseService = $purchaseService;
    }

    public function transaction(Request $request)
    {
        $history = null;
        $stock = Stock::find($request->get('id'));
        $user = Auth::user();


        $totalAmount = StockPortfolio::firstWhere([
                ['stock_id', '=', $request->get('id')],
                ['user_id', '=', $user->id]
            ])->amount ?? 0;


        switch ($request->get('button')) {
            case 'buy':
                $maxAmount = ceil($user->wallet / ($stock->current_price));
                $validator = $request->validate([
                    'amount' => "required|lte:{$maxAmount}|gt:0",
                ],
                    [
                        'amount.lte' => 'Not enough money!',
                        'amount.gt' => 'Nothing to buy!',
                    ]);

                $history = $this->purchaseService->buy(new TransactionRequest(
                    $user,
                    $stock,
                    $request->get('amount')
                ));
                break;

            case 'sell':

                $validator = $request->validate([
                    'amount' => "required|lte:{$totalAmount}|gt:0",
                ],
                    [
                        'amount.lte' => 'You don\'t have so many stocks!',
                        'amount.gt' => 'Nothing to sell!',
                    ]);

                $history = $this->purchaseService->sell(new TransactionRequest(
                    $user,
                    $stock,
                    $request->get('amount')
                ));
                break;

            case 'sell_all':
                $history = $this->purchaseService->sell(new TransactionRequest(
                    $user,
                    $stock,
                    $totalAmount
                ));
                break;
        }


        return view('transactions-page', [
            'data' => $history,
            'wallet' => $user->wallet
        ]);
    }
}
