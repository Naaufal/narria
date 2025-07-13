<?= $this->extend('home/layout/main') ?>

<?= $this->section('content') ?>
<!-- Header Section -->
<section class="gradient-fantasy text-white py-16">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center">
            <h1 class="text-4xl md:text-5xl font-fantasy font-bold mb-4 text-shadow">
                <i class="fas fa-book-open mr-3 text-amber-400"></i>Koleksi Novel
            </h1>
            <p class="text-xl text-purple-100 max-w-2xl mx-auto">
                Jelajahi ribuan novel fantasi dari berbagai genre dan penulis terbaik
            </p>
        </div>
    </div>
</section>

<!-- Filter Section -->
<section class="py-8 bg-white shadow-sm">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <form method="GET" class="flex flex-wrap gap-4 items-center justify-between">
            <!-- Sort -->
            <div class="flex items-center space-x-2">
                <label class="text-gray-700 font-medium">Urutkan:</label>
                <select name="sort" class="border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-purple-500">
                    <option value="latest" <?= $currentSort === 'latest' ? 'selected' : '' ?>>Terbaru</option>
                    <option value="popular" <?= $currentSort === 'popular' ? 'selected' : '' ?>>Terpopuler</option>
                    <option value="title" <?= $currentSort === 'title' ? 'selected' : '' ?>>Judul A-Z</option>
                    <option value="views" <?= $currentSort === 'views' ? 'selected' : '' ?>>Paling Banyak Dibaca</option>
                </select>
            </div>

            <!-- Category Filter -->
            <div class="flex items-center space-x-2">
                <label class="text-gray-700 font-medium">Kategori:</label>
                <select name="category" class="border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-purple-500">
                    <option value="">Semua Kategori</option>
                    <?php foreach ($categories as $category): ?>
                    <option value="<?= $category->id ?>" <?= $currentCategory == $category->id ? 'selected' : '' ?>>
                        <?= esc($category->name) ?>
                    </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <!-- Status Filter -->
            <div class="flex items-center space-x-2">
                <label class="text-gray-700 font-medium">Status:</label>
                <select name="status" class="border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-purple-500">
                    <option value="">Semua Status</option>
                    <option value="ongoing" <?= $currentStatus === 'ongoing' ? 'selected' : '' ?>>Ongoing</option>
                    <option value="completed" <?= $currentStatus === 'completed' ? 'selected' : '' ?>>Completed</option>
                    <option value="hiatus" <?= $currentStatus === 'hiatus' ? 'selected' : '' ?>>Hiatus</option>
                </select>
            </div>

            <button type="submit" class="gradient-fantasy text-white px-6 py-2 rounded-lg hover:opacity-90 transition-opacity">
                <i class="fas fa-filter mr-2"></i>Filter
            </button>
        </form>
    </div>
</section>

