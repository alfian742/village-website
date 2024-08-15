<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\KepalaDusunModel;
use App\Models\SitusModel;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\I18n\Time;
use Myth\Auth\Models\UserModel;
use Myth\Auth\Password;

class KepalaDusun extends BaseController
{
    protected $situsModel;
    protected $kepalaDusunModel;
    protected $userModel;

    public function __construct()
    {
        $this->situsModel       = new SitusModel();
        $this->kepalaDusunModel = new KepalaDusunModel();
        $this->userModel        = new UserModel();
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
                'kepala_dusun'  => $this->kepalaDusunModel->orderBy('nama', 'ASC')->findAll(),
                'title'         => 'Kepala Dusun/Lingkungan',
            ];

            return view('admin/kepala-dusun/index', $data);
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
                'title' => 'Tambah Kepala Dusun/Lingkungan',
            ];

            return view('admin/kepala-dusun/create', $data);
        }
    }

    public function save()
    {
        // Validasi input
        if (!$this->validate([
            'nama' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Nama tidak boleh kosong!'
                ]
            ],

            'nip' => [
                'rules' => 'permit_empty|numeric',
                'errors' => [
                    'numeric' => 'NIP harus berupa angka!'
                ]
            ],

            'foto' => [
                'rules' => 'max_size[foto,1024]|is_image[foto]|mime_in[foto,image/jpg,image/jpeg,image/png]',
                'errors' => [
                    'max_size'  => 'Ukuran foto maksimal 1MB!',
                    'is_image'  => 'Format tidak didukung!',
                    'mime_in'   => 'Yang Anda unggah bukan foto!'
                ]
            ]
        ])) {
            // Jika validasi gagal, kembalikan ke halaman pembuatan dengan pesan kesalahan
            return redirect()->to(base_url('dashboard/kepala-dusun/create'))->withInput()->with('errors', $this->validator->getErrors());
        }

        // Ambil file foto dari input
        $gambar = $this->request->getFile('foto');

        // Periksa apakah foto diunggah atau tidak
        if ($gambar->getError() == 4) {
            // Jika tidak ada foto yang diunggah, gunakan foto default
            $namaGambar = 'default.svg';
        } else {
            // Jika ada foto yang diunggah, simpan foto dengan nama acak
            $namaGambar = $gambar->getRandomName();
            $gambar->move('img/staff', $namaGambar);
        }

        // Buat ID unik untuk kepala dusun
        $staff_id       = uniqid();
        $random         = 'user' . substr($staff_id, 6);
        $randomEmail    = $random . '@gmail.com';
        $randomUsername = $random;

        // Simpan data kepala dusun ke database
        $save = $this->kepalaDusunModel->save([
            'nama'          => $this->request->getVar('nama'),
            'nip'           => $this->request->getVar('nip'),
            'deskripsi'     => $this->request->getVar('deskripsi'),
            'foto'          => $namaGambar,
            'staff_id'      => $staff_id,
            'created_at'    => Time::now('Asia/Singapore', 'id_ID'),
            'updated_at'    => Time::now('Asia/Singapore', 'id_ID'),
        ]);

        // Simpan data pengguna (user) ke database
        $saveUser = $this->userModel->save([
            'email'         => $randomEmail,
            'username'      => $randomUsername,
            'fullname'      => $this->request->getVar('nama'),
            'user_img'      => $namaGambar,
            'level'         => 'kepala dusun',
            'staff_id'      => $staff_id,
            'password_hash' => Password::hash('staff'), // Default password untuk kepala dusun
            'active'        => 1, // Kepala dusun secara default aktif
        ]);

        // Periksa apakah kedua penyimpanan berhasil
        if ($save !== false && $saveUser !== false) {
            // Jika berhasil, arahkan ke halaman daftar kepala dusun dengan pesan sukses
            return redirect()->to(base_url('dashboard/kepala-dusun'))->with('success-message', 'Kepala Dusun/Lingkungan berhasil ditambahkan.');
        } else {
            // Jika gagal, arahkan kembali ke halaman pembuatan dengan pesan kesalahan
            return redirect()->to(base_url('dashboard/kepala-dusun/create'))->with('error-message', 'Kepala Dusun/Lingkungan gagal ditambahkan.');
        }
    }

    public function edit($staff_id)
    {
        // Mendapatkan data situs
        $situs = $this->situsModel->findAll(1);

        if (empty($situs) || user()->level == 'staff' || user()->level == 'kepala dusun') {
            return redirect()->to(base_url('404-not-found'));
        } else {
            $kepalaDusun = $this->kepalaDusunModel->where('staff_id', $staff_id)->first();

            if (!$kepalaDusun) {
                return redirect()->to(base_url('dashboard/kepala-dusun'))->with('warning-message', 'Data tidak ditemukan.');
            } else {
                $data = [
                    'situs'         => $situs,
                    'kepala_dusun'  => $kepalaDusun,
                    'title'         => 'Edit Kepala Dusun/Lingkungan',
                ];

                return view('admin/kepala-dusun/edit', $data);
            }
        }
    }

    public function update($staff_id)
    {
        // Ambil data kepala dusun dan pengguna (user) terkait berdasarkan staff_id
        $kepalaDusun    = $this->kepalaDusunModel->where('staff_id', $staff_id)->first();
        $user           = $this->userModel->where('staff_id', $staff_id)->first();

        // Periksa apakah data user dan kepala dusun terkait ditemukan
        if ($user && $user->staff_id === $kepalaDusun['staff_id']) {
            // Validasi input
            if (!$this->validate([
                'nama' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'Nama tidak boleh kosong!'
                    ]
                ],

                'nip' => [
                    'rules' => 'permit_empty|numeric',
                    'errors' => [
                        'numeric' => 'NIP harus berupa angka!'
                    ]
                ],

                'foto' => [
                    'rules' => 'max_size[foto,1024]|is_image[foto]|mime_in[foto,image/jpg,image/jpeg,image/png]',
                    'errors' => [
                        'max_size'  => 'Ukuran foto maksimal 1MB!',
                        'is_image'  => 'Format tidak didukung!',
                        'mime_in'   => 'Yang Anda unggah bukan foto!'
                    ]
                ]
            ])) {
                // Jika validasi gagal, kembalikan ke halaman edit dengan pesan kesalahan
                return redirect()->to(base_url('dashboard/kepala-dusun/edit/' . $staff_id))->withInput()->with('errors', $this->validator->getErrors());
            }

            // Ambil file foto dari input
            $gambar     = $this->request->getFile('foto');
            $gambarLama = $this->request->getVar('fotoLama');

            // Periksa apakah ada file foto yang diunggah
            if ($gambar->getError() == 4) {
                // Jika tidak ada, gunakan foto lama
                $namaGambar = $gambarLama;
            } else {
                // Jika ada, simpan foto baru dengan nama acak
                $namaGambar = $gambar->getRandomName();
                $gambar->move('img/staff', $namaGambar);
                // Hapus foto lama jika bukan foto default
                if ($gambarLama != 'default.svg') {
                    unlink('img/staff/' . $gambarLama);
                }
            }

            // Lakukan update pada data kepala dusun
            $update = $this->kepalaDusunModel->update($kepalaDusun['id'], [
                'nama'          => $this->request->getVar('nama'),
                'nip'           => $this->request->getVar('nip'),
                'deskripsi'     => $this->request->getVar('deskripsi'),
                'foto'          => $namaGambar,
                'updated_at'    => Time::now('Asia/Singapore', 'id_ID'),
            ]);

            // Lakukan update pada data pengguna (user)
            $updateUser = $this->userModel->update($user->id, [
                'fullname'      => $this->request->getVar('nama'),
                'user_img'      => $namaGambar,
            ]);

            // Periksa apakah kedua penyimpanan berhasil
            if ($update !== false && $updateUser !== false) {
                // Jika berhasil, arahkan ke halaman daftar kepala dusun dengan pesan sukses
                return redirect()->to(base_url('dashboard/kepala-dusun'))->with('success-message', 'Kepala Dusun/Lingkungan berhasil diperbarui.');
            } else {
                // Jika gagal, arahkan kembali ke halaman edit dengan pesan kesalahan
                return redirect()->to(base_url('dashboard/kepala-dusun/edit/' . $staff_id))->with('error-message', 'Kepala Dusun/Lingkungan gagal diperbarui.');
            }
        } else {
            // Jika data tidak ditemukan atau user tidak sesuai dengan kepala dusun terkait, kembalikan dengan pesan kesalahan
            return redirect()->to(base_url('dashboard/kepala-dusun/edit/' . $staff_id))->with('error-message', 'Kepala Dusun/Lingkungan gagal diperbarui.');
        }
    }

    public function delete($staff_id)
    {
        // Ambil data kepala dusun dan pengguna (user) terkait berdasarkan staff_id
        $kepalaDusun    = $this->kepalaDusunModel->where('staff_id', $staff_id)->first();
        $user           = $this->userModel->where('staff_id', $staff_id)->first();

        // Periksa apakah data user dan kepala dusun terkait ditemukan
        if ($user && $user->staff_id === $kepalaDusun['staff_id']) {
            // Periksa apakah foto kepala dusun bukan default.svg, jika bukan, hapus foto
            if ($kepalaDusun['foto'] != 'default.svg') {
                unlink('img/staff/' . $kepalaDusun['foto']);
            }

            // Hapus data kepala dusun
            $delete = $this->kepalaDusunModel->where('staff_id', $staff_id)->delete();
            // Hapus data pengguna (user)
            $deleteUser = $this->userModel->where('staff_id', $staff_id)->delete();

            // Periksa apakah kedua penghapusan berhasil
            if ($delete !== false && $deleteUser !== false) {
                // Jika berhasil, arahkan ke halaman daftar kepala dusun dengan pesan sukses
                return redirect()->to(base_url('dashboard/kepala-dusun'))->with('success-message', 'Kepala Dusun/Lingkungan berhasil dihapus.');
            } else {
                // Jika gagal, arahkan kembali ke halaman daftar kepala dusun dengan pesan kesalahan
                return redirect()->to(base_url('dashboard/kepala-dusun'))->with('error-message', 'Kepala Dusun/Lingkungan gagal dihapus.');
            }
        } else {
            // Jika data tidak ditemukan atau user tidak sesuai dengan kepala dusun terkait, kembalikan dengan pesan kesalahan
            return redirect()->to(base_url('dashboard/kepala-dusun'))->with('error-message', 'Kepala Dusun/Lingkungan gagal dihapus.');
        }
    }
}
