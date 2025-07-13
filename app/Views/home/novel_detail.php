<?= $this->extend('home/layout/main') ?>

<?= $this->section('content') ?>

<div class="min-h-screen bg-gradient-to-b from-purple-50 to-white py-12">
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    
    <!-- Novel Header -->
    <div class="card-fantasy rounded-2xl overflow-hidden shadow-xl mb-8">
        <div class="md:flex">
            <!-- Cover Image - Flexible but Controlled -->
            <div class="md:w-1/3 lg:w-1/4">
                <div class="cover-container">
                    <img src="<?= $novel->cover_image ? base_url('uploads/covers/' . $novel->cover_image) : 'https://via.placeholder.com/400x600?text=No+Cover' ?>" 
                         alt="<?= esc($novel->title) ?>" class="cover-image">
                </div>
            </div>
            
            <!-- Novel Info -->
            <div class="md:w-2/3 lg:w-3/4 p-8">
                <div class="flex flex-wrap gap-2 mb-4">
                    <?php foreach ($novel->categoryNames as $category): ?>
                    <span class="bg-purple-100 text-purple-800 px-3 py-1 rounded-full text-sm font-medium">
                        <?= esc($category) ?>
                    </span>
                    <?php endforeach; ?>
                </div>
                
                <h1 class="text-3xl md:text-4xl font-fantasy font-bold text-purple-800 mb-4">
                    <?= esc($novel->title) ?>
                </h1>
                
                <div class="flex flex-wrap items-center gap-6 mb-6 text-gray-600">
                    <div class="flex items-center">
                        <i class="fas fa-user mr-2 text-purple-500"></i>
                        <span>oleh <strong><?= esc($novel->authorName) ?></strong></span>
                    </div>
                    <div class="flex items-center">
                        <i class="fas fa-eye mr-2 text-purple-500"></i>
                        <span><?= number_format($novel->views) ?> pembaca</span>
                    </div>
                    <div class="flex items-center">
                        <i class="fas fa-calendar mr-2 text-purple-500"></i>
                        <span><?= date('d M Y', strtotime($novel->created_at)) ?></span>
                    </div>
                    <div class="flex items-center">
                        <i class="fas fa-info-circle mr-2 text-purple-500"></i>
                        <span class="<?= $novel->status === 'completed' ? 'text-green-600' : ($novel->status === 'ongoing' ? 'text-blue-600' : 'text-yellow-600') ?> font-medium">
                            <?= ucfirst($novel->status) ?>
                        </span>
                    </div>
                </div>
                
                <div class="prose max-w-none mb-6">
                    <h3 class="text-lg font-semibold text-gray-800 mb-3">Sinopsis</h3>
                    <div class="synopsis-container">
                        <p id="synopsis-text" class="text-gray-700 leading-relaxed synopsis-text"><?= nl2br(esc($novel->sinopsis)) ?></p>
                        <button id="read-more-btn" class="read-more-btn text-purple-600 hover:text-purple-800 font-medium mt-2 transition-colors duration-200" style="display: none;">
                            Baca selengkapnya
                        </button>
                    </div>
                </div>
                
                <div class="flex flex-wrap gap-4">
                    <?php if (!empty($chapters)): ?>
                    <a href="<?= base_url('novel/' . $novel->id . '/chapter/1') ?>" 
                       class="gradient-fantasy hover:opacity-90 text-white font-bold py-3 px-6 rounded-lg transition duration-300 shadow-lg inline-flex items-center">
                        <i class="fas fa-play mr-2"></i>Mulai Membaca
                    </a>
                    <?php endif; ?>
                    
                    <?php if (session()->get('isLoggedIn')): ?>
                    <button id="bookmark-btn" class="bg-purple-100 hover:bg-purple-200 text-purple-800 font-bold py-3 px-6 rounded-lg transition duration-300 inline-flex items-center" 
                            data-novel-id="<?= $novel->id ?>">
                        <i class="fas fa-bookmark mr-2"></i>
                        <span id="bookmark-text">Bookmark</span>
                    </button>
                    <?php endif; ?>
                    
                    <button class="bg-amber-100 hover:bg-amber-200 text-amber-800 font-bold py-3 px-6 rounded-lg transition duration-300 inline-flex items-center">
                        <i class="fas fa-star mr-2"></i>Rating
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Chapter List -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <div class="lg:col-span-2">
            <div class="card-fantasy rounded-xl p-6 shadow-lg">
                <h2 class="text-2xl font-fantasy font-bold text-purple-800 mb-6 flex items-center">
                    <i class="fas fa-list mr-3 text-amber-500"></i>Daftar Chapter (<?= $totalChapters ?>)
                </h2>
                
                <?php if (!empty($chapters)): ?>
                <div class="space-y-3 max-h-96 overflow-y-auto">
                    <?php foreach ($chapters as $index => $chapter): ?>
                    <a href="<?= base_url('novel/' . $novel->id . '/chapter/' . $chapter->chapter_number) ?>" 
                       class="block p-4 bg-white hover:bg-purple-50 rounded-lg border border-purple-100 hover:border-purple-300 transition-all duration-300 group">
                        <div class="flex items-center justify-between">
                            <div>
                                <h3 class="font-semibold text-gray-800 group-hover:text-purple-600 transition-colors">
                                    Chapter <?= $chapter->chapter_number ?>: <?= esc($chapter->title) ?>
                                </h3>
                                <p class="text-sm text-gray-600 mt-1">
                                    <i class="fas fa-calendar mr-1"></i><?= date('d M Y', strtotime($chapter->created_at)) ?>
                                    <span class="ml-4"><i class="fas fa-eye mr-1"></i><?= number_format($chapter->views) ?></span>
                                </p>
                            </div>
                            <i class="fas fa-chevron-right text-purple-400 group-hover:text-purple-600 transition-colors"></i>
                        </div>
                    </a>
                    <?php endforeach; ?>
                </div>
                <?php else: ?>
                <div class="text-center py-8">
                    <i class="fas fa-book-open text-4xl text-gray-400 mb-4"></i>
                    <p class="text-gray-600">Belum ada chapter yang tersedia.</p>
                </div>
                <?php endif; ?>
            </div>
        </div>
        
        <!-- Sidebar -->
        <div class="space-y-6">
            <!-- Related Novels -->
            <div class="card-fantasy rounded-xl p-6 shadow-lg">
                <h3 class="text-xl font-fantasy font-bold text-purple-800 mb-4 flex items-center">
                    <i class="fas fa-magic mr-2 text-amber-500"></i>Novel Serupa
                </h3>
                
                <div class="space-y-4">
                    <?php foreach ($relatedNovels as $related): ?>
                    <a href="<?= base_url('novel/' . $related->id) ?>" class="block group">
                        <div class="flex space-x-3">
                            <img src="<?= $related->cover_image ? base_url('uploads/covers/' . $related->cover_image) : 'https://via.placeholder.com/80x120?text=No+Cover' ?>" 
                                 alt="<?= esc($related->title) ?>" class="w-12 h-16 object-cover rounded">
                            <div class="flex-1 min-w-0">
                                <h4 class="font-semibold text-sm text-gray-800 group-hover:text-purple-600 transition-colors line-clamp-2">
                                    <?= esc($related->title) ?>
                                </h4>
                                <p class="text-xs text-gray-600 mt-1">
                                    oleh <?= esc($related->authorName) ?>
                                </p>
                                <p class="text-xs text-gray-500 mt-1">
                                    <i class="fas fa-eye mr-1"></i><?= number_format($related->views) ?>
                                </p>
                            </div>
                        </div>
                    </a>
                    <?php endforeach; ?>
                </div>
            </div>
            
            <!-- Share -->
            <div class="card-fantasy rounded-xl p-6 shadow-lg">
                <h3 class="text-xl font-fantasy font-bold text-purple-800 mb-4 flex items-center">
                    <i class="fas fa-share-alt mr-2 text-amber-500"></i>Bagikan
                </h3>
                
                <div class="flex space-x-3">
                    <button class="w-10 h-10 bg-blue-500 rounded-full flex items-center justify-center text-white hover:bg-blue-600 transition-colors">
                        <i class="fab fa-facebook-f"></i>
                    </button>
                    <button class="w-10 h-10 bg-blue-400 rounded-full flex items-center justify-center text-white hover:bg-blue-500 transition-colors">
                        <i class="fab fa-twitter"></i>
                    </button>
                    <button class="w-10 h-10 bg-green-500 rounded-full flex items-center justify-center text-white hover:bg-green-600 transition-colors">
                        <i class="fab fa-whatsapp"></i>
                    </button>
                    <button class="w-10 h-10 bg-gray-500 rounded-full flex items-center justify-center text-white hover:bg-gray-600 transition-colors">
                        <i class="fas fa-link"></i>
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
</div>

