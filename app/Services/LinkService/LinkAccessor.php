<?php

namespace App\Services\LinkService;

use App\Models\Link;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

class LinkAccessor
{
    /**
     * @return Collection
     */
    public function index(): Collection
    {
        return Link::all();
    }

    /**
     * @param array $validated
     * @return Model
     */
    public function store(array $validated): Model
    {
        return Link::create($validated);
    }

    /**
     * @param int $linkId
     */
    public function destroy(int $linkId): void
    {
        Link::find($linkId)->delete();
    }
}
