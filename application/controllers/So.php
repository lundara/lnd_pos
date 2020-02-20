<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class so extends CI_Controller {

    function __construct(){
        parent::__construct();
        date_default_timezone_set("Asia/Jakarta");
        $this->load->model('penjualan_model','md');
        $this->load->model("Lnd_model", "lnd");


       if(!$this->session->userdata('lnd_id'))
       {
            redirect('login');
       }
    }

    public function index(){        

        //$this->lnd->akses("pitstop/penjualan", "submenu");

        $this->db->where("kode", "lundara");
        $d = $this->db->get("setting")->row_array();

        $this->db->where("finished_by!=", "");
        $this->db->where("finished_on!=", "");
        $so = $this->db->get("so")->row_array();

        if ($so["id"] == "") {
            $idso = "-";
        }
        else{
            $idso = "SO-".$so["id"];
        }

        $data["page"]     = "so";
        $data["menu"]     = "inventory";
        $data["submenu"]  = "so";
        $data["title"]    = "Stok Opname";
        $data["so"]       = $d["so"];
        $data["noso"]     = $idso;
        $this->load->view('main', $data);
        
    }


    function get_trans(){

        $this->db->where("DATE(created_on)", date("Y-m-d"));
        $this->db->order_by("created_on", "desc");
        $q = $this->db->get("penjualan");
        $c = $q->num_rows();
        $v = $q->row_array();

        if ($c!=0) {
            $digit = substr($v["no_trans"], -3);
        }
        else{
            $digit = 0;
        }

        

        $d = json_encode(array(
                //"no_trans"  =>date("y").date("m").sprintf("%04d", $c+1)
                "no_trans"  =>"LNDJ-".date("ymd").sprintf("%03d", $digit+1)
            ));

        $x = "[".$d."]";
        echo $x;

    }


    public function data(){
            error_reporting(0);

            //filter
            $src_trans      = $_POST["src_trans"];
            $src_from       = $_POST["src_from"];
            $src_to         = $_POST["src_to"];
            $src_pelanggan  = $_POST["src_pelanggan"];
            $src_user       = $_POST["src_user"];
            $src_status     = $_POST["src_status"];
            $src_lunas      = $_POST["src_lunas"];

            $list = $this->md->get_datatables($src_trans, $src_from, $src_to, $src_pelanggan, $src_lunas, $src_status, $src_user);
            $data = array();
            $no = $_POST['start'];
            $gtotal = 0;

            foreach ($list as $v) {

                $sl = "
                    penjualan_detail.id,
                    penjualan_detail.harga,
                    penjualan_detail.qty,
                    penjualan_detail.disc,
                    penjualan_detail.modal,
                    SUM( (penjualan_detail.harga * penjualan_detail.qty) - (penjualan_detail.harga * penjualan_detail.qty)*penjualan_detail.disc/100  ) AS total,
                    penjualan.no_trans,
                    penjualan.lunas,
                    penjualan.status
                ";
                $this->db->select($sl);
                $this->db->from('penjualan_detail');
                $this->db->join("penjualan", "penjualan.no_trans = penjualan_detail.no_trans");
                $this->db->where("penjualan_detail.no_trans", $v->no_trans);
                $total = $this->db->get()->row_array();

                $ppn    = $total["total"] * 10/100;

                switch ($v->lunas) {
                    case 'Y':
                        $lunas = "<label class='label bg-blue'>Lunas</label>";
                    break;
                    case 'N':
                        $lunas = "<label class='label bg-red'>Belum Lunas</label>";
                    break;
                    
                    default:
                        $lunas = "<label class='label '>Unknown</label>";
                    break;
                }
                switch ($v->status) {
                    case 'POSTED':
                        $status = "<label class='label bg-blue'>POSTED</label>";
                    break;
                    case 'DRAFT':
                        $status = "<label class='label bg-yellow'>DRAFT</label>";
                    break;
                    
                    default:
                        $status = "<label class='label '>Unknown</label>";
                    break;
                }

                if ($v->status == "POSTED") {
                    $btn_draft = "
                        <li>
                            <a href='javascript:;' onclick='pembayaran(\"".$v->no_trans."\")' data-toggle='modal' data-target='#md-pembayaran'>
                                <i class='fa fa-money fa-lg'></i> Pembayaran
                            </a>
                        </li>
                    ";
                }
                else{
                    $btn_draft = "
                        <li>
                            <a href='javascript:;' onclick='edit_draft(\"".$v->no_trans."\")' data-toggle='modal' data-target='#md-edraft'>
                                <i class='fa fa-pencil fa-lg'></i> Edit Penjualan
                            </a>
                        </li>
                    ";
                }


                $no++;
                $row = array();
                $row[] = "<center>".$no."</center>";
                $row[] = "<center>".$v->no_trans."</center>";
                $row[] = "<center>".date("d/m/Y H:i:s", strtotime($v->created_on))."</center>";
                $row[] = $v->nama_pelanggan;
                $row[] = "<p style='text-align:right'>".number_format($total["total"], 0, ",", ".")."</p>";
                $row[] = "<center>".$lunas."<center>";
                $row[] = $v->nama;
                $row[] = "<center>".$status."<center>";
                //$row[] = $v->status;
     
                //add html for action//width:auto;min-width:2px;margin-left: -125px;margin-bottom: -70px;
                
                $row[] = "
                            <center>
                            <li class='btn-group dropdown act' >
                                <button id='act' class='btn blue dropdown-toggle drop' type='button' data-toggle='dropdown' aria-haspopup='true' aria-expanded='true' style='padding:5px 10px;'>
                                   <i class='fa fa-bars'></i> 
                                </button>
                                <ul class='dropdown-menu' id='dropdown-menu".$no."'  role='menu' style='width:auto;min-width:2px;max-width:200px'>
                                    ".$btn_draft."
                                    
                                    <li>
                                        <a href='javascript:;' onclick='detail(\"".$v->no_trans."\")' data-toggle='modal' data-target='#md-det'>
                                            <i class='fa fa-clipboard fa-lg'></i> Detail
                                        </a>
                                    </li>
                                    <li>
                                        <a href='".base_url()."pitstop/penjualan/print_inv/".$v->no_trans."' target='_blank'>
                                            <i class='fa fa-print fa-lg'></i> Print
                                        </a>
                                    </li>
                                </ul>
                            </li>
                            </center>
                        ";
                $row[] = $this->md->get_total($src_trans, $src_from, $src_to, $src_pelanggan, $src_lunas, $src_status, $src_user);
     
                $data[] = $row;
            }
     
            $output = array(
                            "draw"              => $_POST['draw'],
                            "recordsTotal"      => $this->md->count_all(),
                            "recordsFiltered"   => $this->md->count_filtered($src_trans, $src_from, $src_to, $src_pelanggan, $src_lunas, $src_status, $src_user),
                            "data"              => $data,
                    );
            //output to json format
            echo json_encode($output);
    } 

    
}
