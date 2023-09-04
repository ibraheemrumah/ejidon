<?php
    require_once 'includes/header_edit.php';
?>

<?php
    $prodData = $this->Constant_model->getDataOneColumn('products', 'id', $id);

    if (count($prodData) == 0) {
        redirect(base_url());
    }

    $code = $prodData[0]->code;
    $name = $prodData[0]->name;
    $category = $prodData[0]->category;
    $cost = $prodData[0]->purchase_price;
    $price = $prodData[0]->retail_price;
    $thumbnail = $prodData[0]->thumbnail;
    $status = $prodData[0]->status;
	$required_qty = $prodData[0]->required_qty;
	$exp_date = $prodData[0]->exp_date;
?>

<style type="text/css">
	.fileUpload {
	    position: relative;
	    overflow: hidden;
	    border-radius: 0px;
	    margin-left: -4px;
	    margin-top: -2px;
	}
	.fileUpload input.upload {
	    position: absolute;
	    top: 0;
	    right: 0;
	    margin: 0;
	    padding: 0;
	    font-size: 20px;
	    cursor: pointer;
	    opacity: 0;
	    filter: alpha(opacity=0);
	}
</style>

<script type="text/javascript">
	$(document).ready(function(){
		document.getElementById("uploadBtn").onchange = function () {
			document.getElementById("uploadFile").value = this.value;
		};
	});
	function stopclick(subBtn){
		document.getElementById("subBtn").style.display 	= "none";
		
		
		
	}
</script>

