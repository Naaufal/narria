<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?? 'Narria - Portal Novel Fantasi Modern' ?></title>
    <meta name="description" content="Jelajahi dunia fantasi melalui ribuan novel di Narria. Portal novel fantasi modern dengan koleksi terlengkap.">
    
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
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Cinzel:wght@400;600;700&family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Custom Styles -->
    <style>
        :root {
            --primary-purple: #4c1d95;
            --secondary-purple: #6d28d9;
            --accent-gold: #f59e0b;
            --dark-purple: #2d1b69;
            --light-purple: #8b5cf6;
        }

        .font-fantasy {
            font-family: 'Cinzel', serif;
        }

        .gradient-fantasy {
            background: linear-gradient(135deg, var(--primary-purple) 0%, var(--secondary-purple) 50%, var(--dark-purple) 100%);
        }

        .gradient-gold {
            background: linear-gradient(135deg, var(--accent-gold) 0%, #fbbf24 100%);
        }

        .card-fantasy {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(139, 92, 246, 0.2);
            transition: all 0.3s ease;
        }

        .card-fantasy:hover {
            transform: translateY(-8px);
            box-shadow: 0 25px 50px -12px rgba(79, 70, 229, 0.25);
            border-color: var(--accent-gold);
        }

        .text-shadow {
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.3);
        }

        /* Particle Animation */
        .particles {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            pointer-events: none;
            z-index: -1;
        }

        .particle {
            position: absolute;
            width: 4px;
            height: 4px;
            background: var(--accent-gold);
            border-radius: 50%;
            opacity: 0.6;
            animation: float 6s ease-in-out infinite;
        }

        .particle:nth-child(odd) {
            background: var(--light-purple);
            animation-duration: 8s;
        }

        .particle:nth-child(3n) {
            width: 2px;
            height: 2px;
            animation-duration: 10s;
        }

        @keyframes float {
            0%, 100% { transform: translateY(0px) rotate(0deg); opacity: 0.6; }
            50% { transform: translateY(-20px) rotate(180deg); opacity: 1; }
        }

        /* Custom scrollbar */
        ::-webkit-scrollbar {
            width: 8px;
        }

        ::-webkit-scrollbar-track {
            background: #f1f5f9;
        }

        ::-webkit-scrollbar-thumb {
            background: var(--secondary-purple);
            border-radius: 4px;
        }

        ::-webkit-scrollbar-thumb:hover {
            background: var(--primary-purple);
        }
    </style>
