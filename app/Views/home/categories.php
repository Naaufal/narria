<?= $this->extend('home/layout/main') ?>

<?= $this->section('content') ?>
<!-- Hero Section -->
<section class="gradient-fantasy py-20 relative overflow-hidden">
    <div class="absolute inset-0 bg-black/20"></div>
    <div class="absolute inset-0">
        <div class="absolute top-10 left-10 w-20 h-20 bg-amber-400/20 rounded-full animate-pulse"></div>
        <div class="absolute top-32 right-20 w-16 h-16 bg-purple-400/20 rounded-full animate-pulse delay-1000"></div>
        <div class="absolute bottom-20 left-1/3 w-12 h-12 bg-pink-400/20 rounded-full animate-pulse delay-500"></div>
    </div>
    
    <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <div class="mb-8">
            <i class="fas fa-magic text-6xl text-amber-400 mb-4 animate-bounce"></i>
        </div>
        <h1 class="text-5xl md:text-6xl font-fantasy font-bold text-white mb-6 text-shadow">
            Jelajahi Kategori
        </h1>
        <p class="text-xl text-purple-100 max-w-3xl mx-auto leading-relaxed">
            Temukan dunia magis yang sesuai dengan selera Anda. Dari romance yang memikat hingga petualangan yang mendebarkan.
        </p>
    </div>
</section>

<!-- Categories Grid -->
<section class="py-16 bg-gradient-to-b from-slate-50 to-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Section Header -->
        <div class="text-center mb-12">
            <h2 class="text-3xl md:text-4xl font-fantasy font-bold text-gray-800 mb-4">
                <i class="fas fa-scroll text-purple-600 mr-3"></i>
                Semua Kategori
            </h2>
            <p class="text-gray-600 text-lg max-w-2xl mx-auto">
                Pilih kategori favorit Anda dan mulai petualangan membaca yang tak terlupakan
            </p>
        </div>

        <?php if (!empty($categories)): ?>
        <!-- Categories Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
            <?php foreach ($categories as $category): ?>
            <div class="card-fantasy rounded-xl p-6 group cursor-pointer" onclick="window.location.href='<?= base_url('category/' . $category->slug) ?>'">
                <!-- Category Icon -->
                <div class="text-center mb-4">
                    <div class="w-16 h-16 mx-auto gradient-fantasy rounded-full flex items-center justify-center mb-3 group-hover:scale-110 transition-transform duration-300">
                        <?php
                        // Icon mapping berdasarkan nama kategori
                        $icons = [
                            'romantis' => 'fas fa-heart',
                            'fantasi' => 'fas fa-magic',
                            'action' => 'fas fa-fist-raised',
                            'drama' => 'fas fa-theater-masks',
                            'komedi' => 'fas fa-laugh',
                            'horor' => 'fas fa-ghost',
                            'mysteri' => 'fas fa-search',
                            'petualangan' => 'fas fa-compass',
                            'sci-fi' => 'fas fa-rocket',
                            'slice of life' => 'fas fa-coffee'
                        ];
                        $iconClass = $icons[strtolower($category->name)] ?? 'fas fa-book';
                        ?>
                        <i class="<?= $iconClass ?> text-2xl text-white"></i>
                    </div>
                </div>

                <!-- Category Info -->
                <div class="text-center">
                    <h3 class="text-xl font-bold text-gray-800 mb-2 group-hover:text-purple-600 transition-colors">
                        <?= esc($category->name) ?>
                    </h3>
                    
                    <div class="flex items-center justify-center text-gray-500 mb-3">
                        <i class="fas fa-book-open mr-2"></i>
                        <span class="text-sm">
                            <?= isset($category->novel_count) ? number_format($category->novel_count) : '0' ?> Novel
                        </span>
                    </div>

                    <?php if (!empty($category->description)): ?>
                    <p class="text-gray-600 text-sm leading-relaxed mb-4">
                        <?= esc(substr($category->description, 0, 100)) ?><?= strlen($category->description) > 100 ? '...' : '' ?>
                    </p>
                    <?php endif; ?>

                    <!-- Action Button -->
                    <div class="mt-4">
                        <span class="inline-flex items-center px-4 py-2 bg-purple-100 text-purple-700 rounded-lg text-sm font-medium group-hover:bg-purple-600 group-hover:text-white transition-colors">
                            <i class="fas fa-arrow-right mr-2"></i>
                            Jelajahi
                        </span>
                    </div>
                </div>

                <!-- Hover Effect Overlay -->
                <div class="absolute inset-0 bg-gradient-to-t from-purple-600/10 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300 rounded-xl"></div>
            </div>
            <?php endforeach; ?>
        </div>
        <?php else: ?>
        <!-- Empty State -->
        <div class="text-center py-16">
            <div class="mb-6">
                <i class="fas fa-tags text-6xl text-gray-300"></i>
            </div>
            <h3 class="text-2xl font-bold text-gray-600 mb-4">Belum Ada Kategori</h3>
            <p class="text-gray-500 mb-8">Kategori novel akan muncul di sini setelah ditambahkan.</p>
            <a href="<?= base_url('novels') ?>" class="gradient-fantasy text-white px-6 py-3 rounded-lg hover:opacity-90 transition-opacity">
                <i class="fas fa-book mr-2"></i>
                Lihat Semua Novel
            </a>
        </div>
        <?php endif; ?>
    </div>
