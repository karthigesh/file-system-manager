<div id="index_content">
	<?php 
	$this->load->view('template/companyusers/leftcol');
	$customusertype = $this->user_model->getcustomizedusertype($userdata->customizedusertype);
	$customizeduserdata = unserialize($customusertype->attributes);	
	$companyini = unserialize($ini->ini);
	$companyprivilegelevel = $companyini['default_privilege_level'];
	$companyhashtaglimit   = $companyini['hash_tag_limit'];
	$companymode           = $companyini['photo_field_mode'];
	$session_stream        = $companyini['session_stream'];
	$upload	= $customizeduserdata['upload_photo'];
	$userprivilegelevel = $customizeduserdata['privilege_level'];
	$clearancelevel = $customizeduserdata['clearance_level'];
	$createmodifyfolder = $customizeduserdata['createmodifyfolder'];
	$publish = $customizeduserdata['publish'];
	$customusertype = $this->user_model->getcusertype($userdata->customizedusertype);
	$get_path = $this->folder_model->getfolder(array('folder_name'=>$foldername));
	$getbreadcrumbs = ($get_path->num_rows() > 0) ? $get_path->result() : FALSE;
	$breadcrumbs = explode('/',$getbreadcrumbs[0]->directory);
	$countbreadcrumbs = count($breadcrumbs);
	$currentfolderlevel = ($countbreadcrumbs)*10;
	if($permission!=""){
		$requeststatus = $permission[0]->status;
	}else{
		$requeststatus = "";
	}
	?>
	<div id="right-col">
		<a id="mobilemenu" class="mobilemenu"><i class="fa fa-bars"></i></a>
		<div class="contentpanel">
			<?php $this->load->view('template/adminuser/topbar');?>
			<ol class="breadcrumb breadcrumb-quirk">
				<li><a href="<?php echo BASE_URL;?>dashboard/"><i class="fa fa-home mr5"></i> Home</a></li>
				<?php 
				$i=1;
				foreach($breadcrumbs as $crumbs){
					if($i != $countbreadcrumbs){
						if($crumbs == 'folders'){
							echo '<li><a href="'.BASE_URL.'user/"><i class="fa fa-folder-open" aria-hidden="true"></i>'.$crumbs.'</a></li>';
						}else{
							echo '<li><a href="'.BASE_URL.'user/'.$crumbs.'/"><i class="fa fa-folder-open" aria-hidden="true"></i>'.$crumbs.'</a></li>';
						}
					}else{
						echo '<li class="active"><i class="fa fa-folder" aria-hidden="true"></i>'.$crumbs.'</li>';
					}
				 $i++;
				}?>
			</ol>
			<div class="panel">
				<div class="row panel-heading">
					<div class="col-sm-6">
						<?php echo $this->session->flashdata('userupdation'); ?> 
						<h4 class="panel-title">Manage Company</h4>
					</div>
					<div class="col-sm-6">
						
					<div class="logout pull-left" style="margin-top: 12px;margin-left: 53px;">
						<?php if(($createmodifyfolder==1)&&($currentfolderlevel<= $clearancelevel)){ ?>
							<a href="<?php echo BASE_URL; ?>userfolder/fcreate/?folder=<?php echo $foldername;?>" data-target="#userajax" data-toggle="modal"><i class="fa fa-upload" ></i> Create New Folder</a>
							<?php } if (($userprivilegelevel>=$companyprivilegelevel)&&($upload==1)){?>
								<a href="<?php echo BASE_URL; ?>userfolder/fileupload/?folder=<?php echo $foldername;?>" data-target="#folderajax" data-toggle="modal"><i class="fa fa-cloud"></i> Upload Files</a>
							<?php } else{?>
								<a data-target="#requestpermission" data-toggle="modal" id="userrequest" >Request Permission</a>
							<?php } ?>
					</div>
					<?php if (isset($company)&&($company!="")){?>
						<div class="pull-right">					
								<a class="btn btn-success btn-quirk btn-wide mr5" target="_blank" href="<?php echo BASE_URL.'companyview/'.$company->name;?>"><?php echo 'view company';?></a></div>
						</div> 
						<?php }?>
				</div>
				<div class="panel-body">
					
					<div class="row">
						 <div class="filemanager">

