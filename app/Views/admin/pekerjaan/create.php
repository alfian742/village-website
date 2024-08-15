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

                <form action="<?= base_url('dashboard/pekerjaan/save'); ?>" method="post">
                    <?= csrf_field(); ?>

                    <div class="form-group mb-4">
                        <label for="pekerjaan">Nama Pekerjaan <span class="text-danger">*</span></label>
                        <input type="text" class="form-control <?= session('errors.pekerjaan') ? 'is-invalid' : ''; ?>" id="pekerjaan" placeholder="Masukan Nama Pekerjaan" name="pekerjaan" value="<?= old('pekerjaan'); ?>">
                        <div class="invalid-feedback">
                            <i class="bx bx-radio-circle"></i>
                            <?= session('errors.pekerjaan') ?>
                        </div>
                    </div>

                    <div class="form-group mb-4">
                        <label for="jumlah">Jumlah <span class="text-danger">*</span></label>
                        <input type="number" class="form-control <?= session('errors.jumlah') ? 'is-invalid' : ''; ?>" id="jumlah" placeholder="Masukan Jumlah Data" name="jumlah" value="<?= old('jumlah'); ?>">
                        <div class="invalid-feedback">
                            <i class="bx bx-radio-circle"></i>
                            <?= session('errors.jumlah') ?>
                        </div>
                    </div>

                    <div class="row g-2">
                        <div class="col-6">
                            <a href="<?= base_url('dashboard/pekerjaan'); ?>" type="button" class="btn btn-danger w-100">Batal</a>
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