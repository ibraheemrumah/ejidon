<?php
    require_once 'includes/header.php';
?>
<!-- Add jQuery library -->
<script type="text/javascript" src="http://code.jquery.com/jquery-latest.min.js"></script>

<!-- Add mousewheel plugin (this is optional) -->
<script type="text/javascript" src="<?=base_url()?>assets/js/fancybox/lib/jquery.mousewheel-3.0.6.pack.js"></script>

<!-- Add fancyBox -->
<link rel="stylesheet" href="<?=base_url()?>assets/js/fancybox/source/jquery.fancybox.css?v=2.1.5" type="text/css" media="screen" />
<script type="text/javascript" src="<?=base_url()?>assets/js/fancybox/source/jquery.fancybox.pack.js?v=2.1.5"></script>

<!-- Optionally add helpers - button, thumbnail and/or media -->
<link rel="stylesheet" href="<?=base_url()?>assets/js/fancybox/source/helpers/jquery.fancybox-buttons.css?v=1.0.5" type="text/css" media="screen" />
<script type="text/javascript" src="<?=base_url()?>assets/js/fancybox/source/helpers/jquery.fancybox-buttons.js?v=1.0.5"></script>
<script type="text/javascript" src="<?=base_url()?>assets/js/fancybox/source/helpers/jquery.fancybox-media.js?v=1.0.6"></script>

<link rel="stylesheet" href="<?=base_url()?>assets/js/fancybox/source/helpers/jquery.fancybox-thumbs.css?v=1.0.7" type="text/css" media="screen" />
<script type="text/javascript" src="<?=base_url()?>assets/js/fancybox/source/helpers/jquery.fancybox-thumbs.js?v=1.0.7"></script>
<script type="text/javascript" src="<?=base_url()?>assets/js/DataTables/datatables.js"></script>

<link href="<?=base_url()?>assets/js/DataTables/datatables.css" rel="stylesheet">
<script type="text/javascript">
$(document).ready(function() {
    $('#example').DataTable( {
       "lengthMenu": [[10,   -1], [10,   "All"]]
        
    } );
} );
</script>
<style>

.row.show-me {
    display: none;
}

body {
background: #ffffff;

}

@media print {
		body { text-transform: uppercase; font-size:11px; }
		#buttons { display: none; }
		#wrapper { width: 100%; margin: 0; font-size:8px; }
		#wrapper img { max-width:300px; width: 80%; }
		#bkpos_wrp{
			display: none;
		}
		button.btn.btn-primary {
 		   display: none;
			}
		th.hide-me {
    		display: none;
		}
		td.hide-me {
 		   display: none;
		}
		th.hide-me {
    display: none;
	}
	.row.hide-me {
    display: none;
	}
	.row.show-me {
    display: contents;
}

	}







