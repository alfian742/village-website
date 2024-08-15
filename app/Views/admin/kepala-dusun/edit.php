<?= $this->extend('admin/layout/template'); ?>

<?= $this->section('content'); ?>

<section class="row justify-content-center align-items-center">
    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6">
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

                <form action="<?= base_url('dashboard/kepala-dusun/update/') . $kepala_dusun['staff_id']; ?>" method="post" enctype="multipart/form-data">
                    <?= csrf_field(); ?>
                    <input type="hidden" name="fotoLama" value="<?= $kepala_dusun['foto']; ?>">

                    <div class="form-group mb-4">
                        <label for="nama">Nama <span class="text-danger">*</span></label>
                        <input type="text" class="form-control <?= session('errors.nama') ? 'is-invalid' : ''; ?>" id="nama" placeholder="Masukan Nama" name="nama" value="<?= (old('nama')) ? old('nama') : $kepala_dusun['nama']; ?>">
                        <div class="invalid-feedback">
                            <i class="bx bx-radio-circle"></i>
                            <?= session('errors.nama') ?>
                        </div>
                    </div>

                    <div class="form-group mb-4">
                        <label for="nip">NIP (Boleh Kosong)</label>
                        <input type="number" class="form-control <?= session('errors.nip') ? 'is-invalid' : ''; ?>" id="nip" placeholder="Masukan Nomor Induk Pegawai" name="nip" value="<?= (old('nip')) ? old('nip') : $kepala_dusun['nip']; ?>">
                        <div class="invalid-feedback">
                            <i class="bx bx-radio-circle"></i>
                            <?= session('errors.nip') ?>
                        </div>
                    </div>

                    <div class="form-group mb-4">
                        <label for="deskripsi" class="form-label">Deskripsi (Boleh Kosong)</label>
                        <textarea class="form-control cke-editor-form <?= session('errors.deskripsi') ? 'is-invalid' : ''; ?>" id="deskripsi" placeholder="Masukan Deskripsi (Masa Jabatan, SK, dan lain-lain)" name="deskripsi" rows="4"><?= (old('deskripsi')) ? old('deskripsi') : $kepala_dusun['deskripsi']; ?></textarea>
                        <div class="invalid-feedback">
                            <i class="bx bx-radio-circle"></i>
                            <?= session('errors.deskripsi') ?>
                        </div>
                    </div>

                    <div class="row justify-content-center align-items-center">
                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12">
                            <div class="form-group mb-4">
                                <label for="gambar" class="ratio ratio-1x1" data-bs-toggle="tooltip" data-bs-title="Klik untuk unggah foto">
                                    <img class="rounded-4 object-fit-cover cursor-pointer form-img" src="<?= base_url('img/staff/') . $kepala_dusun['foto']; ?>" alt="...">
                                </label>
                                <input type="file" class="form-control d-none <?= session('errors.foto') ? 'is-invalid' : ''; ?>" id="gambar" name="foto" onchange="previewImage()" accept="image/jpeg, image/jpg, image/png" value="<?= $kepala_dusun['foto']; ?>">
                                <div class="invalid-feedback">
                                    <i class="bx bx-radio-circle"></i>
                                    <?= session('errors.foto') ?>
                                </div>
                                <p class="d-flex flex-column gap-1 text-center mt-1">
                                    <small class="text-muted">Silahkan klik untuk mengunggah foto</small>
                                    <small class="text-muted"><span class="text-danger">*</span> Format gambar JPG/JPEG/PNG dan ukuran maksimal 1 MB</small>
                                </p>
                            </div>
                        </div>
                    </div>

                    <div class="row g-2">
                        <div class="col-6">
                            <a href="<?= base_url('dashboard/kepala-dusun'); ?>" type="button" class="btn btn-danger w-100">Batal</a>
                        </div>
                        <div class="col-6">
                            <button type="submit" class="btn btn-primary w-100">Simpan</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>

<?= $this->endSection(); ?>