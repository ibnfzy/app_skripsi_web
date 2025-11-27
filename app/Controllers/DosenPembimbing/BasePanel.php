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
            'widgets' => [
                [
                    'title' => 'Jumlah Mahasiswa Bimbingan',
                    'highlight' => '12 aktif',
                    'description' => 'Total mahasiswa yang sedang dibimbing semester ini.',
                ],
                [
                    'title' => 'Jadwal Seminar Hari Ini',
                    'highlight' => '2 sesi',
                    'description' => 'Pantau jadwal sidang mahasiswa bimbingan hari ini.',
                ],
                [
                    'title' => 'Tugas Verifikasi Bimbingan',
                    'highlight' => '3 menunggu',
                    'description' => 'Catatan bimbingan yang perlu disetujui atau dikoreksi.',
                ],
            ],
            'sections' => [
                [
                    'title' => 'Daftar Mahasiswa Aktif',
                    'description' => 'Mahasiswa bimbingan yang perlu pendampingan.',
                    'items' => [
                        '5 mahasiswa pada tahap penulisan hasil.',
                        '4 mahasiswa menyiapkan seminar proposal.',
                        '3 mahasiswa menunggu revisi tugas akhir.',
                    ],
                ],
                [
                    'title' => 'Catatan Bimbingan Terbaru',
                    'description' => 'Ringkasan interaksi terbaru dengan mahasiswa.',
                    'items' => [
                        'Periksa hasil uji coba dan lampiran bukti eksperimen.',
                        'Tekankan konsistensi format sitasi dan daftar pustaka.',
                    ],
                ],
                [
                    'title' => 'Agenda Dosen',
                    'description' => 'Kegiatan pribadi dan institusional terkait bimbingan.',
                    'items' => [
                        'Rapat prodi: koordinasi evaluasi skripsi Jumat.',
                        'Penilaian seminar proposal pada dua mahasiswa.',
                    ],
                ],
            ],
        ];

        return view('panel/dosen_pembimbing/index', $data);
    }
}
