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

                <div class="table-responsive">
                    <table class="table table-hover" id="myTable" data-order='[[1, "asc"]]'>
                        <thead>
                            <tr>
                                <th>Foto</th>
                                <th>Role</th>
                                <th>Nama Lengkap</th>
                                <th>Nama Pengguna</th>
                                <th>Email</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($users as $user) : ?>
                                <tr class="align-middle text-nowrap">
                                    <td><img src="<?= base_url('img/staff/') . $user->user_img; ?>" class="object-fit-cover rounded-circle" alt="" width="52" height="52"></td>
                                    <td>
                                        <div class="text-center text-sm">
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
                                    </td>
                                    <td><?= (empty($user->fullname)) ? '-' : $user->fullname; ?></td>
                                    <td><?= $user->username; ?></td>
                                    <td><?= $user->email; ?></td>
                                    <td>
                                        <div class="d-flex align-items-center gap-2">
                                            <a href="<?= base_url('dashboard/manage-user/edit-data/') . $user->staff_id; ?>" class="btn btn-purple icon" data-bs-toggle="tooltip" data-bs-title="Edit Data"><i class="bi bi-pencil"></i></a>
                                            <button type="button" class="btn btn-purple btn-reset icon" data-bs-toggle="tooltip" data-bs-title="Reset Kata Sandi" data-reset-url="<?= base_url('dashboard/manage-user/reset-password/') . $user->staff_id; ?>" data-reset-fullname="<?= strtoupper($user->fullname); ?>" data-reset-role="<?= strtoupper($user->level); ?>"><i class="bi bi-key"></i></button>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</section>

<?= $this->endSection(); ?>