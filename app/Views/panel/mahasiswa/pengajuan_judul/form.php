<?= $this->extend('panel/base_layout'); ?>

<?= $this->section('content'); ?>
<div class="space-y-8">
  <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-3">
    <div>
      <p class="text-sm text-slate-500">Isi data pengajuan judul sesuai instruksi prodi</p>
      <h2 class="text-3xl font-semibold text-[var(--abu-gelap)]">Form Pengajuan Judul</h2>
    </div>
    <a href="/Mahasiswa/pengajuan-judul" class="px-4 py-2 rounded-xl border border-slate-200 text-[var(--abu-gelap)] bg-white hover:bg-slate-50 transition text-sm font-semibold">Kembali ke Daftar</a>
  </div>

  <div class="p-6 bg-white rounded-2xl shadow-sm border border-slate-100">
    <form action="" method="post" enctype="multipart/form-data" class="space-y-5">
      <?= csrf_field(); ?>
      <div class="grid md:grid-cols-2 gap-4">
        <div>
          <label class="block text-sm text-slate-700 mb-2" for="judul">Judul Skripsi</label>
          <input type="text" name="judul" id="judul" value="<?= old('judul'); ?>" placeholder="Contoh: Analisis Sentimen..." class="w-full rounded-xl border border-slate-200 px-4 py-3 text-sm focus:ring-2 focus:ring-[var(--biru-medium)] focus:outline-none" required />
          <?php if (isset($validation) && $validation->hasError('judul')): ?>
            <p class="text-rose-600 text-xs mt-1"><?= $validation->getError('judul'); ?></p>
          <?php endif; ?>
        </div>
        <div>
          <label class="block text-sm text-slate-700 mb-2" for="bidang">Bidang/Topik</label>
          <input type="text" name="bidang" id="bidang" value="<?= old('bidang'); ?>" placeholder="Contoh: Kecerdasan Buatan" class="w-full rounded-xl border border-slate-200 px-4 py-3 text-sm focus:ring-2 focus:ring-[var(--biru-medium)] focus:outline-none" required />
          <?php if (isset($validation) && $validation->hasError('bidang')): ?>
            <p class="text-rose-600 text-xs mt-1"><?= $validation->getError('bidang'); ?></p>
          <?php endif; ?>
        </div>
      </div>

      <div>
        <label class="block text-sm text-slate-700 mb-2" for="deskripsi">Deskripsi Singkat</label>
        <textarea name="deskripsi" id="deskripsi" rows="4" placeholder="Tuliskan latar belakang, tujuan, dan metode singkat." class="w-full rounded-xl border border-slate-200 px-4 py-3 text-sm focus:ring-2 focus:ring-[var(--biru-medium)] focus:outline-none" required><?= old('deskripsi'); ?></textarea>
        <?php if (isset($validation) && $validation->hasError('deskripsi')): ?>
          <p class="text-rose-600 text-xs mt-1"><?= $validation->getError('deskripsi'); ?></p>
        <?php endif; ?>
      </div>

      <div class="grid md:grid-cols-2 gap-4">
        <div>
          <label class="block text-sm text-slate-700 mb-2" for="pembimbing">Usulan Dosen Pembimbing</label>
          <input type="text" name="pembimbing" id="pembimbing" value="<?= old('pembimbing'); ?>" placeholder="Masukkan nama dosen" class="w-full rounded-xl border border-slate-200 px-4 py-3 text-sm focus:ring-2 focus:ring-[var(--biru-medium)] focus:outline-none" required />
          <?php if (isset($validation) && $validation->hasError('pembimbing')): ?>
            <p class="text-rose-600 text-xs mt-1"><?= $validation->getError('pembimbing'); ?></p>
          <?php endif; ?>
        </div>
        <div>
          <label class="block text-sm text-slate-700 mb-2" for="jurnal">Lampiran Jurnal (PDF)</label>
          <input type="file" name="jurnal" id="jurnal" accept="application/pdf" class="w-full rounded-xl border border-slate-200 px-4 py-3 text-sm focus:ring-2 focus:ring-[var(--biru-medium)] focus:outline-none" required />
          <p class="text-xs text-slate-500 mt-1">Hanya menerima berkas PDF. Maksimalkan kejelasan dengan nama file yang deskriptif.</p>
          <?php if (isset($validation) && $validation->hasError('jurnal')): ?>
            <p class="text-rose-600 text-xs mt-1"><?= $validation->getError('jurnal'); ?></p>
          <?php endif; ?>
        </div>
      </div>

      <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-3">
        <p class="text-xs text-slate-500">Pastikan seluruh data benar. Pengajuan akan otomatis masuk ke daftar riwayat.</p>
        <div class="flex gap-3">
          <a href="/Mahasiswa/pengajuan-judul" class="px-4 py-3 rounded-xl border border-slate-200 text-[var(--abu-gelap)] bg-slate-50 hover:bg-slate-100 transition text-sm font-semibold">Batal</a>
          <button type="submit" class="px-5 py-3 rounded-xl bg-[var(--biru-medium)] hover:bg-[var(--biru-tua)] text-white text-sm font-semibold transition">Kirim Pengajuan</button>
        </div>
      </div>
    </form>
  </div>
</div>
<?= $this->endSection(); ?>
