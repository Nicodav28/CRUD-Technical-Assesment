<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateEmployeeRequest;
use App\Http\Requests\UpdateEmployeeRequest;
use App\Services\EmployeeService;
use App\Utils\ApiResponser;
use Illuminate\Http\JsonResponse;

class EmployeeController
{
    public function __construct(protected readonly EmployeeService $employeeService)
    {
    }

    public function view()
    {
        return view('employees.index');
    }

    public function index(): JsonResponse
    {
        return $this->employeeService->getAllEmployees();
    }

    public function store(CreateEmployeeRequest $request): JsonResponse
    {
        return $this->employeeService->createEmployee($request->validated());
    }

    public function show(int $id): JsonResponse
    {
        return $this->employeeService->getEmployeeById($id);
    }

    public function update(UpdateEmployeeRequest $request, int $id): JsonResponse
    {
        return $this->employeeService->updateEmployee($id, $request->validated());
    }

    public function destroy(int $id): JsonResponse
    {
        return $this->employeeService->deleteEmployee($id);
    }
}
