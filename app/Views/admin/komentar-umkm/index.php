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
                    <table class="table table-hover" id="myTable" data-order='[[0, "desc"]]'>
                        <thead>
                            <tr class="text-nowrap">
                                <th>Unggah</th>
                                <th>Nama</th>
                                <th>Rating</th>
                                <th>Komentar</th>
                                <th>Nama Produk UMKM</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($komentar as $kmt) : ?>
                                <tr class="align-middle">
                                    <td class="text-nowrap"><?= date('d-m-Y H:i', strtotime($kmt['created_at'])); ?></td>
                                    <td>
                                        <div class="text-clamp-2"><?= $kmt['nama']; ?></div>
                                    </td>
                                    <td>
                                        <span class="d-none"><?= $kmt['rating']; ?></span>
                                        <?php
                                        $rating = '';

                                        if ($kmt['rating'] == 5) {
                                            $rating = '<span class="d-flex gap-1 text-warning" style="margin-bottom: 0.75rem">
                                                            <i class="bi bi-star-fill"></i>
                                                            <i class="bi bi-star-fill"></i>
                                                            <i class="bi bi-star-fill"></i>
                                                            <i class="bi bi-star-fill"></i>
                                                            <i class="bi bi-star-fill"></i>
                                                        </span>';
                                        } elseif ($kmt['rating'] == 4) {
                                            $rating = '<span class="d-flex gap-1 text-warning" style="margin-bottom: 0.75rem">
                                                            <i class="bi bi-star-fill"></i>
                                                            <i class="bi bi-star-fill"></i>
                                                            <i class="bi bi-star-fill"></i>
                                                            <i class="bi bi-star-fill"></i>
                                                            <i class="bi bi-star"></i>
                                                        </span>';
                                        } elseif ($kmt['rating'] == 3) {
                                            $rating = '<span class="d-flex gap-1 text-warning" style="margin-bottom: 0.75rem">
                                                            <i class="bi bi-star-fill"></i>
                                                            <i class="bi bi-star-fill"></i>
                                                            <i class="bi bi-star-fill"></i>
                                                            <i class="bi bi-star"></i>
                                                            <i class="bi bi-star"></i>
                                                        </span>';
                                        } elseif ($kmt['rating'] == 2) {
                                            $rating = '<span class="d-flex gap-1 text-warning" style="margin-bottom: 0.75rem">
                                                            <i class="bi bi-star-fill"></i>
                                                            <i class="bi bi-star-fill"></i>
                                                            <i class="bi bi-star"></i>
                                                            <i class="bi bi-star"></i>
                                                            <i class="bi bi-star"></i>
                                                        </span>';
                                        } elseif ($kmt['rating'] == 1) {
                                            $rating = '<span class="d-flex gap-1 text-warning" style="margin-bottom: 0.75rem">
                                                            <i class="bi bi-star-fill"></i>
                                                            <i class="bi bi-star"></i>
                                                            <i class="bi bi-star"></i>
                                                            <i class="bi bi-star"></i>
                                                            <i class="bi bi-star"></i>
                                                        </span>';
                                        } elseif ($kmt['rating'] == 0) {
                                            $rating = '<span class="d-flex gap-1 text-warning" style="margin-bottom: 0.75rem">
                                                            <i class="bi bi-star"></i>
                                                            <i class="bi bi-star"></i>
                                                            <i class="bi bi-star"></i>
                                                            <i class="bi bi-star"></i>
                                                            <i class="bi bi-star"></i>
                                                        </span>';
                                        } else {
                                            $rating = '<span class="text-clamp-1">Tidak ada rating</span>';
                                        }

                                        echo $rating;
                                        ?>
                                    </td>
                                    <td>
                                        <div class="text-clamp-2"><?= implode(" ", array_slice(explode(" ", strip_tags($kmt['deskripsi'])), 0, 20)); ?></div>
                                    </td>
                                    <td>
                                        <div class="text-clamp-2"><?= $kmt['nama_produk']; ?></div>
                                    </td>
                                    <td>
                                        <div class="d-flex align-items-center gap-2">
                                            <a href="<?= base_url('umkm/' . $kmt['slug_umkm']); ?>" target="_blank" class="btn btn-success icon"><i class="bi bi-eye"></i></a>
                                            <form action="<?= base_url('dashboard/komentar-umkm/delete/') . $kmt['id']; ?>" method="post" class="d-inline">
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