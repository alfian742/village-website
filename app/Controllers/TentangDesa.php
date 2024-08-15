<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\KontakModel;
use App\Models\SitusModel;
use App\Models\TentangDesaModel;
use CodeIgniter\HTTP\ResponseInterface;

class TentangDesa extends BaseController
{
    protected $situsModel;
    protected $kontakModel;
    protected $tentangDesaModel;

    public function __construct()
    {
        $this->situsModel       = new SitusModel();
        $this->kontakModel      = new KontakModel();
        $this->tentangDesaModel = new TentangDesaModel();
    }

    public function index()
    {
        $situs = $this->situsModel->findAll(1);

        if (empty($situs)) {
            return redirect()->to(base_url('404-not-found'));
        } else {
            $data = [
                'situs'         => $situs,
                'kontak'        => $this->kontakModel->find(1),
                'tentang_desa'  => $this->tentangDesaModel->find(1),
                'title'         => 'Tentang',
            ];

            return view('user/profil-desa/index', $data);
        }
    }

    public function visiMisi()
    {
        $situs = $this->situsModel->findAll(1);

        if (empty($situs)) {
            return redirect()->to(base_url('404-not-found'));
        } else {
            $data = [
                'situs'         => $situs,
                'kontak'        => $this->kontakModel->find(1),
                'visi_misi'     => $this->tentangDesaModel->find(1),
                'title'         => 'Visi & Misi',
            ];

            return view('user/profil-desa/visi-misi', $data);
        }
    }
}
