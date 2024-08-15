<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\PekerjaanModel;
use App\Models\SitusModel;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\I18n\Time;

class Pekerjaan extends BaseController
{
    protected $situsModel;
    protected $pekerjaanModel;

    public function __construct()
    {
        $this->situsModel           = new SitusModel();
        $this->pekerjaanModel       = new PekerjaanModel();
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
                'pekerjaan' => $this->pekerjaanModel->orderBy('pekerjaan', 'ASC')->findAll(),
                'title'     => 'Data Pekerjaan',
            ];

            return view('admin/pekerjaan/index', $data);
        }
    }

    public function create()
    {
        // Mendapatkan data situs
        $situs = $this->situsModel->findAll(1);

        if (empty($situs) || user()->level == 'staff' || user()->level == 'kepala dusun') {
            return redirect()->to(base_url('404-not-found'));
        } else {
            $data = [
                'situs' => $situs,
                'title' => 'Tambah Pekerjaan',
            ];

            return view('admin/pekerjaan/create', $data);
        }
    }

    public function save()
    {
        // Validasi input sebelum menyimpan data
        if (!$this->validate([
            'pekerjaan' => [
                'rules' => 'required|is_unique[pekerjaan.pekerjaan]', // Memastikan bahwa pekerjaan adalah unik
                'errors' => [
                    'required' => 'Nama pekerjaan tidak boleh kosong!', // Pesan kesalahan jika nama pekerjaan kosong
                    'is_unique' => 'Nama pekerjaan sudah ada!' // Pesan kesalahan jika nama pekerjaan sudah ada di database
                ]
            ],

            'jumlah' => [
                'rules' => 'required|numeric', // Memastikan bahwa jumlah adalah angka
                'errors' => [
                    'required' => 'Jumlah data tidak boleh kosong!', // Pesan kesalahan jika jumlah kosong
                    'numeric' => 'Data harus berupa angka!' // Pesan kesalahan jika jumlah bukan angka
                ]
            ],
        ])) {
            // Jika validasi gagal, kembalikan pengguna ke halaman pembuatan pekerjaan dengan pesan kesalahan dan input sebelumnya
            return redirect()->to(base_url('dashboard/pekerjaan/create'))->withInput()->with('errors', $this->validator->getErrors());
        }

        // Menyimpan data pekerjaan ke dalam database
        $save = $this->pekerjaanModel->save([
            'pekerjaan' => $this->request->getVar('pekerjaan'),
            'jumlah' => $this->request->getVar('jumlah'),
            'created_at' => Time::now('Asia/Singapore', 'id_ID'), // Menyimpan waktu pembuatan dalam zona waktu Asia/Singapore dengan format id_ID
            'updated_at' => Time::now('Asia/Singapore', 'id_ID'), // Menyimpan waktu pembaruan dalam zona waktu Asia/Singapore dengan format id_ID
        ]);

        // Mengembalikan respons berdasarkan keberhasilan penyimpanan data
        if ($save !== false) {
            return redirect()->to(base_url('dashboard/pekerjaan'))->with('success-message', 'Data Pekerjaan berhasil ditambahkan.'); // Jika penyimpanan berhasil, beri pesan sukses
        } else {
            return redirect()->to(base_url('dashboard/pekerjaan'))->with('error-message', 'Data Pekerjaan gagal ditambahkan.'); // Jika penyimpanan gagal, beri pesan kesalahan
        }
    }

    public function edit($id)
    {
        // Mendapatkan data situs
        $situs = $this->situsModel->findAll(1);

        if (empty($situs) || user()->level == 'staff' || user()->level == 'kepala dusun') {
            return redirect()->to(base_url('404-not-found'));
        } else {
            $pekerjaan = $this->pekerjaanModel->find($id);

            if (!$pekerjaan) {
                return redirect()->to(base_url('dashboard/pekerjaan'))->with('warning-message', 'Data tidak ditemukan.');
            } else {
                $data = [
                    'situs'     => $situs,
                    'pekerjaan' => $pekerjaan,
                    'title'     => 'Edit Pekerjaan',
                ];

                return view('admin/pekerjaan/edit', $data);
            }
        }
    }

    public function update($id)
    {
        // Mengambil data pekerjaan berdasarkan ID
        $pekerjaan = $this->pekerjaanModel->find($id);

        // Menyimpan nama pekerjaan lama dan baru
        $pekerjaanLama = $pekerjaan['pekerjaan'];
        $pekerjaanBaru = $this->request->getVar('pekerjaan');

        // Menentukan aturan validasi untuk nama pekerjaan berdasarkan perubahan
        if ($pekerjaanBaru !== $pekerjaanLama) {
            $rulePekerjaan = 'required|is_unique[pekerjaan.pekerjaan]'; // Memastikan nama pekerjaan baru adalah unik jika berbeda dari sebelumnya
        } else {
            $rulePekerjaan = 'required'; // Jika tidak ada perubahan, nama pekerjaan tetap harus diisi
        }

        // Validasi input sebelum memperbarui data
        if (!$this->validate([
            'pekerjaan' => [
                'rules' => $rulePekerjaan,
                'errors' => [
                    'required' => 'Nama pekerjaan tidak boleh kosong!', // Pesan kesalahan jika nama pekerjaan kosong
                    'is_unique' => 'Nama pekerjaan sudah ada!' // Pesan kesalahan jika nama pekerjaan sudah ada di database
                ]
            ],
        ])) {
            // Jika validasi gagal, kembalikan pengguna ke halaman edit pekerjaan dengan pesan kesalahan dan input sebelumnya
            return redirect()->to(base_url('dashboard/pekerjaan/edit/') . $id)->withInput()->with('errors', $this->validator->getErrors());
        }

        // Memeriksa dan validasi jumlah jika diisi
        $jumlah = $this->request->getVar('jumlah');
        if (!empty($jumlah)) {
            if (!is_numeric($jumlah)) {
                // Jika jumlah tidak berupa angka, kembalikan pengguna ke halaman edit dengan pesan kesalahan
                return redirect()->to(base_url('dashboard/pekerjaan/edit/') . $id)->withInput()->with('errors', 'Data harus berupa angka!');
            }
        }

        // Memperbarui data pekerjaan dalam database
        $update = $this->pekerjaanModel->update($id, [
            'pekerjaan'     => $pekerjaanBaru,
            'jumlah'        => $jumlah,
            'updated_at'    => Time::now('Asia/Singapore', 'id_ID'), // Menyimpan waktu pembaruan dalam zona waktu Asia/Singapore dengan format id_ID
        ]);

        // Mengembalikan respons berdasarkan keberhasilan pembaruan data
        if ($update !== false) {
            return redirect()->to(base_url('dashboard/pekerjaan'))->with('success-message', 'Data Pekerjaan berhasil diperbarui.'); // Jika pembaruan berhasil, beri pesan sukses
        } else {
            return redirect()->to(base_url('dashboard/pekerjaan'))->with('error-message', 'Data Pekerjaan gagal diperbarui.'); // Jika pembaruan gagal, beri pesan kesalahan
        }
    }

    public function delete($id)
    {
        // Menghapus data pekerjaan dari database berdasarkan ID
        $delete = $this->pekerjaanModel->delete($id);

        // Mengembalikan respons berdasarkan keberhasilan penghapusan data
        if ($delete !== false) {
            return redirect()->to(base_url('dashboard/pekerjaan'))->with('success-message', 'Data Pekerjaan berhasil dihapus.'); // Jika penghapusan berhasil, beri pesan sukses
        } else {
            return redirect()->to(base_url('dashboard/pekerjaan'))->with('error-message', 'Data Pekerjaan gagal dihapus.'); // Jika penghapusan gagal, beri pesan kesalahan
        }
    }
}
