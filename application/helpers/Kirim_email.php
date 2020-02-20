<?php 
 
if (!defined('BASEPATH'))
    exit('No direct script access allowed');
 
function function KIRIM_EMAIL($judul,$pesan,$tujuanemail){
  
  if ($judul == '') {
     return "Judul Harus di isi";
  } elseif ($pesan == '') {
     return "Deskripsi Email Harus di isi";
  } elseif ($tujuanemail == '') {
     return "Email Tujuan Harus di isi";     
  } else {

	$vtemplate = "<center><img src='". base_url() ."assets/logo-izi.png'></center>";
	$vtemplate .= "<div style='padding:10px; background:#a1c92a; text-align:center;'>". $judul ."</div>";
	$vtemplate .= "<div style='min-height:100px; background:#fff; border:1px solid #a1c92a; padding:15px;'>". $pesan ."</div>";
	
        $this->load->library('email');
        
        $config['protocol'] = 'smtp';
        $config['smtp_host'] = 'mail.smtp2go.com';
        $config['smtp_port'] = '25'; // 8025, 587 and 25 can also be used. Use Port 465 for SSL.
        //$config['smtp_crypto'] = 'tls';
        $config['smtp_user'] = 'info@edumatic.info';
        $config['smtp_pass'] = 'T4E451110';
        $config['charset'] = 'iso-8859-1';
        $config['wordwrap'] = TRUE;        
        $config['mailtype'] = 'html';
        
        $this->email->initialize($config);

        $this->email->from('info@edumatic.info', 'IZI Notifikasi');
        $this->email->to($tujuanemail);
        $this->email->subject($judul);
        $this->email->message($vtemplate);

        try{
            $this->email->send();
            return "yes";
        }catch(Exception $e){
            echo $e->getMessage();
        }
  }     
}
 
?>