<script>
// Synopsis Read More Functionality
document.addEventListener('DOMContentLoaded', function() {
    const synopsisText = document.getElementById('synopsis-text');
    const readMoreBtn = document.getElementById('read-more-btn');
    const maxLength = 300; // Maximum characters to show initially
    
    if (synopsisText) {
        const fullText = synopsisText.innerHTML;
        const textContent = synopsisText.textContent || synopsisText.innerText;
        
        if (textContent.length > maxLength) {
            const truncatedText = textContent.substring(0, maxLength) + '...';
            const truncatedHTML = fullText.substring(0, fullText.indexOf(textContent.substring(maxLength))) + '...';
            
            let isExpanded = false;
            
            // Initially show truncated text
            synopsisText.innerHTML = truncatedHTML;
            readMoreBtn.style.display = 'inline-block';
            
            readMoreBtn.addEventListener('click', function() {
                if (!isExpanded) {
                    synopsisText.innerHTML = fullText;
                    readMoreBtn.textContent = 'Tampilkan lebih sedikit';
                    isExpanded = true;
                } else {
                    synopsisText.innerHTML = truncatedHTML;
                    readMoreBtn.textContent = 'Baca selengkapnya';
                    isExpanded = false;
                }
            });
        }
    }
});

// Check bookmark status on page load
document.addEventListener('DOMContentLoaded', function() {
    const bookmarkBtn = document.getElementById('bookmark-btn');
    if (bookmarkBtn) {
        const novelId = bookmarkBtn.dataset.novelId;
        
        fetch('<?= base_url('check-bookmark') ?>/' + novelId)
            .then(response => response.json())
            .then(data => {
                const icon = bookmarkBtn.querySelector('i');
                const text = document.getElementById('bookmark-text');
                
                if (data.bookmarked) {
                    icon.classList.remove('far');
                    icon.classList.add('fas');
                    text.textContent = ' Hapus Bookmark';
                    bookmarkBtn.classList.add('text-amber-600');
                } else {
                    icon.classList.remove('fas');
                    icon.classList.add('far');
                    text.textContent = 'Bookmark';
                    bookmarkBtn.classList.remove('text-amber-600');
                }
            })
            .catch(error => {
                console.error('Error checking bookmark status:', error);
            });
    }
});

