<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Sistem Skripsi</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
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

<body class="min-h-screen bg-[var(--abu-muda)] flex items-center justify-center text-[var(--abu-gelap)]">
    <div class="absolute inset-0 bg-gradient-to-br from-[var(--biru-tua)] via-[var(--biru-medium)] to-[var(--biru-tua)] opacity-10"></div>
    <div class="relative max-w-6xl w-full mx-auto px-6 grid md:grid-cols-2 gap-10 items-center">
        <div class="hidden md:block space-y-5">
            <div class="inline-flex items-center gap-3 px-4 py-2 rounded-full bg-white/80 shadow border border-white/60">
                <div class="h-10 w-10 rounded-full bg-[var(--biru-tua)] text-white flex items-center justify-center font-bold">SI</div>
                <div>
                    <p class="text-xs text-slate-500">Sistem Informasi</p>
                    <p class="text-base font-semibold text-[var(--abu-gelap)]">Pengajuan &amp; Bimbingan Skripsi</p>
                </div>
            </div>
            <h1 class="text-3xl font-bold leading-tight">Masuk ke Panel Anda</h1>
            <p class="text-slate-600 text-lg leading-relaxed">Kelola pengajuan judul, bimbingan, atau validasi sesuai peran Anda. Gunakan kredensial resmi yang diberikan jurusan.</p>
            <div class="grid grid-cols-2 gap-4">
                <div class="p-4 rounded-xl bg-white shadow border border-slate-100">
                    <p class="text-sm text-slate-500">Terintegrasi</p>
                    <p class="text-2xl font-bold text-[var(--biru-tua)]">4 Panel</p>
                </div>
                <div class="p-4 rounded-xl bg-white shadow border border-slate-100">
                    <p class="text-sm text-slate-500">Keamanan</p>
                    <p class="text-2xl font-bold text-[var(--hijau)]">Aktif</p>
                </div>
            </div>
        </div>
        <div class="bg-white rounded-2xl shadow-xl border border-slate-100 p-8 space-y-6">
            <div>
                <p class="text-sm text-slate-500">Silakan masuk</p>
                <h2 class="text-2xl font-semibold">Autentikasi Pengguna</h2>
            </div>
            <?php if (session('error')): ?>
                <div class="p-4 rounded-xl bg-red-50 border border-red-200 text-red-700 text-sm">
                    <?= esc(session('error')); ?>
                </div>
            <?php endif; ?>
            <?php if (session('message')): ?>
                <div class="p-4 rounded-xl bg-green-50 border border-green-200 text-green-700 text-sm">
                    <?= esc(session('message')); ?>
                </div>
            <?php endif; ?>
            <form action="/login" method="post" class="space-y-4">
                <?= csrf_field(); ?>
                <div class="space-y-2">
                    <label for="role" class="text-sm font-medium">Role</label>
                    <select id="role" name="role" class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-[var(--biru-medium)]">
                        <option value="">Pilih role</option>
                        <option value="Sekjur" <?= set_select('role', 'Sekjur'); ?>>Sekjur</option>
                        <option value="Kaprodi" <?= set_select('role', 'Kaprodi'); ?>>Kaprodi</option>
                        <option value="Dosen Pembimbing" <?= set_select('role', 'Dosen Pembimbing'); ?>>Dosen Pembimbing</option>
                        <option value="Mahasiswa" <?= set_select('role', 'Mahasiswa'); ?>>Mahasiswa</option>
                    </select>
                </div>
                <div class="space-y-2">
                    <label for="username" class="text-sm font-medium">Username</label>
                    <input id="username" name="username" type="text" value="<?= old('username'); ?>" class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-[var(--biru-medium)]" placeholder="Masukkan username">
                </div>
                <div class="space-y-2">
                    <label for="password" class="text-sm font-medium">Password</label>
                    <input id="password" name="password" type="password" class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-[var(--biru-medium)]" placeholder="Masukkan password">
                </div>
                <button type="submit" class="w-full py-3 rounded-xl bg-[var(--biru-medium)] text-white font-semibold shadow hover:bg-[var(--biru-tua)] transition">Masuk</button>
            </form>
            <p class="text-xs text-slate-500 text-center">Akses panel tersedia untuk Sekjur, Kaprodi, Dosen Pembimbing, dan Mahasiswa.</p>
        </div>
    </div>
</body>

</html>
