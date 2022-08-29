<?php

namespace App\Services\LinkService;

use App\Models\Link;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

class LinkAccessor
{
    public function index(): Collection
    {
        return Link::all();
    }

    public function store(array $validated): Model
    {
        return Link::create($validated);
    }

    public function destroy(int $linkId): void
    {
        Link::find($linkId)->delete();
    }
}
