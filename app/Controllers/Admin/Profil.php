<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\KepalaDusunModel;
use App\Models\PerangkatDesaModel;
use App\Models\SitusModel;
use CodeIgniter\HTTP\ResponseInterface;
use Myth\Auth\Models\UserModel;
use Myth\Auth\Password;

class Profil extends BaseController
{
    protected $situsModel;
    protected $userModel;
    protected $perangkatDesaModel;
    protected $kepalaDusunModel;

    public function __construct()
    {
        $this->situsModel           = new SitusModel();
        $this->userModel            = new UserModel();
        $this->perangkatDesaModel   = new PerangkatDesaModel();
        $this->kepalaDusunModel     = new KepalaDusunModel();
    }

    public function index()
    {
        // Mendapatkan data situs
        $situs = $this->situsModel->findAll(1);

        if (empty($situs)) {
            return redirect()->to(base_url('404-not-found'));
        } else {
            $data = [
                'situs' => $situs,
                'title' => 'Profil',
            ];

            return view('admin/profil/index', $data);
        }
    }

    public function updateData()
    {
        $staff_id = $this->request->getVar('staff_id');
        $user = $this->userModel->where('staff_id', $staff_id)->first();

        $emailLama = $user->email;
        $emailBaru = $this->request->getVar('email');
        if ($emailBaru !== $emailLama) {
            $ruleEmail = 'required|valid_email|is_unique[users.email,id,{id}]';
        } else {
            $ruleEmail = 'required';
        }

        $usernameLama = $user->username;
        $usernameBaru = $this->request->getVar('username');
        if ($usernameBaru !== $usernameLama) {
            $ruleUsername = 'required|alpha_numeric_punct|min_length[3]|max_length[30]|is_unique[users.username,id,{id}]';
        } else {
            $ruleUsername = 'required';
        }

        // Validasi input data
        if (!$this->validate([
            'email' => [
                'rules' => $ruleEmail,
                'errors' => [
                    'required' => 'Email tidak boleh kosong!',
                    'valid_email' => 'Email tidak valid',
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

            // Jika gambar boleh kosong
            'user_img' => [
                'rules' => 'max_size[user_img,1024]|is_image[user_img]|mime_in[user_img,image/jpg,image/jpeg,image/png]',
                'errors' => [
                    'max_size'  => 'Ukuran gambar maksimal 1MB!',
                    'is_image'  => 'Format tidak didukung!',
                    'mime_in'   => 'Yang Anda unggah bukan gambar!'
                ]
            ]
        ])) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $gambar = $this->request->getFile('user_img');
        $gambarLama = $this->request->getVar('user_img_old');

        // Cek gambar, apakah tetap gambar lama?
        if ($gambar->getError() == 4) {
            $namaGambar = $gambarLama;
        } else {
            // Generate nama sampul baru
            $namaGambar = $gambar->getRandomName();

            //Pindah gambar
            $gambar->move('img/staff', $namaGambar);

            // Hapus file
            if ($gambarLama != 'default.svg') {
                unlink('img/staff/' . $gambarLama);
            }
        }

        $dataUser = [
            'email'     => $emailBaru,
            'username'  => $usernameBaru,
            'fullname'  => $this->request->getVar('fullname'),
            'user_img'  => $namaGambar,
        ];


        // Penentuan pembaruan berdasarkan peran pengguna
        $perangkatDesa = $this->perangkatDesaModel->where('staff_id', $staff_id)->first() ?? null;
        if ($perangkatDesa) {
            // Update data perangkat desa
            $updatePerangkatDesa = $this->perangkatDesaModel->update($perangkatDesa['id'], [
                'nama'      => $this->request->getVar('fullname'),
                'foto'      => $namaGambar,
            ]);

            // Update data pengguna
            $update = $this->userModel->update($user->id, $dataUser);

            // Pengembalian hasil
            if ($update !== false && $updatePerangkatDesa !== false) {
                return redirect()->to(base_url('dashboard/profil'))->with('success-message-toast', 'Profil berhasil diperbarui.');
            } else {
                return redirect()->to(base_url('dashboard/profil'))->with('error-message-toast', 'Profil gagal diperbarui.');
            }
        }

        $kepalaDusun = $this->kepalaDusunModel->where('staff_id', $staff_id)->first() ?? null;
        if ($kepalaDusun) {
            // Update data kepala dusun
            $updateKepalaDusun = $this->kepalaDusunModel->update($kepalaDusun['id'], [
                'nama'      => $this->request->getVar('fullname'),
                'foto'      => $namaGambar,
            ]);

            // Update data pengguna
            $update = $this->userModel->update($user->id, $dataUser);

            // Pengembalian hasil
            if ($update !== false && $updateKepalaDusun !== false) {
                return redirect()->to(base_url('dashboard/profil'))->with('success-message-toast', 'Profil berhasil diperbarui.');
            } else {
                return redirect()->to(base_url('dashboard/profil'))->with('error-message-toast', 'Profil gagal diperbarui.');
            }
        }

        // Update data pengguna
        $update = $this->userModel->update($user->id, $dataUser);

        // Pengembalian hasil
        if ($update !== false) {
            return redirect()->to(base_url('dashboard/profil'))->with('success-message-toast', 'Profil berhasil diperbarui.');
        } else {
            return redirect()->to(base_url('dashboard/profil'))->with('error-message-toast', 'Profil gagal diperbarui.');
        }
    }

    public function updatePassword()
    {
        $staff_id = $this->request->getVar('staff_id');
        $user = $this->userModel->where('staff_id', $staff_id)->first();

        // Validasi input data
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
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        // Verifikasi kata sandi lama
        if (Password::verify($this->request->getVar('password_hash'), $user->password_hash)) {
            // Simpan kata sandi baru
            $newPassword = $this->request->getVar('password');
            $user->password_hash = Password::hash($newPassword);

            if ($this->userModel->save($user)) {
                return redirect()->to(base_url('dashboard/profil'))->with('success-message-toast', 'Kata Sandi berhasil diperbarui.');
            } else {
                return redirect()->to(base_url('dashboard/profil'))->with('error-message-toast', 'Kata Sandi gagal diperbarui.');
            }
        } else {
            return redirect()->back()->withInput()->with('errors', ['password_hash' => 'Kata Sandi Lama yang Anda masukan salah!']);
        }
    }
}
