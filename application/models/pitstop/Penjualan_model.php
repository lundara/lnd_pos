<?php
defined('BASEPATH') OR exit('No direct script access allowed');
 
class Penjualan_model extends CI_Model {
 
    var $table = 'pitstop_penjualan';
    var $column_order = array(null, "pitstop_penjualan.no_trans", "pitstop_penjualan.created_on", "pitstop_pelanggan.nama_pelanggan", null, null, "pitstop_penjualan.pembayaran", "pitstop_penjualan.lunas", "user.nama", "pitstop_penjualan.status", null); //set column field database for datatable orderable
    var $column_search = array('pitstop_penjualan.no_trans'); //set column field database for datatable searchable just firstname , lastname , address are searchable
    var $order = array('pitstop_penjualan.created_on' => 'desc'); // default order 
  
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }
 
    private function _get_datatables_query()
    {
        
        $sl = "
            pitstop_penjualan.*,
            pitstop_pelanggan.id AS supid,
            pitstop_pelanggan.nama_pelanggan,
            pitstop_pelanggan.no_hp,
            user.username,
            user.nama,
        ";

        $this->db->select($sl);
        $this->db->from($this->table);
        $this->db->join("pitstop_pelanggan", "pitstop_pelanggan.id = pitstop_penjualan.idpelanggan");
        $this->db->join("user", "user.username = pitstop_penjualan.created_by");
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
    public function laporan_lunas($src_trans, $src_from, $src_to, $src_pelanggan, $src_plat, $src_pembayaran, $src_lunas, $src_status, $src_user){
        $sl = "
            pitstop_penjualan.*,
            pitstop_pelanggan.id AS supid,
            pitstop_pelanggan.nama_pelanggan,
            pitstop_pelanggan.no_hp,
            user.username,
            user.nama,
        ";

        $this->db->select($sl);
        $this->db->from($this->table);
        $this->db->join("pitstop_pelanggan", "pitstop_pelanggan.id = pitstop_penjualan.idpelanggan");
        $this->db->join("user", "user.username = pitstop_penjualan.created_by");
        $this->db->where("pitstop_penjualan.lunas", "Y");
        if ($src_trans!="") {

            $this->db->where("pitstop_penjualan.no_trans", $src_trans);
        }
        if ($src_from!="--" AND $src_to!="--") {
            $this->db->where('DATE(pitstop_penjualan.created_on) >=', $src_from);
            $this->db->where('DATE(pitstop_penjualan.created_on) <=', $src_to);
        }
        if ($src_pelanggan!="") {
            $this->db->like("pitstop_pelanggan.nama_pelanggan", $src_pelanggan);
        }
        if ($src_user!="") {
            $this->db->like("user.nama", $src_user);
        }
        if ($src_plat!="") {
            $this->db->like("pitstop_penjualan.kendaraan", $src_plat);
        }
        if ($src_pembayaran!="") {
            $this->db->where("pitstop_penjualan.pembayaran", $src_pembayaran);
        }
        if ($src_status!="") {
            $this->db->where("pitstop_penjualan.status", $src_status);
        }

        $this->db->order_by("pitstop_penjualan.created_on", "ASC");
        $x = $this->db->get()->result();

        return $x;

    }
    public function laporan_blunas($src_trans, $src_from, $src_to, $src_pelanggan, $src_plat, $src_pembayaran, $src_lunas, $src_status, $src_user){
        $sl = "
            pitstop_penjualan.*,
            pitstop_pelanggan.id AS supid,
            pitstop_pelanggan.nama_pelanggan,
            pitstop_pelanggan.no_hp,
            user.username,
            user.nama,
        ";

        $this->db->select($sl);
        $this->db->from($this->table);
        $this->db->join("pitstop_pelanggan", "pitstop_pelanggan.id = pitstop_penjualan.idpelanggan");
        $this->db->join("user", "user.username = pitstop_penjualan.created_by");
        $this->db->where("pitstop_penjualan.lunas", "N");
        if ($src_trans!="") {

            $this->db->where("pitstop_penjualan.no_trans", $src_trans);
        }
        if ($src_from!="--" AND $src_to!="--") {
            $this->db->where('DATE(pitstop_penjualan.created_on) >=', $src_from);
            $this->db->where('DATE(pitstop_penjualan.created_on) <=', $src_to);
        }
        if ($src_pelanggan!="") {
            $this->db->like("pitstop_pelanggan.nama_pelanggan", $src_pelanggan);
        }
        if ($src_user!="") {
            $this->db->like("user.nama", $src_user);
        }
        if ($src_plat!="") {
            $this->db->like("pitstop_penjualan.kendaraan", $src_plat);
        }
        if ($src_pembayaran!="") {
            $this->db->where("pitstop_penjualan.pembayaran", $src_pembayaran);
        }
        if ($src_status!="") {
            $this->db->where("pitstop_penjualan.status", $src_status);
        }

        $this->db->order_by("pitstop_penjualan.created_on", "ASC");
        $x = $this->db->get()->result();

        return $x;

    }
    function get_total($src_trans, $src_from, $src_to, $src_pelanggan, $src_plat, $src_pembayaran, $src_lunas, $src_status, $src_user){
        $this->_get_datatables_query();
        if ($src_trans!="") {

            $this->db->where("pitstop_penjualan.no_trans", $src_trans);
        }
        if ($src_from!="--" AND $src_to!="--") {
            $this->db->where('DATE(pitstop_penjualan.created_on) >=', $src_from);
            $this->db->where('DATE(pitstop_penjualan.created_on) <=', $src_to);
        }
        if ($src_pelanggan!="") {
            $this->db->like("pitstop_pelanggan.nama_pelanggan", $src_pelanggan);
        }
        if ($src_user!="") {
            $this->db->like("user.nama", $src_user);
        }
        if ($src_plat!="") {
            $this->db->like("pitstop_penjualan.kendaraan", $src_plat);
        }
        if ($src_pembayaran!="") {
            $this->db->where("pitstop_penjualan.pembayaran", $src_pembayaran);
        }
        if ($src_status!="") {
            $this->db->where("pitstop_penjualan.status", $src_status);
        }
        if ($src_lunas!="") {
            $this->db->where("pitstop_penjualan.lunas", $src_lunas);
        }
        $x = $this->db->get()->result();

        foreach ($x as $v) {

            $sl = "
                pitstop_penjualan_detail.id,
                pitstop_penjualan_detail.harga,
                pitstop_penjualan_detail.qty,
                pitstop_penjualan_detail.disc,
                SUM( (pitstop_penjualan_detail.harga * pitstop_penjualan_detail.qty) - ( (pitstop_penjualan_detail.harga * pitstop_penjualan_detail.qty) * pitstop_penjualan_detail.disc/100) ) AS total,
                pitstop_penjualan.no_trans,
                pitstop_penjualan.jasa,
                pitstop_penjualan.status
            ";
            $this->db->select($sl);
            $this->db->from('pitstop_penjualan_detail');
            $this->db->join("pitstop_penjualan", "pitstop_penjualan.no_trans = pitstop_penjualan_detail.no_trans");
            $this->db->where("pitstop_penjualan_detail.no_trans", $v->no_trans);
            $total = $this->db->get()->row_array();

            $ppn    = $total["total"] * 10/100;
            $gt = $total['total'];
            
            if ($total["status"] == "POSTED") {
                $gtotal = $gtotal + ($total["total"] + $total["jasa"]);
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

            $this->db->where("pitstop_penjualan.no_trans", $src_trans);
        }
        if ($src_from!="--" AND $src_to!="--") {
            $this->db->where('DATE(pitstop_penjualan.created_on) >=', $src_from);
            $this->db->where('DATE(pitstop_penjualan.created_on) <=', $src_to);
        }
        if ($src_pelanggan!="") {
            $this->db->like("pitstop_pelanggan.nama_pelanggan", $src_pelanggan);
        }
        if ($src_user!="") {
            $this->db->like("user.nama", $src_user);
        }
        if ($src_plat!="") {
            $this->db->like("pitstop_penjualan.kendaraan", $src_plat);
        }
        if ($src_pembayaran!="") {
            $this->db->where("pitstop_penjualan.pembayaran", $src_pembayaran);
        }
        if ($src_status!="") {
            $this->db->where("pitstop_penjualan.status", $src_status);
        }
        if ($src_lunas!="") {
            $this->db->where("pitstop_penjualan.lunas", $src_lunas);
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

            $this->db->where("pitstop_penjualan.no_trans", $src_trans);
        }
        if ($src_from!="--" AND $src_to!="--") {
            $this->db->where('DATE(pitstop_penjualan.created_on) >=', $src_from);
            $this->db->where('DATE(pitstop_penjualan.created_on) <=', $src_to);
        }
        if ($src_pelanggan!="") {
            $this->db->like("pitstop_pelanggan.nama_pelanggan", $src_pelanggan);
        }
        if ($src_user!="") {
            $this->db->like("user.nama", $src_user);
        }
        if ($src_plat!="") {
            $this->db->like("pitstop_penjualan.kendaraan", $src_plat);
        }
        if ($src_pembayaran!="") {
            $this->db->where("pitstop_penjualan.pembayaran", $src_pembayaran);
        }
        if ($src_status!="") {
            $this->db->where("pitstop_penjualan.status", $src_status);
        }
        if ($src_lunas!="") {
            $this->db->where("pitstop_penjualan.lunas", $src_lunas);
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