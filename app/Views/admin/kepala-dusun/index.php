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
                    <div class="d-flex justify-content-end align-items-center gap-2">
                        <a href="<?= base_url('sotk'); ?>" target="_blank" class="btn btn-outline-success icon"><i class="bi bi-eye d-md-none"></i><span class="d-none d-md-inline">Lihat Pratinjau</span></a>
                        <a href="<?= base_url('dashboard/kepala-dusun/create'); ?>" class="btn btn-primary icon"><i class="bi bi-plus-square d-md-none"></i><span class="d-none d-md-inline">Buat Baru</span></a>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <?= $this->include('admin/layout/alert-message'); ?>

                <div class="table-responsive">
                    <table class="table table-hover" id="myTable" data-order='[[1, "asc"]]'>
                        <thead>
                            <tr>
                                <th>Foto</th>
                                <th>Nama</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($kepala_dusun as $kd) : ?>
                                <tr class="align-middle">
                                    <td><img src="<?= base_url('img/staff/') . $kd['foto']; ?>" class="object-fit-cover rounded-3" alt="..." width="52" height="52"></td>
                                    <td class="text-nowrap"><?= $kd['nama']; ?></td>
                                    <td>
                                        <div class="d-flex align-items-center gap-2">
                                            <a href="<?= base_url('dashboard/kepala-dusun/edit/') . $kd['staff_id']; ?>" class="btn btn-primary icon"><i class="bi bi-pencil"></i></a>
                                            <form action="<?= base_url('dashboard/kepala-dusun/delete/') . $kd['staff_id']; ?>" method="post" class="d-inline">
                                                <?= csrf_field(); ?>
                                                <input type="hidden" name="_method" value="DELETE">
                                                <button type="submit" class="btn btn-danger btn-delete icon"><i class="bi bi-trash"></i></button>
                                            </form>
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