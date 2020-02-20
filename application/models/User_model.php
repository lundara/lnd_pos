<?php
defined('BASEPATH') OR exit('No direct script access allowed');
 
class User_model extends CI_Model {
 
    var $table = 'user';
    var $column_order = array('','foto', 'username', 'nama', 'idjabatan', 'divisi', null); //set column field database for datatable orderable
    var $column_search = array('','foto', 'username', 'nama', 'idjabatan','divisi',null); //set column field database for datatable searchable just firstname , lastname , address are searchable
    var $order = array('nama' => 'asc'); // default order 
  
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }
 
    private function _get_datatables_query()
    {
         
        $select = "
            user.*,
            jabatan.id AS jabid,
            jabatan.nama_jabatan
        ";

        $this->db->select($select);
        $this->db->from($this->table);
        $this->db->join("jabatan", "user.idjabatan = jabatan.id");
        if ($this->session->userdata("lnd_id") != "lundara") {
            $this->db->where("user.username!=", "lundara");  
        }
            

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
 
    function get_datatables($src_nama, $src_jabatan)
    {
        $this->_get_datatables_query();
        if ($src_nama!="") {
            $this->db->like("nama", $src_nama);
        }
        if ($src_jabatan!="") {
            $this->db->where("idjabatan", $src_jabatan);
        }
        if($_POST['length'] != -1)
        $this->db->limit($_POST['length'], $_POST['start']);
        $query = $this->db->get();
        return $query->result();
    }
 
    function count_filtered($src_nama, $src_jabatan)
    {
        $this->_get_datatables_query();
        if ($src_nama!="") {
            $this->db->like("nama", $src_nama);
        }
        if ($src_jabatan!="") {
            $this->db->where("idjabatan", $src_jabatan);
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