<?php


class userFungsi extends CI_Controller
{
	protected $_ci;
	
	private $crm_url = 'http://localhost/dev/vtiger/webservice.php';
	private $crm_username = 'admin';
	private $crm_password = 'admin';
	private $crm_user_access_key = 'S0XaW4zgI8ADJH';

	private $edonasi_url = 'http://localhost/dev/edonasi/example/';
	private $edonasi_username = 'admin';
	private $edonasi_password = 'admin';
	private $edonasi_user_access_key = 'S0XaW4zgI8ADJH';

	function __construct()
	{
		$this->_ci =& get_instance();
	}


	
	
	public function clean_str($string) {
	   //$string = str_replace(' ', '-', $string); // Replaces all spaces with hyphens.

	   return preg_replace('/[^A-Za-z0-9\-]/', '', $string); // Removes special chars.
	}
	
 	public function paginasi($elem,$tbl,$val,$hal,$jml_page){
		
		//gettabel($('#tbl-transfer'),'tbl-transfer','','');
		//gettabel(elem,tbl,val,hal)
		
		$md = '';
		if ($jml_page < 11){
			for ($i = 1; $i < ($jml_page + 1);$i++){
				if ($i == $hal){
					$md .= '<li class="active"><a href="javascript:;">'.$i.'</a></li>';
				} else {
					$md .= '<li><a onclick="gettabel(\''.$elem.'\',\''.$tbl.'\',\''.$val.'\','.$i.');" href="javascript:;">'.$i.'</a></li>';
				}
			}
		
		} else {
			if ($hal < 6){
				for ($i = 1; $i < 11;$i++){
					if ($i == $hal){
						$md .= '<li class="active"><a href="javascript:;">'.$i.'</a></li>';
					} else {
						$md .= '<li><a onclick="gettabel(\''.$elem.'\',\''.$tbl.'\',\''.$val.'\','.$i.');" href="javascript:;">'.$i.'</a></li>';
					}
				}
			} else if ($hal > ($jml_page - 5)){
				for ($i = ($jml_page - 6); $i < ($jml_page + 1);$i++){
					if ($i == $hal){
						$md .= '<li class="active"><a href="javascript:;">'.$i.'</a></li>';
					} else {
						$md .= '<li><a onclick="gettabel(\''.$elem.'\',\''.$tbl.'\',\''.$val.'\','.$i.');">'.$i.'</a></li>';
					}
				}
			} else {
				for ($i = ($hal - 4); $i < ($hal + 5);$i++){
					if ($i == $hal){
						$md .= '<li class="active"><a href="javascript:;">'.$i.'</a></li>';
					} else {
						$md .= '<li><a onclick="gettabel(\''.$elem.'\',\''.$tbl.'\',\''.$val.'\','.$i.');" href="javascript:;">'.$i.'</a></li>';
					}
				}
			}
		}
		
		
		
		if ($hal == 1){
			$pg = '
				<li class="disabled"><a href="javascript:;"><i class="icon icon-first"></i></a></li>
				<li class="disabled"><a href="javascript:;"><i class="icon icon-previous2"></i></a></li>
				'.$md.'                                   
				<li><a onclick="gettabel(\''.$elem.'\',\''.$tbl.'\',\''.$val.'\',2);" href="javascript:;"><i class="icon icon-next2"></i></a></li>
				<li><a onclick="gettabel(\''.$elem.'\',\''.$tbl.'\',\''.$val.'\','.$jml_page.');" href="javascript:;"><i class="icon icon-last"></i></a></li>
			';
		} else if ($hal == $jml_page){
			$pg = '
				<li><a onclick="gettabel(\''.$elem.'\',\''.$tbl.'\',\''.$val.'\',1);" href="javascript:;"><i class="icon icon-first"></i></a></li>
				<li><a onclick="gettabel(\''.$elem.'\',\''.$tbl.'\',\''.$val.'\','.($jml_page-1).');" href="javascript:;"><i class="icon icon-previous2"></i></a></li>
				'.$md.'                                   
				<li class="disabled"><a href="javascript:;"><i class="icon icon-next2"></i></a></li>
				<li class="disabled"><a href="javascript:;"><i class="icon icon-last"></i></a></li>
			';
		} else {
			$pg = '
				<li><a onclick="gettabel(\''.$elem.'\',\''.$tbl.'\',\''.$val.'\',1);" href="javascript:;"><i class="icon icon-first"></i></a></li>
				<li><a onclick="gettabel(\''.$elem.'\',\''.$tbl.'\',\''.$val.'\','.($hal-1).');" href="javascript:;"><i class="icon icon-previous2"></i></a></li>
				'.$md.'                                   
				<li><a onclick="gettabel(\''.$elem.'\',\''.$tbl.'\',\''.$val.'\','.($hal+1).');" href="javascript:;"><i class="icon icon-next2"></i></a></li>
				<li><a onclick="gettabel(\''.$elem.'\',\''.$tbl.'\',\''.$val.'\','.$jml_page.');" href="javascript:;"><i class="icon icon-last"></i></a></li>
			';
		}



		if ($jml_page < 2){
			$pg = '';
		} else {
			$pg = '
			<div class="row">
				<div class="col-sm-2 col-xs-12">
					<div class="input-group m-t-10">
						<input placeholder="Go To Page" class="gotopage form-control p-5" style="height: 32px;" type="text">
						<span class="input-group-btn">
							<button onclick="gettabel(\''.$elem.'\',\''.$tbl.'\',\''.$val.'\',$(\'.gotopage\').val());" type="button" style="padding: 5px;" class="btn waves-effect waves-light btn-info f-12">Go!</button>
						</span> 
					</div>
				</div>
				<div class="col-sm-8 col-xs-12 text-left">
					<ul class="pagination push-down-20 m-t-10 m-b-10">
						'.$pg.'
					</ul>
				</div>
			</div>';
		}

		return $pg;
	}

	
	public function getfromurl($tipe,$url)
    {
        $user_agent='Mozilla/5.0 (Windows NT 6.1; rv:8.0) Gecko/20100101 Firefox/8.0';

		if ($tipe == "POST") { $pst = true; } else { $pst = false; }
		
        $options = array(

            CURLOPT_CUSTOMREQUEST  =>$tipe,        //set request type post or get
            CURLOPT_POST           =>$pst,        //set to GET
            CURLOPT_USERAGENT      => $user_agent, //set user agent
            CURLOPT_COOKIEFILE     =>"cookie.txt", //set cookie file
            CURLOPT_COOKIEJAR      =>"cookie.txt", //set cookie jar
            CURLOPT_RETURNTRANSFER => true,     // return web page
            CURLOPT_HEADER         => false,    // don't return headers
            CURLOPT_FOLLOWLOCATION => true,     // follow redirects
            CURLOPT_ENCODING       => "",       // handle all encodings
            CURLOPT_AUTOREFERER    => true,     // set referer on redirect
            CURLOPT_CONNECTTIMEOUT => 120,      // timeout on connect
            CURLOPT_TIMEOUT        => 120,      // timeout on response
            CURLOPT_MAXREDIRS      => 10,       // stop after 10 redirects
        );

        $ch      = curl_init( $url );
        curl_setopt_array( $ch, $options );
        $content = curl_exec( $ch );
        $err     = curl_errno( $ch );
        $errmsg  = curl_error( $ch );
        $header  = curl_getinfo( $ch );
        curl_close( $ch );

        $header['errno']   = $err;
        $header['errmsg']  = $errmsg;
        $header['content'] = $content;
        return $header;
		
    }
	
