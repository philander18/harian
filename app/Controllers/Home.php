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
        $session = session();
        if (!$session->has('akses')) {
            return redirect()->to('home/portal');
            exit;
        }
        if (!$this->HarianModel->data_hari(date('20y-m-d'))) {
            $data_default = $this->HarianModel->data_default();
            foreach ($data_default as $row) {
                $this->HarianModel->insert_default(date('20y-m-d'), $row['id'], $row['isi']);
            }
        }
        $data = [
            'judul' => 'Beranda',
            'akses' => $session->akses,
        ];
        return view('Home/index', $data);
    }

    public function get_log()
    {
        $data = $this->HarianModel->data_hari(date('20y-m-d'));
        return $this->response->setJSON($data);
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
