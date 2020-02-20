<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class po_out_lama extends CI_Controller {

    function __construct(){
        parent::__construct();
        date_default_timezone_set("Asia/Jakarta");
        $this->load->model('Po_out_model','md');
        $this->load->model("Lnd_model", "lnd");


       if(!$this->session->userdata('lnd_id'))
       {
        	redirect('login');
       }
    }

	public function index(){        

        $this->lnd->akses("po_out_lama", "submenu");

		$data["page"]	  = "po_out_lama";
        $data["menu"]     = "transaksi_lama";
        $data["submenu"]  = "po_out_lama";
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
 
            $objget->setTitle('Per Tanggal'); //sheet title
            //Warna header tabel

            $objget->setCellValueByColumnAndRow(0, 1, "LAPORAN PO OUT");            
            $objget->mergeCells('A1:N1');
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

            $src_po         = $_GET['src_po'];
            $src_from       = $_GET['src_from'];
            $src_to         = $_GET['src_to'];
            $src_supplier   = $_GET['src_supplier'];
            $src_user       = $_GET['src_user'];
            $src_status     = $_GET['src_status'];

            if ($src_from=="--" && $src_to=="--") {
                $tgl = "Semua Tanggal";
            }
            else{
                $tgl = date("d F Y", strtotime($src_from))." - ".date("d F Y", strtotime($src_to));
            }


            $objget->setCellValue("B2", $tgl);            
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


            $objget->getStyle("A4:M4")->applyFromArray(
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
            $cols    = array("A","B","C","D","E","F","G","H","I", "J", "K", "L", "M");
            $val   = array("NO ","TANGGAL","NO PO", "VENDOR", "DESCRIPTION", "ESTIMASI", "QTY", "HARGA", "DISCOUNT", "TOTAL", "PPN", "AMOUNT", "KETERANGAN");

            for ($a=0;$a<13; $a++) 
            {
                $objset->setCellValue($cols[$a].'4', $val[$a]);
                 
                //Setting lebar cell
                $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(5); 
                $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(10); 
                $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(30);
                $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(30);
                $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(40); 
                $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(10);
                $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(7);
                $objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(20);
                $objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(10);
                $objPHPExcel->getActiveSheet()->getColumnDimension('J')->setWidth(10);
                $objPHPExcel->getActiveSheet()->getColumnDimension('K')->setWidth(10);
                $objPHPExcel->getActiveSheet()->getColumnDimension('L')->setWidth(15);
                $objPHPExcel->getActiveSheet()->getColumnDimension('M')->setWidth(20);


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



            $list = $this->md->laporan_tgl($src_po, $src_from, $src_to, $src_supplier, $src_user, $src_status);
            $no = 1;
            $ak_total = 0;
            $ak_ppn   = 0;
            $ak_gt    = 0;

            foreach ($list as $v){
                 
               //pemanggilan sesuaikan dengan nama kolom tabel
                $objset->setCellValue("A".$baris, $no); 
                $objset->setCellValue("B".$baris, date("d/m/Y", strtotime($v->created_on)) );
                $objset->setCellValue("C".$baris, $v->no_trans );
                $objset->setCellValue("D".$baris, $v->nama_supplier );

                $sl = "
                    po_out_detail.*,
                    produk.id AS produkid,
                    produk.nama_produk,
                    produk.deskripsi,
                ";

                $this->db->select($sl);
                $this->db->from('po_out_detail');
                $this->db->join("produk", "produk.id = po_out_detail.iditem");
                $this->db->where("po_out_detail.no_trans", $v->no_trans);
                $det = $this->db->get()->result();

                $baris2 = $baris;
                $nod = 0;
                $nod2 = 0;
                $ttl = 0;
                foreach ($det as $vdet) {

                    $dlen = strlen($vdet->deskripsi." ".$vdet->ket);
                    $bts = 46;
                    $cl = ceil($dlen / $bts);


                    $baris3 = $baris2;
                    $ex = 0;
                    $nod3 = 0;
                    for($d = 1;$d<=$cl;$d++){
                        $objset->setCellValue("E".$baris3, substr($vdet->deskripsi." ".$vdet->ket, $ex,45) );

                        $baris3++;
                        $nod2++;
                        $nod3++;
                        $ex = $ex+45;
                    }



                    $pot1 = ( ($vdet->harga*$vdet->qty)*$vdet->disc/100 );
                    $total1 = ($vdet->harga*$vdet->qty) - $pot1;
                    $ppn1 = $total1 *10/100;

                    if ($vdet->estimasi=="0000-00-00") {
                        $dd = "";
                    }
                    else{
                        $dd = date("d/m/Y", strtotime($vdet->estimasi));
                    }

                    $objset->setCellValue("F".$baris2, $dd);
                    $objset->setCellValue("G".$baris2, $vdet->qty );
                    $objset->setCellValue("H".$baris2, $vdet->harga );
                    $objset->setCellValue("I".$baris2, $vdet->disc );
                    $objset->setCellValue("J".$baris2, $total1 );
                    
                    if ($v->ppn=="Y") {
                        $objset->setCellValue("K".$baris2, $ppn1);
                        $objset->setCellValue("L".$baris2, $total1+$ppn1);
                        $ak_ppn = $ak_ppn + $ppn1;
                        $ak_gt = $ak_gt + ($total1);
                        $ttl = $ttl + ($total1+$ppn1);
                    }
                    else{
                        $ak_ppn = $ak_ppn + 0;
                        $ak_gt = $ak_gt + ($total1+$ppn1);
                        $objset->setCellValue("K".$baris2, "0");
                        $objset->setCellValue("L".$baris2, $total1);
                        $ttl = $ttl + $total1;
                    }
                    $ak_total = $ak_total + $total1;

                    $objset->setCellValue("M".$baris2, "");

                    $baris2 = $baris2 + $nod3;
                    $nod++;
                    


                }

                $tbaris = $baris + $nod2;
                $objset->setCellValue("L".$tbaris, $ttl);
                $style_total = array(
                        'font' => array(
                            'size'  => 9,
                            'bold'  => true
                        ),
                    );
                $objset->getStyle("L".$tbaris)->applyFromArray($style_total);


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
                $objPHPExcel->getActiveSheet()->getStyle("G5:G".$baris3)->applyFromArray($style_row);
                $objPHPExcel->getActiveSheet()->getStyle("H5:H".$baris3)->applyFromArray($style_row);
                $objPHPExcel->getActiveSheet()->getStyle('H5:H'.$baris3)->getNumberFormat()->setFormatCode("#,##0");
                $objPHPExcel->getActiveSheet()->getStyle("I5:I".$baris3)->applyFromArray($style_row);
                $objPHPExcel->getActiveSheet()->getStyle("J5:J".$baris3)->applyFromArray($style_row);
                $objPHPExcel->getActiveSheet()->getStyle('J5:J'.$baris3)->getNumberFormat()->setFormatCode("#,##0");
                $objPHPExcel->getActiveSheet()->getStyle("K5:K".$baris3)->applyFromArray($style_row);
                $objPHPExcel->getActiveSheet()->getStyle('K5:K'.$baris3)->getNumberFormat()->setFormatCode("#,##0");
                $objPHPExcel->getActiveSheet()->getStyle("L5:L".$baris3)->applyFromArray($style_row);
                $objPHPExcel->getActiveSheet()->getStyle('L5:L'.$baris3)->getNumberFormat()->setFormatCode("#,##0");
                $objPHPExcel->getActiveSheet()->getStyle("M5:M".$baris3)->applyFromArray($style_row);
                $objPHPExcel->getActiveSheet()->getStyle('M5:M'.$baris3)->getNumberFormat()->setFormatCode("#,##0");



                 
                $baris = $baris + $nod2+1;
                $no++;
            }
                  
            $objget->mergeCells('A'.$baris.':I'.$baris);
            $objset->setCellValue("A".$baris, "GRAND TOTAL");
            //$objPHPExcel->getActiveSheet()->getStyle('A1:I1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
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
            $objPHPExcel->getActiveSheet()->getStyle('A'.$baris.':I'.$baris)->applyFromArray($style_gt);

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

            $objset->getStyle("L".$baris)->applyFromArray($style_tax);
            $objset->getStyle('L'.$baris)->getNumberFormat()->setFormatCode("#,##0");

            $objset->getStyle("M".$baris)->applyFromArray($style_gtotal);

            $objset->setCellValue("J".$baris, $ak_total);
            $objset->setCellValue("K".$baris, $ak_ppn);
            $objset->setCellValue("L".$baris, $ak_ppn+$ak_total);
            $objset->setCellValue("M".$baris,"");


            //Sheet 2
            $sheet2 = $objPHPExcel->createSheet();
            $sheet2->setTitle('Per Perusahaan');

            $sheet2->setCellValueByColumnAndRow(0, 1, "LAPORAN PO OUT");            
            $sheet2->mergeCells('A1:N1');
            $sheet2->getStyle('A1:N1')->applyFromArray($style_title);

            $sheet2->setCellValue("B2", $tgl);            
            $sheet2->mergeCells('B2:C2');
            $sheet2->getStyle('B2:C2')->applyFromArray($style_date);

            $sheet2->setCellValue("B2", $tgl);            
            $sheet2->mergeCells('B2:C2');
            //$objPHPExcel->getActiveSheet()->getStyle('A1:N1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
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
            $sheet2->getStyle('B2:C2')->applyFromArray($style_date);


            $sheet2->getStyle("A4:M4")->applyFromArray(
                array(
                    'fill' => array(
                        'type' => PHPExcel_Style_Fill::FILL_SOLID,
                        'color' => array('rgb' => 'ffc9c9')
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
            $cols    = array("A","B","C","D","E","F","G","H","I", "J", "K", "L", "M");
            $val   = array("NO ","TANGGAL","NO PO", "VENDOR", "DESCRIPTION", "ESTIMASI", "QTY", "HARGA", "DISCOUNT", "TOTAL", "PPN", "AMOUNT", "KETERANGAN");

            for ($a=0;$a<13; $a++) 
            {
                $sheet2->setCellValue($cols[$a].'4', $val[$a]);
                 
                //Setting lebar cell
                $sheet2->getColumnDimension('A')->setWidth(5); 
                $sheet2->getColumnDimension('B')->setWidth(10); 
                $sheet2->getColumnDimension('C')->setWidth(30);
                $sheet2->getColumnDimension('D')->setWidth(30);
                $sheet2->getColumnDimension('E')->setWidth(40); 
                $sheet2->getColumnDimension('F')->setWidth(10);
                $sheet2->getColumnDimension('G')->setWidth(7);
                $sheet2->getColumnDimension('H')->setWidth(20);
                $sheet2->getColumnDimension('I')->setWidth(10);
                $sheet2->getColumnDimension('J')->setWidth(10);
                $sheet2->getColumnDimension('K')->setWidth(10);
                $sheet2->getColumnDimension('L')->setWidth(15);
                $sheet2->getColumnDimension('M')->setWidth(20);


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
                $sheet2->getStyle($cols[$a].'4')->applyFromArray($style);
            }
            $sheet2->getRowDimension(4)->setRowHeight(40);

            //data
            $barisu  = 5;



            $listu = $this->md->laporan_user($src_po, $src_from, $src_to, $src_supplier, $src_user, $src_status, $src_bayar);
            $nou = 1;
            $ak_totalu= 0;
            $ak_ppnu   = 0;
            $ak_gtu    = 0;

            foreach ($listu as $vu){
                 
               //pemanggilan sesuaikan dengan nama kolom tabel
                $sheet2->setCellValue("A".$barisu, $nou); 
                $sheet2->setCellValue("B".$barisu, date("d/m/Y", strtotime($vu->created_on)) );
                $sheet2->setCellValue("C".$barisu, $vu->no_trans );
                $sheet2->setCellValue("D".$barisu, $vu->nama_supplier );

                $slu = "
                    po_out_detail.*,
                    produk.id AS produkid,
                    produk.nama_produk,
                    produk.deskripsi
                ";

                $this->db->select($slu);
                $this->db->from('po_out_detail');
                $this->db->join("produk", "produk.id = po_out_detail.iditem");
                $this->db->where("po_out_detail.no_trans", $vu->no_trans);
                $detu = $this->db->get()->result();

                $baris2u = $barisu;
                $nodu = 0;
                $nod2u = 0;
                $ttlu = 0;
                foreach ($detu as $vdetu) {

                    $dlenu = strlen($vdetu->deskripsi." ".$vdetu->ket);
                    $btsu = 46;
                    $clu = ceil($dlenu / $btsu);


                    $baris3u = $baris2u;
                    $exu = 0;
                    $nod3u = 0;
                    for($du = 1;$du<=$clu;$du++){
                        $sheet2->setCellValue("E".$baris3u, substr($vdetu->deskripsi." ".$vdetu->ket, $exu,45) );

                        $baris3u++;
                        $nod2u++;
                        $nod3u++;
                        $exu = $exu+45;
                    }

                    $pot1u = ( ($vdetu->harga*$vdetu->qty)*$vdetu->disc/100 );
                    $total1u = ($vdetu->harga*$vdetu->qty) - $pot1u;
                    $ppn1u = $total1u *10/100;

                    if ($vdetu->estimasi=="0000-00-00") {
                        $ddu = "";
                    }
                    else{
                        $ddu = date("d/m/Y", strtotime($vdetu->estimasi));
                    }

                    $sheet2->setCellValue("F".$baris2u, $ddu );
                    $sheet2->setCellValue("G".$baris2u, $vu->qty );
                    $sheet2->setCellValue("H".$baris2u, $vdetu->harga );
                    $sheet2->setCellValue("I".$baris2u, $vdetu->disc );
                    $sheet2->setCellValue("J".$baris2u, $total1u );
                    $ak_totalu = $ak_totalu + $total1u;
                    if ($vu->ppn=="Y") {
                        $sheet2->setCellValue("K".$baris2u, $ppn1u);
                        $sheet2->setCellValue("L".$baris2u, $total1u+$ppn1u);
                        $ak_ppnu = $ak_ppnu + $ppn1u;
                        $ak_gtu = $ak_gtu + ($total1u);
                        $ttlu = $ttlu + ($total1+$ppn1u);
                    }
                    else{
                        $ak_ppnu = $ak_ppnu + 0;
                        $ak_gtu = $ak_gt + ($total1+$ppn1);
                        $sheet2->setCellValue("K".$baris2u, "0");
                        $sheet2->setCellValue("L".$baris2u, $total1);
                        $ttlu = $ttlu + $total1u;
                    }
                    $sheet2->setCellValue("M".$baris2, "");
                    $baris2u = $baris2u + $nod3u;
                    $nodu++;
                    $ttlu = $ttlu + ($total1u+$ppn1u);



                }

                $tbarisu = $barisu + $nod2u;
                $sheet2->setCellValue("L".$tbarisu, $ttlu);
                $style_total = array(
                        'font' => array(
                            'size'  => 9,
                            'bold'  => true
                        ),
                    );
                $sheet2->getStyle("L".$tbarisu)->applyFromArray($style_total);


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
                $sheet2->getStyle("A5:A".$baris3u)->applyFromArray($style_no);
                $sheet2->getStyle("B5:B".$baris3u)->applyFromArray($style_no);
                $sheet2->getStyle("C5:C".$baris3u)->applyFromArray($style_no);
                $sheet2->getStyle("D5:D".$baris3u)->applyFromArray($style_row);
                $sheet2->getStyle("E5:E".$baris3u)->applyFromArray($style_row);
                $sheet2->getStyle("F5:F".$baris3u)->applyFromArray($style_no);
                $sheet2->getStyle("G5:G".$baris3u)->applyFromArray($style_row);
                $sheet2->getStyle("H5:H".$baris3u)->applyFromArray($style_row);
                $sheet2->getStyle('H5:H'.$baris3u)->getNumberFormat()->setFormatCode("#,##0");
                $sheet2->getStyle("I5:I".$baris3u)->applyFromArray($style_row);
                $sheet2->getStyle("J5:J".$baris3u)->applyFromArray($style_row);
                $sheet2->getStyle('J5:J'.$baris3u)->getNumberFormat()->setFormatCode("#,##0");
                $sheet2->getStyle("K5:K".$baris3u)->applyFromArray($style_row);
                $sheet2->getStyle('K5:K'.$baris3u)->getNumberFormat()->setFormatCode("#,##0");
                $sheet2->getStyle("L5:L".$baris3u)->applyFromArray($style_row);
                $sheet2->getStyle('L5:L'.$baris3u)->getNumberFormat()->setFormatCode("#,##0");
                $sheet2->getStyle("M5:M".$baris3u)->applyFromArray($style_row);
                $sheet2->getStyle('M5:M'.$baris3u)->getNumberFormat()->setFormatCode("#,##0");


                 
                $barisu = $barisu + $nod2u+1;
                $nou++;
            }
                  
            $sheet2->mergeCells('A'.$barisu.':I'.$barisu);
            $sheet2->setCellValue("A".$barisu, "GRAND TOTAL");
            //$objPHPExcel->getActiveSheet()->getStyle('A1:I1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
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
            $sheet2->getStyle('A'.$barisu.':I'.$barisu)->applyFromArray($style_gt);

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
            $sheet2->getStyle("J".$barisu)->applyFromArray($style_gtotal);
            $sheet2->getStyle('J'.$barisu)->getNumberFormat()->setFormatCode("#,##0");

            $sheet2->getStyle("K".$barisu)->applyFromArray($style_tax);
            $sheet2->getStyle('K'.$barisu)->getNumberFormat()->setFormatCode("#,##0");

            $sheet2->getStyle("L".$barisu)->applyFromArray($style_tax);
            $sheet2->getStyle('L'.$barisu)->getNumberFormat()->setFormatCode("#,##0");

            $sheet2->getStyle("M".$barisu)->applyFromArray($style_gtotal);

            $sheet2->setCellValue("J".$barisu, $ak_totalu);
            $sheet2->setCellValue("K".$barisu, $ak_ppnu);
            $sheet2->setCellValue("L".$barisu, $ak_totalu+$ak_ppnu);
            $sheet2->setCellValue("M".$barisu,"");


            $objPHPExcel->setActiveSheetIndex(0);
            $filename = urlencode("Laporan PO Out.xlsx");
               
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

        $session_no = count($_SESSION['poout_lama']);
        $no_item    = $session_no+1;

        $id     = $_POST["id"];
        $harga  = str_replace(".","",$_POST["harga"]);
        $qty    = str_replace(".","",$_POST["qty"]);
        $modal    = str_replace(".","",$_POST["modal"]);
        $satuan = $_POST["satuan"];
        $lead_time = $_POST["lead_time"];
        $ket = $_POST["ket"];
        $disc = $_POST['disc'];
        $estimasi = $_POST["estimasi"];

        if ($session_no!=0) {
            for($i=1;$i<=$session_no;$i++){

                if ($_SESSION['poout_lama'][$i][0] == $id) {
                    $mqty       = $qty + $_SESSION['poout_lama'][$i][1];
                    $sess_id    = $_SESSION['poout_lama'][$i][2];
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


        $_SESSION['poout_lama'][$sess_id][0]=$id; // idproduk
        $_SESSION['poout_lama'][$sess_id][1]=$mqty; //qty
        $_SESSION['poout_lama'][$sess_id][2]=$sess_id; //session id
        $_SESSION['poout_lama'][$sess_id][3]=$harga; //harga
        $_SESSION['poout_lama'][$sess_id][4]=$satuan; //satuan
        $_SESSION['poout_lama'][$sess_id][5]=$lead_time;
        $_SESSION['poout_lama'][$sess_id][6]=$modal;
        $_SESSION['poout_lama'][$sess_id][7]=$ket;
        $_SESSION['poout_lama'][$sess_id][8]=$disc;
        $_SESSION['poout_lama'][$sess_id][9]=$estimasi;

        echo "1";

    }


    public function del(){

        $id = $_POST["id"];

        unset($_SESSION['poout_lama'][$id][0]);
        unset($_SESSION['poout_lama'][$id][1]);
        unset($_SESSION['poout_lama'][$id][2]);
        unset($_SESSION['poout_lama'][$id][3]);
        unset($_SESSION['poout_lama'][$id][4]);
        unset($_SESSION['poout_lama'][$id][5]);
        unset($_SESSION['poout_lama'][$id][6]);
        unset($_SESSION['poout_lama'][$id][7]);
        unset($_SESSION['poout_lama'][$id][8]);
        unset($_SESSION['poout_lama'][$id][9]);

    }

    function save(){
        error_reporting(0);

        $no_trans   = "NOBIPO.".$_POST["no_trans"];
        $user       = $this->lnd->me();
        $pelanggan   = $_POST["supplier"];
        $quot       = $_POST["quot"];
        $cek_ppn = $_POST["cek_ppn"];
        $kode = $_POST["kode"];
        $tgl = $_POST["tgl"]." 00:00:00";
        $ket_rev = $_POST["ket_rev"];

        $this->db->where("no_trans", $no_trans);
        $c = $this->db->get("po_out")->num_rows();

        if ($c==0) {
            $no_po = $no_trans;
        }
        else{
            $no_po = $no_trans.rand(0,999);
        }

        $session_no = count($_SESSION['poout_lama']);

        $dt = array(
                "no_trans"          => $no_po,
                "created_by"        => $user["username"],
                "idsupplier"        => $pelanggan,
                "no_quot"           => $session_no,
                "ppn"               => $cek_ppn,
                "created_on"        => $tgl,
                "revisi"             => $kode,
                "ket_revisi"        => $ket_rev,
                "status"			=> "Lama"
            );
        $dt_act = array(
            "deskripsi"         => $user["nama"]." telah menambah data PO Out Lama ".$no_trans.".",
            "jenis_aktivitas"   => "TAMBAH",
            "iduser"            => $user['username'],
            "tgl"               => date("Y-m-d H:i:s")
        );


        $this->db->where("no_trans", $no_trans);
        $c = $this->db->get("po_out")->num_rows();

        if ($c==0) {
  
	        $this->db->trans_start();

	            $this->db->insert("po_out", $dt);


	            for($i=1;$i<=$session_no;$i++){
	                if ($_SESSION['poout_lama'][$i][2]!="") {

	                    $ppn = ($_SESSION['poout_lama'][$i][3]) - (($_SESSION['poout_lama'][$i][3]) * 10 / 100);
	                    $tax = ($_SESSION['poout_lama'][$i][3]) - $ppn;

	                    $dt2 = array(
	                            "iditem"        => $_SESSION['poout_lama'][$i][0],
	                            "harga"         => $_SESSION['poout_lama'][$i][3],
	                            "tax"           => $tax,
	                            "no_trans"      => $no_po,
	                            "modal"         => $_SESSION['poout_lama'][$i][6],
	                            "qty"           => $_SESSION['poout_lama'][$i][1],
	                            "ket"           => $_SESSION['poout_lama'][$i][7],
	                            "disc"          => $_SESSION['poout_lama'][$i][8],
	                            "estimasi"      => date("Y-m-d", strtotime($_SESSION['poout_lama'][$i][9]))
	                        );

	                    $this->db->insert("po_out_detail", $dt2);
	                        
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
        else{
        	echo "0.1";
        }
 


    }

    public function des(){
        $this->session->unset_userdata('poout_lama');
    }
    public function des2(){
        $this->session->unset_userdata('q2');
    }
    public function data_item(){
        error_reporting(0);

        $session_no = count($_SESSION['poout_lama']);
        $json = "[";
        $no = 1;
        $vpot = 0;
        for($i=1;$i<=$session_no;$i++){



            if ($_SESSION['poout_lama'][$i][2]!="") {
                if ($no>1) {
                    $json.=",";
                }
                $this->db->where("produk.id", $_SESSION['poout_lama'][$i][0]);
                $produk = $this->db->get("produk")->row_array();

                if ($produk["deskripsi"]==null) {
                    $desc = "";
                }
                else{
                    $desc = $produk["deskripsi"];
                }

                $dt = array(
                        "id_produk"     => $_SESSION['poout_lama'][$i][0],
                        "nama_item"     => $produk["nama_produk"],
                        "qty"           => $_SESSION['poout_lama'][$i][1],
                        "harga"         => $_SESSION['poout_lama'][$i][3],
                        "netto"         => ($_SESSION['poout_lama'][$i][3] * $_SESSION['poout_lama'][$i][1]) - (($_SESSION['poout_lama'][$i][3] * $_SESSION['poout_lama'][$i][1])*$_SESSION['poout_lama'][$i][8]/100) ,
                        "brutto"        => ($_SESSION['poout_lama'][$i][3] * $_SESSION['poout_lama'][$i][1]),
                        "id"            => $_SESSION['poout_lama'][$i][2],
                        "pot"           => "0",
                        "total_item"    => $no,
                        "satuan"        => $_SESSION['poout_lama'][$i][4],
                        "desc"          => $desc,
                        "modal"         => $_SESSION['poout_lama'][$i][6],
                        "lead_time"     => strtoupper($_SESSION['poout_lama'][$i][5]),
                        "ket"           => $_SESSION['poout_lama'][$i][7],
                        "disc"          => $_SESSION['poout_lama'][$i][8],
                        "estimasi"      => $_SESSION['poout_lama'][$i][9]

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
        $q = $this->db->get("po_out");
        $c = $q->num_rows();
        $v = $q->row_array();

        if ($c!=0) {
            $digit = substr($v["no_trans"], -4);
        }
        else{
            $digit = 0;
        }

        

        $d = json_encode(array(
                //"no_trans"  =>date("y").date("m").sprintf("%04d", $c+1)
                "no_trans"  =>"NOBIPO.".date("y").date("m").sprintf("%04d", $digit+1)
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
        foreach ($i as $vi) {
            $bts = 46;
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

            $subtotal = $subtotal + (($vi->harga*$vi->qty) - ( ($vi->harga*$vi->qty) *$vi->disc/100));
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

        $pdf->Image(base_url()."upload/ttd/cap_cb.png", 80, 210, 40,25);

        $pdf->SetXY(155, $line+27);
        $pdf->Cell(35,25, "",1,1,'L', true);

        $pdf->Image(base_url()."upload/ttd/ttd_bos.png", 125, 215, 25,15);
        $pdf->SetXY(124, $line+45);
        $pdf->Cell(10,5, "Firman N",0,1,'L', true);

        $nama = explode(" ", $h['nama']);
        $pdf->Image(base_url()."upload/ttd/".$h['ttd'], 160, 215, 25,15);
        $pdf->SetXY(156, $line+45);
        $pdf->Cell(33,5, $nama[0],0,1,'C', true);
        
        $pdf->Output();
    }

    function detail(){
        $id = $_POST["id"];


        $sl = "
            po_out_detail.*,
            produk.id AS titid,
            produk.nama_produk,
            produk.idsatuan,
            produk.deskripsi,
            satuan.id AS satid,
            satuan.nama_satuan,
            po_out.no_trans,
            po_out.untuk,
            po_out.revisi,
            po_out.ppn
        ";
        $this->db->select($sl);
        $this->db->from("po_out_detail");
        $this->db->join("produk", "produk.id = po_out_detail.iditem");
        $this->db->join("satuan", "satuan.id = produk.idsatuan");
        $this->db->join("po_out", "po_out.no_trans = po_out_detail.no_trans");
        $this->db->where("po_out_detail.no_trans", $id);
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

            if ($v->estimasi=="0000-00-00") {
                $est = "";
            }
            else{
                $est = date("d/m/Y", strtotime($v->estimasi));
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
                    "deskripsi" => $v->deskripsi,
                    "untuk"     => ucwords($v->untuk),
                    "modal"     => number_format($v->modal, 0, ",", "."),
                    "ket"       => $v->ket,
                    "revisi"    => $v->revisi,
                    "disc"      => $v->disc,
                    "idproduk"  => $v->titid,
                    "ket_revisi"    => $v->ket_revisi,
                    "estimasi"  => $est
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
                    po_out_detail.id,
                    po_out_detail.harga,
                    po_out_detail.qty,
                    po_out_detail.disc,
                    SUM( (po_out_detail.harga * po_out_detail.qty) - ( (po_out_detail.harga * po_out_detail.qty) * po_out_detail.disc/100) ) AS total
                ";
                $this->db->select($sl);
                $this->db->from('po_out_detail');
                $this->db->where("po_out_detail.no_trans", $v->no_trans);
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
                $no++;
                $row = array();
                $row[] = "<center>".$no."</center>";
                $row[] = "<center>".$v->no_trans.$v->revisi."</center>";
                $row[] = "<center>".date("d/m/Y H:i:s", strtotime($v->created_on))."</center>";
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
                                    <li>
                                        <a href='".base_url()."po_out/print_po/".$v->no_trans."' target='_blank'>
                                            <i class='fa fa-print fa-lg'></i> Print
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
