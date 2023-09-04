<?php
    require_once 'includes/header.php';
?>
<script type="text/javascript" src="<?=base_url()?>assets/js/DataTables/datatables.js"></script>

<link href="<?=base_url()?>assets/js/DataTables/datatables.css" rel="stylesheet">
<script type="text/javascript">
$(document).ready(function() {
    $('#example').DataTable( {
        
        paging:         false
		
    } );
} );
</script>
<style type="text/css" media="all">
	

	h2, h3, p { 
		margin: 5px 0;
	}
	.left { 
		width:100%; 
		float:left; 
		text-align:left; 
		margin-bottom: 3px;
		margin-top: 3px;
	}
	.right { 
		width:40%; 
		float:right; 
		text-align:right; 
		margin-bottom: 3px; 
	}
	.table, .totals { 
		width: 100%; 
		margin:10px 0; 
	}
	.table th { 
		border-top: 1px solid #000; 
		border-bottom: 1px solid #000; 
		padding-top: 4px;
		padding-bottom: 4px;
	}
	.table td { 
		padding:1px; 
	}
	.totals td { 
		width: 24%; 
		padding:1px; 
	}
	.table td:nth-child(2) { 
		overflow:hidden; 
	}
	body { background: #ffffff;
		
		}
	@media print {
		body { text-transform: uppercase; font-size:11px; font-width: bold;     background: #ffffff;
		
		}
		#buttons { display: none; }
		#bodi { margin: 0; font-size:12px; font-width: bold; }
		#wrapper img { max-width:300px; width: 80%; }
		#bkpos_wrp{
			display: none;
		}
		.mobi{
			display: none;
		}
		
		button.btn.btn-primary {
 		   display: none;
			}
		th.hide-me {
    		display: none;font-width: bold;
		}
		td.hide-me {
 		   display: none;font-width: bold;
		}
		td {
 		  font-width: bold;
		}
	}
</style>
<?php 
	
    $total_paid_amt 	= 0;
    
    $orderPaymentResult	= $this->db->query("SELECT * FROM customers");
    $orderPaymentData 	= $orderPaymentResult->result();
    for($opd = 0; $opd < count($orderPaymentData); $opd++) {
	    $total_paid_amt	+= $orderPaymentData[$opd]->current_balance;
    }
    unset($orderPaymentData);
    unset($orderPaymentResult);



?>
<div class="panel panel-default">
<div id="bodi "class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2 main">
	<div class="row">
		<div class="col-lg-12" align="center">
			<h2 class="page-header align-center"><?php echo $setting_site_name; ?></h2>
			<h3 class="align-center"><?php echo "DEBTORS BALANCE REPORT "; ?></h3>
		<div align="right">
		<STRONG><span><?php echo date("d-m-Y"); ?></span><br></STRONG>
		</div>
		<div align="left">
		<STRONG><span><?php echo "Total Debit"; ?>: N<?php echo number_format($total_paid_amt, 2);	?></span><br></STRONG>
		</div>
		</div>
	</div><!--/.row-->

	
					
					<div class="row" style="margin-top: 0px;">
						<div class="col-md-12">
							
							<div class="table-responsive">
								<table id="example" class="display" cellspacing="0" width="100%">
									<thead>
										<tr>
									    	<th style="border-left: 1px solid #ddd; border-bottom: 1px solid #ddd; border-top: 1px solid #ddd;" width="26%">
										    	<?php echo $lang_customer_name; ?>
									    	</th>
									    	<th class="mobi"style="border-left: 1px solid #ddd; border-bottom: 1px solid #ddd; border-top: 1px solid #ddd;" width="26%">
										    	<?php echo "Mobile"; ?>
									    	</th>
										    <th style="border-left: 1px solid #ddd; border-bottom: 1px solid #ddd; border-top: 1px solid #ddd;" width="20%">
											    <?php echo "Current Balance"; ?>
										    </th>
										    <th class="hide-me" style="border-left: 1px solid #ddd; border-bottom: 1px solid #ddd; border-top: 1px solid #ddd; border-right: 1px solid #ddd;" width="25%"><?php echo $lang_action; ?></th>
										</tr>
									</thead>
									<tbody>
									<?php
									
                                        if (count($results) > 0) {
                                            foreach ($results as $data) {
                                                $cust_id = $data->id;
                                                $cust_fn = $data->fullname;
                                                $cust_em = $data->email;
												$cust_mb = $data->mobile; 
												$current_bal = $data->current_balance;
												?>
									<?php if ($current_bal > 0) {
										?>
												<tr>
													<td style="border-bottom: 1px solid #ddd;"><?php echo $cust_fn; ?></td>
													
													<td class="hide-me" style="border-bottom: 1px solid #ddd;">
													<?php
                                                        if (empty($cust_mb)) {
                                                            echo '-';
                                                        } else {
                                                            echo $cust_mb;
                                                        } ?>
													</td>
													<td style="border-bottom: 1px solid #ddd;">
													<?php
                                                       echo number_format($current_bal, 2);	?>
													</td>
													<td class="hide-me" style="border-bottom: 1px solid #ddd;">
								<a href="<?=base_url()?>customers/edit_customer?cust_id=<?php echo $cust_id; ?>" style="text-decoration: none;">
									<button class="btn btn-primary" style="padding: 4px 12px;">&nbsp;&nbsp;<?php echo $lang_edit; ?>&nbsp;&nbsp;</button>
								</a>
								
								<a href="<?=base_url()?>customers/customer_history?cust_id=<?php echo $cust_id; ?>" style="text-decoration: none; margin-left: 10px;">
									<button class="btn btn-primary" style="padding: 4px 12px;">&nbsp;&nbsp;<?php echo $lang_sales_history; ?>&nbsp;&nbsp;</button>
								</a>
													</td>
												</tr>
									<?php

                                            }
                                        }
                                            ?>
											
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
	
</div>
	
<?php
    require_once 'includes/footer.php';
?>