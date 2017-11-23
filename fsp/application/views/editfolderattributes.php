<?php 
$attribute = $folderdetails[0]->attribute;
if($folderdetails[0]->hashtag !=""){
	$hashtags = explode(',',$folderdetails[0]->hashtag);
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
	  <h4 class="panel-title">Edit Attributes for <?php echo $foldername;?> </h4>
	</div>
	<?php //print_r($userdetails);?>
	<div class="panel-body">
	<form id="edituserform" class="form-horizontal" method="POST" action="<?php echo BASE_URL;?>folder/updateattributes/">
	<?php if($photomode ==3){?>
		<div class="form-group">
			<label class="col-sm-3 text-primary lead control-label">Attributes <span class="text-danger">*</span></label>
			<div class="col-sm-9">
				<textarea name="attributetext" class="form-control" id="attributetext" rows="5" cols="60" required><?php echo $attribute;?></textarea>
			</div>
		</div>
		<?php 
		if($hashtags != ""){
		for($i=0; $i<$hashlimit;$i++){?>
			<div class="form-group">
				<?php if(isset($hashtags[$i])){?>
					<label class="col-sm-3 text-primary lead control-label"><?php echo 'hashtag '.$i;?></label>
					<div class="col-sm-9">
						<input type="text" name="hashtag[<?php echo $i;?>]" class="form-control" id="hashtag_<?php echo $i;?>" value="<?php echo $hashtags[$i];?>" placeholder="<?php echo 'hashtag '.$i;?>"/>
					</div>
				<?php }else{?>
					<label class="col-sm-3 text-primary lead control-label"><?php echo 'hashtag '.$i;?></label>
					<div class="col-sm-9">
						<input type="text" name="hashtag[<?php echo $i;?>]" class="form-control" id="hashtag_<?php echo $i;?>" value="" placeholder="<?php echo 'hashtag '.$i;?>"/>
					</div>
				<?php }?>
			</div>
		<?php }
		}else{
			for($i=0; $i<$hashlimit;$i++){?>
			<div class="form-group">
				<?php if(isset($hashtags[$i])){?>
					<label class="col-sm-3 text-primary lead control-label"><?php echo 'hashtag '.$i;?></label>
					<div class="col-sm-9">
						<input type="text" name="hashtag[<?php echo $i;?>]" class="form-control" id="hashtag_<?php echo $i;?>" value="<?php echo $hashtags[$i];?>" placeholder="<?php echo 'hashtag '.$i;?>"/>
					</div>
				<?php }else{?>
					<label class="col-sm-3 text-primary lead control-label"><?php echo 'hashtag '.$i;?></label>
					<div class="col-sm-9">
						<input type="text" name="hashtag[<?php echo $i;?>]" class="form-control" id="hashtag_<?php echo $i;?>" value="" placeholder="<?php echo 'hashtag '.$i;?>"/>
					</div>
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
					<label class="col-sm-3 text-primary lead control-label"><?php echo 'hashtag '.$i;?></label>
					<div class="col-sm-9">
						<input type="text" name="hashtag[<?php echo $i;?>]" class="form-control" id="hashtag_<?php echo $i;?>" value="<?php echo $hashtags[$i];?>" placeholder="<?php echo 'hashtag '.$i;?>"/>
					</div>
				<?php }else{?>
					<label class="col-sm-3 text-primary lead control-label"><?php echo 'hashtag '.$i;?></label>
					<div class="col-sm-9">
						<input type="text" name="hashtag[<?php echo $i;?>]" class="form-control" id="hashtag_<?php echo $i;?>" value="" placeholder="<?php echo 'hashtag '.$i;?>"/>
					</div>
				<?php }?>
			</div>
		<?php }
		}else{
			for($i=0; $i<$hashlimit;$i++){?>
			<div class="form-group">
				<?php if(isset($hashtags[$i])){?>
					<label class="col-sm-3 text-primary lead control-label"><?php echo 'hashtag '.$i;?></label>
					<div class="col-sm-9">
						<input type="text" name="hashtag[<?php echo $i;?>]" class="form-control" id="hashtag_<?php echo $i;?>" value="<?php echo $hashtags[$i];?>" placeholder="<?php echo 'hashtag '.$i;?>"/>
					</div>
				<?php }else{?>
					<label class="col-sm-3 text-primary lead control-label"><?php echo 'hashtag '.$i;?></label>
					<div class="col-sm-9">
						<input type="text" name="hashtag[<?php echo $i;?>]" class="form-control" id="hashtag_<?php echo $i;?>" value="" placeholder="<?php echo 'hashtag '.$i;?>"/>
					</div>
				<?php }?>
			</div>
		<?php }
		}
		}
		if($photomode == 2){?>
				<div class="form-group">
					<label class="col-sm-3 text-primary lead control-label">Attributes <span class="text-danger">*</span></label>
					<div class="col-sm-9">
						<textarea name="attributetext" class="form-control" id="attributetext" rows="5" cols="60" required><?php echo $attribute;?></textarea>
					</div>
				</div>
		<?php }?>
	<div class="form-group">
		<input type="hidden" name="status" value="1">
		<input type="hidden" name="folderid" value="<?php echo $folderdetails[0]->id;?>">
		<input type="hidden" name="parentfolder" value="<?php echo $urlfolder?>"/>
		<input class="btn btn-success" type="submit" name="user_submit" value="save folder attributes">
		
	</div>
	</form>
</div>
</div>
