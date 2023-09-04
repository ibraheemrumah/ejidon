<?php
    require_once 'includes/header.php';
?>
<div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2 main">
	<div class="row">
		<div class="col-lg-12">
			<h1 class="page-header"><?php echo $lang_dashboard; ?></h1>
		</div>
	</div><!--/.row-->
	
	<div class="row">
		<div class="col-xs-6 col-md-2">
			<div class="panel panel-default">
				<a href="<?=base_url()?>pos" style="text-decoration: none">
					<div class="panel-body easypiechart-panel" style="padding-bottom: 30px;">
						<h4><?php echo $lang_point_of_sales; ?></h4>
						<i class="icono-tiles" style="color: #772953;"></i>
					</div>
				</a>
			</div>
		</div>
		<?php
            if ($user_role < 3) {
                ?>
		<div class="col-xs-6 col-md-2">
			<div class="panel panel-default">
				<a href="<?=base_url()?>sales/list_sales" style="text-decoration: none">
					<div class="panel-body easypiechart-panel" style="padding-bottom: 30px;">
						<h4><?php echo $lang_sales; ?></h4>
						<i class="icono-cart" style="color: #772953;"></i>
					</div>
				</a>
			</div>
		</div>
		
		<div class="col-xs-6 col-md-2">
			<div class="panel panel-default">
				<a href="<?=base_url()?>reports/sales_report" style="text-decoration: none">
					<div class="panel-body easypiechart-panel" style="padding-bottom: 30px;">
						<h4><?php echo $lang_reports; ?></h4>
						<i class="icono-barChart" style="color: #772953;"></i>
					</div>
				</a>
			</div>
		</div>
		<?php

            }
        ?>
		<?php
            if ($user_role < 2) {
                ?>
		<div class="col-xs-6 col-md-2">
			<div class="panel panel-default">
				<a href="<?=base_url()?>setting/outlets" style="text-decoration: none">
					<div class="panel-body easypiechart-panel" style="padding-bottom: 30px;">
						<h4><?php echo $lang_outlets; ?></h4>
						<i class="icono-market" style="color: #772953;"></i>
					</div>
				</a>
			</div>
		</div>
		<div class="col-xs-6 col-md-2">
			<div class="panel panel-default">
				<a href="<?=base_url()?>setting/users" style="text-decoration: none;">
					<div class="panel-body easypiechart-panel" style="padding-bottom: 30px;">
						<h4><?php echo $lang_users; ?></h4>
						<i class="icono-user" style="color: #772953;"></i>
					</div>
				</a>
			</div>
		</div>
		<?php

            }
        ?>
		<?php
            if ($user_role == '1') {
                ?>
		<div class="col-xs-6 col-md-2">
			<div class="panel panel-default">
				<a href="<?=base_url()?>setting/system_setting" style="text-decoration: none;">
					<div class="panel-body easypiechart-panel" style="padding-bottom: 30px;">
						<h4><?php echo $lang_system_setting; ?></h4>
						<i class="icono-gear" style="color: #772953;"></i>
					</div>
				</a>
			</div>
		</div>
		<?php

            }
        ?>
	</div><!--/.row-->
	
	
	
	
