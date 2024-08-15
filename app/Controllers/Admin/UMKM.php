<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\KomentarBalasanUMKMModel;
use App\Models\KomentarUMKMModel;
use App\Models\SitusModel;
use App\Models\UMKMModel;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\I18n\Time;
use Myth\Auth\Models\UserModel;

class UMKM extends BaseController
{
    protected $situsModel;
    protected $umkmModel;
    protected $komentarUMKMModel;
    protected $komentarBalasanUMKMModel;
    protected $userModel;

    public function __construct()
    {
        $this->situsModel                   = new SitusModel();
        $this->umkmModel                    = new UMKMModel();
        $this->komentarUMKMModel            = new KomentarUMKMModel();
        $this->komentarBalasanUMKMModel     = new KomentarBalasanUMKMModel();
        $this->userModel                    = new UserModel();
    }

    private function getSlug($slug)
    {
        return $this->umkmModel->where('slug', $slug)->first();
    }

    public function index()
    {
        // Mendapatkan data situs
        $situs = $this->situsModel->findAll(1);

        if (empty($situs)) {
            return redirect()->to(base_url('404-not-found'));
        } else {
            $data = [
                'situs'     => $situs,
                'umkm'      => $this->umkmModel->orderBy('created_at', 'DESC')->findAll(),
                'title'     => 'Daftar UMKM',
            ];
        }

        return view('admin/umkm/index', $data);
    }

    public function create()
    {
        // Mendapatkan data situs
        $situs = $this->situsModel->findAll(1);

        if (empty($situs)) {
            return redirect()->to(base_url('404-not-found'));
        } else {
            $data = [
                'situs' => $situs,
                'title' => 'Tambah Produk UMKM',
            ];

            return view('admin/umkm/create', $data);
        }
    }

    public function save()
    {
        // Validasi input
        if (!$this->validate([
            'nama' => [
                'rules' => 'required|is_unique[umkm.nama]',
                'errors' => [
                    'required' => 'Nama Produk tidak boleh kosong!',
                    'is_unique' => 'Nama Produk sudah ada!',
                ]
            ],

            'pemilik' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Nama Pemilik tidak boleh kosong!'
                ]
            ],

            'nomor_hp' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Nomor HP/WA tidak boleh kosong!'
                ]
            ],

            'harga' => [
                'rules' => 'required|numeric',
                'errors' => [
                    'required' => 'Harga tidak boleh kosong!',
                    'numeric' => 'Harga harus berupa angka!'
                ]
            ],

