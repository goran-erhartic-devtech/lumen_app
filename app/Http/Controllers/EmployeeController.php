<?php

namespace App\Http\Controllers;

use App\Employee;
use App\Providers\CustomResponseProvider;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;

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
            return $res->jsonGetResponse($employee);
        } catch (ModelNotFoundException $e) {
            return $e->getMessage();
        }
    }

    /**
     * @param CustomResponseProvider $res
     * @return string
     */
    public function getAll(CustomResponseProvider $res)
    {
        $employees = Employee::all();
        return $res->jsonGetResponse($employees);
    }

    /**
     * @param CustomResponseProvider $res
     * @param Request $request
     * @return string
     */
    public function create(CustomResponseProvider $res, Request $request)
    {

        $this->validate($request, [
            'name' => 'required|unique:employees',
            'age' => 'required',
            'jmbg' => 'required|digits:5|unique:employees',
            'isActive' => 'required'
        ]);

        Employee::create($request->all());
        return $res->jsonPostResponse($request->all());
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
            return $res->jsonDeleteResponse($employee);
        } catch (ModelNotFoundException $e) {
            return $e->getMessage();
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
        $this->validate($request, [
            'name' => 'required',
            'age' => 'required',
            'isActive' => 'required'
        ]);

        try {
            $employee = Employee::findOrFail($id);
            $newInfo = $request->all();
            $employee->fill($newInfo)->save();
            return $res->jsonPutResponse($employee);
        } catch (ModelNotFoundException $e) {
            return $e->getMessage();
        }
    }
}
