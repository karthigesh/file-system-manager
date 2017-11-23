<div id="index_content">
	<div id="left-col">
		<div class="media leftpanel-profile">
        <div class="media-left">
            <?php if(isset($picture)&&($picture!="")){?>
				<img src="<?php echo BASE_URL;?>images/<?php echo $picture;?>" alt="" class="media-object img-circle">
			<?php }else{?>
				<img src="<?php echo BASE_URL;?>images/avatars/male.png" alt="" class="media-object img-circle">
			<?php }?>
        </div>
        <?php //print_r($userdata);
        $usertype = $this->user_model->getusertype($userdata->type);
        $uid = $userdata->id;
       $secure1 = rand(100,999).base64_encode($uid);
       ?>
        <div class="media-body">
          <h4 class="media-heading"><?php echo $userdata->username;?><a data-toggle="collapse" data-target="#loguserinfo" class="pull-right collapsed" aria-expanded="false"><i class="fa fa-angle-down"></i></a></h4>
          <span><?php echo $usertype;?></span>
        </div>
      </div>
		<div class="leftpanel-userinfo collapse" id="loguserinfo" aria-expanded="false" style="height: 10px;">
        <ul class="list-group">
          <li class="list-group-item">
            <label class="pull-left"><i class="fa fa-lock"></i></label>
            <span class="pull-right"><a href="<?php echo BASE_URL;?>dashboard/">Dashboard</a></span>
          </li>
          <?php if($usertype=='superadmin'){?>
          <li class="list-group-item">
            <label class="pull-left"><i class="fa fa-pencil"></i></label>
            
            <span class="pull-right"><a href="<?php echo BASE_URL;?>admin/useredit/?id=<?php echo $secure1;?>" data-target="#ajax" data-toggle="modal">Edit Profile</a></span>
          </li>
          <li class="list-group-item">
            <label class="pull-left"><i class="fa fa-user"></i></label>
            <span class="pull-right"><a href="<?php echo BASE_URL;?>admin/changeavatar/?id=<?php echo $secure1;?>" data-target="#ajax" data-toggle="modal">Change Avatar</a></span>
          </li>
          <li class="list-group-item">
            <label class="pull-left"><i class="fa fa-asterisk"></i></label>
            <span class="pull-right"><a href="<?php echo BASE_URL;?>admin/changepass/?id=<?php echo $secure1;?>" data-target="#ajax" data-toggle="modal">Change Password</a></span>
          </li>
          <?php }else if($usertype=='companyadmin'){?>
		   <li class="list-group-item">
            <label class="pull-left"><i class="fa fa-pencil"></i></label>
            <span class="pull-right"><a href="<?php echo BASE_URL;?>company/useredit/?id=<?php echo $secure1;?>&uid=<?php echo $secure1;?>" data-target="#userajax" data-toggle="modal">Edit Profile</a></span>
          </li>
          <li class="list-group-item">
            <label class="pull-left"><i class="fa fa-user"></i></label>
            <span class="pull-right"><a href="<?php echo BASE_URL;?>company/changeavatar/?id=<?php echo $secure1;?>&uid=<?php echo $secure1;?>" data-target="#userajax" data-toggle="modal">Change Avatar</a></span>
          </li>
          <li class="list-group-item">
            <label class="pull-left"><i class="fa fa-asterisk"></i></label>
            <span class="pull-right"><a href="<?php echo BASE_URL;?>company/changepass/?id=<?php echo $secure1;?>&uid=<?php echo $secure1;?>" data-target="#userajax" data-toggle="modal">Change Password</a></span>
          </li>
          <?php }?>
          <li class="list-group-item">
            <label class="pull-left"><i class="fa fa-sign-out"></i></label>
            <span class="pull-right"><a href="<?php echo BASE_URL;?>logout">Logout</a></span>
          </li>
        </ul>
      </div>
	<ul class="nav nav-tabs nav-justified nav-sidebar">
		<li class="tooltips active" data-toggle="tooltip" title="" data-original-title="Main Menu"><a data-toggle="tab" data-target="#mainmenu"><i class="tooltips fa fa-ellipsis-h" data-original-title="" title=""></i></a></li>
		<li class="tooltips" data-toggle="tooltip" title="" data-original-title="Log Out" aria-describedby="tooltip79033"><a href="<?php echo BASE_URL;?>logout"><i class="fa fa-sign-out"></i></a></li>
	</ul>
	<div class="tab-content">

        <!-- ################# MAIN MENU ################### -->

        <div class="tab-pane active" id="mainmenu">
		  <ul class="nav">
            <li><a href="<?php echo BASE_URL;?>dashboard"><i class="fa fa-tachometer"></i> <span>Dashboard</span></a></li>
          </ul>
          <ul class="nav">
            <li class="active"><a href="<?php echo BASE_URL;?>admin/users/"><i class="fa fa-building" aria-hidden="true"></i> <span>Companies</span></a></li>
          </ul>
        </div><!-- tab-pane -->
		
      </div>
	</div>
	<div id="right-col">
		<div class="contentpanel">
						<a id="mobilemenu" class="mobilemenu"><i class="fa fa-bars"></i></a>

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
			  <?php echo $this->session->flashdata('adminupdation'); ?> 
			  <h4 class="panel-title">View Company</h4>
			
		  </div>
		  <div class="col-sm-6">
			  <a class=" btn btn-success pull-right" href="<?php echo BASE_URL;?>admin/createcompany" data-target="#ajax" data-toggle="modal" data-id="2">Add Company</a>
		  </div>
		          
        </div>
        <div class="panel-body">
          <div class="table-responsive">
            <table id="dataTable1" class="table table-bordered table-striped-col">
              <thead>
                <tr>
		  <th>Id</th>
                  <th>Name</th>
                  <th>Email Id</th>
                  <th>Phone No</th>
                  <th>Type</th>
                  <th>Start date</th>
                  <th>Action</th>
                  <th>Status</th>
                </tr>
              </thead>

              

              <tbody>
                <?php if(!empty($userdetails))
{
$i=1;
foreach ($userdetails as $user)  { 
$date = date_create_from_format('Y-m-d H:i:s', $user ->created);
$date=date_format($date, 'd-m-Y'); 
$usertype = $this->user_model->getusertype($user->type);
if($user->status!= 2){

$original = $user->id;
$secure = rand(100,999).base64_encode($original);
?>
				
                <tr>
                  <td><?php echo $i;?></td>
                  <td><?php echo $user->username;?></td>
                  <td><?php echo $user->email;?></td>
                  <td><?php echo $user->phone;?></td>
                  <td><?php echo $usertype;?></td>
                  <td><?php echo $date;?></td>
                  <td>
					  <ul class="table-options">
						<li><a class=" btn btn-success" href="<?php echo BASE_URL; ?>admin/useredit/?id=<?php echo $secure;?>"  data-target="#ajax" data-toggle="modal" data-id="<?php echo $user->id;?>"><i class="fa fa-user"></i></a></li>
						<li><a class=" btn btn-danger" onclick="return confirm('Are You Want To Delete This?')" href="<?php echo BASE_URL; ?>admin/userdelete/?id=<?php echo $secure;?>"><i class="fa fa-user-times"></i></a></li>
						<li><a class=" btn btn-success" href="<?php echo BASE_URL; ?>admin/manage_company?id=<?php echo $secure;?>">Manage Company</a></li>
					  </ul>
                  </td>
                  <td>
					  <form method="POST" name="adminstatuschange_<?php echo $user->id;?>" id="adminstatuschange_<?php echo $user->id;?>" action="<?php echo BASE_URL; ?>Admin/astatuschange/">
						<div class="toggle-wrapper">
						   <div class="<?php if($user->status== 1){echo 'leftpanel-toggle';}else{echo 'leftpanel-toggle-off';}?> toggle-light success admin-status" data-id ="<?php echo $user->id;?>"></div>
						</div>
						<input type="hidden" name="adminid" value="<?php echo $user->id;?>"/>
						<input type="hidden" name="adminstatus" id="adminstatus_<?php echo $user->id;?>" value=""/>
					   </form>
				  </td>
                </tr>
               <?php
$i++; 
}
}}else { ?>  <div class="alert alert-success"><button class="close" data-close="alert"></button><span>No Records Found </span></div>   <?php }?>         
              </tbody>
            </table>
          </div>
        </div>
      </div><!-- panel -->
	</div>
</div>

<div class="modal fade" id="ajax" role="basic" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
		</div>
	</div>
</div>
<script>
$(document).ready(function() {
	$('body').on('hidden.bs.modal', '.modal', function () {
   $(this).removeData('bs.modal');
});

  'use strict';

  $('#dataTable1').DataTable();

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

  function format (d) {
    return '<h4>'+d.name+'<small>'+d.position+'</small></h4>'+
    '<p class="nomargin">Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>';
  }

  $('select').select2({ minimumResultsForSearch: Infinity });

});
</script>

