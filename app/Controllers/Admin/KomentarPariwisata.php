<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\KomentarBalasanPariwisataModel;
use App\Models\KomentarPariwisataModel;
use App\Models\PariwisataModel;
use App\Models\SitusModel;
use CodeIgniter\HTTP\ResponseInterface;

class KomentarPariwisata extends BaseController
{
    protected $situsModel;
    protected $pariwisataModel;
    protected $komentarPariwisataModel;
    protected $komentarBalasanPariwisataModel;

    public function __construct()
    {
        $this->situsModel                       = new SitusModel();
        $this->pariwisataModel                  = new PariwisataModel();
        $this->komentarPariwisataModel          = new KomentarPariwisataModel();
        $this->komentarBalasanPariwisataModel   = new KomentarBalasanPariwisataModel();
    }

    public function index()
    {
        // Mendapatkan data situs
        $situs = $this->situsModel->findAll(1);

        if (empty($situs)) {
            return redirect()->to(base_url('404-not-found'));
        } else {
            $komentar = $this->komentarPariwisataModel->orderBy('created_at', 'DESC')->findAll();

            foreach ($komentar as &$item) {
                $pariwisata = $this->pariwisataModel->find($item['pariwisata_id']);
                $item['judul_pariwisata'] = $pariwisata ? $pariwisata['judul'] : 'Tidak Ada Judul';
                $item['slug_pariwisata'] = $pariwisata ? $pariwisata['slug'] : '';
            }

            $data = [
                'situs'     => $situs,
                'komentar'  => $komentar,
                'title'     => 'Komentar Pariwisata',
            ];

            return view('admin/komentar-pariwisata/index', $data);
        }
    }

    public function delete($id)
    {
        // Temukan komentar pariwisata berdasarkan ID
        $komentar = $this->komentarPariwisataModel->find($id);

        // Periksa apakah komentar ditemukan
        if ($komentar) {
            // Ambil ID komentar pariwisata
            $komentar_pariwisata_id = $komentar['id'];

            // Temukan balasan komentar yang terkait dengan komentar pariwisata
            $balasanKomentar = $this->komentarBalasanPariwisataModel->where('komentar_pariwisata_id', $komentar_pariwisata_id)->findAll();

            // Jika ada balasan komentar, hapus satu per satu
            if ($balasanKomentar) {
                foreach ($balasanKomentar as $balasan) {
                    $this->komentarBalasanPariwisataModel->delete($balasan['id']);
                }
            }

            // Hapus komentar pariwisata
            $delete = $this->komentarPariwisataModel->delete($komentar_pariwisata_id);

            // Periksa apakah penghapusan berhasil
            if ($delete !== false) {
                // Jika berhasil, kembalikan ke halaman dengan pesan sukses
                return redirect()->to(base_url('dashboard/komentar-pariwisata'))->with('success-message', 'Komentar berhasil dihapus.');
            } else {
                // Jika gagal, kembalikan ke halaman dengan pesan kesalahan
                return redirect()->to(base_url('dashboard/komentar-pariwisata'))->with('error-message', 'Komentar gagal dihapus.');
            }
        }
    }
}
