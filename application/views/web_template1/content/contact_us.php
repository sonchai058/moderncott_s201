<?php $site = $this->webinfo_model->getOnceWebMain(); ?>
<div class="contact_us">
	<div class="contact_us_head">
		<h1>ติดต่อเรา</h1>
	</div>
	<div class="contact_map">
		<div id="map"></div>
	</div>
	<div class="contact_address">
		<div class="contact_address_head">
			<h1>ที่อยู่</h1>
		</div>
		<div class="contact_address_main">
			<address>
				<p><?php echo $site['WD_Address']; ?></p>
				<p><?php echo 'โทรศัพท์: '.$site['WD_Tel']; ?></p>
				<p><?php echo 'โทรสาร: '.$site['WD_Fax']; ?></p> 
				<p><?php if (isset($site['WD_Email']) && $site['WD_Email'] !== '') { ?>อีเมล: <a href="mailto:<?php echo $site['WD_Email']; ?>"><?php echo $site['WD_Email']; ?></a><?php } ?></p>
			</address>
		</div>
	</div>
	<div class="contact_find_us">
		<div class="contact_find_us_head">
			<h1>พบกับเราได้ที่</h1>
		</div>
		<div class="contact_find_us_main"> <?php
			echo form_open('main/contact_send', array('id' => 'contact_send')); ?>
				<table>
					<tr>
						<td><?php echo form_input(array('type' => 'text',	'class' => 'input-contact',	'id' => 'name', 	'name' => 'send[CU_Name]', 		'placeholder' => 'ชื่อ-นามสกุล',	'required' => 'required')); ?></td>
						<td><?php echo form_input(array('type' => 'email', 	'class' => 'input-contact',	'id' => 'email', 	'name' => 'send[CU_Email]', 	'placeholder' => 'อีเมล', 		'required' => 'required')); ?></td>
					</tr>
					<tr>
						<td><?php echo form_input(array('type' => 'text', 	'class' => 'input-contact',	'id' => 'phone', 	'name' => 'send[CU_Phone]', 	'placeholder' => 'โทรศัพท์', 		'required' => 'required')); ?></td>
						<td><?php echo form_input(array('type' => 'text', 	'class' => 'input-contact',	'id' => 'subject', 	'name' => 'send[CU_Subject]',	'placeholder' => 'หัวข้อ', 		'required' => 'required')); ?></td>
					</tr>
					<tr>
						<td colspan="2"><?php echo form_textarea(array(		'class' => 'input-contact',	'id' => 'descrip', 	'name' => 'send[CU_Descipt]', 	'placeholder' => 'ข้อความ...', 	'required' => 'required')); ?></td>
					</tr>
					<tr>
						<td colspan="2"><?php echo form_input(array('type' => 'submit',	'id' => 'send', 	'name' => 'send', 				'value' => 'ส่งข้อความ')); ?></td>
					</tr>
				</table> <?php
			echo form_close(); ?>
		</div>
	</div>
</div>
<script type="text/javascript">
	var zoom = 10;

	function initMap() {
		var latLng = {
			lat: parseFloat("<?php echo $site['WD_Latitude']; ?>"), 
			lng: parseFloat("<?php echo $site['WD_Longjitude']; ?>")
		};

  		var map = new google.maps.Map(document.getElementById('map'), {
    		center: latLng,
    		zoom: zoom
  		});

  		var iconBase = "<?php echo base_url('assets/images/marker.png'); ?>";

  		var marker = new google.maps.Marker({
  			position: latLng, 
  			map: map,
  			title: "<?php echo $site['WD_Name']; ?>",
  			icon: iconBase,
  			animation: google.maps.Animation.DROP
		});
	}

	function validateEmail(sEmail) {
		var filter = /^[\w\-\.\+]+\@[a-zA-Z0-9\.\-]+\.[a-zA-z0-9]{2,4}$/;
		if (filter.test(sEmail))
			return true;
		else
			return false;
	}

	$(document).ready(function() {
		if ($(".wrap_content").height() > 1200)
			var wrap_content_height = 0;
		else
			var wrap_content_height = 160;
		// $('html, body').animate({
  //   		scrollTop: $(".wrap_content").offset().top - ($(".wrap_content").height() + wrap_content_height)
		// }, 1000);

		$("#contact_send").submit(function() {
			var value 	= $('#contact_send').serialize();
			var url 	= $('#contact_send').prop('action');
			var request = $.ajax({
	  			url 	: $('#contact_send').prop('action'),
				method	: 'POST',
				data	: value
			});
			request.done(function(msg) {
				$('.input-contact').val('');
				alert(msg);
			});
			request.fail(function(jqXHR, textStatus) {
	  			// alert('Request failed: ' + textStatus);
			});
			return false;
		});
	});
</script>
<script src="https://maps.googleapis.com/maps/api/js?callback=initMap" async defer></script>