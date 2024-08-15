<?= $this->extend('admin/layout/template'); ?>

<?= $this->section('content'); ?>

<section class="row">
    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12">
        <div class="card">
            <div class="card-header">
                <div class="d-flex justify-content-between align-items-center">
                    <h5 class="card-title my-auto">
                        Perbarui <?= $title; ?>
                    </h5>
                </div>
            </div>
            <div class="card-body">
                <form action="<?= base_url('dashboard/profil/update-data'); ?>" method="post" enctype="multipart/form-data">
                    <?= csrf_field(); ?>
                    <input type="hidden" name="user_img_old" value="<?= user()->user_img; ?>">
                    <input type="hidden" name="staff_id" value="<?= user()->staff_id; ?>">

                    <div class="row justify-content-center align-items-center">
                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12">
                            <div class="form-group mb-4">
                                <label for="gambar" class="ratio ratio-1x1" data-bs-toggle="tooltip" data-bs-title="Klik untuk unggah foto">
                                    <img class="rounded-4 object-fit-cover cursor-pointer form-img" src="<?= base_url('img/staff/') . user()->user_img; ?>" alt="...">
                                </label>
                                <input type="file" class="form-control d-none <?= session('errors.user_img') ? 'is-invalid' : ''; ?>" id="gambar" name="user_img" onchange="previewImage()" accept="image/jpeg, image/jpg, image/png" value="<?= user()->user_img; ?>">
                                <div class="invalid-feedback">
                                    <i class="bx bx-radio-circle"></i>
                                    <?= session('errors.user_img') ?>
                                </div>
                                <p class="d-flex flex-column gap-1 text-center mt-1">
                                    <small class="text-muted">Silahkan klik untuk mengunggah foto</small>
                                    <small class="text-muted"><span class="text-danger">*</span> Format gambar JPG/JPEG/PNG dan ukuran maksimal 1 MB</small>
                                </p>
                            </div>
                        </div>
                    </div>

                    <div class="form-group mb-4">
                        <label for="fullname">Nama Lengkap <span class="text-danger">*</span></label>
                        <input type="text" class="form-control <?= session('errors.fullname') ? 'is-invalid' : ''; ?>" id="fullname" placeholder="Masukan Nama Lengkap" name="fullname" value="<?= (old('fullname')) ? old('fullname') : user()->fullname; ?>">
                        <div class="invalid-feedback">
                            <i class="bx bx-radio-circle"></i>
                            <?= session('errors.fullname') ?>
                        </div>
                    </div>

                    <div class="form-group mb-4">
                        <label for="username">Nama Pengguna <span class="text-danger">*</span></label>
                        <input type="text" class="form-control <?= session('errors.username') ? 'is-invalid' : ''; ?>" id="username" placeholder="Masukan Nama Pengguna" name="username" value="<?= (old('username')) ? old('username') : user()->username; ?>">
                        <div class="invalid-feedback">
                            <i class="bx bx-radio-circle"></i>
                            <?= session('errors.username') ?>
                        </div>
                        <p><small class="text-muted">Contoh: user_abc, user123, user_adbc123</small></p>
                    </div>

                    <div class="form-group mb-4">
                        <label for="email">Email <span class="text-danger">*</span></label>
                        <input type="email" class="form-control <?= session('errors.email') ? 'is-invalid' : ''; ?>" id="email" placeholder="Masukan Email" name="email" value="<?= (old('email')) ? old('email') : user()->email; ?>">
                        <div class="invalid-feedback">
                            <i class="bx bx-radio-circle"></i>
                            <?= session('errors.email') ?>
                        </div>
                        <p><small class="text-muted">Contoh: example@gmail.com</small></p>
                    </div>

                    <div class="row g-2">
                        <div class="col-6">
                            <a href="<?= base_url('dashboard'); ?>" type="button" class="btn btn-danger w-100">Batal</a>
                        </div>
                        <div class="col-6">
                            <button type="submit" class="btn btn-primary w-100">Simpan</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12">
        <div class="card">
            <div class="card-header">
                <div class="d-flex justify-content-between align-items-center">
                    <h5 class="card-title my-auto">
                        Perbarui Kata Sandi
                    </h5>
                </div>
            </div>
            <div class="card-body">
                <form action="<?= base_url('dashboard/profil/update-password'); ?>" method="post">
                    <?= csrf_field(); ?>
                    <input type="hidden" name="staff_id" value="<?= user()->staff_id; ?>">

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
                            <a href="<?= base_url('dashboard'); ?>" type="button" class="btn btn-danger w-100">Batal</a>
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

<?= $this->include('admin/layout/toast-message'); ?>

<?= $this->endSection(); ?>