<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Folder extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('user_model');
		$this->load->model('folder_model');
		$this->load->model('company_model');
        $this->load->library('upload');
		$this->load->helper(array('form', 'url'));
		$userdata= $this->session->userinfo;
		if(!$userdata){
			redirect('login');
		}
	}

	public function index(){
        $data = array(
			'view_file'     =>'addfolder',
			'title'		=> '',
			'userid' 	=> $_GET['uid'],
			'site_title'    =>'File System Portal'
                         );
		$this->template->load_simple_template($data);
	}

    public function addfolder(){
		$userdata= $this->session->userinfo;
		$url = $this->input->post('userid');
        $owner = $userdata->id;		 
		$foldername = str_replace(' ', '-', $this->input->post('foldername'));
		$directoryPath = FCPATH.'folders/'.$foldername;
		if (!file_exists($foldername) || !is_dir($foldername)) {
			if (mkdir($directoryPath, 0777)) {
				$dbdirectorypath = 'folders/'.$foldername;
				$data = array(
							'folder_name'=> $foldername,
							'directory'=>$dbdirectorypath,
							'owner'=>$owner,
							'company'=>$owner,
							'created'=>date('Y-m-d H:i:s'),
							'modified'=>date('Y-m-d H:i:s')
						 );
			 $folder = $this->folder_model->add_folder($data);
			 if($folder){
				  $this->session->set_flashdata('companyfolderupdation', '<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><span>Folder has been Created successfully </span></div>');
			 }else{
				 $this->session->set_flashdata('companyfolderupdation', '<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><span>Folder has not been Created.Please try again </span></div>');
			 }
		} else {
			$this->session->set_flashdata('companyfolderupdation', '<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><span>Folder has not been Created.Please try again </span></div>');
		}
	}else{
		$this->session->set_flashdata('companyfolderupdation', '<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><span>Folder exists. Please create with another name. </span></div>');
	}
	redirect('company/folders');
	}
	public function folderverify(){
		if ($this->input->post("name") != "")
		{
			$foldername = str_replace(' ', '-', $this->input->post('name'));
			$folderinfo = $this->folder_model->nameauth($foldername);
			if($folderinfo==1){
				echo 0;
			}else{
				echo 1;
			}
		}
		else
		{
			echo 2;
		}
	}
	public function fcreate(){
		$parentfol =  $_GET['folder'];
		$parentid = $this->folder_model->folderid($parentfol);
		$parent = $parentid->id;		
        $data = array(
			'view_file'		=>'addsubfolder',
			'title'			=> '',
			'userid' 		=> $_GET['uid'],
			'folderid'		=> $parent,
			'foldername'	=> $parentfol,
			'site_title'	=>'File System Portal'
                         );
		$this->template->load_simple_template($data);
	}
	public function addsubfolder(){
		$userdata= $this->session->userinfo;
		$url = $this->input->post('userid');
		$owner = $userdata->id; 
		$parentfolderid = $this->input->post('parentfolderid');
		$parentfoldername = $this->input->post('parentfoldername');
		$foldername = str_replace(' ', '-', $this->input->post('foldername'));
		$parentfolderget = $this->folder_model->getfolder(array('id'=>$parentfolderid));
		$parentfoldergetdetails = ($parentfolderget->num_rows() > 0) ? $parentfolderget->result() : FALSE;
		$folderpath = $parentfoldergetdetails[0]->directory;
		$directoryPath = FCPATH.$folderpath.'/'.$foldername;
		if (!file_exists($foldername) || !is_dir($foldername)) {
			if (mkdir($directoryPath, 0777)) {
				$dbdirectorypath = $folderpath.'/'.$foldername;
				$data = array(
							'folder_name'=> $foldername,
							'directory'=>$dbdirectorypath,
							'owner'=>$owner,
							'company'=>$owner,
							'parent'=>$parentfolderid,
							'created'=>date('Y-m-d H:i:s'),
							'modified'=>date('Y-m-d H:i:s')
						 );
			 $folder = $this->folder_model->add_folder($data);
			 if($folder){
				  $this->session->set_flashdata('companyfileupdation', '<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><span>Folder has been Created successfully </span></div>');
			 }else{
				 $this->session->set_flashdata('companyfileupdation', '<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><span>Folder has not been Created.Please try again </span></div>');
			 }
		} else {
			$this->session->set_flashdata('companyfileupdation', '<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><span>Folder has not been Created.Please try again </span></div>');
		}
	}else{
		$this->session->set_flashdata('companyfileupdation', '<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><span>Folder exists. Please create with another name. </span></div>');
	}
	redirect('company/folders/'.$parentfoldername);
	}
	public function deletefolder(){
		$userdata= $this->session->userinfo;
		$foldername = $_GET['name'];
		$returnfolder = $_GET['parent'];
		$parentfolderget = $this->folder_model->getfolder(array('folder_name'=>$foldername));
		$parentfoldergetdetails = ($parentfolderget->num_rows() > 0) ? $parentfolderget->result() : FALSE;
		if($parentfoldergetdetails != false){
		$folderid = $parentfoldergetdetails[0]->id;
		$folderpath = $parentfoldergetdetails[0]->directory;
		$directoryPath = FCPATH.$folderpath;
		$getallfolders = $this->folder_model->getallfolders($folderid);
		$getallfoldersdetails = ($getallfolders->num_rows() > 0) ? $getallfolders->result() : FALSE;
		foreach($getallfoldersdetails as $folderset){
			$folderid = $folderset->id;
			$foldername = $folderset->folder_name;
			$getfiles = $this->folder_model->getfiles(array('directory'=>$foldername));
			if($getfiles != ""){
			$filedetails = ($getfiles->num_rows() > 0) ? $getfiles->result() : FALSE;
				foreach($filedetails as $files){
					$fileid = $files->id;
					$deletefiles = $this->folder_model->deletefile($fileid);
				}
			}
			$deletefolder = $this->folder_model->deletefolder($folderid);
		}
		if (is_dir($directoryPath)) {
			$files = array_diff(scandir($directoryPath), array('.','..')); 
			foreach ($files as $file) { 
				if(is_dir($directoryPath.'/'.$file)){
					rmdir($directoryPath.'/'.$file);
				}else{
					unlink($directoryPath.'/'.$file);
				}
			}
		}
		if($returnfolder == 'folders'){
			$this->session->set_flashdata('companyfolderupdation', '<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><span>Folder has been Deleted. </span></div>');
			redirect('company/folders/');
		}else{
			$this->session->set_flashdata('companyfileupdation', '<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><span>Folder has been Deleted. </span></div>');
			redirect('company/folders/'.$returnfolder);
		}
	}else{
		if($returnfolder == 'folders'){
			$this->session->set_flashdata('companyfolderupdation', '<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><span>Folder has not been deleted or there is no folder. </span></div>');
			redirect('company/folders/');
		}else{
			$this->session->set_flashdata('companyfileupdation', '<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><span>Folder has not been deleted or there is no folder. </span></div>');
			redirect('company/folders/'.$returnfolder);
		}
	}
	exit;
	}
	public function deletefile(){
		$userdata= $this->session->userinfo;
		$fileid = $_GET['id'];
		$fileget = $this->folder_model->getfiles(array('id'=>$fileid));
		$filedetails = ($fileget->num_rows() > 0) ? $fileget->result() : FALSE;
		$filename = $filedetails[0]->name;
		$filethumb = $filedetails[0]->thumb;
		$dir = $filedetails[0]->directory;
		if($dir !='folders'){
			$parentfolderget = $this->folder_model->getfolder(array('folder_name'=>$dir));
			$parentfoldergetdetails = ($parentfolderget->num_rows() > 0) ? $parentfolderget->result() : FALSE;
			$dir_path = $parentfoldergetdetails[0]->directory;
		}else{
			$dir_path = 'folders';
		}
		if(isset($_GET['folder'])){
			$folderget = $_GET['folder'];
			$filepath = FCPATH.$dir_path.'/'.$filename;
			$thumbpath = FCPATH.'/thumbs/'.$filethumb;
			$lowresolutionpath = FCPATH.'/lowresolution/plain/'.$filename;
			$lowresolutionwaterpath = FCPATH.'/lowresolution/watermark/'.$filename;
			if(file_exists($thumbpath)){
				unlink($thumbpath);
			}
			if(file_exists($lowresolutionpath)){
				unlink($lowresolutionpath);
			}
			if(file_exists($lowresolutionwaterpath)){
				unlink($lowresolutionwaterpath);
			}			
			if(file_exists($filepath)){
				$deletefile = $this->folder_model->deletefile($fileid);
				unlink($filepath);
				$this->session->set_flashdata('companyfileupdation', '<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><span>File has been Deleted. </span></div>');
			}else{
				$this->session->set_flashdata('companyfileupdation', '<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><span>File has not been Deleted. </span></div>');
			}
			redirect('company/folders/'.$folderget);
		}else{
			$filepath = FCPATH.$dir_path.'/'.$filename;
			$thumbpath = FCPATH.'/thumbs/'.$filethumb;
			$lowresolutionpath = FCPATH.'/lowresolution/plain/'.$filename;
			$lowresolutionwaterpath = FCPATH.'/lowresolution/watermark/'.$filename;
			if(file_exists($thumbpath)){
				unlink($thumbpath);
			}
			if(file_exists($lowresolutionpath)){
				unlink($lowresolutionpath);
			}
			if(file_exists($lowresolutionwaterpath)){
				unlink($lowresolutionwaterpath);
			}
			$deletefile = $this->folder_model->deletefile($fileid);
			if(file_exists($filepath)){
				unlink($filepath);
				$this->session->set_flashdata('companyfolderupdation', '<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><span>File has been Deleted. </span></div>');
			}else{
				$this->session->set_flashdata('companyfolderupdation', '<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><span>File has not been Deleted. </span></div>');
			}
			redirect('company/folders/');
		}
		exit;
	}
	public function editattr(){
		$foldername = $_GET['name'];
		$urlfolder = $_GET['parent'];
		$parentfolderget = $this->folder_model->getfolder(array('folder_name'=>$foldername));
		$parentfoldergetdetails = ($parentfolderget->num_rows() > 0) ? $parentfolderget->result() : FALSE;
		$userdata= $this->session->userinfo;
		$companyid = $userdata->id;
		$userini = $this->company_model->get_ini($companyid);
		$data = array(
				'view_file'	=>'editfolderattributes',
				'urlfolder'=>$urlfolder,
				'foldername'	=> $foldername,
				'folderdetails'	=> $parentfoldergetdetails,
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
		if($this->input->post('attributetext')){
			$attribute = $this->input->post('attributetext');
		}else{
			$attribute = "";
		}
		if($this->input->post('hashtag')){
			$hasharray = $this->input->post('hashtag');
			for($i=0;$i<count($hasharray);$i++){
				if($hasharray[$i]!=""){
					$newhashtag[$i] = $hasharray[$i];
				}
			}
			$hashtag = implode(",",$newhashtag);
		}else{
			$hashtag = "";
		}
		if($this->input->post('folderid')){
			$folderid= $this->input->post('folderid');
				$folderdata=array(
					'attribute' => 	$attribute,
					'hashtag' 	=>	$hashtag,
					'modified'	=>	date('Y-m-d H:i:s')
					);
				$filedata=array(
					'attribute' => 	$attribute,
					'hashtag' 	=>	$hashtag,
					'modified_date'	=>	date('Y-m-d H:i:s')
					);
			$folderget = $this->folder_model->getallfolders($folderid);
			$foldergetdetails = ($folderget->num_rows() > 0) ? $folderget->result() : FALSE;
			foreach($foldergetdetails as $folderdetails){
				$folderid = $folderdetails->id;
				$folderupdate = $this->company_model->updatefolderattribute($folderdata, array('id'=>$folderid));
				$foldername = $folderdetails->folder_name;
				$fileupdate = $this->company_model->updateattribute($filedata, array('directory'=>$foldername));
			}
		}
		$url = $this->input->post('parentfolder');
		if($url == 'folders'){
			$this->session->set_flashdata('companyfolderupdation', '<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><span>The folder attributes has been saved succesfully.</span></div>');
			redirect('company/folders/');
		}else{
			$this->session->set_flashdata('companyfileupdation', '<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><span>The folder attributes has been saved succesfully.</span></div>');
			redirect('company/folders/'.$url);
		}
	}
}
