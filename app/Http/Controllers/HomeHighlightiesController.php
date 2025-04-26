<?php

namespace App\Http\Controllers;

use App\Http\Requests\HomeHighlightiesStoreRequest;
use App\Services\HomeHighlightiesService;
use Illuminate\Http\Request;

class HomeHighlightiesController extends Controller
{
    private $homeHighlightiesService;

    public function __construct(HomeHighlightiesService $homeHighlightiesService)
    {
        $this->homeHighlightiesService = $homeHighlightiesService;
    }

    public function index(Request $request)
    {
        return $this->homeHighlightiesService->show($request);

    }

    public function store(HomeHighlightiesStoreRequest $request)
    {
        return $this->homeHighlightiesService->store($request);
    }
}
