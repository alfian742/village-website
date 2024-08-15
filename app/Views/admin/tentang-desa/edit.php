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

                <form action="<?= base_url('dashboard/tentang-desa/update/') . $tentang_desa['id']; ?>" method="post">
                    <?= csrf_field(); ?>

                    <div class="form-group mb-4">
                        <label for="tentang_desa" class="form-label">Tentang Desa/Kelurahan <span class="text-danger">*</span></label>
                        <textarea class="form-control cke-editor-form <?= session('errors.tentang_desa') ? 'is-invalid' : ''; ?>" id="tentang_desa" placeholder="Sejarah, kebudayaan, dan lain sebagainya" name="tentang_desa" rows="4"><?= (old('tentang_desa')) ? old('tentang_desa') : $tentang_desa['tentang_desa']; ?></textarea>
                        <div class="invalid-feedback">
                            <i class="bx bx-radio-circle"></i>
                            <?= session('errors.tentang_desa') ?>
                        </div>
                    </div>

                    <div class="form-group mb-4">
                        <label for="visi" class="form-label">Visi <span class="text-danger">*</span></label>
                        <textarea class="form-control cke-editor-form <?= session('errors.visi') ? 'is-invalid' : ''; ?>" id="visi" placeholder="Masukan Visi" name="visi" rows="4"><?= (old('visi')) ? old('visi') : $tentang_desa['visi']; ?></textarea>
                        <div class="invalid-feedback">
                            <i class="bx bx-radio-circle"></i>
                            <?= session('errors.visi') ?>
                        </div>
                    </div>

                    <div class="form-group mb-4">
                        <label for="misi" class="form-label">Misi <span class="text-danger">*</span></label>
                        <textarea class="form-control cke-editor-form <?= session('errors.misi') ? 'is-invalid' : ''; ?>" id="misi" placeholder="Masukan Misi" name="misi" rows="4"><?= (old('misi')) ? old('misi') : $tentang_desa['misi']; ?></textarea>
                        <div class="invalid-feedback">
                            <i class="bx bx-radio-circle"></i>
                            <?= session('errors.misi') ?>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-xl-4 col-lg-4 col-md-4 col-sm-6">
                            <div class="row g-2">
                                <div class="col-6">
                                    <a href="<?= base_url('dashboard/tentang-desa'); ?>" type="button" class="btn btn-danger w-100">Batal</a>
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