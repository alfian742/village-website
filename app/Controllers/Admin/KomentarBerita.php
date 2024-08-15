<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\BeritaModel;
use App\Models\KomentarBalasanBeritaModel;
use App\Models\KomentarBeritaModel;
use App\Models\SitusModel;
use CodeIgniter\HTTP\ResponseInterface;

class KomentarBerita extends BaseController
{
    protected $situsModel;
    protected $beritaModel;
    protected $komentarBeritaModel;
    protected $komentarBalasanBeritaModel;

    public function __construct()
    {
        $this->situsModel                   = new SitusModel();
        $this->beritaModel                  = new BeritaModel();
        $this->komentarBeritaModel          = new KomentarBeritaModel();
        $this->komentarBalasanBeritaModel   = new KomentarBalasanBeritaModel();
    }

    public function index()
    {
        // Mendapatkan data situs
        $situs = $this->situsModel->findAll(1);

        if (empty($situs) || user()->level == 'kepala dusun') {
            return redirect()->to(base_url('404-not-found'));
        } else {
            $komentar = $this->komentarBeritaModel->orderBy('created_at', 'DESC')->findAll();

            foreach ($komentar as &$item) {
                $berita = $this->beritaModel->find($item['berita_id']);
                $item['judul_berita'] = $berita ? $berita['judul'] : 'Tidak Ada Judul';
                $item['slug_berita'] = $berita ? $berita['slug'] : '';
            }

            $data = [
                'situs'     => $situs,
                'komentar'  => $komentar,
                'title'     => 'Komentar Berita',
            ];

            return view('admin/komentar-berita/index', $data);
        }
    }

    public function delete($id)
    {
        // Temukan komentar berita berdasarkan ID
        $komentar = $this->komentarBeritaModel->find($id);

        // Periksa apakah komentar ditemukan
        if ($komentar) {
            // Ambil ID komentar berita
            $komentar_berita_id = $komentar['id'];

            // Temukan balasan komentar yang terkait dengan komentar berita
            $balasanKomentar = $this->komentarBalasanBeritaModel->where('komentar_berita_id', $komentar_berita_id)->findAll();

            // Jika ada balasan komentar, hapus satu per satu
            if ($balasanKomentar) {
                foreach ($balasanKomentar as $balasan) {
                    $this->komentarBalasanBeritaModel->delete($balasan['id']);
                }
            }

            // Hapus komentar berita
            $delete = $this->komentarBeritaModel->delete($komentar_berita_id);

            // Periksa apakah penghapusan berhasil
            if ($delete !== false) {
                // Jika berhasil, kembalikan ke halaman dengan pesan sukses
                return redirect()->to(base_url('dashboard/komentar-berita'))->with('success-message', 'Komentar berhasil dihapus.');
            } else {
                // Jika gagal, kembalikan ke halaman dengan pesan kesalahan
                return redirect()->to(base_url('dashboard/komentar-berita'))->with('error-message', 'Komentar gagal dihapus.');
            }
        }
    }
}
