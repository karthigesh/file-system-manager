<div class="panel">
	<div class="panel-heading">
	  <h4 class="panel-title">Upload Files</h4>
	</div>
	<?php 
	$hash['1'] = 'folder';
	if($ini != ""){
		$datanew = unserialize($ini->ini);
		$photomode = $datanew['photo_field_mode'];
		$hashlimit = $datanew['hash_tag_limit'];
	}
	?>
	<div class="panel-body">
		<form id="uploadfileform" class="form-horizontal" method="POST" action="<?php echo BASE_URL;?>company/savefiles/" enctype="multipart/form-data">
		<div class="form-group input-group">
                <label class="input-group-btn">
                    <span class="btn btn-primary">
                        Browse… <input type="file" name="picture" id="picture" style="display: none;" required>
                    </span>
                </label>
                <input type="text" class="form-control" readonly="">
        </div>
		<div class="form-group">
               <label class="col-sm-3 text-primary lead control-label">Privilege level <span class="text-danger">*</span></label>
			<div class="col-sm-9">
				<input type="number" name="privilegelevel" class="form-control" onkeypress="validate(event)" id="privilegelevel" value="" min="10" max="100" required>
			</div>
        </div>
		<?php if($photomode == 3){?>
		<div class="form-group">
			<label class="col-sm-3 text-primary lead control-label">Attributes <span class="text-danger">*</span></label>
			<div class="col-sm-9">
				<textarea name="attributetext" class="form-control" id="attributetext" rows="5" cols="60" required></textarea>
			</div>
		</div>
		<?php 
		for($i=1; $i<=$hashlimit;$i++){?>
			<div class="form-group">
				<?php if(isset($hashtag[$i])){?>
					<label class="col-sm-3 text-primary lead control-label"><?php echo 'hashtag '.$i;?></label>
					<div class="col-sm-9">
						<input type="text" name="hashtag[<?php echo $i;?>]" class="form-control" id="hashtag_<?php echo $i;?>" value="<?php echo $hashtag[$i];?>" placeholder="<?php echo 'hashtag '.$i;?>"/>
					</div>
				<?php }else{ ?>
					<?php if(isset($hash[$i])){?>
					<label class="col-sm-3 text-primary lead control-label"><?php echo 'hashtag '.$i;?></label>
					<div class="col-sm-9">
						<input type="text" name="hashtag[<?php echo $i;?>]" class="form-control" id="hashtag_<?php echo $i;?>" value="<?php echo $hash[$i];?>" placeholder="<?php echo 'hashtag '.$i;?>"/>
					</div>
					<?php }else{?>
					<label class="col-sm-3 text-primary lead control-label"><?php echo 'hashtag '.$i;?></label>
					<div class="col-sm-9">
						<input type="text" name="hashtag[<?php echo $i;?>]" class="form-control" id="hashtag_<?php echo $i;?>" value=" " placeholder="<?php echo 'hashtag '.$i;?>"/>
					</div>
					<?php }?>
				<?php }?>
			</div>
		<?php }
		}else if($photomode == 1){
			for($i=1; $i<= $hashlimit;$i++){?>
				<div class="form-group">
					<?php if(isset($hashtag[$i])){?>
					<label class="col-sm-3 text-primary lead control-label"><?php echo 'hashtag '.$i;?></label>
					<div class="col-sm-9">
						<input type="text" name="hashtag[<?php echo $i;?>]" class="form-control" id="hashtag_<?php echo $i;?>" value="<?php echo $hashtag[$i];?>" placeholder="<?php echo 'hashtag '.$i;?>"/>
					</div>
				<?php }else{ ?>
					<label class="col-sm-3 text-primary lead control-label"><?php echo 'hashtag '.$i;?></label>
					<div class="col-sm-9">
						<input type="text" name="hashtag[<?php echo $i;?>]" class="form-control" id="hashtag_<?php echo $i;?>" value=" " placeholder="<?php echo 'hashtag '.$i;?>"/>
					</div>
				<?php }?>
				</div>
		<?php }
		}else if($photomode == 2){?>
				<div class="form-group">
					<label class="col-sm-3 text-primary lead control-label">Attribute text</label>
					<div class="col-sm-9">
						<textarea name="attributetext" class="form-control" id="attributetext" rows="5" cols="60"></textarea>
					</div>
				</div>
		<?php }?>
		<div class="form-group">
			<input type="hidden" name="url" value="<?php echo $hiddenid;?>">
			<input class="btn btn-success" type="submit" id="filesubmit" name="user_submit" value="upload files">
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
    $(function () {
    $(document).on('change', ':file', function () {
        var input = $(this), numFiles = input.get(0).files ? input.get(0).files.length : 1, label = input.val().replace(/\\/g, '/').replace(/.*\//, '');
        input.trigger('fileselect', [
            numFiles,
            label
        ]);
    });    
    $(document).ready(function () {		
        $(':file').on('fileselect', function (event, numFiles, label) {
            var input = $(this).parents('.input-group').find(':text'), log = numFiles > 1 ? numFiles + ' files selected' : label;
            if (input.length) {
                input.val(log);
            } else {
                if (log)
                    alert(log);
            }
        });
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
    $('#filesubmit').on('click', function(){
		if ($('#picture').get(0).files.length === 0) {
			alert('please select a file');
			return false;
		}
	});
	
});
</script>
