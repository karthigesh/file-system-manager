<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Company extends CI_Controller {
	public function __construct()
	{
		parent::__construct();
		$this->load->model('user_model');
		$this->load->model('company_model');
		$this->load->model('folder_model');
		$this->load->library('upload');
		$this->load->library('image_lib');
		$this->load->helper(array('form', 'url'));
		$userdata= $this->session->userinfo;
		if(!$userdata){
			redirect('login');
		}
	}
	public function companyusers(){
		  $this->load->library('form_validation');
		  $userdata= $this->session->userinfo;
		  $picture= $this->session->picture;
		  $companyid = $userdata->id;
		  $usertype  = $this->user_model->getusertype($userdata->type);
		  $compinfo = $this->user_model->getUser(array("id" => $companyid));
		  $compdetails = ($compinfo->num_rows() > 0) ? $compinfo->result() : FALSE;
		  $compusertype = $this->user_model->getusertype($compdetails[0]->type);
		  $compusers = $this->company_model->get_cusers(array("customizedusertype!="=>0,"type"=>4,"companyid" => $companyid));
		  if($compusers){
			  $compusersdetails = ($compusers->num_rows() > 0) ? $compusers->result() : FALSE;
		  }else{
			  $compusersdetails = "";
		  }
		  $compadmins = $this->company_model->get_cusers(array("type"=>3,"companyid" => $companyid));
		  if($compadmins){
			  $compadminsdetails = ($compadmins->num_rows() > 0) ? $compadmins->result() : FALSE;
		  }else{
			  $compadminsdetails = "";
		  }
		  $this->form_validation->set_rules('email','email','required|valid_email|is_unique[user_master.email]');
		  $this->form_validation->set_rules('name','name','required|is_unique[user_master.username]');
		  $companynamedetails = $this->company_model->getCompanydetails($companyid);
		  if($companynamedetails != false){
			 $companynamedetails =$companynamedetails;
		  }else{
			$companynamedetails = "";
		  }
		  $companyusertype = $this->company_model->getCompanyusertype($companyid);
		  if($companyusertype != false){
			 $companyusertype =$companyusertype;
		  }else{
			$companyusertype = "";
		  }
		  $cdefaultusertype = $this->company_model->getdefaultusertype();
		  if($cdefaultusertype != false){
			 $cdefaultusertype =$cdefaultusertype;
		  }else{
			$cdefaultusertype = "";
		  }  
		  if($compdetails){
		  $data = array(
			'view_file'     =>'companyusers',
			'current_menu'  =>'companyusers',
			'site_title'    =>'File System Portal',
			'title'         =>'Company Users',
			'content_title' =>'Company Users',
			'secureid'		=>$companyid,
			'userdata'		=>$userdata,
			'usertype'		=>$usertype,
			'compusertype'	=>$compusertype,
			'companyid'		=> $companyid,
			'compdetails'   => $compdetails,
			'compusers'		=> $compusersdetails,
			'company'		=> $companynamedetails,
			'companyusertypes'		=> $companyusertype,
			'cdefaultusertype'		=> $cdefaultusertype,
			'compadminsdetails'		=> $compadminsdetails,
			'picture'		=> $picture,
			'files'         => array(
								"css"=> array(
									"lib/jquery-toggles/toggles-full.css",
									"lib/datatables-plugins/integration/bootstrap/3/dataTables.bootstrap.css",
									"lib/select2/select2.css",
									"lib/summernote/summernote.css",
									"lib/bootstrap3-wysihtml5-bower/bootstrap3-wysihtml5.css",
								),
								"js" => array(
									"lib/datatables/jquery.dataTables.js",
									"lib/datatables-plugins/integration/bootstrap/3/dataTables.bootstrap.js",
									"lib/select2/select2.js",
									"lib/jquery-toggles/toggles.js",
									"lib/wysihtml5x/wysihtml5x.js",
									"lib/wysihtml5x/wysihtml5x-toolbar.js",
									"lib/summernote/summernote.js",
									"lib/bootstrap3-wysihtml5-bower/bootstrap3-wysihtml5.all.js",
									"js/quirk.js",
									"js/jquery.validate.min.js"
									)
								)
			);
			$this->template->load_comcreate_template($data);
		}else{
			redirect('login');
		}
		  
	  }
	  public function emailverify(){
		if ($this->input->post("email") != "")
		{
			$userinfo = $this->user_model->emailauth($this->input->post("email"));
			if($userinfo==1){
				echo 'false';
			}else{
				echo 'true';
			}
		}
		else
		{
			echo 'true'; //invalid post var
		}
		}
	  public function userverify(){
		if ($this->input->post("name") != "")
		{
			$userinfo = $this->user_model->nameauth($this->input->post("name"));
			if($userinfo==1){
				echo 'false';
			}else{
				echo 'true';
			}
		}
		else
		{
			echo 'true'; //invalid post var
		}
	}
	  public function companyverify(){
		$userdata= $this->session->userinfo;
		$companyid = $userdata->companyid;
		if ($this->input->post("name") != "")
		{
			$cname = str_replace(' ', '-',strtolower($this->input->post("name")));
			$userinfo = $this->company_model->companyauth($cname,$companyid);
			if($userinfo==1){
				echo 'false';
			}else{
				echo 'true';
			}
		}
		else
		{
			echo 'true'; 
		}
	}
	  public function createuser(){
		  
		  if($this->input->post('usertype')){
			  $customizeusertype = $this->input->post('usertype');
		  }else{
			  $customizeusertype = 1;
		  }
		  $data = array(
			'username'=>$this->input->post('name'),
			'first_name'=> $this->input->post('fname'),
			'last_name'=>$this->input->post('lname'),
			'email'=>$this->input->post('email'),
			'phone'=>$this->input->post('phone'),
			'gender'=>$this->input->post('gender'),
			'password'=>MD5($this->input->post('password')),
			'status'=>1,
			'type'=>4,
			'customizedusertype'=> $customizeusertype,
			'companyid'=>$this->input->post('parentid'),
			'created'=>date('Y-m-d H:i:s')
		 );
		 $url = $this->input->post('url');
		 $companyid = $this->user_model->insert_user($data);
		 if($companyid){
			  $this->session->set_flashdata('companyuserupdation', '<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><span>Company User '.$this->input->post('name').' has been created successfully </span></div>');
		  }else{
			 $this->session->set_flashdata('companyuserupdation', '<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><span>Company User '.$this->input->post('name').' has not been saved.Please try again </span></div>');
		  }
		  redirect('company/companyusers?id='.$url);
		  exit;
	  }
	  public function comstatuschange(){
		  $url = $this->input->post('url');
		  $adminid = $this->input->post('compuserid');
		  $status = $this->input->post('compuserstatus');
		  if($status == 'ON'){
			  $newstatus = 1;
		  }else if($status == 'OFF'){
			  $newstatus = 0;
		  }
		  $data = array(
				'status' => $newstatus
			);
		  $statuschange = $this->user_model->update_user_status($adminid , $data);
		  if($statuschange){
			  if($statuschange->status == 1){
				  $this->session->set_flashdata('companyuserupdation', '<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><span>User '.$statuschange->username.' has been activated successfully </span></div>');
			  }else if($statuschange->status == 0){
				  $this->session->set_flashdata('companyuserupdation', '<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><span>User '.$statuschange->username.' has been deactivated successfully </span></div>');
			  }
			  redirect('company/companyusers?id='.$url);
		  }
	  }
	  public function useredit(){
		  $userdata= $this->session->userinfo;
		  $picture= $this->session->picture;
		  $companyid = $userdata->companyid;
		  $getid = $_GET['id'];
		  $parentuserid = $userdata->id;
		  $unsecure = substr($getid,3);
		  $userid = base64_decode($unsecure);
		  $userinfo = $this->user_model->getUser(array("id" => $userid));
		  $userdetails = ($userinfo->num_rows() > 0) ? $userinfo->row() : FALSE;
		  $new = substr($parentuserid,3);
		  $companyid = base64_decode($new);
		  $companyusertype = $this->company_model->getCompanyusertype($companyid);
		  if($companyusertype != false){
			 $companyusertype =$companyusertype;
		  }else{
			$companyusertype = "";
		  }
		  $data = array(
			'view_file'     =>'editeachcompuser',
			'userdetails' => $userdetails,
			'editid' => $parentuserid,
			'companyusertype'=> $companyusertype,
			'files'         => array(
								"css"=> array(
									"lib/jquery-toggles/toggles-full.css",
									"lib/datatables-plugins/integration/bootstrap/3/dataTables.bootstrap.css",
									"lib/select2/select2.css"
								),
								"js" => array(
									"lib/datatables/jquery.dataTables.js",
									"lib/datatables-plugins/integration/bootstrap/3/dataTables.bootstrap.js",
									"lib/select2/select2.js",
									"lib/jquery-toggles/toggles.js",
									"js/quirk.js"
									)
								)
			);
			$this->template->load_edituser_template($data);
	  }
	  public function profileedit(){
		  $getid = $_GET['id'];
		  $parentuserid = $_GET['uid'];
		  $unsecure = substr($getid,3);
		  $userid = base64_decode($unsecure);
		  $userinfo = $this->user_model->getUser(array("id" => $userid));
		  $userdetails = ($userinfo->num_rows() > 0) ? $userinfo->row() : FALSE;
		  $new = substr($parentuserid,3);
		  $companyid = base64_decode($new);
		  $companyusertype = $this->company_model->getCompanyusertype($companyid);
		  if($companyusertype != false){
			 $companyusertype =$companyusertype;
		  }else{
			$companyusertype = "";
		  }
		  $data = array(
			'view_file'     =>'editeachprofile',
			'userdetails' => $userdetails,
			'editid' => $parentuserid,
			'companyusertype'=> $companyusertype,
			'files'         => array(
								"css"=> array(
									"lib/jquery-toggles/toggles-full.css",
									"lib/datatables-plugins/integration/bootstrap/3/dataTables.bootstrap.css",
									"lib/select2/select2.css"
								),
								"js" => array(
									"lib/datatables/jquery.dataTables.js",
									"lib/datatables-plugins/integration/bootstrap/3/dataTables.bootstrap.js",
									"lib/select2/select2.js",
									"lib/jquery-toggles/toggles.js",
									"js/quirk.js"
									)
								)
			);
			$this->template->load_edituser_template($data);
	  }
	  public function editsave(){
		  $url = $this->input->post('url');
		  $unsecure = substr($url,3);
		  $parentid = base64_decode($unsecure);
		  $data = array(
			'username'=>$this->input->post('name'),
			'first_name'=> $this->input->post('fname'),
			'last_name'=>$this->input->post('lname'),
			'gender'=>$this->input->post('gender'),
			'email'=>$this->input->post('email'),
			'phone'=>$this->input->post('phone'),
			'companyid'=>$parentid,
			'type'=>4,
			'customizedusertype'=>$this->input->post('usertype'),
			'status'=>$this->input->post('status'),
			'modified'=>date('Y-m-d H:i:s')
		 );		 
		 $userid = $this->input->post('userid');
		 $username = $this->input->post('name');
		 $userupdated = $this->user_model->updateUser($data,array('id'=>$userid));
		 if($userupdated==1){
			  $this->session->set_flashdata('companyuserupdation', '<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><span>User '.$username.' has been saved successfully </span></div>');
		 }else{
			 $this->session->set_flashdata('companyuserupdation', '<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><span>User '.$username.' has not been saved.Please try again </span></div>');
		 }
		 redirect('company/companyusers?id='.$url);
	  }
	  public function profilesave(){
		  $url = $this->input->post('url');
		  $unsecure = substr($url,3);
		  $parentid = base64_decode($unsecure);
		  $data = array(
			'username'=>$this->input->post('name'),
			'first_name'=> $this->input->post('fname'),
			'last_name'=>$this->input->post('lname'),
			'gender'=>$this->input->post('gender'),
			'email'=>$this->input->post('email'),
			'phone'=>$this->input->post('phone'),
			'companyid'=>$parentid,
			'status'=>$this->input->post('status'),
			'modified'=>date('Y-m-d H:i:s')
		 );		 
		 $userid = $this->input->post('userid');
		 $username = $this->input->post('name');
		 $userupdated = $this->user_model->updateUser($data,array('id'=>$userid));
		 if($userupdated==1){
			  $this->session->set_flashdata('companyuserupdation', '<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><span>'.$username.' profile has been saved successfully </span></div>');
		 }else{
			 $this->session->set_flashdata('companyuserupdation', '<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><span>'.$username.' profile has not been saved.Please try again </span></div>');
		 }
		 redirect('company/companyusers');
	  }
	  public function userdelete(){
		  $getid = $_GET['id'];
		  $url = $_GET['uid'];
		  $unsecure = substr($getid,3);
		  $userid = base64_decode($unsecure);
		  $deleteadmin = $this->user_model->delete_user($userid);
		  $userinfo = $this->user_model->getUser(array("id" => $userid));
		  $userdetails = ($userinfo->num_rows() > 0) ? $userinfo->row() : FALSE;
		  if($deleteadmin==1){
			  $this->session->set_flashdata('companyuserupdation', '<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><span>User '.$userdetails->username.' has been deleted successfully </span></div>');
		  }else{
			 $this->session->set_flashdata('companyuserupdation', '<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><span>User '.$username.' has not been saved.Please try again </span></div>');
		  }
		  redirect('company/companyusers');
	  }
	  public function accountsave(){
			$config['upload_path'] = FCPATH.'images/';
			$config['allowed_types'] = 'gif|jpg|png|jpeg';
			$this->upload->initialize($config);
			$this->load->library('upload', $config);
			if ( ! $this->upload->do_upload('picture'))
			{
				$error = array('error' => $this->upload->display_errors());

				
			}
			else
			{
				$data = array('upload_data' => $this->upload->data());

				
			}
			 if($_FILES['picture']['name']!= '')
			{
				$picture=$_FILES['picture']['name'];
				$upload_data = $this->upload->data(); 
				$picturename = $upload_data['file_name'];   

			}   
			else
			{
				$picturename = $this->input->post('picture'); 
			}
			$url = $this->input->post('url');
			$parentid = $this->input->post('parentid');
			$cname = $this->input->post('cname');
			
			$data=array(
					'company_id'	=>	$this->input->post('parentid'),
					'name'			=>	str_replace(' ', '-', strtolower($cname)),
					'picture'		=>	$picturename,
					'splashscreen'	=>	$this->input->post('splashscreen'),
					//'links'=>$this->input->post('password'),
					);
			$companyget = $this->company_model->getCompanydetails($parentid);
			if($companyget=='-1'){
				$companyinsert = $this->company_model->insertCompanydetails($data);
				$this->session->set_flashdata('companyuserupdation', '<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><span>Account details has been created successfully </span></div>');
			}else{
			$companyupdated = $this->company_model->updateCompanydetails($data,array('company_id'=>$parentid));
				$this->session->set_flashdata('companyuserupdation', '<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><span>Account details has been updated successfully </span></div>');
			}
			redirect('company/companyusers');
		}
	public function changeavatar(){
		 $getid = $_GET['id'];
		 $data = array(
			'view_file'     =>'changecavatar',
			'current_menu'  =>'changecavatar',
			'site_title'    =>'File System Portal',
			'title'         =>'changecavatar',
			'content_title' =>'changecavatar',
			'userid'		=> $getid
			);
			$this->template->load_adminuser_template($data);
	  }
	  public function avatarsave(){
			$config['upload_path'] = FCPATH.'images/';
			$config['allowed_types'] = 'gif|jpg|png|jpeg';
			$this->upload->initialize($config);
			$this->load->library('upload', $config);
			$getid = $this->input->post('userid');
			$unsecure = substr($getid,3);
			$userid = base64_decode($unsecure);
			if ( ! $this->upload->do_upload('picture'))
			{
				$error = array('error' => $this->upload->display_errors());
				$this->session->set_flashdata('companyuserupdation', '<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><span>Avatar has not been updated successfully </span></div>');
				redirect('company/companyusers');
			}
			else
			{
				$data = array('upload_data' => $this->upload->data());
				
			}
			 if($_FILES['picture']['name']!= '')
			{
				$picture=$_FILES['picture']['name'];
				$upload_data = $this->upload->data(); 
				$picturename = $upload_data['file_name'];   

			}
			$data=array(
					'picture'=>	$picturename,
					);
			$this->session->set_userdata('picture', $picturename);
			$userupdated = $this->user_model->updateUser($data,array('id'=>$userid));
			if($userupdated==1){
			  $this->session->set_flashdata('companyuserupdation', '<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><span>Avatar has been updated successfully </span></div>');
			}
			redirect('company/companyusers');
	  }
	  public function changepass(){
		 $getid = $_GET['id'];
		 $data = array(
			'view_file'     =>'changecpass',
			'current_menu'  =>'changepass',
			'site_title'    =>'File System Portal',
			'title'         =>'changepass',
			'content_title' =>'changepass',
			'userid'		=> $getid,
			);
			$this->template->load_adminuser_template($data);
	  }
	  public function passreset(){
		$getid = $this->input->post('userid');
		$unsecure = substr($getid,3);
		$userid = base64_decode($unsecure);
		$password = $this->input->post('password');
		$data=array(
					'password'=>MD5($password),
					);
		$userupdated = $this->user_model->updateUser($data,array('id'=>$userid));
		if($userupdated==1){
			  $this->session->set_flashdata('companyuserupdation', '<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><span>Password has been updated successfully </span></div>');
			}
		redirect('company/companyusers');
	  }
	  public function userini(){
		  $userdata= $this->session->userinfo;
		  $userid = $userdata->id;
		  $cuserid = $userdata->companyid;
		  $data = array(
			'view_file'     =>'inisettings',
			'title'         =>'inisettings',
			'userid'		=> $userid,
			'companyid' => $cuserid,
			);
			$this->template->load_adminuser_template($data);
		  
	  }
	  public function inisave(){
		  $config['upload_path'] = FCPATH.'inifiles/';
		  $config['allowed_types'] = '*';
		  $getid = $this->input->post('userid');
		  $this->upload->initialize($config);  
		  $this->load->library('upload', $config);
			if ( ! $this->upload->do_upload('inifile'))
			{
				$error = array('error' => $this->upload->display_errors());
				$this->session->set_flashdata('companyuserupdation', '<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><span>configuration file is not successful </span></div>');
				redirect('company/companyusers');
			}
			else
			{
				$data = array('upload_data' => $this->upload->data());
				
			}
			 if($_FILES['inifile']['name']!= '')
			{
				$picture=$_FILES['inifile']['name'];
				$upload_data = $this->upload->data(); 
				$picturename = $upload_data['file_name'];
			}
			$parsedini = parse_ini_file($config['upload_path'].$picturename);
			$companyid = $this->input->post('companyid');
			$data = array(
			'cid'			=>$companyid,
			'ini'			=>serialize($parsedini)
			);
			$userupdated = $this->company_model->updateini($data,array('cid'=>$companyid));
			$this->session->set_flashdata('companyuserupdation', '<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><span>configuration file updated successful </span></div>');
				redirect('company/companyusers');
	  }
	  public function uploaduser(){
		  $config['upload_path'] = FCPATH.'xmlfiles/';
		  $config['allowed_types'] = '*';  
		  $this->load->helper('xml');
		  $this->upload->initialize($config);  
		  $this->load->library('upload', $config);
			if ( ! $this->upload->do_upload('userxml'))
			{
				$error = array('error' => $this->upload->display_errors());
				$this->session->set_flashdata('companyuserupdation', '<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><span>user file upload is not successful </span></div>');
				redirect('company/companyusers');
			}
			else
			{
				$data = array('upload_data' => $this->upload->data());
				
			}
			 if($_FILES['userxml']['name']!= '')
			{
				$picture=$_FILES['userxml']['name'];
				$upload_data = $this->upload->data(); 
				$picturename = $upload_data['file_name'];
			}
			$parentadmin = $this->input->post('parentid');
			$filepath = $config['upload_path'].$picturename;
			$xml=@simplexml_load_file($filepath);
			$arr = json_decode(json_encode($xml), TRUE);
			$data = $arr['customizeduser'];
			$userupdated = $this->company_model->updatexml($data,array('usertype'=>$arr['name'],'cid'=>$parentadmin));
			$this->session->set_flashdata('companyuserupdation', '<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><span>User type updated successfully </span></div>');
			redirect('company/companyusers');
	  }
	  public function folders(){
		  $this->load->library('form_validation');
		  $this->load->helper('directory');
		  $userdata= $this->session->userinfo;
		  $picture= $this->session->picture;
		  $record_num = $this->uri->segment_array();
		  $foldername = end($record_num);
		  if($foldername=='folders'){
			  $companyid = $userdata->id;
			  $usertype  = $this->user_model->getusertype($userdata->type);
			  $compinfo = $this->user_model->getUser(array("id" => $companyid));
			  $compdetails = ($compinfo->num_rows() > 0) ? $compinfo->result() : FALSE;
			  $companynamedetails = $this->company_model->getCompanydetails($companyid);
			  $folderget = $this->folder_model->getfolder(array('owner'=>$companyid,'parent='=>""),'','','folder_name','ASC');
			  if($folderget !=""){
				$folders = ($folderget->num_rows() > 0) ? $folderget->result() : FALSE;
			  }else{
				$folders = "";
			  }
			  $filesget = $this->folder_model->getfiles(array('owner'=>$companyid,'directory'=>$foldername),'','','name','ASC');
			  if($filesget !=""){
				$files = ($filesget->num_rows() > 0) ? $filesget->result() : FALSE;
			  }else{
				$files = "";
			  }
			  $requestper = $this->company_model->getrequest();
			  if($requestper !=""){
				$requestperdetails = ($requestper->num_rows() > 0) ? $requestper->result() : FALSE;
			  }else{
				$requestperdetails = "";
			  }			  
			  $filerequest = $this->company_model->getfilerequest();
			  if($filerequest !=""){
				$filerequestdetails = ($filerequest->num_rows() > 0) ? $filerequest->result() : FALSE;
			  }else{
				$filerequestdetails = "";
			  }  
			  $dir = FCPATH. "folders/";
			  $filepath = BASE_URL."folders/";
			  if($companynamedetails != false){
				 $companynamedetails =$companynamedetails;
			  }else{
				$companynamedetails = "";
			  }
			  $companyini = $this->company_model->get_ini($companyid);
			  if($compdetails){
			  $data = array(
				'view_file'     	=>'folders',
				'current_menu'  	=>'folders',
				'site_title'    	=>'File System Portal',
				'title'         	=>'Company Folders',
				'content_title' 	=>'Company Folders',
				'userdata'			=>$userdata,
				'usertype'			=>$usertype,
				'companyid'			=> $companyid,
				'compdetails'   	=> $compdetails,
				'company'			=> $companynamedetails,
				'requests'			=> $requestperdetails,
				'filerequests'		=> $filerequestdetails,
				'filepath'			=> $filepath,
				'mapfolders'		=> $folders,
				'mapfiles'			=> $files,
				'picture'			=> $picture,
				'ini'				=> $companyini,
				'files'         	=> array(
									"css"=> array(
										"css/dropzone.css",
										"lib/datatables-plugins/integration/bootstrap/3/dataTables.bootstrap.css",
										"lib/jquery-toggles/toggles-full.css",
									),
									"js" => array(
										"js/dropzone.js",
										"lib/datatables/jquery.dataTables.js",
										"lib/datatables-plugins/integration/bootstrap/3/dataTables.bootstrap.js",
										"lib/jquery-toggles/toggles.js",
										"js/quirk.js",
										"js/jquery.validate.min.js"
										)
									)
				);
				$this->template->load_folder_template($data);
			}else{
				redirect('login');
			}
			}else{
				$userdata= $this->session->userinfo;
				$companyid = $userdata->id;
				$this->load->helper('directory');
				$record_num = $this->uri->segment_array();
				$foldername = end($record_num);
				$folderset = $this->folder_model->folderid($foldername);
				$parentfolderid = $folderset->id;
				$folderget = $this->folder_model->getfolder(array('owner'=>$companyid,'parent='=>$parentfolderid),'','','folder_name','ASC');
				$companyini = $this->company_model->get_ini($companyid);
				if($folderget !=""){
					$folders = ($folderget->num_rows() > 0) ? $folderget->result() : FALSE;
				}else{
					$folders = "";
				}  
				$filesget = $this->folder_model->getfiles(array('owner'=>$companyid,'directory'=>$foldername),'','','name','ASC');
				if($filesget !=""){
					$files = ($filesget->num_rows() > 0) ? $filesget->result() : FALSE;
				}else{
					$files = "";
				}
				$requestper = $this->company_model->getrequest();
				  if($requestper !=""){
					$requestperdetails = ($requestper->num_rows() > 0) ? $requestper->result() : FALSE;
				  }else{
					$requestperdetails = "";
				  }			  
				  $filerequest = $this->company_model->getfilerequest();
				  if($filerequest !=""){
					$filerequestdetails = ($filerequest->num_rows() > 0) ? $filerequest->result() : FALSE;
				  }else{
					$filerequestdetails = "";
				  }  
				  $usertype  = $this->user_model->getusertype($userdata->type);
				  $compinfo = $this->user_model->getUser(array("id" => $companyid));
				  $compdetails = ($compinfo->num_rows() > 0) ? $compinfo->result() : FALSE;
				  $companynamedetails = $this->company_model->getCompanydetails($companyid);
				  if($companynamedetails != false){
					 $companynamedetails =$companynamedetails;
				  }else{
					$companynamedetails = "";
				  }
				  if($compdetails){
				  $data = array(
					'view_file'     	=>'folderfiles',
					'current_menu'  	=>'folders',
					'site_title'    	=>'File System Portal',
					'title'         	=>'Company Folders',
					'content_title' 	=>'Company Folders',
					'userdata'			=> $userdata,
					'usertype'			=> $usertype,
					'companyid'			=> $companyid,
					'compdetails'   	=> $compdetails,
					'foldername'		=> $foldername,
					'parentfoldername'	=> $foldername,
					'company'			=> $companynamedetails,
					'requests'			=> $requestperdetails,
					'filerequests'		=> $filerequestdetails,
					'mapfolders'		=> $folders,
					'mapfiles'			=> $files,
					'picture'			=> $picture,
					'ini'				=> $companyini,
					'files'         	=> array(
										"css"=> array(
											"lib/jquery-toggles/toggles-full.css",
											"lib/datatables-plugins/integration/bootstrap/3/dataTables.bootstrap.css",
											"css/dropzone.css"
										),
										"js" => array(
											"lib/datatables/jquery.dataTables.js",
											"lib/datatables-plugins/integration/bootstrap/3/dataTables.bootstrap.js",
											"lib/jquery-toggles/toggles.js",
											"js/dropzone.js",
											"js/quirk.js",
											"js/jquery.validate.min.js"
											)
										)
					);
					$this->template->load_folder_template($data);
			}
		  }
		}
	  public function typedelete(){
		  $typeid = $_GET['id'];
		  $deleteusertype = $this->company_model->deleteusertype($typeid);
		  $this->session->set_flashdata('companyuserupdation', '<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><span>User type deleted successfully </span></div>');
		  redirect('company/companyusers');
	  }
	  public function dataadminedit(){
		  $getid = $_GET['id'];
		  $parentuserid = $_GET['uid'];
		  $unsecure = substr($getid,3);
		  $userid = base64_decode($unsecure);
		  $userinfo = $this->user_model->getUser(array("id" => $userid));
		  $userdetails = ($userinfo->num_rows() > 0) ? $userinfo->row() : FALSE;
		  $data = array(
			'view_file'     =>'editeachdataadmin',
			'userdetails' => $userdetails,
			'editid' => $parentuserid,
			'files'         => array(
								"css"=> array(
									"lib/jquery-toggles/toggles-full.css",
									"lib/datatables-plugins/integration/bootstrap/3/dataTables.bootstrap.css",
									"lib/select2/select2.css"
								),
								"js" => array(
									"lib/datatables/jquery.dataTables.js",
									"lib/datatables-plugins/integration/bootstrap/3/dataTables.bootstrap.js",
									"lib/select2/select2.js",
									"lib/jquery-toggles/toggles.js",
									"js/quirk.js"
									)
								)
			);
			$this->template->load_edituser_template($data);
	  }
	  public function createdataadmin(){
		  $data = array(
			'username'=>$this->input->post('name'),
			'first_name'=> $this->input->post('fname'),
			'last_name'=>$this->input->post('lname'),
			'email'=>$this->input->post('email'),
			'phone'=>$this->input->post('phone'),
			'password'=>MD5($this->input->post('password')),
			'gender'=>$this->input->post('gender'),
			'status'=>1,
			'type'=>3,
			'customizedusertype'=>0,
			'companyid'=>$this->input->post('parentid'),
			'created'=>date('Y-m-d H:i:s')
		 );
		 $url = $this->input->post('url');
		 $companyid = $this->user_model->insert_user($data);
		 if($companyid){
			  $this->session->set_flashdata('companyuserupdation', '<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><span>Company Dataadmin '.$this->input->post('name').' has been created successfully </span></div>');
		  }else{
			 $this->session->set_flashdata('companyuserupdation', '<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><span>Company Dataadmin '.$this->input->post('name').' has not been saved.Please try again </span></div>');
		  }
		  redirect('company/companyusers');
		  exit;
	  }
	  public function savedataadmin(){
		  $url = $this->input->post('url');
		  $unsecure = substr($url,3);
		  $companyid = base64_decode($unsecure);
		  $data = array(
			'username'=>$this->input->post('name'),
			'first_name'=> $this->input->post('fname'),
			'last_name'=>$this->input->post('lname'),
			'email'=>$this->input->post('email'),
			'phone'=>$this->input->post('phone'),
			'password'=>MD5($this->input->post('password')),
			'gender'=>$this->input->post('gender'),
			'status'=>1,
			'type'=>3,
			'customizedusertype'=>0,
			'companyid'=>$companyid,
			'created'=>date('Y-m-d H:i:s')
		 );
		 $userid = $this->input->post('userid');
		 $userupdated = $this->user_model->updateUser($data,array('id'=>$userid));
		 if($userupdated){
			  $this->session->set_flashdata('companyuserupdation', '<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><span>Company Dataadmin '.$this->input->post('name').' has been created successfully </span></div>');
		  }else{
			 $this->session->set_flashdata('companyuserupdation', '<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><span>Company Dataadmin '.$this->input->post('name').' has not been saved.Please try again </span></div>');
		  }
		  redirect('company/companyusers');
		  exit;
	  }
	  public function updatedataadmin(){
		  $url = $this->input->post('url');
		  $unsecure = substr($url,3);
		  $companyid = base64_decode($unsecure);
		  $data = array(
			'username'=>$this->input->post('name'),
			'first_name'=> $this->input->post('fname'),
			'last_name'=>$this->input->post('lname'),
			'email'=>$this->input->post('email'),
			'phone'=>$this->input->post('phone'),
			'password'=>MD5($this->input->post('password')),
			'gender'=>$this->input->post('gender'),
			'status'=>1,
			'type'=>3,
			'customizedusertype'=>0,
			'companyid'=>$companyid,
			'created'=>date('Y-m-d H:i:s')
		 );
		 $userid = $this->input->post('userid');
		 $userupdated = $this->user_model->updateUser($data,array('id'=>$userid));
		 if($userupdated){
			  $this->session->set_flashdata('companyuserupdation', '<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><span>Company Dataadmin '.$this->input->post('name').' has been updated successfully </span></div>');
		  }else{
			 $this->session->set_flashdata('companyuserupdation', '<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><span>Company Dataadmin '.$this->input->post('name').' has not been updated.Please try again </span></div>');
		  }
		  redirect('company/companyusers');
		  exit;
	  }
	  public function fileupload(){
		  $getid = $_GET['uid'];
		  $userini = $this->company_model->get_ini($getid);
		  if(isset($_GET['folder'])){
			$data = array(
			'view_file'     =>'subuploadfiles',
			'folder'		=> $_GET['folder'],
			'ini'		=> $userini,
			'hiddenid' => $getid,
			'files'         => array(
								"css"=> array(
									"lib/jquery-toggles/toggles-full.css",
									"lib/datatables-plugins/integration/bootstrap/3/dataTables.bootstrap.css",
									"lib/select2/select2.css"
								),
								"js" => array(
									"lib/datatables/jquery.dataTables.js",
									"lib/datatables-plugins/integration/bootstrap/3/dataTables.bootstrap.js",
									"lib/select2/select2.js",
									"lib/jquery-toggles/toggles.js",
									"js/quirk.js"
									)
								)
			);
		  }else{
			$userini = $this->company_model->get_ini($getid);
		 if($userini !=""){
		  $data = array(
			'view_file'     =>'uploadfiles',
			'hiddenid' => $getid,
			'ini'		=> $userini,
			'files'         => array(
								"css"=> array(
									"lib/jquery-toggles/toggles-full.css",
									"lib/datatables-plugins/integration/bootstrap/3/dataTables.bootstrap.css",
									"lib/select2/select2.css"
								),
								"js" => array(
									"lib/datatables/jquery.dataTables.js",
									"lib/datatables-plugins/integration/bootstrap/3/dataTables.bootstrap.js",
									"lib/select2/select2.js",
									"lib/jquery-toggles/toggles.js",
									"js/quirk.js"
									)
								)
			);
		}else{
			$data = array(
			'view_file'     =>'uploadfiles',
			'hiddenid' 		=> $getid,
			'files'         => array(
								"css"=> array(
									"lib/jquery-toggles/toggles-full.css",
									"lib/datatables-plugins/integration/bootstrap/3/dataTables.bootstrap.css",
									"lib/select2/select2.css"
								),
								"js" => array(
									"lib/datatables/jquery.dataTables.js",
									"lib/datatables-plugins/integration/bootstrap/3/dataTables.bootstrap.js",
									"lib/select2/select2.js",
									"lib/jquery-toggles/toggles.js",
									"js/quirk.js"
									)
								)
			);
		}
			}
			$this->template->load_simple_template($data);
	  }
	  public function savefiles(){
			$userdata= $this->session->userinfo;
			$companyid = $userdata->id;
			$config['upload_path'] = FCPATH.'folders/';
			$config['allowed_types'] = '*';
			//$config['allowed_types'] = 'gif|jpg|png|jpeg|pdf|doc|docx|txt|mpeg|avi|mov|webm|flv|mp4|mp3|aiff|aif|au|avi|bat';
			$this->upload->initialize($config);
			if ( ! $this->upload->do_upload('picture'))
			{
				$error = array('error' => $this->upload->display_errors());
				$this->session->set_flashdata('companyfolderupdation', '<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><span>The file '.$picturename.' has notbeen uploaded succesfully.</span></div>');
				redirect('company/folders');
			}
			else
			{
				$data = array('upload_data' => $this->upload->data());
				
			}
			if(is_file($config['upload_path']))
			{
				chmod($config['upload_path'], 777); 
			}
			 if($_FILES['picture']['name']!= '')
			{
				$picture=$_FILES['picture']['name'];
				$upload_data = $this->upload->data(); 
				$picturename = $upload_data['file_name'];   

			}
			$getfiletype = explode('/',$upload_data['file_type']);
			$filetype = $getfiletype[0];
			if(($upload_data['is_image']==1)){
				/***** for the medium without watermark****/
				$config = array(
				'source_image'      => $upload_data['full_path'], //path to the uploaded image
				'new_image'         => FCPATH.'/lowresolution/plain/', //path to
				'maintain_ratio'    => true,
				'width'             => 500,
				'height'            => 500
				);
				$this->image_lib->clear();
				$this->image_lib->initialize($config);
				$this->image_lib->resize();
				/***** for the medium with watermark****/
				$config1 = array(
				'source_image'      => $upload_data['full_path'], //path to the uploaded image
				'new_image'         => FCPATH.'/lowresolution/watermark/', //path to
				'maintain_ratio'    => true,
				'width'             => 500,
				'height'            => 500
				);
				$this->image_lib->clear();
				$this->image_lib->initialize($config1);
				$resize1 = $this->image_lib->resize();
				$lowres = $upload_data['raw_name'].$upload_data['file_ext'];
				if($resize1){
					/*****for the watermark images*****/
					$config2['source_image'] = $config1['new_image'].$lowres;
					$config2['wm_text'] = 'FSP';
					$config2['wm_font_path'] = './fonts/LiberationSerif-Regular.ttf';
					$config2['wm_type'] = 'text';
					$config2['wm_font_size'] = '40';
					$config2['wm_font_color'] = '000';
					$config2['wm_vrt_alignment'] = 'middle';
					$config2['wm_hor_alignment'] = 'center';
					$config2['wm_hor_offset'] = '0';
					$config2['wm_vrt_offset'] = '0';
					$this->image_lib->clear();
					$this->image_lib->initialize($config2);
					$this->image_lib->watermark();
					//echo $this->image_lib->display_errors();exit;
				}
				/*****for the thumbnail image*****/
				$source_image = $upload_data['full_path'];
				$config3['image_library'] = 'gd2';
				$config3['source_image'] = $source_image;
				$config3['create_thumb'] = TRUE;
				$config3['maintain_ratio'] = TRUE;
				$config3['file_permissions'] = 0644;
				$config3['new_image'] = FCPATH.'/thumbs/';
				$config3['quality'] = 100;
				$config3['width']   = 150;
				$config3['height']  = 100;
				$this->image_lib->clear();
				$this->image_lib->initialize($config3);
				$resize = $this->image_lib->resize();
				$thumbnail = $upload_data['raw_name'].'_thumb'.$upload_data['file_ext'];
			}else{
				$thumbnail="";
			}
			if($this->input->post('attributetext')){
				$attributetext = $this->input->post('attributetext');
			}else{
				$attributetext = "";
			}
			if($this->input->post('privilegelevel')){
				$privilegelevel = $this->input->post('privilegelevel');
			}else{
				$privilegelevel = "";
			}
			if($this->input->post('hashtag')){
				$hashtag = implode(",",$this->input->post('hashtag')); 
			}else{
				$hashtag = "";
			}
			$data=array(
					'name'		=>	$picturename,
					'original_name'	=> $upload_data['raw_name'],
					'owner'		=>	$companyid,
					'company'	=>	$companyid,
					'directory'	=>	'folders',
					'thumb'		=> $thumbnail,
					'extension'	=> $upload_data['file_ext'],
					'type'		=> $filetype,
					'size'		=> $upload_data['file_size'],
					'attribute' => 	$attributetext,
					'hashtag' 	=>	$hashtag,
					'privilegelevel' 	=>	$privilegelevel,
					'status'	=>	1,
					'creation_date'	=>	date('Y-m-d H:i:s'),
					'modified_date'	=>	date('Y-m-d H:i:s')
					);
			$fileupdated = $this->company_model->insertcfiles($data);
			if($fileupdated == 1){
				$this->session->set_flashdata('companyfolderupdation', '<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><span>The file '.$picturename.' has been uploaded succesfully.</span></div>');
			}else{
				$this->session->set_flashdata('companyfolderupdation', '<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><span>The file '.$picturename.' has notbeen uploaded succesfully.</span></div>');
			}
          redirect('company/folders');
		  exit;          
		}
	public function subsavefiles(){
		$foldername = $this->input->post('folder');
		$userdata= $this->session->userinfo;
		$folderget = $this->folder_model->getfolder(array('folder_name'=>$foldername));
		$foldergetdetails = ($folderget->num_rows() > 0) ? $folderget->result() : FALSE;
		$folderpath = $foldergetdetails[0]->directory;
		$dir = FCPATH.$folderpath;
		$companyid = $userdata->id;
		$config['upload_path'] = $dir;
		$config['allowed_types'] = '*';
		//$config['allowed_types'] = 'gif|jpg|png|jpeg|pdf|doc|docx|txt|mpeg|avi|mov|webm|flv|mp4|mp3|aiff|aif|au|avi|bat';
		$this->upload->initialize($config);
		$this->load->library('upload', $config);
		if ( ! $this->upload->do_upload('picture'))
		{
			$error = array('error' => $this->upload->display_errors());
			$this->session->set_flashdata('companyfolderupdation', '<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><span>The file '.$picturename.' has notbeen uploaded succesfully.</span></div>');
			redirect('company/folders');
		}
		else
		{
			$data = array('upload_data' => $this->upload->data());
			
		}
		 if($_FILES['picture']['name']!= '')
		{
			$picture=$_FILES['picture']['name'];
			$upload_data = $this->upload->data(); 
			$picturename = $upload_data['file_name'];   

		}
		$getfiletype = explode('/',$upload_data['file_type']);
		$filetype = $getfiletype[0];
		if(($upload_data['is_image']==1)){
			/***** for the medium without watermark****/
			$config = array(
			'source_image'      => $upload_data['full_path'], //path to the uploaded image
			'new_image'         => FCPATH.'/lowresolution/plain/', //path to
			'maintain_ratio'    => true,
			'width'             => 500,
			'height'            => 500
			);
			$this->image_lib->clear();
			$this->image_lib->initialize($config);
			$this->image_lib->resize();
			/***** for the medium with watermark****/
			$config1 = array(
			'source_image'      => $upload_data['full_path'], //path to the uploaded image
			'new_image'         => FCPATH.'/lowresolution/watermark/', //path to
			'maintain_ratio'    => true,
			'width'             => 500,
			'height'            => 500
			);
			$this->image_lib->clear();
			$this->image_lib->initialize($config1);
			$resize1 = $this->image_lib->resize();
			$lowres = $upload_data['raw_name'].$upload_data['file_ext'];
			if($resize1){
				/*****for the watermark images*****/
				$config2['source_image'] = $config1['new_image'].$lowres;
				$config2['wm_text'] = 'FSP';
				$config2['wm_font_path'] = './fonts/LiberationSerif-Regular.ttf';
				$config2['wm_type'] = 'text';
				$config2['wm_font_size'] = '40';
				$config2['wm_font_color'] = '000';
				$config2['wm_vrt_alignment'] = 'middle';
				$config2['wm_hor_alignment'] = 'center';
				$config2['wm_hor_offset'] = '0';
				$config2['wm_vrt_offset'] = '0';
				$this->image_lib->clear();
				$this->image_lib->initialize($config2);
				$this->image_lib->watermark();
				//echo $this->image_lib->display_errors();exit;
			}
			/*****for the thumbnail image*****/
			$source_image = $upload_data['full_path'];
			$config3['image_library'] = 'gd2';
			$config3['source_image'] = $source_image;
			$config3['create_thumb'] = TRUE;
			$config3['maintain_ratio'] = TRUE;
			$config3['file_permissions'] = 0644;
			$config3['new_image'] = FCPATH.'/thumbs/';
			$config3['quality'] = 100;
			$config3['width']   = 150;
			$config3['height']  = 100;
			$this->image_lib->clear();
			$this->image_lib->initialize($config3);
			$resize = $this->image_lib->resize();
			$thumbnail = $upload_data['raw_name'].'_thumb'.$upload_data['file_ext'];
		}else{
			$thumbnail="";
		}
		if($this->input->post('privilegelevel')){
			$privilegelevel = $this->input->post('privilegelevel');
		}else{
			$privilegelevel = "";
		}
		if($this->input->post('attributetext')){
			$attributetext = $this->input->post('attributetext');
		}else{
			$attributetext = "";
		}
		if($this->input->post('hashtag')){
			$hashtag = implode(",",$this->input->post('hashtag'));
		}else{
			$hashtag = "";
		}
		$data=array(
					'name'		=>	$picturename,
					'original_name'	=> $upload_data['raw_name'],
					'owner'		=>	$companyid,
					'company'	=>	$companyid,
					'directory'	=>	$foldername,
					'thumb'		=> $thumbnail,
					'extension'	=> $upload_data['file_ext'],
					'type'		=> $filetype,
					'size'		=> $upload_data['file_size'],
					'attribute' => 	$attributetext,
					'hashtag' 	=>	$hashtag,
					'privilegelevel' 	=>	$privilegelevel,
					'status'	=>	1,
					'creation_date'	=>	date('Y-m-d H:i:s'),
					'modified_date'	=>	date('Y-m-d H:i:s')
					);
		$fileupdated = $this->company_model->insertcfiles($data);
			if($fileupdated == 1){
				$this->session->set_flashdata('companyfileupdation', '<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><span>The file '.$picturename.' has been uploaded succesfully.</span></div>');
			}else{
				$this->session->set_flashdata('companyfileupdation', '<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><span>The file '.$picturename.' has notbeen uploaded succesfully.</span></div>');
			}
          redirect('company/folders/'.$foldername);
		exit;
	}
	public function dragfileupload(){
		$foldername = $_GET['folder'];
		$userdata= $this->session->userinfo;
		$this->load->helper('directory');
		$folderget = $this->folder_model->getfolder(array('folder_name'=>$foldername));
		if($folderget!=FALSE){
		$foldergetdetails = ($folderget->num_rows() > 0) ? $folderget->result() : FALSE;
			$folderpath = $foldergetdetails[0]->directory;
		}else{
			$folderpath = 'folders';
		}
		$dir = FCPATH.$folderpath;
		$userid = $userdata->id;
		$companyid = $userdata->companyid;
		$config['upload_path'] = $dir;
		$config['allowed_types'] = '*';
		//$config['allowed_types'] = 'gif|jpg|png|jpeg|pdf|doc|docx|txt';
		$this->upload->initialize($config);
		$this->load->library('upload', $config);
		if ( ! $this->upload->do_upload('file'))
		{
			$error = array('error' => $this->upload->display_errors());
		}
		else
		{
			$data = array('upload_data' => $this->upload->data());
			
		}
		 if($_FILES['file']['name']!= '')
		{
			$picture=$_FILES['file']['name'];
			$upload_data = $this->upload->data(); 
			$picturename = $upload_data['file_name'];   

		}
		$getfiletype = explode('/',$upload_data['file_type']);
		$filetype = $getfiletype[0];
		if(($upload_data['is_image']==1)){
			/***** for the medium without watermark****/
			$config = array(
			'source_image'      => $upload_data['full_path'], //path to the uploaded image
			'new_image'         => FCPATH.'/lowresolution/plain/', //path to
			'maintain_ratio'    => true,
			'width'             => 500,
			'height'            => 500
			);
			$this->image_lib->clear();
			$this->image_lib->initialize($config);
			$this->image_lib->resize();
			/***** for the medium with watermark****/
			$config1 = array(
			'source_image'      => $upload_data['full_path'], //path to the uploaded image
			'new_image'         => FCPATH.'/lowresolution/watermark/', //path to
			'maintain_ratio'    => true,
			'width'             => 500,
			'height'            => 500
			);
			$this->image_lib->clear();
			$this->image_lib->initialize($config1);
			$resize1 = $this->image_lib->resize();
			$lowres = $upload_data['raw_name'].$upload_data['file_ext'];
			if($resize1){
				/*****for the watermark images*****/
				$config2['source_image'] = $config1['new_image'].$lowres;
				$config2['wm_text'] = 'FSP';
				$config2['wm_font_path'] = './fonts/LiberationSerif-Regular.ttf';
				$config2['wm_type'] = 'text';
				$config2['wm_font_size'] = '40';
				$config2['wm_font_color'] = '000';
				$config2['wm_vrt_alignment'] = 'middle';
				$config2['wm_hor_alignment'] = 'center';
				$config2['wm_hor_offset'] = '0';
				$config2['wm_vrt_offset'] = '0';
				$this->image_lib->clear();
				$this->image_lib->initialize($config2);
				$this->image_lib->watermark();
				//echo $this->image_lib->display_errors();exit;
			}
			/*****for the thumbnail image*****/
			$source_image = $upload_data['full_path'];
			$config3['image_library'] = 'gd2';
			$config3['source_image'] = $source_image;
			$config3['create_thumb'] = TRUE;
			$config3['maintain_ratio'] = TRUE;
			$config3['file_permissions'] = 0644;
			$config3['new_image'] = FCPATH.'/thumbs/';
			$config3['quality'] = 100;
			$config3['width']   = 150;
			$config3['height']  = 100;
			$this->image_lib->clear();
			$this->image_lib->initialize($config3);
			$resize = $this->image_lib->resize();
			$thumbnail = $upload_data['raw_name'].'_thumb'.$upload_data['file_ext'];
		}else{
			$thumbnail="";
		}
		$data=array(
					'name'			=>	$picturename,
					'original_name'	=> $upload_data['raw_name'],
					'owner'			=>	$userid,
					'company'		=>	$companyid,
					'directory'		=>	$foldername,
					'thumb'			=> $thumbnail,
					'extension'		=> $upload_data['file_ext'],
					'type'			=> $filetype,
					'size'			=> $upload_data['file_size'],
					'status'		=>	1,
					'creation_date'	=>	date('Y-m-d H:i:s'),
					'modified_date'	=>	date('Y-m-d H:i:s')
					);
		$fileupdated = $this->company_model->insertcfiles($data);
		if($fileupdated == 1){
				$this->session->set_flashdata('companyfileupdation', '<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><span>The file '.$picturename.' has been uploaded succesfully.</span></div>');
			}else{
				$this->session->set_flashdata('companyfileupdation', '<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><span>The file '.$picturename.' has notbeen uploaded succesfully.</span></div>');
			}
          redirect('company/folders/'.$foldername);
		exit;
	}
	public function editpictureatt(){
		$fileid = $_GET['id'];
		$filesget = $this->folder_model->getfiles(array('id'=>$fileid));
		if($filesget !=""){
			$files = ($filesget->num_rows() > 0) ? $filesget->result() : FALSE;
		}else{
			$files = "";
		}
		$userdata= $this->session->userinfo;
		$companyid = $userdata->id;
		$userini = $this->company_model->get_ini($companyid);
		$data = array(
			'view_file'	=>'editattributes',
			'hiddenid'	=> $companyid,
			'picture'	=> $files[0],
			'ini'	=> $userini,
			'files'		=> array(
								"css"=> array(
									"lib/jquery-toggles/toggles-full.css",
									"lib/datatables-plugins/integration/bootstrap/3/dataTables.bootstrap.css",
									"lib/select2/select2.css"
								),
								"js" => array(
									"lib/datatables/jquery.dataTables.js",
									"lib/datatables-plugins/integration/bootstrap/3/dataTables.bootstrap.js",
									"lib/select2/select2.js",
									"lib/jquery-toggles/toggles.js",
									"js/quirk.js"
									)
								)
		);
		$this->template->load_simple_template($data);
	}
	public function updateattributes(){
		$newhashtag = [];
		$url = $this->input->post('parentfolder');
		if($this->input->post('attributetext')){
			$attribute = $this->input->post('attributetext');
		}else{
			$attribute = "";
		}
		if($this->input->post('hashtag')!=""){
			$hasharray = $this->input->post('hashtag');
			foreach($hasharray as $hash){
				if($hash!=""){
					$newhashtag[] = $hash;
				}
			}
			$hashtag = implode(",",$newhashtag);
		}else{
			$hashtag = "";
		}
		if($this->input->post('privilegelevel')){
			$privilegelevel = $this->input->post('privilegelevel');
		}else{
			$privilegelevel = "";
		}
		$pictureid = $this->input->post('pictureid');
		$data=array(
					'attribute' => 	$attribute,
					'hashtag' 	=>	$hashtag,
					'privilegelevel' 	=>	$privilegelevel,
					'modified_date'	=>	date('Y-m-d H:i:s')
					);
		$fileupdated = $this->company_model->updateattribute($data,array('id'=>$pictureid));
		if($url == 'folders'){
			if($fileupdated == 1){
				$this->session->set_flashdata('companyfolderupdation', '<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><span>The file attributes has been saved succesfully.</span></div>');
			}else{
				$this->session->set_flashdata('companyfolderupdation', '<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><span>The file attributes has notbeen saved succesfully.</span></div>');
			}
			redirect('company/folders/');
			exit;
		}else{
			if($fileupdated == 1){
				$this->session->set_flashdata('companyfileupdation', '<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><span>The file attributes has been saved succesfully.</span></div>');
			}else{
				$this->session->set_flashdata('companyfileupdation', '<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><span>The file attributes has notbeen saved succesfully.</span></div>');
			}
			redirect('company/folders/'.$url);
			exit;
		}
		exit;
	}
	public function updatefolderattrs(){
		$newhashtag = [];
		if($this->input->post('attributetext')){
			$attribute = $this->input->post('attributetext');
		}else{
			$attribute = "";
		}
		if($this->input->post('hashtag')){
			$hasharray = $this->input->post('hashtag');
			for($i=1;$i<=count($hasharray);$i++){
				if($hasharray[$i]!=""){
					$newhashtag[$i] = $hasharray[$i];
				}
			}
			$hashtag = implode(",",$newhashtag);
		}else{
			$hashtag = "";
		}
		if($this->input->post('folderid')){
			$folderids= $this->input->post('folderid');
			foreach($folderids as $folderid){
				$data=array(
					'attribute' => 	$attribute,
					'hashtag' 	=>	$hashtag,
					'modified'	=>	date('Y-m-d H:i:s')
					);
				$folderupdate = $this->company_model->updatefolderattribute($data, array('id'=>$folderid));
			}
		}
		
		$url = $this->input->post('parentfolder');
		if($url == 'folders'){
			$this->session->set_flashdata('companyfolderupdation', '<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><span>The folder attributes has been saved succesfully.</span></div>');
			redirect('company/folders/');
			exit;
		}else{
			$this->session->set_flashdata('companyfileupdation', '<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><span>The folder attributes has been saved succesfully.</span></div>');
			redirect('company/folders/'.$url);
			exit;
		}
	}
	public function approverequest(){
		$userid = $this->input->post('userid');
		$folder = $this->input->post('folder');
		$status = $this->input->post('status');
		$data =array('status'=>$status);
		$requstpermission = $this->company_model->updaterequest($data, array('uid'=>$userid));
		if($folder == 'folders'){
			if($requstpermission == 1){
				$this->session->set_flashdata('companyfolderupdation', '<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><span>The status has been changed succesfully.</span></div>');
			}else{
				$this->session->set_flashdata('companyfolderupdation', '<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><span>The status has notbeen changed succesfully.</span></div>');
			}
			redirect('company/folders/');
			exit;
		}else{
			if($requstpermission == 1){
				$this->session->set_flashdata('companyfileupdation', '<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><span>The status has been changed succesfully.</span></div>');
			}else{
				$this->session->set_flashdata('companyfileupdation', '<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><span>The status has notbeen changed succesfully.</span></div>');
			}
			redirect('company/folders/'.$folder);
			exit;
		}
	}
	public function approvefilerequest() {
		$folder = $this->input->post('folder');
		$userid = $this->input->post('userid');
		$fileid = $this->input->post('fileid');
		$status = $this->input->post('status');
		$data =array('status'=>$status);
		$requstpermission = $this->company_model->updatefilerequest($data, array('userid'=>$userid,'fileid'=>$fileid));
		if($folder == 'folders'){
			if($requstpermission == 1){
				$this->session->set_flashdata('companyfolderupdation', '<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><span>The status has been changed succesfully.</span></div>');
			}else{
				$this->session->set_flashdata('companyfolderupdation', '<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><span>The status has notbeen changed succesfully.</span></div>');
			}
			redirect('company/folders/');
			exit;
		}else{
			if($requstpermission == 1){
				$this->session->set_flashdata('companyfileupdation', '<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><span>The status has been changed succesfully.</span></div>');
			}else{
				$this->session->set_flashdata('companyfileupdation', '<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><span>The status has notbeen changed succesfully.</span></div>');
			}
			redirect('company/folders/'.$folder);
			exit;
		}
	}

}
