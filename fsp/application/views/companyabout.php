<div id="company">
	<h2>About <?php echo $title;?></h2>
	<?php $about = unserialize(base64_decode($company->about));
	if(($about!=""){
		echo $about;
	}
	?>
</div>
