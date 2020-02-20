<?php
defined('BASEPATH') OR exit('No direct script access allowed');
 
class Penjualan_model extends CI_Model {
 
    var $table = 'penjualan';
    var $column_order = array(null, "penjualan.no_trans", "penjualan.created_on", "pelanggan.nama_pelanggan", null, "penjualan.lunas", "user.nama", "penjualan.status", null); //set column field database for datatable orderable
    var $column_search = array('penjualan.no_trans'); //set column field database for datatable searchable just firstname , lastname , address are searchable
    var $order = array('penjualan.created_on' => 'desc'); // default order 
  
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }
 
    private function _get_datatables_query()
    {
        
        $sl = "
            penjualan.*,
            pelanggan.id AS supid,
            pelanggan.nama_pelanggan,
            pelanggan.no_hp,
            user.username,
            user.nama,
        ";

        $this->db->select($sl);
        $this->db->from($this->table);
        $this->db->join("pelanggan", "pelanggan.id = penjualan.idpelanggan");
        $this->db->join("user", "user.username = penjualan.created_by");
        $i = 0;
     
        foreach ($this->column_search as $item) // loop column 
        {
            if($_POST['search']['value']) // if datatable send POST for search
            {
                 
                if($i===0) // first loop
                {
                    $this->db->group_start(); // open bracket. query Where with OR clause better with bracket. because maybe can combine with other WHERE with AND.


                    $this->db->like($item, $_POST['search']['value']);
                }
                else
                {
                    $this->db->or_like($item, $_POST['search']['value']);
                }

 
                if(count($this->column_search) - 1 == $i) //last loop
                    $this->db->group_end(); //close bracket
            }
            $i++;
        }
         
        if(isset($_POST['order'])) // here order processing
        {
            $this->db->order_by($this->column_order[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
        } 
        else if(isset($this->order))
        {
            $order = $this->order;
            $this->db->order_by(key($order), $order[key($order)]);
        }
    }
    public function laporan_lunas($src_trans, $src_from, $src_to, $src_pelanggan, $src_lunas, $src_status, $src_user){
        $sl = "
            penjualan.*,
            pelanggan.id AS supid,
            pelanggan.nama_pelanggan,
            pelanggan.no_hp,
            user.username,
            user.nama,
        ";

        $this->db->select($sl);
        $this->db->from($this->table);
        $this->db->join("pelanggan", "pelanggan.id = penjualan.idpelanggan");
        $this->db->join("user", "user.username = penjualan.created_by");
        $this->db->where("penjualan.lunas", "Y");
        if ($src_trans!="") {

            $this->db->where("penjualan.no_trans", $src_trans);
        }
        if ($src_from!="--" AND $src_to!="--") {
            $this->db->where('DATE(penjualan.created_on) >=', $src_from);
            $this->db->where('DATE(penjualan.created_on) <=', $src_to);
        }
        if ($src_pelanggan!="") {
            $this->db->like("pelanggan.nama_pelanggan", $src_pelanggan);
        }
        if ($src_user!="") {
            $this->db->like("user.nama", $src_user);
        }
        if ($src_status!="") {
            $this->db->where("penjualan.status", $src_status);
        }

        $this->db->order_by("penjualan.created_on", "ASC");
        $x = $this->db->get()->result();

        return $x;

    }
    public function laporan_blunas($src_trans, $src_from, $src_to, $src_pelanggan, $src_lunas, $src_status, $src_user){
        $sl = "
            penjualan.*,
            pelanggan.id AS supid,
            pelanggan.nama_pelanggan,
            pelanggan.no_hp,
            user.username,
            user.nama,
        ";

        $this->db->select($sl);
        $this->db->from($this->table);
        $this->db->join("pelanggan", "pelanggan.id = penjualan.idpelanggan");
        $this->db->join("user", "user.username = penjualan.created_by");
        $this->db->where("penjualan.lunas", "N");
        if ($src_trans!="") {

            $this->db->where("penjualan.no_trans", $src_trans);
        }
        if ($src_from!="--" AND $src_to!="--") {
            $this->db->where('DATE(penjualan.created_on) >=', $src_from);
            $this->db->where('DATE(penjualan.created_on) <=', $src_to);
        }
        if ($src_pelanggan!="") {
            $this->db->like("pelanggan.nama_pelanggan", $src_pelanggan);
        }
        if ($src_user!="") {
            $this->db->like("user.nama", $src_user);
        }
        if ($src_status!="") {
            $this->db->where("penjualan.status", $src_status);
        }

        $this->db->order_by("penjualan.created_on", "ASC");
        $x = $this->db->get()->result();

        return $x;

    }
    function get_total($src_trans, $src_from, $src_to, $src_pelanggan, $src_lunas, $src_status, $src_user){
        $this->_get_datatables_query();
        if ($src_trans!="") {

            $this->db->where("penjualan.no_trans", $src_trans);
        }
        if ($src_from!="--" AND $src_to!="--") {
            $this->db->where('DATE(penjualan.created_on) >=', $src_from);
            $this->db->where('DATE(penjualan.created_on) <=', $src_to);
        }
        if ($src_pelanggan!="") {
            $this->db->like("pelanggan.nama_pelanggan", $src_pelanggan);
        }
        if ($src_user!="") {
            $this->db->like("user.nama", $src_user);
        }
        if ($src_status!="") {
            $this->db->where("penjualan.status", $src_status);
        }
        if ($src_lunas!="") {
            $this->db->where("penjualan.lunas", $src_lunas);
        }
        $x = $this->db->get()->result();

        foreach ($x as $v) {

            $sl = "
                penjualan_detail.id,
                penjualan_detail.harga,
                penjualan_detail.qty,
                penjualan_detail.disc,
                SUM( (penjualan_detail.harga * penjualan_detail.qty) - ( (penjualan_detail.harga * penjualan_detail.qty) * penjualan_detail.disc/100) ) AS total,
                penjualan.no_trans,
                penjualan.status
            ";
            $this->db->select($sl);
            $this->db->from('penjualan_detail');
            $this->db->join("penjualan", "penjualan.no_trans = penjualan_detail.no_trans");
            $this->db->where("penjualan_detail.no_trans", $v->no_trans);
            $total = $this->db->get()->row_array();

            $ppn    = $total["total"] * 10/100;
            $gt = $total['total'];
            
            if ($total["status"] == "POSTED") {
                $gtotal = $gtotal + ($total["total"]);
            }
            else{
                $gtotal = $gtotal + 0;
            }

        }

        return $gtotal;
    }

    function get_datatables($src_trans, $src_from, $src_to, $src_pelanggan, $src_plat, $src_pembayaran, $src_lunas, $src_status, $src_user)
    {
        $this->_get_datatables_query();
        if ($src_trans!="") {

            $this->db->where("penjualan.no_trans", $src_trans);
        }
        if ($src_from!="--" AND $src_to!="--") {
            $this->db->where('DATE(penjualan.created_on) >=', $src_from);
            $this->db->where('DATE(penjualan.created_on) <=', $src_to);
        }
        if ($src_pelanggan!="") {
            $this->db->like("pelanggan.nama_pelanggan", $src_pelanggan);
        }
        if ($src_user!="") {
            $this->db->like("user.nama", $src_user);
        }
        if ($src_plat!="") {
            $this->db->like("penjualan.kendaraan", $src_plat);
        }
        if ($src_pembayaran!="") {
            $this->db->where("penjualan.pembayaran", $src_pembayaran);
        }
        if ($src_status!="") {
            $this->db->where("penjualan.status", $src_status);
        }
        if ($src_lunas!="") {
            $this->db->where("penjualan.lunas", $src_lunas);
        }
        if($_POST['length'] != -1)
        $this->db->limit($_POST['length'], $_POST['start']);
        $query = $this->db->get();
        return $query->result();
    }
 
    function count_filtered($src_trans, $src_from, $src_to, $src_pelanggan, $src_plat, $src_pembayaran, $src_lunas, $src_status)
    {
        $this->_get_datatables_query();
        if ($src_trans!="") {

            $this->db->where("penjualan.no_trans", $src_trans);
        }
        if ($src_from!="--" AND $src_to!="--") {
            $this->db->where('DATE(penjualan.created_on) >=', $src_from);
            $this->db->where('DATE(penjualan.created_on) <=', $src_to);
        }
        if ($src_pelanggan!="") {
            $this->db->like("pelanggan.nama_pelanggan", $src_pelanggan);
        }
        if ($src_user!="") {
            $this->db->like("user.nama", $src_user);
        }
        if ($src_plat!="") {
            $this->db->like("penjualan.kendaraan", $src_plat);
        }
        if ($src_pembayaran!="") {
            $this->db->where("penjualan.pembayaran", $src_pembayaran);
        }
        if ($src_status!="") {
            $this->db->where("penjualan.status", $src_status);
        }
        if ($src_lunas!="") {
            $this->db->where("penjualan.lunas", $src_lunas);
        }
        $query = $this->db->get();
        return $query->num_rows();
    }
 
    public function count_all()
    {
        $this->db->from($this->table);
        return $this->db->count_all_results();
    }
 
    public function get_by_id($id)
    {
        $this->db->from($this->table);
        $this->db->where('id',$id);
        $query = $this->db->get();
 
        return $query->result();
    }
 
    public function save($data)
    {
        $this->db->insert($this->table, $data);
        return $this->db->insert_id();
    }
 
    public function update($where, $data)
    {
        $this->db->update($this->table, $data, $where);
        return $this->db->affected_rows();
    }
 
    public function delete_by_id($id)
    {
        $this->db->where('id', $id);
        return $this->db->delete($this->table);
    }
 
 
}