<?php
    require_once 'includes/header.php';
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
}

	}


</style>

<div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2 main">
	<div class="row">
		<div class="col-lg-12">
			<h1 class="page-header"><?php echo "Return Purchase Order"; ?></h1>
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
						<div class="col-md-12">
							<?php
                                if ($user_role =='2') {
                                    ?>
							<a href="<?=base_url()?>purchase_order/return_purchase_order" style="text-decoration: none">
								<button class="btn btn-primary" style="padding: 0px 12px;"><i class="icono-plus"></i>
									<?php echo "Add Return PO"; ?>
								</button>
							</a>
							<?php

                                }
                            ?>
						</div>
					</div>
					<div class="row" style="margin-top: 10px;">
						<div class="col-md-12">
							
						<div   >
							<table id="example" class="table table-bordered">
							    <thead>
							    	<tr>
								    	<th width="15%"><?php echo "Return PO Number"; ?></th>
									   
									    <th width="20%"><?php echo $lang_suppliers; ?></th>
									    <th width="10%"><?php echo $lang_created_date; ?></th>
										<th width="20%"><?php echo "Return PO Amount"; ?></th>
									    <th width="13%"><?php echo $lang_status; ?></th>
									    <th width="10%"><?php echo $lang_action; ?></th>
										
									</tr>
							    </thead>
								<tbody>
<?php
			$po_total=0;
    if (count($results) > 0) {
        foreach ($results as $data) {
            $id = $data->id;
            $po_numb = $data->po_number;
            $supplier_id = $data->supplier_id;
            $outlet_id = $data->outlet_id;
            $po_date = $data->po_date;
            $status_id = $data->status;
			$grandtotal = $data->grandTotal;

            $outlet_name = $data->outlet_name;
            $supplier_name = $data->supplier_name;
			$po_total +=$grandtotal;

            $status_name = '';
            $statusData = $this->Constant_model->getDataOneColumn('purchase_order_status', 'id', "$status_id");
            $status_name = $statusData[0]->name; ?>
			<tr>
				<td><?php echo $po_numb; ?></td>
				
				<td><?php echo $supplier_name; ?></td>
				<td><?php echo date("$dateformat", strtotime($po_date)); ?></td>
				<td><?php echo number_format($grandtotal,2); ?></td>
				<td style="font-weight: bold;">
				<?php 
                    if ($status_id == '1') {
                        echo $lang_created;
                    } elseif ($status_id == '2') {
                        echo "Success";
                    } elseif ($status_id == '3') {
                        echo "Received inStock ";
                    }
                    //echo $status_name;
                ?>
				</td>
				
				<td >

						<a href="<?=base_url()?>purchase_order/return_viewpo?id=<?php echo $id; ?>" style="text-decoration: none; margin-left: 5px;">
							<button class="btn btn-primary" style="padding: 5px 12px;">&nbsp;&nbsp;<?php echo $lang_view; ?>&nbsp;&nbsp;</button>
						</a>
						
						
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
			
			<td colspan="2"><?php echo number_format($po_total,2); ?></td>
			<td></td>
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