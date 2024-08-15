<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\DataDusunModel;
use App\Models\DusunModel;
use App\Models\KepalaDusunModel;
use App\Models\SitusModel;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\I18n\Time;

class Dusun extends BaseController
{
    protected $situsModel;
    protected $dusunModel;
    protected $dataDusunModel;
    protected $kepalaDusunModel;

    public function __construct()
    {
        $this->situsModel           = new SitusModel();
        $this->dataDusunModel       = new DataDusunModel();
        $this->dusunModel           = new DusunModel();
        $this->kepalaDusunModel     = new KepalaDusunModel();
    }

    private function getSlug($slug)
    {
        return $this->dusunModel->where('slug', $slug)->first();
    }

    public function index()
    {
        // Mendapatkan data situs
        $situs = $this->situsModel->findAll(1);

        if (empty($situs) || user()->level == 'staff' || user()->level == 'kepala dusun') {
            return redirect()->to(base_url('404-not-found'));
        } else {
            $dusun = $this->dusunModel->orderBy('nama_dusun', 'ASC')->findAll();

            foreach ($dusun as &$item) {
                $kepalaDusun = $this->kepalaDusunModel->find($item['kepala_dusun_id']);
                $item['kepala_dusun'] = $kepalaDusun ? $kepalaDusun['nama'] : 'Tidak Ada';
            }

            $data = [
                'situs'         => $situs,
                'dusun'         => $dusun,
                'title'         => 'Wilayah',
            ];

            return view('admin/dusun/index', $data);
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
                'kepala_dusun'  => $this->kepalaDusunModel->orderBy('nama', 'ASC')->findAll(),
                'title'         => 'Tambah Wilayah',
            ];

            return view('admin/dusun/create', $data);
        }
    }

    public function save()
    {
        // Validasi inputan yang diterima dari form
        if (!$this->validate([
            'nama_dusun' => [
                'rules' => 'required|is_unique[dusun.nama_dusun]',
                'errors' => [
                    'required' => 'Nama Dusun/Lingkungan tidak boleh kosong!',
                    'is_unique' => 'Nama Dusun/Lingkungan sudah ada!'
                ]
            ],
            'deskripsi' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Deskripsi Dusun/Lingkungan tidak boleh kosong!'
                ]
            ],
            // Validasi batas wilayah
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
            // Validasi gambar
            'gambar' => [
                'rules' => 'uploaded[gambar]|max_size[gambar,1024]|is_image[gambar]|mime_in[gambar,image/jpg,image/jpeg,image/png]',
                'errors' => [
                    'uploaded'  => 'Anda belum mengunggah gambar!',
                    'max_size'  => 'Ukuran gambar maksimal 1MB!',
                    'is_image'  => 'Format tidak didukung!',
                    'mime_in'   => 'Yang Anda unggah bukan gambar!'
                ]
            ]
        ])) {
            // Jika validasi gagal, kembalikan pengguna ke halaman pembuatan data dusun dengan pesan kesalahan dan input sebelumnya
            return redirect()->to(base_url('dashboard/dusun/create'))->withInput()->with('errors', $this->validator->getErrors());
        }

        // Simpan gambar yang diunggah ke direktori 'img/dusun'
        $gambar = $this->request->getFile('gambar');
        $namaGambar = $gambar->getRandomName();
        $gambar->move('img/dusun', $namaGambar);

        // Persiapkan data untuk disimpan ke dalam database
        $namaDusun = $this->request->getVar('nama_dusun');
        $slug = url_title($namaDusun, '-', true);

        // Simpan data dusun ke dalam database
        $save = $this->dusunModel->save([
            'nama_dusun'        => $namaDusun,
            'slug'              => $slug,
            'deskripsi'         => $this->request->getVar('deskripsi'),
            'gambar'            => $namaGambar,
            'luas'              => $this->request->getVar('luas'),
            'timur'             => $this->request->getVar('timur'),
            'barat'             => $this->request->getVar('barat'),
            'selatan'           => $this->request->getVar('selatan'),
            'utara'             => $this->request->getVar('utara'),
            'kepala_dusun_id'   => $this->request->getVar('kepala_dusun_id'),
            'created_at'        => Time::now('Asia/Singapore', 'id_ID'),
            'updated_at'        => Time::now('Asia/Singapore', 'id_ID'),
        ]);

        // Memeriksa apakah data berhasil disimpan atau tidak, kemudian mengarahkan pengguna ke halaman data dusun dengan pesan sukses atau gagal
        if ($save !== false) {
            return redirect()->to(base_url('dashboard/dusun'))->with('success-message', 'Data Dusun/Lingkungan berhasil ditambahkan.');
        } else {
            return redirect()->to(base_url('dashboard/dusun/create'))->with('error-message', 'Data Dusun/Lingkungan gagal ditambahkan.');
        }
    }

    public function edit($slug)
    {
        // Mendapatkan data situs
        $situs = $this->situsModel->findAll(1);

        if (empty($situs) || user()->level == 'staff' || user()->level == 'kepala dusun') {
            return redirect()->to(base_url('404-not-found'));
        } else {
            $dusun = $this->getSlug($slug);

            if (!$dusun) {
                return redirect()->to(base_url('dashboard/dusun'))->with('warning-message', 'Data tidak ditemukan.');
            } else {
                $data = [
                    'situs'         => $situs,
                    'dusun'         => $dusun,
                    'kepala_dusun'  => $this->kepalaDusunModel->orderBy('nama', 'ASC')->findAll(),
                    'title'         => 'Edit Wilayah',
                ];

                return view('admin/dusun/edit', $data);
            }
        }
    }

    public function update($slug)
    {
        // Mendapatkan data dusun berdasarkan slug
        $dusun = $this->getSlug($slug);

        // Mendapatkan nama dusun lama dan baru dari input pengguna
        $namaDusunLama = $dusun['nama_dusun'];
        $namaDusunBaru = $this->request->getVar('nama_dusun');

        // Memeriksa apakah nama dusun baru unik atau tidak
        if ($namaDusunBaru !== $namaDusunLama) {
            $rulenamaDusun = 'required|is_unique[dusun.nama_dusun]';
        } else {
            $rulenamaDusun = 'required';
        }

        // Validasi inputan yang diterima dari form
        if (!$this->validate([
            'nama_dusun' => [
                'rules' => $rulenamaDusun,
                'errors' => [
                    'required' => 'Nama Dusun/Lingkungan tidak boleh kosong!',
                    'is_unique' => 'Nama Dusun/Lingkungan sudah ada!'
                ]
            ],
            'deskripsi' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Deskripsi Dusun/Lingkungan tidak boleh kosong!'
                ]
            ],
            // Validasi batas wilayah
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
            // Validasi gambar
            'gambar' => [
                'rules' => 'max_size[gambar,1024]|is_image[gambar]|mime_in[gambar,image/jpg,image/jpeg,image/png]',
                'errors' => [
                    'max_size'  => 'Ukuran gambar maksimal 1MB!',
                    'is_image'  => 'Format tidak didukung!',
                    'mime_in'   => 'Yang Anda unggah bukan gambar!'
                ]
            ]
        ])) {
            // Jika validasi gagal, kembalikan pengguna ke halaman edit data dusun dengan pesan kesalahan dan input sebelumnya
            return redirect()->to(base_url('dashboard/dusun/edit/') . $slug)->withInput()->with('errors', $this->validator->getErrors());
        }

        // Mengambil file gambar yang diunggah
        $gambar = $this->request->getFile('gambar');

        // Memeriksa apakah pengguna mengunggah gambar baru atau tidak
        if ($gambar->getError() == 4) {
            $namaGambar = $this->request->getVar('gambarLama');
        } else {
            // Jika pengguna mengunggah gambar baru, simpan gambar ke direktori 'img/dusun' dan hapus gambar lama
            $namaGambar = $gambar->getRandomName();
            $gambar->move('img/dusun', $namaGambar);
            if ($this->request->getVar('gambarLama') != 'default.svg') {
                unlink('img/dusun/' . $this->request->getVar('gambarLama'));
            }
        }

        // Menghasilkan slug baru berdasarkan nama dusun baru
        $slug = url_title($namaDusunBaru, '-', true);

        // Melakukan update data dusun ke dalam database
        $update = $this->dusunModel->update($dusun['id'], [
            'nama_dusun'        => $namaDusunBaru,
            'slug'              => $slug,
            'deskripsi'         => $this->request->getVar('deskripsi'),
            'gambar'            => $namaGambar,
            'luas'              => $this->request->getVar('luas'),
            'timur'             => $this->request->getVar('timur'),
            'barat'             => $this->request->getVar('barat'),
            'selatan'           => $this->request->getVar('selatan'),
            'utara'             => $this->request->getVar('utara'),
            'kepala_dusun_id'   => $this->request->getVar('kepala_dusun_id'),
            'updated_at'        => Time::now('Asia/Singapore', 'id_ID'),
        ]);

        // Memeriksa apakah data berhasil diperbarui atau tidak, kemudian mengarahkan pengguna ke halaman data dusun dengan pesan sukses atau gagal
        if ($update !== false) {
            return redirect()->to(base_url('dashboard/dusun'))->with('success-message', 'Data Dusun/Lingkungan berhasil diperbarui.');
        } else {
            return redirect()->to(base_url('dashboard/dusun/edit/') . $slug)->with('error-message', 'Data Dusun/Lingkungan gagal diperbarui.');
        }
    }

    public function delete($id)
    {
        // Mengambil data dusun berdasarkan ID
        $dusun = $this->dusunModel->find($id);

        // Memeriksa apakah data dusun ditemukan
        if ($dusun) {
            // Jika ditemukan, cari data dusun yang terkait dengan dusun tersebut
            $dataDusun = $this->dataDusunModel->where('dusun_id', $dusun['id'])->findAll();

            // Hapus semua data dusun terkait
            foreach ($dataDusun as $data) {
                $this->dataDusunModel->delete($data['id']);
            }
        }

        // Menghapus gambar yang terkait dengan dusun jika bukan gambar default
        if ($dusun['gambar'] != 'default.svg') {
            unlink('img/dusun/' . $dusun['gambar']);
        }

        // Menghapus data dusun dari database berdasarkan ID
        $delete = $this->dusunModel->delete($id);

        // Memeriksa apakah data berhasil dihapus atau tidak, kemudian mengarahkan pengguna ke halaman data dusun dengan pesan sukses atau gagal
        if ($delete !== false) {
            return redirect()->to(base_url('dashboard/dusun'))->with('success-message', 'Data Dusun/Lingkungan berhasil dihapus.');
        } else {
            return redirect()->to(base_url('dashboard/dusun'))->with('error-message', 'Data Dusun/Lingkungan gagal dihapus.');
        }
    }
}
