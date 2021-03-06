

<!DOCTYPE html>
<!-- 
Template Name: Metronic - Responsive Admin Dashboard Template build with Twitter Bootstrap 3.3.4
Version: 3.3.0
Author: KeenThemes
Website: http://www.keenthemes.com/
Contact: support@keenthemes.com
Follow: www.twitter.com/keenthemes
Like: www.facebook.com/keenthemes
Purchase: http://themeforest.net/item/metronic-responsive-admin-dashboard-template/4021469?ref=keenthemes
License: You must have a valid license purchased only from themeforest(the above link) in order to legally use the theme for your project.
-->
<!--[if IE 8]> <html lang="en" class="ie8 no-js"> <![endif]-->
<!--[if IE 9]> <html lang="en" class="ie9 no-js"> <![endif]-->
<!--[if !IE]><!-->
<html lang="en">
<!--<![endif]-->
<!-- BEGIN HEAD -->
<head>
<meta charset="utf-8"/>
<title>Lundara POS | Login</title>
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta content="width=device-width, initial-scale=1.0" name="viewport"/>
<meta http-equiv="Content-type" content="text/html; charset=utf-8">
<meta content="" name="description"/>
<meta content="" name="author"/>
<!-- BEGIN GLOBAL MANDATORY STYLES -->
<link href="<?php echo base_url()?>assets/global/plugins/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css"/>
<link href="<?php echo base_url()?>assets/global/plugins/simple-line-icons/simple-line-icons.min.css" rel="stylesheet" type="text/css"/>
<link href="<?php echo base_url()?>assets/global/plugins/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
<link href="<?php echo base_url()?>assets/global/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css"/>
<link href="<?php echo base_url()?>assets/global/plugins/uniform/css/uniform.default.css" rel="stylesheet" type="text/css"/>
<link href="<?php echo base_url()?>assets/global/plugins/pnotify/pnotify.custom.min.css" rel="stylesheet" type="text/css"/>
<!-- END GLOBAL MANDATORY STYLES -->
<!-- BEGIN PAGE LEVEL STYLES -->
<link href="<?php echo base_url()?>assets/pages/css/login2.css" rel="stylesheet" type="text/css"/>
<!-- END PAGE LEVEL SCRIPTS -->
<!-- BEGIN THEME STYLES -->
<link href="<?php echo base_url()?>assets/global/css/components.css" id="style_components" rel="stylesheet" type="text/css"/>
<link href="<?php echo base_url()?>assets/global/css/plugins.css" rel="stylesheet" type="text/css"/>
<link href="<?php echo base_url()?>assets/layout/css/layout.css" rel="stylesheet" type="text/css"/>
<link href="<?php echo base_url()?>assets/layout/css/themes/default.css" rel="stylesheet" type="text/css" id="style_color"/>
<link href="<?php echo base_url()?>assets/layout/css/custom.css" rel="stylesheet" type="text/css"/>
<!-- END THEME STYLES -->

<link rel="stylesheet" type="text/css" href="<?php echo base_url()?>assets/global/plugins/bootstrap-toastr/toastr.min.css"/>



<style type="text/css">

	/*
		#D61C62 -> mid
		#a31549 -> old
		#ff2172 -> y

	*/
	body{
		height: 100%;
	}
	html { 
	  background: url("<?php echo base_url()?>assets/img/bg-login1.jpg") no-repeat center center fixed;
	  -webkit-background-size: cover;
	  -moz-background-size: cover;
	  -o-background-size: cover;
	  background-size: cover;

	}
	.login{
		background: none;
	}
		.login .content .form-control{
			background-color: #a31549;
    		border: 1px solid #a31549;
		}
		.login .content .form-control:focus{
			border-color: white;
		}

		.login .btn-primary{
			background-color: #ff2172;
    		border: 0px solid white;
    		color:white;
		}
		.login .btn-primary:hover{
			background-color: #D61C62;
			border: 0px solid #D61C62;
			color:white;
		}

		.content{
			padding: 20px;
			background: rgba(255, 255, 255, 0.7);
		}
		.form-title .form-title{
			color:#D61C62;
			font-weight: bold !important;
		}
</style>

<!--<link rel="shortcut icon" href="http://sys.cbtekno.com/assets/img/logo_shin.png"/>-->
</head>
<!-- END HEAD -->
<!-- BEGIN BODY -->
<body class="login">
<!-- BEGIN SIDEBAR TOGGLER BUTTON -->
<div class="menu-toggler sidebar-toggler">
</div>
<!-- END SIDEBAR TOGGLER BUTTON -->
<!-- BEGIN LOGO -->
<div class="logo">
<!--
	<label style="font-size: 50px;font-family:old English Text MT;color:white">Apotek Ondang</label> width: 500px-->
	<center style="padding: 10px">
		<img src="<?php echo base_url() ?>assets/img/logo_login_lnd.png" class="img-responsive" style="width: 200px">
	</center>
