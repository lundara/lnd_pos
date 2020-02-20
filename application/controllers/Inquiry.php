<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class inquiry extends CI_Controller {

    function __construct(){
        parent::__construct();
        date_default_timezone_set("Asia/Jakarta");
        $this->load->model('Inquiry_model','md');
        $this->load->model("Lnd_model", "lnd");


       if(!$this->session->userdata('lnd_id'))
       {
        	redirect('login');
       }
    }

	public function index(){        

        $this->lnd->akses("inquiry", "submenu");

		$data["page"]	  = "inquiry";
        $data["menu"]     = "transaksi";
        $data["submenu"]  = "inquiry";
		$this->load->view('main', $data);
		
	}

    function edit(){
        $id = $_POST["id"];


        $this->db->where("id", $id);
        $d = $this->db->get("inquiry_detail")->result();

        echo json_encode($d);

    }

    function update(){

        $id     = $_POST["id"];
        $hjual  = $_POST["hjual"];
        $hbeli  = $_POST["hbeli"];

        /*
        $dt = array(
                ""
        );*/    

    }

    function excel(){
        //$ambildata = $this->mread->export_kontak();
            $this->load->library(array('PHPExcel','PHPExcel/IOFactory'));
            $objPHPExcel = new PHPExcel();
            // Set properties
            $objPHPExcel->getProperties()
                  ->setCreator("SYS CBTEKNO") //creator
                    ->setTitle("System PT. Chakra Bhaskara Tekno");  //file title
 
            $objset = $objPHPExcel->setActiveSheetIndex(0); //inisiasi set object
            $objget = $objPHPExcel->getActiveSheet();  //inisiasi get object
 
            $objget->setTitle('Laporan Quotation'); //sheet title
            //Warna header tabel
            /*
            $objget->getStyle("A1:C1")->applyFromArray(
                array(
                    'fill' => array(
                        'type' => PHPExcel_Style_Fill::FILL_SOLID,
                        'color' => array('rgb' => '92d050')
                    ),
                    'font' => array(
                        'color' => array('rgb' => '000000')
                    )
                )
            );
 
            //table header
            $cols = array("A","B","C");
             
            $val = array("Nama ","Alamat","Kontak");
             
            for ($a=0;$a<3; $a++) 
            {
                $objset->setCellValue($cols[$a].'1', $val[$a]);
                 
                //Setting lebar cell
                $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(25); // NAMA
                $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(25); // ALAMAT
                $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(25); // Kontak
             
                $style = array(
                    'alignment' => array(
                        'horizontal' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
                    )
                );
                $objPHPExcel->getActiveSheet()->getStyle($cols[$a].'1')->applyFromArray($style);
            }
             
            $baris  = 2;
            /*
            foreach ($ambildata as $frow){
                 
               //pemanggilan sesuaikan dengan nama kolom tabel
                $objset->setCellValue("A".$baris, $frow->nama); //membaca data nama
                $objset->setCellValue("B".$baris, $frow->alamat); //membaca data alamat
                $objset->setCellValue("C".$baris, $frow->kontak); //membaca data alamat
                 
                //Set number value
                $objPHPExcel->getActiveSheet()->getStyle('C1:C'.$baris)->getNumberFormat()->setFormatCode('0');
                 
                $baris++;
            }
            $objset->setCellValue("A2", "Isi Nama"); //membaca data nama
            $objset->setCellValue("B2", "Isi Alamat"); //membaca data alamat
            $objset->setCellValue("C2", "Isi Kontak"); //membaca data alamat
             
            //Set number value
            $objPHPExcel->getActiveSheet()->getStyle('C1:C3')->getNumberFormat()->setFormatCode('0');
             
            $objPHPExcel->getActiveSheet()->setTitle('Data Export');
            */
            $objget->setCellValueByColumnAndRow(0, 1, "LAPORAN QUOTATION");            
            $objget->mergeCells('A1:I1');
            //$objPHPExcel->getActiveSheet()->getStyle('A1:I1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            $style_title = array(
                'alignment' => array(
                    'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                ),
                'font' => array(
                    'color' => array('rgb' => '000000'),
                    'bold'  => true,
                    'size'  => 12
                )
            );
            $objPHPExcel->getActiveSheet()->getStyle('A1:I1')->applyFromArray($style_title);

            $objget->setCellValue("B2", "01 Agustus 2018 - 31 Agustus 2018");            
            $objget->mergeCells('B2:C2');
            //$objPHPExcel->getActiveSheet()->getStyle('A1:I1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            $style_date = array(
                'alignment' => array(
                    //'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                ),
                'font' => array(
                    'color' => array('rgb' => '000000'),
                    'bold'  => true,
                    'size'  => 11
                )
            );
            $objPHPExcel->getActiveSheet()->getStyle('B2:C2')->applyFromArray($style_date);


            $objget->getStyle("A4:I4")->applyFromArray(
                array(
                    'fill' => array(
                        'type' => PHPExcel_Style_Fill::FILL_SOLID,
                        'color' => array('rgb' => 'c5d9f1')
                    ),
                    'font' => array(
                        'color' => array('rgb' => '000000'),
                        'bold'  => true,
                        'size'  => 10
                    ),
                    'borders' => array(
                        'allborders' => array(
                            'style' => PHPExcel_Style_Border::BORDER_THIN,
                            'color' => array('rgb' => '000000')
                        )
                    )
                )
            );
            $cols    = array("A","B","C","D","E","F","G","H","I");
            $val   = array("NO ","TGL","INQUIRY", "DESCRIPTION", "QTY", "L TIME", "HARGA BELI", "HARGA JUAL", "NO QUOT");

            for ($a=0;$a<9; $a++) 
            {
                $objset->setCellValue($cols[$a].'4', $val[$a]);
                 
                //Setting lebar cell
                $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(5); 
                $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(10); 
                $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(30);
                $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(40);
                $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(7); 
                $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(10);
                $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(15);
                $objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(15);
                $objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(10);


                //$objPHPExcel->getActiveSheet()->getRowDimension('2')->setHeight(10); 
             
                $style = array(
                    'alignment' => array(
                        'horizontal' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
                        'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER
                    ),
                    'font' => array(
                        'size'  => 9
                    ),
                );
                $objPHPExcel->getActiveSheet()->getStyle($cols[$a].'4')->applyFromArray($style);
            }
            $objPHPExcel->getActiveSheet()->getRowDimension(4)->setRowHeight(40);

            //data
            $baris  = 5;
            $list = $this->md->get_datatables("", "--", "--", "", "", "", "");
            $no = 1;
            foreach ($list as $v){
                 
               //pemanggilan sesuaikan dengan nama kolom tabel
                $objset->setCellValue("A".$baris, $no); 
                $objset->setCellValue("B".$baris, date("d/m/Y", strtotime($v->created_on)) );
                $objset->setCellValue("C".$baris, $v->nama_pelanggan );

                $sl = "
                    quotation_detail.*,
                    produk.id AS produkid,
                    produk.nama_produk,
                    produk.deskripsi
                ";

                $this->db->select($sl);
                $this->db->from('quotation_detail');
                $this->db->join("produk", "produk.id = quotation_detail.iditem");
                $this->db->where("quotation_detail.no_trans", $v->no_trans);
                $det = $this->db->get()->result();

                $baris2 = $baris;
                $nod = 0;
                                    $nod2 = 0;

                foreach ($det as $vdet) {

                    $dlen = strlen($vdet->deskripsi);
                    $bts = 46;
                    $cl = ceil($dlen / $bts);


                    $baris3 = $baris2;
                    $ex = 0;
                    for($d = 1;$d<=$cl;$d++){
                        $objset->setCellValue("D".$baris3, substr($vdet->deskripsi, $ex,45) );

                        $baris3++;
                        $nod2++;
                        $ex = $ex+45;
                    }

                    
                    /*
                    $objset->setCellValue("E".$baris2, $vdet->qty );
                    $objset->setCellValue("F".$baris2, $vdet->lead_time );
                    $objset->setCellValue("G".$baris2, "0" );
                    $objset->setCellValue("H".$baris2, $vdet->harga );*/

                    $baris2 = $baris2 + $nod2;
                    $nod++;

                }



                $objset->setCellValue("I".$baris, $v->no_trans );
                 
                //Set number value
                //$objPHPExcel->getActiveSheet()->getStyle('C1:C'.$baris)->getNumberFormat()->setFormatCode('0');
                $style_no = array(
                    'alignment' => array(
                        'horizontal' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
                        'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER
                    ),
                    'font' => array(
                        'size'  => 9
                    )

                );
                $style_row = array(
                    'font' => array(
                        'size'  => 9
                    )
                );
                $objPHPExcel->getActiveSheet()->getStyle("A5:A".$baris)->applyFromArray($style_no);
                $objPHPExcel->getActiveSheet()->getStyle("B5:B".$baris)->applyFromArray($style_no);
                $objPHPExcel->getActiveSheet()->getStyle("C5:C".$baris)->applyFromArray($style_row);
                $objPHPExcel->getActiveSheet()->getStyle("D5:D".$baris)->applyFromArray($style_row);
                $objPHPExcel->getActiveSheet()->getStyle("E5:E".$baris)->applyFromArray($style_row);
                $objPHPExcel->getActiveSheet()->getStyle("F5:F".$baris)->applyFromArray($style_no);
                $objPHPExcel->getActiveSheet()->getStyle("G5:G".$baris)->applyFromArray($style_row);
                $objPHPExcel->getActiveSheet()->getStyle('G5:G'.$baris)->getNumberFormat()->setFormatCode("#,##0");
                $objPHPExcel->getActiveSheet()->getStyle("H5:H".$baris)->applyFromArray($style_row);
                $objPHPExcel->getActiveSheet()->getStyle('H5:H'.$baris)->getNumberFormat()->setFormatCode("#,##0");
                $objPHPExcel->getActiveSheet()->getStyle("I5:I".$baris)->applyFromArray($style_no);

                 
                $baris = $baris + $nod2;
                $no++;
            }



            $objPHPExcel->setActiveSheetIndex(0);  
            $filename = urlencode("Data".date("Y-m-d H:i:s").".xlsx");
               
              header('Content-Type: application/vnd.ms-excel'); //mime type
              header('Content-Disposition: attachment;filename="'.$filename.'"'); //tell browser what's the file name
              header('Cache-Control: max-age=0'); //no cache
 
            $objWriter = IOFactory::createWriter($objPHPExcel, 'Excel2007');
            ob_end_clean();              
            $objWriter->save('php://output');
            exit;

    }

    public function select2(){
        $sl = "
            inquiry.*
        ";
        $this->db->select($sl);
        $this->db->from("inquiry");
        $this->db->where("no_trans", $_POST["term"]);
        $d = $this->db->get()->result();

        $sl2 = "
            inquiry_detail.*,
            produk.id AS produkid,
            produk.nama_produk,
            produk.deskripsi,
            produk.harga,
            produk.modal
        ";

        $this->db->select($sl2);
        $this->db->from("inquiry_detail");
        $this->db->join("produk", "produk.id = inquiry_detail.iditem");
        $this->db->where("no_trans", $_POST["term"]);
        $d2 = $this->db->get()->result();

        $op = "<option value=''>- Pilih -</option>";
        foreach ($d2 as $vd) {
            $op.="<option value='".$vd->produkid."' dt='".$vd->id."' qty='".$vd->qty."' hrg='".$vd->harga."' mdl='".$vd->modal."'>".$vd->deskripsi."</option>";
        }


        $no = 0;
        $data = "[";
        foreach ($d as $v) {
            
            if ($no > 0) {
                $data.=", ";
            }

            $dt = array(
                    "id"            => $v->no_trans,
                    "op"            => $op
                );

            $data .= json_encode($dt);
            $no++;
        }

        $data.="]";

        echo $data;
    }

    public function add(){
        error_reporting(0);

        $session_no = count($_SESSION['inq']);
        $no_item    = $session_no+1;

        $id     = $_POST["id"];
        //$harga  = str_replace(".","",$_POST["harga"]);
        $qty    = str_replace(".","",$_POST["qty"]);
        $satuan = $_POST["satuan"];
        //$lead_time = $_POST["lead_time"];

        if ($session_no!=0) {
            for($i=1;$i<=$session_no;$i++){

                if ($_SESSION['inq'][$i][0] == $id) {
                    $mqty       = $qty + $_SESSION['inq'][$i][1];
                    $sess_id    = $_SESSION['inq'][$i][2];
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


        $_SESSION['inq'][$sess_id][0]=$id; // idproduk
        $_SESSION['inq'][$sess_id][1]=$mqty; //qty
        $_SESSION['inq'][$sess_id][2]=$sess_id; //session id
        //$_SESSION['inq'][$sess_id][3]=$harga; //harga
        $_SESSION['inq'][$sess_id][4]=$satuan; //satuan
        //$_SESSION['inq'][$sess_id][5]=$lead_time;

        echo "1";

    }

    public function del(){

        $id = $_POST["id"];

        unset($_SESSION['inq'][$id][0]);
        unset($_SESSION['inq'][$id][1]);
        unset($_SESSION['inq'][$id][2]);
        //unset($_SESSION['inq'][$id][3]);
        unset($_SESSION['inq'][$id][4]);
        unset($_SESSION['inq'][$id][5]);

    }
    function save(){
        error_reporting(0);

        $no_trans   = $_POST["no_trans"];
        $user       = $this->lnd->me();
        $pelanggan   = $_POST["supplier"];
        $untuk      = $_POST["untuk"];

        $this->db->where("no_trans", $no_trans);
        $c = $this->db->get("inquiry")->num_rows();

        if ($c==0) {
            $no_po = $no_trans;
        }
        else{
            $no_po = $no_trans.rand(0,999);
        }


        $dt = array(
                "no_trans"          => $no_po,
                "created_by"        => $user["username"],
                "idpelanggan"       => $pelanggan,
                //"idpembayaran"      => $metode,
                //"idbank"            => $bank,
                "untuk"             => $untuk,
                "created_on"        => date("Y-m-d H:i:s")
            );
        $dt_act = array(
            "deskripsi"         => $user["nama"]." telah menambah data Inquiry ".$no_po.".",
            "jenis_aktivitas"   => "TAMBAH",
            "iduser"            => $user['username'],
            "tgl"               => date("Y-m-d H:i:s")
        );


        $this->db->trans_start();

            $this->db->insert("inquiry", $dt);


            $session_no = count($_SESSION['inq']);
            for($i=1;$i<=$session_no;$i++){
                if ($_SESSION['inq'][$i][2]!="") {

                    //$ppn = ($_SESSION['inq'][$i][3]) - (($_SESSION['inq'][$i][3]) * 10 / 100);
                    //$tax = ($_SESSION['inq'][$i][3]) - $ppn;

                    $dt2 = array(
                            "iditem"        => $_SESSION['inq'][$i][0],
                            "no_trans"         => $no_po,
                            "qty"           => $_SESSION['inq'][$i][1],
                        );

                    $this->db->insert("inquiry_detail", $dt2);

                   
                        
                }
                
            }

            $this->db->insert("aktivitas", $dt_act);
            

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
        $this->session->unset_userdata('inq');
    }
    public function data_item(){
        error_reporting(0);

        $session_no = count($_SESSION['inq']);
        $json = "[";
        $no = 1;
        $vpot = 0;
        for($i=1;$i<=$session_no;$i++){



            if ($_SESSION['inq'][$i][2]!="") {
                if ($no>1) {
                    $json.=",";
                }
                $this->db->where("produk.id", $_SESSION['inq'][$i][0]);
                $produk = $this->db->get("produk")->row_array();

                if ($produk["deskripsi"]==null) {
                    $desc = "";
                }
                else{
                    $desc = $produk["deskripsi"];
                }

                $dt = array(
                        "id_produk"     => $_SESSION['inq'][$i][0],
                        "nama_item"     => $produk["nama_produk"],
                        "qty"           => $_SESSION['inq'][$i][1],
                        //"harga"         => $_SESSION['inq'][$i][3],
                        //"netto"         => ($_SESSION['inq'][$i][3] * $_SESSION['inq'][$i][1]),
                        //"brutto"        => ($_SESSION['inq'][$i][3] * $_SESSION['inq'][$i][1]),
                        "id"            => $_SESSION['inq'][$i][2],
                        "pot"           => "0",
                        "total_item"    => $no,
                        "satuan"        => $_SESSION['inq'][$i][4],
                        "desc"          => $desc,
                        //"lead_time"     => strtoupper($_SESSION['inq'][$i][5])

                    );

                $json.=json_encode($dt);
                $no++;
            }
            
        }

        $json.="]";
        
        echo $json;


    }

    function get_trans(){

        $this->db->where("YEAR(created_on)", date("Y"));
        $this->db->order_by("created_on", "desc");
        $q = $this->db->get("inquiry");
        $c = $q->num_rows();
        $v = $q->row_array();

        if ($c!=0) {
            $digit = substr($v["no_trans"], 8,4);
        }
        else{
            $digit = 0;
        }
        $d = json_encode(array(
                "no_trans"  =>"INQ.".date("y").date("m").sprintf("%04d", $digit+1)
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
            quotation.*,
            pelanggan.id AS pelid,
            pelanggan.nama_pelanggan,
            pelanggan.alamat,
            pelanggan.no_hp,
            user.username,
            user.nama,
            user.no_hp,
            bank.id AS bankid,
            bank.nama_bank,
            bank.atas_nama,
            bank.no_rek,
            bank.cabang,
            pembayaran.id AS pembid,
            pembayaran.nama_pembayaran
        ";
        $this->db->select($sl1);
        $this->db->from("quotation");
        $this->db->join("pelanggan", "pelanggan.id = quotation.idpelanggan");
        $this->db->join("user", "user.username = quotation.created_by");
        $this->db->join("bank", "bank.id = quotation.idbank");
        $this->db->join("pembayaran", "pembayaran.id = quotation.idpembayaran");
        $this->db->where("quotation.no_trans", $no);
        $h = $this->db->get()->row_array();


        $this->load->library('pdf');
        //$this->load->library('pdf_gradient');

        $pdf = new FPDF('p','mm', "A4");
        // membuat halaman baru
        $pdf->AddPage();
        // setting jenis font yang akan digunakan

        //logo
        $pdf->Image(base_url()."assets/img/logo_shin.png", 100, 15, 20,20);

        $pdf->SetFont('Arial','B',16);
        $pdf->SetTextColor(74,135,175);
        $pdf->SetXY(23, 15);
        $pdf->Cell(168,10,'',0,1,'R');

        $pdf->SetTextColor(0,0,0);
        $pdf->SetFont('Arial','B',12);
        $pdf->SetXY(23, 20);
        $pdf->Cell(168,5,'PT. CHAKRA BHASKARA TEKNO',0,1,'L');

        $pdf->SetFont('Arial','B',9);
        $pdf->SetTextColor("150", "150", "150");
        $pdf->SetXY(23, 25);
        $pdf->Cell(168,5,'THE TRULLY YOUR BUSINESS PARTNER',0,1,'L');

        $pdf->SetTextColor("0", "0", "0");
        $pdf->SetFont('Arial','B',10);
        $pdf->SetXY(23, 40);
        $pdf->Cell(168,5,'Precision Tools & Automation',0,1,'C');

        $pdf->SetFont('Arial','',9);
        $pdf->SetXY(23, 55);
        $pdf->Cell(168,5,'Jl. Tirtasari Selatan No.10',0,1,'L');

        $pdf->SetXY(23, 60);
        $pdf->Cell(168,5,'Bandung 40151',0,1,'L');

        $pdf->SetXY(23, 65);
        $pdf->Cell(168,5,'Telphone : 022 20271122',0,1,'L');

        $pdf->SetXY(23, 70);
        $pdf->Cell(168,5,'',0,1,'L');

        $pdf->SetFont('Arial','B',9);
        $pdf->SetXY(100, 55);
        $pdf->Cell(168,5,'DATE',0,1,'L');

        $pdf->SetXY(100, 60);
        $pdf->Cell(168,5,'QUOTATION',0,1,'L');

        $pdf->SetXY(100, 65);
        $pdf->Cell(168,5,'CUSTOMER',0,1,'L');

        $pdf->SetFont('Arial','',9);
        $pdf->SetXY(120, 55);
        $pdf->Cell(168,5,': '.date('F d, Y'),0,1,'L');

        $pdf->SetXY(120, 60);
        $pdf->Cell(168,5,': '.$no,0,1,'L');

        $pdf->SetXY(120, 65);
        $pdf->Cell(168,5,': '.$h['nama_pelanggan'],0,1,'L');

        $exp = $this->lnd->tambah_tgl($h['created_on']);

        $pdf->SetFont('Arial','B',9);
        $pdf->SetXY(23, 75);
        $pdf->Cell(168,5,'Quotation for : ',0,1,'L');
        $pdf->SetXY(100, 75);
        $pdf->Cell(168,5,'Quotation valid until',0,1,'L');


        $pdf->SetFont('Arial','',9);
        $pdf->SetXY(23, 80);
        $pdf->MultiCell(168,5, ucwords($h['untuk']),0,'L');
        $pdf->SetXY(23, 85);
        $pdf->MultiCell(168,5, $h['nama_pelanggan'],0,'L');
        $pdf->SetXY(45, 85);
        //$pdf->MultiCell(50,5, $h['alamat'],0,'L');

        $pdf->SetXY(135, 75);
        $pdf->MultiCell(168,5, ": ".date("d/m/Y", strtotime($exp)),0,'L');

        $pdf->SetFont('Arial','B',12);
        $pdf->SetXY(23, 90);
        $pdf->Cell(168,5, "Quotation",0,0,'C');

        $pdf->SetFont('Arial','I',9);
        $pdf->SetXY(23, 95);
        $pdf->Cell(168,5, "ASSY PER ORDER SEE DETAIL BELOW ",0,0,'C');

        $pdf->SetFillColor(210,221,242);
        $pdf->SetFont('Arial','B',8);
        $pdf->SetDrawColor(51, 125, 178);

        $pdf->SetXY(23, 105);
        $pdf->Cell(35,5,'SALES PERSON',1,1,'C', true);

        $pdf->SetXY(58, 105);
        $pdf->Cell(35,5,'PO NUMBER',1,1,'C', true);

        $pdf->SetXY(93, 105);
        $pdf->Cell(40,5,'SHIP DATE',1,1,'C', true);

        $pdf->SetXY(133, 105);
        $pdf->Cell(20,5,'F.O.B POINT',1,1,'C', true);

        $pdf->SetXY(153, 105);
        $pdf->Cell(15,5,'FR POINT',1,1,'C', true);

        $pdf->SetXY(168, 105);
        $pdf->Cell(22,5,'TERMS',1,1,'C', true);

        $pdf->SetFillColor(255,255,255);
        $pdf->SetFont('Arial','',8);
        $pdf->SetDrawColor(51, 125, 178);

        $pdf->SetXY(23, 110);
        $pdf->Cell(35,5, $h['nama'],1,1,'C', true);

        $pdf->SetXY(58, 110);
        $pdf->Cell(35,5,'',1,1,'C', true);

        $pdf->SetXY(93, 110);
        $pdf->Cell(40,5,'',1,1,'C', true);

        $pdf->SetXY(133, 110);
        $pdf->Cell(20,5,'',1,1,'C', true);

        $pdf->SetXY(153, 110);
        $pdf->Cell(15,5,'',1,1,'C', true);

        if (substr($h["nama_pembayaran"], 0,2) == "DP") {
            $term = "DP";
        }
        else{
            $term = $h["nama_pembayaran"];
        }

        $pdf->SetXY(168, 110);
        $pdf->Cell(22,5, $term,1,1,'C', true);

        $pdf->SetFillColor(210,221,242);
        $pdf->SetFont('Arial','B',8);
        $pdf->SetDrawColor(51, 125, 178);

        $pdf->SetXY(23, 120);
        $pdf->Cell(20,5,'QTY',1,1,'C', true);

        $pdf->SetXY(43, 120);
        $pdf->Cell(80,5,'DESCRIPTION #',1,1,'C', true);

        $pdf->SetXY(123, 120);
        $pdf->Cell(22,5,'UNIT PRICE',1,1,'C', true);

        $pdf->SetXY(145, 120);
        $pdf->Cell(25,5,'LEAD TIME',1,1,'C', true);

        $pdf->SetXY(168, 120);
        $pdf->Cell(22,5,'LINE TOTAL',1,1,'C', true);

        $pdf->SetFillColor(255,255,255);
        $pdf->SetFont('Arial','',8);
        $pdf->SetDrawColor(51, 125, 178);

        $sl2 = "
            quotation_detail.*,
            produk.id AS produkid,
            produk.nama_produk,
            produk.deskripsi
        ";
        $this->db->select($sl2);
        $this->db->from("quotation_detail");
        $this->db->join("produk", "produk.id = quotation_detail.iditem");
        $this->db->where("no_trans", $no);
        $i = $this->db->get()->result();

        $line = 125;
        $subtotal = 0;
        $rs = 0;
        foreach ($i as $vi) {
            $bts = 46;
            $char = strlen($vi->deskripsi);
            $bg = ceil($char / $bts);
            if ($bg==1) {
                $hd =5;
            }
            else{
                $hd = $bg * 5;
            }
            $rs = $rs + $bg;
            $pdf->SetFillColor(255,255,255);        
            $pdf->SetXY(23, $line);
            $pdf->Cell(20,$hd, number_format($vi->qty,0,',','.'),1,1,'C', true);

            $pdf->SetXY(43, $line);
            $pdf->MultiCell(80,5, $vi->deskripsi,1,'L', true);

            $pdf->SetXY(145, $line);
            $pdf->Cell(25,$hd, $vi->lead_time,1,1,'C', true);


            $pdf->SetXY(123, $line);
            $pdf->Cell(22,$hd, number_format($vi->harga,0,',','.'),1,1,'R', true);

            $pdf->SetFillColor(210,221,242);
            $pdf->SetXY(168, $line);
            $pdf->Cell(22,$hd, number_format( ($vi->qty*$vi->harga) ,0,',','.'),1,1,'R', true);

            $line = $line +$hd;


            $subtotal = $subtotal + ($vi->qty*$vi->harga);
        }

        for($s = 1; $s <= (12-$rs);$s++){

            $pdf->SetFillColor(255,255,255);        
            $pdf->SetXY(23, $line);
            $pdf->Cell(20,5, "",1,1,'C', true);

            $pdf->SetXY(43, $line);
            $pdf->MultiCell(80,5, "",1,'L', true);

            $pdf->SetXY(145, $line);
            $pdf->Cell(25,5, "",1,1,'C', true);


            $pdf->SetXY(123, $line);
            $pdf->Cell(22,5, "",1,1,'R', true);

            $pdf->SetFillColor(210,221,242);
            $pdf->SetXY(168, $line);
            $pdf->Cell(22,5, "",1,1,'R', true);

            $line = $line + 5;
        }

        $tax = $subtotal * 10/100;
        
        $pdf->SetFont('Arial','',9);
        $pdf->SetDrawColor(51, 125, 178);
        $pdf->SetFillColor(255,255,255);        
        $pdf->SetXY(23, $line);
        $pdf->Cell(100,40, '',1,1,'C', true);

        $pdf->SetXY(24, $line+1);
        $pdf->MultiCell(95,5, "If you have any questions concerning this quotation, please don't hesitated to contact us. ",0,'L', true);

        $pdf->SetXY(24, $line+11);
        $pdf->MultiCell(95,5, "Payment Term :",0,'L', true);

        $pdf->SetFont('Arial','B',8);
        $pdf->SetXY(24, $line+16);
        $pdf->MultiCell(95,5,  $h['nama_pembayaran'],0,'L', true);

        $pdf->SetFont('Arial','',8);
        $pdf->SetXY(24, $line+22);
        $pdf->MultiCell(95,5,  "Please Transfer to ",0,'L', true);

        $pdf->SetFont('Arial','',8);
        $pdf->SetXY(24, $line+26);
        $pdf->MultiCell(40,5,  "Account Bank : ",0,'L', true);

        $pdf->SetFont('Arial','B',8);
        $pdf->SetXY(44, $line+26);
        $pdf->MultiCell(40,5, $h['no_rek']." ".$h['nama_bank'],0,'L', true);

        $pdf->SetFont('Arial','B',8);
        $pdf->SetXY(44, $line+30);
        $pdf->MultiCell(60,5, "A/N ".strtoupper($h['atas_nama']),0,'L', true);

        $pdf->SetFont('Arial','B',8);
        $pdf->SetXY(44, $line+34);
        $pdf->MultiCell(60,5, "Unit ".$h['cabang'] ,0,'L', true);

        $pdf->SetFont('Arial','B',8);
        $pdf->SetXY(124, $line+1);
        $pdf->Cell(35,5, 'SUBTOTAL',0,1,'R', true);

        $pdf->SetXY(124, $line+6);
        $pdf->Cell(35,5, 'TAX RATE',0,1,'R', true);

        $pdf->SetXY(124, $line+11);
        $pdf->Cell(35,5, 'SALES TAX',0,1,'R', true);

        $pdf->SetXY(124, $line+16);
        $pdf->Cell(35,5, 'OTHER',0,1,'R', true);

        $pdf->SetXY(124, $line+21);
        $pdf->Cell(35,5, 'TOTAL',0,1,'R', true);

        $pdf->SetFillColor(210,221,242);
        $pdf->SetXY(160, $line);
        $pdf->Cell(30,5, number_format($subtotal,0,',','.'),1,1,'R', true);

        $pdf->SetFillColor(255,255,255);
        $pdf->SetXY(160, $line+5);
        $pdf->Cell(30,5, "",1,1,'R', true);

        $pdf->SetFillColor(255,255,255);
        $pdf->SetXY(160, $line+10);
        $pdf->Cell(30,5, number_format($tax,0,',','.'),1,1,'R', true);

        $pdf->SetFillColor(210,221,242);
        $pdf->SetXY(160, $line+15);
        $pdf->Cell(30,5, "",1,1,'R', true);

        $pdf->SetFillColor(210,221,242);
        $pdf->SetXY(160, $line+20);
        $pdf->Cell(30,5, number_format($subtotal+$tax,0,',','.'),1,1,'R', true);

        $pdf->SetFillColor(255,255,255);
        $pdf->SetXY(160, $line+30);
        $pdf->Cell(30,5, "Prepare By :",0,1,'L', true);

        $pdf->SetXY(160, $line+50);
        $pdf->Cell(30,5, $h['nama'],0,1,'L', true);

        $pdf->SetXY(160, $line+55);
        $pdf->SetDrawColor(0, 0, 0);
        $pdf->Cell(30,0.1, "",1,1,'L', true);

        $pdf->SetXY(160, $line+56);
        $pdf->Cell(30,5, $h['no_hp'],0,1,'L', true);

        $pdf->SetFont('Arial','B',12);
        $pdf->SetFillColor(255,255,255);
        $pdf->SetXY(23, $line+80);
        $pdf->Cell(167,5, "THANK YOU FOR YOUR BUSINESS !",0,1,'C', true);
        
        $pdf->Output();
    }


    function detail(){
        $id = $_POST["id"];


        $sl = "
            inquiry_detail.*,
            produk.id AS titid,
            produk.nama_produk,
            produk.idsatuan,
            produk.deskripsi,
            satuan.id AS satid,
            satuan.nama_satuan,
            inquiry.no_trans,
            inquiry.untuk
        ";
        $this->db->select($sl);
        $this->db->from("inquiry_detail");
        $this->db->join("produk", "produk.id = inquiry_detail.iditem");
        $this->db->join("satuan", "satuan.id = produk.idsatuan");
        $this->db->join("inquiry", "inquiry.no_trans = inquiry_detail.no_trans");
        $this->db->where("inquiry_detail.no_trans", $id);
        $d = $this->db->get()->result();

        $json = "[";
        $no = 0;
        $subtotal = 0;
        $ppn = 0;
        foreach ($d as $v) {
            
            if ($no > 0) {
                $json.=", ";
            }

            $dt = array(
                    "id"        => $v->id,
                    "nama"      => $v->nama_produk,
                    "qty"       => number_format($v->qty, 0, ",", "."),
                    "deskripsi" => $v->deskripsi,
                    "untuk"     => ucwords($v->untuk),
                    "no_quot"   => $v->no_quot
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

            $list = $this->md->get_datatables($src_po, $src_from, $src_to, $src_supplier, $src_user);
            $data = array();
            $no = $_POST['start'];
            $gtotal = 0;
            foreach ($list as $v) {

                
                $sd = "
                    inquiry_detail.*,
                    produk.id AS produkid,
                    produk.nama_produk,
                    produk.deskripsi,
                    produk.harga AS hproduk
                ";
                $this->db->select($sd);
                $this->db->from("inquiry_detail");
                $this->db->join("produk", "produk.id = inquiry_detail.iditem");
                $this->db->where("inquiry_detail.quot", "1");
                $this->db->where("inquiry_detail.no_trans", $v->no_trans);
                $ada = $this->db->get()->num_rows();


                $this->db->select($sd);
                $this->db->from("inquiry_detail");
                $this->db->join("produk", "produk.id = inquiry_detail.iditem");
                $this->db->where("inquiry_detail.no_trans", $v->no_trans);
                $nop = $this->db->get()->num_rows();

                if ($nop>$ada) {
                    $c = "danger";
                }
                else{
                    $c = "success";
                }

                $no++;
                $row = array();
                $row[] = "<center>".$no."</center>";
                $row[] = $v->no_trans;
                $row[] = "<center>".date("d/m/Y H:i:s", strtotime($v->created_on))."</center>";
                $row[] = $v->nama_pelanggan;
                $row[] = $v->nama;
                $row[] = "<center><label class='label label-".$c."'>".$ada."/".$nop."</label></center>";
                //$row[] = "<center><label class='label label-".$c."' style='font-weight:bold'>".$ada."/".$nop."</label></center>";
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
                                            <a href='javascript:;' onclick='detail(\"".$v->no_trans."\")' data-toggle='modal' data-target='#md-det'>
                                                <i class='fa fa-pencil fa-lg'></i> Detail Item
                                            </a>
                                        </li>
                                    </ul>
                                </li>
                            </center>
                        ";
     
                $data[] = $row;
            }
     
            $output = array(
                            "draw"              => $_POST['draw'],
                            "recordsTotal"      => $this->md->count_all(),
                            "recordsFiltered"   => $this->md->count_filtered($src_po, $src_from, $src_to, $src_supplier, $src_user),
                            "data"              => $data,
                    );
            //output to json format
            echo json_encode($output);
    } 

	
}
