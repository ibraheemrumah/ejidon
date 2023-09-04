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
<?php
    $url_start 		= "";
    $url_end 		= "";
    if(isset($_GET["report"])) {
	    $url_start 	= strip_tags($_GET["start_date"]);
	    $url_end	= strip_tags($_GET["end_date"]);
    }
?>
	 
	
?>
<link href="<?=base_url()?>assets/js/DataTables/datatables.css" rel="stylesheet">
<script type="text/javascript">
$(document).ready(function() {
    $('#example').DataTable( {
       "lengthMenu": [[10,   -1], [10,   "All"]]
        
    } );
} );
</script>
<style>

.row.show-me {
    display: none;
}

body {
background: #ffffff;

}

@media print {
		body { text-transform: uppercase; font-size:11px; }
		#buttons { display: none; }
		a { display: none;}
		#bkpos_wrp{
			display: none;
		}
		button.btn.btn-primary {
 		   display: none;
			}
		th.hide-me {
    		display: none;
		}
		td.hide-me {
 		   display: none;
		}
		th.hide-me {
    display: none;
	}
	.row.hide-me {
    display: none;
	}
	.row.show-me {
    display: contents;
}	th,tr,td{
border-color: black !important;
border: 2px solid black !important;
}

	}


</style>

<div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2 main">
	<div class="row">
		<div class="col-lg-12">
			<h1 class="page-header"><?php echo $lang_purchase_order; ?></h1>
		</div>
	</div><!--/.row-->
	
	<div class="row">
		<div class="col-md-12">
			<div class="panel panel-default">
				
				<div class="panel-body">
					<form action="<?=base_url()?>purchase_order/report/" method="get">
						<div class="row">
												
							<div class="col-md-3">
								<div class="form-group">
									<label><?php echo "Start date"; ?></label>
									<input type="text" name="start_date" class="form-control" id="startDate" required autocomplete="off" value="<?php echo $url_start; ?>" />
								</div>
							</div>
							<div class="col-md-3">
								<div class="form-group">
									<label><?php echo "End date"; ?></label>
									<input type="text" name="end_date" class="form-control" id="endDate" required autocomplete="off" value="<?php echo $url_end; ?>" />
								</div>
							</div>
							<div id="hide" class="col-md-2">
								<div class="form-group">
									<label>&nbsp;</label><br />
									<input type="hidden" name="report" value="1" />
									<input  type="submit" class="btn btn-primary" value="<?php echo "Get report"; ?>" />
									
								</div>
							</div>
						</div>
					</form>
				</div>	
			</div>
		</div>
	</div>

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
					
					<!-- search purchase order-->
					<div class="row" style="margin-top: 10px;">
						<div class="col-md-12">
							
						<div   >
							<table id="example" class="table table-bordered">
							    <thead>
							    	<tr>
								    	<th width="15%"><?php echo $lang_purchase_order_number; ?></th>
									   
									    <th width="20%"><?php echo $lang_suppliers; ?></th>
									    <th width="10%"><?php echo $lang_created_date; ?></th>
										<th width="20%"><?php echo "PO P. Value"; ?></th>
										<th width="20%"><?php echo "PO S. Value"; ?></th>
									    <th width="13%"><?php echo $lang_status; ?></th>
									    <th width="10%"><?php echo $lang_action; ?></th>
										
									</tr>
							    </thead>
								<tbody>
