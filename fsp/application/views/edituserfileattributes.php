<?php 
$filename  = $picture->original_name;
$folder  = $picture->directory;
$attribute = $picture->attribute;
$pichash = $picture->hashtag;
if(!empty($pichash)){
	$hashtags = explode(',',$picture->hashtag);
}else{
	$hashtags = "";
}
if($ini != ""){
		$datanew = unserialize($ini->ini);
		$photomode = $datanew['photo_field_mode'];
		$hashlimit = $datanew['hash_tag_limit'];
	}
?>
<div class="panel">
	<div class="panel-heading">
	  <h4 class="panel-title">Edit Attributes for <?php echo $filename;?> </h4>
	</div>
	<?php //print_r($userdetails);?>
	<div class="panel-body">
	<form id="edituserform" method="POST" action="<?php echo BASE_URL;?>userfolder/updateattributes/">
	<?php if($photomode ==3){?>
		<div class="form-group">
			<textarea name="attributetext" id="attributetext" rows="5" cols="60"><?php echo $attribute;?></textarea>
		</div>
		<?php 
		if($hashtags != ""){
		for($i=0; $i<$hashlimit;$i++){?>
			<div class="form-group">
				<?php if(isset($hashtags[$i])){?>
					<input type="text" name="hashtag[<?php echo $i;?>]" id="hashtag_<?php echo $i;?>" value="<?php echo $hashtags[$i];?>" placeholder="<?php echo 'hashtag '.$i;?>"/>
				<?php }else{?>
					<input type="text" name="hashtag[<?php echo $i;?>]" id="hashtag_<?php echo $i;?>" value="" placeholder="<?php echo 'hashtag '.$i;?>"/>
				<?php }?>
			</div>
		<?php }
		}else{
			for($i=0; $i<$hashlimit;$i++){?>
			<div class="form-group">
				<?php if(isset($hashtags[$i])){?>
					<input type="text" name="hashtag[<?php echo $i;?>]" id="hashtag_<?php echo $i;?>" value="<?php echo $hashtags[$i];?>" placeholder="<?php echo 'hashtag '.$i;?>"/>
				<?php }else{?>
					<input type="text" name="hashtag[<?php echo $i;?>]" id="hashtag_<?php echo $i;?>" value="" placeholder="<?php echo 'hashtag '.$i;?>"/>
				<?php }?>
			</div>
		<?php }
		}
		}
		if($photomode == 1){
			if($hashtags != ""){
		for($i=0; $i<$hashlimit;$i++){?>
			<div class="form-group">
				<?php if(isset($hashtags[$i])){?>
					<input type="text" name="hashtag[<?php echo $i;?>]" id="hashtag_<?php echo $i;?>" value="<?php echo $hashtags[$i];?>" placeholder="<?php echo 'hashtag '.$i;?>"/>
				<?php }else{?>
					<input type="text" name="hashtag[<?php echo $i;?>]" id="hashtag_<?php echo $i;?>" value="" placeholder="<?php echo 'hashtag '.$i;?>"/>
				<?php }?>
			</div>
		<?php }
		}else{
			for($i=0; $i<$hashlimit;$i++){?>
			<div class="form-group">
				<?php if(isset($hashtags[$i])){?>
					<input type="text" name="hashtag[<?php echo $i;?>]" id="hashtag_<?php echo $i;?>" value="<?php echo $hashtags[$i];?>" placeholder="<?php echo 'hashtag '.$i;?>"/>
				<?php }else{?>
					<input type="text" name="hashtag[<?php echo $i;?>]" id="hashtag_<?php echo $i;?>" value="" placeholder="<?php echo 'hashtag '.$i;?>"/>
				<?php }?>
			</div>
		<?php }
		}
		}
		if($photomode == 2){?>
				<div class="form-group">
					<textarea name="attributetext" id="attributetext" rows="5" cols="60"></textarea>
				</div>
		<?php }?>
	<div class="form-group">
		<input type="hidden" name="status" value="1">
		<input type="hidden" name="pictureid" value="<?php echo $picture->id;?>"/>
		<input type="hidden" name="parentfolder" value="<?php echo $folder;?>"/>
		<input class="btn btn-success" type="submit" name="user_submit" value="save picture attributes">
		
	</div>
	</form>
</div>
</div>
