<?php

namespace App\Controllers\Mahasiswa;

use App\Controllers\BaseController;

class BasePanel extends BaseController
{
    public function index(): string
    {
        return view('panel/mahasiswa/index');
    }
}

