<?php
    $settingResult = $this->db->get_where('site_setting');
    $settingData = $settingResult->row();
    $setting_dateformat = $settingData->datetime_format;
	$setting_site_name = $settingData->site_name;

    $poDtaData = $this->Constant_model->getDataOneColumn('purchase_order', 'id', $id);

    $po_numb = $poDtaData[0]->po_number;
    $po_supplier_id = $poDtaData[0]->supplier_id;
    $po_outlet_id = $poDtaData[0]->outlet_id;
    $po_date = date("$setting_dateformat", strtotime($poDtaData[0]->po_date));
    $po_attachment = $poDtaData[0]->attachment_file;
    $po_note = $poDtaData[0]->note;
    $po_status = $poDtaData[0]->status;

    //$supplierNameData 		= $this->Constant_model->getDataOneColumn('suppliers', 'id', $po_supplier_id);
    $supplier_name = $poDtaData[0]->supplier_name;
    $supplier_address = $poDtaData[0]->supplier_address;
    $supplier_email = $poDtaData[0]->supplier_email;
    $supplier_tel = $poDtaData[0]->supplier_tel;
    $supplier_fax = $poDtaData[0]->supplier_fax;

    //$outletNameData 		= $this->Constant_model->getDataOneColumn('outlets', 'id', $po_outlet_id);
    $outlet_name = $poDtaData[0]->outlet_name;
    $outlet_address = $poDtaData[0]->outlet_address;
	$outlet_contact = $poDtaData[0]->outlet_contact;
	

	
    $poDtaData = $this->Constant_model->getDataOneColumn('purchase_order', 'id', $id);

    if (count($poDtaData) == 0) {
        redirect(base_url());
    }

    $po_numb = $poDtaData[0]->po_number;
    $po_supplier_id = $poDtaData[0]->supplier_id;
    $po_outlet_id = $poDtaData[0]->outlet_id;
    $po_date = $poDtaData[0]->po_date;
    $po_attachment = $poDtaData[0]->attachment_file;
    $po_note = $poDtaData[0]->note;
    $po_status = $poDtaData[0]->status;

    $po_outlet_name = $poDtaData[0]->outlet_name;
    $po_supplier_name = $poDtaData[0]->supplier_name;
	
	$user_id = $poDtaData[0]->received_user_id;
	
    $discount = $poDtaData[0]->discount_amount;
    $subTotal = $poDtaData[0]->subTotal;
    $taxTotal = $poDtaData[0]->tax;
    $grandTotal = $poDtaData[0]->grandTotal;

?>
<?php 

$userData = $this->Constant_model->getDataOneColumn('users', 'id', $user_id);

$received_name = $userData[0]->fullname;

?>

<!doctype html>
<html>
	<head>
		<meta charset="utf-8" />
		<title>Print Purchase Order</title>
		<script src="<?=base_url()?>assets/js/jquery-1.7.2.min.js"></script>
		
