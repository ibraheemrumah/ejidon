<?php
    require_once 'includes/header.php';
?>
<script type="text/javascript" src="<?=base_url()?>assets/js/DataTables/datatables.js"></script>

<link href="<?=base_url()?>assets/js/DataTables/datatables.css" rel="stylesheet">
<script type="text/javascript">
	/* Custom filtering function which will search data in column four between two values */
$.fn.dataTable.ext.search.push(function (settings, data, dataIndex) {
    var min = parseFloat($('#min').val(), 10);
    var max = parseFloat($('#max').val(), 10);
    var age = parseFloat(data[5]) || 0; // use data for the age column
 
    if (
        (isNaN(min) && isNaN(max)) ||
        (isNaN(min) && age <= max) ||
        (min <= age && isNaN(max)) ||
        (min <= age && age <= max)
    ) {
        return true;
    }
    return false;
});
 
$(document).ready(function () {
    var table = $('#example').DataTable(
		{
       "lengthMenu": [[10,   -1], [10,   "All"]]
        
    } 
	
	);
 
    // Event listener to the two range filtering inputs to redraw on input
    $('#min, #max').keyup(function () {
        table.draw();
    });
});
</script>


<style>

.row.show-me {
    display: none;
}

body {
background: #ffffff;

}

@media print {
		body { text-transform: uppercase; font-size:10px; }
		#buttons { display: none; }
		#wrapper { width: 100%; margin: 0; font-size:8px; }
		#wrapper img { max-width:300px; width: 80%; }
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
	table.dataTable tbody th, table.dataTable tbody td {
    padding: 0px 10px;
	tr.hide-me {
    display: none;
}

	h1.page-header {
    margin-top: 5px;
    border-bottom: 0;
    font-size: 15px;
}
	}







</style>


<div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2 main">
	<div class="row">
		<div class="col-lg-12">
			<h1 class="page-header"><?php echo $lang_list_products; ?></h1>
		</div>
	</div><!--/.row-->
	
	<div class="row">
		<div class="col-md-12">
			<div class="panel panel-default">
				<div class="panel-body hide-me">
					
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
					
					<?php
                                if ($user_role == 4 || $user_role == 5 || $user_role == 1 ) {
                    
                                    ?>
					<div class="row hide-me" style="border-bottom: 1px solid #e0dede; padding-bottom: 8px;">
						<div class="col-md-12">
							<a href="<?=base_url()?>products/addproduct" style="text-decoration: none">
								<button class="btn btn-primary" style="padding: 0px 12px;"><i class="icono-plus"></i>
									<?php echo $lang_add_product; ?>
								</button>
							</a>
						</div>
					</div>
					<?php

                        }
                    ?>
					
					
					
					<div class="row" style="margin-top: 0px;">
						<div class="col-md-12">
							
						<div>
							<table id="example" class="table-bordered" cellspacing="0" width="100%">
							    <thead>
								
							    	<tr>
								    	
								    	<th width="10%"><?php echo "Product Code"; ?></th>
										<th width="45%"><?php echo $lang_name; ?></th>
								
								    	<th   width="25%"><?php echo "Cost Price"; ?></th>
								    	<th  width="25%"><?php echo "Sales Price"; ?></th>
										
								    	<th  width="5%"><?php echo "Stock Qty"; ?></th>
								    	
										
										
									    <th class="hide-me" width="10%"><?php echo $lang_action; ?></th>
									</tr>
							    </thead>
								<tbody>
								<?php
                                    if (count($results) > 0) {
                                        foreach ($results as $data) {
                                            $id = $data->id;
											$code = $data->code;
                                            $name = $data->name;
											$retail_price =$data->retail_price;
                                            $purchase_price = $data->purchase_price;
											$category = $data->category;
                                            $stock_qty = $data->stock_qty;
											

                                            ?>
											
											<tr>
												
												<td><?php echo $code; ?></td>
												<td><?php echo $name; ?></td>
										
												<td style="text-align: center;"><?php echo $purchase_price; ?></td>
												
												<td style="text-align: center;"><?php echo $retail_price; ?></td>
												<td style="text-align: center;"><?php echo $stock_qty; ?></td>
												
												
												
												
												<td class="hide-me">
										
													
										<a class="fancybox hide-me" onclick="openReceipt ('<?=base_url()?>products/editproduct?id=<?php echo $id; ?>')" style="text-decoration: none;cursor:pointer; margin-left: 10px;" title="Edit">
											<img src="<?=base_url()?>assets/img/edit_icon.png" height="30px" />
										</a>
													
	
												</td>
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
								</tbody>
							</table>
						</div>
							
						</div>
					</div>
					
					<!--<div class="row">
						<div class="col-md-6" style="float: left; padding-top: 10px;">
							<?php echo $displayshowingentries; ?>
						</div>
						<div class="col-md-6" style="text-align: right;">
							<?php echo $links; ?>
						</div>
					</div>-->
					
				</div><!-- Panel Body // END -->
			</div><!-- Panel Default // END -->
		</div><!-- Col md 12 // END -->
	</div><!-- Row // END -->
	
	<br /><br /><br />
	
</div><!-- Right Colmn // END -->
	
	
	
<?php
    require_once 'includes/footer.php';
?>

<script type="text/javascript">
	function openReceipt(ele){
		var myWindow = window.open(ele, "", "width=1083, height=604");
	}	
</script>
