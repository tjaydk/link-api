<?php

namespace App\Services\LinkService;

use App\Models\Link;
use DOMDocument;
use DOMNamedNodeMap;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Http;
use Symfony\Component\HttpKernel\Exception\HttpException;

class LinkService
{
    /**
     * @param LinkAccessor $linkAccessor
     */
    public function __construct(private LinkAccessor $linkAccessor)
    {
        //
    }

    /**
     * @return Collection
     */
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
        if ($response->status() != 200) { throw new HttpException(404,'no response from url'); }

        $title = '';
        $description = '';
        $imageUrl = '';

        $body = $response->body();

        $DOM = new DOMDocument();
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
                    $imageUrl = $this->extractDataFromDOMAttributes($item->attributes, 'image', true);
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

    /**
     * @param DOMNamedNodeMap $attributes
     * @param string $value
     * @param bool $validUrl
     * @return string|null
     */
    private function extractDataFromDOMAttributes(DOMNamedNodeMap $attributes, string $value, bool $validUrl = false): ?string
    {
        foreach ($attributes as $attribute) {
            if (!str_contains($attribute->value, $value)) {
                if (!$validUrl) {
                    return $attribute->value;
                } else if ($this->validateUrl($attribute->value)) {
                    return $attribute->value;
                }
            }
        }
        return null;
    }

    /**
     * @param string $url
     * @return mixed
     */
    private function validateUrl(string $url)
    {
        return filter_var($url, FILTER_VALIDATE_URL);
    }

    /**
     * @param int $linkId
     */
    public function destroy(int $linkId)
    {
        $this->linkAccessor->destroy($linkId);
    }
}
