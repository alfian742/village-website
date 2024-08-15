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

                <form action="<?= base_url('dashboard/identitas-situs/update/') . $identitas_situs['id']; ?>" method="post" enctype="multipart/form-data">
                    <div class="row">
                        <div class="col-xl-8 col-lg-7 col-md-6">
                            <?= csrf_field(); ?>
                            <input type="hidden" name="logoLama" value="<?= $identitas_situs['logo']; ?>">

                            <div class="form-group mb-4">
                                <label for="nama_desa">Nama Desa/Kelurahan <span class="text-danger">*</span></label>
                                <input type="text" class="form-control <?= session('errors.nama_desa') ? 'is-invalid' : ''; ?>" id="nama_desa" placeholder="Masukan Nama Desa/Kelurahan" name="nama_desa" value="<?= (old('nama_desa')) ? old('nama_desa') : $identitas_situs['nama_desa']; ?>">
                                <div class="invalid-feedback">
                                    <i class="bx bx-radio-circle"></i>
                                    <?= session('errors.nama_desa') ?>
                                </div>
                                <p><small class="text-muted">Contoh: Desa ABCD atau Kelurahan ABCD</small></p>
                            </div>

                            <div class="form-group mb-4">
                                <label for="kecamatan">Kecamatan <span class="text-danger">*</span></label>
                                <input type="text" class="form-control <?= session('errors.kecamatan') ? 'is-invalid' : ''; ?>" id="kecamatan" placeholder="Masukan Kecamatan" name="kecamatan" value="<?= (old('kecamatan')) ? old('kecamatan') : $identitas_situs['kecamatan']; ?>">
                                <div class="invalid-feedback">
                                    <i class="bx bx-radio-circle"></i>
                                    <?= session('errors.kecamatan') ?>
                                </div>
                            </div>

                            <div class="form-group mb-4">
                                <label for="kabupaten">Kabupaten/Kota <span class="text-danger">*</span></label>
                                <input type="text" class="form-control <?= session('errors.kabupaten') ? 'is-invalid' : ''; ?>" id="kabupaten" placeholder="Masukan Kabupaten/Kota" name="kabupaten" value="<?= (old('kabupaten')) ? old('kabupaten') : $identitas_situs['kabupaten']; ?>">
                                <div class="invalid-feedback">
                                    <i class="bx bx-radio-circle"></i>
                                    <?= session('errors.kabupaten') ?>
                                </div>
                                <p><small class="text-muted">Contoh: Kabupaten ABCD atau Kota ABCD</small></p>
                            </div>

                            <div class="form-group mb-4">
                                <label for="provinsi">Provinsi <span class="text-danger">*</span></label>
                                <input type="text" class="form-control <?= session('errors.provinsi') ? 'is-invalid' : ''; ?>" id="provinsi" placeholder="Masukan Provinsi" name="provinsi" value="<?= (old('provinsi')) ? old('provinsi') : $identitas_situs['provinsi']; ?>">
                                <div class="invalid-feedback">
                                    <i class="bx bx-radio-circle"></i>
                                    <?= session('errors.provinsi') ?>
                                </div>
                            </div>

                            <div class="form-group mb-4">
                                <label for="kode_pos">Kode Pos <span class="text-danger">*</span></label>
                                <input type="number" class="form-control <?= session('errors.kode_pos') ? 'is-invalid' : ''; ?>" id="kode_pos" placeholder="Masukan Kode Pos" name="kode_pos" value="<?= (old('kode_pos')) ? old('kode_pos') : $identitas_situs['kode_pos']; ?>">
                                <div class="invalid-feedback">
                                    <i class="bx bx-radio-circle"></i>
                                    <?= session('errors.kode_pos') ?>
                                </div>
                            </div>
                        </div>

                        <div class="col-xl-4 col-lg-5 col-md-6">
                            <div class="form-group mb-4">
                                <label for="gambar" class="ratio ratio-4x3" data-bs-toggle="tooltip" data-bs-title="Klik untuk unggah logo">
                                    <img class="rounded-4 object-fit-contain cursor-pointer form-img" src="<?= base_url('img/logo/') . $identitas_situs['logo']; ?>" alt="...">
                                </label>
                                <input type="file" class="form-control d-none <?= session('errors.logo') ? 'is-invalid' : ''; ?>" id="gambar" name="logo" onchange="previewImage()" accept="image/jpeg, image/jpg, image/png" value="<?= $identitas_situs['logo']; ?>">
                                <div class="invalid-feedback">
                                    <i class="bx bx-radio-circle"></i>
                                    <?= session('errors.logo') ?>
                                </div>
                                <p class="d-flex flex-column gap-1 text-center mt-1">
                                    <small class="text-muted">Silahkan klik untuk mengunggah logo</small>
                                    <small class="text-muted">Disarankan rasio gambar 1:1</small>
                                    <small class="text-muted"><span class="text-danger">*</span> Format gambar JPG/JPEG/PNG dan ukuran maksimal 1 MB</small>
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