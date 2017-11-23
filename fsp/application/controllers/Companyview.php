<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Companyview extends CI_Controller {
	public function __construct()
	{
		parent::__construct();
		$this->load->model('user_model');
		$this->load->model('company_model');
		$this->load->library('upload');
		$this->load->helper(array('form', 'url'));
	}
	public function index(){
		$companyname = $this->uri->segment(2);
		$companydetails = $this->company_model->get_company(array('name'=>$companyname));
		$company = ($companydetails->num_rows() > 0) ? $companydetails->row() : FALSE;
		$companyid = $company->company_id;
		$ini = $this->company_model->get_ini($companyid);
		if($ini !=""){
			$inivalue = unserialize($ini->ini);
		}else{
			$inivalue = "";
		}
		//print_r($inivalue);exit;
		
		$data = array(
			'view_file'     =>'company',
			'title'			=> $companyname,
			'site_title'    =>'File System Portal',
			'company'		=> $company,
			'inivalue'		=> $inivalue
			);
		$this->template->load_company_template($data);
	}
	public function about(){
		$companyname = $this->uri->segment(2);
		$companydetails = $this->company_model->get_company(array('name'=>$companyname));
		$company = ($companydetails->num_rows() > 0) ? $companydetails->row() : FALSE;
		$companyid = $company->company_id;
		$ini = $this->company_model->get_ini($companyid);
		if($ini !=""){
			$inivalue = unserialize($ini->ini);
		}else{
			$inivalue = "";
		}
		$data = array(
			'view_file'     =>'companyabout',
			'title'			=> $companyname,
			'site_title'    =>'File System Portal',
			'company'		=> $company,
			'inivalue'		=> $inivalue
			);
		$this->template->load_company_template($data);
	}
public function login()
	{
		$companyname = $this->uri->segment(2);
		$companydetails = $this->company_model->get_company(array('name'=>$companyname));
		$company = ($companydetails->num_rows() > 0) ? $companydetails->row() : FALSE;
		$companyid = $company->company_id;
		$ini = $this->company_model->get_ini($companyid);
		if($ini !=""){
			$inivalue = unserialize($ini->ini);
		}else{
			$inivalue = "";
		}
		$data = array(
			'view_file'     =>'userlogin',
			'title'			=> $companyname,
			'site_title'    =>'File System Portal',
			'company'		=> $company,
			'inivalue'		=> $inivalue
			);
		$this->template->load_company_template($data);

		
		}
}

