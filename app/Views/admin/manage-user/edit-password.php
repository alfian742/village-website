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
                <div class="d-flex align-items-center gap-3 mb-4">
                    <img class="rounded-circle border object-fit-cover" src="<?= base_url('img/staff/') . $user->user_img; ?>" alt="" height="64" width="64">
                    <div class="d-flex flex-column">
                        <h6 class="text-clamp-1"><?= $user->fullname; ?></h6>
                        <div class="text-sm text-clamp-1">
                            <?php if (empty($user->level)) : ?>
                                <span class="badge text-bg-secondary text-uppercase">Tidak ada role</span>
                            <?php else : ?>
                                <?php if ($user->level == 'super admin') : ?>
                                    <span class="badge text-bg-primary text-uppercase"><?= $user->level; ?></span>
                                <?php elseif ($user->level == 'admin') : ?>
                                    <span class="badge text-bg-primary text-uppercase"><?= $user->level; ?></span>
                                <?php elseif ($user->level == 'kepala desa') : ?>
                                    <span class="badge text-bg-success text-uppercase">Kades/Lurah</span>
                                <?php elseif ($user->level == 'kepala dusun') : ?>
                                    <span class="badge text-bg-warning text-uppercase">Kadus/Kaling</span>
                                <?php elseif ($user->level == 'staff') : ?>
                                    <span class="badge text-bg-warning text-uppercase"><?= $user->level; ?></span>
                                <?php endif; ?>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>

                <?= $this->include('admin/layout/alert-message'); ?>

                <form action="<?= base_url('dashboard/manage-user/update-password/') . $user->staff_id; ?>" method="post">
                    <?= csrf_field(); ?>
                    <div class="form-group mb-4">
                        <label for="password_hash">Kata Sandi Lama <span class="text-danger">*</span></label>
                        <input type="password" class="form-control <?= session('errors.password_hash') ? 'is-invalid' : ''; ?>" id="password_hash" placeholder="Masukan Kata Sandi Lama" name="password_hash" autocomplete="off">
                        <div class="invalid-feedback">
                            <i class="bx bx-radio-circle"></i>
                            <?= session('errors.password_hash') ?>
                        </div>
                    </div>

                    <div class="form-group mb-4">
                        <label for="password">Kata Sandi Baru <span class="text-danger">*</span></label>
                        <input type="password" class="form-control <?= session('errors.password') ? 'is-invalid' : ''; ?>" id="password" placeholder="Masukan Kata Sandi Baru" name="password" autocomplete="off">
                        <div class="invalid-feedback">
                            <i class="bx bx-radio-circle"></i>
                            <?= session('errors.password') ?>
                        </div>
                    </div>

                    <div class="form-group mb-4">
                        <label for="pass_confirm">Konfirmasi Kata Sandi Baru <span class="text-danger">*</span></label>
                        <input type="password" class="form-control <?= session('errors.pass_confirm') ? 'is-invalid' : ''; ?>" id="pass_confirm" placeholder="Masukan Konfirmasi Kata Sandi Baru" name="pass_confirm" autocomplete="off">
                        <div class="invalid-feedback">
                            <i class="bx bx-radio-circle"></i>
                            <?= session('errors.pass_confirm') ?>
                        </div>
                    </div>

                    <div class="row g-2">
                        <div class="col-6">
                            <a href="<?= base_url('dashboard/manage-user'); ?>" type="button" class="btn btn-danger w-100">Batal</a>
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