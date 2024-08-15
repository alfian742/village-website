<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\BeritaModel;
use App\Models\KategoriModel;
use App\Models\KomentarBalasanBeritaModel;
use App\Models\KomentarBeritaModel;
use App\Models\SitusModel;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\I18n\Time;
use Myth\Auth\Models\UserModel;

class Berita extends BaseController
{
    protected $situsModel;
    protected $beritaModel;
    protected $kategoriModel;
    protected $komentarBeritaModel;
    protected $komentarBalasanBeritaModel;
    protected $userModel;

    public function __construct()
    {
        $this->situsModel                   = new SitusModel();
        $this->beritaModel                  = new BeritaModel();
        $this->kategoriModel                = new KategoriModel();
        $this->komentarBeritaModel          = new KomentarBeritaModel();
        $this->komentarBalasanBeritaModel   = new KomentarBalasanBeritaModel();
        $this->userModel                    = new UserModel();
    }

    private function getSlug($slug)
    {
        return $this->beritaModel->where('slug', $slug)->first();
    }

    public function index()
    {
        // Mendapatkan data situs
        $situs = $this->situsModel->findAll(1);

        if (empty($situs) || user()->level == 'kepala dusun') {
            return redirect()->to(base_url('404-not-found'));
        } else {
            $berita = $this->beritaModel->orderBy('created_at', 'DESC')->findAll();

            foreach ($berita as &$item) {
                $kategori = $this->kategoriModel->find($item['kategori_id']);
                $item['kategori_berita'] = $kategori ? $kategori['kategori'] : 'Tidak Ada Kategori';

                $user = $this->userModel->find($item['user_id']);
                $item['penulis'] = $user ? $user->fullname : 'Tidak Diketahui';
            }

            $data = [
                'situs'     => $situs,
                'berita'    => $berita,
                'title'     => 'Daftar Berita',
            ];

            return view('admin/berita/index', $data);
        }
    }

    public function create()
    {
        // Mendapatkan data situs
        $situs = $this->situsModel->findAll(1);

        if (empty($situs) || user()->level == 'kepala dusun') {
            return redirect()->to(base_url('404-not-found'));
        } else {
            $data = [
                'situs'     => $situs,
                'kategori'  => $this->kategoriModel->orderBy('kategori', 'ASC')->findAll(),
                'title'     => 'Tambah Berita',
            ];

            return view('admin/berita/create', $data);
        }
    }

