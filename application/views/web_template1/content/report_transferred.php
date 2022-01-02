<?php 
	$banks = $this->common_model->getTable('bank');
    if (count($banks) > 0) {
    	$bank = array();
        foreach ($banks as $key => $value) {
            $bank[$value['B_ID']] = $value['B_Name'];
        }
    }
	$payment = array(
		'1' => 'โอนเงินผ่านธนาคาร', 
		'2' => 'ชำระเงินผ่านบัตรเครดิต', 
		'3' => 'ชำระผ่านเคาน์เตอร์เซอร์วิส',
		'4' => 'อื่นๆ'
	);
?>
<div class="report_transferred">
	<div class="report_transferred_header"><h1>แจ้งการโอนเงิน</h1></div>
	<div class="report_transferred_search">
		<div class="report_transferred_order_no">
			<label>รหัสใบสั่งซื้อ<span>*</span>:</label>
			<?php echo form_input(array('id' => 'OD_Code', 'placeholder' => 'รหัสใบสั่งซื้อ')); ?>
		</div>
		<div class="report_transferred_confirm">
			<label></label>
			<?php echo form_button(array('id' => 'OT_Search', 'content' => 'ค้นหา <i class="fa fa-search"></i>')); ?>
		</div>
	</div>
	<div class="report_transferred_form">
		<div class="report_transferred_warn">*กรุณากรอกหลักฐานการโอนเงินให้ถูกต้อง</div><?php 
		echo form_open_multipart('order/order_transfer_submit',"id='report_transferred_form' autocomplete='off'"); ?>
			<div class="report_transferred_order_no">
				<?php echo form_input(array('type' => 'hidden', 'name' => 'OD_ID', 'id' => 'OD_ID')); ?>
			</div>
			<div class="report_transferred_bank">
				<label>ชื่อธนาคาร<span>*</span>:</label>
				<?php echo form_dropdown('B_ID', $bank, '', 'id="B_ID"'); ?>
			</div>
			<div class="report_transferred_payment">
				<label>ช่องทางชำระเงิน<span>*</span>:</label>
				<?php echo form_dropdown('OT_Payment', $payment, '', 'id="OT_Payment"'); ?>
			</div>
			<div class="report_transferred_date">
				<label>วันที่<span>*</span>:</label>
				<?php echo form_input(array('name' => 'OT_DateAdd', 'id' => 'datepicker', 'placeholder' => 'วันที่', 'value' => date('d').'/'.date('m').'/'.(date('Y') + 543))); ?>
			</div>
			<div class="report_transferred_time">
				<label>เวลา<span>*</span>:</label>
				<?php echo form_input(array('type' => 'number', 'name' => 'OT_HourAdd',		'id' => 'OT_HourAdd', 	'placeholder' => '00', 'min' => '0', 'max' => '23', 'value' => date('H'))); ?>
				<?php echo form_input(array('type' => 'number', 'name' => 'OT_MinuteAdd', 	'id' => 'OT_MinuteAdd',	'placeholder' => '00', 'min' => '0', 'max' => '59', 'value' => date('i'))); ?>
			</div>
			<div class="report_transferred_amount">
				<label>จำนวนเงิน<span>*</span>:</label>
				<?php echo form_input(array('type' => 'number', 'name' => 'OT_Price', 		'id' => 'OT_Price', 	'placeholder' => 'จำนวนเงิน', 'min' => '0')); ?>
			</div>
			<!-- <div class="report_transferred_file">
				<label>ภาพหลักฐานการโอนเงิน:</label>
				<?php echo form_input(array('type' => 'file', 	'name' => 'userfile', 		'id' => 'OT_ImgAttach', 'class' => 'custom-file-input', 'size' => '20')); ?>
			</div>
			<div class="report_transferred_image">
				<label></label>
				<img id="OT_ImgPreview" style="display:none">
			</div> -->
			<div class="report_transferred_confirm">
				<label></label>
				<?php echo form_button(array('id' => 'OT_Submit', 'content' => 'ยืนยัน <i class="fa fa-check"></i>')); ?>
				<?php echo form_button(array('id' => 'OT_cancel', 'content' => 'ยกเลิก <i class="fa fa-ban"></i>')); ?>
			</div> <?php
		echo form_close(); ?>
	</div>
