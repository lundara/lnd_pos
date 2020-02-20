<?php
defined('BASEPATH') OR exit('No direct script access allowed');
 
class Invoice_out_model extends CI_Model {
 
    var $table = 'invoice_out';
    var $column_order = array(null, "invoice_out.no_inv", "invoice_out.no_po", "invoice_out.do", "invoice_out.created_on", "pelanggan.nama_pelanggan",null, "pembayaran.nama_pembayaran", "user.nama", null); //set column field database for datatable orderable
    var $column_search = array('invoice_out.no_inv'); //set column field database for datatable searchable just firstname , lastname , address are searchable
    var $order = array('invoice_out.created_on' => 'DESC'); // default order 
  
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    public function laporan_done($src_inv, $src_po, $src_from, $src_to, $src_supplier, $src_user, $src_status, $src_bayar){
        $sl = "
            invoice_out.*,
            pelanggan.id AS pelid,
            pelanggan.nama_pelanggan,
            user.username,
            user.nama,
            bank.id AS bankid,
            bank.nama_bank,
            bank.no_rek,
            bank.atas_nama,
            pembayaran.id AS pemid,
            pembayaran.nama_pembayaran,
            po_in.no_trans,
            po_in.no_po AS poin,
            po_in.idpelanggan,
            po_in.status,
            po_in.idpembayaran,
            po_in.ppn
        ";

        $this->db->select($sl);
        $this->db->from($this->table);
        $this->db->join("po_in", "po_in.no_po = invoice_out.no_po");
        $this->db->join("pelanggan", "pelanggan.id = po_in.idpelanggan");
        $this->db->join("user", "user.username = invoice_out.created_by");
        $this->db->join("bank", "bank.id = po_in.idbank", "left outer");
        $this->db->join("pembayaran", "pembayaran.id = po_in.idpembayaran");
        if ($src_inv!="") {
            $this->db->where("invoice_out.no_inv", $src_inv); 
        }
        if ($src_po!="") {
            $this->db->where("invoice_out.no_po", $src_po); 
        }
        if ($src_from!="--" AND $src_to!="--") {
            $this->db->where('invoice_out.created_on >=', $src_from." 00:00:00");
            $this->db->where('invoice_out.created_by <=', $src_to." 59:59:59");
        }
        if ($src_supplier!="") {
            $this->db->like("pelanggan.nama_pelanggan", $src_supplier);
        }
        if ($src_user!="") {
            $this->db->like("user.nama", $src_user);
        }
        if ($src_status!="") {
            $this->db->where("po_in.status", $src_status);
        }
        if ($src_bayar!="") {
            $this->db->where("po_in.idpembayaran", $src_bayar);
        }
        $this->db->order_by("invoice_out.created_on", "ASC");
        $x = $this->db->get()->result();

        return $x;

    }
    public function laporan_user($src_po, $src_from, $src_to, $src_supplier, $src_user, $src_status, $src_bayar){
        $sl = "
            invoice_out.*,
            pelanggan.id AS pelid,
            pelanggan.nama_pelanggan,
            user.username,
            user.nama,
            bank.id AS bankid,
            bank.nama_bank,
            bank.no_rek,
            bank.atas_nama,
            pembayaran.id AS pemid,
            pembayaran.nama_pembayaran,
            po_in.no_trans,
            po_in.no_po AS poin,
            po_in.idpelanggan,
            po_in.status,
            po_in.idpembayaran
        ";

        $this->db->select($sl);
        $this->db->from($this->table);
        $this->db->join("po_in", "po_in.no_po = invoice_out.no_po");
        $this->db->join("pelanggan", "pelanggan.id = po_in.idpelanggan");
        $this->db->join("user", "user.username = invoice_out.created_by");
        $this->db->join("bank", "bank.id = po_in.idbank", "left outer");
        $this->db->join("pembayaran", "pembayaran.id = po_in.idpembayaran");
        if ($src_po!="") {
            $this->db->where("po_in.no_po", $src_po); 
        }
        if ($src_from!="--" AND $src_to!="--") {
            $this->db->where('po_in.tgl_po >=', $src_from);
            $this->db->where('po_in.tgl_po <=', $src_to);
        }
        if ($src_supplier!="") {
            $this->db->like("pelanggan.nama_pelanggan", $src_supplier);
        }
        if ($src_user!="") {
            $this->db->like("user.nama", $src_user);
        }
        if ($src_status!="") {
            $this->db->where("po_in.status", $src_status);
        }
        if ($src_bayar!="") {
            $this->db->where("po_in.idpembayaran", $src_bayar);
        }
        $this->db->order_by("pelanggan.nama_pelanggan", "ASC");
        $x = $this->db->get()->result();

        return $x;

    }
    
