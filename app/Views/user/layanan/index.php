<?= $this->extend('user/layout/template'); ?>

<?= $this->section('content'); ?>

<section class="page-section" id="pageSection">
    <div class="container px-4">
        <div class="row justify-content-center align-items-center g-4 mb-4">
            <div class="col-lg-6">
                <h2 class="my-auto text-lg-start text-center"><?= $title; ?></h2>
            </div>
            <div class="col-lg-6">
                <form action="<?= base_url('layanan') ?>" method="get">
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
            <?php if (empty($layanan)) : ?>
                <?= $this->include('user/layout/no-data-page'); ?>
            <?php else : ?>
                <?php foreach ($layanan as $lyn) : ?>
                    <div class="col-lg-4 col-md-6 col-sm-12 col-12">
                        <div class="card rounded-4">
                            <div class="card-content">
                                <div class="card-body">
                                    <h4 class="card-title text-clamp-1"><?= $lyn['nama_layanan']; ?></h4>

                                    <p class="card-text text-clamp-3"> <?= implode(" ", array_slice(explode(" ", strip_tags($lyn['deskripsi'])), 0, 20)); ?></p>

                                    <hr>

                                    <div class="d-flex justify-content-center align-items-center">
                                        <button class="btn btn-primary stretched-link w-100" type="button" data-bs-toggle="modal" data-bs-target="#modalLayanan<?= $lyn['id']; ?>">Selengkapnya</button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="modal fade px-3" id="modalLayanan<?= $lyn['id']; ?>" tabindex=" -1" role="dialog" aria-labelledby="modalLayananLabel<?= $lyn['id']; ?>" data-bs-backdrop="static" data-bs-keyboard="false" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-lg" role="document">
                                <div class="modal-content rounded-4">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="modalLayananLabel<?= $lyn['id']; ?>">
                                            Detail <?= $title; ?>
                                        </h5>
                                        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                                            <i data-feather="x"></i>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <h5 class="text-center mb-2"><?= $lyn['nama_layanan']; ?></h5>
                                        <h6 class="text-center mb-4"><span class="text-danger">*</span> Terakhir diperbarui pada <?= date('d F Y H:i', strtotime($lyn['updated_at'])); ?> WITA</h6>

                                        <article>
                                            <?= $lyn['deskripsi']; ?>
                                        </article>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-outline-primary" data-bs-dismiss="modal">
                                            Tutup
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>

        <?= $pager->links('layanan', 'pagination_page'); ?>
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