<script src="<?=base_url()?>assets/js/highcharts.js"></script>
<script src="<?=base_url()?>assets/js/exporting.js"></script>	
<script type="text/javascript">
	$(document).on('ready', function() {
		$(function () {
		    $('#sales_chart').highcharts({
		        chart: {
		            type: 'column'
		        },
		        title: {
		            text: '<?php echo $lang_monthly_sales_outlet; ?>'
		        },
		        subtitle: {
		            text: ''
		        },
		        xAxis: {
		            categories: [
			        <?php
                          for ($mn = 0; $mn < count($month_name_array); ++$mn) {
                              echo "'".$month_name_array[$mn].' '.$year_name_array[$mn]."',";
                          }
                    ?>
		            ],
		            crosshair: true
		        },
		        yAxis: {
		            min: 0,
		            title: {
		                text: '<?php echo $lang_amount; ?> (<?php echo $currency; ?>)'
		            }
		        },
		        tooltip: {
		            headerFormat: '<span style="font-size:10px">{point.key}</span><table>',
		            pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name}: </td>' +
		                '<td style="padding:0"><b> {point.y:.2f}</b></td></tr>',
		            footerFormat: '</table>',
		            shared: true,
		            useHTML: true
		        },
		        plotOptions: {
		            column: {
		                pointPadding: 0.2,
		                borderWidth: 0
		            }
		        },
		        series: [
			        <?php
                        if ($user_role == '1') {
                            $outletData = $this->Constant_model->getDataOneColumnSortColumn('outlets', 'status', '1', 'id', 'DESC');
                        } else {
                            $outletData = $this->Constant_model->getDataTwoColumnSortColumn('outlets', 'id', "$user_outlet", 'status', '1', 'id', 'DESC');
                        }

                          for ($o = 0; $o < count($outletData); ++$o) {
                              $outlet_id = $outletData[$o]->id;
                              $outlet_name = $outletData[$o]->name; ?>
					{
			            name: '<?php echo $outlet_name; ?>',
			            data: [
			            	<?php
                                for ($m = 0; $m < count($months); ++$m) {
                                    $year = date('Y', strtotime($months[$m]));
                                    $mon = date('m', strtotime($months[$m]));

                                    $total_monthly_amt = 0;
                                    $number_of_day = cal_days_in_month(CAL_GREGORIAN, $mon, $year);

                                    for ($d = 1; $d <= $number_of_day; ++$d) {
                                        if (strlen($d) == 1) {
                                            $d = '0'.$d;
                                        }

                                        $full_date_start = $year.'-'.$mon.'-'.$d.' 00:00:00';
                                        $full_date_end = $year.'-'.$mon.'-'.$d.' 23:59:59';

                                        $orderResult = $this->db->query("SELECT grandtotal FROM orders WHERE ordered_datetime >= '$full_date_start' AND ordered_datetime <= '$full_date_end' AND outlet_id = '$outlet_id' ");
                                        $orderData = $orderResult->result();
                                        for ($od = 0; $od < count($orderData); ++$od) {
                                            $total_monthly_amt += number_format($orderData[$od]->grandtotal, 2, '.', '');
                                        }
                                        unset($orderResult);
                                        unset($orderData);
                                    }    // End of Number of Day Loop;
                                    echo $total_monthly_amt.',';
                                } ?>
			            ]
			
			        }, 
					<?php

                          }
                    ?>
		        ]
		    });
		});		
	});
</script>
	
	<div class="row">
		<div class="col-lg-12">
			<div class="panel panel-default">
				<!-- <div class="panel-heading">Sales Chart</div> -->
				<div class="panel-body">
				
					<?php
                if ($user_role == '1'|| $user_role == '4' || $user_role == '6' ) {
                    ?>
					<form action="<?=base_url()?>returnorder/create_return" method="get">
					<div>	<div class="col-md-3">
							<div class="form-group">
								<label><?php echo "Sale Id"; ?></label>
								<input type="text" name="sales_id" class="form-control" required autocomplete="off"  />
							</div>
						</div>
						
						<div class="col-md-3">
							<div id="bkpos_wrp" class="form-group">
								<label>&nbsp;</label><br />
								
								<input type="submit" class="btn btn-primary" value="<?php echo "Create Return"; ?>" />
							</div>
						</div>
						<div class="col-md-3">
							<div id="bkpos_wrp" class="form-group">
								<label> <br>Enter Sale Id to prepare return order for the customer.</label>
								
							</div>
						</div>
					
					</form>
					<?php

                } ?>
				
				
			</div>
		</div>
	</div><!--/.row-->
	
	<br /><br /><br />
	
</div><!-- Right Colmn // END -->
	
	
	
<?php
    require_once 'includes/footer.php';
?>