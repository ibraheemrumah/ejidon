<?php
    require_once 'includes/header.php';

    $orderRows = 0;
?>
<link rel="stylesheet" href="//code.jquery.com/ui/1.12.0/themes/base/jquery-ui.css">
<script src="https://code.jquery.com/jquery-1.12.4.js"></script>
<script src="https://code.jquery.com/ui/1.12.0/jquery-ui.js"></script>
<script>
	$( function() {
		$( "#startDate" ).datepicker({
			format: "<?php echo $dateformat; ?>",
			autoclose: true
		});

		$("#endDate").datepicker({
			format: "<?php echo $dateformat; ?>",
			autoclose: true
		});
	} );
</script>

<?php
    $url_outlet = '';
    $url_paid_by = '';
    $url_start = '';
    $url_end = '';

    if (isset($_GET['report'])) {
        $url_outlet = $_GET['outlet'];
        $url_paid_by = $_GET['paid'];
        $url_start = $_GET['start_date'];
        $url_end = $_GET['end_date'];
    }
?>
<script type="text/javascript">
	function openReceipt(ele){
		var myWindow = window.open(ele, "", "width=380, height=550");
	}
</script>

<script type="text/javascript" src="<?=base_url()?>assets/js/datatables/jquery-1.12.3.js"></script>
<script type="text/javascript" src="<?=base_url()?>assets/js/datatables/jquery.dataTables.min.js"></script>
<link href="<?=base_url()?>assets/js/datatables/jquery.dataTables.min.css" rel="stylesheet">
<style>
    table, th, td {
        border: 1px solid black;
    }

    @media print {
		body { text-transform: uppercase; }

        #example{
			display: none;
		}
		#bkpos_wrp{
			display: none;
		}
	}

</style>

<div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2 main">
	<div class="row">
		<div class="col-lg-12">
			<h1 class="page-header"><?php echo $lang_sales_report; ?></h1>
		</div>
	</div><!--/.row-->

	<div class="row">
		<div class="col-md-12">
			<div class="panel panel-default">
				<div class="panel-body">

					<form action="<?=base_url()?>reports/sales_report" method="get">
					<div class="row">
						<div class="col-md-3">
							<div id="bkpos_wrp" class="form-group">
								<label><?php echo $lang_outlets; ?></label>
								<select name="outlet" class="form-control" required>
								<?php
                                    if ($user_role == '1') {
                                        ?>
									<option value=""><?php echo $lang_choose_outlet; ?></option>
									<option value="-" <?php if ($url_outlet == '-') {
                                            echo 'selected="selected"';
                                        } ?>><?php echo $lang_all_outlets; ?></option>
								<?php

                                    }
                                ?>

								<?php
                                    if ($user_role == '1') {
                                        $outletData = $this->Constant_model->getDataAll('outlets', 'id', 'ASC');
                                    } else {
                                        $outletData = $this->Constant_model->getDataOneColumn('outlets', 'id', "$user_outlet");
                                    }
                                    for ($o = 0; $o < count($outletData); ++$o) {
                                        $outlet_id = $outletData[$o]->id;
                                        $outlet_fn = $outletData[$o]->name; ?>
										<option value="<?php echo $outlet_id; ?>" <?php if ($url_outlet == $outlet_id) {
                                            echo 'selected="selected"';
                                        } ?>>
											<?php echo $outlet_fn; ?>
										</option>
								<?php

                                    }
                                ?>
								</select>
							</div>
						</div>
						<div class="col-md-3">
							<div id="bkpos_wrp" class="form-group">
								<label><?php echo $lang_paid_by; ?></label>
								<select name="paid" class="form-control" required>
									<option value=""><?php echo $lang_choose_paid_by; ?></option>
									<option value="-" <?php if ($url_paid_by == '-') {
                                    echo 'selected="selected"';
                                } ?>><?php echo $lang_all; ?></option>
								<?php
                                    $paymentData = $this->Constant_model->getDataAll('payment_method', 'name', 'ASC');
                                    for ($p = 0; $p < count($paymentData); ++$p) {
                                        $pay_id = $paymentData[$p]->id;
                                        $pay_name = $paymentData[$p]->name; ?>
										<option value="<?php echo $pay_id; ?>" <?php if ($url_paid_by == "$pay_id") {
                                            echo 'selected="selected"';
                                        } ?>>
											<?php echo $pay_name; ?>
										</option>
								<?php

                                    }
                                ?>
								</select>
							</div>
						</div>
						<div class="col-md-2">
							<div class="form-group">
								<label><?php echo $lang_start_date; ?></label>
								<input type="text" name="start_date" class="form-control" id="startDate" required autocomplete="off" value="<?php echo $url_start; ?>" />
							</div>
						</div>
						<div class="col-md-2">
							<div class="form-group">
								<label><?php echo $lang_end_date; ?></label>
								<input type="text" name="end_date" class="form-control" id="endDate" required autocomplete="off" value="<?php echo $url_end; ?>" />
							</div>
						</div>
						<div class="col-md-2">
							<div id="bkpos_wrp" class="form-group">
								<label>&nbsp;</label><br />
								<input type="hidden" name="report" value="1" />
								<input type="submit" class="btn btn-primary" value="<?php echo $lang_get_report; ?>" />
							</div>
						</div>
					</div>
					</form>

