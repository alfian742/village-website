<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\SitusModel;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\I18n\Time;

class Situs extends BaseController
{
    protected $situsModel;

    public function __construct()
    {
        $this->situsModel = new SitusModel();
    }

    public function index()
    {
        // Mendapatkan data situs
        $situs = $this->situsModel->findAll(1);

        if (empty($situs) || user()->level == 'staff' || user()->level == 'kepala dusun') {
            return redirect()->to(base_url('404-not-found'));
        } else {
            $data = [
                'situs'             => $situs,
                'identitas_situs'   => $this->situsModel->find(1),
                'title'             => 'Identitas Situs',
            ];

            return view('admin/identitas-situs/index', $data);
        }
    }

    public function update($id)
    {
        if (!$this->validate([
            'nama_desa' => [
                'rules' => 'required',
                'errors' => [
                    'required'  => 'Nama Desa/Kelurahan tidak boleh kosong!',
                ]
            ],
            'kecamatan' => [
                'rules' => 'required',
                'errors' => [
                    'required'  => 'Kecamatan tidak boleh kosong!',
                ]
            ],
            'kabupaten' => [
                'rules' => 'required',
                'errors' => [
                    'required'  => 'Kabupaten/Kota tidak boleh kosong!',
                ]
            ],
            'provinsi' => [
                'rules' => 'required',
                'errors' => [
                    'required'  => 'Provinsi tidak boleh kosong!',
                ]
            ],
            'kode_pos' => [
                'rules' => 'required',
                'errors' => [
                    'required'  => 'Kode Pos tidak boleh kosong!',
                ]
            ],

            // Jika gambar boleh kosong
            'logo' => [
                'rules' => 'max_size[logo,1024]|is_image[logo]|mime_in[logo,image/jpg,image/jpeg,image/png]',
                'errors' => [
                    'max_size'  => 'Ukuran gambar maksimal 1MB!',
                    'is_image'  => 'Format tidak didukung!',
                    'mime_in'   => 'Yang Anda unggah bukan gambar!'
                ]
            ]
        ])) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $gambar = $this->request->getFile('logo');

        if ($gambar->getError() == 4) {
            $namaGambar = $this->request->getVar('logoLama');
        } else {
            $namaGambar = $gambar->getRandomName();

            $gambar->move('img/logo', $namaGambar);

            if ($this->request->getVar('logoLama') != 'default.svg') {
                unlink('img/logo/' . $this->request->getVar('logoLama'));
            }
        }

        $update = $this->situsModel->update($id, [
            'nama_desa'     => $this->request->getVar('nama_desa'),
            'kecamatan'     => $this->request->getVar('kecamatan'),
            'kabupaten'     => $this->request->getVar('kabupaten'),
            'provinsi'      => $this->request->getVar('provinsi'),
            'kode_pos'      => $this->request->getVar('kode_pos'),
            'logo'          => $namaGambar,
            'updated_at'    => Time::now('Asia/Singapore', 'id_ID'),
        ]);

        if ($update !== false) {
            return redirect()->to(base_url('dashboard/identitas-situs'))->with('success-message', 'Situs berhasil diperbarui.');
        } else {
            return redirect()->to(base_url('dashboard/identitas-situs'))->with('error-message', 'Situs gagal diperbarui.');
        }
    }
}
