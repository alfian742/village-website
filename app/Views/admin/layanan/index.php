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
                        <a href="<?= base_url('layanan'); ?>" target="_blank" class="btn btn-outline-success icon"><i class="bi bi-eye d-md-none"></i><span class="d-none d-md-inline">Lihat Pratinjau</span></a>
                        <a href="<?= base_url('dashboard/layanan/create'); ?>" class="btn btn-primary icon"><i class="bi bi-plus-square d-md-none"></i><span class="d-none d-md-inline">Buat Baru</span></a>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <?= $this->include('admin/layout/alert-message'); ?>

                <div class="table-responsive">
                    <table class="table table-hover" id="myTable" data-order='[[0, "desc"]]'>
                        <thead>
                            <tr>
                                <th>Unggah</th>
                                <th>Penulis</th>
                                <th>Layanan</th>
                                <th>Deskripsi</th>
                                <th>Dilihat</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($layanan as $lyn) : ?>
                                <tr class="align-middle">
                                    <td class="text-nowrap"><?= date('d-m-Y H:i', strtotime($lyn['updated_at'])); ?></td>
                                    <td>
                                        <div class="text-clamp-2"><?= $lyn['penulis']; ?></div>
                                    </td>
                                    <td>
                                        <div class="text-clamp-2"><?= $lyn['nama_layanan']; ?></div>
                                    </td>
                                    <td>
                                        <div class="text-clamp-2"><?= implode(" ", array_slice(explode(" ", strip_tags($lyn['deskripsi'])), 0, 20)); ?></div>
                                    </td>
                                    <td class="text-nowrap"><?= $lyn['viewer'] . '⨉'; ?></td>
                                    <td>
                                        <div class="d-flex align-items-center gap-2">
                                            <a href="<?= base_url('dashboard/layanan/edit/') . $lyn['slug']; ?>" class="btn btn-primary icon"><i class="bi bi-pencil"></i></a>
                                            <form action="<?= base_url('dashboard/layanan/delete/') . $lyn['id']; ?>" method="post" class="d-inline">
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