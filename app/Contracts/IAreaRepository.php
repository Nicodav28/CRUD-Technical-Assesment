<?php

namespace App\Contracts;

use App\Models\Employee;
use Illuminate\Database\Eloquent\Collection;

interface IAreaRepository
{
    public function getAll(): Collection;
}
