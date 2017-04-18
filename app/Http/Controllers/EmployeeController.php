<?php

namespace App\Http\Controllers;

use App\Employee;
use App\Providers\CustomResponseProvider;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
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
            return $res->jsonResponse(true, "Returned one employee", $employee);
        } catch (ModelNotFoundException $e) {
            http_response_code(404);
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
        return $res->jsonResponse(true, "Returned " . count($employees) . " employees", $employees);
    }

    /**
     * @param CustomResponseProvider $res
     * @param Request $request
     * @return string
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
            return $res->jsonResponse(true, "Created new employee", $request->all());
        } catch (ValidationException $e) {
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
            return $res->jsonResponse(true, "Deleted employee", $employee);
        } catch (ModelNotFoundException $e) {
            http_response_code(404);
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
            return $res->jsonResponse(true, "Employee successfully updated", $employee);
        } catch (ModelNotFoundException $e) {
            http_response_code(404);
            die($res->jsonResponse(false, "There was an error while trying to update employee", $e->getMessage()));
        } catch (ValidationException $e) {
            return $res->jsonResponse(false, "There was an error while trying to update employee", $e->getResponse()->getContent());

        }
    }
}
