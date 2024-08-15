<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\SitusModel;
use App\Models\VideoModel;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\I18n\Time;

class Video extends BaseController
{
    protected $situsModel;
    protected $videoModel;

    public function __construct()
    {
        $this->situsModel   = new SitusModel();
        $this->videoModel   = new VideoModel();
    }

    public function index()
    {
        // Mendapatkan data situs
        $situs = $this->situsModel->findAll(1);

        if (empty($situs) || user()->level == 'staff' || user()->level == 'kepala dusun') {
            return redirect()->to(base_url('404-not-found'));
        } else {
            $data = [
                'situs' => $situs,
                'video' => $this->videoModel->find(1),
                'title' => 'Video',
            ];

            return view('admin/video/index', $data);
        }
    }

    function getYouTubeVideoCode($url)
    {
        // Mendapatkan bagian path dari URL
        $path = parse_url($url, PHP_URL_PATH);

        // Memecah path menjadi array dengan delimiter '/'
        $path_parts = explode('/', $path);

        // Mendapatkan bagian terakhir dari path yang merupakan kode video YouTube
        $video_code = end($path_parts);

        return $video_code;
    }

    public function update($id)
    {
        // Validasi input data
        if (!$this->validate([
            'video_url' => [
                'rules' => 'required|valid_url',
                'errors' => [
                    'required'  => 'URL tidak boleh kosong!',
                    'valid_url' => 'URL tidak valid!'
                ]
            ]
        ])) {
            // Menyimpan pesan error dalam array flashdata
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        // Mendapatkan URL video dari input
        $input_url = $this->request->getVar('video_url');

        // Mengubah URL YouTube standar menjadi URL embed
        $video_code = $this->getYouTubeVideoCode($input_url);
        $embed_url = 'https://www.youtube.com/embed/' . $video_code;

        // Memperbarui URL video dalam database
        $update = $this->videoModel->update($id, [
            'video_url'     => $embed_url,
            'updated_at'    => Time::now('Asia/Singapore', 'id_ID'),
        ]);

        if ($update !== false) {
            return redirect()->to(base_url('dashboard/video'))->with('success-message', 'Video berhasil diperbarui.');
        } else {
            return redirect()->to(base_url('dashboard/video'))->with('error-message', 'Video gagal diperbarui.');
        }
    }
}
