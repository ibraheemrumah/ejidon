<?php
    $user_id = $this->session->userdata('user_id');
    $user_em = $this->session->userdata('user_email');
    $user_role = $this->session->userdata('user_role');
    $user_outlet = $this->session->userdata('user_outlet');

    if (empty($user_id)) {
        redirect(base_url(), 'refresh');
    }

    $tk_c = $this->router->class;
    $tk_m = $this->router->method;

    $alert_msg = $this->session->flashdata('alert_msg');

    $settingResult = $this->db->get_where('site_setting');
    $settingData = $settingResult->row();

    $setting_site_name = $settingData->site_name;
    $setting_pagination = $settingData->pagination;
    $setting_tax = $settingData->tax;
    $setting_currency = $settingData->currency;
    $setting_date = $settingData->datetime_format;
    $setting_product = $settingData->display_product;
    $setting_keyboard = $settingData->display_keyboard;
    $setting_customer_id = $settingData->default_customer_id;

    if (isset($_COOKIE['outlet'])) {
        $this->load->helper('cookie');
        delete_cookie('outlet');
    }

    $login_name = '';
    $this->db->where('id', $user_id);
    $query = $this->db->get('users');
    $result = $query->result();

    $login_name = $result[0]->fullname;
?>

<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1" />
		<title><?php echo $setting_site_name; ?></title>

		<link href="<?=base_url()?>assets/css/bootstrap.min.css" rel="stylesheet">
		<link href="<?=base_url()?>assets/css/maxcd/bootstrap.min.js" rel="stylesheet">
		<link href="<?=base_url()?>assets/css/datepicker3.css" rel="stylesheet">
		<link href="<?=base_url()?>assets/css/styles.css" rel="stylesheet">
		
		<link href="<?=base_url()?>assets/css/icono.min.css" rel="stylesheet">
		
		<!--[if lt IE 9]>
		<script src="<?=base_url()?>assets/js/html5shiv.js"></script>
		<script src="<?=base_url()?>assets/js/respond.min.js"></script>
		<![endif]-->
		
		<script src="<?=base_url()?>assets/js/jquery.min.js"></script>
		
		<script type="text/javascript">
			$(document).ready(function(){
			    $("#closeAlert").click(function(){
			        $("#notificationWrp").fadeToggle(1000);
			    });
			});
		</script>
	</head>
	<style>

 
@media print {
	#sidebar-collapse {
    display: none;
  }
  #example_filter{
	display: none;
  }
  #hide{
	  display: none;
	  }
	  .nav{
		display: none; 
	  }
	  .menu{
		display: none;
	  }


</style>

<body>
	<nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
		<div class="container-fluid">
			<div class="navbar-header">
				<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#sidebar-collapse">
					<span class="sr-only">Toggle navigation</span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				</button>
				<a class="navbar-brand" href="<?=base_url()?>dashboard">
					<?php echo $setting_site_name; ?>
				</a>
				<ul class="user-menu">
					<li class="dropdown pull-right">
						<a href="#" class="dropdown-toggle" data-toggle="dropdown"><svg class="glyph stroked male-user"><use xlink:href="#stroked-male-user"></use></svg> <?php echo $login_name; ?> <span class="caret"></span></a>
						<ul class="dropdown-menu" role="menu">
							<li><a href="<?=base_url()?>auth/logout"><i class="icono-power" style="color: #30a5ff;"></i> <?php echo $lang_logout; ?></a></li>
						</ul>
					</li>
				</ul>
				<ul class="user-menu">
					<li class="dropdown pull-right">
						
						<ul class="dropdown-menu" role="menu">
							<li>
								<a href="<?=base_url()?>" style="text-decoration: none; color: #00598c;">
									<img src="<?=base_url()?>" /> 
								</a>
							</li>
							<li>
								<a href="<?=base_url()?>" style="text-decoration: none; color: #00598c;">
									<img src="<?=base_url()?>" /> 
								</a>
							</li>
						</ul>
					</li>
				</ul>
			</div>
		</div><!-- /.container-fluid -->
		
	</nav>
	
	