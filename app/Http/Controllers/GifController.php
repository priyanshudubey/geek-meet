<?php

namespace App\Http\Controllers;

use App\Services\GiphyService;
use Illuminate\Http\Request;

class GifController extends Controller
{
    protected $giphyService;

    public function __construct(GiphyService $giphyService)
    {
        $this->giphyService = $giphyService;
    }

    public function search(Request $request)
    {
        $query = $request->input('query');
        $gifs = $this->giphyService->searchGifs($query);

        return view('gifs.results', ['gifs' => $gifs['data']]);
    }
}
