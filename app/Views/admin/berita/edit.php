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
                </div>
            </div>
            <div class="card-body">
                <?= $this->include('admin/layout/alert-message'); ?>

                <form action="<?= base_url('dashboard/berita/update/') . $berita['slug']; ?>" method="post" enctype="multipart/form-data">
                    <div class="row">
                        <div class="col-xl-8 col-lg-7 col-md-6">
                            <?= csrf_field(); ?>
                            <input type="hidden" name="gambarLama" value="<?= $berita['gambar']; ?>">

                            <div class="form-group mb-4">
                                <label for="judul">Judul <span class="text-danger">*</span></label>
                                <input type="text" class="form-control <?= session('errors.judul') ? 'is-invalid' : ''; ?>" id="judul" placeholder="Masukan Judul" name="judul" value="<?= (old('judul')) ? old('judul') : $berita['judul']; ?>">
                                <div class="invalid-feedback">
                                    <i class="bx bx-radio-circle"></i>
                                    <?= session('errors.judul') ?>
                                </div>
                            </div>

                            <div class="form-group mb-4">
                                <label for="deskripsi" class="form-label">Isi Berita <span class="text-danger">*</span></label>
                                <textarea class="form-control cke-editor-form <?= session('errors.deskripsi') ? 'is-invalid' : ''; ?>" id="deskripsi" placeholder="Masukan Isi Berita" name="deskripsi" rows="4"><?= (old('deskripsi')) ? old('deskripsi') : $berita['deskripsi']; ?></textarea>
                                <div class="invalid-feedback">
                                    <i class="bx bx-radio-circle"></i>
                                    <?= session('errors.deskripsi') ?>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12">
                                    <div class="form-group mb-4">
                                        <label for="kategori_id" class="form-label">Kategori <span class="text-danger">*</span></label>
                                        <select class="form-select <?= session('errors.kategori_id') ? 'is-invalid' : ''; ?>" id="kategori_id" name="kategori_id">
                                            <?php
                                            $kategoriFound = false;

                                            // Loop pertama: Tampilkan kategori yang cocok dengan berita
                                            foreach ($kategori as $ktg) :
                                                if ($berita['kategori_id'] === $ktg['id']) :
                                                    echo "<option value='{$ktg['id']}'" . (old('kategori_id') == $ktg['id'] ? ' selected' : '') . ">{$ktg['kategori']}</option>";
                                                    $kategoriFound = true;
                                                endif;
                                            endforeach;

                                            // Jika tidak ada kategori yang cocok, tambahkan opsi "Tidak ada kategori"
                                            if (!$kategoriFound && $berita['kategori_id'] !== 0) {
                                                echo "<option value='0'" . (old('kategori_id') == 0 ? ' selected' : '') . ">Tidak ada kategori</option>";
                                            }

                                            // Loop kedua: Tampilkan kategori lainnya (kecuali yang telah dipilih sebelumnya)
                                            foreach ($kategori as $ktg) :
                                                if ($berita['kategori_id'] !== $ktg['id']) :
                                                    echo "<option value='{$ktg['id']}'" . (old('kategori_id') == $ktg['id'] ? ' selected' : '') . ">{$ktg['kategori']}</option>";
                                                endif;
                                            endforeach;
                                            ?>
                                        </select>

                                        <div class="invalid-feedback">
                                            <i class="bx bx-radio-circle"></i>
                                            <?= session('errors.kategori_id') ?>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12">
                                    <div class="form-group mb-4">
                                        <label for="status" class="form-label">Status <span class="text-danger">*</span></label>
                                        <select class="form-select <?= session('errors.status') ? 'is-invalid' : ''; ?>" id="status" name="status">
                                            <option value="Publish" <?= ($berita['status'] == "Publish") ? 'selected' : ''; ?>>Publish</option>
                                            <option value="Draft" <?= ($berita['status'] == "Draft") ? 'selected' : ''; ?>>Draft</option>
                                        </select>
                                        <div class="invalid-feedback">
                                            <i class="bx bx-radio-circle"></i>
                                            <?= session('errors.status') ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-xl-4 col-lg-5 col-md-6">
                            <div class="form-group mb-4">
                                <label for="gambar" class="ratio ratio-4x3" data-bs-toggle="tooltip" data-bs-title="Klik untuk unggah gambar">
                                    <img class="rounded-4 object-fit-cover cursor-pointer form-img" src="<?= base_url('img/berita/') . $berita['gambar']; ?>" alt="...">
                                </label>
                                <input type="file" class="form-control d-none <?= session('errors.gambar') ? 'is-invalid' : ''; ?>" id="gambar" name="gambar" onchange="previewImage()" accept="image/jpeg, image/jpg, image/png" value="<?= $berita['gambar']; ?>">
                                <div class="invalid-feedback text-center">
                                    <i class="bx bx-radio-circle"></i>
                                    <?= session('errors.gambar') ?>
                                </div>
                                <p class="d-flex flex-column gap-1 text-center mt-1">
                                    <small class="text-muted">Silahkan klik untuk mengunggah gambar</small>
                                    <small class="text-muted"><span class="text-danger">*</span> Format gambar JPG/JPEG/PNG dan ukuran maksimal 1 MB</small>
                                </p>
                            </div>

                            <div class="row g-2">
                                <div class="col-6">
                                    <a href="<?= base_url('dashboard/berita'); ?>" type="button" class="btn btn-danger w-100">Batal</a>
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
    </div>
</section>

<?= $this->endSection(); ?>