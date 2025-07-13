<?= $this->extend('home/layout/main') ?>

<?= $this->section('content') ?>

<div class="min-h-screen bg-gradient-to-br from-purple-50 via-pink-50 to-indigo-50 py-12 relative overflow-hidden">
    <!-- Floating Decorative Elements -->
    <div class="fixed inset-0 pointer-events-none overflow-hidden">
        <div class="absolute top-10 left-10 w-20 h-20 bg-gradient-to-r from-purple-400 to-pink-400 rounded-full opacity-20 animate-bounce" style="animation-delay: 0s;"></div>
        <div class="absolute top-32 right-20 w-16 h-16 bg-gradient-to-r from-amber-400 to-orange-400 rounded-full opacity-20 animate-bounce" style="animation-delay: 1s;"></div>
        <div class="absolute bottom-20 left-20 w-24 h-24 bg-gradient-to-r from-blue-400 to-cyan-400 rounded-full opacity-20 animate-bounce" style="animation-delay: 2s;"></div>
        <div class="absolute bottom-32 right-10 w-18 h-18 bg-gradient-to-r from-green-400 to-emerald-400 rounded-full opacity-20 animate-bounce" style="animation-delay: 0.5s;"></div>
        
        <!-- Floating Fantasy Icons -->
        <div class="absolute top-20 right-32 text-4xl text-purple-300 opacity-30 animate-float">✨</div>
        <div class="absolute top-40 left-32 text-3xl text-pink-300 opacity-30 animate-float" style="animation-delay: 1s;">🌟</div>
        <div class="absolute bottom-40 right-40 text-5xl text-amber-300 opacity-30 animate-float" style="animation-delay: 2s;">⭐</div>
        <div class="absolute bottom-20 left-40 text-3xl text-blue-300 opacity-30 animate-float" style="animation-delay: 1.5s;">💫</div>
    </div>

    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
        
        <!-- Profile Header with Rich Decorations -->
        <div class="relative rounded-3xl p-8 mb-8 text-center overflow-hidden">
            <!-- Multi-layered Background -->
            <div class="absolute inset-0 bg-gradient-to-br from-purple-600 via-pink-500 to-indigo-600 opacity-90"></div>
            <div class="absolute inset-0 bg-gradient-to-tl from-amber-400 via-transparent to-cyan-400 opacity-30"></div>
            
            <!-- Decorative Patterns -->
            <div class="absolute inset-0 opacity-10">
                <div class="absolute inset-0" style="background-image: url('data:image/svg+xml,%3Csvg width=\'80\' height=\'80\' viewBox=\'0 0 80 80\' xmlns=\'http://www.w3.org/2000/svg\'%3E%3Cg fill=\'none\' fill-rule=\'evenodd\'%3E%3Cg fill=\'%23ffffff\' fill-opacity=\'0.8\'%3E%3Cpath d=\'M0 0h80v80H0V0zm20 20v40h40V20H20zm20 35a15 15 0 1 1 0-30 15 15 0 0 1 0 30z\' fill-rule=\'nonzero\'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E');"></div>
            </div>
            
            <!-- Corner Ornaments -->
            <div class="absolute top-4 left-4 w-16 h-16 border-4 border-white border-opacity-30 rounded-full flex items-center justify-center">
                <i class="fas fa-crown text-white text-xl opacity-60"></i>
            </div>
            <div class="absolute top-4 right-4 w-16 h-16 border-4 border-white border-opacity-30 rounded-full flex items-center justify-center">
                <i class="fas fa-magic text-white text-xl opacity-60"></i>
            </div>
            <div class="absolute bottom-4 left-4 w-16 h-16 border-4 border-white border-opacity-30 rounded-full flex items-center justify-center">
                <i class="fas fa-gem text-white text-xl opacity-60"></i>
            </div>
            <div class="absolute bottom-4 right-4 w-16 h-16 border-4 border-white border-opacity-30 rounded-full flex items-center justify-center">
                <i class="fas fa-dragon text-white text-xl opacity-60"></i>
            </div>
            
            <div class="relative z-10">
                <!-- Enhanced Profile Picture with Multiple Effects -->
                <div class="relative inline-block mb-8">
                    <!-- Outer Glow Ring -->
                    <div class="absolute inset-0 bg-gradient-to-r from-pink-400 via-purple-400 to-indigo-400 rounded-full blur-xl opacity-75 animate-pulse scale-125"></div>
                    
                    <!-- Middle Ring -->
                    <div class="absolute inset-0 bg-gradient-to-r from-amber-300 to-orange-300 rounded-full blur-lg opacity-50 animate-spin-slow scale-110"></div>
                    
                    <!-- Profile Picture Container -->
                    <div class="relative">
                        <?php if ($user->profile): ?>
                            <div class="relative">
                                <div class="w-40 h-40 rounded-full p-2 bg-gradient-to-r from-white via-yellow-100 to-white shadow-2xl">
                                    <img src="<?= base_url('uploads/profile/' . $user->profile) ?>" 
                                         alt="<?= esc($displayName) ?>" 
                                         class="w-full h-full rounded-full object-cover">
                                </div>
                            </div>
                        <?php else: ?>
                            <div class="w-40 h-40 rounded-full p-2 bg-gradient-to-r from-white via-yellow-100 to-white shadow-2xl">
                                <div class="w-full h-full gradient-fantasy rounded-full flex items-center justify-center text-white text-5xl font-bold">
                                    <?= strtoupper(substr($displayName, 0, 2)) ?>
                                </div>
                            </div>
                        <?php endif; ?>
                        
                        <!-- Enhanced Role Badge with Ornaments -->
                        <?php if ($user->role === 'author'): ?>
                        <div class="absolute -bottom-3 -right-3">
                            <div class="relative w-16 h-16 bg-gradient-to-r from-amber-400 to-orange-500 rounded-full flex items-center justify-center shadow-xl border-4 border-white">
                                <div class="absolute inset-0 bg-gradient-to-r from-yellow-300 to-amber-300 rounded-full blur opacity-75 animate-pulse scale-125"></div>
                                <i class="fas fa-feather-alt text-purple-900 text-xl relative z-10"></i>
                                <!-- Decorative Stars -->
                                <div class="absolute -top-1 -left-1 text-yellow-300 text-xs animate-twinkle">✨</div>
                                <div class="absolute -bottom-1 -right-1 text-yellow-300 text-xs animate-twinkle" style="animation-delay: 0.5s;">⭐</div>
                            </div>
                        </div>
                        <?php elseif ($user->role === 'admin'): ?>
                        <div class="absolute -bottom-3 -right-3">
                            <div class="relative w-16 h-16 bg-gradient-to-r from-red-500 to-red-700 rounded-full flex items-center justify-center shadow-xl border-4 border-white">
                                <div class="absolute inset-0 bg-gradient-to-r from-red-400 to-pink-400 rounded-full blur opacity-75 animate-pulse scale-125"></div>
                                <i class="fas fa-crown text-white text-xl relative z-10"></i>
                                <!-- Royal Ornaments -->
                                <div class="absolute -top-2 left-1/2 transform -translate-x-1/2 text-yellow-300 text-xs animate-bounce">👑</div>
                            </div>
                        </div>
                        <?php else: ?>
                        <div class="absolute -bottom-3 -right-3">
                            <div class="relative w-16 h-16 bg-gradient-to-r from-blue-500 to-purple-600 rounded-full flex items-center justify-center shadow-xl border-4 border-white">
                                <div class="absolute inset-0 bg-gradient-to-r from-blue-400 to-cyan-400 rounded-full blur opacity-75 animate-pulse scale-125"></div>
                                <i class="fas fa-book-reader text-white text-xl relative z-10"></i>
                                <!-- Reading Sparkles -->
                                <div class="absolute -top-1 -right-1 text-cyan-300 text-xs animate-twinkle">📚</div>
                            </div>
                        </div>
                        <?php endif; ?>
                    </div>
                </div>

                <!-- Enhanced Name Section with Rich Typography -->
                <div class="mb-8">
                    <!-- Display Name with Multiple Effects -->
                    <div class="relative mb-4">
                        <h1 class="text-5xl font-fantasy font-bold text-white mb-2 relative z-10 drop-shadow-2xl">
                            <?= esc($displayName) ?>
                        </h1>
                        <!-- Text Shadow Effect -->
                        <div class="absolute inset-0 text-5xl font-fantasy font-bold text-purple-200 opacity-50 blur-sm">
                            <?= esc($displayName) ?>
                        </div>
                    </div>
                    
                    <!-- Username with Decorative Frame -->
                    <div class="flex items-center justify-center mb-6">
                        <div class="relative bg-white bg-opacity-20 backdrop-blur-sm px-6 py-3 rounded-full border-2 border-white border-opacity-30">
                            <!-- Decorative Elements -->
                            <div class="absolute -left-2 top-1/2 transform -translate-y-1/2 w-4 h-4 bg-gradient-to-r from-pink-400 to-purple-400 rounded-full"></div>
                            <div class="absolute -right-2 top-1/2 transform -translate-y-1/2 w-4 h-4 bg-gradient-to-r from-amber-400 to-orange-400 rounded-full"></div>
                            
                            <span class="text-white font-bold text-xl">
                                <i class="fas fa-at mr-2 text-yellow-300"></i><?= esc($user->username) ?>
                            </span>
                        </div>
                    </div>
                    
                    <!-- Profile URL with Ornate Design -->
                    <div class="text-white text-opacity-80 mb-6">
                        <div class="inline-flex items-center bg-white bg-opacity-10 backdrop-blur-sm px-4 py-2 rounded-lg border border-white border-opacity-20">
                            <i class="fas fa-link mr-2 text-cyan-300"></i>
                            <span class="font-mono">narria.com/profile/<?= esc($user->username) ?></span>
                        </div>
                    </div>
                </div>

                <!-- Enhanced Role Badge with Rich Design -->
                <div class="flex items-center justify-center mb-8">
                    <?php if ($user->role === 'author'): ?>
                        <div class="relative">
                            <!-- Glow Effect -->
                            <div class="absolute inset-0 bg-gradient-to-r from-amber-400 to-orange-400 rounded-full blur-lg opacity-75 scale-110"></div>
                            <!-- Main Badge -->
                            <div class="relative bg-gradient-to-r from-amber-400 via-yellow-400 to-orange-400 text-purple-900 px-8 py-4 rounded-full font-bold text-lg shadow-2xl border-2 border-white">
                                <i class="fas fa-feather-alt mr-3"></i>Penulis Fantasi
                                <!-- Decorative Elements -->
                                <div class="absolute -top-2 -left-2 text-white text-sm animate-bounce">✨</div>
                                <div class="absolute -top-2 -right-2 text-white text-sm animate-bounce" style="animation-delay: 0.5s;">🌟</div>
                            </div>
                        </div>
                    <?php elseif ($user->role === 'admin'): ?>
                        <div class="relative">
                            <div class="absolute inset-0 bg-gradient-to-r from-red-500 to-pink-500 rounded-full blur-lg opacity-75 scale-110"></div>
                            <div class="relative bg-gradient-to-r from-red-500 via-red-600 to-red-700 text-white px-8 py-4 rounded-full font-bold text-lg shadow-2xl border-2 border-yellow-300">
                                <i class="fas fa-crown mr-3"></i>Administrator
                                <div class="absolute -top-3 left-1/2 transform -translate-x-1/2 text-yellow-300 text-lg animate-bounce">👑</div>
                            </div>
                        </div>
                    <?php else: ?>
                        <div class="relative">
                            <div class="absolute inset-0 bg-gradient-to-r from-blue-500 to-purple-500 rounded-full blur-lg opacity-75 scale-110"></div>
                            <div class="relative bg-gradient-to-r from-blue-500 via-purple-500 to-indigo-600 text-white px-8 py-4 rounded-full font-bold text-lg shadow-2xl border-2 border-cyan-300">
                                <i class="fas fa-book-reader mr-3"></i>Pembaca Setia
                                <div class="absolute -top-2 -right-2 text-cyan-300 text-sm animate-pulse">📖</div>
                            </div>
                        </div>
                    <?php endif; ?>
                </div>

                <!-- Enhanced Bio Section -->
                <?php if ($user->bio): ?>
                <div class="max-w-2xl mx-auto mb-8">
                    <div class="relative bg-white bg-opacity-20 backdrop-blur-sm rounded-2xl p-6 border border-white border-opacity-30">
                        <!-- Decorative Corner Elements -->
                        <div class="absolute top-2 left-2 w-6 h-6 border-l-2 border-t-2 border-white border-opacity-50"></div>
                        <div class="absolute top-2 right-2 w-6 h-6 border-r-2 border-t-2 border-white border-opacity-50"></div>
                        <div class="absolute bottom-2 left-2 w-6 h-6 border-l-2 border-b-2 border-white border-opacity-50"></div>
                        <div class="absolute bottom-2 right-2 w-6 h-6 border-r-2 border-b-2 border-white border-opacity-50"></div>
                        
                        <p class="text-white leading-relaxed italic text-lg">
                            <span class="text-yellow-300 text-2xl">"</span>
                            <?= esc($user->bio) ?>
                            <span class="text-yellow-300 text-2xl">"</span>
                        </p>
                    </div>
                </div>
                <?php endif; ?>

                <!-- Enhanced Location & Website -->
                <?php if ($user->location || $user->website): ?>
                <div class="flex flex-wrap justify-center gap-6 mb-8">
                    <?php if ($user->location): ?>
                    <div class="relative bg-white bg-opacity-20 backdrop-blur-sm px-6 py-3 rounded-full border border-white border-opacity-30">
                        <div class="absolute -left-1 top-1/2 transform -translate-y-1/2 w-3 h-3 bg-red-400 rounded-full animate-ping"></div>
                        <i class="fas fa-map-marker-alt mr-2 text-red-300"></i>
                        <span class="text-white font-medium"><?= esc($user->location) ?></span>
                    </div>
                    <?php endif; ?>
                    
                    <?php if ($user->website): ?>
                    <a href="<?= esc($user->website) ?>" target="_blank" 
                       class="relative bg-white bg-opacity-20 backdrop-blur-sm px-6 py-3 rounded-full border border-white border-opacity-30 hover:bg-opacity-30 transition-all group">
                        <div class="absolute -left-1 top-1/2 transform -translate-y-1/2 w-3 h-3 bg-green-400 rounded-full animate-pulse"></div>
                        <i class="fas fa-globe mr-2 text-green-300"></i>
                        <span class="text-white font-medium group-hover:text-green-200"><?= esc(parse_url($user->website, PHP_URL_HOST)) ?></span>
                        <i class="fas fa-external-link-alt ml-2 text-xs text-green-300"></i>
                    </a>
                    <?php endif; ?>
                </div>
                <?php endif; ?>

                <!-- Super Enhanced Social Links -->
                <?php if ($user->twitter || $user->instagram || $user->facebook): ?>
                <div class="flex justify-center space-x-6 mb-8">
                    <?php if ($user->twitter): ?>
                    <a href="https://twitter.com/<?= esc($user->twitter) ?>" target="_blank" 
                       class="group relative">
                        <div class="absolute inset-0 bg-blue-400 rounded-full blur-lg opacity-0 group-hover:opacity-75 transition-all duration-300 scale-150"></div>
                        <div class="relative w-16 h-16 bg-gradient-to-r from-blue-400 to-blue-600 rounded-full flex items-center justify-center text-white hover:scale-125 transition-all duration-300 shadow-2xl border-2 border-white">
                            <i class="fab fa-twitter text-2xl"></i>
                            <div class="absolute -top-2 -right-2 text-cyan-300 text-xs animate-bounce">🐦</div>
                        </div>
                    </a>
                    <?php endif; ?>
                    
                    <?php if ($user->instagram): ?>
                    <a href="https://instagram.com/<?= esc($user->instagram) ?>" target="_blank" 
                       class="group relative">
                        <div class="absolute inset-0 bg-pink-500 rounded-full blur-lg opacity-0 group-hover:opacity-75 transition-all duration-300 scale-150"></div>
                        <div class="relative w-16 h-16 bg-gradient-to-r from-pink-500 via-purple-500 to-indigo-500 rounded-full flex items-center justify-center text-white hover:scale-125 transition-all duration-300 shadow-2xl border-2 border-white">
                            <i class="fab fa-instagram text-2xl"></i>
                            <div class="absolute -top-2 -right-2 text-pink-300 text-xs animate-spin">📸</div>
                        </div>
                    </a>
                    <?php endif; ?>
                    
                    <?php if ($user->facebook): ?>
                    <a href="https://facebook.com/<?= esc($user->facebook) ?>" target="_blank" 
                       class="group relative">
                        <div class="absolute inset-0 bg-blue-600 rounded-full blur-lg opacity-0 group-hover:opacity-75 transition-all duration-300 scale-150"></div>
                        <div class="relative w-16 h-16 bg-gradient-to-r from-blue-600 to-blue-800 rounded-full flex items-center justify-center text-white hover:scale-125 transition-all duration-300 shadow-2xl border-2 border-white">
                            <i class="fab fa-facebook-f text-2xl"></i>
                            <div class="absolute -top-2 -right-2 text-blue-300 text-xs animate-pulse">👥</div>
                        </div>
                    </a>
                    <?php endif; ?>
                </div>
                <?php endif; ?>

                <!-- Enhanced Action Buttons -->
                <?php if ($isOwnProfile): ?>
                <div class="flex flex-wrap justify-center gap-6">
                    <a href="<?= base_url('profile/edit') ?>" 
                       class="group relative bg-gradient-to-r from-emerald-400 via-cyan-400 to-blue-500 hover:from-emerald-500 hover:via-cyan-500 hover:to-blue-600 text-white font-bold py-4 px-8 rounded-2xl transition-all duration-300 shadow-2xl inline-flex items-center border-2 border-white transform hover:scale-110">
                        <div class="absolute inset-0 bg-white opacity-0 group-hover:opacity-20 transition-opacity rounded-2xl"></div>
                        <i class="fas fa-edit mr-3 text-xl"></i>
                        <span class="text-lg">Edit Profile</span>
                        <div class="absolute -top-2 -right-2 text-yellow-300 text-sm animate-bounce">✏️</div>
                    </a>
                    <a href="<?= base_url('profile/bookmarks') ?>" 
                       class="group relative bg-gradient-to-r from-purple-500 via-pink-500 to-red-500 hover:from-purple-600 hover:via-pink-600 hover:to-red-600 text-white font-bold py-4 px-8 rounded-2xl transition-all duration-300 shadow-2xl inline-flex items-center border-2 border-white transform hover:scale-110">
                        <i class="fas fa-bookmark mr-3 text-xl"></i>
                        <span class="text-lg">Bookmark</span>
                        <div class="absolute -top-2 -right-2 text-yellow-300 text-sm animate-pulse">🔖</div>
                    </a>
                    <a href="<?= base_url('profile/history') ?>" 
                       class="group relative bg-gradient-to-r from-amber-500 via-orange-500 to-red-500 hover:from-amber-600 hover:via-orange-600 hover:to-red-600 text-white font-bold py-4 px-8 rounded-2xl transition-all duration-300 shadow-2xl inline-flex items-center border-2 border-white transform hover:scale-110">
                        <i class="fas fa-history mr-3 text-xl"></i>
                        <span class="text-lg">Riwayat</span>
                        <div class="absolute -top-2 -right-2 text-yellow-300 text-sm animate-spin">⏰</div>
                    </a>
                </div>
                <?php endif; ?>
            </div>
        </div>

        <!-- Super Enhanced Reader Stats -->
        <?php if ($isOwnProfile && isset($readerStats)): ?>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 mb-12">
            <div class="relative group">
                <div class="absolute inset-0 bg-gradient-to-r from-purple-400 to-pink-400 rounded-2xl blur-lg opacity-75 group-hover:opacity-100 transition-all duration-300"></div>
                <div class="relative bg-white rounded-2xl p-8 text-center shadow-2xl border-2 border-purple-200 transform group-hover:scale-105 transition-all duration-300">
                    <div class="w-20 h-20 bg-gradient-to-r from-purple-500 to-pink-500 rounded-full flex items-center justify-center mx-auto mb-6 shadow-xl relative">
                        <i class="fas fa-bookmark text-white text-3xl"></i>
                        <div class="absolute -top-2 -right-2 w-6 h-6 bg-yellow-400 rounded-full flex items-center justify-center">
                            <span class="text-xs font-bold text-purple-900"><?= $readerStats['total_bookmarks'] > 99 ? '99+' : $readerStats['total_bookmarks'] ?></span>
                        </div>
                    </div>
                    <div class="text-4xl font-bold bg-gradient-to-r from-purple-600 to-pink-600 bg-clip-text text-transparent mb-3"><?= $readerStats['total_bookmarks'] ?></div>
                    <div class="text-gray-700 font-semibold text-lg">Novel Tersimpan</div>
                    <div class="absolute top-4 right-4 text-purple-300 text-2xl animate-bounce">📚</div>
                </div>
            </div>
            
            <div class="relative group">
                <div class="absolute inset-0 bg-gradient-to-r from-amber-400 to-orange-400 rounded-2xl blur-lg opacity-75 group-hover:opacity-100 transition-all duration-300"></div>
                <div class="relative bg-white rounded-2xl p-8 text-center shadow-2xl border-2 border-amber-200 transform group-hover:scale-105 transition-all duration-300">
                    <div class="w-20 h-20 bg-gradient-to-r from-amber-500 to-orange-500 rounded-full flex items-center justify-center mx-auto mb-6 shadow-xl relative">
                        <i class="fas fa-book-open text-white text-3xl"></i>
                        <div class="absolute -top-2 -right-2 w-6 h-6 bg-green-400 rounded-full flex items-center justify-center animate-pulse">
                            <span class="text-xs font-bold text-white">✓</span>
                        </div>
                    </div>
                    <div class="text-4xl font-bold bg-gradient-to-r from-amber-600 to-orange-600 bg-clip-text text-transparent mb-3"><?= $readerStats['total_read'] ?></div>
                    <div class="text-gray-700 font-semibold text-lg">Novel Dibaca</div>
                    <div class="absolute top-4 right-4 text-amber-300 text-2xl animate-spin">📖</div>
                </div>
            </div>
            
            <div class="relative group">
                <div class="absolute inset-0 bg-gradient-to-r from-blue-400 to-cyan-400 rounded-2xl blur-lg opacity-75 group-hover:opacity-100 transition-all duration-300"></div>
                <div class="relative bg-white rounded-2xl p-8 text-center shadow-2xl border-2 border-blue-200 transform group-hover:scale-105 transition-all duration-300">
                    <div class="w-20 h-20 bg-gradient-to-r from-blue-500 to-cyan-500 rounded-full flex items-center justify-center mx-auto mb-6 shadow-xl relative">
                        <i class="fas fa-file-alt text-white text-3xl"></i>
                        <div class="absolute -top-1 -right-1 text-yellow-300 text-sm animate-twinkle">⭐</div>
                    </div>
                    <div class="text-4xl font-bold bg-gradient-to-r from-blue-600 to-cyan-600 bg-clip-text text-transparent mb-3"><?= $readerStats['total_chapters'] ?></div>
                    <div class="text-gray-700 font-semibold text-lg">Chapter Dibaca</div>
                    <div class="absolute top-4 right-4 text-blue-300 text-2xl animate-pulse">📄</div>
                </div>
            </div>
            
            <div class="relative group">
                <div class="absolute inset-0 bg-gradient-to-r from-green-400 to-emerald-400 rounded-2xl blur-lg opacity-75 group-hover:opacity-100 transition-all duration-300"></div>
                <div class="relative bg-white rounded-2xl p-8 text-center shadow-2xl border-2 border-green-200 transform group-hover:scale-105 transition-all duration-300">
                    <div class="w-20 h-20 bg-gradient-to-r from-green-500 to-emerald-500 rounded-full flex items-center justify-center mx-auto mb-6 shadow-xl relative">
                        <i class="fas fa-fire text-white text-3xl"></i>
                        <div class="absolute -top-2 -right-2 text-red-400 text-lg animate-bounce">🔥</div>
                    </div>
                    <div class="text-4xl font-bold bg-gradient-to-r from-green-600 to-emerald-600 bg-clip-text text-transparent mb-3"><?= $readerStats['reading_streak'] ?></div>
                    <div class="text-gray-700 font-semibold text-lg">Hari Berturut</div>
                    <div class="absolute top-4 right-4 text-green-300 text-2xl animate-bounce">🏆</div>
                </div>
            </div>
            
            <div class="relative group">
                <div class="absolute inset-0 bg-gradient-to-r from-red-400 to-pink-400 rounded-2xl blur-lg opacity-75 group-hover:opacity-100 transition-all duration-300"></div>
                <div class="relative bg-white rounded-2xl p-8 text-center shadow-2xl border-2 border-red-200 transform group-hover:scale-105 transition-all duration-300">
                    <div class="w-20 h-20 bg-gradient-to-r from-red-500 to-pink-500 rounded-full flex items-center justify-center mx-auto mb-6 shadow-xl relative">
                        <i class="fas fa-heart text-white text-3xl"></i>
                        <div class="absolute -top-1 -right-1 text-yellow-300 text-sm animate-pulse">💖</div>
                    </div>
                    <div class="text-2xl font-bold bg-gradient-to-r from-red-600 to-pink-600 bg-clip-text text-transparent mb-3"><?= $readerStats['favorite_genre'] ?></div>
                    <div class="text-gray-700 font-semibold text-lg">Genre Favorit</div>
                    <div class="absolute top-4 right-4 text-red-300 text-2xl animate-bounce">❤️</div>
                </div>
            </div>
            
            <div class="relative group">
                <div class="absolute inset-0 bg-gradient-to-r from-indigo-400 to-purple-400 rounded-2xl blur-lg opacity-75 group-hover:opacity-100 transition-all duration-300"></div>
                <div class="relative bg-white rounded-2xl p-8 text-center shadow-2xl border-2 border-indigo-200 transform group-hover:scale-105 transition-all duration-300">
                    <div class="w-20 h-20 bg-gradient-to-r from-indigo-500 to-purple-500 rounded-full flex items-center justify-center mx-auto mb-6 shadow-xl relative">
                        <i class="fas fa-chart-line text-white text-3xl"></i>
                        <div class="absolute -top-2 -right-2 text-green-400 text-lg animate-bounce">📈</div>
                    </div>
                    <div class="text-4xl font-bold bg-gradient-to-r from-indigo-600 to-purple-600 bg-clip-text text-transparent mb-3"><?= $readerStats['recent_activity'] ?></div>
                    <div class="text-gray-700 font-semibold text-lg">Novel dalam 7 Hari</div>
                    <div class="absolute top-4 right-4 text-indigo-300 text-2xl animate-pulse">📊</div>
                </div>
            </div>
        </div>
        <?php endif; ?>

        <!-- Enhanced Author Stats (similar treatment) -->
        <?php if ($user->role === 'author' && isset($authorStats)): ?>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8 mb-12">
            <div class="relative group">
                <div class="absolute inset-0 bg-gradient-to-r from-purple-400 to-indigo-400 rounded-2xl blur-lg opacity-75 group-hover:opacity-100 transition-all duration-300"></div>
                <div class="relative bg-white rounded-2xl p-8 text-center shadow-2xl border-2 border-purple-200 transform group-hover:scale-105 transition-all duration-300">
                    <div class="w-20 h-20 bg-gradient-to-r from-purple-500 to-indigo-500 rounded-full flex items-center justify-center mx-auto mb-6 shadow-xl">
                        <i class="fas fa-book text-white text-3xl"></i>
                    </div>
                    <div class="text-4xl font-bold bg-gradient-to-r from-purple-600 to-indigo-600 bg-clip-text text-transparent mb-3"><?= $authorStats['total_novels'] ?></div>
                    <div class="text-gray-700 font-semibold text-lg">Novel Ditulis</div>
                    <div class="absolute top-4 right-4 text-purple-300 text-2xl animate-bounce">✍️</div>
                </div>
            </div>
            
            <div class="relative group">
                <div class="absolute inset-0 bg-gradient-to-r from-amber-400 to-orange-400 rounded-2xl blur-lg opacity-75 group-hover:opacity-100 transition-all duration-300"></div>
                <div class="relative bg-white rounded-2xl p-8 text-center shadow-2xl border-2 border-amber-200 transform group-hover:scale-105 transition-all duration-300">
                    <div class="w-20 h-20 bg-gradient-to-r from-amber-500 to-orange-500 rounded-full flex items-center justify-center mx-auto mb-6 shadow-xl">
                        <i class="fas fa-eye text-white text-3xl"></i>
                    </div>
                    <div class="text-4xl font-bold bg-gradient-to-r from-amber-600 to-orange-600 bg-clip-text text-transparent mb-3"><?= number_format($authorStats['total_views']) ?></div>
                    <div class="text-gray-700 font-semibold text-lg">Total Pembaca</div>
                    <div class="absolute top-4 right-4 text-amber-300 text-2xl animate-pulse">👀</div>
                </div>
            </div>
            
            <div class="relative group">
                <div class="absolute inset-0 bg-gradient-to-r from-green-400 to-emerald-400 rounded-2xl blur-lg opacity-75 group-hover:opacity-100 transition-all duration-300"></div>
                <div class="relative bg-white rounded-2xl p-8 text-center shadow-2xl border-2 border-green-200 transform group-hover:scale-105 transition-all duration-300">
                    <div class="w-20 h-20 bg-gradient-to-r from-green-500 to-emerald-500 rounded-full flex items-center justify-center mx-auto mb-6 shadow-xl">
                        <i class="fas fa-fire text-white text-3xl"></i>
                    </div>
                    <div class="text-4xl font-bold bg-gradient-to-r from-green-600 to-emerald-600 bg-clip-text text-transparent mb-3"><?= count($authorStats['trending_novels']) ?></div>
                    <div class="text-gray-700 font-semibold text-lg">Novel Trending</div>
                    <div class="absolute top-4 right-4 text-green-300 text-2xl animate-bounce">🔥</div>
                </div>
            </div>
        </div>

        <!-- Enhanced Author's Trending Novels -->
        <?php if (!empty($authorStats['trending_novels'])): ?>
        <div class="relative rounded-3xl p-8 mb-12 overflow-hidden">
            <div class="absolute inset-0 bg-gradient-to-br from-red-500 via-pink-500 to-purple-600 opacity-90"></div>
            <div class="absolute inset-0 bg-gradient-to-tl from-orange-400 via-transparent to-yellow-400 opacity-30"></div>
            
            <div class="relative z-10">
                <h2 class="text-3xl font-fantasy font-bold text-white mb-8 flex items-center justify-center">
                    <div class="w-12 h-12 bg-gradient-to-r from-red-400 to-orange-400 rounded-full flex items-center justify-center mr-4 shadow-xl">
                        <i class="fas fa-fire text-white text-xl"></i>
                    </div>
                    Novel Trending
                    <div class="ml-4 text-yellow-300 text-2xl animate-bounce">🏆</div>
                </h2>
                
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    <?php foreach ($authorStats['trending_novels'] as $novel): ?>
                    <div class="relative bg-white bg-opacity-20 backdrop-blur-sm rounded-xl p-6 border border-white border-opacity-30 hover:bg-opacity-30 transition-all duration-300 group transform hover:scale-105">
                        <h3 class="font-bold text-xl mb-3 text-white group-hover:text-yellow-200 transition-colors">
                            <a href="<?= base_url('novel/' . $novel->id) ?>">
                                <?= esc($novel->title) ?>
                            </a>
                        </h3>
                        <div class="flex flex-wrap gap-2 mb-4">
                            <?php foreach (array_slice($novel->categoryNames, 0, 2) as $category): ?>
                            <span class="bg-gradient-to-r from-purple-400 to-pink-400 text-white px-3 py-1 rounded-full text-sm font-medium border border-white border-opacity-30">
                                <?= esc($category) ?>
                            </span>
                            <?php endforeach; ?>
                        </div>
                        <div class="flex items-center justify-between text-white">
                            <span class="flex items-center bg-white bg-opacity-20 px-3 py-1 rounded-full">
                                <i class="fas fa-eye mr-2 text-blue-300"></i>
                                <?= number_format($novel->views) ?>
                            </span>
                            <span class="bg-<?= $novel->status === 'completed' ? 'green' : ($novel->status === 'ongoing' ? 'blue' : 'yellow') ?>-400 text-white font-medium px-3 py-1 rounded-full text-sm border border-white border-opacity-30">
                                <?= ucfirst($novel->status) ?>
                            </span>
                        </div>
                        
                        <!-- Decorative Elements -->
                        <div class="absolute top-2 right-2 text-yellow-300 text-lg animate-twinkle">⭐</div>
                        <div class="absolute bottom-2 left-2 text-pink-300 text-sm animate-pulse">✨</div>
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
        <?php endif; ?>
        <?php endif; ?>

        <!-- Super Enhanced Member Since -->
        <div class="relative rounded-2xl p-8 text-center overflow-hidden">
            <div class="absolute inset-0 bg-gradient-to-br from-indigo-500 via-purple-500 to-pink-500 opacity-90"></div>
            <div class="absolute inset-0 bg-gradient-to-tl from-cyan-400 via-transparent to-yellow-400 opacity-30"></div>
            
            <!-- Decorative Elements -->
            <div class="absolute top-4 left-4 w-8 h-8 border-2 border-white border-opacity-50 rounded-full animate-spin"></div>
            <div class="absolute top-4 right-4 w-6 h-6 bg-white bg-opacity-30 rounded-full animate-bounce"></div>
            <div class="absolute bottom-4 left-4 w-10 h-10 border-2 border-white border-opacity-50 rounded-full animate-pulse"></div>
            <div class="absolute bottom-4 right-4 w-4 h-4 bg-white bg-opacity-50 rounded-full animate-ping"></div>
            
            <div class="relative z-10">
                <div class="flex items-center justify-center mb-6">
                    <div class="w-16 h-16 bg-gradient-to-r from-cyan-400 to-blue-500 rounded-full flex items-center justify-center shadow-2xl border-2 border-white">
                        <i class="fas fa-calendar-alt text-white text-2xl"></i>
                    </div>
                </div>
                <h3 class="text-2xl font-bold text-white mb-4">Bergabung Sejak</h3>
                <p class="text-white font-bold text-2xl mb-2">
                    <?= date('d F Y', strtotime($user->created_at)) ?>
                </p>
                <p class="text-white text-opacity-80 text-lg">
                    <?= floor((time() - strtotime($user->created_at)) / (60 * 60 * 24)) ?> hari yang lalu
                </p>
                
                <!-- Celebration Elements -->
                <div class="absolute top-8 left-1/2 transform -translate-x-1/2 text-yellow-300 text-2xl animate-bounce">🎉</div>
                <div class="absolute bottom-8 left-1/4 text-pink-300 text-xl animate-pulse">🎊</div>
                <div class="absolute bottom-8 right-1/4 text-cyan-300 text-xl animate-bounce" style="animation-delay: 0.5s;">🌟</div>
            </div>
        </div>
    </div>
</div>

<style>
.card-fantasy {
    background: linear-gradient(135deg, #ffffff 0%, #f8fafc 100%);
    border: 1px solid #e2e8f0;
    backdrop-filter: blur(10px);
}

.gradient-fantasy {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
}

.gradient-gold {
    background: linear-gradient(135deg, #f59e0b 0%, #fbbf24 100%);
}

@keyframes float {
    0%, 100% { transform: translateY(0px); }
    50% { transform: translateY(-20px); }
}

@keyframes twinkle {
    0%, 100% { opacity: 1; transform: scale(1); }
    50% { opacity: 0.5; transform: scale(1.2); }
}

@keyframes spin-slow {
    from { transform: rotate(0deg); }
    to { transform: rotate(360deg); }
}

.animate-float {
    animation: float 3s ease-in-out infinite;
}

.animate-twinkle {
    animation: twinkle 2s ease-in-out infinite;
}

.animate-spin-slow {
    animation: spin-slow 8s linear infinite;
}
</style>

<?= $this->endSection() ?>
