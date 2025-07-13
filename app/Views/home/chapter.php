<?= $this->extend('home/layout/main') ?>

<?= $this->section('content') ?>
<!-- Chapter Header -->
<section class="bg-white border-b border-gray-200 sticky top-16 z-40">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-4">
        <!-- Breadcrumb -->
        <nav class="mb-4">
            <ol class="flex items-center space-x-2 text-sm text-gray-500">
                <li><a href="<?= base_url() ?>" class="hover:text-purple-600 transition-colors">Beranda</a></li>
                <li><i class="fas fa-chevron-right text-xs"></i></li>
                <li><a href="<?= base_url('novels') ?>" class="hover:text-purple-600 transition-colors">Novel</a></li>
                <li><i class="fas fa-chevron-right text-xs"></i></li>
                <li><a href="<?= base_url('novel/' . $novel->id) ?>" class="hover:text-purple-600 transition-colors"><?= esc($novel->title) ?></a></li>
                <li><i class="fas fa-chevron-right text-xs"></i></li>
                <li class="text-purple-600 font-medium"><?= esc($chapter->title) ?></li>
            </ol>
        </nav>

        <div class="flex flex-col md:flex-row justify-between items-start md:items-center space-y-4 md:space-y-0">
            <!-- Chapter Info -->
            <div>
                <h1 class="text-2xl font-bold text-gray-800 mb-2">
                    <?= esc($chapter->title) ?>
                </h1>
                <div class="flex items-center space-x-4 text-sm text-gray-600">
                    <span class="flex items-center">
                        <i class="fas fa-book mr-1 text-purple-500"></i>
                        <?= esc($novel->title) ?>
                    </span>
                    <span class="flex items-center">
                        <i class="fas fa-list-ol mr-1 text-purple-500"></i>
                        Chapter <?= $chapter->chapter_number ?>
                    </span>
                    <span class="flex items-center">
                        <i class="fas fa-clock mr-1 text-purple-500"></i>
                        <?= date('d M Y', strtotime($chapter->created_at)) ?>
                    </span>
                </div>
            </div>

            <!-- Reading Controls -->
            <div class="flex items-center space-x-2">
                <!-- Reading Settings Button -->
                <button id="settingsBtn" class="p-2 text-gray-600 hover:text-purple-600 hover:bg-purple-50 rounded-lg transition-colors" title="Pengaturan Baca">
                    <i class="fas fa-cog"></i>
                </button>
                
                <!-- Bookmark Button -->
                <?php if (session()->get('isLoggedIn')): ?>
                <button id="bookmarkBtn" class="p-2 text-gray-600 hover:text-red-500 hover:bg-red-50 rounded-lg transition-colors" title="Bookmark">
                    <i class="fas fa-bookmark"></i>
                </button>
                <?php endif; ?>
                
                <!-- Share Button -->
                <button id="shareBtn" class="p-2 text-gray-600 hover:text-blue-500 hover:bg-blue-50 rounded-lg transition-colors" title="Bagikan">
                    <i class="fas fa-share-alt"></i>
                </button>
            </div>
        </div>
    </div>
</section>

