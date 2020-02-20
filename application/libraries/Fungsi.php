<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');  
 
require_once APPPATH."/third_party/fungsi.php";

/*
class fungsi extends userFungsi {
    
}

*/

class fungsi extends userFungsi {
	public function test(){
		return 'ok';
	}
}
