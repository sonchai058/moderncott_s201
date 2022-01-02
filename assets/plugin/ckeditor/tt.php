<!DOCTYPE html">
  <head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <title>CKEditor</title>
  <script type="text/javascript" src="ckeditor.js"></script>
  </head>
<body>
	
  <div style="width:980px; height:auto; display:table; margin:100px auto;">
	<?php
	if(!isset($_POST['txtMessage'])){
	?>
	<form method="post" action="">
		<textarea name="txtMessage" class="ckeditor" id="txtMessage" cols="45" rows="5"></textarea>
		<br/>
		<center><input type="submit" value="กดเพื่อบันทึกข้อมูล" style="cursor:pointer; width:200px; height:50px;" onclick="return confirm('บันทึก!!!!!!!!!!!!!!!!')">&nbsp;&nbsp;<input type="reset" value="Reset" style="cursor:pointer; width:200px; height:50px;"></center>
	</form>
	<?php
	}else{
	?>
		<h1 align="center">บันทึกข้อมูล</h1>
	<?php
		echo "<div style='width:100%;border:4px #f00 solid;'>".htmlspecialchars($_POST['txtMessage'])."</div>";
	?>
	<br/><br/><input type="button" value="กลับไป" style="cursor:pointer; width:200px; height:50px;" onclick="history.back()">
	<?php
	}
	?>
  </div>
  
</body>
</html>
