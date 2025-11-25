<?php

namespace App\Controllers\Sekjur;

use App\Controllers\BaseController;

class BasePanel extends BaseController
{
    public function index(): string
    {
        return view('panel/sekjur/index');
    }
}

