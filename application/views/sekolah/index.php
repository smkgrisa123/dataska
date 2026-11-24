<?php
$sekolahAktif = !empty($sekolah) ? $sekolah[0] : null;

$sosmedAktif = [
    'instagram' => '',
    'facebook'  => '',
    'youtube'   => '',
    'tiktok'    => ''
];
if ($sekolahAktif && !empty($sekolahAktif->sosial_media)) {
    $dec = json_decode($sekolahAktif->sosial_media, true);
    if (is_array($dec)) {
        $sosmedAktif = array_merge($sosmedAktif, $dec);
    }
}

$rtRw = implode(' / ', array_filter([
    !empty($sekolahAktif->rt) ? 'RT ' . $sekolahAktif->rt : '',
    !empty($sekolahAktif->rw) ? 'RW ' . $sekolahAktif->rw : ''
]));

$tglPendirianFmt = ($sekolahAktif && !empty($sekolahAktif->tgl_sk_pendirian))
    ? date('d/m/Y', strtotime($sekolahAktif->tgl_sk_pendirian))
    : '-';

$tglIzinFmt = ($sekolahAktif && !empty($sekolahAktif->tgl_sk_izin_operasional))
    ? date('d/m/Y', strtotime($sekolahAktif->tgl_sk_izin_operasional))
    : '-';

$petaUrl = ($sekolahAktif && !empty($sekolahAktif->lintang) && !empty($sekolahAktif->bujur))
    ? 'https://www.google.com/maps?q=' . urlencode($sekolahAktif->lintang . ',' . $sekolahAktif->bujur)
    : '';
?>