</div>
<!-- END LOGO -->
<!-- BEGIN LOGIN -->
<div class="content">
	<!-- BEGIN LOGIN FORM -->
	<div class="form-title">
		<span class="form-title">Selamat Datang.</span>
		<span class="form-subtitle"></span>
	</div>
	<div class="form-group">
		<!--ie8, ie9 does not support html5 placeholder, so we just show field title for that-->
		<label class="control-label visible-ie8 visible-ie9">Username</label>
		<input class="form-control form-control-solid placeholder-no-fix" type="text" autocomplete="off" placeholder="Username" id="username" autofocus="" />
	</div>
	<div class="form-group">
		<label class="control-label visible-ie8 visible-ie9">Password</label>
		<input class="form-control form-control-solid placeholder-no-fix" type="password" autocomplete="off" placeholder="Password" id="password"/>
	</div>
	<div class="form-actions">
		<button type="submit" class="btn btn-primary btn-block uppercase" onclick="login()" id="btn-login">Login</button>
	</div>
	<!--
	<div class="form-actions">
		<div class="pull-left">
			<label class="rememberme check">
			<input type="checkbox" name="remember" value="1"/>Remember me </label>
		</div>
		<div class="pull-right forget-password-block">
			<a href="javascript:;" id="forget-password" class="forget-password">Forgot Password?</a>
		</div>
		</div>-->
	<!-- END LOGIN FORM -->

</div>
<div class="copyright" style="color: white">
	 <?php echo date('Y')?> © Lundara.
</div>
<!-- END LOGIN -->
<!-- BEGIN JAVASCRIPTS(Load javascripts at bottom, this will reduce page load time) -->
<!-- BEGIN CORE PLUGINS -->
<!--[if lt IE 9]>
<script src="<?php echo base_url()?>assets/global/plugins/respond.min.js"></script>
<script src="<?php echo base_url()?>assets/global/plugins/excanvas.min.js"></script> 
<![endif]-->
<script src="<?php echo base_url()?>assets/global/plugins/jquery.min.js" type="text/javascript"></script>
<script src="<?php echo base_url()?>assets/global/plugins/jquery-migrate.min.js" type="text/javascript"></script>
<script src="<?php echo base_url()?>assets/global/plugins/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
<script src="<?php echo base_url()?>assets/global/plugins/jquery.blockui.min.js" type="text/javascript"></script>
<script src="<?php echo base_url()?>assets/global/plugins/uniform/jquery.uniform.min.js" type="text/javascript"></script>
<script src="<?php echo base_url()?>assets/global/plugins/jquery.cokie.min.js" type="text/javascript"></script>
<script src="<?php echo base_url()?>assets/global/plugins/pnotify/pnotify.custom.min.js"></script>

<!-- END CORE PLUGINS -->
<!-- BEGIN PAGE LEVEL PLUGINS -->
<script src="<?php echo base_url()?>assets/global/plugins/jquery-validation/js/jquery.validate.min.js" type="text/javascript"></script>
<!-- END PAGE LEVEL PLUGINS -->
<!-- BEGIN PAGE LEVEL SCRIPTS -->
<script src="<?php echo base_url()?>assets/global/scripts/metronic.js" type="text/javascript"></script>
<script src="<?php echo base_url()?>assets/layout/scripts/layout.js" type="text/javascript"></script>
<script src="<?php echo base_url()?>assets/layout/scripts/demo.js" type="text/javascript"></script>
<script src="<?php echo base_url()?>assets/global/plugins/bootstrap-toastr/toastr.min.js"></script>
<script src="<?php echo base_url()?>assets/pages/scripts/ui-toastr.js"></script>

<!-- END PAGE LEVEL SCRIPTS -->
<script type="text/javascript">


	$(document).ready(function(){

		$("#password").keypress(function(e) {
	          if(e.which == 13) {
	               login();
	          }
      	});

      	$("#username").keypress(function(e) {
	          if(e.which == 13) {
	               login();
	          }
      	});

	});


	function login(){
		var username = $("#username").val();
		var password = $("#password").val();

		if(username && password !==""){
			$.ajax({
				"type":"POST",
				"url":"<?php echo base_url()?>login/proses",
				"dataType":"json",
				"data":{username, password},
				"cache":false,
				beforeSend:function(){
					$("#btn-login").html("<i class='fa fa-spinner fa-pulse'></i> Loading...");
					$("#btn-login").attr("disabled", "disabled");
				},
				success:function(data){
					switch(String(data)){
						case"1":
							notif("Success", "Berhasil Login.", "success");
							setTimeout(function(){location.assign("<?php echo base_url()?>dashboard")}, 1500);
						break;
						case"0":
							notif("Error", "Username atau Password salah.", "error");
						break;
						case"0.1":
							notif("Error", "Gagal Login.", "error");
						break;
						default:
							notif("Error", "Gagal Login.", "error");
						break;
					}
				},
				complete:function(){
					$("#btn-login").html("LOGIN");
					$("#btn-login").removeAttr("disabled");
				}
			});
		}
		else{
			notif("Error", "Tidak boleh kosong.", "error");
		}

	}


	function notif(caption, msg, type){
		PNotify.prototype.options.styling = 'fontawesome';
		new PNotify({
		    title: caption,
		    text: msg,
		    type: type
		});
	}
</script>
<script>
jQuery(document).ready(function() {     
	Metronic.init(); // init metronic core components
	Layout.init(); // init current layout
	Login.init();
	Demo.init();
	UIToastr.init();

});
</script>



<!-- END JAVASCRIPTS -->
</body>
<!-- END BODY -->
</html>