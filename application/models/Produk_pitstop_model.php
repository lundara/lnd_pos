<?php
defined('BASEPATH') OR exit('No direct script access allowed');
 
class Produk_pitstop_model extends CI_Model {
 
    var $table = 'pitstop_produk';
    var $column_order = array('','nama_produk', 'type_mobil', 'harga', 'modal', 'nama_satuan', 'merk', 'nama_kategori', null); //set column field database for datatable orderable
    var $column_search = array('','nama_produk'); //set column field database for datatable searchable just firstname , lastname , address are searchable
    var $order = array('nama_produk' => 'asc'); // default order 
  
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }
 
    private function _get_datatables_query()
    {
         
        $select = "
            pitstop_produk.*,
            satuan.id AS satid,
            satuan.nama_satuan,
            pitstop_kategori.id AS katid,
            pitstop_kategori.nama_kategori
        ";

        $this->db->select($select);
        $this->db->from($this->table);
        $this->db->join("satuan", "pitstop_produk.idsatuan = satuan.id");  
        $this->db->join("pitstop_kategori", "pitstop_produk.idkategori = pitstop_kategori.id"); 

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
 
    function get_datatables($src_nama, $src_satuan, $src_kelbar, $src_kelhar, $src_desc)
    {
        $this->_get_datatables_query();
        if ($src_nama!="") {
            $this->db->like("nama_produk", $src_nama);
        }
        if ($src_satuan!="") {
            $this->db->where("idsatuan", $src_satuan);
        }
        if ($src_desc!="") {
            $this->db->like("merk", $src_desc);
        }
        if($_POST['length'] != -1)
        $this->db->limit($_POST['length'], $_POST['start']);
        $query = $this->db->get();
        return $query->result();
    }
 
    function count_filtered($src_nama, $src_satuan, $src_kelbar, $src_kelhar, $src_desc)
    {
        $this->_get_datatables_query();
        if ($src_nama!="") {
            $this->db->like("nama_produk", $src_nama);
        }
        if ($src_satuan!="") {
            $this->db->where("idsatuan", $src_satuan);
        }
        if ($src_desc!="") {
            $this->db->like("merk", $src_desc);
        }
        $query = $this->db->get();
        return $query->num_rows();
    }
 
    public function count_all()
    {
        $this->db->from($this->table);
        return $this->db->count_all_results();
    }

 
 
}