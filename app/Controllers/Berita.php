<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\BeritaModel;
use App\Models\KategoriModel;
use App\Models\KomentarBalasanBeritaModel;
use App\Models\KomentarBeritaModel;
use App\Models\KontakModel;
use App\Models\SitusModel;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\I18n\Time;
use DateTime;
use DateTimeZone;
use Myth\Auth\Models\UserModel;

class Berita extends BaseController
{
    protected $situsModel;
    protected $kontakModel;
    protected $beritaModel;
    protected $kategoriModel;
    protected $komentarBeritaModel;
    protected $komentarBalasanBeritaModel;
    protected $userModel;

    public function __construct()
    {
        $this->situsModel                   = new SitusModel();
        $this->kontakModel                  = new KontakModel();
        $this->beritaModel                  = new BeritaModel();
        $this->kategoriModel                = new KategoriModel();
        $this->komentarBeritaModel          = new KomentarBeritaModel();
        $this->komentarBalasanBeritaModel   = new KomentarBalasanBeritaModel();
        $this->userModel                    = new UserModel();
    }

    protected function intervalDateTime($timestamp)
    {
        $datetime = new DateTime($timestamp, new DateTimeZone('Asia/Singapore'));
        $now = new DateTime();

        $interval = $datetime->diff($now);

        if ($interval->y > 0) {
            return $interval->format('%y tahun yang lalu');
        } elseif ($interval->m > 0) {
            return $interval->format('%m bulan yang lalu');
        } elseif ($interval->d > 0) {
            return $interval->format('%d hari yang lalu');
        } elseif ($interval->h > 0) {
            return $interval->format('%h jam yang lalu');
        } elseif ($interval->i > 0) {
            return $interval->format('%i menit yang lalu');
        } else {
            return 'Baru saja';
        }
    }

    private function getSlug($slug)
    {
        return $this->beritaModel->where('slug', $slug)->first();
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
                $berita = $this->beritaModel->like('judul', $keyword)
                    ->orLike('deskripsi', $keyword)
                    ->where('status', 'Publish')
                    ->orderBy('created_at', 'DESC')
                    ->paginate(6, 'berita');

                // Jika tidak ada hasil ditemukan
                if (empty($berita)) {
                    session()->setFlashdata('warning-message', "Tidak ada hasil yang ditemukan untuk pencarian \"$keyword\"");
                    return redirect()->to(base_url('berita'));
                }
            } else {
                // Ambil semua berita jika tidak ada kata kunci
                $berita = $this->beritaModel->where('status', 'Publish')
                    ->orderBy('created_at', 'DESC')
                    ->paginate(6, 'berita');
            }

            // Temukan kategori terkait dan penulis untuk setiap berita
            foreach ($berita as &$item) {
                $kategori = $this->kategoriModel->find($item['kategori_id']);
                $item['kategori_berita'] = $kategori ? $kategori['kategori'] : 'Tidak Ada Kategori';
                $item['kategori_slug'] = $kategori ? $kategori['slug'] : 'tidak-ada-kategori';

                $user = $this->userModel->find($item['user_id']);
                $item['penulis'] = $user ? $user->fullname : 'Tidak Diketahui';

                $item['interval'] = $this->intervalDateTime($item['created_at']);
            }

            $data = [
                'situs'     => $situs,
                'kontak'    => $this->kontakModel->find(1),
                'pager'     => $this->beritaModel->pager,
                'berita'    => $berita,
                'title'     => 'Berita',
            ];

