<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\KomentarBalasanPariwisataModel;
use App\Models\KomentarPariwisataModel;
use App\Models\KontakModel;
use App\Models\PariwisataModel;
use App\Models\SitusModel;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\I18n\Time;
use DateTime;
use DateTimeZone;
use Myth\Auth\Models\UserModel;

class Pariwisata extends BaseController
{
    protected $situsModel;
    protected $kontakModel;
    protected $pariwisataModel;
    protected $komentarPariwisataModel;
    protected $komentarBalasanPariwisataModel;
    protected $userModel;

    public function __construct()
    {
        $this->situsModel                       = new SitusModel();
        $this->kontakModel                      = new KontakModel();
        $this->pariwisataModel                  = new PariwisataModel();
        $this->komentarPariwisataModel          = new KomentarPariwisataModel();
        $this->komentarBalasanPariwisataModel   = new KomentarBalasanPariwisataModel();
        $this->userModel                        = new UserModel();
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
        return $this->pariwisataModel->where('slug', $slug)->first();
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
                $pariwisata = $this->pariwisataModel->like('judul', $keyword)
                    ->orLike('deskripsi', $keyword)
                    ->orderBy('created_at', 'DESC')
                    ->paginate(6, 'pariwisata');

                // Jika tidak ada hasil ditemukan
                if (empty($pariwisata)) {
                    session()->setFlashdata('warning-message', "Tidak ada hasil yang ditemukan untuk pencarian \"$keyword\"");
                    return redirect()->to(base_url('pariwisata'));
                }
            } else {
                // Ambil semua pariwisata jika tidak ada kata kunci
                $pariwisata = $this->pariwisataModel->orderBy('created_at', 'DESC')->paginate(6, 'pariwisata');
            }

            // Temukan penulis untuk setiap pariwisata
            foreach ($pariwisata as &$item) {
                $user = $this->userModel->find($item['user_id']);
                $item['penulis'] = $user ? $user->fullname : 'Tidak Diketahui';

                $item['interval'] = $this->intervalDateTime($item['created_at']);
            }

            $data = [
                'situs'         => $situs,
                'kontak'        => $this->kontakModel->find(1),
                'pager'         => $this->pariwisataModel->pager,
                'pariwisata'    => $pariwisata,
                'title'         => 'Pariwisata',
            ];

            return view('user/pariwisata/index', $data);
        }
    }

    public function detail($slug)
    {
        $situs = $this->situsModel->findAll(1);

        if (empty($situs)) {
            return redirect()->to(base_url('404-not-found'));
        } else {
            $pariwisata = $this->getSlug($slug);

            if (!$pariwisata) {
                return redirect()->to(base_url('pariwisata'))->with('warning-message', "Data tidak ditemukan.");
            } else {
                $viewer = $pariwisata['viewer'];
                $viewerIncrement = $viewer + 1;

                $this->pariwisataModel->update($pariwisata['id'], [
                    'viewer' => $viewerIncrement,
                ]);

                // Temukan penulis
                $user = $this->userModel->find($pariwisata['user_id']);
                $pariwisata['penulis'] = $user ? $user->fullname : 'Tidak Diketahui';

                // Ambil pariwisata terbaru
                $pariwisataTerbaru = $this->pariwisataModel->orderBy('created_at', 'DESC')->findAll(3);
                foreach ($pariwisataTerbaru as &$item) {
                    $item['interval'] = $this->intervalDateTime($item['created_at']);
                }

                $data = [
                    'situs'                 => $situs,
                    'kontak'                => $this->kontakModel->find(1),
                    'pariwisata'            => $pariwisata,
                    'pariwisata_terbaru'    => $pariwisataTerbaru,
                    'komentar'              => $this->komentarPariwisataModel->orderBy('created_at', 'DESC')->findAll(),
                    'komentar_balasan'      => $this->komentarBalasanPariwisataModel->orderBy('created_at', 'ASC')->findAll(),
                    'title'                 => 'Detail Pariwisata',
                ];

                return view('user/pariwisata/detail', $data);
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

        $save = $this->komentarPariwisataModel->save([
            'nama'              => $this->request->getVar('nama'),
            'email'             => $email,
            'rating'            => $this->request->getVar('rating'),
            'deskripsi'         => $this->request->getVar('deskripsi'),
            'pariwisata_id'     => $this->request->getVar('pariwisata_id'),
            'created_at'        => Time::now('Asia/Singapore', 'id_ID'),
            'updated_at'        => Time::now('Asia/Singapore', 'id_ID'),
        ]);

        if ($save !== false) {
            return redirect()->to(base_url('pariwisata/') . $slug)->with('success-message-toast', "Komentar berhasil dikirim.");
        } else {
            return redirect()->to(base_url('pariwisata/') . $slug)->with('error-message-toast', "Komentar gagal dikirim.");
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

        $save = $this->komentarBalasanPariwisataModel->save([
            'nama'                      => $this->request->getVar('nama_balasan'),
            'email'                     => $email,
            'rating'                    => $this->request->getVar('rating'),
            'deskripsi'                 => $this->request->getVar('deskripsi_balasan'),
            'komentar_pariwisata_id'    => $this->request->getVar('komentar_id'),
            'created_at'                => Time::now('Asia/Singapore', 'id_ID'),
            'updated_at'                => Time::now('Asia/Singapore', 'id_ID'),
        ]);

        if ($save !== false) {
            return redirect()->to(base_url('pariwisata/') . $slug)->with('success-message-toast', "Komentar berhasil dikirim.");
        } else {
            return redirect()->to(base_url('pariwisata/') . $slug)->with('error-message-toast', "Komentar gagal dikirim.");
        }
    }

    public function deleteKomentar($id)
    {
        $komentar = $this->komentarPariwisataModel->find($id);

        if ($komentar) {
            $komentar_pariwisata_id = $komentar['id'];

            $balasanKomentar = $this->komentarBalasanPariwisataModel->where('komentar_pariwisata_id', $komentar_pariwisata_id)->findAll();

            if ($balasanKomentar) {
                foreach ($balasanKomentar as $balasan) {
                    $this->komentarBalasanPariwisataModel->delete($balasan['id']);
                }
            }

            $slug = $this->request->getVar('slug');
            $delete = $this->komentarPariwisataModel->delete($komentar_pariwisata_id);

            if ($delete !== false) {
                return redirect()->to(base_url('pariwisata/') . $slug)->with('success-message-toast', "Komentar berhasil dihapus.");
            } else {
                return redirect()->to(base_url('pariwisata/') . $slug)->with('error-message-toast', "Komentar gagal dihapus.");
            }
        }
    }

    public function deleteKomentarBalasan($id)
    {
        $slug = $this->request->getVar('slug');
        $delete = $this->komentarBalasanPariwisataModel->delete($id);

        if ($delete !== false) {
            return redirect()->to(base_url('pariwisata/') . $slug)->with('success-message-toast', "Balasan Komentar berhasil dihapus.");
        } else {
            return redirect()->to(base_url('pariwisata/') . $slug)->with('error-message-toast', "Balasan Komentar gagal dihapus.");
        }
    }
}
