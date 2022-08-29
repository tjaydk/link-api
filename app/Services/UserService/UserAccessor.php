<?php

namespace App\Services\UserService;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;

class UserAccessor
{
    /**
     * @param array $validated
     * @return Model
     */
    public function store(array $validated): Model
    {
        return User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => bcrypt($validated['password']),
        ]);
    }
}
