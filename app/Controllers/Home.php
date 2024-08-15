<?php

namespace App\Controllers;

use App\Models\DusunModel;
use App\Models\GeografisModel;
use App\Models\KepalaDusunModel;
use App\Models\KontakModel;
use App\Models\PariwisataModel;
use App\Models\PerangkatDesaModel;
use App\Models\SitusModel;
use App\Models\SliderModel;
use App\Models\UMKMModel;
use App\Models\VideoModel;
use DateTime;
use DateTimeZone;
use Myth\Auth\Models\UserModel;

class Home extends BaseController
{
    // public function index(): string
    // {
    //     return view('welcome_message');
    // }

    protected $situsModel;
    protected $kontakModel;
    protected $dusunModel;
    protected $geografisModel;
    protected $kepalaDusunModel;
    protected $pariwisataModel;
    protected $perangkatDesaModel;
    protected $sliderModel;
    protected $umkmModel;
    protected $userModel;
    protected $videoModel;

    public function __construct()
    {
        $this->situsModel           = new SitusModel();
        $this->kontakModel          = new KontakModel();
        $this->dusunModel           = new DusunModel();
        $this->geografisModel       = new GeografisModel();
        $this->kepalaDusunModel     = new KepalaDusunModel();
        $this->pariwisataModel      = new PariwisataModel();
        $this->perangkatDesaModel   = new PerangkatDesaModel();
        $this->sliderModel          = new SliderModel();
        $this->umkmModel            = new UMKMModel();
        $this->userModel            = new UserModel();
        $this->videoModel           = new VideoModel();
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
            $pariwisata = $this->pariwisataModel->orderBy('created_at', 'DESC')->findAll(3);

            foreach ($pariwisata as &$item) {
                $user = $this->userModel->find($item['user_id']);
                $item['penulis'] = $user ? $user->fullname : 'Tidak Diketahui';

                $item['interval'] = $this->intervalDateTime($item['created_at']);
            }

            $data = [
                'situs'             => $situs,
                'kontak'            => $this->kontakModel->find(1),
                'dusun'             => $this->dusunModel->findAll(),
                'geografis'         => $this->geografisModel->find(1),
                'kepala_dusun'      => $this->kepalaDusunModel->findAll(),
                'pariwisata'        => $pariwisata,
                'perangkat_desa'    => $this->perangkatDesaModel->findAll(),
                'slider'            => $this->sliderModel->findAll(),
                'umkm'              => $this->umkmModel->orderBy('created_at', 'DESC')->findAll(3),
                'video'             => $this->videoModel->find(1),
                'title'             => 'Beranda',
            ];

            return view('user/home/index', $data);
        }
    }
}