<?php //echo '<pre>';print_r($mapfiles);?> 
<?
/*****folders*****/
if(($userprivilegelevel>=$companyprivilegelevel)&&($upload==1)){?>
	<form action="<?php echo BASE_URL; ?>company/dragfileupload/?folder=<?php echo $foldername;?>" class="dropzone">
		 <div class="fallback">
             <input name="file[]" type="file" multiple />
          </div>
	</form>
<?php }
if(($mapfolders !="")&& !empty($mapfolders)&&($currentfolderlevel<= $clearancelevel)){
$i=1;
foreach($mapfolders as $folders){
	 $foldername 	= $folders->folder_name;
	 $createddate	= $folders->created;
	 $directory 	= $folders->directory;
?>
		<div class="col-sm-6 col-md-3 col-lg-6">
				  <div class="thmb">
					<label class="ckbox" style="display: block;">
					  <input type="checkbox"><span></span>
					</label>
					<div class="btn-group fm-group" style="display: block;">
					  <button type="button" class="btn btn-default dropdown-toggle fm-toggle" data-toggle="dropdown">
						<span class="caret"></span>
					  </button>
					  <ul class="dropdown-menu pull-right fm-menu" role="menu">
						<li><a onclick="return confirm('Are You Want To Delete This?')" href="<?php echo BASE_URL;?>folder/deletefolder/?name=<?php echo $foldername;?>"><i class="fa fa-trash-o"></i> Delete</a></li>
					  </ul>
					</div><!-- btn-group -->
					<div class="thmb-prev">
						<a href="<?php echo BASE_URL;?>user/<?php echo $foldername;?>/"><i class="fa fa-folder-o"></i></a>
					</div>
					<h5 class="fm-title"><a href="<?php echo BASE_URL;?>user/<?php echo $foldername;?>/"><?php echo $foldername;?></a></h5>
					<small class="text-muted">Added: <?php echo $createddate;?></small>
				  </div><!-- thmb -->
				</div><!-- col-xs-6 -->
<?php if($i%4==0){
		echo '<div class="clearfix"></div>';
	}
	$i++;
}
echo '<div class="clearfix"></div>';
/*****files*****/
}
if(($mapfiles !="")&& !empty($mapfiles)){
$j=1;
	foreach($mapfiles as $files){		
		$folder = $files->directory;
		$folderget = $this->folder_model->getfolder(array('folder_name'=>$folder));
		$foldergetdetails = ($folderget->num_rows() > 0) ? $folderget->result() : FALSE;
		$folderpath = $foldergetdetails[0]->directory;
		$thumbpath = BASE_URL.'thumbs/';
		$filepath = BASE_URL.$folderpath.'/';
		$extension = $files->extension;
		$privilegelevel = $files->privilegelevel;
		$type = $files->type;
		$size = $files->size.' kb';
		$fileaccessrequest = $this->company_model->getuserfilerequest(array('fileid'=>$fileid));
		if($fileaccessrequest !=""){
			$filerequestaccess = ($fileaccessrequest->num_rows() > 0) ? $fileaccessrequest->result() : FALSE;
			if($filerequestaccess != FALSE){
				$settime= strtotime($filerequestaccess[0]->requesttime);
				$finaldate = strtotime('+'.$expiry_time.' days', $settime);
				$currentdate = strtotime("now");
				if($currentdate<$finaldate){
					$requeststatus = 1;
				}else{
					$requeststatus = 0;
				}
			}else{
				$requeststatus = 0;
			}
		}else{
			$requeststatus = 0;
		}
		echo '<div class="col-sm-6 col-md-3 col-lg-6">
					  <div class="thmb">
						<label class="ckbox" style="display: block;">
						  <input type="checkbox"><span></span>
						</label>
						<div class="btn-group fm-group" style="display: block;">
						  <button type="button" class="btn btn-default dropdown-toggle fm-toggle" data-toggle="dropdown">
							<span class="caret"></span>
						  </button>
						  <ul class="dropdown-menu pull-right fm-menu" role="menu">
				<li><a href="'.BASE_URL.'userfolder/editpictureatt/?id='.$files->id.'" data-target="#dataadminajax" data-toggle="modal" ><i class="fa fa-pencil"></i> Edit</a></li>';?>
				<li><a onclick="return confirm('Are You Want To Delete This?')" href="<?php echo BASE_URL;?>folder/deletefile/?id=<?php echo $files->id;?>&folder=<?php echo $folder;?>"><i class="fa fa-trash-o"></i> Delete</a></li>
			<?php echo '  </ul>
						</div><!-- btn-group -->';
			if(($userprivilegelevel>=$privilegelevel)||($requeststatus == 1))
				{
					echo '<div class="thmb-prev">';
				}else{
					echo '<div class="thmb-prev blur">';
				}
			if($type =='application'){
				echo '<i class="fa fa-file-code-o" aria-hidden="true"></i>';
			}else if($type == 'text'){
				echo '<i class="fa fa-file-code-o" aria-hidden="true"></i>';
			}else if($type == 'audio'){
				echo '<i class="fa fa-file-audio-o" aria-hidden="true"></i>';
			}else if($type == 'video'){
				echo '<i class="fa fa-file-video-o" aria-hidden="true"></i>';
			}else if($type == 'image'){
				echo '<img id="previmage_'.$j.'" data-src="'.$filepath.$files->name.'" data-name="'.$files->name.'" src="'.$thumbpath.$files->thumb.'"/>';
			}
			echo '</div>';
			if(($userprivilegelevel>=$privilegelevel)||($requeststatus == 1))
				{
			if($extension =='.txt'){
				echo '<h5 class="fm-title"><button data-href="'.$filepath.$files->name.'" id="popuptxt_'.$j.'">'.$files->original_name.'</button></h5>
						<small class="text-muted">Added: '.$files->creation_date.'</small><small class="text-muted">Type: '.$type.'</small>';
			}else if(($extension =='.pdf')||($extension =='.doc')||($extension =='.docx')){
				echo '<h5 class="fm-title"><button data-href="'.$filepath.$files->name.'" id="popupfile_'.$j.'">'.$files->original_name.'</button></h5>
						<small class="text-muted">Added: '.$files->creation_date.'</small><small class="text-muted">Type: '.$type.'</small>';
			}else if($type == 'audio'){
				echo '<h5 class="fm-title"><button data-href="'.$filepath.$files->name.'" id="popupaudio_'.$j.'">'.$files->original_name.'</button></h5>
						<small class="text-muted">Added: '.$files->creation_date.'</small><small class="text-muted">Type: '.$type.'</small>';
			}else if($type == 'video'){
				echo '<h5 class="fm-title"><button data-href="'.$filepath.$files->name.'" id="popupvideo_'.$j.'">'.$files->original_name.'</button></h5>
						<small class="text-muted">Added: '.$files->creation_date.'</small><small class="text-muted">Type: '.$type.'</small>';
			}else{
				echo '<h5 class="fm-title"><button data-href="'.$filepath.$files->name.'" id="popupimg_'.$j.'">'.$files->original_name.'</button></h5>
						<small class="text-muted">Added: '.$files->creation_date.'</small><small class="text-muted">Type: '.$type.'</small>';
			}
			}else{
					echo '<h5 class="fm-title"><button id="requestpermission_'.$files->id.'" data-id ='.$files->id.'>'.$files->original_name.'</button></h5>
								<small class="text-muted">Added: '.$files->creation_date.'</small><small class="text-muted">Type: '.$type.'</small>';
			}
			echo '<p><b>Size:</b>'.$size.'</p>';
				echo '</div><!-- thmb -->
					</div><!-- col-xs-6 -->';
			if($j%4==0){
				echo '<div class="clearfix"></div>';
			}
			$j++;
	}
}

