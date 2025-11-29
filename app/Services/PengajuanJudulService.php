<?php

namespace App\Services;

class PengajuanJudulService
{
    private string $sessionKey = 'pengajuan_judul_data';

    public function getSubmissions(): array
    {
        $session = session();
        $submissions = $session->get($this->sessionKey);

        if ($submissions === null) {
            $submissions = $this->defaultSubmissions();
            $session->set($this->sessionKey, $submissions);
        }

        $normalized = $this->normalizeSelections($submissions);

        if ($normalized !== $submissions) {
            $session->set($this->sessionKey, $normalized);
        }

        return $normalized;
    }

    public function find(int $id): ?array
    {
        foreach ($this->getSubmissions() as $submission) {
            if ((int) $submission['id'] === $id) {
                return $submission;
            }
        }

        return null;
    }

    public function add(array $submission): void
    {
        $submissions = $this->getSubmissions();
        $submission['judul_pilihan'] = $submission['judul_pilihan'] ?? 0;
        $submissions[] = $submission;
        session()->set($this->sessionKey, $submissions);
    }

    public function update(int $id, array $payload): ?array
    {
        $submissions = $this->getSubmissions();

        foreach ($submissions as &$submission) {
            if ((int) $submission['id'] === $id) {
                $submission = array_merge($submission, $payload);
                session()->set($this->sessionKey, $submissions);
                return $submission;
            }
        }

        return null;
    }

    public function selectApprovedTitle(int $id): bool
    {
        $submissions = $this->getSubmissions();
        $hasValidSelection = false;

        foreach ($submissions as $submission) {
            if ((int) $submission['id'] === $id && strtolower($submission['status']) === 'disetujui') {
                $hasValidSelection = true;
                break;
            }
        }

        if (! $hasValidSelection) {
            return false;
        }

        foreach ($submissions as &$submission) {
            $submission['judul_pilihan'] = (int) ((int) $submission['id'] === $id ? 1 : 0);
        }

        session()->set($this->sessionKey, $submissions);

        return true;
    }

    private function normalizeSelections(array $submissions): array
    {
        $submissions = array_map(static function ($item) {
            $item['judul_pilihan'] = $item['judul_pilihan'] ?? 0;
            return $item;
        }, $submissions);

        $submissions = $this->enforceSingleChoice($submissions);
        $submissions = $this->autoSelectWhenSingleApproved($submissions);

        return $submissions;
    }

    private function enforceSingleChoice(array $submissions): array
    {
        $chosen = array_values(array_filter($submissions, static fn ($item): bool => (int) ($item['judul_pilihan'] ?? 0) !== 0));

        if (count($chosen) <= 1) {
            return $submissions;
        }

        usort($chosen, static function ($a, $b) {
            return strtotime($a['created_at'] ?? '') <=> strtotime($b['created_at'] ?? '');
        });

        $keepId = (int) ($chosen[0]['id'] ?? 0);

        foreach ($submissions as &$submission) {
            $submission['judul_pilihan'] = (int) ((int) $submission['id'] === $keepId ? 1 : 0);
        }

        return $submissions;
    }

