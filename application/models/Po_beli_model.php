<?php
defined('BASEPATH') OR exit('No direct script access allowed');
 
class Po_beli_model extends CI_Model {
 
    var $table = 'po_beli';
    var $column_order = array(null, "po_beli.no_po", "po_beli.created_on", "supplier.nama_supplier", null, "user.nama", "po_beli.status", null); //set column field database for datatable orderable
    var $column_search = array('po_beli.no_po'); //set column field database for datatable searchable just firstname , lastname , address are searchable
    var $order = array('po_beli.created_on' => 'desc'); // default order 
  
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }
 
    private function _get_datatables_query()
    {
        
        $sl = "
            po_beli.*,
            supplier.id AS supid,
            supplier.nama_supplier,
            user.username,
            user.nama
        ";

        $this->db->select($sl);
        $this->db->from($this->table);
        $this->db->join("supplier", "supplier.id = po_beli.idsupplier");
        $this->db->join("user", "user.username = po_beli.created_by");
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
 
    function get_datatables($src_po, $src_from, $src_to, $src_supplier, $src_user, $src_status)
    {
        $this->_get_datatables_query();
        if ($src_po!="") {
            $this->db->where("po_beli.no_po", $src_po);
        }
        if ($src_from!="--" AND $src_to!="--") {
            $this->db->where('po_beli.created_on >=', $src_from." 00:00:00");
            $this->db->where('po_beli.created_on <=', $src_to." 23:59:59");
        }
        if ($src_supplier!="") {
            $this->db->like("supplier.nama_supplier", $src_supplier);
        }
        if ($src_user!="") {
            $this->db->like("user.nama", $src_user);
        }
        if ($src_status!="") {
            $this->db->where("po_beli.status", $src_status);
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
            $this->db->where("po_beli.no_po", $src_po);
        }
        if ($src_from!="" AND $src_to!="") {
            $this->db->where('po_beli.created_on >=', $src_from." 00:00:00");
            $this->db->where('po_beli.created_on <=', $src_to." 23:59:59");
        }
        if ($src_supplier!="") {
            $this->db->like("supplier.nama_supplier", $src_supplier);
        }
        if ($src_user!="") {
            $this->db->like("user.nama", $src_user);
        }
        if ($src_status!="") {
            $this->db->where("po_beli.status", $src_status);
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