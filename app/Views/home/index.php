<?= $this->extend('home/layout/main') ?>

<?= $this->section('content') ?>
<!-- Hero Section -->
<section class="relative gradient-fantasy text-white py-20 overflow-hidden">
    <div class="absolute inset-0 bg-black/30"></div>
    
    <!-- Hero Background Pattern -->
    <div class="absolute inset-0 opacity-10">
        <div class="absolute top-10 left-10 text-6xl text-amber-400"><i class="fas fa-star"></i></div>
        <div class="absolute top-32 right-20 text-4xl text-purple-300"><i class="fas fa-magic"></i></div>
        <div class="absolute bottom-20 left-1/4 text-5xl text-amber-300"><i class="fas fa-gem"></i></div>
        <div class="absolute bottom-32 right-10 text-3xl text-purple-400"><i class="fas fa-dragon"></i></div>
    </div>

    <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <h1 class="text-4xl md:text-7xl font-fantasy font-bold mb-6 text-shadow">
            Selamat Datang di <span class="text-amber-400">NARRIA</span>
        </h1>
        <p class="text-xl md:text-2xl mb-8 text-purple-100 max-w-3xl mx-auto leading-relaxed">
            Portal novel fantasi modern yang menghadirkan petualangan magis tak terbatas. 
            Jelajahi dunia penuh keajaiban melalui ribuan cerita menakjubkan.
        </p>
        
        <!-- Search Form -->
        <form action="<?= base_url('search') ?>" method="GET" class="max-w-2xl mx-auto mb-12">
            <div class="flex flex-col md:flex-row gap-4">
                <div class="flex-1 relative">
                    <input type="text" name="q" placeholder="Temukan petualangan magis Anda..." 
                           class="w-full pl-14 pr-4 py-4 text-gray-800 rounded-xl text-lg focus:ring-4 focus:ring-amber-400 focus:outline-none bg-white/95 backdrop-blur-sm border border-white/20">
                    <i class="fas fa-search absolute left-5 top-5 text-purple-500 text-lg"></i>
                </div>
                <button type="submit" class="gradient-gold hover:opacity-90 text-purple-900 font-bold py-4 px-8 rounded-xl transition duration-300 shadow-lg">
                    <i class="fas fa-magic mr-2"></i>Mulai Pencarian
                </button>
            </div>
        </form>

        <!-- Stats -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8 max-w-4xl mx-auto">
            <div class="text-center p-6 bg-white/10 backdrop-blur-sm rounded-xl border border-white/20">
                <div class="text-4xl md:text-5xl font-bold text-amber-400 mb-2"><?= number_format($totalNovels) ?></div>
                <div class="text-purple-100 font-medium">Novel Magis</div>
                <i class="fas fa-book-open text-2xl text-purple-300 mt-2"></i>
            </div>
            <div class="text-center p-6 bg-white/10 backdrop-blur-sm rounded-xl border border-white/20">
                <div class="text-4xl md:text-5xl font-bold text-amber-400 mb-2"><?= number_format($totalAuthors) ?></div>
                <div class="text-purple-100 font-medium">Penulis Berbakat</div>
                <i class="fas fa-feather-alt text-2xl text-purple-300 mt-2"></i>
            </div>
            <div class="text-center p-6 bg-white/10 backdrop-blur-sm rounded-xl border border-white/20">
                <div class="text-4xl md:text-5xl font-bold text-amber-400 mb-2">∞</div>
                <div class="text-purple-100 font-medium">Petualangan Tak Terbatas</div>
                <i class="fas fa-infinity text-2xl text-purple-300 mt-2"></i>
            </div>
        </div>
    </div>
</section>

