<?php

namespace App\Controllers\Mahasiswa;

use App\Controllers\BaseController;

class BasePanel extends BaseController
{
    private array $menuItems = [
        ['label' => 'Dashboard', 'url' => '/Mahasiswa'],
        ['label' => 'Pengajuan Judul', 'url' => '#'],
        ['label' => 'Bimbingan', 'url' => '#'],
        ['label' => 'Seminar', 'url' => '#'],
        ['label' => 'Revisi', 'url' => '#'],
        ['label' => 'Pengaturan Akun', 'url' => '/Mahasiswa/pengaturan-akun'],
    ];

    public function index(): string
    {
        $data = [
            'role' => 'Mahasiswa',
            'menu' => $this->menuItems,
            'contentMap' => [
                'Dashboard' => 'Widget status progres skripsi',
                'Pengajuan Judul' => 'Form pengajuan & riwayat pengajuan',
                'Bimbingan' => 'Catatan dosen dan unggah revisi',
                'Seminar' => 'Daftar seminar, pendaftaran, dan jadwal',
                'Revisi' => 'Unggah akhir dan status validasi',
            ],
            'widgets' => [
                [
                    'title' => 'Status Pengajuan Judul',
                    'highlight' => 'Menunggu verifikasi',
                    'description' => 'Pantau status judul terbaru dan catatan pembimbing.',
                ],
                [
                    'title' => 'Progress Bimbingan',
                    'highlight' => '65% rampung',
                    'description' => 'Jumlah sesi yang sudah disetujui dosen pembimbing.',
                ],
                [
                    'title' => 'Jadwal Seminar Terdekat',
                    'highlight' => 'Selasa, 14.00',
                    'description' => 'Cek ruangan, penguji, dan batas unggah berkas.',
                ],
                [
                    'title' => 'Notifikasi Revisi Terbaru',
                    'highlight' => '2 catatan baru',
                    'description' => 'Revisi terakhir dari pembimbing menunggu aksi.',
                ],
            ],
            'sections' => [
                [
                    'title' => 'Ringkasan Skripsi',
                    'description' => 'Lihat komponen utama skripsi yang perlu diselesaikan.',
                    'items' => [
                        'Proposal: direview, menunggu finalisasi.',
                        'Bab 1-3: telah disetujui pembimbing.',
                        'Bab 4-5: revisi minor sebelum unggah lengkap.',
                    ],
                ],
                [
                    'title' => 'Riwayat Bimbingan Terakhir',
                    'description' => 'Catatan pertemuan terbaru dan tugas tindak lanjut.',
                    'items' => [
                        'Pertemuan 12: diskusi hasil uji coba, revisi grafik.',
                        'Tenggat revisi: 3 hari lagi.',
                    ],
                ],
                [
                    'title' => 'Pengumuman Prodi',
                    'description' => 'Informasi dari prodi terkait seminar dan unggah dokumen.',
                    'items' => [
                        'Format laporan terbaru tersedia di portal.',
                        'Batas unggah berkas sidang: 30 Mei.',
                    ],
                ],
            ],
        ];

        return view('panel/mahasiswa/index', $data);
    }

    public function accountSettings(): string
    {
        $data = [
            'role' => 'Mahasiswa',
            'menu' => $this->menuItems,
            'activeMenu' => 'Pengaturan Akun',
            'user' => session()->get('user'),
            'formAction' => '/Mahasiswa/pengaturan-akun',
        ];

        return view('panel/account_settings', $data);
    }
}
