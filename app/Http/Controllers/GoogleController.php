<?php

namespace App\Http\Controllers;

use App\Http\Requests\GoogleImageDetectionRequest;
use App\Http\Requests\GoogleTranslateRequest;
use App\Services\GoogleService\GoogleService;
use ErrorException;
use Google\ApiCore\ApiException;
use Google\ApiCore\ValidationException;
use Illuminate\Http\JsonResponse;


class GoogleController extends Controller
{
    /**
     * @param GoogleService $googleService
     */
    public function __construct(private GoogleService $googleService)
    {
    }

    /**
     * @param GoogleTranslateRequest $request
     * @return JsonResponse
     * @throws ErrorException
     */
    public function translate(GoogleTranslateRequest $request): JsonResponse
    {
        return response()->json($this->googleService->googleTranslate($request->validated()));
    }
}
