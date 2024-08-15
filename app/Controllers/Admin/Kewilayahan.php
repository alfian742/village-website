<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\DataDusunModel;
use App\Models\DusunModel;
use App\Models\KepalaDusunModel;
use App\Models\SitusModel;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\I18n\Time;
use Myth\Auth\Models\UserModel;

class Kewilayahan extends BaseController
{
    protected $situsModel;
    protected $dataDusunModel;
    protected $dusunModel;
    protected $kepalaDusunModel;
    protected $userModel;

    public function __construct()
    {
        $this->situsModel       = new SitusModel();
        $this->dataDusunModel   = new DataDusunModel();
        $this->dusunModel       = new DusunModel();
        $this->kepalaDusunModel = new KepalaDusunModel();
        $this->userModel        = new UserModel();
    }

    public function index()
    {
        // Mendapatkan data situs
        $situs = $this->situsModel->findAll(1);

        if (empty($situs) || user()->level == 'super admin' || user()->level == 'admin' || user()->level == 'kepala desa' || user()->level == 'staff') {
            return redirect()->to(base_url('404-not-found'));
        } else {
            $kepalaDusun    = $this->kepalaDusunModel->where('staff_id', user()->staff_id)->first();
            $dusun          = $this->dusunModel->where('kepala_dusun_id', $kepalaDusun['id'])->first();
            $dataDusun      = $this->dataDusunModel->where('dusun_id', $dusun['id'])->orderBy('waktu', 'DESC')->findAll();

            $data = [
                'situs'         => $situs,
                'data_dusun'    => $dataDusun,
                'dusun'         => $dusun,
                'kepala_dusun'  => $kepalaDusun,
                'title'         => 'Data ' . $dusun['nama_dusun'],
            ];

            return view('admin/kewilayahan/index', $data);
        }
    }

    public function createDataDusun()
    {
        // Mendapatkan data situs
        $situs = $this->situsModel->findAll(1);

        if (empty($situs) || user()->level == 'super admin' || user()->level == 'admin' || user()->level == 'kepala desa' || user()->level == 'staff') {
            return redirect()->to(base_url('404-not-found'));
        } else {
            $kepalaDusun = $this->kepalaDusunModel->where('staff_id', user()->staff_id)->first();
            $dusun = $this->dusunModel->where('kepala_dusun_id', $kepalaDusun['id'])->first();

            $data = [
                'situs' => $situs,
                'dusun' => $dusun,
                'title' => 'Tambah Data ' . $dusun['nama_dusun'],
            ];

            return view('admin/kewilayahan/create', $data);
        }
    }

