<?= $this->extend('admin/layout/template'); ?>

<?= $this->section('content'); ?>

<section class="row">
    <div class="col">
        <div class="card">
            <div class="card-header">
                <div class="d-flex justify-content-between align-items-center">
                    <h5 class="card-title my-auto">
                        Unggah <?= $title; ?>
                    </h5>
                </div>
                <small class="text-muted">Format dokumen PDF/Word/Excel/PowerPoint dan ukuran maksimal 10 MB</small>
            </div>
            <div class="card-body">
                <form action="<?= base_url('dashboard/dokumen/save'); ?>" method="post" enctype="multipart/form-data">
                    <?= csrf_field(); ?>

                    <div class="row align-items-center g-2">
                        <div class="col-xl-6 col-lg-6 col-md-6">
                            <div class="form-group">
                                <label for="nama">Nama Dokumen <span class="text-danger">*</span></label>
                                <input type="text" class="form-control <?= session('errors.nama') ? 'is-invalid' : ''; ?>" id="nama" placeholder="Masukan Nama Dokumen" name="nama" value="<?= old('nama'); ?>">
                                <div class="invalid-feedback">
                                    <i class="bx bx-radio-circle"></i>
                                    <?= session('errors.nama') ?>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-6 col-lg-6 col-md-6">
                            <div class="form-group">
                                <label for="berkas">Dokumen <span class="text-danger">*</span></label>
                                <input type="file" class="form-control <?= session('errors.berkas') ? 'is-invalid' : ''; ?>" id="berkas" placeholder="Unggah Dokumen" name="berkas" accept=".pdf, .doc, .docx, .xls, .xlsx, .ppt, .pptx" value="<?= old('berkas'); ?>">
                                <div class="invalid-feedback">
                                    <i class="bx bx-radio-circle"></i>
                                    <?= session('errors.berkas') ?>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-4 col-lg-4 col-md-4">
                            <div class="row g-2">
                                <div class="col-6">
                                    <button type="reset" class="btn btn-danger w-100">Batal</button>
                                </div>
                                <div class="col-6">
                                    <button type="submit" class="btn btn-primary w-100">Simpan</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <div class="card">
            <div class="card-header">
                <div class="d-flex justify-content-between align-items-center">
                    <h5 class="card-title my-auto">
                        <?= $title; ?>
                    </h5>
                    <div class="d-flex justify-content-end align-items-center gap-2">
                        <a href="<?= base_url('dokumen'); ?>" target="_blank" class="btn btn-outline-success icon"><i class="bi bi-eye d-md-none"></i><span class="d-none d-md-inline">Lihat Pratinjau</span></a>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <?= $this->include('admin/layout/alert-message'); ?>

                <div class="table-responsive">
                    <table class="table table-hover" id="myTable" data-order='[[0, "desc"]]'>
                        <thead>
                            <tr class="text-nowrap">
                                <th>Unggah</th>
                                <th>Nama</th>
                                <th>Tipe</th>
                                <th>Ukuran</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($dokumen as $dkm) : ?>
                                <tr class="align-middle">
                                    <td class="text-nowrap"><?= date('d-m-Y H:i', strtotime($dkm['created_at'])); ?></td>
                                    <td>
                                        <div class="text-clamp-2"><?= $dkm['nama']; ?></div>
                                    </td>
                                    <td>
                                        <?php $extension = strtolower(pathinfo($dkm['berkas'], PATHINFO_EXTENSION)); ?>
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
                                    <td><?= $dkm['ukuran']; ?></td>
                                    <td>
                                        <div class="d-flex align-items-center gap-2">
                                            <a href="<?= base_url('dashboard/dokumen/download/') . $dkm['berkas']; ?>" class="btn btn-success icon"><i class="bi bi-download"></i></a>
                                            <form action="<?= base_url('dashboard/dokumen/delete/') . $dkm['id']; ?>" method="post" class="d-inline">
                                                <?= csrf_field(); ?>
                                                <input type="hidden" name="_method" value="DELETE">
                                                <button type="submit" class="btn btn-danger btn-delete icon"><i class="bi bi-trash"></i></button>
                                            </form>
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
</section>

<?= $this->endSection(); ?>