<?php
    if (isset($_GET['report'])) {
        if ($site_dateformat == 'd/m/Y') {
            $startArray = explode('/', $url_start);
            $endArray = explode('/', $url_end);

            $start_day = $startArray[0];
            $start_mon = $startArray[1];
            $start_yea = $startArray[2];

            $url_start = $start_yea.'-'.$start_mon.'-'.$start_day;

            $end_day = $endArray[0];
            $end_mon = $endArray[1];
            $end_yea = $endArray[2];

            $url_end = $end_yea.'-'.$end_mon.'-'.$end_day;
        }
        if ($site_dateformat == 'd.m.Y') {
            $startArray = explode('.', $url_start);
            $endArray = explode('.', $url_end);

            $start_day = $startArray[0];
            $start_mon = $startArray[1];
            $start_yea = $startArray[2];

            $url_start = $start_yea.'-'.$start_mon.'-'.$start_day;

            $end_day = $endArray[0];
            $end_mon = $endArray[1];
            $end_yea = $endArray[2];

            $url_end = $end_yea.'-'.$end_mon.'-'.$end_day;
        }
        if ($site_dateformat == 'd-m-Y') {
            $startArray = explode('-', $url_start);
            $endArray = explode('-', $url_end);

            $start_day = $startArray[0];
            $start_mon = $startArray[1];
            $start_yea = $startArray[2];

            $url_start = $start_yea.'-'.$start_mon.'-'.$start_day;

            $end_day = $endArray[0];
            $end_mon = $endArray[1];
            $end_yea = $endArray[2];

            $url_end = $end_yea.'-'.$end_mon.'-'.$end_day;
        }

        if ($site_dateformat == 'm/d/Y') {
            $startArray = explode('/', $url_start);
            $endArray = explode('/', $url_end);

            $start_day = $startArray[1];
            $start_mon = $startArray[0];
            $start_yea = $startArray[2];

            $url_start = $start_yea.'-'.$start_mon.'-'.$start_day;

            $end_day = $endArray[1];
            $end_mon = $endArray[0];
            $end_yea = $endArray[2];

            $url_end = $end_yea.'-'.$end_mon.'-'.$end_day;
        }
        if ($site_dateformat == 'm.d.Y') {
            $startArray = explode('.', $url_start);
            $endArray = explode('.', $url_end);

            $start_day = $startArray[1];
            $start_mon = $startArray[0];
            $start_yea = $startArray[2];

            $url_start = $start_yea.'-'.$start_mon.'-'.$start_day;

            $end_day = $endArray[1];
            $end_mon = $endArray[0];
            $end_yea = $endArray[2];

            $url_end = $end_yea.'-'.$end_mon.'-'.$end_day;
        }
        if ($site_dateformat == 'm-d-Y') {
            $startArray = explode('-', $url_start);
            $endArray = explode('-', $url_end);

            $start_day = $startArray[1];
            $start_mon = $startArray[0];
            $start_yea = $startArray[2];

            $url_start = $start_yea.'-'.$start_mon.'-'.$start_day;

            $end_day = $endArray[1];
            $end_mon = $endArray[0];
            $end_yea = $endArray[2];

            $url_end = $end_yea.'-'.$end_mon.'-'.$end_day;
        }

        if ($site_dateformat == 'Y.m.d') {
            $startArray = explode('.', $url_start);
            $endArray = explode('.', $url_end);

            $start_day = $startArray[2];
            $start_mon = $startArray[1];
            $start_yea = $startArray[0];

            $url_start = $start_yea.'-'.$start_mon.'-'.$start_day;

            $end_day = $endArray[2];
            $end_mon = $endArray[1];
            $end_yea = $endArray[0];

            $url_end = $end_yea.'-'.$end_mon.'-'.$end_day;
        }
        if ($site_dateformat == 'Y/m/d') {
            $startArray = explode('/', $url_start);
            $endArray = explode('/', $url_end);

            $start_day = $startArray[2];
            $start_mon = $startArray[1];
            $start_yea = $startArray[0];

            $url_start = $start_yea.'-'.$start_mon.'-'.$start_day;

            $end_day = $endArray[2];
            $end_mon = $endArray[1];
            $end_yea = $endArray[0];

            $url_end = $end_yea.'-'.$end_mon.'-'.$end_day;
        }
        if ($site_dateformat == 'Y-m-d') {
            $startArray = explode('-', $url_start);
            $endArray = explode('-', $url_end);

            $start_day = $startArray[2];
            $start_mon = $startArray[1];
            $start_yea = $startArray[0];

            $url_start = $start_yea.'-'.$start_mon.'-'.$start_day;

            $end_day = $endArray[2];
            $end_mon = $endArray[1];
            $end_yea = $endArray[0];

            $url_end = $end_yea.'-'.$end_mon.'-'.$end_day;
        } ?>
					<div class="row" style="margin-top: 10px;">
						<div class="col-md-12" style="text-align: right;">

						</div>
					</div>
					<div class="row" style="margin-top: 10px;">
						<div class="col-md-12">
							<div class="table-responsive">


<table id="example" class="display" cellspacing="0" width="100%">
    <thead>
        <tr>
            <th width="12%"><?php echo $lang_date; ?></th>
            <th width="5%"><?php echo $lang_sale_id; ?></th>
            <th width="12%"><?php echo "Customer"; ?></th>
            <th width="10%"><?php echo $lang_payment_methods; ?></th>
            <th width="10%"><?php echo "Sale Total"; ?> (<?php echo $site_currency; ?>)</th>
            <th width="10%"><?php echo "Discount"; ?> (<?php echo $site_currency; ?>)</th>
            <th width="10%"><?php echo "Sale Person"; ?> </th>
            <th width="5%"><?php echo $lang_print; ?></th>
        </tr>
    </thead>

    <tbody>
<?php
    	$total_sub_amt 		= 0;
		$total_paidAmount 		= 0;
        $total_disc_amt 		= 0;
        $total_grand_amt 	= 0;
		$total_Debit_amt	=	0;
		$total_cash_hand	= 0;

        $url_start 			= date('Y-m-d', strtotime($url_start));
        $url_end 			= date('Y-m-d', strtotime($url_end));

        $start_date 		= $url_start.' 00:00:00';
        $end_date 			= $url_end.' 23:59:59';

        $paid_sort 			= '';
        if($url_paid_by != '-') {

	        $ordPayResult 	= $this->db->query("SELECT order_id FROM order_payments WHERE created_datetime >= '$start_date' AND created_datetime <= '$end_date' AND payment_method_id = '$url_paid_by' ");
	        $ordPayData 	= $ordPayResult->result();
	        for($k = 0; $k < count($ordPayData); $k++) {
		        $ordPay_order_id 	= $ordPayData[$k]->order_id;

		        $paid_sort 			.= "id = '$ordPay_order_id' || ";

		        unset($ordPay_order_id);
	        }
	        unset($ordPayData);
	        unset($ordPayResult);

	        if(strlen($paid_sort) > 0) {
		        $paid_sort 			= trim($paid_sort, "|| ");
		        $paid_sort 			= "($paid_sort) AND ";
	        }
        }

        $outlet_sort 		= '';
        if ($url_outlet == '-') {
            $outlet_sort 	= ' AND outlet_id > 0 ';
        } else {
            $outlet_sort 	= " AND outlet_id = '$url_outlet' ";
        }

        $orderResult 		= $this->db->query("SELECT * FROM orders WHERE $paid_sort ordered_datetime >= '$start_date' AND ordered_datetime <= '$end_date' AND status = '1' $outlet_sort ORDER BY ordered_datetime DESC ");
        $orderRows 			= $orderResult->num_rows();

        if ($orderRows > 0) {
            $orderData = $orderResult->result();
            for ($od = 0; $od < count($orderData); ++$od) {
                $order_id = $orderData[$od]->id;
                $order_dtm = date("$site_dateformat H:i A", strtotime($orderData[$od]->ordered_datetime));
                $outlet_id = $orderData[$od]->outlet_id;
                $subTotal = $orderData[$od]->subtotal;
				$paidAmount = $orderData[$od]->paid_amt;
                $disc = $orderData[$od]->discount_total;
                $op_id = $orderData[$od]->created_user_id;
                $pay_method_id = $orderData[$od]->payment_method;
                $cheque_numb = $orderData[$od]->cheque_number;

                $cust_name = $orderData[$od]->customer_name;
                $cust_mobile = $orderData[$od]->customer_mobile;
                $payment_method_name = $orderData[$od]->payment_method_name;
                $order_type = $orderData[$od]->status;
				
				$total_sub_amt 		+= $subTotal;
                $total_disc_amt 	+= $disc;
                $total_grand_amt 	= $total_disc_amt + $total_sub_amt;
				$total_paidAmount	+= $paidAmount;
				$total_Debit_amt  = $total_paidAmount - $total_sub_amt;
				$total_cash_hand = $total_paidAmount;


                ?>
            <?php
            $staff_name = '';
            $staffData = $this->Constant_model->getDataOneColumn('users', 'id', $op_id);

            $staff_name = $staffData[0]->fullname;
            ?>
			<tr>
            	<td><?php echo $order_dtm; ?></td>
            	<td><?php echo $order_id; ?></td>
            	<td><?php echo $cust_name; ?><br/> <?php echo $cust_mobile; ?></td>
            	<td>
	            	<?php
		            	if($order_type == '1') {

			            	$payment_name_list		= "";
			            	$ordPayResult 			= $this->db->query("SELECT * FROM order_payments WHERE order_id = '$order_id' ORDER BY id ");
							$ordPayData 			= $ordPayResult->result();
							for($op = 0; $op < count($ordPayData); $op++) {
								$ordPay_name 		= $ordPayData[$op]->payment_method_name;
								$payment_name_list	.= $ordPay_name.", ";
								unset($ordPay_name);
							}
							unset($ordPayData);
							unset($ordPayResult);

							if(strlen($payment_name_list) > 0) {
								$payment_name_list 		= trim($payment_name_list, ", ");
								echo $payment_name_list;
							} else {
								echo "-";
							}

			            } else if ($order_type == "2") {
				            echo $payment_method_name;
				            if (!empty($cheque_numb)) {
								echo "<br />(Cheque No. : $cheque_numb)";
							}
			            }
		            ?>
	            </td>
            	<td><?php echo number_format($subTotal, 2, '.', ''); ?></td>
                <td><?php echo number_format($disc, 2, '.', ''); ?></td>

            	<td><?php echo $staff_name; ?></td>
            	<td>
				<?php
					if($order_type == '1') {
				?>
						<a onclick="openReceipt('<?=base_url()?>pos/view_invoice?id=<?php echo $order_id; ?>')" style="text-decoration: none; cursor: pointer;" title="Print Receipt">
							<i class="icono-list" style="color: #005b8a;"></i>
						</a>
				<?php
					}

					if($order_type == '2') {
				?>
						<a onclick="openReceipt('<?=base_url()?>returnorder/printReturn?return_id=<?php echo $order_id; ?>')" style="text-decoration: none; cursor: pointer;" title="Print Receipt">
							<i class="icono-list" style="color: #005b8a;"></i>
						</a>
				<?php
					}
				?>
            	</td>
	        </tr>
<?php

            	

                unset($order_id);
                unset($order_dtm);
                unset($outlet_id);
                unset($subTotal);
				unset($paidAmount);

                unset($op_id);
            }
            unset($orderData);
        }
        unset($orderResult); ?>
    </tbody>
</table>

							</div>
						</div>
					</div>
<?php

    }
