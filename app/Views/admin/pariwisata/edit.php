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
                </div>
            </div>
            <div class="card-body">
                <?= $this->include('admin/layout/alert-message'); ?>

                <form action="<?= base_url('dashboard/pariwisata/update/') . $pariwisata['slug']; ?>" method="post" enctype="multipart/form-data">
                    <div class="row">
                        <div class="col-xl-8 col-lg-7 col-md-6">
                            <?= csrf_field(); ?>
                            <input type="hidden" name="gambarLama" value="<?= $pariwisata['gambar']; ?>">

                            <div class="form-group mb-4">
                                <label for="judul">Judul <span class="text-danger">*</span></label>
                                <input type="text" class="form-control <?= session('errors.judul') ? 'is-invalid' : ''; ?>" id="judul" placeholder="Masukan Judul" name="judul" value="<?= (old('judul')) ? old('judul') : $pariwisata['judul']; ?>">
                                <div class="invalid-feedback">
                                    <i class="bx bx-radio-circle"></i>
                                    <?= session('errors.judul') ?>
                                </div>
                            </div>

                            <div class="form-group mb-4">
                                <label for="deskripsi" class="form-label">Deskripsi <span class="text-danger">*</span></label>
                                <textarea class="form-control cke-editor-form <?= session('errors.deskripsi') ? 'is-invalid' : ''; ?>" id="deskripsi" placeholder="Masukan Deskripsi" name="deskripsi" rows="4"><?= (old('deskripsi')) ? old('deskripsi') : $pariwisata['deskripsi']; ?></textarea>
                                <div class="invalid-feedback">
                                    <i class="bx bx-radio-circle"></i>
                                    <?= session('errors.deskripsi') ?>
                                </div>
                            </div>
                        </div>

                        <div class="col-xl-4 col-lg-5 col-md-6">
                            <div class="form-group mb-4">
                                <label for="gambar" class="ratio ratio-4x3" data-bs-toggle="tooltip" data-bs-title="Klik untuk unggah gambar">
                                    <img class="rounded-4 object-fit-cover cursor-pointer form-img" src="<?= base_url('img/pariwisata/') . $pariwisata['gambar']; ?>" alt="...">
                                </label>
                                <input type="file" class="form-control d-none <?= session('errors.gambar') ? 'is-invalid' : ''; ?>" id="gambar" name="gambar" onchange="previewImage()" accept="image/jpeg, image/jpg, image/png" value="<?= $pariwisata['gambar']; ?>">
                                <div class="invalid-feedback text-center">
                                    <i class="bx bx-radio-circle"></i>
                                    <?= session('errors.gambar') ?>
                                </div>
                                <p class="d-flex flex-column gap-1 text-center mt-1">
                                    <small class="text-muted">Silahkan klik untuk mengunggah gambar</small>
                                    <small class="text-muted"><span class="text-danger">*</span> Format gambar JPG/JPEG/PNG dan ukuran maksimal 1 MB</small>
                                </p>
                            </div>

                            <div class="row g-2">
                                <div class="col-6">
                                    <a href="<?= base_url('dashboard/pariwisata'); ?>" type="button" class="btn btn-danger w-100">Batal</a>
                                </div>
                                <div class="col-6">
                                    <button type="submit" class="btn btn-primary w-100">Simpan</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>

<?= $this->endSection(); ?>