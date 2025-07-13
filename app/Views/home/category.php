<?= $this->extend('home/layout/main') ?>

<?= $this->section('content') ?>
<!-- Category Hero Section -->
<section class="gradient-fantasy py-20 relative overflow-hidden">
    <div class="absolute inset-0 bg-black/20"></div>
    <div class="absolute inset-0">
        <div class="absolute top-10 left-10 w-20 h-20 bg-amber-400/20 rounded-full animate-pulse"></div>
        <div class="absolute top-32 right-20 w-16 h-16 bg-purple-400/20 rounded-full animate-pulse delay-1000"></div>
        <div class="absolute bottom-20 left-1/3 w-12 h-12 bg-pink-400/20 rounded-full animate-pulse delay-500"></div>
    </div>
    
    <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Breadcrumb -->
        <nav class="mb-8">
            <ol class="flex items-center space-x-2 text-purple-200">
                <li><a href="<?= base_url() ?>" class="hover:text-amber-400 transition-colors">Beranda</a></li>
                <li><i class="fas fa-chevron-right text-xs"></i></li>
                <li><a href="<?= base_url('categories') ?>" class="hover:text-amber-400 transition-colors">Kategori</a></li>
                <li><i class="fas fa-chevron-right text-xs"></i></li>
                <li class="text-amber-400 font-medium"><?= esc($category->name) ?></li>
            </ol>
        </nav>

        <div class="text-center">
            <div class="mb-6">
                <?php
                $icons = [
                    'romance' => 'fas fa-heart',
                    'fantasy' => 'fas fa-magic',
                    'action' => 'fas fa-fist-raised',
                    'drama' => 'fas fa-theater-masks',
                    'comedy' => 'fas fa-laugh',
                    'horror' => 'fas fa-ghost',
                    'mystery' => 'fas fa-search',
                    'adventure' => 'fas fa-compass',
                    'sci-fi' => 'fas fa-rocket',
                    'slice of life' => 'fas fa-coffee'
                ];
                $iconClass = $icons[strtolower($category->name)] ?? 'fas fa-book';
                ?>
                <div class="w-20 h-20 mx-auto bg-white/20 rounded-full flex items-center justify-center mb-4">
                    <i class="<?= $iconClass ?> text-4xl text-amber-400"></i>
                </div>
            </div>
            
            <h1 class="text-5xl md:text-6xl font-fantasy font-bold text-white mb-6 text-shadow">
                <?= esc($category->name) ?>
            </h1>
            
            <?php if (!empty($category->description)): ?>
            <p class="text-xl text-purple-100 max-w-3xl mx-auto leading-relaxed mb-6">
                <?= esc($category->description) ?>
            </p>
            <?php endif; ?>
            
            <div class="flex items-center justify-center space-x-6 text-purple-200">
                <div class="flex items-center">
                    <i class="fas fa-book mr-2 text-amber-400"></i>
                    <span><?= isset($novels) ? count($novels) : 0 ?> Novel</span>
                </div>
                <div class="flex items-center">
                    <i class="fas fa-users mr-2 text-amber-400"></i>
                    <span>Ribuan Pembaca</span>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Filter & Sort Section -->
<section class="bg-white border-b border-gray-200 sticky top-16 z-40">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4">
        <div class="flex flex-col md:flex-row justify-between items-center space-y-4 md:space-y-0">
            <!-- Results Info -->
            <div class="flex items-center text-gray-600">
                <i class="fas fa-filter mr-2 text-purple-500"></i>
                <span>Menampilkan novel dalam kategori <strong class="text-purple-600"><?= esc($category->name) ?></strong></span>
            </div>

            <!-- Sort Options -->
            <div class="flex items-center space-x-4">
                <label class="text-gray-600 font-medium">Urutkan:</label>
                <select id="sortSelect" class="border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                    <option value="latest" <?= ($currentSort ?? 'latest') === 'latest' ? 'selected' : '' ?>>Terbaru</option>
                    <option value="popular" <?= ($currentSort ?? '') === 'popular' ? 'selected' : '' ?>>Terpopuler</option>
                    <option value="title" <?= ($currentSort ?? '') === 'title' ? 'selected' : '' ?>>Judul A-Z</option>
                    <option value="views" <?= ($currentSort ?? '') === 'views' ? 'selected' : '' ?>>Paling Banyak Dibaca</option>
                </select>
            </div>
        </div>
    </div>
