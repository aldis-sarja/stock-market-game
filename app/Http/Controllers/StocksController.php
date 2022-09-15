<?php

namespace App\Http\Controllers;

use App\Models\Purchase;
use App\Models\Sale;
use App\Models\Stock;
use App\Models\StockPortfolio;
use App\Services\GetNewsService;
use App\Services\StocksLookUpService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class StocksController extends Controller
{
    private StocksLookUpService $service;
    private GetNewsService $getNewsService;

    public function __construct(StocksLookUpService $service, GetNewsService $getNewsService)
    {
        $this->service = $service;
        $this->getNewsService = $getNewsService;
    }

    public function getStocks(Request $request)
    {

        return view('dashboard', [
            'data' => Stock::orderBy('updated_at', 'desc')->paginate(10),
            'wallet' => Auth::user()->wallet,
        ]);
    }

    public function getStockInfo(Request $request)
    {
        $stockId = $request->get('id');
        $user = Auth::user();

        $stockInfo = $this->service->getStockFullInfo($stockId);

        $totalAmount = StockPortfolio::firstWhere([
                ['stock_id', '=', $stockId],
                ['user_id', '=', $user->id]
            ])->amount ?? 0;

        $totalSpend = 0;

        if ($totalAmount) {
            $purchases = Purchase::where([
                ['stock_id', '=', $stockId],
                ['user_id', '=', $user->id]
            ])->get();

            foreach ($purchases as $purchase) {
                $totalSpend += $purchase->price;
            }

            $sales = Sale::where([
                ['stock_id', '=', $stockId],
                ['user_id', '=', $user->id]
            ])->get();

            foreach ($sales as $sale) {
                $totalSpend -= $sale->price;
            }
        }

        $payload['to'] = date("Y-m-01");
        $payload['from'] = date("Y-m-01", strtotime("-12 months"));

        $payload['symbol'] = $stockInfo->symbol;

        return view('stock-info', [
            'stock' => $stockInfo,
            'wallet' => $user->wallet,
            'amount' => $totalAmount,
            'total_spend' => $totalSpend,
            'news' => $this->getNewsService->get('/company-news', $payload)
        ]);
    }

    public function searchStock(Request $request)
    {
        $validator = $request->validate([
            'symbol' => "required",
        ],
        [
            'symbol.required' => 'Nothing to search!'
        ]);

        $symbol = $request->get('symbol');
        $stock = $this->service->search($symbol);
        $symbol = $stock->symbol ?? false;

        $validator = $request->validate([
            'symbol' => [
                Rule::in([$symbol]),
            ],
        ],
            [
                'symbol.same' => 'Can\'t find ' . $symbol . "!",
            ]);
        $request['id'] = $stock->id;
        return $this->getStockInfo($request);
    }
}
