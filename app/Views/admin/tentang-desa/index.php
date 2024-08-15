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
                        <div class="dropdown">
                            <button class="btn btn-outline-success icon dropdown-toggle me-1" type="button" id="dropdownProfilDesa" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="bi bi-eye d-md-none"></i><span class="d-none d-md-inline">Lihat Pratinjau</span>
                            </button>
                            <div class="dropdown-menu" aria-labelledby="dropdownProfilDesa">
                                <a class="dropdown-item" href="<?= base_url('profil/tentang'); ?>" target="_blank">Tentang</a>
                                <a class="dropdown-item" href="<?= base_url('profil/visi-misi'); ?>" target="_blank">Visi & Misi</a>
                            </div>
                        </div>
                        <a href="<?= base_url('dashboard/tentang-desa/edit/') . $tentang_desa['id']; ?>" class="btn btn-primary icon"><i class="bi bi-pencil d-md-none"></i><span class="d-none d-md-inline">Edit</span></a>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <?= $this->include('admin/layout/alert-message'); ?>

                <div class="row">
                    <div class="col-12 mb-4">
                        <div class="divider">
                            <div class="divider-text fw-bold text-uppercase rounded">Tentang</div>
                        </div>
                        <article>
                            <?= $tentang_desa['tentang_desa']; ?>
                        </article>
                    </div>

                    <div class="col-xl-6 col-lg-6 mb-4">
                        <div class="divider">
                            <div class="divider-text fw-bold text-uppercase rounded">Visi</div>
                        </div>
                        <article>
                            <?= $tentang_desa['visi']; ?>
                        </article>
                    </div>

                    <div class="col-xl-6 col-lg-6">
                        <div class="divider">
                            <div class="divider-text fw-bold text-uppercase rounded">Misi</div>
                        </div>
                        <article>
                            <?= $tentang_desa['misi']; ?>
                        </article>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<?= $this->endSection(); ?>