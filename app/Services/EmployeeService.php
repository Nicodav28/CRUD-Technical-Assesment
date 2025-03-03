<?php

namespace App\Services;

use App\Contracts\IEmployeeRepository;
use App\Utils\ApiResponser;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;

class EmployeeService
{

    public function __construct(protected readonly IEmployeeRepository $employeeRepository)
    {
    }

    public function getAllEmployees(): JsonResponse
    {
        $employees = $this->employeeRepository->getAll();

        if ($employees->isEmpty()) {
            return ApiResponser::error('No se encontraron empleados', 404);
        }

        return ApiResponser::success($employees);

    }

    public function getEmployeeById(int $id): JsonResponse
    {
        $employee = $this->employeeRepository->findById($id);

        if (!$employee) {
            return ApiResponser::error('Empleado no encontrado', 404);
        }

        return ApiResponser::success($employee);
    }

    public function createEmployee(array $data): JsonResponse
    {
        DB::beginTransaction();
        try {
            $roles = $data['roles'] ?? [];
            unset($data['roles']);

            $employee = $this->employeeRepository->create($data);

            if (!empty($roles)) {
                $employee->roles()->attach($roles);
            }

            DB::commit();
            return ApiResponser::success([]);
        } catch (\Throwable $th) {
            DB::rollBack();
            return ApiResponser::error('Error al crear empleado', 500);
        }
    }

    public function updateEmployee(int $id, array $data)
    {
        DB::beginTransaction();

        try {
            $employee = $this->employeeRepository->findById($id);

            if (!$employee) {
                return ApiResponser::error('Empleado no encontrado', 404);
            }

            $roles = $data['roles'] ?? [];
            unset($data['roles']);

            $this->employeeRepository->update($employee, $data);
            $employee->roles()->sync($roles);

            DB::commit();
            return ApiResponser::success([]);
        } catch (\Throwable $th) {
            DB::rollBack();
            return ApiResponser::error('Error al actualizar empleado', 500);
        }
    }

    public function deleteEmployee(int $id)
    {
        $deleted = $this->employeeRepository->delete($id);

        if (!$deleted) {
            return ApiResponser::error('Error al eliminar empleado', 422);
        }

        return ApiResponser::success([]);
    }
}
