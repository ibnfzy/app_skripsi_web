<?= $this->extend('panel/base_layout'); ?>

<?= $this->section('content'); ?>
<div class="space-y-8">
  <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-3">
    <div>
      <p class="text-sm text-slate-500">Kelola dan pantau pengajuan judul skripsi Anda</p>
      <h2 class="text-3xl font-semibold text-[var(--abu-gelap)]">Pengajuan Judul</h2>
    </div>
    <div class="flex items-center gap-3">
      <a href="/Mahasiswa/pengajuan-judul/tambah"
        class="px-4 py-2 rounded-xl bg-[var(--biru-medium)] hover:bg-[var(--biru-tua)] text-white text-sm font-semibold transition">Tambah Pengajuan</a>
    </div>
  </div>

  <?php if (! empty($flash)): ?>
    <div class="p-4 rounded-xl bg-green-50 border border-green-200 text-green-800 text-sm"><?= esc($flash); ?></div>
  <?php endif; ?>
  <?php if (! empty($errorFlash)): ?>
    <div class="p-4 rounded-xl bg-rose-50 border border-rose-200 text-rose-800 text-sm"><?= esc($errorFlash); ?></div>
  <?php endif; ?>
  <?php if ($allRejected): ?>
    <div class="p-4 rounded-xl bg-amber-50 border border-amber-200 text-amber-800 text-sm">
      Semua pengajuan judul Anda ditolak. Silakan ajukan ulang judul baru sesuai catatan review dekan dan kaprodi.
    </div>
  <?php endif; ?>

  <?php if ($needsSelection): ?>
    <div class="p-6 bg-white rounded-2xl shadow-sm border border-slate-100 space-y-4">
      <div>
        <p class="text-xs text-slate-500">Pilihan Judul Disetujui</p>
        <h3 class="text-xl font-semibold text-[var(--abu-gelap)]">Pilih salah satu judul yang disetujui</h3>
        <p class="text-sm text-slate-600 mt-1">Beberapa judul telah disetujui. Konfirmasi pilihan akhir untuk diproses sebagai judul skripsi.</p>
      </div>
      <form method="post" action="/Mahasiswa/pengajuan-judul/pilih" class="space-y-4">
        <?= csrf_field(); ?>
        <div class="grid md:grid-cols-2 gap-4">
          <?php foreach ($approvedSubmissions as $approved): ?>
            <label class="relative block border rounded-2xl p-4 cursor-pointer hover:border-[var(--biru-medium)] transition">
              <input type="radio" name="judul_id" value="<?= esc($approved['id']); ?>" class="peer sr-only"
                <?= (int) ($approved['judul_pilihan'] ?? 0) !== 0 ? 'checked' : ''; ?> />
              <div class="absolute right-4 top-4 w-5 h-5 rounded-full border peer-checked:border-[var(--biru-medium)] peer-checked:ring-4 peer-checked:ring-[var(--biru-medium)]/20"></div>
              <div class="space-y-2">
                <div class="flex items-center gap-2">
                  <h4 class="font-semibold text-[var(--abu-gelap)] leading-snug flex-1">#<?= esc($approved['id']); ?> - <?= esc($approved['judul']); ?></h4>
                  <span class="px-3 py-1 rounded-full bg-green-50 text-green-700 text-xs font-semibold">Disetujui</span>
                </div>
                <p class="text-sm text-slate-600 leading-relaxed line-clamp-3"><?= esc($approved['deskripsi']); ?></p>
                <div class="flex flex-wrap gap-3 text-xs text-slate-600">
                  <span class="inline-flex items-center gap-1"><span class="font-semibold text-[var(--abu-gelap)]">Pembimbing:</span> <?= esc($approved['dosen_pembimbing']); ?></span>
                  <span class="inline-flex items-center gap-1"><span class="font-semibold text-[var(--abu-gelap)]">Dibuat:</span> <?= date('d F Y', strtotime($approved['created_at'] ?? 'now')); ?></span>
                </div>
                <?php if (! empty($approved['review_notes'])): ?>
                  <p class="text-xs text-slate-500">Catatan: <?= esc($approved['review_notes']); ?></p>
                <?php endif; ?>
              </div>
            </label>
          <?php endforeach; ?>
        </div>
        <button type="submit" class="px-4 py-3 rounded-xl bg-[var(--biru-medium)] hover:bg-[var(--biru-tua)] text-white text-sm font-semibold transition">Konfirmasi Pilihan</button>
      </form>
    </div>
  <?php elseif ($selectedTitleId !== null): ?>
    <?php foreach ($approvedSubmissions as $approved): ?>
      <?php if ((int) $approved['id'] === (int) $selectedTitleId): ?>
        <div class="p-4 rounded-xl bg-sky-50 border border-sky-200 text-sky-800 text-sm flex items-center gap-3">
          <span class="px-3 py-1 rounded-full bg-sky-200 text-sky-800 text-xs font-semibold">Judul Terpilih</span>
          <div>
            <p class="font-semibold text-[var(--abu-gelap)]">#<?= esc($approved['id']); ?> - <?= esc($approved['judul']); ?></p>
            <p class="text-xs text-slate-600">Judul disetujui telah ditandai sebagai pilihan akhir.</p>
          </div>
        </div>
      <?php endif; ?>
    <?php endforeach; ?>
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
      </form>
      <div class="flex gap-3">
        <button type="submit" form="filterForm" class="px-4 py-3 rounded-xl bg-[var(--biru-medium)] hover:bg-[var(--biru-tua)] text-white text-sm font-semibold transition">Terapkan</button>
        <a href="/Mahasiswa/pengajuan-judul" class="px-4 py-3 rounded-xl border border-slate-200 text-sm text-[var(--abu-gelap)] bg-slate-50 hover:bg-slate-100 transition">Reset</a>
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
            <th class="px-4 py-3 text-left border-b border-slate-200">Tanggal</th>
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
                <?php if ((int) ($submission['judul_pilihan'] ?? 0) !== 0): ?>
                  <p class="text-[11px] text-[var(--biru-tua)] font-semibold mt-1">Judul terpilih</p>
                <?php endif; ?>
              </td>
              <td class="px-4 py-3 align-top text-slate-700"><?= esc($submission['tanggal']); ?></td>
              <td class="px-4 py-3 align-top">
                <div class="flex flex-wrap gap-2 text-xs">
                  <button type="button"
                    class="px-3 py-2 rounded-lg border border-slate-200 text-[var(--biru-tua)] font-semibold hover:bg-slate-50 transition detail-btn"
                    data-judul="<?= esc($submission['judul']); ?>"
                    data-bidang="<?= esc($submission['bidang']); ?>"
                    data-pembimbing="<?= esc($submission['dosen_pembimbing']); ?>"
                    data-status="<?= esc($submission['status']); ?>"
                    data-tanggal="<?= esc($submission['tanggal']); ?>"
                    data-deskripsi='<?= esc($submission['deskripsi']); ?>'
                    data-jurnal='<?= json_encode($submission['file_jurnal']); ?>'>Detail</button>
                  <button class="px-3 py-2 rounded-lg border border-slate-200 text-slate-600 hover:bg-slate-50 transition">Edit</button>
                  <button class="px-3 py-2 rounded-lg border border-rose-200 text-rose-600 hover:bg-rose-50 transition">Hapus</button>
                </div>
              </td>
            </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    </div>

    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-3 text-sm text-slate-600">
      <p>Menampilkan <?= count($submissions); ?> dari <?= esc($pagination['totalItems']); ?> data</p>
      <div class="flex items-center gap-2">
        <?php $prevPage = max(1, $pagination['current'] - 1); ?>
        <?php $nextPage = min($pagination['totalPages'], $pagination['current'] + 1); ?>
        <a href="?<?= http_build_query(['search' => $search, 'status' => $statusFilter, 'page' => $prevPage]); ?>"
          class="px-3 py-2 rounded-lg border border-slate-200 hover:bg-slate-50 <?= $pagination['current'] === 1 ? 'opacity-50 pointer-events-none' : ''; ?>">Sebelumnya</a>
        <span class="px-3 py-2">Halaman <?= esc($pagination['current']); ?> dari <?= esc($pagination['totalPages']); ?></span>
        <a href="?<?= http_build_query(['search' => $search, 'status' => $statusFilter, 'page' => $nextPage]); ?>"
          class="px-3 py-2 rounded-lg border border-slate-200 hover:bg-slate-50 <?= $pagination['current'] === $pagination['totalPages'] ? 'opacity-50 pointer-events-none' : ''; ?>">Selanjutnya</a>
      </div>
    </div>
  </div>
