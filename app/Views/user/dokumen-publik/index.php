<?= $this->extend('user/layout/template'); ?>

<?= $this->section('content'); ?>

<section class="page-section" id="pageSection">
    <div class="container px-4">
        <h2 class="my-auto text-center mb-4"><?= $title; ?></h2>

        <div class="row">
            <div class="col">
                <div data-aos="fade-up" data-aos-duration="1000">
                    <div class="card rounded-4 m-0">
                        <div class="card-body p-0">
                            <div class="container p-4">
                                <div class="table-responsive">
                                    <table class="table table-hover" id="myTable" data-order='[[0, "desc"]]'>
                                        <thead class="table-primary">
                                            <tr class="text-nowrap">
                                                <th>Di unggah</th>
                                                <th>Nama</th>
                                                <th>Tipe</th>
                                                <th>Ukuran</th>
                                                <th></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach ($dokumen_publik as $dokumen) : ?>
                                                <tr class="align-middle">
                                                    <td class="text-nowrap"><?= date('d-m-Y H:i', strtotime($dokumen['created_at'])); ?> WITA</td>
                                                    <td>
                                                        <div class="text-clamp-2"><?= $dokumen['nama']; ?></div>
                                                    </td>
                                                    <td>
                                                        <?php $extension = strtolower(pathinfo($dokumen['berkas'], PATHINFO_EXTENSION)); ?>
                                                        <?php if ($extension == 'pdf') : ?>
                                                            <div class="badge text-bg-danger">
                                                                <div class="d-flex align-items-center gap-2">
                                                                    <i class="bi bi-file-earmark-pdf"></i><span>PDF</span>
                                                                </div>
                                                            </div>
                                                        <?php elseif ($extension == 'doc') : ?>
                                                            <div class="badge text-bg-primary">
                                                                <div class="d-flex align-items-center gap-2">
                                                                    <i class="bi bi-file-earmark-word"></i><span>DOC</span>
                                                                </div>
                                                            </div>
                                                        <?php elseif ($extension == 'docx') : ?>
                                                            <div class="badge text-bg-primary">
                                                                <div class="d-flex align-items-center gap-2">
                                                                    <i class="bi bi-file-earmark-word"></i><span>DOCX</span>
                                                                </div>
                                                            </div>
                                                        <?php elseif ($extension == 'xls') : ?>
                                                            <div class="badge text-bg-success">
                                                                <div class="d-flex align-items-center gap-2">
                                                                    <i class="bi bi-file-earmark-excel"></i><span>XLS</span>
                                                                </div>
                                                            </div>
                                                        <?php elseif ($extension == 'xlsx') : ?>
                                                            <div class="badge text-bg-success">
                                                                <div class="d-flex align-items-center gap-2">
                                                                    <i class="bi bi-file-earmark-excel"></i><span>XLSX</span>
                                                                </div>
                                                            </div>
                                                        <?php elseif ($extension == 'ppt') : ?>
                                                            <div class="badge text-bg-warning">
                                                                <div class="d-flex align-items-center gap-2">
                                                                    <i class="bi bi-file-earmark-ppt"></i><span>PPT</span>
                                                                </div>
                                                            </div>
                                                        <?php elseif ($extension == 'pptx') : ?>
                                                            <div class="badge text-bg-warning">
                                                                <div class="d-flex align-items-center gap-2">
                                                                    <i class="bi bi-file-earmark-ppt"></i><span>PPTX</span>
                                                                </div>
                                                            </div>
                                                        <?php else : ?>
                                                            <div class="badge text-bg-secondary">
                                                                <div class="d-flex align-items-center gap-2">
                                                                    <i class="bi bi-file-earmark"></i><span>Tidak diketahui</span>
                                                                </div>
                                                            </div>
                                                        <?php endif; ?>
                                                    </td>
                                                    <td><?= $dokumen['ukuran']; ?></td>
                                                    <td>
                                                        <div class="d-flex align-items-center gap-2">
                                                            <a href="<?= base_url('dokumen/download/') . $dokumen['berkas']; ?>" class="btn btn-sm btn-success icon"><i class="bi bi-download"></i><span class="d-none d-md-inline ms-2">Unduh</span></a>
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
                </div>
            </div>
        </div>
    </div>
</section>

<?= $this->endSection(); ?>