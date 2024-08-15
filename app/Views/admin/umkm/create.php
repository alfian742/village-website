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

                <form action="<?= base_url('dashboard/umkm/save'); ?>" method="post" enctype="multipart/form-data">
                    <div class="row">
                        <div class="col-xl-8 col-lg-7 col-md-6">
                            <?= csrf_field(); ?>
                            <input type="hidden" name="user_id" value="<?= user_id(); ?>">

                            <div class="form-group mb-4">
                                <label for="nama">Nama Produk <span class="text-danger">*</span></label>
                                <input type="text" class="form-control <?= session('errors.nama') ? 'is-invalid' : ''; ?>" id="nama" placeholder="Masukan Nama Produk" name="nama" value="<?= old('nama'); ?>">
                                <div class="invalid-feedback">
                                    <i class="bx bx-radio-circle"></i>
                                    <?= session('errors.nama') ?>
                                </div>
                            </div>

                            <div class="form-group mb-4">
                                <label for="pemilik">Nama Pemilik <span class="text-danger">*</span></label>
                                <input type="text" class="form-control <?= session('errors.pemilik') ? 'is-invalid' : ''; ?>" id="pemilik" placeholder="Masukan Nama Pemilik" name="pemilik" value="<?= old('pemilik'); ?>">
                                <div class="invalid-feedback">
                                    <i class="bx bx-radio-circle"></i>
                                    <?= session('errors.pemilik') ?>
                                </div>
                            </div>

                            <div class="form-group mb-4">
                                <label for="nomor_hp">Nomor HP/WA <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <span class="input-group-text">+62</span>
                                    <input type="number" class="form-control <?= session('errors.nomor_hp') ? 'is-invalid' : ''; ?>" id="nomor_hp" placeholder="Masukan Nomor HP/WA" name="nomor_hp" value="<?= old('nomor_hp'); ?>">
                                    <div class="invalid-feedback">
                                        <i class="bx bx-radio-circle"></i>
                                        <?= session('errors.nomor_hp') ?>
                                    </div>
                                </div>
                                <p><small class="text-muted">Contoh: 81234567890</small></p>
                            </div>

                            <div class="form-group mb-4">
                                <label for="instagram">Instagram (Boleh Kosong)</label>
                                <input type="text" class="form-control <?= session('errors.instagram') ? 'is-invalid' : ''; ?>" id="instagram" placeholder="Masukan URL Instagram" name="instagram" value="<?= old('instagram'); ?>">
                                <div class="invalid-feedback">
                                    <i class="bx bx-radio-circle"></i>
                                    <?= session('errors.instagram') ?>
                                </div>
                                <p><small class="text-muted">Contoh: https://www.instagram.com</small></p>
                            </div>

                            <div class="form-group mb-4">
                                <label for="harga">Harga Produk <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <span class="input-group-text">Rp</span>
                                    <input type="number" class="form-control <?= session('errors.harga') ? 'is-invalid' : ''; ?>" id="harga" placeholder="Masukan Harga Produk" name="harga" value="<?= old('harga'); ?>">
                                    <div class="invalid-feedback">
                                        <i class="bx bx-radio-circle"></i>
                                        <?= session('errors.harga') ?>
                                    </div>
                                </div>
                                <p><small class="text-muted">Contoh: 15000</small></p>
                            </div>

                            <div class="form-group mb-4">
                                <label for="deskripsi" class="form-label">Deskripsi <span class="text-danger">*</span></label>
                                <textarea class="form-control cke-editor-form <?= session('errors.deskripsi') ? 'is-invalid' : ''; ?>" id="deskripsi" placeholder="Masukan Deskripsi" name="deskripsi" rows="4"><?= old('deskripsi'); ?></textarea>
                                <div class="invalid-feedback">
                                    <i class="bx bx-radio-circle"></i>
                                    <?= session('errors.deskripsi') ?>
                                </div>
                            </div>
                        </div>

                        <div class="col-xl-4 col-lg-5 col-md-6">
                            <div class="form-group mb-4">
                                <label for="gambar" class="ratio ratio-4x3" data-bs-toggle="tooltip" data-bs-title="Klik untuk unggah gambar">
                                    <img class="rounded-4 object-fit-cover cursor-pointer form-img" src="<?= base_url('assets/img/upload-placeholder.svg'); ?>" alt="...">
                                </label>
                                <input type="file" class="form-control d-none <?= session('errors.gambar') ? 'is-invalid' : ''; ?>" id="gambar" name="gambar" onchange="previewImage()" accept="image/jpeg, image/jpg, image/png">
                                <div class="invalid-feedback text-center">
                                    <i class="bx bx-radio-circle"></i>
                                    <?= session('errors.gambar') ?>
                                </div>
                                <p class="d-flex flex-column gap-1 text-center mt-1">
                                    <small class="text-muted">Silahkan klik untuk mengunggah gambar</small>
                                    <small class="text-muted"> <span class="text-danger">*</span> Format gambar JPG/JPEG/PNG dan ukuran maksimal 1 MB</small>
                                </p>
                            </div>

                            <div class="row g-2">
                                <div class="col-6">
                                    <a href="<?= base_url('dashboard/umkm'); ?>" type="button" class="btn btn-danger w-100">Batal</a>
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