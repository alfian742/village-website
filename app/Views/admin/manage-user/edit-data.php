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

                <form action="<?= base_url('dashboard/manage-user/update-data/') . $user->staff_id; ?>" method="post" enctype="multipart/form-data">
                    <?= csrf_field(); ?>
                    <input type="hidden" name="user_img_old" value="<?= $user->user_img; ?>">

                    <div class="form-group mb-4">
                        <label for="fullname">Nama Lengkap <span class="text-danger">*</span></label>
                        <input type="text" class="form-control <?= session('errors.fullname') ? 'is-invalid' : ''; ?>" id="fullname" placeholder="Masukan Nama Lengkap" name="fullname" value="<?= (old('fullname')) ? old('fullname') : $user->fullname; ?>">
                        <div class="invalid-feedback">
                            <i class="bx bx-radio-circle"></i>
                            <?= session('errors.fullname') ?>
                        </div>
                    </div>

                    <div class="form-group mb-4">
                        <label for="username">Nama Pengguna <span class="text-danger">*</span></label>
                        <input type="text" class="form-control <?= session('errors.username') ? 'is-invalid' : ''; ?>" id="username" placeholder="Masukan Nama Pengguna" name="username" value="<?= (old('username')) ? old('username') : $user->username; ?>">
                        <div class="invalid-feedback">
                            <i class="bx bx-radio-circle"></i>
                            <?= session('errors.username') ?>
                        </div>
                        <p><small class="text-muted">Contoh: user_abc, user123, user_adbc123</small></p>
                    </div>

                    <div class="form-group mb-4">
                        <label for="email">Email <span class="text-danger">*</span></label>
                        <input type="email" class="form-control <?= session('errors.email') ? 'is-invalid' : ''; ?>" id="email" placeholder="Masukan Email" name="email" value="<?= (old('email')) ? old('email') : $user->email; ?>">
                        <div class="invalid-feedback">
                            <i class="bx bx-radio-circle"></i>
                            <?= session('errors.email') ?>
                        </div>
                        <p><small class="text-muted">Contoh: example@gmail.com</small></p>
                    </div>

                    <div class="form-group mb-4">
                        <label for="level" class="form-label">Role <span class="text-danger">*</span></label>
                        <select class="form-select <?= session('errors.level') ? 'is-invalid' : ''; ?>" id="level" name="level">
                            <?php if (user()->level == 'super admin') : ?>
                                <option value="super admin" <?= ($user->level == "super admin") ? 'selected' : ''; ?>>Super Admin</option>
                            <?php endif ?>
                            <option value="admin" <?= ($user->level == "admin") ? 'selected' : ''; ?>>Admin</option>
                            <option value="kepala desa" <?= ($user->level == "kepala desa") ? 'selected' : ''; ?>>Kades/Lurah</option>
                            <option value="staff" <?= ($user->level == "staff") ? 'selected' : ''; ?>>Staff</option>
                            <option value="kepala dusun" <?= ($user->level == "kepala dusun") ? 'selected' : ''; ?>>Kadus/Kaling</option>
                        </select>
                        <div class="invalid-feedback">
                            <i class="bx bx-radio-circle"></i>
                            <?= session('errors.level') ?>
                        </div>
                    </div>

                    <div class="row justify-content-center align-items-center">
                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12">
                            <div class="form-group mb-4">
                                <label for="gambar" class="ratio ratio-1x1" data-bs-toggle="tooltip" data-bs-title="Klik untuk unggah foto">
                                    <img class="rounded-4 object-fit-cover cursor-pointer form-img" src="<?= base_url('img/staff/') . $user->user_img; ?>" alt="...">
                                </label>
                                <input type="file" class="form-control d-none <?= session('errors.user_img') ? 'is-invalid' : ''; ?>" id="gambar" name="user_img" onchange="previewImage()" accept="image/jpeg, image/jpg, image/png" value="<?= $user->user_img; ?>">
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