<?php 
	if (get_session('M_ID') == '')
        redirect('login', 'refresh');
    else {
        $row = $this->common_model->get_where_custom('admin', 'M_Username', $this->db->escape_str(get_session('M_Username')));
        if (count($row) <= 0) redirect('login', 'refresh');
    }

    $order = rowArray($this->common_model->get_where_custom('order', 'OD_ID', $this->db->escape_str($OD_ID)));
?>
<div class="various-grocery-lightbox">
	<div class="various-select-option">
		<label>สถานะ: </label>
		<select id="OD_Allow"> <?php
			$OD_Allow = array('1' => 'ปกติ', '2' => 'ระงับ', '3' => 'ลบ / บล็อค', '4' => 'รอตรวจสอบ', '5' => 'ยืนยันแล้ว', '6' => 'รอโอนเงิน', '7' => 'โอนเงินแล้ว', '8' => 'รอส่งสินค้า', '9' => 'ส่งสินค้าแล้ว', '10' => 'ได้รับสินค้าแล้ว');
			foreach ($OD_Allow as $key => $value) { ?>
				<option value="<?php echo $key; ?>" <?php if ($key === intval($order['OD_Allow'])) { ?> selected <?php } ?>><?php echo $value; ?></option> <?php 
			} ?>
		</select>
	</div>
	<div class="various-input-submit">
		<label></label>
		<input type="submit" id="OD_Confirm_button" value="บันทึก">
		<input type="button" id="OD_Cancel_button" 	value="ยกเลิก">
	</div>
</div>
<script src="<?php echo base_url('assets/js/bower_components/jquery/dist/jquery.min.js'); ?>"></script>
<script type="text/javascript">
	$(document).ready(function() { 
		$("#OD_Confirm_button").click(function() {
			var request = $.ajax({
	  			url: "<?php echo base_url('order/order_status_changed'); ?>",
				method: "POST",
				data: { 
					OD_ID 		: "<?php echo $OD_ID; ?>",
					OD_Allow 	: $("#OD_Allow").val(),
				}
			});
			request.done(function(msg) {
				location.reload();
			});
			request.fail(function(jqXHR, textStatus) {
	  			alert("Request failed: " + textStatus);
			});
		});

		$("#OD_Cancel_button").click(function() {
			location.reload();
		});
	});
</script>