?>  
          </div><!-- filemanager -->

					</div><!--row-->
				</div><!--panel-body-->
			</div><!-- panel -->
		</div><!--contentpanel-->
	</div><!-- right-col-->
</div> 
<div class="modal fade" id="userajax" role="basic" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
		</div>
	</div>
</div>
<div class="modal fade" id="folderajax" role="basic" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">

	<div class="modal-header"><!-- modal header -->
		<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
		<h4 class="modal-title" id="myModalLabel">Create Category</h4>
	</div><!-- /modal header -->

	<!-- modal body -->
	<div class="modal-body">   
		<form class="validate" method="post" id="useredit" enctype="multipart/form-data" >
        	<fieldset>
        <div class="row">
            <div class="form-group">
                <div class="col-md-6 col-sm-12">
                    <label>Name *</label>
                </div>
                <div class="col-md-6 col-sm-12">
                    <input type="text" name="catergory_name" id="catergory_name" value="" class="form-control required">
                </div>              
            </div>
        </div>      
        <div class="row">
            <div class="form-group">
                <div class="col-md-12 col-sm-12">
                    <label>Status *</label>
                    <select  class="form-control" name="maritial_status">
						   <option value="single">Single</option>
						   <option value="married">Married</option>
						   <option value="divorced">Divorced</option>
						   <option value="widower">Widower</option>
					</select>                  
                </div>
            </div>
        </div>
        <div class="row">
            <div class="form-group">
                <div class="col-md-12 col-sm-6">
                     <button type="submit" class="btn btn-primary">Save changes</button>     
                </div>
            </div>
        </div>
        </fieldset>
     </form>
	</div>
	<!-- /modal body -->
	<div class="modal-footer"><!-- modal footer -->
		<button class="btn btn-default" data-dismiss="modal">Close</button> 
	</div><!-- /modal footer -->
		</div>
	</div>
