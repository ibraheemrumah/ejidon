<?php
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
    $outlet_address = $returnData[0]->outlet_address;
    $outlet_contact = $returnData[0]->outlet_contact;
    $receipt_footer = $returnData[0]->outlet_receipt_footer;

    $pay_name = $returnData[0]->payment_method_name;

    $staff_name = '';
    $staffData = $this->Constant_model->getDataOneColumn('users', 'id', $ret_staff_id);
    if (count($staffData) == 1) {
        $staff_name = $staffData[0]->fullname;
    }
?>
<!doctype html>
<html>
	<head>
		<meta charset="utf-8" />
		<title>Expense No : <?php echo $return_id; ?></title>
		<script src="<?=base_url()?>assets/js/jquery-1.7.2.min.js"></script>
		
<style type="text/css" media="all">
	body { 
		max-width: 300px; 
		margin:0 auto; 
		text-align:center; 
		color:#000; 
		font-family: Arial, Helvetica, sans-serif; 
		font-size:12px; 
	}
	#wrapper { 
		min-width: 250px; 
		margin: 0px auto; 
	}
	#wrapper img { 
		max-width: 300px; 
		width: auto; 
	}

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
		padding:0; 
	}
	.totals td { 
		width: 24%; 
		padding:0; 
	}
	.table td:nth-child(2) { 
		overflow:hidden; 
	}

	@media print {
		body { text-transform: uppercase; }
		#buttons { display: none; }
		#wrapper { width: 100%; margin: 0; font-size:9px; }
		#wrapper img { max-width:300px; width: 80%; }
		#bkpos_wrp{
			display: none;
		}
	}
</style>
</head>

<body>
<div id="wrapper">
    <h2 style="padding-top: 0px; padding-bottom: 5px; font-size: 22px;"><strong><?php echo $outlet_name; ?></strong></h2>
	<span style="padding-top: 0px; padding-bottom: 5px; font-size: 15px;"><?php echo "EXPENSE RECEIPT" ?> </span>
	<span class="left"><?php echo $lang_address; ?> : <?php echo $outlet_address; ?></span>	
	<span class="left"><?php echo $lang_telephone; ?> : <?php echo $outlet_contact; ?></span> 
	<span class="left"><?php echo $lang_date; ?> : <?php echo $ret_date_time; ?><?php echo "  "; ?></span> 
	<span class="left"><?php echo "Produced by"; ?> : <?php echo $staff_name; ?></span> 
	<span class="left">Expanse Id: <?php echo $return_id; ?></span>
	    
	<div style="clear:both;"></div>
    
	<table class="table" cellspacing="0"  border="0"> 
		<thead> 
			<tr> 
			
				<th width="70%" align="left">Expanse Details</th> 
				<th width="30%" align="right"></th>
				
			</tr> 
		</thead> 
		<tbody> 
		<?php
                if (!empty($ret_remark)) {
                    ?>
			<tr>
				
				<td width="100%" align="left" style="overflow:hidden; max-width: 130px; text-overflow:ellipsis;"><?php echo nl2br(  $ret_remark) ; ?></td>
				
    		</tr>
			<?php

                }
            ?>
			<thead> 
				<th width="20%" align="right">Total Amount: </th> 
				<th width="40%" align="right"><?php echo number_format($ret_subTotal, 2); ?></th>
				
			</tr> 
		</thead> 
		
		
		
		
		
			 
    	</tbody> 
	</table> 
	
   
    <div id="bkpos_wrp">
    	<a href="<?=base_url()?>expenseorder/confirmation?return_id=<?php echo $return_id; ?>" style="width:100%; display:block; font-size:12px; text-decoration: none; text-align:center; color:#FFF; background-color:#005b8a; border:0px solid #007FFF; padding: 10px 1px; margin: 5px auto 10px auto; font-weight:bold;"><?php echo $lang_back; ?></a>
    </div>
    
    
</div>

<script src="https://code.jquery.com/jquery-1.10.2.js"></script>
<script type="text/javascript">
	$(window).load(function() { window.print(); });
</script>




</body>
</html>
