<?php
defined('BASEPATH') OR exit('No direct script access allowed');
 
class Quotation_model extends CI_Model {
 
    var $table = 'quotation';
    var $column_order = array(null, "quotation.no_trans", "quotation.created_on", "pelanggan.nama_pelanggan",null, "pembayaran.nama_pembayaran", null, "user.nama", "quotation.status", null); //set column field database for datatable orderable
    var $column_search = array('quotation.no_trans'); //set column field database for datatable searchable just firstname , lastname , address are searchable
    var $order = array('quotation.created_on' => 'desc'); // default order 
  
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    public function laporan_tgl($src_po, $src_from, $src_to, $src_supplier, $src_user, $src_status, $src_bayar){
        $sl = "
            quotation.*,
            pelanggan.id AS pelid,
            pelanggan.nama_pelanggan,
            user.username,
            user.nama,
            bank.id AS bankid,
            bank.nama_bank,
            bank.no_rek,
            bank.atas_nama,
            pembayaran.id AS pemid,
            pembayaran.nama_pembayaran
        ";

        $this->db->select($sl);
        $this->db->from($this->table);
        $this->db->join("pelanggan", "pelanggan.id = quotation.idpelanggan");
        $this->db->join("user", "user.username = quotation.created_by");
        $this->db->join("bank", "bank.id = quotation.idbank");
        $this->db->join("pembayaran", "pembayaran.id = quotation.idpembayaran");
        if ($src_po!="") {
            $revisi = substr($src_po, 8,1);
            $trans = substr($src_po, 0,8);

            $this->db->where("quotation.no_trans", $trans);
            if ($revisi!="") {
                $this->db->where("quotation.revisi", $revisi);
            }
        }
        if ($src_from!="--" AND $src_to!="--") {
            $this->db->where('quotation.created_on >=', $src_from." 00:00:00");
            $this->db->where('quotation.created_on <=', $src_to." 23:59:59");
        }
        if ($src_supplier!="") {
            $this->db->like("pelanggan.nama_pelanggan", $src_supplier);
        }
        if ($src_user!="") {
            $this->db->like("user.nama", $src_user);
        }
        if ($src_status!="") {
            $this->db->where("quotation.status", $src_status);
        }
        if ($src_bayar!="") {
            $this->db->where("quotation.idpembayaran", $src_bayar);
        }
        $this->db->order_by("quotation.created_on", "ASC");
        $x = $this->db->get()->result();

        return $x;

    }
    public function laporan_user($src_po, $src_from, $src_to, $src_supplier, $src_user, $src_status, $src_bayar){
        $sl = "
            quotation.*,
            pelanggan.id AS pelid,
            pelanggan.nama_pelanggan,
            user.username,
            user.nama,
            bank.id AS bankid,
            bank.nama_bank,
            bank.no_rek,
            bank.atas_nama,
            pembayaran.id AS pemid,
            pembayaran.nama_pembayaran
        ";

        $this->db->select($sl);
        $this->db->from($this->table);
        $this->db->join("pelanggan", "pelanggan.id = quotation.idpelanggan");
        $this->db->join("user", "user.username = quotation.created_by");
        $this->db->join("bank", "bank.id = quotation.idbank");
        $this->db->join("pembayaran", "pembayaran.id = quotation.idpembayaran");
        if ($src_po!="") {
            $revisi = substr($src_po, 8,1);
            $trans = substr($src_po, 0,8);

            $this->db->where("quotation.no_trans", $trans);
            if ($revisi!="") {
                $this->db->where("quotation.revisi", $revisi);
            }
        }
        if ($src_from!="--" AND $src_to!="--") {
            $this->db->where('quotation.created_on >=', $src_from." 00:00:00");
            $this->db->where('quotation.created_on <=', $src_to." 23:59:59");
        }
        if ($src_supplier!="") {
            $this->db->like("pelanggan.nama_pelanggan", $src_supplier);
        }
        if ($src_user!="") {
            $this->db->like("user.nama", $src_user);
        }
        if ($src_status!="") {
            $this->db->where("quotation.status", $src_status);
        }
        if ($src_bayar!="") {
            $this->db->where("quotation.idpembayaran", $src_bayar);
        }
        $this->db->order_by("pelanggan.nama_pelanggan", "ASC");
        $x = $this->db->get()->result();

        return $x;

    }
    
