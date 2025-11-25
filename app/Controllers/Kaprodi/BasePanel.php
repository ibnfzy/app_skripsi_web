<?php

namespace App\Controllers\Kaprodi;

use App\Controllers\BaseController;

class BasePanel extends BaseController
{
    public function index(): string
    {
        return view('panel/kaprodi/index');
    }
}

