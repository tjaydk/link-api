<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreLinkRequest;
use App\Models\Link;
use App\Services\LinkService\LinkService;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class LinkController extends Controller
{
    public function __construct(private LinkService $linkService)
    {
        //
    }

    public function publicIndex(): Collection
    {
        return $this->linkService->index();
    }

    public function index(): Collection
    {
        return $this->linkService->index();
    }

    public function store(StoreLinkRequest $request)
    {
        return $this->linkService->store($request->validated());
    }

    public function destroy(int $linkId): JsonResponse
    {
        $this->linkService->destroy($linkId);

        return response()->json('OK');
    }
}
