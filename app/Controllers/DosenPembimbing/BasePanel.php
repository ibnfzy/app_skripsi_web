<?php

namespace App\Controllers\DosenPembimbing;

use App\Controllers\BaseController;

class BasePanel extends BaseController
{
    public function index(): string
    {
        $data = [
            'role' => 'Dosen Pembimbing',
            'menu' => [
                'Dashboard',
                'Daftar Mahasiswa Bimbingan',
                'Catatan Bimbingan',
                'Jadwal Seminar',
            ],
            'contentMap' => [
                'Dashboard' => 'Ringkasan aktivitas bimbingan',
                'Daftar Mahasiswa Bimbingan' => 'List mahasiswa yang dibimbing',
                'Catatan Bimbingan' => 'Editor dan timeline bimbingan',
                'Jadwal Seminar' => 'List jadwal seminar mahasiswa',
            ],
        ];

        return view('panel/dosen_pembimbing/index', $data);
    }
}

