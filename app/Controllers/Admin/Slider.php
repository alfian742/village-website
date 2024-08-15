<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\SitusModel;
use App\Models\SliderModel;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\I18n\Time;

class Slider extends BaseController
{
    protected $situsModel;
    protected $sliderModel;

    public function __construct()
    {
        $this->situsModel   = new SitusModel();
        $this->sliderModel  = new SliderModel();
    }

    public function index()
    {
        // Mendapatkan data situs
        $situs = $this->situsModel->findAll(1);

        if (empty($situs) || user()->level == 'staff' || user()->level == 'kepala dusun') {
            return redirect()->to(base_url('404-not-found'));
        } else {
            $data = [
                'situs'     => $situs,
                'sliders'   => $this->sliderModel->findAll(),
                'title'     => 'Slider',
            ];

            return view('admin/slider/index', $data);
        }
    }

    public function edit($id)
    {
        // Mendapatkan data situs
        $situs = $this->situsModel->findAll(1);

        if (empty($situs) || user()->level == 'staff' || user()->level == 'kepala dusun') {
            return redirect()->to(base_url('404-not-found'));
        } else {
            $slider = $this->sliderModel->find($id);

            if (!$slider) {
                return redirect()->to(base_url('dashboard/slider'))->with('warning-message', 'Data tidak ditemukan.');
            } else {
                $data = [
                    'situs'     => $situs,
                    'slider'    => $slider,
                    'title'     => 'Edit Slider',
                ];

                return view('admin/slider/edit', $data);
            }
        }
    }

    public function update($id)
    {
        // Validasi input data
        if (!$this->validate([
            'judul' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Judul tidak boleh kosong!'
                ]
            ],

            'deskripsi' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Deskripsi tidak boleh kosong!'
                ]
            ],

            // Jika gambar boleh kosong
            'gambar' => [
                'rules' => 'max_size[gambar,1024]|is_image[gambar]|mime_in[gambar,image/jpg,image/jpeg,image/png]',
                'errors' => [
                    'max_size'  => 'Ukuran gambar maksimal 1MB!',
                    'is_image'  => 'Format tidak didukung!',
                    'mime_in'   => 'Yang Anda unggah bukan gambar!'
                ]
            ]
        ])) {
            // Menyimpan pesan error dalam array flashdata
            return redirect()->to(base_url('dashboard/slider/edit/') . $id)->withInput()->with('errors', $this->validator->getErrors());
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
            $gambar->move('img/slider', $namaGambar);

            // Hapus file
            if ($gambarLama != 'default.svg') {
                unlink('img/slider/' . $gambarLama);
            }
        }

        $update = $this->sliderModel->update($id, [
            'judul'         => $this->request->getVar('judul'),
            'deskripsi'     => $this->request->getVar('deskripsi'),
            'relevan_url'   => $this->request->getVar('relevan_url'),
            'gambar'        => $namaGambar,
            'updated_at'    => Time::now('Asia/Singapore', 'id_ID'),
        ]);

        if ($update !== false) {
            return redirect()->to(base_url('dashboard/slider'))->with('success-message', 'Slider berhasil diperbarui.');
        } else {
            return redirect()->to(base_url('dashboard/slider/edit/') . $id)->with('error-message', 'Slider gagal diperbarui.');
        }
    }
}
