<?php

namespace App\Controllers\Dekan;

use App\Controllers\BaseController;

class BasePanel extends BaseController
{
    private array $menuItems = [
        ['label' => 'Dashboard', 'url' => '/Dekan'],
        ['label' => 'Persetujuan Judul', 'url' => '#'],
        ['label' => 'Monitoring Skripsi', 'url' => '#'],
        ['label' => 'Pengaturan Akun', 'url' => '/Dekan/pengaturan-akun'],
    ];

    public function index(): string
    {
        $data = [
            'role' => 'Dekan',
            'menu' => $this->menuItems,
            'activeMenu' => 'Dashboard',
            'contentMap' => [
                'Dashboard' => 'Statistik ringkas fakultas',
                'Persetujuan Judul' => 'Pengajuan yang menunggu validasi dekanat',
                'Monitoring Skripsi' => 'Progres bimbingan lintas program studi',
            ],
            'widgets' => [
                [
                    'title' => 'Pengajuan Menunggu Persetujuan',
                    'highlight' => '24 berkas',
                    'description' => 'Berkas skripsi yang menunggu keputusan dekan.',
                ],
                [
                    'title' => 'Persetujuan Bulan Ini',
                    'highlight' => '18 disetujui',
                    'description' => 'Total berkas yang sudah divalidasi dekanat.',
                ],
                [
                    'title' => 'Tingkat Kelulusan',
                    'highlight' => '92% terselesaikan',
                    'description' => 'Rata-rata kelulusan skripsi dari seluruh prodi.',
                ],
                [
                    'title' => 'Agenda Seminar',
                    'highlight' => '12 jadwal aktif',
                    'description' => 'Daftar seminar proposal dan hasil se-fakultas.',
                ],
            ],
            'sections' => [
                [
                    'title' => 'Prioritas Validasi',
                    'description' => 'Berkas yang membutuhkan keputusan segera.',
                    'items' => [
                        '7 pengajuan dengan catatan revisi minor.',
                        '3 pengajuan menunggu rekomendasi kaprodi.',
                    ],
                ],
                [
                    'title' => 'Ringkasan Fakultas',
                    'description' => 'Capaian akademik lintas program studi.',
                    'items' => [
                        'Rata-rata waktu penyelesaian skripsi: 5,6 bulan.',
                        'Sebaran penguji sudah terdistribusi merata.',
                    ],
                ],
                [
                    'title' => 'Pengumuman Dekanat',
                    'description' => 'Informasi strategis untuk kaprodi dan sekretaris jurusan.',
                    'items' => [
                        'Pembaharuan SOP validasi mulai bulan depan.',
                        'Koordinasi penjadwalan ujian akhir semester.',
                    ],
                ],
            ],
        ];

        return view('panel/dekan/index', $data);
    }

    public function accountSettings(): string
    {
        $data = [
            'role' => 'Dekan',
            'menu' => $this->menuItems,
            'activeMenu' => 'Pengaturan Akun',
            'user' => session()->get('user'),
            'formAction' => '/Dekan/pengaturan-akun',
        ];

        return view('panel/account_settings', $data);
    }
}
