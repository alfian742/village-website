<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\KomentarBalasanPariwisataModel;
use App\Models\KomentarPariwisataModel;
use App\Models\PariwisataModel;
use App\Models\SitusModel;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\I18n\Time;
use Myth\Auth\Models\UserModel;

class Pariwisata extends BaseController
{
    protected $situsModel;
    protected $pariwisataModel;
    protected $komentarPariwisataModel;
    protected $komentarBalasanPariwisataModel;
    protected $userModel;

    public function __construct()
    {
        $this->situsModel                       = new SitusModel();
        $this->pariwisataModel                  = new PariwisataModel();
        $this->komentarPariwisataModel          = new KomentarPariwisataModel();
        $this->komentarBalasanPariwisataModel   = new KomentarBalasanPariwisataModel();
        $this->userModel                        = new UserModel();
    }

    private function getSlug($slug)
    {
        return $this->pariwisataModel->where('slug', $slug)->first();
    }

    public function index()
    {
        // Mendapatkan data situs
        $situs = $this->situsModel->findAll(1);

        if (empty($situs)) {
            return redirect()->to(base_url('404-not-found'));
        } else {
            $pariwisata = $this->pariwisataModel->orderBy('created_at', 'DESC')->findAll();

            foreach ($pariwisata as &$item) {
                $user = $this->userModel->find($item['user_id']);
                $item['penulis'] = $user ? $user->fullname : 'Tidak Diketahui';
            }

            $data = [
                'situs'         => $situs,
                'pariwisata'    => $pariwisata,
                'title'         => 'Daftar Pariwisata',
            ];

            return view('admin/pariwisata/index', $data);
        }
    }

    public function create()
    { // Mendapatkan data situs
        $situs = $this->situsModel->findAll(1);

        if (empty($situs)) {
            return redirect()->to(base_url('404-not-found'));
        } else {
            $data = [
                'situs' => $situs,
                'title' => 'Tambah Pariwisata',
            ];

            return view('admin/pariwisata/create', $data);
        }
    }

