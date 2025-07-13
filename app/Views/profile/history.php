<?= $this->extend('home/layout/main') ?>

<?= $this->section('content') ?>
<div class="min-h-screen bg-gradient-to-b from-purple-50 to-white py-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <!-- Header -->
        <div class="text-center mb-12">
            <h1 class="text-4xl font-fantasy font-bold text-purple-800 mb-4">
                <i class="fas fa-history text-amber-500 mr-3"></i>Riwayat Baca
            </h1>
            <p class="text-gray-600 text-lg">Lacak progress membaca Anda</p>
        </div>

        <!-- Reading Stats -->
        <?php if (isset($readingStats)): ?>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
            <div class="card-fantasy rounded-xl p-6 text-center">
                <div class="text-3xl font-bold text-blue-600 mb-2"><?= $readingStats['unique_novels'] ?></div>
                <div class="text-gray-600 font-medium">Novel Dibaca</div>
                <i class="fas fa-book text-2xl text-blue-400 mt-2"></i>
            </div>
            <div class="card-fantasy rounded-xl p-6 text-center">
                <div class="text-3xl font-bold text-green-600 mb-2"><?= $readingStats['total_chapters'] ?></div>
                <div class="text-gray-600 font-medium">Total Chapter</div>
                <i class="fas fa-file-alt text-2xl text-green-400 mt-2"></i>
            </div>
            <div class="card-fantasy rounded-xl p-6 text-center">
                <div class="text-3xl font-bold text-purple-600 mb-2"><?= $readingStats['recent_activity'] ?></div>
                <div class="text-gray-600 font-medium">Aktivitas 7 Hari</div>
                <i class="fas fa-chart-line text-2xl text-purple-400 mt-2"></i>
            </div>
        </div>
        <?php endif; ?>

        <!-- Continue Reading -->
        <?php if (!empty($continueReading)): ?>
        <div class="card-fantasy rounded-xl p-6 mb-8">
            <h2 class="text-xl font-bold text-gray-800 mb-4 flex items-center">
                <i class="fas fa-play-circle text-green-500 mr-2"></i>Lanjutkan Membaca
            </h2>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                <?php foreach (array_slice($continueReading, 0, 3) as $reading): ?>
                <div class="bg-white rounded-lg border border-gray-200 p-4 hover:shadow-md transition-shadow">
                    <div class="flex items-center space-x-3">
                        <img src="<?= $reading->cover_image ? base_url('uploads/covers/' . $reading->cover_image) : 'https://via.placeholder.com/60x80?text=No+Cover' ?>" 
                            alt="<?= esc($reading->title) ?>" class="w-12 h-16 object-cover rounded">
                        <div class="flex-1 min-w-0">
                            <h3 class="font-semibold text-sm text-gray-800 truncate">
                                <?= esc($reading->title) ?>
                            </h3>
                            <p class="text-xs text-gray-600 mb-1">
                                Chapter <?= $reading->chapter_number ?>: <?= esc($reading->chapter_title) ?>
                            </p>
                            <a href="<?= base_url('novel/' . $reading->novel_id . '/chapter/' . $reading->chapter_id) ?>" 
                            class="text-xs text-purple-600 hover:text-purple-800 font-medium">
                                Lanjutkan <i class="fas fa-arrow-right ml-1"></i>
                            </a>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
        <?php endif; ?>

        <!-- Reading History -->
        <?php if (!empty($history)): ?>
        <div class="card-fantasy rounded-xl p-6">
            <h2 class="text-xl font-bold text-gray-800 mb-6">Riwayat Lengkap</h2>
            <div class="space-y-4">
                <?php foreach ($history as $item): ?>
                <div class="bg-white rounded-lg border border-gray-200 p-4 hover:shadow-md transition-shadow">
                    <div class="flex items-start space-x-4">
                        <img src="<?= $item->cover_image ? base_url('uploads/covers/' . $item->cover_image) : 'https://via.placeholder.com/60x80?text=No+Cover' ?>" 
                            alt="<?= esc($item->title) ?>" class="w-16 h-20 object-cover rounded">
                        
                        <div class="flex-1 min-w-0">
                            <h3 class="font-bold text-lg mb-1">
                                <a href="<?= base_url('novel/' . $item->novel_id) ?>" class="text-gray-800 hover:text-purple-600 transition-colors">
                                    <?= esc($item->title) ?>
                                </a>
                            </h3>
                            
                            <p class="text-gray-600 text-sm mb-2 flex items-center">
                                <i class="fas fa-user mr-2 text-purple-400"></i>
                                <?= esc($item->authorName) ?>
                            </p>

                            <div class="flex items-center space-x-4 text-sm text-gray-600 mb-2">
                                <span>
                                    <i class="fas fa-file-alt mr-1 text-blue-400"></i>
                                    Chapter <?= $item->chapter_number ?>: <?= esc($item->chapter_title) ?>
                                </span>
                                <span>
                                    <i class="fas fa-clock mr-1 text-green-400"></i>
                                    <?= date('d M Y, H:i', strtotime($item->updated_at)) ?>
                                </span>
                            </div>

                            <div class="flex items-center justify-between">
                                <span class="text-xs text-gray-500">
                                    Terakhir dibaca: <?= date('d M Y', strtotime($item->updated_at)) ?>
                                </span>
                                <a href="<?= base_url('novel/' . $item->novel_id . '/chapter/' . $item->chapter_id) ?>" 
                                class="text-purple-600 hover:text-purple-800 font-medium text-sm">
                                    Baca Lagi <i class="fas fa-arrow-right ml-1"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        </div>

        <!-- Pagination -->
        <?php if ($pagination['total'] > 1): ?>
        <div class="mt-8 flex justify-center">
            <nav class="flex space-x-2">
                <?php for ($i = 1; $i <= $pagination['total']; $i++): ?>
                <a href="?page=<?= $i ?>" 
                   class="px-4 py-2 rounded-lg <?= $i === $pagination['current'] ? 'gradient-fantasy text-white' : 'bg-white text-gray-700 hover:bg-purple-50' ?> transition-colors">
                    <?= $i ?>
                </a>
                <?php endfor; ?>
            </nav>
        </div>
        <?php endif; ?>

        <?php else: ?>
        <div class="text-center py-16">
            <i class="fas fa-history text-6xl text-gray-400 mb-4"></i>
            <h3 class="text-xl font-semibold text-gray-600 mb-2">Belum ada riwayat baca</h3>
            <p class="text-gray-500 mb-6">Mulai membaca novel untuk melihat riwayat Anda</p>
            <a href="<?= base_url('novels') ?>" class="gradient-fantasy text-white px-6 py-3 rounded-lg hover:opacity-90 transition-opacity">
                <i class="fas fa-search mr-2"></i>Jelajahi Novel
            </a>
        </div>
        <?php endif; ?>
    </div>
</div>

<style>
.card-fantasy {
    background: linear-gradient(135deg, #ffffff 0%, #f8fafc 100%);
    border: 1px solid #e2e8f0;
}

.gradient-fantasy {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
}
</style>

<?= $this->endSection() ?>
