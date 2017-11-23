<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

class Search_model extends CI_Model{

	public $files = 'files';
	public $folders = 'folder';
        
    public function file($keyword,$companyid)
    {
		$this->db->where('company',$companyid);
			if($keyword != '')
			{
			$this->db->where("( original_name LIKE '%".$keyword."%' OR attribute LIKE '%".$keyword."%' OR hashtag LIKE '%".$keyword."%')");
			
			}
		 $query = $this->db->get($this->files);
           
			return $query->result();

    }
     public function folder($keyword,$companyid)
    {
		$this->db->where('company',$companyid);
			if($keyword != '')
			{
			$this->db->where("( folder_name LIKE '%".$keyword."%' OR attribute LIKE '%".$keyword."%' OR hashtag LIKE '%".$keyword."%')");
			
			}
		 $query = $this->db->get($this->folders);
           
			return $query->result();

    }
     public function search($keyword,$companyid)
    {
		$files = [];
   $files['file'] = $this->file($keyword,$companyid);
   $files['folder'] = $this->folder($keyword,$companyid);
   return $files;
    }
     public function user_file($keyword,$companyid)
    {
		$this->db->where('company',$companyid);
			if($keyword != '')
			{
			$this->db->where("( original_name LIKE '%".$keyword."%' OR attribute LIKE '%".$keyword."%' OR hashtag LIKE '%".$keyword."%')");
			
			}
		 $query = $this->db->get($this->files);
           
			return $query->result();

    }
     public function user_folder($keyword,$companyid)
    {
		$this->db->where('company',$companyid);
			if($keyword != '')
			{
			$this->db->where("( folder_name LIKE '%".$keyword."%' OR attribute LIKE '%".$keyword."%' OR hashtag LIKE '%".$keyword."%')");
			
			}
		 $query = $this->db->get($this->folders);
           
			return $query->result();

    }
     public function user_search($keyword,$companyid)
    {
		$files = [];
   $files['file'] = $this->file($keyword,$companyid);
   $files['folder'] = $this->folder($keyword,$companyid);
   return $files;
    }
}
