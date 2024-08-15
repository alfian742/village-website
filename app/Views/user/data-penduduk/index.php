<?= $this->extend('user/layout/template'); ?>

<?= $this->section('content'); ?>

<section class="page-section" id="pageSection">
    <div class="container px-4">
        <h2 class="my-auto text-center mb-4"><?= $title; ?></h2>

        <div class="row justify-content-center">
            <div class="col-lg-12">
                <div data-aos="fade-up" data-aos-duration="1000">
                    <div class="card rounded-4">
                        <div class="card-body p-0">
                            <div class="container p-4">
                                <h4 class="text-center mb-2">Data Agama</h4>
                                <h6 class="text-center mb-4"><span class="text-danger">*</span> Terakhir diperbarui pada <?= date('d F Y H:i', strtotime($update_agama['updated_at'])); ?> WITA</h6>

                                <div class="row justify-content-center">
                                    <div class="col-lg-6">
                                        <div class="table-responsive">
                                            <table class="table table-bordered table-hover">
                                                <thead class="table-primary text-center">
                                                    <tr>
                                                        <th>Agama</th>
                                                        <th>Jumlah</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                    $jumlahDataAgama = 0;
                                                    foreach ($agama as $agm) :
                                                    ?>
                                                        <tr class="align-middle">
                                                            <td><?= $agm['agama']; ?></td>
                                                            <td><?= $agm['jumlah']; ?></td>
                                                        </tr>
                                                    <?php
                                                        $jumlahDataAgama += $agm['jumlah'];
                                                    endforeach;
                                                    ?>
                                                </tbody>
                                                <tfoot>
                                                    <tr>
                                                        <th>Total</th>
                                                        <th><?= $jumlahDataAgama . ' Jiwa'; ?></th>
                                                    </tr>
                                                </tfoot>
                                            </table>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="border p-2">
                                            <div id="chart-agama"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-12">
                <div data-aos="fade-up" data-aos-duration="1000">
                    <div class="card rounded-4">
                        <div class="card-body p-0">
                            <div class="container p-4">
                                <h4 class="text-center mb-2">Data Usia</h4>
                                <h6 class="text-center mb-4"><span class="text-danger">*</span> Terakhir diperbarui pada <?= date('d F Y H:i', strtotime($update_usia['updated_at'])); ?> WITA</h6>

                                <div class="row justify-content-center">
                                    <div class="col-lg-6">
                                        <div class="table-responsive">
                                            <table class="table table-bordered table-hover">
                                                <thead class="table-primary text-center">
                                                    <tr>
                                                        <th>Usia</th>
                                                        <th>Jumlah</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                    $jumlahDataUsia = 0;
                                                    foreach ($usia as $usa) :
                                                    ?>
                                                        <tr class="align-middle">
                                                            <td><?= $usa['usia']; ?></td>
                                                            <td><?= $usa['jumlah']; ?></td>
                                                        </tr>
                                                    <?php
                                                        $jumlahDataUsia += $usa['jumlah'];
                                                    endforeach;
                                                    ?>
                                                </tbody>
                                                <tfoot>
                                                    <tr>
                                                        <th>Total</th>
                                                        <th><?= $jumlahDataUsia . ' Jiwa'; ?></th>
                                                    </tr>
                                                </tfoot>
                                            </table>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="border p-2">
                                            <div id="chart-usia"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-6">
                <div data-aos="fade-up" data-aos-duration="1000">
                    <div class="card rounded-4">
                        <div class="card-body p-0">
                            <div class="container p-4">
                                <h4 class="text-center mb-2">Data Pekerjaan</h4>
                                <h6 class="text-center mb-4"><span class="text-danger">*</span> Terakhir diperbarui pada <?= date('d F Y H:i', strtotime($update_pekerjaan['updated_at'])); ?> WITA</h6>

                                <div class="row justify-content-center">
                                    <div class="col-lg-12">
                                        <div class="table-responsive">
                                            <table class="table table-bordered table-hover">
                                                <thead class="table-primary text-center">
                                                    <tr>
                                                        <th>Pekerjaan</th>
                                                        <th>Jumlah</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                    $jumlahDataPekerjaan = 0;
                                                    foreach ($pekerjaan as $pkj) :
                                                    ?>
                                                        <tr class="align-middle">
                                                            <td><?= $pkj['pekerjaan']; ?></td>
                                                            <td><?= $pkj['jumlah']; ?></td>
                                                        </tr>
                                                    <?php
                                                        $jumlahDataPekerjaan += $pkj['jumlah'];
                                                    endforeach;
                                                    ?>
                                                </tbody>
                                                <tfoot>
                                                    <tr>
                                                        <th>Total</th>
                                                        <th><?= $jumlahDataPekerjaan . ' Jiwa'; ?></th>
                                                    </tr>
                                                </tfoot>
                                            </table>
                                        </div>
                                    </div>
                                    <div class="col-lg-12">
                                        <div class="border p-2">
                                            <div id="chart-pekerjaan"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-6">
                <div data-aos="fade-up" data-aos-duration="1000">
                    <div class="card rounded-4 m-0">
                        <div class="card-body p-0">
                            <div class="container p-4">
                                <h4 class="text-center mb-2">Data Jenis Kelamin</h4>
                                <h6 class="text-center mb-4"><span class="text-danger">*</span> Terakhir diperbarui pada <?= date('d F Y H:i', strtotime($update_jenis_kelamin['updated_at'])); ?> WITA</h6>

                                <div class="row justify-content-center">
                                    <div class="col-lg-12">
                                        <div class="table-responsive">
                                            <table class="table table-bordered table-hover">
                                                <thead class="table-primary text-center">
                                                    <tr>
                                                        <th>Jenis Kelamin</th>
                                                        <th>Jumlah</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                    $jumlahDataJenisKelamin = 0;
                                                    foreach ($jenis_kelamin as $jk) :
                                                    ?>
                                                        <tr class="align-middle">
                                                            <td><?= $jk['jenis_kelamin']; ?></td>
                                                            <td><?= $jk['jumlah']; ?></td>
                                                        </tr>
                                                    <?php
                                                        $jumlahDataJenisKelamin += $jk['jumlah'];
                                                    endforeach;
                                                    ?>
                                                </tbody>
                                                <tfoot>
                                                    <tr>
                                                        <th>Total</th>
                                                        <th><?= $jumlahDataJenisKelamin . ' Jiwa'; ?></th>
                                                    </tr>
                                                </tfoot>
                                            </table>
                                        </div>
                                    </div>
                                    <div class="col-lg-12">
                                        <div class="border p-2">
                                            <div id="chart-jenis-kelamin"></div>
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

