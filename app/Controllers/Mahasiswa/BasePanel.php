<?php

namespace App\Controllers\Mahasiswa;

use App\Controllers\BaseController;

class BasePanel extends BaseController
{
    public function index(): string
    {
        $data = [
            'role' => 'Mahasiswa',
            'menu' => [
                'Dashboard',
                'Pengajuan Judul',
                'Bimbingan',
                'Seminar',
                'Revisi',
            ],
            'contentMap' => [
                'Dashboard' => 'Widget status progres skripsi',
                'Pengajuan Judul' => 'Form pengajuan & riwayat pengajuan',
                'Bimbingan' => 'Catatan dosen dan unggah revisi',
                'Seminar' => 'Daftar seminar, pendaftaran, dan jadwal',
                'Revisi' => 'Unggah akhir dan status validasi',
            ],
        ];

        return view('panel/mahasiswa/index', $data);
    }
}

