<?php 
	if (get_session('M_ID') == '')
        redirect('login', 'refresh');
    else {
        $row = $this->common_model->get_where_custom('admin', 'M_Username', $this->db->escape_str(get_session('M_Username')));
        if (count($row) <= 0) redirect('login', 'refresh');
    }

    // $product = rowArray($this->common_model->get_where_custom('product', 'P_ID', $P_ID));
    // $product_stock = rowArray($this->common_model->custom_query(
    // 	" SELECT * FROM product_stock WHERE P_ID = '$P_ID' ORDER BY PS_DateTimeUpdate DESC LIMIT 1 "
    // )); 

    $product = rowArray($this->common_model->custom_query(
    	" SELECT * FROM product LEFT JOIN product_stock USING (P_ID) WHERE P_ID = '$P_ID' ORDER BY PS_DateTimeUpdate DESC LIMIT 1 "
    )); 
?>
<!-- <script src="<?php echo base_url('assets/plugin/chosen/chosen.jquery.js'); ?>"></script> -->
<!-- <link rel="stylesheet" href="<?php echo base_url('assets/plugin/chosen/chosen.css'); ?>"> -->
<div class="various-grocery-lightbox">
	<div class="various-product-info">
		<label>ชื่อสินค้า: </label>
		<span id="P_Name"><?php if (isset($product['P_Name']) && $product['P_Name'] !== '') echo $product['P_Name']; ?></span>
	</div>
	<!-- <div class="various-select-option">
		<label>ขนาด/รูปทรง: </label>
		<select class="chosen-select" id="PSI_ID"> 
			<option value="" selected disabled>เลือกขนาด/รูปทรง</option> <?php
			$size = $this->common_model->custom_query(" SELECT * FROM product_size ORDER BY PSI_Order ASC "); 
			foreach ($size as $key => $value) { ?>
				<option value="<?php echo $value['PSI_ID']; ?>"><?php echo $value['PSI_Name'].' - '.$value['PSI_Note']; ?></option> <?php
			} ?>
		</select>
	</div> -->
	<!-- <div class="various-select-option">
		<label>สี: </label>
		<select class="chosen-select" id="PC_ID"> 
			<option value="" selected disabled>เลือกสี</option> <?php
			$color = $this->common_model->custom_query(" SELECT * FROM product_color ORDER BY PC_Order ASC "); 
			foreach ($color as $key => $value) { ?>
				<option value="<?php echo $value['PC_ID']; ?>"><?php echo $value['PC_Name']; ?></option> <?php
			} ?>
		</select>
	</div>  --> <?php
	if ($PS_Price_amount === 'amount') { ?>
		<div class="various-input-textbox">
			<label>จำนวน: </label>
			<input type="hidden" id="PS_FullSumPrice" placeholder="ราคา" min="0" value="<?php if (isset($product['PS_FullSumPrice']) && $product['PS_FullSumPrice'] !== '') echo $product['PS_FullSumPrice']; else echo 0; ?>">
			<input type="number" id="PS_Amount" placeholder="จำนวน" min="0" value="<?php if (isset($product['PS_Amount']) && $product['PS_Amount'] !== '') echo $product['PS_Amount']; else echo 0; ?>">
		</div> <?php
	} 
	else if ($PS_Price_amount === 'price') { ?>
		<div class="various-input-textbox">
			<label>ราคา: </label>
			<input type="number" id="PS_FullSumPrice" placeholder="ราคา" min="0" value="<?php if (isset($product['PS_FullSumPrice']) && $product['PS_FullSumPrice'] !== '') echo $product['PS_FullSumPrice']; else echo 0; ?>">
			<input type="hidden" id="PS_Amount" placeholder="จำนวน" min="0" value="<?php if (isset($product['PS_Amount']) && $product['PS_Amount'] !== '') echo $product['PS_Amount']; else echo 0; ?>">
		</div> 
		<?php
	} ?>
	<!-- <div class="various-product-info">
		<label>จำนวนรวมทั้งสิ้น: </label>
		<input type="number" id="PS_Amount_Total" value="<?php if (isset($product_stock['PS_Amount']) && $product_stock['PS_Amount'] !== '') echo $product_stock['PS_Amount']; else echo 0; ?>" readonly>
	</div>
	<div class="various-product-info">
		<label>ราคารวมทั้งสิ้น: </label>
		<input type="number" id="PS_FullSumPrice_Total" value="<?php if (isset($product_stock['PS_FullSumPrice']) && $product_stock['PS_FullSumPrice'] !== '') echo $product_stock['PS_FullSumPrice']; else echo 0; ?>" readonly>
	</div> -->
	<div class="various-input-submit">
		<label></label>
		<input type="submit" id="PS_Confirm_button" value="บันทึก">
		<input type="button" id="PS_Cancel_button" 	value="ยกเลิก">
	</div>
