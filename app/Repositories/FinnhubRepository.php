<?php

namespace App\Repositories;

use App\Models\Stock;

class FinnhubRepository implements StocksRepository
{
    public function getStock(string $symbol, int $numberOfAttempts)
    {
        $attempts = 0;

        $payload['token'] = getenv('FINNHUB_API_KEY');
        $payload['symbol'] = $symbol;
        $client = new \GuzzleHttp\Client(['timeout' => 30]);

        do {
            try {
                $response = $client->request(
                    'GET',
                    getenv('FINNHUB_API_URL') . '/quote',
                    ['query' => $payload]
                );
                if ($response->getStatusCode() !== 200) {
                    return null;
                }
            } catch (\GuzzleHttp\Exception\ClientException $e) {
                if (strpos($e->getMessage(), "You don't have access to this resource.")) {
                    return null;
                }
                $attempts++;
                sleep(30);
                continue;
            }
            $data = json_decode($response->getBody());
            if ($data->d === null) {
                return null;
            }
            return $data;

        } while ($attempts < $numberOfAttempts);

        return null;
    }

    public function getSymbols(): ?array
    {
        $payload['token'] = getenv('FINNHUB_API_KEY');
        $payload['exchange'] = 'US';
        $client = new \GuzzleHttp\Client(['timeout' => 30]);
        $response = $client->request(
            'GET',
            getenv('FINNHUB_API_URL') . '/stock/symbol',
            ['query' => $payload]
        );

        if ($response->getStatusCode() !== 200) {
            return null;
        }
        return json_decode($response->getBody());
    }


    public function updateStock(Stock $stock): void
    {
        $payload['token'] = getenv('FINNHUB_API_KEY');
        $client = new \GuzzleHttp\Client(['timeout' => 30]);

        $payload['symbol'] = $stock->symbol;
        $response = $client->request(
            'GET',
            getenv('FINNHUB_API_URL') . '/quote',
            ['query' => $payload]
        );
        $response = json_decode($response->getBody());

        $stock->current_price = $response->c * 100;
        $stock->change = $response->d;
        $stock->percent_change = $response->dp;
        $stock->high_price = $response->h;
        $stock->low_price = $response->l;
        $stock->open_price = $response->o;
        $stock->previous_close_price = $response->pc;
        $stock->last_change_time = $response->t;

        $stock->save();

    }

    public function getNews(string $category, $payload): ?array
    {
        $payload['token'] = getenv('FINNHUB_API_KEY');

        $client = new \GuzzleHttp\Client(['timeout' => 30]);
        $response = $client->request(
            'GET',
            getenv('FINNHUB_API_URL') . $category,
            ['query' => $payload]
        );

        if ($response->getStatusCode() !== 200) {
            return null;
        }
        $news = json_decode($response->getBody());
        foreach ($news as $article) {
            $article->summary = preg_replace("/\/?[apliu]{0,2}&[gtli]{2};/", " ", $article->summary);
            $article->summary = preg_replace("/&apos;/", "'", $article->summary);
            $article->summary = preg_replace("/a href=/", "", $article->summary);
            $article->summary = preg_replace("/&quot;/", "", $article->summary);
            $article->summary = preg_replace("/target=_blank\S*/", " ", $article->summary);
            $article->summary = preg_replace("/data-article\S*/", "", $article->summary);

        }
        return $news;
    }

    public function saveStock($symbol, $data)
    {

        $payload['token'] = getenv('FINNHUB_API_KEY');
        $payload['symbol'] = $symbol;

        $client = new \GuzzleHttp\Client(['timeout' => 30]);
        $response = $client->request(
            'GET',
            getenv('FINNHUB_API_URL') . '/stock/profile2',
            ['query' => $payload]
        );

        if ($response->getStatusCode() !== 200) {
            return null;
        }

        $response = json_decode($response->getBody());

        $companyName = $response->name ?? null;

        if (!$companyName) {
            return null;
        }

        $stock = new Stock([
            'symbol' => $symbol,
            'company_name' => $companyName,
            'current_price' => $data->c * 100,
            'change' => $data->d,
            'percent_change' => $data->dp,
            'high_price' => $data->h,
            'low_price' => $data->l,
            'open_price' => $data->o,
            'previous_close_price' => $data->pc,
            'last_change_time' => $data->t
        ]);

        $stock->save();
        return $stock;
    }
}
