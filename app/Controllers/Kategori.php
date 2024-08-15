<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\BeritaModel;
use App\Models\KategoriModel;
use App\Models\KontakModel;
use App\Models\SitusModel;
use CodeIgniter\HTTP\ResponseInterface;
use DateTime;
use DateTimeZone;
use Myth\Auth\Models\UserModel;

class Kategori extends BaseController
{
    protected $situsModel;
    protected $kontakModel;
    protected $beritaModel;
    protected $kategoriModel;
    protected $userModel;

    public function __construct()
    {
        $this->situsModel       = new SitusModel();
        $this->kontakModel      = new KontakModel();
        $this->beritaModel      = new BeritaModel();
        $this->kategoriModel    = new KategoriModel();
        $this->userModel        = new UserModel();
    }

    private function getSlug($slug)
    {
        return $this->kategoriModel->where('slug', $slug)->first();
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

    public function index()
    {
        $situs = $this->situsModel->findAll(1);

        if (empty($situs)) {
            return redirect()->to(base_url('404-not-found'));
        } else {
            $data = [
                'situs'     => $situs,
                'kontak'    => $this->kontakModel->find(1),
                'kategori'  => $this->kategoriModel->orderBy('kategori', 'ASC')->findAll(),
                'title'     => 'Kategori Berita',
            ];

            return view('user/berita/kategori', $data);
        }
    }

    public function detail($slug)
    {
        $situs = $this->situsModel->findAll(1);

        if (empty($situs)) {
            return redirect()->to(base_url('404-not-found'));
        } else {
            $berita = $this->beritaModel
                ->where('kategori_id', $this->getSlug($slug)['id'])
                ->orderBy('created_at', 'DESC')
                ->paginate(6, 'berita');

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
                'berita'    => $berita,
                'pager'     => $this->beritaModel->pager,
                'title'     => 'Kategori Berita',
            ];

            return view('user/berita/kategori-detail', $data);
        }
    }

    public function noCategory()
    {
        $situs = $this->situsModel->findAll(1);

        if (empty($situs)) {
            return redirect()->to(base_url('404-not-found'));
        } else {
            $berita = $this->beritaModel
                ->where('kategori_id', 0)
                ->orderBy('created_at', 'DESC')
                ->paginate(6, 'berita');

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
                'berita'    => $berita,
                'pager'     => $this->beritaModel->pager,
                'title'     => 'Kategori Berita',
            ];

            return view('user/berita/kategori-detail', $data);
        }
    }
}
