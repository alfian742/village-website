<?= $this->extend('admin/layout/template'); ?>

<?= $this->section('content'); ?>

<section class="row">
    <div class="col">
        <div class="card">
            <div class="card-header">
                <div class="d-flex justify-content-between align-items-center">
                    <h5 class="card-title my-auto">
                        Profil <?= $title; ?>
                    </h5>
                    <div class="d-flex justify-content-end align-items-center gap-2">
                        <a href="<?= base_url('data-kewilayahan/') . $dusun['slug']; ?>" target="_blank" class="btn btn-outline-success icon"><i class="bi bi-eye d-md-none"></i><span class="d-none d-md-inline">Lihat Pratinjau</span></a>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="d-flex align-items-center gap-3 mb-5 mt-3">
                    <img class="rounded-circle object-fit-cover border" src="<?= base_url('img/staff/') . $kepala_dusun['foto']; ?>" alt="" height="64" width="64">
                    <div class="d-flex flex-column mt-2">
                        <h6 class="text-clamp-1"><?= $kepala_dusun['nama']; ?></h6>
                        <h6 class="text-uppercase"><?= (user()->level == 'kepala dusun') ? 'Kadus/Kaling' : ''; ?></h6>
                    </div>
                </div>

                <?= $this->include('admin/layout/alert-message'); ?>

                <form action="<?= base_url('dashboard/kewilayahan/dusun/update'); ?>" method="post" enctype="multipart/form-data">
                    <div class="row">
                        <div class="col-xl-8 col-lg-7 col-md-6">
                            <?= csrf_field(); ?>
                            <input type="hidden" name="gambarLama" value="<?= $dusun['gambar']; ?>">
                            <input type="hidden" name="dusun_id" value="<?= $dusun['id']; ?>">

                            <div class="form-group mb-4">
                                <label for="deskripsi" class="form-label">Deskripsi Dusun/Lingkungan <span class="text-danger">*</span></label>
                                <textarea class="form-control cke-editor-form <?= session('errors.deskripsi') ? 'is-invalid' : ''; ?>" id="deskripsi" placeholder="Masukan Deskripsi Dusun/Lingkungan (SDA, SDM dan lain sebagainya)" name="deskripsi" rows="4"><?= (old('deskripsi')) ? old('deskripsi') : $dusun['deskripsi']; ?></textarea>
                                <div class="invalid-feedback">
                                    <i class="bx bx-radio-circle"></i>
                                    <?= session('errors.deskripsi') ?>
                                </div>
                            </div>

                            <div class="form-group mb-4">
                                <label for="luas">Luas (Boleh Kosong)</label>
                                <input type="text" class="form-control <?= session('errors.luas') ? 'is-invalid' : ''; ?>" id="luas" placeholder="Masukan Luas Dusun/Lingkungan" name="luas" value="<?= (old('luas')) ? old('luas') : $dusun['luas']; ?>">
                                <div class="invalid-feedback">
                                    <i class="bx bx-radio-circle"></i>
                                    <?= session('errors.luas') ?>
                                </div>
                                <p><small class="text-muted">Contoh: 12345 km²</small></p>
                            </div>

                            <div class="divider">
                                <div class="divider-text fw-bold rounded">Batas Wilayah</div>
                            </div>

                            <div class="form-group mb-4">
                                <label for="timur">Timur <span class="text-danger">*</span></label>
                                <input type="text" class="form-control <?= session('errors.timur') ? 'is-invalid' : ''; ?>" id="timur" placeholder="Batas Wilayah Timur" name="timur" value="<?= (old('timur')) ? old('timur') : $dusun['timur']; ?>">
                                <div class="invalid-feedback">
                                    <i class="bx bx-radio-circle"></i>
                                    <?= session('errors.timur') ?>
                                </div>
                            </div>

                            <div class="form-group mb-4">
                                <label for="barat">Barat <span class="text-danger">*</span></label>
                                <input type="text" class="form-control <?= session('errors.barat') ? 'is-invalid' : ''; ?>" id="barat" placeholder="Batas Wilayah Barat" name="barat" value="<?= (old('barat')) ? old('barat') : $dusun['barat']; ?>">
                                <div class="invalid-feedback">
                                    <i class="bx bx-radio-circle"></i>
                                    <?= session('errors.barat') ?>
                                </div>
                            </div>

                            <div class="form-group mb-4">
                                <label for="selatan">Selatan <span class="text-danger">*</span></label>
                                <input type="text" class="form-control <?= session('errors.selatan') ? 'is-invalid' : ''; ?>" id="selatan" placeholder="Batas Wilayah Selatan" name="selatan" value="<?= (old('selatan')) ? old('selatan') : $dusun['selatan']; ?>">
                                <div class="invalid-feedback">
                                    <i class="bx bx-radio-circle"></i>
                                    <?= session('errors.selatan') ?>
                                </div>
                            </div>

                            <div class="form-group mb-4">
                                <label for="utara">Utara <span class="text-danger">*</span></label>
                                <input type="text" class="form-control <?= session('errors.utara') ? 'is-invalid' : ''; ?>" id="utara" placeholder="Batas Wilayah Utara" name="utara" value="<?= (old('utara')) ? old('utara') : $dusun['utara']; ?>">
                                <div class="invalid-feedback">
                                    <i class="bx bx-radio-circle"></i>
                                    <?= session('errors.utara') ?>
                                </div>
                            </div>
                        </div>

                        <div class="col-xl-4 col-lg-5 col-md-6">
                            <div class="form-group mb-4">
                                <label for="gambar" class="ratio ratio-4x3" data-bs-toggle="tooltip" data-bs-title="Klik untuk unggah gambar">
                                    <img class="rounded-4 object-fit-cover cursor-pointer form-img" src="<?= base_url('img/dusun/') . $dusun['gambar']; ?>" alt="...">
                                </label>
                                <input type="file" class="form-control d-none <?= session('errors.gambar') ? 'is-invalid' : ''; ?>" id="gambar" name="gambar" onchange="previewImage()" accept="image/jpeg, image/jpg, image/png" value="<?= $dusun['gambar']; ?>">
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
                                    <a href="<?= base_url('dashboard/dashboard'); ?>" type="button" class="btn btn-danger w-100">Batal</a>
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