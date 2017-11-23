<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

class Folder_model extends CI_Model{

	public $user_table	= 'user_master';
    public $folder		= 'folder';
    public $files		= 'files';

    public function add_folder($data)
        {
              $this->db->insert($this->folder, $data);
              $insert_id = $this->db->insert_id();
              return $insert_id;
        }
    public function nameauth($folder)
        {
			$q1=$this->db->get_where($this->folder,array('folder_name'=>$folder));
		
		    return ($q1 != false && $q1->num_rows() > 0) ? 1 : FALSE;
	    }
	public function folderid($parentfol)
		{
			$this->db->select('id');
			$this->db->where(array('folder_name'=>$parentfol));
			$q1=$this->db->get($this->folder);
		    return ($q1 != false && $q1->num_rows() > 0) ? $q1->row() : FALSE;
		}
	public function getfolder($where = array(), $limit = "", $offset = "", $orderby = "", $disporder = "")
		{
			if (count($where) > 0)
				$this->db->where($where);
			
			if ($orderby != "" && $disporder != "")
				$this->db->order_by($orderby, $disporder);
			else
				$this->db->order_by("id", "asc");
			
			if ($limit != "" && $offset != "")
				$this->db->limit($limit, $offset);
			
			$result = $this->db->get($this->folder);
			if ($result != false && $result->num_rows() > 0)
				return $result;
			else
				return false;
		}  
	public function getfiles($where = array(), $limit = "", $offset = "", $orderby = "", $disporder = "")
		{
			if (count($where) > 0)
				$this->db->where($where);
			
			if ($orderby != "" && $disporder != "")
				$this->db->order_by($orderby, $disporder);
			else
				$this->db->order_by("id", "asc");
			
			if ($limit != "" && $offset != "")
				$this->db->limit($limit, $offset);
				
			$result = $this->db->get($this->files);
			if ($result != false && $result->num_rows() > 0)
				return $result;
			else
				return false;
		}  
	public function deletefolder($folderid)
		{
			$this->db->where('id', $folderid);
			$this->db->or_where('parent', $folderid);
			$this->db->delete('folder'); 
			return 1;
		}
	public function deletefile($fileid)
		{
			$this->db->where('id', $fileid);
			$this->db->delete('files'); 
			return 1;
		}
	public function getallfolders($folderid)
	{
		$this->db->where('id', $folderid);
		$this->db->or_where('parent', $folderid);
		$result = $this->db->get($this->folder);
		if ($result != false && $result->num_rows() > 0)
			return $result;
		else
			return false;
	}
}
?>