<!-- Reading Settings Panel -->
<div id="settingsPanel" class="fixed top-20 right-4 bg-white rounded-lg shadow-lg border border-gray-200 p-4 w-64 z-50 hidden">
    <h3 class="font-semibold text-gray-800 mb-4 flex items-center">
        <i class="fas fa-palette mr-2 text-purple-500"></i>
        Pengaturan Baca
    </h3>
    
    <!-- Font Size -->
    <div class="mb-4">
        <label class="block text-sm font-medium text-gray-700 mb-2">Ukuran Font</label>
        <div class="flex items-center space-x-2">
            <button id="fontDecrease" class="w-8 h-8 bg-gray-100 rounded flex items-center justify-center hover:bg-gray-200 transition-colors">
                <i class="fas fa-minus text-xs"></i>
            </button>
            <span id="fontSizeDisplay" class="text-sm text-gray-600 min-w-[3rem] text-center">16px</span>
            <button id="fontIncrease" class="w-8 h-8 bg-gray-100 rounded flex items-center justify-center hover:bg-gray-200 transition-colors">
                <i class="fas fa-plus text-xs"></i>
            </button>
        </div>
    </div>
    
    <!-- Background Theme -->
    <div class="mb-4">
        <label class="block text-sm font-medium text-gray-700 mb-2">Tema Latar</label>
        <div class="grid grid-cols-3 gap-2">
            <button class="theme-btn w-full h-8 bg-white border-2 border-gray-300 rounded flex items-center justify-center" data-theme="light">
                <i class="fas fa-sun text-yellow-500"></i>
            </button>
            <button class="theme-btn w-full h-8 bg-gray-800 border-2 border-gray-600 rounded flex items-center justify-center" data-theme="dark">
                <i class="fas fa-moon text-blue-300"></i>
            </button>
            <button class="theme-btn w-full h-8 bg-amber-50 border-2 border-amber-200 rounded flex items-center justify-center" data-theme="sepia">
                <i class="fas fa-leaf text-amber-600"></i>
            </button>
        </div>
    </div>
    
    <!-- Line Height -->
    <div class="mb-4">
        <label class="block text-sm font-medium text-gray-700 mb-2">Spasi Baris</label>
        <select id="lineHeightSelect" class="w-full border border-gray-300 rounded px-3 py-1 text-sm">
            <option value="1.5">Normal</option>
            <option value="1.8" selected>Lebar</option>
            <option value="2.0">Sangat Lebar</option>
        </select>
    </div>
</div>

<!-- Chapter Navigation (Top) -->
<section class="bg-gray-50 border-b border-gray-200">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-4">
        <div class="flex justify-between items-center">
            <!-- Previous Chapter -->
            <?php if ($prevChapter): ?>
            <a href="<?= base_url('novel/' . $novel->id . '/chapter/' . $prevChapter->chapter_number) ?>" 
               class="flex items-center space-x-2 text-purple-600 hover:text-purple-800 transition-colors group">
                <div class="w-8 h-8 bg-purple-100 rounded-full flex items-center justify-center group-hover:bg-purple-200 transition-colors">
                    <i class="fas fa-chevron-left text-sm"></i>
                </div>
                <div class="hidden sm:block">
                    <div class="text-xs text-gray-500">Chapter Sebelumnya</div>
                    <div class="font-medium"><?= esc($prevChapter->title) ?></div>
                </div>
            </a>
            <?php else: ?>
            <div class="flex items-center space-x-2 text-gray-400">
                <div class="w-8 h-8 bg-gray-100 rounded-full flex items-center justify-center">
                    <i class="fas fa-chevron-left text-sm"></i>
                </div>
                <div class="hidden sm:block">
                    <div class="text-xs">Chapter Pertama</div>
                </div>
            </div>
            <?php endif; ?>

            <!-- Chapter List Button -->
            <a href="<?= base_url('novel/' . $novel->id) ?>" 
               class="flex items-center space-x-2 text-gray-600 hover:text-purple-600 transition-colors">
                <i class="fas fa-list"></i>
                <span class="hidden sm:inline">Daftar Chapter</span>
            </a>

            <!-- Next Chapter -->
            <?php if ($nextChapter): ?>
            <a href="<?= base_url('novel/' . $novel->id . '/chapter/' . $nextChapter->chapter_number) ?>" 
               class="flex items-center space-x-2 text-purple-600 hover:text-purple-800 transition-colors group">
                <div class="hidden sm:block text-right">
                    <div class="text-xs text-gray-500">Chapter Selanjutnya</div>
                    <div class="font-medium"><?= esc($nextChapter->title) ?></div>
                </div>
                <div class="w-8 h-8 bg-purple-100 rounded-full flex items-center justify-center group-hover:bg-purple-200 transition-colors">
                    <i class="fas fa-chevron-right text-sm"></i>
                </div>
            </a>
            <?php else: ?>
            <div class="flex items-center space-x-2 text-gray-400">
                <div class="hidden sm:block text-right">
                    <div class="text-xs">Chapter Terakhir</div>
                </div>
                <div class="w-8 h-8 bg-gray-100 rounded-full flex items-center justify-center">
                    <i class="fas fa-chevron-right text-sm"></i>
                </div>
            </div>
            <?php endif; ?>
        </div>
    </div>
</section>

