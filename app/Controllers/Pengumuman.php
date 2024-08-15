<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\KontakModel;
use App\Models\PengumumanModel;
use App\Models\SitusModel;
use CodeIgniter\HTTP\ResponseInterface;
use Myth\Auth\Models\UserModel;

class Pengumuman extends BaseController
{
    protected $situsModel;
    protected $kontakModel;
    protected $pengumumanModel;
    protected $userModel;

    public function __construct()
    {
        $this->situsModel       = new SitusModel();
        $this->kontakModel      = new KontakModel();
        $this->pengumumanModel  = new PengumumanModel();
        $this->userModel        = new UserModel();
    }

    public function index()
    {
        $situs = $this->situsModel->findAll(1);

        if (empty($situs)) {
            return redirect()->to(base_url('404-not-found'));
        } else {
            // Ambil kata kunci pencarian dari form
            $keyword = $this->request->getVar('keyword');
            $pengumuman = [];

            if ($keyword) {
                // Lakukan pencarian jika ada kata kunci
                $pengumuman = $this->pengumumanModel->like('judul', $keyword)
                    ->orLike('deskripsi', $keyword)
                    ->orderBy('created_at', 'DESC')
                    ->paginate(6, 'pengumuman');

                // Jika tidak ada hasil ditemukan
                if (empty($pengumuman)) {
                    session()->setFlashdata('warning-message', "Tidak ada hasil yang ditemukan untuk pencarian \"$keyword\"");
                    return redirect()->to(base_url('pengumuman'));
                }
            } else {
                // Ambil semua Pengumuman jika tidak ada kata kunci
                $pengumuman = $this->pengumumanModel->orderBy('created_at', 'DESC')->paginate(6, 'pengumuman');
            }

            // Temukan penulis untuk setiap pengumuman
            foreach ($pengumuman as &$item) {
                $user = $this->userModel->find($item['user_id']);
                $item['penulis'] = $user ? $user->fullname : 'Tidak Diketahui';
            }

            $data = [
                'situs'         => $situs,
                'kontak'        => $this->kontakModel->find(1),
                'pengumuman'    => $pengumuman,
                'pager'         => $this->pengumumanModel->pager,
                'title'         => 'Pengumuman',
            ];

            return view('user/pengumuman/index', $data);
        }
    }
}
