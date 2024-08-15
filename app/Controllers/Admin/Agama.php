<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\AgamaModel;
use App\Models\SitusModel;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\I18n\Time;

class Agama extends BaseController
{
    protected $situsModel;
    protected $agamaModel;

    public function __construct()
    {
        $this->situsModel   = new SitusModel();
        $this->agamaModel   = new AgamaModel();
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
                'agama'     => $this->agamaModel->orderBy('agama', 'ASC')->findAll(),
                'title'     => 'Data Agama',
            ];

            return view('admin/agama/index', $data);
        }
    }

    public function update()
    {
        // Mengambil data id dan jumlah dari request
        $id = $this->request->getVar('id');
        $jumlah = $this->request->getVar('jumlah');

        // Melakukan iterasi untuk setiap id
        foreach ($id as $index => $agama_id) {
            // Memeriksa apakah jumlah tidak kosong
            if (!empty($jumlah[$index])) {
                // Memeriksa apakah jumlah adalah angka
                if (!is_numeric($jumlah[$index])) {
                    // Mengembalikan pengguna ke halaman sebelumnya dengan pesan kesalahan jika jumlah bukan angka
                    return redirect()->back()->withInput()->with('error-message-toast', 'Data harus berupa angka!');
                }
            }

            // Memperbarui data agama dengan id yang sesuai
            $update = $this->agamaModel->update($agama_id, [
                'jumlah'        => $jumlah[$index],
                'updated_at'    => Time::now('Asia/Singapore', 'id_ID'),
            ]);

            // Memeriksa apakah proses pembaruan berhasil atau gagal
            if ($update === false) {
                // Mengembalikan pengguna ke halaman sebelumnya dengan pesan kesalahan jika pembaruan gagal
                return redirect()->back()->with('error-message', "Data Agama gagal diperbarui.");
            }
        }

        // Mengarahkan pengguna ke halaman daftar agama dengan pesan sukses jika semua pembaruan berhasil
        return redirect()->to(base_url('dashboard/agama'))->with('success-message', "Data Agama berhasil diperbarui.");
    }
}
