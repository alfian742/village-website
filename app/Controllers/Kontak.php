<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\GeografisModel;
use App\Models\KontakModel;
use App\Models\SitusModel;
use CodeIgniter\HTTP\ResponseInterface;

class Kontak extends BaseController
{
    protected $situsModel;
    protected $kontakModel;
    protected $geografisModel;

    public function __construct()
    {
        $this->situsModel       = new SitusModel();
        $this->kontakModel      = new KontakModel();
        $this->geografisModel   = new GeografisModel();
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
                'geografis' => $this->geografisModel->find(1),
                'title'     => 'Kontak',
            ];

            return view('user/kontak/index', $data);
        }
    }
}
