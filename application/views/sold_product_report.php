<?php
    require_once 'includes/header.php';
?>
<link rel="stylesheet" href="//code.jquery.com/ui/1.12.0/themes/base/jquery-ui.css">
<script src="https://code.jquery.com/jquery-1.12.4.js"></script>
<script src="https://code.jquery.com/ui/1.12.0/jquery-ui.js"></script>
<script>
	$(function() {
		$("#startDate").datepicker({
			format: "<?php echo $dateformat; ?>",
			autoclose: true
		});
		
		$("#endDate").datepicker({
			format: "<?php echo $dateformat; ?>",
			autoclose: true
		});
	});
</script>
<style>
@media print {
		
		.hide-me {
    		display: none;
		
	}


</style>

<?php
    $url_start 		= "";
    $url_end 		= "";
	$url_paid_by = '';
	$url_order_type = '';
    if(isset($_GET["report"])) {
	    $url_start 	= strip_tags($_GET["start_date"]);
	    $url_end	= strip_tags($_GET["end_date"]);
		$url_paid_by = $_GET['paid'];
		
    }
	 if ($url_paid_by == '-') {
            $paid_sort = ' AND created_user_id > 0 ';
        } else {
            $paid_sort = " AND created_user_id ='$url_paid_by' ";
        }
	
?>

<script type="text/javascript" src="<?=base_url()?>assets/js/datatables/jquery-1.12.3.js"></script>
<script type="text/javascript" src="<?=base_url()?>assets/js/datatables/jquery.dataTables.min.js"></script>
<link href="<?=base_url()?>assets/js/DataTables/datatables.css" rel="stylesheet">
<script type="text/javascript">
$(document).ready(function() {
    $('#example').DataTable( {
       
        paging:         false
    } );
} );
</script>
<style>
.ciniki { 
	border: solid 1px #5cb85c;
    padding: 4px 4px 4px 4px;
	
} 
@media print {
	.body{
		font-size: 14px;
	}
	.sidebar-collapse {
    display: none;
  }
  .example_filter{
	display: none;
  }
  #hide{
	  display: none;
	  }
	#wapper{
		font-size: 12px;
		
	}
	.ciniki{
		font-size: 13px;
	}
	#title{
	  font-size: 14px;
	  }
	.main{
		font-size: 12px;
	}
 div#example_length {
    display: none;}
 div#example_filter {
    display: none;
}
}