</div>
<script src="<?php echo base_url('assets/js/bower_components/jquery/dist/jquery.min.js'); ?>"></script>
<script type="text/javascript">
	// var PS_Price_amount = "<?php // echo $PS_Price_amount; ?>";

	$(document).ready(function() { 
		// $(".chosen-select").chosen({
		// 	no_results_text: "ไม่พบข้อมูลของ",
		// 	width: "300px"
		// });

		// if ($("P_Name").val() == "" || $("PS_Amount_Total").val() == "" || $("PS_FullSumPrice_Total").val() == "")
		// 	$("#PSI_ID").prop("disabled", true).trigger("chosen:updated");

		// $("#PC_ID").prop("disabled", true).trigger("chosen:updated");
		// $("#PSL_FullSumPrice").prop("disabled", true);
		// $("#PSL_Amount").prop("disabled", true);
		// $("#PS_Confirm_button").prop("disabled", true);
		// $("#PS_Confirm_button").css("cursor", "not-allowed");
		// $("#PS_Cancel_button").prop("disabled", true);

		// $("#PSI_ID").change(function() {
		// 	$("#PC_ID").prop("disabled", false).trigger("chosen:updated");
		// 	$("#PC_ID option").eq(0).prop("selected", true).trigger("chosen:updated");
		// });

		// $("#PC_ID").change(function() {
		// 	if (PS_Price_amount == "price") {
		// 		$("#PSL_FullSumPrice").prop("disabled", false);
		// 		$("#PSL_Amount").prop("disabled", true);
		// 	}
		// 	else if (PS_Price_amount == "amount") {
		// 		$("#PSL_FullSumPrice").prop("disabled", true);
		// 		$("#PSL_Amount").prop("disabled", false);
		// 	}
		// 	$("#PS_Confirm_button").prop("disabled", false);
		// 	$("#PS_Confirm_button").css("cursor", "pointer");
		// 	$("#PS_Cancel_button").prop("disabled", false);

		// 	var request = $.ajax({
	 //  			url: "<?php echo base_url('product/stock_get'); ?>",
		// 		method: "POST",
		// 		data: { 
		// 			P_ID 	: "<?php echo $P_ID; ?>",
		// 			PSI_ID 	: $("#PSI_ID").chosen().val(),
		// 			PC_ID	: $("#PC_ID").chosen().val()
		// 		}
		// 	});
		// 	request.done(function(msg) {
		// 		$("#PSL_FullSumPrice").val(JSON.parse(msg)['PSL_FullSumPrice']);
	 //  			$("#PSL_Amount").val(JSON.parse(msg)['PSL_Amount']);
		// 	});
		// 	request.fail(function(jqXHR, textStatus) {
	 //  			alert("Request failed: " + textStatus);
		// 	});
		// });

		// $("#PSL_FullSumPrice").keyup(function() {

		// });

		// $("#PSL_Amount").keyup(function() {

		// });

		$("#PS_Confirm_button").click(function() {
			if ($("#PS_FullSumPrice").val() <= 0 || $("#PS_FullSumPrice").val() == '' || $("#PS_FullSumPrice").val() == null)
				$("#PS_FullSumPrice").val(0);
			var request = $.ajax({
	  			url: "<?php echo base_url('product/stock_changed'); ?>",
				method: "POST",
				data: { 
					P_ID 			: "<?php echo $P_ID; ?>",
					PS_Price 		: $("#PS_FullSumPrice").val(),
					PS_Amount 		: $("#PS_Amount").val(),
					// PSL_Price 		: $("#PSL_FullSumPrice").val(),
					// PSL_Amount		: $("#PSL_Amount").val(),
					// PSI_ID 			: $("#PSI_ID").chosen().val(),
					// PC_ID			: $("#PC_ID").chosen().val(),
					// PS_Price_amount : PS_Price_amount
				}
			});
			request.done(function(msg) {
				// alert('Success');
	  			// $.fancybox.close();
	  			location.reload();
			});
			request.fail(function(jqXHR, textStatus) {
	  			alert("Request failed: " + textStatus);
			});
		});

		$("#PS_Cancel_button").click(function() {
			// $.fancybox.close();
			location.reload();
		});
	});
</script>