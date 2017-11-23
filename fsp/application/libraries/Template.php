<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Template class
 *
 * Displays webpage i.e(view page)
 *
 * @package		CodeIgniter
 * @subpackage	Libraries
 * @category	Libraries
 */
class Template {
	
	private $CI;
	
	public function __construct()
	{
		$this->CI =& get_instance();
	}
	// This will load front end template
	public function load_index_template($data = array('content' => '', 'title' => '','site_title' => '', 'view_file' => ''))
	{
		$this->CI->load->view('template/index/header', $data);
		$this->CI->load->view($data['view_file'], $data);
	}
	public function load_login_template($data = array('content' => '', 'title' => '','site_title' => '', 'view_file' => ''))
	{
		$this->CI->load->view('template/login/header', $data);
		$this->CI->load->view($data['view_file'], $data);
	}
	public function load_dashboard_template($data = array('content' => '', 'title' => '','site_title' => '', 'view_file' => ''))
	{
		$this->CI->load->view('template/dashboard/header', $data);
		$this->CI->load->view($data['view_file'], $data);
		$this->CI->load->view('template/dashboard/footer', $data);
	}
	public function load_admin_template($data = array('content' => '', 'title' => '','site_title' => '', 'view_file' => ''))
	{
		$this->CI->load->view('template/dashboard/header', $data);
		$this->CI->load->view($data['view_file'], $data);
		$this->CI->load->view('template/dashboard/footer', $data);
	}
	public function load_adminuser_template($data = array('content' => '', 'title' => '','site_title' => '', 'view_file' => ''))
	{
		$this->CI->load->view('template/adminuser/header', $data);
		$this->CI->load->view($data['view_file'], $data);
		$this->CI->load->view('template/adminuser/footer', $data);
	}
	public function load_comcreate_template($data = array('content' => '', 'title' => '','site_title' => '', 'view_file' => ''))
	{
		$this->CI->load->view('template/comcreate/header', $data);
		$this->CI->load->view($data['view_file'], $data);
		$this->CI->load->view('template/comcreate/footer', $data);
	}
	public function load_folder_template($data = array('content' => '', 'title' => '','site_title' => '', 'view_file' => ''))
	{
		$this->CI->load->view('template/folder/header', $data);
		$this->CI->load->view($data['view_file'], $data);
		$this->CI->load->view('template/folder/footer', $data);
	}
	public function load_admincomcreate_template($data = array('content' => '', 'title' => '','site_title' => '', 'view_file' => ''))
	{
		$this->CI->load->view('template/admincomcreate/header', $data);
		$this->CI->load->view($data['view_file'], $data);
		$this->CI->load->view('template/admincomcreate/footer', $data);
	}
	public function load_company_template($data = array('title' => '','site_title' => '', 'view_file' => ''))
	{
		$this->CI->load->view('template/company/header', $data);
		$this->CI->load->view('template/company/head', $data);
		$this->CI->load->view($data['view_file'], $data);
		$this->CI->load->view('template/company/foot', $data);
		$this->CI->load->view('template/company/footer', $data);
	}
	public function load_edituser_template($data = array('content' => '', 'title' => '','site_title' => '', 'view_file' => ''))
	{
		$this->CI->load->view($data['view_file'], $data);
	}
	public function load_createuser_template($data = array('content' => '', 'title' => '','site_title' => '', 'view_file' => ''))
	{
		$this->CI->load->view($data['view_file'], $data);
	}
	public function load_simple_template($data = array('content' => '', 'title' => '','site_title' => '', 'view_file' => ''))
	{
		$this->CI->load->view($data['view_file'], $data);
	}
	
	
}
?>
