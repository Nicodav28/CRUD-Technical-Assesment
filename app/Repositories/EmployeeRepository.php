<?php

namespace App\Repositories;

use App\Contracts\IEmployeeRepository;
use App\Models\Employee;
use Illuminate\Database\Eloquent\Collection;

class EmployeeRepository implements IEmployeeRepository
{
    public function getAll(): Collection
    {
        return Employee::with('area', 'roles')->orderBy('id')->get();
    }

    public function findById(int $id): ?Employee
    {
        return Employee::with('area', 'roles')->find($id);
    }

    public function create(array $data): Employee
    {
        return Employee::create($data);
    }

    public function update(Employee $employee, array $data): bool
    {
        return $employee->update($data);
    }

    public function delete(int $id): bool
    {
        return Employee::destroy($id);
    }
}
