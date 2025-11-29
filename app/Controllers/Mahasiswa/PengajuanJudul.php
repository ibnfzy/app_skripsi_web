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

        $approvedSubmissions = array_values(array_filter(
            $submissions,
            static fn ($item): bool => strtolower($item['status']) === 'disetujui'
        ));

        $selectedTitleId = null;

        foreach ($approvedSubmissions as $approved) {
            if ((int) ($approved['judul_pilihan'] ?? 0) !== 0) {
                $selectedTitleId = (int) $approved['id'];
                break;
            }
        }

        $needsSelection = count($approvedSubmissions) > 1;
        $allRejected = ! empty($submissions)
            && count(array_filter($submissions, static fn ($item): bool => strtolower($item['status']) !== 'ditolak')) === 0;

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
            'approvedSubmissions' => $approvedSubmissions,
            'search' => $search,
            'statusFilter' => $statusFilter,
            'selectedTitleId' => $selectedTitleId,
            'needsSelection' => $needsSelection,
            'allRejected' => $allRejected,
            'pagination' => [
                'current' => $page,
                'totalPages' => $totalPages,
                'totalItems' => $total,
                'perPage' => $perPage,
            ],
            'statusOptions' => ['Menunggu Review', 'Disetujui', 'Perlu Revisi', 'Ditolak'],
            'flash' => session()->getFlashdata('success') ?? null,
            'errorFlash' => session()->getFlashdata('error') ?? null,
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
                'judul_pilihan' => 0,
                'review_notes' => null,
            ]);
            session()->setFlashdata('success', 'Pengajuan judul berhasil dikirim.');

            return redirect()->to('/Mahasiswa/pengajuan-judul');
        }

        return view('panel/mahasiswa/pengajuan_judul/form', $data);
    }

    public function pilih()
    {
        $selectedId = (int) ($this->request->getPost('judul_id') ?? 0);

        if ($selectedId === 0) {
            session()->setFlashdata('error', 'Pilih salah satu judul yang sudah disetujui.');
            return redirect()->back()->withInput();
        }

        $isSelected = $this->service->selectApprovedTitle($selectedId);

        session()->setFlashdata(
            $isSelected ? 'success' : 'error',
            $isSelected
                ? 'Judul skripsi berhasil dipilih dan disimpan.'
                : 'Pilihan judul tidak valid atau belum disetujui.'
        );

        return redirect()->to('/Mahasiswa/pengajuan-judul');
    }
}