</section>

<!-- Novels Grid -->
<section class="py-12 bg-gradient-to-b from-slate-50 to-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <?php if (!empty($novels)): ?>
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
            <?php foreach ($novels as $novel): ?>
            <div class="card-fantasy rounded-xl overflow-hidden group">
                <!-- Novel Cover -->
                <div class="relative aspect-[3/4] overflow-hidden">
                    <?php if (!empty($novel->cover_image)): ?>
                    <img src="<?= base_url('uploads/covers/' . $novel->cover_image) ?>" 
                         alt="<?= esc($novel->title) ?>" 
                         class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
                    <?php else: ?>
                    <div class="w-full h-full gradient-fantasy flex items-center justify-center">
                        <i class="fas fa-book text-6xl text-white/50"></i>
                    </div>
                    <?php endif; ?>
                    
                    <!-- Overlay -->
                    <div class="absolute inset-0 bg-black/0 group-hover:bg-black/20 transition-colors duration-300"></div>
                    
                    <!-- Quick Actions -->
                    <div class="absolute top-3 right-3 opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                        <button class="w-8 h-8 bg-white/90 rounded-full flex items-center justify-center text-red-500 hover:bg-white transition-colors">
                            <i class="fas fa-heart text-sm"></i>
                        </button>
                    </div>
                    
                    <!-- Status Badge -->
                    <?php if (!empty($novel->status)): ?>
                    <div class="absolute top-3 left-3">
                        <span class="px-2 py-1 bg-<?= $novel->status === 'completed' ? 'green' : ($novel->status === 'ongoing' ? 'blue' : 'yellow') ?>-500 text-white text-xs rounded-full font-medium">
                            <?= ucfirst($novel->status) ?>
                        </span>
                    </div>
                    <?php endif; ?>
                </div>

                <!-- Novel Info -->
                <div class="p-4">
                    <h3 class="font-bold text-gray-800 mb-2 line-clamp-2 group-hover:text-purple-600 transition-colors">
                        <a href="<?= base_url('novel/' . $novel->id) ?>" class="hover:underline">
                            <?= esc($novel->title) ?>
                        </a>
                    </h3>
                    
                    <p class="text-sm text-gray-600 mb-3">
                        <i class="fas fa-user mr-1"></i>
                        <?= esc($novel->authorName ?? 'Unknown') ?>
                    </p>
                    
                    <?php if (!empty($novel->sinopsis)): ?>
                    <p class="text-sm text-gray-600 mb-3 line-clamp-3">
                        <?= esc(substr($novel->sinopsis, 0, 120)) ?><?= strlen($novel->sinopsis) > 120 ? '...' : '' ?>
                    </p>
                    <?php endif; ?>
                    
                    <!-- Stats -->
                    <div class="flex items-center justify-between text-xs text-gray-500 mb-4">
                        <div class="flex items-center">
                            <i class="fas fa-eye mr-1"></i>
                            <span><?= number_format($novel->views ?? 0) ?></span>
                        </div>
                        <?php if (!empty($novel->average_rating)): ?>
                        <div class="flex items-center">
                            <i class="fas fa-star text-yellow-400 mr-1"></i>
                            <span><?= number_format($novel->average_rating, 1) ?></span>
                        </div>
                        <?php endif; ?>
                    </div>
                    
                    <!-- Action Button -->
                    <a href="<?= base_url('novel/' . $novel->id) ?>" 
                       class="block w-full text-center bg-purple-100 text-purple-700 py-2 rounded-lg font-medium hover:bg-purple-600 hover:text-white transition-colors">
                        <i class="fas fa-book-open mr-2"></i>
                        Baca Sekarang
                    </a>
                </div>
            </div>
            <?php endforeach; ?>
        </div>

        <!-- Pagination -->
        <?php if (isset($pagination) && $pagination['total'] > 1): ?>
        <div class="mt-12 flex justify-center">
            <nav class="flex items-center space-x-2">
                <?php if ($pagination['current'] > 1): ?>
                <a href="?page=<?= $pagination['current'] - 1 ?>&sort=<?= $currentSort ?? 'latest' ?>" 
                   class="px-4 py-2 border border-gray-300 rounded-lg text-gray-600 hover:bg-purple-50 hover:border-purple-300 transition-colors">
                    <i class="fas fa-chevron-left mr-1"></i>
                    Sebelumnya
                </a>
                <?php endif; ?>
                
                <?php for ($i = max(1, $pagination['current'] - 2); $i <= min($pagination['total'], $pagination['current'] + 2); $i++): ?>
                <a href="?page=<?= $i ?>&sort=<?= $currentSort ?? 'latest' ?>" 
                   class="px-4 py-2 border rounded-lg transition-colors <?= $i === $pagination['current'] ? 'bg-purple-600 text-white border-purple-600' : 'border-gray-300 text-gray-600 hover:bg-purple-50 hover:border-purple-300' ?>">
                    <?= $i ?>
                </a>
                <?php endfor; ?>
                
                <?php if ($pagination['current'] < $pagination['total']): ?>
                <a href="?page=<?= $pagination['current'] + 1 ?>&sort=<?= $currentSort ?? 'latest' ?>" 
                   class="px-4 py-2 border border-gray-300 rounded-lg text-gray-600 hover:bg-purple-50 hover:border-purple-300 transition-colors">
                    Selanjutnya
                    <i class="fas fa-chevron-right ml-1"></i>
                </a>
                <?php endif; ?>
            </nav>
        </div>
        <?php endif; ?>

        <?php else: ?>
        <!-- Empty State -->
        <div class="text-center py-16">
            <div class="mb-6">
                <i class="fas fa-book-open text-6xl text-gray-300"></i>
            </div>
            <h3 class="text-2xl font-bold text-gray-600 mb-4">Belum Ada Novel</h3>
            <p class="text-gray-500 mb-8">Belum ada novel dalam kategori <strong><?= esc($category->name) ?></strong> saat ini.</p>
            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                <a href="<?= base_url('categories') ?>" class="gradient-fantasy text-white px-6 py-3 rounded-lg hover:opacity-90 transition-opacity">
                    <i class="fas fa-tags mr-2"></i>
                    Lihat Kategori Lain
                </a>
                <a href="<?= base_url('novels') ?>" class="bg-gray-100 text-gray-700 px-6 py-3 rounded-lg hover:bg-gray-200 transition-colors">
                    <i class="fas fa-book mr-2"></i>
                    Semua Novel
                </a>
            </div>
        </div>
        <?php endif; ?>
    </div>
