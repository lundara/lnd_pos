<?php
defined('BASEPATH') OR exit('No direct script access allowed');
 
class Produk_model extends CI_Model {
 
    var $table = 'produk';
    var $column_order = array('','nama_produk', 'barcode', 'harga', 'modal', 'nama_satuan', 'active' ,null); //set column field database for datatable orderable
    var $column_search = array('','nama_produk'); //set column field database for datatable searchable just firstname , lastname , address are searchable
    var $order = array('nama_produk' => 'asc'); // default order 
  
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    public function get_row($id){
        $this->db->where("id", $id);
        $x = $this->db->get("produk")->row_array();

        return $x;
    }

    public function range_harga($id){

        $this->db->where("idproduk", $id);
        $this->db->order_by("harga", "DESC");
        $max = $this->db->get("stok")->row_array();

        $this->db->where("idproduk", $id);
        $this->db->order_by("harga", "ASC");
        $min = $this->db->get("stok")->row_array();

        if ($min["harga"] != $max["harga"]) {
            $x = $this->lnd->toK($min["harga"])." s/d ".$this->lnd->toK($max["harga"]);
        }
        else{
            $x = $this->lnd->toK($min["harga"]);
        }

        return $x;
    }

    public function range_modal($id){

        $this->db->where("idproduk", $id);
        $this->db->order_by("modal", "DESC");
        $max = $this->db->get("stok")->row_array();

        $this->db->where("idproduk", $id);
        $this->db->order_by("modal", "ASC");
        $min = $this->db->get("stok")->row_array();

        if ($min["modal"] != $max["modal"]) {
            $x = $this->lnd->toK($min["modal"])." s/d ".$this->lnd->toK($max["modal"]);
        }
        else{
            $x = $this->lnd->toK($min["modal"]);
        }

        return $x;
    }

    public function get_varian_koma($id){
        $vr = $this->db->get("varian")->result();
        
        foreach ($vr as $vvr) {
            
            $sl = "
                produk_varian.*,
                varian_detail.id AS var_id,
                varian_detail.nama_varian_detail
            ";

            $this->db->select($sl);
            $this->db->from("produk_varian");
            $this->db->where("varian_id", $vvr->id);
            $this->db->join("varian_detail", "varian_detail.id = produk_varian.idvarian_detail");
            $d = $this->db->get()->result();

            $arr= "";
            foreach ($d as $b) {
                //echo $b->nama_varian_detail."<br>";

                $arr[] = $b->idvarian_detail;
            }

            $arrs[] = $arr;

            
        }

        $combos=$this->possible_combos($arrs);

        return $combos;
        /*
        for($i = 0; $i < count($combos);$i++){
            echo str_replace(" ", ",", $combos[$i])."<br>";
        }*/
    }
    public function possible_combos($groups, $prefix='') {
        $result = array();
        $group = array_shift($groups);
        foreach($group as $selected) {
            if($groups) {
                $result = array_merge($result, $this->possible_combos($groups, $prefix . $selected. ' '));
            } else {
                $result[] = $prefix . $selected;
            }
        }
        return $result;
    }
 
    private function _get_datatables_query()
    {
         
        $select = "
            produk.*,
            satuan.id AS satid,
            satuan.nama_satuan
        ";

        $this->db->select($select);
        $this->db->from($this->table);
        $this->db->join("satuan", "produk.idsatuan = satuan.id");
        $this->db->where("parent", null);  

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

    public function produk_parent($id){

        $this->db->where("parent", $id);
        $this->db->order_by("nama_produk", "asc");
        $x = $this->db->get("produk")->result();

        return $x;
    }
    
    public function cek_varian_produk($id){
        /*
        $this->db->where("idproduk", $id);
        $this->db->where("idvarian_detail", $idv);
        $q = $this->db->get("produk_varian");
        $d = $q->row_array();
        $n = $q->num_rows();

        $x = array(
                "total"     => $n,
                "deleted"   => $d["deleted"],
                "id"        => $d["id"]
            );

        return $x;*/

        $this->db->where("idproduk", $id);
        $this->db->where("deleted", "0");
        $this->db->where("varian!=", "");
        $d = $this->db->get("stok")->num_rows();

        return $d;
    }

    public function cek_barcode($v, $id){
        $this->db->where("barcode", $v);
        if ($id!="") {
            $this->db->where("id!=", $id);
        }
        $c = $this->db->get("produk")->num_rows();

        return $c;
    }

    function get_datatables($src_nama, $src_satuan, $src_kelbar, $src_kelhar, $src_desc, $src_status)
    {
        $this->_get_datatables_query();
        if ($src_nama!="") {
            $this->db->like("nama_produk", $src_nama);
            $this->db->or_like(array("barcode" => $src_nama));
        }
        if ($src_satuan!="") {
            $this->db->where("idsatuan", $src_satuan);
        }
        if ($src_status!="") {
            $this->db->where("active", $src_status);
        }
        if($_POST['length'] != -1)
        $this->db->limit($_POST['length'], $_POST['start']);
        $query = $this->db->get();
        return $query->result();
    }
 
    function count_filtered($src_nama, $src_satuan, $src_kelbar, $src_kelhar, $src_desc, $src_status)
    {
        $this->_get_datatables_query();
        if ($src_nama!="") {
            $this->db->like("nama_produk", $src_nama);
            $this->db->or_like(array("barcode" => $src_nama));
        }
        if ($src_satuan!="") {
            $this->db->where("idsatuan", $src_satuan);
        }
        if ($src_status!="") {
            $this->db->where("active", $src_status);
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