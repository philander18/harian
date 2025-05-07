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
        // $this->export_log();
        // dd($this->HarianModel->summary(1, 2025));
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

    public function get_tahun()
    {
        $data = $this->HarianModel->get_tahun();
        return $this->response->setJSON($data);
    }

    public function get_summary()
    {
        $data_kirim = $this->request->getJSON(true); // true = as array
        $data = $this->HarianModel->summary($data_kirim['semester'], $data_kirim['tahun']);
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

    public function export_log()
    {
        $tanggal_awal = $this->request->getGet('tanggal_awal');
        $tanggal_akhir = $this->request->getGet('tanggal_akhir');
        if (!$tanggal_awal || !$tanggal_akhir) {
            return redirect()->back()->with('error', 'Tanggal awal dan akhir wajib diisi');
        }

        if ($tanggal_awal > $tanggal_akhir) {
            return redirect()->back()->with('error', 'Tanggal awal tidak boleh lebih besar dari tanggal akhir');
        }
        $data = $this->HarianModel->log($tanggal_awal, $tanggal_akhir);

        // Header CSV
        $filename = 'log_' . date('YmdHis') . '.csv';
        header("Content-Type: text/csv");
        header("Content-Disposition: attachment; filename=\"$filename\"");

        // Buka output
        $file = fopen('php://output', 'w');

        // Tulis header kolom jika ada data
        if (!empty($data)) {
            fputcsv($file, array_keys((array)$data[0]));
        }

        // Tulis baris data
        foreach ($data as $row) {
            fputcsv($file, (array)$row);
        }

        fclose($file);
        exit;
    }
}
