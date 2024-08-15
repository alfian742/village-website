<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\KontakModel;
use App\Models\SaranaPrasaranaModel;
use App\Models\SitusModel;
use CodeIgniter\HTTP\ResponseInterface;
use DateTime;
use DateTimeZone;

class SaranaPrasarana extends BaseController
{
    protected $situsModel;
    protected $kontakModel;
    protected $saranaPrasaranaModel;

    public function __construct()
    {
        $this->situsModel           = new SitusModel();
        $this->kontakModel          = new KontakModel();
        $this->saranaPrasaranaModel = new SaranaPrasaranaModel();
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
        return $this->saranaPrasaranaModel->where('slug', $slug)->first();
    }

    public function index()
    {
        $situs = $this->situsModel->findAll(1);

        if (empty($situs)) {
            return redirect()->to(base_url('404-not-found'));
        } else {
            // Ambil kata kunci pencarian dari form
            $keyword = $this->request->getVar('keyword');
            $saranaPrasarana = [];

            if ($keyword) {
                // Lakukan pencarian jika ada kata kunci
                $saranaPrasarana = $this->saranaPrasaranaModel->like('nama', $keyword)
                    ->orLike('deskripsi', $keyword)
                    ->orderBy('created_at', 'DESC')
                    ->paginate(6, 'sarana-prasarana');

                // Jika tidak ada hasil ditemukan
                if (empty($saranaPrasarana)) {
                    session()->setFlashdata('warning-message', "Tidak ada hasil yang ditemukan untuk pencarian \"$keyword\"");
                    return redirect()->to(base_url('sarana-prasarana'));
                }
            } else {
                // Ambil semua sarana-prasarana jika tidak ada kata kunci
                $saranaPrasarana = $this->saranaPrasaranaModel->orderBy('created_at', 'DESC')
                    ->paginate(6, 'sarana-prasarana');
            }

            // Ubah format waktu pada sarana-prasarana
            foreach ($saranaPrasarana as &$item) {
                $item['interval'] = $this->intervalDateTime($item['created_at']);
            }

            $data = [
                'situs'             => $situs,
                'kontak'            => $this->kontakModel->find(1),
                'sarana_prasarana'  => $saranaPrasarana,
                'pager'             => $this->saranaPrasaranaModel->pager,
                'title'             => 'Sarana & Prasarana',
            ];

            return view('user/sarana-prasarana/index', $data);
        }
    }

    public function detail($slug)
    {
        $situs = $this->situsModel->findAll(1);

        if (empty($situs)) {
            return redirect()->to(base_url('404-not-found'));
        } else {
            $saranaPrasarana = $this->getSlug($slug);

            if (!$saranaPrasarana) {
                return redirect()->to(base_url('sarana-prasarana'))->with('warning-message', "Data tidak ditemukan.");
            } else {
                $saranaPrasaranaTerbaru = $this->saranaPrasaranaModel->orderBy('created_at', 'DESC')->findAll(3);
                foreach ($saranaPrasaranaTerbaru as &$item) {
                    $item['interval'] = $this->intervalDateTime($item['created_at']);
                }

                $data = [
                    'situs'                     => $situs,
                    'kontak'                    => $this->kontakModel->find(1),
                    'sarana_prasarana'          => $saranaPrasarana,
                    'sarana_prasarana_terbaru'  => $saranaPrasaranaTerbaru,
                    'title'                     => 'Detail Sarana & Prasarana',
                ];

                return view('user/sarana-prasarana/detail', $data);
            }
        }
    }
}
