<div id="index_content folderfiles">
	<?php 
	$this->load->view('template/companyusers/leftcol');
	if($ini != ""){
		$datanew = unserialize($ini->ini);
		$photomode = $datanew['photo_field_mode'];
		$hashlimit = $datanew['hash_tag_limit'];
	}
	$get_path = $this->folder_model->getfolder(array('folder_name'=>$parentfoldername));
	$getbreadcrumbs = ($get_path->num_rows() > 0) ? $get_path->result() : FALSE;
	$breadcrumbs = explode('/',$getbreadcrumbs[0]->directory);
	$countbreadcrumbs = count($breadcrumbs);
	?>
	<div id="right-col">
		<div class="contentpanel  col-md-10">
					<a id="mobilemenu" class="mobilemenu"><i class="fa fa-bars"></i></a>

			<?php $this->load->view('template/folder/topbar');?>
			<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
				<ol class="breadcrumb breadcrumb-quirk navbar-left">
					<li><a href="<?php echo BASE_URL;?>dashboard"><i class="fa fa-home mr5"></i> Home</a></li>
					<?php 
					$i=1;
					foreach($breadcrumbs as $crumbs){
						if($i != $countbreadcrumbs){
							if($crumbs == 'folders'){
								echo '<li><a href="'.BASE_URL.'company/'.$crumbs.'/"><i class="fa fa-folder-open" aria-hidden="true"></i>'.$crumbs.'</a></li>';
							}else{
								echo '<li><a href="'.BASE_URL.'company/folders/'.$crumbs.'/"><i class="fa fa-folder-open" aria-hidden="true"></i>'.$crumbs.'</a></li>';
							}
						}else{
							echo '<li class="active"><i class="fa fa-folder" aria-hidden="true"></i>'.$crumbs.'</li>';
						}
					 $i++;
					}?>
				</ol>
				<ul class="nav navbar-nav navbar-right">
					<li class="fileediting" style="display:none;">
						<a href="#" style="float: left;font-size:13px;padding-right: 5px;">Actions</a>
						<button type="button" class="btn btn-default dropdown-toggle fm-toggle" data-toggle="dropdown" aria-expanded="false" style="border: none;background: none;padding: 15px 0px 0 0px;">
							<span class="caret"></span>
						</button>
						<ul class="dropdown-menu pull-right fm-menu" id="filemenu" role="menu">
							<li><a id="fileattributeedit"><i class="fa fa-trash-o"></i> Edit</a></li>
					  </ul>
					</li>
					<li><button id="gridviewbut" class="gridviewbut" style="border: 2px solid grey;"><i class="fa fa-th" aria-hidden="true"></i></button><button id="listviewbut" class="listviewbut"><i class="fa fa-list" aria-hidden="true"></i></button></li>
					<li><button id="activity-toggle" style="font-size:13px;">Activity</button></li>
				</ul>
			</div>			
			<div class="panel">
				<div class="row panel-heading">
					<div class="col-sm-2">
						<?php echo $this->session->flashdata('companyfileupdation'); ?> 
						<h4 class="panel-title">Manage Company</h4>
					</div>
					<div class="col-sm-10">
						<div class="col-sm-9 attrbuttons pull-left" >
							<a id="folderattr" data-target="#attributefolfulajax" data-toggle="modal"><i class="fa fa-upload" ></i> Edit Folder Bulk Attributes</a>
							<a id="folderattrlist" data-target="#attributefolfulajax" data-toggle="modal" style="display:none;"><i class="fa fa-upload" ></i> Edit Folder Bulk Attributes</a>
							<a href="<?php echo BASE_URL; ?>folder/fcreate/?uid=<?php echo $companyid;?>&folder=<?php echo $foldername;?>" data-target="#userajax" data-toggle="modal"><i class="fa fa-upload" ></i> Create New Folder</a>
							<a href="<?php echo BASE_URL; ?>company/fileupload/?uid=<?php echo $companyid;?>&folder=<?php echo $foldername;?>" data-target="#folderajax" data-toggle="modal"><i class="fa fa-cloud"></i> Upload Files</a>
						</div>
						<?php if (isset($company)&&($company!="")){?>
						<div class="col-sm-3 pull-right">					
							<a class="btn btn-success btn-quirk btn-wide mr5" target="_blank" href="<?php echo BASE_URL.'companyview/'.$company->name;?>"><?php echo 'view company';?></a>
						</div>
						<?php }?>
					</div> 

				</div>
				<div class="panel-body">
					
					<div class="row">
						 <div class="filemanager gridview">

