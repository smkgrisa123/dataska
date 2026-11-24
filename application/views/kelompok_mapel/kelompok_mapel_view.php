<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title; ?></title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">

    <div class="container mt-5">
        <div class="card shadow-sm">
            <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                <h5 class="mb-0">Data Kelompok Mapel</h5>
                <!-- Tombol Buka Modal Tambah -->
                <button type="button" class="btn btn-light btn-sm fw-bold" data-bs-toggle="modal" data-bs-target="#modalTambah">
                    + Tambah Kelompok Mapel
                </button>
            </div>
            <div class="card-body">

                <!-- Notifikasi Flashdata -->
                <?php if ($this->session->flashdata('success')): ?>
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <?= $this->session->flashdata('success'); ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                <?php endif; ?>

                <!-- Tabel Data -->
                <div class="table-responsive">
                    <table class="table table-bordered table-hover align-middle">
                        <thead class="table-secondary">
                            <tr>
                                <th width="8%" class="text-center">No</th>
                                <th>Kelompok Mapel</th>
                                <th width="20%" class="text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (!empty($kelompok)): ?>
                                <?php $no = 1;
                                foreach ($kelompok as $row): ?>
                                    <tr>
                                        <td class="text-center"><?= $no++; ?></td>
                                        <td><?= htmlspecialchars($row->kelompok_mapel); ?></td>
                                        <td class="text-center">
                                            <!-- Tombol Edit (Kirim data ke Modal Edit via atribut data-*) -->
                                            <button type="button"
                                                class="btn btn-warning btn-sm btn-edit"
                                                data-id="<?= $row->id_kelompok; ?>"
                                                data-nama="<?= htmlspecialchars($row->kelompok_mapel); ?>"
                                                data-bs-toggle="modal"
                                                data-bs-target="#modalEdit">
                                                Edit
                                            </button>

                                            <!-- Tombol Hapus -->
                                            <a href="<?= base_url('kelompok_mapel/hapus/' . $row->id_kelompok); ?>"
                                                class="btn btn-danger btn-sm"
                                                onclick="return confirm('Yakin ingin menghapus kelompok mapel ini?');">
                                                Hapus
                                            </a>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="3" class="text-center text-muted">Belum ada data kelompok mapel.</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>

            </div>
        </div>
    </div>

    <!-- ========================================== -->
    <!-- MODAL TAMBAH KELOMPOK MAPEL                -->
    <!-- ========================================== -->
    <div class="modal fade" id="modalTambah" tabindex="-1" aria-labelledby="modalTambahLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="<?= base_url('kelompok_mapel/tambah'); ?>" method="post">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalTambahLabel">Tambah Kelompok Mapel</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="kelompok_mapel" class="form-label">Kelompok Mapel</label>
                            <input type="text" class="form-control" id="kelompok_mapel" name="kelompok_mapel" placeholder="Contoh: Kelompok A (Umum)" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- ========================================== -->
    <!-- MODAL EDIT KELOMPOK MAPEL                  -->
    <!-- ========================================== -->
    <div class="modal fade" id="modalEdit" tabindex="-1" aria-labelledby="modalEditLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="<?= base_url('kelompok_mapel/edit'); ?>" method="post">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalEditLabel">Edit Kelompok Mapel</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <!-- Hidden Input untuk ID -->
                        <input type="hidden" name="id_kelompok" id="edit_id_kelompok">

                        <div class="mb-3">
                            <label for="edit_kelompok_mapel" class="form-label">Kelompok Mapel</label>
                            <input type="text" class="form-control" id="edit_kelompok_mapel" name="kelompok_mapel" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-warning">Update</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Bootstrap 5 JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Script untuk mengisi data otomatis ke dalam Modal Edit -->
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const editButtons = document.querySelectorAll('.btn-edit');
            editButtons.forEach(button => {
                button.addEventListener('click', function() {
                    const id = this.getAttribute('data-id');
                    const nama = this.getAttribute('data-nama');

                    document.getElementById('edit_id_kelompok').value = id;
                    document.getElementById('edit_kelompok_mapel').value = nama;
                });
            });
        });
    </script>

</body>

</html>