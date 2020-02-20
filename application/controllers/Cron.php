<?php  
defined('BASEPATH') OR exit('No direct script access allowed');

class cron extends CI_Controller {

    function __construct(){
        parent::__construct();
        date_default_timezone_set("Asia/Jakarta");
        //$this->load->model('pitstop/Penjualan_model','md');
        $this->load->model("Lnd_model", "lnd");

    }

    function index(){
    	echo "Index of Cron.<br> By : <strong>Lundara</strong>";
    }

    public function test(){

    	$this->lnd->send_wa("082317549221", "Jangan Lupa sholat dan makan ya.....");

    }
}



?>