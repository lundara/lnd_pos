<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class dashboard extends CI_Controller {

    function __construct(){
        parent::__construct();
        date_default_timezone_set("Asia/Jakarta");

        $this->load->model("Lnd_model", "lnd");
        $this->load->model("Dashboard_model", "dashboard");
        
       if(!$this->session->userdata('lnd_id'))
       {
        	redirect('login');
       }
    }


	public function index(){

    $dtuser = $this->lnd->me();

    $data["menu"]     = "dashboard";
    $data["submenu"]  = "";
		$data["page"]	    = "dashboard";


		$this->load->view('main', $data);
		
	}

  function ggwp(){
    $arr="";
    $json="[";
    for($x=1;$x<=5;$x++){
      if ($x>1) {
        $json.=", ";
      }
      $are="";
      for($z=1;$z<=2;$z++){
        $are = array(
            "one" => $z
          );
      }

      if ($x==3) {
        $arr = array(
            "two" => $are,
          );
      }
      else{
       $arr = array(
            "two" => $x,
          );
      }


      $json.=json_encode($arr);
    }
    $json.="]";

    //$m=print_r($arr);
    echo $json."<br>";

    $a = json_decode($json, true);

    print_r($a);
    echo "<br>";
    for($q=0;$q < count($a);$q++){
      if ($q==2) {
        echo $a[$q]["two"]["one"]." ";
      }
      else{
        echo $a[$q]["two"]." ";
      }
    }

    //$d=array("nama_satuan"=>$m);
    //$this->db->insert("satuan", $d);
  }

  function pitstop(){
    $gjual   = $this->dashboard->grafik_penjualan("pitstop_penjualan", "pitstop_penjualan_detail");


    $data["gjual"]    = $gjual;
    $data["menu"]     = "dashboard";
    $data["submenu"]  = "";
    $data["page"]     = "pitstop_dashboard";
    $dtuser = $this->lnd->me();


    $this->load->view('main', $data);
  }

  function aktivitas(){
    $act = $this->dashboard->aktivitas("cbtekno");


    $json = "[";
    $no = 1;
    foreach ($act as $v) {
      
      if ($no>1) {
        $json.=", ";
      }

      $dt = array(
          "tgl"         => $this->lnd->berlalu($v->tgl),
          "deskripsi"   => $v->deskripsi,
          "jenis"       => $v->jenis_aktivitas,
          "nama"        => $v->nama,
          "foto"        => $v->foto
        );

      $json.=json_encode($dt);
      $no++;

    }
    $json.="]";

    echo $json;
  }
  function aktivitas_pitstop(){
    $act = $this->dashboard->aktivitas("pitstop");


    $json = "[";
    $no = 1;
    foreach ($act as $v) {
      
      if ($no>1) {
        $json.=", ";
      }

      $dt = array(
          "tgl"         => $this->lnd->berlalu($v->tgl),
          "deskripsi"   => $v->deskripsi,
          "jenis"       => $v->jenis_aktivitas,
          "nama"        => $v->nama,
          "foto"        => $v->foto
        );

      $json.=json_encode($dt);
      $no++;

    }
    $json.="]";

    echo $json;
  }
  function cron(){

    $quot_hari  = $this->dashboard->jml_data("Hari", "quotation", "created_on");
    $quot_bulan = $this->dashboard->jml_data("Bulan", "quotation","created_on");

    $inq_hari  = $this->dashboard->jml_data("Hari", "inquiry", "created_on");
    $inq_bulan = $this->dashboard->jml_data("Bulan", "inquiry", "created_on");

    $po_in_hari  = $this->dashboard->jml_data("Hari", "po_in", "tgl_po");
    $po_in_bulan = $this->dashboard->jml_data("Bulan", "po_in", "tgl_po");

    $po_out_hari  = $this->dashboard->jml_data("Hari", "po_out", "created_on");
    $po_out_bulan = $this->dashboard->jml_data("Bulan", "po_out", "created_on");

    $inv_out_hari  = $this->dashboard->jml_data("Hari", "invoice_out", "created_on");
    $inv_out_bln = $this->dashboard->jml_data("Bulan", "invoice_out", "created_on");

    $dt = array(
        "quot_hari"     => $quot_hari,
        "quot_bulan"    => $quot_bulan,
        "inq_hari"      => $inq_hari,
        "inq_bulan"     => $inq_bulan,
        "po_in_hari"    => $po_in_hari,
        "po_in_bulan"   => $po_in_bulan,
        "po_out_hari"   => $po_out_hari,
        "po_out_bulan"  => $po_out_bulan,
        "inv_out_hari"  => $inv_out_hari,
        "inv_out_bln"   => $inv_out_bln

      );

    $json="[";
    $json.=json_encode($dt);
    $json.="]";

    echo $json;
  }
  function cron_pitstop(){

    $jual = $this->dashboard->total_penjualan_pitstop("pitstop_penjualan", "pitstop_penjualan_detail");
    $beli = $this->dashboard->total_pembelian_pitstop("pitstop_pembelian", "pitstop_pembelian_detail");
    $jasa = $this->dashboard->total_jasa_pitstop("pitstop_penjualan", "pitstop_penjualan_detail");
    $aset = $this->dashboard->aset_produk();
    $produk = $this->db->get("pitstop_produk")->num_rows();

    $dt = array(
        "jual_hari"   => $jual["pjhari"],
        "jual_bln"    => $jual["pjbln"],
        "beli_hari"   => $beli["blhari"],
        "beli_bln"    => $beli["blbln"],
        "jasa_hari"   => $jasa["jshari"],
        "jasa_bln"    => $jasa["jsbln"],
        "aset"        => $aset,
        "produk"      => $produk
      );

    $json="[";
    $json.=json_encode($dt);
    $json.="]";

    echo $json;
  }



	
}