</section>

<!-- Popular Categories Section -->
<?php if (!empty($categories)): ?>
<section class="py-16 bg-gray-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-12">
            <h2 class="text-3xl font-fantasy font-bold text-gray-800 mb-4">
                <i class="fas fa-fire text-orange-500 mr-3"></i>
                Kategori Terpopuler
            </h2>
            <p class="text-gray-600">Kategori dengan novel terbanyak dan paling banyak dibaca</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <?php 
            // Sort categories by novel count and take top 3
            $popularCategories = array_slice(
                array_filter($categories, function($cat) { return isset($cat->novel_count) && $cat->novel_count > 0; }),
                0, 3
            );
            usort($popularCategories, function($a, $b) {
                return ($b->novel_count ?? 0) - ($a->novel_count ?? 0);
            });
            ?>
            
            <?php foreach ($popularCategories as $index => $category): ?>
            <div class="relative">
                <!-- Ranking Badge -->
                <div class="absolute -top-3 -left-3 w-8 h-8 bg-gradient-to-r from-amber-400 to-orange-500 rounded-full flex items-center justify-center text-white font-bold text-sm z-10">
                    <?= $index + 1 ?>
                </div>
                
                <div class="card-fantasy rounded-xl p-6 h-full group cursor-pointer" onclick="window.location.href='<?= base_url('category/' . $category->slug) ?>'">
                    <div class="flex items-center mb-4">
                        <div class="w-12 h-12 gradient-fantasy rounded-lg flex items-center justify-center mr-4">
                            <?php
                            $iconClass = $icons[strtolower($category->name)] ?? 'fas fa-book';
                            ?>
                            <i class="<?= $iconClass ?> text-white"></i>
                        </div>
                        <div>
                            <h3 class="text-lg font-bold text-gray-800 group-hover:text-purple-600 transition-colors">
                                <?= esc($category->name) ?>
                            </h3>
                            <p class="text-sm text-gray-500">
                                <?= number_format($category->novel_count ?? 0) ?> Novel
                            </p>
                        </div>
                    </div>
                    
                    <div class="flex items-center justify-between">
                        <div class="flex items-center text-gray-500 text-sm">
                            <i class="fas fa-eye mr-1"></i>
                            <span>Populer</span>
                        </div>
                        <i class="fas fa-arrow-right text-purple-400 group-hover:text-purple-600 transition-colors"></i>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>
<?php endif; ?>

<!-- CTA Section -->
<section class="gradient-fantasy py-16 relative overflow-hidden">
    <div class="absolute inset-0 bg-black/20"></div>
    <div class="relative max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <div class="mb-6">
            <i class="fas fa-sparkles text-4xl text-amber-400 animate-pulse"></i>
        </div>
        <h2 class="text-3xl md:text-4xl font-fantasy font-bold text-white mb-6 text-shadow">
            Tidak Menemukan Kategori yang Anda Cari?
        </h2>
        <p class="text-xl text-purple-100 mb-8 leading-relaxed">
            Jelajahi semua novel kami atau gunakan pencarian untuk menemukan cerita yang sempurna untuk Anda
        </p>
        <div class="flex flex-col sm:flex-row gap-4 justify-center">
            <a href="<?= base_url('novels') ?>" class="bg-white text-purple-700 px-8 py-3 rounded-lg font-semibold hover:bg-gray-100 transition-colors">
                <i class="fas fa-book mr-2"></i>
                Lihat Semua Novel
            </a>
            <a href="<?= base_url('search') ?>" class="bg-amber-500 text-white px-8 py-3 rounded-lg font-semibold hover:bg-amber-600 transition-colors">
                <i class="fas fa-search mr-2"></i>
                Pencarian Lanjutan
            </a>
        </div>
    </div>
</section>
<?= $this->endSection() ?>
