<?php

namespace App\Services;

use App\Contracts\IAreaRepository;
use App\Utils\ApiResponser;
use Illuminate\Http\JsonResponse;

class AreaService
{
    public function __construct(protected readonly IAreaRepository $areaRepository)
    {
    }

    public function getAllAreas(): JsonResponse
    {
        $areas = $this->areaRepository->getAll();

        if ($areas->isEmpty()) {
            return ApiResponser::error('No se encontraron areas', 404);
        }

        return ApiResponser::success($areas);

    }
}
