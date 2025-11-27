<?= $this->extend('panel/base_layout'); ?>

<?= $this->section('content'); ?>
<div class="space-y-8">
  <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-3">
    <div>
      <p class="text-sm text-slate-500">Dashboard Kaprodi</p>
      <h2 class="text-3xl font-semibold text-[var(--abu-gelap)]">Pantau capaian program studi</h2>
    </div>
    <span class="px-4 py-2 rounded-full bg-[var(--biru-medium)] text-white text-sm font-semibold">Kaprodi</span>
  </div>

  <div class="grid md:grid-cols-4 gap-4">
    <?php foreach (($widgets ?? []) as $widget): ?>
      <div class="p-4 rounded-2xl bg-white shadow-sm border border-slate-100">
        <p class="text-sm text-slate-500"><?= esc($widget['title']); ?></p>
        <h3 class="text-2xl font-semibold text-[var(--biru-tua)] mt-2"><?= esc($widget['highlight']); ?></h3>
        <p class="text-sm text-slate-600 mt-2 leading-relaxed"><?= esc($widget['description']); ?></p>
      </div>
    <?php endforeach; ?>
  </div>

  <div class="grid md:grid-cols-2 gap-6">
    <?php foreach (($sections ?? []) as $section): ?>
      <div class="p-6 rounded-2xl bg-white shadow-sm border border-slate-100">
        <div class="flex items-center justify-between mb-3">
          <h3 class="text-xl font-semibold text-[var(--abu-gelap)]"><?= esc($section['title']); ?></h3>
          <span class="px-3 py-1 text-xs rounded-full bg-[var(--abu-muda)] text-[var(--biru-tua)]">Section</span>
        </div>
        <p class="text-sm text-slate-600 leading-relaxed"><?= esc($section['description']); ?></p>
        <?php if (! empty($section['items'] ?? [])): ?>
          <ul class="mt-3 space-y-2 text-sm text-slate-700 list-disc list-inside">
            <?php foreach ($section['items'] as $item): ?>
              <li><?= esc($item); ?></li>
            <?php endforeach; ?>
          </ul>
        <?php endif; ?>
      </div>
    <?php endforeach; ?>
  </div>
</div>
<?= $this->endSection(); ?>
