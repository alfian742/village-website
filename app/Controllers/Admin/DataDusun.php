<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\DataDusunModel;
use App\Models\DusunModel;
use App\Models\KepalaDusunModel;
use App\Models\SitusModel;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\I18n\Time;

class DataDusun extends BaseController
{
    protected $situsModel;
    protected $dataDusunModel;
    protected $dusunModel;
    protected $kepalaDusunModel;

    public function __construct()
    {
        $this->situsModel           = new SitusModel();
        $this->dataDusunModel       = new DataDusunModel();
        $this->dusunModel           = new DusunModel();
        $this->kepalaDusunModel     = new KepalaDusunModel();
    }

    public function index()
    {
        // Mendapatkan data situs
        $situs = $this->situsModel->findAll(1);

        if (empty($situs) || user()->level == 'staff' || user()->level == 'kepala dusun') {
            return redirect()->to(base_url('404-not-found'));
        } else {
            $data_dusun = $this->dataDusunModel->orderBy('created_at', 'DESC')->findAll();

            foreach ($data_dusun as &$item) {
                $dusun = $this->dusunModel->find($item['dusun_id']);
                $item['dusun'] = $dusun ? $dusun['nama_dusun'] : 'Tidak Ada';
                $item['slug'] = $dusun ? $dusun['slug'] : '';
            }

            $data = [
                'situs'         => $situs,
                'data_dusun'    => $data_dusun,
                'title'         => 'Data Kewilayahan',
            ];

            return view('admin/data-dusun/index', $data);
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
                'situs'         => $situs,
                'dusun'         => $this->dusunModel->orderBy('nama_dusun', 'ASC')->findAll(),
                'title'         => 'Tambah Data Kewilayahan',
            ];

            return view('admin/data-dusun/create', $data);
        }
    }

    public function save()
    {
        // Validasi inputan yang diterima dari form
        if (!$this->validate([
            'dusun_id' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Silahkan pilih Dusun/Lingkungan!',
                ]
            ],
            'waktu' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Bulan & Tahun tidak boleh kosong!',
                ]
            ],
        ])) {
            // Jika validasi gagal, kembalikan pengguna ke halaman pembuatan data dusun dengan pesan kesalahan dan input sebelumnya
            return redirect()->to('dashboard/data-dusun/create')->withInput()->with('errors', $this->validator->getErrors());
        }

        // Menyimpan data data dusun ke dalam database
        $save = $this->dataDusunModel->save([
            'waktu'         => date('Y-m-d', strtotime($this->request->getVar('waktu'))),
            'jumlah_lahir'  => $this->request->getVar('jumlah_lahir'),
            'jumlah_mati'   => $this->request->getVar('jumlah_mati'),
            'jumlah_masuk'  => $this->request->getVar('jumlah_masuk'),
            'jumlah_keluar' => $this->request->getVar('jumlah_keluar'),
            'dusun_id'      => $this->request->getVar('dusun_id'),
            'created_at'    => Time::now('Asia/Singapore', 'id_ID'),
            'updated_at'    => Time::now('Asia/Singapore', 'id_ID'),
        ]);

        // Memeriksa apakah data berhasil disimpan atau tidak, kemudian mengarahkan pengguna ke halaman data dusun dengan pesan sukses atau gagal
        if ($save !== false) {
            return redirect()->to(base_url('dashboard/data-dusun'))->with('success-message', 'Data Dusun/Lingkungan berhasil ditambahkan.');
        } else {
            return redirect()->to(base_url('dashboard/data-dusun/create'))->with('error-message', 'Data Dusun/Lingkungan gagal ditambahkan.');
        }
    }

    public function edit($id)
    {
        // Mendapatkan data situs
        $situs = $this->situsModel->findAll(1);

        if (empty($situs) || user()->level == 'staff' || user()->level == 'kepala dusun') {
            return redirect()->to(base_url('404-not-found'));
        } else {
            $dataDusun = $this->dataDusunModel->find($id);

            if (!$dataDusun) {
                return redirect()->to(base_url('dashboard/data-dusun'))->with('warning-message', 'Data tidak ditemukan.');
            } else {
                $data = [
                    'situs'         => $situs,
                    'dusun'         => $this->dusunModel->orderBy('nama_dusun', 'ASC')->findAll(),
                    'data_dusun'    => $dataDusun,
                    'title'         => 'Edit Data Kewilayahan',
                ];

                return view('admin/data-dusun/edit', $data);
            }
        }
    }

    public function update($id)
    {
        // Validasi inputan yang diterima dari form
        if (!$this->validate([
            'dusun_id' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Silahkan pilih Dusun/Lingkungan!',
                ]
            ],
            'waktu' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Bulan & Tahun tidak boleh kosong!',
                ]
            ],
        ])) {
            // Jika validasi gagal, kembalikan pengguna ke halaman edit data dusun dengan pesan kesalahan dan input sebelumnya
            return redirect()->to(base_url('dashboard/data-dusun/edit/') . $id)->withInput()->with('errors', $this->validator->getErrors());
        }

        // Melakukan update data dusun berdasarkan ID yang diberikan
        $update = $this->dataDusunModel->update($id, [
            'waktu'         => date('Y-m-d', strtotime($this->request->getVar('waktu'))),
            'jumlah_lahir'  => $this->request->getVar('jumlah_lahir'),
            'jumlah_mati'   => $this->request->getVar('jumlah_mati'),
            'jumlah_masuk'  => $this->request->getVar('jumlah_masuk'),
            'jumlah_keluar' => $this->request->getVar('jumlah_keluar'),
            'dusun_id'      => $this->request->getVar('dusun_id'),
            'updated_at'    => Time::now('Asia/Singapore', 'id_ID'),
        ]);

        // Memeriksa apakah data berhasil diperbarui atau tidak, kemudian mengarahkan pengguna ke halaman data dusun dengan pesan sukses atau gagal
        if ($update !== false) {
            return redirect()->to(base_url('dashboard/data-dusun'))->with('success-message', 'Data berhasil diperbarui.');
        } else {
            return redirect()->to(base_url('dashboard/data-dusun/edit/') . $id)->with('error-message', 'Data gagal diperbarui.');
        }
    }

    public function delete($id)
    {
        // Menghapus data dusun berdasarkan ID
        $delete = $this->dataDusunModel->delete($id);

        // Memeriksa apakah data berhasil dihapus atau tidak, kemudian mengarahkan pengguna ke halaman data dusun dengan pesan sukses atau gagal
        if ($delete !== false) {
            return redirect()->to(base_url('dashboard/data-dusun'))->with('success-message', 'Data berhasil dihapus.');
        } else {
            return redirect()->to(base_url('dashboard/data-dusun'))->with('error-message', 'Data gagal dihapus.');
        }
    }
}
