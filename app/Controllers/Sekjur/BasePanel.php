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
}
