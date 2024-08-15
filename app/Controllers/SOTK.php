<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\DusunModel;
use App\Models\KepalaDusunModel;
use App\Models\KontakModel;
use App\Models\PerangkatDesaModel;
use App\Models\SitusModel;
use App\Models\StrukturOrganisasiModel;
use CodeIgniter\HTTP\ResponseInterface;

class SOTK extends BaseController
{
    protected $situsModel;
    protected $koontakModel;
    protected $dusunModel;
    protected $kepalaDusunModel;
    protected $perangkatDesaModel;
    protected $strukturOrganisasiModel;

    public function __construct()
    {
        $this->situsModel               = new SitusModel();
        $this->koontakModel             = new KontakModel();
        $this->dusunModel               = new DusunModel();
        $this->kepalaDusunModel         = new KepalaDusunModel();
        $this->perangkatDesaModel       = new PerangkatDesaModel();
        $this->strukturOrganisasiModel  = new StrukturOrganisasiModel();
    }

    public function index()
    {
        $situs = $this->situsModel->findAll(1);

        if (empty($situs)) {
            return redirect()->to(base_url('404-not-found'));
        } else {
            $dusun = $this->dusunModel->orderBy('nama_dusun', 'ASC')->findAll();

            foreach ($dusun as &$item) {
                $kepalaDusun = $this->kepalaDusunModel->find($item['kepala_dusun_id']);
                $item['kepala_dusun']   = $kepalaDusun ? $kepalaDusun['nama'] : 'Tidak Ada';
                $item['staff_id']       = $kepalaDusun ? $kepalaDusun['staff_id'] : '-';
                $item['nip']            = $kepalaDusun ? $kepalaDusun['nip'] : '-';
                $item['deskripsi']      = $kepalaDusun ? $kepalaDusun['deskripsi'] : 'Tidak ada deskripsi';
                $item['foto']           = $kepalaDusun ? $kepalaDusun['foto'] : 'default.svg';
            }

            $data = [
                'situs'                 => $situs,
                'kontak'                => $this->koontakModel->find(1),
                'dusun'                 => $dusun,
                'perangkat_desa'        => $this->perangkatDesaModel->findAll(),
                'struktur_organisasi'   => $this->strukturOrganisasiModel->find(1),
                'title'                 => 'SOTK',
            ];

            return view('user/sotk/index', $data);
        }
    }
}
