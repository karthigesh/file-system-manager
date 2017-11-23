<?php 
$filename  = $picture->original_name;
$folder  = $picture->directory;
$attribute = $picture->attribute;
$privilegelevel = $picture->privilegelevel;
if($folder == 'folders'){
	$hashtag[0] = 'folder';
}else{
$foldersforhashget = $this->folder_model->getfolder(array('folder_name'=>$folder));
$folderdetails = ($foldersforhashget->num_rows() > 0) ? $foldersforhashget->result() : FALSE;
$folderpath = $folderdetails[0]->directory; 
$hashtag = explode("/",$folderpath);
}
if($picture->hashtag !=""){
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
	<form id="edituserform" class="form-horizontal" method="POST" action="<?php echo BASE_URL;?>company/updateattributes/">
		<div class="form-group">
               <label class="col-sm-3 text-primary lead control-label">Privilege level <span class="text-danger">*</span></label>
			<div class="col-sm-9">
				<input type="number" name="privilegelevel" class="form-control" onkeypress="validate(event)" id="privilegelevel" value="<?php echo $privilegelevel;?>" min="10" max="100" required>
			</div>
        </div>
	<?php if($photomode ==3){?>
		<div class="form-group">
			<label class="col-sm-3 text-primary lead control-label">Attributes <span class="text-danger">*</span></label>
			<div class="col-sm-9">
				<textarea name="attributetext" class="form-control" id="attributetext" rows="5" cols="60" required><?php echo $attribute;?></textarea>
			</div>
		</div>
		<?php 
		for($i=0; $i<$hashlimit;$i++){?>
			<div class="form-group">
				<?php if((isset($hashtags[$i]))&&($hashtags[$i]!="")){?>
					<label class="col-sm-3 text-primary lead control-label"><?php echo 'hashtag '.$i;?></label>
					<div class="col-sm-9">
						<input type="text" name="hashtag[<?php echo $i;?>]" class="form-control" id="hashtag_<?php echo $i;?>" value="<?php echo $hashtags[$i];?>" placeholder="<?php echo 'hashtag '.$i;?>"/>
					</div>
				<?php }else{
					if(isset($hashtag[$i])){?>
						<label class="col-sm-3 text-primary lead control-label"><?php echo 'hashtag '.$i;?></label>
						<div class="col-sm-9">
							<input type="text" name="hashtag[<?php echo $i;?>]" class="form-control" id="hashtag_<?php echo $i;?>" value="<?php echo $hashtag[$i];?>" placeholder="<?php echo 'hashtag '.$i;?>"/>
						</div>
				<?php }else{?>
						<label class="col-sm-3 text-primary lead control-label"><?php echo 'hashtag '.$i;?></label>
						<div class="col-sm-9">
							<input type="text" name="hashtag[<?php echo $i;?>]" class="form-control" id="hashtag_<?php echo $i;?>" value="" placeholder="<?php echo 'hashtag '.$i;?>"/>
						</div>
				<?php }} ?> 
			</div>
		<?php }
		}else if($photomode == 1){
			for($i=0; $i< $hashlimit;$i++){?>
				<div class="form-group">
					<input type="text" name="hashtag[<?php echo $i;?>]" class="form-control" id="hashtag_<?php echo $i;?>" value="" placeholder="<?php echo 'hashtag '.$i;?>"/>
				</div>
		<?php }
		}else if($photomode == 2){?>
				<div class="form-group">
					<textarea name="attributetext" id="attributetext" class="form-control" rows="5" cols="60"></textarea>
				</div>
		<?php }?>
	<div class="form-group">
		<input type="hidden" name="status" value="1">
		<input type="hidden" name="pictureid" value="<?php echo $picture->id;?>"/>
		<input type="hidden" name="userid" value="<?php echo $hiddenid;?>"/>
		<input type="hidden" name="parentfolder" value="<?php echo $folder;?>"/>
		<input class="btn btn-success" type="submit" name="user_submit" value="save picture attributes">
		
	</div>
	</form>
</div>
</div>
<script>
	function validate(evt) {
		var theEvent = evt || window.event;
		var key = theEvent.keyCode || theEvent.which;
		key = String.fromCharCode( key );
		var regex = /[0-9]|\./;
		if( !regex.test(key) ) {
			theEvent.returnValue = false;
			if(theEvent.preventDefault) theEvent.preventDefault();
		}
	}
	$(document).ready(function () {		
		var t = false
		$('#privilegelevel').focus(function () {
		var $this = $(this)

		t = setInterval(

		function () {
			if (($this.val() <=0 || $this.val() > 100) && $this.val().length != 0) {
				if ($this.val() <= 0) {
					$this.val(10)
				}
				if ($this.val() > 100) {
					$this.val(100)
				}

			}
		}, 50)
		});
		$('#privilegelevel').blur(function () {
		if (t != false) {
		window.clearInterval(t)
		t = false;
		}
		});
    });
</script>
