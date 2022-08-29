<?php

namespace App\Services\LinkService;

use DOMNamedNodeMap;
use HttpException;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Http;

class LinkService
{
    public function __construct(private LinkAccessor $linkAccessor)
    {
        //
    }

    public function index(): Collection
    {
        return $this->linkAccessor->index();
    }

    /**
     * @throws HttpException
     */
    public function store(array $validated): Model
    {
        $response = Http::get($validated['url']);
        if ($response->status() != 200) { throw new HttpException('url responded with error'); }

        $title = '';
        $description = '';
        $imageUrl = '';

        $body = $response->body();

        $DOM = new \DOMDocument();
        $DOM->loadHTML($body, LIBXML_NOERROR);

        // Get title
        foreach ($DOM->getElementsByTagName('title') as $item) {
            $title = $item->textContent;
        }

        // Get description and image tags
        foreach ($DOM->getElementsByTagName('meta') as $item) {
            foreach ($item->attributes as $attribute) {
                if (str_contains($attribute->value, 'description')) {
                    $description = $this->extractDataFromDOMAttributes($item->attributes, 'description');
                }
                if (str_contains($attribute->value, 'image')) {
                    $imageUrl = $this->extractDataFromDOMAttributes($item->attributes, 'image');;
                }
            }
        }

        return $this->linkAccessor->store([
            'url' => $validated['url'],
            'title' => $title,
            'description' => $description,
            'image_url' => $imageUrl,
        ]);
    }

    private function extractDataFromDOMAttributes(DOMNamedNodeMap $attributes, string $value): ?string
    {
        foreach ($attributes as $attribute) {
            if (!str_contains($attribute->value, $value)) {
                return $attribute->value;
            }
        }
        return null;
    }
}