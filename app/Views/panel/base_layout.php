<?php
  $roleLabels = [
    'Mahasiswa' => 'Mahasiswa',
    'Dosen Pembimbing' => 'Dosen Pembimbing',
    'Kaprodi' => 'Ketua Program Studi',
    'Sekjur' => 'Sekretaris Jurusan',
  ];
  $roleDisplay = $roleLabels[$role ?? ''] ?? ($role ?? 'Pengguna');
  $descriptions = [
    'Mahasiswa' => 'Akses pengajuan judul, bimbingan, seminar, dan revisi dalam satu panel.',
    'Dosen Pembimbing' => 'Kelola daftar mahasiswa bimbingan, catatan, serta jadwal seminar.',
    'Kaprodi' => 'Pantau pengajuan judul dan progres bimbingan program studi.',
    'Sekjur' => 'Validasi pengajuan dan atur penjadwalan seminar jurusan.',
  ];
  $modules = $contentMap ?? [];
  $activeMenu = $activeMenu ?? null;
  $currentUser = session()->get('user') ?? [];
?>
<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Panel <?= esc($roleDisplay ?? 'Pengguna'); ?></title>
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
  <div class="min-h-screen flex">
    <aside class="w-72 bg-[var(--biru-tua)] text-white flex flex-col shadow-xl">
      <div class="px-6 py-5 flex items-center gap-3 border-b border-white/10">
        <div class="h-12 w-12 rounded-xl bg-white/10 flex items-center justify-center font-bold">SP</div>
        <div>
          <p class="text-xs text-white/80">Sistem Skripsi</p>
          <p class="text-lg font-semibold">Panel <?= esc($roleDisplay); ?></p>
        </div>
      </div>
      <nav class="flex-1 overflow-y-auto px-4 py-6 space-y-2">
        <?php foreach (($menu ?? []) as $index => $item): ?>
          <?php
            $label = is_array($item) ? ($item['label'] ?? '') : $item;
            $url = is_array($item) ? ($item['url'] ?? '#') : '#';
            $badge = is_array($item) ? ($item['badge'] ?? 'Menu') : 'Menu';
            $isActive = $activeMenu ? $label === $activeMenu : $index === 0;
          ?>
          <a href="<?= esc($url); ?>"
            class="block px-4 py-3 rounded-xl <?= $isActive ? 'bg-white text-[var(--biru-tua)] font-semibold shadow' : 'text-white/90 hover:bg-white/10'; ?> transition">
            <div class="flex items-center justify-between">
              <span><?= esc($label); ?></span>
              <span class="text-xs px-2 py-1 rounded-full bg-white/10"><?= esc($badge); ?></span>
            </div>
          </a>
        <?php endforeach; ?>
      </nav>
      <div class="px-6 py-4 border-t border-white/10">
        <a href="/logout"
          class="block text-center w-full py-3 rounded-lg bg-white/10 hover:bg-white/20 text-white font-semibold transition">Logout</a>
        <p class="text-xs text-white/70 mt-2">Sesi aman, pastikan keluar setelah selesai.</p>
      </div>
    </aside>

    <main class="flex-1">
      <header class="bg-white shadow-sm">
        <div class="max-w-6xl mx-auto px-6 py-4 flex items-center justify-between">
          <div>
            <p class="text-sm text-slate-500"><?= esc($activeMenu ?? 'Dashboard'); ?></p>
            <h1 class="text-2xl font-semibold text-[var(--abu-gelap)]">Halo, <?= esc($roleDisplay); ?></h1>
          </div>
          <div class="flex items-center gap-3">
            <div class="text-right">
              <p class="text-sm font-semibold"><?= esc($currentUser['nama'] ?? 'Nama Pengguna'); ?></p>
              <p class="text-xs text-slate-500">Username: <?= esc($currentUser['username'] ?? '-'); ?></p>
              <p class="text-xs text-slate-500">Role: <?= esc($roleDisplay); ?></p>
            </div>
            <div
              class="h-10 w-10 rounded-full bg-[var(--biru-medium)] text-white flex items-center justify-center font-bold">
              ID</div>
          </div>
        </div>
      </header>

      <section class="max-w-6xl mx-auto px-6 py-10 space-y-8">
        <?= $this->renderSection('content'); ?>
      </section>
    </main>
  </div>
</body>

</html>