<div class="col-sm-10 col-sm-offset-1 col-lg-10 col-lg-offset-1 main">
	<div class="row">
		<div class="col-lg-12">
			<h1 class="page-header"><?php echo $lang_edit_product; ?> : <?php echo $code; ?></h1>
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
							<script>
							window.close();
							</script>
					<?php

                            }
                        }
                    ?>
					
					<?php
                        if ($user_role < 3 ) {
                            ?>
					<div class="row">
						<div class="col-md-12" style="text-align: right;">
							<form action="<?=base_url()?>products/deleteProduct" method="post" onsubmit="return confirm('Do you want to delete this Product?')">
								<input type="hidden" name="prod_id" value="<?php echo $id; ?>" />
								<input type="hidden" name="prod_name" value="<?php echo $name; ?>" />
								<button type="submit" class="btn btn-primary" style="border: 0px; background-color: #c72a25;">
									<?php echo $lang_delete_product; ?>
								</button>
							</form>
						</div>
					</div>
					<?php

                        }
                    ?>
					
	<form action="<?=base_url()?>products/updateProduct" method="post" enctype="multipart/form-data">				
					<div class="row">
						<div class="col-md-4">
							<div class="form-group">
								<label><?php echo $lang_product_code; ?> <span style="color: #F00">*</span></label>
						<input type="text" name="code" class="form-control" maxlength="250" autofocus required autocomplete="off" value="<?php echo $code; ?>" readonly />
							</div>
						</div>
						<div class="col-md-4">
							<div class="form-group">
								<label><?php echo $lang_product_name; ?> <span style="color: #F00">*</span></label>
								<input type="text" name="name" class="form-control" maxlength="250" required autocomplete="off" value="<?php echo $name; ?>" />
							</div>
						</div>
						<div class="col-md-4">
							<div class="form-group">
								<label><?php echo $lang_product_category; ?> <span style="color: #F00">*</span></label>
								<select name="category" class="form-control" required>
									<option value="">Choose Category</option>
								<?php
                                    $catData = $this->Constant_model->getDataOneColumn('category', 'status', '1');
                                    for ($c = 0; $c < count($catData); ++$c) {
                                        $cat_id = $catData[$c]->id;
                                        $cat_name = $catData[$c]->name; ?>
										<option value="<?php echo $cat_id; ?>" <?php if ($category == $cat_id) {
                                            echo 'selected="selected"';
                                        } ?>><?php echo $cat_name; ?></option>
								<?php

                                    }
                                ?>
								</select>
							</div>
						</div>
					</div>
					
					<div class="row">
						<div class="col-md-4">
							<div class="form-group">
								<label><?php echo $lang_purchase_price; ?> (<?php echo $lang_cost; ?>) <span style="color: #F00">*</span></label>
								<input type="text" name="purchase" class="form-control" maxlength="250" autofocus required autocomplete="off" value="<?php echo $cost; ?>" />
							</div>
						</div>
						<div class="col-md-4">
							<div class="form-group">
								<label><?php echo "Wholesale Price"; ?> (<?php echo $lang_price; ?>) <span style="color: #F00">*</span></label>
								<input type="text" name="retail" class="form-control" maxlength="250" required autocomplete="off" value="<?php echo $price; ?>"  />
							</div>
						</div>
							<!--<div class="col-md-4">
							<div class="form-group">
								<label><?php echo "Expire Date"; ?>  <span style="color: #F00">*</span></label>
								<input type="text" name="exp_date" class="form-control" maxlength="250" required autocomplete="off" placeholder="2021-02-01" value="<?php echo $exp_date; ?>"/>
							</div>
						</div>-->
						<div class="col-md-4">
							<div class="form-group">
								<label>Status <span style="color: #F00">*</span></label>
								<select name="status" class="form-control">
									<option value="1" <?php if ($status == '1') {
                                    echo 'selected="selected"';
                                } ?>><?php echo $lang_active; ?></option>
									<option value="0" <?php if ($status == '0') {
                                    echo 'selected="selected"';
                                } ?>><?php echo $lang_inactive; ?></option>
								</select>
							</div>
						</div>
					</div>
					
					<div class="row">
					<!--<div class="col-md-4">
							<div class="form-group">
								<label><?php echo "Qty Required"; ?>  <span style="color: #F00">*</span></label>
								<input type="text" name="required_qty" class="form-control" maxlength="250" autocomplete="off" value="<?php echo $required_qty; ?>" />
							</div>
						</div>-->
						
						<div class="col-md-4">
							<div class="form-group">
								<label><?php echo "Add Qty"; ?>  <span style="color: #F00">*</span></label>
								<input type="text" name="item_qty" class="form-control" maxlength="250" autocomplete="off" placeholder="0"/>
							</div>
						</div>
						
						<div class="col-md-4"></div>
						<div class="col-md-4">
							<?php
                                if ($thumbnail != 'no_image.jpg') {
                                    ?>
									<img src="<?=base_url()?>assets/upload/products/xsmall/<?php echo $code; ?>/<?php echo $thumbnail; ?>" />
							<?php

                                }
                            ?>
						</div>
					</div>
					
					<?php
                        if ($user_role =='1'||$user_role =='2'||$user_role =='3') {
                            ?>					
					<div class="row">
						<div class="col-md-4">
							<div class="form-group">
								<input type="hidden" name="id" value="<?php echo $id; ?>" />
								<button class="btn btn-primary" onclick="stopclick(this)" id="subBtn">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $lang_update; ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</button>
							</div>
						</div>
						
						<div class="col-md-4"></div>
						<div class="col-md-4"></div>
					</div>
					<?php

                        }
                    ?>
	</form>				
					
				</div><!-- Panel Body // END -->
			</div><!-- Panel Default // END -->
			
			
			<div class="panel panel-default">
				<div class="panel-body">
					<h1 class="page-header" style="margin-top: 0px; padding-bottom: 4px; font-size: 30px; margin: 0px 0 11px; color: #0079c0;">
						<?php echo $lang_inventory_by_outlet; ?>
					</h1>
					
					<div class="row">
						<div class="col-md-3"><b style="color: #0079c0"><?php echo $lang_outlets; ?></b></div>
						<div class="col-md-9"><b style="color: #0079c0"><?php echo $lang_inventory_count; ?></b></div>
					</div>
					<?php
                        if ($user_role < 5) {
                            $outletData = $this->Constant_model->getDataOneColumnSortColumn('outlets', 'status', '1', 'name', 'ASC');
                        } else {
                            $outletData = $this->Constant_model->getDataOneColumn('outlets', 'id', "$user_outlet");
                        }
                        for ($t = 0; $t < count($outletData); ++$t) {
                            $outlet_id = $outletData[$t]->id;
                            $outlet_name = $outletData[$t]->name; ?>
					<div class="row" style="padding-top: 5px; padding-bottom: 5px;">
						<div class="col-md-3">
							<?php echo $outlet_name; ?>
						</div>
						<div class="col-md-9">
							<?php
                                $invQty = 0;
                            $invQtyData = $this->Constant_model->getDataTwoColumn('inventory', 'product_code', $code, 'outlet_id', $outlet_id);
                            if (count($invQtyData) > 0) {
                                $invQty = $invQtyData[0]->qty;
                            }

                            echo $invQty; ?>
						</div>
					</div>
					<?php	
                        }
                    ?>
					
				</div>
			</div>
			
			<a href="<?=base_url()?>products/list_products" style="text-decoration: none;">
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