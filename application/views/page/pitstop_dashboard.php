<?php  

        $n = date_create(date('Y-m-d'));
        date_add($n, date_interval_create_from_date_string('-7 days'));


?>

<div class="page-content">

				<!-- BEGIN PAGE HEADER-->
				<h3 class="page-title">
					Dashboard
				</h3>
				<div class="page-bar">
					<ul class="page-breadcrumb">
						<li>
							<i class="fa fa-home"></i>
							<a href="javascript:;">Dashboard</a>
						</li>
					</ul>
					<div class="page-toolbar">
						
					</div>
				</div>
				<!-- END PAGE HEADER-->
				<!-- BEGIN DASHBOARD STATS -->
				<div class="tabbable-custom " style="margin-bottom:0 !important;">
					<ul class="nav nav-tabs ">
						<li class="">
							<a href="<?php echo base_url() ?>dashboard">
								CBTEKNO 
							</a>
						</li>
						<li class="active">
							<a href="javascript:;">
								THE PIT STOP
							</a>
						</li>
					</ul>
				</div>
				<div class="tabbable-custom tabs-below" >
					<div class="tab-content" style="border-top:none;padding: 20px;">
						<div class="tab-pane active" id="tab_cbtekno">
							<div class="row">
								<div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
									<a class="dashboard-stat dashboard-stat-light blue" href="<?php echo base_url() ?>pitstop/penjualan">
									<div class="visual">
										<i class="fa fa-car"></i>
									</div>
									<div class="details">
										<div class="number" id="jual_hari">
											 0
										</div>
										<div class="desc">
											Penjualan Hari ini
										</div>
									</div>
									</a>
								</div>
								<div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
									<a class="dashboard-stat dashboard-stat-light blue" href="<?php echo base_url() ?>pitstop/penjualan">
									<div class="visual">
										<i class="fa fa-car"></i>
									</div>
									<div class="details">
										<div class="number" id="jual_bln">
											 0
										</div>
										<div class="desc">
											Penjualan Bulan Ini
										</div>
									</div>
									</a>
								</div>
								<div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
									<a class="dashboard-stat dashboard-stat-light green-soft" href="<?php echo base_url() ?>pitstop/pembelian">
									<div class="visual">
										<i class="fa fa-truck"></i>
									</div>
									<div class="details">
										<div class="number" id="beli_hari">
											 0
										</div>
										<div class="desc">
											Pembelian Hari Ini
										</div>
									</div>
									</a>
								</div>
								<div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
									<a class="dashboard-stat dashboard-stat-light green-soft" href="<?php echo base_url() ?>pitstop/pembelian">
									<div class="visual">
										<i class="fa fa-truck"></i>
									</div>
									<div class="details">
										<div class="number" id="beli_bln">
											 0
										</div>
										<div class="desc">
											Pembelian Bulan Ini
										</div>
									</div>
									</a>
								</div>
							</div>
							<div class="row">
								<div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
									<a class="dashboard-stat dashboard-stat-light purple-soft" href="<?php echo base_url() ?>pitstop/pelanggan">
									<div class="visual">
										<i class="fa fa-wrench"></i>
									</div>
									<div class="details">
										<div class="number" id="jasa_hari">
											 0
										</div>
										<div class="desc">
											Biaya Jasa Hari ini
										</div>
									</div>
									</a>
								</div>
								<div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
									<a class="dashboard-stat dashboard-stat-light purple-soft" href="<?php echo base_url() ?>pitstop/penjualan">
									<div class="visual">
										<i class="fa fa-wrench"></i>
									</div>
									<div class="details">
										<div class="number" id="jasa_bln">
											 0
										</div>
										<div class="desc">
											Biaya Jasa Bulan ini
										</div>
									</div>
									</a>
								</div>
								<div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
									<a class="dashboard-stat dashboard-stat-light red-soft" href="<?php echo base_url() ?>pitstop/penjualan">
									<div class="visual">
										<i class="fa fa-money"></i>
									</div>
									<div class="details">
										<div class="number" id="produk_ass">
											 0
										</div>
										<div class="desc">
											Asset Produk 
										</div>
									</div>
									</a>
								</div>
								<div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
									<a class="dashboard-stat dashboard-stat-light red-soft" href="<?php echo base_url() ?>pitstop/kategori">
									<div class="visual">
										<i class="fa fa-cubes"></i>
									</div>
									<div class="details">
										<div class="number" id="produk_jml">
											 0
										</div>
										<div class="desc">
											Jumlah Produk
										</div>
									</div>
									</a>
								</div>

							</div>

							<div class="clearfix">
							</div>
							<div class="row">
								<div class="col-md-6 col-sm-12">
									<!-- BEGIN PORTLET-->
									<div class="portlet ">
										<div class="portlet-title">
											<div class="caption">
												<i class="icon-share font-red-sunglo hide"></i>
												<span class="caption-subject font-blue bold uppercase">Grafik Penjualan</span>
												<span class="caption-helper">Per Hari</span>
											</div>
										</div>
										<div class="portlet-body">
											<div id="chart_jual_loading">
												<img src="<?php echo base_url()?>assets/layout2/img/loading.gif" alt="loading"/>
											</div>
											<div id="chart_jual_content" class="display-none">
												<div id="chart_jual" style="height: 228px;width: 100%">
												</div>
											</div>
											<div id="chart_jual_error" class="display-none">
												<label class="alert alert-danger">Error Load.</label>
											</div>

										</div>
									</div>
									<!-- END PORTLET-->
								</div>
							</div>
							<div class="row">
								<div class="col-md-6 col-sm-12">
									<!-- BEGIN PORTLET-->
									<div class="portlet box red-pink ">
										<div class="portlet-title">
											<div class="caption">
												<i class="icon-share font-red-sunglo hide"></i>
												<span class="caption-subject bold uppercase">Aktivitas</span>
											</div>
										</div>
										<div class="portlet-body">
											<div class="scroller" style="height: 353px;" data-always-visible="1" data-rail-visible1="1">
												<ul class="chats" id="act">
													
												</ul>
											</div>


										</div>
									</div>
									<!-- END PORTLET-->
								</div>
							</div>
						</div>
					</div>
				</div>

				
