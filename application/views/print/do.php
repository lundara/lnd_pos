<?php  

    $this->load->model("Lnd_model", "lnd");

    $pdf = new pdftc('P', 'mm', 'A4', true, 'UTF-8', false);
    $pdf->SetTitle('DO.'.$h['do']);
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

    $no = 1;
    $item = "";
    foreach ($d as $v) {


        $item.='
            <tr>
                <td align="center">'.$no.'</td>
                <td align="left"></td>
                <td align="left">'.$v->deskripsi.' '.$v->ket.'</td>
                <td align="center">'.$v->qty.'</td>
                <td align="center">'.$v->qty.'</td>
            </tr>
        ';

        $no++;
    }
    if ($no < 5) {
        $sisa = 5 - $no;
        $col = "";
        $no2 = $no;
        for($x = 0;$x <= $sisa;$x++){
            $col.='
                <tr>
                    <td align="center"></td>
                    <td align="left"></td>
                    <td align="left"></td>
                    <td align="right"></td>
                    <td align="right"></td>
                </tr>
            ';

            $no2++;           
        }
    }
    else{
        $col = "";
    }
    $html = '
        <style>
            .th td{
                line-height:20px;
                background-color:#dbe5f1;
            }
        </style>

        <table border="0" cellpadding="1">
            <tr>
                <td colspan="2" align="right"><h1 style="color:#1476b7">DELIVERY ORDER</h1></td>
            </tr>
            <tr>
                <td width="40%">
                    <label style="font-size:12px;font-weight:bold">PT. CHAKRA BHASKARA TEKNO</label><br>
                    <label style="font-style:italic">THE TRULLY YOUR BUSSINES PARTNER</label>
                </td>
                <td width="20%">
                    <img src="'.base_url().'assets/img/logo_shin.png" style="width:50px;height:50px;" /><br><br>
                </td>
                <td></td>
            </tr>
            <tr>
                <td>Jl. Tirtasari Selatan No. 10 Bandung 40151<br>022 202 71122<br>info@cbtekno.com</td>
                <td align="right">
                    <strong>DO. NO : </strong><br>
                    <strong>DATE : </strong><br>
                    <strong>PO. NO : </strong>
                </td>
                <td>'.$h["do"].'<br>'.date("d/m/Y", strtotime($h["created_on"])).'<br>'.$h["no_po"].'</td>
            </tr>
        </table>
        <br>
        <br>
        <table border="0">
            <tr>
                <td width="10%">Customer</td>
                <td>'.$h["nama_pelanggan"].'<br>'.$h["alamat"].'</td>
            </tr>
        </table>
        <br>
        <br>
        <table border="1" cellpadding="3">
            <tr class="th">
                <td align="center" height="20" width="5%">NO</td>
                <td align="center" width="15%">MAKER</td>
                <td align="center" width="50%">DESCRIPTION</td>
                <td align="center" width="10%">QTY</td>
                <td align="center" width="15%">LINE TOTAL</td>
            </tr>
            '.$item.'
            '.$col.'
        </table>  
        <br>
        <br>
                <br>
        <br>
        <table>
            <tr>
                <td width="63%">
                    Send By : <br>
                    <br>
                    <br>
                    <br>
                    <br>
                    <br>
                    <br>
                    <hr style="width:165px;">
                    PT. CHAKRA BHASKARA TEKNO
                </td>
                <td>
                    Received By : <br>
                    <br>
                    <br>
                    <br>
                    <br>
                    <br>
                    <br>
                    <hr style="width:165px;">
                </td>
            </tr>
        </table>  
    ';  

    $pdf->writeHTML($html, true, false, true, false, '');
    $pdf->Output('do.pdf', 'I');


?>

