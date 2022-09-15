<?php

namespace App\Http\Controllers;

use App\Services\GetNewsService;

class MainPageController extends Controller
{
    private GetNewsService $getNewsService;

    public function __construct(GetNewsService $getNewsService)
    {
        $this->getNewsService = $getNewsService;
    }

    public function index()
    {
        $payload['category'] = 'forex';
        $payload['minId'] = '10';
        $news = $this->getNewsService->get('/news', $payload);

        return view('welcome', ['news' => $news]);
    }
}
