<?php

namespace App\Http\Controllers;

use App\Models\Purchase;
use App\Models\Sale;
use App\Models\StockPortfolio;
use App\Services\PurchasesHistoryRecord;
use Illuminate\Support\Facades\Auth;

class PortfolioController extends Controller
{
    public function showTransactions()
    {
        return view('transactions-page', [
            'data' => new PurchasesHistoryRecord(
                Purchase::where('user_id', Auth::user()->id)
                    ->orderBy('symbol', 'asc')
                    ->orderBy('created_at', 'desc')
                    ->get(),
                Sale::where('user_id', Auth::user()->id)
                    ->orderBy('symbol', 'asc')
                    ->orderBy('created_at', 'desc')
                    ->get()
            ),
            'wallet' => Auth::user()->wallet
        ]);
    }

    public function showPortfolio()
    {
        return view('portfolio-page', [
            'stocks' => StockPortfolio::where([
                ['user_id', '=', Auth::user()->id],
                ['amount', '>', 0]
            ])
                ->orderBy('updated_at', 'desc')
                ->get(),
            'wallet' => Auth::user()->wallet
        ]);
    }
}