    private function autoSelectWhenSingleApproved(array $submissions): array
    {
        $approved = array_values(array_filter($submissions, static fn ($item): bool => strtolower($item['status']) === 'disetujui'));

        if (count($approved) !== 1) {
            return $submissions;
        }

        $approvedId = (int) ($approved[0]['id'] ?? 0);

        foreach ($submissions as &$submission) {
            $submission['judul_pilihan'] = (int) ((int) $submission['id'] === $approvedId ? 1 : 0);
        }

        return $submissions;
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
                'dosen_pembimbing' => 'Dr. Sri Mulyani',
                'created_at' => '2024-05-01 09:00:00',
                'judul_pilihan' => 0,
                'file_jurnal' => [
                    ['label' => 'Dataset & Metodologi.pdf', 'url' => 'https://example.com/jurnal1.pdf'],
                ],
                'review_notes' => null,
            ],
            [
                'id' => 2,
                'judul' => 'Sistem Rekomendasi Buku Berbasis Konten dan Collaborative Filtering',
                'bidang' => 'Data Mining',
                'deskripsi' => 'Menggabungkan metode konten dan collaborative filtering untuk rekomendasi buku.',
                'status' => 'Disetujui',
                'dosen_pembimbing' => 'Prof. Budi Santoso',
                'created_at' => '2024-04-12 14:30:00',
                'judul_pilihan' => 1,
                'file_jurnal' => [
                    ['label' => 'Referensi Rekomendasi.pdf', 'url' => 'https://example.com/jurnal2.pdf'],
                ],
                'review_notes' => 'Layak disetujui, metodologi jelas.',
            ],
            [
                'id' => 3,
                'judul' => 'Implementasi Sistem Absensi Menggunakan Face Recognition',
                'bidang' => 'Computer Vision',
                'deskripsi' => 'Mengembangkan sistem absensi otomatis menggunakan pengenalan wajah.',
                'status' => 'Perlu Revisi',
                'dosen_pembimbing' => 'Dr. Rina Dewi',
                'created_at' => '2024-03-25 10:15:00',
                'judul_pilihan' => 0,
                'file_jurnal' => [
                    ['label' => 'Face Recognition Study.pdf', 'url' => 'https://example.com/jurnal3.pdf'],
                ],
                'review_notes' => 'Perlu penjelasan terkait dataset dan etika privasi.',
            ],
            [
                'id' => 4,
                'judul' => 'Pengembangan Aplikasi Manajemen Tugas Menggunakan Flutter',
                'bidang' => 'Mobile Development',
                'deskripsi' => 'Membangun aplikasi manajemen tugas lintas platform dengan Flutter.',
                'status' => 'Ditolak',
                'dosen_pembimbing' => 'Ir. Anwar Putra',
                'created_at' => '2024-03-17 16:45:00',
                'judul_pilihan' => 0,
                'file_jurnal' => [
                    ['label' => 'Flutter Productivity.pdf', 'url' => 'https://example.com/jurnal4.pdf'],
                ],
                'review_notes' => 'Topik tidak sesuai fokus riset program studi.',
            ],
            [
                'id' => 5,
                'judul' => 'Optimasi Jaringan Pipa Gas Menggunakan Algoritma Genetika',
                'bidang' => 'Optimasi',
                'deskripsi' => 'Optimasi distribusi pipa gas untuk efisiensi energi.',
                'status' => 'Menunggu Review',
                'dosen_pembimbing' => 'Dr. Siti Aminah',
                'created_at' => '2024-03-10 11:20:00',
                'judul_pilihan' => 0,
                'file_jurnal' => [
                    ['label' => 'Genetic Algorithm Case Study.pdf', 'url' => 'https://example.com/jurnal5.pdf'],
                ],
                'review_notes' => null,
            ],
            [
                'id' => 6,
                'judul' => 'Perancangan Sistem Informasi Keuangan Sekolah Berbasis Web',
                'bidang' => 'Sistem Informasi',
                'deskripsi' => 'Sistem untuk mengelola transaksi keuangan sekolah secara transparan.',
                'status' => 'Disetujui',
                'dosen_pembimbing' => 'Ir. Bagus Prabowo',
                'created_at' => '2024-03-02 08:10:00',
                'judul_pilihan' => 1,
                'file_jurnal' => [
                    ['label' => 'Web Finance System.pdf', 'url' => 'https://example.com/jurnal6.pdf'],
                ],
                'review_notes' => 'Setuju, pastikan keamanan data diperkuat.',
            ],
            [
                'id' => 7,
                'judul' => 'Deteksi Dini Penyakit Tanaman Menggunakan CNN',
                'bidang' => 'Deep Learning',
                'deskripsi' => 'Model convolutional neural network untuk deteksi penyakit tanaman.',
                'status' => 'Perlu Revisi',
                'dosen_pembimbing' => 'Prof. Yuniar Hadi',
                'created_at' => '2024-02-20 15:05:00',
                'judul_pilihan' => 0,
                'file_jurnal' => [
                    ['label' => 'Plant Disease Detection.pdf', 'url' => 'https://example.com/jurnal7.pdf'],
                ],
                'review_notes' => 'Tambahkan rencana validasi lapangan.',
            ],
            [
                'id' => 8,
                'judul' => 'Pengembangan Chatbot Layanan Akademik Berbasis NLP',
                'bidang' => 'Natural Language Processing',
                'deskripsi' => 'Chatbot untuk menjawab pertanyaan akademik mahasiswa.',
                'status' => 'Menunggu Review',
                'dosen_pembimbing' => 'Dr. Widodo Hartono',
                'created_at' => '2024-02-11 13:30:00',
                'judul_pilihan' => 0,
                'file_jurnal' => [
                    ['label' => 'Academic Chatbot.pdf', 'url' => 'https://example.com/jurnal8.pdf'],
                ],
                'review_notes' => null,
            ],
            [
                'id' => 9,
                'judul' => 'Sistem Prediksi Harga Komoditas Menggunakan ARIMA',
                'bidang' => 'Data Science',
                'deskripsi' => 'Prediksi harga komoditas pertanian dengan model ARIMA.',
                'status' => 'Disetujui',
                'dosen_pembimbing' => 'Ir. Suryo Wibowo',
                'created_at' => '2024-02-05 09:50:00',
                'judul_pilihan' => 0,
                'file_jurnal' => [
                    ['label' => 'Commodity Forecast.pdf', 'url' => 'https://example.com/jurnal9.pdf'],
                ],
                'review_notes' => 'Siapkan data historis minimal 5 tahun.',
            ],
            [
                'id' => 10,
                'judul' => 'Evaluasi Keamanan Aplikasi Web Menggunakan OWASP ZAP',
                'bidang' => 'Keamanan Informasi',
                'deskripsi' => 'Analisis kerentanan aplikasi web menggunakan OWASP ZAP.',
                'status' => 'Ditolak',
                'dosen_pembimbing' => 'Dr. Eko Saputra',
                'created_at' => '2024-01-22 10:40:00',
                'judul_pilihan' => 0,
                'file_jurnal' => [
                    ['label' => 'Web Security Testing.pdf', 'url' => 'https://example.com/jurnal10.pdf'],
                ],
                'review_notes' => 'Topik serupa telah dikerjakan tahun lalu.',
            ],
            [
                'id' => 11,
                'judul' => 'Pengaruh Gamifikasi pada Aplikasi Edukasi Matematika',
                'bidang' => 'Human Computer Interaction',
                'deskripsi' => 'Studi efek gamifikasi pada motivasi belajar matematika.',
                'status' => 'Menunggu Review',
                'dosen_pembimbing' => 'Dr. Dedi Gunawan',
                'created_at' => '2024-01-15 08:55:00',
                'judul_pilihan' => 0,
                'file_jurnal' => [
                    ['label' => 'Gamification Study.pdf', 'url' => 'https://example.com/jurnal11.pdf'],
                ],
                'review_notes' => null,
            ],
            [
                'id' => 12,
                'judul' => 'Rancang Bangun Sistem Monitoring IoT untuk Kualitas Udara',
                'bidang' => 'Internet of Things',
                'deskripsi' => 'Monitoring kualitas udara realtime menggunakan sensor IoT.',
                'status' => 'Perlu Revisi',
                'dosen_pembimbing' => 'Ir. Ratna Sari',
                'created_at' => '2024-01-07 12:15:00',
                'judul_pilihan' => 0,
                'file_jurnal' => [
                    ['label' => 'IoT Air Quality.pdf', 'url' => 'https://example.com/jurnal12.pdf'],
                ],
                'review_notes' => 'Pertimbangkan integrasi dashboard real-time.',
            ],
        ];
    }
}
