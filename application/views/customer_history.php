<?php
    require_once 'includes/header.php';

    $custDtaData = $this->Constant_model->getDataOneColumn('customers', 'id', $cust_id);

    if (count($custDtaData) == 0) {
        redirect(base_url());
    }

    $fullname = $custDtaData[0]->fullname;
    $email = $custDtaData[0]->email;
    $mobile = $custDtaData[0]->mobile;
	
	$all_total_subTotal_amt = 0;
    $total_taxTotal_amt = 0;
    $all_total_grandTotal_amt = 0;
	$totalUnpaid_amt = 0;
	$sumPaidTotal = 0;
	$upaid_amount =0;
	$sumpaid_noreturn =0;

    $historyData = $this->Constant_model->getDataOneColumnSortColumn('orders', 'customer_id', "$cust_id", 'id', 'DESC');

        for ($h = 0; $h < count($historyData); ++$h) {
            $sales_id = $historyData[$h]->id;
            $subTotal_all = $historyData[$h]->subtotal;
            $tax = $historyData[$h]->tax;
            $grandTotal = $historyData[$h]->grandtotal;
            $total_items = $historyData[$h]->total_items;
            $order_type = $historyData[$h]->status;
			$return_change = $historyData[$h]->return_change;
			$paidTotal = $historyData[$h]->paid_amt;
			$grandtotal_noreturn = $grandTotal -$return_change;
			
			
            $return_sum +=$return_change;
			$all_total_subTotal_amt += $subTotal_all;
            $total_taxTotal_amt += $tax;
            $all_total_grandTotal_amt += $grandtotal_noreturn;
			$sumPaidTotal += $paidTotal;
			
		$totalUnpaid_amt = $all_total_grandTotal_amt - $sumPaidTotal;
		$sumpaid_noreturn = $sumPaidTotal -  $return_sum;
		;}
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
	<div class="row">
		<div class="col-lg-12 text-center">
			
		<h1 class="page-header "><?php echo $setting_site_name; ?></h1>
			<h3 class="page-header"><?php echo "$lang_view_history_customer"; ?> : <?php echo $fullname; ?></h3>
		</div>
	</div><!--/.row-->
	
	
	<div class="row">
		<div class="col-md-12">
			
			<div class="panel panel-default">
					
					<div class="row">
					
						<div class="col-md-12 balance" style="text-align: right;">
							<td style="text-align:right; border-top: 1px solid #000; padding-top: 5px; padding-bottom: 5px;">
					
					<b><?php echo "Out-Standing Balance :"; ?> </b><br>
					<b><?php echo number_format($totalUnpaid_amt, 2); ?></b><br>
					
				</td>
						</div>
						<br><br>
					</div>
					<div class="col-md-12 view-btn" style="text-align: right;">
					<?php
					if ($user_role < 5) {
                            ?>

					<a href="<?=base_url()?>customers/payment_history?cust_id=<?php echo $cust_id; ?>" style="text-decoration: none; margin-left: 10px;">
									<button class="btn btn-primary" style="padding: 4px 12px;">&nbsp;&nbsp;<?php echo "View Payment"; ?>&nbsp;&nbsp;</button>
					</a>
					<a href="<?=base_url()?>customers/debit_history?cust_id=<?php echo $cust_id; ?>" style="text-decoration: none; margin-left: 10px;">
									<button class="btn btn-primary" style="padding: 4px 12px;">&nbsp;&nbsp;<?php echo "View Debit"; ?>&nbsp;&nbsp;</button>
					</a>
					<?php

                        }
                    ?>

					
					</div>
					
					
					
							
					<table id="example" class="display" cellspacing="0" width="80%">
								    <thead>
								    	<tr>
									    	<th ><?php echo $lang_sale_id; ?></th>
									    	<th ><?php echo $lang_type; ?></th>
									    	<th><?php echo $lang_date_time; ?></th>
									    	<th><?php echo $lang_products; ?></th>
									    	<th><?php echo $lang_quantity; ?></th>
									    	<th><?php echo $lang_total_quantity; ?></th>
										    <th><?php echo $lang_sub_total; ?> (<?php echo $currency; ?>)</th>
										    <th><?php echo "Paid Amount"; ?> (<?php echo $currency; ?>)</th>
										    <th><?php echo "Total Unpaid"; ?> (<?php echo $currency; ?>)</th>
										    
										</tr>
								    </thead>
									<tbody>
							
