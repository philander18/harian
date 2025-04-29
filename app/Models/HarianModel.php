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
}
