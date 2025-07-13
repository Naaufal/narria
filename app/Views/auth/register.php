<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar - Narria</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        'primary-purple': '#4c1d95',
                        'secondary-purple': '#6d28d9',
                        'accent-gold': '#f59e0b',
                        'dark-purple': '#2d1b69',
                        'light-purple': '#8b5cf6'
                    }
                }
            }
        }
    </script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Cinzel:wght@400;600;700&family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <style>
        .font-fantasy {
            font-family: 'Cinzel', serif;
        }
        .gradient-fantasy {
            background: linear-gradient(135deg, #4c1d95 0%, #6d28d9 50%, #2d1b69 100%);
        }
        
        .fantasy-bg {
            background-image: url('<?= base_url('assets')?>/img/loginBG.jpg');
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            background-attachment: fixed;
            position: relative;
            overflow: hidden;
        }

        .fantasy-bg::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(0, 0, 0, 0.4);
            backdrop-filter: blur(1px);
        }
        
        .fantasy-pattern {
            background-image: url("data:image/svg+xml,%3Csvg width='80' height='80' viewBox='0 0 80 80' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%23fbbf24' fill-opacity='0.03'%3E%3Cpath d='M0 0h80v80H0V0zm20 20v40h40V20H20zm20 35a15 15 0 1 1 0-30 15 15 0 0 1 0 30z' fill-rule='nonzero'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
        }
        
        .floating-elements {
            position: absolute;
            width: 100%;
            height: 100%;
            overflow: hidden;
            pointer-events: none;
        }
        
        .floating-element {
            position: absolute;
            opacity: 0.08;
            animation: float 8s ease-in-out infinite;
        }
        
        .floating-element:nth-child(1) {
            top: 5%;
            left: 5%;
            animation-delay: 0s;
        }
        
        .floating-element:nth-child(2) {
            top: 15%;
            right: 5%;
            animation-delay: 3s;
        }
        
        .floating-element:nth-child(3) {
            bottom: 15%;
            left: 10%;
            animation-delay: 6s;
        }
        
        .floating-element:nth-child(4) {
            bottom: 5%;
            right: 15%;
            animation-delay: 1.5s;
        }
        
        .floating-element:nth-child(5) {
            top: 50%;
            left: 2%;
            animation-delay: 4.5s;
        }
        
        .floating-element:nth-child(6) {
            top: 60%;
            right: 2%;
            animation-delay: 7s;
        }
        
        @keyframes float {
            0%, 100% { transform: translateY(0px) rotate(0deg) scale(1); }
            33% { transform: translateY(-15px) rotate(120deg) scale(1.1); }
            66% { transform: translateY(-10px) rotate(240deg) scale(0.9); }
        }
        
        .glass-effect {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.2);
        }
        
        .text-shadow {
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.3);
        }
    </style>
