<?php
    $settingResult = $this->db->get_where('site_setting');
    $settingData = $settingResult->row();

    $setting_dateformat = $settingData->datetime_format;
    $setting_site_logo = $settingData->site_logo;
?>

<!doctype html>
<html>
<head>
		<meta charset="utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1" />
		<title><?php echo "Inventory Level"; ?></title>

		<link href="<?=base_url()?>assets/css/bootstrap.min.css" rel="stylesheet">
		<link href="<?=base_url()?>assets/css/datepicker3.css" rel="stylesheet">
		<link href="<?=base_url()?>assets/css/styles.css" rel="stylesheet">
		<style type="text/css" media="all">
		
	<style>
	body { 
		max-width: 950px; 
		margin:0 auto; 
		text-align:center; 
		
		font-family: Arial, Helvetica, sans-serif; 
		font-size:14px; 
	}
	#wrapper { 
		min-width: 900px; 
		margin-left: 20px;
    	margin-right: 20px;
    	margin-top: 0px; 
	}

	.right { 
		width:40%; 
		float:right; 
		text-align:right; 
		margin-right: 30px; 

	}

	@media print {
  #printwithout {
    display: none;
  }
}
</style>
	</head>



<body>
<div id="wrapper">
    <table border="0" style="border-collapse: collapse; width: 100%; height: auto;">
	    <tr>
		    <td width="100%" align="center">
			    <center>
			    	<img src="<?=base_url()?>assets/img/logo/<?php echo $setting_site_logo; ?>" style="width: 80px;" />
			    </center>
		    </td>
	    </tr>
	    
		<tr>
			<td width="100%" align="center">
			<h2 style="padding-top: 0px; font-size: 24px;"><strong><?php echo "TANKURI VENTURES LTD"; ?></strong></h2>
				<h4><?php echo "Address:"; ?> : <?php echo "I.B.B Way, P.O Box 918, Opp. C.P.S Station, Katsina"; ?></h4>	
				<h5><?php echo "Contact No:"; ?> : <?php echo "08035047071, 08027418455, 08037404991"; ?></h5> 

				
				<h3 class="page-header"><?php echo "INVENTORY LEVEL"; ?></h3>
				<br><strong class="right" style="text-align: right;"> <?php echo "Printed on  "  .date('d-m-Y'); ?></strong>	
                
				
			
			</td>
		</tr>   
    </table>
<br/>
<div class="col-lg-12">
	
<div class="row">
		<div class="col-md-12">
			<div class="panel panel-default">
				<div class="panel-body">
					
				<?php
                        $total_cost_amt = 0;
						$total_stock_qty = 0;
						

                        $getAllInvResult = $this->db->query('SELECT * FROM inventory ');
                        $getAllInvData = $getAllInvResult->result();

                        for ($g = 0; $g < count($getAllInvData); ++$g) {
                            $each_row_code = $getAllInvData[$g]->product_code;
                            $each_row_qty = $getAllInvData[$g]->qty;

                            $total_stock_qty += $each_row_qty;

                            $each_cost = 0;
                            $getCostResult = $this->db->query("SELECT retail_price FROM products WHERE code = '$each_row_code' ");
                            $getCostData = $getCostResult->result();

                            $each_cost = $getCostData[0]->retail_price;

                            unset($getCostResult);
                            unset($getCostData);

                            $total_cost_amt += ($each_row_qty * $each_cost);
                        }
                    ?>
					<div class="row" style="padding-top: 10px; padding-bottom: 10px; font-size: 18px; letter-spacing: 0.5px; ">
						<div class="col-md-3" style="font-weight: bold;">Total Stock Qty.</div>
						<div class="col-md-9" style="font-weight: bold;">:
							<?php echo $total_stock_qty; ?>
						</div>
					</div>
					
					<div class="row" style="padding-top: 10px; padding-bottom: 10px; font-size: 18px; letter-spacing: 0.5px; ">
						<div class="col-md-3" style="font-weight: bold;">Total Stock Value (<?php echo $site_currency; ?>)</div>
						<div class="col-md-9" style="font-weight: bold;">: N
							<?php echo number_format($total_cost_amt, 2); ?>
						</div>
						
					</div>	
					
					<div class="row" style=" border-top: 1px solid #ddd;"></div>
					
					<div class="row" style="margin-top: 0px;">
						<div class="col-md-12">
							
						<div class="table-responsive">
							<table class="table">
							    <thead>
							    	<tr>
								    	<th width="5%"><?php echo $lang_code; ?></th>
								    	<th width="15%"><?php echo $lang_name; ?></th>
								    	<th width="12.5%"><?php echo $lang_total_quantity; ?></th>
										<th width="12.5%">Last total upadate</th>
								    	<th width="15%">Total Sales Value</th>
									    <th width="10%" td id ="printwithout"><?php echo $lang_action; ?></th>
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
											$new_qty_date = 0;
                                            $inv_qty = 0;
											
                                            $ckInvResult = $this->db->query("SELECT qty, new_qty, outlet_id, new_qty_date FROM inventory WHERE product_code = '$code' ");
                                            $ckInvData = $ckInvResult->result();
                                            for ($k = 0; $k < count($ckInvData); ++$k) {
                                                $ckInv_qty = $ckInvData[$k]->qty;
												$ckOutlet_id = $ckInvData[$k]->outlet_id;
												$cknew_qty = $ckInvData[$k]->new_qty;
												$new_qty_date = $ckInvData[$k]->new_qty_date;
												

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
									<!-- display only last update > zero -->
									<?php
                						
                						if( $inv_qty > 0) {
											?>
											<tr>
	                                		<td><?php echo $code; ?></td>
	                                		<td><?php echo $name; ?></td>
	                            			<td><?php echo $inv_qty; ?></td>
											<td><?php echo $new_qty; ?></td>
	                            			<td><?php echo number_format($each_row_cost, 2); ?></td>
	                            			<td id ="printwithout">
		                                			<a  href="<?=base_url()?>inventory/view_detail?pcode=<?php echo $code; ?>" style="text-decoration: none;">
			                                			<button id ="printwithout" class="btn btn-primary" style="padding: 5px 12px;">
			                                				&nbsp;&nbsp;<?php echo $lang_view; ?>&nbsp;&nbsp;
			                                			</button>
		                                			</a>
	                                			</td>
                                			</tr>
										<?php

											}
										?>
                                		<!-- end display only last update > zero -->
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
					
					
				</div><!-- Panel Body // END -->
			</div><!-- Panel Default // END -->
		</div><!-- Col md 12 // END -->
	</div><!-- Row // END -->
	
	<br /><br /><br />
	
</div><!-- Right Colmn // END -->
	
	
	
<?php
    require_once 'includes/footer.php';
?>