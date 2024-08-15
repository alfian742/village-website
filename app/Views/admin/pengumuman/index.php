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
                        <a href="<?= base_url('pengumuman'); ?>" target="_blank" class="btn btn-outline-success icon"><i class="bi bi-eye d-md-none"></i><span class="d-none d-md-inline">Lihat Pratinjau</span></a>
                        <a href="<?= base_url('dashboard/pengumuman/create'); ?>" class="btn btn-primary icon"><i class="bi bi-plus-square d-md-none"></i><span class="d-none d-md-inline">Buat Baru</span></a>
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
                                <th>Judul</th>
                                <th>Deskripsi</th>
                                <th>Dilihat</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($pengumuman as $pgm) : ?>
                                <tr class="align-middle">
                                    <td class="text-nowrap"><?= date('d-m-Y H:i', strtotime($pgm['created_at'])); ?></td>
                                    <td>
                                        <div class="text-clamp-2"><?= $pgm['penulis']; ?></div>
                                    </td>
                                    <td>
                                        <div class="text-clamp-2"><?= $pgm['judul']; ?></div>
                                    </td>
                                    <td>
                                        <div class="text-clamp-2"><?= implode(" ", array_slice(explode(" ", strip_tags($pgm['deskripsi'])), 0, 20)); ?></div>
                                    </td>
                                    <td class="text-nowrap"><?= $pgm['viewer'] . '⨉'; ?></td>
                                    <td>
                                        <div class="d-flex align-items-center gap-2">
                                            <a href="<?= base_url('pengumuman/') . $pgm['slug']; ?>" target="_blank" class="btn btn-success icon"><i class="bi bi-eye"></i></a>
                                            <a href="<?= base_url('dashboard/pengumuman/edit/') . $pgm['slug']; ?>" class="btn btn-primary icon"><i class="bi bi-pencil"></i></a>
                                            <form action="<?= base_url('dashboard/pengumuman/delete/') . $pgm['id']; ?>" method="post" class="d-inline">
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