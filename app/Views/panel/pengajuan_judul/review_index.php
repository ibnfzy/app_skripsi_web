<?= $this->extend('panel/base_layout'); ?>

<?= $this->section('content'); ?>
<div class="space-y-8">
  <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-3">
    <div>
      <p class="text-sm text-slate-500">Pantau dan nilai pengajuan judul mahasiswa</p>
      <h2 class="text-3xl font-semibold text-[var(--abu-gelap)]">Review Pengajuan Judul</h2>
    </div>
  </div>

  <?php if (! empty($flash)): ?>
    <div class="p-4 rounded-xl bg-green-50 border border-green-200 text-green-800 text-sm"><?= esc($flash); ?></div>
  <?php endif; ?>

  <?php if (! empty($error)): ?>
    <div class="p-4 rounded-xl bg-rose-50 border border-rose-200 text-rose-800 text-sm"><?= esc($error); ?></div>
  <?php endif; ?>

  <div class="p-6 bg-white rounded-2xl shadow-sm border border-slate-100 space-y-6">
    <div class="flex flex-col md:flex-row md:items-end gap-4">
      <form id="filterForm" action="" method="get" class="flex-1 grid md:grid-cols-3 gap-3">
        <div class="md:col-span-2">
          <label class="block text-sm text-slate-600 mb-2">Pencarian</label>
          <div class="relative">
            <input type="text" name="search" placeholder="Cari judul, bidang, atau pembimbing" value="<?= esc($search); ?>"
              class="w-full rounded-xl border border-slate-200 px-4 py-3 text-sm focus:ring-2 focus:ring-[var(--biru-medium)] focus:outline-none" />
            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-slate-400 absolute right-3 top-3" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
              <circle cx="11" cy="11" r="8" />
              <path d="m21 21-4.35-4.35" />
            </svg>
          </div>
        </div>
        <div>
          <label class="block text-sm text-slate-600 mb-2">Status</label>
          <select name="status" class="w-full rounded-xl border border-slate-200 px-4 py-3 text-sm focus:ring-2 focus:ring-[var(--biru-medium)] focus:outline-none">
            <option value="">Semua Status</option>
            <?php foreach ($statusOptions as $option): ?>
              <option value="<?= esc($option); ?>" <?= $statusFilter === $option ? 'selected' : ''; ?>><?= esc($option); ?></option>
            <?php endforeach; ?>
          </select>
        </div>
        <div>
          <label class="block text-sm text-slate-600 mb-2">Urutkan</label>
          <select name="sort" class="w-full rounded-xl border border-slate-200 px-4 py-3 text-sm focus:ring-2 focus:ring-[var(--biru-medium)] focus:outline-none">
            <option value="desc" <?= $sort === 'desc' ? 'selected' : ''; ?>>Terbaru</option>
            <option value="asc" <?= $sort === 'asc' ? 'selected' : ''; ?>>Terlama</option>
          </select>
        </div>
      </form>
      <div class="flex gap-3">
        <button type="submit" form="filterForm" class="px-4 py-3 rounded-xl bg-[var(--biru-medium)] hover:bg-[var(--biru-tua)] text-white text-sm font-semibold transition">Terapkan</button>
        <a href="<?= esc($basePath); ?>" class="px-4 py-3 rounded-xl border border-slate-200 text-sm text-[var(--abu-gelap)] bg-slate-50 hover:bg-slate-100 transition">Reset</a>
      </div>
    </div>

    <div class="overflow-x-auto">
      <table class="min-w-full border border-slate-200 rounded-lg overflow-hidden text-sm">
        <thead class="bg-slate-50 text-slate-600">
          <tr>
            <th class="px-4 py-3 text-left border-b border-slate-200">Judul</th>
            <th class="px-4 py-3 text-left border-b border-slate-200">Bidang</th>
            <th class="px-4 py-3 text-left border-b border-slate-200">Pembimbing</th>
            <th class="px-4 py-3 text-left border-b border-slate-200">Status</th>
            <th class="px-4 py-3 text-left border-b border-slate-200">Created At</th>
            <th class="px-4 py-3 text-left border-b border-slate-200">Aksi</th>
          </tr>
        </thead>
        <tbody>
          <?php if (empty($submissions)): ?>
            <tr>
              <td colspan="6" class="px-4 py-6 text-center text-slate-500">Tidak ada pengajuan ditemukan.</td>
            </tr>
          <?php endif; ?>
          <?php foreach ($submissions as $submission): ?>
            <?php
              $badgeColors = [
                'Menunggu Review' => 'bg-amber-100 text-amber-700',
                'Disetujui' => 'bg-green-100 text-green-700',
                'Perlu Revisi' => 'bg-sky-100 text-sky-700',
                'Ditolak' => 'bg-rose-100 text-rose-700',
              ];
              $statusColor = $badgeColors[$submission['status']] ?? 'bg-slate-100 text-slate-700';
            ?>
            <tr class="border-b border-slate-200">
              <td class="px-4 py-3 align-top">
                <div class="font-semibold text-[var(--abu-gelap)]"><?= esc($submission['judul']); ?></div>
                <p class="text-xs text-slate-500 mt-1 line-clamp-2">ID Pengajuan: #<?= esc($submission['id']); ?></p>
              </td>
              <td class="px-4 py-3 align-top text-slate-700"><?= esc($submission['bidang']); ?></td>
              <td class="px-4 py-3 align-top text-slate-700"><?= esc($submission['dosen_pembimbing']); ?></td>
              <td class="px-4 py-3 align-top">
                <span class="px-3 py-1 rounded-full text-xs font-semibold <?= $statusColor; ?>"><?= esc($submission['status']); ?></span>
              </td>
              <td class="px-4 py-3 align-top text-slate-700"><?= date('d M Y', strtotime($submission['created_at'])); ?></td>
              <td class="px-4 py-3 align-top">
                <div class="flex flex-wrap gap-2 text-xs">
                  <a href="<?= esc($basePath); ?>/<?= esc($submission['id']); ?>"
                    class="px-3 py-2 rounded-lg border border-slate-200 text-[var(--biru-tua)] font-semibold hover:bg-slate-50 transition">Detail</a>
                </div>
              </td>
            </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    </div>
  </div>
</div>
<?= $this->endSection(); ?>