<!-- Novels Grid -->
<section class="py-16 bg-gradient-to-b from-purple-50 to-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <?php if (!empty($novels)): ?>
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
            <?php foreach ($novels as $novel): ?>
            <div class="card-fantasy rounded-xl overflow-hidden shadow-lg group">
                <div class="relative">
                    <img src="<?= $novel->cover_image ? base_url('uploads/covers/' . $novel->cover_image) : 'https://via.placeholder.com/300x400?text=No+Cover' ?>" 
                         alt="<?= esc($novel->title) ?>" class="w-full h-64 object-cover group-hover:scale-105 transition-transform duration-300">
                    
                    <!-- Status Badge -->
                    <div class="absolute top-3 left-3">
                        <?php
                        $statusColors = [
                            'ongoing' => 'bg-blue-500',
                            'completed' => 'bg-green-500',
                            'hiatus' => 'bg-yellow-500'
                        ];
                        $statusColor = $statusColors[$novel->status] ?? 'bg-gray-500';
                        ?>
                        <span class="<?= $statusColor ?> text-white px-2 py-1 rounded-full text-xs font-bold">
                            <?= ucfirst($novel->status) ?>
                        </span>
                    </div>

                    <!-- Views -->
                    <div class="absolute top-3 right-3">
                        <span class="bg-black/70 text-white px-2 py-1 rounded-full text-xs">
                            <i class="fas fa-eye mr-1"></i><?= number_format($novel->views) ?>
                        </span>
                    </div>

                    <!-- Bookmark Button -->
                    <?php if (session()->get('isLoggedIn')): ?>
                    <button class="bookmark-btn absolute bottom-3 right-3 w-10 h-10 bg-white/90 rounded-full flex items-center justify-center text-purple-600 hover:bg-white transition-colors shadow-lg" 
                            data-novel-id="<?= $novel->id ?>"
                            title="Bookmark novel ini">
                        <i class="far fa-bookmark text-lg"></i>
                    </button>
                    <?php endif; ?>
                </div>

                <div class="p-4">
                    <h3 class="font-bold text-lg mb-2 line-clamp-2">
                        <a href="<?= base_url('novel/' . $novel->id) ?>" class="text-gray-800 hover:text-purple-600 transition-colors">
                            <?= esc($novel->title) ?>
                        </a>
                    </h3>
                    
                    <p class="text-gray-600 text-sm mb-3 flex items-center">
                        <i class="fas fa-user mr-2 text-purple-400"></i>
                        <a href="<?= base_url('author/' . $novel->authorName) ?>" class="hover:text-purple-600">
                            <?= esc($novel->authorName) ?>
                        </a>
                    </p>

                    <!-- Categories -->
                    <div class="flex flex-wrap gap-1 mb-3">
                        <?php foreach (array_slice($novel->categoryNames, 0, 2) as $category): ?>
                        <span class="bg-purple-100 text-purple-800 px-2 py-1 rounded-full text-xs">
                            <?= esc($category) ?>
                        </span>
                        <?php endforeach; ?>
                    </div>

                    <p class="text-gray-700 text-sm line-clamp-3 mb-4">
                        <?= esc(substr($novel->sinopsis, 0, 120)) ?>...
                    </p>

                    <div class="flex justify-between items-center">
                        <span class="text-sm text-gray-500">
                            <i class="fas fa-calendar mr-1"></i>
                            <?= date('d M Y', strtotime($novel->created_at)) ?>
                        </span>
                        <a href="<?= base_url('novel/' . $novel->id) ?>" 
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
                <a href="?page=<?= $i ?>&sort=<?= $currentSort ?>&category=<?= $currentCategory ?>&status=<?= $currentStatus ?>" 
                   class="px-4 py-2 rounded-lg <?= $i === $pagination['current'] ? 'gradient-fantasy text-white' : 'bg-white text-gray-700 hover:bg-purple-50' ?> transition-colors">
                    <?= $i ?>
                </a>
                <?php endfor; ?>
            </nav>
        </div>
        <?php endif; ?>

        <?php else: ?>
        <div class="text-center py-16">
            <i class="fas fa-book-open text-6xl text-gray-400 mb-4"></i>
            <h3 class="text-xl font-semibold text-gray-600 mb-2">Tidak ada novel ditemukan</h3>
            <p class="text-gray-500">Coba ubah filter atau kata kunci pencarian Anda</p>
        </div>
        <?php endif; ?>
    </div>
</section>

<script>
// Toast functions
function showToast(message, type = 'success') {
    console.log('Showing toast:', message, type);
    
    let toast = document.getElementById('toast');
    if (!toast) {
        toast = document.createElement('div');
        toast.id = 'toast';
        toast.className = 'fixed top-4 right-4 bg-white border-l-4 border-green-500 rounded-lg shadow-lg p-4 transform translate-x-full transition-transform duration-300 z-50';
        toast.innerHTML = `
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <i class="fas fa-check-circle text-green-500"></i>
                </div>
                <div class="ml-3">
                    <p class="text-sm font-medium text-gray-900" id="toast-message"></p>
                </div>
                <div class="ml-auto pl-3">
                    <button onclick="hideToast()" class="text-gray-400 hover:text-gray-600">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
            </div>
        `;
        document.body.appendChild(toast);
    }

    const toastMessage = document.getElementById('toast-message');
    const icon = toast.querySelector('i');

    toastMessage.textContent = message;

    if (type === 'success') {
        toast.className = toast.className.replace(/border-\w+-500/, 'border-green-500');
        icon.className = 'fas fa-check-circle text-green-500';
    } else if (type === 'error') {
        toast.className = toast.className.replace(/border-\w+-500/, 'border-red-500');
        icon.className = 'fas fa-exclamation-circle text-red-500';
    }

    toast.classList.remove('translate-x-full');
    setTimeout(() => hideToast(), 3000);
}