<main class="flex-1 overflow-x-hidden overflow-y-auto bg-gray-100 dark:bg-gray-900 p-4 md:p-6" x-data="sekolahLembarProfilApp()">
    <div class="max-w-5xl mx-auto space-y-5">

        <!-- BAR NAVIGASI & AKSI DOKUMEN -->
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 text-xs">
            <div class="flex items-center space-x-2 text-[11px] text-gray-500 dark:text-gray-400 font-medium">
                <a href="<?= site_url('dashboard'); ?>" class="text-blue-600 dark:text-blue-400 hover:underline">Dashboard</a>
                <span>/</span>
                <span>Data Sekolah</span>
                <span>/</span>
                <span class="text-gray-800 dark:text-gray-200 font-semibold">Lembar Profil Sekolah</span>
            </div>

            <div class="flex flex-wrap items-center gap-2 shrink-0">
                <?php if (!empty($sekolah) && count($sekolah) > 1): ?>
                    <select @change="gantiSekolah($event.target.value)" class="h-9 px-3 rounded-xl border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800 text-gray-800 dark:text-white focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <?php foreach ($sekolah as $item): ?>
                            <option value="<?= $item->id; ?>" <?= ($sekolahAktif && $sekolahAktif->id == $item->id) ? 'selected' : ''; ?>>
                                <?= html_escape($item->nama_sekolah); ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                <?php endif; ?>

                <button type="button" @click="bukaModalTambah()" class="inline-flex items-center px-3.5 py-2 rounded-xl bg-white hover:bg-gray-50 dark:bg-gray-800 dark:hover:bg-gray-700 text-gray-700 dark:text-gray-200 font-semibold border border-gray-200 dark:border-gray-700 shadow-2xs transition cursor-pointer">
                    <i class="fa-solid fa-plus mr-1.5 text-blue-600"></i> Tambah Sekolah
                </button>

                <?php if ($sekolahAktif): ?>
                    <button type="button" @click="bukaModalEdit(<?= $sekolahAktif->id; ?>)" class="inline-flex items-center px-4 py-2 rounded-xl bg-blue-600 hover:bg-blue-700 text-white font-semibold shadow-xs transition cursor-pointer">
                        <i class="fa-solid fa-pen-to-square mr-1.5"></i> Ubah Profil
                    </button>
                    <button type="button" @click="konfirmasiHapus('<?= site_url('sekolah/hapus/' . $sekolahAktif->id); ?>')" class="inline-flex items-center px-3.5 py-2 rounded-xl bg-red-50 hover:bg-red-100 text-red-700 font-semibold border border-red-200/70 transition cursor-pointer">
                        <i class="fa-solid fa-trash-can mr-1.5"></i> Hapus
                    </button>
                <?php endif; ?>
            </div>
        </div>

        <!-- LEMBAR PROFIL RESMI SATUAN PENDIDIKAN -->
        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-200 dark:border-gray-700 overflow-hidden text-xs">
            <?php if ($sekolahAktif): ?>

                <!-- KOP / KEPALA LEMBAR PROFIL -->
                <div class="px-6 md:px-8 py-6 bg-slate-50/90 dark:bg-gray-800/90 border-b-2 border-slate-800 dark:border-slate-600 flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                    <div class="flex items-start gap-4">
                        <div class="w-12 h-12 rounded-xl bg-slate-900 text-white flex items-center justify-center text-xl shrink-0 shadow-xs">
                            <i class="fa-solid fa-school"></i>
                        </div>
                        <div>
                            <p class="text-[10px] font-bold uppercase tracking-widest text-blue-700 dark:text-blue-400">
                                Lembar Profil Satuan Pendidikan
                            </p>
                            <h1 class="text-lg md:text-xl font-extrabold text-gray-900 dark:text-white tracking-tight mt-0.5">
                                <?= html_escape($sekolahAktif->nama_sekolah); ?>
                            </h1>
                            <div class="flex flex-wrap items-center gap-x-4 gap-y-1 text-[11px] text-gray-600 dark:text-gray-300 mt-1.5">
                                <span><strong>NPSN:</strong> <span class="font-mono"><?= html_escape($sekolahAktif->npsn ?: '-'); ?></span></span>
                                <span>•</span>
                                <span><strong>Bentuk Pendidikan:</strong> <?= html_escape($sekolahAktif->bentuk_pendidikan ?: '-'); ?></span>
                                <span>•</span>
                                <span><strong>Status Kepemilikan:</strong> <?= html_escape($sekolahAktif->status_kepemilikan ?: '-'); ?></span>
                            </div>
                        </div>
                    </div>

                    <div class="text-left md:text-right text-[11px] text-gray-500 dark:text-gray-400 shrink-0">
                        <div>Dokumen Data Pokok Sekolah</div>
                        <div class="font-semibold text-gray-700 dark:text-gray-300 mt-0.5">
                            <?= html_escape(implode(', ', array_filter([$sekolahAktif->kecamatan ?? '', $sekolahAktif->kabupaten ?? ''])) ?: '-'); ?>
                        </div>
                    </div>
                </div>

                <!-- ISI LEMBAR PROFIL -->
                <div class="p-6 md:p-8 space-y-8">

                    <!-- 1. IDENTITAS SEKOLAH -->
                    <section>
                        <h2 class="text-xs font-bold uppercase tracking-wider text-slate-800 dark:text-gray-100 pb-2 mb-4 border-b border-gray-200 dark:border-gray-700 flex items-center gap-2">
                            <span class="w-5 h-5 rounded-md bg-blue-50 dark:bg-blue-900/30 text-blue-700 dark:text-blue-300 inline-flex items-center justify-center text-[11px]">1</span>
                            <span>Identitas Sekolah</span>
                        </h2>
                        <dl class="grid grid-cols-1 md:grid-cols-2 gap-x-10 gap-y-2.5">
                            <div class="grid grid-cols-1 sm:grid-cols-[175px_1fr] gap-y-0.5 sm:gap-x-3 items-baseline md:col-span-2">
                                <dt class="text-gray-500 dark:text-gray-400 font-medium">Nama Sekolah</dt>
                                <dd class="font-bold text-gray-900 dark:text-white"><?= html_escape($sekolahAktif->nama_sekolah); ?></dd>
                            </div>
                            <div class="grid grid-cols-1 sm:grid-cols-[175px_1fr] gap-y-0.5 sm:gap-x-3 items-baseline">
                                <dt class="text-gray-500 dark:text-gray-400 font-medium">NPSN</dt>
                                <dd class="font-mono font-semibold text-gray-800 dark:text-gray-200"><?= html_escape($sekolahAktif->npsn ?: '-'); ?></dd>
                            </div>
                            <div class="grid grid-cols-1 sm:grid-cols-[175px_1fr] gap-y-0.5 sm:gap-x-3 items-baseline">
                                <dt class="text-gray-500 dark:text-gray-400 font-medium">Bentuk Pendidikan</dt>
                                <dd class="font-semibold text-gray-800 dark:text-gray-200"><?= html_escape($sekolahAktif->bentuk_pendidikan ?: '-'); ?></dd>
                            </div>
                        </dl>
                    </section>

                    <!-- 2. ALAMAT & KOORDINAT -->
                    <section>
                        <h2 class="text-xs font-bold uppercase tracking-wider text-slate-800 dark:text-gray-100 pb-2 mb-4 border-b border-gray-200 dark:border-gray-700 flex items-center gap-2">
                            <span class="w-5 h-5 rounded-md bg-blue-50 dark:bg-blue-900/30 text-blue-700 dark:text-blue-300 inline-flex items-center justify-center text-[11px]">2</span>
                            <span>Alamat & Koordinat</span>
                        </h2>
                        <dl class="grid grid-cols-1 md:grid-cols-2 gap-x-10 gap-y-2.5">
                            <div class="grid grid-cols-1 sm:grid-cols-[175px_1fr] gap-y-0.5 sm:gap-x-3 items-baseline md:col-span-2">
                                <dt class="text-gray-500 dark:text-gray-400 font-medium">Alamat</dt>
                                <dd class="text-gray-800 dark:text-gray-200"><?= html_escape($sekolahAktif->alamat ?: '-'); ?></dd>
                            </div>
                            <div class="grid grid-cols-1 sm:grid-cols-[175px_1fr] gap-y-0.5 sm:gap-x-3 items-baseline">
                                <dt class="text-gray-500 dark:text-gray-400 font-medium">Dusun</dt>
                                <dd class="text-gray-800 dark:text-gray-200"><?= html_escape($sekolahAktif->dusun ?: '-'); ?></dd>
                            </div>
                            <div class="grid grid-cols-1 sm:grid-cols-[175px_1fr] gap-y-0.5 sm:gap-x-3 items-baseline">
                                <dt class="text-gray-500 dark:text-gray-400 font-medium">RT / RW</dt>
                                <dd class="text-gray-800 dark:text-gray-200"><?= html_escape($rtRw ?: '-'); ?></dd>
                            </div>
                            <div class="grid grid-cols-1 sm:grid-cols-[175px_1fr] gap-y-0.5 sm:gap-x-3 items-baseline">
                                <dt class="text-gray-500 dark:text-gray-400 font-medium">Desa / Kelurahan</dt>
                                <dd class="text-gray-800 dark:text-gray-200"><?= html_escape($sekolahAktif->desa ?: '-'); ?></dd>
                            </div>
                            <div class="grid grid-cols-1 sm:grid-cols-[175px_1fr] gap-y-0.5 sm:gap-x-3 items-baseline">
                                <dt class="text-gray-500 dark:text-gray-400 font-medium">Kecamatan</dt>
                                <dd class="text-gray-800 dark:text-gray-200"><?= html_escape($sekolahAktif->kecamatan ?: '-'); ?></dd>
                            </div>
                            <div class="grid grid-cols-1 sm:grid-cols-[175px_1fr] gap-y-0.5 sm:gap-x-3 items-baseline">
                                <dt class="text-gray-500 dark:text-gray-400 font-medium">Kabupaten / Kota</dt>
                                <dd class="text-gray-800 dark:text-gray-200"><?= html_escape($sekolahAktif->kabupaten ?: '-'); ?></dd>
                            </div>
                            <div class="grid grid-cols-1 sm:grid-cols-[175px_1fr] gap-y-0.5 sm:gap-x-3 items-baseline">
                                <dt class="text-gray-500 dark:text-gray-400 font-medium">Provinsi</dt>
                                <dd class="text-gray-800 dark:text-gray-200"><?= html_escape($sekolahAktif->provinsi ?: '-'); ?></dd>
                            </div>
                            <div class="grid grid-cols-1 sm:grid-cols-[175px_1fr] gap-y-0.5 sm:gap-x-3 items-baseline">
                                <dt class="text-gray-500 dark:text-gray-400 font-medium">Lintang</dt>
                                <dd class="font-mono text-gray-800 dark:text-gray-200"><?= html_escape($sekolahAktif->lintang ?: '-'); ?></dd>
                            </div>
                            <div class="grid grid-cols-1 sm:grid-cols-[175px_1fr] gap-y-0.5 sm:gap-x-3 items-baseline">
                                <dt class="text-gray-500 dark:text-gray-400 font-medium">Bujur</dt>
                                <dd class="font-mono text-gray-800 dark:text-gray-200"><?= html_escape($sekolahAktif->bujur ?: '-'); ?></dd>
                            </div>

                            <?php if (!empty($petaUrl)): ?>
                                <div class="grid grid-cols-1 sm:grid-cols-[175px_1fr] gap-y-0.5 sm:gap-x-3 items-baseline md:col-span-2 pt-1">
                                    <dt class="text-gray-500 dark:text-gray-400 font-medium">Titik Lokasi</dt>
                                    <dd>
                                        <a href="<?= html_escape($petaUrl); ?>" target="_blank" rel="noopener noreferrer"
                                            class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg bg-slate-700 hover:bg-slate-800 text-white text-[11px] font-medium transition">
                                            <i class="fa-solid fa-location-dot"></i> Lihat pada peta
                                        </a>
                                    </dd>
                                </div>
                            <?php endif; ?>
                        </dl>
                    </section>

                    <!-- 3. DATA PELENGKAP -->
                    <section>
                        <h2 class="text-xs font-bold uppercase tracking-wider text-slate-800 dark:text-gray-100 pb-2 mb-4 border-b border-gray-200 dark:border-gray-700 flex items-center gap-2">
                            <span class="w-5 h-5 rounded-md bg-blue-50 dark:bg-blue-900/30 text-blue-700 dark:text-blue-300 inline-flex items-center justify-center text-[11px]">3</span>
                            <span>Data Pelengkap</span>
                        </h2>
                        <dl class="grid grid-cols-1 md:grid-cols-2 gap-x-10 gap-y-2.5">
                            <div class="grid grid-cols-1 sm:grid-cols-[175px_1fr] gap-y-0.5 sm:gap-x-3 items-baseline">
                                <dt class="text-gray-500 dark:text-gray-400 font-medium">Kebutuhan Khusus</dt>
                                <dd class="text-gray-800 dark:text-gray-200"><?= html_escape($sekolahAktif->nama_kebutuhan_khusus ?: 'Tidak Ada / Umum'); ?></dd>
                            </div>
                            <div class="grid grid-cols-1 sm:grid-cols-[175px_1fr] gap-y-0.5 sm:gap-x-3 items-baseline">
                                <dt class="text-gray-500 dark:text-gray-400 font-medium">Status Kepemilikan</dt>
                                <dd class="text-gray-800 dark:text-gray-200"><?= html_escape($sekolahAktif->status_kepemilikan ?: '-'); ?></dd>
                            </div>
                            <div class="grid grid-cols-1 sm:grid-cols-[175px_1fr] gap-y-0.5 sm:gap-x-3 items-baseline md:col-span-2">
                                <dt class="text-gray-500 dark:text-gray-400 font-medium">Yayasan</dt>
                                <dd class="text-gray-800 dark:text-gray-200"><?= html_escape($sekolahAktif->yayasan ?: '-'); ?></dd>
                            </div>
                            <div class="grid grid-cols-1 sm:grid-cols-[175px_1fr] gap-y-0.5 sm:gap-x-3 items-baseline">
                                <dt class="text-gray-500 dark:text-gray-400 font-medium">SK Pendirian Sekolah</dt>
                                <dd class="text-gray-800 dark:text-gray-200"><?= html_escape($sekolahAktif->sk_pendirian ?: '-'); ?></dd>
                            </div>
                            <div class="grid grid-cols-1 sm:grid-cols-[175px_1fr] gap-y-0.5 sm:gap-x-3 items-baseline">
                                <dt class="text-gray-500 dark:text-gray-400 font-medium">Tanggal SK Pendirian</dt>
                                <dd class="text-gray-800 dark:text-gray-200"><?= html_escape($tglPendirianFmt); ?></dd>
                            </div>
                            <div class="grid grid-cols-1 sm:grid-cols-[175px_1fr] gap-y-0.5 sm:gap-x-3 items-baseline">
                                <dt class="text-gray-500 dark:text-gray-400 font-medium">SK Izin Operasional</dt>
                                <dd class="text-gray-800 dark:text-gray-200"><?= html_escape($sekolahAktif->sk_izin_operasional ?: '-'); ?></dd>
                            </div>
                            <div class="grid grid-cols-1 sm:grid-cols-[175px_1fr] gap-y-0.5 sm:gap-x-3 items-baseline">
                                <dt class="text-gray-500 dark:text-gray-400 font-medium">Tanggal SK Izin Ops</dt>
                                <dd class="text-gray-800 dark:text-gray-200"><?= html_escape($tglIzinFmt); ?></dd>
                            </div>
                        </dl>
                    </section>

                    <!-- 4. KONTAK & SOSIAL MEDIA -->
                    <section>
                        <h2 class="text-xs font-bold uppercase tracking-wider text-slate-800 dark:text-gray-100 pb-2 mb-4 border-b border-gray-200 dark:border-gray-700 flex items-center gap-2">
                            <span class="w-5 h-5 rounded-md bg-blue-50 dark:bg-blue-900/30 text-blue-700 dark:text-blue-300 inline-flex items-center justify-center text-[11px]">4</span>
                            <span>Kontak & Sosial Media</span>
                        </h2>
                        <dl class="grid grid-cols-1 md:grid-cols-2 gap-x-10 gap-y-2.5">
                            <div class="grid grid-cols-1 sm:grid-cols-[175px_1fr] gap-y-0.5 sm:gap-x-3 items-baseline">
                                <dt class="text-gray-500 dark:text-gray-400 font-medium">No. Telepon</dt>
                                <dd class="text-gray-800 dark:text-gray-200"><?= html_escape($sekolahAktif->no_telepon ?: '-'); ?></dd>
                            </div>
                            <div class="grid grid-cols-1 sm:grid-cols-[175px_1fr] gap-y-0.5 sm:gap-x-3 items-baseline">
                                <dt class="text-gray-500 dark:text-gray-400 font-medium">No. HP / WhatsApp</dt>
                                <dd class="text-gray-800 dark:text-gray-200"><?= html_escape($sekolahAktif->no_hp ?: '-'); ?></dd>
                            </div>
                            <div class="grid grid-cols-1 sm:grid-cols-[175px_1fr] gap-y-0.5 sm:gap-x-3 items-baseline">
                                <dt class="text-gray-500 dark:text-gray-400 font-medium">Email</dt>
                                <dd class="text-gray-800 dark:text-gray-200 break-all"><?= html_escape($sekolahAktif->email ?: '-'); ?></dd>
                            </div>
                            <div class="grid grid-cols-1 sm:grid-cols-[175px_1fr] gap-y-0.5 sm:gap-x-3 items-baseline">
                                <dt class="text-gray-500 dark:text-gray-400 font-medium">Website</dt>
                                <dd class="text-gray-800 dark:text-gray-200 break-all">
                                    <?php if (!empty($sekolahAktif->website)): ?>
                                        <a href="<?= html_escape($sekolahAktif->website); ?>" target="_blank" rel="noopener noreferrer" class="text-blue-600 hover:underline">
                                            <?= html_escape($sekolahAktif->website); ?>
                                        </a>
                                    <?php else: ?>
                                        -
                                    <?php endif; ?>
                                </dd>
                            </div>
                            <div class="grid grid-cols-1 sm:grid-cols-[175px_1fr] gap-y-0.5 sm:gap-x-3 items-baseline">
                                <dt class="text-gray-500 dark:text-gray-400 font-medium">Instagram</dt>
                                <dd class="text-gray-800 dark:text-gray-200">
                                    <i class="fa-brands fa-instagram text-pink-600 mr-1.5"></i><?= html_escape($sosmedAktif['instagram'] ?: '-'); ?>
                                </dd>
                            </div>
                            <div class="grid grid-cols-1 sm:grid-cols-[175px_1fr] gap-y-0.5 sm:gap-x-3 items-baseline">
                                <dt class="text-gray-500 dark:text-gray-400 font-medium">Facebook</dt>
                                <dd class="text-gray-800 dark:text-gray-200">
                                    <i class="fa-brands fa-facebook text-blue-600 mr-1.5"></i><?= html_escape($sosmedAktif['facebook'] ?: '-'); ?>
                                </dd>
                            </div>
                            <div class="grid grid-cols-1 sm:grid-cols-[175px_1fr] gap-y-0.5 sm:gap-x-3 items-baseline">
                                <dt class="text-gray-500 dark:text-gray-400 font-medium">YouTube</dt>
                                <dd class="text-gray-800 dark:text-gray-200">
                                    <i class="fa-brands fa-youtube text-red-600 mr-1.5"></i><?= html_escape($sosmedAktif['youtube'] ?: '-'); ?>
                                </dd>
                            </div>
                            <div class="grid grid-cols-1 sm:grid-cols-[175px_1fr] gap-y-0.5 sm:gap-x-3 items-baseline">
                                <dt class="text-gray-500 dark:text-gray-400 font-medium">TikTok</dt>
                                <dd class="text-gray-800 dark:text-gray-200">
                                    <i class="fa-brands fa-tiktok mr-1.5"></i><?= html_escape($sosmedAktif['tiktok'] ?: '-'); ?>
                                </dd>
                            </div>
                        </dl>
                    </section>

                </div>

                <!-- KAKI LEMBAR PROFIL -->
                <div class="px-6 md:px-8 py-3.5 bg-gray-50 dark:bg-gray-800/70 border-t border-gray-200 dark:border-gray-700 flex flex-wrap items-center justify-between gap-2 text-[11px] text-gray-500 dark:text-gray-400">
                    <span>
                        Terakhir diperbarui:
                        <strong class="text-gray-700 dark:text-gray-200">
                            <?= !empty($sekolahAktif->updated_at) ? html_escape(date('d/m/Y H:i', strtotime($sekolahAktif->updated_at))) : '-'; ?>
                        </strong>
                    </span>
                    <button type="button" @click="bukaModalEdit(<?= $sekolahAktif->id; ?>)" class="inline-flex items-center gap-1.5 px-3.5 py-1.5 rounded-lg bg-blue-600 hover:bg-blue-700 text-white font-semibold text-xs transition cursor-pointer">
                        <i class="fa-solid fa-pen-to-square"></i> Ubah Profil Sekolah
                    </button>
                </div>

            <?php else: ?>
                <div class="p-10 text-center space-y-3">
                    <p class="text-gray-500 dark:text-gray-400">Belum ada data sekolah yang tersimpan.</p>
                    <button type="button" @click="bukaModalTambah()" class="inline-flex items-center px-4 py-2 rounded-xl bg-blue-600 hover:bg-blue-700 text-white text-xs font-semibold cursor-pointer">
                        <i class="fa-solid fa-plus mr-1.5"></i> Tambah Data Sekolah
                    </button>
                </div>
            <?php endif; ?>
        </div>

    </div>

    <!-- MODAL FORM TAMBAH / UBAH PROFIL SEKOLAH -->
    <div x-show="isModalOpen" x-cloak class="fixed inset-0 z-50 flex items-center justify-center bg-black/50 backdrop-blur-xs p-4 overflow-y-auto">
        <div @click.away="isModalOpen = false" class="bg-white dark:bg-gray-800 rounded-2xl shadow-xl max-w-4xl w-full p-6 border border-gray-100 dark:border-gray-700 my-auto max-h-[90vh] overflow-y-auto">
            <div class="flex justify-between items-center mb-4 border-b border-gray-100 dark:border-gray-700 pb-3 sticky top-0 bg-white dark:bg-gray-800 z-10">
                <h3 class="text-base font-bold text-gray-800 dark:text-white" x-text="modalTitle"></h3>
                <button type="button" @click="isModalOpen = false" class="text-gray-400 hover:text-gray-600 text-sm cursor-pointer">
                    <i class="fa-solid fa-xmark"></i>
                </button>
            </div>

            <form action="<?= site_url('sekolah/simpan'); ?>" method="POST" autocomplete="off" class="space-y-6 text-xs">
                <input type="hidden" name="id" x-model="form.id">

                <!-- 1. IDENTITAS SEKOLAH -->
                <div>
                    <h4 class="text-xs font-bold uppercase tracking-wider text-blue-600 dark:text-blue-400 mb-3">Identitas Sekolah</h4>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <div class="md:col-span-2">
                            <label class="block mb-1 font-bold text-gray-700 dark:text-gray-300">Nama Sekolah *</label>
                            <input type="text" name="nama_sekolah" x-model="form.nama_sekolah" required class="w-full h-10 px-3 border border-gray-200 rounded-xl bg-gray-50 dark:bg-gray-900 dark:border-gray-700 dark:text-white focus:outline-none focus:border-blue-500">
                        </div>
                        <div>
                            <label class="block mb-1 font-bold text-gray-700 dark:text-gray-300">NPSN</label>
                            <input type="text" name="npsn" x-model="form.npsn" class="w-full h-10 px-3 border border-gray-200 rounded-xl bg-gray-50 dark:bg-gray-900 dark:border-gray-700 dark:text-white focus:outline-none focus:border-blue-500">
                        </div>
                        <div>
                            <label class="block mb-1 font-bold text-gray-700 dark:text-gray-300">Bentuk Pendidikan</label>
                            <select name="bentuk_pendidikan" x-model="form.bentuk_pendidikan" class="w-full h-10 px-3 border border-gray-200 rounded-xl bg-gray-50 dark:bg-gray-900 dark:border-gray-700 dark:text-white focus:outline-none focus:border-blue-500">
                                <option value="">-- Pilih Bentuk Pendidikan --</option>
                                <?php foreach ($bentuk_pendidikan_list as $bp): ?>
                                    <option value="<?= html_escape($bp); ?>"><?= html_escape($bp); ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                </div>

                <!-- 2. ALAMAT & KOORDINAT -->
                <div class="pt-4 border-t border-gray-100 dark:border-gray-700">
                    <h4 class="text-xs font-bold uppercase tracking-wider text-blue-600 dark:text-blue-400 mb-3">Alamat & Koordinat</h4>
                    <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                        <div class="md:col-span-4">
                            <label class="block mb-1 font-bold text-gray-700 dark:text-gray-300">Alamat</label>
                            <input type="text" name="alamat" x-model="form.alamat" class="w-full h-10 px-3 border border-gray-200 rounded-xl bg-gray-50 dark:bg-gray-900 dark:border-gray-700 dark:text-white focus:outline-none focus:border-blue-500">
                        </div>
                        <div>
                            <label class="block mb-1 font-bold text-gray-700 dark:text-gray-300">Dusun</label>
                            <input type="text" name="dusun" x-model="form.dusun" class="w-full h-10 px-3 border border-gray-200 rounded-xl bg-gray-50 dark:bg-gray-900 dark:border-gray-700 dark:text-white focus:outline-none focus:border-blue-500">
                        </div>
                        <div>
                            <label class="block mb-1 font-bold text-gray-700 dark:text-gray-300">RT</label>
                            <input type="text" name="rt" x-model="form.rt" class="w-full h-10 px-3 border border-gray-200 rounded-xl bg-gray-50 dark:bg-gray-900 dark:border-gray-700 dark:text-white focus:outline-none focus:border-blue-500">
                        </div>
                        <div>
                            <label class="block mb-1 font-bold text-gray-700 dark:text-gray-300">RW</label>
                            <input type="text" name="rw" x-model="form.rw" class="w-full h-10 px-3 border border-gray-200 rounded-xl bg-gray-50 dark:bg-gray-900 dark:border-gray-700 dark:text-white focus:outline-none focus:border-blue-500">
                        </div>
                        <div>
                            <label class="block mb-1 font-bold text-gray-700 dark:text-gray-300">Desa / Kelurahan</label>
                            <input type="text" name="desa" x-model="form.desa" class="w-full h-10 px-3 border border-gray-200 rounded-xl bg-gray-50 dark:bg-gray-900 dark:border-gray-700 dark:text-white focus:outline-none focus:border-blue-500">
                        </div>
                        <div>
                            <label class="block mb-1 font-bold text-gray-700 dark:text-gray-300">Kecamatan</label>
                            <input type="text" name="kecamatan" x-model="form.kecamatan" class="w-full h-10 px-3 border border-gray-200 rounded-xl bg-gray-50 dark:bg-gray-900 dark:border-gray-700 dark:text-white focus:outline-none focus:border-blue-500">
                        </div>
                        <div>
                            <label class="block mb-1 font-bold text-gray-700 dark:text-gray-300">Kabupaten / Kota</label>
                            <input type="text" name="kabupaten" x-model="form.kabupaten" class="w-full h-10 px-3 border border-gray-200 rounded-xl bg-gray-50 dark:bg-gray-900 dark:border-gray-700 dark:text-white focus:outline-none focus:border-blue-500">
                        </div>
                        <div>
                            <label class="block mb-1 font-bold text-gray-700 dark:text-gray-300">Provinsi</label>
                            <input type="text" name="provinsi" x-model="form.provinsi" class="w-full h-10 px-3 border border-gray-200 rounded-xl bg-gray-50 dark:bg-gray-900 dark:border-gray-700 dark:text-white focus:outline-none focus:border-blue-500">
                        </div>
                        <div class="grid grid-cols-2 gap-2">
                            <div>
                                <label class="block mb-1 font-bold text-gray-700 dark:text-gray-300">Lintang</label>
                                <input type="text" name="lintang" x-model="form.lintang" class="w-full h-10 px-2.5 border border-gray-200 rounded-xl bg-gray-50 dark:bg-gray-900 dark:border-gray-700 dark:text-white focus:outline-none focus:border-blue-500">
                            </div>
                            <div>
                                <label class="block mb-1 font-bold text-gray-700 dark:text-gray-300">Bujur</label>
                                <input type="text" name="bujur" x-model="form.bujur" class="w-full h-10 px-2.5 border border-gray-200 rounded-xl bg-gray-50 dark:bg-gray-900 dark:border-gray-700 dark:text-white focus:outline-none focus:border-blue-500">
                            </div>
                        </div>
                    </div>
                </div>

                <!-- 3. DATA PELENGKAP -->
                <div class="pt-4 border-t border-gray-100 dark:border-gray-700">
                    <h4 class="text-xs font-bold uppercase tracking-wider text-blue-600 dark:text-blue-400 mb-3">Data Pelengkap</h4>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <div>
                            <label class="block mb-1 font-bold text-gray-700 dark:text-gray-300">Kebutuhan Khusus yang Dilayani</label>
                            <select name="berkebutuhan_khusus_id" x-model="form.berkebutuhan_khusus_id" class="w-full h-10 px-3 border border-gray-200 rounded-xl bg-gray-50 dark:bg-gray-900 dark:border-gray-700 dark:text-white focus:outline-none focus:border-blue-500">
                                <option value="">-- Tidak Ada / Umum --</option>
                                <?php foreach ($berkebutuhan_khusus as $bk): ?>
                                    <option value="<?= $bk->id; ?>"><?= html_escape($bk->nama); ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div>
                            <label class="block mb-1 font-bold text-gray-700 dark:text-gray-300">Status Kepemilikan</label>
                            <select name="status_kepemilikan" x-model="form.status_kepemilikan" class="w-full h-10 px-3 border border-gray-200 rounded-xl bg-gray-50 dark:bg-gray-900 dark:border-gray-700 dark:text-white focus:outline-none focus:border-blue-500">
                                <option value="">-- Pilih Status Kepemilikan --</option>
                                <option value="Pemerintah Pusat">Pemerintah Pusat</option>
                                <option value="Pemerintah Daerah">Pemerintah Daerah</option>
                                <option value="Yayasan">Yayasan</option>
                            </select>
                        </div>
                        <div>
                            <label class="block mb-1 font-bold text-gray-700 dark:text-gray-300">Yayasan</label>
                            <input type="text" name="yayasan" x-model="form.yayasan" class="w-full h-10 px-3 border border-gray-200 rounded-xl bg-gray-50 dark:bg-gray-900 dark:border-gray-700 dark:text-white focus:outline-none focus:border-blue-500">
                        </div>
                        <div>
                            <label class="block mb-1 font-bold text-gray-700 dark:text-gray-300">SK Pendirian Sekolah</label>
                            <input type="text" name="sk_pendirian" x-model="form.sk_pendirian" class="w-full h-10 px-3 border border-gray-200 rounded-xl bg-gray-50 dark:bg-gray-900 dark:border-gray-700 dark:text-white focus:outline-none focus:border-blue-500">
                        </div>
                        <div>
                            <label class="block mb-1 font-bold text-gray-700 dark:text-gray-300">Tanggal SK Pendirian</label>
                            <input type="date" name="tgl_sk_pendirian" x-model="form.tgl_sk_pendirian" class="w-full h-10 px-3 border border-gray-200 rounded-xl bg-gray-50 dark:bg-gray-900 dark:border-gray-700 dark:text-white focus:outline-none focus:border-blue-500">
                        </div>
                        <div>
                            <label class="block mb-1 font-bold text-gray-700 dark:text-gray-300">SK Izin Operasional</label>
                            <input type="text" name="sk_izin_operasional" x-model="form.sk_izin_operasional" class="w-full h-10 px-3 border border-gray-200 rounded-xl bg-gray-50 dark:bg-gray-900 dark:border-gray-700 dark:text-white focus:outline-none focus:border-blue-500">
                        </div>
                        <div>
                            <label class="block mb-1 font-bold text-gray-700 dark:text-gray-300">Tanggal SK Izin Operasional</label>
                            <input type="date" name="tgl_sk_izin_operasional" x-model="form.tgl_sk_izin_operasional" class="w-full h-10 px-3 border border-gray-200 rounded-xl bg-gray-50 dark:bg-gray-900 dark:border-gray-700 dark:text-white focus:outline-none focus:border-blue-500">
                        </div>
                    </div>
                </div>

                <!-- 4. KONTAK & SOSIAL MEDIA -->
                <div class="pt-4 border-t border-gray-100 dark:border-gray-700">
                    <h4 class="text-xs font-bold uppercase tracking-wider text-blue-600 dark:text-blue-400 mb-3">Kontak & Sosial Media</h4>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <div>
                            <label class="block mb-1 font-bold text-gray-700 dark:text-gray-300">No. Telepon</label>
                            <input type="text" name="no_telepon" x-model="form.no_telepon" class="w-full h-10 px-3 border border-gray-200 rounded-xl bg-gray-50 dark:bg-gray-900 dark:border-gray-700 dark:text-white focus:outline-none focus:border-blue-500">
                        </div>
                        <div>
                            <label class="block mb-1 font-bold text-gray-700 dark:text-gray-300">No. HP / WhatsApp</label>
                            <input type="text" name="no_hp" x-model="form.no_hp" class="w-full h-10 px-3 border border-gray-200 rounded-xl bg-gray-50 dark:bg-gray-900 dark:border-gray-700 dark:text-white focus:outline-none focus:border-blue-500">
                        </div>
                        <div>
                            <label class="block mb-1 font-bold text-gray-700 dark:text-gray-300">Email</label>
                            <input type="email" name="email" x-model="form.email" class="w-full h-10 px-3 border border-gray-200 rounded-xl bg-gray-50 dark:bg-gray-900 dark:border-gray-700 dark:text-white focus:outline-none focus:border-blue-500">
                        </div>
                        <div class="md:col-span-3">
                            <label class="block mb-1 font-bold text-gray-700 dark:text-gray-300">Website</label>
                            <input type="text" name="website" x-model="form.website" class="w-full h-10 px-3 border border-gray-200 rounded-xl bg-gray-50 dark:bg-gray-900 dark:border-gray-700 dark:text-white focus:outline-none focus:border-blue-500">
                        </div>
                        <div>
                            <label class="block mb-1 font-bold text-gray-700 dark:text-gray-300"><i class="fa-brands fa-instagram text-pink-600 mr-1"></i> Instagram</label>
                            <input type="text" name="sosmed_ig" x-model="form.sosmed_ig" class="w-full h-10 px-3 border border-gray-200 rounded-xl bg-gray-50 dark:bg-gray-900 dark:border-gray-700 dark:text-white focus:outline-none focus:border-blue-500">
                        </div>
                        <div>
                            <label class="block mb-1 font-bold text-gray-700 dark:text-gray-300"><i class="fa-brands fa-facebook text-blue-600 mr-1"></i> Facebook</label>
                            <input type="text" name="sosmed_fb" x-model="form.sosmed_fb" class="w-full h-10 px-3 border border-gray-200 rounded-xl bg-gray-50 dark:bg-gray-900 dark:border-gray-700 dark:text-white focus:outline-none focus:border-blue-500">
                        </div>
                        <div>
                            <label class="block mb-1 font-bold text-gray-700 dark:text-gray-300"><i class="fa-brands fa-youtube text-red-600 mr-1"></i> YouTube</label>
                            <input type="text" name="sosmed_yt" x-model="form.sosmed_yt" class="w-full h-10 px-3 border border-gray-200 rounded-xl bg-gray-50 dark:bg-gray-900 dark:border-gray-700 dark:text-white focus:outline-none focus:border-blue-500">
                        </div>
                        <div>
                            <label class="block mb-1 font-bold text-gray-700 dark:text-gray-300"><i class="fa-brands fa-tiktok mr-1"></i> TikTok</label>
                            <input type="text" name="sosmed_tt" x-model="form.sosmed_tt" class="w-full h-10 px-3 border border-gray-200 rounded-xl bg-gray-50 dark:bg-gray-900 dark:border-gray-700 dark:text-white focus:outline-none focus:border-blue-500">
                        </div>
                    </div>
                </div>

                <!-- TOMBOL AKSI -->
                <div class="flex justify-end space-x-2 pt-4 border-t border-gray-100 dark:border-gray-700 sticky bottom-0 bg-white dark:bg-gray-800 py-2">
                    <button type="button" @click="isModalOpen = false" class="px-4 py-2 rounded-xl border border-gray-200 text-gray-600 text-xs font-semibold cursor-pointer">Batal</button>
                    <button type="submit" class="px-4 py-2 rounded-xl bg-blue-600 hover:bg-blue-700 text-white text-xs font-semibold shadow-sm cursor-pointer">Simpan</button>
                </div>
            </form>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            <?php if ($this->session->flashdata('success')): ?>
                const Toast = Swal.mixin({
                    toast: true,
                    position: 'top-end',
                    showConfirmButton: false,
                    timer: 3000,
                    timerProgressBar: true
                });
                Toast.fire({
                    icon: 'success',
                    title: '<?= $this->session->flashdata('success'); ?>'
                });
            <?php endif; ?>
        });

        function kosongkanFormSekolah() {
            return {
                id: '',
                nama_sekolah: '',
                npsn: '',
                bentuk_pendidikan: '',
                alamat: '',
                dusun: '',
                rt: '',
                rw: '',
                desa: '',
                kecamatan: '',
                kabupaten: '',
                provinsi: '',
                lintang: '',
                bujur: '',
                berkebutuhan_khusus_id: '',
                status_kepemilikan: '',
                yayasan: '',
                sk_pendirian: '',
                tgl_sk_pendirian: '',
                sk_izin_operasional: '',
                tgl_sk_izin_operasional: '',
                no_telepon: '',
                no_hp: '',
                email: '',
                website: '',
                sosmed_ig: '',
                sosmed_fb: '',
                sosmed_yt: '',
                sosmed_tt: ''
            };
        }

        function sekolahLembarProfilApp() {
            return {
                isModalOpen: false,
                modalTitle: 'Ubah Profil Sekolah',
                form: kosongkanFormSekolah(),
                bukaModalTambah() {
                    this.modalTitle = 'Tambah Data Sekolah';
                    this.form = kosongkanFormSekolah();
                    this.isModalOpen = true;
                },
                bukaModalEdit(id) {
                    fetch(`<?= site_url('sekolah/get_by_id/') ?>${id}`)
                        .then(res => res.json())
                        .then(data => {
                            let sosmed = {
                                instagram: '',
                                facebook: '',
                                youtube: '',
                                tiktok: ''
                            };
                            if (data.sosial_media) {
                                try {
                                    sosmed = Object.assign(sosmed, typeof data.sosial_media === 'string' ? JSON.parse(data.sosial_media) : data.sosial_media);
                                } catch (e) {}
                            }
                            this.modalTitle = 'Ubah Profil Sekolah';
                            this.form = {
                                id: data.id || '',
                                nama_sekolah: data.nama_sekolah || '',
                                npsn: data.npsn || '',
                                bentuk_pendidikan: data.bentuk_pendidikan || '',
                                alamat: data.alamat || '',
                                dusun: data.dusun || '',
                                rt: data.rt || '',
                                rw: data.rw || '',
                                desa: data.desa || '',
                                kecamatan: data.kecamatan || '',
                                kabupaten: data.kabupaten || '',
                                provinsi: data.provinsi || '',
                                lintang: data.lintang || '',
                                bujur: data.bujur || '',
                                berkebutuhan_khusus_id: data.berkebutuhan_khusus_id ? String(data.berkebutuhan_khusus_id) : '',
                                status_kepemilikan: data.status_kepemilikan || '',
                                yayasan: data.yayasan || '',
                                sk_pendirian: data.sk_pendirian || '',
                                tgl_sk_pendirian: data.tgl_sk_pendirian || '',
                                sk_izin_operasional: data.sk_izin_operasional || '',
                                tgl_sk_izin_operasional: data.tgl_sk_izin_operasional || '',
                                no_telepon: data.no_telepon || '',
                                no_hp: data.no_hp || '',
                                email: data.email || '',
                                website: data.website || '',
                                sosmed_ig: sosmed.instagram || '',
                                sosmed_fb: sosmed.facebook || '',
                                sosmed_yt: sosmed.youtube || '',
                                sosmed_tt: sosmed.tiktok || ''
                            };
                            this.isModalOpen = true;
                        });
                },
                gantiSekolah(id) {
                    window.location.href = `<?= site_url('sekolah/index/') ?>${id}`;
                },
                konfirmasiHapus(urlDelete) {
                    Swal.fire({
                        title: 'Apakah Anda yakin?',
                        text: "Data sekolah yang dihapus tidak dapat dikembalikan!",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#e11d48',
                        cancelButtonColor: '#6b7280',
                        confirmButtonText: 'Ya, Hapus!',
                        cancelButtonText: 'Batal'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            window.location.href = urlDelete;
                        }
                    });
                }
            };
        }
    </script>
</main>