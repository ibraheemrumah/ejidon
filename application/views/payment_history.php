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
<script type="text/javascript" src="<?=base_url()?>assets/js/DataTables/datatables.js"></script>

<link href="<?=base_url()?>assets/js/DataTables/datatables.css" rel="stylesheet">
<script type="text/javascript">
	$(document).ready(function() {
    $('#example').DataTable( {
        "paging":   false,
        "ordering": false,
        "info":     false
    } );
} );
</script>
	<div class="col-lg-12 text-center">


<style>
table, th, td {
        border: 0.5px solid black;
    }

    @media print {
		body { text-transform: uppercase; }

		#bkpos_wrp{
			display: none;
		}
	}
.balance {
   padding-right: 30px;
   padding-top: 15px;
   font-size: medium;

}

.view-btn {
    padding-bottom: 10px;
	padding-top: 10px;
}

</style>
	
<div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2 main">		
			<h1 class="page-header "><?php echo $setting_site_name; ?></h1>
				<h3 class="page-header"><?php echo "Payments history"; ?> : <?php echo $fullname; ?></h3>
			</div>
		</div><!--/.row-->
		
		
		<div class="row">
			<div class="col-md-12">
				<div class="panel panel-default">
				
			
					<div class="panel-body">
						
						
						
						<div class="row" style="margin-top: 0px;">
							<div class="col-md-12">
							<div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2 main">					
							<div>
								<table id="example" class="display" cellspacing="0" width="75%">
									<thead>
										<tr>
											
											<th width="10%"><?php echo "Date"; ?></th>
											
											<th width="15%"><?php echo "Customer Name"; ?></th>
											
											<th width="15%"><?php echo "Received by"; ?></th>
											<th width="15%"><?php echo "Paid Amount"; ?></th>
											<th width="10%"><?php echo "Action"; ?></th>
											
											
										</tr>
									</thead>
									<tbody>
	
	<?php
	 $orderResult = $this->db->query("SELECT orders.id,orders.customer_name,orders.current_balance, orders.customer_id, order_payments.payment_amount,order_payments.created_datetime, order_payments.created_user_id, order_payments.order_id, order_payments.id FROM orders INNER JOIN order_payments ON orders.id = order_payments.order_id WHERE orders.customer_id = $cust_id  ");
	 
	$orderData = $orderResult->result();

        $order_result_count = count($orderData);
		$sub_total = 0;
		
        if ($order_result_count > 0) {
			foreach ($orderData as $data) {
				$id = $data->order_id;
				$cust_name = $data->customer_name;
				$order_date = $data->created_datetime;
				$payment_id = $data->id;
				
				
				$paid_amt = $data->payment_amount;
				$p_user_id = $data->created_user_id;
				
				$sub_total += $paid_amt;
				
				?>


<div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2 main">
	<div class="row">
									
								<tr>
								<?php 
								$staffData = $this->Constant_model->getDataOneColumn('users', 'id', $p_user_id);

								$staff_name = $staffData[0]->fullname;

								
								
								if ($paid_amt > 0){
									?>
	                                		
	                                			<td><?php echo $order_date; ?></td>
	                                			
	                                			<td><?php echo $cust_name; ?></td>
												<td><?php echo $staff_name; ?></td>
												<td><?php echo number_format($paid_amt, 2); ?></td>
												<td>
												<a id="hide" href="<?=base_url()?>debit/deletePayment?id=<?php echo $payment_id; ?>" style="text-decoration: none; margin-left: 5px;" title="Delete" onclick="return confirm('Are you confirm to delete this Sale?')">
												<i class="icono-crossCircle" style="color: #F00"></i>
												</a>
												</td>
												
												
	                                			
	                                		<?php

                                    }
                                ?>	
	                                			
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
								<tr>
											<td colspan="3" align="right" style="border-top: 1px solid #010101;"><b><?php echo "Total"; ?></b></td>
											<td style="border-top: 1px solid #010101;">
												<b><?php echo "N"; ?> <?php echo number_format($sub_total, 2); ?></b>
											</td>
											
											
										</tr>	
								</tbody>
							</table>			
							</div>
							
						</div>
					</div>
					
					
					
					
					
				</div><!-- Panel Body // END -->
			</div><!-- Panel Default // END -->
			
			
			
			
		</div><!-- Col md 12 // END -->
	</div><!-- Row // END -->
	
	
	<br /><br /><br /><br /><br />
	
</div><!-- Right Colmn // END -->
	
	
	
<?php
    require_once 'includes/footer.php';
?>