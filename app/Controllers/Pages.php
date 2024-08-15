<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

class Pages extends BaseController
{
    public function forbiddenPage()
    {
        $data = [
            'title' => '403 | Terlarang'
        ];

        return view('pages/errors/error-403', $data);
    }

    public function notFoundPage()
    {
        $data = [
            'title' => '404 | Tidak Ditemukan'
        ];

        return view('pages/errors/error-404', $data);
    }

    public function internalErrorPage()
    {
        $data = [
            'title' => '500 | Sistem Bermasalah'
        ];

        return view('pages/errors/error-500', $data);
    }
}
