<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\KontakModel;
use App\Models\LayananModel;
use App\Models\SitusModel;
use CodeIgniter\HTTP\ResponseInterface;

class Layanan extends BaseController
{
    protected $situsModel;
    protected $kontakModel;
    protected $layananModel;

    public function __construct()
    {
        $this->situsModel   = new SitusModel();
        $this->kontakModel  = new KontakModel();
        $this->layananModel = new LayananModel();
    }

    public function index()
    {
        $situs = $this->situsModel->findAll(1);

        if (empty($situs)) {
            return redirect()->to(base_url('404-not-found'));
        } else {
            // Ambil kata kunci pencarian dari form
            $keyword = $this->request->getVar('keyword');
            $layanan = [];

            if ($keyword) {
                // Lakukan pencarian jika ada kata kunci
                $layanan = $this->layananModel->like('nama_layanan', $keyword)
                    ->orLike('deskripsi', $keyword)
                    ->orderBy('nama_layanan', 'ASC')
                    ->paginate(6, 'layanan');

                // Jika tidak ada hasil ditemukan
                if (empty($layanan)) {
                    session()->setFlashdata('warning-message', "Tidak ada hasil yang ditemukan untuk pencarian \"$keyword\"");
                    return redirect()->to(base_url('layanan'));
                }
            } else {
                // Ambil semua layanan jika tidak ada kata kunci
                $layanan = $this->layananModel->orderBy('nama_layanan', 'ASC')->paginate(6, 'layanan');
            }

            $data = [
                'situs'     => $situs,
                'kontak'    => $this->kontakModel->find(1),
                'layanan'   => $layanan,
                'pager'     => $this->layananModel->pager,
                'title'     => 'Layanan',
            ];

            return view('user/layanan/index', $data);
        }
    }
}
