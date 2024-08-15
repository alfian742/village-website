<?= $this->extend('admin/layout/template'); ?>

<?= $this->section('content'); ?>

<section class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-body p-4">
                <div class="row align-items-center">
                    <div class="col-lg-8">

                        <div class="d-flex flex-wrap gap-2 mb-4">
                            <h4>Dashboard</h4>
                            <?php foreach ($situs as $site) : ?>
                                <h4><?= $site['nama_desa']; ?></h4>
                            <?php endforeach; ?>
                        </div>
                        <div class="d-flex flex-column">
                            <div class="d-flex align-items-center gap-3 mt-auto">
                                <img class="rounded-circle object-fit-cover" src="<?= base_url('img/staff/') . user()->user_img; ?>" alt="" height="84" width="84">
                                <div class="d-flex flex-column">
                                    <h5 class="text-clamp-1"><?= user()->fullname; ?></h5>
                                    <h6 class="text-clamp-1 text-uppercase">
                                        <?php
                                        if (user()->level == 'kepala desa') :
                                            echo 'kades/lurah';
                                        elseif (user()->level == 'kepala dusun') :
                                            echo 'kadus/kaling';
                                        else :
                                            echo user()->level;
                                        endif;
                                        ?>
                                    </h6>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 d-none d-lg-inline">
                        <div class="d-flex justify-content-end">
                            <img src="<?= base_url('assets/img/filing-system.svg'); ?>" alt="" height="168" width="168">
                        </div>
                    </div>
                    <?php if (user()->level == 'kepala dusun') : ?>
                        <div class="col-lg-12">
                            <div class="row justify-content-center mt-5">
                                <div class="col-lg-8">
                                    <div class="row g-lg-4 g-3">
                                        <div class="col-lg-6 col-md-6 col-sm-6">
                                            <a href="<?= base_url('dashboard/kewilayahan/dusun'); ?>" class="btn btn-lg text-start btn-primary rounded-4 w-100 fw-bold">
                                                <div class="d-flex justify-content-between align-items-center gap-2">
                                                    <img src="<?= base_url('assets/img/profiling.svg'); ?>" alt="" height="64" width="64">
                                                    Profil Wilayah
                                                </div>
                                            </a>
                                        </div>
                                        <div class="col-lg-6 col-md-6 col-sm-6">
                                            <a href="<?= base_url('dashboard/kewilayahan/data-dusun'); ?>" class="btn btn-lg text-start btn-primary rounded-4 w-100 fw-bold">
                                                <div class="d-flex justify-content-between align-items-center gap-2">
                                                    <img src="<?= base_url('assets/img/data-extraction.svg'); ?>" alt="" height="64" width="64">
                                                    Data Wilayah
                                                </div>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>

    <?php if (user()->level == 'super admin' || user()->level == 'admin' || user()->level == 'kepala desa' || user()->level == 'staff') : ?>
        <div class="col-6 col-lg-3 col-md-6">
            <div class="card">
                <div class="card-body px-4 py-4-5">
                    <div class="row">
                        <div class="col-md-4 col-lg-12 col-xl-12 col-xxl-5 d-flex justify-content-start ">
                            <div class="stats-icon purple mb-2">
                                <i class="iconly-boldPaper"></i>
                            </div>
                        </div>
                        <div class="col-md-8 col-lg-12 col-xl-12 col-xxl-7">
                            <h6 class="text-muted font-semibold">Berita</h6>
                            <h6 class="font-extrabold mb-0"><?= $beritaCount; ?></h6>
                        </div>
                    </div>
                    <div class="row mt-2">
                        <div class="col">
                            <small><?= 'Dilihat : ' . $totalBeritaViewers . '⨉' ?></small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-6 col-lg-3 col-md-6">
            <div class="card">
                <div class="card-body px-4 py-4-5">
                    <div class="row">
                        <div class="col-md-4 col-lg-12 col-xl-12 col-xxl-5 d-flex justify-content-start ">
                            <div class="stats-icon red mb-2">
                                <i class="iconly-boldChat"></i>
                            </div>
                        </div>
                        <div class="col-md-8 col-lg-12 col-xl-12 col-xxl-7">
                            <h6 class="text-muted font-semibold">Pegumuman</h6>
                            <h6 class="font-extrabold mb-0"><?= $pengumumanCount; ?></h6>
                        </div>
                    </div>
                    <div class="row mt-2">
                        <div class="col">
                            <small><?= 'Dilihat : ' . $totalPengumumanViewers . '⨉' ?></small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-6 col-lg-3 col-md-6">
            <div class="card">
                <div class="card-body px-4 py-4-5">
                    <div class="row">
                        <div class="col-md-4 col-lg-12 col-xl-12 col-xxl-5 d-flex justify-content-start ">
                            <div class="stats-icon green mb-2">
                                <i class="iconly-boldActivity"></i>
                            </div>
                        </div>
                        <div class="col-md-8 col-lg-12 col-xl-12 col-xxl-7">
                            <h6 class="text-muted font-semibold">Pariwisata</h6>
                            <h6 class="font-extrabold mb-0"><?= $pariwisataCount; ?></h6>
                        </div>
                    </div>
                    <div class="row mt-2">
                        <div class="col">
                            <small><?= 'Dilihat : ' . $totalPariwisataViewers . '⨉' ?></small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-6 col-lg-3 col-md-6">
            <div class="card">
                <div class="card-body px-4 py-4-5">
                    <div class="row">
                        <div class="col-md-4 col-lg-12 col-xl-12 col-xxl-5 d-flex justify-content-start ">
                            <div class="stats-icon blue mb-2">
                                <i class="iconly-boldBag"></i>
                            </div>
                        </div>
                        <div class="col-md-8 col-lg-12 col-xl-12 col-xxl-7">
                            <h6 class="text-muted font-semibold">UMKM</h6>
                            <h6 class="font-extrabold mb-0"><?= $umkmCount; ?></h6>
                        </div>
                    </div>
                    <div class="row mt-2">
                        <div class="col">
                            <small><?= 'Dilihat : ' . $totalUMKMViewers . '⨉' ?></small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-6 col-lg-6 col-md-6">
            <div class="card">
                <div class="card-body px-4 py-4-5">
                    <div class="row">
                        <div class="col-md-4 col-lg-3 col-xl-3 col-xxl-3 d-flex justify-content-start ">
                            <div class="stats-icon yellow mb-2">
                                <i class="iconly-boldBookmark"></i>
                            </div>
                        </div>
                        <div class="col-md-8 col-lg-9 col-xl-9 col-xxl-9">
                            <h6 class="text-muted font-semibold">Layanan</h6>
                            <h6 class="font-extrabold mb-0"><?= $layananCount; ?></h6>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-6 col-lg-6 col-md-6">
            <div class="card">
                <div class="card-body px-4 py-4-5">
                    <div class="row">
                        <div class="col-md-4 col-lg-3 col-xl-3 col-xxl-3 d-flex justify-content-start ">
                            <div class="stats-icon grey mb-2">
                                <i class="iconly-boldFolder"></i>
                            </div>
                        </div>
                        <div class="col-md-8 col-lg-9 col-xl-9 col-xxl-9">
                            <h6 class="text-muted font-semibold">Sarana & Prasarana</h6>
                            <h6 class="font-extrabold mb-0"><?= $saranaPrasaranaCount; ?></h6>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <?php endif; ?>

    <?php if (user()->level == 'kepala dusun') : ?>
        <div class="col-6 col-lg-6 col-md-6">
            <div class="card">
                <div class="card-body px-4 py-4-5">
                    <div class="row">
                        <div class="col-md-4 col-lg-12 col-xl-12 col-xxl-5 d-flex justify-content-start ">
                            <div class="stats-icon green mb-2">
                                <i class="iconly-boldActivity"></i>
                            </div>
                        </div>
                        <div class="col-md-8 col-lg-12 col-xl-12 col-xxl-7">
                            <h6 class="text-muted font-semibold">Pariwisata</h6>
                            <h6 class="font-extrabold mb-0"><?= $pariwisataCount; ?></h6>
                        </div>
                    </div>
                    <div class="row mt-2">
                        <div class="col">
                            <small><?= 'Dilihat : ' . $totalPariwisataViewers . '⨉' ?></small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-6 col-lg-6 col-md-6">
            <div class="card">
                <div class="card-body px-4 py-4-5">
                    <div class="row">
                        <div class="col-md-4 col-lg-12 col-xl-12 col-xxl-5 d-flex justify-content-start ">
                            <div class="stats-icon blue mb-2">
                                <i class="iconly-boldBag"></i>
                            </div>
                        </div>
                        <div class="col-md-8 col-lg-12 col-xl-12 col-xxl-7">
                            <h6 class="text-muted font-semibold">UMKM</h6>
                            <h6 class="font-extrabold mb-0"><?= $umkmCount; ?></h6>
                        </div>
                    </div>
                    <div class="row mt-2">
                        <div class="col">
                            <small><?= 'Dilihat : ' . $totalUMKMViewers . '⨉' ?></small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <?php endif; ?>
</section>

<?= $this->endSection(); ?>