<!-- Chapter Content -->
<main id="chapterContent" class="reading-content py-8 transition-all duration-300">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <article class="prose prose-lg max-w-none">
            <!-- Chapter Title -->
            <header class="text-center mb-12 pb-8 border-b border-gray-200">
                <h1 class="text-3xl md:text-4xl font-fantasy font-bold text-gray-800 mb-4">
                    <?= esc($chapter->title) ?>
                </h1>
                <div class="flex items-center justify-center space-x-6 text-sm text-gray-600">
                    <span class="flex items-center">
                        <i class="fas fa-book mr-2 text-purple-500"></i>
                        <?= esc($novel->title) ?>
                    </span>
                    <span class="flex items-center">
                        <i class="fas fa-hashtag mr-2 text-purple-500"></i>
                        Chapter <?= $chapter->chapter_number ?>
                    </span>
                </div>
            </header>

            <!-- Chapter Text Content -->
            <div id="chapterText" class="chapter-text leading-relaxed text-gray-800">
                <?= nl2br(esc($chapter->content)) ?>
            </div>

            <!-- Chapter End -->
            <footer class="text-center mt-12 pt-8 border-t border-gray-200">
                <div class="mb-6">
                    <i class="fas fa-sparkles text-2xl text-purple-400 animate-pulse"></i>
                </div>
                <p class="text-gray-600 mb-6">
                    <i class="fas fa-heart text-red-400 mr-2"></i>
                    Terima kasih telah membaca chapter ini!
                </p>
                
                <!-- Social Actions -->
                <div class="flex items-center justify-center space-x-4 mb-8">
                    <?php if (session()->get('isLoggedIn')): ?>
                    <button class="flex items-center space-x-2 px-4 py-2 bg-red-100 text-red-600 rounded-lg hover:bg-red-200 transition-colors">
                        <i class="fas fa-heart"></i>
                        <span>Suka</span>
                    </button>
                    <button class="flex items-center space-x-2 px-4 py-2 bg-blue-100 text-blue-600 rounded-lg hover:bg-blue-200 transition-colors">
                        <i class="fas fa-comment"></i>
                        <span>Komentar</span>
                    </button>
                    <?php endif; ?>
                    <button class="flex items-center space-x-2 px-4 py-2 bg-green-100 text-green-600 rounded-lg hover:bg-green-200 transition-colors">
                        <i class="fas fa-share"></i>
                        <span>Bagikan</span>
                    </button>
                </div>
            </footer>
        </article>
    </div>
</main>

<!-- Chapter Navigation (Bottom) -->
<section class="bg-gray-50 border-t border-gray-200">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <!-- Previous Chapter -->
            <div>
                <?php if ($prevChapter): ?>
                <a href="<?= base_url('novel/' . $novel->id . '/chapter/' . $prevChapter->chapter_number) ?>" 
                   class="block p-4 bg-white rounded-lg border border-gray-200 hover:border-purple-300 hover:shadow-md transition-all group">
                    <div class="flex items-center space-x-3">
                        <div class="w-10 h-10 bg-purple-100 rounded-full flex items-center justify-center group-hover:bg-purple-200 transition-colors">
                            <i class="fas fa-chevron-left text-purple-600"></i>
                        </div>
                        <div class="flex-1 min-w-0">
                            <div class="text-xs text-gray-500 mb-1">Chapter Sebelumnya</div>
                            <div class="font-medium text-gray-800 truncate"><?= esc($prevChapter->title) ?></div>
                        </div>
                    </div>
                </a>
                <?php endif; ?>
            </div>

            <!-- Back to Novel -->
            <div class="flex justify-center">
                <a href="<?= base_url('novel/' . $novel->id) ?>" 
                   class="flex items-center space-x-2 px-6 py-3 bg-purple-600 text-white rounded-lg hover:bg-purple-700 transition-colors">
                    <i class="fas fa-list"></i>
                    <span>Daftar Chapter</span>
                </a>
            </div>

            <!-- Next Chapter -->
            <div class="flex justify-end">
                <?php if ($nextChapter): ?>
                <a href="<?= base_url('novel/' . $novel->id . '/chapter/' . $nextChapter->chapter_number) ?>" 
                   class="block p-4 bg-white rounded-lg border border-gray-200 hover:border-purple-300 hover:shadow-md transition-all group">
                    <div class="flex items-center space-x-3">
                        <div class="flex-1 min-w-0 text-right">
                            <div class="text-xs text-gray-500 mb-1">Chapter Selanjutnya</div>
                            <div class="font-medium text-gray-800 truncate"><?= esc($nextChapter->title) ?></div>
                        </div>
                        <div class="w-10 h-10 bg-purple-100 rounded-full flex items-center justify-center group-hover:bg-purple-200 transition-colors">
                            <i class="fas fa-chevron-right text-purple-600"></i>
                        </div>
                    </div>
                </a>
                <?php endif; ?>
            </div>
        </div>
    </div>
