<?php

namespace App\Http\Controllers;

use App\Http\Requests\AboutUsDataStoreRequest;
use App\Services\AboutUsDataService;
use Illuminate\Http\Request;

class AboutUsDataController extends Controller
{
    private $aboutUsDataService;

    public function __construct(AboutUsDataService $aboutUsDataService)
    {
        $this->aboutUsDataService = $aboutUsDataService;
    }

    public function index(Request $request)
    {
        return $this->aboutUsDataService->show($request);

    }

    public function store(AboutUsDataStoreRequest $request)
    {
        return $this->aboutUsDataService->store($request);
    }

    public function destroy($id)
    {
        return $this->aboutUsDataService->destroy($id);
    }

    public function setMainAbout(Request $request)
    {
        return $this->aboutUsDataService->setMainAbout($request);
    }
}
