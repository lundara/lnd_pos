<?php
defined('BASEPATH') OR exit('No direct script access allowed');
 
class Akses_model extends CI_Model {
 
    var $table = 'akses';
    var $column_order = array('menu.nama_menu', 'modul.nama_modul', 'akses.status',null); //set column field database for datatable orderable
    var $column_search = array('menu.nama_menu', 'modul.nama_modul', 'akses.status',null); //set column field database for datatable searchable just firstname , lastname , address are searchable
    var $order = array('menu.nama_menu' => 'asc'); // default order 
  
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }
 
    private function _get_datatables_query()
    {
         
        $select = "
            akses.*,
            user.username AS iduser,
            user.nama,
            menu.id AS menuid,
            menu.nama_menu,
            modul.id AS modulid,
            modul.nama_modul
        ";

        $this->db->select($select);
        $this->db->from($this->table);
        $this->db->join("menu", "menu.id = akses.idmenu");
        $this->db->join("modul", "menu.idmodul = modul.id");
        $this->db->join("user", "user.username = akses.username");

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
 
    function get_datatables($id)
    {
        $this->_get_datatables_query();
        if ($id!="") {
            $this->db->where("user.username=", $id);      
        }
        if($_POST['length'] != -1)
        $this->db->limit($_POST['length'], $_POST['start']);
        $query = $this->db->get();
        return $query->result();
    }
 
    function count_filtered($id)
    {
        $this->_get_datatables_query();
        if ($id!="") {
            $this->db->where("user.username=", $id);      
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