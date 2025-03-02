<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateEmployeeRequest;
use App\Http\Requests\UpdateEmployeeRequest;
use App\Models\Employee;
use Illuminate\Http\Request;

class EmployeeController
{
    public function index()
    {
        $employees = Employee::all();
        return view('employees.index', compact('employees'));
    }

    public function store(CreateEmployeeRequest $request)
    {
        $employee = Employee::create($request->all());
        return response()->json([ 'message' => 'Empleado agregado', 'employee' => $employee ]);
    }

    public function edit(int $id)
    {
        $employee = Employee::findOrFail($id);
        return response()->json($employee);
    }

    public function update(UpdateEmployeeRequest $request, int $id)
    {
        $employee = Employee::findOrFail($id);
        $employee->update($request->all());
        return response()->json([ 'message' => 'Empleado actualizado', 'employee' => $employee ]);
    }

    public function destroy(int $id)
    {
        Employee::destroy($id);
        return response()->json([ 'message' => 'Empleado eliminado' ]);
    }

    public function search(Request $request)
    {
        $search = $request->search;

        $employees = Employee::where('name', 'like', "%$search%")
            ->orWhere('email', 'like', "%$search%")
            ->get();

        return view('employee', compact('employees'));
    }


}
