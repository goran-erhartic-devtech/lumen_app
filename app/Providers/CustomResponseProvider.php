<?php
/**
 * Created by PhpStorm.
 * User: goran.erhartic
 * Date: 13/4/2017
 * Time: 2:05 PM
 */

namespace App\Providers;

class CustomResponseProvider
{
    function jsonGetResponse($param)
    {
        header('Content-type: application/json');
        $out = array(
            'success' => true,
            'message' => "There are " . count($param) . " employees",
            'data' => $param
        );

        return json_encode($out);
    }

    function jsonPostResponse($param)
    {
        header('Content-type: application/json');
        $out = array(
            'success' => true,
            'message' => "New user has been created",
            'data' => $param
        );

        return json_encode($out);
    }

    function jsonDeleteResponse($param)
    {
        header('Content-type: application/json');
        $out = array(
            'success' => true,
            'message' => "User has been deleted",
            'data' => $param
        );

        return json_encode($out);
    }

    function jsonPutResponse($param)
    {
        header('Content-type: application/json');
        $out = array(
            'success' => true,
            'message' => "User has been updated",
            'data' => $param
        );

        return json_encode($out);
    }
}
