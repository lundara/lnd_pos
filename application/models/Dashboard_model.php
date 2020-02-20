<?php
defined('BASEPATH') OR exit('No direct script access allowed');
 
class Dashboard_model extends CI_Model {
   
    public function __construct()
    {
        parent::__construct();
        $this->load->database();

        $this->load->model("Lnd_model", "lnd");
    }

    public function jml_data($per, $db, $ord){


      switch ($per) {
        case 'Hari':
          

          if ($ord=="tgl_po") {
            $this->db->where("$ord", date("Y-m-d"));
          }
          else{
            $this->db->where("DATE($ord)", date("Y-m-d"));
          }
        break;
        case 'Bulan':
          $this->db->where("MONTH(".$ord.")", date("m"));
          $this->db->where("YEAR(".$ord.")", date("Y"));

        break;
        
        default:
          
        break;
      }

      $x = $this->db->get($db)->num_rows();

      return $x;

    }

    function aset_produk(){

      $sl = "
        pitstop_stok.*,
        pitstop_produk.id AS produkid,
        pitstop_produk.nama_produk,
        pitstop_produk.modal,
        pitstop_produk.harga,
        SUM(pitstop_produk.modal * pitstop_stok.qty) AS ttl
      ";
      $this->db->select($sl);
      $this->db->from("pitstop_stok");
      $this->db->join("pitstop_produk", "pitstop_produk.id = pitstop_stok.idproduk");
      $d = $this->db->get()->row_array();

      return number_format($d["ttl"],0,",",".");

    }

    function aktivitas($divisi){
        $n = date_create(date('Y-m-d'));
        date_add($n, date_interval_create_from_date_string('-7 days'));

      $sl = "
        aktivitas.*,
        user.username,
        user.nama,
        user.foto

      ";
      $this->db->select($sl);
      $this->db->from("aktivitas");
      $this->db->join("user", "user.username = aktivitas.iduser");
      //$this->db->where("iduser!=", "lundara");
      $this->db->where("DATE(tgl)>=", date_format($n, 'Y-m-d'));
      $this->db->where("aktivitas.divisi", $divisi);
      $this->db->order_by("tgl", "DESC");
      $x = $this->db->get()->result();

      return $x;

    }
    
    function persediaan_kelbar(){

      $dtuser = $this->lnd->me();

        $sper = "
          stok.*,
          produk.id AS produkid,
          produk.nama_produk,
          produk.harga,
          produk.modal,
          kelbar.id AS klid,
          kelbar.kelbar,
          SUM( (stok.stok * produk.modal) ) AS sedia
        ";


        $this->db->select($sper);
        $this->db->from("stok");
        $this->db->join("produk", "produk.id = stok.idproduk");
        $this->db->join("kelbar", "kelbar.id = produk.idkelbar");
        $this->db->where("idcabang", $dtuser['idcabang']);
        $this->db->where("kelbar.kelbar", "OTC");
        $otc = $this->db->get()->row_array();

        $this->db->select($sper);
        $this->db->from("stok");
        $this->db->join("produk", "produk.id = stok.idproduk");
        $this->db->join("kelbar", "kelbar.id = produk.idkelbar");
        $this->db->where("idcabang", $dtuser['idcabang']);
        $this->db->where("kelbar.kelbar", "Dispensing");
        $disp = $this->db->get()->row_array();

        $this->db->select($sper);
        $this->db->from("stok");
        $this->db->join("produk", "produk.id = stok.idproduk");
        $this->db->join("kelbar", "kelbar.id = produk.idkelbar");
        $this->db->where("idcabang", $dtuser['idcabang']);
        $this->db->where("kelbar.kelbar", "Resep");
        $rsp = $this->db->get()->row_array();

        $this->db->select($sper);
        $this->db->from("stok");
        $this->db->join("produk", "produk.id = stok.idproduk");
        $this->db->join("kelbar", "kelbar.id = produk.idkelbar");
        $this->db->where("idcabang", $dtuser['idcabang']);
        $this->db->where("kelbar.kelbar", "Generik");
        $gnk = $this->db->get()->row_array();

        $this->db->select($sper);
        $this->db->from("stok");
        $this->db->join("produk", "produk.id = stok.idproduk");
        $this->db->join("kelbar", "kelbar.id = produk.idkelbar");
        $this->db->where("idcabang", $dtuser['idcabang']);
        $this->db->where("kelbar.kelbar", "Herbal");
        $hrb = $this->db->get()->row_array();

        $this->db->select($sper);
        $this->db->from("stok");
        $this->db->join("produk", "produk.id = stok.idproduk");
        $this->db->join("kelbar", "kelbar.id = produk.idkelbar");
        $this->db->where("idcabang", $dtuser['idcabang']);
        $this->db->where("kelbar.kelbar", "Alkes");
        $alk = $this->db->get()->row_array();

        $persediaan = array(
              "otc"   => $otc["sedia"],
              "disp"  => $disp["sedia"],
              "rsp"   => $rsp["sedia"],
              "gnk"   => $gnk["sedia"],
              "hrb"   => $hrb["sedia"],
              "alk"   => $alk["sedia"]
          );

        return $persediaan;

    }

