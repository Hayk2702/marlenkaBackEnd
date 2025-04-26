<?php

namespace App\Http\Controllers;

use App\Http\Requests\AwardStoreRequest;
use App\Http\Requests\FAQStoreRequest;
use App\Http\Requests\PrivacyPolicyStoreRequest;
use App\Services\AwardService;
use App\Services\FAQService;
use App\Services\PrivacyPolicyService;
use Illuminate\Http\Request;

class PrivacyPolicyController extends Controller
{
    private $privacyPolicyService;

    public function __construct(PrivacyPolicyService $privacyPolicyService)
    {
        $this->privacyPolicyService = $privacyPolicyService;
    }

    public function index(Request $request)
    {
        return $this->privacyPolicyService->show($request);

    }

    public function store(PrivacyPolicyStoreRequest $request)
    {
        return $this->privacyPolicyService->store($request);
    }

}