    public function save()
    {
        // Validasi input
        if (!$this->validate([
            'judul' => [
                'rules' => 'required|is_unique[pariwisata.judul]',
                'errors' => [
                    'required' => 'Judul tidak boleh kosong!',
                    'is_unique' => 'Judul sudah ada!'
                ]
            ],
            'deskripsi' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Isi pariwisata tidak boleh kosong!'
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
            // Jika validasi gagal, kembalikan ke halaman pembuatan pariwisata dengan pesan kesalahan
            return redirect()->to(base_url('dashboard/pariwisata/create'))->withInput()->with('errors', $this->validator->getErrors());
        }

        // Ambil file gambar dari form
        $gambar = $this->request->getFile('gambar');
        // Generate nama acak untuk gambar
        $namaGambar = $gambar->getRandomName();
        // Pindahkan gambar ke direktori yang ditentukan
        $gambar->move('img/pariwisata', $namaGambar);

        // Ambil data dari form
        $judul = $this->request->getVar('judul');
        $slug = url_title($judul, '-', true);

        // Simpan data pariwisata ke dalam database
        $save = $this->pariwisataModel->save([
            'judul'         => $judul,
            'slug'          => $slug,
            'deskripsi'     => $this->request->getVar('deskripsi'),
            'viewer'        => 0,
            'gambar'        => $namaGambar,
            'user_id'       => $this->request->getVar('user_id'),
            'status'        => $this->request->getVar('status'),
            'created_at'    => Time::now('Asia/Singapore', 'id_ID'),
            'updated_at'    => Time::now('Asia/Singapore', 'id_ID'),
        ]);

        // Periksa apakah proses penyimpanan berhasil
        if ($save !== false) {
            // Jika berhasil, kembalikan ke halaman pariwisata dengan pesan sukses
            return redirect()->to(base_url('dashboard/pariwisata'))->with('success-message', 'Pariwisata berhasil ditambahkan.');
        } else {
            // Jika gagal, kembalikan ke halaman pembuatan pariwisata dengan pesan kesalahan
            return redirect()->to(base_url('dashboard/pariwisata/create'))->with('error-message', 'Pariwisata gagal ditambahkan.');
        }
    }

    public function edit($slug)
    {
        // Mendapatkan data situs
        $situs = $this->situsModel->findAll(1);

        if (empty($situs)) {
            return redirect()->to(base_url('404-not-found'));
        } else {
            $pariwisata = $this->getSlug($slug);

            if (!$pariwisata) {
                return redirect()->to(base_url('dashboard/pariwisata'))->with('warning-message', 'Data tidak ditemukan.');
            } else {
                $data = [
                    'situs'         => $situs,
                    'pariwisata'    => $pariwisata,
                    'title'         => 'Edit Pariwisata',
                ];

                return view('admin/pariwisata/edit', $data);
            }
        }
    }

    public function update($slug)
    {
        // Dapatkan data pariwisata berdasarkan slug
        $pariwisata = $this->getSlug($slug);

        // Ambil judul lama dan judul baru dari form
        $judulLama = $pariwisata['judul'];
        $judulBaru = $this->request->getVar('judul');

        // Tentukan aturan validasi untuk judul baru
        if ($judulBaru !== $judulLama) {
            $ruleJudul = 'required|is_unique[pariwisata.judul]';
        } else {
            $ruleJudul = 'required';
        }

        // Lakukan validasi terhadap input yang diterima
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
                    'required' => 'Isi pariwisata tidak boleh kosong!'
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
            // Jika validasi gagal, kembalikan ke halaman edit pariwisata dengan pesan kesalahan
            return redirect()->to(base_url('dashboard/pariwisata/edit/') . $slug)->withInput()->with('errors', $this->validator->getErrors());
        }

        // Ambil file gambar dari form
        $gambar = $this->request->getFile('gambar');
        $gambarLama = $this->request->getVar('gambarLama');

        // Proses pengolahan gambar baru
        if ($gambar->getError() == 4) {
            $namaGambar = $gambarLama;
        } else {
            $namaGambar = $gambar->getRandomName();
            $gambar->move('img/pariwisata', $namaGambar);
            if ($gambarLama != 'default.svg') {
                unlink('img/pariwisata/' . $gambarLama);
            }
        }

        // Buat slug baru berdasarkan judul baru
        $slug = url_title($judulBaru, '-', true);

        // Update data pariwisata di database
        $update = $this->pariwisataModel->update($pariwisata['id'], [
            'judul'         => $judulBaru,
            'slug'          => $slug,
            'deskripsi'     => $this->request->getVar('deskripsi'),
            'gambar'        => $namaGambar,
            'status'        => $this->request->getVar('status'),
            'updated_at'    => Time::now('Asia/Singapore', 'id_ID'),
        ]);

        // Periksa apakah proses update berhasil
        if ($update !== false) {
            // Jika berhasil, kembalikan ke halaman pariwisata dengan pesan sukses
            return redirect()->to(base_url('dashboard/pariwisata'))->with('success-message', 'Pariwisata berhasil diperbarui.');
        } else {
            // Jika gagal, kembalikan ke halaman edit pariwisata dengan pesan kesalahan
            return redirect()->to(base_url('dashboard/pariwisata/edit/') . $slug)->with('error-message', 'Pariwisata gagal diperbarui.');
        }
    }

    public function delete($id)
    {
        // Mengambil data pariwisata berdasarkan ID
        $pariwisata = $this->pariwisataModel->find($id);

        if ($pariwisata) {
            $pariwisata_id = $pariwisata['id'];

            // Menghapus semua komentar terkait dengan pariwisata
            $komentar = $this->komentarPariwisataModel->where('pariwisata_id', $pariwisata_id)->findAll();

            if ($komentar) {
                foreach ($komentar as $k) {
                    $komentar_id = $k['id'];

                    // Menghapus semua balasan komentar terkait dengan komentar
                    $balasanKomentar = $this->komentarBalasanPariwisataModel->where('komentar_pariwisata_id', $komentar_id)->findAll();

                    if ($balasanKomentar) {
                        foreach ($balasanKomentar as $b) {
                            $balasan_id = $b['id'];

                            // Menghapus balasan komentar
                            $this->komentarBalasanPariwisataModel->delete($balasan_id);
                        }
                    }

                    // Menghapus komentar
                    $this->komentarPariwisataModel->delete($komentar_id);
                }
            }
        }

        // Menghapus gambar terkait dengan pariwisata jika bukan gambar default
        if ($pariwisata['gambar'] != 'default.svg') {
            unlink('img/pariwisata/' . $pariwisata['gambar']);
        }

        // Menghapus pariwisata dari database
        $delete = $this->pariwisataModel->delete($id);

        // Memeriksa apakah penghapusan berhasil atau tidak, kemudian mengarahkan pengguna ke halaman pariwisata dengan pesan sukses atau gagal
        if ($delete !== false) {
            return redirect()->to(base_url('dashboard/pariwisata'))->with('success-message', 'Pariwisata berhasil dihapus.');
        } else {
            return redirect()->to(base_url('dashboard/pariwisata'))->with('error-message', 'Pariwisata gagal dihapus.');
        }
    }
}
