<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\PengumumanModel;
use App\Models\SitusModel;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\I18n\Time;
use Myth\Auth\Models\UserModel;

class Pengumuman extends BaseController
{
    protected $situsModel;
    protected $pengumumanModel;
    protected $userModel;

    public function __construct()
    {
        $this->situsModel           = new SitusModel();
        $this->pengumumanModel      = new PengumumanModel();
        $this->userModel            = new UserModel();
    }

    private function getSlug($slug)
    {
        return $this->pengumumanModel->where('slug', $slug)->first();
    }

    public function index()
    {
        // Mendapatkan data situs
        $situs = $this->situsModel->findAll(1);

        if (empty($situs) || user()->level == 'kepala dusun') {
            return redirect()->to(base_url('404-not-found'));
        } else {
            $pengumuman = $this->pengumumanModel->orderBy('created_at', 'DESC')->findAll();

            foreach ($pengumuman as &$item) {
                $user = $this->userModel->find($item['user_id']);
                $item['penulis'] = $user ? $user->fullname : 'Tidak Diketahui';
            }

            $data = [
                'situs'         => $situs,
                'pengumuman'    => $pengumuman,
                'users'         => $this->userModel->findAll(),
                'title'         => 'Pengumuman',
            ];

            return view('admin/pengumuman/index', $data);
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
                'title' => 'Tambah Pengumuman',
            ];

            return view('admin/pengumuman/create', $data);
        }
    }

    public function save()
    {
        // Validasi input sebelum menyimpan data pengumuman
        if (!$this->validate([
            'judul' => [
                'rules' => 'required|is_unique[pengumuman.judul]', // Memastikan judul pengumuman adalah unik
                'errors' => [
                    'required' => 'Judul tidak boleh kosong!', // Pesan kesalahan jika judul kosong
                    'is_unique' => 'Judul sudah ada!' // Pesan kesalahan jika judul sudah ada di database
                ]
            ],

            'deskripsi' => [
                'rules' => 'required', // Memastikan deskripsi pengumuman diisi
                'errors' => [
                    'required' => 'Isi pengumuman tidak boleh kosong!' // Pesan kesalahan jika deskripsi kosong
                ]
            ],
        ])) {
            // Jika validasi gagal, kembalikan pengguna ke halaman pembuatan pengumuman dengan pesan kesalahan dan input sebelumnya
            return redirect()->to(base_url('dashboard/pengumuman/create'))->withInput()->with('errors', $this->validator->getErrors());
        }

        // Menyiapkan data untuk disimpan
        $judul = $this->request->getVar('judul');
        $slug = url_title($judul, '-', true); // Membuat slug berdasarkan judul pengumuman

        // Menyimpan data pengumuman ke dalam database
        $save = $this->pengumumanModel->save([
            'judul'         => $judul,
            'slug'          => $slug,
            'deskripsi'     => $this->request->getVar('deskripsi'),
            'viewer'        => 0, // Jumlah viewer awal diatur menjadi 0
            'user_id'       => $this->request->getVar('user_id'), // Mengambil user_id dari form
            'created_at'    => Time::now('Asia/Singapore', 'id_ID'), // Menyimpan waktu pembuatan dalam zona waktu Asia/Singapore dengan format id_ID
            'updated_at'    => Time::now('Asia/Singapore', 'id_ID'), // Menyimpan waktu pembaruan dalam zona waktu Asia/Singapore dengan format id_ID
        ]);

        // Mengembalikan respons berdasarkan keberhasilan penyimpanan data pengumuman
        if ($save !== false) {
            return redirect()->to(base_url('dashboard/pengumuman'))->with('success-message', 'Pengumuman berhasil ditambahkan.'); // Jika penyimpanan berhasil, beri pesan sukses
        } else {
            return redirect()->to(base_url('dashboard/pengumuman/create'))->with('error-message', 'Pengumuman gagal ditambahkan.'); // Jika penyimpanan gagal, beri pesan kesalahan
        }
    }


    public function edit($slug)
    {
        // Mendapatkan data situs
        $situs = $this->situsModel->findAll(1);

        if (empty($situs) || user()->level == 'kepala dusun') {
            return redirect()->to(base_url('404-not-found'));
        } else {
            $pengumuman = $this->getSlug($slug);

            if (!$pengumuman) {
                return redirect()->to(base_url('dashboard/pengumuman'))->with('warning-message', 'Data tidak ditemukan.');
            } else {
                $data = [
                    'situs'         => $situs,
                    'pengumuman'    => $pengumuman,
                    'title'         => 'Edit Pengumuman',
                ];

                return view('admin/pengumuman/edit', $data);
            }
        }
    }

    public function update($slug)
    {
        // Mendapatkan data pengumuman berdasarkan slug
        $pengumuman = $this->getSlug($slug);

        // Menyimpan judul pengumuman lama dan baru
        $judulLama = $pengumuman['judul'];
        $judulBaru = $this->request->getVar('judul');

        // Menentukan aturan validasi untuk judul berdasarkan perubahan
        if ($judulBaru !== $judulLama) {
            $ruleJudul = 'required|is_unique[pengumuman.judul]'; // Memastikan judul baru adalah unik jika berbeda dari sebelumnya
        } else {
            $ruleJudul = 'required'; // Jika tidak ada perubahan, judul tetap harus diisi
        }

        // Validasi input sebelum memperbarui data pengumuman
        if (!$this->validate([
            'judul' => [
                'rules' => $ruleJudul,
                'errors' => [
                    'required' => 'Judul tidak boleh kosong!', // Pesan kesalahan jika judul kosong
                    'is_unique' => 'Judul sudah ada!' // Pesan kesalahan jika judul sudah ada di database
                ]
            ],

            'deskripsi' => [
                'rules' => 'required', // Memastikan deskripsi pengumuman diisi
                'errors' => [
                    'required' => 'Isi pengumuman tidak boleh kosong!' // Pesan kesalahan jika deskripsi kosong
                ]
            ],
        ])) {
            // Jika validasi gagal, kembalikan pengguna ke halaman edit pengumuman dengan pesan kesalahan dan input sebelumnya
            return redirect()->to(base_url('dashboard/pengumuman/edit/') . $slug)->withInput()->with('errors', $this->validator->getErrors());
        }

        // Menyiapkan slug baru berdasarkan judul baru
        $slug = url_title($judulBaru, '-', true);

        // Memperbarui data pengumuman dalam database
        $update = $this->pengumumanModel->update($pengumuman['id'], [
            'judul'         => $judulBaru,
            'slug'          => $slug,
            'deskripsi'     => $this->request->getVar('deskripsi'),
            'updated_at'    => Time::now('Asia/Singapore', 'id_ID'), // Menyimpan waktu pembaruan dalam zona waktu Asia/Singapore dengan format id_ID
        ]);

        // Mengembalikan respons berdasarkan keberhasilan pembaruan data pengumuman
        if ($update !== false) {
            return redirect()->to(base_url('dashboard/pengumuman'))->with('success-message', 'Pengumuman berhasil diperbarui.'); // Jika pembaruan berhasil, beri pesan sukses
        } else {
            return redirect()->to(base_url('dashboard/pengumuman/edit/') . $slug)->with('error-message', 'Pengumuman gagal diperbarui.'); // Jika pembaruan gagal, beri pesan kesalahan
        }
    }

    public function delete($id)
    {
        // Menghapus data pengumuman dari database berdasarkan ID
        $delete = $this->pengumumanModel->delete($id);

        // Mengembalikan respons berdasarkan keberhasilan penghapusan data
        if ($delete !== false) {
            return redirect()->to(base_url('dashboard/pengumuman'))->with('success-message', 'Pengumuman berhasil dihapus.'); // Jika penghapusan berhasil, beri pesan sukses
        } else {
            return redirect()->to(base_url('dashboard/pengumuman'))->with('error-message', 'Pengumuman gagal dihapus.'); // Jika penghapusan gagal, beri pesan kesalahan
        }
    }
}
