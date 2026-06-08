<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=yes">
    <title>Reky Saputra | Portfolio Futuristik</title>
    <!-- Tailwind CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Cinzel:wght@400;700;800&family=Inter:wght@300;400;600;700;800&display=swap" rel="stylesheet">
    
    <style>
        /* ========== CSS FULL ========== */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            background-color: #050505;
            color: #ffffff;
            font-family: 'Inter', sans-serif;
            overflow-x: hidden;
            cursor: default;
        }
        
        h1, h2, h3, .brand-font {
            font-family: 'Cinzel', serif;
            letter-spacing: 1px;
        }
        
        /* Canvas Background Particle Interaktif */
        #particleCanvas {
            position: fixed;
            top: 0;
            left: 0;
            width: 100vw;
            height: 100vh;
            z-index: -2;
            pointer-events: auto;
            display: block;
        }
        
        /* Magnetic Liquid Glow (cairan warna-warni mengikuti mouse) */
        #liquidGlow {
            position: fixed;
            top: 0;
            left: 0;
            width: 500px;
            height: 500px;
            background: radial-gradient(circle, rgba(255,0,150,0.5), rgba(0,200,255,0.4), rgba(255,255,0,0.3));
            filter: blur(80px);
            border-radius: 50%;
            pointer-events: none;
            z-index: -1;
            transition: transform 0.08s linear;
            mix-blend-mode: screen;
            opacity: 0.7;
            will-change: transform;
        }
        
        /* Glassmorphism standar */
        .glass-panel {
            background: rgba(10, 10, 20, 0.4);
            backdrop-filter: blur(14px);
            -webkit-backdrop-filter: blur(14px);
            border: 1px solid rgba(255,255,255,0.1);
            border-radius: 2rem;
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
            transform-style: preserve-3d;
            --mouse-x: 50%;
            --mouse-y: 50%;
        }
        
        /* Efek 3D Tilt (diterapkan via JS) */
        .tilt-effect {
            transition: transform 0.1s ease-out;
            will-change: transform;
        }
        
        /* 1. Border Spotlight khusus untuk About Card */
        .border-spotlight {
            position: relative;
            isolation: isolate;
        }
        .border-spotlight::after {
            content: '';
            position: absolute;
            inset: 0;
            border-radius: 2rem;
            padding: 2px;
            background: radial-gradient(circle at var(--mouse-x, 50%) var(--mouse-y, 50%), #3b82f6, #a855f7, #ec4899);
            -webkit-mask: linear-gradient(#fff 0 0) content-box, linear-gradient(#fff 0 0);
            mask: linear-gradient(#fff 0 0) content-box, linear-gradient(#fff 0 0);
            -webkit-mask-composite: xor;
            mask-composite: exclude;
            pointer-events: none;
            opacity: 0;
            transition: opacity 0.3s;
        }
        .border-spotlight:hover::after {
            opacity: 1;
        }
        
        /* 2. Cyberpunk Glitch (teks bergetar) */
        .glitch-text {
            transition: all 0.2s;
        }
        .glitch-text:hover {
            animation: glitch-skew 0.3s infinite alternate;
            color: #0ff;
            text-shadow: -2px 0 #ff00c1, 2px 0 #00fff9;
        }
        @keyframes glitch-skew {
            0% { transform: skew(0deg); text-shadow: -1px 0 #ff00c1, 1px 0 #00fff9; }
            20% { transform: skew(2deg); text-shadow: -2px 0 #ff00c1, 2px 0 cyan; }
            40% { transform: skew(-2deg); }
            60% { transform: skew(1deg); }
            80% { transform: skew(-1deg); }
            100% { transform: skew(0deg); }
        }
        
        /* 3. Dynamic Expand (muncul teks tersembunyi) */
        .expand-card {
            transition: all 0.4s cubic-bezier(0.2, 0.9, 0.4, 1.1);
        }
        .expand-hidden {
            max-height: 0;
            opacity: 0;
            overflow: hidden;
            transition: max-height 0.5s ease, opacity 0.4s ease;
        }
        .expand-card:hover .expand-hidden {
            max-height: 200px;
            opacity: 1;
        }
        
        /* 4. Magnetic Pull (efek tarik ke kursor) */
        .magnetic-item {
            transition: transform 0.2s cubic-bezier(0.2, 0.9, 0.6, 1.1);
            will-change: transform;
            cursor: pointer;
            display: inline-block;
        }
        
        /* 5. 3D Flip Card */
        .flip-card {
            background-color: transparent;
            perspective: 1500px;
            cursor: pointer;
        }
        .flip-inner {
            position: relative;
            width: 100%;
            height: 100%;
            transition: transform 0.7s cubic-bezier(0.23, 1, 0.32, 1);
            transform-style: preserve-3d;
            border-radius: 1.5rem;
        }
        .flip-card:hover .flip-inner {
            transform: rotateY(180deg);
        }
        .flip-front, .flip-back {
            position: absolute;
            width: 100%;
            height: 100%;
            backface-visibility: hidden;
            border-radius: 1.5rem;
            background: rgba(15, 15, 30, 0.6);
            backdrop-filter: blur(12px);
            border: 1px solid rgba(255,255,255,0.15);
            padding: 1.5rem;
        }
        .flip-back {
            transform: rotateY(180deg);
            background: linear-gradient(135deg, rgba(59,130,246,0.2), rgba(139,92,246,0.2));
        }
        
        /* Navbar styling */
        .navbar {
            background: rgba(0,0,0,0.6);
            backdrop-filter: blur(12px);
            border-bottom: 1px solid rgba(255,255,255,0.1);
            transition: all 0.3s;
        }
        .nav-link {
            position: relative;
            transition: color 0.2s;
            cursor: pointer;
        }
        .nav-link::after {
            content: '';
            position: absolute;
            bottom: -5px;
            left: 0;
            width: 0;
            height: 2px;
            background: linear-gradient(90deg, #3b82f6, #a855f7);
            transition: width 0.3s;
        }
        .nav-link:hover::after {
            width: 100%;
        }
        
        /* Reveal animasi scroll */
        .reveal {
            opacity: 0;
            transform: translateY(35px);
            transition: all 0.8s ease-out;
        }
        .reveal.active {
            opacity: 1;
            transform: translateY(0);
        }
        
        /* Typewriter cursor */
        .cursor::after {
            content: '|';
            animation: blink 1s step-end infinite;
            color: #3b82f6;
        }
        @keyframes blink {
            50% { opacity: 0; }
        }
        
        html {
            scroll-behavior: smooth;
        }
        
        ::selection {
            background: #3b82f6;
            color: #fff;
        }
        
        /* Responsive adjustments */
        @media (max-width: 768px) {
            .glass-panel {
                border-radius: 1.5rem;
            }
            .flip-card {
                height: 280px;
            }
        }
    </style>
</head>
<body>

    <canvas id="particleCanvas"></canvas>
    <div id="liquidGlow"></div>

    <!-- Navbar Menu -->
    <nav class="navbar fixed top-0 w-full z-50 py-4 px-6 md:px-12 transition-all" id="navbar">
        <div class="max-w-7xl mx-auto flex flex-wrap justify-between items-center">
            <a href="#" class="text-2xl font-bold tracking-wider brand-font bg-gradient-to-r from-blue-400 to-purple-500 bg-clip-text text-transparent">REKY</a>
            <div class="flex gap-5 text-sm md:text-base font-medium">
                <a href="#home" class="nav-link text-gray-300 hover:text-white">Home</a>
                <a href="#about" class="nav-link text-gray-300 hover:text-white">About</a>
                <a href="#experience" class="nav-link text-gray-300 hover:text-white">Experience</a>
                <a href="#projects" class="nav-link text-gray-300 hover:text-white">Projects</a>
                <a href="#skills" class="nav-link text-gray-300 hover:text-white">Skills</a>
                <a href="#contact" class="nav-link text-gray-300 hover:text-white">Contact</a>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section id="home" class="min-h-screen flex flex-col justify-center items-center text-center px-4 pt-28 pb-20 relative">
        <h1 class="text-6xl md:text-8xl font-bold tracking-widest mb-5 reveal brand-font bg-gradient-to-r from-white to-gray-400 bg-clip-text text-transparent">REKY SAPUTRA</h1>
        <div class="text-xl text-gray-300 reveal"><span id="typewriter" class="text-white text-2xl md:text-3xl cursor"></span></div>
        <p class="mt-6 text-gray-400 max-w-xl reveal">#Creative | #Design | #Visionary</p>
        <div class="mt-10 flex gap-4 reveal">
            <a href="#projects" class="px-6 py-3 rounded-full bg-blue-600 hover:bg-blue-500 transition shadow-lg">Explore Work</a>
            <a href="#contact" class="px-6 py-3 rounded-full border border-white/30 hover:bg-white/10 transition">Contact Me</a>
        </div>
    </section>

    <!-- Main Content -->
    <main class="max-w-7xl mx-auto px-4 md:px-6 pb-24 relative z-10">
        
        <!-- About Section dengan Foto Profil -->
        <section id="about" class="mb-24 reveal">
            <div class="glass-panel border-spotlight p-8 md:p-10 tilt-effect" id="aboutCard">
                <div class="flex flex-col md:flex-row gap-8 items-center">
                    <div class="flex-1">
                        <h3 class="text-3xl font-bold text-blue-300 brand-font">Tentang Saya</h3>
                        <p class="text-gray-300 mt-4 leading-relaxed">Halo! Saya <span class="text-white font-semibold">Reky Dwi Saputra</span>, seorang mahasiswa aktif Politeknik Elektronika Negeri Surabaya jurusan Multimedia Broadcasting yang memiliki minat dan kemampuan di bidang produksi konten, editing video, serta pengelolaan media digital. Terbiasa bekerja secara individu maupun tim, serta siap mengembangkan diri dan berkontribusi di industri kreatif.</p>
                        <p class="text-gray-400 mt-3">🎓 Politeknik Elektronika Negeri Surabaya | 🚀 Jurusan Multimedia Broadcasting</p>
                    </div>
                    <div class="flex-shrink-0">
                        <div class="relative">
                            <!-- Efek glow di belakang -->
                            <div class="absolute inset-0 bg-gradient-to-r from-blue-500 to-purple-600 rounded-full blur-xl opacity-60"></div>
                            <!-- Foto profil dengan border bulat -->
                            <div class="relative w-32 h-32 md:w-40 md:h-40 rounded-full overflow-hidden border-2 border-white/30 shadow-xl">
                                <!-- DI SINI LOKASI KODE FOTO KAMU DIPERBARUI -->
                                <img 
                                    src="{{ asset('images/foto-reky.jpg') }}" 
                                    alt="Reky Saputra"
                                    class="w-full h-full object-cover"
                                >
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        
        <!-- Experience Section -->
        <section id="experience" class="mb-24 reveal">
            <h2 class="text-4xl md:text-5xl font-bold mb-10 text-center brand-font bg-gradient-to-r from-cyan-400 to-purple-400 bg-clip-text text-transparent">Work Experience</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-7">
                <div class="glass-panel p-7 glitch-text transition-all duration-300">
                    <div class="flex items-center gap-3 mb-3">
                        <span class="text-3xl">💼</span>
                        <h3 class="text-2xl font-bold">WORKSHOP NEXTGEN CREATORS | 2024</h3>
                    </div>
                    <p class="text-cyan-300 text-sm">Divisi Perlengkapan</p>
                    <p class="text-gray-300 mt-2">Mengelola dan mendistribusikan kebutuhan perlengkapan teknis maupun non-teknis guna memastikan seluruh rangkaian workshop berjalan lancar dan terorganisir.</p>
                </div>
                <div class="glass-panel p-7 glitch-text transition-all duration-300">
                    <div class="flex items-center gap-3 mb-3">
                        <span class="text-3xl">⚙️</span>
                        <h3 class="text-2xl font-bold">MMB FEST | 2025</h3>
                    </div>
                    <p class="text-cyan-300 text-sm">Sie Perlengkapan</p>
                    <p class="text-gray-300 mt-2">Berkoordinasi antar tim untuk menyiapkan, mengelola, dan memastikan ketersediaan seluruh perlengkapan serta kebutuhan operasional selama festival berlangsung.</p>
                </div>
                <div class="glass-panel p-7 glitch-text transition-all duration-300">
                    <div class="flex items-center gap-3 mb-3">
                        <span class="text-3xl">🎨</span>
                        <h3 class="text-2xl font-bold">PROJECT FILM PAMBALI | 2025</h3>
                    </div>
                    <p class="text-cyan-300 text-sm">Lightman</p>
                    <p class="text-gray-300 mt-2">Merancang dan mengeksekusi tata cahaya selama masa produksi untuk membangun suasana adegan, mendukung kualitas visual, dan memperkuat elemen sinematografi film.</p>
                </div>
                <div class="glass-panel p-7 glitch-text transition-all duration-300">
                    <div class="flex items-center gap-3 mb-3">
                        <span class="text-3xl">🏆</span>
                        <h3 class="text-2xl font-bold">HIMA MMB | 2025 - 2026</h3>
                    </div>
                    <p class="text-cyan-300 text-sm">Penanggung Jawab</p>
                    <p class="text-gray-300 mt-2">Memimpin perencanaan hingga eksekusi program sosial "HIMA MMB Berbagi 2026". Mengoordinasikan tim pelaksana untuk kegiatan donasi dan buka bersama guna memberikan dampak positif bagi masyarakat.</p>
                </div>
            </div>
        </section>
        
        <!-- Projects Section -->
        <section id="projects" class="mb-24 reveal">
            <h2 class="text-4xl md:text-5xl font-bold mb-10 text-center brand-font bg-gradient-to-r from-blue-400 to-pink-500 bg-clip-text text-transparent">Projects</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <!-- Dynamic Expand Card -->
                <div class="glass-panel expand-card p-6 transition-all hover:border-blue-400/50">
                    <div class="flex justify-between items-start">
                        <h3 class="text-2xl font-bold text-blue-300">Fotografi</h3>
                        <span class="text-xs bg-blue-500/30 px-3 py-1 rounded-full">Photography</span>
                    </div>
                    <p class="text-gray-400 mt-2">Eksplorasi visual fotografi yang menonjolkan estetika cahaya, keseimbangan komposisi, dan penyampaian emosi.</p>
                    <div class="expand-hidden mt-4">
                        <p class="text-gray-300 text-sm border-t border-white/10 pt-3">✨ Gaya: Dramatic Backlight, Simetri Refleksi, Negative Space. Menciptakan karya visual yang bersih, estetik, dan berkarakter unik.</p>
                    </div>
                </div>
                <!-- 3D Flip Card -->
                <div class="flip-card h-64 md:h-72">
                    <div class="flip-inner">
                        <div class="flip-front flex flex-col justify-center items-center text-center">
                            <span class="text-5xl mb-3">🔄</span>
                            <h3 class="text-2xl font-bold">AR ParentEase</h3>
                            <p class="text-gray-300 text-sm px-2 mt-2">Detail</p>
                        </div>
                        <div class="flip-back flex flex-col justify-center items-center text-center">
                            <h3 class="text-xl font-bold text-white">Unity AR</h3>
                            <p class="text-gray-200 text-sm mt-2">Prototipe aplikasi edukasi interaktif untuk mengenalkan berbagai jenis hewan kepada anak melalui metode bermain sambil belajar.</p>
                            <span class="text-xs bg-purple-500/40 mt-3 px-3 py-1 rounded-full">AR</span>
                        </div>
                    </div>
                </div>
                <!-- Dynamic Expand Card 2 -->
                <div class="glass-panel expand-card p-6 transition-all hover:border-green-400/50">
                    <div class="flex justify-between items-start">
                        <h3 class="text-2xl font-bold text-green-300">Graphic Design</h3>
                        <span class="text-xs bg-green-500/30 px-3 py-1 rounded-full">Design</span>
                    </div>
                    <p class="text-gray-400 mt-2">Pengembangan visual komprehensif yang mencakup pengeditan foto, video, dan desain logo yang menarik serta komunikatif.</p>
                    <div class="expand-hidden mt-4">
                        <p class="text-gray-300 text-sm border-t border-white/10 pt-3">✨ Keahlian: Retouching & Komposisi Foto, Penyusunan Footage & Color Grading Video, Desain Logo Minimalis untuk identitas brand yang kuat.</p>
                    </div>
                </div>
                <!-- Dynamic Expand Card 3 -->
                <div class="glass-panel expand-card p-6 transition-all hover:border-yellow-400/50">
                    <div class="flex justify-between items-start">
                        <h3 class="text-2xl font-bold text-yellow-300">Script Writer</h3>
                        <span class="text-xs bg-yellow-500/30 px-3 py-1 rounded-full">Action</span>
                    </div>
                    <p class="text-gray-400 mt-2">Naskah film pendek bergenre aksi yang mengisahkan perjuangan bertahan hidup dari ancaman sindikat judi online.</p>
                    <div class="expand-hidden mt-4">
                        <p class="text-gray-300 text-sm border-t border-white/10 pt-3">✨ Fokus: Pengembangan Konsep, Alur Cerita, Penokohan. Menghadirkan intrik ketegangan seputar perebutan file rahasia bernilai tinggi.</p>
                    </div>
                </div>
            </div>
        </section>
        
        <!-- Skills Section -->
        <section id="skills" class="mb-24 reveal">
            <h2 class="text-4xl md:text-5xl font-bold mb-10 text-center brand-font bg-gradient-to-r from-emerald-400 to-sky-400 bg-clip-text text-transparent">Skills & Tools</h2>
            <div class="glass-panel p-8 md:p-10">
                <div class="flex flex-wrap justify-center gap-4" id="magneticContainer">
                    <!-- Soft & Technical Skills -->
                    <span data-magnetic class="magnetic-item px-6 py-3 bg-white/5 rounded-full border border-white/20 text-lg font-medium backdrop-blur-sm">Editing</span>
                    <span data-magnetic class="magnetic-item px-6 py-3 bg-white/5 rounded-full border border-white/20 text-lg font-medium">Graphic Design</span>
                    <span data-magnetic class="magnetic-item px-6 py-3 bg-white/5 rounded-full border border-white/20 text-lg font-medium">Photography</span>
                    <span data-magnetic class="magnetic-item px-6 py-3 bg-white/5 rounded-full border border-white/20 text-lg font-medium">Videography</span>
                    <span data-magnetic class="magnetic-item px-6 py-3 bg-white/5 rounded-full border border-white/20 text-lg font-medium">Video Editing</span>
                    <span data-magnetic class="magnetic-item px-6 py-3 bg-white/5 rounded-full border border-white/20 text-lg font-medium">Multimedia Production</span>
                    
                    <!-- Soft Skills -->
                    <span data-magnetic class="magnetic-item px-6 py-3 bg-white/5 rounded-full border border-white/20 text-lg font-medium">Situation Awareness</span>
                    <span data-magnetic class="magnetic-item px-6 py-3 bg-white/5 rounded-full border border-white/20 text-lg font-medium">Attention to Detail</span>
                    <span data-magnetic class="magnetic-item px-6 py-3 bg-white/5 rounded-full border border-white/20 text-lg font-medium">Discipline & Responsibility</span>
                    <span data-magnetic class="magnetic-item px-6 py-3 bg-white/5 rounded-full border border-white/20 text-lg font-medium">Teamwork</span>
                    <span data-magnetic class="magnetic-item px-6 py-3 bg-white/5 rounded-full border border-white/20 text-lg font-medium">Time Management</span>
                    <span data-magnetic class="magnetic-item px-6 py-3 bg-white/5 rounded-full border border-white/20 text-lg font-medium">Problem Solving</span>
                </div>
                <p class="text-center text-gray-400 mt-8 text-sm">✨ Technical Skills & Soft Skills</p>
            </div>
        </section>
        
        <!-- Contact Section -->
        <section id="contact" class="reveal">
            <div class="glass-panel p-8 md:p-12 text-center">
                <h2 class="text-4xl font-bold brand-font mb-4">Mari Kolaborasi</h2>
                <p class="text-gray-300 max-w-lg mx-auto">Siap membantu mewujudkan ide digital Anda. Tersedia untuk project freelance & konsultasi.</p>
                <div class="flex flex-wrap justify-center gap-5 mt-8">
                    <a href="mailto:reky.saputra262@gmail.com" class="px-6 py-3 rounded-full bg-gradient-to-r from-blue-600 to-purple-600 hover:shadow-xl transition">Email Me</a>
                    <a href="https://github.com/rekysaputra" target="_blank" class="px-6 py-3 rounded-full border border-white/30 hover:bg-white/10 transition">GitHub</a>
                    <a href="https://www.instagram.com/rekydsaputra?igsh=MWIzdW5xeGM2Y3B0ag%3D%3D&utm_source=qr" class="px-6 py-3 rounded-full border border-white/30 hover:bg-white/10 transition">Instagram</a>
                </div>
                <p class="text-gray-500 text-sm mt-8">📍 Surabaya, Indonesia</p>
            </div>
        </section>
    </main>

    <footer class="text-center py-8 text-gray-500 text-sm border-t border-white/10 mt-10">
        © 2026 Reky Saputra | Creativity is the Future. All rights reserved.
    </footer>

    <!-- ========== JAVASCRIPT FULL ========== -->
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            // ======================== 1. INTERACTIVE PARTICLE BACKGROUND ========================
            const canvas = document.getElementById('particleCanvas');
            const ctx = canvas.getContext('2d');
            let particles = [];
            let mousePosition = { x: -1000, y: -1000 };
            const MOUSE_RADIUS = 120;
            const REPEL_STRENGTH = 1.2;
            const RETURN_STRENGTH = 0.035;
            
            function resizeCanvas() {
                canvas.width = window.innerWidth;
                canvas.height = window.innerHeight;
                initParticles();
            }
            
            function initParticles() {
                const area = canvas.width * canvas.height;
                let particleCount = Math.min(200, Math.floor(area / 7000));
                particleCount = Math.max(80, particleCount);
                particles = [];
                for(let i = 0; i < particleCount; i++) {
                    particles.push({
                        x: Math.random() * canvas.width,
                        y: Math.random() * canvas.height,
                        vx: (Math.random() - 0.5) * 0.2,
                        vy: (Math.random() - 0.5) * 0.2,
                        radius: Math.random() * 2.5 + 1,
                        alpha: Math.random() * 0.5 + 0.3,
                        originalX: null,
                        originalY: null
                    });
                }
                particles.forEach(p => {
                    p.originalX = p.x;
                    p.originalY = p.y;
                });
            }
            
            function updateParticles() {
                particles.forEach(p => {
                    const dx = p.x - mousePosition.x;
                    const dy = p.y - mousePosition.y;
                    const distance = Math.sqrt(dx * dx + dy * dy);
                    
                    if (distance < MOUSE_RADIUS) {
                        const angle = Math.atan2(dy, dx);
                        const force = (MOUSE_RADIUS - distance) / MOUSE_RADIUS;
                        const moveX = Math.cos(angle) * force * REPEL_STRENGTH;
                        const moveY = Math.sin(angle) * force * REPEL_STRENGTH;
                        p.x += moveX;
                        p.y += moveY;
                    }
                    
                    if (p.originalX !== null && p.originalY !== null) {
                        p.x += (p.originalX - p.x) * RETURN_STRENGTH;
                        p.y += (p.originalY - p.y) * RETURN_STRENGTH;
                    }
                    
                    p.x += p.vx;
                    p.y += p.vy;
                    
                    if (p.x < p.radius) { p.x = p.radius; p.vx *= -0.5; }
                    if (p.x > canvas.width - p.radius) { p.x = canvas.width - p.radius; p.vx *= -0.5; }
                    if (p.y < p.radius) { p.y = p.radius; p.vy *= -0.5; }
                    if (p.y > canvas.height - p.radius) { p.y = canvas.height - p.radius; p.vy *= -0.5; }
                });
            }
            
            function drawParticles() {
                if (!ctx) return;
                ctx.clearRect(0, 0, canvas.width, canvas.height);
                
                for(let i = 0; i < particles.length; i++) {
                    for(let j = i + 1; j < particles.length; j++) {
                        const dx = particles[i].x - particles[j].x;
                        const dy = particles[i].y - particles[j].y;
                        const distance = Math.sqrt(dx * dx + dy * dy);
                        if(distance < 100) {
                            ctx.beginPath();
                            ctx.moveTo(particles[i].x, particles[i].y);
                            ctx.lineTo(particles[j].x, particles[j].y);
                            const opacity = (1 - distance / 100) * 0.12;
                            ctx.strokeStyle = `rgba(100, 180, 255, ${opacity})`;
                            ctx.lineWidth = 0.8;
                            ctx.stroke();
                        }
                    }
                }
                
                particles.forEach(p => {
                    const dx = p.x - mousePosition.x;
                    const dy = p.y - mousePosition.y;
                    const distToMouse = Math.sqrt(dx * dx + dy * dy);
                    let r = 80, g = 150, b = 255;
                    if(distToMouse < MOUSE_RADIUS) {
                        const intensity = 1 - (distToMouse / MOUSE_RADIUS);
                        r = 255;
                        g = 80 + Math.floor(70 * intensity);
                        b = 120 + Math.floor(135 * (1 - intensity));
                    }
                    ctx.beginPath();
                    ctx.arc(p.x, p.y, p.radius, 0, Math.PI * 2);
                    ctx.fillStyle = `rgba(${r}, ${g}, ${b}, ${p.alpha})`;
                    ctx.fill();
                });
            }
            
            function animateParticles() {
                updateParticles();
                drawParticles();
                requestAnimationFrame(animateParticles);
            }
            
            window.addEventListener('mousemove', (e) => {
                mousePosition.x = e.clientX;
                mousePosition.y = e.clientY;
            });
            
            window.addEventListener('mouseleave', () => {
                mousePosition.x = -1000;
                mousePosition.y = -1000;
            });
            
            window.addEventListener('resize', resizeCanvas);
            resizeCanvas();
            animateParticles();
            
            // ======================== 2. MAGNETIC LIQUID GLOW ========================
            const liquid = document.getElementById('liquidGlow');
            let mouseX = 0, mouseY = 0;
            let liquidX = 0, liquidY = 0;
            
            document.addEventListener('mousemove', (e) => {
                mouseX = e.clientX;
                mouseY = e.clientY;
            });
            
            function animateLiquid() {
                liquidX += (mouseX - liquidX) * 0.08;
                liquidY += (mouseY - liquidY) * 0.08;
                liquid.style.transform = `translate(${liquidX - 250}px, ${liquidY - 250}px)`;
                requestAnimationFrame(animateLiquid);
            }
            animateLiquid();
            
            // ======================== 3. 3D TILT EFFECT ========================
            const tiltElements = document.querySelectorAll('.glass-panel');
            tiltElements.forEach(el => {
                el.addEventListener('mousemove', (e) => {
                    const rect = el.getBoundingClientRect();
                    const x = e.clientX - rect.left;
                    const y = e.clientY - rect.top;
                    const rotateX = ((y / rect.height) - 0.5) * -12;
                    const rotateY = ((x / rect.width) - 0.5) * 12;
                    el.style.transform = `perspective(1000px) rotateX(${rotateX}deg) rotateY(${rotateY}deg) scale(1.01)`;
                    el.style.setProperty('--mouse-x', x + 'px');
                    el.style.setProperty('--mouse-y', y + 'px');
                });
                el.addEventListener('mouseleave', () => {
                    el.style.transform = `perspective(1000px) rotateX(0deg) rotateY(0deg) scale(1)`;
                });
            });
            
            // ======================== 4. MAGNETIC PULL (SKILLS) ========================
            const magneticItems = document.querySelectorAll('[data-magnetic]');
            magneticItems.forEach(item => {
                item.addEventListener('mousemove', (e) => {
                    const rect = item.getBoundingClientRect();
                    const mouseXRel = e.clientX - rect.left - rect.width / 2;
                    const mouseYRel = e.clientY - rect.top - rect.height / 2;
                    const pullX = mouseXRel * 0.2;
                    const pullY = mouseYRel * 0.2;
                    item.style.transform = `translate(${pullX}px, ${pullY}px) scale(1.1)`;
                });
                item.addEventListener('mouseleave', () => {
                    item.style.transform = `translate(0px, 0px) scale(1)`;
                });
            });

            // ======================== 5. SCROLL REVEAL ANIMATION ========================
            function reveal() {
                var reveals = document.querySelectorAll(".reveal");
                for (var i = 0; i < reveals.length; i++) {
                    var windowHeight = window.innerHeight;
                    var elementTop = reveals[i].getBoundingClientRect().top;
                    var elementVisible = 100;
                    if (elementTop < windowHeight - elementVisible) {
                        reveals[i].classList.add("active");
                    }
                }
            }
            window.addEventListener("scroll", reveal);
            reveal(); // Trigger saat halaman pertama kali diload

            // ======================== 6. TYPEWRITER EFFECT ========================
            const words = ["Multimedia Enthusiast.", "Graphic Design.", "Creative Thinker."];
            let i = 0;
            let timer;

            function typingEffect() {
                let word = words[i].split("");
                var loopTyping = function() {
                    if (word.length > 0) {
                        document.getElementById('typewriter').innerHTML += word.shift();
                    } else {
                        setTimeout(deletingEffect, 2000);
                        return false;
                    };
                    timer = setTimeout(loopTyping, 100);
                };
                loopTyping();
            }

            function deletingEffect() {
                let word = words[i].split("");
                var loopDeleting = function() {
                    if (word.length > 0) {
                        word.pop();
                        document.getElementById('typewriter').innerHTML = word.join("");
                    } else {
                        if (words.length > (i + 1)) {
                            i++;
                        } else {
                            i = 0;
                        };
                        typingEffect();
                        return false;
                    };
                    timer = setTimeout(loopDeleting, 50);
                };
                loopDeleting();
            }
            typingEffect();
        });
    </script>
</body>
</html>