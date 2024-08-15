<?= $this->extend('user/layout/template'); ?>

<?= $this->section('content'); ?>

<?php if (empty($dusun) && empty($kepala_dusun)) : ?>
    <section class="page-section" id="pageSection">
        <div class="container px-4">
            <div class="row justify-content-center">
                <?= $this->include('user/layout/no-data-page'); ?>
            </div>
        </div>
    </section>
<?php else : ?>
    <section class="hero">
        <div class="card m-0">
            <img class="object-fit-cover" src="<?= base_url('img/dusun/') . $dusun['gambar']; ?>" alt="" height="464" />
            <div class="card-img-overlay bg-transparent p-0">
                <div class="bg-img-overlay-3 d-flex justify-content-center align-items-center p-2 h-100">
                    <div data-aos="fade-down" data-aos-duration="1000">
                        <h1 class="card-title text-center my-auto"><?= $dusun['nama_dusun']; ?></h1>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="page-section" style="margin-top: -84px;">
        <div class="container px-4 py-0">
            <div data-aos="fade-up" data-aos-duration="1000">
                <div class="card rounded-4 bg-glass">
                    <div class="card-body">
                        <div class="row justify-content-center align-items-center g-4 mb-4">
                            <div class="col-lg-2">
                                <div class="d-flex justify-content-center align-items-center">
                                    <div class="ratio ratio-1x1 img-container">
                                        <img class="rounded-circle object-fit-cover" src="<?= base_url('img/staff/') . $kepala_dusun['foto']; ?>" alt="" />
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-10">
                                <h5 class="card-title text-lg-start text-center"><?= $kepala_dusun['nama']; ?></h5>
                                <div class="d-flex flex-wrap justify-content-lg-start justify-content-center gap-1">
                                    <p class="card-text text-lg-start text-center fw-semibold mb-0">Pelaksana Kewilayahan</p>
                                    <p class="card-text text-lg-start text-center fw-semibold"><?= $dusun['nama_dusun']; ?></p>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col">
                                <article class="mb-4">
                                    <?= $dusun['deskripsi']; ?>
                                </article>

                                <div class="table-responsive mb-4">
                                    <table class="table table-borderless">
                                        <thead>
                                            <tr>
                                                <th colspan="4">Batas Wilayah</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr class="align-middle">
                                                <td style="width: 5rem;">Timur</td>
                                                <td style="width: 0.25rem;">:</td>
                                                <td class="text-nowrap"><?= $dusun['timur']; ?></td>
                                            </tr>
                                            <tr class="align-middle">
                                                <td style="width: 5rem;">Barat</td>
                                                <td style="width: 0.25rem;">:</td>
                                                <td class="text-nowrap"><?= $dusun['barat']; ?></td>
                                            </tr>
                                            <tr class="align-middle">
                                                <td style="width: 5rem;">Selatan</td>
                                                <td style="width: 0.25rem;">:</td>
                                                <td class="text-nowrap"><?= $dusun['selatan']; ?></td>
                                            </tr>
                                            <tr class="align-middle">
                                                <td style="width: 5rem;">Utara</td>
                                                <td style="width: 0.25rem;">:</td>
                                                <td class="text-nowrap"><?= $dusun['utara']; ?></td>
                                            </tr>
                                        </tbody>
                                        <tfoot>
                                            <tr class="align-middle">
                                                <th style="width: 5rem;">Luas</th>
                                                <th style="width: 0.25rem;">:</th>
                                                <th class="text-nowrap">
                                                    <?php
                                                    if (empty($dusun['luas'])) {
                                                        echo '-';
                                                    } else {
                                                        echo $dusun['luas'];
                                                    }
                                                    ?>
                                                </th>
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div>

                                <h5 class="text-center">Data Penduduk <?= $dusun['nama_dusun']; ?></h5>
                                <?php if (empty($data_terbaru['updated_at'])) : ?>
                                    <h6 class="text-center mb-4"></h6>
                                <?php else : ?>
                                    <h6 class="text-center mb-4"><span class="text-danger">*</span> Terakhir diperbarui pada <?= date('d F Y H:i', strtotime($data_terbaru['updated_at'])); ?> WITA</h6>
                                <?php endif; ?>

                                <div class="table-responsive mb-4">
                                    <table class="table table-bordered table-hover" id="myTable" data-order='[[0, "desc"]]'>
                                        <thead class="table-primary">
                                            <tr class="text-nowrap">
                                                <th>Tahun</th>
                                                <th>Bulan</th>
                                                <th>Kelahiran</th>
                                                <th>Kematian</th>
                                                <th>Penduduk Masuk</th>
                                                <th>Penduduk Keluar</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach ($data_dusun as $data_ds) : ?>
                                                <tr class="align-middle text-no-wrap">
                                                    <td class="text-nowrap"><span><?= date('Y', strtotime($data_ds['waktu'])); ?></span><span class="d-none"><?= '-' . date('m', strtotime($data_ds['waktu'])); ?></span></td>
                                                    <td class="text-nowrap"><span class="d-none"><?= date('Y-m', strtotime($data_ds['waktu'])); ?></span> <span><?= date('F', strtotime($data_ds['waktu'])); ?></span></td>
                                                    <td><?= $data_ds['jumlah_lahir'] . ' orang'; ?></td>
                                                    <td><?= $data_ds['jumlah_mati'] . ' orang'; ?></td>
                                                    <td><?= $data_ds['jumlah_masuk'] . ' orang'; ?></td>
                                                    <td><?= $data_ds['jumlah_keluar'] . ' orang'; ?></td>
                                                </tr>
                                            <?php endforeach; ?>
                                        </tbody>
                                    </table>
                                </div>

                                <div class="row justify-content-lg-end justify-content-center align-items-center">
                                    <div class="col-lg-3 col-md-4 col-sm-7 col-8">
                                        <a href="<?= base_url('data-kewilayahan'); ?>" class="btn btn-outline-primary w-100">Lihat Wilayah Lainnya</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
<?php endif; ?>

<?= $this->endSection(); ?>