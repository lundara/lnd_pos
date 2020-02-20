<?php
defined('BASEPATH') OR exit('No direct script access allowed');
 
class Pembelian_model extends CI_Model {
 
    var $table = 'pitstop_pembelian';
    var $column_order = array(null, "pitstop_pembelian.no_inv", "pitstop_pembelian.created_on", "pitstop_supplier.nama_supplier", null, "user.nama", null); //set column field database for datatable orderable
    var $column_search = array('pitstop_pembelian.no_trans'); //set column field database for datatable searchable just firstname , lastname , address are searchable
    var $order = array('pitstop_pembelian.tgl_inv' => 'desc'); // default order 
  
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }
 
    private function _get_datatables_query()
    {
        
        $sl = "
            pitstop_pembelian.*,
            pitstop_supplier.id AS supid,
            pitstop_supplier.nama_supplier,
            user.username,
            user.nama,
        ";

        $this->db->select($sl);
        $this->db->from($this->table);
        $this->db->join("pitstop_supplier", "pitstop_supplier.id = pitstop_pembelian.idsupplier");
        $this->db->join("user", "user.username = pitstop_pembelian.created_by");
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

    function get_total($src_po, $src_from, $src_to, $src_supplier, $src_user, $src_status){
        $this->_get_datatables_query();
        if ($src_po!="") {

            $this->db->where("pitstop_pembelian.no_inv", $src_po);
        }
        if ($src_from!="--" AND $src_to!="--") {
            $this->db->where('pitstop_pembelian.tgl_inv >=', $src_from);
            $this->db->where('pitstop_pembelian.tgl_inv <=', $src_to);
        }
        if ($src_supplier!="") {
            $this->db->like("pitstop_supplier.nama_supplier", $src_supplier);
        }
        if ($src_user!="") {
            $this->db->like("user.nama", $src_user);
        }
        if ($src_status!="") {
            $this->db->where("pitstop_pembelian.lunas", $src_status);
        }
        $x = $this->db->get()->result();

        foreach ($x as $v) {

            $sl = "
                pitstop_pembelian_detail.id,
                pitstop_pembelian_detail.harga,
                pitstop_pembelian_detail.qty,
                pitstop_pembelian_detail.disc,
                SUM( (pitstop_pembelian_detail.harga * pitstop_pembelian_detail.qty) - ( (pitstop_pembelian_detail.harga * pitstop_pembelian_detail.qty) * pitstop_pembelian_detail.disc/100) ) AS total
            ";
            $this->db->select($sl);
            $this->db->from('pitstop_pembelian_detail');
            $this->db->where("pitstop_pembelian_detail.no_trans", $v->no_trans);
            //$this->db->where("penjualan_detail.retur", "N");
            $total = $this->db->get()->row_array();

            $ppn    = $total["total"] * 10/100;
            if ($v->ppn=="Y") {
                $gt = $total['total']+$ppn;
                $gtotal = $gtotal + (($total["total"] * 10/100))+$total["total"];
            }
            else{
                $gt = $total['total'];
                $gtotal = $gtotal + $total["total"];
            }

        }

        return $gtotal;
    }

    function get_datatables($src_po, $src_from, $src_to, $src_supplier, $src_user, $src_status)
    {
        $this->_get_datatables_query();
        if ($src_po!="") {

            $this->db->where("pitstop_pembelian.no_inv", $src_po);
        }
        if ($src_from!="--" AND $src_to!="--") {
            $this->db->where('pitstop_pembelian.tgl_inv >=', $src_from);
            $this->db->where('pitstop_pembelian.tgl_inv <=', $src_to);
        }
        if ($src_supplier!="") {
            $this->db->like("pitstop_supplier.nama_supplier", $src_supplier);
        }
        if ($src_user!="") {
            $this->db->like("user.nama", $src_user);
        }
        if ($src_status!="") {
            $this->db->where("pitstop_pembelian.lunas", $src_status);
        }
        if($_POST['length'] != -1)
        $this->db->limit($_POST['length'], $_POST['start']);
        $query = $this->db->get();
        return $query->result();
    }
 
    function count_filtered($src_po, $src_from, $src_to, $src_supplier, $src_user, $src_status)
    {
        $this->_get_datatables_query();
        if ($src_po!="") {

            $this->db->where("pitstop_pembelian.no_inv", $src_po);
        }
        if ($src_from!="--" AND $src_to!="--") {
            $this->db->where('pitstop_pembelian.tgl_inv >=', $src_from);
            $this->db->where('pitstop_pembelian.tgl_inv <=', $src_to);
        }
        if ($src_supplier!="") {
            $this->db->like("pitstop_supplier.nama_supplier", $src_supplier);
        }
        if ($src_user!="") {
            $this->db->like("user.nama", $src_user);
        }
        if ($src_status!="") {
            $this->db->where("pitstop_pembelian.lunas", $src_status);
        }
        $query = $this->db->get();
        return $query->num_rows();
    }

    function laporan($src_po, $src_from, $src_to, $src_supplier, $src_user, $src_status){
        $sl = "
            pitstop_pembelian.*,
            pitstop_supplier.id AS supid,
            pitstop_supplier.nama_supplier,
            user.username,
            user.nama,
        ";

        $this->db->select($sl);
        $this->db->from($this->table);
        $this->db->join("pitstop_supplier", "pitstop_supplier.id = pitstop_pembelian.idsupplier");
        $this->db->join("user", "user.username = pitstop_pembelian.created_by");
        if ($src_po!="") {
            $this->db->where("pitstop_pembelian.no_inv", $src_po);
        }
        if ($src_from!="--" AND $src_to!="--") {
            $this->db->where('pitstop_pembelian.tgl_inv >=', $src_from);
            $this->db->where('pitstop_pembelian.tgl_inv <=', $src_to);
        }
        if ($src_supplier!="") {
            $this->db->like("pitstop_supplier.nama_supplier", $src_supplier);
        }
        if ($src_user!="") {
            $this->db->like("user.nama", $src_user);
        }
        if ($src_status!="") {
            $this->db->where("pitstop_pembelian.lunas", $src_status);
        }
        $this->db->order_by("pitstop_pembelian.created_on", "ASC");
        $x = $this->db->get()->result();

        return $x;

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