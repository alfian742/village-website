<?= $this->extend('user/layout/template'); ?>

<?= $this->section('content'); ?>

<section class="page-section" id="pageSection">
    <div class="container px-4">
        <h2 class="my-auto text-center mb-4"><?= $title; ?></h2>

        <div class="row justify-content-center g-4">
            <div class="col-lg-8">
                <div data-aos="fade-up" data-aos-duration="1000">
                    <div class="card rounded-4 m-0">
                        <div class="card-body p-0">
                            <div class="container p-4">
                                <div class="d-flex justify-content-center align-items-center">
                                    <span class="text-center rounded-circle fs-4 icon-wrapper icon-location"><i class="bi bi-geo-alt"></i></span>
                                </div>

                                <h4 class="text-center mt-2 mb-4">Lokasi</h4>

                                <div class="ratio ratio-4x3">
                                    <iframe src="https://maps.google.com/maps?q=<?= urlencode($geografis['lokasi']); ?>&hl=id&m=h&output=embed" class="rounded-4" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="row justify-content-center g-4">
                    <div class="col-lg-12">
                        <div data-aos="fade-up" data-aos-duration="1000">
                            <div class="card rounded-4 m-0">
                                <div class="card-body p-0">
                                    <div class="container p-4">
                                        <div class="d-flex justify-content-center align-items-center">
                                            <span class="text-center rounded-circle fs-4 icon-wrapper icon-email"><i class="bi bi-envelope"></i></span>
                                        </div>

                                        <h4 class="text-center my-2">Email</h4>

                                        <div class="d-flex justify-content-center align-items-center">
                                            <a href="mailto:<?= $kontak['email']; ?>" class="stretched-link"><?= $kontak['email']; ?></a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-12">
                        <div data-aos="fade-up" data-aos-duration="1000">
                            <div class="card rounded-4 m-0">
                                <div class="card-body p-0">
                                    <div class="container p-4">
                                        <div class="d-flex justify-content-center align-items-center">
                                            <span class="text-center rounded-circle fs-4 icon-wrapper icon-whatsapp"><i class="bi bi-whatsapp"></i></span>
                                        </div>

                                        <h4 class="text-center my-2">Nomor HP/WA</h4>

                                        <div class="d-flex justify-content-center align-items-center">
                                            <a href="<?= 'https://wa.me/+62' . $kontak['nomor_hp']; ?>" class="stretched-link"><?= '+62' . $kontak['nomor_hp']; ?></a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-12">
                        <div data-aos="fade-up" data-aos-duration="1000">
                            <div class="card rounded-4 m-0">
                                <div class="card-body p-0">
                                    <div class="container p-4">
                                        <h4 class="text-center mb-3">Media Sosial</h4>

                                        <div class="d-flex justify-content-center align-items-center gap-3">
                                            <?php if (!empty($kontak['instagram'])) : ?>
                                                <a class="d-flex justify-content-center align-items-center" href="<?= $kontak['instagram']; ?>" target="_blank">
                                                    <span class="text-center rounded-circle fs-4 icon-wrapper icon-instagram"><i class="bi bi-instagram"></i></span>
                                                </a>
                                            <?php endif; ?>
                                            <?php if (!empty($kontak['facebook'])) : ?>
                                                <a class="d-flex justify-content-center align-items-center" href="<?= $kontak['facebook']; ?>" target="_blank">
                                                    <span class="text-center rounded-circle fs-4 icon-wrapper icon-facebook"><i class="bi bi-facebook"></i></span>
                                                </a>
                                            <?php endif; ?>
                                            <?php if (!empty($kontak['twitter'])) : ?>
                                                <a class="d-flex justify-content-center align-items-center" href="<?= $kontak['twitter']; ?>" target="_blank">
                                                    <span class="text-center rounded-circle fs-4 icon-wrapper icon-twitter"><i class="bi bi-twitter-x"></i></span>
                                                </a>
                                            <?php endif; ?>
                                            <?php if (!empty($kontak['tiktok'])) : ?>
                                                <a class="d-flex justify-content-center align-items-center" href="<?= $kontak['tiktok']; ?>" target="_blank">
                                                    <span class="text-center rounded-circle fs-4 icon-wrapper icon-tiktok"><i class="bi bi-tiktok"></i></span>
                                                </a>
                                            <?php endif; ?>
                                            <?php if (!empty($kontak['youtube'])) : ?>
                                                <a class="d-flex justify-content-center align-items-center" href="<?= $kontak['youtube']; ?>" target="_blank">
                                                    <span class="text-center rounded-circle fs-4 icon-wrapper icon-youtube"><i class="bi bi-youtube"></i></span>
                                                </a>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<?= $this->endSection(); ?>