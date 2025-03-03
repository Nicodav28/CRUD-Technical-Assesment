<?php

namespace App\Contracts;

use App\Models\Employee;
use Illuminate\Database\Eloquent\Collection;

interface IEmployeeRepository
{
    public function getAll(): Collection;

    public function findById(int $id): ?Employee;

    public function create(array $data): Employee;

    public function update(Employee $employee, array $data): bool;

    public function delete(int $id): bool;
}
