<?= $this->extend('home/layout/main') ?>

<?= $this->section('content') ?>

<div class="min-h-screen bg-gradient-to-br from-purple-50 via-pink-50 to-indigo-50 py-12 relative overflow-hidden">
    <!-- Floating Decorative Elements -->
    <div class="fixed inset-0 pointer-events-none overflow-hidden">
        <div class="absolute top-10 left-10 w-16 h-16 bg-gradient-to-r from-purple-400 to-pink-400 rounded-full opacity-20 animate-bounce" style="animation-delay: 0s;"></div>
        <div class="absolute top-32 right-20 w-12 h-12 bg-gradient-to-r from-amber-400 to-orange-400 rounded-full opacity-20 animate-bounce" style="animation-delay: 1s;"></div>
        <div class="absolute bottom-20 left-20 w-20 h-20 bg-gradient-to-r from-blue-400 to-cyan-400 rounded-full opacity-20 animate-bounce" style="animation-delay: 2s;"></div>
        <div class="absolute bottom-32 right-10 w-14 h-14 bg-gradient-to-r from-green-400 to-emerald-400 rounded-full opacity-20 animate-bounce" style="animation-delay: 0.5s;"></div>
        
        <!-- Floating Fantasy Icons -->
        <div class="absolute top-20 right-32 text-3xl text-purple-300 opacity-30 animate-float">✨</div>
        <div class="absolute top-40 left-32 text-2xl text-pink-300 opacity-30 animate-float" style="animation-delay: 1s;">🌟</div>
        <div class="absolute bottom-40 right-40 text-4xl text-amber-300 opacity-30 animate-float" style="animation-delay: 2s;">⭐</div>
        <div class="absolute bottom-20 left-40 text-2xl text-blue-300 opacity-30 animate-float" style="animation-delay: 1.5s;">💫</div>
    </div>

    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
        
        <!-- Header with Rich Design -->
        <div class="text-center mb-8">
            <div class="relative inline-block">
                <h1 class="text-4xl font-fantasy font-bold bg-gradient-to-r from-purple-600 via-pink-600 to-indigo-600 bg-clip-text text-transparent mb-2">
                    Edit Profile
                </h1>
                <div class="absolute -top-2 -right-2 text-2xl animate-bounce">✏️</div>
                <div class="absolute -top-2 -left-2 text-2xl animate-pulse">🎨</div>
            </div>
            <p class="text-gray-600 text-lg">Perbarui informasi profile Anda dengan gaya fantasi</p>
        </div>

        <!-- Success/Error Messages with Enhanced Design -->
        <?php if (session()->getFlashdata('success')): ?>
        <div class="relative bg-gradient-to-r from-green-400 to-emerald-500 text-white px-6 py-4 rounded-2xl mb-6 shadow-xl border-2 border-white">
            <div class="flex items-center">
                <div class="w-8 h-8 bg-white bg-opacity-20 rounded-full flex items-center justify-center mr-3">
                    <i class="fas fa-check text-white"></i>
                </div>
                <span class="font-medium"><?= session()->getFlashdata('success') ?></span>
            </div>
            <div class="absolute top-2 right-2 text-green-200 animate-bounce">🎉</div>
        </div>
        <?php endif; ?>

        <?php if (session()->getFlashdata('error')): ?>
        <div class="relative bg-gradient-to-r from-red-400 to-pink-500 text-white px-6 py-4 rounded-2xl mb-6 shadow-xl border-2 border-white">
            <div class="flex items-center">
                <div class="w-8 h-8 bg-white bg-opacity-20 rounded-full flex items-center justify-center mr-3">
                    <i class="fas fa-exclamation-triangle text-white"></i>
                </div>
                <span class="font-medium"><?= session()->getFlashdata('error') ?></span>
            </div>
        </div>
        <?php endif; ?>

        <?php if (session()->getFlashdata('errors')): ?>
        <div class="relative bg-gradient-to-r from-red-400 to-pink-500 text-white px-6 py-4 rounded-2xl mb-6 shadow-xl border-2 border-white">
            <div class="flex items-start">
                <div class="w-8 h-8 bg-white bg-opacity-20 rounded-full flex items-center justify-center mr-3 mt-1">
                    <i class="fas fa-exclamation-circle text-white"></i>
                </div>
                <div>
                    <h4 class="font-bold mb-2">Terjadi kesalahan:</h4>
                    <ul class="list-disc list-inside space-y-1">
                        <?php foreach (session()->getFlashdata('errors') as $error): ?>
                        <li><?= esc($error) ?></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            </div>
        </div>
        <?php endif; ?>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Main Edit Form -->
            <div class="lg:col-span-2">
                <div class="relative rounded-3xl p-8 overflow-hidden shadow-2xl">
                    <!-- Multi-layered Background -->
                    <div class="absolute inset-0 bg-gradient-to-br from-white via-purple-50 to-pink-50"></div>
                    <div class="absolute inset-0 bg-gradient-to-tl from-blue-50 via-transparent to-amber-50 opacity-50"></div>
                    
                    <!-- Decorative Border -->
                    <div class="absolute inset-0 border-4 border-gradient-to-r from-purple-200 via-pink-200 to-indigo-200 rounded-3xl"></div>
                    
                    <form action="<?= base_url('profile/update') ?>" method="POST" enctype="multipart/form-data" class="relative z-10">
                        <?= csrf_field() ?>
                        
                        <!-- Enhanced Profile Picture Section -->
                        <div class="text-center mb-8">
                            <h3 class="text-xl font-bold text-gray-800 mb-4 flex items-center justify-center">
                                <i class="fas fa-camera mr-2 text-purple-500"></i>Foto Profile
                            </h3>
                            <div class="relative inline-block">
                                <!-- Glow Effect -->
                                <div class="absolute inset-0 bg-gradient-to-r from-purple-400 to-pink-400 rounded-full blur-lg opacity-50 scale-110 animate-pulse"></div>
                                
                                <?php if ($user->profile): ?>
                                    <div class="relative w-32 h-32 rounded-full p-1 bg-gradient-to-r from-purple-400 via-pink-400 to-indigo-400 shadow-2xl">
                                        <img id="profile-preview" src="<?= base_url('uploads/profile/' . $user->profile) ?>" 
                                             alt="Profile" class="w-full h-full rounded-full object-cover bg-white">
                                    </div>
                                <?php else: ?>
                                    <div class="relative w-32 h-32 rounded-full p-1 bg-gradient-to-r from-purple-400 via-pink-400 to-indigo-400 shadow-2xl">
                                        <div id="profile-preview" class="w-full h-full gradient-fantasy rounded-full flex items-center justify-center text-white text-4xl font-bold">
                                            <?= strtoupper(substr($user->display_name ?: $user->username, 0, 2)) ?>
                                        </div>
                                    </div>
                                <?php endif; ?>
                                
                                <!-- Enhanced Camera Button -->
                                <label for="profile" class="absolute bottom-0 right-0 w-12 h-12 bg-gradient-to-r from-amber-400 to-orange-500 rounded-full flex items-center justify-center cursor-pointer shadow-xl hover:scale-110 transition-all duration-300 border-2 border-white">
                                    <i class="fas fa-camera text-white"></i>
                                    <div class="absolute -top-1 -right-1 w-4 h-4 bg-green-400 rounded-full animate-ping"></div>
                                </label>
                                <input type="file" id="profile" name="profile" accept="image/*" class="hidden">
                            </div>
                            <p class="text-gray-600 text-sm mt-4">Klik icon kamera untuk mengubah foto profile</p>
                        </div>

                        <!-- Enhanced Form Fields -->
                        <div class="space-y-6">
                            <!-- Display Name & Username Section -->
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div class="relative">
                                    <label for="display_name" class="block text-sm font-bold text-gray-700 mb-3">
                                        <div class="flex items-center">
                                            <div class="w-8 h-8 bg-gradient-to-r from-purple-500 to-pink-500 rounded-full flex items-center justify-center mr-2">
                                                <i class="fas fa-user text-white text-sm"></i>
                                            </div>
                                            Nama Tampilan
                                        </div>
                                    </label>
                                    <input type="text" 
                                           id="display_name" 
                                           name="display_name" 
                                           value="<?= old('display_name', $user->display_name ?: $user->username) ?>"
                                           class="w-full px-4 py-3 border-2 border-purple-200 rounded-xl focus:ring-4 focus:ring-purple-300 focus:border-purple-500 transition-all duration-300 bg-white shadow-lg"
                                           required>
                                    <p class="mt-2 text-xs text-gray-500 flex items-center">
                                        <i class="fas fa-info-circle mr-1 text-purple-400"></i>
                                        Nama yang akan ditampilkan di profil Anda
                                    </p>
                                </div>
                                
                                <div class="relative">
                                    <label for="username" class="block text-sm font-bold text-gray-700 mb-3">
                                        <div class="flex items-center">
                                            <div class="w-8 h-8 bg-gradient-to-r from-indigo-500 to-blue-500 rounded-full flex items-center justify-center mr-2">
                                                <i class="fas fa-at text-white text-sm"></i>
                                            </div>
                                            Username (URL)
                                        </div>
                                    </label>
                                    <div class="relative">
                                        <input type="text" 
                                               id="username" 
                                               name="username" 
                                               value="<?= old('username', $user->username) ?>"
                                               class="w-full px-4 py-3 border-2 border-indigo-200 rounded-xl focus:ring-4 focus:ring-indigo-300 focus:border-indigo-500 transition-all duration-300 bg-white shadow-lg"
                                               required>
                                        
                                    </div>
                                    <p class="mt-2 text-xs text-gray-500 flex items-center">
                                        <i class="fas fa-info-circle mr-1 text-indigo-400"></i>
                                        Username untuk URL profil (huruf kecil, angka, underscore, titik)
                                    </p>
                                </div>
                            </div>

                            <!-- Email -->
                            <div class="relative">
                                <label for="email" class="block text-sm font-bold text-gray-700 mb-3">
                                    <div class="flex items-center">
                                        <div class="w-8 h-8 bg-gradient-to-r from-green-500 to-emerald-500 rounded-full flex items-center justify-center mr-2">
                                            <i class="fas fa-envelope text-white text-sm"></i>
                                        </div>
                                        Email
                                    </div>
                                </label>
                                <input type="email" 
                                       id="email" 
                                       name="email" 
                                       value="<?= old('email', $user->email) ?>"
                                       class="w-full px-4 py-3 border-2 border-green-200 rounded-xl focus:ring-4 focus:ring-green-300 focus:border-green-500 transition-all duration-300 bg-white shadow-lg"
                                       required>
                            </div>

                            <!-- Bio -->
                            <div class="relative">
                                <label for="bio" class="block text-sm font-bold text-gray-700 mb-3">
                                    <div class="flex items-center">
                                        <div class="w-8 h-8 bg-gradient-to-r from-amber-500 to-orange-500 rounded-full flex items-center justify-center mr-2">
                                            <i class="fas fa-quote-left text-white text-sm"></i>
                                        </div>
                                        Bio
                                    </div>
                                </label>
                                <textarea id="bio" 
                                          name="bio" 
                                          rows="4"
                                          placeholder="Ceritakan tentang diri Anda dengan gaya fantasi..."
                                          class="w-full px-4 py-3 border-2 border-amber-200 rounded-xl focus:ring-4 focus:ring-amber-300 focus:border-amber-500 transition-all duration-300 bg-white shadow-lg resize-none"><?= old('bio', $user->bio) ?></textarea>
                            </div>

                            <!-- Location & Website -->
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div class="relative">
                                    <label for="location" class="block text-sm font-bold text-gray-700 mb-3">
                                        <div class="flex items-center">
                                            <div class="w-8 h-8 bg-gradient-to-r from-red-500 to-pink-500 rounded-full flex items-center justify-center mr-2">
                                                <i class="fas fa-map-marker-alt text-white text-sm"></i>
                                            </div>
                                            Lokasi
                                        </div>
                                    </label>
                                    <input type="text" 
                                           id="location" 
                                           name="location" 
                                           value="<?= old('location', $user->location) ?>" 
                                           placeholder="Jakarta, Indonesia"
                                           class="w-full px-4 py-3 border-2 border-red-200 rounded-xl focus:ring-4 focus:ring-red-300 focus:border-red-500 transition-all duration-300 bg-white shadow-lg">
                                </div>
                                
                                <div class="relative">
                                    <label for="website" class="block text-sm font-bold text-gray-700 mb-3">
                                        <div class="flex items-center">
                                            <div class="w-8 h-8 bg-gradient-to-r from-cyan-500 to-blue-500 rounded-full flex items-center justify-center mr-2">
                                                <i class="fas fa-globe text-white text-sm"></i>
                                            </div>
                                            Website
                                        </div>
                                    </label>
                                    <input type="url" 
                                           id="website" 
                                           name="website" 
                                           value="<?= old('website', $user->website) ?>" 
                                           placeholder="https://website-anda.com"
                                           class="w-full px-4 py-3 border-2 border-cyan-200 rounded-xl focus:ring-4 focus:ring-cyan-300 focus:border-cyan-500 transition-all duration-300 bg-white shadow-lg">
                                </div>
                            </div>

                            <!-- Social Media Section -->
                            <div class="relative">
                                <h3 class="text-lg font-bold text-gray-800 mb-4 flex items-center">
                                    <div class="w-10 h-10 bg-gradient-to-r from-purple-500 to-pink-500 rounded-full flex items-center justify-center mr-3">
                                        <i class="fas fa-share-alt text-white"></i>
                                    </div>
                                    Media Sosial
                                    <div class="ml-2 text-2xl animate-bounce">📱</div>
                                </h3>
                                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                    <div class="relative">
                                        <label for="twitter" class="block text-sm font-bold text-gray-700 mb-2">
                                            <div class="flex items-center">
                                                <i class="fab fa-twitter mr-2 text-blue-400 text-lg"></i>Twitter
                                            </div>
                                        </label>
                                        <input type="text" 
                                               id="twitter" 
                                               name="twitter" 
                                               value="<?= old('twitter', $user->twitter) ?>" 
                                               placeholder="username"
                                               class="w-full px-4 py-3 border-2 border-blue-200 rounded-xl focus:ring-4 focus:ring-blue-300 focus:border-blue-500 transition-all duration-300 bg-white shadow-lg">
                                    </div>
                                    
                                    <div class="relative">
                                        <label for="instagram" class="block text-sm font-bold text-gray-700 mb-2">
                                            <div class="flex items-center">
                                                <i class="fab fa-instagram mr-2 text-pink-500 text-lg"></i>Instagram
                                            </div>
                                        </label>
                                        <input type="text" 
                                               id="instagram" 
                                               name="instagram" 
                                               value="<?= old('instagram', $user->instagram) ?>" 
                                               placeholder="username"
                                               class="w-full px-4 py-3 border-2 border-pink-200 rounded-xl focus:ring-4 focus:ring-pink-300 focus:border-pink-500 transition-all duration-300 bg-white shadow-lg">
                                    </div>
                                    
                                    <div class="relative">
                                        <label for="facebook" class="block text-sm font-bold text-gray-700 mb-2">
                                            <div class="flex items-center">
                                                <i class="fab fa-facebook mr-2 text-blue-600 text-lg"></i>Facebook
                                            </div>
                                        </label>
                                        <input type="text" 
                                               id="facebook" 
                                               name="facebook" 
                                               value="<?= old('facebook', $user->facebook) ?>" 
                                               placeholder="username"
                                               class="w-full px-4 py-3 border-2 border-blue-200 rounded-xl focus:ring-4 focus:ring-blue-300 focus:border-blue-500 transition-all duration-300 bg-white shadow-lg">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Enhanced Action Buttons -->
                        <div class="flex flex-col sm:flex-row gap-4 justify-center mt-8">
                            <button type="submit" 
                                    class="group relative bg-gradient-to-r from-emerald-400 via-cyan-400 to-blue-500 hover:from-emerald-500 hover:via-cyan-500 hover:to-blue-600 text-white font-bold py-4 px-8 rounded-2xl transition-all duration-300 shadow-2xl transform hover:scale-105 border-2 border-white">
                                <div class="absolute inset-0 bg-white opacity-0 group-hover:opacity-20 transition-opacity rounded-2xl"></div>
                                <div class="flex items-center justify-center">
                                    <i class="fas fa-save mr-3 text-xl"></i>
                                    <span class="text-lg">Simpan Perubahan</span>
                                </div>
                                <div class="absolute -top-2 -right-2 text-yellow-300 text-lg animate-bounce">💾</div>
                            </button>
                            <a href="<?= base_url('profile') ?>" 
                               class="group relative bg-gradient-to-r from-gray-400 to-gray-600 hover:from-gray-500 hover:to-gray-700 text-white font-bold py-4 px-8 rounded-2xl transition-all duration-300 shadow-2xl text-center transform hover:scale-105 border-2 border-white">
                                <div class="flex items-center justify-center">
                                    <i class="fas fa-times mr-3 text-xl"></i>
                                    <span class="text-lg">Batal</span>
                                </div>
                            </a>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Enhanced Profile Preview -->
            <div class="lg:col-span-1">
                <div class="sticky top-24">
                    <div class="relative rounded-3xl p-6 overflow-hidden shadow-2xl">
                        <!-- Background -->
                        <div class="absolute inset-0 bg-gradient-to-br from-purple-600 via-pink-500 to-indigo-600"></div>
                        <div class="absolute inset-0 bg-gradient-to-tl from-amber-400 via-transparent to-cyan-400 opacity-30"></div>
                        
                        <!-- Decorative Elements -->
                        <div class="absolute top-2 left-2 w-4 h-4 border-2 border-white border-opacity-50 rounded-full animate-ping"></div>
                        <div class="absolute top-2 right-2 w-3 h-3 bg-white bg-opacity-50 rounded-full animate-bounce"></div>
                        <div class="absolute bottom-2 left-2 w-5 h-5 border-2 border-white border-opacity-50 rounded-full animate-pulse"></div>
                        <div class="absolute bottom-2 right-2 w-2 h-2 bg-white bg-opacity-50 rounded-full animate-ping"></div>
                        
                        <div class="relative z-10 text-center">
                            <h3 class="text-xl font-bold text-white mb-6 flex items-center justify-center">
                                <i class="fas fa-eye mr-2"></i>Preview Profil
                                <div class="ml-2 text-yellow-300 animate-twinkle">👁️</div>
                            </h3>
                            
                            <!-- Preview Avatar -->
                            <div class="relative inline-block mb-4">
                                <div class="absolute inset-0 bg-gradient-to-r from-yellow-300 to-orange-300 rounded-full blur opacity-75 animate-pulse scale-110"></div>
                                <img id="preview-avatar" 
                                     src="<?= $user->profile ? base_url('uploads/profile/' . $user->profile) : 'data:image/svg+xml;base64,' . base64_encode('<svg xmlns="http://www.w3.org/2000/svg" width="80" height="80" viewBox="0 0 80 80"><rect width="80" height="80" fill="#667eea"/><text x="40" y="45" font-family="Arial" font-size="30" fill="white" text-anchor="middle">' . strtoupper(substr($user->display_name ?: $user->username, 0, 2)) . '</text></svg>') ?>" 
                                     alt="Preview" 
                                     class="relative w-20 h-20 rounded-full object-cover border-4 border-white shadow-xl">
                            </div>
                            
                            <!-- Preview Names -->
                            <h4 id="preview-display-name" class="text-2xl font-bold text-white mb-2 drop-shadow-lg">
                                <?= esc($user->display_name ?: $user->username) ?>
                            </h4>
                            
                            <p id="preview-username" class="text-white text-opacity-80 mb-3 font-medium">
                                @<?= esc($user->username) ?>
                            </p>
                            
                            <!-- Preview URL -->
                            <div class="bg-white bg-opacity-20 backdrop-blur-sm rounded-lg p-3 mb-4 border border-white border-opacity-30">
                                <div class="text-xs text-white text-opacity-80 mb-1">
                                    <i class="fas fa-link mr-1"></i>URL Profil:
                                </div>
                                <div class="text-xs text-white font-mono break-all overflow-hidden">
                                    narria.com/profile/<span id="preview-url"><?= esc($user->username) ?></span>
                                </div>
                            </div>
                            
                            <!-- Preview Bio -->
                            <?php if ($user->bio): ?>
                            <p id="preview-bio" class="text-white text-opacity-90 italic text-sm leading-relaxed">
                                "<?= esc($user->bio) ?>"
                            </p>
                            <?php else: ?>
                            <p id="preview-bio" class="text-white text-opacity-60 italic text-sm">
                                Bio akan muncul di sini...
                            </p>
                            <?php endif; ?>
                            
                            <!-- Decorative Stars -->
                            <div class="absolute top-8 left-8 text-yellow-300 text-lg animate-twinkle">⭐</div>
                            <div class="absolute top-12 right-8 text-pink-300 text-sm animate-bounce">✨</div>
                            <div class="absolute bottom-8 left-8 text-cyan-300 text-lg animate-pulse">💫</div>
                            <div class="absolute bottom-12 right-8 text-amber-300 text-sm animate-twinkle" style="animation-delay: 1s;">🌟</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
