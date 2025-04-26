<?php

namespace App\Http\Controllers;

use App\Http\Requests\AwardStoreRequest;
use App\Http\Requests\FAQStoreRequest;
use App\Services\AwardService;
use App\Services\FAQService;
use Illuminate\Http\Request;

class FAQController extends Controller
{
    private $FAQService;

    public function __construct(FAQService $FAQService)
    {
        $this->FAQService = $FAQService;
    }

    public function index(Request $request)
    {
        return $this->FAQService->show($request);

    }

    public function store(FAQStoreRequest $request)
    {
        return $this->FAQService->store($request);
    }

    public function destroy($id)
    {
        return $this->FAQService->destroy($id);
    }

}
