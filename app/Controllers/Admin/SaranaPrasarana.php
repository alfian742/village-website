<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\SaranaPrasaranaModel;
use App\Models\SitusModel;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\I18n\Time;
use Myth\Auth\Models\UserModel;

class SaranaPrasarana extends BaseController
{
    protected $situsModel;
    protected $saranaPrasaranaModel;
    protected $userModel;

    public function __construct()
    {
        $this->situsModel           = new SitusModel();
        $this->saranaPrasaranaModel = new SaranaPrasaranaModel();
        $this->userModel            = new UserModel();
    }

    private function getSlug($slug)
    {
        return $this->saranaPrasaranaModel->where('slug', $slug)->first();
    }

    public function index()
    {
        // Mendapatkan data situs
        $situs = $this->situsModel->findAll(1);

        if (empty($situs) || user()->level == 'kepala dusun') {
            return redirect()->to(base_url('404-not-found'));
        } else {
            $saranaPrasarana = $this->saranaPrasaranaModel->orderBy('created_at', 'DESC')->findAll();

            foreach ($saranaPrasarana as &$item) {
                $user = $this->userModel->find($item['user_id']);
                $item['penulis'] = $user ? $user->fullname : 'Tidak Diketahui';
            }

            $data = [
                'situs'             => $situs,
                'sarana_prasarana'  => $saranaPrasarana,
                'title'             => 'Sarana & Prasarana',
            ];

            return view('admin/sarana-prasarana/index', $data);
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
                'title' => 'Tambah Sarana & Prasarana',
            ];

            return view('admin/sarana-prasarana/create', $data);
        }
    }

    public function save()
    {
        // Validasi input data
        if (!$this->validate([
            'nama' => [
                'rules' => 'required|is_unique[sarana_prasarana.nama]',
                'errors' => [
                    'required' => 'Sarana & Prasarana tidak boleh kosong!',
                    'is_unique' => 'Sarana & Prasarana sudah ada!'
                ]
            ],

            'deskripsi' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Deskripsi tidak boleh kosong!'
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
            // Menyimpan pesan error dalam array flashdata
            return redirect()->to(base_url('dashboard/sarana-prasarana/create'))->withInput()->with('errors', $this->validator->getErrors());
        }

        // Ambil gamber
        $gambar = $this->request->getFile('gambar');
        // Generate nama file
        $namaGambar = $gambar->getRandomName();
        // Pindah file
        $gambar->move('img/sarana-prasarana', $namaGambar);

        $namaSaranaPrasarana =  $this->request->getVar('nama');
        $slug = url_title($namaSaranaPrasarana, '-', true);

        $save = $this->saranaPrasaranaModel->save([
            'nama'          => $namaSaranaPrasarana,
            'slug'          => $slug,
            'deskripsi'     => $this->request->getVar('deskripsi'),
            'viewer'        => 0,
            'user_id'       => $this->request->getVar('user_id'),
            'gambar'        => $namaGambar,
            'created_at'    => Time::now('Asia/Singapore', 'id_ID'),
            'updated_at'    => Time::now('Asia/Singapore', 'id_ID'),
        ]);

        if ($save !== false) {
            return redirect()->to(base_url('dashboard/sarana-prasarana'))->with('success-message', 'Sarana & Prasarana berhasil ditambahkan.');
        } else {
            return redirect()->to(base_url('dashboard/sarana-prasarana/create'))->with('error-message', 'Sarana & Prasarana gagal ditambahkan.');
        }
    }

    public function edit($slug)
    {
        // Mendapatkan data situs
        $situs = $this->situsModel->findAll(1);

        if (empty($situs) || user()->level == 'kepala dusun') {
            return redirect()->to(base_url('404-not-found'));
        } else {
            $saranaPasarana = $this->getSlug($slug);

            if (!$saranaPasarana) {
                return redirect()->to(base_url('dashboard/sarana-prasarana'))->with('warning-message', 'Sarana & Prasarana tidak ditemukan.');
            } else {
                $data = [
                    'situs'             => $situs,
                    'sarana_prasarana'  => $saranaPasarana,
                    'title'             => 'Edit Sarana & Prasarana',
                ];

                return view('admin/sarana-prasarana/edit', $data);
            }
        }
    }

    public function update($slug)
    {
        $saranaPrasarana = $this->getSlug($slug);

        $saranaPrasaranaLama = $saranaPrasarana['nama'];
        $saranaPrasaranaBaru = $this->request->getVar('nama');

        if ($saranaPrasaranaBaru !== $saranaPrasaranaLama) {
            $ruleSaranaPrasarana = 'required|is_unique[sarana_prasarana.nama]';
        } else {
            $ruleSaranaPrasarana = 'required';
        }

        // Validasi input data
        if (!$this->validate([
            'nama' => [
                'rules' => $ruleSaranaPrasarana,
                'errors' => [
                    'required' => 'Sarana & Prasarana tidak boleh kosong!',
                    'is_unique' => 'Sarana & Prasarana sudah ada!'
                ]
            ],

            'deskripsi' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Deskripsi tidak boleh kosong!'
                ]
            ],

            // Jika gambar boleh kosong
            'gambar' => [
                'rules' => 'max_size[gambar,1024]|is_image[gambar]|mime_in[gambar,image/jpg,image/jpeg,image/png]',
                'errors' => [
                    'max_size'  => 'Ukuran gambar maksimal 1MB!',
                    'is_image'  => 'Format tidak didukung!',
                    'mime_in'   => 'Yang Anda unggah bukan gambar!'
                ]
            ]
        ])) {
            // Menyimpan pesan error dalam array flashdata
            return redirect()->to(base_url('dashboard/sarana-prasarana/edit/') . $slug)->withInput()->with('errors', $this->validator->getErrors());
        }

        $gambar = $this->request->getFile('gambar');
        $gambarLama = $this->request->getVar('gambarLama');

        // Cek gambar, apakah tetap gambar lama?
        if ($gambar->getError() == 4) {
            $namaGambar = $gambarLama;
        } else {
            // Generate nama sampul baru
            $namaGambar = $gambar->getRandomName();

            //Pindah gambar
            $gambar->move('img/sarana-prasarana', $namaGambar);

            // Hapus file
            if ($gambarLama != 'default.svg') {
                unlink('img/sarana-prasarana/' . $gambarLama);
            }
        }

        $slug = url_title($saranaPrasaranaBaru, '-', true);

        $update = $this->saranaPrasaranaModel->update($saranaPrasarana['id'], [
            'nama'          => $saranaPrasaranaBaru,
            'slug'          => $slug,
            'deskripsi'     => $this->request->getVar('deskripsi'),
            'gambar'        => $namaGambar,
            'updated_at'    => Time::now('Asia/Singapore', 'id_ID'),
        ]);

        if ($update !== false) {
            return redirect()->to(base_url('dashboard/sarana-prasarana'))->with('success-message', 'Sarana & Prasarana berhasil diperbarui.');
        } else {
            return redirect()->to(base_url('dashboard/sarana-prasarana/edit/') . $slug)->with('error-message', 'Sarana & Prasarana gagal diperbarui.');
        }
    }

    public function delete($id)
    {
        $saranaPrasarana = $this->saranaPrasaranaModel->find($id);

        // Cek jika file gambar default
        if ($saranaPrasarana['gambar'] != 'default.svg') {
            // Hapus gambar
            unlink('img/sarana-prasarana/' . $saranaPrasarana['gambar']);
        }

        $delete = $this->saranaPrasaranaModel->delete($id);

        if ($delete !== false) {
            return redirect()->to(base_url('dashboard/sarana-prasarana'))->with('success-message', 'Sarana & Prasarana berhasil dihapus.');
        } else {
            return redirect()->to(base_url('dashboard/sarana-prasarana'))->with('error-message', 'Sarana & Prasarana gagal dihapus.');
        }
    }
}
