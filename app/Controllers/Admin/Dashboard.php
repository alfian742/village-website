<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\BeritaModel;
use App\Models\LayananModel;
use App\Models\PariwisataModel;
use App\Models\PengumumanModel;
use App\Models\SaranaPrasaranaModel;
use App\Models\SitusModel;
use App\Models\UMKMModel;
use CodeIgniter\HTTP\ResponseInterface;

class Dashboard extends BaseController
{
    protected $situsModel;
    protected $beritaModel;
    protected $layananModel;
    protected $pariwisataModel;
    protected $pengumumanModel;
    protected $saranaPrasaranaModel;
    protected $umkmModel;

    public function __construct()
    {
        $this->situsModel           = new SitusModel();
        $this->beritaModel          = new BeritaModel();
        $this->layananModel         = new LayananModel();
        $this->pariwisataModel      = new PariwisataModel();
        $this->pengumumanModel      = new PengumumanModel();
        $this->saranaPrasaranaModel = new SaranaPrasaranaModel();
        $this->umkmModel            = new UMKMModel();
    }

    public function index()
    {
        // Mendapatkan data situs
        $situs = $this->situsModel->findAll(1);

        if (empty($situs)) {
            return redirect()->to(base_url('404-not-found'));
        } else {
            // Menghitung jumlah entri dari setiap model
            $beritaCount = $this->beritaModel->countAll();
            $pariwisataCount = $this->pariwisataModel->countAll();
            $umkmCount = $this->umkmModel->countAll();
            $pengumumanCount = $this->pengumumanModel->countAll();
            $layananCount = $this->layananModel->countAll();
            $saranaPrasaranaCount = $this->saranaPrasaranaModel->countAll();

            // Menghitung total viewer dari setiap model
            $totalBeritaViewers = $this->beritaModel->selectSum('viewer')->first();
            $totalPariwisataViewers = $this->pariwisataModel->selectSum('viewer')->first();
            $totalPengumumanViewers = $this->pengumumanModel->selectSum('viewer')->first();
            $totalUMKMViewers = $this->umkmModel->selectSum('viewer')->first();

            // Menentukan jumlah viewer berdasarkan hasil query, jika tidak ada data maka defaultnya 0
            $totalBeritaViewers = $totalBeritaViewers['viewer'] ?? 0;
            $totalPariwisataViewers = $totalPariwisataViewers['viewer'] ?? 0;
            $totalPengumumanViewers = $totalPengumumanViewers['viewer'] ?? 0;
            $totalUMKMViewers = $totalUMKMViewers['viewer'] ?? 0;

            // Menyiapkan data untuk dikirimkan ke view
            $data = [
                'situs'                     => $situs,
                'beritaCount'               => $beritaCount,
                'layananCount'              => $layananCount,
                'pengumumanCount'           => $pengumumanCount,
                'pariwisataCount'           => $pariwisataCount,
                'saranaPrasaranaCount'      => $saranaPrasaranaCount,
                'umkmCount'                 => $umkmCount,
                'totalBeritaViewers'        => $totalBeritaViewers,
                'totalPariwisataViewers'    => $totalPariwisataViewers,
                'totalPengumumanViewers'    => $totalPengumumanViewers,
                'totalUMKMViewers'          => $totalUMKMViewers,
                'title'                     => 'Dashboard'
            ];

            return view('admin/dashboard/index', $data);
        }
    }
}
