<?= $this->extend('admin/layout/template'); ?>

<?= $this->section('content'); ?>

<section class="row justify-content-center align-items-center">
    <div class="col-xl-8 col-lg-8 col-md-6 col-sm-6">
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

                <form action="<?= base_url('dashboard/layanan/update/') . $layanan['slug']; ?>" method="post">
                    <?= csrf_field(); ?>

                    <div class="form-group mb-4">
                        <label for="nama_layanan">Nama Layanan <span class="text-danger">*</span></label>
                        <input type="text" class="form-control <?= session('errors.nama_layanan') ? 'is-invalid' : ''; ?>" id="nama_layanan" placeholder="Masukan Nama Layanan" name="nama_layanan" value="<?= (old('nama_layanan')) ? old('nama_layanan') : $layanan['nama_layanan']; ?>">
                        <div class="invalid-feedback">
                            <i class="bx bx-radio-circle"></i>
                            <?= session('errors.nama_layanan') ?>
                        </div>
                    </div>

                    <div class="form-group mb-4">
                        <label for="deskripsi" class="form-label">Deskripsi <span class="text-danger">*</span></label>
                        <textarea class="form-control cke-editor-form <?= session('errors.deskripsi') ? 'is-invalid' : ''; ?>" id="deskripsi" placeholder="Masukan Deskripsi" name="deskripsi" rows="4"><?= (old('deskripsi')) ? old('deskripsi') : $layanan['deskripsi']; ?></textarea>
                        <div class="invalid-feedback">
                            <i class="bx bx-radio-circle"></i>
                            <?= session('errors.deskripsi') ?>
                        </div>
                    </div>

                    <div class="row g-2">
                        <div class="col-6">
                            <a href="<?= base_url('dashboard/layanan'); ?>" type="button" class="btn btn-danger w-100">Batal</a>
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