</style>
<div id ="wapper" class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2 main ">
	<div  class="row">
		<div class="col-lg-12">
		<h1 id = "title" style="text-align: center;"><?php echo $setting_site_name; ?></h1>
            <strong><h3 id = "title" style="text-align: center;"> <?php echo 'SOLD PRODUCT REPORT'; ?></h3></strong>
		</div>
	</div><!--/.row-->
	<div class="row">
		<div class="col-md-12">
			<div class="panel panel-default">
			
				<div class="panel-body">
					<form action="<?=base_url()?>reports/sold_by_products" method="get">
						<div class="row">
						<div class="col-md-3">
							<div class="form-group ">
								<label><?php echo "Select Sale Person"; ?></label>
								<select name="paid" class="form-control" required>
									<option value=""><?php echo "Choose a User"; ?></option>
									<option value="-" <?php if ($url_paid_by == '-') {
                                    echo 'selected="selected"';
                                } ?>><?php echo $lang_all; ?></option>
								<?php
                                    $paymentData = $this->Constant_model->getDataAll('users', 'fullname', 'ASC');
                                    for ($p = 0; $p < count($paymentData); ++$p) {
                                        $pay_id = $paymentData[$p]->id;
                                        $pay_name = $paymentData[$p]->fullname; ?>
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
						
							<div class="col-md-3">
								<div class="form-group">
									<label><?php echo $lang_start_date; ?></label>
									<input type="text" name="start_date" class="form-control" id="startDate" required autocomplete="off" value="<?php echo $url_start; ?>" />
								</div>
							</div>
							<div class="col-md-3">
								<div class="form-group">
									<label><?php echo $lang_end_date; ?></label>
									<input type="text" name="end_date" class="form-control" id="endDate" required autocomplete="off" value="<?php echo $url_end; ?>" />
								</div>
							</div>
							<div id="hide" class="col-md-2">
								<div class="form-group">
									<label>&nbsp;</label><br />
									<input type="hidden" name="report" value="1" />
									<input  type="submit" class="btn btn-primary" value="<?php echo $lang_get_report; ?>" />
									
								</div>
							</div>
						</div>
					</form>

<?php
	if(isset($_GET["report"])) {
		if ($site_dateformat == 'd/m/Y') {
            $startArray 	= explode('/', $url_start);
            $endArray 		= explode('/', $url_end);

            $start_day 		= $startArray[0];
            $start_mon 		= $startArray[1];
            $start_yea 		= $startArray[2];

            $url_start 		= $start_yea.'-'.$start_mon.'-'.$start_day;

            $end_day 		= $endArray[0];
            $end_mon 		= $endArray[1];
            $end_yea 		= $endArray[2];

            $url_end 		= $end_yea.'-'.$end_mon.'-'.$end_day;
        }
        if ($site_dateformat == 'd.m.Y') {
            $startArray 	= explode('.', $url_start);
            $endArray 		= explode('.', $url_end);

            $start_day 		= $startArray[0];
            $start_mon 		= $startArray[1];
            $start_yea 		= $startArray[2];

            $url_start 		= $start_yea.'-'.$start_mon.'-'.$start_day;

            $end_day 		= $endArray[0];
            $end_mon 		= $endArray[1];
            $end_yea 		= $endArray[2];

            $url_end 		= $end_yea.'-'.$end_mon.'-'.$end_day;
        }
        if ($site_dateformat == 'd-m-Y') {
            $startArray 	= explode('-', $url_start);
            $endArray 		= explode('-', $url_end);

            $start_day 		= $startArray[0];
            $start_mon 		= $startArray[1];
            $start_yea 		= $startArray[2];

            $url_start 		= $start_yea.'-'.$start_mon.'-'.$start_day;

            $end_day 		= $endArray[0];
            $end_mon 		= $endArray[1];
            $end_yea 		= $endArray[2];

            $url_end 		= $end_yea.'-'.$end_mon.'-'.$end_day;
        }

        if ($site_dateformat == 'm/d/Y') {
            $startArray 	= explode('/', $url_start);
            $endArray 		= explode('/', $url_end);

            $start_day 		= $startArray[1];
            $start_mon 		= $startArray[0];
            $start_yea 		= $startArray[2];

            $url_start 		= $start_yea.'-'.$start_mon.'-'.$start_day;

            $end_day 		= $endArray[1];
            $end_mon 		= $endArray[0];
            $end_yea 		= $endArray[2];

            $url_end 		= $end_yea.'-'.$end_mon.'-'.$end_day;
        }
        if ($site_dateformat == 'm.d.Y') {
            $startArray 	= explode('.', $url_start);
            $endArray	 	= explode('.', $url_end);

            $start_day 		= $startArray[1];
            $start_mon 		= $startArray[0];
            $start_yea 		= $startArray[2];

            $url_start 		= $start_yea.'-'.$start_mon.'-'.$start_day;

            $end_day 		= $endArray[1];
            $end_mon 		= $endArray[0];
            $end_yea 		= $endArray[2];

            $url_end 		= $end_yea.'-'.$end_mon.'-'.$end_day;
        }
        if ($site_dateformat == 'm-d-Y') {
            $startArray 	= explode('-', $url_start);
            $endArray 		= explode('-', $url_end);

            $start_day 		= $startArray[1];
            $start_mon 		= $startArray[0];
            $start_yea 		= $startArray[2];

            $url_start 		= $start_yea.'-'.$start_mon.'-'.$start_day;

            $end_day 		= $endArray[1];
            $end_mon 		= $endArray[0];
            $end_yea 		= $endArray[2];

            $url_end 		= $end_yea.'-'.$end_mon.'-'.$end_day;
        }

        if ($site_dateformat == 'Y.m.d') {
            $startArray 	= explode('.', $url_start);
            $endArray 		= explode('.', $url_end);

            $start_day 		= $startArray[2];
            $start_mon 		= $startArray[1];
            $start_yea 		= $startArray[0];

            $url_start 		= $start_yea.'-'.$start_mon.'-'.$start_day;

            $end_day 		= $endArray[2];
            $end_mon 		= $endArray[1];
            $end_yea 		= $endArray[0];

            $url_end 		= $end_yea.'-'.$end_mon.'-'.$end_day;
        }
        if ($site_dateformat == 'Y/m/d') {
            $startArray 	= explode('/', $url_start);
            $endArray 		= explode('/', $url_end);

            $start_day 		= $startArray[2];
            $start_mon 		= $startArray[1];
            $start_yea 		= $startArray[0];

            $url_start 		= $start_yea.'-'.$start_mon.'-'.$start_day;

            $end_day 		= $endArray[2];
            $end_mon 		= $endArray[1];
            $end_yea 		= $endArray[0];

            $url_end 		= $end_yea.'-'.$end_mon.'-'.$end_day;
        }
        if ($site_dateformat == 'Y-m-d') {
            $startArray 	= explode('-', $url_start);
            $endArray 		= explode('-', $url_end);

            $start_day	 	= $startArray[2];
            $start_mon 		= $startArray[1];
            $start_yea 		= $startArray[0];

            $url_start 		= $start_yea.'-'.$start_mon.'-'.$start_day;

            $end_day 		= $endArray[2];
            $end_mon 		= $endArray[1];
            $end_yea 		= $endArray[0];

            $url_end 		= $end_yea.'-'.$end_mon.'-'.$end_day;
        }
        
?>
		<div class="row" style="margin-top: 10px;">
			
		</div>
		<div class="row" style="margin-top: 10px;">
			<div class="col-md-12">
				<div class="">
					<table id="example" class="display" cellspacing="0" width="100%">
					    <thead>
						
					        <tr>
						        
						        <th width="28%"><?php echo $this->lang->line("product_name"); ?></th>
								
						        <th width="15%"><?php echo $this->lang->line("sold_by_product_sold_qty"); ?></th>
								<th id = "hide" width="28%"><?php echo "Unit Price"; ?></th>
								<th  id = "hide" width="15%"><?php echo "Total Amount"; ?></th>
								
					        </tr>
					    </thead>
					    <tbody>
<?php
	$pcodeArray 	= array();
	$start_dtm 		= $url_start." 00:00:00";
	$end_dtm 		= $url_end." 23:59:59";
	
	$ordItemResult 	= $this->db->query("SELECT DISTINCT product_code FROM order_items WHERE created_datetime >= '$start_dtm' AND created_datetime <= '$end_dtm' AND status = '1' $paid_sort  ORDER BY id DESC ");
	$ordItemData 	= $ordItemResult->result();
	for($oit = 0; $oit < count($ordItemData); $oit++) {
		$ordItem_pcode 		= $ordItemData[$oit]->product_code;
		
		if(in_array("$ordItem_pcode", $pcodeArray)) {
			
		} else {
			array_push($pcodeArray, $ordItem_pcode);
		}
		
		unset($ordItem_pcode);
	}
	unset($ordItemData);
	unset($ordItemResult);
?>

<?php
	if(count($pcodeArray) > 0) {
		for($p = 0; $p < count($pcodeArray); $p++) {
			$pcode 				= $pcodeArray[$p];
			
			$pname 				= "-";
			$pcat_name 			= "-";
			$prodDtaResult		= $this->db->query("SELECT * FROM products WHERE code = '$pcode' ");
			$prodDtaRows 		= $prodDtaResult->num_rows();
			if($prodDtaRows == 1) {
				$prodDtaData	= $prodDtaResult->result();
				$pname 			= $prodDtaData[0]->name;
				$retail_price 	= $prodDtaData[0]->retail_price;
				$pcat_id 		= $prodDtaData[0]->category;
				unset($prodDtaData);
				
				$catNameResult	= $this->db->query("SELECT name FROM category WHERE id = '$pcat_id' ");
				$catNameRows 	= $catNameResult->num_rows();
				if($catNameRows == 1) {
					$catNameData= $catNameResult->result();
					$pcat_name	= $catNameData[0]->name;
					unset($catNameData);
				}
				unset($catNameRows);
				unset($catNameResult);
			}
			unset($prodDtaRows);
			unset($prodDtaResult);
			
			
			$total_sold_qty 	= 0;
			$soldItemResult 	= $this->db->query("SELECT qty FROM order_items WHERE product_code = '$pcode' AND created_datetime >= '$start_dtm' AND created_datetime <= '$end_dtm' $paid_sort AND status = '1' ");
			$soldItemData 		= $soldItemResult->result();
			for($s = 0; $s < count($soldItemData); $s++) {
				$soldItem_qty	= $soldItemData[$s]->qty;
				
				$total_sold_qty += $soldItem_qty;
				
				
				unset($soldItem_qty);
			}
			$total_amount = 0;
			$total_amount = $total_sold_qty * $retail_price;
			unset($soldItemData);
			unset($soldItemResult);

			$number_invoice 	= 0;
			
			$invCountResult 	= $this->db->query("SELECT id FROM orders WHERE  created_datetime >= '$start_dtm' AND created_datetime <= '$end_dtm' $paid_sort AND status = '1' ");
			$invCountData 		= $invCountResult->result();
			$number_invoice = count($invCountData);
			
			unset($invCountData);
			unset($invCountResult);
			
?>
			<tr>
				
				<td><?php echo $pname; ?></td>
				
				<td><?php echo $total_sold_qty; ?></td>
				<td id = "hide"><?php echo $soldItem_price; ?></td>
				<td id = "hide"><?php echo $total_amount; ?></td>
				
			</tr>
<?php
		}
	}
?>		
<?php 
$alltotal = 0;
  $orderResult = $this->db->query("SELECT * FROM orders WHERE created_datetime >= '$start_dtm' AND created_datetime <= '$end_dtm' $paid_sort");
       $orderRows = $orderResult->num_rows();
        $orderData = $orderResult->result();

        foreach ($orderData as $data) {
   			$grandTotal = $data->grandtotal;
			$alltotal += $grandTotal;
		}
           


?>	
<?php 
$Dine_in = 0;
  $orderResultDine_in = $this->db->query("SELECT * FROM orders WHERE created_datetime >= '$start_dtm' AND created_datetime <= '$end_dtm'");
       $orderRows = $orderResultDine_in->num_rows();
        $orderData_dine = $orderResultDine_in->result();

        foreach ($orderData_dine as $data) {
   			$grandTotal_dine = $data->grandtotal;
			$Dine_in += $grandTotal_dine;
		}






$Delivery_qty = 0;		
$soldItemResult 	= $this->db->query("SELECT qty FROM order_items WHERE created_datetime >= '$start_dtm' AND created_datetime <= '$end_dtm'  AND status = '1'  ");
			$soldItemData 		= $soldItemResult->result();
			for($s = 0; $s < count($soldItemData); $s++) {
				$qty_delivery	= $soldItemData[$s]->qty;
				$Delivery_qty += $qty_delivery;
			
			}    
$Take_out_qty = 0;		
$soldItemResult 	= $this->db->query("SELECT qty FROM order_items WHERE created_datetime >= '$start_dtm' AND created_datetime <= '$end_dtm'  AND status = '1' ");
			$soldItemData 		= $soldItemResult->result();
			for($s = 0; $s < count($soldItemData); $s++) {
				$take_out	= $soldItemData[$s]->qty;
				$Take_out_qty += $take_out;
			
			}    
$Dine_in_qty = 0;
$soldItemResult 	= $this->db->query("SELECT qty FROM order_items WHERE created_datetime >= '$start_dtm' AND created_datetime <= '$end_dtm'  AND status = '1' ");
			$soldItemData 		= $soldItemResult->result();
			for($s = 0; $s < count($soldItemData); $s++) {
				$dine_in	= $soldItemData[$s]->qty;
				$Dine_in_qty += $dine_in;
			
			}    
			
$total_qty = 0;
$soldItemResult 	= $this->db->query("SELECT qty FROM order_items WHERE created_datetime >= '$start_dtm' AND created_datetime <= '$end_dtm'  AND status = '1'  ");
			$soldItemData 		= $soldItemResult->result();
			for($s = 0; $s < count($soldItemData); $s++) {
				$all_qty	= $soldItemData[$s]->qty;
				$total_qty += $all_qty;
			
			}    
			

$total_ticket_amt =  $Dine_in + $Take_out + $Delivery ;

$total_ticket = 0;
unset($soldItemResult);
unset($orderResultDine_in);
unset($orderRows);
unset($soldItemResult);
// check user sellected 

$select_user = '';
                                            $getCostResult = $this->db->query("SELECT fullname FROM users WHERE id = '$url_paid_by' ");
                                            $getCostData = $getCostResult->result();

                                            $select_user = $getCostData[0]->fullname;

?>	
		
		
						</tbody>
						<div>
						<strong><p style="text-align: right;"> <?php echo 'Printed on: '; ?><?php echo date("d-m-Y H:i:s"); ?></p></p></strong>
						</div>
						
						
						
						<div class="row ciniki" style="padding-top: 10px; padding-bottom: 10px; text-align: right; font-size: 18px; letter-spacing: 0.5px; margin-bottom: 10px;">
						
						<div class="col-md-8" style="font-weight: bold;"><?php echo "Sales Total "; ?></div>
						<div class="col-md-4" style="font-weight: bold;">:<?php echo 'N '?><?php echo number_format($total_ticket_amt, 2); ?></div>
						</div>
						<div class="row ciniki" style="padding-top: 10px; padding-bottom: 10px; text-align: right; font-size: 18px; letter-spacing: 0.5px; margin-bottom: 10px;">
						<div class="col-md-8" style="font-weight: bold;"><?php echo $select_user 
						." ( Total Sales )"; ?></div>
						<div class="col-md-4" style="font-weight: bold;">: <?php echo 'N '?><?php echo number_format($alltotal, 2); ?></div>
						<div class="col-md-8" style="font-weight: bold;"><?php echo "Completed Transaction"; ?></div>
						<div class="col-md-4" style="font-weight: bold;"><?php echo $number_invoice; ?></div>
						</div>
						
					
					</table>
				
			</div>
		</div>
<?php
	}	
?>

					
					
				</div><!-- Panel Body // END -->
			</div><!-- Panel Default // END -->
		</div><!-- Col md 12 // END -->
	</div><!-- Row // END -->
	
	<br /><br /><br />
	
</div><!-- Right Colmn // END -->
	
	
	
<?php
    require_once 'includes/footer.php';
?>