    public function save()
    {
        // Memvalidasi inputan yang diterima dari form
        if (!$this->validate([
            'judul' => [
                'rules' => 'required|is_unique[berita.judul]',
                'errors' => [
                    'required' => 'Judul tidak boleh kosong!',
                    'is_unique' => 'Judul sudah ada!'
                ]
            ],
            'deskripsi' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Isi berita tidak boleh kosong!'
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
            // Jika validasi gagal, kembalikan pengguna ke halaman pembuatan berita dengan pesan kesalahan dan input sebelumnya
            return redirect()->to(base_url('dashboard/berita/create'))->withInput()->with('errors', $this->validator->getErrors());
        }

        // Mengunggah gambar ke direktori yang ditentukan dan mendapatkan nama gambar yang diacak
        $gambar     = $this->request->getFile('gambar');
        $namaGambar = $gambar->getRandomName();
        $gambar->move('img/berita', $namaGambar);

        // Mendapatkan nilai inputan untuk judul dan membuat slug
        $judul = $this->request->getVar('judul');
        $slug = url_title($judul, '-', true);

        // Menyimpan data berita ke dalam database
        $save = $this->beritaModel->save([
            'judul'         => $judul,
            'slug'          => $slug,
            'deskripsi'     => $this->request->getVar('deskripsi'),
            'viewer'        => 0,
            'gambar'        => $namaGambar,
            'user_id'       => $this->request->getVar('user_id'),
            'kategori_id'   => $this->request->getVar('kategori_id'),
            'status'        => $this->request->getVar('status'),
            'created_at'    => Time::now('Asia/Singapore', 'id_ID'),
            'updated_at'    => Time::now('Asia/Singapore', 'id_ID'),
        ]);

        // Memeriksa apakah data berhasil disimpan atau tidak, kemudian mengarahkan pengguna ke halaman berita dengan pesan sukses atau gagal
        if ($save !== false) {
            return redirect()->to(base_url('dashboard/berita'))->with('success-message', "Berita berhasil ditambahkan.");
        } else {
            return redirect()->to(base_url('dashboard/berita/create'))->with('error-message', "Berita gagal ditambahkan.");
        }
    }

    public function edit($slug)
    {
        // Mendapatkan data situs
        $situs = $this->situsModel->findAll(1);

        if (empty($situs) || user()->level == 'kepala dusun') {
            return redirect()->to(base_url('404-not-found'));
        } else {
            $berita = $this->getSlug($slug);

            if (!$berita) {
                return redirect()->to(base_url('dashboard/berita'))->with('warning-message', "Data tidak ditemukan.");
            } else {
                $data = [
                    'situs'     => $situs,
                    'berita'    => $berita,
                    'kategori'  => $this->kategoriModel->orderBy('kategori', 'ASC')->findAll(),
                    'title'     => 'Edit Berita',
                ];

                return view('admin/berita/edit', $data);
            }
        }
    }

    public function update($slug)
    {
        // Mengambil data berita berdasarkan slug yang diberikan
        $berita = $this->getSlug($slug);

        // Memeriksa perbedaan judul lama dan judul baru untuk menentukan aturan validasi
        $judulLama = $berita['judul'];
        $judulBaru = $this->request->getVar('judul');

        if ($judulBaru !== $judulLama) {
            $ruleJudul = 'required|is_unique[berita.judul]';
        } else {
            $ruleJudul = 'required';
        }

        // Validasi inputan yang diterima dari form
        if (!$this->validate([
            'judul' => [
                'rules' => $ruleJudul,
                'errors' => [
                    'required' => 'Judul tidak boleh kosong!',
                    'is_unique' => 'Judul sudah ada!'
                ]
            ],
            'deskripsi' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Isi berita tidak boleh kosong!'
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
            // Jika validasi gagal, kembalikan pengguna ke halaman edit berita dengan pesan kesalahan dan input sebelumnya
            return redirect()->to(base_url('dashboard/berita/edit/') . $slug)->withInput()->with('errors', $this->validator->getErrors());
        }

        // Memproses gambar baru jika diunggah
        $gambar     = $this->request->getFile('gambar');
        $gambarLama = $this->request->getVar('gambarLama');

        if ($gambar->getError() == 4) {
            $namaGambar = $gambarLama; // Jika tidak ada gambar baru diunggah, gunakan gambar lama
        } else {
            $namaGambar = $gambar->getRandomName();
            $gambar->move('img/berita', $namaGambar);
            if ($gambarLama != 'default.svg') {
                unlink('img/berita/' . $gambarLama); // Hapus gambar lama dari direktori
            }
        }

        // Membuat slug baru berdasarkan judul baru
        $slug = url_title($judulBaru, '-', true);

        // Menyimpan data berita yang diperbarui ke dalam database
        $update = $this->beritaModel->update($berita['id'], [
            'judul'         => $judulBaru,
            'slug'          => $slug,
            'deskripsi'     => $this->request->getVar('deskripsi'),
            'gambar'        => $namaGambar,
            'kategori_id'   => $this->request->getVar('kategori_id'),
            'status'        => $this->request->getVar('status'),
            'updated_at'    => Time::now('Asia/Singapore', 'id_ID'),
        ]);

        // Memeriksa apakah data berhasil diperbarui atau tidak, kemudian mengarahkan pengguna ke halaman berita dengan pesan sukses atau gagal
        if ($update !== false) {
            return redirect()->to(base_url('dashboard/berita'))->with('success-message', "Berita berhasil diperbarui.");
        } else {
            return redirect()->to(base_url('dashboard/berita/edit/') . $slug)->with('error-message', "Berita gagal diperbarui.");
        }
    }

    public function delete($id)
    {
        // Mengambil data berita berdasarkan ID
        $berita = $this->beritaModel->find($id);

        if ($berita) {
            $berita_id = $berita['id'];

            // Menghapus semua komentar terkait dengan berita
            $komentar = $this->komentarBeritaModel->where('berita_id', $berita_id)->findAll();

            if ($komentar) {
                foreach ($komentar as $k) {
                    $komentar_id = $k['id'];

                    // Menghapus semua balasan komentar terkait dengan komentar
                    $balasanKomentar = $this->komentarBalasanBeritaModel->where('komentar_berita_id', $komentar_id)->findAll();

                    if ($balasanKomentar) {
                        foreach ($balasanKomentar as $b) {
                            $balasan_id = $b['id'];

                            // Menghapus balasan komentar
                            $this->komentarBalasanBeritaModel->delete($balasan_id);
                        }
                    }

                    // Menghapus komentar
                    $this->komentarBeritaModel->delete($komentar_id);
                }
            }
        }

        // Menghapus gambar terkait dengan berita jika bukan gambar default
        if ($berita['gambar'] != 'default.svg') {
            unlink('img/berita/' . $berita['gambar']);
        }

        // Menghapus berita dari database
        $delete = $this->beritaModel->delete($id);

        // Memeriksa apakah penghapusan berhasil atau tidak, kemudian mengarahkan pengguna ke halaman berita dengan pesan sukses atau gagal
        if ($delete !== false) {
            return redirect()->to(base_url('dashboard/berita'))->with('success-message', "Berita berhasil dihapus.");
        } else {
            return redirect()->to(base_url('dashboard/berita'))->with('error-message', "Berita gagal dihapus.");
        }
    }
}