<!-- Need: Apexcharts -->
<script src="https://cdn.jsdelivr.net/gh/zuramai/mazer@docs/demo/assets/extensions/apexcharts/apexcharts.min.js"></script>
<script>
    // Chart Agama
    var optionsChartAgama = {
        annotations: {
            position: "back",
        },
        dataLabels: {
            enabled: false,
        },
        chart: {
            type: "bar",
            width: "100%",
            height: "295px",
        },
        fill: {
            opacity: 1,
        },
        plotOptions: {},
        series: <?= json_encode($chart_data_agama['series']) ?>,
        colors: "#435ebe",
        xaxis: {
            categories: <?= json_encode($chart_data_agama['categories']) ?>,
        },
    }
    var chartChartAgama = new ApexCharts(
        document.querySelector("#chart-agama"),
        optionsChartAgama
    )
    chartChartAgama.render();

    // Chart Usia
    var optionsChartUsia = {
        annotations: {
            position: "back",
        },
        dataLabels: {
            enabled: false,
        },
        chart: {
            type: "bar",
            width: "100%",
            height: "295px",
        },
        fill: {
            opacity: 1,
        },
        plotOptions: {},
        series: <?= json_encode($chart_data_usia['series']) ?>,
        colors: "#435ebe",
        xaxis: {
            categories: <?= json_encode($chart_data_usia['categories']) ?>,
        },
    }
    var chartChartUsia = new ApexCharts(
        document.querySelector("#chart-usia"),
        optionsChartUsia
    )
    chartChartUsia.render();

    // Chart Pekerjaan
    var optionsChartPekerjaan = {
        annotations: {
            position: "back",
        },
        dataLabels: {
            enabled: false,
        },
        chart: {
            type: "bar",
            width: "100%",
            height: "295px",
        },
        fill: {
            opacity: 1,
        },
        plotOptions: {},
        series: <?= json_encode($chart_data_pekerjaan['series']) ?>,
        colors: "#435ebe",
        xaxis: {
            categories: <?= json_encode($chart_data_pekerjaan['categories']) ?>,
        },
    }
    var chartChartPekerjaan = new ApexCharts(
        document.querySelector("#chart-pekerjaan"),
        optionsChartPekerjaan
    )
    chartChartPekerjaan.render();

    // Chart Jenis Kelamin
    let optionsJenisKelamin = {
        series: <?= json_encode($chart_data_jenis_kelamin['series'][0]['data']) ?>,
        labels: <?= json_encode($chart_data_jenis_kelamin['categories']) ?>,
        colors: ["#435ebe", "#0dcaf0"],
        chart: {
            type: "donut",
            width: "100%",
            height: "282px",
        },
        legend: {
            position: "bottom",
        },
        plotOptions: {
            pie: {
                donut: {
                    size: "25%",
                },
            },
        },
    }
    var chartJenisKelamin = new ApexCharts(
        document.getElementById("chart-jenis-kelamin"),
        optionsJenisKelamin
    )
    chartJenisKelamin.render()
</script>

<?= $this->endSection(); ?>