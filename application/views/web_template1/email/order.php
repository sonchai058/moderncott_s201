<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title></title>
	<style>
		.email-order-list {
			width: 100%;
		}
		.po-code {
			color: #4078C0;
		}
		.po-status {
			color: #BD2C00;
		}
		th {
			background-color: #E6E6E6;
		}
	</style>
</head>
<body>
	<p>
		<table>
			<tr>
				<td>วันเวลาที่สั่งซื้อ: </td>
				<?php
					$day 	= date('d');
					$month 	= date('m');
					$year 	= date('Y') + 543;
					$hour 	= date('H');
					$minute = date('i');
					$second = date('s');
				?>
				<td><?php echo $day.'-'.$month.'-'.$year.' '.$hour.':'.$minute.':'.$second; ?></td>
			</tr>
			<tr>
				<td>รหัสใบสั่งซื้อ: </td>
				<td class="po-code"><?php echo $order['OD_Code']; ?></td>
			</tr>
			<tr>
				<td>สถานะใบสั่งซื้อ: </td>
				<td class="po-status"><?php echo $order['OD_Allow']; ?></td>
			</tr>
		</table>
	</p>
	<p>
		<b>ที่อยู่สำหรับจัดส่งสินค้า</b>
		<table>
			<tr>
				<td>ชื่อ-นามสกุล: </td>
				<td><?php echo $order_address['OD_Name']; ?></td>
			</tr>
			<tr>
				<td>ที่อยู่: </td>
				<td><?php echo $order_address['OD_Address']; ?></td>
			</tr>
			<tr>
				<td>เบอร์โทรศัพท์: </td>
				<td><?php echo $order_address['OD_Tel']; ?></td>
			</tr>
		</table>
	</p>
	<p>
		<b>รายการสินค้า</b>
		<table border="1" class="email-order-list">
			<thead>
				<tr>
					<th align="center">ลำดับที่</th>
					<th align="center">สินค้า</th>
					<th align="center">ราคา</th>
					<th align="center">จำนวน</th>
					<th align="center">ราคารวม</th>
				</tr>
			</thead>
			<tbody> <?php
				foreach ($order_list as $key => $value) { ?>
					<tr>
						<td align="center"><?php 	echo ($key + 1); ?></td>
						<td align="left"><?php 		echo $value['P_Name']; ?></td>
						<td align="center"><?php 	echo number_format($value['ODL_Price'], 			2, '.', ','); ?></td>
						<td align="center"><?php 	echo $value['ODL_Amount']; ?></td>
						<td align="right"><?php 	echo number_format($value['ODL_FullSumPrice'], 		2, '.', ','); ?></td>
					</tr> <?php
				} ?>
			</tbody>
			<tfoot>
				<tr>
					<th colspan="4" align="right">ยอดรวม</th>
					<th colspan="1" align="right"><?php echo number_format($order['OD_SumPrice'], 		2, '.', ','); ?></th>
				</tr>
				<tr>
					<th colspan="4" align="right">ขนส่งสินค้า</th>
					<?php
						if ($order['OD_FullSumPrice'] > $order['OD_SumPrice'])
							$OD_Transfer = $order['OD_FullSumPrice'] - $order['OD_SumPrice'];
						else
							$OD_Transfer = $order['OD_FullSumPrice'];
					?>
					<th colspan="1" align="right"><?php echo number_format($OD_Transfer,				2, '.', ','); ?></th>
				</tr>
				<tr>
					<th colspan="4" align="right">ยอดสุทธิ</th>
					<th colspan="1" align="right"><?php echo number_format($order['OD_FullSumPrice'],	2, '.', ','); ?></th>
				</tr>
			</tfoot>
		</table>
	</p>
	<p>** หมายเหตุ: โปรดรออีเมล์ยืนยันการสั่งซื้อสินค้าของคุณจากทางเว็บไซต์ ขอบคุณค่ะ **</p>
</body>
</html>