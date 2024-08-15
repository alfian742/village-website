<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\DokumenPublikModel;
use App\Models\KontakModel;
use App\Models\SitusModel;
use CodeIgniter\HTTP\ResponseInterface;

class DokumenPublik extends BaseController
{
    protected $situsModel;
    protected $kontakModel;
    protected $dokumenPublikModel;

    public function __construct()
    {
        $this->situsModel           = new SitusModel();
        $this->kontakModel          = new KontakModel();
        $this->dokumenPublikModel   = new DokumenPublikModel();
    }

    public function index()
    {
        $situs = $this->situsModel->findAll(1);

        if (empty($situs)) {
            return redirect()->to(base_url('404-not-found'));
        } else {
            $data = [
                'situs'             => $situs,
                'kontak'            => $this->kontakModel->find(1),
                'dokumen_publik'    => $this->dokumenPublikModel->orderBy('created_at', 'DESC')->findAll(),
                'title'             => 'Dokumen Publik',
            ];

            return view('user/dokumen-publik/index', $data);
        }
    }

    public function download($berkas)
    {
        $dokumen = $this->dokumenPublikModel->where('berkas', $berkas)->first();

        if (empty($dokumen)) {
            // Dokumen tidak ditemukan, redirect ke halaman lain atau tampilkan pesan error
            return redirect()->to(base_url('dokumen-publik'))->with('warning-message', "Dokumen tidak ditemukan.");
        }

        // Path lengkap ke file dokumen
        $filePath = 'doc/uploads/' . $dokumen['berkas'];

        // Pastikan file dokumen ada
        if (!file_exists($filePath)) {
            // File tidak ditemukan, redirect ke halaman lain atau tampilkan pesan error
            return redirect()->to(base_url('dokumen-publik'))->with('warning-message', "File dokumen tidak ditemukan.");
        }

        // Unduh file
        return $this->response->download($filePath, null);
    }
}