@keyframes float {
    0%, 100% { transform: translateY(0px); }
    50% { transform: translateY(-20px); }
}

@keyframes twinkle {
    0%, 100% { opacity: 1; transform: scale(1); }
    50% { opacity: 0.5; transform: scale(1.2); }
}

.animate-float {
    animation: float 3s ease-in-out infinite;
}

.animate-twinkle {
    animation: twinkle 2s ease-in-out infinite;
}

.gradient-fantasy {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
}
</style>

<script>
// Enhanced Profile picture preview
document.getElementById('profile').addEventListener('change', function(e) {
    const file = e.target.files[0];
    if (file) {
        const reader = new FileReader();
        reader.onload = function(e) {
            const preview = document.getElementById('profile-preview');
            const previewAvatar = document.getElementById('preview-avatar');
            
            // Update main preview
            if (preview.tagName === 'IMG') {
                preview.src = e.target.result;
            } else {
                preview.innerHTML = `<img src="${e.target.result}" alt="Profile Preview" class="w-full h-full rounded-full object-cover">`;
            }
            
            // Update sidebar preview
            previewAvatar.src = e.target.result;
        };
        reader.readAsDataURL(file);
    }
});

// Enhanced Live preview updates - Manual updates only
document.getElementById('display_name').addEventListener('input', function() {
    const displayName = this.value || 'User';
    
    // Update preview display name
    document.getElementById('preview-display-name').textContent = displayName;
    
    // Update avatar initials if no profile image
    const preview = document.getElementById('profile-preview');
    if (preview && !preview.querySelector('img')) {
        preview.textContent = displayName.substring(0, 2).toUpperCase();
    }
});

// Separate listener for username field
document.getElementById('username').addEventListener('input', function() {
    const username = this.value || 'username';
    
    // Update preview username and URL
    document.getElementById('preview-username').textContent = '@' + username;
    document.getElementById('preview-url').textContent = username;
});

document.getElementById('bio').addEventListener('input', function() {
    const bio = this.value;
    const previewBio = document.getElementById('preview-bio');
    
    if (bio.trim()) {
        previewBio.textContent = '"' + bio + '"';
        previewBio.className = 'text-white text-opacity-90 italic text-sm leading-relaxed';
    } else {
        previewBio.textContent = 'Bio akan muncul di sini...';
        previewBio.className = 'text-white text-opacity-60 italic text-sm';
    }
});

// Add some interactive effects
document.querySelectorAll('input, textarea').forEach(input => {
    input.addEventListener('focus', function() {
        this.style.transform = 'scale(1.02)';
    });
    
    input.addEventListener('blur', function() {
        this.style.transform = 'scale(1)';
    });
});
</script>

<?= $this->endSection() ?>