            return view('user/berita/index', $data);
        }
    }

    public function detail($slug)
    {
        $situs = $this->situsModel->findAll(1);

        if (empty($situs)) {
            return redirect()->to(base_url('404-not-found'));
        } else {
            $berita = $this->getSlug($slug);

            if (!$berita) {
                return redirect()->to(base_url('berita'))->with('warning-message', "Data tidak ditemukan.");
            } else {
                $viewer = $berita['viewer'];
                $viewerIncrement = $viewer + 1;

                $this->beritaModel->update($berita['id'], [
                    'viewer' => $viewerIncrement,
                ]);

                // Temukan kategori dan penulis
                $kategori = $this->kategoriModel->find($berita['kategori_id']);
                $berita['kategori_berita'] = $kategori ? $kategori['kategori'] : 'Tidak Ada Kategori';
                $berita['kategori_slug'] = $kategori ? $kategori['slug'] : 'tidak-ada-kategori';

                $user = $this->userModel->find($berita['user_id']);
                $berita['penulis'] = $user ? $user->fullname : 'Tidak Diketahui';

                // Ambil berita terbaru
                $beritaTerbaru = $this->beritaModel->orderBy('created_at', 'DESC')->findAll(3);
                foreach ($beritaTerbaru as &$item) {
                    $item['interval'] = $this->intervalDateTime($item['created_at']);
                }

                $data = [
                    'situs'             => $situs,
                    'kontak'            => $this->kontakModel->find(1),
                    'berita'            => $berita,
                    'berita_terbaru'    => $beritaTerbaru,
                    'kategori'          => $this->kategoriModel->findAll(),
                    'komentar'          => $this->komentarBeritaModel->orderBy('created_at', 'DESC')->findAll(),
                    'komentar_balasan'  => $this->komentarBalasanBeritaModel->orderBy('created_at', 'ASC')->findAll(),
                    'title'             => 'Detail Berita',
                ];

                return view('user/berita/detail', $data);
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

        $save = $this->komentarBeritaModel->save([
            'nama'          => $this->request->getVar('nama'),
            'email'         => $email,
            'deskripsi'     => $this->request->getVar('deskripsi'),
            'berita_id'     => $this->request->getVar('berita_id'),
            'created_at'    => Time::now('Asia/Singapore', 'id_ID'),
            'updated_at'    => Time::now('Asia/Singapore', 'id_ID'),
        ]);

        if ($save !== false) {
            return redirect()->to(base_url('berita/') . $slug)->with('success-message-toast', "Komentar berhasil dikirim.");
        } else {
            return redirect()->to(base_url('berita/') . $slug)->with('error-message-toast', "Komentar gagal dikirim.");
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

        $save = $this->komentarBalasanBeritaModel->save([
            'nama'                  => $this->request->getVar('nama_balasan'),
            'email'                 => $email,
            'deskripsi'             => $this->request->getVar('deskripsi_balasan'),
            'komentar_berita_id'    => $this->request->getVar('komentar_id'),
            'created_at'            => Time::now('Asia/Singapore', 'id_ID'),
            'updated_at'            => Time::now('Asia/Singapore', 'id_ID'),
        ]);

        if ($save !== false) {
            return redirect()->to(base_url('berita/') . $slug)->with('success-message-toast', "Komentar berhasil dikirim.");
        } else {
            return redirect()->to(base_url('berita/') . $slug)->with('error-message-toast', "Komentar gagal dikirim.");
        }
    }

    public function deleteKomentar($id)
    {
        $komentar = $this->komentarBeritaModel->find($id);

        if ($komentar) {
            $komentar_berita_id = $komentar['id'];

            $balasanKomentar = $this->komentarBalasanBeritaModel->where('komentar_berita_id', $komentar_berita_id)->findAll();

            if ($balasanKomentar) {
                foreach ($balasanKomentar as $balasan) {
                    $this->komentarBalasanBeritaModel->delete($balasan['id']);
                }
            }

            $slug = $this->request->getVar('slug');
            $delete = $this->komentarBeritaModel->delete($komentar_berita_id);

            if ($delete !== false) {
                return redirect()->to(base_url('berita/') . $slug)->with('success-message-toast', "Komentar berhasil dihapus.");
            } else {
                return redirect()->to(base_url('berita/') . $slug)->with('error-message-toast', "Komentar gagal dihapus.");
            }
        }
    }

    public function deleteKomentarBalasan($id)
    {
        $slug = $this->request->getVar('slug');
        $delete = $this->komentarBalasanBeritaModel->delete($id);

        if ($delete !== false) {
            return redirect()->to(base_url('berita/') . $slug)->with('success-message-toast', "Balasan Komentar berhasil dihapus.");
        } else {
            return redirect()->to(base_url('berita/') . $slug)->with('error-message-toast', "Balasan Komentar gagal dihapus.");
        }
    }
}
