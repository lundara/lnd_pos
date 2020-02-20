<?php  

    $this->load->model("Lnd_model", "lnd");

    $pdf = new pdftc('P', 'mm', array(95, 110), true, 'UTF-8', false);
    $pdf->SetTitle("Test Penjualan Pit Stop");
    $pdf->SetHeaderMargin(30);
    $pdf->SetTopMargin(10);
    $pdf->setFooterMargin(10);
    $pdf->SetAutoPageBreak(true, PDF_MARGIN_BOTTOM);
    $pdf->SetAuthor('SYS CBTEKNO');
    $pdf->SetDisplayMode('real', 'default');
    $pdf->SetFont('arial', '', '10' , '', 'default', true );
    $pdf->SetPrintHeader(false);
    $pdf->SetPrintFooter(false);
    $pdf->AddPage('P', array(240, 280));


    $html = '


        <table border="0">
            <tr>
                <td width="15%" align="center"><img src="'.base_url().'assets/img/pit_stop.png" height="50" width="60"></td>
                <td width="20%"><strong>The Pit Stop</strong><br>Jl. Cilameri Subang<br>Telp. (0260) xxxxxx</td>
                <td width="35%"></td>
                <td width="30%" align="right"><br><br><H1 style="font-size:18px">INVOICE</H1></td>
            </tr>
        </table>
        <hr>

    ';

    $pdf->writeHTML($html, true, false, true, false, '');
    $pdf->Output('penjualan.pdf', 'I');


?>

