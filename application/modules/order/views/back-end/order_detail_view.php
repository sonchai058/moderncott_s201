<?php 
	$frst_val = 0;
	$prev_val = 0;
	$next_val = 0;
	$last_val = 0;

	$orders = $this->common_model->custom_query(
		" 	SELECT * FROM `order` 
			WHERE `OD_ID` = $OD_ID AND `OD_Allow` != '3' 
			LIMIT 1 "
	);
	$lists = $this->common_model->custom_query(
		" 	SELECT * FROM `order_list` 
			LEFT JOIN `product` ON `order_list`.`P_ID` = `product`.`P_ID` 
			WHERE `OD_ID` = $OD_ID AND `ODL_Allow` = '1' 
			ORDER BY `ODL_DateTimeUpdate` ASC, `ODL_ID` ASC "
	);
	$sums = $this->common_model->custom_query(
		" 	SELECT 
			SUM(`ODL_Amount`) AS ODL_Amount, 
			SUM(`ODL_Price`) AS ODL_Price, 
			SUM(`ODL_SumPrice`) AS ODL_SumPrice, 
			SUM(`ODL_FullSumPrice`) AS ODL_FullSumPrice 
			FROM `order_list` 
			WHERE `OD_ID` = $OD_ID AND `ODL_Allow` = '1' "
	);
	$address = $this->common_model->custom_query(
		" 	SELECT * FROM `order_address`
			LEFT JOIN `districts` 		ON `order_address`.`District_ID` 	= `districts`.`District_ID`
			LEFT JOIN `amphures` 		ON `order_address`.`Amphur_ID` 		= `amphures`.`Amphur_ID`
			LEFT JOIN `provinces` 		ON `order_address`.`Province_ID` 	= `provinces`.`Province_ID` 
			WHERE `OD_ID` = $OD_ID AND OD_Allow = '1' 
			LIMIT 1 "
	);

	$frsts = $this->common_model->custom_query(
		" 	SELECT OD_ID FROM `order` WHERE `OD_ID` = (SELECT MIN(`OD_ID`) FROM `order` WHERE `OD_Allow` != '3') "
	);
	$prevs = $this->common_model->custom_query(
		" 	SELECT OD_ID FROM `order` WHERE `OD_ID` = (SELECT MAX(`OD_ID`) FROM `order` WHERE `OD_ID` < $OD_ID) AND `OD_Allow` = '1' "
	);
	$nexts = $this->common_model->custom_query(
		" 	SELECT OD_ID FROM `order` WHERE `OD_ID` = (SELECT MIN(`OD_ID`) FROM `order` WHERE `OD_ID` > $OD_ID) AND `OD_Allow` = '1' "
	);
	$lasts = $this->common_model->custom_query(
		" 	SELECT OD_ID FROM `order` WHERE `OD_ID` = (SELECT MAX(`OD_ID`) FROM `order` WHERE `OD_Allow` != '3') "
	);

	if (count($frsts) > 0) { 
		$frst_row = rowArray($frsts); 
		$frst_val = $frst_row['OD_ID'];
	}
	if (count($prevs) > 0) { 
		$prev_row = rowArray($prevs); 
		$prev_val = $prev_row['OD_ID'];
	}
	if (count($nexts) > 0) { 
		$next_row = rowArray($nexts); 
		$next_val = $next_row['OD_ID'];
	}
	if (count($lasts) > 0) { 
		$last_row = rowArray($lasts); 
		$last_val = $last_row['OD_ID'];
	}

	if (count($orders) > 0  && count($lists) > 0 && count($sums) > 0 && count($address) > 0) { ?>
		<div id="order_detail">
			<div class="pDiv">
				<div class="form-button-box">
					<input type="button" value="กลับไปยังรายการ" class="cancel-button">
				</div>
				<div class="form-button-box"> <?php
					if (count($frsts) > 0 && $OD_ID !== $frst_val) { ?>
						<input type="button" value="<< First" class="first-button"> <?php
					}
					if (count($prevs) > 0) { ?>
						<input type="button" value=" < Prev " class="previous-button"> <?php
					} 
					if (count($nexts) > 0) { ?>
						<input type="button" value=" Next > " class="next-button"> <?php
					} 
					if (count($lasts) > 0 && $OD_ID !== $last_val) { ?>
						<input type="button" value="Last  >>" class="last-button"> <?php
					} ?>
				</div>
				<div class="form-button-box">
					<button class="print-button"><i class="fa fa-print"></i> PDF</button>
				</div>
			</div>
			<div class="mDiv">
				<div class="ftitle">ข้อมูลการซื้อขาย / สั่งซื้อ</div>
			</div>
			<div class="main-table-box">
				<div class="form-div"> <?php
					$OD_Status = array(
						'1' => 'ปกติ',
						'2' => 'Pre-order'
					);
					$OD_Allow = array(
						'1'  => 'ปกติ',
						'2'  => 'ระงับ',
						'3'  => 'ลบ / บล๊อค',
						'4'  => 'รอตรวจสอบ',
						'5'  => 'ยืนยันแล้ว',
						'6'  => 'รอโอนเงิน',
						'7'  => 'โอนเงินแล้ว',
						'8'  => 'รอส่งสินค้า',
						'9'  => 'ส่งสินค้าแล้ว',
						'10' => 'ได้รับสินค้าแล้ว'
					);
					foreach ($orders as $key => $value) { ?>
						<div class="form-field-box odd">
							<div class="form-header-box">รหัสใบสั่งซื้อ: </div>
							<div class="form-display-box"><?php echo $value['OD_Code']; ?></div>
						</div>
						<div class="form-field-box even">
							<div class="form-header-box">รหัส EMS: </div>
							<div class="form-display-box"><?php echo $value['OD_EmsCode']; ?></div>
						</div>
						<div class="form-field-box odd">
							<div class="form-header-box">ราคารวม: </div>
							<div class="form-display-box">฿<?php echo number_format($value['OD_SumPrice'], 2); ?></div>
						</div>
						<div class="form-field-box even">
							<div class="form-header-box">ราคาเต็มแบบไม่คิดส่วนลด: </div>
							<div class="form-display-box">฿<?php echo number_format($value['OD_FullSumPrice'], 2); ?></div>
						</div>
						<div class="form-field-box odd">
							<div class="form-header-box">การซื้อขาย / สั่งซื้อ: </div>
							<div class="form-display-box"><?php echo $OD_Status[$value['OD_Status']]; ?></div>
						</div>
						<div class="form-field-box even">
							<div class="form-header-box">สถานะ: </div>
							<div class="form-display-box"><?php echo $OD_Allow[$value['OD_Allow']]; ?></div>
						</div> <?php
					} ?>
				</div>
			</div>
			<div class="mDiv">
				<div class="ftitle">รายละเอียดการซื้อขาย / สั่งซื้อ</div>
			</div>
			<div class="main-table-box">
				<div class="bDiv">
					<table cellspacing="0" cellpadding="0" border="0">
						<thead>
							<tr class="hDiv">
								<th><div class="text-center">สินค้า</div></th>
								<th><div class="text-center">รายละเอียด / หมายเหตุ</div></th>
								<th><div class="text-center">จำนวน</div></th>
								<th><div class="text-center">ราคา</div></th>
								<th><div class="text-center">ราคารวม</div></th>
								<th><div class="text-center">ราคาสุทธิ</div></th>
							</tr>
						</thead>
						<tbody> <?php
							$erow = 1; 
							foreach ($lists as $key => $value) { ?>
								<tr <?php if ($erow %2 === 0) { ?> class="erow" <?php } ?>>
									<td><div class="text-left"><?php echo $value['P_Name'].' ('.$value['P_IDCode'].')'; ?></div></td>
									<td><div class="text-left"><?php echo $value['ODL_Descript']; ?></div></td>
									<td><div class="text-right"><?php echo $value['ODL_Amount']; ?></div></td>
									<td><div class="text-right">฿<?php echo number_format($value['ODL_Price'], 2); ?></div></td>
									<td><div class="text-right">฿<?php echo number_format($value['ODL_SumPrice'], 2); ?></div></td>
									<td><div class="text-right">฿<?php echo number_format($value['ODL_FullSumPrice'], 2); ?></div></td>
								</tr> <?php
								$erow += 1; 
							} ?>
						</tbody>
						<tfoot> <?php
							foreach ($sums as $key => $value) { ?>
								<tr class="hDiv">
									<th><div class="text-left">รวมทั้งหมด</div></th>
									<th><div class="text-left"></div></th>
									<th><div class="text-right"><?php echo $value['ODL_Amount']; ?></div></th>
									<th><div class="text-right">฿<?php echo number_format($value['ODL_Price'], 2); ?></div></th>
									<th><div class="text-right">฿<?php echo number_format($value['ODL_SumPrice'], 2); ?></div></th>
									<th><div class="text-right">฿<?php echo number_format($value['ODL_FullSumPrice'], 2); ?></div></th>
								</tr> <?php 
							} ?>
						</tfoot>
					</table>
				</div>
			</div>
			<div class="mDiv">
				<div class="ftitle">ข้อมูลติดต่อ และที่อยู่ในการจัดส่ง</div>
			</div>
			<div class="main-table-box">
				<div class="form-div"> <?php
					foreach ($address as $key => $value) { ?>
						<div class="form-field-box odd">
							<div class="form-header-box">ชื่อ - นามสกุล: </div>
							<div class="form-display-box"><?php echo $value['OD_Name']; ?></div>
						</div>
						<div class="form-field-box even">
							<div class="form-header-box">โทรศัพท์: </div>
							<div class="form-display-box"><?php echo $value['OD_Tel']; ?></div>
						</div>
						<div class="form-field-box odd">
							<div class="form-header-box">อีเมล: </div>
							<div class="form-display-box"><?php echo $value['OD_Email']; ?></div>
						</div>
						<div class="form-field-box even">
							<div class="form-header-box">เลขที่ / ห้อง: </div>
							<div class="form-display-box"><?php echo $value['OD_hrNumber']; ?></div>
						</div>
						<div class="form-field-box odd">
							<div class="form-header-box">หมู่บ้าน / อาคาร / คอนโด: </div>
							<div class="form-display-box"><?php echo $value['OD_VilBuild']; ?></div>
						</div>
						<div class="form-field-box even">
							<div class="form-header-box">หมู่ที่: </div>
							<div class="form-display-box"><?php echo $value['OD_VilNo']; ?></div>
						</div>
						<div class="form-field-box odd">
							<div class="form-header-box">ตรอก / ซอย: </div>
							<div class="form-display-box"><?php echo $value['OD_LaneRoad']; ?></div>
						</div>
						<div class="form-field-box even">
							<div class="form-header-box">ถนน: </div>
							<div class="form-display-box"><?php echo $value['OD_Street']; ?></div>
						</div>
						<div class="form-field-box odd">
							<div class="form-header-box">แขวง / ตำบล: </div>
							<div class="form-display-box"><?php echo $value['District_Name']; ?></div>
						</div>
						<div class="form-field-box even">
							<div class="form-header-box">เขต / อำเภอ: </div>
							<div class="form-display-box"><?php echo $value['Amphur_Name']; ?></div>
						</div>
						<div class="form-field-box odd">
							<div class="form-header-box">จังหวัด: </div>
							<div class="form-display-box"><?php echo $value['Province_Name']; ?></div>
						</div>
						<div class="form-field-box even">
							<div class="form-header-box">รหัสไปรษณีย์: </div>
							<div class="form-display-box"><?php echo $value['Zipcode_Code']; ?></div>
						</div> <?php
					} ?>
				</div>
			</div>
			<div class="pDiv">
				<div class="form-button-box">
					<input type="button" value="กลับไปยังรายการ" class="cancel-button">
				</div>
				<div class="form-button-box"> <?php
					if (count($frsts) > 0) { ?>
						<input type="button" value="<< First" class="first-button"> <?php
					}
					if (count($prevs) > 0) { ?>
						<input type="button" value=" < Prev " class="previous-button"> <?php
					} 
					if (count($nexts) > 0) { ?>
						<input type="button" value=" Next > " class="next-button"> <?php
					} 
					if (count($lasts) > 0) { ?>
						<input type="button" value="Last  >>" class="last-button"> <?php
					} ?>
				</div>
				<div class="form-button-box">
					<button class="print-button"><i class="fa fa-print"></i> PDF</button>
				</div>
			</div>
		</div> <?php
	} 
?>
<script>
	$( document ).ready(function() {
  		$(".cancel-button").click(function() {
  			$(location).prop("href", "<?php echo base_url('order/order_management'); ?>");
  		});
  		$(".first-button").click(function() {
  			$(location).prop("href", "<?php echo base_url('order/order_read/'.$frst_val); ?>");
  		});
  		$(".previous-button").click(function() {
  			$(location).prop("href", "<?php echo base_url('order/order_read/'.$prev_val); ?>");
  		});
  		$(".next-button").click(function() {
  			$(location).prop("href", "<?php echo base_url('order/order_read/'.$next_val); ?>");
  		});
  		$(".last-button").click(function() {
  			$(location).prop("href", "<?php echo base_url('order/order_read/'.$last_val); ?>");
  		});
  		$(".print-button").click(function() {
  			window.open("<?php echo base_url('order/order_print/'.$OD_ID); ?>", "_blank");
  		});
	});
</script>