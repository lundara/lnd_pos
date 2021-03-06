<?php
defined('BASEPATH') OR exit('No direct script access allowed');
 
class Kartu_stok_model extends CI_Model {
 
    var $table = 'stok';
    var $column_order = array('','idproduk', '', null, null); //set column field database for datatable orderable
    var $column_search = array('','idproduk', ''); //set column field database for datatable searchable just firstname , lastname , address are searchable
    var $order = array('created_on' => 'desc'); // default order 
  
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }
    
    function cal($id, $var){
       $q = "
            SELECT
                SUM(awal) AS tawal,
                SUM(jual) AS tjual,
                SUM(beli) AS tbeli,
                SUM(adj) AS tadj,
                SUM(rjual) AS trjual,
                SUM(rbeli) AS trbeli,
                SUM(akhir) AS takhir
            FROM 
                stok_log
            WHERE
                idproduk = '".$id."'
                
       ";
       $d = $this->db->query($q)->row_array();

       return $d;


    }

    private function _get_datatables_query()
    {
        
        $sl = "
            stok.*,
            produk.id AS produk_id,
            produk.nama_produk
        ";

        $this->db->select($sl);
        $this->db->from($this->table);
        $this->db->join("produk", "produk.id = stok.idproduk");
        $this->db->group_by("produk.nama_produk, stok.varian");
        $this->db->order_by("produk.nama_produk, stok.varian", "asc");
        $this->db->where("stok.deleted", "0");
 
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
 
    function get_datatables($src_nama, $src_kode)
    {
        $this->_get_datatables_query();
        if ($src_nama!="") {
            $this->db->like("nama_outlet", $src_nama);
        }
        if ($src_kode!="") {
            $this->db->like("kode_outlet", $src_kode);
        }
        if($_POST['length'] != -1)
        $this->db->limit($_POST['length'], $_POST['start']);
        $query = $this->db->get();
        return $query->result();
    }
 
    function count_filtered($src_nama, $src_kode)
    {
        $this->_get_datatables_query();
        if ($src_nama!="") {
            $this->db->like("nama_outlet", $src_nama);
        }
        if ($src_kode!="") {
            $this->db->like("kode_outlet", $src_kode);
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