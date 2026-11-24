<!-- Main Content Area -->
<div class="flex-1 flex flex-col overflow-hidden">
    <!-- Top Navbar -->
    <header class="h-16 bg-white dark:bg-gray-800 border-b border-gray-200 dark:border-gray-700 flex items-center justify-between px-6 transition-colors duration-300">
        <!-- Info Satuan Pendidikan / Selamat Pagi -->
        <div class="flex items-center space-x-3">
            <span class="text-xl">☀️</span>
            <div>
                <p class="text-xs text-gray-500 dark:text-gray-400">Selamat pagi, <span class="font-bold text-gray-800 dark:text-gray-200">DIDIK</span></p>
                <p class="text-[11px] text-gray-400 dark:text-gray-500">Satuan Pendidikan SMK</p>
            </div>
        </div>

        <!-- Right Nav: Location, Dark Mode Toggle, Profile -->
        <div class="flex items-center space-x-4">
            <!-- Wilayah Badge -->
            <div class="hidden md:flex items-center text-xs bg-gray-100 dark:bg-gray-700 px-3 py-1.5 rounded-full text-gray-600 dark:text-gray-300">
                <i class="fa-solid fa-location-dot text-red-500 mr-1.5"></i>
                <span>JAWA TIMUR <span class="text-gray-400">| KAB. BANYUWANGI</span></span>
            </div>

            <!-- Dark Mode Toggle Button -->
            <button onclick="toggleDarkMode()" class="p-2 rounded-lg text-gray-600 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 focus:outline-none transition-colors">
                <!-- Icon Sun (Light Mode) -->
                <i class="fa-solid fa-sun hidden dark:block text-yellow-400"></i>
                <!-- Icon Moon (Dark Mode) -->
                <i class="fa-solid fa-moon block dark:hidden text-gray-600"></i>
            </button>

            <!-- User Profile Dropdown / Badge -->
            <div class="flex items-center space-x-2 bg-blue-600 text-white pl-2 pr-4 py-1.5 rounded-full text-xs font-medium">
                <span class="bg-blue-800 w-6 h-6 flex items-center justify-center rounded-full font-bold">DA</span>
                <span>DIDIK ARIF CAHYONO</span>
            </div>
        </div>
    </header>

    <!-- Content Body (Tempat konten dashboard Anda nanti) -->
    <main class="flex-1 overflow-x-hidden overflow-y-auto bg-gray-50 dark:bg-gray-900 p-6">
        <!-- Contoh Kotak Konten / Placeholder Card -->
        <div class="max-w-4xl mx-auto bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-200 dark:border-gray-700 p-8 text-center transition-colors duration-300">
            <div class="flex justify-center mb-4">
                <div class="text-blue-600 text-5xl">
                    <i class="fa-solid fa-gears animate-spin-slow"></i>
                </div>
            </div>
            <h2 class="text-xl font-bold text-gray-800 dark:text-white mb-2">Dashboard Siap Digunakan</h2>
            <p class="text-sm text-gray-500 dark:text-gray-400 mb-6">Template layout bagian header, sidebar, dan footer berhasil dipisah. Silakan masukkan konten atau widget dashboard Anda di sini.</p>
            <a href="#" class="inline-flex items-center px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium rounded-xl transition-colors">
                <i class="fa-solid fa-rotate-right mr-2"></i> Muat Ulang
            </a>
        </div>
    </main>