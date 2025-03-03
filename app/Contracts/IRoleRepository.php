<?php

namespace App\Contracts;

use App\Models\Employee;
use Illuminate\Database\Eloquent\Collection;

interface IRoleRepository
{
    public function getAll(): Collection;
}
