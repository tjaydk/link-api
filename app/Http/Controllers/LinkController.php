<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreLinkRequest;
use App\Services\LinkService\LinkService;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\JsonResponse;

class LinkController extends Controller
{
    /**
     * @param LinkService $linkService
     */
    public function __construct(private LinkService $linkService)
    {
        //
    }

    /**
     * @return Collection
     */
    public function publicIndex(): Collection
    {
        return $this->linkService->index();
    }

    /**
     * @return Collection
     */
    public function index(): Collection
    {
        return $this->linkService->index();
    }

    /**
     * @param StoreLinkRequest $request
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function store(StoreLinkRequest $request)
    {
        return $this->linkService->store($request->validated());
    }

    /**
     * @param int $linkId
     * @return JsonResponse
     */
    public function destroy(int $linkId): JsonResponse
    {
        $this->linkService->destroy($linkId);

        return response()->json('OK');
    }
}
