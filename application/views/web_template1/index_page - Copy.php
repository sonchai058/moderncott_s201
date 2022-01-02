<!DOCTYPE html>
<html>
<head>
<?php
  //$site=$this->webinfo_model->getOnceWebMain();
 ?>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1.0">
    <meta name="description" content="<?php echo @$site['WD_Descrip']?>">
    <meta name="keywords" content="<?php echo @$site['WD_Keyword']?>">
    <meta name="author" content="<?php echo @$site['WD_Name']?>">

    <link rel="shortcut icon" href="<?php echo base_url('assets/images/'.@$site['WD_Icon']);?>" type="image/x-icon">
    <link rel="icon" href="<?php echo base_url('assets/images/'.@$site['WD_Icon']);?>" type="image/x-icon">

    <?php $this->load->file('assets/tools/tools_config.php');?>

    <?php
        if($this->template->content_view_set==1){
            $this->load->file(APPPATH.'modules/'.uri_seg(1).'/assets/tools/front-end/tools_config.php');
        }
    ?>


    <title><?php echo $title;?></title>
  
    
    <?php if(isset($output))
		{
			foreach($css_files as $file): ?>
				<link type="text/css" rel="stylesheet" href="<?php echo $file; ?>" />
			<?php endforeach; ?>
			<?php foreach($js_files as $file): ?>
				<script src="<?php echo $file; ?>"></script>
			<?php endforeach; ?>
	<?php
		}
	 ?>

</head>

<body>

  <div class="wrap_admin">
    <div class="wrap_head">
        <br/><br/>
        <h1 align="center">Header</h1>
    </div>
    <div class="wrap_nav">
        <br/><br/>
        <h1 align="center">Navigator</h1>
    </div>
    <div class="wrap_content">
        <br/><br/>
        <h1 align="center">Content</h1>
    <?php
			if(isset($output)){
    ?>
    <div class="grocury">
<?php
				echo ($output);
    ?>
    </div>
    <?php
      }else{
            if($this->template->content_view_set==0)
    		  $this->load->view($this->template->name.'/'.$content_view);
            else
              $this->load->file(APPPATH.'modules/'.uri_seg(1).'/views/front-end/'.$content_view.'.php'); 
	   }
    ?>
    </div>
    <div class="wrap_footer">
        <br/><br/>
        <h1 align="center">Footer</h1>
    </div>
  </div>


</body>
<?php $this->load->file('assets/admin/tools/tools_script.php'); ?>
    <?php
        if($this->template->content_view_set==1){
            $this->load->file(APPPATH.'modules/'.uri_seg(1).'/assets/tools/front-end/tools_script.php');
        }
    ?>
</html>

