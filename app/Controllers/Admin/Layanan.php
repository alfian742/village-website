<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\LayananModel;
use App\Models\SitusModel;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\I18n\Time;
use Myth\Auth\Models\UserModel;

class Layanan extends BaseController
{
    protected $situsModel;
    protected $layananModel;
    protected $userModel;

    public function __construct()
    {
        $this->situsModel   = new SitusModel();
        $this->layananModel = new LayananModel();
        $this->userModel    = new UserModel();
    }

    private function getSlug($slug)
    {
        return $this->layananModel->where('slug', $slug)->first();
    }

    public function index()
    {
        // Mendapatkan data situs
        $situs = $this->situsModel->findAll(1);

        if (empty($situs) || user()->level == 'kepala dusun') {
            return redirect()->to(base_url('404-not-found'));
        } else {
            $layanan = $this->layananModel->orderBy('created_at', 'DESC')->findAll();

            foreach ($layanan as &$item) {
                $user = $this->userModel->find($item['user_id']);
                $item['penulis'] = $user ? $user->fullname : 'Tidak Diketahui';
            }

            $data = [
                'situs'     => $situs,
                'layanan'   => $layanan,
                'users'     => $this->userModel->findAll(),
                'title'     => 'Layanan',
            ];

            return view('admin/layanan/index', $data);
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
                'situs' => $situs,
                'title' => 'Tambah Layanan',
            ];

            return view('admin/layanan/create', $data);
        }
    }

    public function save()
    {
        // Validasi input
        if (!$this->validate([
            'nama_layanan' => [
                'rules' => 'required|is_unique[layanan.nama_layanan]',
                'errors' => [
                    'required' => 'Nama layanan tidak boleh kosong!',
                    'is_unique' => 'Nama layanan sudah ada!'
                ]
            ],
            'deskripsi' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Deskripsi tidak boleh kosong!'
                ]
            ],
        ])) {
            // Jika validasi gagal, kembalikan ke halaman dengan pesan kesalahan
            return redirect()->to(base_url('dashboard/layanan/create'))->withInput()->with('errors', $this->validator->getErrors());
        }

        // Ambil data dari form
        $nama_layanan = $this->request->getVar('nama_layanan');
        $slug = url_title($nama_layanan, '-', true);

        // Simpan data ke dalam database
        $save = $this->layananModel->save([
            'nama_layanan'  => $nama_layanan,
            'slug'          => $slug,
            'deskripsi'     => $this->request->getVar('deskripsi'),
            'viewer'        => 0, // Jumlah viewer awal diatur menjadi 0
            'user_id'       => $this->request->getVar('user_id'), // Mengambil user_id dari form
            'created_at'    => Time::now('Asia/Singapore', 'id_ID'),
            'updated_at'    => Time::now('Asia/Singapore', 'id_ID'),
        ]);

        // Periksa apakah penyimpanan berhasil
        if ($save !== false) {
            // Jika berhasil, kembalikan ke halaman daftar layanan dengan pesan sukses
            return redirect()->to(base_url('dashboard/layanan'))->with('success-message', 'Layanan berhasil ditambahkan.');
        } else {
            // Jika gagal, kembalikan ke halaman tambah layanan dengan pesan kesalahan
            return redirect()->to(base_url('dashboard/layanan/create'))->with('error-message', 'Layanan gagal ditambahkan.');
        }
    }

    public function edit($slug)
    {
        // Mendapatkan data situs
        $situs = $this->situsModel->findAll(1);

        if (empty($situs) || user()->level == 'kepala dusun') {
            return redirect()->to(base_url('404-not-found'));
        } else {
            $layanan =  $this->getSlug($slug);

            if (!$layanan) {
                return redirect()->to(base_url('dashboard/layanan'))->with('warning-message', 'Layanan tidak ditemukan.');
            } else {
                $data = [
                    'situs'     => $situs,
                    'layanan'   => $layanan,
                    'title'     => 'Edit Layanan',
                ];

                return view('admin/layanan/edit', $data);
            }
        }
    }

    public function update($slug)
    {
        // Dapatkan data layanan berdasarkan slug
        $layanan = $this->getSlug($slug);

        // Ambil nama layanan lama dan baru
        $layananLama = $layanan['nama_layanan'];
        $layananBaru = $this->request->getVar('nama_layanan');

        // Tentukan aturan validasi berdasarkan perubahan nama layanan
        if ($layananBaru !== $layananLama) {
            $ruleLayanan = 'required|is_unique[layanan.nama_layanan]';
        } else {
            $ruleLayanan = 'required';
        }

        // Lakukan validasi
        if (!$this->validate([
            'nama_layanan' => [
                'rules' => $ruleLayanan,
                'errors' => [
                    'required' => 'Nama layanan tidak boleh kosong!',
                    'is_unique' => 'Nama layanan sudah ada!'
                ]
            ],
            'deskripsi' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Deskripsi tidak boleh kosong!'
                ]
            ],
        ])) {
            // Jika validasi gagal, kembalikan ke halaman edit dengan pesan kesalahan
            return redirect()->to(base_url('dashboard/layanan/edit/') . $slug)->withInput()->with('errors', $this->validator->getErrors());
        }

        // Buat slug baru
        $slug = url_title($layananBaru, '-', true);

        // Lakukan pembaruan data layanan
        $update = $this->layananModel->update($layanan['id'], [
            'nama_layanan'  => $layananBaru,
            'slug'          => $slug,
            'deskripsi'     => $this->request->getVar('deskripsi'),
            'updated_at'    => Time::now('Asia/Singapore', 'id_ID'),
        ]);

        // Periksa apakah pembaruan berhasil
        if ($update !== false) {
            // Jika berhasil, kembalikan ke halaman daftar layanan dengan pesan sukses
            return redirect()->to(base_url('dashboard/layanan'))->with('success-message', 'Layanan berhasil diperbarui.');
        } else {
            // Jika gagal, kembalikan ke halaman edit dengan pesan kesalahan
            return redirect()->to(base_url('dashboard/layanan/edit/') . $slug)->with('error-message', 'Layanan gagal diperbarui.');
        }
    }

    public function delete($id)
    {
        // Hapus data layanan berdasarkan ID
        $delete = $this->layananModel->delete($id);

        // Periksa apakah penghapusan berhasil
        if ($delete !== false) {
            // Jika berhasil, kembalikan ke halaman daftar layanan dengan pesan sukses
            return redirect()->to(base_url('dashboard/layanan'))->with('success-message', 'Layanan berhasil dihapus.');
        } else {
            // Jika gagal, kembalikan ke halaman daftar layanan dengan pesan kesalahan
            return redirect()->to(base_url('dashboard/layanan'))->with('error-message', 'Layanan gagal dihapus.');
        }
    }
}
