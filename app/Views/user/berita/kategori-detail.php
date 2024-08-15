<?= $this->extend('user/layout/template'); ?>

<?= $this->section('content'); ?>

<section class="page-section" id="pageSection">
    <div class="container px-4">
        <div class="row justify-content-between align-items-center g-4 mb-4">
            <div class="col-lg-6">
                <h2 class="my-auto text-lg-start text-center"><?= $title; ?></h2>
            </div>
            <div class="col-lg-6">
                <div class="d-flex justify-content-lg-end justify-content-center align-items-center">
                    <a href="<?= base_url('kategori-berita'); ?>">Lihat semua kategori</a>
                </div>
            </div>
        </div>

        <div class="row justify-content-center">
            <?php if (empty($berita)) : ?>
                <?= $this->include('user/layout/no-data-page'); ?>
            <?php else : ?>
                <?php foreach ($berita as $brt) : ?>
                    <div class="col-lg-4 col-md-6 col-sm-6 col-12">
                        <div class="card rounded-4">
                            <div class="card-content">
                                <div class="position-absolute top-0 left-0 z-3 tag-custom">
                                    <a class="text-bg-secondary tag-item-custom py-1 px-3" href="<?= base_url('kategori-berita/') . $brt['kategori_slug']; ?>"><?= $brt['kategori_berita']; ?></a>
                                </div>
                                <div class="ratio ratio-4x3">
                                    <img class="object-fit-cover rounded-top-4" src="<?= base_url('img/berita/') . $brt['gambar']; ?>" alt="<?= $brt['judul']; ?>" loading="lazy" />
                                </div>
                                <div class="card-body">
                                    <h4 class="card-title text-clamp-2"><?= $brt['judul']; ?></h4>

                                    <div class="d-flex gap-2 align-items-center card-subtitle mb-3">
                                        <span class="icon"><i class="bi bi-person-circle"></i></span>
                                        <span class="mt-1"><?= $brt['penulis']; ?></span>
                                    </div>

                                    <p class="card-text text-clamp-3"> <?= implode(" ", array_slice(explode(" ", strip_tags($brt['deskripsi'])), 0, 20)); ?></p>

                                    <hr>

                                    <div class="row justify-content-between align-items-center g-3">
                                        <div class="col-lg-8">
                                            <div class="d-flex gap-2 align-items-center text-muted my-auto">
                                                <small class="icon"><i class="bi bi-clock"></i></small>
                                                <small class="mt-1"><?= $brt['interval']; ?></small>
                                            </div>
                                        </div>
                                        <div class="col-lg-4">
                                            <a href="<?= base_url('berita/') . $brt['slug']; ?>" class="btn btn-primary w-100 stretched-link">Lihat</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>

        <?= $pager->links('berita', 'pagination_page'); ?>
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