</div>

<script type="text/javascript">
	
	$(document).ready(function(){


		//setTimeout(function(){chart_penjualan();}, 2000);
		chart_penjualan("#chart_jual_loading", "#chart_jual_content", "#chart_jual_error", <?php echo $gjual; ?>,  "#chart_jual", "#3598DC");
		card();
		act();
		//pie2();
		setInterval(function(){card();}, 10000);
		//setInterval(function(){chart_penjualan();}, 10000);
		setInterval(function(){act();}, 5000);
	});
	function card(){
		$.ajax({
			url:"<?php echo base_url() ?>dashboard/cron_pitstop",
			dataType:"json",
			type:"POST",
			beforeSend:function(){

			},
			success:function(data){
				$("#jual_hari").html(data[0].jual_hari);
				$("#jual_bln").html(data[0].jual_bln);
				$("#beli_hari").html(data[0].beli_hari);
				$("#beli_bln").html(data[0].beli_bln);
				$("#jasa_hari").html(data[0].jasa_hari);
				$("#jasa_bln").html(data[0].jasa_bln);
				$("#produk_ass").html(data[0].aset);
				$("#produk_jml").html(data[0].produk);

			},
			complete:function(){

			}
		});
	}
	function act(){
		$.ajax({
			url:"<?php echo base_url() ?>dashboard/aktivitas_pitstop",
			dataType:"json",
			type:"POST",
			beforeSend:function(){

			},
			success:function(data){

				var act = "";

				for(var i =0;i<data.length;i++){


					act+="<li class='in'>";
						act+="<img class='avatar' alt='' src='<?php echo base_url() ?>upload/user/"+data[i].foto+"'/>";
						act+="<div class='message'>";
							act+="<span class='arrow'></span>";
							act+="<a href='javascript:;' class='name'></a>";
							act+="<span class='datetime' style='color:#898989'> "+data[i].tgl+"</span>";
							act+="<span class='body'>";
								act+= data[i].deskripsi;
							act+="</span>";
						act+="</div>";
					act+="</li>";
				}

				$("#act").html(act);

			},
			complete:function(){

			}
		});
	}
	/*
	function pie2(){


            var data = [];
            var series = Math.floor(Math.random() * 10) + 1;
            series = series < 5 ? 5 : series;

            for (var i = 0; i < series; i++) {
                data[i] = {
                    label: "Series" + (i + 1),
                    data: Math.floor(Math.random() * 100) + 1
                };
            }

            //[ ["04\/08\/2018","39183","2018-08-03"], ["05\/08\/2018","185735","2018-08-03"], ["06\/08\/2018","18498","2018-08-03"], ["07\/08\/2018","1496","2018-08-03"], ["08\/08\/2018","15972","2018-08-03"], ["09\/08\/2018","180564","2018-08-03"], ["10\/08\/2018","47190","2018-08-03"] ]

            var dt = [ 
            			{label:"Dispensing", data:"<?php echo $per['disp'] ?>", color:"#2C3E50"}, 
            			{label:"OTC", data:"<?php echo $per['otc'] ?>", color:"#1BA39C"},
            			{label:"Resep", data:"<?php echo $per['rsp'] ?>", color:"#D91E18"},
            			{label:"Generik", data:"<?php echo $per['gnk'] ?>", color:"#E87E04"},
            			{label:"Herbal", data:"<?php echo $per['hrb'] ?>", color:"#8E44AD"},
            			{label:"Alkes", data:"<?php echo $per['alk'] ?>", color:"#555555"}
            		];

		    if ($('#pie_chart_1').size() !== 0) {
                $.plot($("#pie_chart_1"), dt, {
                    series: {
                        pie: {
                            show: true,
                            radius: 1,
                            label: {
                                show: true,
                                radius: 3 / 4,
                                formatter: function(label, series) {
                                    return '<div style="font-size:8pt;text-align:center;padding:2px;color:white;">' + label + '<br/>' + Math.round(series.percent) + '%</div>';
                                },
                                background: {
                                    opacity: 0.5
                                }
                            }
                        }
                    },
                    legend: {
                        show: false
                    }
                });
            }
	}

	function pie(){

        var chart = AmCharts.makeChart("chart_6", {
            "type": "pie",
            "theme": "light",

            "fontFamily": 'Open Sans',
            
            "color":    '#888',

            "dataProvider": [{
                "country": "Lithuania",
                "litres": 501.9
            }, {
                "country": "Czech Republic",
                "litres": 301.9
            }, {
                "country": "Ireland",
                "litres": 201.1
            }, {
                "country": "Germany",
                "litres": 165.8
            }, {
                "country": "Australia",
                "litres": 139.9
            }, {
                "country": "Austria",
                "litres": 128.3
            }, {
                "country": "UK",
                "litres": 99
            }, {
                "country": "Belgium",
                "litres": 60
            }, {
                "country": "The Netherlands",
                "litres": 50
            }],
            "valueField": "litres",
            "titleField": "country",
            "exportConfig": {
                menuItems: [{
                    icon: Metronic.getGlobalPluginsPath() + "amcharts/amcharts/images/export.png",
                    format: 'png'
                }]
            }
        });

        $('#chart_6').closest('.portlet').find('.fullscreen').click(function() {
            chart.invalidateSize();
        });
	    
	}*/

	
	
    function showChartTooltip(x, y, xValue, yValue) {
        $('<div id="tooltip" class="chart-tooltip">' + yValue + '<\/div>').css({
            position: 'absolute',
            display: 'none',
            top: y - 40,
            left: x - 40,
            border: '0px solid #ccc',
            padding: '2px 6px',
            'background-color': '#fff'
        }).appendTo("body").fadeIn(200);
    }
	function chart_penjualan(loading, content, error, json, grap, color){
			var previousPoint2 = null;
            
            		$(loading).hide();
            		$(content).show();
                        var data1 = json;

            			var plot_statistics = $.plot($(grap),
	                    [{
	                        data: data1,
	                        lines: {
	                            fill: 0.6,
	                            lineWidth: 0,
	                        },
	                        color: [color]
	                    }, {
	                        data: data1,
	                        points: {
	                            show: true,
	                            fill: true,
	                            radius: 5,
	                            fillColor: color,
	                            lineWidth: 3
	                        },
	                        color: color,
	                        shadowSize: 0
	                    }],

		                {

		                    xaxis: {
		                        tickLength: 0,
	                            tickDecimals: 0,
	                            mode: "categories",
	                            min: 0,
	                            font: {
	                                lineHeight: 14,
	                                style: "normal",
	                                variant: "small-caps",
	                                color: color,
	                                size:9
	                            }
		                    },
		                    yaxis: {
		                        minTickSize: 1,
		                        tickFormatter: function (val, axis) {
		                            return val.toLocaleString("de-DE");
		                        },
		                        ticks: 7,
		                        tickDecimals: 0,
		                        tickColor: "#eee",
		                        font: {
		                            lineHeight: 14,
		                            style: "normal",
		                            variant: "small-caps",
		                            color: color
		                        }

		                    },
		                    grid: {
		                        hoverable: true,
		                        clickable: true,
		                        tickColor: "#eee",
		                        borderColor: "#eee",
		                        borderWidth: 1
		                    }
		                });

		            $(grap).bind("plothover", function (event, pos, item) {
		                $("#x").text(pos.x.toFixed(2));
		                $("#y").text(pos.y.toFixed(2));
		                if (item) {
		                    if (previousPoint2 != item.dataIndex) {
		                        previousPoint2 = item.dataIndex;
		                        $("#tooltip").remove();
		                        var x = item.datapoint[0].toFixed(2),
		                            y = item.datapoint[1].toFixed(2);
		                        showChartTooltip(item.pageX, item.pageY, item.datapoint[0], 'Rp. '+parseInt(item.datapoint[1]).toLocaleString("de-DE"));
		                    }
		                }
		                else {
	                        $("#tooltip").remove();
	                        previousPoint2 = null;
	                    }
		            });
	}

</script>