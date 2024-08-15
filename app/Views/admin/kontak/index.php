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
                    <div class="d-flex justify-content-end align-items-center gap-2">
                        <a href="<?= base_url('kontak'); ?>" target="_blank" class="btn btn-outline-success icon"><i class="bi bi-eye d-md-none"></i><span class="d-none d-md-inline">Lihat Pratinjau</span></a>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <?= $this->include('admin/layout/alert-message'); ?>

                <form action="<?= base_url('dashboard/kontak/update/') . $kontak['id']; ?>" method="post">
                    <div class="divider">
                        <div class="divider-text fw-bold rounded">Kontak Utama</div>
                    </div>

                    <?= csrf_field(); ?>

                    <div class="form-group mb-4">
                        <label for="email">Email <span class="text-danger">*</span></label>
                        <input type="email" class="form-control <?= session('errors.email') ? 'is-invalid' : ''; ?>" id="email" placeholder="Masukan Email" name="email" value="<?= (old('email')) ? old('email') : $kontak['email']; ?>">
                        <div class="invalid-feedback">
                            <i class="bx bx-radio-circle"></i>
                            <?= session('errors.email') ?>
                        </div>
                        <p><small class="text-muted">Contoh: example@gmail.com</small></p>
                    </div>

                    <div class="form-group mb-4">
                        <label for="nomor_hp">Nomor HP/WA <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <span class="input-group-text">+62</span>
                            <input type="number" class="form-control <?= session('errors.nomor_hp') ? 'is-invalid' : ''; ?>" id="nomor_hp" placeholder="Masukan Nomor HP" name="nomor_hp" value="<?= (old('nomor_hp')) ? old('nomor_hp') : $kontak['nomor_hp']; ?>">
                            <div class="invalid-feedback">
                                <i class="bx bx-radio-circle"></i>
                                <?= session('errors.nomor_hp') ?>
                            </div>
                        </div>
                        <p><small class="text-muted">Contoh: 81234567890</small></p>
                    </div>

                    <div class="divider">
                        <div class="divider-text fw-bold rounded">Media Sosial</div>
                    </div>

                    <div class="form-group mb-4">
                        <label for="instagram">Instagram (Boleh Kosong)</label>
                        <input type="text" class="form-control <?= session('errors.instagram') ? 'is-invalid' : ''; ?>" id="instagram" placeholder="Masukan URL Instagram" name="instagram" value="<?= (old('instagram')) ? old('instagram') : $kontak['instagram']; ?>">
                        <div class="invalid-feedback">
                            <i class="bx bx-radio-circle"></i>
                            <?= session('errors.instagram') ?>
                        </div>
                        <p><small class="text-muted">Contoh: https://www.instagram.com</small></p>
                    </div>

                    <div class="form-group mb-4">
                        <label for="facebook">Facebook (Boleh Kosong)</label>
                        <input type="text" class="form-control <?= session('errors.facebook') ? 'is-invalid' : ''; ?>" id="facebook" placeholder="Masukan URL Facebook" name="facebook" value="<?= (old('facebook')) ? old('facebook') : $kontak['facebook']; ?>">
                        <div class="invalid-feedback">
                            <i class="bx bx-radio-circle"></i>
                            <?= session('errors.facebook') ?>
                        </div>
                        <p><small class="text-muted">Contoh: https://www.facebook.com</small></p>
                    </div>

                    <div class="form-group mb-4">
                        <label for="twitter">Twitter/X (Boleh Kosong)</label>
                        <input type="text" class="form-control <?= session('errors.twitter') ? 'is-invalid' : ''; ?>" id="twitter" placeholder="Masukan URL Twitter/X" name="twitter" value="<?= (old('twitter')) ? old('twitter') : $kontak['twitter']; ?>">
                        <div class="invalid-feedback">
                            <i class="bx bx-radio-circle"></i>
                            <?= session('errors.twitter') ?>
                        </div>
                        <p><small class="text-muted">Contoh: https://www.twitter.com</small></p>
                    </div>

                    <div class="form-group mb-4">
                        <label for="tiktok">Tiktok (Boleh Kosong)</label>
                        <input type="text" class="form-control <?= session('errors.tiktok') ? 'is-invalid' : ''; ?>" id="tiktok" placeholder="Masukan URL Tiktok" name="tiktok" value="<?= (old('tiktok')) ? old('tiktok') : $kontak['tiktok']; ?>">
                        <div class="invalid-feedback">
                            <i class="bx bx-radio-circle"></i>
                            <?= session('errors.tiktok') ?>
                        </div>
                        <p><small class="text-muted">Contoh: https://www.tiktok.com</small></p>
                    </div>

                    <div class="form-group mb-4">
                        <label for="youtube">Youtube (Boleh Kosong)</label>
                        <input type="text" class="form-control <?= session('errors.youtube') ? 'is-invalid' : ''; ?>" id="youtube" placeholder="Masukan URL Youtube" name="youtube" value="<?= (old('youtube')) ? old('youtube') : $kontak['youtube']; ?>">
                        <div class="invalid-feedback">
                            <i class="bx bx-radio-circle"></i>
                            <?= session('errors.youtube') ?>
                        </div>
                        <p><small class="text-muted">Contoh: https://www.youtube.com</small></p>
                    </div>

                    <div class="row">
                        <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12">
                            <button type="submit" class="btn btn-primary w-100">Simpan</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>

<?= $this->endSection(); ?>