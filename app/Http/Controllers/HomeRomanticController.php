<?php

namespace App\Http\Controllers;

use App\Http\Requests\ContactUsStoreRequest;
use App\Http\Requests\HomeRomanticStoreRequest;
use App\Http\Requests\HomeSliderStoreRequest;
use App\Services\ContactUsService;
use App\Services\HomeRomanticService;
use App\Services\HomeSliderService;
use Illuminate\Http\Request;

class HomeRomanticController extends Controller
{
    private $homeRomanticService;

    public function __construct(HomeRomanticService $homeRomanticService)
    {
        $this->homeRomanticService = $homeRomanticService;
    }

    public function index(Request $request)
    {
        return $this->homeRomanticService->show($request);

    }

    public function store(HomeRomanticStoreRequest $request)
    {
        return $this->homeRomanticService->store($request);
    }
}
