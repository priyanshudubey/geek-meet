<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class GiphyService
{
    protected $apiKey;

    public function __construct()
    {
        $this->apiKey = env('GIPHY_API_KEY');
    }

    public function searchGifs(string $query, int $limit = 12)
    {
        $url = "https://api.giphy.com/v1/gifs/search";
        $response = Http::get($url, [
            'api_key' => $this->apiKey,
            'q' => $query,
            'limit' => $limit,
        ]);

        if ($response->failed()) {
            throw new \Exception('Failed to fetch GIFs.');
        }

        return $response->json()['data'];
    }
}
