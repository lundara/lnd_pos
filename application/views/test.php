<?php  


    $pdf = new pdftc('P', 'mm', 'A4', true, 'UTF-8', false);
    $pdf->SetTitle('Daftar Vendor');
    $pdf->SetHeaderMargin(30);
    $pdf->SetTopMargin(20);
    $pdf->setFooterMargin(20);
    $pdf->SetAutoPageBreak(true, PDF_MARGIN_BOTTOM);
    $pdf->SetAuthor('SYS CBTEKNO');
    $pdf->SetDisplayMode('real', 'default');
    $pdf->SetFont('helvetica', '', '10' , '', 'default', true );

    $pdf->AddPage();

    $no = 1;
    $dt = "";
    foreach ($q as $v) {
        $dt.='
            <tr >
                <td align="center">'.$no.'</td>
                <td>'.$v->nama_supplier.'</td>
                <td>
                    Telp : '.$v->telp.'<br>
                    Email : '.$v->email.'
                </td>
                <td>'.$v->alamat.'</td>
            </tr>
        ';
        $no++;
    }

    $html = '

        <center><h3>Data Vendor</h3></center>
        
        <table cellspacing="1" cellpadding="1" border="1">
            <tr>
                <td width="5%" height="25" align="center">No.</td>
                <td width="30%" align="center">Nama Vendor</td>
                <td width="35%" align="center">Kontak</td>
                <td width="30%" align="center">Alamat</td>
            </tr>
            '.$dt.'
        </table>
    ';


    $pdf->writeHTML($html, true, false, true, false, '');
    $pdf->Output('data_vendor.pdf', 'I');

?>