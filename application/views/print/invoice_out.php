<?php  

    $this->load->model("Lnd_model", "lnd");

    $pdf = new pdftc('P', 'mm', 'A4', true, 'UTF-8', false);
    $pdf->SetTitle('INV/'.$h['no_inv']."/CBT");
    $pdf->SetHeaderMargin(30);
    $pdf->SetTopMargin(10);
    $pdf->setFooterMargin(10);
    $pdf->SetAutoPageBreak(true, PDF_MARGIN_BOTTOM);
    $pdf->SetAuthor('SYS CBTEKNO');
    $pdf->SetDisplayMode('real', 'default');
    $pdf->SetFont('arial', '', '10' , '', 'default', true );
    $pdf->SetPrintHeader(false);
    $pdf->SetPrintFooter(false);
    $pdf->AddPage();

    $item = "";
    $no = 1;
    $is = 0;
    $r = "";
    foreach ($q as $vq) {

        $gg = $vq->nominal + ($vq->nominal*10/100);
        $r.="Remarks : INV/".$vq->no_inv."/CBT - ".date('d M Y', strtotime($vq->created_on))." (Rp. ".number_format($gg, 0, ',', '.').")  <br>";
    }

    foreach ($d as $v) {

        $pot = ( ($v->harga * $v->qty) * $v->disc/100 );
        $sbt = $v->harga * $v->qty;
        $net = ($sbt - $pot);

        $dis = $v->harga * $v->disc/100;
        $hrg = $v->harga - $dis;

        if ($no%2 == 0) {
            $item.='
                <tr style="background-color:#a5dcea">
                    <td align="center" height="10" style="line-height:15px;font-size:9px">'.$no.'</td>
                    <td style="line-height:15px;font-size:9px">'.$v->deskripsi.' '.$v->ket.'</td>
                    <td align="right" style="line-height:15px;font-size:9px">'.$v->qty.'</td>
                    <td align="right" style="line-height:15px;font-size:9px">'.number_format( $hrg , 0, ",", ".").'</td>
                    <td align="right" style="line-height:15px;font-size:9px">'.number_format($v->disc, 0, ",", ".").'</td>
                    <td align="right" style="line-height:15px;font-size:9px;background-color:#58b8c9">'.number_format($net, 0, ",", ".").'</td>
                </tr>
            ';
        }
        else{
            $item.='

                <tr style="">
                    <td align="center" height="10" style="line-height:15px;font-size:9px">'.$no.'</td>
                    <td style="line-height:15px;font-size:9px">'.$v->deskripsi.' '.$v->ket.'</td>
                    <td align="right" style="line-height:15px;font-size:9px">'.$v->qty.'</td>
                    <td align="right" style="line-height:15px;font-size:9px">'.number_format( $hrg, 0, ",", ".").'</td>
                    <td align="right" style="line-height:15px;font-size:9px">'.number_format($v->disc, 0, ",", ".").'</td>
                    <td align="right" style="line-height:15px;font-size:9px;background-color:#a5dcea">'.number_format($net, 0, ",", ".").'</td>
                </tr>

            ';
        }

        $is = $is + $net;

        $no++;
    }

    if ($h["type"] == "biasa") {
        
        /*
        if ($h["ppn"] == "Y") {
            $tax = number_format( ($is*10/100) , 0, ',', '.');
            $ttl = $is + ($is*10/100);
        }
        else{
            $tax = number_format( 0 , 0, ',', '.');
            $ttl = $is;
        }
        $terbilang = $this->lnd->terbilang(ceil($ttl));;
        */



        $title_inv = "INVOICE";
    }
    else{
        /*
        $terbilang = $this->lnd->terbilang(ceil($h['nominal'] + ($h['nominal']*10/100)));
        if ($h["ppn"] == "Y") {
            $tax = number_format( ($h['nominal']*10/100) , 0, ',', '.');
            $ttl = $h["nominal"] + ($h['nominal']*10/100);

        }
        else{
            $tax = number_format( 0 , 0, ',', '.');
            $ttl = $h["nominal"];

        }*/
        $title_inv = "PERFORMA INVOICE";
    }
    
    if ($h["nominal"]!=0 || $h["tax"]!=0) {
        $term = number_format($h["nominal"], 0, ",", ".");
        
        if ($h["ppn"] == "Y") {
            $tax  = number_format($h["tax"], 0, ",", ".");
            $terbilang2 = $this->lnd->terbilang(ceil($h["nominal"] + $h["tax"]));
            $ttl = $h["nominal"] + $h["tax"];
            $tax2  = number_format(($is*10/100), 0, ",", ".");
            $ttl2 = number_format( $is + ($is*10/100) , 0, ',', '.');
        }
        else{
            $tax = number_format( 0 , 0, ',', '.');
            $terbilang2 = $this->lnd->terbilang(ceil($h["nominal"]));
            $ttl = $h["nominal"];
            $tax2 = number_format( 0 , 0, ',', '.');
            $ttl2 =  number_format( $is , 0, ',', '.');
        }

        $ket_term = $h["ket_term"];
        $ket_tax  = $h["ket_tax"];

        $terbilang = "";

        $ket_po = '
            <tr>
                <td colspan="4" height="15" style="line-height:20px;font-size:9px;font-style:italic;" rowspan="2">'.$terbilang2.'</td>
                <td style="line-height:20px;font-size:10px;border:1px solid #17585d;" align="">Tax</td>
                <td align="right" style="line-height:20px;font-size:10px;background-color:#a5dcea;border:1px solid #17585d;">'.$tax2.'</td>
            </tr>
            <tr>
                <td style="line-height:20px;font-size:10px;border:1px solid #17585d;" align="">Subtotal</td>
                <td align="right" style="line-height:20px;font-size:10px;background-color:#a5dcea;border:1px solid #17585d;">'.$ttl2.'</td>
            </tr>
        ';

    }
    else{
        $term = 0;
        if ($h["ppn"] == "Y") {
            $tax  = number_format(($is*10/100), 0, ",", ".");
            $terbilang = $this->lnd->terbilang(ceil($is + ($is*10/100)));
            $ttl = $is + ($is*10/100);
        }
        else{
            $tax = number_format( 0 , 0, ',', '.');
            $terbilang = $this->lnd->terbilang(ceil($is));
            $ttl = $is;

        }

        $ket_term = "Term";
        $ket_tax  = "Tax";

        $ket_po = '
            
        ';

    }
    

    if ($no < 4) {
        $sisa = 4 - $no;
        $col = "";
        $no2 = $no;
        for($x = 0;$x <= $sisa;$x++){
             if ($no2%2 == 0) {
                $col.='
                    <tr style="background-color:#a5dcea">
                        <td align="center" height="10" style="line-height:15px;font-size:9px"></td>
                        <td style="line-height:15px;font-size:9px"></td>
                        <td align="right" style="line-height:15px;font-size:9px"></td>
                        <td align="right" style="line-height:15px;font-size:9px"></td>
                        <td align="right" style="line-height:15px;font-size:9px"></td>
                        <td align="right" style="line-height:15px;font-size:9px;background-color:#58b8c9"></td>
                    </tr>
                ';
            }
            else{
                $col.='

                    <tr style="">
                        <td align="center" height="10" style="line-height:15px;font-size:9px"></td>
                        <td style="line-height:15px;font-size:9px"></td>
                        <td align="right" style="line-height:15px;font-size:9px"></td>
                        <td align="right" style="line-height:15px;font-size:9px"></td>
                        <td align="right" style="line-height:15px;font-size:9px"></td>
                        <td align="right" style="line-height:15px;font-size:9px;background-color:#a5dcea"></td>
                    </tr>

                ';
            }

            $no2++;           
        }
    }
    else{
        $col = "";
    }

    $html = '

        <style>
            .title{
                
                color:white;
                width:100%;
                font-size:15px;
                font-weight:bold;
                /*border-bottom:3px solid #a5dcea;*/
            }
            .info{
                background-color:#79cbdf;
                font-size:9px;

            }
            .kpd{
                font-size:9px;
            }

            .table-head{
                font-size:14px;
                color:#21788e;
            }
            .thead td{
                font-size:11px;
            }
        </style>

        <table cellpadding="2" cellspacing="0" width="100%">
            <tr style="background-color:#21788e;">
                <td colspan="4" class="title" height="25" style="line-height:40px;">
                    
                    <img src="'.base_url().'assets/img/logo-bulat.png" width="27" height="27" style="background-color:white;"/>

                    PT. CHAKRA BHASKARA TEKNO
                </td>
            </tr>
            <tr class="info" >
                <td width="10%" height="30"></td>
                <td width="30%" style="line-height:15px;">Jl. Tirtasari Selatan No. 10 Bandung 40151</td>
                <td width="25%" style="line-height:15px;">P : 022 202 71122 <br>F : - </td>
                <td width="35%" style="line-height:15px;">Email : shinobi.ken@outlook.co.id <br>Website : https://www.cbtekno.com/</td>
            </tr>
            <tr class="kpd">
                <td>Bill To :</td>
                <td>'.$h["nama_pelanggan"].'</td>
                <td>Phone : '.$h["no_hp"].'<br>Fax &nbsp;&nbsp;&nbsp;&nbsp;: '.$h["fax"].'</td>
                <td>Invoice : INV/'.$h["no_inv"].'/CBT</td>
            </tr>
            <tr class="kpd">
                <td>Address : </td>
                <td>'.$h["alamat"].'</td>
                <td>Email : '.$h["email"].'</td>
                <td>Invoice Date : '.date("d/m/Y", strtotime($h['created_on'])).' <br>No. PO : '.$h['no_po'].'<br><br>'.$r.'</td>
            </tr>

        </table>
        <h3 style="text-align:center">'.$title_inv.'</h3>

        <table cellspacing="0" cellpadding="1" border="0">
            <tr class="thead">
                <td class="table-head" width="10%" style="border-top:1px solid #21788e;line-height:30px" height="25">No</td>
                <td class="table-head" width="35%" style="border-top:1px solid #21788e;line-height:30px">Description</td>
                <td class="table-head" width="10%" style="border-top:1px solid #21788e;line-height:30px">Qty</td>
                <td class="table-head" width="15%" style="border-top:1px solid #21788e;line-height:30px">Unit Price</td>
                <td class="table-head" width="15%" style="border-top:1px solid #21788e;line-height:30px">Discount</td>
                <td class="table-head" width="15%" style="border-top:1px solid #21788e;line-height:30px">Price</td>
            </tr>
            '.$item.'
            '.$col.'




            <tr>
                <td colspan="4" height="15" style="line-height:20px;font-size:9px;font-style:italic;">In Word</td>
                <td style="line-height:20px;font-size:10px;border:1px solid #17585d;" align="">Invoice Subtotal</td>
                <td align="right" style="line-height:20px;font-size:10px;background-color:#a5dcea;border:1px solid #17585d;">'.number_format($is, 0, ",", ".").'</td>
            </tr>
            '.$ket_po.'
            <tr>
                <td colspan="4" height="15" style="line-height:20px;font-size:9px;font-style:italic;" rowspan="2">'.$terbilang.'</td>
                <td style="line-height:20px;font-size:10px;background-color:#a5dcea;border:1px solid #17585d;" align="">'.$ket_term.'</td>
                <td align="right" style="line-height:20px;font-size:10px;background-color:#58b8c9;border:1px solid #17585d;">'.number_format($h['nominal'], 0, ',', '.').'</td>
            </tr>
            <tr>
                <td style="line-height:20px;font-size:10px;border:1px solid #17585d;" align="">'.$ket_tax.'</td>
                <td align="right" style="line-height:20px;font-size:10px;background-color:#a5dcea;border:1px solid #17585d;">'.$tax.'</td>
            </tr>
            <tr>
                <td colspan="4" height="15" style="line-height:20px;font-size:9px;font-style:italic;" bgcolor="#a5dcea"></td>
                <td style="line-height:20px;font-size:10px;font-weight:bold;background-color:#58b8c9;border:1px solid #17585d;" align="">TOTAL</td>
                <td align="right" style="line-height:20px;font-size:10px;background-color:#58b8c9;border:1px solid #17585d;"><strong>'.number_format( $ttl , 0, ',', '.').'</strong></td>
            </tr>
            <tr>
                <td colspan="6" height="25" style="line-height:15px;font-size:9px;" >
                    Please pay to : <br> 
                    Bank Mandiri PT CHAKRA BHASKARA TEKNO<br>
                    MANDIRI. ACCOUNT No. 173.00.0359774.8<br>
                    KCP. SUBANG AHMAD YANI 
                </td>
            </tr>

        </table>

        <table  border="0" width="100%">
            <tr>
                <td width="70%"></td>
                <td align="center" width="30%">
                    Yours Faithfully<br>
                    SHINOBI<br><br>
                    <img src="'.base_url().'assets/img/logo_shin.png" width="40" height="40" /><br>
                    Ms. Deli Kartika
                    <hr style="width:85px;">
                    0852 9568 8636
                </td>
            </tr>
        </table>



    ';

    $pdf->writeHTML($html, true, false, true, false, '');
    $pdf->Output('invoice_out.pdf', 'I');


?>

