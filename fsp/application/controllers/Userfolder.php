<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Userfolder extends CI_Controller {
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
	public function foldercreate(){
		$userdata= $this->session->userinfo;
		$userid = $userdata->id;
		$folder = $_GET['folder'];
        $data = array(
			'view_file'     =>'adduserfolder',
			'title'			=> '',
			'userid' 		=> $userid,
			'folder'		=> $folder,
			'site_title'    =>'File System Portal'
                         );
		$this->template->load_simple_template($data);
	}
	public function addfolder(){
		$userdata= $this->session->userinfo;
        $owner = $userdata->id;
        $companyid = $userdata->companyid;  
		$foldername = $this->input->post('foldername');
		$parentfolder = 
		$directoryPath = FCPATH.'folders/'.$foldername;
		if (!file_exists($foldername) || !is_dir($foldername)) {
			if (mkdir($directoryPath, 0777)) {
				//echo 'Folder created'; exit;   
				$dbdirectorypath = 'folders/'.$foldername;
				$data = array(
							'folder_name'=> $foldername,
							'directory'=>$dbdirectorypath,
							'owner'=>$owner,
							'company'=>$companyid,
							'created'=>date('Y-m-d H:i:s'),
							'modified'=>date('Y-m-d H:i:s')
						 );
			 $folder = $this->folder_model->add_folder($data);
			 if($folder){
				  $this->session->set_flashdata('userupdation', '<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><span>Folder has been Created successfully </span></div>');
			 }else{
				 $this->session->set_flashdata('userupdation', '<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><span>Folder has not been Created.Please try again </span></div>');
			 }
		} else {
			$this->session->set_flashdata('userupdation', '<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><span>Folder has not been Created.Please try again </span></div>');
		}
	}else{
		$this->session->set_flashdata('userupdation', '<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><span>Folder exists. Please create with another name. </span></div>');
	}
	redirect('user');
	}
	public function fileupload(){
		//echo 'hi';exit;
		  $userdata= $this->session->userinfo;
		  $userid = $userdata->id;
		  $companyid = $userdata->companyid;
		  $userini = $this->company_model->get_ini($companyid);
		  if(isset($_GET['folder'])){
			$data = array(
			'view_file'     =>'subuploaduserfiles',
			'folder'		=> $_GET['folder'],
			'ini'		=> $userini,
			'hiddenid' => $userid,
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
		$this->template->load_simple_template($data);
	  }
	  public function savefiles(){
			$userdata= $this->session->userinfo;
			$userid = $userdata->id;
			$companyid = $userdata->companyid;
			$config['upload_path'] = FCPATH.'folders/';
			$config['allowed_types'] = '*';
			//$config['allowed_types'] = 'gif|jpg|png|jpeg|pdf|doc|docx|txt|mpeg|avi|mov|webm|flv|mp4|mp3|aiff|aif|au|avi|bat';
			$this->upload->initialize($config);
			if ( ! $this->upload->do_upload('picture'))
			{
				$error = array('error' => $this->upload->display_errors());
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
			if($this->input->post('hashtag')){
				$hashtag = implode(",",$this->input->post('hashtag')); 
			}else{
				$hashtag = "";
			}
			$data=array(
					'name'		=>	$picturename,
					'original_name'	=> $upload_data['raw_name'],
					'owner'		=>	$userid,
					'company'	=>	$companyid,
					'directory'	=>	'folders',
					'thumb'		=> $thumbnail,
					'extension'	=> $upload_data['file_ext'],
					'type'		=> $filetype,
					'size'		=> $upload_data['file_size'],
					'attribute' => 	$attributetext,
					'hashtag' 	=>	$hashtag,
					'status'	=>	1,
					'creation_date'	=>	date('Y-m-d H:i:s'),
					'modified_date'	=>	date('Y-m-d H:i:s')
					);
			$fileupdated = $this->company_model->insertcfiles($data);
			if($fileupdated == 1){
				$this->session->set_flashdata('userupdation', '<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><span>The file '.$picturename.' has been uploaded succesfully.</span></div>');
			}else{
				$this->session->set_flashdata('userupdation', '<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><span>The file '.$picturename.' has notbeen uploaded succesfully.</span></div>');
			}
          redirect('user');
		  exit;          
		}
		public function subsavefiles(){
		$foldername = $this->input->post('folder');
		$userdata= $this->session->userinfo;
		$userid = $userdata->id;
		$folderget = $this->folder_model->getfolder(array('folder_name'=>$foldername));
		$foldergetdetails = ($folderget->num_rows() > 0) ? $folderget->result() : FALSE;
		$folderpath = $foldergetdetails[0]->directory;
		$dir = FCPATH.$folderpath;
		$companyid = $userdata->companyid;
		$config['upload_path'] = $dir;
		$config['allowed_types'] = '*';
		//$config['allowed_types'] = 'gif|jpg|png|jpeg|pdf|doc|docx|txt|mpeg|avi|mov|webm|flv|mp4|mp3|aiff|aif|au|avi|bat';
		$this->upload->initialize($config);
		$this->load->library('upload', $config);
		if ( ! $this->upload->do_upload('picture'))
		{
			$error = array('error' => $this->upload->display_errors());
			$this->session->set_flashdata('userupdation', '<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><span>The file '.$picturename.' has notbeen uploaded succesfully.</span></div>');
			redirect('user/'.$foldername);
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
					'owner'		=>	$userid,
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
				$this->session->set_flashdata('userupdation', '<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><span>The file '.$picturename.' has been uploaded succesfully.</span></div>');
			}else{
				$this->session->set_flashdata('userupdation', '<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><span>The file '.$picturename.' has notbeen uploaded succesfully.</span></div>');
			}
          redirect('user/'.$foldername);
		exit;
	}
	public function deletefolder(){
		$userdata= $this->session->userinfo;
		$foldername = $_GET['name'];
		$parentfolderget = $this->folder_model->getfolder(array('folder_name'=>$foldername));
		$parentfoldergetdetails = ($parentfolderget->num_rows() > 0) ? $parentfolderget->result() : FALSE;
		$folderid = $parentfoldergetdetails[0]->id;
		$folderpath = $parentfoldergetdetails[0]->directory;
		$directoryPath = FCPATH.$folderpath;
		if (!file_exists($foldername) || !is_dir($foldername)) {
			if(rmdir($directoryPath)){
				$deleteroot = $this->folder_model->deletefolder($folderid);
				$this->session->set_flashdata('userupdation', '<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><span>Folder has been Deleted. </span></div>');
			}else{
				$this->session->set_flashdata('userupdation', '<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><span>Folder has not been Deleted. </span></div>');
			}
		}
		redirect('user');
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
		$userid = $userdata->id;
		$companyid = $userdata->companyid;
		$userini = $this->company_model->get_ini($companyid);
		$data = array(
			'view_file'	=>'edituserfileattributes',
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
		//print_r($this->input->post());exit;
		$url = $this->input->post('parentfolder');
		if($this->input->post('attributetext')){
			$attribute = $this->input->post('attributetext');
		}else{
			$attribute = "";
		}
		if($this->input->post('hashtag')){
			$hashtag = implode(",",$this->input->post('hashtag'));
		}else{
			$hashtag = "";
		}
		$data=array(
					'attribute' => 	$attribute,
					'hashtag' 	=>	$hashtag,
					'modified_date'	=>	date('Y-m-d H:i:s')
					);
		$fileupdated = $this->company_model->updateattribute($data);
		if($fileupdated == 1){
				$this->session->set_flashdata('userupdation', '<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><span>The file attributes has been saved succesfully.</span></div>');
			}else{
				$this->session->set_flashdata('userupdation', '<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><span>The file attributes has notbeen saved succesfully.</span></div>');
			}
		if(($url == 'user')||($url == 'folders')){
			redirect('user');
		}else{
			redirect('user/'.$url);
		}
		exit;
	}
	public function fcreate(){
	    $parentfol = $_GET['folder'];
		$parentid = $this->folder_model->folderid($parentfol);
		$parent = $parentid->id;
        $data = array(
			'view_file'		=>'addusersubfolder',
			'title'			=> '',
			'folderid'		=> $parent,
			'foldername'	=> $parentfol,
			'site_title'	=>'File System Portal'
                         );
		$this->template->load_simple_template($data);
	}
	public function addsubfolder(){
		$userdata= $this->session->userinfo;
		$owner = $userdata->id; 
		$companyid = $userdata->companyid; 
		$parentfolderid = $this->input->post('parentfolderid');
		$parentfoldername = $this->input->post('parentfolder');
		$foldername = $this->input->post('foldername');
		$parentfolderget = $this->folder_model->getfolder(array('id'=>$parentfolderid));
		$parentfoldergetdetails = ($parentfolderget->num_rows() > 0) ? $parentfolderget->result() : FALSE;
		$folderpath = $parentfoldergetdetails[0]->directory;
		$directoryPath = FCPATH.$folderpath.'/'.$foldername;
		if (!file_exists($directoryPath) || !is_dir($directoryPath)) {
			if (mkdir($directoryPath, 0777)) {
				//echo 'Folder created'; exit;   
				$dbdirectorypath = $folderpath.'/'.$foldername;
				$data = array(
							'folder_name'=> $foldername,
							'directory'=>$dbdirectorypath,
							'owner'=>$owner,
							'company'=>$companyid,
							'parent'=>$parentfolderid,
							'created'=>date('Y-m-d H:i:s'),
							'modified'=>date('Y-m-d H:i:s')
						 );
			 $folder = $this->folder_model->add_folder($data);
			 if($folder){
				  $this->session->set_flashdata('userupdation', '<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><span>Folder has been Created successfully </span></div>');
			 }else{
				 $this->session->set_flashdata('userupdation', '<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><span>Folder has not been Created.Please try again </span></div>');
			 }
		} else {
			$this->session->set_flashdata('userupdation', '<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><span>Folder has not been Created.please check for the folder permissions.Please try again </span></div>');
		}
	}else{
		$this->session->set_flashdata('userupdation', '<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><span>Folder exists. Please create with another name. </span></div>');
	}
	redirect('user/'.$parentfoldername);
	}
	public function deletefile(){
		$userdata= $this->session->userinfo;
		$fileid = $_GET['id'];
		$folderget = $_GET['folder'];
		$fileget = $this->folder_model->getfiles(array('id'=>$fileid));
		$filedetails = ($fileget->num_rows() > 0) ? $fileget->result() : FALSE;
		$filename = $filedetails[0]->name;
		$dir = $filedetails[0]->directory;
		if($dir !='folders'){
			$parentfolderget = $this->folder_model->getfolder(array('folder_name'=>$dir));
			$parentfoldergetdetails = ($parentfolderget->num_rows() > 0) ? $parentfolderget->result() : FALSE;
			$dir_path = $parentfoldergetdetails[0]->directory;
		}else{
			$dir_path = 'folders';
		}
		if($folderget!=""){
			$filepath = FCPATH.$dir_path.'/'.$filename;
			if(file_exists($filepath)){
				unlink($filepath);
				$deletefile = $this->folder_model->deletefile($fileid);
				$this->session->set_flashdata('userupdation', '<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><span>File has been Deleted. </span></div>');
			}else{
				$this->session->set_flashdata('userupdation', '<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><span>File has not been Deleted. </span></div>');
			}
			redirect('user/'.$folderget);
		}else{
			$filepath = FCPATH.$dir_path.'/'.$filename;
			if(file_exists($filepath)){
				unlink($filepath);
				$deletefile = $this->folder_model->deletefile($fileid);
				$this->session->set_flashdata('userupdation', '<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><span>File has been Deleted. </span></div>');
			}else{
				$this->session->set_flashdata('userupdation', '<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><span>File has not been Deleted. </span></div>');
			}
			redirect('user/');
		}
		exit;
	}
	public function profileedit(){
		  $userdata= $this->session->userinfo;
		  $data = array(
			'view_file'     =>'edituserprofile',
			'userdetails' => $userdata,
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
	public function profilesave(){
		  $data = array(
			'username'=>$this->input->post('name'),
			'first_name'=> $this->input->post('fname'),
			'last_name'=>$this->input->post('lname'),
			'gender'=>$this->input->post('gender'),
			'email'=>$this->input->post('email'),
			'phone'=>$this->input->post('phone'),
			'status'=>$this->input->post('status'),
			'modified'=>date('Y-m-d H:i:s')
		 );		 
		 $userid = $this->input->post('userid');
		 $username = $this->input->post('name');
		 $userupdated = $this->user_model->updateUser($data,array('id'=>$userid));
		 $getuserdata = $this->user_model->getUser(array('id'=>$userid));
		 $auth = ($getuserdata->num_rows() > 0) ? $getuserdata->result() : FALSE;
		 $this->session->set_userdata(array(
										'id' => $auth[0]->id,
										'user_name'  => $auth[0]->username,
										'email'      => $auth[0]->email,
										'picture'	 => $auth[0]->picture,
										'userinfo'=>$auth[0]
								));
		 if($userupdated==1){
			  $this->session->set_flashdata('userupdation', '<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><span>'.$username.' profile has been saved successfully </span></div>');
		 }else{
			 $this->session->set_flashdata('userupdation', '<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><span>'.$username.' profile has not been saved.Please try again </span></div>');
		 }
		 redirect('user/');
	  }
	public function changeavatar(){
		$userdata= $this->session->userinfo;
		 $data = array(
			'view_file'     =>'changeuseravatar',
			'current_menu'  =>'changecavatar',
			'site_title'    =>'File System Portal',
			'title'         =>'changecavatar',
			'content_title' =>'changecavatar'
			);
			$this->template->load_adminuser_template($data);
	  }
	  public function avatarsave(){
			$userdata= $this->session->userinfo;
			$config['upload_path'] = FCPATH.'images/';
			$config['allowed_types'] = 'gif|jpg|png|jpeg';
			$this->upload->initialize($config);
			$this->load->library('upload', $config);
			$userid = $userdata->id;
			if ( ! $this->upload->do_upload('picture'))
			{
				$error = array('error' => $this->upload->display_errors());
				$this->session->set_flashdata('userupdation', '<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><span>Avatar has not been updated successfully </span></div>');
				redirect('user/');
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
			  $this->session->set_flashdata('userupdation', '<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><span>Avatar has been updated successfully </span></div>');
			}
			redirect('user/');
	  }
	  public function changepass(){
		 $userdata= $this->session->userinfo;
		 $userid = $userdata->id;
		 $data = array(
			'view_file'     =>'changeuserpass',
			'current_menu'  =>'changepass',
			'site_title'    =>'File System Portal',
			'title'         =>'changepass',
			'content_title' =>'changepass',
			'userid'		=> $userid,
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
		redirect('company/companyusers?id='.$getid);
	  }
	public function requestper(){
		$userdata= $this->session->userinfo;
		$url = $this->input->post('url');
		$customusertype = $this->user_model->getcusertype($userdata->customizedusertype);
		$userid = $userdata->id;
		$username = $userdata->username;
		$permission = 'User '.$username.' with the usertype '.$customusertype.' has requested the permission for the access of the file upload';
		$currentdate = date('Y-m-d');
		$data = array(
					'uid'		=> $userid,
					'username'	=> $username,
					'permission'=> $permission,
					'date'		=> $currentdate,
					'status'=>0
				);
		$requstpermission = $this->company_model->requestper($data, array('uid'=>$userid));
		if($requstpermission == 1){
			$this->session->set_flashdata('userupdation', '<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><span>Permission request has been submitted. </span></div>');
		}else{
			$this->session->set_flashdata('userupdation', '<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><span>Permission request has not been submitted. </span></div>');
		}
		if($url== 'user'){
			redirect('user/');
		}else{
			redirect('user/'.$url);
		}
		exit;
	}
	public function filepermission(){
		$userdata = $this->session->userinfo;
		$url = $this->input->post('url');
		$customusertype = $this->user_model->getcusertype($userdata->customizedusertype);
		$userid = $userdata->id;
		$companyid = $userdata->companyid;
		$username = $userdata->username;
		$fileid = $this->input->post('reqfileid');
		$filename = $this->input->post('reqfilename');
		$currentdate = date('Y-m-d');
		$data = array(
					'userid'		=> $userid,
					'companyid'		=> $companyid,
					'username'		=> $username,
					'fileid'		=> $fileid,
					'filename'		=> $filename,
					'requesttime'	=> $currentdate,
					'status'=>0
				);
		$filerequest = $this->company_model->requestfile($data, array('userid'=>$userid));
		if($filerequest == 1){
			$this->session->set_flashdata('userupdation', '<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><span>File Permission request has been submitted. </span></div>');
		}else{
			$this->session->set_flashdata('userupdation', '<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><span>File Permission request has not been submitted. </span></div>');
		}
		if($url== 'user'){
			redirect('user/');
		}else{
			redirect('user/'.$url);
		}
		exit;
	}
}
