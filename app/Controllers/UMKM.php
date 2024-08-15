<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\KomentarBalasanUMKMModel;
use App\Models\KomentarUMKMModel;
use App\Models\KontakModel;
use App\Models\SitusModel;
use App\Models\UMKMModel;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\I18n\Time;
use Myth\Auth\Models\UserModel;

class UMKM extends BaseController
{
    protected $situsModel;
    protected $kontakModel;
    protected $umkmModel;
    protected $kategoriModel;
    protected $komentarUMKMModel;
    protected $komentarBalasanUMKMModel;
    protected $userModel;

    public function __construct()
    {
        $this->situsModel               = new SitusModel();
        $this->kontakModel              = new KontakModel();
        $this->umkmModel                = new UMKMModel();
        $this->komentarUMKMModel        = new KomentarUMKMModel();
        $this->komentarBalasanUMKMModel = new KomentarBalasanUMKMModel();
        $this->userModel                = new UserModel();
    }

    private function getSlug($slug)
    {
        return $this->umkmModel->where('slug', $slug)->first();
    }

    public function index()
    {
        $situs = $this->situsModel->findAll(1);

        if (empty($situs)) {
            return redirect()->to(base_url('404-not-found'));
        } else {
            // Ambil kata kunci pencarian dari form
            $keyword = $this->request->getVar('keyword');

            if ($keyword) {
                // Lakukan pencarian jika ada kata kunci
                $umkm = $this->umkmModel->like('nama', $keyword)
                    ->orLike('pemilik', $keyword)
                    ->orLike('harga', $keyword)
                    ->orLike('deskripsi', $keyword)
                    ->orderBy('created_at', 'DESC')
                    ->paginate(6, 'umkm');

                // Jika tidak ada hasil ditemukan
                if (empty($umkm)) {
                    session()->setFlashdata('warning-message', "Tidak ada hasil yang ditemukan untuk pencarian \"$keyword\"");
                    return redirect()->to(base_url('umkm'));
                }
            } else {
                // Ambil semua umkm jika tidak ada kata kunci
                $umkm = $this->umkmModel->orderBy('created_at', 'DESC')->paginate(6, 'umkm');
            }

            $data = [
                'situs'         => $situs,
                'kontak'        => $this->kontakModel->find(1),
                'pager'         => $this->umkmModel->pager,
                'umkm'          => $umkm,
                'title'         => 'Produk UMKM',
            ];

            return view('user/umkm/index', $data);
        }
    }

    public function detail($slug)
    {
        $situs = $this->situsModel->findAll(1);

        if (empty($situs)) {
            return redirect()->to(base_url('404-not-found'));
        } else {
            $umkm = $this->getSlug($slug);

            if (!$umkm) {
                return redirect()->to(base_url('umkm'))->with('warning-message', "Data tidak ditemukan.");
            } else {
                $viewer = $umkm['viewer'];
                $viewerIncrement = $viewer + 1;

                $this->umkmModel->update($umkm['id'], [
                    'viewer' => $viewerIncrement,
                ]);

                // Temukan penulis
                $user = $this->userModel->find($umkm['user_id']);
                $umkm['penulis'] = $user ? $user->fullname : 'Tidak Diketahui';

                // Ambil umkm terbaru
                $umkmTerbaru = $this->umkmModel->orderBy('created_at', 'DESC')->findAll(3);

                $data = [
                    'situs'             => $situs,
                    'kontak'            => $this->kontakModel->find(1),
                    'umkm'              => $umkm,
                    'umkm_terbaru'      => $umkmTerbaru,
                    'komentar'          => $this->komentarUMKMModel->orderBy('created_at', 'DESC')->findAll(),
                    'komentar_balasan'  => $this->komentarBalasanUMKMModel->orderBy('created_at', 'ASC')->findAll(),
                    'title'             => 'Detail Produk',
                ];

                return view('user/umkm/detail', $data);
            }
        }
    }