?>


<!--Cost price total --->
<?php 
            $csum = 0;
            $camount =0;
            
            $orderResult 		= $this->db->query("SELECT * FROM order_items WHERE  created_datetime >= '$start_date' AND created_datetime <= '$end_date' AND status = '1'");
            $orderRows 			= $orderResult->num_rows();


                $orderData = $orderResult->result();
                for ($od = 0; $od < count($orderData); ++$od) {
                    $cqty = $orderData[$od]->qty;
                    $cprice = $orderData[$od]->cost;
                    $camount = $cqty * $cprice;


                    $csum += $camount;
                }
                

?>


<!--cash payment only --->
<?php 
            $cashTotal = 0;
            
            $orderResult 		= $this->db->query("SELECT * FROM order_payments WHERE  payment_method_id ='1' AND created_datetime >= '$start_date' AND created_datetime <= '$end_date' AND status = '1'");
            $orderRows 			= $orderResult->num_rows();


                $orderData = $orderResult->result();
                for ($od = 0; $od < count($orderData); ++$od) {
                    $OrderPayment = $orderData[$od]->payment_amount;

                    $cashTotal += $OrderPayment;
                }
                

?>
    <!--cash payment transfer method-->
<?php 
            $TransferTotal = 0;
            
            $orderResult 		= $this->db->query("SELECT * FROM order_payments WHERE payment_method_id ='8' AND created_datetime >= '$start_date' AND created_datetime <= '$end_date' AND status = '1'");
            $orderRows 			= $orderResult->num_rows();


                $orderData = $orderResult->result();
                for ($od = 0; $od < count($orderData); ++$od) {
                    $OrderPayment = $orderData[$od]->payment_amount;

                    $TransferTotal += $OrderPayment;
                }
                

