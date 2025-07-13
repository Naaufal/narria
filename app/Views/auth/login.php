<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Narria</title>
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
            background-image: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%23fbbf24' fill-opacity='0.05'%3E%3Cpath d='M30 30c0-11.046-8.954-20-20-20s-20 8.954-20 20 8.954 20 20 20 20-8.954 20-20zm0 0c0 11.046 8.954 20 20 20s20-8.954 20-20-8.954-20-20-20-20 8.954-20 20z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
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
            opacity: 0.1;
            animation: float 6s ease-in-out infinite;
        }
        
        .floating-element:nth-child(1) {
            top: 10%;
            left: 10%;
            animation-delay: 0s;
        }
        
        .floating-element:nth-child(2) {
            top: 20%;
            right: 10%;
            animation-delay: 2s;
        }
        
        .floating-element:nth-child(3) {
            bottom: 20%;
            left: 20%;
            animation-delay: 4s;
        }
        
        .floating-element:nth-child(4) {
            bottom: 10%;
            right: 20%;
            animation-delay: 1s;
        }
        
        @keyframes float {
            0%, 100% { transform: translateY(0px) rotate(0deg); }
            50% { transform: translateY(-20px) rotate(180deg); }
        }
        
        .glass-effect {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.2);
        }
    </style>
</head>
<body class="fantasy-bg min-h-screen">
    <div class="min-h-screen flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8 relative z-10">
        <div class="max-w-md w-full space-y-8">
            <!-- Header -->
            <div class="text-center">
                <a href="<?= base_url() ?>" class="text-5xl font-fantasy font-bold text-white hover:text-amber-300 transition-colors text-shadow">
                    <i class="fas fa-book-open mr-3 text-amber-400"></i>NARRIA
                </a>
                <h2 class="mt-6 text-3xl font-bold text-white text-shadow">
                    Selamat Datang Kembali
                </h2>
                <p class="mt-2 text-sm text-purple-100">
                    Masuk ke akun Anda untuk melanjutkan petualangan magis
                </p>
            </div>

            <!-- Form -->
            <div class="glass-effect rounded-xl shadow-2xl p-8">
                <?php if (session()->getFlashdata('success')): ?>
                <div class="mb-6 bg-green-50 border border-green-200 rounded-lg p-4">
                    <div class="flex">
                        <i class="fas fa-check-circle text-green-400 mr-3 mt-1"></i>
                        <div class="text-sm text-green-800">
                            <?= session()->getFlashdata('success') ?>
                        </div>
                    </div>
                </div>
                <?php endif; ?>

                <?php if (session()->getFlashdata('msg')): ?>
                <div class="mb-6 bg-red-50 border border-red-200 rounded-lg p-4">
                    <div class="flex">
                        <i class="fas fa-exclamation-circle text-red-400 mr-3 mt-1"></i>
                        <div class="text-sm text-red-800">
                            <?= session()->getFlashdata('msg') ?>
                        </div>
                    </div>
                </div>
                <?php endif; ?>

                <form action="<?= base_url('login') ?>" method="POST" class="space-y-6">
                    <?= csrf_field() ?>
                    
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
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent transition-colors bg-white/90"
                               required autofocus>
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
                                   placeholder="Masukkan password Anda"
                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent transition-colors pr-12 bg-white/90"
                                   required>
                            <button type="button" 
                                    onclick="togglePassword('password')"
                                    class="absolute right-3 top-3 text-gray-400 hover:text-gray-600">
                                <i class="fas fa-eye" id="password-eye"></i>
                            </button>
                        </div>
                    </div>

                    <!-- Remember Me & Forgot Password -->
                    <div class="flex items-center justify-between">
                        <div class="flex items-center">
                            <input type="checkbox" 
                                   id="remember" 
                                   name="remember" 
                                   class="h-4 w-4 text-purple-600 focus:ring-purple-500 border-gray-300 rounded">
                            <label for="remember" class="ml-2 block text-sm text-gray-700">
                                Ingat saya
                            </label>
                        </div>
                        <div class="text-sm">
                            <a href="#" class="text-purple-600 hover:text-purple-800 font-medium">
                                Lupa password?
                            </a>
                        </div>
                    </div>

                    <!-- Submit Button -->
                    <button type="submit" 
                            class="w-full gradient-fantasy text-white font-bold py-3 px-4 rounded-lg hover:opacity-90 transition duration-300 shadow-lg transform hover:scale-105">
                        <i class="fas fa-sign-in-alt mr-2"></i>Masuk ke Dunia Fantasi
                    </button>
                </form>

                <!-- Register Link -->
                <div class="mt-6 text-center">
                    <p class="text-sm text-gray-600">
                        Belum memiliki akun petualang? 
                        <a href="<?= base_url('register') ?>" class="text-purple-600 hover:text-purple-800 font-medium">
                            Bergabung sekarang
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
