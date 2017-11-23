<div class="panel">
	<div class="panel-heading">
	  <h4 class="panel-title">Add Folder</h4>
	</div>
		<div class="panel-body">
	<form id="createfolder" method="POST" aria-required="true" action="<?php echo BASE_URL;?>userfolder/addfolder/"> 
	<div class="form-group">
			<?php 
			$data = array(
			'type'	  => 'text',
			'class'      => 'form-control bottom-border foldererror',
			'id'		=>'foldername',
			'name'       => 'foldername',
			'placeholder'	=> 'Enter Your Folder Name',
			'required' => 'required',
			'onchange'=> 'checkfname(this)'
			);        
			echo form_input($data);
			?> 
	</div>
	<div class="form-group">
		<input type="hidden" name="userid" value="<?php echo $userid;?>"/>
		<input type="hidden" name="parentfolder" value="<?php echo $folder;?>"/>
		<input class="btn btn-success" type="submit" name="company_submit" id="foldercreate" value="Create Folder">
	</div>
	</form>
</div>
</div>
<script language="javascript">
		function checkfname(fname){
			var name = $('#foldername').val();
			var url = '<?php echo BASE_URL.'folder/folderverify/';?>';
			$.ajax({
			   type: "POST",
			   url: url,
			   data: {name:name},
			   success: function(data)
			   {
				   if(data == 0){
					   $('#foldername').css('border','1px solid red');
				   }else{
					   $('#foldername').css('border','1px solid #bdc3d1');
				   }
			   }
			 });
			return false;
		}
		$('#foldercreate').click(function(){
			var name = $('#foldername').val();
			if(name==''){
				$('#foldername').css('border','1px solid red');
				return false;
			}else{
				var url = '<?php echo BASE_URL.'folder/folderverify/';?>'; 
				$.ajax({
				   type: "POST",
				   url: url,
				   data: {name:name},
				   success: function(data)
				   {
					   if(data == 0){
						   $('#foldername').css('border','1px solid red');
					   }else{
						   $('#createfolder').submit();
					   }
				   }
				 });
				return false;
			}
		});
</script>
