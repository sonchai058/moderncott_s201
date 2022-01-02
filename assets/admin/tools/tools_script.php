<?php
  if(isset($this->template->js_assets_footer))
  foreach ($this->template->js_assets_footer as $key => $data) {
    echo $data;
  }
?>
<?php
	if(isset($this->template->css_assets_footer))
    foreach ($this->template->css_assets_footer as $key => $data) {
      echo $data;
    }
?>

<script>
var base_url    = "<?php echo base_url();?>";
$(document).ready(function(){
  

});
</script>