</head>
<body class="fantasy-bg">
    <!-- Floating Fantasy Elements -->
    <div class="floating-elements">
        <div class="floating-element">
            <i class="fas fa-hat-wizard text-7xl text-amber-400"></i>
        </div>
        <div class="floating-element">
            <i class="fas fa-dragon text-6xl text-purple-400"></i>
        </div>
        <div class="floating-element">
            <i class="fas fa-magic text-5xl text-amber-400"></i>
        </div>
        <div class="floating-element">
            <i class="fas fa-castle text-6xl text-purple-400"></i>
        </div>
        <div class="floating-element">
            <i class="fas fa-gem text-4xl text-amber-400"></i>
        </div>
        <div class="floating-element">
            <i class="fas fa-scroll text-5xl text-purple-400"></i>
        </div>
    </div>

    <div class="min-h-screen flex items-center justify-center py-6 px-4 sm:px-6 lg:px-8 relative z-10">
        <div class="max-w-md w-full space-y-6">
            <!-- Header -->
            <div class="text-center">
                <a href="<?= base_url() ?>" class="text-5xl font-fantasy font-bold text-white hover:text-amber-300 transition-colors text-shadow">
                    <i class="fas fa-book-open mr-3 text-amber-400"></i>NARRIA
                </a>
                <h2 class="mt-4 text-2xl font-bold text-white text-shadow">
                    Bergabung dengan Dunia Fantasi
                </h2>
                <p class="mt-2 text-sm text-purple-100">
                    Mulai petualangan magis Anda hari ini
                </p>
            </div>

            <!-- Form -->
            <div class="glass-effect rounded-xl shadow-2xl p-6">
                <?php if (session()->getFlashdata('errors')): ?>
                <div class="mb-6 bg-red-50 border border-red-200 rounded-lg p-4">
                    <div class="flex">
                        <i class="fas fa-exclamation-circle text-red-400 mr-3 mt-1"></i>
                        <div>
                            <h3 class="text-sm font-medium text-red-800">Terjadi kesalahan:</h3>
                            <ul class="mt-2 text-sm text-red-700 list-disc list-inside">
                                <?php foreach (session()->getFlashdata('errors') as $error): ?>
                                <li><?= esc($error) ?></li>
                                <?php endforeach; ?>
                            </ul>
                        </div>
                    </div>
                </div>
                <?php endif; ?>

                <form action="<?= base_url('register') ?>" method="POST" class="space-y-4">
                    <?= csrf_field() ?>
                    
                    <!-- Username -->
                    <div>
                        <label for="username" class="block text-sm font-medium text-gray-700 mb-2">
                            <i class="fas fa-at mr-2 text-purple-500"></i>Username
                        </label>
                        <input type="text" 
                               id="username" 
                               name="username" 
                               value="<?= old('username') ?>"
                               placeholder="Username"
                               class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent transition-colors bg-white/90"
                               required>
                        <p class="mt-1 text-xs text-gray-500">
                            <i class="fas fa-info-circle mr-1"></i>
                            Username untuk URL profil (tanpa spasi, huruf kecil, underscore/titik diperbolehkan)
                        </p>
                    </div>

                    <!-- Display Name -->
                    <div>
                        <label for="display_name" class="block text-sm font-medium text-gray-700 mb-2">
                            <i class="fas fa-user mr-2 text-purple-500"></i>Nama
                        </label>
                        <input type="text" 
                               id="display_name" 
                               name="display_name" 
                               value="<?= old('display_name') ?>"
                               placeholder="Nama Lengkap Anda"
                               class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent transition-colors bg-white/90"
                               required>
                        <p class="mt-1 text-xs text-gray-500">
                            <i class="fas fa-info-circle mr-1"></i>
                            Nama yang akan ditampilkan di profil Anda (bisa menggunakan spasi)
                        </p>
                    </div>

                    <!-- Email -->
                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700 mb-2">
                            <i class="fas fa-envelope mr-2 text-purple-500"></i>Email
                        </label>
                        <input type="email" 
                               id="email" 
                               name="email" 
                               value="<?= old('email') ?>"
                               placeholder="nama@email.com"
                               class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent transition-colors bg-white/90"
                               required>
                    </div>

                    <!-- Password -->
                    <div>
                        <label for="password" class="block text-sm font-medium text-gray-700 mb-2">
                            <i class="fas fa-lock mr-2 text-purple-500"></i>Password
                        </label>
                        <div class="relative">
                            <input type="password" 
                                   id="password" 
                                   name="password" 
                                   placeholder="Minimal 6 karakter"
                                   class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent transition-colors pr-12 bg-white/90"
                                   required>
                            <button type="button" 
                                    onclick="togglePassword('password')"
                                    class="absolute right-3 top-3 text-gray-400 hover:text-gray-600">
                                <i class="fas fa-eye" id="password-eye"></i>
                            </button>
                        </div>
                    </div>

                    <!-- Confirm Password -->
                    <div>
                        <label for="password_confirm" class="block text-sm font-medium text-gray-700 mb-2">
                            <i class="fas fa-lock mr-2 text-purple-500"></i>Konfirmasi Password
                        </label>
                        <div class="relative">
                            <input type="password" 
                                   id="password_confirm" 
                                   name="password_confirm" 
                                   placeholder="Ulangi password"
                                   class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent transition-colors pr-12 bg-white/90"
                                   required>
                            <button type="button" 
                                    onclick="togglePassword('password_confirm')"
                                    class="absolute right-3 top-3 text-gray-400 hover:text-gray-600">
                                <i class="fas fa-eye" id="password_confirm-eye"></i>
                            </button>
                        </div>
                    </div>

                    <!-- Submit Button -->
                    <button type="submit" 
                            class="w-full gradient-fantasy text-white font-bold py-3 px-4 rounded-lg hover:opacity-90 transition duration-300 shadow-lg transform hover:scale-105">
                        <i class="fas fa-user-plus mr-2"></i>Mulai Petualangan
                    </button>
                </form>

                <!-- Login Link -->
                <div class="mt-6 text-center">
                    <p class="text-sm text-gray-600">
                        Sudah memiliki akun petualang? 
                        <a href="<?= base_url('login') ?>" class="text-purple-600 hover:text-purple-800 font-medium">
                            Masuk di sini
                        </a>
                    </p>
                </div>
            </div>

            <!-- Back to Home -->
            <div class="text-center">
                <a href="<?= base_url() ?>" class="text-white hover:text-amber-300 font-medium inline-flex items-center transition-colors">
                    <i class="fas fa-arrow-left mr-2"></i>Kembali ke Portal Utama
                </a>
            </div>
        </div>
    </div>

    <script>
        function togglePassword(fieldId) {
            const field = document.getElementById(fieldId);
            const eye = document.getElementById(fieldId + '-eye');
            
            if (field.type === 'password') {
                field.type = 'text';
                eye.classList.remove('fa-eye');
                eye.classList.add('fa-eye-slash');
            } else {
                field.type = 'password';
                eye.classList.remove('fa-eye-slash');
                eye.classList.add('fa-eye');
            }
        }
    </script>
</body>
</html>
