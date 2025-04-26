<?php

namespace App\Http\Controllers;

use App\Http\Requests\AwardStoreRequest;
use App\Services\AwardService;
use Illuminate\Http\Request;

class AwardsController extends Controller
{
    private $awardService;

    public function __construct(AwardService $awardService)
    {
        $this->awardService = $awardService;
    }

    public function index(Request $request)
    {
        return $this->awardService->show($request);

    }

    public function store(AwardStoreRequest $request)
    {
        return $this->awardService->store($request);
    }

    public function destroy($id)
    {
        return $this->awardService->destroy($id);
    }

}
