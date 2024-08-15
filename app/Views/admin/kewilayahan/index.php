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
                        <a href="<?= base_url('data-kewilayahan/') . $dusun['slug']; ?>" target="_blank" class="btn btn-outline-success icon"><i class="bi bi-eye d-md-none"></i><span class="d-none d-md-inline">Lihat Pratinjau</span></a>
                        <a href="<?= base_url('dashboard/kewilayahan/data-dusun/create'); ?>" class="btn btn-primary icon"><i class="bi bi-plus-square d-md-none"></i><span class="d-none d-md-inline">Buat Baru</span></a>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <?= $this->include('admin/layout/alert-message'); ?>

                <div class="table-responsive">
                    <table class="table table-hover" id="myTable" data-order='[[1, "desc"]]'>
                        <thead>
                            <tr class="text-nowrap">
                                <th>Tahun</th>
                                <th>Bulan</th>
                                <th>Kelahiran</th>
                                <th>Kematian</th>
                                <th>Penduduk Masuk</th>
                                <th>Penduduk Keluar</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($data_dusun as $data_dsn) : ?>
                                <tr class="align-middle">
                                    <td class="text-nowrap"><span><?= date('Y', strtotime($data_dsn['waktu'])); ?></span><span class="d-none"><?= '-' . date('m', strtotime($data_dsn['waktu'])); ?></span></td>
                                    <td class="text-nowrap"><span class="d-none"><?= date('Y-m', strtotime($data_dsn['waktu'])); ?></span> <span><?= date('F', strtotime($data_dsn['waktu'])); ?></span></td>
                                    <td><?= $data_dsn['jumlah_mati'] . ' orang'; ?></td>
                                    <td><?= $data_dsn['jumlah_lahir'] . ' orang'; ?></td>
                                    <td><?= $data_dsn['jumlah_masuk'] . ' orang'; ?></td>
                                    <td><?= $data_dsn['jumlah_keluar'] . ' orang'; ?></td>
                                    <td>
                                        <div class="d-flex align-items-center gap-2">
                                            <a href="<?= base_url('dashboard/kewilayahan/data-dusun/edit/') . $data_dsn['id']; ?>" class="btn btn-primary icon"><i class="bi bi-pencil"></i></a>
                                            <form action="<?= base_url('dashboard/kewilayahan/data-dusun/delete/') . $data_dsn['id']; ?>" method="post" class="d-inline">
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