function hideToast() {
    const toast = document.getElementById('toast');
    if (toast) {
        toast.classList.add('translate-x-full');
    }
}

// Load bookmark status when page loads
document.addEventListener('DOMContentLoaded', function() {
    console.log('DOM loaded, checking bookmarks');
    const bookmarkBtns = document.querySelectorAll('.bookmark-btn');
    console.log('Found bookmark buttons:', bookmarkBtns.length);

    bookmarkBtns.forEach(function(btn) {
        const novelId = btn.dataset.novelId;
        console.log('Checking bookmark status for novel:', novelId);

        fetch('<?= base_url('check-bookmark') ?>/' + novelId)
            .then(response => {
                console.log('Check bookmark response status:', response.status);
                return response.json();
            })
            .then(data => {
                console.log('Check bookmark data:', data);
                const icon = btn.querySelector('i');
                if (data.bookmarked) {
                    icon.classList.remove('far');
                    icon.classList.add('fas');
                    btn.classList.add('text-amber-500');
                    btn.title = 'Hapus dari bookmark';
                } else {
                    icon.classList.remove('fas');
                    icon.classList.add('far');
                    btn.classList.remove('text-amber-500');
                    btn.title = 'Bookmark novel ini';
                }
            })
            .catch(error => {
                console.error('Error checking bookmark status:', error);
            });
    });
});

// Bookmark functionality
document.querySelectorAll('.bookmark-btn').forEach(function(btn) {
    btn.addEventListener('click', function(e) {
        e.preventDefault();
        e.stopPropagation();

        const button = this;
        const novelId = button.dataset.novelId;
        const icon = button.querySelector('i');
        const originalIcon = icon.className;

        console.log('Bookmark button clicked for novel:', novelId);

        // Show loading state
        icon.className = 'fas fa-spinner fa-spin';
        button.disabled = true;

        console.log('Sending bookmark request...');

        const formData = new FormData();
        formData.append('novel_id', novelId);
        formData.append('<?= csrf_token() ?>', '<?= csrf_hash() ?>');

        fetch('<?= base_url('toggle-bookmark') ?>', {
            method: 'POST',
            headers: {
                'X-Requested-With': 'XMLHttpRequest'
            },
            body: formData
        })
        .then(response => {
            console.log('Toggle bookmark response status:', response.status);
            
            if (!response.ok) {
                throw new Error(`HTTP error! status: ${response.status}`);
            }
            
            return response.json();
        })
        .then(data => {
            console.log('Toggle bookmark data:', data);
            
            if (data.success) {
                if (data.bookmarked) {
                    icon.className = 'fas fa-bookmark';
                    button.classList.add('text-amber-500');
                    button.title = 'Hapus dari bookmark';
                } else {
                    icon.className = 'far fa-bookmark';
                    button.classList.remove('text-amber-500');
                    button.title = 'Bookmark novel ini';
                }
                showToast(data.message, 'success');
            } else {
                icon.className = originalIcon;
                showToast(data.message || 'Terjadi kesalahan', 'error');
            }
        })
        .catch(error => {
            console.error('Fetch error:', error);
            icon.className = originalIcon;
            showToast('Terjadi kesalahan saat memproses bookmark: ' + error.message, 'error');
        })
        .finally(() => {
            button.disabled = false;
        });
    });
});
</script>

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

.card-fantasy {
    background: linear-gradient(135deg, #ffffff 0%, #f8fafc 100%);
    border: 1px solid #e2e8f0;
}

.gradient-fantasy {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
}
</style>

<?= $this->endSection() ?>