// Bookmark functionality
document.getElementById('bookmark-btn')?.addEventListener('click', function() {
    const novelId = this.dataset.novelId;
    const icon = this.querySelector('i');
    const text = document.getElementById('bookmark-text');
    const originalIcon = icon.className;
    const originalText = text.textContent;
    
    // Show loading state
    icon.className = 'fas fa-spinner fa-spin';
    text.textContent = 'Loading...';
    this.disabled = true;
    
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
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            if (data.bookmarked) {
                icon.className = 'fas fa-bookmark';
                text.textContent = ' Hapus Bookmark';
                this.classList.add('text-amber-600');
            } else {
                icon.className = 'far fa-bookmark';
                text.textContent = 'Bookmark';
                this.classList.remove('text-amber-600');
            }
            
            // Show toast notification
            showToast(data.message, 'success');
        } else {
            // Restore original state on error
            icon.className = originalIcon;
            text.textContent = originalText;
            showToast(data.message, 'error');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        icon.className = originalIcon;
        text.textContent = originalText;
        showToast('Terjadi kesalahan saat memproses bookmark', 'error');
    })
    .finally(() => {
        this.disabled = false;
    });
});

// Toast function
function showToast(message, type = 'success') {
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
</script>

<style>
.line-clamp-2 {
    display: -webkit-box;
    -webkit-line-clamp: 2;
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

/* Flexible Cover Image Styles - More Natural */
.cover-container {
    width: 100%;
    min-height: 20rem; /* 320px minimum height */
    max-height: 28rem; /* 448px maximum height */
    background-color: #f9fafb;
    display: flex;
    align-items: center;
    justify-content: center;
    overflow: hidden;
    border-radius: 0.5rem;
    margin: 1rem;
}

@media (min-width: 768px) {
    .cover-container {
        min-height: 24rem; /* 384px minimum on larger screens */
        max-height: 32rem; /* 512px maximum on larger screens */
        margin: 0;
        border-radius: 0;
    }
}

.cover-image {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform 0.3s ease;
}

.cover-image:hover {
    transform: scale(1.02);
}

/* Synopsis Styles */
.synopsis-container {
    position: relative;
}

.synopsis-text {
    transition: all 0.3s ease;
    line-height: 1.7;
}

.read-more-btn {
    background: none;
    border: none;
    cursor: pointer;
    padding: 0.25rem 0;
    font-size: inherit;
    text-decoration: underline;
    border-radius: 0.25rem;
    transition: all 0.2s ease;
}

.read-more-btn:hover {
    text-decoration: none;
    background-color: rgba(147, 51, 234, 0.1);
    padding: 0.25rem 0.5rem;
}

.read-more-btn:focus {
    outline: 2px solid rgba(147, 51, 234, 0.5);
    outline-offset: 2px;
}

/* Responsive adjustments */
@media (max-width: 767px) {
    .cover-container {
        margin: 0.5rem;
        border-radius: 0.75rem;
    }
}
</style>

<?= $this->endSection() ?>