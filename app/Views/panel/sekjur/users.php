<?= $this->extend('panel/base_layout'); ?>

<?= $this->section('content'); ?>
<div class="space-y-8">
  <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-3">
    <div>
      <p class="text-sm text-slate-500">Panel Sekretaris Jurusan</p>
      <h2 class="text-3xl font-semibold text-[var(--abu-gelap)]">Kelola Data Pengguna</h2>
      <p class="text-sm text-slate-600 mt-2">Buat, ubah, dan hapus akun berdasarkan data pengguna yang sudah dimigrasi.</p>
    </div>
    <span class="px-4 py-2 rounded-full bg-[var(--biru-medium)] text-white text-sm font-semibold">Kelola User</span>
  </div>

  <div class="grid lg:grid-cols-3 gap-6">
    <div class="lg:col-span-1 p-6 rounded-2xl bg-white shadow-sm border border-slate-200">
      <h3 class="text-xl font-semibold text-[var(--abu-gelap)]">Form User</h3>
      <p class="text-sm text-slate-600 mt-1">Isi data sesuai kolom tabel migrasi pengguna.</p>

      <form id="userForm" class="mt-4 space-y-4">
        <input type="hidden" id="userId" />
        <div>
          <label for="nama" class="block text-sm font-medium text-slate-700">Nama Lengkap</label>
          <input type="text" id="nama" name="nama" class="mt-1 w-full rounded-lg border border-slate-300 px-3 py-2 focus:outline-none focus:ring-2 focus:ring-[var(--biru-medium)]" required />
        </div>
        <div>
          <label for="username" class="block text-sm font-medium text-slate-700">Username</label>
          <input type="text" id="username" name="username" class="mt-1 w-full rounded-lg border border-slate-300 px-3 py-2 focus:outline-none focus:ring-2 focus:ring-[var(--biru-medium)]" required />
        </div>
        <div>
          <label for="password" class="block text-sm font-medium text-slate-700">Password</label>
          <input type="password" id="password" name="password" class="mt-1 w-full rounded-lg border border-slate-300 px-3 py-2 focus:outline-none focus:ring-2 focus:ring-[var(--biru-medium)]" placeholder="Isi saat membuat atau mengubah password" />
          <p class="text-xs text-slate-500 mt-1">Biarkan kosong saat mengubah data tanpa mengganti kata sandi.</p>
        </div>
        <div>
          <label for="role" class="block text-sm font-medium text-slate-700">Role</label>
          <select id="role" name="role" class="mt-1 w-full rounded-lg border border-slate-300 px-3 py-2 focus:outline-none focus:ring-2 focus:ring-[var(--biru-medium)]" required>
            <option value="" disabled selected>Pilih role</option>
            <?php foreach (($roleOptions ?? []) as $option): ?>
              <option value="<?= esc($option['value']); ?>"><?= esc($option['label']); ?></option>
            <?php endforeach; ?>
          </select>
        </div>
        <div class="flex items-center gap-3">
          <button type="submit" class="px-4 py-2 rounded-lg bg-[var(--biru-medium)] text-white font-semibold hover:bg-[var(--biru-tua)] transition" id="submitBtn">Simpan User</button>
          <button type="button" id="resetBtn" class="px-4 py-2 rounded-lg border border-slate-300 text-slate-700 hover:bg-slate-50 transition">Reset</button>
        </div>
        <p id="formFeedback" class="text-sm mt-2"></p>
      </form>
    </div>

    <div class="lg:col-span-2 space-y-4">
      <div class="p-6 rounded-2xl bg-white shadow-sm border border-slate-200">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-3 mb-4">
          <div>
            <h3 class="text-xl font-semibold text-[var(--abu-gelap)]">Daftar User</h3>
            <p class="text-sm text-slate-600">Tabel responsif dengan pencarian dan pagination (10 data per halaman).</p>
          </div>
          <div class="relative w-full md:w-72">
            <input type="text" id="searchInput" placeholder="Cari nama, username, atau role" class="w-full rounded-lg border border-slate-300 px-3 py-2 pl-10 focus:outline-none focus:ring-2 focus:ring-[var(--biru-medium)]" />
            <span class="absolute left-3 top-2.5 text-slate-400">
              <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                <path fill-rule="evenodd" d="M12.9 14.32a6 6 0 111.414-1.414l3.387 3.387a1 1 0 01-1.414 1.414l-3.387-3.387zM14 8a5 5 0 11-10 0 5 5 0 0110 0z" clip-rule="evenodd" />
              </svg>
            </span>
          </div>
        </div>

        <div class="overflow-x-auto border border-slate-200 rounded-xl">
          <table class="min-w-full divide-y divide-slate-200">
            <thead class="bg-slate-50">
              <tr>
                <th class="px-4 py-3 text-left text-xs font-semibold text-slate-600 uppercase tracking-wider">Nama</th>
                <th class="px-4 py-3 text-left text-xs font-semibold text-slate-600 uppercase tracking-wider">Username</th>
                <th class="px-4 py-3 text-left text-xs font-semibold text-slate-600 uppercase tracking-wider">Role</th>
                <th class="px-4 py-3 text-left text-xs font-semibold text-slate-600 uppercase tracking-wider">Dibuat</th>
                <th class="px-4 py-3 text-right text-xs font-semibold text-slate-600 uppercase tracking-wider">Aksi</th>
              </tr>
            </thead>
            <tbody id="userTableBody" class="divide-y divide-slate-200 bg-white">
              <tr>
                <td colspan="5" class="px-4 py-4 text-center text-sm text-slate-500">Memuat data...</td>
              </tr>
            </tbody>
          </table>
        </div>

        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-3 mt-4">
          <p id="tableInfo" class="text-sm text-slate-600">Menampilkan 0 data</p>
          <div class="flex items-center gap-2">
            <button id="prevPage" class="px-3 py-2 rounded-lg border border-slate-300 text-slate-700 hover:bg-slate-50 disabled:opacity-50 disabled:cursor-not-allowed">Sebelumnya</button>
            <span id="pageIndicator" class="text-sm text-slate-700">Halaman 1</span>
            <button id="nextPage" class="px-3 py-2 rounded-lg border border-slate-300 text-slate-700 hover:bg-slate-50 disabled:opacity-50 disabled:cursor-not-allowed">Berikutnya</button>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<script>
  const tableBody = document.getElementById('userTableBody');
  const searchInput = document.getElementById('searchInput');
  const tableInfo = document.getElementById('tableInfo');
  const prevBtn = document.getElementById('prevPage');
  const nextBtn = document.getElementById('nextPage');
  const pageIndicator = document.getElementById('pageIndicator');
  const form = document.getElementById('userForm');
  const resetBtn = document.getElementById('resetBtn');
  const formFeedback = document.getElementById('formFeedback');
  const submitBtn = document.getElementById('submitBtn');
  const rowsPerPage = 10;

  let users = [];
  let currentPage = 1;
  let filteredUsers = [];

  const roleLabels = {
    mahasiswa: 'Mahasiswa',
    dosen: 'Dosen Pembimbing',
    kaprodi: 'Ketua Program Studi',
    sekjur: 'Sekretaris Jurusan',
  };

  const formatDateTime = (value) => {
    if (!value) return '-';
    const date = new Date(value);
    return new Intl.DateTimeFormat('id-ID', {
      year: 'numeric',
      month: 'long',
      day: 'numeric',
      hour: '2-digit',
      minute: '2-digit',
    }).format(date);
  };

  const renderTable = () => {
    const query = searchInput.value.toLowerCase();
    filteredUsers = users.filter((user) => {
      const combined = `${user.nama} ${user.username} ${user.role}`.toLowerCase();
      return combined.includes(query);
    });

    const totalPages = Math.max(1, Math.ceil(filteredUsers.length / rowsPerPage));
    currentPage = Math.min(currentPage, totalPages);
    const start = (currentPage - 1) * rowsPerPage;
    const pageItems = filteredUsers.slice(start, start + rowsPerPage);

    tableBody.innerHTML = '';

    if (pageItems.length === 0) {
      tableBody.innerHTML = '<tr><td colspan="5" class="px-4 py-4 text-center text-sm text-slate-500">Data tidak ditemukan.</td></tr>';
    } else {
      pageItems.forEach((user) => {
        const row = document.createElement('tr');
        row.innerHTML = `
          <td class="px-4 py-3 whitespace-nowrap">
            <p class="font-semibold text-[var(--abu-gelap)]">${user.nama}</p>
            <p class="text-sm text-slate-600">ID: ${user.id}</p>
          </td>
          <td class="px-4 py-3 whitespace-nowrap">${user.username}</td>
          <td class="px-4 py-3 whitespace-nowrap">
            <span class="px-3 py-1 rounded-full text-xs font-semibold bg-[var(--abu-muda)] text-[var(--biru-tua)]">${roleLabels[user.role] || user.role}</span>
          </td>
          <td class="px-4 py-3 whitespace-nowrap text-sm text-slate-600">${formatDateTime(user.created_at)}</td>
          <td class="px-4 py-3 whitespace-nowrap text-right space-x-2">
            <button class="px-3 py-2 rounded-lg border border-slate-300 text-slate-700 hover:bg-slate-50" data-action="edit" data-id="${user.id}">Edit</button>
            <button class="px-3 py-2 rounded-lg bg-red-500 text-white hover:bg-red-600" data-action="delete" data-id="${user.id}">Hapus</button>
          </td>`;
        tableBody.appendChild(row);
      });
    }

    pageIndicator.textContent = `Halaman ${currentPage} / ${totalPages}`;
    tableInfo.textContent = `Menampilkan ${pageItems.length} dari ${filteredUsers.length} data (batas ${rowsPerPage} baris per halaman).`;
    prevBtn.disabled = currentPage === 1;
    nextBtn.disabled = currentPage === totalPages || filteredUsers.length === 0;
  };

  const fetchUsers = async () => {
    tableBody.innerHTML = '<tr><td colspan="5" class="px-4 py-4 text-center text-sm text-slate-500">Memuat data...</td></tr>';
    try {
      const response = await fetch('/Sekjur/users/data');
      users = await response.json();
      currentPage = 1;
      renderTable();
    } catch (error) {
      tableBody.innerHTML = '<tr><td colspan="5" class="px-4 py-4 text-center text-sm text-red-500">Gagal memuat data.</td></tr>';
    }
  };

  const resetForm = () => {
    form.reset();
    document.getElementById('userId').value = '';
    submitBtn.textContent = 'Simpan User';
    formFeedback.textContent = '';
    formFeedback.className = 'text-sm mt-2';
  };

  const handleSubmit = async (event) => {
    event.preventDefault();
    formFeedback.textContent = '';

    const id = document.getElementById('userId').value;
    const nama = document.getElementById('nama').value.trim();
    const username = document.getElementById('username').value.trim();
    const password = document.getElementById('password').value.trim();
    const role = document.getElementById('role').value;

    if (!nama || !username || !role) {
      formFeedback.textContent = 'Nama, username, dan role wajib diisi.';
      formFeedback.className = 'text-sm mt-2 text-red-600';
      return;
    }

    const payload = { nama, username, role };
    if (password) {
      payload.password = password;
    }

    const method = id ? 'PUT' : 'POST';
    const url = id ? `/Sekjur/users/${id}` : '/Sekjur/users';

    try {
      const response = await fetch(url, {
        method,
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify(payload),
      });
      if (!response.ok) {
        throw new Error('Gagal menyimpan data');
      }
      await fetchUsers();
      resetForm();
      formFeedback.textContent = id ? 'Data berhasil diperbarui.' : 'Data berhasil ditambahkan.';
      formFeedback.className = 'text-sm mt-2 text-green-600';
    } catch (error) {
      formFeedback.textContent = 'Terjadi kesalahan saat menyimpan data.';
      formFeedback.className = 'text-sm mt-2 text-red-600';
    }
  };

  const handleTableClick = async (event) => {
    const action = event.target.getAttribute('data-action');
    const id = event.target.getAttribute('data-id');
    if (!action || !id) return;

    if (action === 'edit') {
      const user = users.find((item) => String(item.id) === String(id));
      if (!user) return;
      document.getElementById('userId').value = user.id;
      document.getElementById('nama').value = user.nama;
      document.getElementById('username').value = user.username;
      document.getElementById('password').value = '';
      document.getElementById('role').value = user.role;
      submitBtn.textContent = 'Perbarui User';
      formFeedback.textContent = 'Mode ubah aktif. Simpan untuk memperbarui data.';
      formFeedback.className = 'text-sm mt-2 text-[var(--biru-medium)]';
    }

    if (action === 'delete') {
      if (!confirm('Yakin ingin menghapus data ini?')) return;
      try {
        const response = await fetch(`/Sekjur/users/${id}`, { method: 'DELETE' });
        if (!response.ok) {
          throw new Error('Gagal menghapus data');
        }
        await fetchUsers();
        resetForm();
        formFeedback.textContent = 'Data berhasil dihapus.';
        formFeedback.className = 'text-sm mt-2 text-green-600';
      } catch (error) {
        formFeedback.textContent = 'Terjadi kesalahan saat menghapus data.';
        formFeedback.className = 'text-sm mt-2 text-red-600';
      }
    }
  };

  searchInput.addEventListener('input', () => {
    currentPage = 1;
    renderTable();
  });

  prevBtn.addEventListener('click', () => {
    if (currentPage > 1) {
      currentPage--;
      renderTable();
    }
  });

  nextBtn.addEventListener('click', () => {
    const totalPages = Math.max(1, Math.ceil(filteredUsers.length / rowsPerPage));
    if (currentPage < totalPages) {
      currentPage++;
      renderTable();
    }
  });

  tableBody.addEventListener('click', handleTableClick);
  form.addEventListener('submit', handleSubmit);
  resetBtn.addEventListener('click', resetForm);

  fetchUsers();
</script>
<?= $this->endSection(); ?>
