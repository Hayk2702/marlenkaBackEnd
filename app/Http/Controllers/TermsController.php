<?php

namespace App\Http\Controllers;

use App\Http\Requests\AwardStoreRequest;
use App\Http\Requests\FAQStoreRequest;
use App\Http\Requests\PrivacyPolicyStoreRequest;
use App\Http\Requests\TermStoreRequest;
use App\Services\AwardService;
use App\Services\FAQService;
use App\Services\PrivacyPolicyService;
use App\Services\TermService;
use Illuminate\Http\Request;

class TermsController extends Controller
{
    private $termService;

    public function __construct(TermService $termService)
    {
        $this->termService = $termService;
    }

    public function index(Request $request)
    {
        return $this->termService->show($request);

    }

    public function store(TermStoreRequest $request)
    {
        return $this->termService->store($request);
    }

}
