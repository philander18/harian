<?php

namespace App\Models;

use CodeIgniter\Model;

class HarianModel extends Model
{
    protected $table = 'log';
    protected $allowedFields = ['tanggal', 'durasi', 'kategori', 'subkategori', 'keterangan', 'updated_at'];
    public function akses($kode)
    {
        $where = "kode = '" . $kode . "'";
        return $this->db->table('akses')->select('akses, kode')->where($where)->get()->getResultArray();
    }

    public function insert_default($tanggal, $id, $isi)
    {
        $data = [
            'tanggal' => $tanggal,
            'durasi' => 0,
            'kategori_id' => $id,
            'keterangan' => $isi,
        ];
        return $this->db->table('log')->insert($data);
    }

    public function data_default()
    {
        return $this->db->table('kategori')->select('id,isi')->where('standar = 1')->get()->getResultArray();
    }

    public function data_hari($hari)
    {
        $select = "log.id as id,log.tanggal, kategori.kategori, kategori.subkategori, log.keterangan, log.durasi";
        return $this->db->table('log')->join('kategori', 'kategori.id = log.kategori_id', 'left')->select($select)->where("log.tanggal = '" . $hari . "'")->orderBy('kategori.kategori asc, kategori.subkategori asc')->get()->getResultArray();
    }
    public function get_kategori()
    {
        return $this->db->table('kategori')->select('kategori')->distinct('kategori')->orderBy('kategori asc')->get()->getResultArray();
    }
    public function get_subkategori($kategori, $tanggal)
    {
        $subquery = $this->db->table('log')->select('kategori_id')->where("tanggal = '" . $tanggal . "'");
        return $this->db->table('kategori')->select('subkategori')->whereNotIn('id', $subquery)->where("kategori = '" . $kategori . "'")->get()->getResultArray();
    }
    public function get_kategori_id($kategori, $subkategori)
    {
        $where = "kategori = '" . $kategori . "' and subkategori = '" . $subkategori . "'";
        return $this->db->table('kategori')->select('id')->where($where)->get()->getResultArray();
    }
    public function get_tahun()
    {
        return $this->db->table('log')->select("year(tanggal) as tahun")->groupBy("year(tanggal)")->get()->getResultArray();
    }
    public function tambah_task($data)
    {
        return $this->db->table('log')->insert($data);
    }
    public function update_data($id, $data)
    {
        return $this->db->table('log')->where('id', $id)->update($data);
    }
    public function total_durasi($tanggal)
    {
        return $this->db->table('log')->select('sum(durasi) as total')->where("tanggal = '" . $tanggal . "'")->get()->getResultArray();
    }
    public function summary($semester, $tahun)
    {
        $select = "kategori.kategori as kategori, round((sum(durasi)/480),2) as hari";
        $bulan = $semester == 1 ? '1 and 6' : '7 and 12';
        $where = "log.durasi <> 0 and year(log.tanggal) = " . $tahun . " and month(log.tanggal) BETWEEN " . $bulan;
        return $this->db->table('log')->join('kategori', 'log.kategori_id = kategori.id', 'left')->select($select)->where($where)->groupBy('kategori.kategori')->get()->getResultArray();
    }

    public function log($tanggal_awal, $tanggal_akhir)
    {
        $select = "log.tanggal as tanggal, (log.durasi / 60) as durasi, kategori.kategori as kategori, kategori.subkategori as subkategori, log.keterangan as keterangan";
        $where = "log.durasi <> 0 and tanggal >= '" . $tanggal_awal . "' and tanggal <= '" . $tanggal_akhir . "'";
        return $this->db->table('log')->join('kategori', 'log.kategori_id = kategori.id', 'left')->select($select)->where($where)->orderBy("log.tanggal asc, kategori.kategori asc, kategori.subkategori asc")->get()->getResultArray();
    }
}
