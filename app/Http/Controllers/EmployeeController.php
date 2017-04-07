<?php

namespace App\Http\Controllers;

use App\Employee;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EmployeeController extends Controller
{
    /**
     * Get one employee by ID
     * @param $id
     * @return mixed
     */
    public function getOne($id)
    {
        try {
            $employee = Employee::findOrFail($id);
            return $employee;
        } catch (ModelNotFoundException $e) {
            return $e->getMessage();
        }
    }

    /**
     * Get all employees
     */
    public function getAll()
    {
        $employees = Employee::all();

        foreach ($employees as $employee) {
            echo "<p> $employee </p>";
        }
    }

    /**
     * @param Request $request
     * @return string
     */
    public function create(Request $request)
    {

        $this->validate($request, [
            'name' => 'required|unique:employees',
            'age' => 'required',
            'jmbg' => 'required|digits:5|unique:employees',
            'isActive' => 'required'
        ]);

        Employee::create($request->all());
        return "Employee '{$request['name']}' has been created successfully";
    }

    /**
     * @param $id
     * @return string
     */
    public function delete($id)
    {
        try {
            $employee = Employee::findOrFail($id);
            $employee->delete();
            return "{$employee['name']} - successfully deleted";
        } catch (ModelNotFoundException $e) {
            return $e->getMessage();
        }
    }

    public function update($id, Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'age' => 'required',
            'isActive' => 'required'
        ]);

        try {
            $employee = Employee::findOrFail($id);
            $newInfo = $request->all();
            $employee->fill($newInfo)->save();
            return "Employee '{$request['name']}' has been edited successfully";
        } catch (ModelNotFoundException $e) {
            return $e->getMessage();
        }
    }
}
