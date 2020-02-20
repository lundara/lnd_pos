<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class penjualan extends CI_Controller {

    function __construct(){
        parent::__construct();
        date_default_timezone_set("Asia/Jakarta");
        $this->load->model('pitstop/Penjualan_model','md');
        $this->load->model("Lnd_model", "lnd");


       if(!$this->session->userdata('lnd_id'))
       {
        	redirect('login');
       }
    }

	public function index(){        

        //$this->lnd->akses("pitstop/penjualan", "submenu");

		$data["page"]	  = "pitstop_penjualan";
        $data["menu"]     = "transaksi";
        $data["submenu"]  = "pitstop_penjualan";
		$this->load->view('main', $data);
		
	}

    function print_inv(){
        $this->load->library('Tcpdf');


        $id = $this->uri->segment(4);

        $sl = "
            pitstop_penjualan.*,
            pitstop_pelanggan.id AS supid,
            pitstop_pelanggan.nama_pelanggan,
            pitstop_pelanggan.no_hp,
            user.username,
            user.nama,
        ";

        $this->db->select($sl);
        $this->db->from("pitstop_penjualan");
        $this->db->join("pitstop_pelanggan", "pitstop_pelanggan.id = pitstop_penjualan.idpelanggan");
        $this->db->join("user", "user.username = pitstop_penjualan.created_by");
        $this->db->where("pitstop_penjualan.no_trans", $id);
        $h = $this->db->get()->row_array();

        $sl2 = "
        	pitstop_penjualan_detail.*,
        	pitstop_produk.nama_produk,
        	pitstop_produk.merk,
        	pitstop_produk.type_mobil
        ";
        $this->db->select($sl2);
        $this->db->from("pitstop_penjualan_detail");
        $this->db->join("pitstop_produk", "pitstop_produk.id = pitstop_penjualan_detail.iditem");
        $this->db->where("pitstop_penjualan_detail.no_trans", $id);
        $d = $this->db->get()->result();


        $data["h"]	= $h;
        $data["d"]	= $d;

        $this->load->view("print/pitstop/penj", $data);

    }
    function ff(){
        error_reporting(0);
        $d = $this->md->laporan_lunas($src_trans, "--", "--", $src_pelanggan, $src_plat, $src_pembayaran, $src_lunas, $src_status, $src_user);

        foreach ($d as $v) {
            echo $v->no_trans.", ";
        }
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
 
            $objget->setTitle('LUNAS'); //sheet title
            //Warna header tabel

            $objget->setCellValueByColumnAndRow(0, 1, "LAPORAN PENJUALAN PIT STOP");            
            $objget->mergeCells('A1:N1');
            //$objset->getStyle('A1:I1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
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
            $objset->getStyle('A1:I1')->applyFromArray($style_title);

            $src_trans      = $_GET['src_trans'];
            $src_from       = $_GET['src_from'];
            $src_to         = $_GET['src_to'];
            $src_pelanggan  = $_GET['src_pelanggan'];
            $src_user       = $_GET['src_user'];
            $src_status     = $_GET['src_status'];
            $src_pembayaran = $_GET['src_pembayaran'];
            $src_lunas      = $_GET['src_lunas'];
            $src_plat       = $_GET['src_plat'];

            if ($src_from=="--" && $src_to=="--") {
                $tgl = "Semua Tanggal";
            }
            else{
                $tgl = date("d F Y", strtotime($src_from))." - ".date("d F Y", strtotime($src_to));
            }


            $objget->setCellValue("B2", $tgl);            
            $objget->mergeCells('B2:D2');
            //$objset->getStyle('A1:I1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
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
            $objset->getStyle('B2:D2')->applyFromArray($style_date);


            $objget->getStyle("A4:N4")->applyFromArray(
                array(
                    'fill' => array(
                        'type' => PHPExcel_Style_Fill::FILL_SOLID,
                        'color' => array('rgb' => 'b8f2d6')
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
            $cols    = array("A","B","C","D","E","F","G","H","I", "J", "K", "L", "M", "N");
            $val   = array("NO ","TGL","NO TRANS", "PELANGGAN", "KENDARAAN", "PRODUK", "QTY", "HARGA JUAL", "DISC %", "SUBTOTAL", "JASA", "TOTAL", "PEMBAYARAN", "STATUS");

            for ($a=0;$a<14; $a++) 
            {
                $objset->setCellValue($cols[$a].'4', $val[$a]);
                 
                //Setting lebar cell
                $objset->getColumnDimension('A')->setWidth(5); 
                $objset->getColumnDimension('B')->setWidth(10); 
                $objset->getColumnDimension('C')->setWidth(15);
                $objset->getColumnDimension('D')->setWidth(30);
                $objset->getColumnDimension('E')->setWidth(30);
                $objset->getColumnDimension('F')->setWidth(40); 
                $objset->getColumnDimension('G')->setWidth(7);
                $objset->getColumnDimension('H')->setWidth(15);
                $objset->getColumnDimension('I')->setWidth(7);
                $objset->getColumnDimension('J')->setWidth(15);
                $objset->getColumnDimension('K')->setWidth(15);
                $objset->getColumnDimension('L')->setWidth(15);
                $objset->getColumnDimension('M')->setWidth(12);
                $objset->getColumnDimension('N')->setWidth(10);


                //$objset->getRowDimension('2')->setHeight(10); 
             
                $style = array(
                    'alignment' => array(
                        'horizontal' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
                        'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER
                    ),
                    'font' => array(
                        'size'  => 9
                    ),

                );
                $objset->getStyle($cols[$a].'4')->applyFromArray($style);
            }
            $objset->getRowDimension(4)->setRowHeight(40);

            //data
            $baris  = 5;



            $list = $this->md->laporan_lunas($src_trans, $src_from, $src_to, $src_pelanggan, $src_plat, $src_pembayaran, $src_lunas, $src_status, $src_user);
            $no = 1;
            $ak_total = 0;
            $ak_jasa   = 0;
            $ak_gt    = 0;

            foreach ($list as $v){
                 
               //pemanggilan sesuaikan dengan nama kolom tabel
                $objset->setCellValue("A".$baris, $no); 
                $objset->setCellValue("B".$baris, date("d/m/Y", strtotime($v->created_on)) );
                $objset->setCellValue("C".$baris, $v->no_trans );
                $objset->setCellValue("D".$baris, $v->nama_pelanggan );
                $objset->setCellValue("E".$baris, $v->kendaraan." (".$v->plat.")" );

                $sl = "
                    pitstop_penjualan_detail.*,
                    pitstop_produk.id AS titid,
                    pitstop_produk.nama_produk,
                    pitstop_produk.idsatuan,
                    pitstop_produk.merk,
                    satuan.id AS satid,
                    satuan.nama_satuan,
                    pitstop_penjualan.no_trans,
                    pitstop_penjualan.jasa
                ";
                $this->db->select($sl);
                $this->db->from("pitstop_penjualan_detail");
                $this->db->join("pitstop_produk", "pitstop_produk.id = pitstop_penjualan_detail.iditem");
                $this->db->join("satuan", "satuan.id = pitstop_produk.idsatuan");
                $this->db->join("pitstop_penjualan", "pitstop_penjualan.no_trans = pitstop_penjualan_detail.no_trans");
                $this->db->where("pitstop_penjualan_detail.no_trans", $v->no_trans);
                $det = $this->db->get()->result();

                $baris2 = $baris;
                $nod = 0;
                $nod2 = 0;
                $ttl = 0;
                foreach ($det as $vdet) {

                    if ($vdet->merk != "") {
                        $merk = " (".$vdet->merk.")";
                    }
                    else{
                        $merk = "";
                    }

                    $dlen = strlen($vdet->nama_produk.$merk);
                    $bts = 46;
                    $cl = ceil($dlen / $bts);


                    $baris3 = $baris2;
                    $ex = 0;
                    $nod3 = 0;
                    for($d = 1;$d<=$cl;$d++){
                        $objset->setCellValue("F".$baris3, substr($vdet->nama_produk.$merk, $ex,45) );
                        $baris3++;
                        $nod2++;
                        $nod3++;
                        $ex = $ex+45;
                    }

                    $pot1 = ( ( $vdet->harga *$vdet->qty)*$vdet->disc/100 );
                    $total1 = ($vdet->harga *$vdet->qty) - $pot1;
                    $ppn1 = $total1 *10/100;

                    if ($v->lunas == "Y") {
                        $lunas = "Lunas";
                    }
                    else{
                        $lunas = "Belum Lunas";
                    }

                    $objset->setCellValue("G".$baris2, $vdet->qty );
                    $objset->setCellValue("H".$baris2, $vdet->harga );
                    $objset->setCellValue("I".$baris2, $vdet->disc );
                    $objset->setCellValue("J".$baris2, $total1);

                    //$ak_ppn = $ak_ppn + 0;
                    
                    
                    $baris2 = $baris2 + $nod3;
                    $nod++;
                    $ttl = $ttl + $total1;

                    $ak_total = $ak_total + $total1;

                }
                $ak_gt = $ak_gt + ($ttl+$v->jasa);
                $ak_jasa = $ak_jasa + $v->jasa;

                //$ttl = $ttl + ($v->jasa + $ak_total);


                $objget->mergeCells('K'.$baris.':K'.($baris2-1));
                $objget->mergeCells('L'.$baris.':L'.($baris2-1));
                $objget->mergeCells('M'.$baris.':M'.($baris2-1));
                $objget->mergeCells('N'.$baris.':N'.($baris2-1));

                $objset->setCellValue("K".$baris, $v->jasa);
                $objset->setCellValue("L".$baris, $v->jasa + $ttl);
                $objset->setCellValue("M".$baris, $v->pembayaran);
                $objset->setCellValue("N".$baris, $lunas);

                $style_mrg = array(
                    'alignment' => array(
                        'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
                    )
                );
                $objget->getStyle('K'.$baris.':K'.($baris2-1))->applyFromArray($style_mrg);
                $objget->getStyle('L'.$baris.':L'.($baris2-1))->applyFromArray($style_mrg);
                $objget->getStyle('M'.$baris.':M'.($baris2-1))->applyFromArray($style_mrg);
                $objget->getStyle('N'.$baris.':N'.($baris2-1))->applyFromArray($style_mrg);

                $tbaris = $baris + $nod2;
                //$objset->setCellValue("K".$tbaris, $ttl);
                $style_total = array(
                        'font' => array(
                            'size'  => 9,
                            'bold'  => true
                        ),
                    );
                $objset->getStyle("L".$tbaris)->applyFromArray($style_total);


                //$objset->setCellValue("I".$baris, $v->no_trans );
                 
                //Set number value
                //$objset->getStyle('C1:C'.$baris)->getNumberFormat()->setFormatCode('0');
                $style_no = array(
                    'alignment' => array(
                        'horizontal' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
                        'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER
                    ),
                    'font' => array(
                        'size'  => 9
                    ),
                    'borders' => array(
                        'allborders' => array(
                            'style' => PHPExcel_Style_Border::BORDER_THIN,
                            'color' => array('rgb' => '000000')
                        )
                    )

                );
                $style_row = array(
                    'font' => array(
                        'size'  => 9
                    ),
                    'borders' => array(
                        'allborders' => array(
                            'style' => PHPExcel_Style_Border::BORDER_THIN,
                            'color' => array('rgb' => '000000')
                        )
                    )
                );
                $objset->getStyle("A5:A".$baris3)->applyFromArray($style_no);
                $objset->getStyle("B5:B".$baris3)->applyFromArray($style_no);
                $objset->getStyle("C5:C".$baris3)->applyFromArray($style_no);
                $objset->getStyle("D5:D".$baris3)->applyFromArray($style_row);
                $objset->getStyle("E5:E".$baris3)->applyFromArray($style_row);
                $objset->getStyle("F5:F".$baris3)->applyFromArray($style_row);
                $objset->getStyle("G5:G".$baris3)->applyFromArray($style_row);
                $objset->getStyle('G5:G'.$baris3)->getNumberFormat()->setFormatCode("#,##0");
                $objset->getStyle("H5:H".$baris3)->applyFromArray($style_row);
                $objset->getStyle('H5:H'.$baris3)->getNumberFormat()->setFormatCode("#,##0");
                $objset->getStyle("I5:I".$baris3)->applyFromArray($style_row);
                $objset->getStyle('I5:I'.$baris3)->getNumberFormat()->setFormatCode("#,##0");
                $objset->getStyle("J5:J".$baris3)->applyFromArray($style_row);
                $objset->getStyle('J5:J'.$baris3)->getNumberFormat()->setFormatCode("#,##0");
                $objset->getStyle("K5:K".$baris3)->applyFromArray($style_row);
                $objset->getStyle('K5:K'.$baris3)->getNumberFormat()->setFormatCode("#,##0");
                $objset->getStyle("L5:L".$baris3)->applyFromArray($style_row);
                $objset->getStyle('L5:L'.$baris3)->getNumberFormat()->setFormatCode("#,##0");
                $objset->getStyle("M5:M".$baris3)->applyFromArray($style_no);
                $objset->getStyle("N5:N".$baris3)->applyFromArray($style_no);



                 
                $baris = $baris + $nod2+1;
                $no++;
            }
                  
            $objget->mergeCells('A'.$baris.':I'.$baris);
            $objset->setCellValue("A".$baris, "GRAND TOTAL");
            //$objset->getStyle('A1:I1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            $style_gt = array(
                'alignment' => array(
                    'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
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
            );
            $objset->getStyle('A'.$baris.':I'.$baris)->applyFromArray($style_gt);

            $style_gtotal = array(
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
            );
            $style_tax = array(
                'font' => array(
                    'color' => array('rgb' => 'ff0000'),
                    'bold'  => true,
                    'size'  => 10
                ),
                'borders' => array(
                    'allborders' => array(
                        'style' => PHPExcel_Style_Border::BORDER_THIN,
                        'color' => array('rgb' => '000000')
                    )
                )
            );
            $objset->getStyle("J".$baris)->applyFromArray($style_gtotal);
            $objset->getStyle('J'.$baris)->getNumberFormat()->setFormatCode("#,##0");
            $objset->getStyle("K".$baris)->applyFromArray($style_tax);
            $objset->getStyle('K'.$baris)->getNumberFormat()->setFormatCode("#,##0");
            $objset->getStyle("L".$baris)->applyFromArray($style_gtotal);
            $objset->getStyle('L'.$baris)->getNumberFormat()->setFormatCode("#,##0");
            $objset->getStyle("M".$baris)->applyFromArray($style_gtotal);
            $objset->getStyle("N".$baris)->applyFromArray($style_gtotal);

            $objset->setCellValue("J".$baris, $ak_total);
            $objset->setCellValue("K".$baris, $ak_jasa);
            $objset->setCellValue("L".$baris, $ak_gt);
            $objset->setCellValue("M".$baris,"");
            $objset->setCellValue("N".$baris,"");

            //========================== SHEET 2 ===========================================================//


            $objget2 = $objPHPExcel->createSheet(); 
            $objget2->setTitle('BELUM LUNAS'); //sheet title
            //Warna header tabel

            $objget2->setCellValueByColumnAndRow(0, 1, "LAPORAN PENJUALAN PIT STOP");            
            $objget2->mergeCells('A1:N1');
            //$objset->getStyle('A1:I1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
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
            $objget2->getStyle('A1:I1')->applyFromArray($style_title);

            $src_trans      = $_GET['src_trans'];
            $src_from       = $_GET['src_from'];
            $src_to         = $_GET['src_to'];
            $src_pelanggan  = $_GET['src_pelanggan'];
            $src_user       = $_GET['src_user'];
            $src_status     = $_GET['src_status'];
            $src_pembayaran = $_GET['src_pembayaran'];
            $src_lunas      = $_GET['src_lunas'];
            $src_plat       = $_GET['src_plat'];

            if ($src_from=="--" && $src_to=="--") {
                $tgl = "Semua Tanggal";
            }
            else{
                $tgl = date("d F Y", strtotime($src_from))." - ".date("d F Y", strtotime($src_to));
            }


            $objget2->setCellValue("B2", $tgl);            
            $objget2->mergeCells('B2:D2');
            //$objget2->getStyle('A1:I1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
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
            $objget2->getStyle('B2:D2')->applyFromArray($style_date);


            $objget2->getStyle("A4:N4")->applyFromArray(
                array(
                    'fill' => array(
                        'type' => PHPExcel_Style_Fill::FILL_SOLID,
                        'color' => array('rgb' => 'ffe2a5')
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
            $cols    = array("A","B","C","D","E","F","G","H","I", "J", "K", "L", "M", "N");
            $val   = array("NO ","TGL","NO TRANS", "PELANGGAN", "KENDARAAN", "PRODUK", "QTY", "HARGA JUAL", "DISC %", "SUBTOTAL", "JASA", "TOTAL", "PEMBAYARAN", "STATUS");

            for ($a=0;$a<14; $a++) 
            {
                $objget2->setCellValue($cols[$a].'4', $val[$a]);
                 
                //Setting lebar cell
                $objget2->getColumnDimension('A')->setWidth(5); 
                $objget2->getColumnDimension('B')->setWidth(10); 
                $objget2->getColumnDimension('C')->setWidth(15);
                $objget2->getColumnDimension('D')->setWidth(30);
                $objget2->getColumnDimension('E')->setWidth(30);
                $objget2->getColumnDimension('F')->setWidth(40); 
                $objget2->getColumnDimension('G')->setWidth(7);
                $objget2->getColumnDimension('H')->setWidth(15);
                $objget2->getColumnDimension('I')->setWidth(7);
                $objget2->getColumnDimension('J')->setWidth(15);
                $objget2->getColumnDimension('K')->setWidth(15);
                $objget2->getColumnDimension('L')->setWidth(15);
                $objget2->getColumnDimension('M')->setWidth(12);
                $objget2->getColumnDimension('N')->setWidth(10);


                //$objget2->getRowDimension('2')->setHeight(10); 
             
                $style = array(
                    'alignment' => array(
                        'horizontal' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
                        'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER
                    ),
                    'font' => array(
                        'size'  => 9
                    ),

                );
                $objget2->getStyle($cols[$a].'4')->applyFromArray($style);
            }
            $objget2->getRowDimension(4)->setRowHeight(40);

            //data
            $baris  = 5;



            $list = $this->md->laporan_blunas($src_trans, $src_from, $src_to, $src_pelanggan, $src_plat, $src_pembayaran, $src_lunas, $src_status, $src_user);
            $no = 1;
            $ak_total = 0;
            $ak_jasa   = 0;
            $ak_gt    = 0;

            foreach ($list as $v){
                 
               //pemanggilan sesuaikan dengan nama kolom tabel
                $objget2->setCellValue("A".$baris, $no); 
                $objget2->setCellValue("B".$baris, date("d/m/Y", strtotime($v->created_on)) );
                $objget2->setCellValue("C".$baris, $v->no_trans );
                $objget2->setCellValue("D".$baris, $v->nama_pelanggan );
                $objget2->setCellValue("E".$baris, $v->kendaraan." (".$v->plat.")" );

                $sl = "
                    pitstop_penjualan_detail.*,
                    pitstop_produk.id AS titid,
                    pitstop_produk.nama_produk,
                    pitstop_produk.idsatuan,
                    pitstop_produk.merk,
                    satuan.id AS satid,
                    satuan.nama_satuan,
                    pitstop_penjualan.no_trans,
                    pitstop_penjualan.jasa
                ";
                $this->db->select($sl);
                $this->db->from("pitstop_penjualan_detail");
                $this->db->join("pitstop_produk", "pitstop_produk.id = pitstop_penjualan_detail.iditem");
                $this->db->join("satuan", "satuan.id = pitstop_produk.idsatuan");
                $this->db->join("pitstop_penjualan", "pitstop_penjualan.no_trans = pitstop_penjualan_detail.no_trans");
                $this->db->where("pitstop_penjualan_detail.no_trans", $v->no_trans);
                $det = $this->db->get()->result();

                $baris2 = $baris;
                $nod = 0;
                $nod2 = 0;
                $ttl = 0;
                foreach ($det as $vdet) {

                    if ($vdet->merk != "") {
                        $merk = " (".$vdet->merk.")";
                    }
                    else{
                        $merk = "";
                    }

                    $dlen = strlen($vdet->nama_produk.$merk);
                    $bts = 46;
                    $cl = ceil($dlen / $bts);


                    $baris3 = $baris2;
                    $ex = 0;
                    $nod3 = 0;
                    for($d = 1;$d<=$cl;$d++){
                        $objget2->setCellValue("F".$baris3, substr($vdet->nama_produk.$merk, $ex,45) );
                        $baris3++;
                        $nod2++;
                        $nod3++;
                        $ex = $ex+45;
                    }

                    $pot1 = ( ( $vdet->harga *$vdet->qty)*$vdet->disc/100 );
                    $total1 = ($vdet->harga *$vdet->qty) - $pot1;
                    $ppn1 = $total1 *10/100;

                    if ($v->lunas == "Y") {
                        $lunas = "Lunas";
                    }
                    else{
                        $lunas = "Belum Lunas";
                    }

                    $objget2->setCellValue("G".$baris2, $vdet->qty );
                    $objget2->setCellValue("H".$baris2, $vdet->harga );
                    $objget2->setCellValue("I".$baris2, $vdet->disc );
                    $objget2->setCellValue("J".$baris2, $total1);

                    $ak_ppn = $ak_ppn + 0;
                    
                    
                    $baris2 = $baris2 + $nod3;
                    $nod++;
                    $ttl = $ttl + $total1;

                    $ak_total = $ak_total + $total1;

                }
                $ak_gt = $ak_gt + ($ttl+$v->jasa);
                $ak_jasa = $ak_jasa + $v->jasa;

                //$ttl = $ttl + ($v->jasa + $ak_total);


                $objget2->mergeCells('K'.$baris.':K'.($baris2-1));
                $objget2->mergeCells('L'.$baris.':L'.($baris2-1));
                $objget2->mergeCells('M'.$baris.':M'.($baris2-1));
                $objget2->mergeCells('N'.$baris.':N'.($baris2-1));

                $objget2->setCellValue("K".$baris, $v->jasa);
                $objget2->setCellValue("L".$baris, $v->jasa + $ttl);
                $objget2->setCellValue("M".$baris, $v->pembayaran);
                $objget2->setCellValue("N".$baris, $lunas);

                $style_mrg = array(
                    'alignment' => array(
                        'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
                    )
                );
                $objget2->getStyle('K'.$baris.':K'.($baris2-1))->applyFromArray($style_mrg);
                $objget2->getStyle('L'.$baris.':L'.($baris2-1))->applyFromArray($style_mrg);
                $objget2->getStyle('M'.$baris.':M'.($baris2-1))->applyFromArray($style_mrg);
                $objget2->getStyle('N'.$baris.':N'.($baris2-1))->applyFromArray($style_mrg);

                $tbaris = $baris + $nod2;
                //$objget2->setCellValue("K".$tbaris, $ttl);
                $style_total = array(
                        'font' => array(
                            'size'  => 9,
                            'bold'  => true
                        ),
                    );
                $objget2->getStyle("L".$tbaris)->applyFromArray($style_total);


                //$objget2->setCellValue("I".$baris, $v->no_trans );
                 
                //Set number value
                //$objget2->getStyle('C1:C'.$baris)->getNumberFormat()->setFormatCode('0');
                $style_no = array(
                    'alignment' => array(
                        'horizontal' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
                        'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER
                    ),
                    'font' => array(
                        'size'  => 9
                    ),
                    'borders' => array(
                        'allborders' => array(
                            'style' => PHPExcel_Style_Border::BORDER_THIN,
                            'color' => array('rgb' => '000000')
                        )
                    )

                );
                $style_row = array(
                    'font' => array(
                        'size'  => 9
                    ),
                    'borders' => array(
                        'allborders' => array(
                            'style' => PHPExcel_Style_Border::BORDER_THIN,
                            'color' => array('rgb' => '000000')
                        )
                    )
                );
                $objget2->getStyle("A5:A".$baris3)->applyFromArray($style_no);
                $objget2->getStyle("B5:B".$baris3)->applyFromArray($style_no);
                $objget2->getStyle("C5:C".$baris3)->applyFromArray($style_no);
                $objget2->getStyle("D5:D".$baris3)->applyFromArray($style_row);
                $objget2->getStyle("E5:E".$baris3)->applyFromArray($style_row);
                $objget2->getStyle("F5:F".$baris3)->applyFromArray($style_row);
                $objget2->getStyle("G5:G".$baris3)->applyFromArray($style_row);
                $objget2->getStyle('G5:G'.$baris3)->getNumberFormat()->setFormatCode("#,##0");
                $objget2->getStyle("H5:H".$baris3)->applyFromArray($style_row);
                $objget2->getStyle('H5:H'.$baris3)->getNumberFormat()->setFormatCode("#,##0");
                $objget2->getStyle("I5:I".$baris3)->applyFromArray($style_row);
                $objget2->getStyle('I5:I'.$baris3)->getNumberFormat()->setFormatCode("#,##0");
                $objget2->getStyle("J5:J".$baris3)->applyFromArray($style_row);
                $objget2->getStyle('J5:J'.$baris3)->getNumberFormat()->setFormatCode("#,##0");
                $objget2->getStyle("K5:K".$baris3)->applyFromArray($style_row);
                $objget2->getStyle('K5:K'.$baris3)->getNumberFormat()->setFormatCode("#,##0");
                $objget2->getStyle("L5:L".$baris3)->applyFromArray($style_row);
                $objget2->getStyle('L5:L'.$baris3)->getNumberFormat()->setFormatCode("#,##0");
                $objget2->getStyle("M5:M".$baris3)->applyFromArray($style_no);
                $objget2->getStyle("N5:N".$baris3)->applyFromArray($style_no);



                 
                $baris = $baris + $nod2+1;
                $no++;
            }
                  
            $objget2->mergeCells('A'.$baris.':I'.$baris);
            $objget2->setCellValue("A".$baris, "GRAND TOTAL");
            //$objget2->getStyle('A1:I1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            $style_gt = array(
                'alignment' => array(
                    'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
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
            );
            $objget2->getStyle('A'.$baris.':I'.$baris)->applyFromArray($style_gt);

            $style_gtotal = array(
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
            );
            $style_tax = array(
                'font' => array(
                    'color' => array('rgb' => 'ff0000'),
                    'bold'  => true,
                    'size'  => 10
                ),
                'borders' => array(
                    'allborders' => array(
                        'style' => PHPExcel_Style_Border::BORDER_THIN,
                        'color' => array('rgb' => '000000')
                    )
                )
            );
            $objget2->getStyle("J".$baris)->applyFromArray($style_gtotal);
            $objget2->getStyle('J'.$baris)->getNumberFormat()->setFormatCode("#,##0");
            $objget2->getStyle("K".$baris)->applyFromArray($style_tax);
            $objget2->getStyle('K'.$baris)->getNumberFormat()->setFormatCode("#,##0");
            $objget2->getStyle("L".$baris)->applyFromArray($style_gtotal);
            $objget2->getStyle('L'.$baris)->getNumberFormat()->setFormatCode("#,##0");
            $objget2->getStyle("M".$baris)->applyFromArray($style_gtotal);
            $objget2->getStyle("N".$baris)->applyFromArray($style_gtotal);

            $objget2->setCellValue("J".$baris, $ak_total);
            $objget2->setCellValue("K".$baris, $ak_jasa);
            $objget2->setCellValue("L".$baris, $ak_gt);
            $objget2->setCellValue("M".$baris,"");
            $objget2->setCellValue("N".$baris,"");



            $objPHPExcel->setActiveSheetIndex(0);
            $filename = urlencode("Laporan Penjualan Pit Stop.xlsx");
               
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
            quotation.*
        ";
        $this->db->select($sl);
        $this->db->from("quotation");
        $this->db->like("no_trans", $_POST["term"]);
        $d = $this->db->get()->result();


        $no = 0;
        $data = "[";
        foreach ($d as $v) {
            
            if ($no > 0) {
                $data.=", ";
            }

            $dt = array(
                    "id"            => $v->no_trans
                );

            $data .= json_encode($dt);
            $no++;
        }

        $data.="]";

        echo $data;
    }

    public function add(){
        error_reporting(0);

        $session_no = count($_SESSION['pjp']);
        $no_item    = $session_no+1;

        $id     = $_POST["id"];
        $harga  = str_replace(".","",$_POST["harga"]);
        $qty    = str_replace(".","",$_POST["qty"]);
        $modal    = str_replace(".","",$_POST["modal"]);
        $satuan = $_POST["satuan"];
        if ($_POST['disc']=="") {
        	$disc = 0;
        }
        else{
        	$disc = $_POST['disc'];
        }

        if ($session_no!=0) {
            for($i=1;$i<=$session_no;$i++){

                if ($_SESSION['pjp'][$i][0] == $id) {
                    $mqty       = $qty + $_SESSION['pjp'][$i][1];
                    $sess_id    = $_SESSION['pjp'][$i][2];
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


        $_SESSION['pjp'][$sess_id][0]=$id; // idproduk
        $_SESSION['pjp'][$sess_id][1]=$mqty; //qty
        $_SESSION['pjp'][$sess_id][2]=$sess_id; //session id
        $_SESSION['pjp'][$sess_id][3]=$harga; //harga
        $_SESSION['pjp'][$sess_id][4]=$satuan; //satuan
        $_SESSION['pjp'][$sess_id][5]=$modal;
        $_SESSION['pjp'][$sess_id][6]=$disc;

        echo "1";

    }
    public function add_draft(){

        $id         = $_POST["id"];
        $harga      = str_replace(".","",$_POST["harga"]);
        $qty        = str_replace(".","",$_POST["qty"]);
        $modal      = str_replace(".","",$_POST["modal"]);
        $satuan     = $_POST["satuan"];
        $no_trans   = $_POST["no_trans"];

        if ($_POST['disc']=="") {
            $disc = 0;
        }
        else{
            $disc = $_POST['disc'];
        }

        $this->db->where("no_trans", $no_trans);
        $this->db->where("iditem", $id);
        $q = $this->db->get("pitstop_penjualan_detail");
        $d = $q->row_array();
        $n = $q->num_rows();

        $this->db->trans_start();

            if ($n == 0) {
                $dt = array(
                        "iditem"    => $id,
                        "harga"     => $harga,
                        "modal"     => $modal,
                        "qty"       => $qty,
                        "disc"      => $disc,
                        "no_trans"  => $no_trans
                    );
                $this->db->insert("pitstop_penjualan_detail", $dt);
            }
            else{

                $tqty = $qty + $d["qty"];

                $dt = array(
                        "qty"   => $tqty
                    );

                $this->db->where("no_trans", $no_trans);
                $this->db->where("iditem", $id);
                $this->db->update("pitstop_penjualan_detail", $dt);
            }

        $this->db->trans_complete();

        if ($this->db->trans_status() === TRUE) {
            $this->db->trans_commit();
            echo "1";
        }
        else{
            $this->db->trans_rollback();
            echo "0";
        }

    }
    function del_draft(){
        $id = $_POST["id"];

        $this->db->where("id", $id);
        $this->db->delete("pitstop_penjualan_detail");
    }
    public function del(){

        $id = $_POST["id"];

        unset($_SESSION['pjp'][$id][0]);
        unset($_SESSION['pjp'][$id][1]);
        unset($_SESSION['pjp'][$id][2]);
        unset($_SESSION['pjp'][$id][3]);
        unset($_SESSION['pjp'][$id][4]);
        unset($_SESSION['pjp'][$id][5]);
        unset($_SESSION['pjp'][$id][6]);

    }

    public function potong_stok($idproduk, $qty){

    	$this->db->where("idproduk", $idproduk);
    	$this->db->where("idgudang", "4");
    	$d = $this->db->get("pitstop_stok")->row_array();

    	$sisa = $d["qty"] - $qty;

    	$dt = array(
    			"qty"	=> $sisa
    		);
    	$this->db->where("idproduk", $idproduk);
    	$this->db->where("idgudang", "4");
    	$this->db->update("pitstop_stok", $dt);



    }
    function draft(){
        error_reporting(0);

        $no_trans   = $_POST["no_trans"];
        $user       = $this->lnd->me();
        $pelanggan  = $_POST["pelanggan"];
        $pembayaran = $_POST["pembayaran"];
        $plat       = $_POST["plat"];
        $kendaraan  = $_POST["kendaraan"];

        $this->db->where("no_trans", $no_trans);
        $c = $this->db->get("pitstop_penjualan")->num_rows();

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
                "pembayaran"        => $pembayaran,
                "plat"              => $plat,
                "kendaraan"         => $kendaraan,
                "lunas"             => "N",
                "status"            => "DRAFT",
                "debit_bank"        => "",
                "created_by"        => $user["username"],
                "created_on"        => date("Y-m-d H:i:s")
            );
        $dt_act = array(
            "deskripsi"         => $user["nama"]." telah menambah data Draft Penjualan ".$no_trans.".",
            "jenis_aktivitas"   => "TAMBAH",
            "divisi"            => "pitstop",
            "iduser"            => $user['username'],
            "tgl"               => date("Y-m-d H:i:s")
        );

        $this->db->trans_start();

            $this->db->insert("pitstop_penjualan", $dt);

            $session_no = count($_SESSION['pjp']);
            for($i=1;$i<=$session_no;$i++){
                if ($_SESSION['pjp'][$i][2]!="") {


                    $dt2 = array(
                            "iditem"        => $_SESSION['pjp'][$i][0],
                            "harga"         => $_SESSION['pjp'][$i][3],
                            "no_trans"      => $no_po,
                            "modal"         => $_SESSION['pjp'][$i][5],
                            "qty"           => $_SESSION['pjp'][$i][1],
                            "disc"          => $_SESSION['pjp'][$i][6],
                        );

                    $this->db->insert("pitstop_penjualan_detail", $dt2);
                        
                }
                
            }

            //$this->db->insert("aktivitas", $dt_act);

            

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

    function add_pembayaran(){
    	$sisa 		= $_POST["sisa"];
    	$nominal 	= $_POST["nominal"];
    	$no_trans 	= $_POST["no_trans"];

    	if ($nominal >= $sisa) {
    		$lunas = "Y";
    	}
    	else{
    		$lunas = "N";
    	}

    	$dt = array(
    			"lunas"	=> $lunas
    		);
        
    	$dt2 = array(
    			"no_trans"		=> $no_trans,
    			"nominal"		=> $nominal,
    			"created_on"	=> date("Y-m-d H:i:s"),
    			"created_by"	=> $this->session->userdata("lnd_id"),
    		);

    	$this->db->trans_start();

    		$this->db->where("no_trans", $no_trans);
    		$this->db->update("pitstop_penjualan", $dt);

    		$this->db->insert("pitstop_pembayaran", $dt2);

    	$this->db->trans_complete();

    	if ($this->db->trans_status() === TRUE) {
    		$this->db->trans_commit();
    		echo "1";
    	}
    	else{
    		$this->db->trans_rollback();
    		echo "0";
    	}
    }

    function wa(){
        $this->lnd->send_wa("085321845172", "Selamat.\nTransaksi Penjualan Pit Stop baru dengan No. Transaksi TPSJ-181210001 senilai Rp. 350.000 telah berhasil.\nBy : *Lundara Bot*");
    }
    function save(){
        error_reporting(0);

        $no_trans   = $_POST["no_trans"];
        $user       = $this->lnd->me();
        $pelanggan  = $_POST["pelanggan"];
        $pembayaran = $_POST["pembayaran"];
        $plat 		= $_POST["plat"];
        $kendaraan 	= $_POST["kendaraan"];
        $bayar 		= str_replace(".", "", $_POST["bayar"]);
        $kembalian	= str_replace(".", "", $_POST["kembalian"]);
        $jasa 		= str_replace(".", "", $_POST["jasa"]);
        $gtotal     = $_POST["gtotal"];

        $this->db->where("no_trans", $no_trans);
        $c = $this->db->get("pitstop_penjualan")->num_rows();

        if ($c==0) {
            $no_po = $no_trans;
        }
        else{
            $no_po = $no_trans.rand(0,999);
        }

        if ($bayar >= $gtotal) {
            $lunas = "Y";
        }
        else{
            $lunas = "N";
        }



        $dt = array(
                "no_trans"          => $no_po,
                "created_by"        => $user["username"],
                "idpelanggan"       => $pelanggan,
                "pembayaran"      	=> $pembayaran,
                "plat"            	=> $plat,
                "kendaraan"         => $kendaraan,
                "bayar"             => $bayar,
                "kembalian"			=> $kembalian,
                "jasa"				=> $jasa,
                "lunas"				=> $lunas,
                "status"			=> "POSTED",
                "debit_bank"		=> "",
                "created_by"		=> $user["username"],
                "created_on"        => date("Y-m-d H:i:s")
            );
        $dt_act = array(
            "deskripsi"         => $user["nama"]." telah menambah data Penjualan ".$no_trans.".",
            "jenis_aktivitas"   => "TAMBAH",
            "divisi"			=> "pitstop",
            "iduser"            => $user['username'],
            "tgl"               => date("Y-m-d H:i:s")
        );
        $dt_bayar = array(
                "no_trans"      => $no_po,
                "nominal"       => $bayar,
                "created_by"    => $user["username"],
                "created_on"    => date("Y-m-d H:i:s")

            );
        $this->db->trans_start();

            $this->db->insert("pitstop_penjualan", $dt);

            $this->db->insert("pitstop_pembayaran", $dt_bayar);

            $session_no = count($_SESSION['pjp']);
            for($i=1;$i<=$session_no;$i++){
                if ($_SESSION['pjp'][$i][2]!="") {


                    $dt2 = array(
                            "iditem"        => $_SESSION['pjp'][$i][0],
                            "harga"         => $_SESSION['pjp'][$i][3],
                            "no_trans"      => $no_po,
                            "modal"         => $_SESSION['pjp'][$i][5],
                            "qty"           => $_SESSION['pjp'][$i][1],
                            "disc"          => $_SESSION['pjp'][$i][6],
                        );

                    $this->db->where("idproduk", $_SESSION['pjp'][$i][0]);
                    $this->db->where("created_on", date("Y-m-d"));
                    $this->db->order_by("created_on", "desc");
                    $this->db->limit(1);
                    $qks = $this->db->get("pitstop_kartu_stok");
                    $cks = $qks->num_rows();
                    $dks = $qks->row_array();

                    if ($cks == 0) {
                        $this->db->where("idproduk", $_SESSION['pjp'][$i][0]);
                        $this->db->order_by("created_on", "desc");
                        $this->db->limit(1);
                        $ks = $this->db->get("pitstop_kartu_stok")->row_array();
                        $dtks = array(
                                "idproduk"  => $_SESSION['pjp'][$i][0],
                                "jual"      => $_SESSION['pjp'][$i][1],
                                "beli"      => "0",
                                "stok"      => $ks["stok"] - $_SESSION['pjp'][$i][1],
                                "created_on"    => date("Y-m-d")
                            );
                        $this->db->insert("pitstop_kartu_stok", $dtks);
                    }
                    else{
                        $dtks = array(
                                "idproduk"  => $_SESSION['pjp'][$i][0],
                                "jual"      => $dks["jual"] + $_SESSION['pjp'][$i][1],
                                "beli"      => $dks["beli"],
                                "stok"      => $dks["stok"] - $_SESSION['pjp'][$i][1]
                            );

                        $this->db->where("id", $dks["id"]);
                        $this->db->update("pitstop_kartu_stok", $dtks);
                    }

                    $this->db->insert("pitstop_penjualan_detail", $dt2);
                    $this->potong_stok($_SESSION['pjp'][$i][0], $_SESSION['pjp'][$i][1]);
                        
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

    function save_draft(){
        error_reporting(0);

        $no_trans   = $_POST["no_trans"];
        $user       = $this->lnd->me();
        $pelanggan  = $_POST["pelanggan"];
        $pembayaran = $_POST["pembayaran"];
        $plat       = $_POST["plat"];
        $kendaraan  = $_POST["kendaraan"];
        $bayar      = str_replace(".", "", $_POST["bayar"]);
        $kembalian  = str_replace(".", "", $_POST["kembalian"]);
        $jasa       = str_replace(".", "", $_POST["jasa"]);
        $gtotal     = $_POST["gtotal"];


        if ($bayar >= $gtotal) {
            $lunas = "Y";
        }
        else{
            $lunas = "N";
        }



        $dt = array(
                "no_trans"          => $no_trans,
                "idpelanggan"       => $pelanggan,
                "pembayaran"        => $pembayaran,
                "plat"              => $plat,
                "kendaraan"         => $kendaraan,
                "bayar"             => $bayar,
                "kembalian"         => $kembalian,
                "jasa"              => $jasa,
                "lunas"             => $lunas,
                "status"            => "POSTED",
                "debit_bank"        => "",
                "created_on"		=> date("Y-m-d H:i:s")
        );
        $dt_act = array(
            "deskripsi"         => $user["nama"]." telah memposting data Penjualan ".$no_trans.".",
            "jenis_aktivitas"   => "TAMBAH",
            "divisi"            => "pitstop",
            "iduser"            => $user['username'],
            "tgl"               => date("Y-m-d H:i:s")
        );
        $dt_bayar = array(
                "no_trans"      => $no_trans,
                "nominal"       => $bayar,
                "created_by"    => $user["username"],
                "created_on"    => date("Y-m-d H:i:s")

        );

        $this->db->where("no_trans", $no_trans);
        $det = $this->db->get("pitstop_penjualan_detail")->result();

        $this->db->trans_start();

            $this->db->where("no_trans", $no_trans);
            $this->db->update("pitstop_penjualan", $dt);

            $this->db->insert("pitstop_pembayaran", $dt_bayar);

            $this->db->insert("aktivitas", $dt_act);



            foreach ($det as $vdet) {
                $this->db->where("idproduk", $vdet->iditem);
                $this->db->where("created_on", date("Y-m-d"));
                $this->db->order_by("created_on", "desc");
                $this->db->limit(1);
                $qks = $this->db->get("pitstop_kartu_stok");
                $cks = $qks->num_rows();
                $dks = $qks->row_array();

                $this->db->where("no_trans", $no_trans);
                $dn = $this->db->get("pitstop_penjualan")->row_array();

                if ($cks == 0) {
                    $this->db->where("idproduk", $vdet->iditem);
                    $this->db->order_by("created_on", "desc");
                    $this->db->limit(1);
                    $ks = $this->db->get("pitstop_kartu_stok")->row_array();
                    $dtks = array(
                            "idproduk"  => $vdet->iditem,
                            "jual"      => $vdet->qty,
                            "beli"      => "0",
                            "stok"      => $ks["stok"] - $vdet->qty,
                            //"created_on"    => date("Y-m-d")
                            "created_on"    => date("Y-m-d")
                        );
                    $this->db->insert("pitstop_kartu_stok", $dtks);
                }
                else{
                    $dtks = array(
                            "idproduk"  => $vdet->iditem,
                            "jual"      => $dks["jual"] + $vdet->qty,
                            "beli"      => $dks["beli"],
                            "stok"      => $dks["stok"] - $vdet->qty
                        );

                    $this->db->where("id", $dks["id"]);
                    $this->db->update("pitstop_kartu_stok", $dtks);
                }
                //$this->potong_stok($vdet->iditem, $vdet->qty);
            }

            //$this->potong_stok(idproduk, qty);


        $this->db->trans_complete();          

        if ($this->db->trans_status() === TRUE) {
            $this->db->trans_commit();
            echo "1";
        }   
        else{
            $this->db->trans_rollback();
            echo "0";
        }  


    }

    public function des(){
        $this->session->unset_userdata('pjp');
    }

    public function data_item(){
        error_reporting(0);

        $session_no = count($_SESSION['pjp']);
        $json = "[";
        $no = 1;
        $vpot = 0;
        for($i=1;$i<=$session_no;$i++){



            if ($_SESSION['pjp'][$i][2]!="") {
                if ($no>1) {
                    $json.=",";
                }
                $this->db->where("pitstop_produk.id", $_SESSION['pjp'][$i][0]);
                $produk = $this->db->get("pitstop_produk")->row_array();

                if ($produk["type_mobil"]==null) {
                    $tipe = "";
                }
                else{
                    $tipe = " (".$produk["type_mobil"].")";
                }

                $vpot = $vpot + (( $_SESSION['pjp'][$i][3] * $_SESSION['pjp'][$i][1])*$_SESSION['pjp'][$i][6]/100);

                $dt = array(
                        "id_produk"     => $_SESSION['pjp'][$i][0],
                        "nama_item"     => $produk["nama_produk"].$tipe,
                        "qty"           => $_SESSION['pjp'][$i][1],
                        "harga"         => $_SESSION['pjp'][$i][3],
                        "netto"         => ( $_SESSION['pjp'][$i][3] * $_SESSION['pjp'][$i][1]) - (( $_SESSION['pjp'][$i][3] * $_SESSION['pjp'][$i][1])*$_SESSION['pjp'][$i][6]/100) ,
                        "brutto"        => ($_SESSION['pjp'][$i][3] * $_SESSION['pjp'][$i][1]),
                        "id"            => $_SESSION['pjp'][$i][2],
                        "pot"           => $vpot,
                        "total_item"    => $no,
                        "merk"			=> $produk["merk"],
                        "satuan"        => $_SESSION['pjp'][$i][4],
                        "modal"         => $_SESSION['pjp'][$i][5],
                        "disc"          => $_SESSION['pjp'][$i][6],


                    );

                $json.=json_encode($dt);
                $no++;
            }
            
        }

        $json.="]";
        
        echo $json;


    }

    function get_trans(){

        $this->db->where("DATE(created_on)", date("Y-m-d"));
        $this->db->order_by("created_on", "desc");
        $q = $this->db->get("pitstop_penjualan");
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
                "no_trans"  =>"TPSJ-".date("ymd").sprintf("%03d", $digit+1)
            ));

        $x = "[".$d."]";
        echo $x;

    }


    function pembayaran(){
        $id = $_POST["id"];

        $sl = "
            pitstop_pembayaran.*,
            user.username,
            user.nama
        ";
        $this->db->select($sl);
        $this->db->from("pitstop_pembayaran");
        $this->db->join("user", "user.username = pitstop_pembayaran.created_by");
        $this->db->where("pitstop_pembayaran.no_trans", $id);
        $d = $this->db->get()->result();

        $slb = "
        	pitstop_pembayaran.*,
        	SUM(pitstop_pembayaran.nominal) AS bayar
        ";
        $this->db->select($slb);
        $this->db->from("pitstop_pembayaran");
        $this->db->where("pitstop_pembayaran.no_trans", $id);
        $dtb = $this->db->get()->row_array();

       $slp = "
            pitstop_penjualan_detail.id,
            pitstop_penjualan_detail.harga,
            pitstop_penjualan_detail.qty,
            pitstop_penjualan_detail.disc,
            pitstop_penjualan_detail.modal,
            SUM( (pitstop_penjualan_detail.harga * pitstop_penjualan_detail.qty) - (pitstop_penjualan_detail.harga * pitstop_penjualan_detail.qty)*pitstop_penjualan_detail.disc/100  ) AS piutang,
            pitstop_penjualan.no_trans,
            pitstop_penjualan.lunas,
            pitstop_penjualan.status,
            pitstop_penjualan.jasa
        ";
        $this->db->select($slp);
        $this->db->from('pitstop_penjualan_detail');
        $this->db->join("pitstop_penjualan", "pitstop_penjualan.no_trans = pitstop_penjualan_detail.no_trans");
        $this->db->where("pitstop_penjualan_detail.no_trans", $id);
        $dtp = $this->db->get()->row_array();


        if ($dtb["bayar"] >= ($dtp["piutang"]+$dtp["jasa"]) ) {
        	$sisa = 0;
        }
        else{
        	$sisa = number_format($dtb["bayar"] - ($dtp["piutang"]+$dtp["jasa"]), 0, ",", ".");
        }

        $no = 1;
        $json = "[";
        foreach ($d as $v) {
            if ($no>1) {
                $json.=", ";
            }

            $dt = array(
                    "id"        => $v->id,
                    "nominal"   => number_format($v->nominal, 0, ",", "."),
                    "tgl"       => date("d/m/Y H:i:s", strtotime($v->created_on)),
                    "kasir"     => $v->nama,
                    "bayar"		=> number_format($dtb["bayar"], 0, ",", "."),
                    "piutang"	=> number_format($dtp["piutang"]+$dtp["jasa"], 0, ",", "."),
                    "sisa"		=> $sisa
                );

            $json.=json_encode($dt);
            $no++;
        }
        $json.="]";

        echo $json;
    }

    function detail(){
        $id = $_POST["id"];


        $sl = "
            pitstop_penjualan_detail.*,
            pitstop_produk.id AS titid,
            pitstop_produk.nama_produk,
            pitstop_produk.idsatuan,
            pitstop_produk.merk,
            satuan.id AS satid,
            satuan.nama_satuan,
            pitstop_penjualan.no_trans,
            pitstop_penjualan.jasa
        ";
        $this->db->select($sl);
        $this->db->from("pitstop_penjualan_detail");
        $this->db->join("pitstop_produk", "pitstop_produk.id = pitstop_penjualan_detail.iditem");
        $this->db->join("satuan", "satuan.id = pitstop_produk.idsatuan");
        $this->db->join("pitstop_penjualan", "pitstop_penjualan.no_trans = pitstop_penjualan_detail.no_trans");
        $this->db->where("pitstop_penjualan_detail.no_trans", $id);
        $d = $this->db->get()->result();

        $json = "[";
        $no = 0;
        $subtotal = 0;
        $ppn = 0;
        foreach ($d as $v) {
            
            if ($no > 0) {
                $json.=", ";
            }

            $total = ( $v->harga * $v->qty) - (( $v->harga * $v->qty) * $v->disc/100) ;
            $subtotal = $subtotal+$total;
            $ppn = $ppn + ($total*10/100);

            $tppn = 0;
            $tgt = number_format($subtotal + $v->jasa, 0, ",", ".");

            $dt = array(
                    "id"        => $v->id,
                    "nama"      => $v->nama_produk,
                    "qty"       => number_format($v->qty, 0, ",", "."),
                    "harga"     => number_format($v->harga, 0, ",", "."),
                    "disc"      => $v->disc."%",
                    "total"     => number_format($total, 0, ",", "."),
                    "subtotal"  => number_format($subtotal, 0, ",", "."),
                    "ppn"       => $tppn,
                    "gtotal"    => $tgt,
                    "modal"     => number_format($v->modal, 0, ",", "."),
                    "merk"       => $v->merk,
                    "disc"      => $v->disc,
                    "jasa"      => number_format($v->jasa, 0, ",", "."),
                    "idproduk"  => $v->titid,
                );

            $json.=json_encode($dt);
            $no++;

        }
        $json.="]";

        echo $json;
    }
    function edit_draft(){
        $id = $_POST["id"];


        $sl = "
            pitstop_penjualan_detail.*,
            pitstop_produk.id AS titid,
            pitstop_produk.nama_produk,
            pitstop_produk.idsatuan,
            pitstop_produk.merk,
            satuan.id AS satid,
            satuan.nama_satuan,
            pitstop_penjualan.no_trans,
            pitstop_penjualan.jasa,
            pitstop_penjualan.pembayaran,
            pitstop_penjualan.kendaraan,
            pitstop_penjualan.plat,
            pitstop_penjualan.idpelanggan,
            pitstop_pelanggan.id AS pelid,
            pitstop_pelanggan.nama_pelanggan
        ";
        $this->db->select($sl);
        $this->db->from("pitstop_penjualan_detail");
        $this->db->join("pitstop_produk", "pitstop_produk.id = pitstop_penjualan_detail.iditem");
        $this->db->join("satuan", "satuan.id = pitstop_produk.idsatuan");
        $this->db->join("pitstop_penjualan", "pitstop_penjualan.no_trans = pitstop_penjualan_detail.no_trans");
        $this->db->join("pitstop_pelanggan", "pitstop_pelanggan.id = pitstop_penjualan.idpelanggan");
        $this->db->where("pitstop_penjualan_detail.no_trans", $id);
        $d = $this->db->get()->result();

        $json = "[";
        $no = 0;
        $subtotal = 0;
        $ppn = 0;
        foreach ($d as $v) {
            
            if ($no > 0) {
                $json.=", ";
            }

            $total = ( $v->harga * $v->qty) - (( $v->harga * $v->qty) * $v->disc/100) ;
            $subtotal = $subtotal+$total;
            $ppn = $ppn + ($total*10/100);

            $tppn = 0;
            $tgt = number_format($subtotal + $v->jasa, 0, ",", ".");

            $dt = array(
                    "id"        => $v->id,
                    "nama"      => $v->nama_produk,
                    "qty"       => number_format($v->qty, 0, ",", "."),
                    "harga"     => number_format($v->harga, 0, ",", "."),
                    "disc"      => $v->disc."%",
                    "total"     => number_format($total, 0, ",", "."),
                    "subtotal"  => number_format($subtotal, 0, ",", "."),
                    "ppn"       => $tppn,
                    "gtotal"    => $tgt,
                    "modal"     => number_format($v->modal, 0, ",", "."),
                    "merk"       => $v->merk,
                    "disc"      => $v->disc,
                    "jasa"      => number_format($v->jasa, 0, ",", "."),
                    "idproduk"  => $v->titid,
                    "idpelanggan" => $v->idpelanggan,
                    "nama_pelanggan" => $v->nama_pelanggan,
                    "plat"      => $v->plat,
                    "kendaraan" => $v->kendaraan,
                    "pembayaran" => $v->pembayaran
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
            $src_trans      = $_POST["src_trans"];
            $src_from       = $_POST["src_from"];
            $src_to         = $_POST["src_to"];
            $src_pelanggan  = $_POST["src_pelanggan"];
            $src_user       = $_POST["src_user"];
            $src_status     = $_POST["src_status"];
            $src_pembayaran = $_POST["src_pembayaran"];
            $src_lunas      = $_POST["src_lunas"];
            $src_plat       = $_POST["src_plat"];

            $list = $this->md->get_datatables($src_trans, $src_from, $src_to, $src_pelanggan, $src_plat, $src_pembayaran, $src_lunas, $src_status, $src_user);
            $data = array();
            $no = $_POST['start'];
            $gtotal = 0;

            foreach ($list as $v) {

                $sl = "
                    pitstop_penjualan_detail.id,
                    pitstop_penjualan_detail.harga,
                    pitstop_penjualan_detail.qty,
                    pitstop_penjualan_detail.disc,
                    pitstop_penjualan_detail.modal,
                    SUM( (pitstop_penjualan_detail.harga * pitstop_penjualan_detail.qty) - (pitstop_penjualan_detail.harga * pitstop_penjualan_detail.qty)*pitstop_penjualan_detail.disc/100  ) AS total,
                    pitstop_penjualan.no_trans,
                    pitstop_penjualan.lunas,
                    pitstop_penjualan.status
                ";
                $this->db->select($sl);
                $this->db->from('pitstop_penjualan_detail');
                $this->db->join("pitstop_penjualan", "pitstop_penjualan.no_trans = pitstop_penjualan_detail.no_trans");
                $this->db->where("pitstop_penjualan_detail.no_trans", $v->no_trans);
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

                if ($v->no_trans=="TPSJ-181217003") {
                	$lt = number_format(20979000, 0, ",", ".");
                }
                else{
                	$lt = number_format($total["total"] + $v->jasa, 0, ",", ".");
                }

                $no++;
                $row = array();
                $row[] = "<center>".$no."</center>";
                $row[] = "<center>".$v->no_trans."</center>";
                $row[] = "<center>".date("d/m/Y H:i:s", strtotime($v->created_on))."</center>";
                $row[] = $v->nama_pelanggan;
                $row[] = "<center>".$v->plat."<br>(".$v->kendaraan.")</center>";
                $row[] = "<p style='text-align:right'>".number_format($total["total"] + $v->jasa, 0, ",", ".")."</p>";
                $row[] = $v->pembayaran;
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
                $row[] = $this->md->get_total($src_trans, $src_from, $src_to, $src_pelanggan, $src_plat, $src_pembayaran, $src_lunas, $src_status, $src_user);
     
                $data[] = $row;
            }
     
            $output = array(
                            "draw"              => $_POST['draw'],
                            "recordsTotal"      => $this->md->count_all(),
                            "recordsFiltered"   => $this->md->count_filtered($src_trans, $src_from, $src_to, $src_pelanggan, $src_plat, $src_pembayaran, $src_lunas, $src_status, $src_user),
                            "data"              => $data,
                    );
            //output to json format
            echo json_encode($output);
    } 

	
}
