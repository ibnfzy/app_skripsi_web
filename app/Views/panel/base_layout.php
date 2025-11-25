<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Panel <?= esc($role ?? 'Pengguna'); ?></title>
  <script src="https://cdn.tailwindcss.com"></script>
  <style>
  :root {
    --biru-tua: #0D47A1;
    --biru-medium: #1976D2;
    --hijau: #4CAF50;
    --abu-gelap: #212121;
    --abu-muda: #F5F5F5;
  }

  body {
    font-family: 'Inter', system-ui, -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
  }
  </style>
</head>

<body class="bg-[var(--abu-muda)] text-[var(--abu-gelap)]">
  <?php
    $descriptions = [
        'Mahasiswa' => 'Akses pengajuan judul, bimbingan, seminar, dan revisi dalam satu panel.',
        'Dosen Pembimbing' => 'Kelola daftar mahasiswa bimbingan, catatan, serta jadwal seminar.',
        'Kaprodi' => 'Pantau pengajuan judul dan progres bimbingan program studi.',
        'Sekjur' => 'Validasi pengajuan dan atur penjadwalan seminar jurusan.',
    ];
    $modules = $contentMap ?? [];
    ?>
  <div class="min-h-screen flex">
    <aside class="w-72 bg-[var(--biru-tua)] text-white flex flex-col shadow-xl">
      <div class="px-6 py-5 flex items-center gap-3 border-b border-white/10">
        <div class="h-12 w-12 rounded-xl bg-white/10 flex items-center justify-center font-bold">SP</div>
        <div>
          <p class="text-xs text-white/80">Sistem Skripsi</p>
          <p class="text-lg font-semibold">Panel <?= esc($role ?? 'Pengguna'); ?></p>
        </div>
      </div>
      <nav class="flex-1 overflow-y-auto px-4 py-6 space-y-2">
        <?php foreach (($menu ?? []) as $index => $item): ?>
        <a href="#"
          class="block px-4 py-3 rounded-xl <?php echo $index === 0 ? 'bg-white text-[var(--biru-tua)] font-semibold shadow' : 'text-white/90 hover:bg-white/10'; ?> transition">
          <div class="flex items-center justify-between">
            <span><?= esc($item); ?></span>
            <span class="text-xs px-2 py-1 rounded-full bg-white/10">Menu</span>
          </div>
        </a>
        <?php endforeach; ?>
      </nav>
      <div class="px-6 py-4 border-t border-white/10">
        <button
          class="w-full py-3 rounded-lg bg-white/10 hover:bg-white/20 text-white font-semibold transition">Logout</button>
        <p class="text-xs text-white/70 mt-2">Sesi aman, pastikan keluar setelah selesai.</p>
      </div>
    </aside>

    <main class="flex-1">
      <header class="bg-white shadow-sm">
        <div class="max-w-6xl mx-auto px-6 py-4 flex items-center justify-between">
          <div>
            <p class="text-sm text-slate-500">Dashboard</p>
            <h1 class="text-2xl font-semibold text-[var(--abu-gelap)]">Halo, <?= esc($role ?? 'Pengguna'); ?></h1>
          </div>
          <div class="flex items-center gap-3">
            <div class="text-right">
              <p class="text-sm font-semibold">Nama Pengguna</p>
              <p class="text-xs text-slate-500">Role: <?= esc($role ?? 'Pengguna'); ?></p>
            </div>
            <div
              class="h-10 w-10 rounded-full bg-[var(--biru-medium)] text-white flex items-center justify-center font-bold">
              ID</div>
          </div>
        </div>
      </header>

      <section class="max-w-6xl mx-auto px-6 py-10 space-y-8">
        <?= $this->renderSection('content'); ?>
        <div class="grid md:grid-cols-[2fr,1fr] gap-6">
          <div class="p-6 rounded-2xl bg-white shadow-sm border border-slate-100">
            <div class="flex items-start justify-between gap-4">
              <div>
                <p class="text-sm text-slate-500">Panel Peran</p>
                <h2 class="text-3xl font-semibold text-[var(--abu-gelap)]"><?= esc($role ?? 'Pengguna'); ?></h2>
                <p class="mt-2 text-slate-600 leading-relaxed">
                  <?= esc($descriptions[$role] ?? 'Akses modul sesuai peran Anda.'); ?></p>
              </div>
              <span class="px-3 py-1 rounded-full text-xs font-semibold bg-[var(--hijau)] text-white">Aktif</span>
            </div>
            <div class="mt-5 grid sm:grid-cols-2 gap-3">
              <div class="p-4 rounded-xl bg-[var(--abu-muda)] border border-slate-100">
                <p class="text-sm text-slate-500">Modul</p>
                <p class="text-xl font-bold text-[var(--biru-tua)]"><?= count($menu ?? []); ?> Menu</p>
              </div>
              <div class="p-4 rounded-xl bg-[var(--abu-muda)] border border-slate-100">
                <p class="text-sm text-slate-500">Komponen Dinamis</p>
                <p class="text-xl font-bold text-[var(--biru-tua)]"><?= count($modules); ?> Komponen</p>
              </div>
            </div>
          </div>
          <div
            class="p-6 rounded-2xl bg-gradient-to-br from-[var(--biru-tua)] to-[var(--biru-medium)] text-white shadow-lg">
            <p class="text-sm text-white/80">Informasi Singkat</p>
            <h3 class="text-2xl font-semibold mt-2">Alur Komponen</h3>
            <p class="text-white/80 mt-2">Panel memuat modul dinamis berdasarkan role. Gunakan menu samping untuk
              navigasi.</p>
            <div class="mt-4 space-y-2 text-sm">
              <div class="flex items-center gap-2"><span class="h-2 w-2 rounded-full bg-white"></span>Sidebar
                menampilkan menu sesuai role.</div>
              <div class="flex items-center gap-2"><span class="h-2 w-2 rounded-full bg-white"></span>Topbar menampilkan
                identitas pengguna.</div>
              <div class="flex items-center gap-2"><span class="h-2 w-2 rounded-full bg-white"></span>Konten dinamis
                berdasarkan modul aktif.</div>
            </div>
            <button
              class="mt-5 w-full py-3 rounded-lg bg-white text-[var(--biru-tua)] font-semibold hover:translate-y-[-2px] transition">Lihat
              Modul Aktif</button>
          </div>
        </div>

        <div class="grid md:grid-cols-3 gap-4">
          <?php foreach ($modules as $title => $desc): ?>
          <div
            class="p-5 rounded-2xl bg-white border border-slate-100 shadow-sm hover:-translate-y-1 hover:shadow-lg transition">
            <div class="flex items-center justify-between mb-3">
              <h4 class="text-lg font-semibold text-[var(--abu-gelap)]"><?= esc($title); ?></h4>
              <span class="text-xs px-3 py-1 rounded-full bg-[var(--abu-muda)] text-[var(--biru-tua)]">Modul</span>
            </div>
            <p class="text-sm text-slate-600 leading-relaxed"><?= esc($desc); ?></p>
          </div>
          <?php endforeach; ?>
        </div>

        <div class="grid md:grid-cols-2 gap-6">
          <div class="p-5 rounded-2xl bg-white border border-slate-100 shadow-sm">
            <div class="flex items-center justify-between mb-3">
              <h4 class="text-lg font-semibold text-[var(--abu-gelap)]">Dynamic Content Loader</h4>
              <span class="px-3 py-1 text-xs rounded-full bg-[var(--biru-medium)] text-white">Aktif</span>
            </div>
            <p class="text-sm text-slate-600">Load view dan komponen otomatis sesuai role: mahasiswa, dosen, kaprodi,
              atau sekjur. Setiap modul siap dihubungkan dengan data backend.</p>
            <div class="mt-4 grid grid-cols-2 gap-3 text-sm">
              <div class="p-3 rounded-xl bg-[var(--abu-muda)]">Sidebar: dynamic_menu</div>
              <div class="p-3 rounded-xl bg-[var(--abu-muda)]">Topbar: user_info</div>
              <div class="p-3 rounded-xl bg-[var(--abu-muda)]">Role Label: <?= esc($role ?? 'Pengguna'); ?></div>
              <div class="p-3 rounded-xl bg-[var(--abu-muda)]">Notif Center: Opsional</div>
            </div>
          </div>
          <div class="p-5 rounded-2xl bg-white border border-slate-100 shadow-sm">
            <div class="flex items-center justify-between mb-3">
              <h4 class="text-lg font-semibold text-[var(--abu-gelap)]">Logout</h4>
              <span class="px-3 py-1 text-xs rounded-full bg-[var(--hijau)] text-white">Siap</span>
            </div>
            <p class="text-sm text-slate-600">Sesi aman dengan alur destroy_session dan redirect_login. Integrasikan
              dengan middleware autentikasi.</p>
            <div
              class="mt-4 p-4 rounded-xl bg-[var(--abu-muda)] border border-dashed border-[var(--biru-medium)] text-sm text-[var(--biru-tua)]">
              Klik tombol logout pada sidebar untuk keluar dari sistem.</div>
          </div>
        </div>
      </section>
    </main>
  </div>
</body>

</html>