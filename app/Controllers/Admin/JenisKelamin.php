<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\JenisKelaminModel;
use App\Models\SitusModel;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\I18n\Time;

class JenisKelamin extends BaseController
{
    protected $situsModel;
    protected $jenisKelaminModel;

    public function __construct()
    {
        $this->situsModel           = new SitusModel();
        $this->jenisKelaminModel    = new JenisKelaminModel();
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
                'jenis_kelamin' => $this->jenisKelaminModel->orderBy('jenis_kelamin', 'ASC')->findAll(),
                'title'         => 'Jenis Kelamin',
            ];

            return view('admin/jenis-kelamin/index', $data);
        }
    }

    public function update()
    {
        // Mendapatkan data ID dan jumlah dari request
        $id = $this->request->getVar('id');
        $jumlah = $this->request->getVar('jumlah');

        // Looping melalui setiap ID untuk melakukan update data
        foreach ($id as $index => $jenis_kelamin_id) {
            // Memeriksa apakah jumlah tidak kosong dan merupakan angka
            if (!empty($jumlah[$index])) {
                if (!is_numeric($jumlah[$index])) {
                    // Jika jumlah bukan angka, kembalikan ke halaman sebelumnya dengan pesan kesalahan
                    return redirect()->back()->withInput()->with('error-message-toast', 'Data harus berupa angka!');
                }
            }

            // Melakukan update jumlah untuk jenis kelamin tertentu
            $update = $this->jenisKelaminModel->update($jenis_kelamin_id, [
                'jumlah' => $jumlah[$index],
                'updated_at' => Time::now('Asia/Singapore', 'id_ID'),
            ]);

            // Memeriksa apakah proses update berhasil
            if ($update === false) {
                // Jika gagal, kembali ke halaman sebelumnya dengan pesan kesalahan
                return redirect()->back()->with('error-message', "Data Jenis Kelamin gagal diperbarui.");
            }
        }

        // Jika semua update berhasil, arahkan ke halaman dashboard jenis kelamin dengan pesan sukses
        return redirect()->to(base_url('dashboard/jenis-kelamin'))->with('success-message', "Data Jenis Kelamin berhasil diperbarui.");
    }
}
