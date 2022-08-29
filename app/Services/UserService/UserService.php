<?php

namespace App\Services\UserService;

use Illuminate\Database\Eloquent\Model;

class UserService
{
    /**
     * @param UserAccessor $accessor
     */
    public function __construct(private UserAccessor $accessor)
    {
    }

    /**
     * @param array $validated
     * @return Model
     */
    public function store(array $validated): Model
    {
        return $this->accessor->store($validated);
    }
}
