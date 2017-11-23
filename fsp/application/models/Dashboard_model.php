<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

class Dashboard_model extends CI_Model{

	public $files = 'files';
	public $folders = 'folder';
	public $user_master = 'user_master';

        
    public function sup_company()
    {
		        $this->db->select('count(username) as count');
                $this->db->from('user_master');
				$this->db->where('type',2);
			    $res=$this->db->get()->row();
                isset($res->count)? $res->count : 0;
                $ress=$res->count;
                echo isset($ress)? $ress : 0;
		
    }
     public function sup_user()
    {
		        $this->db->select('count(username) as count');
                $this->db->from('user_master');
				$this->db->where('type',4);
			    $res=$this->db->get()->row();
                isset($res->count)? $res->count : 0;
                $ress=$res->count;
                echo isset($ress)? $ress : 0;
		
    }
     public function sup_folder()
    {
		        $this->db->select('count(folder_name) as count');
                $this->db->from('folder');
			    $res=$this->db->get()->row();
                isset($res->count)? $res->count : 0;
                $ress=$res->count;
                echo isset($ress)? $ress : 0;
		
    }
    public function sup_files()
    {
		        $this->db->select('count(original_name) as count');
                $this->db->from('files');
			    $res=$this->db->get()->row();
                isset($res->count)? $res->count : 0;
                $ress=$res->count;
                echo isset($ress)? $ress : 0;
		
    }
    public function com_user($companyid)
    {
		        $this->db->select('count(username) as count');
                $this->db->from('user_master');
				$this->db->where('type',4);
				$this->db->where('companyid',$companyid);
			    $res=$this->db->get()->row();
                isset($res->count)? $res->count : 0;
                $ress=$res->count;
                echo isset($ress)? $ress : 0;
		
    }
    public function com_folder($companyid)
    {
		        $this->db->select('count(folder_name) as count');
                $this->db->from('folder');
                $this->db->where('company',$companyid);
			    $res=$this->db->get()->row();
                isset($res->count)? $res->count : 0;
                $ress=$res->count;
                echo isset($ress)? $ress : 0;
		
    }
     public function com_files($companyid)
    {
		        $this->db->select('count(original_name) as count');
                $this->db->from('files');
                $this->db->where('company',$companyid);
			    $res=$this->db->get()->row();
                isset($res->count)? $res->count : 0;
                $ress=$res->count;
                echo isset($ress)? $ress : 0;
		
    }
    public function user_folder($companyid,$userid)
    {
		        $this->db->select('count(folder_name) as count');
                $this->db->from('folder');
                $this->db->where('company',$companyid);
                $this->db->where('owner',$userid);
			    $res=$this->db->get()->row();
                isset($res->count)? $res->count : 0;
                $ress=$res->count;
                echo isset($ress)? $ress : 0;
		
    }
    public function user_files($companyid,$userid)
    {
		        $this->db->select('count(original_name) as count');
                $this->db->from('files');
                $this->db->where('company',$companyid);
                $this->db->where('owner',$userid);
			    $res=$this->db->get()->row();
                isset($res->count)? $res->count : 0;
                $ress=$res->count;
                echo isset($ress)? $ress : 0;
		
    }
    
    
}
