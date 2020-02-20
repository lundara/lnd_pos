<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class invoice_out_lama extends CI_Controller {

    function __construct(){
        parent::__construct();
        date_default_timezone_set("Asia/Jakarta");
        $this->load->model('invoice_out_model','md');
        $this->load->model("Lnd_model", "lnd");


       if(!$this->session->userdata('lnd_id'))
       {
            redirect('login');
       }
    }

    public function index(){        

        $this->lnd->akses("invoice_out_lama", "submenu");

        $data["page"]     = "invoice_out_lama";
        $data["menu"]     = "transaksi";
        $data["submenu"]  = "invoice_out_lama";
        $this->load->view('main', $data);
        
    }
    function print_do(){
        $id = $this->uri->segment(3);

        $sl = "
            invoice_out.*,
            po_in.no_trans,
            po_in.no_po,
            po_in.tgl_po,
            po_in.idpelanggan,
            pelanggan.id AS pelid,
            pelanggan.nama_pelanggan,
            pelanggan.no_hp,
            pelanggan.email,
            pelanggan.fax,
            pelanggan.alamat

        ";
        $this->db->select($sl);
        $this->db->from("invoice_out");
        $this->db->join("po_in", "po_in.no_po = invoice_out.no_po");
        $this->db->join("pelanggan", "po_in.idpelanggan = pelanggan.id");
        $this->db->where("invoice_out.no_inv", $id);
        $h = $this->db->get()->row_array();

        $sl2 = "
            po_in_detail.*,
            produk.id AS produkid,
            produk.nama_produk,
            produk.deskripsi
        ";
        $this->db->select($sl2);
        $this->db->from("po_in_detail");
        $this->db->join("produk", "produk.id = po_in_detail.iditem");
        $this->db->where("po_in_detail.no_trans", $h["no_trans"]);
        $d = $this->db->get()->result();

        $this->db->where("created_on<", $h["created_on"]);
        $this->db->where("no_po", $h['no_po']);
        $this->db->order_by("created_on", "ASC");
        $q = $this->db->get("invoice_out")->result();




        $this->load->library('Tcpdf');


        $data["h"]      = $h;
        $data["d"]      = $d;
        $data["q"]      = $q;
        $this->load->view("print/do", $data);       
    }
    function print_inv(){
        $id = $this->uri->segment(3);

        $sl = "
            invoice_out.*,
            po_in.no_trans,
            po_in.no_po,
            po_in.tgl_po,
            po_in.idpelanggan,
            pelanggan.id AS pelid,
            pelanggan.nama_pelanggan,
            pelanggan.no_hp,
            pelanggan.email,
            pelanggan.fax,
            pelanggan.alamat

        ";
        $this->db->select($sl);
        $this->db->from("invoice_out");
        $this->db->join("po_in", "po_in.no_po = invoice_out.no_po");
        $this->db->join("pelanggan", "po_in.idpelanggan = pelanggan.id");
        $this->db->where("invoice_out.no_inv", $id);
        $h = $this->db->get()->row_array();

        $sl2 = "
            po_in_detail.*,
            produk.id AS produkid,
            produk.nama_produk,
            produk.deskripsi
        ";
        $this->db->select($sl2);
        $this->db->from("po_in_detail");
        $this->db->join("produk", "produk.id = po_in_detail.iditem");
        $this->db->where("po_in_detail.no_trans", $h["no_trans"]);
        $d = $this->db->get()->result();

        $this->db->where("created_on<", $h["created_on"]);
        $this->db->where("no_po", $h['no_po']);
        $this->db->order_by("created_on", "ASC");
        $q = $this->db->get("invoice_out")->result();




        $this->load->library('Tcpdf');


        $data["h"]      = $h;
        $data["d"]      = $d;
        $data["q"]      = $q;

        $this->load->view("print/invoice_out", $data);

    }
    function lampiran(){

        $id = $_POST["id"];

        $this->db->where("no_trans", $id);
        $d = $this->db->get("po_in")->row_array();

        $json="[";

        $json.=json_encode(array(
                "lampiran"  => $d['lampiran'],
                "ext"       => pathinfo($d['lampiran'], PATHINFO_EXTENSION)
            ));

        $json.="]";

        echo $json;
    }

    public function upload_lampiran(){

        $id = $_POST["id"];

        //header("Content-type: image/jpg");
        $config['upload_path']      = './upload/po_in/';
        $config['allowed_types']    = '*';
        $config["overwrite"]        = TRUE;
        $config['encrypt_name']     = TRUE;
        
        $this->load->library('upload', $config);        
        
        
        $s1=$this->upload->do_upload('lampiran');
        $g1 =$this->upload->data();

        $this->db->where("no_trans", $id);
        $d = $this->db->get("po_in")->row_array();

        if($s1){

            if($d["lampiran"]!=""){
                unlink("./upload/po_in/".$d["lampiran"]);
            }

            $arr = array(
                    "lampiran"       => $g1["file_name"]
            );

            $this->db->trans_start();
                $this->db->where("no_trans", $id);
                $this->db->update("po_in", $arr);
            $this->db->trans_complete();

            if($this->db->trans_status() === TRUE){
                $this->db->trans_commit();
                echo "1";
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
 
            $objget->setTitle('Done'); //sheet title
            //Warna header tabel

            $objget->setCellValueByColumnAndRow(0, 1, "LAPORAN INVOICE OUT");            
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

            $src_inv        = $_GET["src_inv"];
            $src_po         = $_GET['src_po'];
            $src_from       = $_GET['src_from'];
            $src_to         = $_GET['src_to'];
            $src_supplier   = $_GET['src_supplier'];
            $src_user       = $_GET['src_user'];
            $src_status     = $_GET['src_status'];
            $src_bayar      = $_GET['src_bayar'];

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


            $objget->getStyle("A4:O4")->applyFromArray(
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
            $cols    = array("A","B","C","D","E","F","G","H","I", "J", "K", "L", "M", "N", "O");
            $val   = array("TANGGAL","PERUSAHAAN", "PO", "INVOICE", "DO", "NAMA BARANG",  "QTY", "HARGA", "JUMLAH", "PPN", "TOTAL", "PIUTANG", "TERM", "SISA", "STATUS");

            for ($a=0;$a<15; $a++) 
            {
                $objset->setCellValue($cols[$a].'4', $val[$a]);
                 
                //Setting lebar cell
                $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(10); 
                $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(30); 
                $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(15);
                $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(15);
                $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(15); 
                $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(40);
                $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(7);
                $objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(10);
                $objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(10);
                $objPHPExcel->getActiveSheet()->getColumnDimension('J')->setWidth(10);
                $objPHPExcel->getActiveSheet()->getColumnDimension('K')->setWidth(10);
                $objPHPExcel->getActiveSheet()->getColumnDimension('L')->setWidth(10);
                $objPHPExcel->getActiveSheet()->getColumnDimension('M')->setWidth(10);
                $objPHPExcel->getActiveSheet()->getColumnDimension('N')->setWidth(10);
                $objPHPExcel->getActiveSheet()->getColumnDimension('O')->setWidth(15);


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



            $list = $this->md->laporan_done($src_inv, $src_po, $src_from, $src_to, $src_supplier, $src_user, $src_status, $src_bayar);
            $no = 1;
            $ak_total = 0;
            $ak_ppn   = 0;
            $ak_gt    = 0;

            foreach ($list as $v){
                 
               //pemanggilan sesuaikan dengan nama kolom tabel
                $objset->setCellValue("A".$baris, date("d/m/Y", strtotime($v->created_on))); 
                $objset->setCellValue("B".$baris,  $v->nama_pelanggan);
                $objset->setCellValue("C".$baris,  $v->no_po);
                $objset->setCellValue("D".$baris,  $v->no_inv);
                $objset->setCellValue("E".$baris,  "");

                $sl = "
                    po_in_detail.*,
                    produk.id AS produkid,
                    produk.nama_produk,
                    produk.deskripsi,
                ";

                $this->db->select($sl);
                $this->db->from('po_in_detail');
                $this->db->join("produk", "produk.id = po_in_detail.iditem");
                $this->db->where("po_in_detail.no_trans", $v->no_trans);
                $det = $this->db->get()->result();

                $baris2 = $baris;
                $nod = 0;
                $nod2 = 0;
                $ttl = 0;
                $bayar1 = 0;
                foreach ($det as $vdet) {

                    $dlen = strlen($vdet->deskripsi." ".$vdet->ket);
                    $bts = 46;
                    $cl = ceil($dlen / $bts);


                    $baris3 = $baris2;
                    $ex = 0;
                    $nod3 = 0;
                    for($d = 1;$d<=$cl;$d++){
                        $objset->setCellValue("F".$baris3, substr($vdet->deskripsi." ".$vdet->ket, $ex,45) );
                        $baris3++;
                        $nod2++;
                        $nod3++;
                        $ex = $ex+45;
                    }



                    $pot1 = ( ($vdet->harga*$vdet->qty)*$vdet->disc/100 );
                    $total1 = ($vdet->harga*$vdet->qty) - $pot1;
                    $ppn1 = $total1 *10/100;
                    $bayar1 = $bayar1 + $v->bayar;

                    $objset->setCellValue("G".$baris2, $vdet->qty );
                    $objset->setCellValue("H".$baris2, $vdet->harga );
                    $objset->setCellValue("I".$baris2, $total1 );
                    
                    if ($v->ppn=="Y") {
                        $objset->setCellValue("J".$baris2, $ppn1 );
                        $objset->setCellValue("K".$baris2, $total1+$ppn1);
                        $ak_ppn = $ak_ppn + $ppn1;
                        $ak_gt = $ak_gt + ($total1);
                        $ttl = $ttl + ($total1+$ppn1);
                    }
                    else{
                        $ak_ppn = $ak_ppn + 0;
                        $ak_gt = $ak_gt + ($total1+$ppn1);
                        $objset->setCellValue("J".$baris2, "0");
                        $objset->setCellValue("K".$baris2, $total1);
                        $ttl = $ttl + $total1;
                    }
                    $ak_total = $ak_total + $total1;

                    $objset->setCellValue("L".$baris2, "");
                    $objset->setCellValue("M".$baris2, $v->nominal);
                    $objset->setCellValue("N".$baris2, "");
                    $objset->setCellValue("O".$baris2, "");

                    $baris2 = $baris2 + $nod3;
                    $nod++;
                    


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
                $objPHPExcel->getActiveSheet()->getStyle("B5:B".$baris3)->applyFromArray($style_row);
                $objPHPExcel->getActiveSheet()->getStyle("C5:C".$baris3)->applyFromArray($style_no);
                $objPHPExcel->getActiveSheet()->getStyle("D5:D".$baris3)->applyFromArray($style_no);
                $objPHPExcel->getActiveSheet()->getStyle("E5:E".$baris3)->applyFromArray($style_no);
                $objPHPExcel->getActiveSheet()->getStyle("F5:F".$baris3)->applyFromArray($style_row);
                $objPHPExcel->getActiveSheet()->getStyle("G5:G".$baris3)->applyFromArray($style_row);
                $objPHPExcel->getActiveSheet()->getStyle("H5:H".$baris3)->applyFromArray($style_row);
                $objPHPExcel->getActiveSheet()->getStyle('H5:H'.$baris3)->getNumberFormat()->setFormatCode("#,##0");
                $objPHPExcel->getActiveSheet()->getStyle("I5:I".$baris3)->applyFromArray($style_row);
                $objPHPExcel->getActiveSheet()->getStyle('I5:I'.$baris3)->getNumberFormat()->setFormatCode("#,##0");
                $objPHPExcel->getActiveSheet()->getStyle("J5:J".$baris3)->applyFromArray($style_row);
                $objPHPExcel->getActiveSheet()->getStyle('J5:J'.$baris3)->getNumberFormat()->setFormatCode("#,##0");
                $objPHPExcel->getActiveSheet()->getStyle("K5:K".$baris3)->applyFromArray($style_row);
                $objPHPExcel->getActiveSheet()->getStyle('K5:K'.$baris3)->getNumberFormat()->setFormatCode("#,##0");
                $objPHPExcel->getActiveSheet()->getStyle("L5:L".$baris3)->applyFromArray($style_row);
                $objPHPExcel->getActiveSheet()->getStyle('L5:L'.$baris3)->getNumberFormat()->setFormatCode("#,##0");
                $objPHPExcel->getActiveSheet()->getStyle("M5:M".$baris3)->applyFromArray($style_row);
                $objPHPExcel->getActiveSheet()->getStyle('M5:M'.$baris3)->getNumberFormat()->setFormatCode("#,##0");
                $objPHPExcel->getActiveSheet()->getStyle("N5:N".$baris3)->applyFromArray($style_row);
                $objPHPExcel->getActiveSheet()->getStyle('N5:N'.$baris3)->getNumberFormat()->setFormatCode("#,##0");
                $objPHPExcel->getActiveSheet()->getStyle("O5:O".$baris3)->applyFromArray($style_row);


                 
                $baris = $baris + $nod2+1;
                $no++;
            }
                  
            $objget->mergeCells('A'.$baris.':H'.$baris);
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
            $objPHPExcel->getActiveSheet()->getStyle('A'.$baris.':O'.$baris)->applyFromArray($style_gt);

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

            $objset->getStyle("L".$baris)->applyFromArray($style_gtotal);
            $objset->getStyle('L'.$baris)->getNumberFormat()->setFormatCode("#,##0");

            $objset->getStyle("M".$baris)->applyFromArray($style_gtotal);
            $objset->getStyle('M'.$baris)->getNumberFormat()->setFormatCode("#,##0");

            $objset->getStyle("N".$baris)->applyFromArray($style_gtotal);
            $objset->getStyle('N'.$baris)->getNumberFormat()->setFormatCode("#,##0");


            $objset->setCellValue("I".$baris, $ak_total);
            $objset->setCellValue("J".$baris, $ak_ppn);
            $objset->setCellValue("K".$baris, $ak_ppn+$ak_total);
            $objset->setCellValue("L".$baris, "");
            $objset->setCellValue("M".$baris, $bayar1);
            $objset->setCellValue("N".$baris, "");
            $objset->setCellValue("O".$baris, "");


            /*
            //Sheet 2
            $sheet2 = $objPHPExcel->createSheet();
            $sheet2->setTitle('Per Perusahaan');

            $sheet2->setCellValueByColumnAndRow(0, 1, "LAPORAN PO IN");            
            $sheet2->mergeCells('A1:O1');
            $sheet2->getStyle('A1:O1')->applyFromArray($style_title);

            $sheet2->setCellValue("B2", $tgl);            
            $sheet2->mergeCells('B2:C2');
            $sheet2->getStyle('B2:C2')->applyFromArray($style_date);

            $sheet2->setCellValue("B2", $tgl);            
            $sheet2->mergeCells('B2:C2');
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
            $sheet2->getStyle('B2:C2')->applyFromArray($style_date);


            $sheet2->getStyle("A4:O4")->applyFromArray(
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
            $cols    = array("A","B","C","D","E","F","G","H","I", "J", "K", "L", "M", "N", "O");
            $val   = array("NO ","TGL PO","NO PO", "USER", "DESCRIPTION", "QTY", "DELIV DATE", "TERMS", "HARGA BELI", "HARGA JUAL", "DISCOUNT", "TOTAL", "PPN", "AMOUNT", "KETERANGAN");

            for ($a=0;$a<15; $a++) 
            {
                $sheet2->setCellValue($cols[$a].'4', $val[$a]);
                 
                //Setting lebar cell
                $sheet2->getColumnDimension('A')->setWidth(5); 
                $sheet2->getColumnDimension('B')->setWidth(10); 
                $sheet2->getColumnDimension('C')->setWidth(30);
                $sheet2->getColumnDimension('D')->setWidth(30);
                $sheet2->getColumnDimension('E')->setWidth(40); 
                $sheet2->getColumnDimension('F')->setWidth(7);
                $sheet2->getColumnDimension('G')->setWidth(10);
                $sheet2->getColumnDimension('H')->setWidth(20);
                $sheet2->getColumnDimension('I')->setWidth(10);
                $sheet2->getColumnDimension('J')->setWidth(10);
                $sheet2->getColumnDimension('K')->setWidth(10);
                $sheet2->getColumnDimension('L')->setWidth(15);
                $sheet2->getColumnDimension('M')->setWidth(15);
                $sheet2->getColumnDimension('N')->setWidth(15);
                $sheet2->getColumnDimension('O')->setWidth(20);


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
                $sheet2->setCellValue("B".$barisu, date("d/m/Y", strtotime($vu->tgl_po)) );
                $sheet2->setCellValue("C".$barisu, $vu->no_po );
                $sheet2->setCellValue("D".$barisu, $vu->nama_pelanggan );

                $slu = "
                    po_in_detail.*,
                    produk.id AS produkid,
                    produk.nama_produk,
                    produk.deskripsi
                ";

                $this->db->select($slu);
                $this->db->from('po_in_detail');
                $this->db->join("produk", "produk.id = po_in_detail.iditem");
                $this->db->where("po_in_detail.no_trans", $vu->no_trans);
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

                    if ($vdetu->delivery_date=="0000-00-00") {
                        $ddu = "";
                    }
                    else{
                        $ddu = date("d/m/Y", strtotime($vdetu->delivery_date));
                    }

                    $sheet2->setCellValue("F".$baris2u, $vdetu->qty );
                    $sheet2->setCellValue("G".$baris2u, $ddu );
                    $sheet2->setCellValue("H".$baris2u, $vu->nama_pembayaran );
                    $sheet2->setCellValue("I".$baris2u, $vdetu->modal );
                    $sheet2->setCellValue("J".$baris2u, $vdetu->harga );
                    $sheet2->setCellValue("K".$baris2u, $vdetu->disc );
                    $sheet2->setCellValue("L".$baris2u, $total1u);
                    $sheet2->setCellValue("O".$baris2u, "");

                    $baris2u = $baris2u + $nod3u;
                    $nodu++;
                    $ttlu = $ttlu + ($total1u+$ppn1u);

                    $ak_totalu = $ak_totalu + $total1u;
                    if ($vu->ppn=="Y") {
                        $sheet2->setCellValue("M".$baris2u, $ppn1u);
                        $sheet2->setCellValue("N".$baris2u, $total1u+$ppn1u);
                        $ak_ppnu = $ak_ppnu + $ppn1u;
                        $ak_gtu = $ak_gtu + ($total1u);
                        $ttlu = $ttlu + ($total1+$ppn1u);
                    }
                    else{
                        $ak_ppnu = $ak_ppnu + 0;
                        $ak_gtu = $ak_gt + ($total1+$ppn1);
                        $sheet2->setCellValue("M".$baris2u, "0");
                        $sheet2->setCellValue("N".$baris2u, $total1);
                        $ttlu = $ttlu + $total1u;
                    }

                }

                $tbarisu = $barisu + $nod2u;
                $sheet2->setCellValue("N".$tbarisu, $ttlu);
                $style_total = array(
                        'font' => array(
                            'size'  => 9,
                            'bold'  => true
                        ),
                    );
                $sheet2->getStyle("N".$tbarisu)->applyFromArray($style_total);


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
                $sheet2->getStyle("I5:I".$baris3u)->applyFromArray($style_row);
                $sheet2->getStyle('I5:I'.$baris3u)->getNumberFormat()->setFormatCode("#,##0");
                $sheet2->getStyle("J5:J".$baris3u)->applyFromArray($style_row);
                $sheet2->getStyle('J5:J'.$baris3u)->getNumberFormat()->setFormatCode("#,##0");
                $sheet2->getStyle("K5:K".$baris3u)->applyFromArray($style_row);
                $sheet2->getStyle("L5:L".$baris3u)->applyFromArray($style_row);
                $sheet2->getStyle('L5:L'.$baris3u)->getNumberFormat()->setFormatCode("#,##0");
                $sheet2->getStyle("M5:M".$baris3u)->applyFromArray($style_row);
                $sheet2->getStyle('M5:M'.$baris3u)->getNumberFormat()->setFormatCode("#,##0");
                $sheet2->getStyle("N5:N".$baris3u)->applyFromArray($style_row);
                $sheet2->getStyle('N5:N'.$baris3u)->getNumberFormat()->setFormatCode("#,##0");
                $sheet2->getStyle("O5:O".$baris3u)->applyFromArray($style_row);


                 
                $barisu = $barisu + $nod2u+1;
                $nou++;
            }
                  
            $sheet2->mergeCells('A'.$barisu.':K'.$barisu);
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
            $sheet2->getStyle('A'.$barisu.':K'.$barisu)->applyFromArray($style_gt);

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
            $sheet2->getStyle("L".$barisu)->applyFromArray($style_gtotal);
            $sheet2->getStyle('L'.$barisu)->getNumberFormat()->setFormatCode("#,##0");

            $sheet2->getStyle("M".$barisu)->applyFromArray($style_tax);
            $sheet2->getStyle('M'.$barisu)->getNumberFormat()->setFormatCode("#,##0");

            $sheet2->getStyle("N".$barisu)->applyFromArray($style_tax);
            $sheet2->getStyle('N'.$barisu)->getNumberFormat()->setFormatCode("#,##0");

            $sheet2->getStyle("O".$barisu)->applyFromArray($style_gtotal);

            $sheet2->setCellValue("L".$barisu, $ak_totalu);
            $sheet2->setCellValue("M".$barisu, $ak_ppnu);
            $sheet2->setCellValue("N".$barisu, $ak_totalu+$ak_ppnu);
            $sheet2->setCellValue("O".$barisu,"");
        */


            $objPHPExcel->setActiveSheetIndex(0);
            $filename = urlencode("Laporan Invoice Out.xlsx");
               
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
            po_in.*
        ";
        $this->db->select($sl);
        $this->db->from("po_in");
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

        $session_no = count($_SESSION['poin']);
        $no_item    = $session_no+1;

        $id     = $_POST["id"];
        $harga  = str_replace(".","",$_POST["harga"]);
        $qty    = str_replace(".","",$_POST["qty"]);
        $modal    = str_replace(".","",$_POST["modal"]);
        $satuan = $_POST["satuan"];
        $lead_time = $_POST["lead_time"];
        $ket = $_POST["ket"];
        $disc = $_POST['disc'];
        $dd = $_POST['dd'];

        if ($session_no!=0) {
            for($i=1;$i<=$session_no;$i++){

                if ($_SESSION['poin'][$i][0] == $id) {
                    $mqty       = $qty + $_SESSION['poin'][$i][1];
                    $sess_id    = $_SESSION['poin'][$i][2];
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


        $_SESSION['poin'][$sess_id][0]=$id; // idproduk
        $_SESSION['poin'][$sess_id][1]=$mqty; //qty
        $_SESSION['poin'][$sess_id][2]=$sess_id; //session id
        $_SESSION['poin'][$sess_id][3]=$harga; //harga
        $_SESSION['poin'][$sess_id][4]=$satuan; //satuan
        $_SESSION['poin'][$sess_id][7]=$ket;
        $_SESSION['poin'][$sess_id][8]=$disc;
        $_SESSION['poin'][$sess_id][9]=$dd;
        $_SESSION['poin'][$sess_id][10]=$modal;

        echo "1";

    }

    public function del(){

        $id = $_POST["id"];

        unset($_SESSION['poin'][$id][0]);
        unset($_SESSION['poin'][$id][1]);
        unset($_SESSION['poin'][$id][2]);
        unset($_SESSION['poin'][$id][3]);
        unset($_SESSION['poin'][$id][4]);
        unset($_SESSION['poin'][$id][7]);
        unset($_SESSION['poin'][$id][8]);
        unset($_SESSION['poin'][$id][9]);
        unset($_SESSION['poin'][$id][10]);

    }

    function save(){
        error_reporting(0);

        $no_trans   = $_POST["no_trans"];
        $po         = $_POST["po"];
        $bayar      = str_replace(".", "", $_POST["bayar"]);
        $tempo      = $_POST["tempo"];
        $sisa       = str_replace(".", "", $_POST["sisa"]);
        $type       = $_POST["type"];
        $do         = $_POST["no_do"];
        $tgl_inv    = $_POST["tgl_inv"];  

        $user = $this->lnd->me();

        $this->db->where("no_inv", $no_trans);
        $c = $this->db->get("invoice_out")->num_rows();

        if ($c==0) {
            $no_po = $no_trans;
        }
        else{
            $no_po = $no_trans.rand(0,999);
        }


        $dt = array(
                "no_inv"            => $no_trans,
                "no_po"             => $po,
                "nominal"           => $bayar,
                "type"              => $type,
                "do"                => $do,
                "created_by"        => $user["username"],
                "created_on"        => $tgl_inv." 00:00:00"
        $dt_act = array(
            "deskripsi"         => $user["nama"]." telah menambah data Invoice Out LAMA ".$no_trans.".",
            "jenis_aktivitas"   => "TAMBAH",
            "iduser"            => $user['username'],
            "tgl"               => date("Y-m-d H:i:s")
        );

        if ($bayar>=$sisa) {
            $st = "Lunas";
        }
        else{
            $st = "Belum Lunas";
        }
        
        $dt_po = array(
                "jatuh_tempo"   => date("Y-m-d", strtotime($tempo)),
                "status"        => $st
            );
        $this->db->trans_start();

            $this->db->where("no_po", $po);
            $this->db->update("po_in", $dt_po);

            $this->db->insert("invoice_out", $dt);

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

    public function des(){
        $this->session->unset_userdata('poin');
    }

    public function data_item(){
        error_reporting(0);

        $session_no = count($_SESSION['poin']);
        $json = "[";
        $no = 1;
        $vpot = 0;
        for($i=1;$i<=$session_no;$i++){



            if ($_SESSION['poin'][$i][2]!="") {
                if ($no>1) {
                    $json.=",";
                }
                $this->db->where("produk.id", $_SESSION['poin'][$i][0]);
                $produk = $this->db->get("produk")->row_array();

                if ($produk["deskripsi"]==null) {
                    $desc = "";
                }
                else{
                    $desc = $produk["deskripsi"];
                }

                $dt = array(
                        "id_produk"     => $_SESSION['poin'][$i][0],
                        "nama_item"     => $produk["nama_produk"],
                        "qty"           => $_SESSION['poin'][$i][1],
                        "harga"         => $_SESSION['poin'][$i][3],
                        "netto"         => ($_SESSION['poin'][$i][3] * $_SESSION['poin'][$i][1]) - (($_SESSION['poin'][$i][3] * $_SESSION['poin'][$i][1])*$_SESSION['poin'][$i][8]/100) ,
                        "brutto"        => ($_SESSION['poin'][$i][3] * $_SESSION['poin'][$i][1]),
                        "id"            => $_SESSION['poin'][$i][2],
                        "pot"           => "0",
                        "total_item"    => $no,
                        "satuan"        => $_SESSION['poin'][$i][4],
                        "desc"          => $desc,
                        "ket"           => $_SESSION['poin'][$i][7],
                        "disc"          => $_SESSION['poin'][$i][8],
                        "dd"            => $_SESSION['poin'][$i][9],
                        "modal"         => $_SESSION['poin'][$i][10]

                    );

                $json.=json_encode($dt);
                $no++;
            }
            
        }

        $json.="]";
        
        echo $json;


    }

    public function rand_trans(){


        $x = "RAND-".date("Ymd").rand(100,999);

        return $x;

    }

    public function get_trans(){

        $this->db->where("YEAR(created_on)", date("Y"));
        $this->db->order_by("created_on", "desc");
        $q = $this->db->get("invoice_out");
        $c = $q->num_rows();
        $v = $q->row_array();

        if ($c!=0) {
            $digit = substr($v["no_inv"], -4);
        }
        else{
            $digit = 0;
        }
        //get trans in 
        

        $d = json_encode(array(
                //"no_trans"  =>date("y").date("m").sprintf("%04d", $c+1)
                "no_trans"  =>date("y").date("m").sprintf("%04d", $digit+1)
            ));

        $x = "[".$d."]";
        echo $x;

    }
    public function get_do(){

        $this->db->where("YEAR(created_on)", date("Y"));
        $this->db->where("do!=", "");
        $this->db->order_by("created_on", "desc");
        $q = $this->db->get("invoice_out");
        $c = $q->num_rows();
        $v = $q->row_array();

        if ($c!=0) {
            $digit = substr($v["do"], -4);
        }
        else{
            $digit = 0;
        }
        //get trans in 
        

        $d = json_encode(array(
                //"no_trans"  =>date("y").date("m").sprintf("%04d", $c+1)
                "no_trans"  =>date("y").date("m").sprintf("%04d", $digit+1)
            ));

        $x = "[".$d."]";
        echo $x;

    }



    function detail(){
        $id = $_POST["id"];


        $sl = "
            po_in_detail.*,
            produk.id AS titid,
            produk.nama_produk,
            produk.idsatuan,
            produk.deskripsi,
            satuan.id AS satid,
            satuan.nama_satuan,
            po_in.no_trans,
            po_in.ppn
        ";
        $this->db->select($sl);
        $this->db->from("po_in_detail");
        $this->db->join("produk", "produk.id = po_in_detail.iditem");
        $this->db->join("satuan", "satuan.id = produk.idsatuan");
        $this->db->join("po_in", "po_in.no_trans = po_in_detail.no_trans");
        $this->db->where("po_in_detail.no_trans", $id);
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

            if ($v->delivery_date!="0000-00-00") {
                $dd = date("d/m/Y", strtotime($v->delivery_date));
            }
            else{
                $dd = "";
            }

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
                    "delivery_date" => $dd,
                    "deskripsi" => $v->deskripsi,
                    "modal"     => number_format($v->modal, 0, ",", "."),
                    "ket"       => $v->ket,
                    "disc"      => $v->disc,
                    "idproduk"  => $v->titid,
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
            $src_bayar      = $_POST["src_bayar"];
            $src_inv        = $_POST["src_inv"];

            $list = $this->md->get_datatables($src_inv, $src_po, $src_from, $src_to, $src_supplier, $src_user, $src_status, $src_bayar);
            $data = array();
            $no = $_POST['start'];
            $gtotal = 0;

            foreach ($list as $v) {

                if ($v->do != "") {
                    $do = "
                        <li>
                            <a target='_blank' href='".base_url()."invoice_out/print_do/".$v->no_inv."'>
                                <i class='fa fa-print fa-lg'></i> Print DO
                            </a>
                        </li>
                    ";
                }
                else{
                    $do = "";
                }

                $no++;
                $row = array();
                $row[] = "<center>".$no."</center>";
                $row[] = "INV/".$v->no_inv."/CBT";
                $row[] = $v->no_po;
                $row[] = "DO.".$v->do;
                $row[] = "<center>".date("d/m/Y H:i:s", strtotime($v->created_on))."</center>";
                $row[] = $v->nama_pelanggan;
                $row[] = "<p style='text-align:right'>".number_format($v->nominal, 0, ",", ".")."</p>";
                $row[] = $v->nama_pembayaran;
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
                                        <a target='_blank' href='".base_url()."invoice_out/print_inv/".$v->no_inv."'>
                                            <i class='fa fa-print fa-lg'></i> Print
                                        </a>
                                    </li>
                                    ".$do."
                                </ul>
                            </li>
                            </center>
                        ";
                $row[] = $this->md->get_total($src_inv, $src_po, $src_from, $src_to, $src_supplier, $src_user, $src_status, $src_bayar);
     
                $data[] = $row;
            }
     
            $output = array(
                            "draw"              => $_POST['draw'],
                            "recordsTotal"      => $this->md->count_all(),
                            "recordsFiltered"   => $this->md->count_filtered($src_po, $src_from, $src_to, $src_supplier, $src_user, $src_status, $src_bayar),
                            "data"              => $data,
                    );
            //output to json format
            echo json_encode($output);
    } 

    
}
