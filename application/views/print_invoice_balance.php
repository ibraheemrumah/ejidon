<?php
    $settingResult 				= $this->db->get_where('site_setting');
    $settingData 				= $settingResult->row();
    $setting_dateformat 		= $settingData->datetime_format;
    $setting_site_logo 			= $settingData->site_logo;

    $orderData 					= $this->Constant_model->getDataOneColumn('orders', 'id', $order_id);
    if (count($orderData) == 0) {
        $this->session->set_flashdata('alert_msg', array('success', 'Error', 'Something Wrong!'));
        redirect(base_url().'pos');
        die();
    }

    $ordered_dtm 				= date("$setting_dateformat H:i A", strtotime($orderData[0]->ordered_datetime));
    $cust_fullname 				= $orderData[0]->customer_name;
	$cust_id	 				= $orderData[0]->customer_id;
	
    $cust_mobile 				= $orderData[0]->customer_mobile;
    $outlet_id 					= $orderData[0]->outlet_id;
    $subTotal 					= $orderData[0]->subtotal;
    $dis_amt 					= $orderData[0]->discount_total;
    $tax_amt 					= $orderData[0]->tax;
    $grandTotal 				= $orderData[0]->grandtotal;
    $us_id 						= $orderData[0]->created_user_id;
    $pay_method_id 				= $orderData[0]->payment_method;
    $pay_method_name 			= $orderData[0]->payment_method_name;
    $paid_amt 					= $orderData[0]->paid_amt;
    $return_change 				= $orderData[0]->return_change;
    $cheque_numb 				= $orderData[0]->cheque_number;
    $dis_percentage 			= $orderData[0]->discount_percentage;

    $outlet_name 				= $orderData[0]->outlet_name;
    $outlet_address 			= $orderData[0]->outlet_address;
    $outlet_contact 			= $orderData[0]->outlet_contact;
    $card_numb 					= $orderData[0]->gift_card;

    $addi_card_numb 			= $orderData[0]->card_number;

    $receipt_header	 			= '';
	$receipt_footer 			= $orderData[0]->outlet_receipt_footer;
	$staff_name = '';
    $staffData = $this->Constant_model->getDataOneColumn('users', 'id', $us_id);

    $staff_name = $staffData[0]->fullname;
    
    //if ( ($pay_method_id == '6') || ($pay_method_id == '7') ) {
    //if (($pay_method_id == '6')) {
      //  $unpaid_amt = $paid_amt - $grandTotal;
   // }
   
   
    $unpaid_amt 		= 0;
    $total_paid_amt 	= 0;
    
    $orderPaymentResult	= $this->db->query("SELECT * FROM order_payments WHERE order_id = '$order_id' ");
    $orderPaymentData 	= $orderPaymentResult->result();
    for($opd = 0; $opd < count($orderPaymentData); $opd++) {
	    $total_paid_amt	+= $orderPaymentData[$opd]->payment_amount;
    }
    unset($orderPaymentData);
    unset($orderPaymentResult);
    
	
    $unpaid_amt 		= $total_paid_amt - $grandTotal;
	
	$all_total_subTotal_amt = 0;
    $total_taxTotal_amt = 0;
    $all_total_grandTotal_amt = 0;
	$totalUnpaid_amt = 0;
	$all_sumPaidTotal = 0;

    $historyData = $this->Constant_model->getDataOneColumnSortColumn('orders', 'customer_id', "$cust_id", 'id', 'DESC');

        for ($h = 0; $h < count($historyData); ++$h) {
            $sales_id = $historyData[$h]->id;
            $subTotal_all = $historyData[$h]->subtotal;
            $tax = $historyData[$h]->tax;
            $all_grandTotal = $historyData[$h]->grandtotal;
            $all_total_items = $historyData[$h]->total_items;
            $all_order_type = $historyData[$h]->status;
			$all_paidTotal = $historyData[$h]->paid_amt;
			
			
            $all_total_subTotal_amt += $subTotal_all;
            $total_taxTotal_amt += $tax;
            $all_total_grandTotal_amt += $all_grandTotal;
			$all_sumPaidTotal += $all_paidTotal;
		$totalUnpaid_amt = $all_total_grandTotal_amt - $all_sumPaidTotal;}
