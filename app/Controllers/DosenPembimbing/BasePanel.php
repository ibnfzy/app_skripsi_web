<?php

namespace App\Controllers\DosenPembimbing;

use App\Controllers\BaseController;

class BasePanel extends BaseController
{
    public function index(): string
    {
        return view('panel/dosen_pembimbing/index');
    }
}

