<?php

namespace App\Repositories;

use App\Contracts\IAreaRepository;
use App\Models\Area;
use App\Models\Employee;
use Illuminate\Database\Eloquent\Collection;

class AreaRepository implements IAreaRepository
{
    public function getAll(): Collection
    {
        return Area::all();
    }
}
