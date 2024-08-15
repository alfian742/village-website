<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\AgamaModel;
use App\Models\JenisKelaminModel;
use App\Models\KontakModel;
use App\Models\PekerjaanModel;
use App\Models\SitusModel;
use App\Models\UsiaModel;
use CodeIgniter\HTTP\ResponseInterface;

class DataPenduduk extends BaseController
{
    protected $situsModel;
    protected $kontakModel;
    protected $agamaModel;
    protected $jenisKelaminModel;
    protected $pekerjaanModel;
    protected $usiaModel;

    public function __construct()
    {
        $this->situsModel           = new SitusModel();
        $this->kontakModel          = new KontakModel();
        $this->agamaModel           = new AgamaModel();
        $this->jenisKelaminModel    = new JenisKelaminModel();
        $this->pekerjaanModel       = new PekerjaanModel();
        $this->usiaModel            = new UsiaModel();
    }

    public function index()
    {
        $situs = $this->situsModel->findAll(1);

        if (empty($situs)) {
            return redirect()->to(base_url('404-not-found'));
        } else {
            // Chart
            $chartAgama         = $this->getDataChartAgama();
            $chartJenisKelamin  = $this->getDataChartJenisKelamin();
            $chartPekerjaan     = $this->getDataChartPekerjaan();
            $chartUsia          = $this->getDataChartUsia();

            // Mendapatkan data yang paling baru
            $updateAgama        = $this->agamaModel->orderBy('updated_at', 'DESC')->first();
            $updateJenisKelamin = $this->jenisKelaminModel->orderBy('updated_at', 'DESC')->first();
            $updatePekerjaan    = $this->pekerjaanModel->orderBy('updated_at', 'DESC')->first();
            $updateUsia         = $this->usiaModel->orderBy('updated_at', 'DESC')->first();

            $data = [
                'situs'                     => $situs,
                'kontak'                    => $this->kontakModel->find(1),
                'chart_data_agama'          => $chartAgama,
                'chart_data_jenis_kelamin'  => $chartJenisKelamin,
                'chart_data_pekerjaan'      => $chartPekerjaan,
                'chart_data_usia'           => $chartUsia,
                'update_agama'              => $updateAgama,
                'update_jenis_kelamin'      => $updateJenisKelamin,
                'update_pekerjaan'          => $updatePekerjaan,
                'update_usia'               => $updateUsia,
                'agama'                     => $this->agamaModel->findAll(),
                'jenis_kelamin'             => $this->jenisKelaminModel->findAll(),
                'pekerjaan'                 => $this->pekerjaanModel->findAll(),
                'usia'                      => $this->usiaModel->findAll(),
                'title'                     => 'Data Penduduk',
            ];

            return view('user/data-penduduk/index', $data);
        }
    }

    public function getDataChartAgama()
    {
        $agamaData = $this->agamaModel->findAll(); // Mengambil data dari model

        $categories = []; // Array untuk menyimpan kategori 
        $seriesData = []; // Array untuk menyimpan jumlah data 

        // Memproses data 
        foreach ($agamaData as $agama) {
            $categories[] = $agama['agama']; // Menambahkan nama ke array kategori
            $seriesData[] = (int) $agama['jumlah']; // Menambahkan jumlah ke array data series
        }

        // Menyiapkan data untuk ditampilkan dalam format yang sesuai dengan chart
        $chartData = [
            'categories' => $categories,
            'series' => [
                [
                    'name' => 'Jumlah',
                    'data' => $seriesData,
                ],
            ],
        ];

        return $chartData; // Mengembalikan data yang telah diproses
    }

    public function getDataChartJenisKelamin()
    {
        $jenisKelaminData = $this->jenisKelaminModel->findAll(); // Mengambil data dari model

        $categories = []; // Array untuk menyimpan kategori
        $seriesData = []; // Array untuk menyimpan jumlah data

        // Memproses data
        foreach ($jenisKelaminData as $jenisKelamin) {
            $categories[] = $jenisKelamin['jenis_kelamin']; // Menambahkan nama ke array kategori
            $seriesData[] = (int) $jenisKelamin['jumlah']; // Menambahkan jumlah ke array data series
        }

        // Menyiapkan data untuk ditampilkan dalam format yang sesuai dengan chart
        $chartData = [
            'categories' => $categories,
            'series' => [
                [
                    'name' => 'Jumlah',
                    'data' => $seriesData,
                ],
            ],
        ];

        return $chartData; // Mengembalikan data yang telah diproses
    }

    public function getDataChartPekerjaan()
    {
        $pekerjaanData = $this->pekerjaanModel->findAll(); // Mengambil data dari model

        $categories = []; // Array untuk menyimpan kategori 
        $seriesData = []; // Array untuk menyimpan jumlah data 

        // Memproses data 
        foreach ($pekerjaanData as $pekerjaan) {
            $categories[] = $pekerjaan['pekerjaan']; // Menambahkan nama ke array kategori
            $seriesData[] = (int) $pekerjaan['jumlah']; // Menambahkan jumlah ke array data series
        }

        // Menyiapkan data untuk ditampilkan dalam format yang sesuai dengan chart
        $chartData = [
            'categories' => $categories,
            'series' => [
                [
                    'name' => 'Jumlah',
                    'data' => $seriesData,
                ],
            ],
        ];

        return $chartData; // Mengembalikan data yang telah diproses
    }

    public function getDataChartUsia()
    {
        $usiaData = $this->usiaModel->findAll(); // Mengambil data dari model

        $categories = []; // Array untuk menyimpan kategori 
        $seriesData = []; // Array untuk menyimpan jumlah data 

        // Memproses data 
        foreach ($usiaData as $usia) {
            $categories[] = $usia['usia']; // Menambahkan nama ke array kategori
            $seriesData[] = (int) $usia['jumlah']; // Menambahkan jumlah ke array data series
        }

        // Menyiapkan data untuk ditampilkan dalam format yang sesuai dengan chart
        $chartData = [
            'categories' => $categories,
            'series' => [
                [
                    'name' => 'Jumlah',
                    'data' => $seriesData,
                ],
            ],
        ];

        return $chartData; // Mengembalikan data yang telah diproses
    }
}