    function grafik_penjualan($h, $d){
        $dtuser = $this->lnd->me();

        $m = date_create(date('Y-m-d'));
        date_add($m, date_interval_create_from_date_string('-7 days'));

        $n = date_create(date_format($m, 'Y-m-d'));
        
        $arr["tgl"][] = date("Y-m-d");
        $json="[";
        $no = 1;
        for($i = 0;$i <7;$i++){
          date_add($n, date_interval_create_from_date_string('+1 days'));
          //echo date_format($n, 'Y-m-d').", ";

          $arr["tgl"][]= date_format($n, 'Y-m-d');
          if ($no > 1) {
            $json.=", ";
          }
          $sl = "
              ".$d.".id,
              ".$d.".no_trans,
              ".$d.".harga,
              ".$d.".qty,
              ".$d.".disc,
              SUM( (".$d.".harga * ".$d.".qty ) - ( (".$d.".harga * ".$d.".qty) * ".$d.".disc/100 ) ) AS gg,
              ".$h.".no_trans,
              ".$h.".created_on,
              DATE_FORMAT(".$h.".created_on, '%Y-%m-%d') AS tgl
            ";
            $this->db->select($sl);
            $this->db->from($d);
            $this->db->join($h, $d.".no_trans = ".$h.".no_trans", "left outer");
            $this->db->where('DATE('.$h.'.created_on)', date_format($n, 'Y-m-d'));
            $this->db->where("pitstop_penjualan.lunas", "Y");
            $this->db->where($h.".status", "POSTED");
            $dw = $this->db->get()->row_array();

            $slj = "
                  pitstop_penjualan.*,
                  SUM(pitstop_penjualan.jasa) AS total
                ";
            $this->db->select($slj);
            $this->db->from("pitstop_penjualan");
            $this->db->where("DATE(pitstop_penjualan.created_on)", date_format($n, 'Y-m-d'));
            $this->db->where("pitstop_penjualan.lunas", "Y");
            $this->db->where("pitstop_penjualan.status", "POSTED");
            $js = $this->db->get()->row_array();

            //echo date_format($n, 'Y-m-d')."=".($dw["gg"]+$js["total"])."<BR>";

            $dt=array(
                    date_format($n, 'd/m/Y'),
                    ($dw["gg"]+$js["total"]),
                    date_format($n, 'Y-m-d')
                  );
            $no++;
            $json.=json_encode($dt);
        }
        $json.="]";

        return $json;
    }