</section>

<!-- Related Categories -->
<?php if (!empty($categories)): ?>
<section class="py-16 bg-gray-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-12">
            <h2 class="text-3xl font-fantasy font-bold text-gray-800 mb-4">
                <i class="fas fa-compass text-purple-600 mr-3"></i>
                Jelajahi Kategori Lainnya
            </h2>
            <p class="text-gray-600">Temukan lebih banyak cerita menarik di kategori lain</p>
        </div>

        <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-6 gap-4">
            <?php 
            $otherCategories = array_filter($categories, function($cat) use ($category) {
                return $cat->id !== $category->id;
            });
            $otherCategories = array_slice($otherCategories, 0, 6);
            ?>
            
            <?php foreach ($otherCategories as $otherCategory): ?>
            <a href="<?= base_url('category/' . $otherCategory->slug) ?>" 
               class="card-fantasy rounded-lg p-4 text-center group hover:scale-105 transition-transform duration-300">
                <div class="w-12 h-12 mx-auto gradient-fantasy rounded-full flex items-center justify-center mb-3">
                    <?php
                    $iconClass = $icons[strtolower($otherCategory->name)] ?? 'fas fa-book';
                    ?>
                    <i class="<?= $iconClass ?> text-white"></i>
                </div>
                <h3 class="font-semibold text-gray-800 text-sm group-hover:text-purple-600 transition-colors">
                    <?= esc($otherCategory->name) ?>
                </h3>
                <p class="text-xs text-gray-500 mt-1">
                    <?= isset($otherCategory->novel_count) ? $otherCategory->novel_count : '0' ?> novel
                </p>
            </a>
            <?php endforeach; ?>
        </div>
    </div>
</section>
<?php endif; ?>

<script>
// Sort functionality
document.getElementById('sortSelect').addEventListener('change', function() {
    const currentUrl = new URL(window.location.href);
    currentUrl.searchParams.set('sort', this.value);
    currentUrl.searchParams.delete('page'); // Reset to first page when sorting
    window.location.href = currentUrl.toString();
});
</script>
<?= $this->endSection() ?>
