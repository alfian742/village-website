<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\DokumenPublikModel;
use App\Models\SitusModel;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\I18n\Time;

class DokumenPublik extends BaseController
{
    protected $situsModel;
    protected $dokumenPublikModel;

    public function __construct()
    {
        $this->situsModel           = new SitusModel();
        $this->dokumenPublikModel   = new DokumenPublikModel();
    }

    private function formatSizeUnits($bytes)
    {
        if ($bytes >= 1073741824) {
            $bytes = number_format($bytes / 1073741824, 2) . ' GB';
        } elseif ($bytes >= 1048576) {
            $bytes = number_format($bytes / 1048576, 2) . ' MB';
        } elseif ($bytes >= 1024) {
            $bytes = number_format($bytes / 1024, 2) . ' KB';
        } elseif ($bytes > 1) {
            $bytes = $bytes . ' bytes';
        } elseif ($bytes == 1) {
            $bytes = $bytes . ' byte';
        } else {
            $bytes = '0 bytes';
        }

        return $bytes;
    }

    public function index()
    {
        // Mendapatkan data situs
        $situs = $this->situsModel->findAll(1);

        if (empty($situs) || user()->level == 'staff' || user()->level == 'kepala dusun') {
            return redirect()->to(base_url('404-not-found'));
        } else {
            $data = [
                'situs'     => $situs,
                'dokumen'   => $this->dokumenPublikModel->orderBy('created_at', 'DESC')->findAll(),
                'title'     => 'Dokumen Publik',
            ];

            return view('admin/dokumen-publik/index', $data);
        }
    }

    public function save()
    {
        // Validasi input data
        if (!$this->validate([
            'nama' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Nama dokumen tidak boleh kosong!'
                ]
            ],
            'berkas' => [
                'rules' => 'uploaded[berkas]|max_size[berkas,10240]|ext_in[berkas,pdf,doc,docx,xls,xlsx,ppt,pptx]',
                'errors' => [
                    'uploaded'  => 'Anda belum mengunggah dokumen!',
                    'max_size'  => 'Ukuran dokumen maksimal 10MB!',
                    'ext_in'    => 'Format dokumen tidak didukung! Hanya file PDF, Word, Excel, dan PowerPoint yang diperbolehkan.'
                ]
            ]

        ])) {
            // Menyimpan pesan error dalam array flashdata
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        // Ambil berkas yang diunggah
        $berkas = $this->request->getFile('berkas');

        // Ambil nama berkas dari input pengguna
        $namaDokumen = $this->request->getVar('nama');

        // Ambil ekstensi berkas
        $ekstensiBerkas = $berkas->getClientExtension();

        // Generate nama file dengan format tanggal_waktu_nama
        $namaBerkas = Time::now('Asia/Singapore', 'id_ID')->format('Ymd_His') . '_' . str_replace(' ', '_', $namaDokumen) . '.' . $ekstensiBerkas;

        // Pindahkan berkas
        $berkas->move('doc/uploads', $namaBerkas);

        // Ambil tipe berkas
        $tipeBerkas = $berkas->getClientMimeType();

        // Ambil ukuran berkas dalam byte
        $ukuranBerkas = $berkas->getSize();

        // Ubah ukuran berkas menjadi format yang lebih mudah dibaca
        $ukuranBerkasFormatted = $this->formatSizeUnits($ukuranBerkas);

        $save = $this->dokumenPublikModel->save([
            'nama'          => $namaDokumen,
            'tipe'          => $tipeBerkas,
            'ukuran'        => $ukuranBerkasFormatted,
            'berkas'        => $namaBerkas,
            'created_at'    => Time::now('Asia/Singapore', 'en_US'),
            'updated_at'    => Time::now('Asia/Singapore', 'en_US'),
        ]);

        if ($save !== false) {
            return redirect()->to(base_url('dashboard/dokumen'))->with('success-message', "Dokumen berhasil ditambahkan.");
        } else {
            return redirect()->to(base_url('dashboard/dokumen'))->with('error-message', "Dokumen gagal ditambahkan.");
        }
    }

    public function delete($id)
    {
        $dokumen = $this->dokumenPublikModel->find($id);

        if ($dokumen['berkas'] != 'default.pdf') {
            unlink('doc/uploads/' . $dokumen['berkas']);
        }

        $delete = $this->dokumenPublikModel->delete($id);

        if ($delete !== false) {
            return redirect()->to(base_url('dashboard/dokumen'))->with('success-message', "Dokumen berhasil dihapus.");
        } else {
            return redirect()->to(base_url('dashboard/dokumen'))->with('error-message', "Dokumen gagal dihapus.");
        }
    }

    public function download($berkas)
    {
        $dokumen = $this->dokumenPublikModel->where('berkas', $berkas)->first();

        if (empty($dokumen)) {
            // Dokumen tidak ditemukan, redirect ke halaman lain atau tampilkan pesan error
            return redirect()->to(base_url('dashboard/dokumen'))->with('warning-message', "Data tidak ditemukan.");
        }

        // Path lengkap ke file dokumen
        $filePath = 'doc/uploads/' . $dokumen['berkas'];

        // Pastikan file dokumen ada
        if (!file_exists($filePath)) {
            // File tidak ditemukan, redirect ke halaman lain atau tampilkan pesan error
            return redirect()->to(base_url('dashboard/dokumen'))->with('warning-message', "File dokumen tidak ditemukan.");
        }

        // Unduh file
        return $this->response->download($filePath, null);
    }
}
