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
            'widgets' => [
                [
                    'title' => 'Jumlah Pengajuan Masuk',
                    'highlight' => '18 berkas',
                    'description' => 'Pengajuan judul yang menunggu penilaian.',
                ],
                [
                    'title' => 'Jumlah Pengajuan Disetujui',
                    'highlight' => '12 disetujui',
                    'description' => 'Total pengajuan yang sudah divalidasi kaprodi.',
                ],
                [
                    'title' => 'Monitoring Progres Skripsi',
                    'highlight' => '76% rata-rata',
                    'description' => 'Capaian rata-rata progres bimbingan mahasiswa.',
                ],
                [
                    'title' => 'Jadwal Seminar Minggu Ini',
                    'highlight' => '5 jadwal',
                    'description' => 'Rencana seminar proposal dan hasil pekan ini.',
                ],
            ],
            'sections' => [
                [
                    'title' => 'Daftar Pengajuan Menunggu Validasi',
                    'description' => 'Prioritaskan pengajuan yang memerlukan keputusan.',
                    'items' => [
                        '6 judul menunggu verifikasi kelayakan.',
                        '2 judul perlu revisi abstrak sebelum disetujui.',
                    ],
                ],
                [
                    'title' => 'Statistik Kemajuan Mahasiswa',
                    'description' => 'Gambaran tingkat progres mahasiswa per angkatan.',
                    'items' => [
                        'Angkatan 2020: 80% sudah seminar hasil.',
                        'Angkatan 2021: 60% pada tahap bimbingan intensif.',
                    ],
                ],
                [
                    'title' => 'Pengumuman Program Studi',
                    'description' => 'Informasi strategis bagi dosen dan mahasiswa.',
                    'items' => [
                        'Evaluasi kurikulum skripsi bulan depan.',
                        'Standar rubrik penilaian diperbarui.',
                    ],
                ],
            ],
        ];

        return view('panel/kaprodi/index', $data);
    }
}