</head>
<body class="bg-slate-50 relative">
    <!-- Particle Background -->
    <div class="particles" id="particles"></div>

    <!-- Navigation -->
    <nav class="bg-white/90 backdrop-blur-md shadow-lg sticky top-0 z-50 border-b border-purple-100">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-16">
                <!-- Logo -->
                <div class="flex items-center">
                    <a href="<?= base_url() ?>" class="text-2xl font-fantasy font-bold text-purple-800 hover:text-purple-600 transition-colors">
                        NARRIA
                    </a>
                </div>

                <!-- Desktop Menu -->
                <div class="hidden md:flex items-center space-x-8">
                    <a href="<?= base_url() ?>" class="text-gray-700 hover:text-purple-600 transition duration-300 font-medium">
                        <i class="fas fa-home mr-1"></i>Beranda
                    </a>
                    <a href="<?= base_url('novels') ?>" class="text-gray-700 hover:text-purple-600 transition duration-300 font-medium">
                        <i class="fas fa-book mr-1"></i>Novel
                    </a>
                    <a href="<?= base_url('categories') ?>" class="text-gray-700 hover:text-purple-600 transition duration-300 font-medium">
                        <i class="fas fa-tags mr-1"></i>Kategori
                    </a>
                    
                    <!-- Search Form -->
                    <form action="<?= base_url('search') ?>" method="GET" class="flex items-center">
                        <div class="relative">
                            <input type="text" name="q" placeholder="Cari novel magis..." 
                                   class="w-64 pl-10 pr-4 py-2 border border-purple-200 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent bg-white/80">
                            <i class="fas fa-search absolute left-3 top-3 text-purple-400"></i>
                        </div>
                    </form>

                    <!-- Auth Links -->
                    <?php if (session()->get('isLoggedIn')): ?>
                        <div class="flex items-center space-x-4">
                            <div class="relative group">
                                <?php
                                    $profileImage = session()->get('profile') 
                                        ? base_url('uploads/profile/' . session()->get('profile')) 
                                        : base_url('uploads/profile/default.png'); // fallback jika kosong
                                    
                                    // Gunakan display_name jika ada, fallback ke username
                                    $displayName = session()->get('user_display_name') ?: session()->get('user_name');
                                ?>
                                <button class="flex items-center space-x-2 text-gray-700 hover:text-purple-600 transition-colors">
                                    <img src="<?= $profileImage ?>" alt="Foto Profil" class="w-8 h-8 rounded-full object-cover border border-gray-300 shadow-sm">
                                    <span class="font-medium"><?= esc($displayName) ?></span>
                                    <i class="fas fa-chevron-down text-xs"></i>
                                </button>
                                
                                <!-- Dropdown Menu -->
                                <div class="absolute right-0 mt-2 w-48 bg-white rounded-lg shadow-lg border border-purple-100 opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-200">
                                    <div class="py-2">
                                        <a href="<?= base_url('profile') ?>" class="block px-4 py-2 text-gray-700 hover:bg-purple-50 hover:text-purple-600">
                                            <i class="fas fa-user mr-2"></i>Profile
                                        </a>
                                        <a href="<?= base_url('profile/bookmarks') ?>" class="block px-4 py-2 text-gray-700 hover:bg-purple-50 hover:text-purple-600">
                                            <i class="fas fa-bookmark mr-2"></i>Bookmark
                                        </a>
                                        <a href="<?= base_url('profile/history') ?>" class="block px-4 py-2 text-gray-700 hover:bg-purple-50 hover:text-purple-600">
                                            <i class="fas fa-history mr-2"></i>Riwayat
                                        </a>
                                        <?php if (session()->get('role') === 'author'): ?>
                                        <a href="<?= base_url('author') ?>" class="block px-4 py-2 text-gray-700 hover:bg-purple-50 hover:text-purple-600">
                                            <i class="fas fa-pen mr-2"></i>Dashboard Author
                                        </a>
                                        <?php endif; ?>
                                        <?php if (session()->get('role') === 'admin'): ?>
                                        <a href="<?= base_url('admin') ?>" class="block px-4 py-2 text-gray-700 hover:bg-purple-50 hover:text-purple-600">
                                            <i class="fas fa-cog mr-2"></i>Admin Panel
                                        </a>
                                        <?php endif; ?>
                                        <hr class="my-2">
                                        <a href="<?= base_url('logout') ?>" class="block px-4 py-2 text-red-600 hover:bg-red-50">
                                            <i class="fas fa-sign-out-alt mr-2"></i>Logout
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php else: ?>
                        <div class="flex items-center space-x-4">
                            <a href="<?= base_url('login') ?>" class="text-purple-600 hover:text-purple-800 font-medium">
                                <i class="fas fa-sign-in-alt mr-1"></i>Masuk
                            </a>
                            <a href="<?= base_url('register') ?>" class="gradient-fantasy text-white px-4 py-2 rounded-lg hover:opacity-90 transition duration-300 font-medium">
                                <i class="fas fa-user-plus mr-1"></i>Daftar
                            </a>
                        </div>
                    <?php endif; ?>
                </div>

                <!-- Mobile menu button -->
                <div class="md:hidden">
                    <button id="mobile-menu-button" class="text-gray-700 hover:text-purple-600">
                        <i class="fas fa-bars text-xl"></i>
                    </button>
                </div>
            </div>

            <!-- Mobile Menu -->
            <div id="mobile-menu" class="md:hidden hidden pb-4">
                <div class="flex flex-col space-y-4">
                    <a href="<?= base_url() ?>" class="text-gray-700 hover:text-purple-600 font-medium">
                        <i class="fas fa-home mr-2"></i>Beranda
                    </a>
                    <a href="<?= base_url('novels') ?>" class="text-gray-700 hover:text-purple-600 font-medium">
                        <i class="fas fa-book mr-2"></i>Novel
                    </a>
                    <a href="<?= base_url('categories') ?>" class="text-gray-700 hover:text-purple-600 font-medium">
                        <i class="fas fa-tags mr-2"></i>Kategori
                    </a>
                    
                    <!-- Mobile Search -->
                    <form action="<?= base_url('search') ?>" method="GET" class="mt-4">
                        <input type="text" name="q" placeholder="Cari novel magis..." 
                               class="w-full pl-4 pr-4 py-2 border border-purple-200 rounded-lg focus:ring-2 focus:ring-purple-500 bg-white/80">
                    </form>

                    <?php if (session()->get('isLoggedIn')): ?>
                        <div class="border-t border-purple-100 pt-4">
                            <?php $displayName = session()->get('user_display_name') ?: session()->get('user_name'); ?>
                            <p class="text-gray-700 mb-2 font-medium">Halo, <?= esc($displayName) ?></p>
                            <a href="<?= base_url('profile') ?>" class="block text-purple-600 hover:text-purple-800 mb-2">
                                <i class="fas fa-user mr-2"></i>Profile
                            </a>
                            <a href="<?= base_url('logout') ?>" class="block bg-red-500 text-white px-4 py-2 rounded-lg text-center">
                                <i class="fas fa-sign-out-alt mr-2"></i>Logout
                            </a>
                        </div>
                    <?php else: ?>
                        <div class="border-t border-purple-100 pt-4 space-y-2">
                            <a href="<?= base_url('login') ?>" class="block text-center text-purple-600 hover:text-purple-800 font-medium">
                                <i class="fas fa-sign-in-alt mr-2"></i>Masuk
                            </a>
                            <a href="<?= base_url('register') ?>" class="block gradient-fantasy text-white px-4 py-2 rounded-lg text-center font-medium">
                                <i class="fas fa-user-plus mr-2"></i>Daftar
                            </a>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <?= $this->renderSection('content') ?>

    <!-- Footer -->
    <footer class="gradient-fantasy text-white mt-10 relative overflow-hidden">
        <div class="absolute inset-0 bg-black/20"></div>
        <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
                <!-- About -->
                <div>
                    <h3 class="text-2xl font-fantasy font-bold mb-4 text-shadow">
                        <i class="fas fa-magic mr-2 text-amber-400"></i>NARRIA
                    </h3>
                    <p class="text-purple-100 mb-6 leading-relaxed">
                        Portal novel fantasi modern yang menghadirkan dunia magis melalui ribuan cerita menakjubkan. 
                        Jelajahi petualangan tak terbatas di ujung jari Anda.
                    </p>
                    <div class="flex space-x-4">
                        <a href="#" class="w-10 h-10 bg-white/20 rounded-full flex items-center justify-center text-white hover:bg-amber-500 transition-colors">
                            <i class="fab fa-facebook-f"></i>
                        </a>
                        <a href="#" class="w-10 h-10 bg-white/20 rounded-full flex items-center justify-center text-white hover:bg-amber-500 transition-colors">
                            <i class="fab fa-twitter"></i>
                        </a>
                        <a href="#" class="w-10 h-10 bg-white/20 rounded-full flex items-center justify-center text-white hover:bg-amber-500 transition-colors">
                            <i class="fab fa-instagram"></i>
                        </a>
                        <a href="#" class="w-10 h-10 bg-white/20 rounded-full flex items-center justify-center text-white hover:bg-amber-500 transition-colors">
                            <i class="fab fa-discord"></i>
                        </a>
                    </div>
                </div>

                <!-- Quick Links -->
                <div>
                    <h4 class="text-lg font-semibold mb-6 text-amber-400 font-fantasy">
                        <i class="fas fa-compass mr-2"></i>Navigasi
                    </h4>
                    <ul class="space-y-3">
                        <li><a href="<?= base_url() ?>" class="text-purple-100 hover:text-amber-400 transition-colors flex items-center">
                            <i class="fas fa-home mr-2 w-4"></i>Beranda
                        </a></li>
                        <li><a href="<?= base_url('novels') ?>" class="text-purple-100 hover:text-amber-400 transition-colors flex items-center">
                            <i class="fas fa-book mr-2 w-4"></i>Semua Novel
                        </a></li>
                        <li><a href="<?= base_url('categories') ?>" class="text-purple-100 hover:text-amber-400 transition-colors flex items-center">
                            <i class="fas fa-tags mr-2 w-4"></i>Kategori
                        </a></li>
                        <li><a href="<?= base_url('search') ?>" class="text-purple-100 hover:text-amber-400 transition-colors flex items-center">
                            <i class="fas fa-search mr-2 w-4"></i>Pencarian
                        </a></li>
                    </ul>
                </div>

                <!-- Categories -->
                <div>
                    <h4 class="text-lg font-semibold mb-6 text-amber-400 font-fantasy">
                        <i class="fas fa-dragon mr-2"></i>Genre Populer
                    </h4>
                    <ul class="space-y-3">
                        <li><a href="#" class="text-purple-100 hover:text-amber-400 transition-colors flex items-center">
                            <i class="fas fa-heart mr-2 w-4 text-pink-400"></i>Romance
                        </a></li>
                        <li><a href="#" class="text-purple-100 hover:text-amber-400 transition-colors flex items-center">
                            <i class="fas fa-magic mr-2 w-4 text-purple-400"></i>Fantasy
                        </a></li>
                        <li><a href="#" class="text-purple-100 hover:text-amber-400 transition-colors flex items-center">
                            <i class="fas fa-theater-masks mr-2 w-4 text-blue-400"></i>Drama
                        </a></li>
                        <li><a href="#" class="text-purple-100 hover:text-amber-400 transition-colors flex items-center">
                            <i class="fas fa-fist-raised mr-2 w-4 text-red-400"></i>Action
                        </a></li>
                    </ul>
                </div>

                <!-- Contact -->
                <div>
                    <h4 class="text-lg font-semibold mb-6 text-amber-400 font-fantasy">
                        <i class="fas fa-scroll mr-2"></i>Kontak Kami
                    </h4>
                    <ul class="space-y-3 text-purple-100">
                        <li class="flex items-center">
                            <i class="fas fa-envelope mr-3 w-4 text-amber-400"></i>
                            <a href="mailto:info@narria.com" class="hover:text-amber-400 transition-colors">info@narria.com</a>
                        </li>
                        <li class="flex items-center">
                            <i class="fas fa-phone mr-3 w-4 text-amber-400"></i>
                            <span>+62 123 456 789</span>
                        </li>
                        <li class="flex items-center">
                            <i class="fas fa-map-marker-alt mr-3 w-4 text-amber-400"></i>
                            <span>Jakarta, Indonesia</span>
                        </li>
                        <li class="flex items-center">
                            <i class="fas fa-clock mr-3 w-4 text-amber-400"></i>
                            <span>24/7 Online</span>
                        </li>
                    </ul>
                </div>
            </div>

            <div class="border-t border-white/20 mt-12 pt-8">
                <div class="flex flex-col md:flex-row justify-between items-center">
                    <p class="text-purple-100 text-center md:text-left mb-4 md:mb-0">
                        &copy; <?= date('Y') ?> Narria. Semua hak cipta dilindungi undang-undang. 
                        <span class="text-amber-400">✨ Dibuat dengan magis dan cinta</span>
                    </p>
                    <div class="flex space-x-6 text-sm">
                        <a href="#" class="text-purple-100 hover:text-amber-400 transition-colors">Kebijakan Privasi</a>
                        <a href="#" class="text-purple-100 hover:text-amber-400 transition-colors">Syarat & Ketentuan</a>
                        <a href="#" class="text-purple-100 hover:text-amber-400 transition-colors">FAQ</a>
                    </div>
                </div>
            </div>
        </div>
    </footer>

    <!-- Scroll to Top Button -->
    <button id="scrollToTop" class="fixed bottom-6 right-6 w-12 h-12 gradient-gold rounded-full shadow-lg opacity-0 invisible transition-all duration-300 hover:scale-110 z-50">
        <i class="fas fa-arrow-up text-white"></i>
    </button>

    <script>
        // Create particles
        function createParticles() {
            const particlesContainer = document.getElementById('particles');
            const particleCount = 15;
            
            for (let i = 0; i < particleCount; i++) {
                const particle = document.createElement('div');
                particle.className = 'particle';
                particle.style.left = Math.random() * 100 + '%';
                particle.style.top = Math.random() * 100 + '%';
                particle.style.animationDelay = Math.random() * 6 + 's';
                particlesContainer.appendChild(particle);
            }
        }

        // Mobile menu toggle
        document.getElementById('mobile-menu-button').addEventListener('click', function() {
            const mobileMenu = document.getElementById('mobile-menu');
            mobileMenu.classList.toggle('hidden');
        });

        // Scroll to top functionality
        const scrollToTopBtn = document.getElementById('scrollToTop');
        
        window.addEventListener('scroll', () => {
            if (window.pageYOffset > 300) {
                scrollToTopBtn.classList.remove('opacity-0', 'invisible');
            } else {
                scrollToTopBtn.classList.add('opacity-0', 'invisible');
            }
        });

        scrollToTopBtn.addEventListener('click', () => {
            window.scrollTo({
                top: 0,
                behavior: 'smooth'
            });
        });

        // Initialize particles when page loads
        document.addEventListener('DOMContentLoaded', createParticles);
    </script>
</body>
</html>