<?php
		$start_dtm 		= $url_start." 00:00:00";
		$end_dtm 		= $url_end." 23:59:59";
		$po_total = 0;
		$po_sale = 0;
		
		$PurchaseItemResult 	= $this->db->query("SELECT * FROM purchase_order WHERE created_datetime >= '$start_dtm' AND created_datetime <= '$end_dtm'  ");
		$PurchaseItemData 		= $PurchaseItemResult->result();
		$cn = (count($PurchaseItemData));
			for($s = 0; $s < count($PurchaseItemData); $s++) {
			
			
            $id = $PurchaseItemData[$s]->id;
            $po_numb = $PurchaseItemData[$s]->po_number;
            $supplier_id = $PurchaseItemData[$s]->supplier_id;
            $outlet_id = $PurchaseItemData[$s]->outlet_id;
			$po_date = date("$site_dateformat H:i A", strtotime($PurchaseItemData[$s]->created_datetime));
            
            $status_id = $PurchaseItemData[$s]->status;
			$grandtotal = $PurchaseItemData[$s]->grandTotal;
			$saletotal = $PurchaseItemData[$s]->sale_value;

            $outlet_name = $PurchaseItemData[$s]->outlet_name;
            $supplier_name = $PurchaseItemData[$s]->supplier_name;
			$po_total +=$grandtotal;
			$po_sale +=$saletotal;

             ?>
			<tr>
				<td><?php echo $po_numb; ?></td>
				
				<td><?php echo $supplier_name; ?></td>
				<td><?php echo $po_date; ?></td>
				<td><?php echo number_format($grandtotal,2); ?></td>
				<td><?php echo number_format($saletotal,2); ?></td>
				<td style="font-weight: bold;">
				<?php 
                    if ($status_id == '1') {
                        echo $lang_created;
                    } elseif ($status_id == '2') {
                        echo "Checked by Audit";
                    } elseif ($status_id == '3') {
                        echo "Received inStock ";
                    }
                    //echo $status_name;
                ?>
				</td>
				
				<td >
				<?php
                    if ($status_id == '1' ) {
                        ?>
						<a href="<?=base_url()?>purchase_order/editpo?id=<?php echo $id; ?>" style="text-decoration: none; margin-left: 5px;">
							<button class="btn btn-primary" style="padding: 5px 12px;">&nbsp;&nbsp;<?php echo $lang_edit; ?>&nbsp;&nbsp;</button>
						</a>
						
						<?php
                            if ($user_role == '2') {
                                ?>
						<a href="<?=base_url()?>purchase_order/deletePO?id=<?php echo $id; ?>&po_numb=<?php echo $po_numb; ?>" style="text-decoration: none; margin-left: 10px;" onclick="return confirm('Are you sure to delete this Purchase Order : <?php echo $po_numb; ?>?')">
							<i class="icono-cross" style="color:#F00;"></i>
						</a>
						<?php

                            } ?>
				<?php	
                    } else {
                        ?>
						<?php
                            if ($status_id == '2') {
                                ?>
								<a href="<?=base_url()?>purchase_order/receivepo?id=<?php echo $id; ?>" style="text-decoration: none; margin-left: 5px;">
									<button class="btn btn-primary" style="padding: 5px 12px;">&nbsp;&nbsp;<?php echo $lang_receive; ?>&nbsp;&nbsp;</button>
								</a>
						<?php

                            } ?>
						<a href="<?=base_url()?>purchase_order/viewpo?id=<?php echo $id; ?>" style="text-decoration: none; margin-left: 5px;">
							<button class="btn btn-primary" style="padding: 5px 12px;">&nbsp;&nbsp;<?php echo $lang_view; ?>&nbsp;&nbsp;</button>
						</a>
						
						<?php
                            if ($status_id == '2') {
                                if ($user_role < 3) {
                                    ?>
						<a href="<?=base_url()?>purchase_order/deletePO?id=<?php echo $id; ?>&po_numb=<?php echo $po_numb; ?>" style="text-decoration: none; margin-left: 10px;" onclick="return confirm('Are you sure to delete this Purchase Order : <?php echo $po_numb; ?>?')">
							<i class="icono-cross" style="color:#F00;"></i>
						</a>
						<?php

                                }
                            } ?>
				<?php

                    } ?>	
				</td>
			</tr>
			
<?php	
        }
    } else {
        ?>
		<tr class="no-records-found">
			<td colspan="6"><?php echo $lang_no_match_found; ?></td>
		</tr>
<?php

    }
?>			<tr>
			<td colspan="2" style="
    text-align: end;
">Total<td>
			
			<td colspan="1"><?php if ($cn > 0) { echo number_format($po_total,2);} ?></td>
			<td><?php if ($cn > 0) { echo number_format($po_sale,2); } ?></td>
			<td colspan="1"><?php if ($cn > 0) { echo number_format(($po_sale - $po_total),2); }?></td>
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
	
	<br /><br /><br />
	
</div><!-- Right Colmn // END -->
	
	
	
<?php
	
	  require_once 'includes/footer.php';
?>