</div>
<script type="text/javascript">
	function readURL(input) {
	    if (input.files && input.files[0]) {
	        var reader = new FileReader();
	        reader.onload = function(e) {
	        	$('#OT_ImgPreview').hide();
	        	$('#OT_ImgPreview').fadeIn('slow', function() {
	        		$('#OT_ImgPreview').show();
	        	});
	            $('#OT_ImgPreview').prop('src', e.target.result);
	        }
	        reader.readAsDataURL(input.files[0]);
	    }
	}

	$(function() {
		$(".report_transferred_form").hide();

		$('#OT_Search').click(function() {
			if ($('#OD_Code').val() !== '') {
				var request = $.ajax({
	  				url 	: "<?php echo base_url('order/search_order_code'); ?>",
	  				method 	: "POST",
	  				data 	: { OD_Code : $("#OD_Code").val() }
				});
				request.done(function(msg) {
					if (msg !== '') {
						$(".report_transferred_form").hide();
	  					$(".report_transferred_form").slideDown("fast", function() {
	  						$(".report_transferred_form").show();
	  					});
	  					$("#OD_ID").val(msg);
	  				}
	  				else {
	  					alert("ไม่พบรหัสใบสั่งซื้อที่ท่านค้นหา");
	  					$("#OT_cancel").click();
	  				}
				});
				request.fail(function(jqXHR, textStatus) {
	  				// alert("Request failed: " + textStatus);
				});
			}
			else {
				$(".report_transferred_form").slideUp("fast", function() {
					$(".report_transferred_form").hide();
				});
			}
		});

    	var d = new Date();
    	var toDay = d.getDate() + '/' + (d.getMonth() + 1) + '/' + (d.getFullYear() + 543);
    	$('#datepicker').datepicker({
    		altField: '#datepicker',
    		dateFormat: 'dd/mm/yy', 
      		isBuddhist: true, 
      		changeMonth: true, 
      		changeYear: true,
      		gotoCurrent: true,
      		defaultDate: toDay, 
      		dayNames: ['อาทิตย์', 'จันทร์', 'อังคาร', 'พุธ', 'พฤหัสบดี', 'ศุกร์', 'เสาร์'],
      		dayNamesMin: ['อา.','จ.','อ.','พ.','พฤ.','ศ.','ส.'],
      		monthNames: ['มกราคม','กุมภาพันธ์','มีนาคม','เมษายน','พฤษภาคม','มิถุนายน','กรกฎาคม','สิงหาคม','กันยายน','ตุลาคม','พฤศจิกายน','ธันวาคม'],
      		monthNamesShort: ['ม.ค.','ก.พ.','มี.ค.','เม.ย.','พ.ค.','มิ.ย.','ก.ค.','ส.ค.','ก.ย.','ต.ค.','พ.ย.','ธ.ค.'],
    		autoSize: true,
    		// showOn: 'button',
      		// buttonImage: "<?php base_url('assets/plugin/datepicker/images/x_office_calendar.png'); ?>",
      		// buttonImageOnly: true,
      		// buttonText: 'Select date'
    	});

    	$('#datepicker').keyup(function() {
    		$(this).val('');
    	});

    	$('#OT_HourAdd').focusout(function() {
    		if ($(this).val() > 23)	$(this).val(23);
    		if ($(this).val() < 0)	$(this).val(0);
    	});

    	$('#OT_MinuteAdd').focusout(function() {
    		if ($(this).val() > 59) $(this).val(59);
    		if ($(this).val() < 0) 	$(this).val(0);
    	});

    	$('#OT_Price').focusout(function() {
    		if ($(this).val() < 0) $(this).val(0);
    	});

    	$('#OT_Submit').click(function() {
    		if ($("#OD_Code").val() == '' || $('#datepicker').val() == '' || $('#OT_HourAdd').val() == '' || $('#OT_MinuteAdd').val() == '' || $('#OT_Price').val() == '') {
    			alert('กรุณากรอกข้อมูลให้ครบถ้วน');
    		}
    		else {
    			if ($('#OT_HourAdd').val() 		> 23)	$('#OT_HourAdd').val(23);
	    		if ($('#OT_HourAdd').val() 		< 0)	$('#OT_HourAdd').val(0);
	    		if ($('#OT_MinuteAdd').val() 	> 59)	$('#OT_MinuteAdd').val(59);
	    		if ($('#OT_MinuteAdd').val() 	< 0)	$('#OT_MinuteAdd').val(0);
    			alert('บันทึกหลักฐานการโอนเงินเรียบร้อยแล้ว');
    			$('#report_transferred_form').submit();
    		}
    	});

    	// $('#submit').click(function() {
    	// 	if ($('#datepicker').val() == '' || $('#OT_HourAdd').val() == '' || $('#OT_MinuteAdd').val() == '' || $('#OT_Price').val() == '') {
    	// 		alert('กรุณากรอกข้อมูลให้ครบถ้วน');
    	// 		return false;
    	// 	}
    	// 	else {
    	// 		if ($('#OT_HourAdd').val() 		> 23)	$('#OT_HourAdd').val(23);
	    // 		if ($('#OT_HourAdd').val() 		< 0)	$('#OT_HourAdd').val(0);
	    // 		if ($('#OT_MinuteAdd').val() 	> 59)	$('#OT_MinuteAdd').val(59);
	    // 		if ($('#OT_MinuteAdd').val() 	< 0)	$('#OT_MinuteAdd').val(0);
    	// 		alert('บันทึกหลักฐานการโอนเงินเรียบร้อยแล้ว');
    	// 	}
    	// });

    	$('#OT_cancel').click(function() {
    		$('#OD_Code').val('');
    		$('#OD_ID').val('');
    		$('#B_ID option:eq(0)').prop('selected', true);
    		$('#OT_Payment option:eq(0)').prop('selected', true);
    		$('#OT_Price').val('');
    		$('#OT_ImgPreview').prop('src', '');
    		$('#OT_ImgPreview').css('display', 'none');
    		$('.report_transferred_form').slideUp('fast', function() {
				$('.report_transferred_form').hide();
			});
    	});

    	$('#OT_ImgAttach').change(function(){
    		readURL(this);
		});
  	});
</script>