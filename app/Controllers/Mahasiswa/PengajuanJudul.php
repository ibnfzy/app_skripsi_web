<?php

namespace App\Controllers\Mahasiswa;

use App\Controllers\BaseController;

class PengajuanJudul extends BaseController
{
    private array $menuItems = [
        ['label' => 'Dashboard', 'url' => '/Mahasiswa'],
        ['label' => 'Pengajuan Judul', 'url' => '/Mahasiswa/pengajuan-judul'],
        ['label' => 'Bimbingan', 'url' => '#'],
        ['label' => 'Seminar', 'url' => '#'],
        ['label' => 'Revisi', 'url' => '#'],
        ['label' => 'Pengaturan Akun', 'url' => '/Mahasiswa/pengaturan-akun'],
    ];

    public function index(): string
    {
        $submissions = $this->getSubmissions();

        $search = trim($this->request->getGet('search') ?? '');
        $statusFilter = $this->request->getGet('status') ?? '';
        $page = max(1, (int) ($this->request->getGet('page') ?? 1));
        $perPage = 10;

        $filtered = array_filter($submissions, static function ($item) use ($search, $statusFilter): bool {
            $matchesSearch = true;
            $matchesStatus = true;

            if ($search !== '') {
                $matchesSearch = str_contains(strtolower($item['judul']), strtolower($search))
                    || str_contains(strtolower($item['bidang']), strtolower($search))
                    || str_contains(strtolower($item['dosen_pembimbing']), strtolower($search));
            }

            if ($statusFilter !== '') {
                $matchesStatus = strtolower($item['status']) === strtolower($statusFilter);
            }

            return $matchesSearch && $matchesStatus;
        });

        $total = count($filtered);
        $totalPages = max(1, (int) ceil($total / $perPage));
        $page = min($page, $totalPages);
        $offset = ($page - 1) * $perPage;
        $pagedSubmissions = array_slice(array_values($filtered), $offset, $perPage);

        $data = [
            'role' => 'Mahasiswa',
            'menu' => $this->menuItems,
            'activeMenu' => 'Pengajuan Judul',
            'submissions' => $pagedSubmissions,
            'search' => $search,
            'statusFilter' => $statusFilter,
            'pagination' => [
                'current' => $page,
                'totalPages' => $totalPages,
                'totalItems' => $total,
                'perPage' => $perPage,
            ],
            'statusOptions' => ['Menunggu Review', 'Disetujui', 'Perlu Revisi', 'Ditolak'],
            'flash' => session()->getFlashdata('success') ?? null,
        ];

        return view('panel/mahasiswa/pengajuan_judul/index', $data);
    }

    public function create()
    {
        helper(['form']);

        $data = [
            'role' => 'Mahasiswa',
            'menu' => $this->menuItems,
            'activeMenu' => 'Pengajuan Judul',
            'validation' => null,
        ];

        if ($this->request->getMethod() === 'post') {
            $validationRules = [
                'judul' => 'required|min_length[6]',
                'bidang' => 'required',
                'deskripsi' => 'required|min_length[10]',
                'pembimbing' => 'required',
                'jurnal' => 'uploaded[jurnal]|mime_in[jurnal,application/pdf]|ext_in[jurnal,pdf]',
            ];

            if (! $this->validate($validationRules)) {
                $data['validation'] = $this->validator;
                return view('panel/mahasiswa/pengajuan_judul/form', $data);
            }

            $uploadDirectory = rtrim(FCPATH, '/\\') . '/uploads/jurnal';
            if (! is_dir($uploadDirectory)) {
                mkdir($uploadDirectory, 0775, true);
            }

            $file = $this->request->getFile('jurnal');
            $fileName = $file->getRandomName();
            $file->move($uploadDirectory, $fileName);

            $submissions = $this->getSubmissions();
            $newId = empty($submissions) ? 1 : (int) (max(array_column($submissions, 'id')) + 1);

            $submissions[] = [
                'id' => $newId,
                'judul' => $this->request->getPost('judul'),
                'bidang' => $this->request->getPost('bidang'),
                'deskripsi' => $this->request->getPost('deskripsi'),
                'status' => 'Menunggu Review',
                'tanggal' => date('d F Y'),
                'dosen_pembimbing' => $this->request->getPost('pembimbing'),
                'file_jurnal' => [
                    [
                        'label' => $file->getClientName(),
                        'url' => base_url('uploads/jurnal/' . $fileName),
                    ],
                ],
            ];

            $this->saveSubmissions($submissions);
            session()->setFlashdata('success', 'Pengajuan judul berhasil dikirim.');

            return redirect()->to('/Mahasiswa/pengajuan-judul');
        }

        return view('panel/mahasiswa/pengajuan_judul/form', $data);
    }

