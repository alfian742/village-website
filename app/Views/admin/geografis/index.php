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
                        <a href="<?= base_url(); ?>" target="_blank" class="btn btn-outline-success icon"><i class="bi bi-eye d-md-none"></i><span class="d-none d-md-inline">Lihat Pratinjau</span></a>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <?= $this->include('admin/layout/alert-message'); ?>

                <form action="<?= base_url('dashboard/geografis/update/') . $geografis['id']; ?>" method="post">
                    <div class="row">
                        <div class="col-xl-8 col-lg-7 col-md-6">
                            <?= csrf_field(); ?>

                            <div class="form-group mb-4">
                                <label for="lokasi">Lokasi <span class="text-danger">*</span></label>
                                <input type="text" class="form-control <?= session('errors.lokasi') ? 'is-invalid' : ''; ?>" id="lokasi" placeholder="Masukan Lokasi" name="lokasi" value="<?= (old('lokasi')) ? old('lokasi') : $geografis['lokasi']; ?>">
                                <div class="invalid-feedback">
                                    <i class="bx bx-radio-circle"></i>
                                    <?= session('errors.lokasi') ?>
                                </div>
                                <p><small class="text-muted">Contoh: Desa/Kelurahan, Kecamatan, Kabupaten/Kota</small></p>
                            </div>

                            <div class="form-group mb-4">
                                <label for="luas">Luas (Boleh Kosong)</label>
                                <input type="text" class="form-control <?= session('errors.luas') ? 'is-invalid' : ''; ?>" id="luas" placeholder="Masukan Luas" name="luas" value="<?= (old('luas')) ? old('luas') : $geografis['luas']; ?>">
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
                                <input type="text" class="form-control <?= session('errors.timur') ? 'is-invalid' : ''; ?>" id="timur" placeholder="Masukan Wilayah Timur" name="timur" value="<?= (old('timur')) ? old('timur') : $geografis['timur']; ?>">
                                <div class="invalid-feedback">
                                    <i class="bx bx-radio-circle"></i>
                                    <?= session('errors.timur') ?>
                                </div>
                            </div>

                            <div class="form-group mb-4">
                                <label for="barat">Barat <span class="text-danger">*</span></label>
                                <input type="text" class="form-control <?= session('errors.barat') ? 'is-invalid' : ''; ?>" id="barat" placeholder="Masukan Wilayah Barat" name="barat" value="<?= (old('barat')) ? old('barat') : $geografis['barat']; ?>">
                                <div class="invalid-feedback">
                                    <i class="bx bx-radio-circle"></i>
                                    <?= session('errors.barat') ?>
                                </div>
                            </div>

                            <div class="form-group mb-4">
                                <label for="selatan">Selatan <span class="text-danger">*</span></label>
                                <input type="text" class="form-control <?= session('errors.selatan') ? 'is-invalid' : ''; ?>" id="selatan" placeholder="Masukan Wilayah Selatan" name="selatan" value="<?= (old('selatan')) ? old('selatan') : $geografis['selatan']; ?>">
                                <div class="invalid-feedback">
                                    <i class="bx bx-radio-circle"></i>
                                    <?= session('errors.selatan') ?>
                                </div>
                            </div>

                            <div class="form-group mb-4">
                                <label for="utara">Utara <span class="text-danger">*</span></label>
                                <input type="text" class="form-control <?= session('errors.utara') ? 'is-invalid' : ''; ?>" id="utara" placeholder="Masukan Wilayah Utara" name="utara" value="<?= (old('utara')) ? old('utara') : $geografis['utara']; ?>">
                                <div class="invalid-feedback">
                                    <i class="bx bx-radio-circle"></i>
                                    <?= session('errors.utara') ?>
                                </div>
                            </div>
                        </div>

                        <div class="col-xl-4 col-lg-5 col-md-6">
                            <div class="ratio ratio-1x1 mb-4">
                                <iframe src="https://maps.google.com/maps?q=<?= urlencode($geografis['lokasi']); ?>&hl=id&m=h&output=embed" class="rounded-4" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
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