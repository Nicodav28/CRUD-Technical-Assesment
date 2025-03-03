<?php

namespace App\Http\Controllers;

use App\Models\Area;
use App\Services\AreaService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class AreaController
{
    public function __construct(protected readonly AreaService $areaService)
    {
    }

    public function index(): JsonResponse
    {
        return $this->areaService->getAllAreas();
    }
}
