<?= $this->extend('panel/base_layout'); ?>

<?= $this->section('content'); ?>
<div class="space-y-8">
  <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-3">
    <div>
      <p class="text-sm text-slate-500">Pengaturan akun panel <?= esc($role ?? 'Pengguna'); ?></p>
      <h2 class="text-3xl font-semibold text-[var(--abu-gelap)]">Pengaturan Akun</h2>
      <p class="text-sm text-slate-600 mt-2">Perbarui informasi profil dan ubah kata sandi jika diperlukan.</p>
    </div>
    <span class="px-4 py-2 rounded-full bg-[var(--biru-medium)] text-white text-sm font-semibold">Profil Akun</span>
  </div>

  <?php if (session()->getFlashdata('message')): ?>
    <div class="p-4 rounded-xl bg-emerald-50 border border-emerald-200 text-emerald-800">
      <?= esc(session()->getFlashdata('message')); ?>
    </div>
  <?php endif; ?>

  <?php if (session()->getFlashdata('error')): ?>
    <div class="p-4 rounded-xl bg-red-50 border border-red-200 text-red-700 space-y-2">
      <p class="font-semibold">Terjadi kesalahan</p>
      <p><?= esc(session()->getFlashdata('error')); ?></p>
      <?php if ($errors = session()->getFlashdata('errors')): ?>
        <ul class="list-disc list-inside text-sm space-y-1">
          <?php foreach ($errors as $error): ?>
            <li><?= esc($error); ?></li>
          <?php endforeach; ?>
        </ul>
      <?php endif; ?>
    </div>
  <?php endif; ?>

  <div class="grid lg:grid-cols-3 gap-6">
    <div class="lg:col-span-2 p-6 rounded-2xl bg-white shadow-sm border border-slate-200">
      <h3 class="text-xl font-semibold text-[var(--abu-gelap)]">Data Akun</h3>
      <p class="text-sm text-slate-600 mt-1">Isi sesuai data pada tabel users. Kolom kata sandi bersifat opsional.</p>

      <form action="<?= esc($formAction ?? current_url()); ?>" method="post" class="mt-6 space-y-4">
        <?= csrf_field(); ?>
        <div>
          <label for="nama" class="block text-sm font-medium text-slate-700">Nama Lengkap</label>
          <input type="text" id="nama" name="nama" value="<?= old('nama', $user['nama'] ?? ''); ?>"
            class="mt-1 w-full rounded-lg border border-slate-300 px-3 py-2 focus:outline-none focus:ring-2 focus:ring-[var(--biru-medium)]" required>
        </div>

        <div>
          <label for="username" class="block text-sm font-medium text-slate-700">Username</label>
          <input type="text" id="username" name="username" value="<?= old('username', $user['username'] ?? ''); ?>"
            class="mt-1 w-full rounded-lg border border-slate-300 px-3 py-2 focus:outline-none focus:ring-2 focus:ring-[var(--biru-medium)]" required>
        </div>

        <div>
          <label class="block text-sm font-medium text-slate-700">Role</label>
          <input type="text" value="<?= esc($user['role'] ?? ($role ?? 'Pengguna')); ?>" disabled
            class="mt-1 w-full rounded-lg border border-slate-200 bg-slate-50 px-3 py-2 text-slate-600">
          <p class="text-xs text-slate-500 mt-1">Role mengikuti data yang tercatat pada akun.</p>
        </div>

        <div>
          <label for="password" class="block text-sm font-medium text-slate-700">Password Baru (Opsional)</label>
          <input type="password" id="password" name="password" placeholder="Isi untuk mengganti password lama"
            class="mt-1 w-full rounded-lg border border-slate-300 px-3 py-2 focus:outline-none focus:ring-2 focus:ring-[var(--biru-medium)]">
          <p class="text-xs text-slate-500 mt-1">Biarkan kosong jika tidak ingin mengubah password. Minimal 6 karakter saat diisi.</p>
        </div>

        <div class="flex items-center gap-3">
          <button type="submit"
            class="px-4 py-2 rounded-lg bg-[var(--biru-medium)] text-white font-semibold hover:bg-[var(--biru-tua)] transition">Simpan Perubahan</button>
          <p class="text-xs text-slate-500">Perubahan akan langsung diterapkan pada sesi Anda.</p>
        </div>
      </form>
    </div>

    <div class="p-6 rounded-2xl bg-white shadow-sm border border-slate-200 space-y-4">
      <div>
        <h4 class="text-lg font-semibold text-[var(--abu-gelap)]">Tips Keamanan</h4>
        <ul class="mt-2 space-y-2 text-sm text-slate-600 list-disc list-inside">
          <li>Gunakan kombinasi huruf, angka, dan simbol saat mengganti password.</li>
          <li>Jangan bagikan kredensial Anda pada orang lain.</li>
          <li>Segera keluar dari sistem setelah selesai menggunakan panel.</li>
        </ul>
      </div>
      <div class="p-4 rounded-xl bg-[var(--abu-muda)] border border-slate-200">
        <p class="text-sm text-slate-700">Jika Anda lupa password, hubungi administrator untuk bantuan reset akun.</p>
      </div>
    </div>
  </div>
</div>
<?= $this->endSection(); ?>
