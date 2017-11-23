<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Index extends CI_Controller {
	public function index(){
	    $data = array(
		    'view_file'=>'index',
		    'current_menu'=>'Index',
		    'site_title' =>'File System Portal',
		    'title'=>'Home',
		);
		$this->template->load_index_template($data);
	}
}
