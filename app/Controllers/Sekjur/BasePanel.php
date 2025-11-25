<?php

namespace App\Controllers\Sekjur;

use App\Controllers\BaseController;

class BasePanel extends BaseController
{
    public function index(): string
    {
        $data = [
            'role' => 'Sekjur',
            'menu' => [
                'Dashboard',
                'Validasi Pengajuan',
                'Pendaftaran Seminar',
                'Penjadwalan Seminar',
            ],
            'contentMap' => [
                'Dashboard' => 'Statistik singkat jurusan',
                'Validasi Pengajuan' => 'List pengecekan dan validasi judul',
                'Pendaftaran Seminar' => 'Daftar mahasiswa untuk seminar',
                'Penjadwalan Seminar' => 'Form penjadwalan seminar',
            ],
        ];

        return view('panel/sekjur/index', $data);
    }
}

