<?php

namespace App\Http\Controllers;

use App\Http\Requests\ContactUsStoreRequest;
use App\Http\Requests\HomeIngredientStoreRequest;
use App\Http\Requests\HomeSliderStoreRequest;
use App\Services\ContactUsService;
use App\Services\HomeIngredientService;
use App\Services\HomeSliderService;
use Illuminate\Http\Request;

class HomeIngredientController extends Controller
{
    private $homeIngredientService;

    public function __construct(HomeIngredientService $homeIngredientService)
    {
        $this->homeIngredientService = $homeIngredientService;
    }

    public function index(Request $request)
    {
        return $this->homeIngredientService->show($request);

    }

    public function store(HomeIngredientStoreRequest $request)
    {
        return $this->homeIngredientService->store($request);
    }

    public function destroy($id)
    {
        return $this->homeIngredientService->destroy($id);
    }
}