<!-- Featured Novels Carousel -->
<section class="py-16 bg-gradient-to-b from-purple-50 to-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-12">
            <h2 class="text-4xl font-fantasy font-bold text-purple-800 mb-4">
                <i class="fas fa-crown text-amber-500 mr-3"></i>Novel Pilihan Editor
            </h2>
            <p class="text-gray-600 text-lg">Novel terpopuler yang wajib Anda baca</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <?php foreach (array_slice($featuredNovels, 0, 3) as $index => $novel): ?>
            <div class="card-fantasy rounded-2xl overflow-hidden shadow-xl relative group">
                <div class="absolute top-4 left-4 z-10">
                    <span class="gradient-gold text-purple-900 px-3 py-1 rounded-full text-sm font-bold">
                        #<?= $index + 1 ?> Trending
                    </span>
                </div>
                <div class="relative overflow-hidden">
                    <img src="<?= $novel->cover_image ? base_url('uploads/covers/' . $novel->cover_image) : 'https://via.placeholder.com/400x600?text=No+Cover' ?>" 
                         alt="<?= esc($novel->title) ?>" class="w-full h-80 object-cover group-hover:scale-110 transition-transform duration-500">
                    <div class="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent"></div>
                    <div class="absolute bottom-4 right-4">
                        <span class="bg-white/90 text-purple-800 px-3 py-1 rounded-full text-sm font-bold">
                            <i class="fas fa-eye mr-1"></i><?= number_format($novel->views) ?>
                        </span>
                    </div>
                </div>
                <div class="p-6">
                    <h3 class="font-bold text-xl mb-3 text-gray-800 line-clamp-2">
                        <a href="<?= base_url('novel/' . $novel->id) ?>" class="hover:text-purple-600 transition-colors">
                            <?= esc($novel->title) ?>
                        </a>
                    </h3>
                    <p class="text-gray-600 text-sm mb-3 flex items-center">
                        <i class="fas fa-feather-alt mr-2 text-purple-500"></i>oleh <?= esc($novel->authorName) ?>
                    </p>
                    <div class="flex flex-wrap gap-2 mb-4">
                        <?php foreach (array_slice($novel->categoryNames, 0, 2) as $category): ?>
                        <span class="bg-purple-100 text-purple-800 px-3 py-1 rounded-full text-xs font-medium">
                            <?= esc($category) ?>
                        </span>
                        <?php endforeach; ?>
                    </div>
                    <p class="text-gray-700 text-sm line-clamp-3 mb-4"><?= esc(substr($novel->sinopsis, 0, 120)) ?>...</p>
                    <a href="<?= base_url('novel/' . $novel->id) ?>" class="inline-flex items-center text-purple-600 hover:text-purple-800 font-medium">
                        Baca Sekarang <i class="fas fa-arrow-right ml-2"></i>
                    </a>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<!-- Novel Populer -->
<section class="py-16">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center mb-12">
            <h2 class="text-3xl font-fantasy font-bold text-purple-800">
                <i class="fas fa-fire text-red-500 mr-3"></i>Novel Terpopuler
            </h2>
            <a href="<?= base_url('novels') ?>" class="text-purple-600 hover:text-purple-800 font-semibold flex items-center">
                Lihat Semua <i class="fas fa-arrow-right ml-2"></i>
            </a>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
            <?php foreach ($novelPopuler as $novel): ?>
            <div class="card-fantasy rounded-xl overflow-hidden shadow-lg group">
                <div class="relative">
                    <img src="<?= $novel->cover_image ? base_url('uploads/covers/' . $novel->cover_image) : 'https://via.placeholder.com/300x400?text=No+Cover' ?>" 
                         alt="<?= esc($novel->title) ?>" class="w-full h-64 object-cover group-hover:scale-105 transition-transform duration-300">
                    <div class="absolute top-3 right-3">
                        <span class="bg-red-500 text-white px-2 py-1 rounded-full text-xs font-bold shadow-lg">
                            <i class="fas fa-eye mr-1"></i><?= number_format($novel->views) ?>
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
                    <p class="text-gray-700 text-sm line-clamp-3"><?= esc(substr($novel->sinopsis, 0, 100)) ?>...</p>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<!-- Novel Terbaru -->