</section>

<!-- Reading Progress Bar -->
<div id="progressBar" class="fixed bottom-0 left-0 w-full h-1 bg-gray-200 z-50">
    <div id="progressFill" class="h-full bg-gradient-to-r from-purple-500 to-purple-600 transition-all duration-300" style="width: 0%"></div>
</div>

<!-- Floating Navigation (Mobile) -->
<div class="fixed bottom-4 right-4 flex flex-col space-y-2 md:hidden z-40">
    <?php if ($prevChapter): ?>
    <a href="<?= base_url('novel/' . $novel->id . '/chapter/' . $prevChapter->chapter_number) ?>" 
       class="w-12 h-12 bg-purple-600 text-white rounded-full flex items-center justify-center shadow-lg hover:bg-purple-700 transition-colors">
        <i class="fas fa-chevron-left"></i>
    </a>
    <?php endif; ?>
    
    <?php if ($nextChapter): ?>
    <a href="<?= base_url('novel/' . $novel->id . '/chapter/' . $nextChapter->chapter_number) ?>" 
       class="w-12 h-12 bg-purple-600 text-white rounded-full flex items-center justify-center shadow-lg hover:bg-purple-700 transition-colors">
        <i class="fas fa-chevron-right"></i>
    </a>
    <?php endif; ?>
</div>

<style>
/* Reading Themes */
.reading-content.light {
    background-color: #ffffff;
    color: #1f2937;
}

.reading-content.dark {
    background-color: #1f2937;
    color: #f9fafb;
}

.reading-content.sepia {
    background-color: #fef7ed;
    color: #451a03;
}

.chapter-text {
    font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
    line-height: 1.8;
    font-size: 16px;
    text-align: justify;
    word-spacing: 0.1em;
}

.chapter-text p {
    margin-bottom: 1.5em;
    text-indent: 2em;
}

.chapter-text p:first-child {
    text-indent: 0;
}

/* Smooth scrolling */
html {
    scroll-behavior: smooth;
}

/* Hide scrollbar but keep functionality */
.reading-content::-webkit-scrollbar {
    width: 6px;
}

.reading-content::-webkit-scrollbar-track {
    background: transparent;
}

.reading-content::-webkit-scrollbar-thumb {
    background: rgba(139, 92, 246, 0.3);
    border-radius: 3px;
}

