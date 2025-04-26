<?php

namespace App\Http\Controllers;

use App\Http\Requests\AboutUsDataStoreRequest;
use App\Http\Requests\CategoriesStoreRequest;
use App\Services\AboutUsDataService;
use App\Services\CategoriesService;
use Illuminate\Http\Request;

class CategoriesController extends Controller
{
    private $categoriesService;

    public function __construct(CategoriesService $categoriesService)
    {
        $this->categoriesService = $categoriesService;
    }

    public function index(Request $request)
    {
        return $this->categoriesService->show($request);

    }

    public function store(CategoriesStoreRequest $request)
    {
        return $this->categoriesService->store($request);
    }

    public function destroy($id)
    {
        return $this->categoriesService->destroy($id);
    }
}
