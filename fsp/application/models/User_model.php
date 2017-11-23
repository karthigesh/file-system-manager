<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

class User_model extends CI_Model{

	public $user_table = 'user_master';
        
        public function updateUser($data, $where = array())
		{
			if (count($where) > 0)
				$this->db->where($where);
				//print_r($data);exit;
			return $this->db->update('user_master', $data);
		}
		public function getUser($where = array(), $limit = "", $offset = "", $orderby = "", $disporder = "")
		{
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
		 public function getcustomizedusertype($id)
		 {
			 $this->db->select('*');
			 $this->db->from('companyusertype');
			 $this->db->where('id',$id);
			 $query=$this->db->get();
			 $result = $query->row();
			 return $result;
		 }
		 public function get_user_details($id)
		 {
			 $this->db->select('*');
			 $this->db->from($this->user_table);
			 $this->db->where('id',$id);
			 $query=$this->db->get();
			 $result = $query->row();
			return $result;
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
		public function auth($nm,$pwd)
		{
		    $q1=$this->db->get_where('user_master',array('username'=>$nm,'password'=>MD5($pwd)));
		    $newu = ($q1 != false && $q1->num_rows() > 0) ? $q1->row() : FALSE;
			if(($newu != FALSE)&&($newu->status == '1')){
				return $newu;
			}else if(($newu != FALSE)&&($newu->status == '0')){
				return 'deactivated';
			}else{
				return FALSE;
			}
		}
		public function emailauth($nm)
		{
		    //$this->db->select('id_user_master,user_name,email');
		    $q1=$this->db->get_where('user_master',array('email'=>$nm));
		
		    return ($q1 != false && $q1->num_rows() > 0) ? 1 : FALSE;
		}
		public function nameauth($nm)
		{
		    //$this->db->select('id_user_master,user_name,email');
		    $q1=$this->db->get_where('user_master',array('username'=>$nm));
		
		    return ($q1 != false && $q1->num_rows() > 0) ? 1 : FALSE;
		}
		public function insert_user($data)
        {
              $this->db->insert($this->user_table, $data);
              $insert_id = $this->db->insert_id();
              return $insert_id;
        }
		public function update_user_status($id,$data)
        {
			$this->db->where('id', $id);
			$res=$this->db->update('user_master', $data);
			$userdetails = $this->get_user_details($id);
			return $userdetails;
		}
		public function delete_user($id_user_master)
        {
			$data=array('status'=>'0');
			$this->db->where('id', $id_user_master);
			$res=$this->db->update('user_master',$data);
			return $res;
        }
    }