?>

<!--cash payment POS Access Bank method--> 
<?php 
            $Pos_Access_bank_Total = 0;
            
            $orderResult 		= $this->db->query("SELECT * FROM order_payments WHERE payment_method_id ='9' AND created_datetime >= '$start_date' AND created_datetime <= '$end_date' AND status = '1'");
            $orderRows 			= $orderResult->num_rows();


                $orderData = $orderResult->result();
                for ($od = 0; $od < count($orderData); ++$od) {
                    $OrderPayment = $orderData[$od]->payment_amount;

                    $Pos_Access_bank_Total += $OrderPayment;
                }
                

?>

<!--cash payment POS First Bank method--->
<?php 
            $Pos_First_bank_Total = 0;
            
            $orderResult 		= $this->db->query("SELECT * FROM order_payments WHERE payment_method_id ='10' AND created_datetime >= '$start_date' AND created_datetime <= '$end_date' AND status = '1'");
            $orderRows 			= $orderResult->num_rows();


                $orderData = $orderResult->result();
                for ($od = 0; $od < count($orderData); ++$od) {
                    $OrderPayment = $orderData[$od]->payment_amount;

                    $Pos_First_bank_Total += $OrderPayment;
                }
                

?>

<!-- cash payment POS Jaiz Bank method-->
<?php 
            $Pos_Jaiz_bank_Total = 0;
            
            $orderResult 		= $this->db->query("SELECT * FROM order_payments WHERE payment_method_id ='11' AND created_datetime >= '$start_date' AND created_datetime <= '$end_date' AND status = '1'");
            $orderRows 			= $orderResult->num_rows();


                $orderData = $orderResult->result();
                for ($od = 0; $od < count($orderData); ++$od) {
                    $OrderPayment = $orderData[$od]->payment_amount;

                    $Pos_Jaiz_bank_Total += $OrderPayment;
                }
                

