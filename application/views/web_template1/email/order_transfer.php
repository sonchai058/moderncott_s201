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
		** ขณะนี้ได้รับเงินโอนจากท่านเรียบร้อยแล้ว ทางเราจะรีบจัดส่งสินค้าให้ท่านโดยเร็วที่สุด ขอบคุณค่ะ
		<table>
			<tr>
				<td>รหัสใบสั่งซื้อ: </td>
				<td class="po-code"><?php echo $OD_Code; ?></td>
			</tr>
			<tr>
				<td>ชื่อธนาคาร: </td>
				<td><?php echo $B_Name; ?></td>
			</tr>
			<tr>
				<td>ช่องทางชำระเงิน: </td>
				<td><?php echo $OT_Payment; ?></td>
			</tr>
			<tr>
				<td>วันเวลาที่โอนเงิน: </td>
				<?php
					$day 	= date('d', strtotime($OT_DateTimeUpdate));
					$month 	= date('m', strtotime($OT_DateTimeUpdate));
					$year 	= date('Y', strtotime($OT_DateTimeUpdate));
					$hour 	= date('H', strtotime($OT_DateTimeUpdate));
					$minute	= date('i', strtotime($OT_DateTimeUpdate));
					$second = date('s', strtotime($OT_DateTimeUpdate));
				?>
				<td><?php echo $day.'-'.$month.'-'.($year + 543).' '.$hour.':'.$minute.':'.$second; ?></td>
			</tr>
			<tr>
				<td>จำนวนเงิน: </td>
				<td><?php echo number_format($OT_FullSumPrice, 2, '.', ','); ?></td>
			</tr>
			<!-- <tr>
				<td></td>
				<td><img src="<?php echo base_url('assets/uploads/user_uploads_img/'.$OT_ImgAttach); ?>" alt="<?php echo $OT_ImgAttach; ?>" title="<?php echo $OT_ImgAttach; ?>"></td>
			</tr> -->
		</table>
	</p>
</body>
</html>