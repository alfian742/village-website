<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\KontakModel;
use App\Models\SitusModel;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\I18n\Time;

class Kontak extends BaseController
{
    protected $situsModel;
    protected $kontakModel;

    public function __construct()
    {
        $this->situsModel       = new SitusModel();
        $this->kontakModel      = new KontakModel();
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
                'kontak'    => $this->kontakModel->find(1),
                'title'     => 'Kontak',
            ];

            return view('admin/kontak/index', $data);
        }
    }

    public function update($id)
    {
        if (!$this->validate([
            'email' => [
                'rules' => 'required',
                'errors' => [
                    'required'  => 'Email tidak boleh kosong!',
                ]
            ],
            'nomor_hp' => [
                'rules' => 'required',
                'errors' => [
                    'required'  => 'Nomor HP tidak boleh kosong!',
                ]
            ],
        ])) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $update = $this->kontakModel->update($id, [
            'email'         => $this->request->getVar('email'),
            'nomor_hp'      => $this->request->getVar('nomor_hp'),
            'instagram'     => $this->request->getVar('instagram'),
            'facebook'      => $this->request->getVar('facebook'),
            'twitter'       => $this->request->getVar('twitter'),
            'tiktok'        => $this->request->getVar('tiktok'),
            'youtube'       => $this->request->getVar('youtube'),
            'updated_at'    => Time::now('Asia/Singapore', 'id_ID'),
        ]);

        if ($update !== false) {
            return redirect()->to(base_url('dashboard/kontak'))->with('success-message', 'Kontak berhasil diperbarui.');
        } else {
            return redirect()->to(base_url('dashboard/kontak'))->with('error-message', 'Kontak gagal diperbarui.');
        }
    }
}
