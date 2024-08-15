<?= $this->extend('admin/layout/template'); ?>

<?= $this->section('content'); ?>

<section class="row">
    <div class="col">
        <div class="card">
            <div class="card-header">
                <div class="d-flex justify-content-between align-items-center">
                    <h5 class="card-title my-auto">
                        <?= $title; ?>
                    </h5>
                    <div class="d-flex justify-content-end align-items-center gap-2">
                        <a href="<?= base_url('sotk'); ?>" target="_blank" class="btn btn-outline-success icon"><i class="bi bi-eye d-md-none"></i><span class="d-none d-md-inline">Lihat Pratinjau</span></a>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <?= $this->include('admin/layout/alert-message'); ?>

                <form action="<?= base_url('dashboard/struktur-organisasi/update/') . $struktur_organisasi['id']; ?>" method="post" enctype="multipart/form-data">
                    <div class="row g-4">
                        <div class="col-xl-8 col-lg-7 col-md-6">
                            <label for="gambar" class="ratio ratio-16x9" data-bs-toggle="tooltip" data-bs-title="Klik untuk unggah gambar">
                                <img class="rounded-4 cursor-pointer form-img" src="<?= base_url('img/struktur-organisasi/') . $struktur_organisasi['gambar']; ?>" alt="..." loading="eager">
                            </label>
                        </div>

                        <div class="col-xl-4 col-lg-5 col-md-6">
                            <?= csrf_field(); ?>
                            <input type="hidden" name="gambarLama" value="<?= $struktur_organisasi['gambar']; ?>">

                            <div class="form-group mb-4">
                                <input type="file" class="form-control <?= session('errors.gambar') ? 'is-invalid' : ''; ?>" id="gambar" placeholder="Unggah Gambar" name="gambar" onchange="previewImage()" accept="image/jpeg, image/jpg, image/png" value="<?= $struktur_organisasi['gambar']; ?>">
                                <div class="invalid-feedback">
                                    <i class="bx bx-radio-circle"></i>
                                    <?= session('errors.gambar') ?>
                                </div>
                                <p class="d-flex flex-column gap-1 mt-1">
                                    <small class="text-muted">Disarankan rasio gambar 16:9</small>
                                    <small class="text-muted"><span class="text-danger">*</span> Format gambar JPG/JPEG/PNG dan ukuran maksimal 3 MB</small>
                                </p>
                            </div>

                            <button type="submit" class="btn btn-primary w-100">Simpan</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>

<?= $this->endSection(); ?>