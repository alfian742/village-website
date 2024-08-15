<?= $this->extend('user/layout/template'); ?>

<?= $this->section('content'); ?>

<section class="page-section" id="pageSection">
    <div class="container px-4">
        <?php if (empty($struktur_organisasi) && empty($perangkat_desa) && empty($dusun)) : ?>
            <div class="row justify-content-center align-items-center">
                <?= $this->include('user/layout/no-data-page'); ?>
            </div>
        <?php else : ?>
            <h2 class="text-center mb-2"><?= $title; ?></h2>
            <?php foreach ($situs as $site) : ?>
                <h5 class="text-center mb-4">Susunan Organisasi dan Tata Kerja Pemerintahan <?= $site['nama_desa']; ?></h5>
            <?php endforeach; ?>

            <div class="row justify-content-center align-items-center mb-5">
                <div class="col">
                    <div data-aos="zoom-in" data-aos-duration="1000">
                        <div class="ratio ratio-16x9">
                            <img class="rounded-4" src="<?= base_url('img/struktur-organisasi/') . $struktur_organisasi['gambar']; ?>" alt="..." loading="eager">
                        </div>
                    </div>
                </div>
            </div>

            <div class="row justify-content-center">
                <?php foreach ($perangkat_desa as $pd) : ?>
                    <div class="col-lg-3 col-md-6 col-sm-6 col-6">
                        <div data-aos="fade-up" data-aos-duration="1000">
                            <div class="card rounded-4 cursor-pointer zoom" data-bs-toggle="modal" data-bs-target="#modalPerangkatDesa<?= $pd['staff_id']; ?>">
                                <div class="card-content">
                                    <div class="ratio ratio-1x1">
                                        <img class="object-fit-cover rounded-top-4" src="<?= base_url('img/staff/') . $pd['foto']; ?>" alt="" loading="lazy" />
                                    </div>
                                    <div class="card-body p-3">
                                        <h5 class="card-title text-center text-clamp-1"><?= $pd['nama']; ?></h5>
                                        <p class="card-text text-center text-clamp-1 border-top pt-2"><?= $pd['jabatan']; ?></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal fade px-3" id="modalPerangkatDesa<?= $pd['staff_id']; ?>" tabindex=" -1" role="dialog" aria-labelledby="modalPerangkatDesaLabel<?= $pd['staff_id']; ?>" data-bs-backdrop="static" data-bs-keyboard="false" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-lg" role="document">
                                <div class="modal-content rounded-4">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="modalPerangkatDesaLabel<?= $pd['staff_id']; ?>">
                                            Detail
                                        </h5>
                                        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                                            <i data-feather="x"></i>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <p class="text-center mb-4"><span class="text-danger">*</span> Terakhir diperbarui pada <?= date('d F Y H:i', strtotime($pd['updated_at'])); ?> WITA</p>

                                        <div class="mb-4">
                                            <p class="mb-1">Nama:</p>
                                            <h6><?= $pd['nama']; ?></h6>
                                        </div>

                                        <div class="mb-4">
                                            <p class="mb-1">Jabatan:</p>
                                            <h6><?= $pd['jabatan']; ?></h6>
                                        </div>

                                        <div class="mb-4">
                                            <p class="mb-1">NIP:</p>
                                            <h6><?= (!empty($pd['nip'])) ? $pd['nip'] : '-'; ?></h6>
                                        </div>

                                        <div>
                                            <p class="mb-1">Keterangan:</p>
                                            <article>
                                                <?= (!empty($pd['deskripsi'])) ? $pd['deskripsi'] : '-'; ?>
                                            </article>
                                        </div>
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
                <?php foreach ($dusun as $ds) : ?>
                    <div class="col-lg-3 col-md-6 col-sm-6 col-6">
                        <div data-aos="fade-up" data-aos-duration="1000">
                            <div class="card rounded-4 cursor-pointer zoom" data-bs-toggle="modal" data-bs-target="#modalDusun<?= $ds['staff_id']; ?>">
                                <div class="card-content">
                                    <div class="ratio ratio-1x1">
                                        <img class="object-fit-cover rounded-top-4" src="<?= base_url('img/staff/') . $ds['foto']; ?>" alt="" loading="lazy" />
                                    </div>
                                    <div class="card-body p-3">
                                        <h5 class="card-title text-center text-clamp-1"><?= $ds['kepala_dusun']; ?></h5>
                                        <p class="card-text text-center text-clamp-1 border-top pt-2"><?= 'Pelaksana Kewilayahan ' . $ds['nama_dusun']; ?></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal fade px-3" id="modalDusun<?= $ds['staff_id']; ?>" tabindex=" -1" role="dialog" aria-labelledby="modalDusunLabel<?= $ds['staff_id']; ?>" data-bs-backdrop="static" data-bs-keyboard="false" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-lg" role="document">
                                <div class="modal-content rounded-4">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="modalPerangkatDesaLabel<?= $pd['staff_id']; ?>">
                                            Detail
                                        </h5>
                                        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                                            <i data-feather="x"></i>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <p class="text-center mb-4"><span class="text-danger">*</span> Terakhir diperbarui pada <?= date('d F Y H:i', strtotime($ds['updated_at'])); ?> WITA</p>

                                        <div class="mb-4">
                                            <p class="mb-1">Nama:</p>
                                            <h6><?= $ds['kepala_dusun']; ?></h6>
                                        </div>

                                        <div class="mb-4">
                                            <p class="mb-1">Jabatan:</p>
                                            <h6><?= 'Pelaksana Kewilayahan ' . $ds['nama_dusun']; ?></h6>
                                        </div>

                                        <div class="mb-4">
                                            <p class="mb-1">NIP:</p>
                                            <h6><?= (!empty($pd['nip'])) ? $pd['nip'] : '-'; ?></h6>
                                        </div>

                                        <div>
                                            <p class="mb-1">Keterangan:</p>
                                            <article>
                                                <?= (!empty($pd['deskripsi'])) ? $pd['deskripsi'] : '-'; ?>
                                            </article>
                                        </div>
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
            </div>
        <?php endif; ?>
    </div>
</section>

<?= $this->endSection(); ?>