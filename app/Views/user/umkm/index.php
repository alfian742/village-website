<?= $this->extend('user/layout/template'); ?>

<?= $this->section('content'); ?>

<section class="page-section" id="pageSection">
    <div class="container px-4">
        <div class="row justify-content-center align-items-center g-4 mb-4">
            <div class="col-lg-6">
                <h2 class="my-auto text-lg-start text-center"><?= $title; ?></h2>
            </div>
            <div class="col-lg-6">
                <form action="<?= base_url('umkm') ?>" method="get">
                    <?= csrf_field(); ?>
                    <div class="input-group rounded-pill">
                        <label for="keyword" class="input-group-text border-0 rounded-start-pill"><i class="bi bi-search ms-1" style="margin-bottom: 0.75rem;"></i></label>
                        <input type="search" class="form-control border-0" id="keyword" placeholder="Masukan Kata Kunci" name="keyword" autofocus>
                        <button type="submit" class="btn btn-primary icon rounded-end-pill px-4">Cari</button>
                    </div>
                </form>
            </div>
        </div>

        <?= $this->include('user/layout/alert-message'); ?>

        <div class="row justify-content-center">
            <?php if (empty($umkm)) : ?>
                <?= $this->include('user/layout/no-data-page'); ?>
            <?php else : ?>
                <?php foreach ($umkm as $umkms) : ?>
                    <div class="col-lg-4 col-md-6 col-sm-6 col-12">
                        <div class="card rounded-4">
                            <div class="card-content">
                                <div class="ratio ratio-4x3">
                                    <img class="object-fit-cover rounded-top-4" src="<?= base_url('img/umkm/') . $umkms['gambar']; ?>" alt="<?= $umkms['nama']; ?>" loading="lazy" />
                                </div>
                                <div class="card-body">
                                    <h4 class="card-title text-clamp-2"><?= $umkms['nama']; ?></h4>

                                    <div class="row align-items-center g-2">
                                        <div class="col-lg-6">
                                            <div class="d-flex gap-2 align-items-center card-subtitle">
                                                <span class="icon"><i class="bi bi-shop"></i></span>
                                                <span class="mt-1 text-clamp-1"><?= $umkms['pemilik']; ?></span>
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="d-flex gap-2 justify-content-lg-end justify-content-start align-items-center card-subtitle">
                                                <span class="icon"><i class="bi bi-tag"></i></span>
                                                <span class="mt-1"><?= 'Rp ' . number_format($umkms['harga'], 0, ',', '.'); ?></span>
                                            </div>
                                        </div>
                                    </div>

                                    <hr>

                                    <div class="row align-items-center g-3">
                                        <div class="col-lg-5 z-3">
                                            <div class="d-flex gap-3 gap-lg-2 align-items-center my-auto">
                                                <?php if (!empty($umkms['instagram'])) : ?>
                                                    <a href="<?= $umkms['instagram']; ?>" target="_blank" class="btn bg-instagram icon w-100"><i class="bi bi-instagram"></i></a>
                                                <?php endif; ?>
                                                <a href="<?= 'https://wa.me/+62' . $umkms['nomor_hp']; ?>" target="_blank" class="btn bg-whatsapp icon w-100"><i class="bi bi-whatsapp"></i><?= (!empty($umkms['instagram'])) ? '' : '<span class="ms-2 d-inline d-lg-none">Whatsapp</span>'; ?></a>
                                            </div>
                                        </div>
                                        <div class="col-lg-7 z-1">
                                            <a href="<?= base_url('umkm/') . $umkms['slug']; ?>" class="btn btn-primary w-100 stretched-link">Lihat Produk</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>

        <?= $pager->links('umkm', 'pagination_page'); ?>
    </div>
</section>

<script>
    // Pagination
    var paginationElement = document.querySelector('.pagination');
    window.onload = function() {
        removePaginationLGClass();
    };
    window.onresize = function() {
        removePaginationLGClass();
    };

    function removePaginationLGClass() {
        var windowWidth = window.innerWidth;

        if (windowWidth < 992) {
            paginationElement.classList.remove('pagination-lg');
        } else {
            paginationElement.classList.add('pagination-lg');
        }
    }
</script>

<?= $this->endSection(); ?>