</div>

<div id="detailModal" class="fixed inset-0 bg-black/40 hidden items-center justify-center px-4 z-50">
  <div class="bg-white w-full max-w-4xl max-h-[90vh] overflow-y-auto rounded-2xl shadow-xl">
    <div class="flex items-start justify-between p-6 border-b border-slate-200">
      <div>
        <p class="text-sm text-slate-500">Detail Pengajuan Judul</p>
        <h3 id="modalTitle" class="text-xl font-semibold text-[var(--abu-gelap)]"></h3>
      </div>
      <button id="closeModal" class="text-slate-500 hover:text-slate-800">&times;</button>
    </div>
    <div class="p-6 space-y-4 text-sm text-slate-700">
      <div class="grid md:grid-cols-2 gap-4">
        <div>
          <p class="text-xs text-slate-500">Bidang</p>
          <p id="modalBidang" class="font-semibold text-[var(--abu-gelap)]"></p>
        </div>
        <div>
          <p class="text-xs text-slate-500">Tanggal Pengajuan</p>
          <p id="modalTanggal" class="font-semibold text-[var(--abu-gelap)]"></p>
        </div>
        <div>
          <p class="text-xs text-slate-500">Pembimbing</p>
          <p id="modalPembimbing" class="font-semibold text-[var(--abu-gelap)]"></p>
        </div>
        <div>
          <p class="text-xs text-slate-500">Status</p>
          <span id="modalStatus" class="inline-block px-3 py-1 rounded-full text-xs font-semibold bg-slate-100 text-slate-700"></span>
        </div>
      </div>
      <div>
        <p class="text-xs text-slate-500 mb-1">Deskripsi</p>
        <p id="modalDeskripsi" class="leading-relaxed"></p>
      </div>
      <div>
        <p class="text-xs text-slate-500 mb-2">Lampiran Jurnal</p>
        <ul id="modalJurnal" class="list-disc list-inside space-y-1"></ul>
      </div>
    </div>
  </div>
