<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

class Error extends BaseController
{
    public function noAccess()
    {
        return view('error/403');
    }

    public function notFound()
    {
        return view('error/404');
    }
}
