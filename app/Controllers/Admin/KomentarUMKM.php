<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\KomentarBalasanUMKMModel;
use App\Models\KomentarUMKMModel;
use App\Models\SitusModel;
use App\Models\UMKMModel;
use CodeIgniter\HTTP\ResponseInterface;

class KomentarUMKM extends BaseController
{
    protected $situsModel;
    protected $umkmModel;
    protected $komentarUMKMModel;
    protected $komentarBalasanUMKMModel;

    public function __construct()
    {
        $this->situsModel                   = new SitusModel();
        $this->umkmModel                    = new UMKMModel();
        $this->komentarUMKMModel            = new KomentarUMKMModel();
        $this->komentarBalasanUMKMModel     = new KomentarBalasanUMKMModel();
    }

    public function index()
    {
        // Mendapatkan data situs
        $situs = $this->situsModel->findAll(1);

        if (empty($situs)) {
            return redirect()->to(base_url('404-not-found'));
        } else {
            $komentar = $this->komentarUMKMModel->orderBy('created_at', 'DESC')->findAll();

            foreach ($komentar as &$item) {
                $umkm = $this->umkmModel->find($item['umkm_id']);
                $item['nama_produk'] = $umkm ? $umkm['nama'] : 'Tidak Ada Nama Produk';
                $item['slug_umkm'] = $umkm ? $umkm['slug'] : '';
            }

            $data = [
                'situs'     => $situs,
                'komentar'  => $komentar,
                'title'     => 'Komentar UMKM',
            ];

            return view('admin/komentar-umkm/index', $data);
        }
    }

    public function delete($id)
    {
        // Temukan komentar UMKM berdasarkan ID
        $komentar = $this->komentarUMKMModel->find($id);

        // Periksa apakah komentar ditemukan
        if ($komentar) {
            // Ambil ID komentar UMKM
            $komentar_umkm_id = $komentar['id'];

            // Temukan balasan komentar yang terkait dengan komentar UMKM
            $balasanKomentar = $this->komentarBalasanUMKMModel->where('komentar_umkm_id', $komentar_umkm_id)->findAll();

            // Jika ada balasan komentar, hapus satu per satu
            if ($balasanKomentar) {
                foreach ($balasanKomentar as $balasan) {
                    $this->komentarBalasanUMKMModel->delete($balasan['id']);
                }
            }

            // Hapus komentar UMKM
            $delete = $this->komentarUMKMModel->delete($komentar_umkm_id);

            // Periksa apakah penghapusan berhasil
            if ($delete !== false) {
                // Jika berhasil, kembalikan ke halaman dengan pesan sukses
                return redirect()->to(base_url('dashboard/komentar-umkm'))->with('success-message', "Komentar berhasil dihapus.");
            } else {
                // Jika gagal, kembalikan ke halaman dengan pesan kesalahan
                return redirect()->to(base_url('dashboard/komentar-umkm'))->with('error-message', "Komentar gagal dihapus.");
            }
        }
    }
}