?>
<!doctype html>
<html>
	<head>
		<meta charset="utf-8" />
		<title>Sale No : <?php echo $order_id; ?></title>
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
		float:right; 
		text-align:right; 
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
    border-left: 1px solid #000;
    padding: 4px;
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
	.table, .totals {
    width: 100%;
    margin: 10px 0;
    
    margin: 0px;
    padding: 1px;
	}

	@media print {
		body { text-transform: uppercase; }
		#buttons { display: none; }
		#wrapper { width: 100%; margin: 0; font-size:9px; font-weight: bold; }
		#wrapper img { max-width:300px; width: 80%; }
		#bkpos_wrp{
			display: none;
		}
	}
</style>
</head>

<body>
<div id="wrapper">
	<table border="0" style="border-collapse: collapse;border-top: 1px solid #000;border-right: 1px solid #000;border-left: 1px solid #000; ">
	   <!-- <tr>
		    <td width="100%" align="center">
			    <center>
			    	<img src="<?=base_url()?>assets/img/logo/logo.png" style="width: 60px;" />
			    </center>
		    </td>
	    </tr>-->
	    <tr>
		    <td width="100%" style="border-bottom:1px solid black" align="center">
			    <h2 style="padding-top: 0px; font-size: 16px;"><strong><?php echo $outlet_name; ?></strong></h2>
		    </td>
	    </tr>
		<tr>
			<td width="100%">
				<span class="left" style="text-align: left;"><?php echo $lang_address; ?> : <?php echo $outlet_address; ?></span>	
				<span class="left" style="text-align: left;"><?php echo "Tel"; ?> : <?php echo $outlet_contact; ?></span> 
				<span class="left" style="text-align: left;"><?php echo $lang_sale_id; ?> : <?php echo $order_id; ?></span>
				<span class="left" style="text-align: left;"><?php echo $lang_date; ?> : <?php echo $ordered_dtm; ?></span>
				<span class="left" style="text-align: left;"><?php echo $lang_customer_name; ?>&nbsp; : <?php echo $cust_fullname; ?></span> 
				<span class="left" style="text-align: left;"><?php echo $lang_mobile; ?> : <?php if (empty($cust_mobile)) {
    echo '-';
} else {
    echo $cust_mobile;
} ?></span>
				<span class="left" style="text-align: left;"><?php echo "Sales Person"; ?> : <?php echo $staff_name; ?>
			</td>
		</tr>   
    </table>
    
	
	    
	<div style="clear:both;"></div>
    
	<table class="table" cellspacing="0"  border="0" style="border-collapse: collapse;border-right: 1px solid #000;border-left: 1px solid #000; border-bottom: 1px solid #000;"> 
		<thead> 
			<tr> 
				<th width="10%"><em>#</em></th> 
				<th width="35%" align="left"><?php echo $lang_products; ?></th>
				<th width="10%"><?php echo $lang_qty; ?></th>
				<th width="25%"><?php echo $lang_per_item; ?></th>
				<th width="20%" align="right" style="border-right: 1px solid black;"><?php echo $lang_total; ?></th> 
			</tr> 
		</thead> 
		<tbody> 
		<?php
            $total_item_amt = 0;
            $total_item_qty = 0;

            $orderItemResult = $this->db->query("SELECT * FROM order_items WHERE order_id = '$order_id' ORDER BY id ");
            $orderItemData = $orderItemResult->result();
            for ($i = 0; $i < count($orderItemData); ++$i) {
                $pcode = $orderItemData[$i]->product_code;
                $name = $orderItemData[$i]->product_name;
                $qty = $orderItemData[$i]->qty;
                $price = $orderItemData[$i]->price;

                $each_row_price = 0;
                $each_row_price = $qty * $price;

                $total_item_amt += $each_row_price; ?>
				<tr>
	            	<td style="text-align:center; width:30px;padding: 4px;border-left: 1px solid black;4px;border-bottom: 1px solid black;" valign="top"><?php echo $i + 1; ?></td>
	                <td style="text-align:left;width:130px; padding: 4px;border-left: 1px solid black;4px;border-bottom: 1px solid black;"><?php echo $name; ?></td>
	                <td style="text-align:center; width:50px;padding: 4px;border-left: 1px solid black;4px;border-bottom: 1px solid black;" valign="top"><?php echo $qty; ?></td>
	                <td style="text-align:center; width:50px;padding: 4px;border-left: 1px solid black;4px;border-bottom: 1px solid black;" valign="top"><?php echo number_format($price, 2); ?></td>
	                <td style="text-align:right; width:70px;padding: 4px;border-left: 1px solid black;border-right: 1px solid black;4px;border-bottom: 1px solid black;" valign="top"><?php echo number_format($each_row_price, 2); ?></td>
				</tr>	
		<?php
                $total_item_qty += $qty;

                unset($pcode);
                unset($name);
                unset($qty);
                unset($price);
            }
            unset($orderItemResult);
            unset($orderItemData);
        ?>
			 
    	</tbody> 
	</table> 
	
    
    <table class="totals" cellspacing="0" border="0" style="margin-bottom:5px;border-collapse: collapse;border-right: 1px solid #000;border-left: 1px solid #000; border-bottom: 1px solid #000;">
    	<tbody>
			<tr>
				<td style="text-align:left; padding-top: 5px;padding: 4px;"><?php echo $lang_total_items; ?></td>
				<td style="text-align:right; padding-right:1.5%; border-right: 1px solid #000;font-weight:bold;padding: 4px;"><?php echo $total_item_qty; ?></td>
				<td style="text-align:left; padding-left:1.5%;padding: 4px;"><?php echo $lang_total; ?></td>
				<td style="text-align:right;font-weight:bold;padding: 4px;"><?php echo number_format($total_item_amt, 2); ?></td>
			</tr>
    
			<?php
                if ($dis_amt > 0) {
                    ?>
			<tr>
				<td style="text-align:left;"></td>
				<td style="text-align:right; padding-right:1.5%; border-right: 1px solid #000;font-weight:bold;padding: 4px;"></td>
				<td style="text-align:left; padding-left:1.5%; padding-bottom: 5px;padding: 4px;"><?php echo $lang_discount; ?>&nbsp;<?php if (!empty($dis_percentage)) {
                        echo '('.$dis_percentage.')';
                    } ?></td>
				<td style="text-align:right;font-weight:bold;padding: 4px;">-<?php echo number_format($dis_amt, 2); ?></td>
			</tr>
			<?php
                }
            ?>
			<tr>
				<td style="text-align:left; padding-top: 5px;padding: 4px;">&nbsp;</td>
				<td style="text-align:right; padding-right:1.5%; border-right: 1px solid #000;font-weight:bold;padding: 4px;">&nbsp;</td>
				<td style="text-align:left; padding-left:1.5%;padding: 4px;"><?php echo $lang_sub_total; ?></td>
				<td style="text-align:right;font-weight:bold;padding: 4px;"><?php echo number_format($subTotal, 2); ?></td>
			</tr>
			<tr>
				<td style="text-align:left; padding-top: 5px;padding: 4px;">&nbsp;</td>
				<td style="text-align:right; padding-right:1.5%; border-right: 1px solid #000;font-weight:bold;padding: 4px;">&nbsp;</td>
				
			</tr>
			<tr>
				<td colspan="2" style="text-align:left; font-weight:bold; border-top:1px solid #000; padding-top: 5px; padding-bottom: 5px;padding: 4px;"><?php echo $lang_grand_total; ?></td>
				<td colspan="2" style="text-align:right; font-weight:bold; border-top:1px solid #000; padding-top: 5px; padding-bottom: 5px;padding: 4px;"><?php echo number_format($grandTotal, 2); ?></td>
    		</tr>
    		
			<tr>    
				<td colspan="2" style="text-align:left; font-weight:bold; padding-top: 5px; padding-bottom: 5px;padding: 4px;"><?php echo $lang_paid_amt; ?></td>
				<td colspan="2" style="text-align:right; font-weight:bold; padding-top: 5px; padding-bottom: 5px;padding: 4px;"><?php echo number_format($total_paid_amt, 2); ?></td>
			</tr>	
			<?php
				if ($return_change > 0) {
			?>
			<tr>
				<td colspan="2" style="text-align:left; font-weight:bold; padding-top: 5px; padding-bottom: 5px;"><?php echo $lang_return_change; ?></td>
				<td colspan="2" style="text-align:right; font-weight:bold; padding-top: 5px; padding-bottom: 5px;"><?php echo number_format($return_change, 2); ?></td>
			</tr>
			<?php
				}
			?>
			<?php
				if ($unpaid_amt < 0) {
			?>
			<tr>
				<td colspan="2" style="text-align:left; font-weight:bold; padding-top: 5px; padding-bottom: 5px;padding: 4px;"><?php echo $lang_unpaid_amount; ?></td>
				<td colspan="2" style="text-align:right; font-weight:bold; padding-top: 5px; padding-bottom: 5px;padding: 4px;"><?php echo number_format($unpaid_amt, 2); ?></td>
			</tr>
			<?php
				}
			?>
			
			<?php
				$ordPayResult 		= $this->db->query("SELECT * FROM order_payments WHERE order_id = '$order_id' ORDER BY id ");
				$ordPayData 		= $ordPayResult->result();
				for($op = 0; $op < count($ordPayData); $op++) {
					$ordPay_key 	= $ordPayData[$op]->payment_method_id;
					$ordPay_name 	= $ordPayData[$op]->payment_method_name;
					$ordPay_amt 	= $ordPayData[$op]->payment_amount;
					$ordPay_number 	= $ordPayData[$op]->number;
					$ordPay_date 	= date("$setting_dateformat", strtotime($ordPayData[$op]->created_datetime));
					
					$display_card_numb 		= "";
					if( ($ordPay_key == "3") || ($ordPay_key == "4") ) {
						$display_card_numb 	= "Card Number : $ordPay_number";
					} else if ($ordPay_key == "5") {
						$display_card_numb 	= "Cheque Number : $ordPay_number";
					} else if ($ordPay_key == "7") {
						$display_card_numb 	= "Gift Card Number : $ordPay_number";
					}
			?>
			<tr>
				<td colspan="3" style="text-align:left; border-top: 1px solid #000; padding-top: 5px; padding-bottom: 5px;padding: 4px;">
					<b><?php echo $lang_paid_by; ?> :</b> <?php echo $ordPay_name; ?> [<?php echo $ordPay_date; ?>]
					<?php
						if(strlen($display_card_numb) > 0) {
							echo "<br />[$display_card_numb]";
						}	
					?>
				</td>
				<td style="text-align:right; border-top: 1px solid #000; padding-top: 5px; padding-bottom: 5px;padding: 4px;">
					<?php echo number_format($ordPay_amt, 2); ?>
				</td>
				<tr>
									<?php 

					
					$data = array (
						'current_balance' => $totalUnpaid_amt


					);
					$this->db->where('id', $order_id);
					$this->db->update('orders',$data);
					

					
					$data = array (
						'current_balance' => $totalUnpaid_amt


					);
					$this->db->where('id', $cust_id);
					$this->db->update('customers',$data);
					
					?>
				<td colspan="3" style="text-align:left; border-top: 1px solid #000; padding-top: 5px; padding-bottom: 5px;padding: 4px;">
				<?php
                	 if ($totalUnpaid_amt > 0 ) {
                        echo "Out standing Balance";
                        } else {
                      echo "Account Balance";
                                    } ?>	
				</td>
				
				
				<td style="text-align:right; border-top: 1px solid #000; padding-top: 5px; padding-bottom: 5px;padding: 4px;">
									<?php
                	 if ($totalUnpaid_amt < 0 ) {
                        echo "0.0";
                        } else {
                      echo number_format($totalUnpaid_amt, 2);
                                    } ?>	
				

				</td>
			</tr>
			<?php
					unset($ordPay_date);
					unset($ordPay_number);
					unset($ordPay_amt);
					unset($ordPay_name);
					unset($ordPay_key);
				}
				unset($ordPayData);
				unset($ordPayResult);
			?>
    </tbody>
    </table>
    
    
		<div style="border-top:1px solid #000; padding-top:0px;">
    	<?php
            echo $receipt_footer;
        ?>    
    </div>
	<div style="border-top:1px solid #000; padding-top:10px;">
    	
		Poweredby Mu'ammil Web Services 08066620283	 
          
    </div>
