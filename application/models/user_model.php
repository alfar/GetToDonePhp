<?php
class User_model extends MY_Model {
	public function __construct() {
		$this->load->database();
	}
	
	public function get()
	{
		$this->db->order_by('id', 'desc');
		$query = $this->db->get('user');
		return $query->result_array();
	}

	public function select($query = FALSE, $exclude = FALSE, $limit = FALSE, $start = FALSE)
	{
		if ($query != FALSE)
		{
			$this->db->like('name', $query, 'after');
		}
		
		if ($exclude != FALSE)
		{
			$this->db->where('id !=', $exclude);
		}		
		
		if ($limit != FALSE)
		{
			$this->db->limit($limit, $start);
		}
		
		$this->db->select('id, name');
		$this->db->order_by('name', 'asc');
		$query = $this->db->get('user');
		return $query->result_array();
	}
	
	public function get_random()
	{
		$this->db->order_by('RAND()');
		$this->db->limit(1, 0);
		$query = $this->db->get('user');
		return $query->row_array();		
	}
	
	public function get_userid($provider, $uid)
	{
		$this->db->select('user_id');
		$query = $this->db->get_where('user_login', array('provider' => $provider, 'uid' => $uid));
		if ($query->num_rows() == 0)
		{
			return FALSE;
		}
		$row = $query->row_array();
		return $row['user_id'];
	}

	public function get_login_user($provider, $uid)
	{
		$this->db->select('user.*');
		$this->db->join('user', 'user.id = user_login.user_id');

		$query = $this->db->get_where('user_login', array('provider' => $provider, 'uid' => $uid));
		if ($query->num_rows() == 0)
		{
			return FALSE;
		}

		return $query->row_array();
	}

	public function update_user($provider, $uid, $name, $email, $image)
	{		
		$data = array(
			'name' => $name,
			'email' => $email,
			'image' => $image
		);
		
		$id = $this->get_userid($provider, $uid);
		
		if ($id !== FALSE)
		{
			$this->db->where(array('id' => $id));
			$this->db->update('user', $data);
		}
		
		return $id;
	}
		
	public function create_user($provider, $uid, $name, $email, $image)
	{		
		$data = array(
			'name' => $name,
			'email' => $email,
			'image' => $image
		);
		
		$this->db->insert('user', $data);
		$id = $this->db->insert_id();
		
		$data = array(
			'provider' => $provider,
			'uid' => $uid,
			'user_id' => $id
		);		
		$this->db->insert('user_login', $data);
	}
	
	public function get_user($id)
	{
		$this->db->where('id', $id);
		$query = $this->db->get('user');
		
		return $query->row_array();
	}
	
	public function update_profile($id, $name, $bio)
	{
		$data = array(
			'name' => $name,
			'bio' => $bio
		);
		
		$this->db->where('id', $id);
		$this->db->update('user', $data);
	}
}
