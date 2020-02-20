<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class pembelian extends CI_Controller {

    function __construct(){
        parent::__construct();
        date_default_timezone_set("Asia/Jakarta");
        $this->load->model('pitstop/Pembelian_model','md');
        $this->load->model("Lnd_model", "lnd");


       if(!$this->session->userdata('lnd_id'))
       {
        	redirect('login');
       }
    }

	public function index(){        

        $this->lnd->akses("pitstop/pembelian", "submenu");

		$data["page"]	  = "pitstop_pembelian";
        $data["menu"]     = "transaksi";
        $data["submenu"]  = "pitstop_pembelian";
		$this->load->view('main', $data);
		
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
 
            $objget->setTitle('PEMBELIAN'); //sheet title
            //Warna header tabel

            $objget->setCellValueByColumnAndRow(0, 1, "LAPORAN PEMBELIAN PIT STOP");            
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

            $src_po         = $_GET['src_po'];
            $src_from       = $_GET['src_from'];
            $src_to         = $_GET['src_to'];
            $src_supplier   = $_GET['src_supplier'];
            $src_user       = $_GET['src_user'];
            $src_status     = "";

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


            $objget->getStyle("A4:K4")->applyFromArray(
                array(
                    'fill' => array(
                        'type' => PHPExcel_Style_Fill::FILL_SOLID,
                        'color' => array('rgb' => 'd4adff')
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
            $cols    = array("A","B","C","D","E","F","G","H","I", "J", "K");
            $val   = array("NO ","TGL","NO INV", "VENDOR", "PRODUK", "QTY", "HARGA BELI", "DISC %", "SUBTOTAL", "PPN", "TOTAL");

            for ($a=0;$a<11; $a++) 
            {
                $objset->setCellValue($cols[$a].'4', $val[$a]);
                 
                //Setting lebar cell
                $objset->getColumnDimension('A')->setWidth(5); 
                $objset->getColumnDimension('B')->setWidth(10); 
                $objset->getColumnDimension('C')->setWidth(15);
                $objset->getColumnDimension('D')->setWidth(30);
                $objset->getColumnDimension('E')->setWidth(40);
                $objset->getColumnDimension('F')->setWidth(7); 
                $objset->getColumnDimension('G')->setWidth(15);
                $objset->getColumnDimension('H')->setWidth(7);
                $objset->getColumnDimension('I')->setWidth(15);
                $objset->getColumnDimension('J')->setWidth(15);
                $objset->getColumnDimension('K')->setWidth(15);


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



            $list       = $this->md->laporan($src_po, $src_from, $src_to, $src_supplier, $src_user, $src_status);
            $no         = 1;
            $ak_total   = 0;
            $ak_jasa    = 0;
            $ak_gt      = 0;

            foreach ($list as $v){
                 
               //pemanggilan sesuaikan dengan nama kolom tabel
                $objset->setCellValue("A".$baris, $no); 
                $objset->setCellValue("B".$baris, date("d/m/Y", strtotime($v->created_on)) );
                $objset->setCellValue("C".$baris, $v->no_inv );
                $objset->setCellValue("D".$baris, $v->nama_supplier );

                $sl = "
                    pitstop_pembelian_detail.*,
                    pitstop_produk.id AS titid,
                    pitstop_produk.nama_produk,
                    pitstop_produk.idsatuan,
                    pitstop_produk.merk,
                    satuan.id AS satid,
                    satuan.nama_satuan,
                    pitstop_pembelian.no_trans,
                    pitstop_pembelian.tgl_inv,
                    pitstop_pembelian.no_inv,
                    pitstop_pembelian.ppn
                ";
                $this->db->select($sl);
                $this->db->from("pitstop_pembelian_detail");
                $this->db->join("pitstop_produk", "pitstop_produk.id = pitstop_pembelian_detail.iditem");
                $this->db->join("satuan", "satuan.id = pitstop_produk.idsatuan");
                $this->db->join("pitstop_pembelian", "pitstop_pembelian.no_trans = pitstop_pembelian_detail.no_trans");
                $this->db->where("pitstop_pembelian_detail.no_trans", $v->no_trans);
                $det = $this->db->get()->result();

                $baris2 = $baris;
                $nod = 0;
                $nod2 = 0;
                $ttl = 0;
                foreach ($det as $vdet) {

                    $dlen = strlen($vdet->nama_produk);
                    $bts = 46;
                    $cl = ceil($dlen / $bts);


                    $baris3 = $baris2;
                    $ex = 0;
                    $nod3 = 0;
                    for($d = 1;$d<=$cl;$d++){
                        $objset->setCellValue("E".$baris3, substr($vdet->nama_produk, $ex,45) );
                        $baris3++;
                        $nod2++;
                        $nod3++;
                        $ex = $ex+45;
                    }

                    $pot1 = ( ( $vdet->harga *$vdet->qty)*$vdet->disc/100 );
                    $total1 = ($vdet->harga*$vdet->qty) - $pot1;
                    $ppn1 = $total1 *10/100;

                    $objset->setCellValue("F".$baris2, $vdet->qty );
                    $objset->setCellValue("G".$baris2, $vdet->harga );
                    $objset->setCellValue("H".$baris2, $vdet->disc );
                    $objset->setCellValue("I".$baris2, $total1);
                    if ($v->ppn=="Y") {
                        $objset->setCellValue("J".$baris2, $ppn1);
                        $objset->setCellValue("K".$baris2, $total1+$ppn1);
                        $ak_ppn = $ak_ppn + $ppn1;
                        $ak_gt = $ak_gt + ($total1+$ppn1);
                        
                        $ttl = $ttl + ($total1+$ppn1);
                    }
                    else{
                        $ak_ppn = $ak_ppn + 0;
                        $ak_gt = $ak_gt + ($total1);
                        $objset->setCellValue("J".$baris2, "0");
                        $objset->setCellValue("K".$baris2, $total1);
                        $ttl = $ttl + $total1;
                    }
                    $baris2 = $baris2 + $nod3;
                    $nod++;

                    $ak_total = $ak_total + $total1;

                }

                $tbaris = $baris + $nod2;
                $objset->setCellValue("K".$tbaris, $ttl);
                $style_total = array(
                        'font' => array(
                            'size'  => 9,
                            'bold'  => true
                        ),
                    );
                $objset->getStyle("K".$tbaris)->applyFromArray($style_total);


                //$objset->setCellValue("I".$baris, $v->no_trans );
                 
                //Set number value
                //$objPHPExcel->getActiveSheet()->getStyle('C1:C'.$baris)->getNumberFormat()->setFormatCode('0');
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
                $objPHPExcel->getActiveSheet()->getStyle("A5:A".$baris3)->applyFromArray($style_no);
                $objPHPExcel->getActiveSheet()->getStyle("B5:B".$baris3)->applyFromArray($style_no);
                $objPHPExcel->getActiveSheet()->getStyle("C5:C".$baris3)->applyFromArray($style_no);
                $objPHPExcel->getActiveSheet()->getStyle("D5:D".$baris3)->applyFromArray($style_row);
                $objPHPExcel->getActiveSheet()->getStyle("E5:E".$baris3)->applyFromArray($style_row);
                $objPHPExcel->getActiveSheet()->getStyle("F5:F".$baris3)->applyFromArray($style_no);
                $objPHPExcel->getActiveSheet()->getStyle('F5:F'.$baris3)->getNumberFormat()->setFormatCode("#,##0");
                $objPHPExcel->getActiveSheet()->getStyle("G5:G".$baris3)->applyFromArray($style_row);
                $objPHPExcel->getActiveSheet()->getStyle('G5:G'.$baris3)->getNumberFormat()->setFormatCode("#,##0");
                $objPHPExcel->getActiveSheet()->getStyle("H5:H".$baris3)->applyFromArray($style_row);
                $objPHPExcel->getActiveSheet()->getStyle('H5:H'.$baris3)->getNumberFormat()->setFormatCode("#,##0");
                $objPHPExcel->getActiveSheet()->getStyle("I5:I".$baris3)->applyFromArray($style_row);
                $objPHPExcel->getActiveSheet()->getStyle('I5:I'.$baris3)->getNumberFormat()->setFormatCode("#,##0");
                $objPHPExcel->getActiveSheet()->getStyle("J5:J".$baris3)->applyFromArray($style_row);
                $objPHPExcel->getActiveSheet()->getStyle('J5:J'.$baris3)->getNumberFormat()->setFormatCode("#,##0");
                $objPHPExcel->getActiveSheet()->getStyle("K5:K".$baris3)->applyFromArray($style_row);
                $objPHPExcel->getActiveSheet()->getStyle('K5:K'.$baris3)->getNumberFormat()->setFormatCode("#,##0");

                 
                $baris = $baris + $nod2+1;
                $no++;
            }
                  
            $objget->mergeCells('A'.$baris.':H'.$baris);
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
            $objset->getStyle('A'.$baris.':H'.$baris)->applyFromArray($style_gt);

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
            $objset->getStyle("I".$baris)->applyFromArray($style_gtotal);
            $objset->getStyle('I'.$baris)->getNumberFormat()->setFormatCode("#,##0");
            $objset->getStyle("J".$baris)->applyFromArray($style_tax);
            $objset->getStyle('J'.$baris)->getNumberFormat()->setFormatCode("#,##0");
            $objset->getStyle("K".$baris)->applyFromArray($style_gtotal);
            $objset->getStyle('K'.$baris)->getNumberFormat()->setFormatCode("#,##0");

            $objset->setCellValue("I".$baris, $ak_total);
            $objset->setCellValue("J".$baris, $ak_ppn);
            $objset->setCellValue("K".$baris, $ak_gt);

            //========================== SHEET 2 ===========================================================//

            /*
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
            */


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
            po_out.*
        ";
        $this->db->select($sl);
        $this->db->from("po_out");
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

        $session_no = count($_SESSION['pit_pmb']);
        $no_item    = $session_no+1;

        $id     = $_POST["id"];
        $harga  = str_replace(".","",$_POST["harga"]);
        $hrg    = str_replace(",",".",$harga);
        $qty    = str_replace(".","",$_POST["qty"]);
        $satuan = $_POST["satuan"];
        if ($_POST["disc"]=="") {
        	$disc = 0;
        }
        else{
        	$disc = $_POST['disc'];
        }
        

        $this->db->where("id", $id);
        $d = $this->db->get("pitstop_produk")->row_array();

        $merk = $d["merk"];

        if ($session_no!=0) {
            for($i=1;$i<=$session_no;$i++){

                if ($_SESSION['pit_pmb'][$i][0] == $id) {
                    $mqty       = $qty + $_SESSION['pit_pmb'][$i][1];
                    $sess_id    = $_SESSION['pit_pmb'][$i][2];
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


        $_SESSION['pit_pmb'][$sess_id][0]=$id; // idproduk
        $_SESSION['pit_pmb'][$sess_id][1]=$mqty; //qty
        $_SESSION['pit_pmb'][$sess_id][2]=$sess_id; //session id
        $_SESSION['pit_pmb'][$sess_id][3]=$hrg; //harga
        $_SESSION['pit_pmb'][$sess_id][4]=$merk; //satuan
        $_SESSION['pit_pmb'][$sess_id][5]=$disc; //satuan

        echo "1";

    }


    public function del(){

        $id = $_POST["id"];

        unset($_SESSION['pit_pmb'][$id][0]);
        unset($_SESSION['pit_pmb'][$id][1]);
        unset($_SESSION['pit_pmb'][$id][2]);
        unset($_SESSION['pit_pmb'][$id][3]);
        unset($_SESSION['pit_pmb'][$id][4]);
        unset($_SESSION['pit_pmb'][$id][5]);

    }

    function save(){
        error_reporting(0);

        $no_trans   = $_POST["no_trans"];
        $user       = $this->lnd->me();
        $pelanggan  = $_POST["supplier"];
        $inv       	= $_POST["inv"];
        $tgl_inv    = $_POST["tgl_inv"];
        $cek_ppn 	= $_POST["cek_ppn"];

        $this->db->where("no_trans", $no_trans);
        $c = $this->db->get("pitstop_pembelian")->num_rows();

        if ($c==0) {
            $no_po = $no_trans;
        }
        else{
            $no_po = $no_trans.rand(0,999);
        }

        $session_no = count($_SESSION['pit_pmb']);

        $dt = array(
                "no_trans"          => $no_po,
                "created_by"        => $user["username"],
                "idsupplier"        => $pelanggan,
                "no_inv"           	=> $inv,
                "tgl_inv"          	=> $tgl_inv,
                "ppn"               => $cek_ppn,
                "created_on"        => date("Y-m-d H:i:s")
            );
        $dt_act = array(
            "deskripsi"         => $user["nama"]." telah menambah data Pembelian Pit Stop ".$no_trans.".",
            "jenis_aktivitas"   => "TAMBAH",
            "divisi"			=> "pitstop",
            "iduser"            => $user['username'],
            "tgl"               => date("Y-m-d H:i:s")
        );
        $this->db->trans_start();

            $this->db->insert("pitstop_pembelian", $dt);


            for($i=1;$i<=$session_no;$i++){
                if ($_SESSION['pit_pmb'][$i][2]!="") {


                	$dt_modal = array(
                			"modal"		=> $_SESSION['pit_pmb'][$i][3],
                			"harga"		=> $_SESSION['pit_pmb'][$i][3] + ($_SESSION['pit_pmb'][$i][3] * 35/100)
                		);
                	//$this->db->where("id", $_SESSION['pit_pmb'][$i][0]);
                	//$this->db->update("pitstop_produk", $dt_modal);

                	$this->db->where("idproduk", $_SESSION['pit_pmb'][$i][0]);
                	$this->db->where("idgudang", "4");
                	$stok = $this->db->get("pitstop_stok")->row_array();

                	$dt_stok = array(
                			"qty"	=> $stok["qty"] + $_SESSION['pit_pmb'][$i][1]
                		);
                	$this->db->where("id", $stok["id"]);
                	$this->db->update("pitstop_stok", $dt_stok);

                    $this->db->where("idproduk", $_SESSION['pit_pmb'][$i][0]);
                    $this->db->where("created_on", date("Y-m-d"));
                    $this->db->order_by("created_on", "desc");
                    $this->db->limit(1);
                    $qks = $this->db->get("pitstop_kartu_stok");
                    $cks = $qks->num_rows();
                    $dks = $qks->row_array();

                    if ($cks == 0) {
                        $this->db->where("idproduk", $_SESSION['pit_pmb'][$i][0]);
                        $this->db->order_by("created_on", "desc");
                        $this->db->limit(1);
                        $ks = $this->db->get("pitstop_kartu_stok")->row_array();
                        $dtks = array(
                                "idproduk"  => $_SESSION['pit_pmb'][$i][0],
                                "jual"      => "0",
                                "beli"      => $_SESSION['pit_pmb'][$i][1],
                                "stok"      => $ks["stok"] + $_SESSION['pit_pmb'][$i][1],
                                "created_on"    => date("Y-m-d")
                            );
                        $this->db->insert("pitstop_kartu_stok", $dtks);
                    }
                    else{
                        $dtks = array(
                                "idproduk"  => $_SESSION['pit_pmb'][$i][0],
                                "jual"      => $dks["jual"],
                                "beli"      => $dks["beli"] + $_SESSION['pit_pmb'][$i][1],
                                "stok"      => $dks["stok"] + $_SESSION['pit_pmb'][$i][1]
                            );

                        $this->db->where("id", $dks["id"]);
                        $this->db->update("pitstop_kartu_stok", $dtks);
                    }


                    $dt2 = array(
                            "iditem"        => $_SESSION['pit_pmb'][$i][0],
                            "harga"         => $_SESSION['pit_pmb'][$i][3],
                            "no_trans"      => $no_po,
                            "disc"			=> $_SESSION['pit_pmb'][$i][5],
                            "qty"           => $_SESSION['pit_pmb'][$i][1],
                        );

                    $this->db->insert("pitstop_pembelian_detail", $dt2);
                        
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
        $this->session->unset_userdata('pit_pmb');
    }
    public function des2(){
        $this->session->unset_userdata('q2');
    }
    public function data_item(){
        error_reporting(0);

        $session_no = count($_SESSION['pit_pmb']);
        $json = "[";
        $no = 1;
        $vpot = 0;
        for($i=1;$i<=$session_no;$i++){



            if ($_SESSION['pit_pmb'][$i][2]!="") {
                if ($no>1) {
                    $json.=",";
                }
                $this->db->join("satuan", "satuan.id = pitstop_produk.idsatuan");
                $this->db->where("pitstop_produk.id", $_SESSION['pit_pmb'][$i][0]);
                $produk = $this->db->get("pitstop_produk")->row_array();


                $dt = array(
                        "id_produk"     => $_SESSION['pit_pmb'][$i][0],
                        "nama_item"     => $produk["nama_produk"],
                        "qty"           => $_SESSION['pit_pmb'][$i][1],
                        "harga"         => $_SESSION['pit_pmb'][$i][3],
                        "netto"         => ($_SESSION['pit_pmb'][$i][3] * $_SESSION['pit_pmb'][$i][1]) - (($_SESSION['pit_pmb'][$i][3] * $_SESSION['pit_pmb'][$i][1])*$_SESSION['pit_pmb'][$i][5]/100) ,
                        "brutto"        => ($_SESSION['pit_pmb'][$i][3] * $_SESSION['pit_pmb'][$i][1]),
                        "id"            => $_SESSION['pit_pmb'][$i][2],
                        "pot"           => "0",
                        "total_item"    => $no,
                        "satuan"        => $produk["nama_satuan"],
                        "merk"          => $produk["merk"],
                        "disc"          => $_SESSION['pit_pmb'][$i][5],

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
        $this->db->where("YEAR(created_on)", date("Y"));
        $this->db->order_by("created_on", "desc");
        $q = $this->db->get("pitstop_pembelian");
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
                "no_trans"  =>"TPSB-".date("ym").sprintf("%03d", $digit+1)
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
            po_out.*,
            supplier.id AS supid,
            supplier.nama_supplier,
            supplier.alamat,
            supplier.telp,
            user.username,
            user.nama,
            user.ttd
        ";
        $this->db->select($sl1);
        $this->db->from("po_out");
        $this->db->join("supplier", "supplier.id = po_out.idsupplier");
        $this->db->join("user", "user.username = po_out.created_by");
        $this->db->where("po_out.no_trans", $no);
        $h = $this->db->get()->row_array();


        $this->load->library('pdf');
        //$this->load->library('pdf_gradient');

        $pdf = new FPDF('p','mm', "A4");
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
        $pdf->Cell(168,5,'Jl. Tirtasari Selatan No.10',0,1,'L');

        $pdf->SetXY(23, 60);
        $pdf->Cell(168,5,'Bandung 40151',0,1,'L');

        $pdf->SetXY(23, 65);
        $pdf->Cell(168,5,'022 202 71122',0,1,'L');

        $pdf->SetXY(23, 70);
        $pdf->Cell(168,5,'info@cbtekno.com',0,1,'L');

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
        $pdf->MultiCell(55,5, $h['alamat'],0,'L');

        $pdf->SetXY(120, 80);
        $pdf->MultiCell(168,5, "PT. CHAKRA BASKARA TEKNO",0,'L');
        $pdf->SetXY(120, 85);
        $pdf->MultiCell(50,5, "Jl. Tirtasari Selatan No.10",0,'L');
        $pdf->SetXY(120, 90);
        $pdf->MultiCell(50,5, "Bandung 40151",0,'L');
        $pdf->SetXY(120, 95);
        $pdf->MultiCell(50,5, "022 202 71122",0,'L');

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
        $pdf->Cell(65,5,'DESCRIPTION',1,1,'C', true);

        $pdf->SetXY(135, 120);
        $pdf->Cell(25,5,'UNIT PRICE',1,1,'C', true);

        $pdf->SetXY(160, 120);
        $pdf->Cell(30,5,'LINE TOTAL',1,1,'C', true);

        $pdf->SetFillColor(255,255,255);
        $pdf->SetFont('Arial','',8);
        $pdf->SetDrawColor(51, 125, 178);

        $sl2 = "
            po_out_detail.*,
            produk.id AS produkid,
            produk.nama_produk,
            produk.deskripsi
        ";
        $this->db->select($sl2);
        $this->db->from("po_out_detail");
        $this->db->join("produk", "produk.id = po_out_detail.iditem");
        $this->db->where("no_trans", $no);
        $i = $this->db->get()->result();

        $line = 125;
        $subtotal = 0;
        $rs = 0;
        $xp = "";
        $ds = 0;
        foreach ($i as $vi) {
            $bts = 40;
            $char = strlen($vi->deskripsi." ".$vi->ket);
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
            $pdf->MultiCell(30,$hd, $vi->nama_produk,1,'C', true);

            $pdf->SetXY(73, $line);
            $pdf->MultiCell(62,5, $vi->deskripsi." ".$vi->ket,1,'L', true);

            $pdf->SetXY(135, $line);
            $pdf->Cell(25,$hd, number_format($vi->harga,0,',','.'),1,1,'R', true);

            $pdf->SetFillColor(210,221,242);
            $pdf->SetXY(160, $line);
            $pdf->Cell(30,$hd, number_format( ($vi->qty*$vi->harga) ,0,',','.'),1,1,'R', true);

            $line = $line +$hd;

            //$subtotal = $subtotal + (($vi->harga*$vi->qty) - ( ($vi->harga*$vi->qty) *$vi->disc/100));
            $subtotal = $subtotal + (($vi->harga*$vi->qty));
            $ds = $ds + ( ($vi->harga*$vi->qty) * $vi->disc/100 );

        }
        
        for($s = 1; $s <= (12-$rs);$s++){

            $pdf->SetFillColor(255,255,255);        
            $pdf->SetXY(23, $line);
            $pdf->Cell(20,5, "",1,1,'C', true);

            $pdf->SetXY(43, $line);
            $pdf->MultiCell(30,5, "",1,'C', true);

            $pdf->SetXY(73, $line);
            $pdf->MultiCell(62,5, "",1,'L', true);

            $pdf->SetXY(135, $line);
            $pdf->Cell(25,5, "",1,1,'R', true);

            $pdf->SetFillColor(210,221,242);
            $pdf->SetXY(160, $line);
            $pdf->Cell(30,5, "",1,1,'R', true);


            $line = $line + 5;
        }
        
        if ($h["ppn"] == "Y") {
            $tax = ($subtotal - $ds) * 10/100;
        }
        else{
            $tax = 0;
        }


        $pdf->SetFont('Arial','',9);
        $pdf->SetDrawColor(51, 125, 178);
        $pdf->SetFillColor(255,255,255);        
        $pdf->SetXY(23, $line);
        $pdf->Cell(100,62, '',1,1,'C', true);

        $pdf->SetXY(24, $line+1);
        $pdf->Cell(50,5, "NOTE : ",0,0,'L', true);

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
        $pdf->Cell(35,5, 'DISCOUNT',0,1,'R', true);

        $pdf->SetXY(124, $line+11);
        $pdf->Cell(35,5, '',0,1,'R', true);

        $pdf->SetXY(124, $line+16);
        $pdf->Cell(35,5, 'TAX',0,1,'R', true);

        $pdf->SetXY(124, $line+21);
        $pdf->Cell(35,5, 'TOTAL',0,1,'R', true);

        $pdf->SetFillColor(210,221,242);
        $pdf->SetXY(160, $line);
        $pdf->Cell(30,5, number_format($subtotal,0,',','.'),1,1,'R', true);

        $pdf->SetFillColor(210,221,242);
        $pdf->SetXY(160, $line+5);
        $pdf->Cell(30,5, number_format($ds,0,',','.'),1,1,'R', true);

        $pdf->SetFillColor(210,221,242);
        $pdf->SetXY(160, $line+10);
        $pdf->Cell(30,5, number_format($subtotal-$ds,0,',','.'),1,1,'R', true);

        $pdf->SetFillColor(255,255,255);
        $pdf->SetXY(160, $line+15);
        $pdf->Cell(30,5, number_format($tax,0,',','.'),1,1,'R', true);

        $pdf->SetFillColor(210,221,242);
        $pdf->SetXY(160, $line+20);
        $pdf->Cell(30,5, number_format(($subtotal-$ds) +$tax,0,',','.'),1,1,'R', true);

        $pdf->SetFillColor(255,255,255);
        $pdf->SetXY(123, $line+30);
        $pdf->Cell(67,7, "",1,1,'R', true);

        $pdf->SetXY(124, $line+31);
        $pdf->Cell(30,5, "Authorized By : ",0,1,'L', true);

        $pdf->SetXY(160, $line+31);
        $pdf->Cell(28,5, "Prepare By : ",0,1,'L', true);

        $pdf->SetXY(123, $line+37);
        $pdf->Cell(35,25, "",1,1,'L', true);

        $pdf->Image(base_url()."upload/ttd/cap_cb.png", 80, 220, 40,25);

        $pdf->SetXY(155, $line+37);
        $pdf->Cell(35,25, "",1,1,'L', true);

        $pdf->Image(base_url()."upload/ttd/ttd_bos.png", 125, 225, 25,15);
        $pdf->SetXY(124, $line+55);
        $pdf->Cell(10,5, "Firman N",0,1,'L', true);

        $nama = explode(" ", $h['nama']);
        $pdf->Image(base_url()."upload/ttd/".$h['ttd'], 160, 225, 25,15);
        $pdf->SetXY(156, $line+55);
        $pdf->Cell(33,5, $nama[0],0,1,'C', true);
        
        $pdf->Output();
    }

    function detail(){
        $id = $_POST["id"];


        $sl = "
            pitstop_pembelian_detail.*,
            pitstop_produk.id AS titid,
            pitstop_produk.nama_produk,
            pitstop_produk.idsatuan,
            pitstop_produk.merk,
            satuan.id AS satid,
            satuan.nama_satuan,
            pitstop_pembelian.no_trans,
            pitstop_pembelian.tgl_inv,
            pitstop_pembelian.no_inv,
            pitstop_pembelian.ppn
        ";
        $this->db->select($sl);
        $this->db->from("pitstop_pembelian_detail");
        $this->db->join("pitstop_produk", "pitstop_produk.id = pitstop_pembelian_detail.iditem");
        $this->db->join("satuan", "satuan.id = pitstop_produk.idsatuan");
        $this->db->join("pitstop_pembelian", "pitstop_pembelian.no_trans = pitstop_pembelian_detail.no_trans");
        $this->db->where("pitstop_pembelian_detail.no_trans", $id);
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

            if ($v->ppn=="Y") {
                $tppn = number_format($ppn, 0, ",", ".");
                $tgt = number_format($ppn+$subtotal, 0, ",", ".");
            }
            else{
                $tppn = 0;
                $tgt = number_format($subtotal, 0, ",", ".");
            }

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
                    "inv"    	=> $v->no_inv,
                    "merk" 		=> $v->merk,
                    "disc"      => $v->disc,
                    "idproduk"  => $v->titid,
                );

            $json.=json_encode($dt);
            $no++;

        }
        $json.="]";

        echo $json;
    }

    function rev_item(){
        $id     = $_POST["id"];
        $qty    = $_POST["qty"];
        $jual   = str_replace(".","",$_POST["harga"]);
        $disc   = $_POST["disc"];
        $idproduk = $_POST['idproduk'];
        $ket_rev  = $_POST["ket_rev"];
        $estimasi = $_POST['estimasi'];

        $dt = array(
                "qty"   => $qty,
                "harga" => $jual,
                "disc"  => $disc,
                "ket_revisi"    => $ket_rev,
                "estimasi"  => $estimasi
            );

        $this->db->trans_start();

            $this->db->where("id", $id);
            $this->db->update("po_out_detail", $dt);

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
    function save_rev(){
        $id     = $_POST["no_trans"];
        $kode    = strtoupper($_POST["kode"]);
        //$ket_rev = $_POST["ket_rev"];
        $user = $this->lnd->me();
        $dt = array(
                "revisi"   => $kode,
                "updated_by"    => $user['username'],
                "updated_on"    => date("Y-m-d H:i:s")
            );

        $this->db->where("revisi", $kode);
        $this->db->where("no_trans", $id);
        $c = $this->db->get("po_out")->num_rows();

        /*
        if ($c==0) {
            
            
        }
        else{
            echo "0.1";
        }*/
        $dt_act = array(
            "deskripsi"         => $user["nama"]." telah merevisi data PO Out ".$id." menjadi ".$id.$kode.".",
            "jenis_aktivitas"   => "EDIT",
            "iduser"            => $user['username'],
            "tgl"               => date("Y-m-d H:i:s")
        );
        $this->db->trans_start();

            $this->db->where("no_trans", $id);
            $this->db->update("po_out", $dt);

            $this->db->insert("aktivitas", $dt_act);

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
                    pitstop_pembelian_detail.id,
                    pitstop_pembelian_detail.harga,
                    pitstop_pembelian_detail.qty,
                    pitstop_pembelian_detail.disc,
                    SUM( (pitstop_pembelian_detail.harga * pitstop_pembelian_detail.qty) - ( (pitstop_pembelian_detail.harga * pitstop_pembelian_detail.qty) * pitstop_pembelian_detail.disc/100) ) AS total
                ";
                $this->db->select($sl);
                $this->db->from('pitstop_pembelian_detail');
                $this->db->where("pitstop_pembelian_detail.no_trans", $v->no_trans);
                $total = $this->db->get()->row_array();

                
                $gt = $total['total'];
                $gtotal = $gtotal + $total["total"];
                $no++;
                $row = array();
                $row[] = "<center>".$no."</center>";
                $row[] = "<center>".$v->no_trans."</center>";
                $row[] = "<center>".date("d/m/Y", strtotime($v->tgl_inv))."</center>";
                $row[] = $v->nama_supplier;
                $row[] = "<p style='text-align:right'>".number_format($gt, 0, ",", ".")."</p>";
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
                                        <a href='javascript:;' onclick='detail(\"".$v->no_trans."\")' data-toggle='modal' data-target='#md-det'>
                                            <i class='fa fa-clipboard fa-lg'></i> Detail
                                        </a>
                                    </li>
                                </ul>
                            </li>
                            </center>
                        ";
                $row[] = $this->md->get_total($src_po, $src_from, $src_to, $src_supplier, $src_user, $src_status);
     
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
