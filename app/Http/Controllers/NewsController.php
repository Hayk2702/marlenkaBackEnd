<?php

namespace App\Http\Controllers;

use App\Http\Requests\AboutUsDataStoreRequest;
use App\Http\Requests\NewsStoreRequest;
use App\Services\AboutUsDataService;
use App\Services\NewsService;
use Illuminate\Http\Request;

class NewsController extends Controller
{
    private $newsService;

    public function __construct(NewsService $newsService)
    {
        $this->newsService = $newsService;
    }

    public function index(Request $request)
    {
        return $this->newsService->show($request);

    }

    public function store(NewsStoreRequest $request)
    {
        return $this->newsService->store($request);
    }

    public function destroy($id)
    {
        return $this->newsService->destroy($id);
    }
}
