<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\PerangkatDesaModel;
use App\Models\SitusModel;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\I18n\Time;
use Myth\Auth\Models\UserModel;
use Myth\Auth\Password;

class PerangkatDesa extends BaseController
{
    protected $situsModel;
    protected $perangkatDesaModel;
    protected $userModel;

    public function __construct()
    {
        $this->situsModel           = new SitusModel();
        $this->perangkatDesaModel   = new PerangkatDesaModel();
        $this->userModel            = new UserModel();
    }

    public function index()
    {
        // Mendapatkan data situs
        $situs = $this->situsModel->findAll(1);

        if (empty($situs) || user()->level == 'staff' || user()->level == 'kepala dusun') {
            return redirect()->to(base_url('404-not-found'));
        } else {
            $data = [
                'situs'             => $situs,
                'perangkat_desa'    => $this->perangkatDesaModel->findAll(),
                'title'             => 'Pemerintah Desa/Kelurahan',
            ];

            return view('admin/perangkat-desa/index', $data);
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
                'title' => 'Tambah Pemerintah Desa/Kelurahan',
            ];

            return view('admin/perangkat-desa/create', $data);
        }
    }

    public function save()
    {
        // Validasi input sebelum menyimpan data perangkat desa
        if (!$this->validate([
            'nama' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Nama tidak boleh kosong!' // Pesan kesalahan jika nama kosong
                ]
            ],

            'nip' => [
                'rules' => 'permit_empty|numeric',
                'errors' => [
                    'numeric' => 'NIP harus berupa angka!'
                ]
            ],

            'jabatan' => [
                'rules' => 'required|is_unique[perangkat_desa.jabatan]', // Memastikan jabatan adalah unik
                'errors' => [
                    'required' => 'Jabatan tidak boleh kosong!', // Pesan kesalahan jika jabatan kosong
                    'is_unique' => 'Jabatan sudah ada!' // Pesan kesalahan jika jabatan sudah ada di database
                ]
            ],
            'foto' => [
                'rules' => 'max_size[foto,1024]|is_image[foto]|mime_in[foto,image/jpg,image/jpeg,image/png]', // Membatasi ukuran, format, dan jenis file gambar
                'errors' => [
                    'max_size'  => 'Ukuran foto maksimal 1MB!', // Pesan kesalahan jika ukuran foto melebihi batas
                    'is_image'  => 'Format tidak didukung!', // Pesan kesalahan jika format file bukan gambar
                    'mime_in'   => 'Yang Anda unggah bukan foto!' // Pesan kesalahan jika jenis file bukan gambar
                ]
            ]
        ])) {
            // Jika validasi gagal, kembalikan pengguna ke halaman pembuatan perangkat desa dengan pesan kesalahan dan input sebelumnya
            return redirect()->to(base_url('dashboard/perangkat-desa/create'))->withInput()->with('errors', $this->validator->getErrors());
        }

        // Mengelola upload gambar
        $gambar = $this->request->getFile('foto');

        // Menyiapkan nama unik untuk gambar
        if ($gambar->getError() == 4) {
            $namaGambar = 'default.svg'; // Jika tidak ada gambar yang diupload, gunakan gambar default
        } else {
            $namaGambar = $gambar->getRandomName(); // Jika ada gambar yang diupload, gunakan nama random
            $gambar->move('img/staff', $namaGambar); // Pindahkan gambar ke direktori yang ditentukan
        }

        // Menyiapkan ID unik untuk staff
        $staff_id = uniqid();
        $random = 'user' . substr($staff_id, 6);
        $randomEmail = $random . '@gmail.com';
        $randomUsername = $random;

        // Menyimpan data perangkat desa ke dalam database
        $save = $this->perangkatDesaModel->save([
            'nama'          => $this->request->getVar('nama'),
            'jabatan'       => $this->request->getVar('jabatan'),
            'nip'           => $this->request->getVar('nip'),
            'deskripsi'     => $this->request->getVar('deskripsi'),
            'foto'          => $namaGambar,
            'staff_id'      => $staff_id,
            'created_at'    => Time::now('Asia/Singapore', 'id_ID'), // Menyimpan waktu pembuatan dalam zona waktu Asia/Singapore dengan format id_ID
            'updated_at'    => Time::now('Asia/Singapore', 'id_ID'), // Menyimpan waktu pembaruan dalam zona waktu Asia/Singapore dengan format id_ID
        ]);

        // Menyimpan data user ke dalam database
        $saveUser = $this->userModel->save([
            'email'         => $randomEmail,
            'username'      => $randomUsername,
            'fullname'      => $this->request->getVar('nama'),
            'user_img'      => $namaGambar,
            'level'         => 'staff',
            'staff_id'      => $staff_id,
            'password_hash' => Password::hash('staff'), // Menyimpan password awal sebagai 'staff'
            'active'        => 1, // Menandai user sebagai aktif
        ]);

        // Mengembalikan respons berdasarkan keberhasilan penyimpanan data perangkat desa dan user
        if ($save !== false && $saveUser !== false) {
            return redirect()->to(base_url('dashboard/perangkat-desa'))->with('success-message', "Pemerintah Desa/Kelurahan berhasil ditambahkan."); // Jika penyimpanan berhasil, beri pesan sukses
        } else {
            return redirect()->to(base_url('dashboard/perangkat-desa/create'))->with('error-message', "Pemerintah Desa/Kelurahan gagal ditambahkan."); // Jika penyimpanan gagal, beri pesan kesalahan
        }
    }


    public function edit($staff_id)
    {
        // Mendapatkan data situs
        $situs = $this->situsModel->findAll(1);

        if (empty($situs) || user()->level == 'staff' || user()->level == 'kepala dusun') {
            return redirect()->to(base_url('404-not-found'));
        } else {
            $peraangkatDesa = $this->perangkatDesaModel->where('staff_id', $staff_id)->first();

            if (!$peraangkatDesa) {
                return redirect()->to(base_url('dashboard/perangkat-desa'))->with('warning-message', "Data tidak ditemukan.");
            } else {
                $data = [
                    'situs'             => $situs,
                    'perangkat_desa'    => $peraangkatDesa,
                    'title'             => 'Edit Pemerintah Desa/Kelurahan',
                ];

                return view('admin/perangkat-desa/edit', $data);
            }
        }
    }

    public function update($staff_id)
    {
        // Mendapatkan data perangkat desa dan user berdasarkan staff_id
        $perangkatDesa = $this->perangkatDesaModel->where('staff_id', $staff_id)->first();
        $user = $this->userModel->where('staff_id', $staff_id)->first();

        // Memeriksa apakah user dan perangkat desa terkait dengan staff_id yang sama
        if ($user->staff_id === $perangkatDesa['staff_id']) {
            // Menyimpan jabatan perangkat desa lama dan baru
            $jabatanLama = $perangkatDesa['jabatan'];
            $jabatanBaru = $this->request->getVar('jabatan');

            // Menentukan aturan validasi untuk jabatan berdasarkan perubahan
            if ($jabatanBaru !== $jabatanLama) {
                $ruleJabatan = 'required|is_unique[perangkat_desa.jabatan]'; // Memastikan jabatan baru adalah unik jika berbeda dari sebelumnya
            } else {
                $ruleJabatan = 'required'; // Jika tidak ada perubahan, jabatan tetap harus diisi
            }

            // Validasi input sebelum memperbarui data perangkat desa
            if (!$this->validate([
                'nama' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'Nama tidak boleh kosong!' // Pesan kesalahan jika nama kosong
                    ]
                ],

                'nip' => [
                    'rules' => 'permit_empty|numeric',
                    'errors' => [
                        'numeric' => 'NIP harus berupa angka!'
                    ]
                ],

                'jabatan' => [
                    'rules' => $ruleJabatan,
                    'errors' => [
                        'required' => 'Jabatan tidak boleh kosong!', // Pesan kesalahan jika jabatan kosong
                        'is_unique' => 'Jabatan sudah ada!' // Pesan kesalahan jika jabatan sudah ada di database
                    ]
                ],
                'foto' => [
                    'rules' => 'max_size[foto,1024]|is_image[foto]|mime_in[foto,image/jpg,image/jpeg,image/png]', // Membatasi ukuran, format, dan jenis file gambar
                    'errors' => [
                        'max_size'  => 'Ukuran foto maksimal 1MB!', // Pesan kesalahan jika ukuran foto melebihi batas
                        'is_image'  => 'Format tidak didukung!', // Pesan kesalahan jika format file bukan gambar
                        'mime_in'   => 'Yang Anda unggah bukan foto!' // Pesan kesalahan jika jenis file bukan gambar
                    ]
                ]
            ])) {
                // Jika validasi gagal, kembalikan pengguna ke halaman edit perangkat desa dengan pesan kesalahan dan input sebelumnya
                return redirect()->to(base_url('dashboard/perangkat-desa/edit/') . $staff_id)->withInput()->with('errors', $this->validator->getErrors());
            }

            // Mengelola upload gambar
            $gambar = $this->request->getFile('foto');
            $gambarLama = $this->request->getVar('fotoLama');

            // Menyiapkan nama gambar baru atau tetap menggunakan nama gambar lama
            if ($gambar->getError() == 4) {
                $namaGambar = $gambarLama; // Jika tidak ada gambar yang diupload, gunakan nama gambar lama
            } else {
                $namaGambar = $gambar->getRandomName(); // Jika ada gambar yang diupload, gunakan nama random baru
                $gambar->move('img/staff', $namaGambar); // Pindahkan gambar baru ke direktori yang ditentukan
                if ($gambarLama != 'default.svg') {
                    unlink('img/staff/' . $gambarLama); // Hapus gambar lama jika bukan gambar default
                }
            }

            // Memperbarui data perangkat desa dalam database
            $update = $this->perangkatDesaModel->update($perangkatDesa['id'], [
                'nama'          => $this->request->getVar('nama'),
                'jabatan'       => $jabatanBaru,
                'nip'           => $this->request->getVar('nip'),
                'deskripsi'     => $this->request->getVar('deskripsi'),
                'foto'          => $namaGambar,
                'updated_at'    => Time::now('Asia/Singapore', 'id_ID'), // Menyimpan waktu pembaruan dalam zona waktu Asia/Singapore dengan format id_ID
            ]);

            // Memperbarui data user dalam database
            $updateUser = $this->userModel->update($user->id, [
                'fullname'      => $this->request->getVar('nama'),
                'user_img'      => $namaGambar,
            ]);

            // Mengembalikan respons berdasarkan keberhasilan pembaruan data perangkat desa dan user
            if ($update !== false && $updateUser !== false) {
                return redirect()->to(base_url('dashboard/perangkat-desa'))->with('success-message', "Pemerintah Desa/Kelurahan berhasil diperbarui."); // Jika pembarbaruan berhasil, beri pesan sukses
            } else {
                return redirect()->to(base_url('dashboard/perangkat-desa/edit/') . $staff_id)->with('error-message', "Pemerintah Desa/Kelurahan gagal diperbarui."); // Jika pembaruan gagal, beri pesan kesalahan
            }
        } else {
            return redirect()->to(base_url('dashboard/perangkat-desa/edit/') . $staff_id)->with('error-message', "Pemerintah Desa/Kelurahan gagal diperbarui."); // Jika user dan perangkat desa tidak terkait, beri pesan kesalahan
        }
    }


    public function delete($staff_id)
    {
        // Mendapatkan data perangkat desa dan user berdasarkan staff_id
        $perangkatDesa = $this->perangkatDesaModel->where('staff_id', $staff_id)->first();
        $user = $this->userModel->where('staff_id', $staff_id)->first();

        // Memeriksa apakah user dan perangkat desa terkait dengan staff_id yang sama
        if ($user->staff_id == $perangkatDesa['staff_id']) {
            // Memeriksa apakah gambar perangkat desa bukan default.svg, jika bukan, hapus gambar
            if ($perangkatDesa['foto'] != 'default.svg') {
                unlink('img/staff/' . $perangkatDesa['foto']); // Menghapus gambar perangkat desa dari direktori
            }

            // Menghapus data perangkat desa dan user dari database berdasarkan staff_id
            $delete = $this->perangkatDesaModel->where('staff_id', $staff_id)->delete();
            $deleteUser = $this->userModel->where('staff_id', $staff_id)->delete();

            // Mengembalikan respons berdasarkan keberhasilan penghapusan data perangkat desa dan user
            if ($delete !== false && $deleteUser !== false) {
                return redirect()->to(base_url('dashboard/perangkat-desa'))->with('success-message', "Pemerintah Desa/Kelurahan berhasil dihapus."); // Jika penghapusan berhasil, beri pesan sukses
            } else {
                return redirect()->to(base_url('dashboard/perangkat-desa'))->with('error-message', "Pemerintah Desa/Kelurahan gagal dihapus."); // Jika penghapusan gagal, beri pesan kesalahan
            }
        } else {
            return redirect()->to(base_url('dashboard/perangkat-desa'))->with('error-message', "Pemerintah Desa/Kelurahan gagal dihapus."); // Jika user dan perangkat desa tidak terkait, beri pesan kesalahan
        }
    }
}