?>

<!-- Expenses total -->
<?php 
            $expenses_total = 0;
            $date_sort = " AND date >= '$start_date' AND date <= '$end_date' ";
            $orderResult 		= $this->db->query("SELECT * FROM expenses WHERE status = '1' $sort $date_sort ORDER BY date DESC ");
            $orderRows 			= $orderResult->num_rows();


                $orderData = $orderResult->result();
                for ($od = 0; $od < count($orderData); ++$od) {
                    $expense_amount = $orderData[$od]->amount;

                    $expenses_total += $expense_amount;
                }
                

?>


<?php

    if ($orderRows > 0) {
        ?>
		
<?php

    }
?>

<div class="row" style=";  font-size: 15px; letter-spacing: 0.5px;">
			<div class="col-md-2" style="font-weight: bold;"><?php echo "Cost Price Total"; ?> (NGN)</div>
			<div class="col-md-10" style="font-weight: bold;">: <?php echo number_format($csum, 2); ?></div>
		</div>
<div class="row" style=";  font-size: 15px; letter-spacing: 0.5px;">
			<div class="col-md-2" style="font-weight: bold;"><?php echo "Sales Price Total"; ?> (NGN)</div>
			<div class="col-md-10" style="font-weight: bold;">: <?php echo number_format($total_sub_amt, 2); ?></div>
		</div>

        <div class="row" style=";  font-size: 15px; letter-spacing: 0.5px;">
			<div class="col-md-2" style="font-weight: bold;"><?php echo "Sales Margin Total"; ?> (NGN)</div>
			<div class="col-md-10" style="font-weight: bold;">: <?php echo number_format($total_sub_amt - $csum, 2); ?></div>
		</div> 


		<div class="row" style=" font-size: 15px; letter-spacing: 0.5px;">
			<div class="col-md-2" style="font-weight: bold;"><?php echo "Expense Total"; ?> (NGN)</div>
			<div class="col-md-10" style="font-weight: bold;">: <?php echo number_format($expenses_total, 2); ?></div>
		</div>

        <div class="row" style=" font-size: 15px; letter-spacing: 0.5px;">
			<div class="col-md-2" style="font-weight: bold;"><?php echo "Discount Total"; ?> (NGN)</div>
			<div class="col-md-10" style="font-weight: bold;">: <?php echo number_format($total_disc_amt, 2); ?></div>
		</div>
        <div class="row" style=" font-size: 15px; letter-spacing: 0.5px;">
			<div class="col-md-2" style="font-weight: bold;"><?php echo "Profit Total"; ?> (NGN)</div>
			<div class="col-md-10" style="font-weight: bold;">: <?php echo number_format($total_sub_amt - $csum - $expenses_total - $total_disc_amt, 2); ?></div>
		</div>
		<hr width="100%" style="border: 2px solid black;">
		<div class="row" style=" font-size: 15px; letter-spacing: 0.5px;">
			<div class="col-md-2" style="font-weight: bold;"><?php echo "Cash Total"; ?> (NGN)</div>
			<div class="col-md-10" style="font-weight: bold;">: <?php echo number_format($cashTotal, 2); ?></div>
		</div>
        <div class="row" style=" font-size: 15px; letter-spacing: 0.5px;">
			<div class="col-md-2" style="font-weight: bold;"><?php echo "Mobile Transfer"; ?> (NGN)</div>
			<div class="col-md-10" style="font-weight: bold;">: <?php echo number_format($TransferTotal, 2); ?></div>
		</div>
        <div class="row" style=" font-size: 15px; letter-spacing: 0.5px;">
			<div class="col-md-2" style="font-weight: bold;"><?php echo "POS Access Bank"; ?> (NGN)</div>
			<div class="col-md-10" style="font-weight: bold;">: <?php echo number_format($Pos_Access_bank_Total, 2); ?></div>
		</div>
        <div class="row" style=" font-size: 15px; letter-spacing: 0.5px;">
			<div class="col-md-2" style="font-weight: bold;"><?php echo "POS First Bank"; ?> (NGN)</div>
			<div class="col-md-10" style="font-weight: bold;">: <?php echo number_format($Pos_First_bank_Total, 2); ?></div>
		</div>
        <div class="row" style=" font-size: 15px; letter-spacing: 0.5px;">
			<div class="col-md-2" style="font-weight: bold;"><?php echo "POS Jaiz Bank"; ?> (NGN)</div>
			<div class="col-md-10" style="font-weight: bold;">: <?php echo number_format($Pos_Jaiz_bank_Total, 2); ?></div>
		</div>

		<div class="row" style=" font-size: 15px; letter-spacing: 0.5px;">
			<div class="col-md-2" style="font-weight: bold;"><?php echo "Debit Sales Total"; ?> (NGN)</div>
			<div class="col-md-10" style="font-weight: bold;">: <?php echo number_format($total_Debit_amt, 2); ?></div>
		</div>
        <div class="row" style=" font-size: 15px; letter-spacing: 0.5px;">
			<div class="col-md-2" style="font-weight: bold;"><?php echo "Total Payment"; ?> (NGN)</div>
			<div class="col-md-10" style="font-weight: bold;">: <?php echo number_format($cashTotal + $TransferTotal + $Pos_Access_bank_Total + 
            
            $Pos_First_bank_Total + $Pos_Jaiz_bank_Total, 2); ?></div>
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