    private function getSubmissions(): array
    {
        $session = session();
        $submissions = $session->get('submissions_mahasiswa');

        if ($submissions === null) {
            $submissions = $this->defaultSubmissions();
            $session->set('submissions_mahasiswa', $submissions);
        }

        return $submissions;
    }

    private function saveSubmissions(array $submissions): void
    {
        session()->set('submissions_mahasiswa', $submissions);
    }

    private function defaultSubmissions(): array
    {
        return [
            [
                'id' => 1,
                'judul' => 'Analisis Sentimen Ulasan Produk Menggunakan LSTM',
                'bidang' => 'Kecerdasan Buatan',
                'deskripsi' => 'Membangun model LSTM untuk mengklasifikasi sentimen ulasan produk e-commerce.',
                'status' => 'Menunggu Review',
                'tanggal' => '01 Mei 2024',
                'dosen_pembimbing' => 'Dr. Sri Mulyani',
                'file_jurnal' => [
                    ['label' => 'Dataset & Metodologi.pdf', 'url' => 'https://example.com/jurnal1.pdf'],
                ],
            ],
            [
                'id' => 2,
                'judul' => 'Sistem Rekomendasi Buku Berbasis Konten dan Collaborative Filtering',
                'bidang' => 'Data Mining',
                'deskripsi' => 'Menggabungkan metode konten dan collaborative filtering untuk rekomendasi buku.',
                'status' => 'Disetujui',
                'tanggal' => '12 April 2024',
                'dosen_pembimbing' => 'Prof. Budi Santoso',
                'file_jurnal' => [
                    ['label' => 'Referensi Rekomendasi.pdf', 'url' => 'https://example.com/jurnal2.pdf'],
                ],
            ],
            [
                'id' => 3,
                'judul' => 'Implementasi Sistem Absensi Menggunakan Face Recognition',
                'bidang' => 'Computer Vision',
                'deskripsi' => 'Mengembangkan sistem absensi otomatis menggunakan pengenalan wajah.',
                'status' => 'Perlu Revisi',
                'tanggal' => '25 Maret 2024',
                'dosen_pembimbing' => 'Dr. Rina Dewi',
                'file_jurnal' => [
                    ['label' => 'Face Recognition Study.pdf', 'url' => 'https://example.com/jurnal3.pdf'],
                ],
            ],
            [
                'id' => 4,
                'judul' => 'Pengembangan Aplikasi Manajemen Tugas Menggunakan Flutter',
                'bidang' => 'Mobile Development',
                'deskripsi' => 'Membangun aplikasi manajemen tugas lintas platform dengan Flutter.',
                'status' => 'Ditolak',
                'tanggal' => '17 Maret 2024',
                'dosen_pembimbing' => 'Ir. Anwar Putra',
                'file_jurnal' => [
                    ['label' => 'Flutter Productivity.pdf', 'url' => 'https://example.com/jurnal4.pdf'],
                ],
            ],
            [
                'id' => 5,
                'judul' => 'Optimasi Jaringan Pipa Gas Menggunakan Algoritma Genetika',
                'bidang' => 'Optimasi',
                'deskripsi' => 'Optimasi distribusi pipa gas untuk efisiensi energi.',
                'status' => 'Menunggu Review',
                'tanggal' => '10 Maret 2024',
                'dosen_pembimbing' => 'Dr. Siti Aminah',
                'file_jurnal' => [
                    ['label' => 'Genetic Algorithm Case Study.pdf', 'url' => 'https://example.com/jurnal5.pdf'],
                ],
            ],
            [
                'id' => 6,
                'judul' => 'Perancangan Sistem Informasi Keuangan Sekolah Berbasis Web',
                'bidang' => 'Sistem Informasi',
                'deskripsi' => 'Sistem untuk mengelola transaksi keuangan sekolah secara transparan.',
                'status' => 'Disetujui',
                'tanggal' => '02 Maret 2024',
                'dosen_pembimbing' => 'Ir. Bagus Prabowo',
                'file_jurnal' => [
                    ['label' => 'Web Finance System.pdf', 'url' => 'https://example.com/jurnal6.pdf'],
                ],
            ],
            [
                'id' => 7,
                'judul' => 'Deteksi Dini Penyakit Tanaman Menggunakan CNN',
                'bidang' => 'Deep Learning',
                'deskripsi' => 'Model convolutional neural network untuk deteksi penyakit tanaman.',
                'status' => 'Perlu Revisi',
                'tanggal' => '20 Februari 2024',
                'dosen_pembimbing' => 'Prof. Yuniar Hadi',
                'file_jurnal' => [
                    ['label' => 'Plant Disease Detection.pdf', 'url' => 'https://example.com/jurnal7.pdf'],
                ],
            ],
            [
                'id' => 8,
                'judul' => 'Pengembangan Chatbot Layanan Akademik Berbasis NLP',
                'bidang' => 'Natural Language Processing',
                'deskripsi' => 'Chatbot untuk menjawab pertanyaan akademik mahasiswa.',
                'status' => 'Menunggu Review',
                'tanggal' => '11 Februari 2024',
                'dosen_pembimbing' => 'Dr. Widodo Hartono',
                'file_jurnal' => [
                    ['label' => 'Academic Chatbot.pdf', 'url' => 'https://example.com/jurnal8.pdf'],
                ],
            ],
            [
                'id' => 9,
                'judul' => 'Sistem Prediksi Harga Komoditas Menggunakan ARIMA',
                'bidang' => 'Data Science',
                'deskripsi' => 'Prediksi harga komoditas pertanian dengan model ARIMA.',
                'status' => 'Disetujui',
                'tanggal' => '05 Februari 2024',
                'dosen_pembimbing' => 'Ir. Suryo Wibowo',
                'file_jurnal' => [
                    ['label' => 'Commodity Forecast.pdf', 'url' => 'https://example.com/jurnal9.pdf'],
                ],
            ],
            [
                'id' => 10,
                'judul' => 'Evaluasi Keamanan Aplikasi Web Menggunakan OWASP ZAP',
                'bidang' => 'Keamanan Informasi',
                'deskripsi' => 'Analisis kerentanan aplikasi web menggunakan OWASP ZAP.',
                'status' => 'Ditolak',
                'tanggal' => '22 Januari 2024',
                'dosen_pembimbing' => 'Dr. Eko Saputra',
                'file_jurnal' => [
                    ['label' => 'Web Security Testing.pdf', 'url' => 'https://example.com/jurnal10.pdf'],
                ],
            ],
            [
                'id' => 11,
                'judul' => 'Pengaruh Gamifikasi pada Aplikasi Edukasi Matematika',
                'bidang' => 'Human Computer Interaction',
                'deskripsi' => 'Studi efek gamifikasi pada motivasi belajar matematika.',
                'status' => 'Menunggu Review',
                'tanggal' => '15 Januari 2024',
                'dosen_pembimbing' => 'Dr. Dedi Gunawan',
                'file_jurnal' => [
                    ['label' => 'Gamification Study.pdf', 'url' => 'https://example.com/jurnal11.pdf'],
                ],
            ],
            [
                'id' => 12,
                'judul' => 'Rancang Bangun Sistem Monitoring IoT untuk Kualitas Udara',
                'bidang' => 'Internet of Things',
                'deskripsi' => 'Monitoring kualitas udara realtime menggunakan sensor IoT.',
                'status' => 'Perlu Revisi',
                'tanggal' => '07 Januari 2024',
                'dosen_pembimbing' => 'Ir. Ratna Sari',
                'file_jurnal' => [
                    ['label' => 'IoT Air Quality.pdf', 'url' => 'https://example.com/jurnal12.pdf'],
                ],
            ],
        ];
    }
}
