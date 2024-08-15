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
                        <a href="<?= base_url('data-kewilayahan'); ?>" target="_blank" class="btn btn-outline-success icon"><i class="bi bi-eye d-md-none"></i><span class="d-none d-md-inline">Lihat Pratinjau</span></a>
                        <a href="<?= base_url('dashboard/dusun/create'); ?>" class="btn btn-primary icon"><i class="bi bi-plus-square d-md-none"></i><span class="d-none d-md-inline">Buat Baru</span></a>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <?= $this->include('admin/layout/alert-message'); ?>

                <div class="table-responsive">
                    <table class="table table-hover" id="myTable" data-order='[[1, "asc"]]'>
                        <thead>
                            <tr class="text-nowrap">
                                <th>Gambar</th>
                                <th>Dusun/Lingkungan</th>
                                <th>Pelaksana</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($dusun as $dsn) : ?>
                                <tr class="align-middle">
                                    <td><img src="<?= base_url('img/dusun/') . $dsn['gambar']; ?>" class="object-fit-cover rounded-3" alt="" width="52" height="52"></td>
                                    <td>
                                        <div class="text-clamp-1"><?= $dsn['nama_dusun']; ?></div>
                                    </td>
                                    <td>
                                        <div class="text-clamp-1"><?= $dsn['kepala_dusun']; ?></div>
                                    </td>
                                    <td>
                                        <div class="d-flex align-items-center gap-2">
                                            <a href="<?= base_url('data-kewilayahan/') . $dsn['slug']; ?>" target="_blank" class="btn btn-success icon"><i class="bi bi-eye"></i></a>
                                            <a href="<?= base_url('dashboard/dusun/edit/') . $dsn['slug']; ?>" class="btn btn-primary icon"><i class="bi bi-pencil"></i></a>
                                            <form action="<?= base_url('dashboard/dusun/delete/') . $dsn['id']; ?>" method="post" class="d-inline">
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