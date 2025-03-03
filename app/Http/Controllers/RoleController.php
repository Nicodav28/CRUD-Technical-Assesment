<?php

namespace App\Http\Controllers;

use App\Services\RoleService;
use Illuminate\Http\JsonResponse;

class RoleController
{
    public function __construct(protected readonly RoleService $roleService)
    {
    }

    public function index(): JsonResponse
    {
        return $this->roleService->getAllAreas();
    }
}