    function total_penjualan_pitstop($h, $d){

        $this->load->model("Lnd_model", "lnd");

        $dtuser = $this->lnd->me();

        $slhari = "
          ".$h.".*,
          ".$d.".id AS pjid,
          ".$d.".qty,
          ".$d.".harga,
          ".$d.".disc,
          ".$d.".no_trans,
        ";
        $this->db->select($slhari);
        $this->db->from("".$h."");
        $this->db->join("".$d."", "".$d.".no_trans = ".$h.".no_trans");
        $this->db->where("date(".$h.".created_on)", date("Y-m-d"));
        $this->db->where("lunas", "Y");
        $this->db->where("status", "POSTED");
        $pj = $this->db->get()->result();

        $total_hari = 0;
        foreach ($pj as $vpj) {
          
          $total_hari = $total_hari + ( ($vpj->harga * $vpj->qty ) - (($vpj->harga * $vpj->qty) * $vpj->disc/100) );

        }  

        $slbln = "
          ".$h.".*,
          ".$d.".id AS pjid,
          ".$d.".qty,
          ".$d.".harga,
          ".$d.".disc,
          ".$d.".no_trans,
        ";
        $this->db->select($slbln);
        $this->db->from("".$h."");
        $this->db->join("".$d."", "".$d.".no_trans = ".$h.".no_trans");
        $this->db->where("MONTH(".$h.".created_on)", date("m"));
        $this->db->where("YEAR(".$h.".created_on)", date("Y"));
        $this->db->where("lunas", "Y");
        $this->db->where($h.".status", "POSTED");
        $pjbln = $this->db->get()->result();



        $total_bulan = 0;
        foreach ($pjbln as $vbln) {
          
          $total_bulan = $total_bulan + (($vbln->harga * $vbln->qty ) - (($vbln->harga * $vbln->qty) * $vbln->disc/100) );

        }   

        $sj = "
          ".$h.".*,
          SUM(".$h.".jasa) AS total_jasa
        ";

        $this->db->select($sj);
        $this->db->from("pitstop_penjualan");
        $this->db->where("MONTH(".$h.".created_on)", date("m"));
        $this->db->where("YEAR(".$h.".created_on)", date("Y"));
        $this->db->where("lunas", "Y");
        $this->db->where($h.".status", "POSTED");
        $jsb = $this->db->get()->row_array();
  
        $this->db->select($sj);
        $this->db->from("pitstop_penjualan");
        $this->db->where("date(".$h.".created_on)", date("Y-m-d"));
        $this->db->where("lunas", "Y");
        $this->db->where($h.".status", "POSTED");
        $jsh = $this->db->get()->row_array();     

        $v = array(
                "pjhari"    => number_format($total_hari+$jsh["total_jasa"], 0, ",", "."),
                "pjbln"     => number_format($total_bulan+$jsb["total_jasa"], 0, ",", ".")
            );

        return $v;
    }
    function total_pembelian_pitstop($h, $d){

        $this->load->model("Lnd_model", "lnd");

        $dtuser = $this->lnd->me();

        $slhari = "
          ".$h.".*,
          ".$d.".id AS pjid,
          ".$d.".qty,
          ".$d.".harga,
          ".$d.".disc,
          ".$d.".no_trans,
        ";
        $this->db->select($slhari);
        $this->db->from("".$h."");
        $this->db->join("".$d."", "".$d.".no_trans = ".$h.".no_trans");
        $this->db->where("date(".$h.".tgl_inv)", date("Y-m-d"));
        $pj = $this->db->get()->result();

        $total_hari = 0;
        foreach ($pj as $vpj) {
          
          $total_hari = $total_hari + ( ($vpj->harga * $vpj->qty ) - (($vpj->harga * $vpj->qty) * $vpj->disc/100) );

        }  

        $slbln = "
          ".$h.".*,
          ".$d.".id AS pjid,
          ".$d.".qty,
          ".$d.".harga,
          ".$d.".disc,
          ".$d.".no_trans,
        ";
        $this->db->select($slbln);
        $this->db->from("".$h."");
        $this->db->join("".$d."", "".$d.".no_trans = ".$h.".no_trans");
        $this->db->where("MONTH(".$h.".tgl_inv)", date("m"));
        $this->db->where("YEAR(".$h.".tgl_inv)", date("Y"));
        $pjbln = $this->db->get()->result();



        $total_bulan = 0;
        foreach ($pjbln as $vbln) {
          
          $total_bulan = $total_bulan + (($vbln->harga * $vbln->qty ) - (($vbln->harga * $vbln->qty) * $vbln->disc/100) );

        }   
    

        $v = array(
                "blhari"    => number_format($total_hari, 0, ",", "."),
                "blbln"     => number_format($total_bulan, 0, ",", ".")
            );

        return $v;
    }
    function total_jasa_pitstop($h, $d){

        $this->load->model("Lnd_model", "lnd");

        $dtuser = $this->lnd->me();
 
        $sj = "
          ".$h.".*,
          SUM(".$h.".jasa) AS total_jasa
        ";

        $this->db->select($sj);
        $this->db->from("pitstop_penjualan");
        $this->db->where("MONTH(".$h.".created_on)", date("m"));
        $this->db->where("YEAR(".$h.".created_on)", date("Y"));
        $this->db->where("lunas", "Y");
        $this->db->where($h.".status", "POSTED");
        $jsb = $this->db->get()->row_array();
  
        $this->db->select($sj);
        $this->db->from("pitstop_penjualan");
        $this->db->where("date(".$h.".created_on)", date("Y-m-d"));
        $this->db->where("lunas", "Y");
        $this->db->where($h.".status", "POSTED");
        $jsh = $this->db->get()->row_array();     

        $v = array(
                "jshari"    => number_format($jsh["total_jasa"], 0, ",", "."),
                "jsbln"     => number_format($jsb["total_jasa"], 0, ",", ".")
            );

        return $v;
    }
 
}