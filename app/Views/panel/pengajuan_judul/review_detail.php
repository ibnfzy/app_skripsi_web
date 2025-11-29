<?= $this->extend('panel/base_layout'); ?>

<?= $this->section('content'); ?>
<div class="space-y-8">
  <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-3">
    <div>
      <p class="text-sm text-slate-500">Tinjau detail pengajuan dan berikan keputusan</p>
      <h2 class="text-3xl font-semibold text-[var(--abu-gelap)]">Detail Pengajuan</h2>
    </div>
    <div class="flex items-center gap-3 text-sm">
      <a href="<?= esc($basePath); ?>" class="px-4 py-2 rounded-xl border border-slate-200 text-[var(--abu-gelap)] hover:bg-slate-50 transition">Kembali</a>
    </div>
  </div>

  <?php if (! empty($flash)): ?>
    <div class="p-4 rounded-xl bg-green-50 border border-green-200 text-green-800 text-sm"><?= esc($flash); ?></div>
  <?php endif; ?>

  <?php if (! empty($error)): ?>
    <div class="p-4 rounded-xl bg-rose-50 border border-rose-200 text-rose-800 text-sm"><?= esc($error); ?></div>
  <?php endif; ?>

  <div class="grid lg:grid-cols-3 gap-6">
    <div class="lg:col-span-2 space-y-4">
      <div class="p-6 bg-white rounded-2xl shadow-sm border border-slate-100 space-y-3">
        <div class="flex items-center justify-between gap-3">
          <div>
            <p class="text-sm text-slate-500">Judul Skripsi</p>
            <h3 class="text-xl font-semibold text-[var(--abu-gelap)] leading-snug"><?= esc($submission['judul']); ?></h3>
          </div>
          <?php
            $badgeColors = [
              'Menunggu Review' => 'bg-amber-100 text-amber-700',
              'Disetujui' => 'bg-green-100 text-green-700',
              'Perlu Revisi' => 'bg-sky-100 text-sky-700',
              'Ditolak' => 'bg-rose-100 text-rose-700',
            ];
            $statusColor = $badgeColors[$submission['status']] ?? 'bg-slate-100 text-slate-700';
          ?>
          <span class="px-3 py-1 rounded-full text-xs font-semibold <?= $statusColor; ?>"><?= esc($submission['status']); ?></span>
        </div>
        <div class="grid md:grid-cols-3 gap-4 text-sm text-slate-700">
          <div>
            <p class="text-xs text-slate-500">Bidang</p>
            <p class="font-semibold text-[var(--abu-gelap)]"><?= esc($submission['bidang']); ?></p>
          </div>
          <div>
            <p class="text-xs text-slate-500">Pembimbing</p>
            <p class="font-semibold text-[var(--abu-gelap)]"><?= esc($submission['dosen_pembimbing']); ?></p>
          </div>
          <div>
            <p class="text-xs text-slate-500">Tanggal Pengajuan</p>
            <p class="font-semibold text-[var(--abu-gelap)]"><?= date('d F Y', strtotime($submission['created_at'])); ?></p>
          </div>
        </div>
        <div>
          <p class="text-xs text-slate-500 mb-1">Deskripsi</p>
          <p class="leading-relaxed text-slate-700"><?= esc($submission['deskripsi']); ?></p>
        </div>
      </div>

      <div class="p-6 bg-white rounded-2xl shadow-sm border border-slate-100">
        <p class="text-sm font-semibold text-[var(--abu-gelap)] mb-3">Lampiran Jurnal</p>
        <ul class="list-disc list-inside space-y-2 text-sm text-[var(--biru-tua)]">
          <?php foreach ($submission['file_jurnal'] as $file): ?>
            <li>
              <a href="<?= esc($file['url']); ?>" target="_blank" rel="noopener noreferrer" class="hover:underline">
                <?= esc($file['label'] ?? 'Lampiran Jurnal'); ?>
              </a>
            </li>
          <?php endforeach; ?>
          <?php if (empty($submission['file_jurnal'])): ?>
            <li class="text-slate-500">Tidak ada lampiran jurnal.</li>
          <?php endif; ?>
        </ul>
      </div>

      <?php if (! empty($submission['review_notes'])): ?>
        <div class="p-6 bg-blue-50 border border-blue-100 rounded-2xl">
          <p class="text-sm font-semibold text-blue-900 mb-2">Catatan Review Sebelumnya</p>
          <p class="text-sm text-blue-800 leading-relaxed"><?= esc($submission['review_notes']); ?></p>
        </div>
      <?php endif; ?>
    </div>

    <div class="lg:col-span-1">
      <div class="p-6 bg-white rounded-2xl shadow-sm border border-slate-100 space-y-4">
        <div>
          <p class="text-sm font-semibold text-[var(--abu-gelap)]">Keputusan Review</p>
          <p class="text-xs text-slate-500">Status wajib dipilih, catatan review opsional.</p>
        </div>
        <form action="<?= esc($formAction); ?>" method="post" class="space-y-4">
          <?= csrf_field(); ?>
          <div>
            <label class="block text-sm text-slate-600 mb-2">Status Pengajuan</label>
            <select name="status" class="w-full rounded-xl border border-slate-200 px-4 py-3 text-sm focus:ring-2 focus:ring-[var(--biru-medium)] focus:outline-none" required>
              <option value="">Pilih Status</option>
              <?php foreach ($statusOptions as $option): ?>
                <option value="<?= esc($option); ?>" <?= $submission['status'] === $option ? 'selected' : ''; ?>><?= esc($option); ?></option>
              <?php endforeach; ?>
            </select>
          </div>
          <div>
            <label class="block text-sm text-slate-600 mb-2">Catatan Review (Opsional)</label>
            <textarea name="review" rows="5" placeholder="Berikan catatan atau alasan keputusan"
              class="w-full rounded-xl border border-slate-200 px-4 py-3 text-sm focus:ring-2 focus:ring-[var(--biru-medium)] focus:outline-none"><?= esc($submission['review_notes'] ?? ''); ?></textarea>
          </div>
          <div class="flex flex-col gap-2 text-sm">
            <button type="submit" class="w-full px-4 py-3 rounded-xl bg-[var(--biru-medium)] hover:bg-[var(--biru-tua)] text-white font-semibold transition">Simpan Review</button>
            <a href="<?= esc($basePath); ?>" class="w-full text-center px-4 py-3 rounded-xl border border-slate-200 text-[var(--abu-gelap)] hover:bg-slate-50 transition">Batalkan</a>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
<?= $this->endSection(); ?>
