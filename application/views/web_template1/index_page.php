<!DOCTYPE html>
<html lang="en">
	<head>
		<?php $site = $this->webinfo_model->getOnceWebMain(); ?>

		<meta charset="utf-8">
		<!-- <meta name="viewport" content="width=device-width,initial-scale=1.0"> -->
		<meta name="viewport" content="user-scalable=yes">
        <meta name="description" content="<?php echo @$site['WD_Descrip']?>">
        <meta name="keywords" content="<?php echo @$site['WD_Keyword']?>">
        <meta name="author" content="<?php echo @$site['WD_Name']?>">
		
		<link rel="shortcut icon" href="<?php echo base_url('assets/images/'.@$site['WD_Icon']);?>" type="image/x-icon">
        <link rel="icon" href="<?php echo base_url('assets/images/'.@$site['WD_Icon']);?>" type="image/x-icon">

        <title><?php echo $site['WD_Name'].' ('.$title.')'; ?></title>

		<link rel="stylesheet" href="<?php echo base_url('assets/css/reset.css'); ?>">
		<link rel="stylesheet" href="<?php echo base_url('assets/css/main.css'); ?>">
		<link rel="stylesheet" href="<?php echo base_url('assets/css/jquery-ui.min.css'); ?>">

		<script src="<?php echo base_url('assets/js/bower_components/jquery/dist/jquery.min.js'); ?>"></script>
		<script src="<?php echo base_url('assets/js/jquery-ui.min.js'); ?>"></script>
		<link rel="stylesheet" href="<?php echo base_url('assets/js/bower_components/font-awesome/css/font-awesome.min.css'); ?>">

		<script type="text/javascript" src="<?php echo base_url('assets/plugin/fancyapps/source/jquery.fancybox.js'); ?>"></script>
		<link rel="stylesheet" href="<?php echo base_url('assets/plugin/fancyapps/source/jquery.fancybox.css'); ?>" type="text/css" media="screen">

		<?php 
			if ($content_view === 'content/main') { ?>
				<script type="text/javascript" src="<?php echo base_url('assets/plugin/bxSlider/jquery.bxslider.js'); ?>"></script>
				<link rel="stylesheet" href="<?php echo base_url('assets/plugin/bxSlider/jquery.bxslider.css'); ?>"> <?php 
			} 
			if ($content_view === 'content/product_details' || $content_view === 'content/product_galleries') { ?>
				<script type="text/javascript" src="<?php echo base_url('assets/plugin/fancyapps/source/helpers/jquery.fancybox-thumbs.js'); ?>"></script>
				<link rel="stylesheet" href="<?php echo base_url('assets/plugin/fancyapps/source/helpers/jquery.fancybox-thumbs.css'); ?>" type="text/css" media="screen"> <?php 
			} 
		?>

		<!--
		<script type="text/javascript" src="<?php echo base_url('assets/plugin/chosen/chosen.jquery.js'); ?>"></script>
		<link rel="stylesheet" href="<?php echo base_url('assets/plugin/chosen/chosen.css'); ?>">
		-->
	</head>

	<body>
		<div id="fb-root"></div>
		<script>
			(function(d, s, id) {
	  			var js, fjs = d.getElementsByTagName(s)[0];
	  			if (d.getElementById(id)) 
	  				return;
	  			js = d.createElement(s); 
	  			js.id = id;
	  			js.src = "//connect.facebook.net/th_TH/sdk.js#xfbml=1&version=v2.5&appId=154375408056169";
	  			fjs.parentNode.insertBefore(js, fjs);
			}
			(document, 'script', 'facebook-jssdk'));
		</script>

		<?php $this->template->load('header/header_index'); ?>
		<div class="wrap_root">
			<?php 
				$this->template->load('header/header_sub'); 
				$this->template->load('header/header_menu'); 
				if ($content_view === '' || $content_view === 'content/main')
					$this->template->load('header/header_slide'); 
			?>
			<div class="wrap_content">
				<div class="left">
					<?php $this->template->load($content_view); ?>
				</div>
				<div class="right">
					<?php 
						$this->template->load('content/category'); 
						$this->template->load('content/login'); 
						$this->template->load('content/tracking'); 
					?>
				</div>
			</div>
			<!-- <div class="footer"> -->
				<?php 
					// $this->template->load('footer/footer_index');
					// $this->template->load('footer/footer_detail');
				?>
			<!-- </div> -->
		</div>
		<div class="wrap_foot">
			<div class="footer">
				<?php 
					$this->template->load('footer/footer_index');
					$this->template->load('footer/footer_detail');
				?>
			</div>
		</div>
	</body>

	<?php 
		if ($content_view === 'content/main') { ?>
			<script>
				$(document).ready(function(){
				  	$('.bxslider').bxSlider({
						auto: true,
						speed:500,
						autoDelay:100
				  	});
				  	// $('html, body').animate({
		        		// scrollTop: $(".wrap_content").offset().top
		    		// }, 1000);
				});
			</script> <?php
		} 
	?>
</html>