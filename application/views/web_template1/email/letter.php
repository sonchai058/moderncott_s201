<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title><?php echo $mail['LT_Head']?></title>
	<style type="text/css">
		.content{
			padding: 10px;
			width:980px ;
			margin:0 auto;
			background-color: #eee;
		}
		.fileAtch{
			list-style-type: none;
		}
		.dlFile{
			text-decoration: none;
		}
		.dlFile:hover {
			text-decoration: underline;
		}
		
	</style>
</head>
<body>
	<div class="content">
		<span><?php echo $mail['LT_Head']?></span>
		<hr>
		<?php echo $mail['LT_Detail']?>
		<hr>
		<?php
		$fi = unserialize($mail['LT_Files']);
		if($fi[0]['file']!=''){
		?>
		<div>
			<span>ไฟล์แนบ</span>
			<ul class="fileAtch">
				<?php 
				foreach ($fi as $file) {?>
				<li>
					<a class="dlFile" target='_blank' href="<?php echo base_url('main/fileDownload/letter_files/'.downloadName($file['name']).'/'.$file['file'])?>" title="<?php echo $file['name'];?>">
						<span><?php echo $file['name'];?></span>
					</a>	
				</li>
				<?php }?>
			</ul>
		</div>
		<?php }?>
	</div>
</body>
</html>