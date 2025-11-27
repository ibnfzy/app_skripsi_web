<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Sistem Informasi Pengajuan & Bimbingan Skripsi</title>
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
        body { font-family: 'Inter', system-ui, -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif; }
    </style>
</head>
<body class="bg-[var(--abu-muda)] text-[var(--abu-gelap)]">
    <header class="bg-white shadow-sm sticky top-0 z-40">
        <div class="max-w-6xl mx-auto px-6 py-4 flex items-center justify-between">
            <div class="flex items-center gap-3">
                <div class="h-12 w-12 rounded-full bg-[var(--biru-tua)] flex items-center justify-center text-white font-bold shadow-md">SI</div>
                <div>
                    <p class="text-sm text-slate-500">Universitas Negeri</p>
                    <h1 class="text-xl font-semibold text-[var(--abu-gelap)]">Sistem Skripsi</h1>
                </div>
            </div>
            <nav class="hidden md:flex items-center gap-6 text-sm font-medium">
                <a href="#beranda" class="text-[var(--abu-gelap)] hover:text-[var(--biru-medium)] transition">Beranda</a>
                <a href="#panduan" class="text-[var(--abu-gelap)] hover:text-[var(--biru-medium)] transition">Panduan</a>
                <a href="/login" class="text-[var(--abu-gelap)] hover:text-[var(--biru-medium)] transition">Login</a>
                <a href="#kontak" class="text-[var(--abu-gelap)] hover:text-[var(--biru-medium)] transition">Kontak</a>
                <a href="/login" class="px-4 py-2 rounded-full bg-[var(--biru-tua)] text-white shadow hover:bg-[var(--biru-medium)] transition">Masuk</a>
            </nav>
        </div>
    </header>

    <main id="beranda">
        <section class="relative overflow-hidden bg-gradient-to-br from-[var(--biru-tua)] via-[var(--biru-medium)] to-[var(--biru-tua)] text-white">
            <div class="absolute inset-0 opacity-20 bg-[radial-gradient(circle_at_20%_20%,white,transparent_30%),radial-gradient(circle_at_80%_0%,white,transparent_25%),radial-gradient(circle_at_50%_80%,white,transparent_35%)]"></div>
            <div class="max-w-6xl mx-auto px-6 py-20 relative z-10 grid md:grid-cols-2 gap-12 items-center">
                <div class="space-y-6">
                    <p class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-white/10 border border-white/30 text-sm backdrop-blur">Platform Terintegrasi</p>
                    <h2 class="text-4xl md:text-5xl font-bold leading-tight">Sistem Informasi Pengajuan &amp; Bimbingan Skripsi</h2>
                    <p class="text-lg text-white/90">Platform digital untuk mengelola pengajuan judul, proses bimbingan, hingga seminar dan penyelesaian skripsi secara terstruktur.</p>
                    <div class="flex flex-wrap gap-3">
                        <a href="#panduan" class="px-5 py-3 rounded-lg bg-white text-[var(--biru-tua)] font-semibold shadow hover:translate-y-[-2px] transform transition">Lihat Panduan</a>
                        <a href="#pengumuman" class="px-5 py-3 rounded-lg border border-white/50 text-white font-semibold hover:bg-white/10 hover:translate-y-[-2px] transform transition">Pengumuman Terbaru</a>
                    </div>
                    <div class="grid grid-cols-2 gap-4 pt-4">
                        <div class="p-4 rounded-xl bg-white/10 border border-white/20 backdrop-blur">
                            <p class="text-3xl font-bold">24/7</p>
                            <p class="text-sm text-white/80">Akses kapan saja</p>
                        </div>
                        <div class="p-4 rounded-xl bg-white/10 border border-white/20 backdrop-blur">
                            <p class="text-3xl font-bold">Terintegrasi</p>
                            <p class="text-sm text-white/80">Ketua Program Studi &amp; Dosen</p>
                        </div>
                    </div>
                </div>
                <div class="relative">
                    <div class="absolute -top-6 -left-6 w-24 h-24 bg-white/10 rounded-full blur-2xl"></div>
                    <div class="absolute -bottom-8 -right-4 w-28 h-28 bg-white/10 rounded-full blur-3xl"></div>
                    <div class="bg-white text-[var(--abu-gelap)] rounded-2xl shadow-2xl p-6 space-y-4 border border-white/60">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm text-slate-500">Status Mahasiswa</p>
                                <h3 class="text-xl font-semibold">Progres Skripsi</h3>
                            </div>
                            <span class="px-3 py-1 rounded-full text-xs font-semibold bg-[var(--hijau)] text-white">Aktif</span>
                        </div>
                        <div class="space-y-3">
                            <div>
                                <div class="flex justify-between text-sm font-medium mb-1">
                                    <span>Pengajuan Judul</span>
                                    <span>80%</span>
                                </div>
                                <div class="h-2 rounded-full bg-slate-100 overflow-hidden">
                                    <div class="h-full bg-[var(--biru-medium)] w-[80%] transition-all"></div>
                                </div>
                            </div>
                            <div>
                                <div class="flex justify-between text-sm font-medium mb-1">
                                    <span>Bimbingan</span>
                                    <span>60%</span>
                                </div>
                                <div class="h-2 rounded-full bg-slate-100 overflow-hidden">
                                    <div class="h-full bg-[var(--hijau)] w-[60%] transition-all"></div>
                                </div>
                            </div>
                            <div>
                                <div class="flex justify-between text-sm font-medium mb-1">
                                    <span>Seminar</span>
                                    <span>40%</span>
                                </div>
                                <div class="h-2 rounded-full bg-slate-100 overflow-hidden">
                                    <div class="h-full bg-[var(--biru-tua)] w-[40%] transition-all"></div>
                                </div>
                            </div>
                        </div>
                        <div class="flex items-center gap-3 pt-2">
                            <div class="h-10 w-10 rounded-full bg-[var(--biru-tua)] text-white flex items-center justify-center font-semibold">VN</div>
                            <div>
                                <p class="text-sm text-slate-500">Dosen Pembimbing</p>
                                <p class="font-semibold">Dr. Vania Nirmala, M.Kom</p>
                            </div>
                        </div>
                        <a href="/login" class="block text-center w-full mt-2 py-3 rounded-lg bg-[var(--biru-medium)] text-white font-semibold shadow hover:bg-[var(--biru-tua)] transition">Masuk ke Sistem</a>
                    </div>
                </div>
            </div>
        </section>

        <section id="pengumuman" class="max-w-6xl mx-auto px-6 py-16">
            <div class="flex items-center justify-between mb-6">
                <h3 class="text-2xl font-semibold text-[var(--abu-gelap)]">Pengumuman Terbaru</h3>
                <a href="#" class="text-[var(--biru-medium)] font-semibold text-sm hover:underline">Lihat semua</a>
            </div>
            <div class="grid md:grid-cols-3 gap-6">
                <?php $pengumuman = [
                    ['judul' => 'Jadwal Seminar Proposal Gelombang 2', 'tgl' => '12 Juni 2024', 'isi' => 'Pendaftaran dibuka hingga 5 Juni 2024 melalui menu seminar.'],
                    ['judul' => 'Pembukaan Pengajuan Judul Semester Ganjil', 'tgl' => '02 Juni 2024', 'isi' => 'Mahasiswa dapat mengajukan judul maksimal 2 topik melalui panel mahasiswa.'],
                    ['judul' => 'Workshop Penulisan Bab Metodologi', 'tgl' => '28 Mei 2024', 'isi' => 'Wajib untuk mahasiswa angkatan 2020-2021, daftar pada menu revisi.'],
                    ['judul' => 'Maintenance Sistem', 'tgl' => '20 Mei 2024', 'isi' => 'Sistem tidak dapat diakses pukul 22.00-23.00 WIB untuk peningkatan server.'],
                    ['judul' => 'Pengumpulan Draft Akhir', 'tgl' => '15 Mei 2024', 'isi' => 'Unggah draft akhir sebelum sidang untuk proses validasi Sekretaris Jurusan.'],
                ]; ?>
                <?php foreach ($pengumuman as $item): ?>
                    <article class="p-5 rounded-xl bg-white shadow-sm border border-slate-100 hover:-translate-y-1 hover:shadow-lg transition">
                        <div class="flex items-center justify-between text-xs text-slate-500 mb-2">
                            <span><?= $item['tgl']; ?></span>
                            <span class="px-3 py-1 bg-[var(--abu-muda)] rounded-full text-[var(--biru-tua)] font-semibold">Info</span>
                        </div>
                        <h4 class="text-lg font-semibold mb-2 text-[var(--abu-gelap)]"><?= $item['judul']; ?></h4>
                        <p class="text-slate-600 text-sm leading-relaxed"><?= $item['isi']; ?></p>
                    </article>
                <?php endforeach; ?>
            </div>
        </section>

        <section class="bg-white py-16">
            <div class="max-w-6xl mx-auto px-6 grid md:grid-cols-2 gap-12 items-center">
                <div class="space-y-4">
                    <h3 class="text-2xl font-semibold text-[var(--abu-gelap)]">Statistik Sistem</h3>
                    <p class="text-slate-600">Pantau kinerja dan aktivitas skripsi secara real-time untuk memastikan proses berjalan lancar.</p>
                    <div class="grid grid-cols-2 gap-4">
                        <?php $stats = [
                            ['label' => 'Total Pengajuan Judul', 'value' => '320'],
                            ['label' => 'Total Bimbingan', 'value' => '1.240'],
                            ['label' => 'Seminar Dijadwalkan', 'value' => '58'],
                            ['label' => 'Skripsi Selesai', 'value' => '210'],
                        ]; ?>
                        <?php foreach ($stats as $stat): ?>
                            <div class="p-4 rounded-xl bg-[var(--abu-muda)] border border-slate-100">
                                <p class="text-sm text-slate-500"><?= $stat['label']; ?></p>
                                <p class="text-3xl font-bold text-[var(--biru-tua)]"><?= $stat['value']; ?></p>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
                <div class="bg-gradient-to-br from-white via-white to-[var(--abu-muda)] p-6 rounded-2xl shadow-lg border border-slate-100">
                    <div class="flex items-center gap-3 mb-4">
                        <div class="h-12 w-12 rounded-lg bg-[var(--biru-tua)] text-white flex items-center justify-center font-semibold">PG</div>
                        <div>
                            <p class="text-sm text-slate-500">Panduan Singkat</p>
                            <h4 class="text-xl font-semibold text-[var(--abu-gelap)]">Langkah Cepat</h4>
                        </div>
                    </div>
                    <ol class="space-y-4">
                        <?php $langkah = [
                            'Login ke sistem',
                            'Ajukan judul skripsi',
                            'Proses persetujuan Ketua Program Studi & Dekan',
                            'Bimbingan dengan dosen',
                            'Daftar seminar & upload revisi'
                        ]; ?>
                        <?php foreach ($langkah as $index => $step): ?>
                            <li class="flex gap-3 items-start">
                                <span class="mt-1 h-8 w-8 rounded-full bg-[var(--biru-medium)] text-white flex items-center justify-center font-semibold shadow">
                                    <?= $index + 1; ?>
                                </span>
                                <p class="text-[var(--abu-gelap)] font-medium leading-relaxed"><?= $step; ?></p>
                            </li>
                        <?php endforeach; ?>
                    </ol>
                </div>
            </div>
        </section>

        <section id="panduan" class="max-w-6xl mx-auto px-6 py-16">
            <div class="grid md:grid-cols-2 gap-10 items-center">
                <div class="space-y-3">
                    <p class="text-sm font-semibold text-[var(--biru-medium)] uppercase tracking-wide">Alur Sistem</p>
                    <h3 class="text-3xl font-semibold text-[var(--abu-gelap)]">Panduan Singkat Penggunaan</h3>
                    <p class="text-slate-600">Ikuti setiap tahapan untuk memastikan proses skripsi berjalan lancar. Sistem akan memberikan notifikasi otomatis setiap kali ada pembaruan.</p>
                    <div class="flex gap-3 pt-2">
                        <button class="px-4 py-2 rounded-lg bg-[var(--biru-tua)] text-white font-semibold shadow hover:bg-[var(--biru-medium)] transition">Unduh Buku Panduan</button>
                        <button class="px-4 py-2 rounded-lg border border-[var(--biru-medium)] text-[var(--biru-medium)] font-semibold hover:bg-[var(--biru-medium)] hover:text-white transition">Tonton Tutorial</button>
                    </div>
                </div>
                <div class="grid gap-4">
                    <?php foreach ($langkah as $index => $step): ?>
                        <div class="p-4 rounded-xl bg-white shadow-sm border border-slate-100 flex items-center justify-between hover:-translate-y-1 transition">
                            <div class="flex items-center gap-3">
                                <span class="h-10 w-10 rounded-lg bg-[var(--abu-muda)] text-[var(--biru-tua)] flex items-center justify-center font-bold">0<?= $index + 1; ?></span>
                                <p class="font-semibold text-[var(--abu-gelap)]"><?= $step; ?></p>
                            </div>
                            <span class="text-xs px-3 py-1 rounded-full bg-[var(--hijau)] text-white font-semibold">Aktif</span>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </section>

        <section id="kontak" class="bg-[var(--biru-tua)] text-white py-14">
            <div class="max-w-6xl mx-auto px-6 grid md:grid-cols-3 gap-8 items-center">
                <div class="md:col-span-2">
                    <h3 class="text-2xl font-semibold mb-3">Kontak &amp; Bantuan</h3>
                    <p class="text-white/80 mb-6">Hubungi admin apabila membutuhkan bantuan teknis atau informasi lebih lanjut mengenai proses skripsi.</p>
                    <div class="grid sm:grid-cols-3 gap-4">
                        <div class="p-4 rounded-xl bg-white/10 border border-white/20">
                            <p class="text-sm text-white/80">Alamat Fakultas</p>
                            <p class="font-semibold">Jl. Pendidikan No. 45, Bandung</p>
                        </div>
                        <div class="p-4 rounded-xl bg-white/10 border border-white/20">
                            <p class="text-sm text-white/80">Email Admin</p>
                            <p class="font-semibold">admin.skripsi@univ.ac.id</p>
                        </div>
                        <div class="p-4 rounded-xl bg-white/10 border border-white/20">
                            <p class="text-sm text-white/80">Nomor Kontak</p>
                            <p class="font-semibold">(+62) 812-3456-7890</p>
                        </div>
                    </div>
                </div>
                <div class="bg-white text-[var(--abu-gelap)] p-6 rounded-2xl shadow-xl">
                    <h4 class="text-xl font-semibold mb-2">Butuh Bantuan Cepat?</h4>
                    <p class="text-slate-600 mb-4">Kirim pesan langsung ke admin, kami akan merespons dalam 1x24 jam.</p>
                    <form class="space-y-3">
                        <input type="text" placeholder="Nama" class="w-full rounded-lg border border-slate-200 px-4 py-2 focus:border-[var(--biru-medium)] focus:outline-none" />
                        <input type="email" placeholder="Email" class="w-full rounded-lg border border-slate-200 px-4 py-2 focus:border-[var(--biru-medium)] focus:outline-none" />
                        <textarea rows="3" placeholder="Pesan" class="w-full rounded-lg border border-slate-200 px-4 py-2 focus:border-[var(--biru-medium)] focus:outline-none"></textarea>
                        <button type="button" class="w-full py-3 rounded-lg bg-[var(--hijau)] text-white font-semibold hover:bg-emerald-600 transition">Kirim Pesan</button>
                    </form>
                </div>
            </div>
        </section>
    </main>

    <footer class="bg-[var(--abu-gelap)] text-white py-4">
        <div class="max-w-6xl mx-auto px-6 flex flex-wrap justify-between items-center gap-3">
            <p class="text-sm">© 2024 Sistem Skripsi. All rights reserved.</p>
            <div class="flex items-center gap-4 text-sm">
                <a href="#" class="hover:underline">Kebijakan Privasi</a>
                <a href="#" class="hover:underline">Bantuan</a>
            </div>
        </div>
    </footer>
</body>
</html>
