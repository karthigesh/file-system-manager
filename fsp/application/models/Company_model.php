<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

class Company_model extends CI_Model{
	public $user_table = 'user_master';
    public $company = 'company_details';
    
    public function get_cusers($where = array(), $limit = "", $offset = "", $orderby = "", $disporder = ""){
			if (count($where) > 0)
				$this->db->where($where);
			
			if ($orderby != "" && $disporder != "")
				$this->db->order_by($orderby, $disporder);
			else
				$this->db->order_by("id", "asc");
			
			if ($limit != "" && $offset != "")
				$this->db->limit($limit, $offset);
			
			$result = $this->db->get('user_master');
			if ($result != false && $result->num_rows() > 0)
				return $result;
			else
				return false;
	}
	public function getusertype($id)
		 {
			 $this->db->select('*');
			 $this->db->from('user_type');
			 $this->db->where('type_id',$id);
			 $query=$this->db->get();
			 $result = $query->row();
			 $usertype = $result->type;
			 return $usertype;
		 }
	public function getcusertype($id)
		 {
			 $this->db->select('*');
			 $this->db->from('companyusertype');
			 $this->db->where('id',$id);
			 $query=$this->db->get();
			 $result = $query->row();
			 $usertype = $result->usertype;
			 return $usertype;
		 }
    public function get_company($where = array(), $limit = "", $offset = "", $orderby = "", $disporder = ""){
			if (count($where) > 0)
				$this->db->where($where);
			
			if ($orderby != "" && $disporder != "")
				$this->db->order_by($orderby, $disporder);
			else
				$this->db->order_by("id", "asc");
			
			if ($limit != "" && $offset != "")
				$this->db->limit($limit, $offset);
			
			$result = $this->db->get('company_details');
			if ($result != false && $result->num_rows() > 0)
				return $result;
			else
				return false;
	}
	public function getCompanydetails($id)
	 {
		 $this->db->select('*');
		 $this->db->from('company_details');
		 $this->db->where('company_id',$id);
		 $query=$this->db->get();
		 $result = $query->row();
		 if($query->num_rows() >0)
                               {
                                       return $result;
                               }
                               else
                               {
                                       return false;
                               }
		
	 }
	 public function companyauth($nm,$cid)
		{
			if($cid!=""){
				$q1=$this->db->get_where('company_details',array('name'=>$nm, 'company_id !='=>$cid));
			}else{
				$q1=$this->db->get_where('company_details',array('name'=>$nm));
			}
		    return ($q1 != false && $q1->num_rows() > 0) ? 1 : FALSE;
		}
	public function getCompanyusertype($id)
	 {
		 $this->db->select('*');
		 $this->db->from('companyusertype');
		 $this->db->where('cid',$id);
		 $query=$this->db->get();
		 $result = $query->result();
		 if($query->num_rows() >0)
                               {
                                       return $result;
                               }
                               else
                               {
                                       return false;
                               }
		
	 }
	 public function getdefaultusertype()
		{
			$this->db->select('*');
			 $this->db->from('companyusertype');
			 $this->db->where('id',1);
			 $query=$this->db->get();
			 $result = $query->row();
			 return $result;
		}
	public function deleteusertype($id)
	{
		$this->db->where('id', $id);
		$this->db->delete('companyusertype');
		$this->db->where(array('customizedusertype'=>$id));
		$data = array('customizedusertype'=>1);
		$update = $this->db->update('user_master', $data);
		return $update;
	}
	 public function insertCompanydetails($data)
        {
              $this->db->insert($this->company, $data);
              $insert_id = $this->db->insert_id();
              return $insert_id;
        }
	public function updateCompanydetails($data, $where = array())
		{
			if (count($where) > 0)
				$this->db->where($where);
			$result = $this->db->get('company_details');
			if ($result != false && $result->num_rows() > 0){
				if (count($where) > 0)
				$this->db->where($where);
				return $this->db->update('company_details', $data);
			}else{
			  $this->db->insert($this->company, $data);
              $insert_id = $this->db->insert_id();
              return $insert_id;
			}
		}
	public function updateini($data, $where= array())
		{
			if (count($where) > 0)
				$this->db->where($where);
			$result = $this->db->get('ini');
			if ($result != false && $result->num_rows() > 0){
				if (count($where) > 0)
				$this->db->where($where);
				return $this->db->update('ini', $data);
			}else{
			  $this->db->insert('ini', $data);
              $insert_id = $this->db->insert_id();
              return $insert_id;
			}
		}
	public function get_ini($companyid){
		$this->db->select('ini');
		$this->db->from('ini');
		$this->db->where('cid',$companyid);
		$query=$this->db->get();
		$result = $query->row();
		return $result;
	}
	public function updatexml($data, $where= array())
		{
			if (count($where) > 0)
				$this->db->where($where);
			$type = $where['usertype'];
			$cid =  $where['cid'];
			//print_r($data);exit;
			$sdata = array(
						 'usertype' 	  =>$type,
						 'attributes' =>serialize($data)
						);
			$newdata = array(
						 'cid'			 =>$cid,
						 'usertype' 	  =>$type,
						 'attributes' =>serialize($data)
						);
			$result = $this->db->get('companyusertype');
			if ($result != false && $result->num_rows() > 0){
				if (count($where) > 0)
				$this->db->where($where);
				$this->db->update('companyusertype', $sdata);
			}else{
			  $this->db->insert('companyusertype', $newdata);
              $insert_id = $this->db->insert_id();
              //echo $insert_id;exit;
			}
			return 1;
		}

