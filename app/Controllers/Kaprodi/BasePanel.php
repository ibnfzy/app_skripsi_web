<?php

namespace App\Controllers\Kaprodi;

use App\Controllers\BaseController;

class BasePanel extends BaseController
{
    public function index(): string
    {
        $data = [
            'role' => 'Kaprodi',
            'menu' => [
                'Dashboard',
                'Persetujuan Judul',
                'Monitoring Bimbingan',
            ],
            'contentMap' => [
                'Dashboard' => 'Data ringkas capaian program studi',
                'Persetujuan Judul' => 'Daftar pengajuan judul untuk disetujui',
                'Monitoring Bimbingan' => 'Grafik dan tabel progres bimbingan',
            ],
        ];

        return view('panel/kaprodi/index', $data);
    }
}