<style type="text/css" media="all">
	body { 
		max-width: 950px; 
		margin:0 auto; 
		text-align:center; 
		color:#000; 
		font-family: Arial, Helvetica, sans-serif; 
		font-size:12px; 
	}
	#wrapper { 
		min-width: 950px; 
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

					<!-- Product List // START -->
					
					<script type="text/javascript">
	function getValue(){
		var total_count 	= document.getElementById("total_row_count").value;
		var dbTax 			= document.getElementById("dbtax").value;
		var discount 		= document.getElementById("discount").value;
		
		if(discount.length == 0){
			discount 		= 0;
		}
		discount 			= parseFloat(discount);
		
		var total_amt 		= 0;
		var total_p_amt 	= 0;
		for(var i = 1; i < total_count; i++){
			var qty 		= document.getElementById("qty_"+i).value;
			var cost 		= document.getElementById("cost_"+i).value;
			var price 		= document.getElementById("price_"+i).value;
			
			if(qty.length == 0){
				qty 		= 0;
			}
			if(price.length == 0){
				cost 		= 0;
			}
			
			qty 			= parseInt(qty);
			cost 			= parseFloat(cost);
			price 			= parseFloat(price);
			
			total_amt 		+= (qty * cost);
			total_p_amt		+= (qty * price);
		}
		
		total_amt 			= total_amt - discount;
		
		var subTotal 		= 0;
		var taxTotal 		= 0;
		var grandTotal 		= 0;
		var grandPTotal 	= 0;
		var subPtotal		= 0;
		
		var taxTotal 		= total_amt * (dbTax/100);
		
		subTotal 			= total_amt - taxTotal;
		subPtotal			= total_p_amt - taxTotal;
		grandTotal 			= subTotal + taxTotal;
		grandPTotal			= total_p_amt + taxTotal;
		
		document.getElementById("subTotal").value 		= subTotal.toFixed(2);
		document.getElementById("subPtotal").value 		= subPtotal.toFixed(2);
		document.getElementById("tax").value 			= taxTotal.toFixed(2);
		document.getElementById("grandTotal").value 	= grandTotal.toFixed(2);
		document.getElementById("grandPTotal").value 	= grandPTotal.toFixed(2);
	}
	function calculateDiscount(ele){
		var total_count 	= document.getElementById("total_row_count").value;
		var dbTax 			= document.getElementById("dbtax").value;
		var discount 		= document.getElementById("discount").value;
		
		if(discount.length == 0){
			discount 		= 0;
		}
		discount 			= parseFloat(discount);
		
		var total_amt 		= 0;
		for(var i = 1; i < total_count; i++){
			var qty 		= document.getElementById("qty_"+i).value;
			var cost 		= document.getElementById("cost_"+i).value;
			var price 		= document.getElementById("price_"+i).value;
			
			if(qty.length == 0){
				qty 		= 0;
			}
			if(cost.length == 0){
				cost 		= 0;
			}
			if(price.length == 0){
				price 		= 0;
			}
			
			qty 			= parseInt(qty);
			cost 			= parseFloat(cost);
			price 			= parseFloat(price);
			
			
			total_amt 		+= (qty * cost);
			total_p_amt 	+= (qty * price);
		}
		
		total_amt 			= total_amt - discount;
		
		var subTotal 		= 0;
		var salesTotal 		= 0;
		var taxTotal 		= 0;
		var grandTotal 		= 0;
		
		var taxTotal 		= total_amt * (dbTax/100);
		
		salesTotal			= total_p_amt;
		subTotal 			= total_amt - taxTotal;
		grandTotal 			= subTotal + taxTotal;
		
		document.getElementById("salesTotal").value 	= salesTotal.toFixed(2);
		document.getElementById("subTotal").value 		= subTotal.toFixed(2);
		document.getElementById("tax").value 			= taxTotal.toFixed(2);
		document.getElementById("grandTotal").value 	= grandTotal.toFixed(2);
	}
</script>

</head>