<section class="py-16 bg-gradient-to-b from-purple-50 to-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center mb-12">
            <h2 class="text-3xl font-fantasy font-bold text-purple-800">
                <i class="fas fa-sparkles text-green-500 mr-3"></i>Novel Terbaru
            </h2>
            <a href="<?= base_url('novels') ?>" class="text-purple-600 hover:text-purple-800 font-semibold flex items-center">
                Lihat Semua <i class="fas fa-arrow-right ml-2"></i>
            </a>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
            <?php foreach ($novelTerbaru as $novel): ?>
            <div class="card-fantasy rounded-xl overflow-hidden shadow-lg group">
                <div class="relative">
                    <img src="<?= $novel->cover_image ? base_url('uploads/covers/' . $novel->cover_image) : 'https://via.placeholder.com/300x400?text=No+Cover' ?>" 
                         alt="<?= esc($novel->title) ?>" class="w-full h-64 object-cover group-hover:scale-105 transition-transform duration-300">
                    <div class="absolute top-3 left-3">
                        <span class="gradient-gold text-purple-900 px-2 py-1 rounded-full text-xs font-bold shadow-lg">
                            <i class="fas fa-star mr-1"></i>Baru
                        </span>
                    </div>
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
                    <p class="text-gray-700 text-sm line-clamp-3"><?= esc(substr($novel->sinopsis, 0, 100)) ?>...</p>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<!-- Kategori -->
<section class="py-16">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-12">
            <h2 class="text-3xl font-fantasy font-bold text-purple-800 mb-4">
                <i class="fas fa-compass text-amber-500 mr-3"></i>Jelajahi Genre Fantasi
            </h2>
            <p class="text-gray-600 text-lg">Temukan petualangan sesuai selera Anda</p>
        </div>

        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-4">
            <?php 
            $fantasyIcons = [
                'romance' => ['fas fa-heart', 'text-pink-500', 'bg-pink-100'],
                'fantasy' => ['fas fa-magic', 'text-purple-500', 'bg-purple-100'],
                'drama' => ['fas fa-theater-masks', 'text-blue-500', 'bg-blue-100'],
                'action' => ['fas fa-sword', 'text-red-500', 'bg-red-100'],
                'comedy' => ['fas fa-laugh', 'text-yellow-500', 'bg-yellow-100'],
                'horror' => ['fas fa-ghost', 'text-gray-700', 'bg-gray-100'],
                'mystery' => ['fas fa-search', 'text-indigo-500', 'bg-indigo-100'],
                'sci-fi' => ['fas fa-rocket', 'text-green-500', 'bg-green-100']
            ];
            
            foreach (array_slice($categories, 0, 12) as $category): 
                $categoryKey = strtolower($category->name);
                $iconData = $fantasyIcons[$categoryKey] ?? ['fas fa-book', 'text-purple-500', 'bg-purple-100'];
            ?>
            <a href="<?= base_url('category/' . $category->slug) ?>" 
               class="card-fantasy rounded-xl p-6 text-center border-2 border-transparent hover:border-amber-400 group">
                <div class="w-16 h-16 <?= $iconData[2] ?> rounded-full flex items-center justify-center mx-auto mb-4 group-hover:scale-110 transition-transform duration-300">
                    <i class="<?= $iconData[0] ?> <?= $iconData[1] ?> text-2xl"></i>
                </div>
                <h3 class="font-bold text-gray-800 mb-2 group-hover:text-purple-600 transition-colors"><?= esc($category->name) ?></h3>
                <p class="text-gray-600 text-sm"><?= $category->novel_count ?> novel</p>
            </a>
            <?php endforeach; ?>
        </div>

        <div class="text-center mt-10">
            <a href="<?= base_url('categories') ?>" 
               class="gradient-fantasy hover:opacity-90 text-white font-bold py-4 px-8 rounded-xl transition duration-300 shadow-lg inline-flex items-center">
                <i class="fas fa-compass mr-2"></i>Jelajahi Semua Genre
            </a>
        </div>
    </div>
</section>