</div>

<script>
  const detailButtons = document.querySelectorAll('.detail-btn');
  const modal = document.getElementById('detailModal');
  const closeModal = document.getElementById('closeModal');

  const modalTitle = document.getElementById('modalTitle');
  const modalBidang = document.getElementById('modalBidang');
  const modalPembimbing = document.getElementById('modalPembimbing');
  const modalTanggal = document.getElementById('modalTanggal');
  const modalStatus = document.getElementById('modalStatus');
  const modalDeskripsi = document.getElementById('modalDeskripsi');
  const modalJurnal = document.getElementById('modalJurnal');

  detailButtons.forEach((btn) => {
    btn.addEventListener('click', () => {
      modalTitle.textContent = btn.dataset.judul;
      modalBidang.textContent = btn.dataset.bidang;
      modalPembimbing.textContent = btn.dataset.pembimbing;
      modalTanggal.textContent = btn.dataset.tanggal;
      modalStatus.textContent = btn.dataset.status;
      modalDeskripsi.textContent = btn.dataset.deskripsi;

      modalJurnal.innerHTML = '';
      try {
        const jurnalList = JSON.parse(btn.dataset.jurnal ?? '[]');
        jurnalList.forEach((item) => {
          const li = document.createElement('li');
          const link = document.createElement('a');
          link.href = item.url;
          link.target = '_blank';
          link.rel = 'noopener noreferrer';
          link.className = 'text-[var(--biru-tua)] hover:underline';
          link.textContent = item.label ?? 'Jurnal';
          li.appendChild(link);
          modalJurnal.appendChild(li);
        });
      } catch (error) {
        modalJurnal.innerHTML = '<li class="text-slate-500">Lampiran jurnal tidak tersedia.</li>';
      }

      modal.classList.remove('hidden');
      modal.classList.add('flex');
    });
  });

  const hideModal = () => {
    modal.classList.add('hidden');
    modal.classList.remove('flex');
  };

  closeModal?.addEventListener('click', hideModal);
  modal?.addEventListener('click', (event) => {
    if (event.target === modal) hideModal();
  });
</script>
<?= $this->endSection(); ?>