<!--
        <div id="buttons" style="padding-top:10px; text-transform:uppercase;">
    <span class="left"><a href="#" style="width:90%; display:block; font-size:12px; text-decoration: none; text-align:center; color:#000; background-color:#4FA950; border:2px solid #4FA950; padding: 10px 1px; font-weight:bold;" id="email">Email</a></span>
    <span class="right"><button type="button" onClick="window.print();return false;" style="width:100%; cursor:pointer; font-size:12px; background-color:#FFA93C; color:#000; text-align: center; border:1px solid #FFA93C; padding: 10px 1px; font-weight:bold;">Print</button></span>
    <div style="clear:both;"></div>
-->
   
    <div id="bkpos_wrp">
    	<a href="<?=base_url()?>pos" style="width:100%; display:block; font-size:12px; text-decoration: none; text-align:center; color:#FFF; background-color:#005b8a; border:0px solid #007FFF; padding: 10px 1px; margin: 5px auto 10px auto; font-weight:bold;"><?php echo $lang_back_to_pos; ?></a>
    </div>
    
    <div id="bkpos_wrp">
    	<button type="button" onClick="window.print();return false;" style="width:101%; cursor:pointer; font-size:12px; background-color:#FFA93C; color:#000; text-align: center; border:1px solid #FFA93C; padding: 10px 0px; font-weight:bold;"><?php echo $lang_print_small_receipt; ?></button>
    </div>
    
	<div id="bkpos_wrp" style="margin-top: 8px;">
    	<span class="left"><a href="#" style="width:100%; display:block; font-size:12px; text-decoration: none; text-align:center; color:#000; background-color:#4FA950; border:2px solid #4FA950; padding: 10px 0px; font-weight:bold;" id="email"><?php echo $lang_email; ?></a></span>
    </div>
    
    <div id="bkpos_wrp">
    	<span class="left">
    		<a href="<?=base_url()?>pos/view_invoice_a4?id=<?php echo $order_id; ?>" style="width:100%; display:block; font-size:12px; text-decoration: none; text-align:center; color:#000; background-color:#4FA950; border:2px solid #4FA950; padding: 10px 0px; font-weight:bold; margin-top: 6px;">
	    		<?php echo $lang_print_a4; ?>
	    	</a>
	    </span>
    </div>
    
    <input type="hidden" id="id" value="<?php echo $order_id; ?>" />
    
</div>

<script src="https://code.jquery.com/jquery-1.10.2.js"></script>
<script type="text/javascript">
	$(document).ready(function(){ 
		$('#email').click( function(){
			var email 	= prompt("Please enter email address","test@mail.com");	
			var id 		= document.getElementById("id").value;
			
			$.ajax({
				type: "POST",
				url: "<?=base_url()?>pos/send_invoice",
				data: { email: email, id: id}
			}).done(function( msg ) {
			      alert( "Successfully Sent Receipt to "+email);
			});
			
		});
	});

	$(window).load(function() { window.print(); });
</script>




</body>
</html>
