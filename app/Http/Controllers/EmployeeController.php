<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Employee;

class EmployeeController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:employees,email',
            'address' => 'required|string|max:255',
            'phone' => 'required|string|max:15',
        ]);

        Employee::create([
            'name' => $request->name,
            'email' => $request->email,
            'address' => $request->address,
            'phone' => $request->phone,
        ]);

        return response()->json([
            'status' => 200,
            'message' => 'Employee added successfully',
        ]);
    }

    public function getall()
    {
        $employees = Employee::all();
        return response()->json([
            'status' => 200,
            'employees' => $employees,
        ]);
    }

    public function edit($id)
    {
        $employee = Employee::find($id);

        if ($employee) {
            return response()->json([
                'status' => 200,
                'employee' => $employee,
            ]);
        }

        return response()->json([
            'status' => 404,
            'message' => 'Employee not found',
        ]);
    }

    public function update(Request $request)
    {
        $request->validate([
            'id' => 'required|exists:employees,id',
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:employees,email,'.$request->id,
            'address' => 'required|string|max:255',
            'phone' => 'required|string|max:15',
        ]);

        $employee = Employee::find($request->id);
        $employee->update([
            'name' => $request->name,
            'email' => $request->email,
            'address' => $request->address,
            'phone' => $request->phone,
        ]);

        return response()->json([
            'status' => 200,
            'message' => 'Employee updated successfully',
        ]);
    }

    public function delete(Request $request)
    {
        $request->validate([
            'id' => 'required|exists:employees,id',
        ]);

        $employee = Employee::find($request->id);

        if ($employee) {
            $employee->delete();
            return response()->json([
                'status' => 200,
                'message' => 'Employee deleted successfully.',
            ]);
        }

        return response()->json([
            'status' => 400,
            'message' => 'Failed to delete employee.',
        ]);
    }
}