.reading-content::-webkit-scrollbar-thumb:hover {
    background: rgba(139, 92, 246, 0.5);
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Reading Settings
    const settingsBtn = document.getElementById('settingsBtn');
    const settingsPanel = document.getElementById('settingsPanel');
    const chapterContent = document.getElementById('chapterContent');
    const chapterText = document.getElementById('chapterText');
    
    // Font size controls
    const fontDecrease = document.getElementById('fontDecrease');
    const fontIncrease = document.getElementById('fontIncrease');
    const fontSizeDisplay = document.getElementById('fontSizeDisplay');
    
    // Theme buttons
    const themeButtons = document.querySelectorAll('.theme-btn');
    
    // Line height control
    const lineHeightSelect = document.getElementById('lineHeightSelect');
    
    // Progress bar
    const progressBar = document.getElementById('progressFill');
    
    // Load saved settings
    let fontSize = parseInt(localStorage.getItem('fontSize')) || 16;
    let theme = localStorage.getItem('readingTheme') || 'light';
    let lineHeight = localStorage.getItem('lineHeight') || '1.8';
    
    // Apply saved settings
    applyFontSize(fontSize);
    applyTheme(theme);
    applyLineHeight(lineHeight);
    
    // Settings panel toggle
    settingsBtn.addEventListener('click', function(e) {
        e.stopPropagation();
        settingsPanel.classList.toggle('hidden');
    });
    
    // Close settings panel when clicking outside
    document.addEventListener('click', function(e) {
        if (!settingsPanel.contains(e.target) && !settingsBtn.contains(e.target)) {
            settingsPanel.classList.add('hidden');
        }
    });
    
    // Font size controls
    fontDecrease.addEventListener('click', function() {
        if (fontSize > 12) {
            fontSize -= 2;
            applyFontSize(fontSize);
            localStorage.setItem('fontSize', fontSize);
        }
    });
    
    fontIncrease.addEventListener('click', function() {
        if (fontSize < 24) {
            fontSize += 2;
            applyFontSize(fontSize);
            localStorage.setItem('fontSize', fontSize);
        }
    });
    
    // Theme controls
    themeButtons.forEach(button => {
        button.addEventListener('click', function() {
            const selectedTheme = this.dataset.theme;
            applyTheme(selectedTheme);
            localStorage.setItem('readingTheme', selectedTheme);
        });
    });
    
    // Line height control
    lineHeightSelect.addEventListener('change', function() {
        const selectedLineHeight = this.value;
        applyLineHeight(selectedLineHeight);
        localStorage.setItem('lineHeight', selectedLineHeight);
    });
    
    // Functions
    function applyFontSize(size) {
        chapterText.style.fontSize = size + 'px';
        fontSizeDisplay.textContent = size + 'px';
    }
    
    function applyTheme(themeName) {
        chapterContent.className = chapterContent.className.replace(/\b(light|dark|sepia)\b/g, '');
        chapterContent.classList.add(themeName);
        
        // Update theme button states
        themeButtons.forEach(btn => {
            btn.classList.remove('ring-2', 'ring-purple-500');
            if (btn.dataset.theme === themeName) {
                btn.classList.add('ring-2', 'ring-purple-500');
            }
        });
    }
    
    function applyLineHeight(height) {
        chapterText.style.lineHeight = height;
        lineHeightSelect.value = height;
    }
    
    // Reading progress
    function updateProgress() {
        const scrollTop = window.pageYOffset;
        const docHeight = document.body.scrollHeight - window.innerHeight;
        const scrollPercent = (scrollTop / docHeight) * 100;
        progressBar.style.width = Math.min(scrollPercent, 100) + '%';
    }
    
    window.addEventListener('scroll', updateProgress);
    
    // Keyboard navigation
    document.addEventListener('keydown', function(e) {
        if (e.key === 'ArrowLeft' && e.ctrlKey) {
            // Previous chapter
            <?php if ($prevChapter): ?>
            window.location.href = '<?= base_url('novel/' . $novel->id . '/chapter/' . $prevChapter->chapter_number) ?>';
            <?php endif; ?>
        } else if (e.key === 'ArrowRight' && e.ctrlKey) {
            // Next chapter
            <?php if ($nextChapter): ?>
            window.location.href = '<?= base_url('novel/' . $novel->id . '/chapter/' . $nextChapter->chapter_number) ?>';
            <?php endif; ?>
        }
    });
    
    // Auto-save reading position
    let readingTimer;
    window.addEventListener('scroll', function() {
        clearTimeout(readingTimer);
        readingTimer = setTimeout(function() {
            // Save reading position to localStorage or send to server
            const scrollPosition = window.pageYOffset;
            localStorage.setItem('chapter_<?= $chapter->id ?>_position', scrollPosition);
        }, 1000);
    });
    
    // Restore reading position
    const savedPosition = localStorage.getItem('chapter_<?= $chapter->id ?>_position');
    if (savedPosition) {
        setTimeout(() => {
            window.scrollTo(0, parseInt(savedPosition));
        }, 100);
    }
    
    // Share functionality
    const shareBtn = document.getElementById('shareBtn');
    if (shareBtn) {
        shareBtn.addEventListener('click', function() {
            if (navigator.share) {
                navigator.share({
                    title: '<?= esc($chapter->title) ?> - <?= esc($novel->title) ?>',
                    text: 'Baca chapter ini di Narria!',
                    url: window.location.href
                });
            } else {
                // Fallback: copy to clipboard
                navigator.clipboard.writeText(window.location.href).then(() => {
                    alert('Link berhasil disalin!');
                });
            }
        });
    }
});
</script>
<?= $this->endSection() ?>
