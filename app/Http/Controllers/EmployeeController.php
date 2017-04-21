<?php

namespace App\Http\Controllers;

use App\Employee;
use App\Providers\CustomResponseProvider;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;

class EmployeeController extends Controller
{
    /**
     * Get one employee by ID
     * @param CustomResponseProvider $res
     * @param $id
     * @return string
     */
    public function getOne(CustomResponseProvider $res, $id)
    {
        try {
            $employee = Employee::findOrFail($id);
            Log::info('Returned employe with ID: ' . $id);
            return $res->jsonResponse(true, "Returned one employee", $employee);
        } catch (ModelNotFoundException $e) {
            http_response_code(404);
            Log::error('Missing employe with ID: ' . $id);
            die($res->jsonResponse(false, "There was an error while trying to retrieve the employee", $e->getMessage()));
        }
    }

    /**
     * @param CustomResponseProvider $res
     * @return string
     */
    public function getAll(CustomResponseProvider $res)
    {
        $employees = Employee::all();
        Log::info('Returned all employees');
        return $res->jsonResponse(true, "Returned " . count($employees) . " employees", $employees);
    }

    /**
     * @param CustomResponseProvider $res
     * @param Request $request
     * @return \Illuminate\Contracts\Support\MessageBag|string
     */
    public function create(CustomResponseProvider $res, Request $request)
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
            return $res->jsonResponse(true, "Created new employee", $request->all());
        } catch (ValidationException $e) {
            Log::warning('Failed to create new employee with this error: ' . $e->validator->getMessageBag());
            return $res->jsonResponse(false, "There was an error while trying to create new employee", $e->getResponse()->getContent());
        }
    }

    /**
     * @param CustomResponseProvider $res
     * @param $id
     * @return string
     */
    public function delete(CustomResponseProvider $res, $id)
    {
        try {
            $employee = Employee::findOrFail($id);
            $employee->delete();
            Log::info('Employee with ID: ' . $id . ' has been deleted');
            return $res->jsonResponse(true, "Deleted employee", $employee);
        } catch (ModelNotFoundException $e) {
            http_response_code(404);
            Log::error('Employee with ID: ' . $id . ' not found');
            die($res->jsonResponse(false, "There was an error while trying to delete employee", $e->getMessage()));
        }
    }

    /**
     * @param CustomResponseProvider $res
     * @param $id
     * @param Request $request
     * @return string
     */
    public function update(CustomResponseProvider $res, $id, Request $request)
    {
        try {
            $employee = Employee::findOrFail($id);

            $this->validate($request, [
                'name' => 'required|unique:employees',
                'age' => 'required',
                'jmbg' => 'required|digits:5|unique:employees',
                'isActive' => 'required'
            ]);

            $newInfo = $request->all();
            $employee->fill($newInfo)->save();
            Log::info('Employee with ID: ' . $id . ' has been updated');
            return $res->jsonResponse(true, "Employee successfully updated", $employee);
        } catch (ModelNotFoundException $e) {
            http_response_code(404);
            Log::error('Employee with ID: ' . $id . ' not found');
            die($res->jsonResponse(false, "There was an error while trying to update employee", $e->getMessage()));
        } catch (ValidationException $e) {
            Log::warning('Failed to update employee with this error: ' . $e->validator->getMessageBag());
            return $res->jsonResponse(false, "There was an error while trying to update employee", $e->getResponse()->getContent());
        }
    }
}