    public function komentar()
    {
        if (!$this->validate([
            'nama' => [
                'rules' => 'required',
                'errors' => [
                    'required'  => 'Nama tidak boleh kosong!',
                ]
            ],
            'rating' => [
                'rules' => 'required',
                'errors' => [
                    'required'  => 'Silahkan beri rating!',
                ]
            ],
            'deskripsi' => [
                'rules' => 'required',
                'errors' => [
                    'required'  => 'Komentar tidak boleh kosong!',
                ]
            ],
        ])) {
            return redirect()->back()->withInput()->with('error-message-toast', $this->validator->getErrors());
        }

        $email = '';
        $slug = $this->request->getVar('slug');

        $save = $this->komentarUMKMModel->save([
            'nama'          => $this->request->getVar('nama'),
            'email'         => $email,
            'rating'        => $this->request->getVar('rating'),
            'deskripsi'     => $this->request->getVar('deskripsi'),
            'umkm_id'       => $this->request->getVar('umkm_id'),
            'created_at'    => Time::now('Asia/Singapore', 'id_ID'),
            'updated_at'    => Time::now('Asia/Singapore', 'id_ID'),
        ]);

        if ($save !== false) {
            return redirect()->to(base_url('umkm/') . $slug)->with('success-message-toast', "Komentar berhasil dikirim.");
        } else {
            return redirect()->to(base_url('umkm/') . $slug)->with('error-message-toast', "Komentar gagal dikirim.");
        }
    }

    public function komentarBalasan()
    {
        if (!$this->validate([
            'nama_balasan' => [
                'rules' => 'required',
                'errors' => [
                    'required'  => 'Nama tidak boleh kosong!',
                ]
            ],
            'deskripsi_balasan' => [
                'rules' => 'required',
                'errors' => [
                    'required'  => 'Komentar tidak boleh kosong!',
                ]
            ],
        ])) {
            return redirect()->back()->withInput()->with('error-message-toast', $this->validator->getErrors());
        }

        $email = '';
        $slug = $this->request->getVar('slug');

        $save = $this->komentarBalasanUMKMModel->save([
            'nama'              => $this->request->getVar('nama_balasan'),
            'email'             => $email,
            'rating'            => $this->request->getVar('rating'),
            'deskripsi'         => $this->request->getVar('deskripsi_balasan'),
            'komentar_umkm_id'  => $this->request->getVar('komentar_id'),
            'created_at'        => Time::now('Asia/Singapore', 'id_ID'),
            'updated_at'        => Time::now('Asia/Singapore', 'id_ID'),
        ]);

        if ($save !== false) {
            return redirect()->to(base_url('umkm/') . $slug)->with('success-message-toast', "Komentar berhasil dikirim.");
        } else {
            return redirect()->to(base_url('umkm/') . $slug)->with('error-message-toast', "Komentar gagal dikirim.");
        }
    }

    public function deleteKomentar($id)
    {
        $komentar = $this->komentarUMKMModel->find($id);

        if ($komentar) {
            $komentar_umkm_id = $komentar['id'];

            $balasanKomentar = $this->komentarBalasanUMKMModel->where('komentar_umkm_id', $komentar_umkm_id)->findAll();

            if ($balasanKomentar) {
                foreach ($balasanKomentar as $balasan) {
                    $this->komentarBalasanUMKMModel->delete($balasan['id']);
                }
            }

            $slug = $this->request->getVar('slug');
            $delete = $this->komentarUMKMModel->delete($komentar_umkm_id);

            if ($delete !== false) {
                return redirect()->to(base_url('umkm/') . $slug)->with('success-message-toast', "Komentar berhasil dihapus.");
            } else {
                return redirect()->to(base_url('umkm/') . $slug)->with('error-message-toast', "Komentar gagal dihapus.");
            }
        }
    }

    public function deleteKomentarBalasan($id)
    {
        $slug = $this->request->getVar('slug');
        $delete = $this->komentarBalasanUMKMModel->delete($id);

        if ($delete !== false) {
            return redirect()->to(base_url('umkm/') . $slug)->with('success-message-toast', "Balasan Komentar berhasil dihapus.");
        } else {
            return redirect()->to(base_url('umkm/') . $slug)->with('error-message-toast', "Balasan Komentar gagal dihapus.");
        }
    }
}
