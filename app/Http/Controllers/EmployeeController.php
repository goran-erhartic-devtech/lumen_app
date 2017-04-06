<?php

namespace App\Http\Controllers;

use App\User;

class EmployeeController extends Controller
{
//    /**
//     * Create a new controller instance.
//     *
//     * @return void
//     */
//    public function __construct()
//    {
//        //
//    }
//
//    //
    public function getOne($id)
    {
        return app('db')->select("SELECT * FROM employees where id = $id");
    }
}