    private function _get_datatables_query()
    {
        
        $sl = "
            invoice_out.*,
            pelanggan.id AS pelid,
            pelanggan.nama_pelanggan,
            user.username,
            user.nama,
            bank.id AS bankid,
            bank.nama_bank,
            bank.no_rek,
            bank.atas_nama,
            pembayaran.id AS pemid,
            pembayaran.nama_pembayaran,
            po_in.no_trans,
            po_in.no_po AS poin,
            po_in.idpelanggan,
            po_in.status,
            po_in.idpembayaran
        ";

        $this->db->select($sl);
        $this->db->from($this->table);
        $this->db->join("po_in", "po_in.no_po = invoice_out.no_po");
        $this->db->join("pelanggan", "pelanggan.id = po_in.idpelanggan");
        $this->db->join("user", "user.username = invoice_out.created_by");
        $this->db->join("bank", "bank.id = po_in.idbank", "left outer");
        $this->db->join("pembayaran", "pembayaran.id = po_in.idpembayaran");
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

    function get_total($src_inv, $src_po, $src_from, $src_to, $src_supplier, $src_user, $src_status, $src_bayar){
        $this->_get_datatables_query();
        if ($src_inv!="") {
            $this->db->where("invoice_out.no_inv", $src_inv); 
        }
        if ($src_po!="") {
            $this->db->where("invoice_out.no_po", $src_po); 
        }
        if ($src_from!="--" AND $src_to!="--") {
            $this->db->where('invoice_out.created_on >=', $src_from." 00:00:00");
            $this->db->where('invoice_out.created_by <=', $src_to." 59:59:59");
        }
        if ($src_supplier!="") {
            $this->db->like("pelanggan.nama_pelanggan", $src_supplier);
        }
        if ($src_user!="") {
            $this->db->like("user.nama", $src_user);
        }
        if ($src_status!="") {
            $this->db->where("po_in.status", $src_status);
        }
        if ($src_bayar!="") {
            $this->db->where("po_in.idpembayaran", $src_bayar);
        }
        $x = $this->db->get()->result();

        $sl = "
            invoice_out.*,
            SUM(invoice_out.nominal) AS jml
        ";
        $this->db->select($sl);
        $this->db->from("invoice_out");
        $d = $this->db->get()->row_array();
        $gtotal = $d["jml"];
        return $gtotal;
    }
 
    function get_datatables($src_inv, $src_po, $src_from, $src_to, $src_supplier, $src_user, $src_status, $src_bayar)
    {
        $this->_get_datatables_query();
        if ($src_inv!="") {
            $this->db->where("invoice_out.no_inv", $src_inv); 
        }
        if ($src_po!="") {
            $this->db->where("invoice_out.no_po", $src_po); 
        }
        if ($src_from!="--" AND $src_to!="--") {
            $this->db->where('invoice_out.created_on >=', $src_from." 00:00:00");
            $this->db->where('invoice_out.created_by <=', $src_to." 59:59:59");
        }
        if ($src_supplier!="") {
            $this->db->like("pelanggan.nama_pelanggan", $src_supplier);
        }
        if ($src_user!="") {
            $this->db->like("user.nama", $src_user);
        }
        if ($src_status!="") {
            $this->db->where("po_in.status", $src_status);
        }
        if ($src_bayar!="") {
            $this->db->where("po_in.idpembayaran", $src_bayar);
        }
        if($_POST['length'] != -1)
        $this->db->limit($_POST['length'], $_POST['start']);
        //$this->db->limit(1);
        $query = $this->db->get();
        return $query->result();
    }
 
    function count_filtered($src_inv, $src_po, $src_from, $src_to, $src_supplier, $src_user, $src_status, $src_bayar)
    {
        $this->_get_datatables_query();
        if ($src_inv!="") {
            $this->db->where("invoice_out.no_inv", $src_inv); 
        }
        if ($src_po!="") {
            $this->db->where("invoice_out.no_po", $src_po); 
        }
        if ($src_from!="--" AND $src_to!="--") {
            $this->db->where('invoice_out.created_on >=', $src_from." 00:00:00");
            $this->db->where('invoice_out.created_by <=', $src_to." 59:59:59");
        }
        if ($src_supplier!="") {
            $this->db->like("pelanggan.nama_pelanggan", $src_supplier);
        }
        if ($src_user!="") {
            $this->db->like("user.nama", $src_user);
        }
        if ($src_status!="") {
            $this->db->where("po_in.status", $src_status);
        }
        if ($src_bayar!="") {
            $this->db->where("po_in.idpembayaran", $src_bayar);
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