<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\SitusModel;
use App\Models\StrukturOrganisasiModel;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\I18n\Time;

class StrukturOrganisasi extends BaseController
{
    protected $situsModel;
    protected $strukturOrganisasiModel;

    public function __construct()
    {
        $this->situsModel               = new SitusModel();
        $this->strukturOrganisasiModel  = new StrukturOrganisasiModel();
    }

    public function index()
    {
        // Mendapatkan data situs
        $situs = $this->situsModel->findAll(1);

        if (empty($situs) || user()->level == 'staff' || user()->level == 'kepala dusun') {
            return redirect()->to(base_url('404-not-found'));
        } else {
            $data = [
                'situs'                 => $situs,
                'struktur_organisasi'   => $this->strukturOrganisasiModel->find(1),
                'title'                 => 'Struktur Organisasi Desa/Kelurahan',
            ];

            return view('admin/struktur-organisasi/index', $data);
        }
    }

    public function update($id)
    {
        // Validasi input data
        if (!$this->validate([
            'gambar' => [
                'rules' => 'max_size[gambar,3072]|is_image[gambar]|mime_in[gambar,image/jpg,image/jpeg,image/png]',
                'errors' => [
                    'max_size'  => 'Ukuran gambar maksimal 3MB!',
                    'is_image'  => 'Format tidak didukung!',
                    'mime_in'   => 'Yang Anda unggah bukan gambar!'
                ]
            ]
        ])) {
            // Menyimpan pesan error dalam array flashdata
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $gambar = $this->request->getFile('gambar');
        $gambarLama = $this->request->getVar('gambarLama');

        // Cek gambar, apakah tetap gambar lama?
        if ($gambar->getError() == 4) {
            $namaGambar = $gambarLama;
        } else {
            // Generate nama sampul baru
            $namaGambar = $gambar->getRandomName();

            //Pindah gambar
            $gambar->move('img/struktur-organisasi', $namaGambar);

            // Hapus file
            if ($gambarLama != 'default.svg') {
                unlink('img/struktur-organisasi/' . $gambarLama);
            }
        }

        $update = $this->strukturOrganisasiModel->update($id, [
            'gambar'        => $namaGambar,
            'updated_at'    => Time::now('Asia/Singapore', 'id_ID'),
        ]);

        if ($update !== false) {
            return redirect()->to(base_url('dashboard/struktur-organisasi'))->with('success-message', 'Struktur Organisasi berhasil diperbarui.');
        } else {
            return redirect()->to(base_url('dashboard/struktur-organisasi'))->with('error-message', 'Struktur Organisasi gagal diperbarui.');
        }
    }
}
