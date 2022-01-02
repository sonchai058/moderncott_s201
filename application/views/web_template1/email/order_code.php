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
				<td>รหัสใบสั่งซื้อ: </td>
				<td class="po-code"><?php echo $OD_Code; ?></td>
			</tr>
			<tr>
				<td>หมายเลขสิ่งของฝากส่งทางไปรษณีย์: </td>
				<td><?php echo $OD_EmsCode; ?></td>
			</tr>
			<tr>
				<td>สถานะใบสั่งซื้อ: </td>
				<td class="po-status"><?php echo $OD_Allow; ?></td>
			</tr>
		</table>
	</p>
</body>
</html>