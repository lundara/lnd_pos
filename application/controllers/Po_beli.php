<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class po_beli extends CI_Controller {

    function __construct(){
        parent::__construct();
        date_default_timezone_set("Asia/Jakarta");
        $this->load->model('Po_beli_model','md');
        $this->load->model("Lnd_model", "lnd");


       if(!$this->session->userdata('lnd_id'))
       {
        	redirect('login');
       }
    }

	public function index(){        

        $this->lnd->akses("po_beli", "submenu");

		$data["page"]	  = "po_beli";
        $data["menu"]     = "transaksi";
        $data["submenu"]  = "po_beli";
		$this->load->view('main', $data);
		
	}
    public function select2(){
        $sl = "
            po_beli.*
        ";
        $this->db->select($sl);
        $this->db->from("po_beli");
        $this->db->like("no_po", $_POST["term"]);
        $d = $this->db->get()->result();


        $no = 0;
        $data = "[";
        foreach ($d as $v) {
            
            if ($no > 0) {
                $data.=", ";
            }

            $dt = array(
                    "id"            => $v->no_po
                );

            $data .= json_encode($dt);
            $no++;
        }

        $data.="]";

        echo $data;
    }

    public function add(){
        error_reporting(0);

        $session_no = count($_SESSION['po']);
        $no_item    = $session_no+1;

        $id     = $_POST["id"];
        $harga  = str_replace(".","",$_POST["harga"]);
        $qty    = str_replace(".","",$_POST["qty"]);
        $satuan = $_POST["satuan"];

        if ($session_no!=0) {
            for($i=1;$i<=$session_no;$i++){

                if ($_SESSION["po"][$i][0] == $id) {
                    $mqty       = $qty + $_SESSION["po"][$i][1];
                    $sess_id    = $_SESSION["po"][$i][2];
                    break 1;
                }
                else{
                    $mqty = $qty;
                    $sess_id = $no_item;
                }



            }
        }
        else{
            $mqty = $qty;
            $sess_id = $no_item;
        }

        



        $_SESSION['po'][$sess_id][0]=$id; // idproduk
        $_SESSION['po'][$sess_id][1]=$mqty; //qty
        $_SESSION['po'][$sess_id][2]=$sess_id; //session id
        $_SESSION['po'][$sess_id][3]=$harga; //harga
        $_SESSION['po'][$sess_id][4]=$satuan; //satuan

        echo "1";

    }

    public function del(){

        $id = $_POST["id"];

        unset($_SESSION['po'][$id][0]);
        unset($_SESSION['po'][$id][1]);
        unset($_SESSION['po'][$id][2]);
        unset($_SESSION['po'][$id][3]);
        unset($_SESSION['po'][$id][4]);

    }
    function save(){
        error_reporting(0);

        $no_trans   = $_POST["no_trans"];
        $user       = $this->lnd->me();
        $supplier   = $_POST["supplier"];
        $untuk      = $_POST["untuk"];

        $this->db->where("no_po", $no_trans);
        $c = $this->db->get("po_beli")->num_rows();

        if ($c==0) {
            $no_po = $no_trans;
        }
        else{
            $no_po = $no_trans.rand(0,999);
        }


        $dt = array(
                "no_po"         => $no_po,
                "created_by"    => $user["username"],
                "idsupplier"    => $supplier,
                "created_on"    => date("Y-m-d H:i:s")
            );

        $this->db->trans_start();

            $this->db->insert("po_beli", $dt);


            $session_no = count($_SESSION['po']);
            for($i=1;$i<=$session_no;$i++){
                if ($_SESSION["po"][$i][2]!="") {

                    $ppn = ($_SESSION["po"][$i][3]) - (($_SESSION["po"][$i][3]) * 10 / 100);
                    $tax = ($_SESSION["po"][$i][3]) - $ppn;

                    $dt2 = array(
                            "iditem"        => $_SESSION["po"][$i][0],
                            "harga"         => $_SESSION["po"][$i][3],
                            "disc"          => "0",
                            "tax"           => $tax,
                            "no_po"         => $no_po,
                            "qty"           => $_SESSION["po"][$i][1]
                        );

                    $this->db->insert("po_beli_detail", $dt2);
                        
                }
                
            }

            

        $this->db->trans_complete();          

        if ($this->db->trans_status() === TRUE) {
            $this->db->trans_commit();
            echo "1";
            $this->des();
        }   
        else{
            $this->db->trans_rollback();
            echo "0";
        }  


    }
    public function des(){
        $this->session->unset_userdata('po');
    }
    public function data_item(){
        error_reporting(0);

        $session_no = count($_SESSION['po']);
        $json = "[";
        $no = 1;
        $vpot = 0;
        for($i=1;$i<=$session_no;$i++){



            if ($_SESSION["po"][$i][2]!="") {
                if ($no>1) {
                    $json.=",";
                }
                $this->db->where("produk.id", $_SESSION["po"][$i][0]);
                $produk = $this->db->get("produk")->row_array();

                if ($produk["deskripsi"]==null) {
                    $desc = "";
                }
                else{
                    $desc = $produk["deskripsi"];
                }

                $dt = array(
                        "id_produk"     => $_SESSION["po"][$i][0],
                        "nama_item"     => $produk["nama_produk"],
                        "qty"           => $_SESSION["po"][$i][1],
                        "harga"         => $_SESSION['po'][$i][3],
                        "netto"         => ($_SESSION['po'][$i][3] * $_SESSION["po"][$i][1]),
                        "brutto"        => ($_SESSION['po'][$i][3] * $_SESSION["po"][$i][1]),
                        "id"            => $_SESSION["po"][$i][2],
                        "pot"           => "0",
                        "total_item"    => $no,
                        "satuan"        => $_SESSION["po"][$i][4],
                        "desc"          => $desc

                    );

                $json.=json_encode($dt);
                $no++;
            }
            
        }

        $json.="]";
        
        echo $json;


    }

    function get_trans(){

        $this->db->where("MONTH(created_on)", date("m"));
        $c = $this->db->get("po_beli")->num_rows();

        $d = json_encode(array(
                "no_trans"  => "NOBIPO.".date("y").date("m").sprintf("%04d", $c+1)
            ));

        $x = "[".$d."]";
        echo $x;

    }

    function print_po(){
        $red=array(255,0,0);
        $blue=array(0,0,200);
        $yellow=array(255,255,0);
        $green=array(0,255,0);
        $white=array(255);
        $black=array(0);

        $coords=array(0,0,1,0);

        $no = $this->uri->segment(3);

        $sl1 = "
            po_beli.*,
            supplier.id AS supid,
            supplier.nama_supplier,
            supplier.alamat,
            supplier.telp,
            user.username,
            user.nama
        ";
        $this->db->select($sl1);
        $this->db->from("po_beli");
        $this->db->join("supplier", "supplier.id = po_beli.idsupplier");
        $this->db->join("user", "user.username = po_beli.created_by");
        $this->db->where("po_beli.no_po", $no);
        $h = $this->db->get()->row_array();


        $this->load->library('pdf');
        //$this->load->library('pdf_gradient');

        $pdf = new FPDF('p','mm', array(215,330));
        // membuat halaman baru
        $pdf->AddPage();
        // setting jenis font yang akan digunakan

        //logo
        $pdf->Image(base_url()."assets/img/logo_shin.png", 25, 15, 20,20);

        $pdf->SetFont('Arial','B',16);
        $pdf->SetTextColor(74,135,175);
        $pdf->SetXY(23, 15);
        $pdf->Cell(168,10,'PURCHASE ORDER',0,1,'R');

        $pdf->SetTextColor(0,0,0);
        $pdf->SetFont('Arial','B',11);
        $pdf->SetXY(23, 40);
        $pdf->Cell(168,5,'PT. CHAKRA BASKARA TEKNO',0,1,'L');
        $pdf->SetXY(23, 45);
        $pdf->Cell(168,5,'THE TRULLY YOUR BUSSISNES PARTNER',0,1,'L');

        $pdf->SetFont('Arial','',9);
        $pdf->SetXY(23, 55);
        $pdf->Cell(168,5,'Jl. Mohammad Toha No. 367B',0,1,'L');

        $pdf->SetXY(23, 60);
        $pdf->Cell(168,5,'Bandung',0,1,'L');

        $pdf->SetXY(23, 65);
        $pdf->Cell(168,5,'021-xxxxxxx',0,1,'L');

        $pdf->SetXY(23, 70);
        $pdf->Cell(168,5,'test@mail.com',0,1,'L');

        $pdf->SetFont('Arial','B',9);
        $pdf->SetXY(100, 55);
        $pdf->Cell(168,5,'PO. NO',0,1,'L');

        $pdf->SetXY(100, 60);
        $pdf->Cell(168,5,'DATE',0,1,'L');

        $pdf->SetXY(100, 65);
        $pdf->Cell(168,5,'VENDOR',0,1,'L');

        $pdf->SetFont('Arial','',9);
        $pdf->SetXY(120, 55);
        $pdf->Cell(168,5,': '.$no,0,1,'L');

        $pdf->SetXY(120, 60);
        $pdf->Cell(168,5,': '.date('F d, Y'),0,1,'L');

        $pdf->SetXY(120, 65);
        $pdf->Cell(168,5,': '.$h['nama_supplier'],0,1,'L');

        $pdf->SetFont('Arial','B',9);
        $pdf->SetXY(23, 80);
        $pdf->Cell(168,5,'VENDOR',0,1,'L');
        $pdf->SetXY(100, 80);
        $pdf->Cell(168,5,'SHIP TO',0,1,'L');


        $pdf->SetFont('Arial','',9);
        $pdf->SetXY(45, 80);
        $pdf->MultiCell(168,5,$h['nama_supplier'],0,'L');
        $pdf->SetXY(45, 85);
        $pdf->MultiCell(55,5, $h['alamat'],1,'L');

        $pdf->SetXY(120, 80);
        $pdf->MultiCell(168,5, "PT. CHAKRA BASKARA TEKNO",0,'L');
        $pdf->SetXY(120, 85);
        $pdf->MultiCell(50,5, "Jl. Mohammad Toha No. 367B",0,'L');
        $pdf->SetXY(120, 90);
        $pdf->MultiCell(50,5, "021-xxxxxxx",0,'L');

        $pdf->SetFillColor(210,221,242);
        $pdf->SetFont('Arial','B',8);
        $pdf->SetDrawColor(51, 125, 178);

        $pdf->SetXY(23, 105);
        $pdf->Cell(50,5,'SHIPPING METHOD',1,1,'C', true);

        $pdf->SetXY(73, 105);
        $pdf->Cell(88,5,'SHIPPING TERMS',1,1,'C', true);

        $pdf->SetXY(160, 105);
        $pdf->Cell(30,5,'DELIVERY DATE',1,1,'C', true);

        $pdf->SetFillColor(255,255,255);
        $pdf->SetFont('Arial','',8);
        $pdf->SetDrawColor(51, 125, 178);

        $pdf->SetXY(23, 110);
        $pdf->Cell(50,5,'',1,1,'C', true);

        $pdf->SetXY(73, 110);
        $pdf->Cell(88,5,'',1,1,'C', true);

        $pdf->SetXY(160, 110);
        $pdf->Cell(30,5,'',1,1,'C', true);

        $pdf->SetFillColor(210,221,242);
        $pdf->SetFont('Arial','B',8);
        $pdf->SetDrawColor(51, 125, 178);

        $pdf->SetXY(23, 120);
        $pdf->Cell(20,5,'QTY',1,1,'C', true);

        $pdf->SetXY(43, 120);
        $pdf->Cell(30,5,'ITEM #',1,1,'C', true);

        $pdf->SetXY(73, 120);
        $pdf->Cell(50,5,'DESCRIPTION',1,1,'C', true);

        $pdf->SetXY(123, 120);
        $pdf->Cell(37,5,'UNIT PRICE',1,1,'C', true);

        $pdf->SetXY(160, 120);
        $pdf->Cell(30,5,'LINE TOTAL',1,1,'C', true);

        $pdf->SetFillColor(255,255,255);
        $pdf->SetFont('Arial','',8);
        $pdf->SetDrawColor(51, 125, 178);

        $sl2 = "
            po_beli_detail.*,
            produk.id AS produkid,
            produk.nama_produk,
            produk.deskripsi
        ";
        $this->db->select($sl2);
        $this->db->from("po_beli_detail");
        $this->db->join("produk", "produk.id = po_beli_detail.iditem");
        $this->db->where("no_po", $no);
        $i = $this->db->get()->result();

        $line = 125;
        $subtotal = 0;
        foreach ($i as $vi) {
            $pdf->SetFillColor(255,255,255);        
            $pdf->SetXY(23, $line);
            $pdf->Cell(20,5, number_format($vi->qty,0,',','.'),1,1,'C', true);

            $pdf->SetXY(43, $line);
            $pdf->MultiCell(30,5, $vi->nama_produk,1,'C', true);

            $pdf->SetXY(73, $line);
            $pdf->MultiCell(50,5, $vi->deskripsi,1,'L', true);

            $pdf->SetXY(123, $line);
            $pdf->Cell(37,5, number_format($vi->harga,0,',','.'),1,1,'R', true);

            $pdf->SetFillColor(210,221,242);
            $pdf->SetXY(160, $line);
            $pdf->Cell(30,5, number_format( ($vi->qty*$vi->harga) ,0,',','.'),1,1,'R', true);

            $line = $line +5;

            $subtotal = $subtotal + ($vi->qty*$vi->harga);
        }

        $tax = $subtotal * 10/100;

        $pdf->SetFont('Arial','',9);
        $pdf->SetDrawColor(51, 125, 178);
        $pdf->SetFillColor(255,255,255);        
        $pdf->SetXY(23, $line);
        $pdf->Cell(100,52, '',1,1,'C', true);

        $pdf->SetXY(24, $line+1);
        $pdf->Cell(50,5, 'NOTE :',0,0,'L', true);

        $pdf->SetXY(24, $line+6);
        $pdf->Cell(50,5, '1. Please send two copies of your invoice.',0,0,'L', true);

        $pdf->SetXY(24, $line+11);
        $pdf->MultiCell(90,5, '2. Enter this order in accordance with the prices, terms, delivery method, and specifications listed above.',0,'L', true);

        $pdf->SetXY(24, $line+16);
        $pdf->MultiCell(90,5, '3. Please notify us immediately if you are unable to.',0,'L', true);

        $pdf->SetFont('Arial','B',8);
        $pdf->SetXY(124, $line+1);
        $pdf->Cell(35,5, 'SUBTOTAL',0,1,'R', true);

        $pdf->SetXY(124, $line+6);
        $pdf->Cell(35,5, 'TAX',0,1,'R', true);

        $pdf->SetXY(124, $line+11);
        $pdf->Cell(35,5, 'TOTAL',0,1,'R', true);

        $pdf->SetFillColor(210,221,242);
        $pdf->SetXY(160, $line);
        $pdf->Cell(30,5, number_format($subtotal,0,',','.'),1,1,'R', true);

        $pdf->SetFillColor(255,255,255);
        $pdf->SetXY(160, $line+5);
        $pdf->Cell(30,5, number_format($tax,0,',','.'),1,1,'R', true);

        $pdf->SetFillColor(210,221,242);
        $pdf->SetXY(160, $line+10);
        $pdf->Cell(30,5, number_format($subtotal+$tax,0,',','.'),1,1,'R', true);

        $pdf->SetFillColor(255,255,255);
        $pdf->SetXY(123, $line+20);
        $pdf->Cell(67,7, "",1,1,'R', true);

        $pdf->SetXY(124, $line+21);
        $pdf->Cell(30,5, "Authorized By : ",0,1,'L', true);

        $pdf->SetXY(160, $line+21);
        $pdf->Cell(28,5, "Prepare By : ",0,1,'L', true);

        $pdf->SetXY(123, $line+27);
        $pdf->Cell(35,25, "",1,1,'L', true);

        $pdf->SetXY(155, $line+27);
        $pdf->Cell(35,25, "",1,1,'L', true);

        $pdf->SetXY(124, $line+45);
        $pdf->Cell(10,5, "Firman N",0,1,'L', true);

        $pdf->SetXY(156, $line+45);
        $pdf->Cell(10,5, $h['nama'],0,1,'L', true);

        $pdf->Output();
    }


    function detail(){
        $id = $_POST["id"];


        $sl = "
            po_beli_detail.*,
            produk.id AS titid,
            produk.nama_produk,
            produk.idsatuan,
            satuan.id AS satid,
            satuan.nama_satuan
        ";
        $this->db->select($sl);
        $this->db->from("po_beli_detail");
        $this->db->join("produk", "produk.id = po_beli_detail.iditem");
        $this->db->join("satuan", "satuan.id = produk.idsatuan");
        $this->db->where("po_beli_detail.no_po", $id);
        $d = $this->db->get()->result();

        $json = "[";
        $no = 0;
        $subtotal = 0;
        $ppn = 0;
        foreach ($d as $v) {
            
            if ($no > 0) {
                $json.=", ";
            }

            $total = ($v->harga * $v->qty) - (($v->harga * $v->qty) * $v->disc/100) ;

            $subtotal = $subtotal+$total;
            $ppn = $ppn + ($total*10/100);

            $dt = array(
                    "id"        => $v->id,
                    "nama"      => $v->nama_produk,
                    "qty"       => number_format($v->qty, 0, ",", "."),
                    "harga"     => number_format($v->harga, 0, ",", "."),
                    "disc"      => $v->disc."%",
                    "total"     => number_format($total, 0, ",", "."),
                    "subtotal"  => number_format($subtotal, 0, ",", "."),
                    "ppn"       => number_format($ppn, 0, ",", "."),
                    "gtotal"    => number_format($ppn+$subtotal, 0, ",", ".")
                );

            $json.=json_encode($dt);
            $no++;

        }
        $json.="]";

        echo $json;
    }

    public function data(){
            error_reporting(0);

            //filter
            $src_po         = $_POST["src_po"];
            $src_from       = $_POST["src_from"];
            $src_to         = $_POST["src_to"];
            $src_supplier   = $_POST["src_supplier"];
            $src_user       = $_POST["src_user"];
            $src_status     = $_POST["src_status"];

            $list = $this->md->get_datatables($src_po, $src_from, $src_to, $src_supplier, $src_user, $src_status);
            $data = array();
            $no = $_POST['start'];
            $gtotal = 0;
            foreach ($list as $v) {

                $sl = "
                    po_beli_detail.id,
                    po_beli_detail.no_po,
                    po_beli_detail.harga,
                    po_beli_detail.qty,
                    po_beli_detail.disc,
                    SUM( ((po_beli_detail.harga+po_beli_detail.tax) * po_beli_detail.qty) - (((po_beli_detail.harga+po_beli_detail.tax) * po_beli_detail.qty) * po_beli_detail.disc/100) ) AS total
                ";
                $this->db->select($sl);
                $this->db->from('po_beli_detail');
                $this->db->where("po_beli_detail.no_po", $v->no_po);
                //$this->db->where("penjualan_detail.retur", "N");
                $total = $this->db->get()->row_array();

                $gtotal = $gtotal + $total["total"];

                $no++;
                $row = array();
                $row[] = "<center>".$no."</center>";
                $row[] = $v->no_po;
                $row[] = date("d/m/Y H:i:s", strtotime($v->created_on));
                $row[] = $v->nama_supplier;
                $row[] = "<p style='text-align:right'>".number_format($total['total'], 0, ",", ".")."</p>";
                $row[] = $v->nama;
                //$row[] = $v->status;
     
                //add html for action//width:auto;min-width:2px;margin-left: -125px;margin-bottom: -70px;
                
                $row[] = "
                            <center>
                            <li class='btn-group dropdown act' >
                                <button id='act' class='btn blue dropdown-toggle drop' type='button' data-toggle='dropdown' aria-haspopup='true' aria-expanded='true' style='padding:5px 10px;'>
                                   <i class='fa fa-bars'></i> 
                                </button>
                                <ul class='dropdown-menu' id='dropdown-menu".$no."'  role='menu' style='width:auto;min-width:2px'>
                                    <li>
                                        <a href='javascript:;' onclick='detail(\"".$v->no_po."\")' data-toggle='modal' data-target='#md-det'>
                                            <i class='fa fa-clipboard fa-lg'></i> Detail
                                        </a>
                                    </li>
                                    <li>
                                        <a href='".base_url()."po_beli/print_po/".$v->no_po."' target='_blank'>
                                            <i class='fa fa-print fa-lg'></i> Print
                                        </a>
                                    </li>
                                </ul>
                            </li>
                            </center>
                        ";
                /*
                $row[] = "
                    <div class='btn-toolbar'>
                        <div class='btn-group btn-group-md'>
                            
                                <button type='button' class='btn yellow-gold' onclick='edit(".$v->id.")' data-toggle='modal' data-target='#md-edit'>
                                    <i class='fa fa-pencil fa-lg'></i>
                                </button>
                                <button type='button' class='btn red-thunderbird' onclick='getId(".$v->id.")' data-toggle='modal' data-target='#md-delete'>
                                    <i class='fa fa-trash fa-lg'></i>
                                </button>
                            
                        </div>
                    </div>
                ";*/
                $row[] = $gtotal;
     
                $data[] = $row;
            }
     
            $output = array(
                            "draw"              => $_POST['draw'],
                            "recordsTotal"      => $this->md->count_all(),
                            "recordsFiltered"   => $this->md->count_filtered($src_po, $src_from, $src_to, $src_supplier, $src_user, $src_status),
                            "data"              => $data,
                    );
            //output to json format
            echo json_encode($output);
    } 

	
}
