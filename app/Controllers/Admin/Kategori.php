<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\BeritaModel;
use App\Models\KategoriModel;
use App\Models\SitusModel;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\I18n\Time;

class Kategori extends BaseController
{
    protected $situsModel;
    protected $beritaModel;
    protected $kategoriModel;

    public function __construct()
    {
        $this->situsModel       = new SitusModel();
        $this->beritaModel      = new BeritaModel();
        $this->kategoriModel    = new KategoriModel();
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
                'kategori'  => $this->kategoriModel->orderBy('kategori', 'ASC')->findAll(),
                'title'     => 'Kategori Berita',
            ];

            return view('admin/kategori/index', $data);
        }
    }

    public function save()
    {
        // Validasi input untuk kategori berita
        if (!$this->validate([
            'kategori' => [
                'rules' => 'required|is_unique[kategori.kategori]',
                'errors' => [
                    'required' => 'Nama kategori Berita tidak boleh kosong!',
                    'is_unique' => 'Kategori Berita sudah ada!'
                ]
            ],
        ])) {
            // Jika validasi gagal, kembalikan ke halaman sebelumnya dengan pesan kesalahan
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        // Mendapatkan data kategori dari request
        $kategori = $this->request->getVar('kategori');
        // Membuat slug dari nama kategori
        $slug = url_title($kategori, '-', true);

        // Menyimpan data kategori baru ke dalam database
        $save = $this->kategoriModel->save([
            'kategori'      => $kategori,
            'slug'          => $slug,
            'created_at'    => Time::now('Asia/Singapore', 'id_ID'),
            'updated_at'    => Time::now('Asia/Singapore', 'id_ID'),
        ]);

        // Memeriksa apakah proses penyimpanan berhasil atau tidak
        if ($save !== false) {
            // Jika berhasil, arahkan ke halaman kategori dengan pesan sukses
            return redirect()->to(base_url('dashboard/kategori-berita'))->with('success-message', 'Kategori Berita berhasil ditambahkan.');
        } else {
            // Jika gagal, arahkan ke halaman kategori dengan pesan kesalahan
            return redirect()->to(base_url('dashboard/kategori-berita'))->with('error-message', 'Kategori Berita gagal ditambahkan.');
        }
    }

    public function update($id)
    {
        // Mengambil data kategori berdasarkan ID
        $kategori = $this->kategoriModel->find($id);

        // Mengambil nama kategori lama dan baru dari request
        $kategoriLama = $kategori['kategori'];
        $kategoriBaru = $this->request->getVar('edit_kategori');

        // Menentukan aturan validasi berdasarkan perubahan nama kategori
        if ($kategoriBaru !== $kategoriLama) {
            $ruleKategori = 'required|is_unique[kategori.kategori]';
        } else {
            $ruleKategori = 'required';
        }

        // Validasi input untuk nama kategori
        if (!$this->validate([
            'edit_kategori' => [
                'rules' => $ruleKategori,
                'errors' => [
                    'required' => 'Nama kategori tidak boleh kosong!',
                    'is_unique' => 'Kategori sudah ada!'
                ]
            ],
        ])) {
            // Jika validasi gagal, kembalikan ke halaman sebelumnya dengan pesan kesalahan
            return redirect()->back()->withInput()->with('error-message-toast', $this->validator->getErrors());
        }

        // Membuat slug dari nama kategori baru
        $slug = url_title($kategoriBaru, '-', true);

        // Memperbarui data kategori dalam database
        $update = $this->kategoriModel->update($id, [
            'kategori'      => $kategoriBaru,
            'slug'          => $slug,
            'updated_at'    => Time::now('Asia/Singapore', 'id_ID'),
        ]);

        // Memeriksa apakah proses pembaruan berhasil atau tidak
        if ($update !== false) {
            // Jika berhasil, arahkan ke halaman kategori dengan pesan sukses
            return redirect()->to(base_url('dashboard/kategori-berita'))->with('success-message', 'Kategori Berita berhasil diperbarui.');
        } else {
            // Jika gagal, arahkan ke halaman kategori dengan pesan kesalahan
            return redirect()->to(base_url('dashboard/kategori-berita'))->with('error-message', 'Kategori Berita gagal diperbarui.');
        }
    }


    public function delete($id)
    {
        // Mencari semua berita yang terkait dengan kategori yang akan dihapus
        $berita = $this->beritaModel->where('kategori_id', $id)->findAll();

        // Menghapus kategori dari setiap berita yang terkait
        foreach ($berita as $b) {
            $this->beritaModel->update($b['id'], [
                'kategori_id' => 0, // Mengubah kategori menjadi 0 (kategori default)
                'updated_at' => Time::now('Asia/Singapore', 'id_ID'),
            ]);
        }

        // Menghapus kategori dari database
        $delete = $this->kategoriModel->delete($id);

        // Memeriksa apakah proses penghapusan berhasil atau tidak
        if ($delete) {
            // Jika berhasil, arahkan ke halaman kategori dengan pesan sukses
            return redirect()->to(base_url('dashboard/kategori-berita'))->with('success-message', 'Kategori Berita berhasil dihapus.');
        } else {
            // Jika gagal, arahkan ke halaman kategori dengan pesan kesalahan
            return redirect()->to(base_url('dashboard/kategori-berita'))->with('error-message', 'Kategori Berita gagal dihapus.');
        }
    }
}
