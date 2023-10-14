<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;

    public function sendJson($data, $status, $code = 200)
    {
        $data['status'] = $status;
        $data['message'] = $data && isset($data['message']) ? $data['message'] : ($status ? 'Success' : 'Something went wrong!');
        return response($data, $code);
    }
}
