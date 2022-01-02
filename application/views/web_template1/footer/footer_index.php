<?php $site = $this->webinfo_model->getOnceWebMain(); ?>

<div class="head">
	<div class="head_main">
		<div class="left">
			<div class="left_img">
				<img src="<?php echo base_url('assets/images/bus21.png'); ?>" title="Free Shipping">
			</div>
			<div class="left_text">
				<div class="left_text_head"><span>จัดส่งฟรี</span></div>
				<div class="left_text_cont"><span><!-- Lorem ipsum dolor sit amet --></span></div>
			</div>
		</div>
		<div class="right">
			<div class="right_main">
				<div class="right_head">
					<span>สมัครรับข่าวสาร</span>
				</div>
				<div class="right_email">
					<input type='email' id="subscribeEmail" title='อีเมล์' placeholder="อีเมล">
				</div>
				<div class="right_subsr">
					<input type='button' id="subscribeBtn" title="สมัครสมาชิก" value='สมัครรับข่าวสาร'>
				</div>
			</div>
		</div>
	</div>
</div>
<script type="text/javascript">
	function validateEmail(sEmail) {
		var filter = /^[\w\-\.\+]+\@[a-zA-Z0-9\.\-]+\.[a-zA-z0-9]{2,4}$/;
		if (filter.test(sEmail))
			return true;
		else
			return false;
	}

	$(document).ready(function() {
		$('#subscribeBtn').click(function() {
			var sEmail = $('#subscribeEmail').val();
			if ($.trim(sEmail).length === 0) {
				alert('กรุณากรอกอีเมล');
				e.preventDefault();
			}
			if (validateEmail(sEmail))
				alert('คุณได้สมัครรับจดหมายข่าวแล้ว');
			else {
				alert('รูปแบบอีเมลไม่ถูกต้อง');
				e.preventDefault();
			}
		});	
	});
</script>