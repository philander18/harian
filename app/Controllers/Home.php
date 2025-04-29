<?php

namespace App\Controllers;

use App\Models\HarianModel;
use DateTime;

class Home extends BaseController
{
    protected $HarianModel;
    public function __construct()
    {
        $this->HarianModel = new HarianModel();
    }
    public function index()
    {
        // dd($this->HarianModel->get_subkategori('Operasional', '2025-04-29'));
        $session = session();
        if (!$session->has('akses')) {
            return redirect()->to('home/portal');
            exit;
        }
        $data = [
            'judul' => 'Beranda',
            'akses' => $session->akses,
        ];
        return view('Home/index', $data);
    }

    public function get_log()
    {
        $data_kirim = $this->request->getJSON(true); // true = as array
        $data = $this->HarianModel->data_hari($data_kirim['tanggal']);
        return $this->response->setJSON($data);
    }
    public function get_kategori()
    {
        $data = $this->HarianModel->get_kategori();
        return $this->response->setJSON($data);
    }
    public function get_subkategori()
    {
        $data_kirim = $this->request->getJSON(true); // true = as array
        $data = $this->HarianModel->get_subkategori($data_kirim['kategori'], $data_kirim['tanggal']);
        return $this->response->setJSON($data);
    }

    public function tambah_task()
    {
        $data = $this->request->getJSON(true); // true = as array
        if ($data) {
            $data = [
                'tanggal' => $data['tanggal'],
                'keterangan' => $data['keterangan'],
                'durasi' => $data['durasi'],
                'kategori_id' => $this->HarianModel->get_kategori_id($data['kategori'], $data['subkategori'])[0]['id'],
            ];
            if ($this->HarianModel->tambah_task($data)) {
                return $this->response->setJSON(['success' => true]);
            } else {
                return $this->response->setJSON(['success' => false]);
            }
        } else {
            return $this->response->setJSON(['success' => false]);
        }
    }
    public function update_data()
    {
        $data_kirim = $this->request->getJSON(true); // true = as array
        $data = [
            'keterangan' => $data_kirim['keterangan'],
            'durasi' => $data_kirim['durasi'],
        ];
        $this->HarianModel->update_data($data_kirim['id'], $data);
        return $this->response->setJSON(['success' => true]);
    }

    public function generate()
    {
        $data_default = $this->HarianModel->data_default();
        foreach ($data_default as $row) {
            $this->HarianModel->insert_default($_POST['tanggal'], $row['id'], $row['isi']);
        }
    }

    public function portal()
    {
        $session = session();
        if (!is_null($this->request->getVar('kode'))) {
            if (!empty($this->HarianModel->akses($this->request->getVar('kode')))) {
                $session->set('akses', $this->HarianModel->akses($this->request->getVar('kode'))[0]['akses']);
            } else {
                session()->setFlashdata('notifikasi', 'Kode tidak terdaftar.');
            }
        }
        if ($session->has('akses')) {
            return redirect()->to('home');
            exit;
        }
        $data = [
            'judul' => 'Portal',
            'akses' => $session->akses
        ];
        return view('Portal/index', $data);
    }

    public function keluar()
    {
        $session = session();
        $session->remove('akses');
        return redirect()->to('home/portal');
        exit;
    }
}
