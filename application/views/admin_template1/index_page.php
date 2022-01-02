<!DOCTYPE html>
<html lang="en">

    <head>
        <?php $site = rowArray($this->common_model->custom_query("SELECT * FROM webconfig")); ?>

        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width,initial-scale=1.0">
        <meta name="description" content="<?php echo @$site['WD_Descrip']?>">
        <meta name="keywords" content="<?php echo @$site['WD_Keyword']?>">
        <meta name="author" content="<?php echo @$site['WD_Name']?>">

        <link rel="shortcut icon" href="<?php echo base_url('assets/images/'.@$site['WD_Icon']);?>" type="image/x-icon">
        <link rel="icon" href="<?php echo base_url('assets/images/'.@$site['WD_Icon']);?>" type="image/x-icon">

        <?php 
            $this->load->file('assets/admin/tools/tools_config.php');
            if ($this->template->content_view_set == 1) {
                //$this->load->file(APPPATH.'modules/'.uri_seg(1).'/assets/tools/back-end/tools_config.php');
                $this->load->file('assets/modules/'.uri_seg(1).'/tools/back-end/tools_config.php');
            }
        ?>

        <title><?php echo $site['WD_Name'].' ('.$title.')'; ?></title>
        
        <?php 
            if (isset($content)) {
                if (gettype($content) == 'object') {
        			foreach($content->css_files as $file): ?>
        				<link type="text/css" rel="stylesheet" href="<?php echo $file; ?>"> <?php 
                    endforeach; 
                    foreach($content->js_files as $file): ?>
        				<script src="<?php echo $file; ?>"></script> <?php 
                    endforeach; 
                }
    		}
    	?>
    </head>

    <body>
        <div class="wrap_admin">
            <div class="wrap_panel">
                <?php 
                    $this->template->load('header');
                    $this->template->load('navbar'); 
                ?>
                <div class="wrap_content">
                    <div class="wrap_content_main">
                        <?php 
                            if (isset($content_view)) {
                                if ($content_view === 'main')
                                    $this->template->load($content_view);
                                else 
                                    $this->load->view($content_view); 
                            }
                            else if (isset($content)) { 
                                if (gettype($content) == 'object') 
                                    echo $content->output;
                                if (gettype($content) == 'string') 
                                    echo $content;
                            }
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </body>

    <?php 
        $this->load->file('assets/admin/tools/tools_script.php');
        if($this->template->content_view_set == 1) {
            //$this->load->file(APPPATH.'modules/'.uri_seg(1).'/assets/tools/back-end/tools_script.php');
            $this->load->file('assets/modules/'.uri_seg(1).'/tools/back-end/tools_script.php');
        }
    ?>

    <script type="text/javascript">
        
    </script>

</html>