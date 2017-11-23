<div class="panel">
	<div class="panel-heading">
	  <h4 class="panel-title">Upload Files</h4>
	</div>
	<?php //print_r($ini);
	if($ini != ""){
		$datanew = unserialize($ini->ini);
		$photomode = $datanew['photo_field_mode'];
		$hashlimit = $datanew['hash_tag_limit'];
	}
	?>
	<div class="panel-body">
		<form id="uploadfileform" method="POST" action="<?php echo BASE_URL;?>userfolder/savefiles/" enctype="multipart/form-data">
		<div class="form-group">
			<?php /*<input type="file" name="picture" required accept="audio/*,video/*,image/*,.doc,.docx,.pdf,.txt">*/?>
			<input type="file" name="picture" required >
		</div>
		<?php if($photomode ==3){?>
		<div class="form-group">
			<textarea name="attributetext" id="attributetext" rows="5" cols="60"></textarea>
		</div>
		<?php 
		for($i=1; $i<= $hashlimit;$i++){?>
			<div class="form-group">
				<input type="text" name="hashtag[<?php echo $i;?>]" id="hashtag_<?php echo $i;?>" value="" placeholder="<?php echo 'hashtag '.$i;?>"/>
			</div>
		<?php }
		}else if($photomode == 1){
			for($i=1; $i<= $hashlimit;$i++){?>
				<div class="form-group">
					<input type="text" name="hashtag[<?php echo $i;?>]" id="hashtag_<?php echo $i;?>" value="" placeholder="<?php echo 'hashtag '.$i;?>"/>
				</div>
		<?php }
		}else if($photomode == 2){?>
				<div class="form-group">
					<textarea name="attributetext" id="attributetext" rows="5" cols="60"></textarea>
				</div>
		<?php }?>
		<div class="form-group">
			<input type="hidden" name="url" value="<?php echo $hiddenid;?>">
			<input class="btn btn-success" type="submit" name="user_submit" value="upload files">
		</div>
		</form>
	</div>
</div>
