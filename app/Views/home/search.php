<?= $this->extend('home/layout/main') ?>

<?= $this->section('content') ?>

<div class="min-h-screen bg-gradient-to-b from-purple-50 to-white py-12">
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    
    <!-- Search Header -->
    <div class="text-center mb-8">
        <h1 class="text-4xl font-fantasy font-bold text-purple-800 mb-4">
            <i class="fas fa-search text-amber-500 mr-3"></i>Pencarian Novel
        </h1>
        <?php if ($keyword): ?>
        <p class="text-gray-600 text-lg">
            Hasil pencarian untuk: <strong>"<?= esc($keyword) ?>"</strong>
            <?php if ($totalResults > 0): ?>
            <span class="text-purple-600">(<?= $totalResults ?> novel ditemukan)</span>
            <?php endif; ?>
        </p>
        <?php else: ?>
        <p class="text-gray-600 text-lg">Temukan novel fantasi favorit Anda</p>
        <?php endif; ?>
    </div>

    <!-- Advanced Search Form -->
    <div class="bg-white rounded-xl p-6 mb-8 shadow-lg border-0">
        <form action="<?= base_url('search') ?>" method="GET" class="space-y-6">
            
            <!-- Main Search Field -->
            <div class="relative">
                <label class="block text-sm font-medium text-gray-700 mb-3 flex items-center gap-2">
                    <i class="fas fa-search text-purple-500"></i>
                    Kata Kunci
                </label>
                <div class="relative">
                    <i class="fas fa-search absolute left-4 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                    <input type="text" name="q" value="<?= esc($keyword) ?>" 
                        placeholder="Judul, penulis, atau deskripsi..."
                        class="w-full pl-12 pr-4 py-4 text-lg border border-gray-200 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-purple-500 transition-all">
                </div>
            </div>

            <!-- Advanced Filters Toggle -->
            <div class="border-t border-gray-100 pt-4">
                <button type="button" onclick="toggleFilters()" 
                        class="w-full flex items-center justify-between p-3 bg-gray-50 hover:bg-gray-100 rounded-lg transition-colors">
                    <span class="flex items-center gap-2 font-medium text-gray-700">
                        <i class="fas fa-filter text-purple-500"></i>
                        Filter Lanjutan
                    </span>
                    <i class="fas fa-chevron-down text-gray-500 transition-transform" id="filter-icon"></i>
                </button>
                
                <!-- Filters Content -->
                <div id="advanced-filters" class="hidden mt-4 space-y-4">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <!-- Category Filter -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2 flex items-center gap-2">
                                <i class="fas fa-tags text-purple-500"></i>
                                Kategori
                            </label>
                            <select name="categories[]" multiple 
                                    class="w-full px-4 py-3 border border-gray-200 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-purple-500 transition-colors">
                                <?php foreach ($categories as $category): ?>
                                <option value="<?= $category->id ?>" <?= in_array($category->id, $selectedCategories) ? 'selected' : '' ?>>
                                    <?= esc($category->name) ?>
                                </option>
                                <?php endforeach; ?>
                            </select>
                            <p class="text-xs text-gray-500 mt-1">Tahan Ctrl untuk pilih multiple</p>
                        </div>
                        
                        <!-- Sort -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2 flex items-center gap-2">
                                <i class="fas fa-sort text-purple-500"></i>
                                Urutkan Berdasarkan
                            </label>
                            <select name="sort" 
                                    class="w-full px-4 py-3 border border-gray-200 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-purple-500 transition-colors">
                                <option value="relevance">Relevansi</option>
                                <option value="latest">Terbaru</option>
                                <option value="popular">Terpopuler</option>
                                <option value="title">Judul A-Z</option>
                                <option value="views">Paling Banyak Dibaca</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Action Buttons -->
            <div class="flex flex-col sm:flex-row gap-3 pt-2">
                <button type="submit" 
                        class="flex-1 bg-gradient-to-r from-purple-600 to-pink-600 hover:from-purple-700 hover:to-pink-700 text-white font-semibold py-3 px-6 rounded-lg transition-all shadow-md hover:shadow-lg">
                    <i class="fas fa-search mr-2"></i>
                    Cari Novel
                </button>
                
                <a href="<?= base_url('search') ?>" 
                class="px-6 py-3 border border-gray-300 hover:bg-gray-50 text-gray-700 font-semibold rounded-lg transition-colors text-center">
                    <i class="fas fa-times mr-2"></i>
                    Reset
                </a>
            </div>
            
        </form>
    </div>


    <!-- Search Results -->
    <?php if ($keyword || !empty($selectedCategories)): ?>
        <?php if (!empty($novels)): ?>
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
            <?php foreach ($novels as $novel): ?>
            <div class="card-fantasy rounded-xl overflow-hidden shadow-lg group">
                <div class="relative">
                    <img src="<?= $novel->cover_image ? base_url('uploads/covers/' . $novel->cover_image) : 'https://via.placeholder.com/300x400?text=No+Cover' ?>" 
                         alt="<?= esc($novel->title) ?>" class="w-full h-64 object-cover group-hover:scale-105 transition-transform duration-300">
                    
                    <div class="absolute top-3 right-3">
                        <span class="bg-purple-500 text-white px-2 py-1 rounded-full text-xs font-bold shadow-lg">
                            <i class="fas fa-eye mr-1"></i><?= number_format($novel->views) ?>
                        </span>
                    </div>
                    
                    <div class="absolute top-3 left-3">
                        <span class="<?= $novel->status === 'completed' ? 'bg-green-500' : ($novel->status === 'ongoing' ? 'bg-blue-500' : 'bg-yellow-500') ?> text-white px-2 py-1 rounded-full text-xs font-bold shadow-lg">
                            <?= ucfirst($novel->status) ?>
                        </span>
                    </div>
                    
                    <div class="absolute inset-0 bg-gradient-to-t from-black/40 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                </div>
                
                <div class="p-4">
                    <h3 class="font-bold text-lg mb-2 line-clamp-2">
                        <a href="<?= base_url('novel/' . $novel->id) ?>" class="text-gray-800 hover:text-purple-600 transition-colors">
                            <?= esc($novel->title) ?>
                        </a>
                    </h3>
                    
                    <p class="text-gray-600 text-sm mb-3 flex items-center">
                        <i class="fas fa-user mr-2 text-purple-400"></i>oleh <?= esc($novel->authorName) ?>
                    </p>
                    
                    <div class="flex flex-wrap gap-1 mb-3">
                        <?php foreach (array_slice($novel->categoryNames, 0, 2) as $category): ?>
                        <span class="bg-purple-100 text-purple-800 px-2 py-1 rounded-full text-xs">
                            <?= esc($category) ?>
                        </span>
                        <?php endforeach; ?>
                    </div>
                    
                    <p class="text-gray-700 text-sm line-clamp-3 mb-4"><?= esc(substr($novel->sinopsis, 0, 100)) ?>...</p>
                    
                    <div class="flex items-center justify-between">
                        <span class="text-xs text-gray-500">
                            <i class="fas fa-calendar mr-1"></i><?= date('d M Y', strtotime($novel->created_at)) ?>
                        </span>
                        <a href="<?= base_url('novel/' . $novel->id) ?>" class="text-purple-600 hover:text-purple-800 font-medium text-sm">
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
                <a href="?page=<?= $i ?>&q=<?= urlencode($keyword) ?>" 
                   class="px-4 py-2 rounded-lg <?= $i === $pagination['current'] ? 'gradient-fantasy text-white' : 'bg-white text-gray-700 hover:bg-purple-50' ?> transition-colors">
                    <?= $i ?>
                </a>
                <?php endfor; ?>
            </nav>
        </div>
        <?php endif; ?>

        <?php else: ?>
        <!-- No Results -->
        <div class="card-fantasy rounded-xl p-12 text-center shadow-lg">
            <div class="text-6xl text-gray-400 mb-6">
                <i class="fas fa-search"></i>
            </div>
            <h3 class="text-2xl font-bold text-gray-800 mb-4">Novel Tidak Ditemukan</h3>
            <p class="text-gray-600 mb-6 max-w-md mx-auto">
                Maaf, tidak ada novel yang sesuai dengan pencarian Anda. 
                Coba gunakan kata kunci yang berbeda atau jelajahi kategori lain.
            </p>
            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                <a href="<?= base_url('novels') ?>" class="gradient-fantasy hover:opacity-90 text-white font-bold py-3 px-6 rounded-lg transition duration-300">
                    <i class="fas fa-book mr-2"></i>Lihat Semua Novel
                </a>
                <a href="<?= base_url('categories') ?>" class="bg-purple-100 hover:bg-purple-200 text-purple-800 font-bold py-3 px-6 rounded-lg transition duration-300">
                    <i class="fas fa-tags mr-2"></i>Jelajahi Kategori
                </a>
            </div>
        </div>
        <?php endif; ?>
    <?php else: ?>
    <!-- Popular Searches / Suggestions -->
    <div class="card-fantasy rounded-xl p-8 text-center shadow-lg">
        <h3 class="text-2xl font-fantasy font-bold text-purple-800 mb-6">
            <i class="fas fa-fire text-amber-500 mr-2"></i>Pencarian Populer
        </h3>
        <div class="flex flex-wrap justify-center gap-3">
            <a href="<?= base_url('search?q=romance') ?>" class="bg-purple-100 hover:bg-purple-200 text-purple-800 px-4 py-2 rounded-full text-sm font-medium transition-colors">
                Romance
            </a>
            <a href="<?= base_url('search?q=fantasy') ?>" class="bg-purple-100 hover:bg-purple-200 text-purple-800 px-4 py-2 rounded-full text-sm font-medium transition-colors">
                Fantasy
            </a>
            <a href="<?= base_url('search?q=action') ?>" class="bg-purple-100 hover:bg-purple-200 text-purple-800 px-4 py-2 rounded-full text-sm font-medium transition-colors">
                Action
            </a>
            <a href="<?= base_url('search?q=drama') ?>" class="bg-purple-100 hover:bg-purple-200 text-purple-800 px-4 py-2 rounded-full text-sm font-medium transition-colors">
                Drama
            </a>
            <a href="<?= base_url('search?q=mystery') ?>" class="bg-purple-100 hover:bg-purple-200 text-purple-800 px-4 py-2 rounded-full text-sm font-medium transition-colors">
                Mystery
            </a>
        </div>
    </div>
    <?php endif; ?>
</div>
</div>

<style>
.line-clamp-2 {
display: -webkit-box;
-webkit-line-clamp: 2;
-webkit-box-orient: vertical;
overflow: hidden;
}

.line-clamp-3 {
display: -webkit-box;
-webkit-line-clamp: 3;
-webkit-box-orient: vertical;
overflow: hidden;
}
</style>

<script>
function toggleFilters() {
    const filters = document.getElementById('advanced-filters');
    const icon = document.getElementById('filter-icon');
    
    if (filters.classList.contains('hidden')) {
        filters.classList.remove('hidden');
        icon.style.transform = 'rotate(180deg)';
    } else {
        filters.classList.add('hidden');
        icon.style.transform = 'rotate(0deg)';
    }
}
</script>

<?= $this->endSection() ?>
