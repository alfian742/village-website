<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\GeografisModel;
use App\Models\SitusModel;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\I18n\Time;

class Geografis extends BaseController
{
    protected $situsModel;
    protected $geografisModel;

    public function __construct()
    {
        $this->situsModel       = new SitusModel();
        $this->geografisModel   = new GeografisModel();
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
                'geografis'     => $this->geografisModel->find(1),
                'title'         => 'Geografis',
            ];

            return view('admin/geografis/index', $data);
        }
    }

    public function update($id)
    {
        if (!$this->validate([
            'lokasi' => [
                'rules' => 'required',
                'errors' => [
                    'required'  => 'Lokasi tidak boleh kosong!',
                ]
            ],
            'timur' => [
                'rules' => 'required',
                'errors' => [
                    'required'  => 'Batas wilayah tidak boleh kosong!',
                ]
            ],
            'barat' => [
                'rules' => 'required',
                'errors' => [
                    'required'  => 'Batas wilayah tidak boleh kosong!',
                ]
            ],
            'selatan' => [
                'rules' => 'required',
                'errors' => [
                    'required'  => 'Batas wilayah tidak boleh kosong!',
                ]
            ],
            'utara' => [
                'rules' => 'required',
                'errors' => [
                    'required'  => 'Batas wilayah tidak boleh kosong!',
                ]
            ],
        ])) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $update = $this->geografisModel->update($id, [
            'lokasi'        => $this->request->getVar('lokasi'),
            'luas'          => $this->request->getVar('luas'),
            'timur'         => $this->request->getVar('timur'),
            'barat'         => $this->request->getVar('barat'),
            'selatan'       => $this->request->getVar('selatan'),
            'utara'         => $this->request->getVar('utara'),
            'updated_at'    => Time::now('Asia/Singapore', 'id_ID'),
        ]);

        if ($update !== false) {
            return redirect()->to(base_url('dashboard/geografis'))->with('success-message', 'Geografis berhasil diperbarui.');
        } else {
            return redirect()->to(base_url('dashboard/geografis'))->with('error-message', 'Geografis gagal diperbarui.');
        }
    }
}