    public function saveDataDusun()
    {
        // Validasi input, pastikan waktu tidak kosong
        if (!$this->validate([
            'waktu' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Bulan & Tahun tidak boleh kosong!',
                ]
            ],
        ])) {
            // Jika validasi gagal, kembalikan ke halaman create dengan pesan kesalahan
            return redirect()->to(base_url('dashboard/kewilayahan/data-dusun/create'))->withInput()->with('errors', $this->validator->getErrors());
        }

        // Simpan data dusun ke database
        $save = $this->dataDusunModel->save([
            'waktu'         => date('Y-m-d', strtotime($this->request->getVar('waktu'))),
            'jumlah_lahir'  => $this->request->getVar('jumlah_lahir'),
            'jumlah_mati'   => $this->request->getVar('jumlah_mati'),
            'jumlah_masuk'  => $this->request->getVar('jumlah_masuk'),
            'jumlah_keluar' => $this->request->getVar('jumlah_keluar'),
            'dusun_id'      => $this->request->getVar('dusun_id'),
            'created_at'    => Time::now('Asia/Singapore', 'id_ID'),
            'updated_at'    => Time::now('Asia/Singapore', 'id_ID'),
        ]);

        // Periksa apakah penyimpanan berhasil
        if ($save !== false) {
            // Jika berhasil, arahkan ke halaman data-dusun dengan pesan sukses
            return redirect()->to(base_url('dashboard/kewilayahan/data-dusun'))->with('success-message', 'Data berhasil ditambahkan.');
        } else {
            // Jika gagal, kembalikan ke halaman create dengan pesan kesalahan
            return redirect()->to(base_url('dashboard/kewilayahan/data-dusun/create'))->with('error-message', 'Data gagal ditambahkan.');
        }
    }

    public function editDataDusun($id)
    {
        // Mendapatkan data situs
        $situs = $this->situsModel->findAll(1);

        if (empty($situs) || user()->level == 'super admin' || user()->level == 'admin' || user()->level == 'kepala desa' || user()->level == 'staff') {
            return redirect()->to(base_url('404-not-found'));
        } else {
            $dataDusun = $this->dataDusunModel->find($id);

            if (!$dataDusun) {
                return redirect()->to(base_url('dashboard/kewilayahan/data-dusun'))->with('warning-message', 'Data tidak ditemukan.');
            } else {
                $kepalaDusun = $this->kepalaDusunModel->where('staff_id', user()->staff_id)->first();
                $dusun = $this->dusunModel->where('kepala_dusun_id', $kepalaDusun['id'])->first();

                $data = [
                    'situs'         => $situs,
                    'data_dusun'    => $dataDusun,
                    'dusun'         => $dusun,
                    'title'         => 'Edit Data ' . $dusun['nama_dusun'],
                ];

                return view('admin/kewilayahan/edit', $data);
            }
        }
    }

    public function updateDataDusun($id)
    {
        // Validasi input
        if (!$this->validate([
            'waktu' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Bulan & Tahun tidak boleh kosong!',
                ]
            ],
        ])) {
            // Jika validasi gagal, kembalikan pengguna ke halaman edit dengan pesan kesalahan
            return redirect()->to(base_url('dashboard/kewilayahan/data-dusun/edit/') . $id)->withInput()->with('errors', $this->validator->getErrors());
        }

        // Perbarui data dusun berdasarkan ID
        $update = $this->dataDusunModel->update($id, [
            'waktu'         => date('Y-m-d', strtotime($this->request->getVar('waktu'))),
            'jumlah_lahir'  => $this->request->getVar('jumlah_lahir'),
            'jumlah_mati'   => $this->request->getVar('jumlah_mati'),
            'jumlah_masuk'  => $this->request->getVar('jumlah_masuk'),
            'jumlah_keluar' => $this->request->getVar('jumlah_keluar'),
            'dusun_id'      => $this->request->getVar('dusun_id'),
            'updated_at'    => Time::now('Asia/Singapore', 'id_ID'),
        ]);

        // Periksa apakah pembaruan berhasil
        if ($update !== false) {
            // Jika berhasil, kembalikan pengguna ke halaman data-dusun dengan pesan sukses
            return redirect()->to(base_url('dashboard/kewilayahan/data-dusun'))->with('success-message', 'Data berhasil diperbarui.');
        } else {
            // Jika gagal, kembalikan pengguna ke halaman edit dengan pesan kesalahan
            return redirect()->to(base_url('dashboard/kewilayahan/data-dusun/edit/') . $id)->with('error-message', 'Data gagal diperbarui.');
        }
    }

    public function deleteDataDusun($id)
    {
        // Hapus data dusun berdasarkan ID
        $delete = $this->dataDusunModel->delete($id);

        // Periksa apakah penghapusan berhasil
        if ($delete !== false) {
            // Jika berhasil, kembalikan pengguna ke halaman data-dusun dengan pesan sukses
            return redirect()->to(base_url('dashboard/kewilayahan/data-dusun'))->with('success-message', 'Data berhasil dihapus.');
        } else {
            // Jika gagal, kembalikan pengguna ke halaman data-dusun dengan pesan kesalahan
            return redirect()->to(base_url('dashboard/kewilayahan/data-dusun'))->with('error-message', 'Data gagal dihapus.');
        }
    }


    public function viewDusun()
    {
        // Mendapatkan data situs
        $situs = $this->situsModel->findAll(1);

        if (empty($situs) || user()->level == 'super admin' || user()->level == 'admin' || user()->level == 'kepala desa' || user()->level == 'staff') {
            return redirect()->to(base_url('404-not-found'));
        } else {
            $kepalaDusun = $this->kepalaDusunModel->where('staff_id', user()->staff_id)->first();
            $dusun = $this->dusunModel->where('kepala_dusun_id', $kepalaDusun['id'])->first();

            $data = [
                'situs'         => $situs,
                'dusun'         => $dusun,
                'kepala_dusun'  => $kepalaDusun,
                'title'         => $dusun['nama_dusun'],
            ];

            return view('admin/kewilayahan/dusun', $data);
        }
    }

    public function updateDusun()
    {
        // Validasi input
        if (!$this->validate([
            'deskripsi' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Deskripsi Dusun/Lingkungan tidak boleh kosong!'
                ]
            ],
            'timur' => [
                'rules' => 'required',
                'errors' => [
                    'required'  => 'Batas wilayah tidak boleh kosong!',
                ]
            ],
            'barat' => [
                'rules' => 'required',
                'errors' => [
                    'required'  => 'Batas wilayah tidak boleh kosong!',
                ]
            ],
            'selatan' => [
                'rules' => 'required',
                'errors' => [
                    'required'  => 'Batas wilayah tidak boleh kosong!',
                ]
            ],
            'utara' => [
                'rules' => 'required',
                'errors' => [
                    'required'  => 'Batas wilayah tidak boleh kosong!',
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
            // Jika validasi gagal, kembali ke halaman dengan pesan kesalahan
            return redirect()->to(base_url('dashboard/kewilayahan/dusun'))->withInput()->with('errors', $this->validator->getErrors());
        }

        // Proses pengelolaan gambar
        $gambar = $this->request->getFile('gambar');
        $gambarLama = $this->request->getVar('gambarLama');

        if ($gambar->getError() == 4) {
            $namaGambar = $gambarLama;
        } else {
            $namaGambar = $gambar->getRandomName();
            $gambar->move('img/dusun', $namaGambar);
            if ($gambarLama != 'default.svg') {
                unlink('img/dusun/' . $gambarLama);
            }
        }

        // Ambil id dusun dari input
        $dusun_id = $this->request->getVar('dusun_id');

        // Lakukan update data dusun
        $update = $this->dusunModel->update($dusun_id, [
            'deskripsi'     => $this->request->getVar('deskripsi'),
            'gambar'        => $namaGambar,
            'luas'          => $this->request->getVar('luas'),
            'timur'         => $this->request->getVar('timur'),
            'barat'         => $this->request->getVar('barat'),
            'selatan'       => $this->request->getVar('selatan'),
            'utara'         => $this->request->getVar('utara'),
            'updated_at'    => Time::now('Asia/Singapore', 'id_ID'),
        ]);

        // Periksa apakah update berhasil
        if ($update !== false) {
            // Jika berhasil, kembalikan ke halaman dengan pesan sukses
            return redirect()->to(base_url('dashboard/kewilayahan/dusun'))->with('success-message', 'Data berhasil diperbarui.');
        } else {
            // Jika gagal, kembalikan ke halaman dengan pesan kesalahan
            return redirect()->to(base_url('dashboard/kewilayahan/dusun'))->with('error-message', 'Data gagal diperbarui.');
        }
    }
}
