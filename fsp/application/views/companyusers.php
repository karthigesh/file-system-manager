<div id="index_content companyuserset">
	<?php 
	$this->load->view('template/companyusers/leftcol');?>
	<div id="right-col">
			<a id="mobilemenu" class="mobilemenu"><i class="fa fa-bars"></i></a>
		<div class="contentpanel">
			<div class="header">
				<div class="logohead">
					<img class="logo" src="<?php echo BASE_URL;?>images/logo_dark.png" alt="logo">
				</div>
				<div class="logout">
					<a href="<?php echo BASE_URL;?>logout"><i class="fa fa-sign-out"></i>Logout</a>
				</div>
			</div><!--header-->
			<div class="panel">
				<div class="row panel-heading">
					<div class="col-sm-6">
						<?php echo $this->session->flashdata('companyuserupdation'); ?> 
						<h4 class="panel-title">Manage Company</h4>
					</div>
					<div class="col-sm-6">
						<?php if(($company!="")&& !empty($company)){?>
						<div class="pull-right"><a class="btn btn-success btn-quirk btn-wide mr5" target="_blank" href="<?php echo BASE_URL.'companyview/'.$company->name;?>"><?php echo 'view company';?></a></div>
						<?php }?>
					</div>          
				</div>
				<div class="panel-body">
					<div class="row tab-side-wrapper">
						<div class="col-xs-4 col-sm-3 tab-left">
						<!-- Nav tabs -->
							<ul class="nav nav-pills nav-stacked">
								<li class="active"><a href="#account" data-toggle="tab" aria-expanded="false"><strong>Account Settings</strong></a></li>
								<li><a href="#usertype" data-toggle="tab" aria-expanded="true"><strong>Create New Usertype</strong></a></li>
								<li class=""><a href="#allusertypes" data-toggle="tab" aria-expanded="true"><strong>ALL User Types</strong></a></li>
								<li class=""><a href="#newuser" data-toggle="tab" aria-expanded="true"><strong>Create New User</strong></a></li>
								<li class=""><a href="#edituser" data-toggle="tab" aria-expanded="false"><strong>Delete/Edit user</strong></a></li>
								<?php /*<li class=""><a href="#newadmin" data-toggle="tab" aria-expanded="true"><strong>Create New Dataadmin</strong></a></li>
								<li class=""><a href="#editadmin" data-toggle="tab" aria-expanded="false"><strong>Delete/Edit Dataadmin</strong></a></li>*/?>
								
							</ul>
						</div>
						<div class="col-xs-8 col-sm-9 col-xs-offset-4 col-sm-offset-3 tab-main">
							<!-- Tab panes -->
							<div class="tab-content">
								<div class="tab-pane  active" id="account">
									<?php //print_r($company);?>
									<?php if(($company!="")&& !empty($company)){?>
									<form name="accountform" action="<?php echo BASE_URL;?>company/accountsave/" id="accountform" method="POST" enctype="multipart/form-data" aria-required="true">
										<div class="form-group">
											<?php 
											$data = array(
											'type'	  => 'text',
											'class'      => 'form-control bottom-border',
											'id'	=>'cname',
											'name'       => 'cname',
											'placeholder'	=> 'Company Name',
											'value'		=>$company->name,
											'onchange'	=>'companycheck()',
											'required' => 'required'
											);        
											echo form_input($data);
											?> 
										</div>
										<div class="form-group">
											<label><strong>Choose Your Company Picture :</strong></label>
											<input type="hidden" name="picture" value="<?php echo $company->picture;?>">
											<div class="cpicture"><img src="<?php echo IMG_PATH.$company->picture;?>"/></div>
											<input type="file" name="picture" accept="image/*" >
										</div>
										<div class="form-group">
											<label><strong>Set your Splash Screen</strong></label>
											<?php 
											$data = array(
											'class'      => 'form-control bottom-border',
											'id'		=>'summernote',
											'name'       => 'splashscreen',
											'placeholder'	=> 'Enter Some Details',
											'value'		=> $company->splashscreen,
											'rows'=>'20',
											'cols'=>'40'
											);        
											echo form_textarea($data);
											?>  
										</div>
										<div class="form-group">
											<input type="hidden" name="parentid" value="<?php echo $companyid;?>">
											<input type="hidden" name="url" value="<?php echo $secureid;?>">
											<input class="btn btn-success" id="account_submit" type="submit" name="account_submit" value="Submit">
										</div>
									</form>
									<?php }else{?>
									<form name="accountform" action="<?php echo BASE_URL;?>company/accountsave/" id="accountform" method="POST" enctype="multipart/form-data" aria-required="true">
										<div class="form-group">
											<?php 
											$data = array(
											'type'	  => 'text',
											'class'      => 'form-control bottom-border',
											'id'	=>'cname',
											'name'       => 'cname',
											'placeholder'	=> 'Company Name',
											'required' => 'required'
											);        
											echo form_input($data);
											?> 
										</div>
										<div class="form-group">
											<label><strong>Choose Your Company Picture :</strong></label>
											<input type="file" name="picture" required>
										</div>
										<div class="form-group">
											<label><strong>Set your Splash Screen</strong></label>
											<?php 
											$data = array(
											'class'      => 'form-control bottom-border',
											'id'		=>'summernote',
											'name'       => 'splashscreen',
											'placeholder'	=> 'Enter Some Details',
											'rows'=>'20',
											'cols'=>'40'
											);        
											echo form_textarea($data);
											?>  
										</div>
										<div class="form-group">
											<input type="hidden" name="parentid" value="<?php echo $companyid;?>">
											<input type="hidden" name="url" value="<?php echo $secureid;?>">
											<input id="account_submit" class="btn btn-success" type="submit" name="account_submit" value="Submit">
										</div>
									</form>
									<?php }?>
								</div>
								<div class="tab-pane" id="usertype">
									<h2>Upload Usertype xml for creating user</h2>
									<form name="uploaduser" action="<?php echo BASE_URL;?>company/uploaduser" class="form-horizontal" id="compuploaduser" method="POST" enctype="multipart/form-data">
										<div class="form-group">
											<input type="file" name="userxml" accept="text/xml" required>
										</div>
										<div class="form-group">
											<input type="hidden" name="parentid" value="<?php echo $secureid;?>">
											<input class="btn btn-success" type="submit" name="company_submit" value="create usertype">
										</div>
									</form>
								</div>
								<div class="tab-pane" id="allusertypes">
									<div class="table-responsive">
										<h2>ALL User types</h2>
										<table id="dataTable2" class="table table-bordered table-striped-col">
											<thead>
												<tr>
													<th>Id</th>
													<th>Usertype</th>
													<th>Permissions</th>
													<th>Actions</th>
												</tr>
											</thead>
											<tbody>
												<?php 
												echo '<tr>';
												echo '<td>1</td>';
												echo '<td>'.$cdefaultusertype->usertype.'</td>';
												$attributes = unserialize($cdefaultusertype->attributes);
												$numItems = count($attributes);
												echo '<td>';
												$j=1;
												foreach($attributes as $key=>$value){
													if($value==1){
														echo '<span><strong>'.$key.'</strong> -Enabled</span>';
													}else if($value==0){
														echo '<span><strong>'.$key.'</strong> -Disabled</span>';
													}else{
														echo '<span><strong>'.$key.'</strong> -'.$value.'</span>';
													}
													if($j != $numItems){
														echo ',&nbsp;';
													}
													$j++;
												}
												echo '</td>';
												echo '<td></td>';
												echo '</tr>';
												$i=2;
												if(!empty($companyusertypes)&&($companyusertypes!="")){
												foreach($companyusertypes as $nusertype){
													echo '<tr>
													<td>'.$i.'</td>
													<td>'.$nusertype->usertype.'</td>';
													$attributes = unserialize($nusertype->attributes);
													echo '<td>';
													$numItems = count($attributes);
													//print_r($attributes);
													$j=1;
													foreach($attributes as $key=>$value){
														if($value==1){
															echo '<span><strong>'.$key.'</strong> -Enabled</span>';
														}else if($value==0){
															echo '<span><strong>'.$key.'</strong> -Disabled</span>';
														}else{
															echo '<span><strong>'.$key.'</strong> -'.$value.'</span>';
														}
														if($j != $numItems){
															echo ',';
														}
														$j++;
													}
													echo '</td>';
													echo '<td><a class="btn btn-danger" onclick="return confirm(Are You Want To Delete This?)" href="'.BASE_URL.'company/typedelete/?id='.$nusertype->id.'"><i class="fa fa-user-times"></i></a></td>';
													echo '</tr>';
													$i++;
												}
												}?>
											</tbody>
										</table>
									</div>
								</div>
								<div class="tab-pane" id="newuser">
									<form name="comcreateuser" action="<?php echo BASE_URL;?>company/createuser/" id="compcreateuser" method="POST" novalidate="novalidate" aria-required="true">
										<div class="form-group">
											<?php 
											$data = array(
											'type'	  => 'text',
											'class'      => 'form-control bottom-border',
											'id'		=>'name',
											'name'       => 'name',
											'placeholder'	=> 'Enter Your Name',
											'required' => 'required'
											);        
											echo form_input($data);
											?> 
										</div>
										<div class="form-group">
											<?php 
											$data = array(
											'type'	  => 'text',
											'class'      => 'form-control bottom-border',
											'id'		=>'fname',
											'name'       => 'fname',
											'placeholder'	=> 'First Name',
											'required' => 'required'
											);        
											echo form_input($data);
											?> 
										</div>
										<div class="form-group">
											<?php 
											$data = array(
											'type'	  => 'text',
											'class'      => 'form-control bottom-border',
											'id'		=>'lname',
											'name'       => 'lname',
											'placeholder'	=> 'Last Name',
											'required' => 'required'
											);        
											echo form_input($data);
											?> 
										</div>
										<div class="form-group">
											<?php 
											$data = array(
											'type'	  => 'password',
											'class'      => 'form-control bottom-border',
											'name'       => 'password',
											'placeholder'	=> 'Enter Your Password',
											'required' => 'required'
											);        
											echo form_input($data);
											?> 
										</div>
										<div class="form-group">
											<?php 
											$data = array(
											'type'	  => 'email',
											'class'      => 'form-control bottom-border',
											'id'	=>'email_id',
											'name'       => 'email',
											'placeholder'	=> 'Enter Your Email',
											'required' => 'required'
											);        
											echo form_input($data);
											?> 
										</div>
										<div class="form-group">
											<?php 
											$data = array(
											'type'	  => 'text',
											'class'      => 'form-control bottom-border',
											'id'	=>'phone',
											'name'       => 'phone',
											'placeholder'	=> 'Enter Your phone',
											'required' => 'required'
											);        
											echo form_input($data);
											?> 
										</div>
										<div class="form-group">
											<?php if(($companyusertypes !="")&& !empty($companyusertypes)){?>
											<select name="usertype" id="select2" required>
												<option value="">-Select User Type-</option>
												<?php foreach($companyusertypes as $nusertype){?>
													<option value="<?php echo $nusertype->id;?>"><?php echo $nusertype->usertype;?></option>
												<?php }?>
											</select>
											<?php }?>
										</div>
										<div class="form-group">
											<select name="gender" id="select3" required>
												<option value="">-Select gender-</option>
												<option value="male">&nbsp;&nbsp;Male&nbsp;&nbsp;</option>
												<option value="female">&nbsp;Female&nbsp;&nbsp;</option>
											</select>
										</div>
										<div class="form-group">
											<input type="hidden" name="parentid" value="<?php echo $companyid;?>">
											<input type="hidden" name="url" value="<?php echo $secureid;?>">
											<input class="btn btn-success" type="submit" name="company_submit" value="create user">
										</div>
									</form>
								</div>
								<div class="tab-pane" id="edituser">
									<div class="table-responsive">
										<?php if(($compusers !="")&& !empty($compusers)){?>
										<table id="dataTable1" class="table table-bordered table-striped-col">
												<thead>
													<tr>
														<th>Id</th>
														<th>Name</th>
														<th>Email Id</th>
														<th>Phone No</th>
														<th>User Type</th>
														<th>Start date</th>
														<th>Action</th>
														<th>Status</th>
													</tr>
												</thead>
												<tbody>
													<?php
													$k=1; 
													foreach($compusers as $users){
													if($users->customizedusertype !=0){
													$usertype = $this->company_model->getcusertype($users->customizedusertype);
													$date = date_create_from_format('Y-m-d H:i:s', $users ->created);
													$date=date_format($date, 'd-m-Y'); 
													$original = $users->id;
													$secure = rand(100,999).base64_encode($original);
													?>
													<tr>
													<td><?php echo $k;?></td>
													<td><?php echo $users->username;?></td>
													<td><?php echo $users->email;?></td>
													<td><?php echo $users->phone;?></td>
													<td><?php echo $usertype;?></td>
													<td><?php echo $date;?></td>
													<td>
														<ul class="table-options">
															<li><a class=" btn btn-success" href="<?php echo BASE_URL; ?>company/useredit/?id=<?php echo $secure;?>&uid=<?php echo $secureid;?>"  data-target="#userajax" data-toggle="modal" data-id="<?php echo $users->id;?>"><i class="fa fa-user"></i></a></li>
															<li><a class=" btn btn-danger" onclick="return confirm('Are You Want To Delete This?')" href="<?php echo BASE_URL; ?>company/userdelete/?id=<?php echo $secure;?>&uid=<?php echo $secureid;?>"><i class="fa fa-user-times"></i></a></li>
														</ul>
													</td>
													<td>
														<form method="POST" name="compuserstatuschange_<?php echo $users->id;?>" id="compuserstatuschange_<?php echo $users->id;?>" action="<?php echo BASE_URL; ?>company/comstatuschange/">
															<div class="toggle-wrapper">
															   <div class="<?php if($users->status== 1){echo 'leftpanel-toggle';}else{echo 'leftpanel-toggle-off';}?> toggle-light success companyadmin-status" data-id ="<?php echo $users->id;?>"></div>
															</div>
															<input type="hidden" name="compuserid" value="<?php echo $users->id;?>"/>
															<input type="hidden" name="url" value="<?php echo $secureid;?>"/>
															<input type="hidden" name="compuserstatus" id="compuserstatus_<?php echo $users->id;?>" value=""/>
														</form>
													</td>
													</tr>
													<?
													}
													$k++;
													}
													?>
												</tbody>
										</table>
										<?php }else{?>
											<?php echo 'no records found';?>
										<?php }?>
									</div>
								</div>
								<div class="tab-pane" id="newadmin">
									<form name="comcreateadmin" action="<?php echo BASE_URL;?>company/createdataadmin/" id="comcreateadmin" method="POST" novalidate="novalidate" aria-required="true">
										<div class="form-group">
											<?php 
											$data = array(
											'type'	  => 'text',
											'class'      => 'form-control bottom-border',
											'id'		=>'name',
											'name'       => 'name',
											'placeholder'	=> 'Enter Your Name',
											'required' => 'required'
											);        
											echo form_input($data);
											?> 
										</div>
										<div class="form-group">
											<?php 
											$data = array(
											'type'	  => 'text',
											'class'      => 'form-control bottom-border',
											'id'		=>'fname',
											'name'       => 'fname',
											'placeholder'	=> 'First Name',
											'required' => 'required'
											);        
											echo form_input($data);
											?> 
										</div>
										<div class="form-group">
											<?php 
											$data = array(
											'type'	  => 'text',
											'class'      => 'form-control bottom-border',
											'id'		=>'lname',
											'name'       => 'lname',
											'placeholder'	=> 'Last Name',
											'required' => 'required'
											);        
											echo form_input($data);
											?> 
										</div>
										<div class="form-group">
											<?php 
											$data = array(
											'type'	  => 'password',
											'class'      => 'form-control bottom-border',
											'name'       => 'password',
											'placeholder'	=> 'Enter Your Password',
											'required' => 'required'
											);        
											echo form_input($data);
											?> 
										</div>
										<div class="form-group">
											<?php 
											$data = array(
											'type'	  => 'email',
											'class'      => 'form-control bottom-border',
											'id'	=>'email_id',
											'name'       => 'email',
											'placeholder'	=> 'Enter Your Email',
											'required' => 'required'
											);        
											echo form_input($data);
											?> 
										</div>
										<div class="form-group">
											<?php 
											$data = array(
											'type'	  => 'text',
											'class'      => 'form-control bottom-border',
											'id'	=>'phone',
											'name'       => 'phone',
											'placeholder'	=> 'Enter Your phone',
											'required' => 'required'
											);        
											echo form_input($data);
											?> 
										</div>
										<div class="form-group">
											<select name="gender" id="select4" required>
												<option value="">-Select gender-</option>
												<option value="male">&nbsp;&nbsp;Male&nbsp;&nbsp;</option>
												<option value="female">&nbsp;Female&nbsp;&nbsp;</option>
											</select>
										</div>
										<div class="form-group">
											<input type="hidden" name="parentid" value="<?php echo $companyid;?>">
											<input type="hidden" name="url" value="<?php echo $secureid;?>">
											<input class="btn btn-success" type="submit" name="company_submit" value="create dataadmin">
										</div>
									</form>
								</div>
								<div class="tab-pane" id="editadmin">
									<div class="table-responsive">
										<?php if(($compadminsdetails !="")&& !empty($compadminsdetails)){?>
										<table id="dataTable1" class="table table-bordered table-striped-col">
												<thead>
													<tr>
														<th>Id</th>
														<th>Name</th>
														<th>Email Id</th>
														<th>Phone No</th>
														<th>User Type</th>
														<th>Start date</th>
														<th>Action</th>
														<th>Status</th>
													</tr>
												</thead>
												<tbody>
													<?php
													$i=1; 
													foreach($compadminsdetails as $admins){
													//print_r($admins);exit;
													$usertype = $this->company_model->getusertype($admins->type);
													$date = date_create_from_format('Y-m-d H:i:s', $admins ->created);
													$date=date_format($date, 'd-m-Y'); 
													$original = $admins->id;
													$secure = rand(100,999).base64_encode($original);
													?>
													<tr>
													<td><?php echo $i;?></td>
													<td><?php echo $admins->username;?></td>
													<td><?php echo $admins->email;?></td>
													<td><?php echo $admins->phone;?></td>
													<td><?php echo $usertype;?></td>
													<td><?php echo $date;?></td>
													<td>
														<ul class="table-options">
															<li><a class=" btn btn-success" href="<?php echo BASE_URL; ?>company/dataadminedit/?id=<?php echo $secure;?>&uid=<?php echo $secureid;?>"  data-target="#dataadminajax" data-toggle="modal" data-id="<?php echo $admins->id;?>"><i class="fa fa-user"></i></a></li>
															<li><a class=" btn btn-danger" onclick="return confirm('Are You Want To Delete This?')" href="<?php echo BASE_URL; ?>company/userdelete/?id=<?php echo $secure;?>&uid=<?php echo $secureid;?>"><i class="fa fa-user-times"></i></a></li>
														</ul>
													</td>
													<td>
														<form method="POST" name="compuserstatuschange_<?php echo $admins->id;?>" id="compuserstatuschange_<?php echo $admins->id;?>" action="<?php echo BASE_URL; ?>company/comstatuschange/">
															<div class="toggle-wrapper">
															   <div class="<?php if($admins->status== 1){echo 'leftpanel-toggle';}else{echo 'leftpanel-toggle-off';}?> toggle-light success companyadmin-status" data-id ="<?php echo $admins->id;?>"></div>
															</div>
															<input type="hidden" name="compuserid" value="<?php echo $admins->id;?>"/>
															<input type="hidden" name="url" value="<?php echo $secureid;?>"/>
															<input type="hidden" name="compuserstatus" id="compuserstatus_<?php echo $admins->id;?>" value=""/>
														</form>
													</td>
													</tr>
													<?
													$i++;
													}
													?>
												</tbody>
										</table>
										<?php }else{?>
											<?php echo 'no records found';?>
										<?php }?>
									</div>
								</div>
							</div>
						</div>
					</div><!--tab-side-wrapper-->
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
<div class="modal fade" id="dataadminajax" role="basic" aria-hidden="true">
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
<script>
function companycheck(){
	var companyname = $('#cname').val();
	var url = '<?php echo BASE_URL.'company/companyverify/';?>';
			$.ajax({
			   type: "POST",
			   url: url,
			   data: {name:companyname},
			   success: function(data)
			   {
				   if(data == 'false'){
					   $('#cname').css('border','1px solid red');
				   }else{
					   $('#cname').css('border','1px solid #bdc3d1');
				   }
			   }
			 });
			return false;
}
$(document).ready(function() {
	$('body').on('hidden.bs.modal', '.modal', function () {
		$(this).removeData('bs.modal');
	});
	'use strict';

  $('#dataTable1').DataTable();
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
    { 'data': 'name' },
    { 'data': 'position' },
    { 'data': 'office' },
    { 'data': 'start_date'},
    { 'data': 'salary' }
    ],
    'order': [[1, 'asc']]
  });
  $('#exRowTable tbody').on('click', 'td.details-control', function () {
    var tr = $(this).closest('tr');
    var row = exRowTable.row( tr );

    if ( row.child.isShown() ) {
      row.child.hide();
      tr.removeClass('shown');
    } else {
      row.child( format(row.data()) ).show();
      tr.addClass('shown');
    }
  });
	$('#select1, #select2, #select3, #select4').select2();
	$('#account_submit').click(function(){
			var companyname = $('#cname').val();
			if(companyname==''){
				$('#cname').css('border','1px solid red');
				return false;
			}else{
				var url = '<?php echo BASE_URL.'company/companyverify/';?>';
				$.ajax({
				   type: "POST",
				   url: url,
				   data: {name:companyname},
				   success: function(data)
				   {
					   if(data == 'false'){
						   $('#cname').css('border','1px solid red');
					   }else{
						   $('#cname').css('border','1px solid #bdc3d1');
					   }
				   }
				 });
				return false;
			}
		});
});
</script>
