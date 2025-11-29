<?php

namespace App\Controllers\Kaprodi;

use App\Controllers\BaseController;
use App\Services\PengajuanJudulService;

class PengajuanJudul extends BaseController
{
    private PengajuanJudulService $service;

    private array $menuItems = [
        ['label' => 'Dashboard', 'url' => '/Kaprodi'],
        ['label' => 'Persetujuan Judul', 'url' => '/Kaprodi/pengajuan-judul'],
        ['label' => 'Monitoring Bimbingan', 'url' => '#'],
        ['label' => 'Pengaturan Akun', 'url' => '/Kaprodi/pengaturan-akun'],
    ];

    public function __construct()
    {
        $this->service = new PengajuanJudulService();
    }

    public function index(): string
    {
        $search = trim($this->request->getGet('search') ?? '');
        $statusFilter = $this->request->getGet('status') ?? '';
        $sort = strtolower($this->request->getGet('sort') ?? 'desc');

        $submissions = $this->service->getSubmissions();

        $filtered = array_filter($submissions, static function ($submission) use ($search, $statusFilter): bool {
            $matchesSearch = true;
            $matchesStatus = true;

            if ($search !== '') {
                $matchesSearch = str_contains(strtolower($submission['judul']), strtolower($search))
                    || str_contains(strtolower($submission['bidang']), strtolower($search))
                    || str_contains(strtolower($submission['dosen_pembimbing']), strtolower($search));
            }

            if ($statusFilter !== '') {
                $matchesStatus = strtolower($submission['status']) === strtolower($statusFilter);
            }

            return $matchesSearch && $matchesStatus;
        });

        usort($filtered, static function ($a, $b) use ($sort) {
            $direction = $sort === 'asc' ? 1 : -1;
            return $direction * (strtotime($a['created_at']) <=> strtotime($b['created_at']));
        });

        $data = [
            'role' => 'Kaprodi',
            'menu' => $this->menuItems,
            'activeMenu' => 'Persetujuan Judul',
            'submissions' => $filtered,
            'search' => $search,
            'statusFilter' => $statusFilter,
            'sort' => $sort,
            'statusOptions' => ['Menunggu Review', 'Disetujui', 'Perlu Revisi', 'Ditolak'],
            'basePath' => '/Kaprodi/pengajuan-judul',
            'flash' => session()->getFlashdata('success') ?? null,
            'error' => session()->getFlashdata('error') ?? null,
        ];

        return view('panel/pengajuan_judul/review_index', $data);
    }

    public function show(int $id)
    {
        $submission = $this->service->find($id);

        if ($submission === null) {
            session()->setFlashdata('error', 'Pengajuan tidak ditemukan.');
            return redirect()->to('/Kaprodi/pengajuan-judul');
        }

        $data = [
            'role' => 'Kaprodi',
            'menu' => $this->menuItems,
            'activeMenu' => 'Persetujuan Judul',
            'submission' => $submission,
            'statusOptions' => ['Menunggu Review', 'Disetujui', 'Perlu Revisi', 'Ditolak'],
            'formAction' => "/Kaprodi/pengajuan-judul/{$id}/review",
            'basePath' => '/Kaprodi/pengajuan-judul',
            'flash' => session()->getFlashdata('success') ?? null,
            'error' => session()->getFlashdata('error') ?? null,
        ];

        return view('panel/pengajuan_judul/review_detail', $data);
    }

    public function review(int $id)
    {
        if ($this->request->getMethod() !== 'post') {
            return redirect()->to("/Kaprodi/pengajuan-judul/{$id}");
        }

        $status = $this->request->getPost('status');
        $review = trim($this->request->getPost('review') ?? '');

        if ($status === null || $status === '') {
            session()->setFlashdata('error', 'Status pengajuan wajib dipilih.');
            return redirect()->to("/Kaprodi/pengajuan-judul/{$id}");
        }

        $updated = $this->service->update($id, [
            'status' => $status,
            'review_notes' => $review !== '' ? $review : null,
        ]);

        if ($updated === null) {
            session()->setFlashdata('error', 'Pengajuan tidak ditemukan.');
            return redirect()->to('/Kaprodi/pengajuan-judul');
        }

        session()->setFlashdata('success', 'Review pengajuan berhasil disimpan.');

        return redirect()->to("/Kaprodi/pengajuan-judul/{$id}");
    }
}
