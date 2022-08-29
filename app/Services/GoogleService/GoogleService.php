<?php

namespace App\Services\GoogleService;

use App\Models\User;
use ErrorException;
use Google\ApiCore\ApiException;
use Google\ApiCore\ValidationException;
use Google\Cloud\Vision\V1\AnnotateImageResponse;
use Stichoza\GoogleTranslate\GoogleTranslate;
use Google\Cloud\Vision\V1\Feature\Type;
use Google\Cloud\Vision\V1\ImageAnnotatorClient;

class GoogleService
{
    /**
     * Translate a string from one language to another through Google Translate API.
     * Text is the string to translate.
     * Target is the target language to translate to.
     * Source is hint of which language to translate from.
     *
     * @param array $validated
     * @return string|null
     * @throws ErrorException
     */
    public function googleTranslate(array $validated): ?string
    {
        return GoogleTranslate::trans($validated['text'], $validated['target'], $validated['source']);
    }
}
