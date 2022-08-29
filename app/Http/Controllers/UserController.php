<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateUserRequest;
use App\Services\UserService\UserService;
use Illuminate\Database\Eloquent\Model;

class UserController extends Controller
{
    /**
     * @param UserService $service
     */
    public function __construct(private UserService $service)
    {
    }

    /**
     * @param CreateUserRequest $request
     * @return Model
     */
    public function store(CreateUserRequest $request): Model
    {
        return $this->service->store($request->validated());
    }
}
