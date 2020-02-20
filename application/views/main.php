<!DOCTYPE html>

<html lang="en" class="no-js">
<!--<![endif]-->
<!-- BEGIN HEAD -->
<head>
<meta charset="utf-8"/>
<title>Lundara POS | <?php echo $title ?></title>
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta content="width=device-width, initial-scale=1" name="viewport"/>
<meta content="" name="description"/>
<meta content="" name="author"/>
<!-- BEGIN GLOBAL MANDATORY STYLES -->
<link href="http://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700&subset=all" rel="stylesheet" type="text/css"/>
<link href="<?php echo base_url()?>assets/global/plugins/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css"/>
<link href="<?php echo base_url()?>assets/global/plugins/simple-line-icons/simple-line-icons.min.css" rel="stylesheet" type="text/css"/>
<link href="<?php echo base_url()?>assets/global/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css"/>
<link href="<?php echo base_url()?>assets/global/plugins/uniform/css/uniform.default.css" rel="stylesheet" type="text/css"/>
<link href="<?php echo base_url()?>assets/global/plugins/bootstrap-switch/css/bootstrap-switch.min.css" rel="stylesheet" type="text/css"/>
<!-- END GLOBAL MANDATORY STYLES -->
<!-- BEGIN PAGE LEVEL PLUGIN STYLES -->
<link href="<?php echo base_url()?>assets/global/plugins/bootstrap-daterangepicker/daterangepicker-bs3.css" rel="stylesheet" type="text/css"/>
<link href="<?php echo base_url()?>assets/global/plugins/fullcalendar/fullcalendar.min.css" rel="stylesheet" type="text/css"/>
<link href="<?php echo base_url()?>assets/global/plugins/jqvmap/jqvmap/jqvmap.css" rel="stylesheet" type="text/css"/>
<link href="<?php echo base_url()?>assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.css" rel="stylesheet" type="text/css"/>
<link href="<?php echo base_url()?>assets/pages/css/profile.css?v6" rel="stylesheet" type="text/css"/>
<link href="<?php echo base_url()?>assets/pages/css/tasks.css" rel="stylesheet" type="text/css"/>
<link rel="stylesheet" type="text/css" href="<?php echo base_url()?>assets/global/plugins/datatables/plugins/bootstrap/dataTables.bootstrap.css"/>
<link rel="stylesheet" type="text/css" href="<?php echo base_url()?>assets/global/plugins/bootstrap-select/bootstrap-select.min.css"/>
<link rel="stylesheet" type="text/css" href="<?php echo base_url()?>assets/global/plugins/select2/select2.css"/>
<link href="<?php echo base_url()?>assets/global/plugins/dropzone/css/dropzone.css" rel="stylesheet"/>
<!--<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.5/css/select2.min.css">-->
<link href="<?php echo base_url()?>assets/global/plugins/icheck/skins/all.css" rel="stylesheet"/>

<!-- END PAGE LEVEL PLUGIN STYLES -->
<!-- BEGIN PAGE STYLES -->
<link href="<?php echo base_url()?>assets/pages/css/tasks.css" rel="stylesheet" type="text/css"/>
<!-- END PAGE STYLES -->
<!-- BEGIN THEME STYLES -->
<!-- DOC: To use 'rounded corners' style just load 'components-rounded.css' stylesheet instead of 'components.css' in the below style tag -->
<link href="<?php echo base_url()?>assets/global/css/components.css" id="style_components" rel="stylesheet" type="text/css"/>
<link href="<?php echo base_url()?>assets/global/css/plugins.css?v1" rel="stylesheet" type="text/css"/>
<link href="<?php echo base_url()?>assets/layout2/css/layout.css" rel="stylesheet" type="text/css"/>
<link href="<?php echo base_url()?>assets/layout2/css/themes/grey.css" rel="stylesheet" type="text/css" id="style_color"/>
<link href="<?php echo base_url()?>assets/layout2/css/custom.css" rel="stylesheet" type="text/css"/>
<!-- END THEME STYLES -->
<link rel="shortcut icon" href="http://sys.cbtekno.com/assets/img/logo_shin.png"/>
<link href="<?php echo base_url()?>assets/global/plugins/pnotify/pnotify.custom.min.css" rel="stylesheet" type="text/css"/>
<link rel="stylesheet" type="text/css" href="<?php echo base_url()?>assets/global/plugins/datatables/extensions/Scroller/css/dataTables.scroller.min.css"/>
<link rel="stylesheet" type="text/css" href="<?php echo base_url()?>assets/global/plugins/datatables/extensions/ColReorder/css/dataTables.colReorder.min.css"/>
<link rel="stylesheet" type="text/css" href="<?php echo base_url()?>assets/global/plugins/datatables/plugins/bootstrap/dataTables.bootstrap.css"/>
<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-tagsinput/0.8.0/bootstrap-tagsinput.css">
<link href="https://gitcdn.github.io/bootstrap-toggle/2.2.2/css/bootstrap-toggle.min.css" rel="stylesheet">
<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/magnific-popup.js/1.1.0/magnific-popup.min.css">

