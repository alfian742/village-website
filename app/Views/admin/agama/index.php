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
                        <a href="<?= base_url('data-penduduk'); ?>" target="_blank" class="btn btn-outline-success icon"><i class="bi bi-eye d-md-none"></i><span class="d-none d-md-inline">Lihat Pratinjau</span></a>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <?= $this->include('admin/layout/alert-message'); ?>

                <form action="<?= base_url('dashboard/agama/update'); ?>" method="post">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>No.</th>
                                    <th>Agama</th>
                                    <th>Jumlah</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $i = 1;
                                foreach ($agama as $agm) :
                                ?>
                                    <tr class="align-middle">
                                        <td><?= $i++; ?></td>
                                        <td><?= $agm['agama']; ?></td>
                                        <td>
                                            <div class="w-max-content" data-bs-toggle="tooltip" data-bs-title="Edit jumlah data">
                                                <input type="hidden" name="id[]" value="<?= $agm['id']; ?>">
                                                <input type="number" class="form-control" placeholder="Masukan Data" name="jumlah[]" value="<?= (old('jumlah')) ? old('jumlah') : $agm['jumlah']; ?>">
                                                <small class="text-muted"><span class="text-danger">*</span> Boleh Kosong</small>
                                            </div>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                    <div class="d-flex justify-content-end align-items-center gap-2">
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>

<?= $this->include('admin/layout/toast-message'); ?>

<?= $this->endSection(); ?>