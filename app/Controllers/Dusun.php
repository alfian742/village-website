<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\DataDusunModel;
use App\Models\DusunModel;
use App\Models\KepalaDusunModel;
use App\Models\KontakModel;
use App\Models\SitusModel;
use CodeIgniter\HTTP\ResponseInterface;

class Dusun extends BaseController
{
    protected $situsModel;
    protected $kontakModel;
    protected $dusunModel;
    protected $dataDusunModel;
    protected $kepalaDusunModel;

    public function __construct()
    {
        $this->situsModel       = new SitusModel();
        $this->kontakModel      = new KontakModel();
        $this->dataDusunModel   = new DataDusunModel();
        $this->dusunModel       = new DusunModel();
        $this->kepalaDusunModel = new KepalaDusunModel();
    }

    private function getSlug($slug)
    {
        return $this->dusunModel->where('slug', $slug)->first();
    }

    public function index()
    {
        $situs = $this->situsModel->findAll(1);

        if (empty($situs)) {
            return redirect()->to(base_url('404-not-found'));
        } else {
            $data = [
                'situs'     => $situs,
                'kontak'    => $this->kontakModel->find(1),
                'dusun'     => $this->dusunModel->orderBy('nama_dusun', 'ACS')->findAll(),
                'title'     => 'Data Kewilayahan',
            ];

            return view('user/dusun/index', $data);
        }
    }

    public function detail($slug)
    {
        $situs = $this->situsModel->findAll(1);

        if (empty($situs)) {
            return redirect()->to(base_url('404-not-found'));
        } else {
            $dusun = $this->getSlug($slug);

            if (!$dusun) {
                return redirect()->to('dusun')->with('warning-message', "Data tidak ditemukan.");
            } else {
                $kepalaDusun = $this->kepalaDusunModel->find($dusun['kepala_dusun_id']);
                $dataDusun = $this->dataDusunModel->where('dusun_id', $dusun['id'])->orderBy('waktu', 'DESC')->findAll();

                // Mengurutkan data_dusun berdasarkan updated_at dengan urutan descending
                usort($dataDusun, function ($a, $b) {
                    return strtotime($b['updated_at']) - strtotime($a['updated_at']);
                });

                // Mengambil data_dusun yang pertama setelah diurutkan (data dengan updated_at terbaru)
                $dataTerbaru = reset($dataDusun);

                // Pastikan kepala dusun dan data dusun tidak hilang (null) dari array data yang akan dilewatkan ke view
                $kepalaDusun = $kepalaDusun ?? null;
                $dataDusun = $dataDusun ?? null;

                $data = [
                    'situs'         => $situs,
                    'kontak'        => $this->kontakModel->find(1),
                    'data_dusun'    => $dataDusun,
                    'data_terbaru'  => $dataTerbaru,
                    'dusun'         => $dusun,
                    'kepala_dusun'  => $kepalaDusun,
                    'title'         => $dusun['nama_dusun'],
                ];

                return view('user/dusun/detail', $data);
            }
        }
    }
}
