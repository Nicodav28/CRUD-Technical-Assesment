<?php

namespace App\Repositories;

use App\Contracts\IRoleRepository;
use App\Models\Role;
use Illuminate\Database\Eloquent\Collection;

class RoleRepository implements IRoleRepository
{
    public function getAll(): Collection
    {
        return Role::all();
    }
}