	public function insertcfiles($data)
	{
		$this->db->insert('files', $data);
		$insert_id = $this->db->insert_id();
		if($insert_id){
			return 1;
		}else{
			return 0;
		}
	}
	public function updateattribute($data, $where= array())
	{
		if (count($where) > 0)
			$this->db->where($where);
		return $this->db->update('files', $data);
	}
	public function updatefolderattribute($data, $where= array())
	{
		if (count($where) > 0)
			$this->db->where($where);
		return $this->db->update('folder', $data);
	}
	public function requestper($data, $where= array())
	{
		if (count($where) > 0)
				$this->db->where($where);
		$sdata = array(
						'username'	=> $data['username'],
						'permission'=> $data['permission'],
						'date'=> $data['date'],
						'status'=>0
						);
		$newdata = array(
						'uid'		=> $data['uid'],
						'username'	=> $data['username'],
						'permission'=> $data['permission'],
						'date'=> $data['date'],
						'status'=>0
						);
		$result = $this->db->get('user_permission');
		if ($result != false && $result->num_rows() > 0){
			if (count($where) > 0)
			$this->db->where($where);
			$this->db->update('user_permission', $sdata);
		}else{
		  $this->db->insert('user_permission', $newdata);
		  $insert_id = $this->db->insert_id();
		}
		return 1;
	}
	public function getrequest()
	{
		$result = $this->db->get('user_permission');
		return $result;
	}
	public function getuserrequeststatus($where=array())
	{
		if (count($where) > 0)
			$this->db->where($where);
		return $this->db->get('user_permission');
	}
	public function updaterequest($data, $where= array())
	{
		if (count($where) > 0)
			$this->db->where($where);
		return $this->db->update('user_permission', $data);
	}
	public function requestfile($data, $where=array())
	{
		if(count($where) > 0)
			$this->db->where($where);
			
		$sdata = array(
						'companyid'		=> $data['companyid'],
						'username'		=> $data['username'],
						'fileid'		=> $data['fileid'],
						'filename'		=> $data['filename'],
						'requesttime'	=> $data['requesttime'],
						'status'		=> $data['status']
						);
		$newdata = array(
						'userid'		=> $data['userid'],
						'companyid'		=> $data['companyid'],
						'username'		=> $data['username'],
						'fileid'		=> $data['fileid'],
						'filename'		=> $data['filename'],
						'requesttime'	=> $data['requesttime'],
						'status'		=> $data['status']
						);
		$result = $this->db->get('filerequest');
		if ($result != false && $result->num_rows() > 0){
			if (count($where) > 0)
			$this->db->where($where);
			$this->db->update('filerequest', $sdata);
		}else{
		  $this->db->insert('filerequest', $newdata);
		  $insert_id = $this->db->insert_id();
		}
		return 1;
	}
	public function getfilerequest()
	{
		$result = $this->db->get('filerequest');
		return $result;
	}
	public function getuserfilerequest($where=array())
	{
		if(count($where) > 0)
			$this->db->where($where);
		$result = $this->db->get('filerequest');
		return $result;
	}
	public function updatefilerequest($data, $where= array())
	{
		if (count($where) > 0)
			$this->db->where($where);
		return $this->db->update('filerequest', $data);
	}
}
?>