<body>
<div id="wrapper">
    
	<table border="0" style="border-collapse: collapse; font-family: arial; font-size: 11px;" width="100%" height="auto">
		<tr>
			<td width="100%" height="auto" align="center">
			<h1 class="page-header "><?php echo $setting_site_name; ?></h1>
			<h3 class="page-header"><?php echo "Purchase Order Received"; ?></h3>
			</td>
		</tr>
	</table>
	<table border="0" style="border-collapse: collapse; font-family: arial; font-size: 13px; margin-top: 10px; border-bottom: 1px solid #656563; padding-bottom: 10px;" width="100%" height="auto">
		<tr>
			<td width="50%" height="auto" valign="top">
				<table border="0" style="border-collapse: collapse;" width="100%" height="auto">
					<tr>
						<td width="30%" style="font-size: 15px;" align="left"><?php echo $lang_suppliers; ?></td>
						<td width="70%" style="font-size: 15px;" align="left">: <?php echo $supplier_name; ?></td>
					</tr>
					<tr>
						<td width="30%" height="20px" align="left"><?php echo $lang_address; ?></td>
						<td width="70%" align="left">: <?php echo $supplier_address; ?></td>
					</tr>
					<tr>
						<td width="30%" height="20px" align="left"><?php echo $lang_email; ?></td>
						<td width="70%" align="left">: <?php echo $supplier_email; ?></td>
					</tr>
					<tr>
						<td width="30%" height="20px" align="left"><?php echo $lang_telephone; ?></td>
						<td width="70%" align="left">: <?php echo $supplier_tel; ?></td>
					</tr>
					<tr>
						<td width="30%" height="20px" align="left"><?php echo $lang_fax; ?></td>
						<td width="70%" align="left">: <?php echo $supplier_fax; ?></td>
					</tr>
				</table>
			</td>
			<td width="50%" height="auto" align="right" valign="top">
				<table border="0" style="border-collapse: collapse;" width="100%" height="auto">
					<tr>
						<td width="60%" height="20px" align="right" style="font-size: 15px; color: #005b8a;"><?php echo $lang_purchase_order_number; ?>&nbsp;&nbsp;</td>
						<td width="40%" style="font-size: 15px; color: #005b8a;">: &nbsp;<?php echo $po_numb; ?></td>
					</tr>
					<tr>
						<td width="60%" height="20px" align="right" style="font-size: 15px; color: #005b8a;"><?php echo $lang_created_date; ?>&nbsp;&nbsp;</td>
						<td width="40%" style="font-size: 15px; color: #005b8a;">: &nbsp;<?php echo $po_date; ?></td>
					</tr>
				</table>
			</td>
		</tr>
	</table>
	<table border="0" style="border-collapse: collapse; font-family: arial; font-size: 11px; margin-top: 0px;" width="100%" height="auto">
		<tr>
			<td width="50%" height="auto" align="left">
				<h1 style="font-size: 15px; color: #005b8a;"><?php echo $lang_ship_to; ?></h1>
			</td>
		</tr>
	</table>
	<table border="0" style="border-collapse: collapse; font-family: arial; font-size: 13px; margin-top: 0px;" width="100%" height="auto">
		<tr>
			<td width="50%" height="auto" valign="top">
				<table border="0" style="border-collapse: collapse;" width="100%" height="auto">
					<tr>
						<td width="40%" height="20px" align="left"><?php echo $lang_outlets; ?></td>
						<td width="60%" align="left">: <?php echo $outlet_name; ?></td>
					</tr>
					<tr>
						<td width="40%" height="20px" align="left" valign="top"><?php echo $lang_address; ?></td>
						<td width="60%" align="left">: <?php echo $outlet_address; ?></td>
					</tr>
					<tr>
						<td width="40%" height="20px" align="left"><?php echo $lang_telephone; ?></td>
						<td width="60%" align="left">: <?php echo $outlet_contact; ?></td>
					</tr>
				</table>
			</td>
			<td width="50%" height="auto" align="right" valign="top">&nbsp;</td>
		</tr>
	</table>
    <table class="table">
		<thead>
			<tr>
		    	<th width="15%" style="background-color: #686868; color: #FFF;"><?php echo $lang_product_code; ?></th>
		    	<th width="15%" style="background-color: #686868; color: #FFF;"><?php echo $lang_product_name; ?></th>
		    	<th width="15%" style="background-color: #686868; color: #FFF;"><?php echo $lang_ordered_quantity; ?></th>
		    	<th width="15%" style="background-color: #686868; color: #FFF;"><?php echo $lang_received_quantity; ?></th>
		    	<th width="15%" style="background-color: #686868; color: #FFF;"><?php echo $lang_each_cost; ?> (<?php echo $currency; ?>)</th>
				<th width="15%" style="background-color: #686868; color: #FFF;"><?php echo "Each Price"; ?> (<?php echo $currency; ?>)</th>
			</tr>
		</thead>
		<?php
            $jj = 1;
			$pvalue = 0;
			$tpvalue = 0;
			
			
            $poItemData = $this->Constant_model->getDataOneColumnSortColumn('purchase_order_items', 'po_id', $id, 'id', 'ASC');
            for ($pi = 0; $pi < count($poItemData); ++$pi) {
                $po_item_id = $poItemData[$pi]->id;
                $po_item_pcode = $poItemData[$pi]->product_code;
                $po_item_qty = $poItemData[$pi]->ordered_qty;
                $po_rec_qty = $poItemData[$pi]->received_qty;
                $po_rec_cost = $poItemData[$pi]->cost;
				$po_rec_price = $poItemData[$pi]->price;
				$pvalue = $po_rec_qty * $po_rec_price;
				$tpvalue += $pvalue;
				
                $poNameResult = $this->db->query("SELECT * FROM products WHERE code = '$po_item_pcode' ");
                $poNameData = $poNameResult->result();

                $po_name = $poNameData[0]->name; ?>
				<tr>
					<td><?php echo $po_item_pcode; ?></td>
					<td><?php echo $po_name; ?></td>
					<td>
					<?php echo $po_item_qty; ?>
                    
                
					</td>
					<td>
					<?php
                        if ($po_rec_qty != 0) {
                            echo $po_rec_qty;
                        } else {
                            ?>
						<input type="text" id="qty_<?php echo $jj; ?>" name="receiveQty_<?php echo $po_item_id; ?>" class="form-control" style="width: 80%;" onkeyup="getValue()" />
					<?php

                        } ?>
					</td>
					
					<td>
					<?php
                        if ($po_rec_qty != 0) {
                            echo number_format($po_rec_cost, 2, '.', '');
                        } else {
                            ?>
						<input type="text" id="cost_<?php echo $jj; ?>" name="receiveCost_<?php echo $po_item_id; ?>" class="form-control" style="width: 80%;" onkeyup="getValue()" />
					<?php

                        } ?>
					</td>
					<td>
					<?php
                        if ($po_rec_price != 0) {
                            echo number_format($po_rec_price, 2, '.', '');
                        } else {
                            ?>
						<input type="text" id="price_<?php echo $jj; ?>" name="receivePrice_<?php echo $po_item_id; ?>" class="form-control" style="width: 80%;" onkeyup="getValue()" />
					<?php

                        } ?>
					</td>
				</tr>
		<?php
                ++$jj;
            }
        ?>
        		<tr>
	        		<td style="vertical-align: middle; text-align: right; border-top: 1px solid #000;">
		        		<b><?php echo $lang_discount_amount; ?> (<?php echo $currency; ?>) :</b>
	        		</td>
	        		<td style="border-top: 1px solid #000; vertical-align: middle;">
		        		<?php
                            if ($po_status != '3') {
                                ?>
		        		<input type="text" name="discount" id="discount" class="form-control" onkeyup="calculateDiscount(this.value)" />
		        		<?php

                            } else {
                                echo number_format($discount, 2, '.', '');
                            }
                        ?>
	        		</td>
	        		<td colspan="2" align="right" valign="middle" style="vertical-align : middle; border-top: 1px solid #000;"><b><?php echo $lang_total; ?> (<?php echo $currency; ?>) : </b></td>
	        		<td style="border-top: 1px solid #000;">
		        		<?php
                            if ($po_status != '3') {
                                ?>
		        		<input type="text" name="subTotal" id="subTotal" class="form-control" required readonly style="width: 80%;" />
		        		<?php

                            } else {
                                echo number_format($subTotal, 2);
                            }
                        ?>
	        		</td>
					<td style="border-top: 1px solid #000;">
		        		<?php
                            if ($po_status != '3') {
                                ?>
		        		<input type="text" name="subPtotal" id="subPtotal" class="form-control" required readonly style="width: 80%;" />
		        		<?php

                            } else {
                                echo number_format($tpvalue, 2);
                            }
                        ?>
	        		</td>
        		</tr>
        		<tr>
	        		<td colspan="4" align="right" valign="middle" style="vertical-align : middle;"><b><?php echo $lang_tax; ?> (<?php echo $tax; ?>%) (<?php echo $currency; ?>) :</b></td>
	        		<td style="vertical-align: middle;">
		        		<?php
                            if ($po_status != '3') {
                                ?>
		        		
		        		<?php

                            } else {
                                echo number_format($taxTotal, 2);
                            }
                        ?>
	        		</td>
        		</tr>
				
        		<tr>
	        		<td colspan="4" align="right" valign="middle" style="vertical-align : middle;"><b><?php echo "Gross Margin"; ?> (<?php echo $currency; ?>):</b></td>
	        		<td style="
    font-size: medium;
    font-weight: 600;
