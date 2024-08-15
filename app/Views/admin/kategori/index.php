<?= $this->extend('admin/layout/template'); ?>

<?= $this->section('content'); ?>

<section class="row">
    <div class="col-xl-4 col-lg-4 col-md-12 col-sm-12">
        <div class="card">
            <div class="card-header">
                <div class="d-flex justify-content-between align-items-center">
                    <h5 class="card-title my-auto">
                        Tambah <?= $title; ?>
                    </h5>
                </div>
            </div>
            <div class="card-body">
                <form action="<?= base_url('dashboard/kategori-berita/save'); ?>" method="post">
                    <?= csrf_field(); ?>

                    <div class="form-group mb-4">
                        <label for="kategori" class="form-label">Kategori Baru <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <input type="text" class="form-control <?= session('errors.kategori') ? 'is-invalid' : ''; ?>" id="kategori" placeholder="Masukan Kategori Baru" name="kategori" value="<?= old('kategori'); ?>">
                            <button type="submit" class="btn btn-primary rounded-end">Simpan</button>
                            <div class="invalid-feedback">
                                <i class="bx bx-radio-circle"></i>
                                <?= session('errors.kategori') ?>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="col-xl-8 col-lg-8 col-md-12 col-sm-12">
        <div class="card">
            <div class="card-header">
                <div class="d-flex justify-content-between align-items-center">
                    <h5 class="card-title my-auto">
                        <?= $title; ?>
                    </h5>
                    <div class="d-flex justify-content-end align-items-center gap-2">
                        <a href="<?= base_url('kategori-berita'); ?>" target="_blank" class="btn btn-outline-success icon"><i class="bi bi-eye d-md-none"></i><span class="d-none d-md-inline">Lihat Pratinjau</span></a>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <?= $this->include('admin/layout/alert-message'); ?>

                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Unggah</th>
                                <th>Kategori</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($kategori as $kgt) : ?>
                                <tr class="align-middle">
                                    <td class="text-nowrap"><?= date('d-m-Y H:i', strtotime($kgt['created_at'])); ?></td>
                                    <td>
                                        <div class="d-flex align-items-center gap-2">
                                            <form action="<?= base_url('dashboard/kategori-berita/update/') . $kgt['id']; ?>" method="post" class="w-max-content">
                                                <?= csrf_field(); ?>
                                                <div class="input-group" data-bs-toggle="tooltip" data-bs-title="Edit kategori">
                                                    <input type="text" class="form-control" id="edit_kategori" placeholder="Masukan Kategori" name="edit_kategori" value="<?= (old('edit_Kategori')) ? old('edit_Kategori') : $kgt['kategori']; ?>">
                                                    <button type="submit" class="btn btn-primary icon rounded-end"><i class="bi bi-pencil"></i></button>
                                                </div>
                                            </form>
                                            <form action="<?= base_url('dashboard/kategori-berita/delete/') . $kgt['id']; ?>" method="post" class="d-inline">
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

<?= $this->include('admin/layout/toast-message'); ?>


<?= $this->endSection(); ?>