	public function call_crm($url, $params, $type = "GET")
	{
		$is_post = 0;
		if ($type == "POST") {
			$is_post = 1;
			$post_data = $params;
		} else {
			$url = $url . "?" . http_build_query($params);
		}
		$ch = curl_init($url);
		if (!$ch) {
			die("Cannot allocate a new PHP-CURL handle");
		}
		if ($is_post) {
			curl_setopt($ch, CURLOPT_POST, $is_post);
			curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($params));
		}

		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		$data = curl_exec($ch);

		$return = null;
		if (curl_error($ch)) {
			$return = false;
		} else {
			$return = json_decode($data, true);
		}

		curl_close($ch);

		return $return;
	}
	
	
	public function getsesID()
	{
		$endpointUrl = 'http://localhost:84/vtigercrm/webservice.php';
		$userName = 'admin';
		$password = 'admin';
		$userAccessKey = 'r6jbXe2rZmGFeQJY';

		$sessionData = $this->call_crm($endpointUrl, array("operation" => "getchallenge", "username" => $userName));
		$challengeToken = $sessionData['result']['token'];
		$generatedKey = md5($challengeToken . $userAccessKey);
		$dataDetails = $this->call_crm($endpointUrl, array("operation" => "login", "username" => $userName, "accessKey" => $generatedKey), "POST");

		$sessionid = $dataDetails['result']['sessionName'];
		
		return $sessionid;
		
		/*
		
		if(!isset($params["assigned_user_id"]))
			
			$params["assigned_user_id"]=$userName;
		
			$data=json_encode($params);
		
			$add_contact = $this->call_crm($endpointUrl, array("operation" => "create", "sessionName" => $sessionid,"element"=>$data ,'elementType' => 'Contacts'),"POST");
		
		
		var_dump($add_contact['result']);
		
		if (!empty($add_contact['result'])) {
		    return "1";
		} else {
		    return "0";
		}
		
		*/
	}
	
	
	
	
	
}



