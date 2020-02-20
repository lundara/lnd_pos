<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class supplier extends CI_Controller {

    function __construct(){
        parent::__construct();
        date_default_timezone_set("Asia/Jakarta");
        $this->load->model('Supplier_model','md');



       if(!$this->session->userdata('lnd_id'))
       {
        	redirect('login');
       }
    }

	public function index(){        

		$data["page"]	  = "supplier";
        $data["menu"]     = "master_data";
        $data["submenu"]  = "supplier";
        $data["title"]    = "Supplier";
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
 
            $objget->setTitle('Data Vendor'); //sheet title
            //Warna header tabel

            $objget->setCellValueByColumnAndRow(0, 1, "DATA VENDOR");            
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
            $cols    = array("A","B","C","D", "E");
            $val   = array("NO ","NAMA VENDOR","TELP", "EMAIL", "ALAMAT");

            for ($a=0;$a<5; $a++) 
            {
                $objset->setCellValue($cols[$a].'4', $val[$a]);
                 
                //Setting lebar cell
                $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(5); 
                $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(10); 
                $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(20);
                $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(20);
                $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(30);


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


            $this->db->order_by("nama_supplier", "asc");
            $list = $this->db->get("supplier")->result();
            $no = 1;
            $ak_total = 0;
            $ak_ppn   = 0;
            $ak_gt    = 0;

            foreach ($list as $v){
                 
               //pemanggilan sesuaikan dengan nama kolom tabel
                $objset->setCellValue("A".$baris, $no); 
                $objset->setCellValue("B".$baris, $v->nama_supplier );
                $objset->setCellValue("C".$baris, $v->telp );
                $objset->setCellValue("D".$baris, $v->email );

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

    function gg(){
        $this->load->library('m_pdf');
        //now pass the data//
         $this->data['title']="MY PDF TITLE 1.";
         $this->data['description']="";
         $this->data['description']="adasw";
         //now pass the data //
 
        
        $html=$this->load->view('test',$this->data, true); //load the pdf_output.php by passing our data and get all data in $html varriable.
     
        //this the the PDF filename that user will get to download
        $pdfFilePath ="mypdfName-".time()."-download.pdf";
 
        
        //actually, you can pass mPDF parameter on this load() function
        $pdf = $this->m_pdf->load();
        //generate the PDF!
        $pdf->WriteHTML($html,2);
        //offer it to user via browser download! (The PDF won't be saved on your server HDD)
        $pdf->Output($pdfFilePath, "D");
    }

    function cetak(){
        $this->load->library('Tcpdf');

        $this->db->order_by("nama_supplier");
        $data["q"]  = $this->db->get("supplier")->result();

        $this->load->view("test", $data);
    }

    function cetak2(){
        $this->load->library('myPDF');
        //$this->load->library('pdf_gradient');

        $pdf = new myPDF('p','mm', "A4");
        // membuat halaman baru
        $pdf->AddPage();
        
        $pdf->SetTitle("Data Vendor");
        /*
        $pdf->SetFont('Arial','B',12);
        $pdf->Cell(190,10,'DATA VENDOR',0,1,'C');

        $pdf->Cell(190,15,'',0,1,'C');
        
        $pdf->SetFont('Arial','B',10);
        $pdf->Cell(15,10,'No.',1,0,'C');
        $pdf->Cell(60,10,'Nama Vendor',1,0,'C');
        $pdf->Cell(50,10,'Kontak',1,0,'C');
        $pdf->Cell(65,10,'Alamat',1,1,'C');

        $this->db->order_by("nama_supplier", "ASC");
        $d = $this->db->get("supplier")->result();
        $no = 1;
        foreach ($d as $v) {

            $len = strlen($v->alamat);
            $ceil = ceil($len/44);

            if ($ceil==1) {
               $hg = 5;
            }
            else{
                $hg = $ceil *5;
            }

            $pdf->SetFont('Arial','',9);
            $pdf->Cell(15,$hg, $no,1,0,'C');
            $pdf->Cell(60,$hg, $v->nama_supplier,1,0,'L');
            $pdf->Cell(50,$hg, "Telp : ".$v->telp,1,0,'L');
            $pdf->MultiCell(65,5, preg_replace( "/\r|\n/", "", ucwords(strtolower($v->alamat)) ),1,'L');

            $no++;

        }
        */
        $pdf->Ln();

        $w=45;
        $h=15;
        $x=$pdf->getx();
        $pdf->myCell($w,$h,$x,'1.1 satu titik satu');
        $x=$pdf->getx();
        $pdf->myCell($w,$h,$x,'1.2 satu titik dua');
        $x=$pdf->getx();
        $pdf->myCell($w,$h,$x,'1.3 satu titik tiga');
        $x=$pdf->getx();
        $pdf->myCell($w,$h,$x,'1.4 satu titik empat');
        $pdf->Ln();

        $x=$pdf->getx();
        $pdf->myCell($w,$h,$x,'2.1 dua titik satu');
        $x=$pdf->getx();
        $pdf->myCell($w,$h,$x,'2.2 dua titik dua');
        $x=$pdf->getx();
        $pdf->myCell($w,$h,$x,'2.3 dua titik tiga');
        $x=$pdf->getx();
        $pdf->myCell($w,$h,$x,'2.4 dua titik empat');
        $pdf->Ln();

        $x=$pdf->getx();
        $pdf->myCell($w,$h,$x,'3.1 tiga titik satu');
        $x=$pdf->getx();
        $pdf->myCell($w,$h,$x,'3.2 tiga titik dua');
        $x=$pdf->getx();
        $pdf->myCell($w,$h,$x,'3.3 tiga titik tiga');
        $x=$pdf->getx();
        $pdf->myCell($w,$h,$x,'3.4 tiga titik empat');
        $pdf->Ln();

        $x=$pdf->getx();
        $pdf->myCell($w,$h,$x,'4.1 empat titik satu');
        $x=$pdf->getx();
        $pdf->myCell($w,$h,$x,'4.2 empat titik dua');
        $x=$pdf->getx();
        $pdf->myCell($w,$h,$x,'4.3 empat titik tiga');
        $x=$pdf->getx();
        $pdf->myCell($w,$h,$x,'4.4 empat titik empat');

        $pdf->Output();
    }

    function select2(){
        $sl = "
            supplier.id,
            supplier.nama_supplier
        ";
        $this->db->select($sl);
        $this->db->from("supplier");
        $this->db->like("nama_supplier", $_POST["term"]);
        $data = $this->db->get()->result();

        $json = '[ ';
        $no = 0;
            foreach ($data as $v) {

                if ($no > 0) {
                    $json.=", ";
                }

                $dt = array(
                        "nama_supplier" => $v->nama_supplier,
                        "id"            => $v->id
                    );
                
                $no++;
                $json.= json_encode($dt);

            }

        $json.= "]";
        
        echo $json;

    }


    public function select(){
        
        $sl = "
            supplier.id,
            supplier.nama_cabang AS name
        ";
        $this->db->select($sl);
        $this->db->from("supplier");
        $data = $this->db->get()->result();

        header('Content-Type: application/json');
        echo json_encode($data);
    }

    public function edit(){
        $id = $_POST["id"];

        $this->db->where("id", $id);
        $data = $this->db->get("supplier")->result();
        header('Content-Type: application/json');
        echo json_encode($data);
    }

    public function hapus(){
        $id = $_POST["id"];

        $this->db->where("id", $id);
        $satuan = $this->db->get("supplier")->row_array();

        $iduser = $this->session->userdata("lnd_id");
        $this->db->where("username", $iduser);
        $user = $this->db->get("user")->row_array();

        $dt_act = array(
            "deskripsi"         => $user["nama"]." telah menghapus data Vendor ".$satuan['nama_supplier'].".",
            "jenis_aktivitas"   => "HAPUS",
            "iduser"            => $iduser,
            "tgl"               => date("Y-m-d H:i:s")
        );



        $this->db->trans_start();
            $this->db->where("id", $id);
            $this->db->delete("supplier");
            
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

    public function tambah(){

        $nama   = ucwords($_POST["nama"]);
        $telp   = $_POST['telp'];
        $email  = $_POST["email"];
        $alamat = $_POST["alamat"];

        $iduser = $this->session->userdata("lnd_id");
        $this->db->where("username", $iduser);
        $user = $this->db->get("user")->row_array();


        $dt = array(
                    "nama_supplier" => $nama,
                    "telp"          => $telp,
                    "email"         => $email,
                    "alamat"        => $alamat,
                    "created_by"    => $user["nama"],
                    "created_on"    => date("Y-m-d H:i:s")
            );

        $dt_act = array(
                "deskripsi"         => $user["nama"]." telah menambah data Vendor ".$nama.".",
                "jenis_aktivitas"   => "TAMBAH",
                "iduser"            => $iduser,
                "tgl"               => date("Y-m-d H:i:s")
            );

        $this->db->trans_start();
            $this->db->insert("supplier", $dt);

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

    public function update(){

        $nama   = ucwords($_POST["nama"]);
        $telp   = $_POST['telp'];
        $email  = $_POST["email"];
        $alamat = $_POST["alamat"];
        $id     = $_POST["id"];

        $iduser = $this->session->userdata("lnd_id");
        $this->db->where("username", $iduser);
        $user   = $this->db->get("user")->row_array();


        $dt = array(
                    "nama_supplier" => $nama,
                    "telp"          => $telp,
                    "email"         => $email,
                    "alamat"        => $alamat,
                    "updated_by"    => $user["nama"],
                    "updated_on"    => date("Y-m-d H:i:s")
            );

        $dt_act = array(
                "deskripsi"         => $user["nama"]." telah mengubah data Vendor ".$nama.".",
                "jenis_aktivitas"   => "EDIT",
                "iduser"            => $iduser,
                "tgl"               => date("Y-m-d H:i:s")
            );

        $this->db->trans_start();
            $this->db->where("id", $id);
            $this->db->update("supplier", $dt);

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
            $src_nama = $_POST["src_nama"];

            $list = $this->md->get_datatables($src_nama);
            $data = array();
            $no = $_POST['start'];
            foreach ($list as $v) {
                $no++;
                $row = array();
                $row[] = "<center>".$no."</center>";
                $row[] = $v->nama_supplier;
                $row[] = "<center>".$v->telp."</center>";
                $row[] = "<center>".$v->email."</center>";
                $row[] = $v->alamat;
     
                //add html for action
                $row[] = "
                            <center>
                            <div class='btn-group dropup'>
                                <button class='btn blue dropdown-toggle' type='button' data-toggle='dropdown'>
                                    Action <i class='fa fa-angle-up'></i>
                                </button>
                                <ul class='dropdown-menu' role='menu' style='width:auto;min-width:2px'>
                                    <li>
                                        <a href='javascript:;' onclick='edit(".$v->id.")' data-toggle='modal' data-target='#md-edit'>
                                            <i class='fa fa-pencil fa-lg'></i> Edit
                                        </a>
                                    </li>
                                    <li>
                                        <a href='javascript:;' onclick='getId(".$v->id.")' data-toggle='modal' data-target='#md-delete'>
                                            <i class='fa fa-trash fa-lg'></i> Hapus
                                        </a>
                                    </li>
                                </ul>
                            </div>
                            </center>
                        ";
     
                $data[] = $row;
            }
     
            $output = array(
                            "draw"              => $_POST['draw'],
                            "recordsTotal"      => $this->md->count_all(),
                            "recordsFiltered"   => $this->md->count_filtered($src_nama),
                            "data"              => $data,
                    );
            //output to json format
            echo json_encode($output);
    } 

	
}