">
		        		<?php
                            if ($po_status != '3') {
                                ?>
		        		<input type="text" name="diff" id="diff" class="form-control" required readonly style="width: 80%;" />
		        		<?php
								
                            } else {
								$diff = $tpvalue - $grandTotal;
                                echo number_format($diff, 2);
                            }
                        ?>
	        		</td>
        		</tr>
        		<input type="hidden" id="total_row_count" value="<?php echo $jj; ?>" />
        		<input type="hidden" id="dbtax" name="dbtax" value="<?php echo $tax; ?>" />
				<tr>
					<td colspan="5" align="center">
					<?php
                        if ($po_status != '3') {
                            ?>
						<input type="hidden" name="id" value="<?php echo $id; ?>" />
						<input type="hidden" name="outlet_id" value="<?php echo $po_outlet_id; ?>" />
						<button class="btn btn-primary" style="font-size: 15px; padding: 15px 40px;"><?php echo $lang_receive; ?></button>
					<?php

                        }
                    ?>
					</td>
				</tr>
	</table>
    
    <table border="0" style="border-collapse: collapse; font-family: arial; font-size: 13px; margin-top: 30px;" width="100%" height="auto">
		<tr>
			<td width="50%" height="auto" align="left" valign="top">
			
				<table border="0" style="border-collapse: collapse;" width="100%" height="auto">
					<tr>
						<td width="20%" valign="top" align="left"><b><?php echo "Received by:"; ?></b> :</td>
						<td width="80%" align="left"><?php echo $received_name; ?></td>
					</tr>
				</table>
			
			</td>
			<td width="50%" height="auto" align="right" valign="top">
				
				<table border="0" style="border-collapse: collapse;" width="100%" height="auto">
					<tr>
						<td width="40%" align="right"><b><?php echo $lang_authorized_by; ?></b></td>
						<td width="60%" style="border-bottom: 1px solid #656563"></td>
					</tr>
					<tr>
						<td colspan="2" height="30px"></td>
					</tr>
					<tr>
						<td width="40%" align="right"><b><?php echo $lang_signature; ?></b></td>
						<td width="60%" style="border-bottom: 1px solid #656563"></td>
					</tr>
				</table>
				
			</td>
		</tr>
	</table>
</div>

<script src="https://code.jquery.com/jquery-1.10.2.js"></script>
<script type="text/javascript">
	$(window).load(function() { window.print(); });
</script>
</body>

</html>
