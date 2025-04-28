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
}
