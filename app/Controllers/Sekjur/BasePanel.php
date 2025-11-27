<?php

namespace App\Controllers\Sekjur;

use App\Controllers\BaseController;

class BasePanel extends BaseController
{
    private array $menuItems = [
        ['label' => 'Dashboard', 'url' => '/Sekjur'],
        ['label' => 'Validasi Pengajuan', 'url' => '#'],
        ['label' => 'Pendaftaran Seminar', 'url' => '#'],
        ['label' => 'Penjadwalan Seminar', 'url' => '#'],
        ['label' => 'Kelola User', 'url' => '/Sekjur/users'],
    ];

    public function index(): string
    {
        $data = [
            'role' => 'Sekjur',
            'menu' => $this->menuItems,
            'activeMenu' => 'Dashboard',
            'contentMap' => [
                'Dashboard' => 'Statistik singkat jurusan',
                'Validasi Pengajuan' => 'List pengecekan dan validasi judul',
                'Pendaftaran Seminar' => 'Daftar mahasiswa untuk seminar',
                'Penjadwalan Seminar' => 'Form penjadwalan seminar',
            ],
            'widgets' => [
                [
                    'title' => 'Jumlah Berkas Seminar Masuk',
                    'highlight' => '9 berkas',
                    'description' => 'Berkas seminar yang baru diunggah mahasiswa.',
                ],
                [
                    'title' => 'Jadwal Seminar Aktif',
                    'highlight' => '7 jadwal',
                    'description' => 'Sesi seminar yang sudah terpublikasi minggu ini.',
                ],
                [
                    'title' => 'Status Penjadwalan',
                    'highlight' => '3 menunggu ruang',
                    'description' => 'Pengajuan seminar yang menunggu alokasi ruang/penguji.',
                ],
            ],
            'sections' => [
                [
                    'title' => 'Daftar Pengajuan Seminar',
                    'description' => 'Kelola pengajuan seminar proposal maupun hasil.',
                    'items' => [
                        'Validasi kelengkapan dokumen dan persyaratan.',
                        'Pastikan berita acara dan lembar bimbingan terlampir.',
                    ],
                ],
                [
                    'title' => 'Rekapan Jadwal',
                    'description' => 'Tinjau jadwal lintas ruang dan penguji.',
                    'items' => [
                        'Senin-Rabu: jadwal penuh, cek ketersediaan ruangan.',
                        'Kamis-Jumat: slot penguji masih tersedia.',
                    ],
                ],
                [
                    'title' => 'Pengelolaan Administrasi',
                    'description' => 'Koordinasi administrasi dengan prodi dan dosen.',
                    'items' => [
                        'Kirim undangan seminar otomatis ke penguji.',
                        'Upload berita acara setelah seminar selesai.',
                    ],
                ],
            ],
        ];

        return view('panel/sekjur/index', $data);
    }

    public function users(): string
    {
        $data = [
            'role' => 'Sekjur',
            'menu' => $this->menuItems,
            'activeMenu' => 'Kelola User',
            'roleOptions' => [
                ['value' => 'mahasiswa', 'label' => 'Mahasiswa'],
                ['value' => 'dosen', 'label' => 'Dosen Pembimbing'],
                ['value' => 'kaprodi', 'label' => 'Ketua Program Studi'],
                ['value' => 'sekjur', 'label' => 'Sekretaris Jurusan'],
            ],
        ];

        return view('panel/sekjur/users', $data);
    }
}