</style>
<div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2 main">
	
	<div width="100%" height="auto" align="center">
				
			<h2 class="page-header "><?php echo $setting_site_name; ?></h2>
			<h3 class="page-header"><?php echo "Stock Update List"; ?></h3>
			
		
	</div>
	<div class="row">
		<div class="col-md-12">
			<div class="panel panel-default">
				<div class="panel-body">
					
				<?php
                        $total_cost_amt = 0;
						$total_stock_qty = 0;
						$total_pcost_amt = 0;
						$today_start = date('Y-m-d 00:00:00', time());

                        $getAllInvResult = $this->db->query("SELECT * FROM inventory WHERE new_qty_date >= '$today_start'");
                        $getAllInvData = $getAllInvResult->result();

                        for ($g = 0; $g < count($getAllInvData); ++$g) {
                            $each_row_code = $getAllInvData[$g]->product_code;
                            $each_row_qty = $getAllInvData[$g]->qty;

                            $total_stock_qty += $each_row_qty;

                            $each_cost = 0;
                            $getCostResult = $this->db->query("SELECT retail_price, purchase_price FROM products WHERE code = '$each_row_code' ");
                            $getCostData = $getCostResult->result();

                            $each_cost = $getCostData[0]->retail_price;
							$each_pcost = $getCostData[0]->purchase_price;

                            unset($getCostResult);
                            unset($getCostData);

                            $total_cost_amt += ($each_row_qty * $each_cost);
							$total_pcost_amt += ($each_row_qty * $each_pcost);
                        }
						$profit = $total_cost_amt - $total_pcost_amt;
                    ?>
					
					<?php
					if ($user_role == '1'){
						?>
					<div class="row hide-me" style="padding-top: 10px; padding-bottom: 10px; font-size: 18px; letter-spacing: 0.5px; ">
						<div class="col-md-4" style="font-weight: bold;">Total Stock Qty.</div>
						<div class="col-md-8" style="font-weight: bold;">: 
							<?php echo $total_stock_qty; ?>
						</div>
					</div>
					<div class="row hide-me" style="padding-top: 10px; padding-bottom: 10px; font-size: 18px; letter-spacing: 0.5px; ">
						<div class="col-md-4" style="font-weight: bold;">Total Stock Value <?php echo $site_currency; ?></div>
						<div class="col-md-8" style="font-weight: bold;">: 
							<?php echo number_format($total_pcost_amt, 2); ?> 
						</div>
						
						</div>
					<div class="row hide-me" style="padding-top: 10px; padding-bottom: 10px; font-size: 18px; letter-spacing: 0.5px; ">
						<div class="col-md-4" style="font-weight: bold;">Total Stock Sales Value <?php echo $site_currency; ?></div>
						<div class="col-md-8" style="font-weight: bold;">: 
							<?php echo number_format($total_cost_amt, 2); ?> 
						</div>
						</div>
						<div class="row hide-me" style="padding-top: 10px; padding-bottom: 10px; font-size: 18px; letter-spacing: 0.5px; ">
						<div class="col-md-4" style="font-weight: bold;">Expected Profit<?php echo $site_currency; ?></div>
						<div class="col-md-8" style="font-weight: bold;">: 
							<?php echo number_format($profit, 2); ?> 
						</div>
						</div>
						
						
						<div align="right">
						<STRONG><span><?php echo date("d-m-Y"); ?></span><br></STRONG>
						</div>
					</div>
					<div>
					<div class="row show-me" style="padding-top: 10px; padding-bottom: 10px; font-size: 10px; letter-spacing: 0.5px; ">
						<div class="col-md-4" style="font-weight: bold;">Total Stock Qty.</div>
						<div class="col-md-8" style="font-weight: bold;">: 
							<?php echo $total_stock_qty; ?>
						</div>
					</div>
					
					<div class="row show-me" style="padding-top: 10px; padding-bottom: 10px; font-size: 10px; letter-spacing: 0.5px; ">
						<div class="col-md-4" style="font-weight: bold;">Total Stock Value <?php echo $site_currency; ?></div>
						<div class="col-md-8" style="font-weight: bold;">: 
							<?php echo number_format($total_pcost_amt, 2); ?> 
						</div>
						
						</div>
					<div class="row show-me" style="padding-top: 10px; padding-bottom: 10px; font-size: 10px; letter-spacing: 0.5px; ">
						<div class="col-md-4" style="font-weight: bold;">Total Stock Sales Value <?php echo $site_currency; ?></div>
						<div class="col-md-8" style="font-weight: bold;">: 
							<?php echo number_format($total_cost_amt, 2); ?> 
						</div>
						</div>
						<div class="row show-me" style="padding-top: 10px; padding-bottom: 10px; font-size: 10px; letter-spacing: 0.5px; ">
						<div class="col-md-4" style="font-weight: bold;">Expected Profit<?php echo $site_currency; ?></div>
						<div class="col-md-8" style="font-weight: bold;">: 
							<?php echo number_format($profit, 2); ?> 
						</div>
						</div>
					</div>

					<?php
					}
					?>
					<div class="row" style=" border-top: 1px solid #ddd;"></div>
					
					<div class="row" style="margin-top: 0px;">
						<div class="col-md-12">
							
						<div class="table-responsive">
							<table class="table table-boredred" id="example" class="display" cellspacing="0" width="100%">
							    <thead>
							    	<tr>
								    	<th class="hide-me" width="5%"><?php echo $lang_code; ?></th>
								    	<th width="15%"><?php echo $lang_name; ?></th>
								    	<th width="12.5%"><?php echo $lang_total_quantity; ?></th>
										<th class="hide-me" width="12.5%">Stock Qty</th>
								    	<th class="hide-me" width="15%">Total Sales Value</th>
									    <th class="hide-me" width="10%"><?php echo $lang_action; ?></th>
									</tr>
							    </thead>
								<tbody>
								<?php
                                    if (count($results) > 0) {
                                        foreach ($results as $data) {
                                            $id = $data->id;
                                            $code = $data->code;
											$name = $data->name;
											$new_qty = 0;

                                            $inv_qty = 0;

                                            $ckInvResult = $this->db->query("SELECT qty, new_qty, outlet_id FROM inventory WHERE product_code = '$code' ");
                                            $ckInvData = $ckInvResult->result();
                                            for ($k = 0; $k < count($ckInvData); ++$k) {
                                                $ckInv_qty = $ckInvData[$k]->qty;
												$ckOutlet_id = $ckInvData[$k]->outlet_id;
												$cknew_qty = $ckInvData[$k]->new_qty;

                                                // Check Outlet;
                                                $ckOutletResult = $this->db->query("SELECT id FROM outlets WHERE id = '$ckOutlet_id' ");
                                                $ckOutletRows = $ckOutletResult->num_rows();
                                                if ($ckOutletRows == 1) {
													$inv_qty += $ckInv_qty;
													$new_qty += $cknew_qty;
                                                }
                                                unset($ckOutletResult);
                                                unset($ckOutletRows);

												unset($ckInv_qty);
												unset($cknew_qty);
                                                unset($ckOutlet_id);
                                            }
                                            unset($ckInvResult);
                                            unset($ckInvData);

                                            $each_cost = 0;
                                            $getCostResult = $this->db->query("SELECT retail_price FROM products WHERE code = '$code' ");
                                            $getCostData = $getCostResult->result();

                                            $each_cost = $getCostData[0]->retail_price;

                                            unset($getCostResult);
                                            unset($getCostData);

                                            $each_row_cost = 0;
                                            $each_row_cost = $inv_qty * $each_cost; ?>
                                			<tr>
	                                			<td class="hide-me" ><?php echo $code; ?></td>
	                                			<td><?php echo $name; ?></td>
	                                			<td><?php echo $inv_qty; ?></td>
												<td class="hide-me"><?php echo $new_qty; ?></td>
	                                			<td class="hide-me"><?php echo number_format($each_row_cost, 2); ?></td>
	                                			<td class="hide-me">
												<?php
                                if ($user_role < 8 ) {
                                    ?>
		                                			<a href="<?=base_url()?>inventory/view_detail?pcode=<?php echo $code; ?>" style="text-decoration: none;">
			                                			<button class="btn btn-primary" style="padding: 5px 12px;">
			                                				&nbsp;&nbsp;<?php echo $lang_view; ?>&nbsp;&nbsp;
			                                			</button>
		                                			</a>
													<?php

                                }
                            ?>
	                                			</td>
                                			</tr>
                                <?php

                                        }
                                    } else {
                                        ?>
										<tr class="no-records-found">
											<td colspan="3"><?php echo $lang_no_match_found; ?></td>
										</tr>
								<?php

                                    }
                                ?>
								</tbody>
							</table>
						</div>
							
						</div>
					</div>
					<div align="right">
					
					</div>
					
					
					
					
					
				</div><!-- Panel Body // END -->
			</div><!-- Panel Default // END -->
		</div><!-- Col md 12 // END -->
	</div><!-- Row // END -->
	
	<br /><br /><br />
	
</div><!-- Right Colmn // END -->
	
	
	
<?php
    require_once 'includes/footer.php';
?>