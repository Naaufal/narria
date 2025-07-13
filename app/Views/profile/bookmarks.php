<?= $this->extend('home/layout/main') ?>

<?= $this->section('content') ?>
<div class="min-h-screen bg-gradient-to-b from-purple-50 to-white py-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <!-- Header -->
        <div class="text-center mb-12">
            <h1 class="text-4xl font-fantasy font-bold text-purple-800 mb-4">
                <i class="fas fa-bookmark text-amber-500 mr-3"></i>Bookmark Saya
            </h1>
            <p class="text-gray-600 text-lg">Novel-novel favorit yang telah Anda simpan</p>
        </div>

        <?php if (!empty($bookmarks)): ?>
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
            <?php foreach ($bookmarks as $bookmark): ?>
            <div class="card-fantasy rounded-xl overflow-hidden shadow-lg group">
                <div class="relative">
                    <img src="<?= $bookmark->cover_image ? base_url('uploads/covers/' . $bookmark->cover_image) : 'https://via.placeholder.com/300x400?text=No+Cover' ?>" 
                         alt="<?= esc($bookmark->title) ?>" class="w-full h-64 object-cover group-hover:scale-105 transition-transform duration-300">
                    
                    <div class="absolute top-3 right-3">
                        <span class="bg-amber-500 text-white px-2 py-1 rounded-full text-xs font-bold">
                            <i class="fas fa-bookmark mr-1"></i>Tersimpan
                        </span>
                    </div>
                </div>

                <div class="p-4">
                    <h3 class="font-bold text-lg mb-2 line-clamp-2">
                        <a href="<?= base_url('novel/' . $bookmark->novel_id) ?>" class="text-gray-800 hover:text-purple-600 transition-colors">
                            <?= esc($bookmark->title) ?>
                        </a>
                    </h3>
                    
                    <p class="text-gray-600 text-sm mb-3 flex items-center">
                        <i class="fas fa-user mr-2 text-purple-400"></i>
                        <?= esc($bookmark->authorName) ?>
                    </p>

                    <p class="text-gray-700 text-sm line-clamp-3 mb-4">
                        <?= esc(substr($bookmark->sinopsis, 0, 120)) ?>...
                    </p>

                    <div class="flex justify-between items-center">
                        <span class="text-sm text-gray-500">
                            <i class="fas fa-calendar mr-1"></i>
                            <?= date('d M Y', strtotime($bookmark->created_at)) ?>
                        </span>
                        <a href="<?= base_url('novel/' . $bookmark->novel_id) ?>" 
                           class="text-purple-600 hover:text-purple-800 font-medium text-sm">
                            Baca <i class="fas fa-arrow-right ml-1"></i>
                        </a>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>

        <!-- Pagination -->
        <?php if ($pagination['total'] > 1): ?>
        <div class="mt-12 flex justify-center">
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
            <i class="fas fa-bookmark text-6xl text-gray-400 mb-4"></i>
            <h3 class="text-xl font-semibold text-gray-600 mb-2">Belum ada bookmark</h3>
            <p class="text-gray-500 mb-6">Mulai simpan novel favorit Anda untuk dibaca nanti</p>
            <a href="<?= base_url('novels') ?>" class="gradient-fantasy text-white px-6 py-3 rounded-lg hover:opacity-90 transition-opacity">
                <i class="fas fa-search mr-2"></i>Jelajahi Novel
            </a>
        </div>
        <?php endif; ?>
    </div>
</div>

<?= $this->endSection() ?>