            'deskripsi' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Deskripsi tidak boleh kosong!'
                ]
            ],

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
            // Jika validasi gagal, kembalikan ke halaman form create dengan pesan error
            return redirect()->to(base_url('dashboard/umkm/create'))->withInput()->with('errors', $this->validator->getErrors());
        }

        // Mengambil file gambar dari form
        $gambar = $this->request->getFile('gambar');
        $namaGambar = $gambar->getRandomName();
        $gambar->move('img/umkm', $namaGambar);

        // Membuat slug dari nama produk
        $namaProduk = $this->request->getVar('nama');
        $slug = url_title($namaProduk, '-', true);

        // Menyimpan data produk UMKM ke database
        $save = $this->umkmModel->save([
            'nama'          => $namaProduk,
            'slug'          => $slug,
            'pemilik'       => $this->request->getVar('pemilik'),
            'nomor_hp'      => $this->request->getVar('nomor_hp'),
            'instagram'     => $this->request->getVar('instagram'),
            'harga'         => $this->request->getVar('harga'),
            'deskripsi'     => $this->request->getVar('deskripsi'),
            'viewer'        => 0,
            'gambar'        => $namaGambar,
            'user_id'       => $this->request->getVar('user_id'),
            'created_at'    => Time::now('Asia/Singapore', 'en_US'),
            'updated_at'    => Time::now('Asia/Singapore', 'en_US'),
        ]);

        // Memeriksa apakah penyimpanan berhasil atau tidak, kemudian mengarahkan pengguna ke halaman produk UMKM dengan pesan sukses atau gagal
        if ($save !== false) {
            return redirect()->to(base_url('dashboard/umkm'))->with('success-message', 'Produk UMKM berhasil ditambahkan.');
        } else {
            return redirect()->to(base_url('dashboard/umkm/create'))->with('error-message', 'Produk UMKM gagal ditambahkan.');
        }
    }

    public function edit($slug)
    {
        // Mendapatkan data situs
        $situs = $this->situsModel->findAll(1);

        if (empty($situs)) {
            return redirect()->to(base_url('404-not-found'));
        } else {
            $umkm = $this->getSlug($slug);

            if (!$umkm) {
                return redirect()->to(base_url('dashboard/umkm'))->with('warning-message', 'Data tidak ditemukan.');
            } else {
                $data = [
                    'situs' => $situs,
                    'umkm' => $umkm,
                    'title' => 'Edit Produk UMKM',
                ];

                return view('admin/umkm/edit', $data);
            }
        }
    }

    public function update($slug)
    {
        // Mengambil data produk UMKM berdasarkan slug
        $umkm = $this->getSlug($slug);

        // Ambil nama lama dan nama baru dari form
        $namaProdukLama = $umkm['nama'];
        $namaProdukBaru = $this->request->getVar('nama');

        // Menentukan aturan validasi berdasarkan apakah nama produk baru sama dengan nama produk lama
        if ($namaProdukBaru !== $namaProdukLama) {
            $ruleUMKM = 'required|is_unique[umkm.nama]';
        } else {
            $ruleUMKM = 'required';
        }

        // Validasi input
        if (!$this->validate([
            'nama' => [
                'rules' => $ruleUMKM,
                'errors' => [
                    'required' => 'Nama Produk tidak boleh kosong!',
                    'is_unique' => 'Nama Produk sudah ada!',
                ]
            ],

            'pemilik' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Nama Pemilik tidak boleh kosong!'
                ]
            ],

            'nomor_hp' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Nomor HP/WA tidak boleh kosong!'
                ]
            ],

            'harga' => [
                'rules' => 'required|numeric',
                'errors' => [
                    'required' => 'Harga tidak boleh kosong!',
                    'numeric' => 'Harga harus berupa angka!'
                ]
            ],

            'deskripsi' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Deskripsi tidak boleh kosong!'
                ]
            ],

            'gambar' => [
                'rules' => 'max_size[gambar,1024]|is_image[gambar]|mime_in[gambar,image/jpg,image/jpeg,image/png]',
                'errors' => [
                    'max_size'  => 'Ukuran gambar maksimal 1MB!',
                    'is_image'  => 'Format tidak didukung!',
                    'mime_in'   => 'Yang Anda unggah bukan gambar!'
                ]
            ]
        ])) {
            // Jika validasi gagal, kembali ke halaman form edit dengan pesan error
            return redirect()->to(base_url('dashboard/umkm/edit/') . $slug)->withInput()->with('errors', $this->validator->getErrors());
        }

        // Mengambil file gambar dari input form
        $gambar = $this->request->getFile('gambar');
        $gambarLama = $this->request->getVar('gambarLama');

        // Memeriksa apakah gambar baru diunggah
        if ($gambar->getError() == 4) {
            $namaGambar = $gambarLama;
        } else {
            // Jika gambar baru diunggah, simpan gambar baru ke direktori
            $namaGambar = $gambar->getRandomName();
            $gambar->move('img/umkm', $namaGambar);

            // Hapus gambar lama jika bukan gambar default
            if ($gambarLama != 'default.svg') {
                unlink('img/umkm/' . $gambarLama);
            }
        }

        // Membuat slug baru dari nama produk baru
        $slug = url_title($namaProdukBaru, '-', true);

        // Update data produk UMKM ke dalam database
        $update = $this->umkmModel->update($umkm['id'], [
            'nama'          => $namaProdukBaru,
            'slug'          => $slug,
            'pemilik'       => $this->request->getVar('pemilik'),
            'nomor_hp'      => $this->request->getVar('nomor_hp'),
            'instagram'     => $this->request->getVar('instagram'),
            'harga'         => $this->request->getVar('harga'),
            'deskripsi'     => $this->request->getVar('deskripsi'),
            'gambar'        => $namaGambar,
            'updated_at'    => Time::now('Asia/Singapore', 'en_US'),
        ]);

        // Memeriksa apakah proses update berhasil atau tidak, kemudian arahkan pengguna ke halaman produk UMKM dengan pesan sukses atau gagal
        if ($update !== false) {
            return redirect()->to(base_url('dashboard/umkm'))->with('success-message', 'Data berhasil diperbarui.');
        } else {
            return redirect()->to(base_url('dashboard/umkm/edit/') . $slug)->with('error-message', 'Data gagal diperbarui.');
        }
    }

    public function delete($id)
    {
        // Mengambil data umkm berdasarkan ID
        $umkm = $this->umkmModel->find($id);

        if ($umkm) {
            $umkm_id = $umkm['id'];

            // Menghapus semua komentar terkait dengan umkm
            $komentar = $this->komentarUMKMModel->where('umkm_id', $umkm_id)->findAll();

            if ($komentar) {
                foreach ($komentar as $k) {
                    $komentar_id = $k['id'];

                    // Menghapus semua balasan komentar terkait dengan komentar
                    $balasanKomentar = $this->komentarBalasanUMKMModel->where('komentar_umkm_id', $komentar_id)->findAll();

                    if ($balasanKomentar) {
                        foreach ($balasanKomentar as $b) {
                            $balasan_id = $b['id'];

                            // Menghapus balasan komentar
                            $this->komentarBalasanUMKMModel->delete($balasan_id);
                        }
                    }

                    // Menghapus komentar
                    $this->komentarUMKMModel->delete($komentar_id);
                }
            }
        }

        // Menghapus gambar terkait dengan umkm jika bukan gambar default
        if ($umkm['gambar'] != 'default.svg') {
            unlink('img/umkm/' . $umkm['gambar']);
        }

        // Menghapus umkm dari database
        $delete = $this->umkmModel->delete($id);

        // Memeriksa apakah penghapusan berhasil atau tidak, kemudian mengarahkan pengguna ke halaman umkm dengan pesan sukses atau gagal
        if ($delete !== false) {
            return redirect()->to(base_url('dashboard/umkm'))->with('success-message', 'UMKM berhasil dihapus.');
        } else {
            return redirect()->to(base_url('dashboard/umkm'))->with('error-message', 'UMKM gagal dihapus.');
        }
    }
}
