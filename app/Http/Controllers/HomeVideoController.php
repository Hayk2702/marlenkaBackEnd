<?php

namespace App\Http\Controllers;

use App\Http\Requests\ContactUsStoreRequest;
use App\Http\Requests\HomeSliderStoreRequest;
use App\Http\Requests\HomeVideoStoreRequest;
use App\Services\ContactUsService;
use App\Services\HomeSliderService;
use App\Services\HomeVideoService;
use Illuminate\Http\Request;

class HomeVideoController extends Controller
{
    private $homeVideoService;

    public function __construct(HomeVideoService $homeVideoService)
    {
        $this->homeVideoService = $homeVideoService;
    }

    public function index(Request $request)
    {
        return $this->homeVideoService->show($request);

    }

    public function store(HomeVideoStoreRequest $request)
    {
        return $this->homeVideoService->store($request);
    }
}
