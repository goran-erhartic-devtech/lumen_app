<?php
/**
 * Created by PhpStorm.
 * User: goran.erhartic
 * Date: 5/4/2017
 * Time: 2:53 PM
 */

namespace App\Http\Controllers;


use App\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function createUser(Request $request)
    {
        $user = User::create($request->all());
        return response()->json($user);
    }

    /**
     * Get all users
     */
    public function getAll()
    {
        $users = User::all();

        foreach ($users as $user) {
            echo "<p> $user </p>";
        }
    }
}