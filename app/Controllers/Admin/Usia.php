<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\SitusModel;
use App\Models\UsiaModel;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\I18n\Time;

class Usia extends BaseController
{
    protected $situsModel;
    protected $usiaModel;

    public function __construct()
    {
        $this->situsModel   = new SitusModel();
        $this->usiaModel    = new UsiaModel();
    }

    public function index()
    {
        // Mendapatkan data situs
        $situs = $this->situsModel->findAll(1);

        if (empty($situs) || user()->level == 'staff' || user()->level == 'kepala dusun') {
            return redirect()->to(base_url('404-not-found'));
        } else {
            $data = [
                'situs' => $situs,
                'usia'  => $this->usiaModel->orderBy('id', 'ASC')->findAll(),
                'title' => 'Usia',
            ];

            return view('admin/usia/index', $data);
        }
    }

    public function update()
    {
        $id = $this->request->getVar('id');
        $jumlah = $this->request->getVar('jumlah');

        // Lakukan pembaruan data untuk setiap elemen
        foreach ($id as $index => $id_usia) {
            // Cek apakah ada input jumlah
            if (!empty($jumlah[$index])) {
                // Jika ada input, lakukan validasi numerik
                if (!is_numeric($jumlah[$index])) {
                    return redirect()->back()->withInput()->with('error-message-toast', 'Data harus berupa angka!');
                }
            }

            $update = $this->usiaModel->update($id_usia, [
                'jumlah'        => $jumlah[$index], // Mungkin kosong, itu oke
                'updated_at'    => Time::now('Asia/Singapore', 'id_ID'),
            ]);

            // Periksa hasil pembaruan
            if ($update === false) {
                return redirect()->back()->with('error-message', 'Data Usia gagal diperbarui.');
            }
        }

        // Jika semua pembaruan berhasil
        return redirect()->to(base_url('dashboard/usia'))->with('success-message', 'Data Usia berhasil diperbarui.');
    }
}