<!-- Top Authors -->
<section class="py-16 bg-gradient-to-b from-purple-50 to-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-12">
            <h2 class="text-3xl font-fantasy font-bold text-purple-800 mb-4">
                <i class="fas fa-crown text-amber-500 mr-3"></i>Penulis Legendaris
            </h2>
            <p class="text-gray-600 text-lg">Para pencipta dunia fantasi terpopuler</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            <?php foreach ($topAuthors as $index => $author): ?>
            <div class="card-fantasy rounded-xl p-6 text-center group">
                <div class="relative inline-block mb-4">
                    <div class="w-20 h-20 gradient-fantasy rounded-full flex items-center justify-center text-white font-bold text-2xl shadow-lg">
                        <?= strtoupper(substr($author->username, 0, 2)) ?>
                    </div>
                    <?php if ($index < 3): ?>
                    <div class="absolute -top-2 -right-2 w-8 h-8 gradient-gold rounded-full flex items-center justify-center shadow-lg">
                        <i class="fas fa-crown text-purple-900 text-sm"></i>
                    </div>
                    <?php endif; ?>
                </div>
                <h3 class="font-bold text-xl text-gray-800 mb-2 group-hover:text-purple-600 transition-colors">
                    <?= esc($author->username) ?>
                </h3>
                <p class="text-gray-600 mb-4 font-medium">Penulis Fantasi</p>
                <div class="grid grid-cols-2 gap-4">
                    <div class="text-center p-3 bg-purple-50 rounded-lg">
                        <div class="text-2xl font-bold text-purple-600"><?= $author->novel_count ?></div>
                        <div class="text-gray-600 text-sm">Novel</div>
                    </div>
                    <div class="text-center p-3 bg-amber-50 rounded-lg">
                        <div class="text-2xl font-bold text-amber-600"><?= number_format($author->total_views) ?></div>
                        <div class="text-gray-600 text-sm">Pembaca</div>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<!-- CTA Section -->
<section class="relative gradient-fantasy text-white py-20 overflow-hidden">
    <div class="absolute inset-0 bg-black/20"></div>
    
    <!-- CTA Background Elements -->
    <div class="absolute inset-0 opacity-10">
        <div class="absolute top-10 left-10 text-6xl text-amber-400 animate-pulse"><i class="fas fa-magic"></i></div>
        <div class="absolute top-20 right-20 text-4xl text-purple-300 animate-bounce"><i class="fas fa-star"></i></div>
        <div class="absolute bottom-20 left-1/4 text-5xl text-amber-300 animate-pulse"><i class="fas fa-gem"></i></div>
        <div class="absolute bottom-10 right-10 text-6xl text-purple-400 animate-bounce"><i class="fas fa-dragon"></i></div>
    </div>

    <div class="relative max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <h2 class="text-4xl md:text-5xl font-fantasy font-bold mb-6 text-shadow">
            Mulai Petualangan Magis Anda!
        </h2>
        <p class="text-xl mb-10 text-purple-100 leading-relaxed max-w-2xl mx-auto">
            Bergabunglah dengan ribuan pembaca lainnya dan rasakan keajaiban dunia fantasi 
            yang menanti untuk dijelajahi. Petualangan tak terbatas dimulai dari sini.
        </p>
        <div class="flex flex-col sm:flex-row gap-6 justify-center">
            <a href="<?= base_url('novels') ?>" 
               class="gradient-gold hover:opacity-90 text-purple-900 font-bold py-4 px-8 rounded-xl transition duration-300 shadow-xl inline-flex items-center justify-center">
                <i class="fas fa-book-open mr-3"></i>Mulai Membaca Sekarang
            </a>
            <?php if (!session()->get('isLoggedIn')): ?>
            <a href="<?= base_url('register') ?>" 
               class="bg-white/20 backdrop-blur-sm border-2 border-white hover:bg-white hover:text-purple-800 text-white font-bold py-4 px-8 rounded-xl transition duration-300 shadow-xl inline-flex items-center justify-center">
                <i class="fas fa-user-plus mr-3"></i>Bergabung Gratis
            </a>
            <?php endif; ?>
        </div>
    </div>
</section>

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

@keyframes bounce {
    0%, 20%, 53%, 80%, 100% {
        transform: translate3d(0,0,0);
    }
    40%, 43% {
        transform: translate3d(0,-30px,0);
    }
    70% {
        transform: translate3d(0,-15px,0);
    }
    90% {
        transform: translate3d(0,-4px,0);
    }
}

@keyframes pulse {
    0% {
        opacity: 1;
    }
    50% {
        opacity: .5;
    }
    100% {
        opacity: 1;
    }
}

.animate-bounce {
    animation: bounce 2s infinite;
}

.animate-pulse {
    animation: pulse 2s cubic-bezier(0.4, 0, 0.6, 1) infinite;
}
</style>

<?= $this->endSection() ?>