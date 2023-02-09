<?php
use app\models\Users;
use app\models\Slides;
$slides = Slides::find()->orderBy(['ORD'=>SORT_DESC])->all();
$this->title = 'Бахолаш тизими';
?>

<link rel="stylesheet" href="./css/flexslider.css" type="text/css" media="screen" />
<script src="./js/jquery.min.js"></script>
<script defer src="./js/jquery.flexslider.js"></script>
<script type="text/javascript">
	// $(window).load(function() {
	//   $('.flexslider').flexslider({
	//     animation: "slide"
	//   });
	// });

	$(window).load(function() {
	// The slider being synced must be initialized first
	  $('#carousel').flexslider({
	    animation: "slide",
	    controlNav: false,
	    animationLoop: false,
	    slideshow: false,
	    itemWidth: 210,
	    itemMargin: 5,
	    asNavFor: '#slider'
	  });
	 
	  $('#slider').flexslider({
	    animation: "slide",
	    controlNav: false,
	    animationLoop: false,
	    slideshow: false,
	    sync: "#carousel"
	  });
	});
</script>

<!-- Place somewhere in the <body> of your page -->
<?php
$n = 0;
if ($slides) {
?>
<div id="slider" style="width: 65%;height: auto;" class="flexslider">
  <ul class="slides">
  	<?php
  	foreach ($slides as $slide) {
  		echo '<li>
		        <img  src="'.$slide->URL.'" />
		    </li>';
		    $n++;
  	}
  	?>
  </ul>
</div>
<?php
}
?>
<?php
if ($n>1) {
?>
<div id="carousel" class="flexslider" style="background: #F4F6F9;padding:0px; text-align: center; ">
  <ul class="slides">
    <?php
  	foreach ($slides as $slide) {
  		echo '<li style="width: 65%;height: auto">
		        <img  src="'.$slide->URL.'" />
		    </li>';
  	}
  	?>
  </ul>
</div>

<?php
}
?>

<style type="text/css">
	h1,h2{
        text-align: center;
    }
	.img img{
		margin: 20px auto;
		display: block;
	}
    .img p{
        text-align: center;
        font-size: 30px;
        margin: 0 auto;
        display: block;
    }
    h1,h2{
        text-align: center;
    }
    .clear{
        clear: both;
    }
    video{
        margin: 0 auto;
        display: block;
    }
	h1{
		display:none;
	}
</style>