/*

function clean_str($string) {
   //$string = str_replace(' ', '-', $string); // Replaces all spaces with hyphens.

   return preg_replace('/[^A-Za-z0-9\-]/', '', $string); // Removes special chars.
}

function getdataolah($prshn,$idx,$segprod,$segpas,$pj){
	if ($prshn == "air"){
		$id = 'olah-'.$idx.'-'.$segprod.$segpas.$pj;
		$rslt = mysql_query("SELECT * FROM tbl_olahan WHERE id_hrgref = '".$idx."' AND prshn = '".$prshn."' AND id_strategi = '".$id."' ORDER BY id ASC");
		while ($row = mysql_fetch_array($rslt, MYSQL_ASSOC)) {
			return [$row["tgl_mulai"],$row["tgl_selesai"],$row["harga"]];
		}
	} else {
		$rslt = mysql_query("SELECT * FROM tbl_olahan WHERE id_hrgref = '".$idx."' AND prshn = '".$prshn."' ORDER BY id ASC");
		while ($row = mysql_fetch_array($rslt, MYSQL_ASSOC)) {
			return [$row["tgl_mulai"],$row["tgl_selesai"],$row["harga"]];
		}
	}
}

function gethrgakhir($idhrgref,$hpm,$disk){
	$rslt = mysql_query("SELECT * FROM tbl_hrgref WHERE id = ".$idhrgref);
	while ($row = mysql_fetch_array($rslt, MYSQL_ASSOC)) {
		$kdbrg = $row["kd_item"];
		$diskon	= $row["diskon"];
		$modal	= $row["diskon"];
		$id_hist	= $row["id_hist"];
		$id_hist_strategi_bbi	= $row["id_hist_strategi_bbi"];
		$id_hist_strategi_air	= $row["id_hist_strategi_air"];
		
	}
	
	if ($disk == ""){
		$disk = $diskon;
	}
	
	if($hpm == ""){
		$hpm = $hpm;
	}
	
	
	//bbi buy 
	$beli = floatval($hpm) * (1 - floatval($disk));
	$bbi_buy = Array("segmen_produk"=>$row["segmen_produk"],"kode_brg"=>$row["kd_item"],"diskon"=>$disk,"hnappn"=>$hpm,"harga_beli"=>$beli);

	//bbi sell 
	$rslt = mysql_query("SELECT * FROM tbl_strategi WHERE id_hist = '".$id_hist_strategi_bbi."'");
	$rows = [];
	while ($row = mysql_fetch_array($rslt, MYSQL_ASSOC)) {
		$rows[] = $row;
	}
	
	$sql = "
	SELECT
	tbl_hrgref.id,
	master_barang.id_segprod,
	master_barang.segmen_produk,
	tbl_hrgref.kd_item,
	master_barang.nama_brg,
	tbl_hrgref.diskon,
	0 AS diskon_bbi,
	tbl_hrgref.hpm,
	0 AS harga_jadi,
	0 AS profit_bbi,
	tbl_hrgref.ket,
	olahan.tgl_mulai,
	olahan.tgl_selesai,
	olahan.harga
	FROM
	tbl_hrgref
	INNER JOIN master_barang ON tbl_hrgref.kd_item = master_barang.kode_brg
	LEFT JOIN (SELECT * FROM tbl_olahan WHERE prshn = 'bbi') AS olahan ON tbl_hrgref.id = olahan.id_hrgref
	WHERE
	tbl_hrgref.id = ".$idhrgref."
	ORDER BY
	master_barang.segmen_produk, tbl_hrgref.kd_item
	";
	
	$rslt = mysql_query($sql);
	$tr = "";
	while ($row = mysql_fetch_array($rslt, MYSQL_ASSOC)) {
		$stmp = $rows;
		foreach($stmp as $key=>$val){
			if ($row["id_segprod"] != $val["id_segprod"]){
				unset($stmp[$key]);
			}
		}
		$stmp = array_values($stmp);
		$id_stra = '';
		if (count($stmp) == 1){
			$srcharga = $stmp[0]["smb_harga"];
			if ($srcharga == "Harga Jadi"){
				$hrg = floatval($hpm) * (1 - floatval($disk)); 
			} else if ($srcharga == "HNA+PPN"){
				$hrg = floatval($hpm);
			}
			$profit = floatval($stmp[0]["nilai"]);
			$hrgakhir = floatval($hrg) * (1 + floatval($profit));
			
			if (floatval($disk) > $profit){
				$disbbi = floatval($disk) - $profit;
			} else {
				$disbbi = 0;
			}
			
			$id_stra = $stmp[0]["id"]; 
			
			
		} else {
			$diskon = floatval($disk);
			foreach($stmp as $key=>$val){
				if ($diskon >= $val["diskon_bawah"] && $diskon <= $val["diskon_atas"]){
					$srcharga = $val["smb_harga"];
					if ($srcharga == "Harga Jadi"){
						$hrg = floatval($hpm) * (1 - floatval($disk)); 
					} else if ($srcharga == "HNA+PPN"){
						$hrg = floatval($hpm);
					}
					$profit = floatval($val["nilai"]);
					$hrgakhir = floatval($hrg) * (1 + floatval($profit));
					if (floatval($disk) > $profit){
						$disbbi = floatval($disk) - $profit;
					} else {
						$disbbi = 0;
					}
					$id_stra = $val["id"]; 
				}
			}
		}
		
		if ($row["tgl_mulai"] == "" && $row["tgl_selesai"] == ""){
			if ($row["harga"] != ""){
				$hrgakhir = $row["harga"];
			}
		} else {
			if ($skr >= $row["tgl_mulai"] && $skr <= $row["tgl_selesai"]){
				$hrgakhir = $row["harga"];
			} 
		}
		
		
		
		$bbi_sell = Array("segmen_produk"=>$row["segmen_produk"],"kode_brg"=>$row["kd_item"],"diskon"=>$disk,"diskon_bbi"=>$disbbi,"hnappn"=>$hpm,"harga_jadi"=>$hrg,"profit_bbi"=>$profit,"jual_bbi"=>$hrgakhir);

	}

	//air buy
	$rslt = mysql_query("SELECT * FROM tbl_strategi WHERE id_hist = '".$id_hist_strategi_bbi."'");
	$rows = [];
	while ($row = mysql_fetch_array($rslt, MYSQL_ASSOC)) {
		$rows[] = $row;
	}
	
	$sql = "
	SELECT
	tbl_hrgref.id,
	master_barang.id_segprod,
	master_barang.segmen_produk,
	tbl_hrgref.kd_item,
	master_barang.nama_brg,
	tbl_hrgref.diskon,
	0 AS diskon_bbi,
	tbl_hrgref.hpm,
	0 AS harga_jadi,
	0 AS profit_bbi,
	tbl_hrgref.ket,
	olahan.tgl_mulai,
	olahan.tgl_selesai,
	olahan.harga
	FROM
	tbl_hrgref
	INNER JOIN master_barang ON tbl_hrgref.kd_item = master_barang.kode_brg
	LEFT JOIN (SELECT * FROM tbl_olahan WHERE prshn = 'bbi') AS olahan ON tbl_hrgref.id = olahan.id_hrgref
	WHERE
	tbl_hrgref.id = ".$idhrgref."
	ORDER BY
	master_barang.segmen_produk, tbl_hrgref.kd_item
	";
	
	$rslt = mysql_query($sql);
	$tr = "";
	while ($row = mysql_fetch_array($rslt, MYSQL_ASSOC)) {
		$stmp = $rows;
		foreach($stmp as $key=>$val){
			if ($row["id_segprod"] != $val["id_segprod"]){
				unset($stmp[$key]);
			}
		}
		$stmp = array_values($stmp);
		$id_stra = '';
		if (count($stmp) == 1){
			$srcharga = $stmp[0]["smb_harga"];
			if ($srcharga == "Harga Jadi"){
				$hrg = floatval($hpm) * (1 - floatval($disk)); 
			} else if ($srcharga == "HNA+PPN"){
				$hrg = floatval($hpm);
			}
			$profit = floatval($stmp[0]["nilai"]);
			$hrgakhir = floatval($hrg) * (1 + floatval($profit));
			
			if (floatval($disk) > $profit){
				$disbbi = floatval($disk) - $profit;
			} else {
				$disbbi = 0;
			}
			
			$id_stra = $stmp[0]["id"]; 
			
			
		} else {
			$diskon = floatval($disk);
			foreach($stmp as $key=>$val){
				if ($diskon >= $val["diskon_bawah"] && $diskon <= $val["diskon_atas"]){
					$srcharga = $val["smb_harga"];
					if ($srcharga == "Harga Jadi"){
						$hrg = floatval($hpm) * (1 - floatval($disk)); 
					} else if ($srcharga == "HNA+PPN"){
						$hrg = floatval($hpm);
					}
					$profit = floatval($val["nilai"]);
					$hrgakhir = floatval($hrg) * (1 + floatval($profit));
					if (floatval($disk) > $profit){
						$disbbi = floatval($disk) - $profit;
					} else {
						$disbbi = 0;
					}
					$id_stra = $val["id"]; 
				}
			}
		}
		
		if ($row["tgl_mulai"] == "" && $row["tgl_selesai"] == ""){
			if ($row["harga"] != ""){
				$hrgakhir = $row["harga"];
			}
		} else {
			if ($skr >= $row["tgl_mulai"] && $skr <= $row["tgl_selesai"]){
				$hrgakhir = $row["harga"];
			} 
		}
		
		$hrgbeli = floatval($hrgakhir) * (1 - (floatval($disbbi)));
		
		$air_buy = Array("segmen_produk"=>$row["segmen_produk"],"kode_brg"=>$row["kd_item"],"diskon_bbi"=>$disbbi,"harga_jadi"=>$hrgakhir,"beli_air"=>$hrgbeli);

	}
	//air sell
	$rslt = mysql_query("SELECT * FROM tbl_strategi WHERE id_hist = '".$id_hist_strategi_bbi."'");
		$rows = [];
		while ($row = mysql_fetch_array($rslt, MYSQL_ASSOC)) {
			$rows[] = $row;
		}
		
		$sql = "
		SELECT
		tbl_hrgref.id,
		master_barang.id_segprod,
		master_barang.segmen_produk,
		tbl_hrgref.kd_item,
		master_barang.nama_brg,
		tbl_hrgref.diskon,
		0 AS diskon_bbi,
		tbl_hrgref.hpm,
		0 AS harga_jadi,
		0 AS profit_bbi,
		tbl_hrgref.ket
		FROM
		tbl_hrgref
		INNER JOIN master_barang ON tbl_hrgref.kd_item = master_barang.kode_brg
		WHERE
		tbl_hrgref.id = ".$idhrgref."
		ORDER BY
		tbl_hrgref.kd_item, master_barang.segmen_produk
		";
		
		$rslt = mysql_query($sql);
		$tr = "";
		$hrgairsell = Array();
		while ($row = mysql_fetch_array($rslt, MYSQL_ASSOC)) {
			$stmp = $rows;
			foreach($stmp as $key=>$val){
				if ($row["id_segprod"] != $val["id_segprod"]){
					unset($stmp[$key]);
				}
			}
			$stmp = array_values($stmp);
			
			if (count($stmp) == 1){
				$srcharga = $stmp[0]["smb_harga"];
				if ($srcharga == "Harga Jadi"){
					$hrg = floatval($hpm) * (1 - floatval($disk)); 
				} else if ($srcharga == "HNA+PPN"){
					$hrg = floatval($hpm);
				}
				$profit = floatval($stmp[0]["nilai"]);
				$hrgakhir = floatval($hrg) * (1 + floatval($profit));
				
				if (floatval($disk) > $profit){
					$disbbi = floatval($disk) - $profit;
				} else {
					$disbbi = 0;
				}
				$id_stra = $stmp[0]["id"];
				
				$olah_bbi = getdataolah('bbi',$row["id"],"","","");
				
				
			} else {
				$diskon = floatval($disk);
				foreach($stmp as $key=>$val){
					if ($diskon >= $val["diskon_bawah"] && $diskon <= $val["diskon_atas"]){
						$srcharga = $val["smb_harga"];
						if ($srcharga == "Harga Jadi"){
							$hrg = floatval($hpm) * (1 - floatval($disk)); 
						} else if ($srcharga == "HNA+PPN"){
							$hrg = floatval($hpm);
						}
						$profit = floatval($val["nilai"]);
						$hrgakhir = floatval($hrg) * (1 + floatval($profit));
						if (floatval($disk) > $profit){
							$disbbi = floatval($disk) - $profit;
						} else {
							$disbbi = 0;
						}
						$id_stra = $val["id"];
						$olah_bbi = getdataolah('bbi',$row["id"],"","","");
					}
				}
			}
			
			//var_dump($stmp);
			$skr = date('Y-m-d');
			if ($olah_bbi[0] == "" && $olah_bbi[1] == ""){
				if ($olah_bbi[2] != ""){
					$hrgakhir = $olah_bbi[2];
				}
			} else {
				if ($skr >= $olah_bbi[0] && $skr <= $olah_bbi[1]){
					$hrgakhir = $olah_bbi[2];
				} 
			}
			
			
			$casewhen = ''; $idcasewhen = '';
			$trfld = '';
			$rsltsegpas = mysql_query("SELECT * FROM ref_polajual ORDER BY id ASC");
			while ($rowsegpas = mysql_fetch_array($rsltsegpas, MYSQL_ASSOC)) {
				$casewhen .= "SUM(CASE WHEN tbl_strategi.id_polajual = ".$rowsegpas["id"]." THEN tbl_strategi.nilai ELSE 0 END) AS pj".$rowsegpas["id"].", ";
				$idcasewhen .= "SUM(CASE WHEN tbl_strategi.id_polajual = ".$rowsegpas["id"]." THEN tbl_strategi.id ELSE 0 END) AS id".$rowsegpas["id"].", ";
				
				$trfld .= '<th class="">'.$rowsegpas["nm_pj"].'</th><th class="">->OLAH</th>';
 			}
			
			$qr1 = "SELECT
			tbl_strategi.prshn,
			tbl_strategi.id_hist,
			tbl_strategi.date_ins,
			tbl_strategi.diskon_bawah,
			tbl_strategi.diskon_atas,
			tbl_strategi.smb_diskon,
			tbl_strategi.id_user,
			tbl_strategi.id_segprod,
			tbl_strategi.id_segpas,
			ref_segpas.segpas,
			".$casewhen."
			tbl_strategi.smb_harga,
			tbl_strategi.baseon_id,
			tbl_strategi.ket
			FROM `tbl_strategi`
			LEFT JOIN ref_segpas ON tbl_strategi.id_segpas = ref_segpas.id
			WHERE tbl_strategi.id_hist = '".$id_hist_strategi_air."' AND tbl_strategi.id_segprod = '".$row["id_segprod"]."'
			GROUP BY
			tbl_strategi.prshn,
			tbl_strategi.id_hist,
			tbl_strategi.date_ins,
			tbl_strategi.diskon_bawah,
			tbl_strategi.diskon_atas,
			tbl_strategi.smb_diskon,
			tbl_strategi.id_user,
			tbl_strategi.id_segprod,
			tbl_strategi.id_segpas,
			ref_segpas.segpas,
			tbl_strategi.smb_harga,
			tbl_strategi.baseon_id,
			tbl_strategi.ket";
			
			//echo $qr1;
			
			$rslthrg = mysql_query($qr1);
			$trpj = '';
			while ($rowhrg = mysql_fetch_array($rslthrg, MYSQL_ASSOC)) {
				if ( floatval($rowhrg["diskon_bawah"]) == 0 && floatval($rowhrg["diskon_atas"]) == 0 ){ //tak ada diskon dari bbi
					if (true){ //if (floatval($disbbi) == 0){
						$tdpj = '';
						$rsltpj = mysql_query("SELECT * FROM ref_polajual ORDER BY id ASC");
						while ($rowpj = mysql_fetch_array($rsltpj, MYSQL_ASSOC)) {
							$hrgolah = getdataolah('air',$row["id"],$rowhrg["id_segprod"],$rowhrg["id_segpas"],$rowpj["id"]);
							$col = "pj".$rowpj["id"];

							if ($rowhrg["smb_harga"] == 'Harga Jadi'){
								$hrgair = (1+$rowhrg[$col]) * $hrgakhir;
							} else {
								$hrgair = (1+$rowhrg[$col]) * $hpm;
							}
							
							//$tdpj .= '<td class="p-b-5 p-t-5">'.number_format($hrgair,0,".",",").'</td><td class="p-b-5 p-t-5" id="olah-'.$row["id"].'-'.$rowhrg["id_segprod"].$rowhrg["id_segpas"].$rowpj["id"].'">'.$btn.'</td>';	

							array_push($hrgairsell,Array("segmen_produk"=>$row["segmen_produk"],"segmen_pasar"=>"Standard Selling ".$rowhrg["segpas"],"pola_jual"=>$rowpj["nm_erp"],"kode_brg"=>$row["kd_item"],"hnappn"=>$hpm,"diskon_bbi"=>$disbbi,"harga_jadi"=>$hrgair));
						}
					}
					
				} else {
					if (floatval($disbbi) >= floatval($rowhrg["diskon_bawah"]) && floatval($disbbi) <= floatval($rowhrg["diskon_atas"])){
						$tdpj = '';
						$rsltpj = mysql_query("SELECT * FROM ref_polajual ORDER BY id ASC");
						while ($rowpj = mysql_fetch_array($rsltpj, MYSQL_ASSOC)) {
							$hrgolah = getdataolah('air',$row["id"],$rowhrg["id_segprod"],$rowhrg["id_segpas"],$rowpj["id"]);
							$col = "pj".$rowpj["id"];
							if ($rowhrg["smb_harga"] == 'Harga Jadi'){
								$hrgair = (1+floatval($rowhrg[$col])) * floatval($hrgakhir);
							} else {
								$hrgair = (1+floatval($rowhrg[$col])) * floatval($hpm);
							}
							//$tdpj .= '<td class="p-b-5 p-t-5">'.number_format($hrgair,0,".",",").'</td><td class="p-b-5 p-t-5" id="olah-'.$row["id"].'-'.$rowhrg["id_segprod"].$rowhrg["id_segpas"].$rowpj["id"].'">'.$btn.'</td>';	
							
							array_push($hrgairsell,Array("segmen_produk"=>$row["segmen_produk"],"segmen_pasar"=>"Standard Selling ".$rowhrg["segpas"],"pola_jual"=>$rowpj["nm_erp"],"kode_brg"=>$row["kd_item"],"hnappn"=>$hpm,"diskon_bbi"=>$disbbi,"harga_jadi"=>$hrgair));
							
						}
					}
				}
			}
			
			$cnt++;
		}
		
		$air_sell = $hrgairsell;
	
	$out = Array();
	array_push($out,$bbi_buy);
	array_push($out,$bbi_sell);
	array_push($out,$air_buy);
	array_push($out,$air_sell);
	
		
	return $out;

}


function paginasi($val,$jml_page,$hal,$flphp,$elem){
	$md = '';
	if ($jml_page < 11){
		for ($i = 1; $i < ($jml_page + 1);$i++){
			if ($i == $hal){
				$md .= '<li class="active"><a href="javascript:;">'.$i.'</a></li>';
			} else {
				$md .= '<li><a onclick="goto_page(\''.$flphp.'\',\''.$elem.'\',\''.$val.'\','.$i.');" class="item-kat" href="javascript:;">'.$i.'</a></li>';
			}
		}
	
	} else {
		if ($hal < 6){
			for ($i = 1; $i < 11;$i++){
				if ($i == $hal){
					$md .= '<li class="active"><a href="javascript:;">'.$i.'</a></li>';
				} else {
					$md .= '<li><a class="item-kat" onclick="goto_page(\''.$flphp.'\',\''.$elem.'\',\''.$val.'\','.$i.');" href="javascript:;">'.$i.'</a></li>';
				}
			}
		} else if ($hal > ($jml_page - 5)){
			for ($i = ($jml_page - 6); $i < ($jml_page + 1);$i++){
				if ($i == $hal){
					$md .= '<li class="active"><a href="javascript:;">'.$i.'</a></li>';
				} else {
					$md .= '<li><a class="item-kat" onclick="goto_page(\''.$flphp.'\',\''.$elem.'\',\''.$val.'\','.$i.');" href="javascript:;">'.$i.'</a></li>';
				}
			}
		} else {
			for ($i = ($hal - 4); $i < ($hal + 5);$i++){
				if ($i == $hal){
					$md .= '<li class="active"><a href="javascript:;">'.$i.'</a></li>';
				} else {
					$md .= '<li><a class="item-kat" onclick="goto_page(\''.$flphp.'\',\''.$elem.'\',\''.$val.'\','.$i.');" href="javascript:;">'.$i.'</a></li>';
				}
			}
		}
	}
	
	
	
	if ($hal == 1){
		$pg = '
			<li class="disabled"><a href="javascript:;"><i class="icon icon-first"></i></a></li>
			<li class="disabled"><a href="javascript:;"><i class="icon icon-previous2"></i></a></li>
			'.$md.'                                   
			<li><a class="item-kat" onclick="goto_page(\''.$flphp.'\',\''.$elem.'\',\''.$val.'\',2);" href="javascript:;"><i class="fa fa-angle-right"></i></a></li>
			
			<li><a class="item-kat" onclick="goto_page(\''.$flphp.'\',\''.$elem.'\',\''.$val.'\','.$jml_page.');" href="javascript:;"><i class="icon icon-last"></i></a></li>
		';
	} else if ($hal == $jml_page){
		$pg = '
			<li><a class="item-kat" onclick="goto_page(\''.$flphp.'\',\''.$elem.'\',\''.$val.'\',1);" href="javascript:;"><i class="icon icon-first"></i></a></li>
			<li><a class="item-kat" onclick="goto_page(\''.$flphp.'\',\''.$elem.'\',\''.$val.'\','.($jml_page-1).');" href="javascript:;"><i class="icon icon-previous2"></i></a></li>
			'.$md.'                                   
			<li class="disabled"><a href="javascript:;"><i class="fa fa-angle-right"></i></a></li>
			<li class="disabled"><a href="javascript:;"><i class="icon icon-last"></i></a></li>
		';
	} else {
		$pg = '
			<li><a class="item-kat" onclick="goto_page(\''.$flphp.'\',\''.$elem.'\',\''.$val.'\',1);" href="javascript:;"><i class="icon icon-first"></i></a></li>
			<li><a class="item-kat" onclick="goto_page(\''.$flphp.'\',\''.$elem.'\',\''.$val.'\','.($hal-1).');" href="javascript:;"><i class="icon icon-previous2"></i></a></li>
			'.$md.'                                   
			<li><a class="item-kat" onclick="goto_page(\''.$flphp.'\',\''.$elem.'\',\''.$val.'\','.($hal+1).');" href="javascript:;"><i class="fa fa-angle-right"></i></a></li>
			<li><a class="item-kat" onclick="goto_page(\''.$flphp.'\',\''.$elem.'\',\''.$val.'\','.$jml_page.');" href="javascript:;"><i class="icon icon-last"></i></a></li>
		';
	}



	if ($jml_page < 2){
		$pg = '';
	} else {
		$pg = '
		<div class="row">
			<div class="col-sm-2 col-xs-12">
				<div class="input-group m-t-10">
					<input id="gopage" placeholder="Go To Page" class="form-control p-5" style="height: 32px;" type="text">
					<span class="input-group-btn">
						<button onclick="goto_page(\''.$flphp.'\',\''.$elem.'\',\''.$val.'\',$(\'#gopage\').val());" type="button" style="padding: 5px;" class="btn waves-effect waves-light btn-info f-12">Go!</button>
					</span> 
				</div>
			</div>
			<div class="col-sm-8 col-xs-12 text-left">
				<ul class="pagination push-down-20 m-t-10 m-b-10">
					'.$pg.'
				</ul>
			</div>
		</div>';
	}

	return $pg;


}




function update_tbl($dtins,$tbl,$fldkey,$valkey){
	
	$hsl = mysql_query("SELECT * FROM ".$tbl." WHERE ".$fldkey." = ".$valkey);
	
	$insname = Array();
	$insval = Array();
	foreach($dtins as $key=>$val){
		array_push($insname,$key);
		array_push($insval,$val);
	}
	$fldname = Array();
	$fldtipe = Array();
	for ($i = 0;$i < mysql_num_fields($hsl); $i++){
		array_push($fldname, mysql_field_name($hsl,$i));
		array_push($fldtipe, mysql_field_type($hsl,$i));
	}
	
	$str = array("string", "datetime", "blob");
	$int = array("int ", "real ");
	
	$valins = Array();
	foreach($fldname as $key=>$val){
		if (in_array($val,$insname)){
			if ($dtins[$val] == ""){
				array_push($valins,$val." = NULL");
			} else {
				if (in_array($fldtipe[$key],$str)){
					array_push($valins,$val." = '".$dtins[$val]."'");
				} else {
					array_push($valins,$val." = ".$dtins[$val]);
				}
			}
		
		
		}
	}
	
	$txt = implode(",",$valins);
	$sql = "UPDATE ".$tbl." SET ".$txt." WHERE ".$fldkey." ='".$valkey."'";
	return $sql;
}


function insert_tbl($dtins,$tbl,$fldkey,$valkey){
	$hsl = mysql_query("SELECT * FROM ".$tbl." LIMIT 0,1"); //." WHERE ".$fldkey." = ".$valkey);
	$insname = Array();
	$insval = Array();
	$str = array("string", "datetime", "blob");
	$int = array("int ", "real ");
	$primarykey = array("id","kodesat","kelompok","kodekec","kodekk");
	
	foreach($dtins as $key=>$val){
		array_push($insname,$key);
		array_push($insval,$val);
	}
	$fldname = Array();
	$fldtipe = Array();
	for ($i = 0;$i < mysql_num_fields($hsl); $i++){
		if  (in_array(mysql_field_name($hsl,$i),$primarykey)){
		} else {
			array_push($fldname, mysql_field_name($hsl,$i));
			array_push($fldtipe, mysql_field_type($hsl,$i));
		}
	}
	
	
	
	$fld = implode(",",$fldname);
	$valins = Array();
	
	foreach($fldname as $key=>$val){
		if (in_array($val,$insname)){
			if ($dtins[$val] == ""){
				array_push($valins,"NULL");
			} else {
				if (in_array($fldtipe[$key],$str)){
					array_push($valins,"'".$dtins[$val]."'");
				} else {
					array_push($valins,$dtins[$val]);
				}
			}
		} else {
			array_push($valins,"NULL");
		}
	}
	
	$txt = implode(",",$valins);
	$sql = "INSERT INTO ".$tbl." (".$fld.") VALUES (".$txt.");";
	
	return $sql;
}

*/

?>