<?php
    $total_subTotal_amt = 0;
    $total_taxTotal_amt = 0;
    $total_grandTotal_amt = 0;
	$totalUnpaid_amt = 0;
	$sumPaidTotal = 0;
	$upaid_amount =0;

    $historyData = $this->Constant_model->getDataOneColumnSortColumn('orders', 'customer_id', "$cust_id", 'id', 'DESC');

    if (count($historyData) > 0) {
        for ($h = 0; $h < count($historyData); ++$h) {
            $sales_id = $historyData[$h]->id;
            $dtm = date("$dateformat   H:i A", strtotime($historyData[$h]->ordered_datetime));
            $subTotal = $historyData[$h]->subtotal;
            $tax = $historyData[$h]->tax;
            $grandTotal = $historyData[$h]->grandtotal;
            $total_items = $historyData[$h]->total_items;
            $order_type = $historyData[$h]->status;
			$paidTotal = $historyData[$h]->paid_amt;
			$return_change = $historyData[$h]->return_change;
			$grand_only = $grandTotal - $return_change;
			$zero_paid = 0;
			
            $total_subTotal_amt += $subTotal;
            $total_taxTotal_amt += $tax;
            $total_grandTotal_amt += $grand_only;
			$sumPaidTotal += $paidTotal;
			$totalUnpaid_amt = $grand_only - $sumPaidTotal;
			$upaid_amount = $grand_only - $paidTotal;
			

            $pcodeArray = array();
            $pnameArray = array();
            $qtyArray = array();

            if ($order_type == '1') {                // Order;

                $oItemResult = $this->db->query("SELECT * FROM order_items WHERE order_id = '$sales_id' ORDER BY id ");
                $oItemRows = $oItemResult->num_rows();
                if ($oItemRows > 0) {
                    $oItemData = $oItemResult->result();

                    for ($t = 0; $t < count($oItemData); ++$t) {
                        $oItem_pcode = $oItemData[$t]->product_code;
                        $oItem_pname = $oItemData[$t]->product_name;
                        $oItem_qty = $oItemData[$t]->qty;

                        array_push($pcodeArray, $oItem_pcode);
                        array_push($pnameArray, $oItem_pname);
                        array_push($qtyArray, $oItem_qty);

                        unset($oItem_pcode);
                        unset($oItem_pname);
                        unset($oItem_qty);
                    }

                    unset($oItemData);
                }
                unset($oItemResult);
                unset($oItemRows);
            } elseif ($order_type == '2') {    // Return;

                $rItemResult = $this->db->query("SELECT * FROM return_items WHERE order_id = '$sales_id' ORDER BY id ");
                $rItemRows = $rItemResult->num_rows();
                if ($rItemRows > 0) {
                    $rItemData = $rItemResult->result();
                    for ($r = 0; $r < count($rItemData); ++$r) {
                        $rItem_pcode = $rItemData[$r]->product_code;
                        $rItem_qty = $rItemData[$r]->qty;

                        $productData = $this->Constant_model->getDataOneColumn('products', 'code', $rItem_pcode);
                        $rItem_pname = $productData[0]->name;

                        array_push($pcodeArray, $rItem_pcode);
                        array_push($pnameArray, $rItem_pname);
                        array_push($qtyArray, $rItem_qty);

                        unset($rItem_pcode);
                        unset($rItem_qty);
                        unset($rItem_pname);
                    }
                    unset($rItemData);
                }
                unset($rItemResult);
                unset($rItemRows);
            } ?>			
			<tr>
				<td>
					<?php
                        if ($order_type == '1') {
                            ?>
					<a href="<?=base_url()?>pos/view_invoice?id=<?php echo $sales_id; ?>" style="text-decoration: none;" target="_blank">
					<?php	
                        }
            if ($order_type == '2') {
                ?>
					<a href="<?=base_url()?>returnorder/printReturn?return_id=<?php echo $sales_id; ?>" style="text-decoration: none;" target="_blank">
					<?php

            } ?>
						<?php echo $sales_id; ?>
					</a>
				</td>
				<td style="font-weight: bold;">
					<?php
                        if ($order_type == '1') {
                            echo 'Sale';
                        }
            if ($order_type == '2') {
                echo 'Return';
            } ?>
				</td>
				<td><?php echo $dtm; ?></td>
				<td>
					<?php
                        if (count($pcodeArray) > 0) {
                            echo $pnameArray[0].' ['.$pcodeArray[0].']';
                        } ?>
				</td>
				<td>
					<?php
                        if (count($qtyArray) > 0) {
                            echo $qtyArray[0];
                        } ?>
				</td>
				<td><?php echo $total_items; ?></td>
				<td><?php echo number_format($subTotal, 2); ?></td>
				<td>
				<?php
                        if ($order_type == '1') {
                            echo number_format($paidTotal, 2);
                        }
            if ($order_type == '2') {
                echo number_format($zero_paid, 2);
            } ?>
				
				</td>
				<td><?php echo number_format($upaid_amount, 2); ?></td>
				
			</tr>
			<?php
                if (count($pcodeArray) > 1) {
                    for ($p = 1; $p < count($pcodeArray); ++$p) {
                        ?>
						<tr>
							<td></td>
							<td></td>
							<td></td>
							<td>
								<?php
                                    echo $pnameArray[$p].' ['.$pcodeArray[$p].']'; ?>
							</td>
							<td>
								<?php
                                    echo $qtyArray[$p]; ?>
							</td>
							<td></td>
							<td></td>
							<td></td>
							<td></td>
							
						</tr>
			<?php

                    }
                } ?>
<?php

        } ?>
			<tr>
				<td colspan="6" align="center" style="border-top: 1px solid #010101;"><b><?php echo $lang_total; ?></b></td>
				<td style="border-top: 1px solid #010101;">
					<b><?php echo number_format($total_subTotal_amt, 2)." ($currency)"; ?></b>
				</td>
				<td style="border-top: 1px solid #010101;">
					<b><?php echo number_format($sumPaidTotal, 2)." ($currency)"; ?></b>
				</td>
				<td style="border-top: 1px solid #010101;">
					<b><?php echo number_format($totalUnpaid_amt, 2)." ($currency)"; ?></b>
				</td>
				
			</tr>		
<?php

    } else {
        ?>

			<tr>
				<td colspan="6"><?php echo $lang_no_match_found; ?></td>
			</tr>
<?php	
    }
?>
									</tbody>
								</table>
							</div>
							
						</div>
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