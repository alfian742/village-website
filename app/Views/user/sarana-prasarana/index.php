<?= $this->extend('user/layout/template'); ?>

<?= $this->section('content'); ?>

<section class="page-section" id="pageSection">
    <div class="container px-4">
        <div class="row justify-content-center align-items-center g-4 mb-4">
            <div class="col-lg-6">
                <h2 class="my-auto text-lg-start text-center"><?= $title; ?></h2>
            </div>
            <div class="col-lg-6">
                <form action="<?= base_url('sarana-prasarana') ?>" method="get">
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
            <?php if (empty($sarana_prasarana)) : ?>
                <?= $this->include('user/layout/no-data-page'); ?>
            <?php else : ?>
                <?php foreach ($sarana_prasarana as $sp) : ?>
                    <div class="col-lg-4 col-md-6 col-sm-6 col-12">
                        <div class="card rounded-4">
                            <div class="card-content">
                                <div class="ratio ratio-4x3">
                                    <img class="object-fit-cover rounded-top-4" src="<?= base_url('img/sarana-prasarana/') . $sp['gambar']; ?>" alt="<?= $sp['nama']; ?>" loading="lazy" />
                                </div>
                                <div class="card-body">
                                    <h4 class="card-title text-clamp-1"><?= $sp['nama']; ?></h4>

                                    <p class="card-text text-clamp-3"> <?= implode(" ", array_slice(explode(" ", strip_tags($sp['deskripsi'])), 0, 20)); ?></p>

                                    <hr>

                                    <div class="row justify-content-between align-items-center g-3">
                                        <div class="col-lg-8">
                                            <div class="d-flex gap-2 align-items-center text-muted my-auto">
                                                <small class="icon"><i class="bi bi-clock"></i></small>
                                                <small class="mt-1"><?= $sp['interval']; ?></small>
                                            </div>
                                        </div>
                                        <div class="col-lg-4">
                                            <a href="<?= base_url('sarana-prasarana/') . $sp['slug']; ?>" class="btn btn-primary w-100 stretched-link">Lihat</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>

        <?= $pager->links('sarana-prasarana', 'pagination_page'); ?>
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