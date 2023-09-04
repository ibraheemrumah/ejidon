<?php
    require_once 'includes/header.php';

    $returnData = $this->Constant_model->getDataTwoColumn('orders', 'id', $return_id, 'status', '2');
    if (count($returnData) == 0) {
        redirect(base_url().'dashboard');
    }

    $ret_cust_name = $returnData[0]->customer_name;
    $ret_date_time = date("$site_dateformat", strtotime($returnData[0]->ordered_datetime));
    $ret_outlet_id = $returnData[0]->outlet_id;
    $ret_subTotal = $returnData[0]->subtotal;
    $ret_taxTotal = $returnData[0]->tax;
    $ret_grandTotal = $returnData[0]->grandtotal;
    $ret_paid_by = $returnData[0]->payment_method;
    $ret_cheque_no = $returnData[0]->cheque_number;
    $ret_paid_amt = $returnData[0]->paid_amt;
    $ret_staff_id = $returnData[0]->created_user_id;
    $ret_vt_status = $returnData[0]->refund_status;
    $ret_remark = $returnData[0]->remark;

    $outlet_name = $returnData[0]->outlet_name;
    $pay_name = $returnData[0]->payment_method_name;

    $staff_name = '';
    $staffData = $this->Constant_model->getDataOneColumn('users', 'id', $ret_staff_id);
    if (count($staffData) == 1) {
        $staff_name = $staffData[0]->fullname;
    }
?>



<div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2 main">
	<div class="row">
		<div class="col-lg-12">
			<h1 class="page-header"><?php echo $lang_return_order_confirmation; ?></h1>
		</div>
	</div><!--/.row-->
	
	<div class="row">
		<div class="col-md-12">
			<div class="panel panel-default">
				<div class="panel-body">
					
					<?php
                        if (!empty($alert_msg)) {
                            $flash_status = $alert_msg[0];
                            $flash_header = $alert_msg[1];
                            $flash_desc = $alert_msg[2];

                            if ($flash_status == 'failure') {
                                ?>
							<div class="row" id="notificationWrp">
								<div class="col-md-12">
									<div class="alert bg-warning" role="alert">
										<i class="icono-exclamationCircle" style="color: #FFF;"></i> 
										<?php echo $flash_desc; ?> <i class="icono-cross" id="closeAlert" style="cursor: pointer; color: #FFF; float: right;"></i>
									</div>
								</div>
							</div>
					<?php	
                            }
                            if ($flash_status == 'success') {
                                ?>
							<div class="row" id="notificationWrp">
								<div class="col-md-12">
									<div class="alert bg-success" role="alert">
										<i class="icono-check" style="color: #FFF;"></i> 
										<?php echo $flash_desc; ?> <i class="icono-cross" id="closeAlert" style="cursor: pointer; color: #FFF; float: right;"></i>
									</div>
								</div>
							</div>
					<?php

                            }
                        }
                    ?>
					
									
										
					<div class="row">
						
						<div class="col-md-9">
							<div class="form-group">
								<label style="font-size: 14px;"><?php echo $lang_outlets; ?></label>
								<br />
								<?php echo $outlet_name; ?>
							</div>
						</div>
						<div class="col-md-3">
							<div class="form-group">
								<label style="font-size: 14px;"><?php echo "Amount Spent"; ?></label>
								<br/>
								<?php echo number_format($ret_paid_amt, 2); ?> (<?php echo $site_currency; ?>)
							</div>
						</div>
						

						
					</div>
					
					<div class="row">
						<div class="col-md-7">
							<div class="form-group">
								<label style="font-size: 14px;"><?php echo "Reasons"; ?></label>
								<br />
								<?php echo nl2br($ret_remark); ?>
							</div>
						</div>
						
					</div>
				
					
					<div class="row">
						<div class="col-md-12" style="text-align: left;">
							<a href="<?=base_url()?>expenseorder/printReturn?return_id=<?php echo $return_id ?>" style="text-decoration: none;">
								<button type="button" class="btn btn-success" style="background-color: #5cb85c; border-color: #4cae4c;">
									<?php echo "Print Expense Receipt"; ?>
								</button>
							</a>
						</div>
						
						
					</div>
					
					
					
					<div class="row" style="margin-top: 5px; margin-bottom: 15px;">
						<div class="col-md-12" style="border-top: 1px solid #ccc;"></div>
					</div>
					
										
					<div class="row">
						<div class="col-md-12">

						</div>
					</div>
					
					<!-- Product List // END -->
					
					
					
					
					
				</div><!-- Panel Body // END -->
			</div><!-- Panel Default // END -->
			
			
		</div><!-- Col md 12 // END -->
	</div><!-- Row // END -->
	
	<br /><br /><br /><br /><br />
	
</div><!-- Right Colmn // END -->
	
	
<?php
    require_once 'includes/footer.php';
?>

