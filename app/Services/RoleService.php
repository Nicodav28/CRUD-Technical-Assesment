<?php

namespace App\Services;

use App\Contracts\IRoleRepository;
use App\Utils\ApiResponser;
use Illuminate\Http\JsonResponse;

class RoleService
{
    public function __construct(protected readonly IRoleRepository $roleRepository)
    {
    }

    public function getAllAreas(): JsonResponse
    {
        $areas = $this->roleRepository->getAll();

        if ($areas->isEmpty()) {
            return ApiResponser::error('No se encontraron areas', 404);
        }

        return ApiResponser::success($areas);

    }
}