    private function _get_datatables_query()
    {
        
        $sl = "
            quotation.*,
            pelanggan.id AS pelid,
            pelanggan.nama_pelanggan,
            user.username,
            user.nama,
            bank.id AS bankid,
            bank.nama_bank,
            bank.no_rek,
            bank.atas_nama,
            pembayaran.id AS pemid,
            pembayaran.nama_pembayaran
        ";

        $this->db->select($sl);
        $this->db->from($this->table);
        $this->db->join("pelanggan", "pelanggan.id = quotation.idpelanggan");
        $this->db->join("user", "user.username = quotation.created_by");
        $this->db->join("bank", "bank.id = quotation.idbank");
        $this->db->join("pembayaran", "pembayaran.id = quotation.idpembayaran");
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
    function get_total($src_po, $src_from, $src_to, $src_supplier, $src_user, $src_status, $src_bayar){
        $this->_get_datatables_query();
        if ($src_po!="") {
            $revisi = substr($src_po, 8,1);
            $trans = substr($src_po, 0,8);

            $this->db->where("quotation.no_trans", $trans);
            if ($revisi!="") {
                $this->db->where("quotation.revisi", $revisi);
            }
        }
        if ($src_from!="--" AND $src_to!="--") {
            $this->db->where('quotation.created_on >=', $src_from." 00:00:00");
            $this->db->where('quotation.created_on <=', $src_to." 23:59:59");
        }
        if ($src_supplier!="") {
            $this->db->like("pelanggan.nama_pelanggan", $src_supplier);
        }
        if ($src_user!="") {
            $this->db->like("user.nama", $src_user);
        }
        if ($src_status!="") {
            $this->db->where("quotation.status", $src_status);
        }
        if ($src_bayar!="") {
            $this->db->where("quotation.idpembayaran", $src_bayar);
        }
        $x = $this->db->get()->result();

        foreach ($x as $v) {
            $sl = "
                quotation_detail.id,
                quotation_detail.harga,
                quotation_detail.qty,
                quotation_detail.disc,
                SUM( ( (quotation_detail.harga + quotation_detail.fee) * quotation_detail.qty) - ( ((quotation_detail.harga + quotation_detail.fee) * quotation_detail.qty) * quotation_detail.disc/100) ) AS total
            ";
            $this->db->select($sl);
            $this->db->from('quotation_detail');
            $this->db->where("quotation_detail.no_trans", $v->no_trans);
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
    function get_datatables($src_po, $src_from, $src_to, $src_supplier, $src_user, $src_status, $src_bayar)
    {
        $this->_get_datatables_query();
        if ($src_po!="") {

            $revisi = substr($src_po, 8,1);
            $trans = substr($src_po, 0,8);

            $this->db->where("quotation.no_trans", $trans);
            if ($revisi!="") {
                $this->db->where("quotation.revisi", $revisi);
            }
            
        }
        if ($src_from!="--" AND $src_to!="--") {
            $this->db->where('quotation.created_on >=', $src_from." 00:00:00");
            $this->db->where('quotation.created_on <=', $src_to." 23:59:59");
        }
        if ($src_supplier!="") {
            $this->db->like("pelanggan.nama_pelanggan", $src_supplier);
        }
        if ($src_user!="") {
            $this->db->like("user.nama", $src_user);
        }
        if ($src_status!="") {
            $this->db->where("quotation.status", $src_status);
        }
        if ($src_bayar!="") {
            $this->db->where("quotation.idpembayaran", $src_bayar);
        }
        if($_POST['length'] != -1)
        $this->db->limit($_POST['length'], $_POST['start']);
        //$this->db->limit(1);
        $query = $this->db->get();
        return $query->result();
    }
 
    function count_filtered($src_po, $src_from, $src_to, $src_supplier, $src_user, $src_status, $src_bayar)
    {
        $this->_get_datatables_query();
        if ($src_po!="") {
            $revisi = substr($src_po, 8,1);
            $trans = substr($src_po, 0,8);

            $this->db->where("quotation.no_trans", $trans);
            if ($revisi!="") {
                $this->db->where("quotation.revisi", $revisi);
            }
        }
        if ($src_from!="--" AND $src_to!="--") {
            $this->db->where('quotation.created_on >=', $src_from." 00:00:00");
            $this->db->where('quotation.created_on <=', $src_to." 23:59:59");
        }
        if ($src_supplier!="") {
            $this->db->like("pelanggan.nama_pelanggan", $src_supplier);
        }
        if ($src_user!="") {
            $this->db->like("user.nama", $src_user);
        }
        if ($src_status!="") {
            $this->db->where("quotation.status", $src_status);
        }
        if ($src_bayar!="") {
            $this->db->where("quotation.idpembayaran", $src_bayar);
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