</div>
<div class="modal fade" id="imageajax" role="basic" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">

	<div class="modal-header"><!-- modal header -->
		<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
		<h4 class="modal-title" id="imagelabel">Image View</h4>
	</div><!-- /modal header -->

	<!-- modal body -->
	<div class="modal-body"> 
		<a href="" id="imgdown" class="btn btn-primary btn-quirk btn-stroke" style="float: right;" download>Download image</a>
		<img class="popmodalimage" src="" style="width: 100%;"/>  
	</div>
	<!-- /modal body -->
	<div class="modal-footer"><!-- modal footer -->
		<button class="btn btn-default" data-dismiss="modal">Close</button> 
	</div><!-- /modal footer -->
		</div>
	</div>
</div>
<div class="modal fade" id="dataadminajax" role="basic" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
		</div>
	</div>
</div>
<div class="modal fade" id="requestpermission" role="basic" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="requstperm">
			<form action="<?php echo BASE_URL;?>userfolder/requestper/" method="POST">
				<input type="hidden" name="url" value="<?php echo $foldername;?>"/>
				<input type="submit" name="submit" value="send request" class="btn btn-success btn-quirk btn-wide mr5">
			</form>
			</div>
		</div>
	</div>
</div>
<div class="modal fade" id="requestforfiles" role="basic" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="requstperm">
			<form action="<?php echo BASE_URL;?>userfolder/requestfile/" method="POST">
				<input type="hidden" name="url" value="user"/>
				<input type="submit" name="submit" value="send request" class="btn btn-success btn-quirk btn-wide mr5">
			</form>
			</div>
		</div>
	</div>
</div>
<div class="modal fade" id="presettimeended" role="basic" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="timeended">
			<p style="font-size: 25px;text-align: center;color: red;">Presettime has ended!</p>
			</div>
		</div>
	</div>
</div>
<script>
$(document).ready(function() {
	$('body').on('hidden.bs.modal', '.modal', function () {
		$(this).removeData('bs.modal');
	});
	'use strict';
	$('button[id^="popupimg_"]').on('click', function(e) {
		 e.preventDefault();
			$('.popmodalimage').attr('src', $(this).attr('data-href'));
			$('#imgdown').attr('href', $(this).attr('data-href'));
			$('#imagelabel').html($(this).attr('data-name'));
			$('#imageajax').modal('show');   
		});
	$('button[id^="popuptxt_"]').on('click', function(e) {
		 e.preventDefault();
		 $('#filetxtdown').attr('href', $(this).attr('data-href'));
		 $('#filecontent').load($(this).attr('data-href')); 
		 $('#filetxtajax').modal('show');
		});
	$('button[id^="popupfile_"]').on('click', function(e) {
		 e.preventDefault();
		 $('#filedown').attr('href', $(this).attr('data-href'));
		 $('#fileajax').modal('show');
		});
	$('button[id^="popupvideo_"]').on('click', function(e) {
		 e.preventDefault();
		 //$('#videodown').attr('href', $(this).attr('data-href'));
		 $('#videoatt').attr('src', $(this).attr('data-href'));
		 $('#videoajax').modal('show');
		});
	$('button[id^="popupaudio_"]').on('click', function(e) {
		 e.preventDefault();
		 //$('#audiodown').attr('href', $(this).attr('data-href'));
		 $('#audioatt').attr('src', $(this).attr('data-href'));
		 $('#audioajax').modal('show');
		});
	$('button[id^="popupapplication_"]').on('click', function(e) {
		 e.preventDefault();
		 $('#applicationdown').attr('href', $(this).attr('data-href'));
		 $('#applicationajax').modal('show');
		});
	$('[id^="previmage_"]').on('click', function(e) {
		 e.preventDefault();
			$('.popmodalimage').attr('src', $(this).attr('data-src'));
			$('#imgdown').attr('href', $(this).attr('data-src'));
			$('#imagelabel').html($(this).attr('data-name'));
			$('#imageajax').modal('show');   
		});
	$('[id^="requestpermission_"]').on('click', function(e) {
		e.preventDefault();
		var fileid = $(this).attr('data-id');
	});
	var video = document.querySelector('video');
	var time = '<?php echo $session_stream;?>';
	video.addEventListener('timeupdate', function() {
	if (!this._startTime) this._startTime = this.currentTime;

	var playedTime = this.currentTime - this._startTime;

	if (playedTime >= time){
		this.pause();
		$('.close').click();
		$('#presettimeended').modal('show');
	}
	 //
	});
	video.addEventListener('seeking', function() {
	this._startTime = undefined;
	});
	var audio = document.querySelector('audio');
	var time = '<?php echo $session_stream;?>';
	audio.addEventListener('timeupdate', function() {
	if (!this._startTime) this._startTime = this.currentTime;

	var playedTime = this.currentTime - this._startTime;

	if (playedTime >= time){
		this.pause();
		$('.close').click();
		$('#presettimeended').modal('show');
	}
	 //
	});
	audio.addEventListener('seeking', function() {
	this._startTime = undefined;
	});
});
</script>
