<!DOCTYPE html>
<html>
<head>
<title>Demonstrations | Clustering Markers | Google Maps V3 API CodeIgniter Library</title>

<!-- jQuery library (served from Google) -->
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.8.2/jquery.min.js"></script>
<!-- bxSlider Javascript file -->
<script src="jquery.bxslider.js"></script>
<!-- bxSlider CSS file -->
<link href="jquery.bxslider.css" rel="stylesheet" />
<style type="text/css">
.w_bxslider{
	margin:0 auto;
	width:500px;
	height:500px;
}

</style>
</head>
<body>
<div class="w_bxslider">
<ul class="bxslider">
  <li><img src="54c71885abcf3.jpg" /></li>
  <li><img src="54c71885abcf3.jpg" /></li>
  <li><img src="54c71885abcf3.jpg" /></li>
  <li><img src="54c71885abcf3.jpg" /></li>
</ul>
</div>
</body>
<script>

$(document).ready(function(){
  $('.bxslider').bxSlider({
	auto: true,
	speed:500,
	autoDelay:100
  });
});

</script>
</html>