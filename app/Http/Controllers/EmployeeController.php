<?php

namespace App\Http\Controllers;

use App\Employee;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;

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
            Log::info('Returned employe with ID: ' . $id);
            return $employee;
        } catch (ModelNotFoundException $e) {
            Log::error('Missing employe with ID: ' . $id);
            return $e->getMessage();
        }
    }

    /**
     * Get all employees
     */
    public function getAll()
    {
        $employees = Employee::all();
        Log::info('Returned all employees');
        foreach ($employees as $employee) {
            echo "<p> $employee </p>";
        }
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\Support\MessageBag|string
     */
    public function create(Request $request)
    {
        try {
            $this->validate($request, [
                'name' => 'required|unique:employees',
                'age' => 'required',
                'jmbg' => 'required|digits:5|unique:employees',
                'isActive' => 'required'
            ]);
            Employee::create($request->all());
            Log::info('Created new employee');
            return "Employee '{$request['name']}' has been created successfully";
        } catch (ValidationException $e) {
            Log::warning('Failed to create new employee with this error: ' . $e->validator->getMessageBag());
            return $e->validator->getMessageBag();
        }
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
            Log::info('Employee with ID: ' . $id . ' has been deleted');
            return "{$employee['name']} - successfully deleted";
        } catch (ModelNotFoundException $e) {
            Log::error('Employee with ID: ' . $id . ' not found');
            return $e->getMessage();
        }
    }

    /**
     * @param $id
     * @param Request $request
     * @return \Illuminate\Contracts\Support\MessageBag|string
     */
    public function update($id, Request $request)
    {
        try {
            $this->validate($request, [
                'name' => 'required|unique:employees',
                'age' => 'required',
                'jmbg' => 'required|digits:5|unique:employees',
                'isActive' => 'required'
            ]);
        } catch (ValidationException $e) {
            Log::warning('Failed to update employee with this error: ' . $e->validator->getMessageBag());
            return $e->validator->getMessageBag();
        }
        try {
            $employee = Employee::findOrFail($id);
            $newInfo = $request->all();
            $employee->fill($newInfo)->save();
            Log::info('Employee with ID: ' . $id . ' has been updated');
            return "Employee '{$request['name']}' has been edited successfully";
        } catch (ModelNotFoundException $e) {
            Log::error('Employee with ID: ' . $id . ' not found');
            return $e->getMessage();
        }
    }
}
