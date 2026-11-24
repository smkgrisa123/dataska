<!DOCTYPE html>
<html lang="id" x-data="{ darkMode: localStorage.getItem('darkMode') === 'true', sidebarOpen: true }" :class="{ 'dark': darkMode }">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= isset($title) ? $title : 'Dashboard' ?></title>
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            darkMode: 'class',
        }
    </script>
    <!-- FontAwesome untuk Icon -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Alpine.js untuk Interaksi -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>

<body class="bg-gray-100 dark:bg-gray-900 text-gray-800 dark:text-gray-100 font-sans transition-colors duration-300">
    <div class="flex h-screen overflow-hidden">

        <!-- Panggil Sidebar di sini -->
        <?php $this->load->view('template/sidebar'); ?>

        <!-- Main Content Area Wrapper -->
        <div class="flex-1 flex flex-col overflow-hidden">

            <!-- Top Navbar -->
            <header class="h-16 bg-white dark:bg-gray-800 border-b border-gray-200 dark:border-gray-700 flex items-center justify-between px-6 transition-colors duration-300 shrink-0">
                <!-- Info Satuan Pendidikan / Selamat Pagi -->
                <div class="flex items-center space-x-3">
                    <span class="text-xl">☀️</span>
                    <div>
                        <p class="text-xs text-gray-500 dark:text-gray-400"
                            x-data="{
                   salam: '',
                   init() {
                       const jam = new Date().getHours();
                       if (jam >= 4 && jam < 11) this.salam = 'Selamat pagi';
                       else if (jam >= 11 && jam < 15) this.salam = 'Selamat siang';
                       else if (jam >= 15 && jam < 18) this.salam = 'Selamat sore';
                       else this.salam = 'Selamat malam';
                   }
                }">
                            <span x-text="salam">Selamat pagi</span>,
                            <span class="font-bold text-gray-800 dark:text-gray-200 uppercase">
                                <?= htmlspecialchars($this->session->userdata('nama') ?? 'PENGGUNA'); ?>
                            </span>
                        </p>
                        <p class="text-[11px] text-gray-400 dark:text-gray-500">WALI KELAS SMK GRISA</p>
                    </div>
                </div>

                <!-- Right Nav: Location, Dark Mode Toggle, Profile Dropdown -->
                <div class="flex items-center space-x-4">
                    <!-- Wilayah Badge -->
                    <div class="hidden md:flex items-center text-xs bg-gray-100 dark:bg-gray-700 px-3 py-1.5 rounded-full text-gray-600 dark:text-gray-300"
                        x-data="{
         lokasi: 'MEMUAT LOKASI...',
         init() {
             if (navigator.geolocation) {
                 navigator.geolocation.getCurrentPosition(
                     position => {
                         const lat = position.coords.latitude;
                         const lon = position.coords.longitude;
                         
                         fetch(`https://nominatim.openstreetmap.org/reverse?format=json&lat=${lat}&lon=${lon}&zoom=14&addressdetails=1`)
                             .then(res => res.json())
                             .then(data => {
                                 if (data && data.address) {
                                     const addr = data.address;
                                     const desa = addr.village || addr.suburb || addr.hamlet || addr.neighborhood || '';
                                     const kecamatan = addr.town || addr.city_district || addr.subdistrict || '';
                                     const kabupaten = addr.city || addr.county || addr.municipality || 'BANYUWANGI';
                                     const provinsi = addr.state || 'JAWA TIMUR';
                                     
                                     let wilayahUtama = [];
                                     if (desa) wilayahUtama.push(desa.toUpperCase());
                                     if (kecamatan) wilayahUtama.push(kecamatan.toUpperCase());
                                     
                                     let textUtama = wilayahUtama.length > 0 ? wilayahUtama.join(', ') : provinsi.toUpperCase();
                                     let textKab = kabupaten.replace(/Kabupaten|Kota/gi, '').trim().toUpperCase();
                                     
                                     this.lokasi = `${textUtama} <span class='text-gray-400'>| KAB. ${textKab}</span>`;
                                 } else {
                                     this.lokasi = 'JAWA TIMUR <span class=\'text-gray-400\'>| KAB. BANYUWANGI</span>';
                                 }
                             })
                             .catch(() => {
                                 this.lokasi = 'JAWA TIMUR <span class=\'text-gray-400\'>| KAB. BANYUWANGI</span>';
                             });
                     },
                     () => {
                         // Fallback default jika GPS tidak diizinkan
                         this.lokasi = 'JAWA TIMUR <span class=\'text-gray-400\'>| KAB. BANYUWANGI</span>';
                     },
                     { timeout: 10000 }
                 );
             } else {
                 this.lokasi = 'JAWA TIMUR <span class=\'text-gray-400\'>| KAB. BANYUWANGI</span>';
             }
         }
     }">
                        <i class="fa-solid fa-location-dot text-red-500 mr-1.5"></i>
                        <span x-html="lokasi">JAWA TIMUR <span class="text-gray-400">| KAB. BANYUWANGI</span></span>
                    </div>

                    <!-- Dark Mode Toggle Button -->
                    <button onclick="toggleDarkMode()" class="p-2 rounded-lg text-gray-600 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 focus:outline-none transition-colors">
                        <i class="fa-solid fa-sun hidden dark:block text-yellow-400"></i>
                        <i class="fa-solid fa-moon block dark:hidden text-gray-600"></i>
                    </button>

                    <!-- User Profile Dropdown with Alpine.js -->
                    <div class="relative" x-data="{ profileOpen: false }">
                        <?php
                        $nama_user = $this->session->userdata('nama') ?? 'Pengguna';
                        // Membuat inisial otomatis dari 2 kata pertama
                        $words = explode(' ', trim($nama_user));
                        $inisial = strtoupper(substr($words[0], 0, 1) . (isset($words[1]) ? substr($words[1], 0, 1) : ''));
                        ?>

                        <button @click="profileOpen = !profileOpen" @click.away="profileOpen = false" class="flex items-center space-x-2 bg-blue-600 hover:bg-blue-700 text-white pl-2 pr-4 py-1.5 rounded-full text-xs font-medium focus:outline-none transition-colors cursor-pointer">
                            <span class="bg-blue-800 w-6 h-6 flex items-center justify-center rounded-full font-bold"><?= htmlspecialchars($inisial); ?></span>
                            <span><?= htmlspecialchars($nama_user); ?></span>
                            <i class="fa-solid fa-chevron-down text-[10px] ml-1 transition-transform" :class="{ 'rotate-180': profileOpen }"></i>
                        </button>

                        <!-- Box Dropdown Menu -->
                        <div x-show="profileOpen"
                            x-transition:enter="transition ease-out duration-100"
                            x-transition:enter-start="transform opacity-0 scale-95"
                            x-transition:enter-end="transform opacity-100 scale-100"
                            x-transition:leave="transition ease-in duration-75"
                            x-transition:leave-start="transform opacity-100 scale-100"
                            x-transition:leave-end="transform opacity-0 scale-95"
                            class="absolute right-0 mt-2 w-64 bg-white dark:bg-gray-800 rounded-2xl shadow-xl border border-gray-200 dark:border-gray-700 py-3 px-3 z-50 text-gray-800 dark:text-gray-100">

                            <div class="flex items-center space-x-3 px-3 py-2 border-b border-gray-100 dark:border-gray-700">
                                <div class="bg-blue-600 text-white w-8 h-8 flex items-center justify-center rounded-full font-bold text-xs shrink-0">GRISA</div>
                                <div class="overflow-hidden">
                                    <p class="font-bold text-xs truncate">SMKS PGRI PESANGGARAN</p>
                                    <p class="text-[10px] text-gray-400 truncate">Satuan Pendidikan SMK</p>
                                </div>
                            </div>

                            <a href="#" class="flex items-center px-3 py-2.5 mt-2 text-xs font-medium rounded-xl hover:bg-gray-100 dark:hover:bg-gray-700/60 transition-colors">
                                <span class="w-7 h-7 bg-blue-50 dark:bg-blue-900/40 text-blue-600 dark:text-blue-400 rounded-lg flex items-center justify-center mr-2.5">
                                    <i class="fa-regular fa-user text-xs"></i>
                                </span>
                                <div>
                                    <p class="font-semibold leading-tight">Profile</p>
                                    <p class="text-[10px] text-gray-400">Kelola akun saya</p>
                                </div>
                            </a>

                            <a href="<?= site_url('auth/logout'); ?>" class="flex items-center px-3 py-2.5 text-xs font-medium rounded-xl hover:bg-red-50 dark:hover:bg-red-900/20 text-red-600 dark:text-red-400 transition-colors">
                                <span class="w-7 h-7 bg-red-50 dark:bg-red-900/40 text-red-600 dark:text-red-400 rounded-lg flex items-center justify-center mr-2.5">
                                    <i class="fa-solid fa-right-from-bracket text-xs"></i>
                                </span>
                                <div>
                                    <p class="font-semibold leading-tight">Logout</p>
                                    <p class="text-[10px] text-gray-400">Keluar dari sesi ini</p>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>
            </header>