<?php //echo '<pre>';print_r($mapfiles);?> 
<?
/*****folders*****/
//if(($mapfolders=="")&& ($mapfiles=="")){?>
<div class="draggableset">
	<form action="<?php echo BASE_URL; ?>company/dragfileupload/?folder=<?php echo $foldername;?>" class="dropzone">
		 <div class="fallback">
             <input name="file[]" type="file" multiple />
          </div>
	</form>
</div>
<?php //}
if(($mapfolders !="")&& !empty($mapfolders)){
$i=1;
foreach($mapfolders as $folders){
	 //print_r($folders);exit;
	 $foldername 	= $folders->folder_name;
	 $createddate	= $folders->created;
	 $directory 	= $folders->directory;
?>
		<div class="col-sm-6 col-md-3 col-lg-6">
				  <div class="thmb" id="<?php echo $folders->id;?>">
					<label class="ckbox" style="display: block;">
					  <input type="checkbox"><span></span>
					</label>
					<div class="btn-group fm-group" style="display: block;">
					  <button type="button" class="btn btn-default dropdown-toggle fm-toggle" data-toggle="dropdown">
						<span class="caret"></span>
					  </button>
					  <ul class="dropdown-menu pull-right fm-menu" role="menu">
						<li><a href="<?php echo BASE_URL;?>folder/editattr/?name=<?php echo $foldername;?>&parent=<?php echo $parentfoldername;?>" data-target="#attributefolajax" data-toggle="modal"><i class="fa fa-trash-o"></i> Edit</a></li>
						<li><a onclick="return confirm('Are You Want To Delete This?')" href="<?php echo BASE_URL;?>folder/deletefolder/?name=<?php echo $foldername;?>&parent=<?php echo $parentfoldername;?>"><i class="fa fa-trash-o"></i> Delete</a></li>
					  </ul>
					</div><!-- btn-group -->
					<div class="thmb-prev">
						<a id="<?php echo 'folderid_'.$folders->id;?>" data-id="<?php echo $folders->id;?>"><i class="fa fa-folder-o"></i></a>
					</div>
					<h5 class="fm-title"><a href="<?php echo BASE_URL;?>company/folders/<?php echo $foldername;?>/"><?php echo $foldername;?></a></h5>
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
		$filelowrespath = BASE_URL.'lowresolution/watermark/';
		$extension = $files->extension;
		$type = $files->type;
		$size = $files->size.' kb';
		 //print_r($files);exit;
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
						  <li><a href="'.BASE_URL.'company/editpictureatt/?id='.$files->id.'" data-target="#dataadminajax" data-toggle="modal" ><i class="fa fa-pencil"></i> Edit</a></li>';?>
				<li><a onclick="return confirm('Are You Want To Delete This?')" href="<?php echo BASE_URL;?>folder/deletefile/?id=<?php echo $files->id;?>&folder=<?php echo $folder;?>"><i class="fa fa-trash-o"></i> Delete</a></li>
			<?php echo '</ul>
						</div><!-- btn-group -->
						<div class="thmb-prev">';
			if($type =='application'){
				echo '<i class="fa fa-file-code-o" aria-hidden="true"></i>';
			}else if($type == 'text'){
				echo '<i class="fa fa-file-code-o" aria-hidden="true"></i>';
			}else if($type == 'audio'){
				echo '<i class="fa fa-file-audio-o" aria-hidden="true"></i>';
			}else if($type == 'video'){
				echo '<i class="fa fa-file-video-o" aria-hidden="true"></i>';
			}else if($type == 'image'){
				echo '<img id="previmage_'.$j.'" data-src="'.$filelowrespath.$files->name.'" data-name="'.$files->name.'" src="'.$thumbpath.$files->thumb.'"/>';
			}
			echo '</div>';
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
			}else if($type == 'application'){
					echo '<h5 class="fm-title"><button data-href="'.$filepath.$files->name.'" id="popupapplication_'.$j.'">'.$files->original_name.'</button></h5>
						<small class="text-muted">Added: '.$files->creation_date.'</small><small class="text-muted">Type: '.$type.'</small>';
			}else{
				echo '<h5 class="fm-title"><button data-href="'.$filelowrespath.$files->name.'" id="popupimg_'.$j.'">'.$files->original_name.'</button></h5>
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
          </div><!-- filemanager gridview-->
<div class="filemanager listview" style="display:none;">

<div class="draggableset">
	<form action="<?php echo BASE_URL; ?>company/dragfileupload/?folder=<?php echo $foldername;?>" class="dropzone">
		 <div class="fallback">
             <input name="file[]" type="file" multiple />
          </div>
	</form>
</div>
<div class="table-responsive folderlist">
	<table id="dataTable2" class="table table-bordered table-striped-col">
		<thead>
			<tr>
				<th>Action</th>
				<th>Folders/Files</th>
				<th>Description</th>
			</tr>
		</thead>
		<tbody>
<?php
if(($mapfolders !="")&& !empty($pamfolders)){
$i=1;
foreach($mapfolders as $folders){
	 //print_r($folders);exit;
	 $foldername 	= $folders->folder_name;
	 $createddate	= $folders->created;
	 $directory 	= $folders->directory;
?>
		<tr>
			<td style="width: 10%;">
				<label class="ckbox" style="display: block;position: relative;">
				  <input type="checkbox" class="folcheck" data-folid="<?php echo $folders->id;?>"><span></span>
				</label>
			 </td>
			 <td style="width: 25%;">
				 <a id="<?php echo 'folderid_'.$folders->id;?>" data-id="<?php echo $folders->id;?>"><i class="fa fa-folder-o"></i></a>
			 </td>
			<td style="width: 65%;">
				<h5 class="fm-title"><a href="<?php echo BASE_URL;?>company/folders/<?php echo $foldername;?>/"><?php echo $foldername;?></a></h5>
				<small class="text-muted">Added: <?php echo $createddate;?></small>
			</td>
		</tr><!-- col-xs-6 -->
<?php 
}
}
/*****files*****/
if(($mapfiles !="")&& !empty($mapfiles)){
$j=1;
	foreach($mapfiles as $files){
		$folder = $files->directory;
		$folderget = $this->folder_model->getfolder(array('folder_name'=>$folder));
		$foldergetdetails = ($folderget->num_rows() > 0) ? $folderget->result() : FALSE;
		$folderpath = $foldergetdetails[0]->directory;
		$filelowrespath = BASE_URL.'lowresolution/watermark/';
		$thumbpath = BASE_URL.'thumbs/';
		$filepath = BASE_URL.$folderpath.'/';
		$extension = $files->extension;
		$type = $files->type;
		$size = $files->size.' kb';
		 //print_r($files);exit;
		echo '<tr>
					<td style="width: 10%;">
						<label class="ckbox" style="display: block;position: relative;">
						  <input type="checkbox" class="filecheck" data-id='.$files->id.'><span></span>
						</label>
					</td>
					<td style="width: 25%;padding: 10px 0;">';
					if($type =='application'){
						echo '<i class="fa fa-file-code-o" aria-hidden="true"></i>';
					}else if($type == 'text'){
						echo '<i class="fa fa-file-code-o" aria-hidden="true"></i>';
					}else if($type == 'audio'){
						echo '<i class="fa fa-file-audio-o" aria-hidden="true"></i>';
					}else if($type == 'video'){
						echo '<i class="fa fa-file-video-o" aria-hidden="true"></i>';
					}else if($type == 'image'){
						echo '<img id="previmage_'.$j.'" data-src="'.$filelowrespath.$files->name.'" data-name="'.$files->name.'" src="'.$thumbpath.$files->thumb.'"/>';
					}
				echo '</td>
					<td style="width: 65%;">';
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
					}else if($type == 'application'){
					echo '<h5 class="fm-title"><button data-href="'.$filepath.$files->name.'" id="popupapplication_'.$j.'">'.$files->original_name.'</button></h5>
						<small class="text-muted">Added: '.$files->creation_date.'</small><small class="text-muted">Type: '.$type.'</small>';
					}else{
						echo '<h5 class="fm-title"><button data-href="'.$filelowrespath.$files->name.'" id="popupimg_'.$j.'">'.$files->original_name.'</button></h5>
								<small class="text-muted">Added: '.$files->creation_date.'</small><small class="text-muted">Type: '.$type.'</small>';
					}
					echo '<p><b>Size:</b>'.$size.'</p>';
				echo '</td>
			</tr><!-- col-xs-6 -->';
	}
}
?>  
		</tbody>
	</table>
</div> 
          </div><!-- filemanager listview-->

					</div><!--row-->
				</div><!--panel-body-->
			</div><!-- panel -->
		</div><!--contentpanel-->
		<div class="activity-notice col-md-2">
				<div class="panel">
					<div class="row panel-heading">
						<h4 class="panel-title">Recent Activity</h4>
					</div>
					<div class="panel-body">
						<?php //print_r($requests);
						$k=1;
						if(isset($requests)&& ($requests !="")){
							foreach($requests as $request){
								echo '<p>'.$k.'.&nbsp'.$request->permission.'</p>';
								if($request->status==0){
								echo '<div class="activity">';
								echo '<form method="POST" action="'.BASE_URL.'company/approverequest/">
								<input type="hidden" name="userid" value="'.$request->uid.'"/>
								<input type="hidden" name="status" value="1"/>
								<input type="hidden" name="folder" value="folders"/>
								<input type="submit" name="submit" value="approve" class="btn btn-primary btn-xs">
								</form>';
								echo '</div>';
								}else{
								echo '<div class="activity">';
								echo '<div class="set1"><form method="POST" action="'.BASE_URL.'company/approverequest/">
								<input type="hidden" name="userid" value="'.$request->uid.'"/>
								<input type="hidden" name="status" value="0"/>
								<input type="hidden" name="folder" value="folders"/>
								<input type="submit" name="submit" value="unapprove" class="btn btn-warning btn-xs">
								</form></div>';
								echo '<div class="set2"><button class="btn btn-primary btn-xs">Approved</button></div>';
								echo '</div>';
								}
								$k++;
							}
						}
						//print_r($filerequests);
						$l =1;
						if(isset($filerequests)&& ($filerequests !="")){
							foreach($filerequests as $filerequest){
								echo '<p>'.$l.'User &nbsp'.$filerequest->username.' has request the access for the file <strong>'.$filerequest->filename.'</strong></p>';
								if($filerequest->status==0){
								echo '<div class="activity">';
								echo '<form method="POST" action="'.BASE_URL.'company/approvefilerequest/">
								<input type="hidden" name="userid" value="'.$filerequest->userid.'"/>
								<input type="hidden" name="fileid" value="'.$filerequest->fileid.'"/>
								<input type="hidden" name="status" value="1"/>
								<input type="hidden" name="folder" value="folders"/>
								<input type="submit" name="submit" value="approve" class="btn btn-primary btn-xs">
								</form>';
								echo '</div>';
								}else{
								echo '<div class="activity">';
								echo '<div class="set1"><form method="POST" action="'.BASE_URL.'company/approvefilerequest/">
								<input type="hidden" name="userid" value="'.$filerequest->userid.'"/>
								<input type="hidden" name="fileid" value="'.$filerequest->fileid.'"/>
								<input type="hidden" name="status" value="0"/>
								<input type="hidden" name="folder" value="folders"/>
								<input type="submit" name="submit" value="unapprove" class="btn btn-warning btn-xs">
								</form></div>';
								echo '<div class="set2"><button class="btn btn-primary btn-xs">Approved</button></div>';
								echo '</div>';
								}
								$l++; 
							}
						}
						?>
					</div>
				</div>
		</div><!-- activity-notice -->
	</div><!-- right-col-->
</div>
<!----- userajax starts----->
<div class="modal fade" id="userajax" role="basic" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
		</div>
	</div>
</div>
<!----- userajax ends----->
<!----- folderajax starts----->
<div class="modal fade" id="folderajax" role="basic" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
		</div>
	</div>
</div>
<!----- folderajax ends----->
<!----- imageajax starts----->
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
<!----- imageajax ends----->
<!-----videoajax starts----->
<div class="modal fade" id="videoajax" role="basic" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">

	<div class="modal-header"><!-- modal header -->
		<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
		<h4 class="modal-title" id="imagelabel">Video View</h4>
	</div><!-- /modal header -->

	<!-- modal body -->
	<div class="modal-body"> 
		<a href="" id="videodown" class="btn btn-primary btn-quirk btn-stroke" style="float: right;" download>Download video</a>
		<video id="videoatt" src="" width="320" height="240" controls></video>
	</div>
	<!-- /modal body -->
	<div class="modal-footer"><!-- modal footer -->
		<button class="btn btn-default" data-dismiss="modal">Close</button> 
	</div><!-- /modal footer -->
		</div>
	</div>
</div>
<!-----videoajax ends----->
<!-----audioajax starts----->
<div class="modal fade" id="audioajax" role="basic" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">

	<div class="modal-header"><!-- modal header -->
		<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
		<h4 class="modal-title" id="imagelabel">Audio View</h4>
	</div><!-- /modal header -->

	<!-- modal body -->
	<div class="modal-body"> 
		<a href="" id="audiodown" class="btn btn-primary btn-quirk btn-stroke" style="float: right;" download>Download audio</a>
		<audio id="audioatt" src="" controls></audio>
	</div>
	<!-- /modal body -->
	<div class="modal-footer"><!-- modal footer -->
		<button class="btn btn-default" data-dismiss="modal">Close</button> 
	</div><!-- /modal footer -->
		</div>
	</div>
</div>
<!-----audioajax ends----->
<!-----filetxtajax starts----->
<div class="modal fade" id="filetxtajax" role="basic" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">

	<div class="modal-header"><!-- modal header -->
		<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
		<h4 class="modal-title" id="imagelabel">File View</h4>
	</div><!-- /modal header -->

	<!-- modal body -->
	<div class="modal-body"> 
		<a href="" id="filetxtdown" class="btn btn-primary btn-quirk btn-stroke" style="float: right;" download>Download File</a>
		<div id="filecontent" style="clear: both;"></div>
	</div>
	<!-- /modal body -->
	<div class="modal-footer"><!-- modal footer -->
		<button class="btn btn-default" data-dismiss="modal">Close</button> 
	</div><!-- /modal footer -->
		</div>
	</div>
</div>
<!-----filetxtajax ends----->
<!-----fileajax starts----->
<div class="modal fade" id="fileajax" role="basic" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">

	<div class="modal-header"><!-- modal header -->
		<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
		<h4 class="modal-title" id="imagelabel">File View</h4>
	</div><!-- /modal header -->

	<!-- modal body -->
	<div class="modal-body"> 
		<a href="" id="filedown" class="btn btn-primary btn-quirk btn-stroke" download>Download File</a>
	</div>
	<!-- /modal body -->
	<div class="modal-footer"><!-- modal footer -->
		<button class="btn btn-default" data-dismiss="modal">Close</button> 
	</div><!-- /modal footer -->
		</div>
	</div>
</div>
<!-----fileajax ends----->
<!-----applicationajax starts----->
<div class="modal fade" id="applicationajax" role="basic" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">

	<div class="modal-header"><!-- modal header -->
		<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
		<h4 class="modal-title" id="imagelabel">File View</h4>
	</div><!-- /modal header -->

	<!-- modal body -->
	<div class="modal-body"> 
		<a href="" id="applicationdown" class="btn btn-primary btn-quirk btn-stroke" download>Download File</a>
	</div>
	<!-- /modal body -->
	<div class="modal-footer"><!-- modal footer -->
		<button class="btn btn-default" data-dismiss="modal">Close</button> 
	</div><!-- /modal footer -->
		</div>
	</div>
</div>
<!-----applicationajax ends----->
<!----- dataadminajax starts----->
<div class="modal fade" id="dataadminajax" role="basic" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
		</div>
	</div>
</div>
<!----- dataadminajax ends----->
<!----- attributefolderajax starts----->
<div class="modal fade" id="attributefolajax" role="basic" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header"><!-- modal header -->
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h4 class="modal-title" id="imagelabel">Edit Attributes for Folders</h4>
			</div><!-- /modal header -->
			<div class="modal-body"> 
				<form id="edituserform" method="POST" action="<?php echo BASE_URL;?>company/updatefolderattrs/">
					<?php if($photomode ==3){?>
						<div class="form-group">
							<label class="col-sm-3 text-primary lead control-label">Attributes <span class="text-danger">*</span></label>
							<div class="col-sm-9"><textarea name="attributetext" class="form-control" id="attributetext" rows="5" cols="60" required=""></textarea></div>
						</div>
					<?php 
					for($i=1; $i<=$hashlimit;$i++){?>
						<div class="form-group">
							<label class="col-sm-3 text-primary lead control-label"><?php echo 'hashtag '.$i;?> </label>
							<div class="col-sm-9">
								<input type="text" name="hashtag[<?php echo $i;?>]" class="form-control" id="hashtag_<?php echo $i;?>" value="" placeholder="<?php echo 'hashtag '.$i;?>"/>
							</div>
						</div>
					<?php }
					}else if($photomode == 1){
						for($i=1; $i<= $hashlimit;$i++){?>
							<div class="form-group">
								<label class="col-sm-3 text-primary lead control-label"><?php echo 'hashtag '.$i;?> </label>
								<div class="col-sm-9">
									<input type="text" name="hashtag[<?php echo $i;?>]" class="form-control" id="hashtag_<?php echo $i;?>" value="" placeholder="<?php echo 'hashtag '.$i;?>"/>
								</div>
							</div>
					<?php }
					}else if($photomode == 2){?>
						<div class="form-group">
							<label class="col-sm-3 text-primary lead control-label">Attributes <span class="text-danger">*</span></label>
							<div class="col-sm-9"><textarea name="attributetext" class="form-control" id="attributetext" rows="5" cols="60" required=""></textarea></div>
						</div>
					<?php }?>
					<div class="form-group bottom">
						<input type="hidden" name="status" value="1">
						<input type="hidden" name="parentfolder" value="<?php echo $parentfoldername;?>">
						<input class="btn btn-success" type="submit" name="user_submit" value="save Folder attributes">
					</div>
				</form>			
			</div><!-- /modal body -->
			<div class="modal-footer"><!-- modal footer -->
				<button class="btn btn-default" data-dismiss="modal">Close</button> 
			</div><!-- /modal footer -->
		</div>
	</div>
</div>
<!----- attributefolderajax ends----->
<!----- attributefolfulajax starts----->
<div class="modal fade" id="attributefolfulajax" role="basic" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header"><!-- modal header -->
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h4 class="modal-title" id="imagelabel">Edit Attributes for Folders</h4>
			</div><!-- /modal header -->
			<div class="modal-body"> 
				<form id="edituserform" class="form-horizontal" method="POST" action="<?php echo BASE_URL;?>company/updatefolderattrs/">
					<?php if($photomode ==3){?>
						<div class="form-group">
							<label class="col-sm-3 text-primary lead control-label">Attributes <span class="text-danger">*</span></label>
							<div class="col-sm-9"><textarea name="attributetext" class="form-control" id="attributetext" rows="5" cols="60" required=""></textarea></div>
						</div>
					<?php 
					for($i=1; $i<=$hashlimit;$i++){?>
						<div class="form-group">
							<label class="col-sm-3 text-primary lead control-label"><?php echo 'hashtag '.$i;?></label>
							<div class="col-sm-9">
								<input type="text" name="hashtag[<?php echo $i;?>]" class="form-control" id="hashtag_<?php echo $i;?>" value="" placeholder="<?php echo 'hashtag '.$i;?>"/>
							</div>
						</div>
					<?php }
					}else if($photomode == 1){
						for($i=1; $i<= $hashlimit;$i++){?>
							<div class="form-group">
								<label class="col-sm-3 text-primary lead control-label"><?php echo 'hashtag '.$i;?></label>
								<div class="col-sm-9">
									<input type="text" name="hashtag[<?php echo $i;?>]" class="form-control" id="hashtag_<?php echo $i;?>" value="" placeholder="<?php echo 'hashtag '.$i;?>"/>
								</div>
							</div>
					<?php }
					}else if($photomode == 2){?>
						<div class="form-group">
							<label class="col-sm-3 text-primary lead control-label">Attributes <span class="text-danger">*</span></label>
							<div class="col-sm-9"><textarea name="attributetext" class="form-control" id="attributetext" rows="5" cols="60" required=""></textarea></div>
						</div>
					<?php }?>
					<div class="form-group bottom">
						<input type="hidden" name="status" value="1">
						<input type="hidden" name="parentfolder" value="<?php echo $parentfoldername;?>">
						<input class="btn btn-success" type="submit" name="user_submit" value="save Folder attributes">
					</div>
				</form>			
			</div><!-- /modal body -->
			<div class="modal-footer"><!-- modal footer -->
				<button class="btn btn-default" data-dismiss="modal">Close</button> 
			</div><!-- /modal footer -->
		</div>
	</div>
</div>
<!----- attributefolfulajax ends----->
<script>
$(document).ready(function() {
	'use strict';
	$('body').on('hidden.bs.modal', '.modal', function () {
		$(this).removeData('bs.modal');
	});
	'use strict';
	$('#dataTable2').DataTable();
	var exRowTable = $('#exRowTable').DataTable({
    responsive: true,
    'fnDrawCallback': function(oSettings) {
      $('#exRowTable_paginate ul').addClass('pagination-active-success');
    },
    'ajax': 'ajax/objects.txt',
    'columns': [{
      'class': 'details-control',
      'orderable': false,
      'data': null,
      'defaultContent': ''
    },
    { 'data': 'Action' },
    { 'data': 'Folders/Files' },
    { 'data': 'Description' }
    ],
    'order': [[1, 'asc']]
  });
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
		 $('#videodown').attr('href', $(this).attr('data-href'));
		 $('#videoatt').attr('src', $(this).attr('data-href'));
		 $('#videoajax').modal('show');
		});
	$('button[id^="popupaudio_"]').on('click', function(e) {
		 e.preventDefault();
		 $('#audiodown').attr('href', $(this).attr('data-href'));
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
	$('[id^="folderid_"]').on('click', function(e) {
		e.preventDefault();
		var id = $(this).attr("data-id");
		$(this).closest('.thmb').toggleClass('selectedfolder');
		});
	$('#folderattr').click(function(e){
		if ($('.selectedfolder').length > 0){
			$('.folderidset').remove();
			$('.selectedfolder').each(function(){
				var id = $(this).attr("id");
				$('.bottom').append('<input type="hidden" class="folderidset" name="folderid[]" value="'+id+'">');
			});
		}else{
			$('.folderidset').remove();
			alert('Please Select the folders for bulk editing attributes');
			return false;
		}
	});
	$('#folderattrlist').click(function(e){
		if ($('.selectfolder').length > 0){
			$('.folderidset').remove();
			$('.selectfolder').each(function(){
				var id = $(this).attr("data-folid");
				$('.bottom').append('<input type="hidden" class="folderidset" name="folderid[]" value="'+id+'">');
			});
		}else{
			$('.folderidset').remove();
			alert('Please Select the folders for bulk editing attributes');
			return false;
		}
	});
	$('#gridviewbut').click(function(){
		$('#listviewbut').css('border', 'none');
		$(this).css('border', '2px solid grey');
		$('.gridview').css('display','block');
		$('.listview').css('display','none');
		$('#folderattr').css('display','block');
		$('#folderattrlist').css('display','none');
		$('.fileediting').css('display','none');
	});
	$('#listviewbut').click(function(){
		$('#gridviewbut').css('border', 'none');
		$(this).css('border', '2px solid grey');
		$('.gridview').css('display','none');
		$('.listview').css('display','block');
		$('#folderattr').css('display','none');
		$('#folderattrlist').css('display','block');
		$('.fileediting').css('display','block');
	});
	$('.folcheck').change(function() {
		if(this.checked) {
			$(this).addClass('selectfolder');
			$('.filecheck').prop("checked", false);
			$('.filecheck').removeClass('selectfile');
		}else{
			$('.folderidset').remove();
			$(this).removeClass('selectfolder');
		}
	});
	$('.filecheck').change(function() {
		if(this.checked) {
			$('.filecheck').prop("checked", false);
			$('.filecheck').removeClass('selectfile');
			$(this).prop("checked", true);
			$(this).addClass('selectfile');
			$('.folcheck').prop("checked", false);
			$('.folderidset').remove();
			$('.folcheck').removeClass('selectfolder');
			$('#filemenu li').remove();
			var id = $(this).attr('data-id');
			var siteurl = '<?php echo BASE_URL;?>';
			$("#filemenu").append('<li><a href="'+siteurl+'company/editpictureatt/?id='+id+'" data-target="#dataadminajax" data-toggle="modal"><i class="fa fa-pencil"></i> edit file attributes</a></li>');
		}else{
			$('.filecheck').prop("checked", false);
			$('.filecheck').removeClass('selectfile');
			$('#filemenu li').remove();
		}
	});
	$('.contentpanel').css('border-right','3px solid #eee');
	$('#activity-toggle').click(function(){
		$('body').toggleClass('opened');
		if ( $('.contentpanel').hasClass('col-md-10') ) {
			$('.contentpanel').removeClass('col-md-10').addClass('col-md-12');
			$('.contentpanel').css('border','none');
			$('.activity-notice').removeClass('col-md-2');
			$('.activity-notice').css('display','none');
		}else{
			$('.contentpanel').removeClass('col-md-12').addClass('col-md-10');
			$('.contentpanel').css('border-right','3px solid #eee');
			$('.activity-notice').addClass('col-md-2');
			$('.activity-notice').css('display','block');
		}
	});
});
</script>
