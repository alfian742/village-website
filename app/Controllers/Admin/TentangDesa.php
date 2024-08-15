<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\SitusModel;
use App\Models\TentangDesaModel;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\I18n\Time;

class TentangDesa extends BaseController
{
    protected $situsModel;
    protected $tentangDesaModel;

    public function __construct()
    {
        $this->situsModel       = new SitusModel();
        $this->tentangDesaModel = new TentangDesaModel();
    }

    public function index()
    {
        // Mendapatkan data situs
        $situs = $this->situsModel->findAll(1);

        if (empty($situs) || user()->level == 'staff' || user()->level == 'kepala dusun') {
            return redirect()->to(base_url('404-not-found'));
        } else {
            $data = [
                'situs'         => $situs,
                'tentang_desa'  => $this->tentangDesaModel->find(1),
                'title'         => 'Tentang Desa/Kelurahan',
            ];

            return view('admin/tentang-desa/index', $data);
        }
    }

    public function edit($id)
    {
        // Mendapatkan data situs
        $situs = $this->situsModel->findAll(1);

        if (empty($situs) || user()->level == 'staff' || user()->level == 'kepala dusun') {
            return redirect()->to(base_url('404-not-found'));
        } else {
            $data = [
                'situs'         => $situs,
                'tentang_desa'  => $this->tentangDesaModel->find($id),
                'title'         => 'Edit Tentang Desa/Kelurahan',
            ];

            return view('admin/tentang-desa/edit', $data);
        }
    }

    public function update($id)
    {
        // Validasi input data
        if (!$this->validate([
            'tentang_desa' => [
                'rules' => 'required',
                'errors' => [
                    'required'  => 'Deskripsi Desa/Kelurahan tidak boleh kosong!',
                ]
            ],
            'visi' => [
                'rules' => 'required',
                'errors' => [
                    'required'  => 'Visi tidak boleh kosong!',
                ]
            ],
            'misi' => [
                'rules' => 'required',
                'errors' => [
                    'required'  => 'Misi tidak boleh kosong!',
                ]
            ],
        ])) {
            // Menyimpan pesan error dalam array flashdata
            return redirect()->to(base_url('dashboard/tentang-desa/edit/') . $id)->withInput()->with('errors', $this->validator->getErrors());
        }

        $update = $this->tentangDesaModel->update($id, [
            'tentang_desa'  => $this->request->getVar('tentang_desa'),
            'visi'          => $this->request->getVar('visi'),
            'misi'          => $this->request->getVar('misi'),
            'updated_at'    => Time::now('Asia/Singapore', 'id_ID'),
        ]);

        if ($update !== false) {
            return redirect()->to(base_url('dashboard/tentang-desa'))->with('success-message', 'Data berhasil diperbarui.');
        } else {
            return redirect()->to(base_url('dashboard/tentang-desa/edit/') . $id)->with('error-message', 'Data gagal diperbarui.');
        }
    }
}
