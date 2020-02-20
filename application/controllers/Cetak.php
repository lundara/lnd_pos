<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class cetak extends CI_Controller {

    function __construct(){
        parent::__construct();
        date_default_timezone_set("Asia/Jakarta");

        $this->load->model("Lnd_model", "lnd");
    }

	public function index(){
		echo "Index of Cetak";
	}

  function vendor(){
      $this->db->order_by("nama_supplier", "ASC");
      $d = $this->db->get("supplier")->result();

      $x= "
        <div style='padding:30px;'>
          <table>
            <tr>
              <td width='10%'>No</td>
              <td>Nama Vendor</td>
              <td>Kontak</td>
              <td>Alamat</td>
            </tr>
        
      ";
      $no = 1;
      foreach ($d as $v) {
          $x.="
            <tr>
            <td width='10%'>".$no."</td>
            <td>".$v->nama_supplier."</td>
            <td>Telp : ".$v->telp."</td>
            <td>".$v->alamat."</td>
          </tr>
          ";
          $no++;
      }

      $x.= "</table></div>";


      echo $x;

  }


	
}
