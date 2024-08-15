<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\KepalaDusunModel;
use App\Models\PerangkatDesaModel;
use App\Models\SitusModel;
use CodeIgniter\HTTP\ResponseInterface;
use Myth\Auth\Models\UserModel;
use Myth\Auth\Password;

class ManageUser extends BaseController
{
    protected $situsModel;
    protected $kepalaDusunModel;
    protected $perangkatDesaModel;
    protected $userModel;

    public function __construct()
    {
        $this->situsModel           = new SitusModel();
        $this->kepalaDusunModel     = new KepalaDusunModel();
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
            // Filter users access
            if (user()->level == 'super admin') {
                $user = $this->userModel->orderBy('level', 'ASC')->orderBy('fullname', 'ASC')->findAll();
            } else {
                $user = $this->userModel->where('level !=', 'super admin')->orderBy('level', 'ASC')->orderBy('fullname', 'ASC')->findAll();
            }

            $data = [
                'situs' => $situs,
                'users' => $user,
                'title' => 'Kelola Pengguna',
            ];

            return view('admin/manage-user/index', $data);
        }
    }

    public function editData($staff_id)
    {
        // Mendapatkan data situs
        $situs = $this->situsModel->findAll(1);

        if (empty($situs) || user()->level == 'staff' || user()->level == 'kepala dusun') {
            return redirect()->to(base_url('404-not-found'));
        } else {
            $user = $this->userModel->where('staff_id', $staff_id)->first();

            if (!$user) {
                return redirect()->to(base_url('dashboard/manage-user'))->with('warning-message', 'Data Pengguna tidak ditemukan.');
            } else {
                $data = [
                    'situs' => $situs,
                    'user'  => $user,
                    'title' => 'Edit Data Pengguna',
                ];

                return view('admin/manage-user/edit-data', $data);
            }
        }
    }

    public function updateData($staff_id)
    {
        // Ambil data pengguna berdasarkan staff_id
        $user = $this->userModel->where('staff_id', $staff_id)->first();

        // Validasi email baru
        $emailLama = $user->email;
        $emailBaru = $this->request->getVar('email');
        if ($emailBaru !== $emailLama) {
            $ruleEmail = 'required|valid_email|is_unique[users.email,id,{id}]';
        } else {
            $ruleEmail = 'required';
        }

        // Validasi username baru
        $usernameLama = $user->username;
        $usernameBaru = $this->request->getVar('username');
        if ($usernameBaru !== $usernameLama) {
            $ruleUsername = 'required|alpha_numeric_punct|min_length[3]|max_length[30]|is_unique[users.username,id,{id}]';
        } else {
            $ruleUsername = 'required';
        }

        // Validasi data input
        if (!$this->validate([
            'email' => [
                'rules' => $ruleEmail,
                'errors' => [
                    'required' => 'Email tidak boleh kosong!',
                    'valid_email' => 'Email tidak valid!',
                    'is_unique' => 'Email sudah ada!'
                ]
            ],
            'username' => [
                'rules' => $ruleUsername,
                'errors' => [
                    'required' => 'Nama Pengguna tidak boleh kosong!',
                    'alpha_numeric_punct' => 'Nama Pengguna hanya boleh berisi huruf, angka, dan karakter spesial.',
                    'min_length' => 'Nama Pengguna minimal {param} karakter.',
                    'max_length' => 'Nama Pengguna maksimal {param} karakter.',
                    'is_unique' => 'Nama Pengguna sudah ada!'
                ]
            ],
            'fullname' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Nama Lengkap tidak boleh kosong!',
                ]
            ],
            'level' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Role tidak boleh kosong!'
                ]
            ],
            'user_img' => [
                'rules' => 'max_size[user_img,1024]|is_image[user_img]|mime_in[user_img,image/jpg,image/jpeg,image/png]',
                'errors' => [
                    'max_size'  => 'Ukuran gambar maksimal 1MB!',
                    'is_image'  => 'Format tidak didukung!',
                    'mime_in'   => 'Yang Anda unggah bukan gambar!'
                ]
            ]
        ])) {
            // Jika validasi gagal, kembali ke halaman edit dengan pesan kesalahan
            return redirect()->to(base_url('dashboard/manage-user/edit-data/') . $staff_id)->withInput()->with('errors', $this->validator->getErrors());
        }

        // Proses upload gambar
        $gambar = $this->request->getFile('user_img');
        $gambarLama = $this->request->getVar('user_img_old');
        if ($gambar->getError() == 4) {
            $namaGambar = $gambarLama;
        } else {
            $namaGambar = $gambar->getRandomName();
            $gambar->move('img/staff', $namaGambar);
            if ($gambarLama != 'default.svg') {
                unlink('img/staff/' . $gambarLama);
            }
        }

        // Data pengguna yang akan diupdate
        $dataUser = [
            'email'     => $emailBaru,
            'username'  => $usernameBaru,
            'fullname'  => $this->request->getVar('fullname'),
            'level'     => $this->request->getVar('level'),
            'user_img'  => $namaGambar,
        ];

        // Periksa apakah pengguna adalah perangkat desa
        $perangkatDesa = $this->perangkatDesaModel->where('staff_id', $staff_id)->first() ?? null;
        if ($perangkatDesa) {
            // Jika ya, update data perangkat desa dan pengguna
            $updatePerangkatDesa = $this->perangkatDesaModel->update($perangkatDesa['id'], [
                'nama'      => $this->request->getVar('fullname'),
                'nip'       => $this->request->getVar('nip'),
                'deskripsi' => $this->request->getVar('deskripsi'),
                'foto'      => $namaGambar,
            ]);
            $update = $this->userModel->update($user->id, $dataUser);
            if ($update !== false && $updatePerangkatDesa !== false) {
                return redirect()->to(base_url('dashboard/manage-user'))->with('success-message', 'Staff berhasil diperbarui.');
            } else {
                return redirect()->to(base_url('dashboard/manage-user/edit-data/') . $staff_id)->with('error-message', 'Staff gagal diperbarui.');
            }
        }

        // Periksa apakah pengguna adalah kepala dusun
        $kepalaDusun = $this->kepalaDusunModel->where('staff_id', $staff_id)->first() ?? null;
        if ($kepalaDusun) {
            // Jika ya, update data kepala dusun dan pengguna
            $updateKepalaDusun = $this->kepalaDusunModel->update($kepalaDusun['id'], [
                'nama'      => $this->request->getVar('fullname'),
                'nip'       => $this->request->getVar('nip'),
                'deskripsi' => $this->request->getVar('deskripsi'),
                'foto'      => $namaGambar,
            ]);
            $update = $this->userModel->update($user->id, $dataUser);
            if ($update !== false && $updateKepalaDusun !== false) {
                return redirect()->to(base_url('dashboard/manage-user'))->with('success-message', 'Pelaksana Kewilayahan berhasil diperbarui.');
            } else {
                return redirect()->to(base_url('dashboard/manage-user/edit-data/') . $staff_id)->with('error-message', 'Pelaksana Kewilayahan gagal diperbarui.');
            }
        }

        // Jika pengguna bukan perangkat desa atau kepala dusun, update data pengguna
        $update = $this->userModel->update($user->id, $dataUser);
        if ($update !== false) {
            return redirect()->to(base_url('dashboard/manage-user'))->with('success-message', 'Data Pengguna berhasil diperbarui.');
        } else {
            return redirect()->to(base_url('dashboard/manage-user/edit-data/') . $staff_id)->with('error-message', 'Data Pengguna gagal diperbarui.');
        }
    }

    public function editPassword($staff_id)
    {
        // Mendapatkan data situs
        $situs = $this->situsModel->findAll(1);

        if (empty($situs) || user()->level == 'staff' || user()->level == 'kepala dusun') {
            return redirect()->to(base_url('404-not-found'));
        } else {
            $user = $user = $this->userModel->where('staff_id', $staff_id)->first();

            if (!$user) {
                return redirect()->to(base_url('dashboard/manage-user'))->with('warning-message', 'Data tidak ditemukan.');
            } else {
                $data = [
                    'situs' => $situs,
                    'user'  => $user,
                    'title' => 'Edit Kata Sandi Pengguna',
                ];

                return view('admin/manage-user/edit-password', $data);
            }
        }
    }

    public function updatePassword($staff_id)
    {
        $user = $this->userModel->where('staff_id', $staff_id)->first();

        // Validasi input
        if (!$this->validate([
            'password_hash' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Kata Sandi Lama tidak boleh kosong!',
                ]
            ],
            'password' => [
                'rules' => 'required|min_length[8]',
                'errors' => [
                    'required' => 'Kata Sandi Baru tidak boleh kosong!',
                    'min_length' => 'Kata Sandi Baru harus memiliki panjang minimal {param} karakter!',
                ]
            ],
            'pass_confirm' => [
                'rules' => 'required|matches[password]',
                'errors' => [
                    'required' => 'Konfirmasi Kata Sandi Baru tidak boleh kosong!',
                    'matches' => 'Konfirmasi Kata Sandi Baru tidak cocok!',
                ]
            ],
        ])) {
            return redirect()->to(base_url('dashboard/manage-user/edit-password/') . $staff_id)->withInput()->with('errors', $this->validator->getErrors());
        }

        // Verifikasi kata sandi lama
        if (Password::verify($this->request->getVar('password_hash'), $user->password_hash)) {
            $newPassword = $this->request->getVar('password');
            $user->password_hash = Password::hash($newPassword);

            // Simpan perubahan kata sandi
            if ($this->userModel->save($user)) {
                return redirect()->to(base_url('dashboard/manage-user'))->with('success-message', 'Kata Sandi berhasil diperbarui.');
            } else {
                return redirect()->to(base_url('dashboard/manage-user/edit-data/') . $staff_id)->with('error-message', 'Kata Sandi gagal diperbarui.');
            }
        } else {
            // Jika kata sandi lama tidak cocok, kembalikan dengan pesan kesalahan
            return redirect()->to(base_url('dashboard/manage-user/edit-password/') . $staff_id)->withInput()->with('errors', ['password_hash' => 'Kata Sandi Lama yang Anda masukkan salah!']);
        }
    }

    public function resetPassword($staff_id)
    {
        // Mendapatkan data situs
        $situs = $this->situsModel->findAll(1);

        if (empty($situs) || user()->level == 'staff' || user()->level == 'kepala dusun') {
            return redirect()->to(base_url('404-not-found'));
        } else {
            // Ambil data pengguna berdasarkan ID staf
            $user = $this->userModel->where('staff_id', $staff_id)->first();

            // Periksa apakah pengguna ditemukan
            if (!$user) {
                return redirect()->to(base_url('dashboard/manage-user'))->with('warning-message', 'Data Pengguna tidak ditemukan.');
            }

            // Tentukan kata sandi baru untuk direset
            $newPassword = 'staff';

            // Hash kata sandi baru dan simpan ke dalam model pengguna
            $user->password_hash = Password::hash($newPassword);
            $update = $this->userModel->save($user);

            // Periksa apakah kata sandi berhasil direset
            if ($update) {
                return redirect()->to(base_url('dashboard/manage-user'))->with('success-message', 'Kata Sandi Pengguna berhasil direset menjadi "<i>staff</i>".');
            } else {
                return redirect()->to(base_url('dashboard/manage-user/edit-data/') . $staff_id)->with('error-message', 'Kata Sandi gagal direset.');
            }
        }
    }
}
