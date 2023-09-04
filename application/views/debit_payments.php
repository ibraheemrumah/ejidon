<?php
    require_once 'includes/header.php';

    $custDtaData = $this->Constant_model->getDataOneColumn('customers', 'id', $cust_id);

    if (count($custDtaData) == 0) {
        redirect(base_url());
    }

    $fullname = $custDtaData[0]->fullname;
    $email = $custDtaData[0]->email;
	$mobile = $custDtaData[0]->mobile;
	$cust_id = $custDtaData[0]->id;
	?>
	<div class="col-lg-12 text-center">
	
<div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2 main">		
			<h1 class="page-header "><?php echo $setting_site_name; ?></h1>
				<h3 class="page-header"><?php echo "Customer Unpaid Receipt"; ?> : <?php echo $fullname; ?></h3>
			</div>
		</div><!--/.row-->
		
		
		<div class="row">
			<div class="col-md-12">
				<div class="panel panel-default">
				
			
					<div class="panel-body">
						
						
						
						<div class="row" style="margin-top: 0px;">
							<div class="col-md-12">
							<div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2 main">					
							<div class="table-responsive">
								<table class="table">
									<thead>
										<tr>
											<th width="16%"><?php echo $lang_sale_id; ?></th>
											<th width="16%"><?php echo "Date"; ?></th>
											<th width="16%"><?php echo "Outlet"; ?></th>
											<th width="16%"><?php echo "Customer Name"; ?></th>
											<th width="16%"><?php echo "Grand Total"; ?></th>
											<th width="16%"><?php echo "Unpaid Amount"; ?></th>
											<th width="16%"><?php echo "Action"; ?></th>
										</tr>
									</thead>
									<tbody>
	
	<?php
	 $orderResult = $this->db->query("SELECT * FROM orders WHERE customer_id = $cust_id ");
	$orderData = $orderResult->result();

        $order_result_count = count($orderData);

        if ($order_result_count > 0) {
			foreach ($orderData as $data) {
				$id = $data->id;
				$cust_name = $data->customer_name;
				$order_date = $data->ordered_datetime;
				$outlet_name = $data->outlet_name;
				$grandTotal = $data->grandtotal;
				$paid_amt = $data->paid_amt;

				$unpaid_amt = 0;
				$unpaid_amt = $paid_amt - $grandTotal; ?>


<div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2 main">
	<div class="row">
									
								<tr>
	                                			<td><?php echo $id; ?></td>
	                                			<td><?php echo $order_date; ?></td>
	                                			<td><?php echo $outlet_name; ?></td>
	                                			<td><?php echo $cust_name; ?></td>
	                                			<td><?php echo number_format($grandTotal, 2); ?></td>
	                                			<td><?php echo number_format($unpaid_amt, 2); ?></td>
	                                			<td>		<?php
                    			if ($user_role < 3) {
                            ?>
									
								<a href="<?=base_url()?>pos/deposit?id=<?php echo $id; ?>" style="text-decoration: none;">
									<button class="btn btn-primary" style="padding: 4px 12px;">&nbsp;&nbsp;<?php echo "Make Payment"; ?>&nbsp;&nbsp;</button>
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
					
					
					
					
					
				</div><!-- Panel Body // END -->
			</div><!-- Panel Default // END -->
			
			
			<a href="<?=base_url()?>customers/view" style="text-decoration: none;">
				<div class="btn btn-success" style="background-color: #999; color: #FFF; padding: 0px 12px 0px 2px; border: 1px solid #999;"> 
					<i class="icono-caretLeft" style="color: #FFF;"></i><?php echo $lang_back; ?>
				</div>
			</a>
			
		</div><!-- Col md 12 // END -->
	</div><!-- Row // END -->
	
	
	<br /><br /><br /><br /><br />
	
</div><!-- Right Colmn // END -->
	
	
	
<?php
    require_once 'includes/footer.php';
?>