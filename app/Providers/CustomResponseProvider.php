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
    private $out;

    public function jsonResponse($is_success, $message, $param)
    {
        header('Content-type: application/json');
        $this->out = array(
            'success' => $is_success,
            'message' => $message,
            'data' => json_decode($param) == null ? $param : json_decode($param)
        );

        return json_encode($this->out);
    }
}
