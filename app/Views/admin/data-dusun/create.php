<?= $this->extend('admin/layout/template'); ?>

<?= $this->section('content'); ?>

<section class="row justify-content-center align-items-center">
    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12">
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

                <form action="<?= base_url('dashboard/data-dusun/save'); ?>" method="post">
                    <?= csrf_field(); ?>

                    <div class="form-group mb-4">
                        <label for="dusun_id" class="form-label">Nama Dusun/Lingkungan <span class="text-danger">*</span></label>
                        <select class="form-select <?= session('errors.dusun_id') ? 'is-invalid' : ''; ?>" id="dusun_id" name="dusun_id">
                            <?php foreach ($dusun as $dsn) : ?>
                                <option value="<?= $dsn['id']; ?>" <?= old('dusun_id') == $dsn['id'] ? 'selected' : ''; ?>><?= $dsn['nama_dusun']; ?></option>
                            <?php endforeach; ?>
                        </select>
                        <div class="invalid-feedback">
                            <i class="bx bx-radio-circle"></i>
                            <?= session('errors.dusun_id') ?>
                        </div>
                    </div>

                    <div class="form-group mb-4">
                        <label for="waktu">Bulan & Tahun <span class="text-danger">*</span></label>
                        <input type="month" class="form-control <?= session('errors.waktu') ? 'is-invalid' : ''; ?>" id="waktu" placeholder="Masukan Bulan & Tahun" name="waktu" value="<?= old('waktu'); ?>">
                        <div class="invalid-feedback">
                            <i class="bx bx-radio-circle"></i>
                            <?= session('errors.waktu') ?>
                        </div>
                    </div>

                    <div class="form-group mb-4">
                        <label for="jumlah_lahir">Kelahiran (Boleh Kosong)</label>
                        <input type="number" class="form-control <?= session('errors.jumlah_lahir') ? 'is-invalid' : ''; ?>" id="jumlah_lahir" placeholder="Masukan Jumlah Data" name="jumlah_lahir" value="<?= old('jumlah_lahir'); ?>">
                        <div class="invalid-feedback">
                            <i class="bx bx-radio-circle"></i>
                            <?= session('errors.jumlah_lahir') ?>
                        </div>
                    </div>

                    <div class="form-group mb-4">
                        <label for="jumlah_mati">Kematian (Boleh Kosong)</label>
                        <input type="number" class="form-control <?= session('errors.jumlah_mati') ? 'is-invalid' : ''; ?>" id="jumlah_mati" placeholder="Masukan Jumlah Data" name="jumlah_mati" value="<?= old('jumlah_mati'); ?>">
                        <div class="invalid-feedback">
                            <i class="bx bx-radio-circle"></i>
                            <?= session('errors.jumlah_mati') ?>
                        </div>
                    </div>

                    <div class="form-group mb-4">
                        <label for="jumlah_masuk">Penduduk Masuk (Boleh Kosong)</label>
                        <input type="number" class="form-control <?= session('errors.jumlah_masuk') ? 'is-invalid' : ''; ?>" id="jumlah_masuk" placeholder="Masukan Jumlah Data" name="jumlah_masuk" value="<?= old('jumlah_masuk'); ?>">
                        <div class="invalid-feedback">
                            <i class="bx bx-radio-circle"></i>
                            <?= session('errors.jumlah_masuk') ?>
                        </div>
                    </div>

                    <div class="form-group mb-4">
                        <label for="jumlah_keluar">Penduduk Keluar (Boleh Kosong)</label>
                        <input type="number" class="form-control <?= session('errors.jumlah_keluar') ? 'is-invalid' : ''; ?>" id="jumlah_keluar" placeholder="Masukan Jumlah Data" name="jumlah_keluar" value="<?= old('jumlah_keluar'); ?>">
                        <div class="invalid-feedback">
                            <i class="bx bx-radio-circle"></i>
                            <?= session('errors.jumlah_keluar') ?>
                        </div>
                    </div>

                    <div class="row g-2">
                        <div class="col-6">
                            <a href="<?= base_url('dashboard/data-dusun'); ?>" type="button" class="btn btn-danger w-100">Batal</a>
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