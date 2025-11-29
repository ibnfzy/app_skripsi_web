<?php

namespace App\Controllers\Mahasiswa;

use App\Controllers\BaseController;
use App\Services\PengajuanJudulService;

class PengajuanJudul extends BaseController
{
    private PengajuanJudulService $service;

    private array $menuItems = [
        ['label' => 'Dashboard', 'url' => '/Mahasiswa'],
        ['label' => 'Pengajuan Judul', 'url' => '/Mahasiswa/pengajuan-judul'],
        ['label' => 'Bimbingan', 'url' => '#'],
        ['label' => 'Seminar', 'url' => '#'],
        ['label' => 'Revisi', 'url' => '#'],
        ['label' => 'Pengaturan Akun', 'url' => '/Mahasiswa/pengaturan-akun'],
    ];

    public function __construct()
    {
        $this->service = new PengajuanJudulService();
    }

    public function index(): string
    {
        $submissions = $this->service->getSubmissions();

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

        $formattedSubmissions = array_map(static function ($submission) {
            $submission['created_at'] = $submission['created_at'] ?? date('Y-m-d H:i:s');
            $submission['tanggal'] = date('d F Y', strtotime($submission['created_at']));

            return $submission;
        }, $pagedSubmissions);

        $data = [
            'role' => 'Mahasiswa',
            'menu' => $this->menuItems,
            'activeMenu' => 'Pengajuan Judul',
            'submissions' => $formattedSubmissions,
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

            $submissions = $this->service->getSubmissions();
            $newId = empty($submissions) ? 1 : (int) (max(array_column($submissions, 'id')) + 1);

            $this->service->add([
                'id' => $newId,
                'judul' => $this->request->getPost('judul'),
                'bidang' => $this->request->getPost('bidang'),
                'deskripsi' => $this->request->getPost('deskripsi'),
                'status' => 'Menunggu Review',
                'tanggal' => date('d F Y'),
                'created_at' => date('Y-m-d H:i:s'),
                'dosen_pembimbing' => $this->request->getPost('pembimbing'),
                'file_jurnal' => [
                    [
                        'label' => $file->getClientName(),
                        'url' => base_url('uploads/jurnal/' . $fileName),
                    ],
                ],
                'review_notes' => null,
            ]);
            session()->setFlashdata('success', 'Pengajuan judul berhasil dikirim.');

            return redirect()->to('/Mahasiswa/pengajuan-judul');
        }

        return view('panel/mahasiswa/pengajuan_judul/form', $data);
    }
}