<script src="<?php echo base_url()?>assets/global/plugins/jquery.min.js" type="text/javascript"></script>

<style type="text/css">
	.page-title{
		color: black !important;
	}
	.page-container-bg-solid .page-content{
		background: #dbdbdb !important;
	}
	.main.btn{
		background: #D61C62 !important;
		color: white;
	}
	.main.box{
		background: #D61C62 !important;
	}

	.f-white{
		color:white !important;
	}
	.f-color{
		color:#D61C62 !important;
	}

	.tooltips {
	    z-index: 2080 !important;
	}
	.page-header.navbar .page-logo{
		background:#D61C62;
	}
	.page-header-inner{
		background:#D61C62;
	}

	.require:before{
		color:red;
		content: "*";
	}
	.modal-dialog-big {
	  width: 90%;
	  /*height: 100%;*/
	  margin: auto;
	}

	.modal-content-big {
	  height: auto;
	  min-height: 100%;
	  border-radius: 0;
	}
	.page-sidebar .page-sidebar-menu > li.active > a > i{
		color:#ff2172;
	}
	.page-sidebar .page-sidebar-menu > li > a > i{
		color:#ffb2ce;
	}
	.page-sidebar .page-sidebar-menu > li:hover > a > i{
		color:#ff2172;
	}

	.dropzone{
		border: 3px dashed #D61C62;
	}

	.bootstrap-tagsinput{
		min-height: 34px !important;
		width: 100% !important;
		line-height: 30px;
		padding: 1px 6px;
	}
		.bootstrap-tagsinput .label{
			font-weight: 600 !important;
		}

	.btn-default.btn-on-2.active{background-color: #D61C62;color: white;}
	.btn-default.btn-off-2.active{background-color: #A7A7A7;color: white;}

	.page-header.navbar.navbar-fixed-top{
		z-index: 1000;
	}

	.dropdown > .dropdown-menu:before, .dropdown-toggle > .dropdown-menu:before, .btn-group > .dropdown-menu:before {
		left: 120px;
	}
	.dropdown > .dropdown-menu:before, .dropdown-toggle > .dropdown-menu:before, .btn-group > .dropdown-menu:after {
		left: 110px;
	}
	.page-container-bg-solid .page-sidebar .page-sidebar-menu > li.active > a > .selected{
		border-color: transparent #DBDBDB transparent transparent;
	}


</style>

</head>
<!-- END HEAD -->
<!-- BEGIN BODY -->
<!-- DOC: Apply "page-header-fixed-mobile" and "page-footer-fixed-mobile" class to body element to force fixed header or footer in mobile devices -->
<!-- DOC: Apply "page-sidebar-closed" class to the body and "page-sidebar-menu-closed" class to the sidebar menu element to hide the sidebar by default -->
<!-- DOC: Apply "page-sidebar-hide" class to the body to make the sidebar completely hidden on toggle -->
<!-- DOC: Apply "page-sidebar-closed-hide-logo" class to the body element to make the logo hidden on sidebar toggle -->
<!-- DOC: Apply "page-sidebar-hide" class to body element to completely hide the sidebar on sidebar toggle -->
<!-- DOC: Apply "page-sidebar-fixed" class to have fixed sidebar -->
<!-- DOC: Apply "page-footer-fixed" class to the body element to have fixed footer -->
<!-- DOC: Apply "page-sidebar-reversed" class to put the sidebar on the right side -->
<!-- DOC: Apply "page-full-width" class to the body element to have full width page without the sidebar menu -->
<body class="page-boxed page-header-fixed page-sidebar-closed-hide-logo page-container-bg-solid page-sidebar-closed-hide-logo">
<!-- BEGIN HEADER -->
<div class="page-header navbar navbar-fixed-top">
	<!-- BEGIN HEADER INNER -->
	<div class="page-header-inner">
		<!-- BEGIN LOGO -->
		<div class="page-logo">
		<!--
			<center>
				<label style="margin-top:5px;font-size: 24px;font-family:Verdana;color:white" id="jam"><?php echo date("H:i:s") ?></label><br>
				<label style="margin-top:-10px;font-size: 14px;font-family:Verdana;color:white" id="jam"><?php echo date("d/m/Y") ?></label>
			</center>-->
			<a href="index.html">
				<center>
				<label class="logo-default" style="margin-top:5px;font-size: 24px;font-family:Verdana;color:white" id="jam"><?php echo date("H:i:s") ?></label><br>
				<label class="logo-default" style="margin-top:-10px;font-size: 14px;font-family:Verdana;color:white" id="jam"><?php echo date("d/m/Y") ?></label>
				</center>
			</a>
			<div class="menu-toggler sidebar-toggler">
				
			</div>
		</div>
		<!-- END LOGO -->
		<!-- BEGIN RESPONSIVE MENU TOGGLER -->
		<a href="javascript:;" class="menu-toggler responsive-toggler" data-toggle="collapse" data-target=".navbar-collapse" id="a">
			
		</a>
		<!-- END RESPONSIVE MENU TOGGLER -->

		<!-- BEGIN PAGE TOP -->
		<?php include('port/header.php'); ?>
		<!-- END PAGE TOP -->
	</div>
	<!-- END HEADER INNER -->
</div>
<!-- END HEADER -->
<div class="clearfix">
</div>
<!-- BEGIN CONTAINER -->
<div class="page-container">
		<!-- BEGIN SIDEBAR -->
		<?php include('port/sidebar.php'); ?>
		<!-- END SIDEBAR -->
		<!-- BEGIN CONTENT -->
		<div class="page-content-wrapper">
			<?php include("page/".$page.".php"); ?>
		</div>
		<!-- END CONTENT -->


		<!-- BEGIN QUICK SIDEBAR -->
		<!--Cooming Soon...-->
		<!-- END QUICK SIDEBAR -->
	</div>
	<!-- END CONTAINER -->
	<!-- BEGIN FOOTER -->
	<?php include('port/footer.php'); ?>
	<!-- END FOOTER -->
<!-- BEGIN JAVASCRIPTS(Load javascripts at bottom, this will reduce page load time) -->
<!-- BEGIN CORE PLUGINS -->
<!--[if lt IE 9]>
<script src="<?php echo base_url()?>assets/global/plugins/respond.min.js"></script>
<script src="<?php echo base_url()?>assets/global/plugins/excanvas.min.js"></script> 
<![endif]-->
<script src="<?php echo base_url()?>assets/global/plugins/jquery.min.js" type="text/javascript"></script>
<script src="<?php echo base_url()?>assets/global/plugins/jquery-migrate.min.js" type="text/javascript"></script>
<!-- IMPORTANT! Load jquery-ui.min.js before bootstrap.min.js to fix bootstrap tooltip conflict with jquery ui tooltip -->
<script src="<?php echo base_url()?>assets/global/plugins/jquery-ui/jquery-ui.min.js" type="text/javascript"></script>
<script src="<?php echo base_url()?>assets/global/plugins/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
<script src="<?php echo base_url()?>assets/global/plugins/bootstrap-hover-dropdown/bootstrap-hover-dropdown.min.js" type="text/javascript"></script>
<script src="<?php echo base_url()?>assets/global/plugins/jquery-slimscroll/jquery.slimscroll.min.js" type="text/javascript"></script>
<script src="<?php echo base_url()?>assets/global/plugins/jquery.blockui.min.js" type="text/javascript"></script>
<script src="<?php echo base_url()?>assets/global/plugins/jquery.cokie.min.js" type="text/javascript"></script>
<script src="<?php echo base_url()?>assets/global/plugins/uniform/jquery.uniform.min.js" type="text/javascript"></script>
<script src="<?php echo base_url()?>assets/global/plugins/bootstrap-switch/js/bootstrap-switch.min.js" type="text/javascript"></script>
<!-- END CORE PLUGINS -->
<!-- BEGIN PAGE LEVEL PLUGINS -->
<script src="<?php echo base_url()?>assets/global/plugins/jqvmap/jqvmap/jquery.vmap.js" type="text/javascript"></script>
<script src="<?php echo base_url()?>assets/global/plugins/jqvmap/jqvmap/maps/jquery.vmap.russia.js" type="text/javascript"></script>
<script src="<?php echo base_url()?>assets/global/plugins/jqvmap/jqvmap/maps/jquery.vmap.world.js" type="text/javascript"></script>
<script src="<?php echo base_url()?>assets/global/plugins/jqvmap/jqvmap/maps/jquery.vmap.europe.js" type="text/javascript"></script>
<script src="<?php echo base_url()?>assets/global/plugins/jqvmap/jqvmap/maps/jquery.vmap.germany.js" type="text/javascript"></script>
<script src="<?php echo base_url()?>assets/global/plugins/jqvmap/jqvmap/maps/jquery.vmap.usa.js" type="text/javascript"></script>
<script src="<?php echo base_url()?>assets/global/plugins/jqvmap/jqvmap/data/jquery.vmap.sampledata.js" type="text/javascript"></script>
<script src="<?php echo base_url()?>assets/global/plugins/flot/jquery.flot.min.js" type="text/javascript"></script>
<script src="<?php echo base_url()?>assets/global/plugins/flot/jquery.flot.resize.min.js" type="text/javascript"></script>
<script src="<?php echo base_url()?>assets/global/plugins/flot/jquery.flot.categories.min.js" type="text/javascript"></script>
<script src="<?php echo base_url()?>assets/global/plugins/jquery.pulsate.min.js" type="text/javascript"></script>
<script src="<?php echo base_url()?>assets/global/plugins/bootstrap-daterangepicker/moment.min.js" type="text/javascript"></script>
<script src="<?php echo base_url()?>assets/global/plugins/bootstrap-daterangepicker/daterangepicker.js" type="text/javascript"></script>
<script src="<?php echo base_url()?>assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.js" type="text/javascript"></script>
<script src="<?php echo base_url()?>assets/global/plugins/jquery.sparkline.min.js" type="text/javascript"></script>

<!-- IMPORTANT! fullcalendar depends on jquery-ui.min.js for drag & drop support -->
<script src="<?php echo base_url()?>assets/global/plugins/fullcalendar/fullcalendar.min.js" type="text/javascript"></script>
<script src="<?php echo base_url()?>assets/global/plugins/jquery-easypiechart/jquery.easypiechart.min.js" type="text/javascript"></script>
<script src="<?php echo base_url()?>assets/global/plugins/jquery.sparkline.min.js" type="text/javascript"></script>

<script src="<?php echo base_url()?>assets/global/plugins/jquery.pulsate.min.js" type="text/javascript"></script>
<script src="<?php echo base_url()?>assets/global/plugins/jquery-bootpag/jquery.bootpag.min.js" type="text/javascript"></script>
<script src="<?php echo base_url()?>assets/global/plugins/holder.js" type="text/javascript"></script>


<!-- END PAGE LEVEL PLUGINS -->
<!-- BEGIN PAGE LEVEL SCRIPTS -->
<script src="<?php echo base_url()?>assets/global/scripts/metronic.js" type="text/javascript"></script>
<script src="<?php echo base_url()?>assets/layout2/scripts/layout.js" type="text/javascript"></script>
<script src="<?php echo base_url()?>assets/layout2/scripts/demo.js" type="text/javascript"></script>
<script src="<?php echo base_url()?>assets/pages/scripts/index.js?1" type="text/javascript"></script>
<script src="<?php echo base_url()?>assets/pages/scripts/tasks.js" type="text/javascript"></script>
<script type="text/javascript" src="<?php echo base_url()?>assets/global/plugins/datatables/media/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="<?php echo base_url()?>assets/global/plugins/datatables/extensions/TableTools/js/dataTables.tableTools.min.js"></script>
<script type="text/javascript" src="<?php echo base_url()?>assets/global/plugins/datatables/extensions/ColReorder/js/dataTables.colReorder.min.js"></script>
<script type="text/javascript" src="<?php echo base_url()?>assets/global/plugins/datatables/extensions/Scroller/js/dataTables.scroller.min.js"></script>
<script type="text/javascript" src="<?php echo base_url()?>assets/global/plugins/datatables/plugins/bootstrap/dataTables.bootstrap.js"></script>
<script type="text/javascript" src="<?php echo base_url()?>assets/global/plugins/bootstrap-select/bootstrap-select.min.js"></script>
<script type="text/javascript" src="<?php echo base_url()?>assets/global/plugins/select2/select2.min.js"></script>
<!--<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.5/js/select2.min.js"></script>-->
<script src="<?php echo base_url()?>assets/pages/scripts/form-icheck.js"></script>
<script src="<?php echo base_url()?>assets/global/plugins/icheck/icheck.min.js"></script>
<script src="<?php echo base_url()?>assets/pages/scripts/ui-general.js" type="text/javascript"></script>
<!-- END PAGE LEVEL SCRIPTS -->
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.13/jquery.mask.min.js"></script>
<script src="<?php echo base_url()?>assets/global/plugins/pnotify/pnotify.custom.min.js"></script>
<script type="text/javascript" src="//cdn.datatables.net/plug-ins/1.10.16/api/sum().js"></script>
<script src="<?php echo base_url() ?>assets/global/plugins/amcharts/amcharts/amcharts.js" type="text/javascript"></script>
<script src="<?php echo base_url() ?>assets/global/plugins/amcharts/amcharts/pie.js" type="text/javascript"></script>

<script src="<?php echo base_url() ?>assets/global/plugins/flot/jquery.flot.min.js"></script>
<script src="<?php echo base_url() ?>assets/global/plugins/flot/jquery.flot.resize.min.js"></script>
<script src="<?php echo base_url() ?>assets/global/plugins/flot/jquery.flot.pie.min.js"></script>
<script src="<?php echo base_url() ?>assets/global/plugins/flot/jquery.flot.stack.min.js"></script>
<script src="<?php echo base_url() ?>assets/global/plugins/flot/jquery.flot.crosshair.min.js"></script>
<script src="<?php echo base_url() ?>assets/global/plugins/flot/jquery.flot.categories.min.js" type="text/javascript"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.22.2/moment.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.22.2/locale/id.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-tagsinput/0.8.0/bootstrap-tagsinput.min.js"></script>
<script src="https://gitcdn.github.io/bootstrap-toggle/2.2.2/js/bootstrap-toggle.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/magnific-popup.js/1.1.0/jquery.magnific-popup.min.js"></script>

<script>
	jQuery(document).ready(function() {    
	   Metronic.init(); // init metronic core componets
	   Layout.init(); // init layout
	   Demo.init(); // init demo features
	   UIGeneral.init();
	   Index.init();   
	   Index.initDashboardDaterange();
	   //Index.initJQVMAP(); // init index page's custom scripts
	   Index.initCalendar(); // init index page's custom scripts
	   Index.initCharts(); // init index page's custom scripts
	   Index.initChat();
	   Index.initMiniCharts();
	   Tasks.initDashboardWidget();

	    $('.date-mask').mask('00/00/0000');
	    $('.time-mask').mask('00:00:00');
	    $('.img-popup').magnificPopup({type:'image'});
	    //$(".uppercase").val().toUpperCase(),
	    $('.rupiah').mask('000.000.000.000', {reverse: true});
	});

	function upper(id){
		$('#'+id).keyup(function() {
	        this.value = this.value.toUpperCase();
	    });
	}

	function ucwords(str, id){
		str = str.toLowerCase().replace(/\b[a-z]/g, function(letter) {
		    return letter.toUpperCase();
		});
		$("#"+id).val(str);
	}
	

	function submitForm(id){

		var form = $("#"+id);
		var link = $(form).attr("url");

		$.ajax({
			url:link,
			data: $(form).serialize(),
			method:"POST",
			dataType:"JSON",
			beforeSend: function() {
               floading_on(id);
            },
		 	success: function(data){ 	   

		 		if (data[0].st == "1") {
		 			notif('Success', data[0].msg, 'success');

		 			$(".inp-"+id).val("");
		 			$(".inp-"+id).trigger("change");
		 			$("#md-"+id).modal('toggle');
		 		}
		 		else{
		 			notif('Error', data[0].msg, 'error');
		 		}

		 		table.ajax.reload(null, false);
					 			
			},
			complete:function(){
				floading_off(id);
			}
		});

	}

	function floading_on(f){
		$("#btn-"+f).attr("disabled", "disabled");
		$("#btn-"+f).html("<i class='fa fa-spinner fa-pulse'></i> Loading...");

		$(".inp-"+f).attr("disabled", "disabled");
	}
	function floading_off(f){
		$("#btn-"+f).removeAttr("disabled");
		$("#btn-"+f).html("Simpan");

		$(".inp-"+f).removeAttr("disabled");
	}


	function lead_zero(x){
	   y=(x>9)?x:'0'+x;
	   return y;
	}
    window.setTimeout("waktu()",1000);
    function waktu() {
        var tanggal = new Date();
        setTimeout("waktu()",1000);
        $("#jam").html(lead_zero(tanggal.getHours())+":"+lead_zero(tanggal.getMinutes())+":"+lead_zero(tanggal.getSeconds()));
    }

	function ribu(v){
		var x = parseInt(v).toLocaleString("de-DE");

		return x;
	}

	function select(url, id){
		$.ajax({
			url:"<?php echo base_url()?>"+url,
			type:"POST",
			daraType:"json",
			cache:false,
			beforeSend:function(){
				$("#"+id).attr("disabled", "disabled");
			},
			success:function(data){

				var op = "<option value='' selected>- Pilih -</option>";
				for(var i = 0;i<data.length;i++){

					if (url == "produk/select") {
						op += "<option value='"+data[i].produk_id+"' harga='"+data[i].harga+"' modal='"+data[i].modal+"' satuan='"+data[i].nama_satuan+"' qty='"+data[i].stok+"'>"+data[i].name+"</option>";
					}
					else{
						op += "<option value='"+data[i].id+"'>"+data[i].name+"</option>";
					}

					
				}

				$("#"+id).html(op);
			},
			complete:function(){
				if (url == "produk/select") {
					$('#produk').select2('focus');
				}
				$("#"+id).removeAttr("disabled");
			}
		 });	
	}

	function loading_event(){
		var l = "<i class='fa fa-spinner fa-pulse fa-lg'></i> Loading...";

		return l;
	}

	function notif(caption, msg, type){
		PNotify.prototype.options.styling = 'fontawesome';
		new PNotify({
		    title: caption,
		    text: msg,
		    type: type
		});
	}

	function toTgl(v){
        //1996-12-02
        //0123456789
        var tgl = v.substr(8,2);
        var bln = v.substr(5,2);
        var thn = v.substr(0,4);

        var value = tgl+"/"+bln+"/"+thn;

        return value;
    }

    

    function toTglnTime(v){
        //1996-12-02 00:00:00
        //0123456789012345678
        var tgl = v.substr(8,2);
        var bln = v.substr(5,2);
        var thn = v.substr(0,4);

        var time = v.substr(10);

        var value = tgl+"/"+bln+"/"+thn+" "+time;

        return value;
    }

    function toTglSys(v){
        //02-12-1996
        //0123456789

        var tgl = v.substr(0,2);
        var bln = v.substr(3,2);
        var thn = v.substr(6,4);

        var value = thn+"-"+bln+"-"+tgl;

        return value;
    }
</script>
<!-- END JAVASCRIPTS -->
</body>
<!-- END BODY -->
</html>